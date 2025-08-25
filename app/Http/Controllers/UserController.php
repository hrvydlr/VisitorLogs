<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('userType')->get(); // Eager load userType
        $userTypes = UserType::all();

        return view('users.index', compact('users', 'userTypes'));
    }

    public function save(Request $request)
    {
        $userId = auth()->id();
        $recordId = $request->record_id; // only using record_id
    
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username')->ignore($recordId, 'id'),
            ],
            'user_type' => 'required|exists:user_types,id',
            'password'  => $recordId ? 'nullable|string' : 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
    
        $data = [
            'username'  => $request->username,
            'user_type' => $request->user_type,
        ];
    
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user = User::find($recordId);
    
        if ($user) {
            // UPDATE
            $data['updated_by'] = $userId;
            $user->update($data);
            $action = 'updated';
        } else {
            // CREATE
            $data['created_by'] = $userId;
            $data['remember_token'] = \Str::random(60);
            User::create($data);
            $action = 'created';
        }
    
        return response()->json([ "User successfully {$action}: {$request->username}",
        ]);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function list(Request $request)
    {
        $keywords = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
    
        $columns = ['id', 'username', 'user_type_name', 'created_at', 'updated_at'];
    
        $usersQuery = User::select('users.*', 'user_types.type_name as user_type_name')
            ->leftJoin('user_types', 'users.user_type', '=', 'user_types.id')
            ->when(!empty($keywords) && is_string($keywords), function ($query) use ($keywords) {
                $query->where('username', 'LIKE', "%{$keywords}%")
                      ->orWhere('user_types.type_name', 'LIKE', "%{$keywords}%")
                      ->orWhere('users.created_at', 'LIKE', "%{$keywords}%");
            });
    
        $filteredQuery = clone $usersQuery;
        $totalRecords = $filteredQuery->count();
    
        $users = $usersQuery->orderBy($columns[$orderColumnIndex], $orderDir)
            ->offset($start)
            ->limit($limit)
            ->get();
        
    
    
        $newData = [];
        foreach ($users as $user) {
            $newData[] = [
                'id'                => $user->id,
                'username'          => $user->username,
                'user_type'         => $user->userType ? $user->userType->type_name : '',
                'remember_token'    => $user->remember_token,
                'created_by'        => $this->getUserName($user->created_by),
                'updated_by'        => $this->getUserName($user->updated_by),
                'created_at'        => Carbon::parse($user->created_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i a'),
                'updated_at'        => Carbon::parse($user->updated_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i a'),
                'action' => "
                <div class='dropdown'>
                    <button class='btn btn-sm border-0 bg-transparent text-dark' type='button' id='actionDropdown{$user->id}' data-bs-toggle='dropdown' aria-expanded='false'>
                        &#8942; <!-- Unicode for vertical ellipsis -->
                    </button>
                    <ul class='dropdown-menu' aria-labelledby='actionDropdown{$user->id}'>
                        <li>
                            <button class='dropdown-item btn-edit' data-id='{$user->id}'>Edit</button>
                        </li>
                        <li>
                            <button class='dropdown-item btn-delete' data-id='{$user->id}' data-details='{$user->username}'>Delete</button>
                        </li>
                    </ul>
                </div>",];
        }
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => User::count(),
            'recordsFiltered' => $totalRecords,
            'data' => $newData
        ]);
    }
    
    public function search(Request $request)
    {
        $user = User::find($request->id);
        return response()->json($user);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);  // Use $request->id to find the user
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $details = $user->username;
        $user->update(['deleted_by' => auth()->id()]);
        $user->delete();

        return response()->json(['You have successfully deleted ' . $details]);
    }

    private function getUserName($userId)
    {
        $user = User::find($userId);
        return $user ? $user->username : 'Unknown User';
    }
}
