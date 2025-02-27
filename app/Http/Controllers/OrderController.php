<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('user.shipping')->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'message' => 'There are no orders.',
            ], 404);
        }

        foreach($orders as $order){
            $order->user->shipping->makeHidden('user_id')->makeHidden('order_id');
            $order->user->makeHidden('password', 'remember_token');
        }
        
        return response()->json($orders,200);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'stripe_payment_intent_id' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|phone|max:255',
            'address' => 'required|string|max:255',
            'zip' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        $order = Order::createOrder($request);
        
        // if there is an error it should be handled via app.php 
        return response()->json($order, 201);        
    }

    public function show(int $cartId){
        $order = Order::find($cartId);

        if(!$order){
            return response()->json([
                'message' => 'Order not found',
            ], 404);
        }
        
        return response()->json($order, 200);
    }

    public function update(Request $request, int $orderId){
        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $validatedData = collect($request->validate([
            'total_price' => 'nullable|integer|min:255',
        ]));

        $updatedData = array_filter($validatedData, function ($value) {
            return !is_null($value);
        });
    
        $order->update($updatedData);

        return response()->json($order, 200); 
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

    public function orderByUser(Request $request, ?int $user_id){
        $user = User::where("api_token", $request->header("USER_API_KEY"))
                ->orWhere('id', $user_id)->first();

        if(!$user){
            return response()->json(['message' => 'No user found'], 404);
        }

        $orders = Order::orderByUser($user);

        if ($orders['orders']->isEmpty()) {
            return response()->json([
                'message' => 'No orders found for this user.',
            ], 404);
        }

        return response()->json($orders,200);
    }
}
