<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\User;
use Dedoc\Scramble\Attributes\HeaderParameter;
use Dedoc\Scramble\Attributes\BodyParameter;

class CartController extends Controller
{
    /**
     * Show all Carts tokens.
     * 
     * @response Cart[]
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'Admin API Token', type: 'string')]
    public function index(){
        $carts = Cart::with('product.category')->get();

        if ($carts->isEmpty()) {
            return response()->json(['message' => 'There are no cart items.'], 404);
        }

        return response()->json(['carts' => $carts], 200);
    }

    /**
     * Store a cart item.
     * 
     * @response Cart
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function store(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'session_id' => 'nullable|string',
        ]);

        if ($request->header('USER_API_KEY')) {
            $user = User::where('api_token', $request->header('USER_API_KEY'))->first();
            $validatedData['user_id'] = $user->id;
            $validatedData['session_id'] = $user->api_token;
        } elseif (!$request->session_id) {
            $validatedData['session_id'] = Str::random(34);
        }

        $cart = Cart::create($validatedData);

        return response()->json($cart, 201);
    }

    /**
     * Show a cart item.
     * 
     * @response Cart
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function show(Request $request){
        $query = Cart::with('product.category');

        if ($session_id = $request->header('session_id')) {
            $query->where('session_id', $session_id);
            $cart = $query->get();
        } elseif ($api_token = $request->header('USER_API_KEY')) {
            $query->where('session_id', $api_token);
            $cart = $query->get();
        } else {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        return response()->json($cart, 200);
    }

    /**
     * Update a cart item.
     * 
     * @response Cart
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function update(Request $request){
        $cart = Cart::find($request->cart_id);

        if (!$cart) {
            return response()->json(['message' => 'Cart not found'], 404);
        }

        $validatedData = $request->validate([
            'quantity' => 'nullable|integer|min:1',
        ]);

        if ($request->header('USER_API_KEY')) {
            $validatedData['session_id'] = $request->header('USER_API_KEY');
        }

        $cart->update(array_filter($validatedData));

        return response()->json($cart, 200);
    }

    /**
     * Delete a cart item.
     * 
     * @response Cart
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function destroy(Request $request){
        $cart = Cart::find($request->cart_id);

        if (!$cart) {
            return response()->json(['message' => 'Cart cannot be found.'], 404);
        }

        if ($cart->delete()) {
            return response()->json(['message' => 'Cart has been deleted successfully.'], 200);
        } else {
            return response()->json(['message' => 'Failed to delete cart.'], 500);
        }
    }

    /**
     * Show cart by sessions_id
     * 
     * @response Cart
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[BodyParameter('session_id', description: 'Main Application API Token', type: 'string')]
    public function cartBySession(Request $request){
        $cart = Cart::sessionCart($request->input('session_id'));

        if ($cart->isEmpty()) {
            return response()->json(['message' => 'Cart not found with session Id.'], 404);
        }

        return response()->json($cart, 200);
    }

    /**
     * Show cart by User API Token
     * 
     * @response Cart
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string')]
    public function cartByUser(Request $request){
        $user = User::find($request->authed_user->id);
        $cart = Cart::where('user_id', $user->id)->with('product.category')->get();

        if ($cart->isEmpty()) {
            return response()->json(['message' => 'Cart not found for the given user.'], 404);
        }

        return response()->json($cart, 200);
    }
}