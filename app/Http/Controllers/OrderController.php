<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Shipping;

class OrderController extends Controller
{
    public function index(){
        // Eager load shipping details with orders and debug the query
        $orders = Order::with('user.shipping')->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'There are no orders.',
                'orders' => null,
            ], 404);
        }

        foreach($orders as $order){
            $order->user->shipping->makeHidden('user_id')->makeHidden('order_id');
            $order->user->makeHidden('password', 'remember_token');
        }
        return response()->json($orders->toJson(),200);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'stripe_payment_intent_id' => 'required|string|max:255',
            'user_id' => 'required|integer|exists:users,id',
            'total_price' => 'required|integer|min:1',
        ]);
    
        $user = Order::create($validatedData);
    
        return response()->json($user->toJson(), 201);
    }

    public function show(int $cartId){
        $order = Order::find($cartId);

        if(!$order){
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }
        
        return response()->json($order->toJson(), 200);
    }

    public function update(Request $request, int $orderId){
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $validatedData = $request->validate([
            'total_price' => 'nullable|integer|min:255',
        ]);

        $order->total_price = $validatedData['total_price'];
        $order->save(); 

        return response()->json($order->toJson(), 200); 
    }

    public function destroy(int $orderId){
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order cannot be found.'], 404);
        }
        
        if ($order->delete()) {
            return response()->json(['message' => 'Order deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete order.'], 500);
        }
    }

    public function orderByUser(int $userId){
        $user = User::find($userId);
        if(!$user){
            return response()->json(['message' => 'No user found'], 404);
        }

        $orders = Order::orderByUser($user);

        if (!$orders) {
            return response()->json([
                'message' => 'No orders found for this user.',
            ], 404);
        }

        return response()->json($orders->toJson(),200);
    }

    //-------Not used but reponse needed --->
    public function edit(){
        return response()->json([
            'message' => "Please use PUT PATCH api/order/*orderID* to update admin info"
        ], 404);
    }

    public function create(){
        return response()->json([
            'message' => "Please use POST api/order with proper payload to create a cart item."
        ], 404);
    }
}
