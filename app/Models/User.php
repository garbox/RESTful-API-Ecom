<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Shipping;



class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'city', 'state_id', 'zip', 'phone'
    ];

    public static function totalSales(int $userId){
        return Order::where('user_id', $userId)->sum('total_price');
    }

    //-----relationships----
    public function orders(){
        return $this->hasMany(Order::class);
    }

    //-----relationships----
    public function carts(){
        return $this->hasMany(Cart::class);
    }

    //-----relationships----
    public function shipping(){
        return $this->hasMany(Shipping::class);
    }
}
