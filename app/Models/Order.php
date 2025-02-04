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

    public static function updateCart(int $id, $data){
        $order = Order::find($id);

        if ($order) {
            $order->update($data);

            return response()->json([
                'message' => 'Order updated successfully.',
                'order' => $order
            ]);
        }

        return response()->json(['message' => 'Order not found.'], 404);
    }

    public static function orderByUser(int $userId){
        $user = User::find($userId);
    
        if (!$user) {
            return false; 
        }

        return $user->with('orders')->find($userId)
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
