<?php 
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Shipping;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_price', 'status_id', 'stripe_payment_intent_id'
    ];

    public static function orderByUser(User $user){

        return $user->with('orders')->find($user->id)
        ->makeHidden('password','remember_token', 'updated_at');
    }

    //------relationships
    public function orderitems(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function shipping(){
        return $this->hasOne(Shipping::class);
    }

}
