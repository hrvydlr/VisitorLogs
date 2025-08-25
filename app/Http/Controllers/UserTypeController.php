<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\RegisteredID;
use App\Models\UserType;


use Carbon\Carbon;
use Validator;

class UserTypeController extends Controller
{
    public function index()
    {
        $userTypes = UserType::all();
        return view('user_type.index', compact('userTypes'));
    }

    // Show the form for creating a new visitor type or editing an existing one
    public function show($id = null)
    {
        $userType = null;
        if ($id) {
            // Find the visitor type by ID for editing
            $userType = userType::findOrFail($id);
        }

        return view('user_type.index', compact('userType'));
    }

    // Save the visitor type (either create or update)
    public function save(Request $request)
    {       
        $userId = auth()->id();

        $validator = Validator::make($request->all(), 
            [
                'type_name'   => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) use ($request) {
                        $count = UserType::withoutTrashed()
                                    ->where('type_name', $value)
                                    ->where('id', '!=', $request->record_id)
                                    ->count();
                        
                        if ($count > 0) {
                            $fail('Duplicate Entry.');
                        }
                    }
                ]
            ], 
            ['type_name.unique' => 'Duplicate Entry.']
        );

        if ($validator->fails()) return response()->json(['errors'=>$validator->errors()]);
        
        $data = ['type_name' => $request->type_name];

        if($request->record_id > 0) 
        {
            $data['updated_by'] = $userId;
            $type               = "updated";
            $record             = UserType::find($request->record_id);
            $record->update($data);

        } 
        else
        {
            $data['created_by'] = $userId;
            $type               = "inserted";
            $record             = UserType::create($data);
        }

        return response()->json(['You have successfully '. $type .' '. $request->type_name]);
    }

    // Delete a visitor type
    public function delete(Request $request)
    {
        // $userType = UserType::findOrFail($id);
        // $userType->delete();
        // return redirect()->route('usertype.index')->with('success', 'Visitor Type deleted successfully!');
        
        $record  = UserType::find($request->id);
        $details = $record->type_name;
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
        $columns = ['id', 'type', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    
        $userTypeQuery = UserType::with('createdBy', 'updatedBy')
            ->when(!empty($keywords) && is_string($keywords), function ($query) use ($keywords) {
                $query->where('type_name', 'LIKE', "%{$keywords}%")
                ->orWhere('created_at', 'LIKE', "%{$keywords}%");

            });
    
        $filteredQuery = clone $userTypeQuery;
    
        $totalRecords = $filteredQuery->count();
    
        $userTypes = $userTypeQuery->orderBy($columns[$orderColumnIndex], $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();
    
        $newData = [];
        foreach ($userTypes as $userType) {
            $newData[] = [
                'id'            => $userType->id,
                'type_name'     => $userType->type_name,
                'created_at'    => Carbon::parse($userType->created_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i a'),
                'created_by'    => $userType->createdBy ? $userType->createdBy->username : 'N/A',
                'updated_by'    => $userType->updatedBy ? $userType->updatedBy->username : 'N/A',
                'action'        => "<div class='dropdown'>
                    <button class='btn btn-sm border-0 bg-transparent text-dark' type='button' id='actionDropdown{$userType->id}' data-bs-toggle='dropdown' aria-expanded='false'>
                        &#8942; <!-- Unicode for vertical ellipsis -->
                    </button>
                    <ul class='dropdown-menu' aria-labelledby='actionDropdown{$userType->id}'>
                        <li>
                            <button class='dropdown-item btn-edit' data-id='{$userType->id}'>Edit</button>
                        </li>
                        <li>
                            <button class='dropdown-item btn-delete' data-id='{$userType->id}' data-details='{$userType->type_name}'>Delete</button>
                        </li>
                    </ul>
                </div>",
            ];
        }

        return response()->json([
            'draw' => intval(request()->input('draw')),
            'recordsTotal' => UserType::count(),
            'recordsFiltered' => $totalRecords,
            'data' => $newData

        ]);
    }

    public function search(Request $request)
    {        
        $record = UserType::find($request->id);
        return response()->json($record);
    }
    
}
