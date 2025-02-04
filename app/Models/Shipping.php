<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Order;

class Shipping extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'email', 'address', 'city', 'zip', 'state', 'phone', 'user_id', 'order_id'
    ];

    //-----relationships----
    public function user(){
        return $this->hasOne(User::class);
    }

    public function order(){
        return $this->hasOne(Order::class);
    }
}
