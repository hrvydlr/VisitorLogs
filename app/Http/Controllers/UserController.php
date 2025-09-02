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
        return view('users.index');
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
            'user_type' => 'required',
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
            User::create($data);
            $action = 'created';
        }
    
        return response()->json([ "User successfully {$action}: {$request->username}",
        ]);
    }

    public function list(Request $request)
    {
        $keywords = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $orderDir = $request->input('order.0.dir');
    
        $columns = ['id', 'username', 'user_type_name', 'created_at', 'updated_at'];
    
        $usersQuery = User::when(!empty($keywords) && is_string($keywords), function ($query) use ($keywords) {
                $query->where('username', 'LIKE', "%{$keywords}%");
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
                'user_type'         => $user->userType ? $user->userType->name : '',
                'remember_token'    => $user->remember_token,
                'created_by'        => name($user->created_by),
                'updated_by'        => name($user->updated_by),
                'created_at'        => Carbon::parse($user->created_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i a'),
                'updated_at'        => Carbon::parse($user->updated_at)->setTimezone('Asia/Manila')->format('F j, Y, g:i a'),
                'action'            => create_action($user->id,$user->username,'Edit')
            ];
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

}
