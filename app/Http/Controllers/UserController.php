<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        $user = User::create($validatedData);

        return response()->json($user, 201);
    }

    public function show(int $userId){
        $user = User::find($userId);

        if(!$user){
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json(new UserResource($user),200);
    }

    public function update(Request $request, int $userID){
        $user = User::find($userID);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $userID,
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->save(); 

        return response()->json($user, 200); // HTTP 200 OK
    }

    public function destroy(int $userId){
        $user = User::find($userId);

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

    public function getOrders(int $userId){
        $orders = User::with('orders.shipping')->find($userId);

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

    public function getShippingInfo(int $userId){
        $userOrders = User::with('shipping')->withOut('orders')->find($userId);

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

    public function getCartInfo(int $userId){
        $userCart = User::with('carts.product')->find($userId);
        
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

    public function totalSales(int $userId){
        $user = User::find($userId);

        if(!$user){
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        return response()->json([
            'total' => User::totalSales($userId),
        ],200);
    }

}
