<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Shipping;

class User extends Authenticatable
{
    use HasFactory;
    use Billable;

    protected $fillable = [
        'name', 'email', 'password', 'address', 'city', 'state', 'zip', 'phone', 'api_token'
    ];

    protected $hidden = [
        'password', 'email_verified_at', 'created_at', 'updated_at', 'stripe_id', 'pm_type', 'pm_last_four', 'trial_ends_at'
    ];
    
    public static function totalSales(int $userId){
        return Order::where('user_id', $userId)->sum('total_price');
    }

    public static function verifyToken(?string $token){
        return User::where('api_token', $token)->first();
    }

    //-----relationships----
    public function orders(): HasMany{
        return $this->hasMany(Order::class);
    }
    
    public function carts(): HasMany{
        return $this->hasMany(Cart::class);
    }

    public function shipping(): HasMany{
        return $this->hasMany(Shipping::class);
    }
}
