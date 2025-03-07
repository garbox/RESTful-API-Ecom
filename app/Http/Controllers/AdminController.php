<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AdminResource;
use Dedoc\Scramble\Attributes\HeaderParameter;

class AdminController extends Controller
{
    /**
     * Get all admin users
     * 
     * @response Admin[]
     * 
     */ 
   #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
   #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function index(){
        $admins = Admin::all();

        if ($admins->isEmpty()) {
            return response()->json(['message' => 'There are no admins.'], 404);
        }

        return response()->json($admins, 200);
    }

    /**
     * Create an admin user
     * @response Admin[]
     */
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
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

    /**
     * Get an single admin user
     * @response Admin[]
     */
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function show(Request $request){
        $admin = Admin::find($request->authed_user->id);

        if (!$admin) {
            return response()->json(['message' => 'Admin user not found.'], 404);
        }

        return response()->json(new AdminResource($admin), 200);
    }

    /**
     * Update an admin user
     * @response Admin[]
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function update(Request $request){
        $admin = Admin::find($request->authed_user->id);
    
        if (!$admin) {
            return response()->json(['message' => 'Admin user not found.'], 404);
        }
    
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:admins,email,' . $admin->id,
        ]);
    
        $admin->update(array_filter($validatedData));
    
        return response()->json(new AdminResource($admin), 200);
    }

    /**
     * Delete an admin user
     */
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function destroy(Request $request){
        $admin = Admin::find($request->authed_user->id);
    
        if (!$admin) {
            return response()->json(['message' => 'Admin user cannot be found.'], 404);
        }
    
        $admin->delete();
    
        return response()->json(['message' => 'Admin user deleted successfully.'], 200);
    }

    /**
     * Admin login.
     * @response Admin
     */
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function login(LoginRequest $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::verifyCredentials($credentials);

        if (!$admin) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        return response()->json($admin, 200);
    }
}