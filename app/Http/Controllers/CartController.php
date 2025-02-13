<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;

class CartController extends Controller
{
    public function index(){
        $carts = Cart::with('product.category')->get();

        if($carts->isEmpty()){
            return response()->json([
                'message' => 'There are no cart items.',
            ], 404);
        }
        return response()->json([
            'carts' => $carts,
        ], 201);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'session_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $cart = Cart::create($validatedData);
    
        return response()->json($cart, 201);
    }

    public function show(int $cartId){
        $cart = Cart::with('product.category')->find($cartId);

        if(!$cart){
            return response()->json([
                'message' => 'Cart not found'
            ],404);
        }
        
        return response()->json([
            'cart' => $cart,
        ],200);
    }

    public function update(Request $request, int $cartID){
        $cart = Cart::find($cartID);

        if (!$cart) {
            return response()->json(['error' => 'Cart not found'], 404);
        }

        $validatedData = collect($request->validate([
            'quantity' => 'nullable|integer',
        ]));

        $updatedData = array_filter($validatedData, function ($value) {
            return !is_null($value);
        });
    
        $cart->update($updatedData);

        return response()->json($cart, 200);
    }

    public function destroy(int $cartId){
        $cart = Cart::find($cartId);
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

    public function cartBySession(string $sessionToken){
        $cart = Cart::sessionCart($sessionToken);
        if($cart->isEmpty()){
            return response()->json([
                'message' => 'Cart not found with session Id.'
            ],404);
        }

        return response()->json([
            'session_id' => $sessionToken,
            'cart'=> $cart,
        ],200);
    }

    public function cartByUser(int $cartId){
        $user = User::find($cartId);

        if(!$user){
            return response()->json([
                'message' => "User not found",
            ],200);
        }

        $cart = Cart::userCart($cartId);

        if ($cart->carts->isEmpty()) {
            return response()->json([
                'message' => 'Cart not found for the given user id.'
            ], 200); 
        }
        return response()->json($cart,200);
    }
}
