<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\User;

class CartController extends Controller
{
    public function index(){
        $carts = Cart::with('product.category')->get();

        if($carts->isEmpty()){
            return response()->json([
                'message' => 'There are no cart items.',
            ], 201);
        }
        return response()->json([
            'carts' => $carts,
        ], 201);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'session_id' => 'nullable|string',
        ]);


        if ($request->header('USER-API-KEY')) {
            $validatedData['session_id'] = $request->header('USER-API-KEY');
            $validatedData['user_id'] = $request['user_id'];
        } 

        elseif(!$request['session_id']) {
            $validatedData['session_id'] = Str::random(34);
        } 
        
        $cart = Cart::create($validatedData);
    
        return response()->json($cart, 201);
    }

    public function show(Request $request){
        $query = Cart::with('product.category');

        if($request->header('session_id')){
            $query->where('session_id', $request->header('session_id'));
        }
        elseif($request->authed_user){
            $query->where('user_id', $request->authed_user->id);
        }

        $cart = $query->get();

        if ($cart->isEmpty()) {
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }
        
        return response()->json([
            'cart' => $cart,
        ], 200);
    }
    

    public function update(Request $request){
        $cart = Cart::find($request->cart_id);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $validatedData = collect($request->validate([
            'quantity' => 'nullable|integer',
        ]));

        if($request->header('USER_API_KEY')){
            $validatedData['session_id'] = $request->header('USER_API_KEY');
        }

        $updatedData = $validatedData->filter(function (string $value, string $key) {
            return !is_null($value);
        });
        
        $cart->update($updatedData->toArray());

        return response()->json($cart, 200);
    }
    
    public function destroy(Request $request){
        $cart = Cart::find($request->cart_id);
        
        if (!$cart) {
            return response()->json(['message' => 'Cart cannot be found.'], 404);
        }
        
        if ($cart->delete()) {
            return response()->json(['message' => 'Cart has been deleted successfully.'], 200);
        } 
        else {
            return response()->json(['message' => 'Failed to delete admin.'], 500);
        }
    }

    public function cartBySession(string $session_id){
        $cart = Cart::sessionCart($session_id);
        if($cart->isEmpty()){
            return response()->json([
                'message' => 'Cart not found with session Id.'
            ],404);
        }

        return response()->json([
            'cart'=> $cart,
        ],200);
    }

    public function cartByUser(Request $request){
        $user = User::find($request->authed_user->id);

        $cart = Cart::userCart($user->id);

        if ($cart->carts->isEmpty()) {
            return response()->json([
                'message' => 'Cart not found for the given user.'
            ], 200); 
        }
        return response()->json($cart,200);
    }
}

