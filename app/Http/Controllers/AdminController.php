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
   #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
   #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
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
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|confirmed|email|unique:admins,email',
            'role_id' => 'required|integer',
            'permissions' => 'required|integer',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['api_token'] = Str::random(34);
        $admin = Admin::create($validatedData);

        // function to send varification email. 

        return response()->json(new AdminResource($admin), 201);
    }

    /**
     * Get an admin user
     * 
     */
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function show(int $admin_id){
        $admin = Admin::find($admin_id);

        if (!$admin) {
            return response()->json(['message' => 'Admin user not found.'], 404);
        }

        return response()->json(new AdminResource($admin), 200);
    }

    /**
     * Update an admin user
     * 
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function update(Request $request){
        // $request->authed_user->id dosnt allow for documentation to be created due to error. 
        
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:admins,email,' . $request->authed_user->id,
        ]); 
    
        $admin = Admin::find($request->authed_user->id)->update(array_filter($validatedData));
    
        return response()->json(new AdminResource($admin), 200);
    }

    /**
     * Delete an admin user
     */
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function destroy(int $adminId){
        $admin = Admin::find($adminId);
        
        if (!$admin) {
            return response()->json(['message' => 'Admin user cannot be found.'], 404);
        }
    
        $admin->delete();
    
        return response()->json(['message' => 'Admin user deleted successfully.'], 200);
    }

    /**
     * Get a current admins' info.
     */
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function currentAdmin(Request $request){
        $admin = Admin::find($request->authed_user->id);
        
        if (!$admin) {
            return response()->json(['message' => 'Admin user not found.'], 404);
        }

        return response()->json(new AdminResource($admin), 200);
    }

    /**
     * Admin login.
     * @response Admin
     */
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
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