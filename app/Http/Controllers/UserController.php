<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Dedoc\Scramble\Attributes\HeaderParameter;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\CartResource;
use App\Http\Resources\ShippingResource;
use App\Http\Resources\OrderResource;

class UserController extends Controller
{
    /**
     * Show all users
     * 
     * @response User[]
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function index(){
        $users = User::all();
        if ($users->isEmpty()) {
            return response()->json([
                'message' => 'There is no user information available.',
            ], 404);
        }

        return UserResource::collection($users);
    }

    /**
     * Create a new user
     * 
     * @response User
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|confirmed|unique:users,email',
            'address' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|integer',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['api_token'] = Str::random(34);

        $user = User::create($validatedData);

        return new UserResource($user);
    }

    /**
     * Show a user
     * 
     * @response User
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function show(Request $request){
        return new UserResource($request->authed_user);
    }

    /**
     * Update a user
     * 
     *
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function update(Request $request){
        $user = User::find($request->authed_user->id);
        
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $request->authed_user->id,
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
        ]);

        if (empty($validatedData)) {
            return response()->json(['message' => 'No valid data provided'], 400);
        }
        
        $user->updateOrFail(array_filter($validatedData));

        return new UserResource($user);
    }

    /**
     * Delete a user
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function destroy(Request $request){
        $user = User::find($request->authed_user->id);

        if (!$user) {
            return response()->json(['message' => 'User cannot be found.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.'], 200);
    }

    /**
     * Get all orders for a user
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function getOrders(Request $request){
        $user = User::with('orders.shipping')->find($request->authed_user->id);

        if (!$user) {
            return response()->json([
                'message' => "User not found",
            ], 404);
        }

        if ($user->orders->isEmpty()) {
            return response()->json([
                'message' => "User has no orders",
            ], 404);
        }

        return OrderResource::collection($user->orders);
    }

    /**
     * Get shipping information for a user
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function getShippingInfo(Request $request){
        $user = User::with('shipping')->find($request->authed_user->id);

        if (!$user) {
            return response()->json([
                'message' => "User cannot be found",
            ], 404);
        }

        if ($user->shipping->isEmpty()) {
            return response()->json([
                'message' => "User has no shipping information",
            ], 404);
        }

        return ShippingResource::collection($user->shipping);
    }

    /**
     * Get cart information for a user
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function getCartInfo(Request $request){
        $user = User::with('carts.product')->find($request->authed_user->id);

        if (!$user) {
            return response()->json(['message' => 'User cannot be found'], 404);
        }

        if ($user->carts->isEmpty()) {
            return response()->json(['message' => 'User cart is empty'], 404);
        }

        return CartResource::collection($user->carts);
    }

    /**
     * Show total sales for a user
     * 
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function totalSales(Request $request){
        $user = User::find($request->authed_user->id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'total' => User::totalSales($user->id),
        ], 200);
    }

    /**
     * User login
     * 
     * @response User
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json($user, 201);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}