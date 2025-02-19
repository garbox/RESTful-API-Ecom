<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


use App\Models\User;

class UserController extends Controller
{

    public function index(){
        $user = User::all();
        if($user->isEmpty()){
            return response()->json([
                'message' => 'There is no user information avaliable.',
            ], 404);
        }
        return response()->json(UserResource::collection($user), 201);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|confirmed|unique:users,email',
            'address' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['api_token'] = Str::random(34);

        $user = User::create($validatedData);

        return response()->json(new UserResource($user), 201);
    }

    public function show(Request $request){
        return response()->json(new UserResource($request->authed_user),200);
    }

    public function update(Request $request){
        $user = User::find($request->authed_user->id);

        $validatedData = collect($request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $request->authed_user->id,
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
        ]));

        $updatedData = array_filter($validatedData, function ($value) {
            return !is_null($value);
        });
    
        $user->update($updatedData);
    
        return response()->json(new UserResource($user), 200);
    }

    public function destroy(Request $request){
        $user = User::find($request->authed_user->id);

        $validatedData = collect($request->validate([
            'api_token' => 'required|string|max:34',
        ]));

        if (!$user) {
            return response()->json(['message' => 'User cannot be found.'], 404);
        }
        
        if ($user->delete()) {
            return response()->json(['message' => 'User deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete user.'], 500);
        }
    }

    public function getOrders(Request $request){
        $orders = User::with('orders.shipping')->find($request->authed_user->id);

        if(!$orders){
            return response()->json([
                'message' => "User not found",
            ], 404);
        }

        if($orders->orders->isEmpty()){
            return response()->json([
                'message' => "User has no orders",
            ], 404);
        }

        foreach($orders->orders as $order){
            $order->shipping->makeHidden('user_id', 'order_id', 'updated_at');
            $order->makeHidden('user_id','updated_at');
        }

        $orders->makeHidden('password','remember_token', 'email_verified_at');
        return response()->json($orders, 200);
    }

    public function getShippingInfo(Request $request){
        $userOrders = User::with('shipping')->withOut('orders')->find($request->authed_user->id);

        if(!$userOrders){
            return response()->json([
                'message' => "User cant not be found",
            ], 404);
        }

        if($userOrders->orders->isEmpty()){
            return response()->json([
                'message' => "User has no orders",
            ], 404);
        }
        
        foreach($userOrders->shipping as $shipping){
            $shipping->makeHidden('user_id','created_at','updated_at');
        }

        $userOrders->makeHidden('password','remember_token', 'email_verified_at','orders',);
        
        return response()->json($userOrders,200);
    }

    public function getCartInfo(Request $request){
        $userCart = User::with('carts.product')->find($request->authed_user->id);
        
        if(!$userCart){
            return response()->json([
                'message' => "User can not be found",
            ], 404);
        }

        if($userCart->carts->isEmpty()){
            return response()->json([
                'message' => "User cart is empty",
            ], 404);
        }
        
        foreach($userCart->carts as $cart){
            $cart->makeHidden('product_id','user_id','created_at','updated_at');
        }

        $userCart->makeHidden('password','remember_token', 'email_verified_at','orders',);
        
        return response()->json($userCart, 200);
    }

    public function totalSales(Request $request){
        $user = User::find($request->authed_user->id);

        if(!$user){
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'total' => User::totalSales($user->id),
        ],200);
    }

    public function login(LoginRequest $request){
        $credentials = $request->validate([
            'email' => 'required'|'email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
    
            return response()->json(new UserResource($user),200);
        }
    
        return response()->json([
            'error' => 'Invalid credentials'
        ], 401);
    }
}
