<?php 
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Shipping;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_price', 'stripe_payment_intent_id'
    ];

    public static function orderByUser(User $user){
        return $user->with(['orders.orderitems.product'])->find($user->id)
        ->makeHidden('password','updated_at');
    }

    public static function createOrder(Request $request){
        $user = $request['authed_user'];
        $orderItems = collect();
        $carts = Cart::find($user->api_token)->with('product')->get();

        $totalPrice = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->price;
        });

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'stripe_payment_intent_id' =>$request['stripe_payment_intent_id'],
            ]);

            foreach($carts as $cart){
                $orderItems->push([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);
            }
            
            OrderItem::create($orderItems);

            Shipping::create([
                'user_id' => $request['shipping']->user_id,
                'order_id' => $request['shipping']->$order->id,
                'name' => $request['shipping']->name,
                'email' => $request['shipping']->email,
                'phone' => $request['shipping']->phone,
                'address' => $request['shipping']->address,
                'zip' => $request['shipping']->zip,
                'city' => $request['shipping']->city,
                'state' => $request['shipping']->state
            ]);
            
            //reset user api_token and return?
            $user->api_token = Str::random(34);
            $user->save();

            return [
                'order_id' => $order->id,
                'user_api_token' => $user->api_token,
            ];
        }

        catch (\Exception $e) {    

            return $e->getMessage();
        }
    }
    

    //------relationships
    public function orderitems(): HasMany{
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function shipping(): HasOne {
        return $this->hasOne(Shipping::class);
    }

}
