<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Dedoc\Scramble\Attributes\HeaderParameter;

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
    #[HeaderParameter('USER_API_KEY', description: 'User API Token', type: 'string|nullable')]
    public function store(Request $request){
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'session_id' => 'nullable|string',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $validatedData['price'] = Product::price($validatedData['product_id']);
        
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
     * @response Cart[]
     */ 
    #[HeaderParameter('GLOBAL_API_KEY', description: 'Main Application API Token', type: 'string')]
    public function show(Request $request, int $cartId){
        $query = Cart::with('product.category');
    
        $session_id = $request->session_id ?? $request->header('USER_API_KEY');
    
        if (!$session_id) {
            return response()->json(['message' => 'Cart not found'], 404);
        }
    
        $cart = $query->where('session_id', $session_id)->get();
    
        if ($cart->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 200);
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
    #[HeaderParameter('session_id', description: 'Main Application API Token', type: 'string')]
    public function cartBySession(Request $request){
        $cart = Cart::sessionCart($request->header('session_id'));

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
        $cart = Cart::userCart($user->id);
        
        if ($cart->isEmpty()) {
            return response()->json(['message' => 'Cart not found for the given user.'], 404);
        }

        return response()->json($cart, 200);
    }
}