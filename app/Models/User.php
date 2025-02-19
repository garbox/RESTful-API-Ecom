<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Shipping;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'city', 'state', 'zip', 'phone', 'api_token'
    ];

    public static function totalSales(int $userId){
        return Order::where('user_id', $userId)->sum('total_price');
    }

    public static function verifyToken(?string $token){
        return User::where('api_token', $token)->first();
    }

    //-----relationships----
    public function orders(){
        return $this->hasMany(Order::class);
    }
    
    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function shipping(){
        return $this->hasMany(Shipping::class);
    }
}
