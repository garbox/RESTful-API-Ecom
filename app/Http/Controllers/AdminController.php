<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Admin;

class AdminController extends Controller
{
    
    public function index(){
        $admins = Admin::all();

        if($admins->isEmpty()){
            return response()->json([
                'message' => 'There are no admins.',
            ], 404);
        }

        return response()->json($admins, 201);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'role_id' => 'required|integer',
            'permissions' => 'required|integer',
        ]);
    
        $admin = Admin::create($validatedData);
    
        return response()->json($admin, 201);
    }

    public function show(int $adminId){
        $admin = Admin::find($adminId);
        if(!$admin){
            return response()->json([
                'message' => 'Admin user not found.'
            ], 404);
        }
        return response()->json($admin, 200);
    }

    public function update(Request $request, $adminId){
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $adminId,
        ]);

        $admin = Admin::find($adminId);

        if (!$admin) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $admin->name = $validatedData['name'];
        $admin->email = $validatedData['email'];
        $admin->save(); 

        return response()->json($admin, 200); // HTTP 200 OK
    }

    public function destroy(int $adminId){
        $admin = Admin::find($adminId);

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

    //-------Not used but reponse needed --->
    public function edit(){
        return response()->json([
            'message' => "Please use PUT PATCH api/admin/*adminID* to update admin info"
        ],404);
    }

    public function create(){
        return response()->json([
            'message' => "Please use POST api/admin with proper payload to create admin user"
        ],404);
    }
}
