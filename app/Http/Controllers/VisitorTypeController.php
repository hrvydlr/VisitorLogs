<?php

namespace App\Http\Controllers;

use App\Models\VisitorType;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Validator;

class VisitorTypeController extends Controller
{
    // Display a list of all visitor types
    public function index()
    {
        $visitorTypes = VisitorType::all();
        return view('visitor_type.index', compact('visitorTypes'));
    }

    // Show the form for creating a new visitor type or editing an existing one
    public function show($id = null)
    {
        $visitorType = null;
        if ($id) {
            // Find the visitor type by ID for editing
            $visitorType = VisitorType::findOrFail($id);
        }

        return view('visitor_type.index', compact('visitorType'));
    }

    // Save the visitor type (either create or update)
    public function save(Request $request)
    {     
        $userId = auth()->id();

        $validator = Validator::make($request->all(), 
            [
                'name'   => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) use ($request) {
                        $count = VisitorType::withoutTrashed()
                                    ->where('name', $value)
                                    ->where('id', '!=', $request->record_id)
                                    ->count();
                        
                        if ($count > 0) {
                            $fail('Duplicate Entry.');
                        }
                    }
                ]
            ], 
            ['name.unique' => 'Duplicate Entry.']
        );

        if ($validator->fails()) return response()->json(['errors'=>$validator->errors()]);
        
        $data = ['name' => $request->name];

        if($request->record_id > 0) 
        {
            $data['updated_by'] = $userId;
            $type               = "updated";
            $record             = VisitorType::find($request->record_id);
            $record->update($data);

        } 
        else
        {
            $data['created_by'] = $userId;
            $type               = "inserted";
            $record             = VisitorType::create($data);
        }

        return response()->json(['You have successfully '. $type .' '. $request->name]);
    }

    // Delete a visitor type
    public function delete(Request $request)
    {
        // $userType = UserType::findOrFail($id);
        // $userType->delete();
        // return redirect()->route('usertype.index')->with('success', 'Visitor Type deleted successfully!');
        
        $record  = VisitorType::find($request->id);
        $details = $record->name;
        $record->update(['deleted_by' => auth()->id()]);
        $record->delete();
        return response()->json(['You have successfully delete '. $details]);
    }

    // Return a list of visitor types for AJAX requests or other purposes
    public function list(Request $request)
    {
   
        $keywords = request()->input('search.value');
        $limit = request()->input('length');
        $start = request()->input('start');
        $orderColumnIndex = request()->input('order.0.column');
        $orderDir = request()->input('order.0.dir');
        $columns = ['id', 'name', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    
        $visitorTypeQuery = VisitorType::with('createdBy', 'updatedBy')
                            ->when(!empty($keywords) && is_string($keywords), function ($query) use ($keywords) {
                                $query->where('name', 'LIKE', "%{$keywords}%");
                            });
                        
        $filteredQuery = clone $visitorTypeQuery;
    
        $totalRecords = $filteredQuery->count();
    
        $visitorTypes = $visitorTypeQuery->orderBy($columns[$orderColumnIndex], $orderDir)
                        ->offset($start)
                        ->limit($limit)
                        ->get();
    
        $newData = [];
        foreach ($visitorTypes as $visitorType) {
            $newData[] = [
                'id'            => $visitorType->id,
                'name'          => $visitorType->name,
                'created_at'    => Carbon::parse($visitorType->created_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i a'),
                'created_by'    => name($visitorType->created_by),
                'updated_by'    => name($visitorType->updated_by),
                'action'        => create_action($visitorType->id, $visitorType->name, 'Edit') 
            ];
        }

        return response()->json([
            'draw' => intval(request()->input('draw')),
            'recordsTotal' => VisitorType::count(),
            'recordsFiltered' => $totalRecords,
            'data' => $newData

        ]);
    }

    public function search(Request $request)
    {        
        $record = VisitorType::find($request->id);
        return response()->json($record);
    }
}
