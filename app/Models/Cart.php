<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\Category ;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'session_id', 'quantity', 'user_id'
    ];

    public static function userCart(int $userId){
        $user = User::with('carts.product')->find($userId);

        foreach ($user->carts as $cart) {
            $cart->product['category'] = Category::find($cart->product['category_id']);
            $cart->product->category->makeHidden('updated_at', 'created_at');
            $cart->product->makeHidden('short_description', 'long_description','created_at','updated_at','category_id');
            $cart->makeHidden('product_id', "user_id",'created_at','updated_at');
        }

        $user->makeHidden('password','email_verified_at','remember_token','created_at','updated_at');
        return $user;
    }

    public static function sessionCart(string $session_id){
        $cart =  Cart::with('product.category')
        ->where('session_id', $session_id)
        ->get();

        $cart->each(function($cartItem) {
            $cartItem->product->category->makeHidden('updated_at', 'created_at');
            $cartItem->product->makeHidden('category_id','updated_at', 'created_at', 'short_description', 'long_description');
            $cartItem->makeHidden('product_id','updated_at', 'created_at');
        });

        return $cart;
    }

    //-----relationships------

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
