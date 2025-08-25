<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\User;
use App\Models\VisitorType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\RegisteredID;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\UserType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class RegisteredIDController extends Controller
{
    public function index(Request $request)
    {
        $registeredIDs = RegisteredID::with('createdBy')->get();
        $visitorTypes = VisitorType::all();
         return view('registered_id.index', compact('registeredIDs','visitorTypes'));
           
    }
    public function list(Request $request)
    {
        $keywords = request()->input('search.value');
        $limit = request()->input('length');
        $start = request()->input('start');
        $orderColumnIndex = request()->input('order.0.column');
        $orderDir = request()->input('order.0.dir');
        $columns = ['id', 'visitor_type', 'id_number', 'created_at'];
    
       $registeredIDQuery = RegisteredID::with(['visitorType', 'createdBy', 'updatedBy'])
            ->when(!empty($keywords) && is_string($keywords), function ($query) use ($keywords) {
                $query->where('visitor_type', 'LIKE', "%{$keywords}%")
                      ->orWhere('id_number', 'LIKE', "%{$keywords}%");
            });
    
        $filteredQuery = clone $registeredIDQuery;
    
        $totalRecords = $filteredQuery->count();
    
        $registeredIDs = $registeredIDQuery->orderBy($columns[$orderColumnIndex], $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();
    
        $newData = [];
        foreach ($registeredIDs as $registeredID) {
            $newData[] = [
                'id'             => $registeredID->id,
                'id_number'      =>  $registeredID->id_number,
                'visitor_type'   => $registeredID->visitorType ? $registeredID->visitorType->type_name : 'N/A',
                'created_at'     => Carbon::parse($registeredID->created_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i a'),
                'created_by'     => $registeredID->createdBy ? $registeredID->createdBy->username : 'N/A',
                'updated_at'     => Carbon::parse($registeredID->updated_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i a'),
                'updated_by'     => $registeredID->updatedBy ? $registeredID->updatedBy->username : 'N/A',
                'updater'        => $registeredID->updatedBy ? $registeredID->updatedBy->username : '', // Ensure you get the updater's name if possible
                'action'         => "
                                    <div class='dropdown'>
                                        <button class='btn btn-sm border-0 bg-transparent text-dark' type='button' id='actionDropdown{$registeredID->id}' data-bs-toggle='dropdown' aria-expanded='false'>
                                            &#8942; <!-- Unicode for vertical ellipsis -->
                                        </button>
                                        <ul class='dropdown-menu' aria-labelledby='actionDropdown{$registeredID->id}'>
                                            <li>
                                                <button class='dropdown-item btn-edit' data-id='{$registeredID->id}'>Edit</button>
                                            </li>
                                            <li>
                                                <button class='dropdown-item btn-delete' data-id='{$registeredID->id}' data-details='{$registeredID->type_name}'>Delete</button>
                                            </li>
                                        </ul>
                                    </div>",
            ];
        }
    
        return response()->json([
            'draw'              => intval(request()->input('draw')),
            'recordsTotal'      => RegisteredID::count(),
            'recordsFiltered'   => $totalRecords,
            'data' => $newData
        ]);
    }
    public function save(Request $request)
    {      
        $userId = auth()->id();

        $validator = Validator::make($request->all(), 
            [
                'visitor_type' => 'required|exists:visitor_types,id',
                'id_number' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) use ($request) {
                        $count = RegisteredID::where('visitor_type', $request->visitor_type)
                                    ->where('id_number', $value)
                                    ->when($request->record_id, function ($query) use ($request) {
                                        $query->where('id', '!=', $request->record_id);
                                    })
                                    ->count();

                        if ($count > 0) {
                            $fail('A record with this visitor type and ID number already exists.');
                        }
                    }
                ]
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = [
            'visitor_type'  => $request->visitor_type,
            'id_number'     => $request->id_number,
        ];

        if ($request->record_id > 0) {
            $data['updated_by'] = $userId;
            $type = "updated";
            $record = RegisteredID::find($request->record_id);
            $record->update($data);
        } else {
            $data['created_by'] = $userId;
            $type = "inserted";
            $record = RegisteredID::create($data);
        }

        return response()->json(['You have successfully ' . $type . ' a registered ID.']);
    }
    public function search(Request $request)
    {
        $record = RegisteredID::find($request->id);
        return response()->json($record);
    }
    public function delete(Request $request)
    {
        // $userType = UserType::findOrFail($id);
        // $userType->delete();
        // return redirect()->route('usertype.index')->with('success', 'Visitor Type deleted successfully!');
        
        $record  = RegisteredID::find($request->id);
        $details = $record->visitor_type . 'ID ' . $record->id_number . '';
        $record->update(['deleted_by' => auth()->id]);
        $record->delete();
        return response()->json(['You have successfully delete '. $details]);
    }
}
