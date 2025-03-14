<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'session_id', 'quantity', 'user_id', 'price'
    ];

    public static function userCart(int $userId)
    {
        $user = User::with('carts.product')->find($userId);
        return $user->carts;
    }

    public static function sessionCart(string $session_id){
        $cart =  Cart::with('product.category')
        ->where('session_id', $session_id)
        ->get();

        return $cart;
    }

    //-----relationships------

    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }
}
