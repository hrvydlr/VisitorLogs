<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\VisitorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisteredID;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::with('visitorType')->get();
        $visitorTypes = VisitorType::all(); // This line is missing
        return view('visitors.index');
    }

     public function save(Request $request)
    {
        $record_id =  $request->id;
        $validator = Validator::make($request->all(),[
            'id_number' => 'required|string|min:3|max:4',
    'visitor_type' => 'required|exists:visitor_types,id',
    'first_name' => 'required|string|max:255',
    'middle_name' => 'nullable|string|max:255',
    'last_name' => 'required|string|max:255',
    'number' => 'required|string',
    'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $isRegistered = RegisteredID::where('id_number', $request->id_number)
                                ->where('visitor_type', $request->visitor_type)->exists();
        
        if (!$isRegistered) {
            return response()->json(['error' => 'The provided ID number is not registered for the selected visitor type.'], 422);
        }

        $isBorrowed = Visitor::where('id_number', $request->id_number)
            ->where('visitor_type', $request->visitor_type)
            ->whereNull('time_out')
            ->when($record_id > 0, fn($q) => $q->where('id', '!=', $record_id))
            ->exists();

        if ($isBorrowed) {
            return response()->json(['error' => 'This ID number is currently in use and has not been checked out.'], 422);
        }
        
        $userId = Auth::id();

        // Build data to save
        $data = [
            'first_name'   => $request->first_name,
            'middle_name'  => $request->middle_name,
            'last_name'    => $request->last_name,
            'number'       => $request->number,
            'address'      => $request->address,
            'id_number'    => $request->id_number,
            'visitor_type' => $request->visitor_type,
        ];

        // // Handle image (if provided)
        $imageBase64 = $request->input('image');
        if (!empty($imageBase64)) {
            $data['image_path'] = $this->storeImage($imageBase64);
        }
    
        if ($record_id > 0) {
            //  Edit Mode
            $visitor = Visitor::findOrFail($record_id);
            $data['updated_by'] = $userId;
    
            // Keep original visit_date and time_in if not updated
            $data['visit_date'] = $data['visit_date'] ?? $visitor->visit_date;
            $data['time_in']    = $data['time_in'] ?? $visitor->time_in;
    
            $visitor->update($data);
            $message = 'Visitor updated successfully!';
        } else {
            // ➕ Create Mode
            $data['visit_date']    =  now()->toDateString();
            $data['time_in']       =  now();
            $data['created_by']    = $userId;
    
            Visitor::create($data);
            $message = 'Visitor added successfully!';
        }
        return response()->json(['message' => $message]);
       
        // return redirect()->route('visitor.form')->with('success', $message);
    }
    
    private function storeImage($imageData)
    {
        if (!$imageData) {
            return null;
        }
    
        preg_match('/^data:image\/(\w+);base64,/', $imageData, $matches);
        $extension = isset($matches[1]) ? $matches[1] : 'png';
    
        $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $imageData);
        $imageData = str_replace(' ', '+', $imageData);
        $imageName = 'images/' . uniqid() . '.' . $extension;
    
        Storage::disk('public')->put($imageName, base64_decode($imageData));
    
        return 'storage/' . $imageName;
    }


    public function search(Request $id)
    {
        $visitor = Visitor::findOrFail($id);
        return response()->json($visitor);
    }

    public function delete(Request $request)
    {
        $visitor = Visitor::find($request->id);  // Use $request->id to find the user
        if (!$visitor) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $details = $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name;
        $validated = $visitor->id;
        $visitor->update(['deleted_by' => auth()->id()]);
        $visitor->delete();

        return response()->json([ 'You have successfully deleted ' . $details]);
    }

    public function list(Request $request)
    {
        $keywords = $request->input('search.value');
        $limit =    $request->input('length');
        $start =    $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');

        $columns = ['id', 'first_name', 'middle_name', 'last_name', 'number', 'address', 'visitor_type_id','image_path', 'id_number', 'status', 'deleted_at'];
        $orderColumn = $columns[$orderColumnIndex] ?? 'id';
        $orderDirection = in_array(strtolower($orderDir), ['asc', 'desc']) ? $orderDir : 'asc';

        $role = Auth::user()->user_type;

        $baseQuery = Visitor::with(['visitorType', 'creator', 'updater'])
            ->whereNull('time_out')
            ->when(!empty($keywords), function ($query) use ($keywords) {
                  $query->where(function ($q) use ($keywords) {
                      $q->where('first_name', 'like', "%{$keywords}%")
                        ->orWhere('middle_name', 'like', "%{$keywords}%")
                        ->orWhere('last_name', 'like', "%{$keywords}%")
                        ->orWhere('id_number', 'like', "%{$keywords}%")
                        ->orWhere('number', 'like', "%{$keywords}%")
                        ->orWhere('address', 'like', "%{$keywords}%");
                });
            });

        $filteredQuery = clone $baseQuery;
        $totalRecords = $filteredQuery->count();

        $visitors = $baseQuery->orderBy($orderColumn, $orderDirection)
            ->skip($start)
            ->take($limit)
            ->get();

        $data = [];
        foreach ($visitors as $visitor) {
            $name = "{$visitor->first_name} {$visitor->middle_name} {$visitor->last_name}";

            $action = "
            <div class='dropdown'>
                <button class='btn btn-sm border-0 bg-transparent text-dark' type='button' id='actionDropdown{$visitor->id}' data-bs-toggle='dropdown' aria-expanded='false'>
                    &#8942; <!-- Unicode for vertical ellipsis -->
                </button>
                <ul class='dropdown-menu' aria-labelledby='actionDropdown{$visitor->id}'>
                    <li>
                        <a class='dropdown-item btn-view' href='" . route('visitor.show', $visitor->id) . "' data-name='{$name}'>View</a>
                    </li>";
            
            if ($visitor->time_out === null) {
                $action .= "
                    <li>
                        <button class='dropdown-item btn-timeout' data-id='{$visitor->id}'>Timeout</button>
                    </li>";
            
                if (Auth::user()->userType->name == 'ADMIN')  {
                    $action .= "
                    <li>
                        <button class='dropdown-item btn-delete' data-id='{$visitor->id}' data-details='{$name}'>Delete</button>
                    </li>
                    <li>
                        <a class='dropdown-item' href='" . route('visitor.edit', $visitor->id) . "'>Edit</a>
                    </li>";
                }
            }
            
            $action .= "</ul></div>";

            $data[] = [
                'id'            => $visitor->id,
                'fullname'      => $visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name,
                'number'        => $visitor->number,
                'address'       => $visitor->address,
                'visitor_type'  => $visitor->visitorType ? $visitor->visitorType->type_name : 'N/A',
                'id_number'     => $visitor->id_number,
                'image_path'    => $visitor->image_path,
                'visit_date'    => $visitor->visit_date,
                'time_in'       => $visitor->time_in,
                'time_out'      => $visitor->time_out,
                'created_by'    => $visitor->creator ? $visitor->creator->username : 'N/A',
                'updated_by'    => $visitor->updater ? $visitor->updater->username : 'N/A',
                'status'        => $visitor->time_out ? 'Timed Out' : 'Active',
                'action'        => $action,
            ];
        }

        return response()->json([
            'draw'              => intval($request->input('draw')),
            'recordsTotal'      => $totalRecords,
            'recordsFiltered'   => $totalRecords,
            'data'              => $data,
        ]);
    }

    public function show($id)
    {
        $visitor = Visitor::with(['visitorType', 'creator', 'updater'])->find($id);

        if (!$visitor) {
            return redirect()->route('visitor.index')->with('error', 'Visitor not found.');
        }

        return view('visitors.show', compact('visitor'));
    }


    public function checkVisitorID($id_number, $visitor_type_id)
    {
        $typeName = VisitorType::where('id', $visitor_type_id)->value('type_name');

        if (!$typeName) {
            return response()->json(['status' => 'invalid']);
        }

        $match = RegisteredID::where('id_number', $id_number)
                    ->where('type_name', $typeName)
                    ->first();

        return response()->json([
            'status' => $match ? 'valid' : 'invalid'
        ]);
    }

    public function create($id = null)
    {
        $visitor = null;

        if ($id) {
            $visitor = Visitor::findOrFail($id);
        }

        $visitorTypes = VisitorType::all();
        return view('visitors.form', compact('visitor', 'visitorTypes'));
    }


    public function getNameById(Request $request)
    {
        $visitorTypeId = $request->input('visitor_type');
        $visitorType = VisitorType::find($visitorTypeId);

        if ($visitorType) {
            return response()->json(['name' => $visitorType->name]);
        }

        return response()->json(['name' => '']);
    }

    public function setTimeOut($id)
    {
        $visitor = Visitor::findOrFail($id);
        $visitor->time_out = now()->toDateTimeString();
        $visitor->save();

        return response()->json(['success' => true, 'message' => 'Visitor timed out successfully.']);
    }

}
