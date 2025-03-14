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

use function PHPSTORM_META\type;

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
        $totalPrice = 0;
        $orderItems = collect();

        // payment intent_id... send to stripe and get a success message. might be able to get total from stripe object since payment intent confimrs all that info. 
        
        try {

            foreach ($carts as $cart){
                $totalPrice += $cart->price * $cart->quantity;
            }

            // Create the order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
                'stripe_payment_intent_id' => 'some_payment_intent_id', // Replace with actual payment intent ID
            ]);
            
            foreach ($carts as $cart) {
                $orderItems->push([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);
            }

            // Insert order items
            OrderItem::insert($orderItems->toArray());
    
            // Create shipping information
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
    
            // Update user's API token
            $user->api_token = Str::random(34);
            $user->save();
    
            // Clear the user's cart
            Cart::where('user_id', $user->id)->delete();
    
            return response()->json($order, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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
