<?php 
namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Cart;
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
        $carts = Cart::userCart($user->id);

        //$paymentMethodId = $request->input('payment_method_id');
        //$payment = Payment::processPayment($paymentMethodId);
        //if ($payment->status !== 'succeeded') {
        //   return response()->json(['error' => 'Payment failed'], 400);
        //}
        
        // Calculate the total price from the cart items
        $totalPrice = $carts->sum(fn($cart) => $cart->quantity * $cart->product->price);

        try {

            
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'stripe_payment_intent_id' => 'some_payment_intent_id', // Replace with actual payment intent ID
            ]);

            $orderItems = $carts->map(fn($cart) => [
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price,
            ])->toArray(); 
            
            OrderItem::insert($orderItems);

            Shipping::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'name' => $request->input('shipping_name'),
                'email' => $request->input('shipping_email'),
                'phone' => $request->input('shipping_phone'),
                'address' => $request->input('shipping_address'),
                'zip' => $request->input('shipping_zip'),
                'city' => $request->input('shipping_city'),
                'state' => $request->input('shipping_state'),
            ]);

            $user->api_token = Str::random(34);
            $user->save();
            Cart::where('user_id', $user->id)->delete();

            return  $order;
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
