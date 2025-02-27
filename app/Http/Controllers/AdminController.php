<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AdminResource;

class AdminController extends Controller
{
    
    public function index(){
        $admins = Admin::all();

        if($admins->isEmpty()){
            return response()->json([
                'message' => 'There are no admins.',
            ], 404);
        }
        $admins->makeHidden(['password', 'api_token']);
        return response()->json($admins, 201);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'role_id' => 'required|integer',
            'permissions' => 'required|integer',
            'password' => 'required|string|confirmed|min:8',
        ]);
        
        
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['api_token'] = Str::random(34);
        $admin = Admin::create($validatedData);
    
        return response()->json(new AdminResource($admin), 201);
    }

    public function show(Request $request){
        
        $admin = Admin::find($request->authed_user->id);
        
        if(!$admin){
            return response()->json([
                'message' => 'Admin user not found.'
            ], 404);
        }
        return response()->json(new AdminResource($admin), 200);
    }

    public function update(Request $request){
        
        
        $validatedData = collect($request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $request->authed_user->email,
        ]));

        $updatedData = $validatedData->filter(function (string $value, string $key) {
            return !is_null($value);
        });
        
        $admin = Admin::find($request->authed_user->id);
        $admin->update($updatedData->toArray());

        return response()->json(new AdminResource($admin), 200);
    }

    public function destroy(Request $request){
        $admin = Admin::find($request->authed_user->id);
        
        if (!$admin) {
            return response()->json(['message' => 'Admin user cannot be found.'], 404);
        }
        
        if ($admin->delete()) {
            return response()->json(['message' => 'Admin user deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete admin.'], 500);
        }
    }

    public function login(LoginRequest $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $admin = Admin::verifyCredentials( $credentials);
        if(!$admin){
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }
            
        return response()->json(new AdminResource($admin),200);
    }
}
