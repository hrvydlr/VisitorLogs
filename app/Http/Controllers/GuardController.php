<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\VisitorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RegisteredID;
use Illuminate\Support\Facades\Log;


class GuardController extends Controller
{
    public function index()
    {
        $visitors = Visitor::with('visitorType')->get();
        $visitorTypes = VisitorType::all(); // This line is missing
        return view('guard.index', compact('visitors', 'visitorTypes'));
    }


    public function save(Request $request)
    {
        $validated = $request->validate([
            'first_name'        =>'required|string|max:255',
            'middle_name'       =>'nullable|string|max:255',
            'last_name'         =>'required|string|max:255',
            'number'            =>'required|string|max:255',
            'address'           =>'nullable|string|max:255',
            'id_number'         =>'nullable|string|max:255',
            'visitor_type'      =>'required|exists:visitor_types,id',
            'visit_date'        =>'nullable|date',
            'time_in'           =>'nullable|date_format:H:i',
            'created_by'        =>'nullable|integer',
        ]);

        if ($request->input('id') > 0) {
            // EDIT mode
            $visitor = Visitor::findOrFail($request->input('id'));
            $validated['updated_by'] = Auth::id();

            // Keep original values if visit_date/time_in were not submitted
            $validated['visit_date'] = $validated['visit_date'] ?? $visitor->visit_date;
            $validated['time_in'] = $validated['time_in'] ?? $visitor->time_in;

            $visitor->update($validated);
            $message = 'Visitor updated successfully!';
        } else {
            // CREATE mode
            $validated['visit_date'] = $validated['visit_date'] ?? now()->toDateString();
            $validated['time_in'] = $validated['time_in'] ?? now()->format('H:i:s');
            $validated['created_by'] = Auth::id() ?? '';

            Visitor::create($validated);
            $message = 'Visitor added successfully!';
        }

        return redirect()->route('guard.form')->with('success', $message);
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
        $userId = auth()->id();
        
        $keywords = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
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
                            &#8942;
                        </button>
                        <ul class='dropdown-menu' aria-labelledby='actionDropdown{$visitor->id}'>
                            <li>
                                <a href='" . route('guard.show', $visitor->id) . "' class='dropdown-item btn-view' data-name='{$name}'>View</a>
                            </li>";

                    if ($visitor->time_out === null) {
                        $action .= "
                            <li>
                                <button class='dropdown-item btn-timeout' data-id='{$visitor->id}'>Timeout</button>
                            </li>";
                    }

                    $action .= "
                        </ul>
                    </div>";


            $data[] = [
                'id'            =>$visitor->id,
                'fullname'      =>$visitor->first_name . ' ' . $visitor->middle_name . ' ' . $visitor->last_name,
                'number'        =>$visitor->number,
                'address'       =>$visitor->address,
                'visitor_type'  =>$visitor->visitorType ? $visitor->visitorType->type_name : 'N/A',
                'id_number'     =>$visitor->id_number,
                'image_path'    =>$visitor->image_path,
                'visit_date'    =>$visitor->visit_date,
                'time_in'       =>$visitor->time_in,
                'time_out'      =>$visitor->time_out,
                'created_by'    =>$visitor->creator ? $visitor->creator->username : 'N/A',
                'updated_by'    =>$visitor->updater ? $visitor->updater->username : 'N/A',
                'status'        =>$visitor->time_out ? 'Timed Out' : 'Active',
                'action'        =>$action,
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

        return view('guard.show', compact('visitor'));
    }

    public function checkVisitorId(Request $request)
    {
        try {
            $idNumber = $request->input('id_number');
            $visitorTypeId = $request->input('visitor_type');

            if (empty($idNumber) || empty($visitorTypeId)) {
                return response()->json(['status' => 'error', 'message' => 'Missing ID number or Visitor Type'], 400);
            }

            // Check if the combination exists
            $exists = RegisteredID::where('id_number', $idNumber)
                ->where('visitor_type', $visitorTypeId)
                ->exists();

            if ($exists) {
                return response()->json(['status' => 'valid']);
            }

            return response()->json(['status' => 'invalid']);
        } catch (\Exception $e) {
            Log::error('checkVisitorId Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Server error occurred.'], 500);
        }
    }


    public function create($id = null)
    {
        $visitor = null;

        if ($id) {
            $visitor = Visitor::findOrFail($id);
        }

        $visitorTypes = VisitorType::all();
        return view('guard.form', compact('visitor', 'visitorTypes'));
    }


    public function getNameById(Request $request)
    {
        $visitorTypeId = $request->input('visitor_type');
        $visitorType = VisitorType::find($visitorTypeId);

        if ($visitorType) {
            return response()->json(['name' => $visitorType->type_name]);
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
