<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Dedoc\Scramble\Attributes\HeaderParameter;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    /**
     * Show all orders
     * 
     *  @response Order[]
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function index(){
        $orders = Order::with('user.shipping')->get();

        if ($orders->isEmpty()) {
            return response()->json(['message' => 'There are no orders.'], 404);
        }

        $orders->each(function ($order) {
            $order->user->shipping->makeHidden(['user_id', 'order_id']);
            $order->user->makeHidden(['password', 'remember_token']);
        });

        return response()->json($orders, 200);
    }

    /**
     * Cerate an order
     * 
     * @response Order[]
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'User API Token', type: 'string')]
    public function store(Request $request){

        $request->validate([
            //Comes from Strip API and starts with pi_**********
            'stripe_payment_intent_id' => 'required|string|min:20',
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|integer|min:10',
            'shipping_address' => 'required|string|max:255',
            'shipping_zip' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
        ]);

        $order = Order::createOrder($request);

        return response()->json($order, 200);
    }

    /**
     * Show an order
     * 
     * @response Order
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function show(int $orderId){
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json($order, 200);
    }

    /**
     * Update an order
     * 
     * @response Order
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function update(Request $request, int $orderId){
        $order = Order::find($orderId);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $validatedData = $request->validate([
            'total_price' => 'nullable|integer|min:0',
        ]);

        $order->update(array_filter($validatedData));

        return response()->json($order, 200);
    }

    /**
     * Destory an order
     * 
     *
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'Admin API Token', type: 'string')]
    public function destroy(int $orderId){
        $order = Order::find($orderId);
    
        if (!$order) {
            return response()->json(['message' => 'Order cannot be found.'], 404);
        }
    
        $order->delete();
    
        return response()->json(['message' => 'Order deleted successfully.'], 200);
    }

    /**
     * Show all orders by user
     * 
     * 
     */ 
    #[HeaderParameter('global-api-key', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('user-api-key', description: 'User API Token', type: 'string')]
    public function orderByUser(Request $request, ?int $user_id = null){
        $user = User::where('api_token', $request->header('user-api-key'))
            ->orWhere('id', $user_id)
            ->first();
            
        if (!$user) {
            return response()->json(['message' => 'No user found'], 404);
        }

        $orders = Order::orderByUser($user);

        if ($orders['orders']->isEmpty()) {
            return response()->json(['message' => 'No orders found for this user.'], 404);
        }

        return OrderResource::collection($orders['orders']);
    }
}