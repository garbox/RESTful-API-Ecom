<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Order;

class Shipping extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'email', 'address', 'city', 'zip', 'state', 'phone', 'user_id', 'order_id'
    ];

    public static function edit(int $id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip' => 'nullable|string|max:20',
            'state_id' => 'nullable|integer|exists:states,id',
            'note' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Find the shipping record by ID
        $shipping = Shipping::find($id);

        if (!$shipping) {
            return response()->json(['message' => 'Shipping info not found.'], 404);
        }

        // Update the shipping record
        $shipping->update($request->all());

        return response()->json([
            'message' => 'Shipping information updated successfully.',
            'shipping' => $shipping
        ]);
    }

    public static function get(int $id){
        $shipping = Shipping::find($id);

        if (!$shipping) {
            return response()->json(['message' => 'Shipping info not found.'], 404);
        }

        return response()->json($shipping);
    }

    public static function updateShipping(Shipping $shipping, Request $request){

        $shipping->update([
            'name' => $request->name ?? $shipping->name,
            'email' => $request->email ?? $shipping->email,
            'address' => $request->address ?? $shipping->address,
            'zip' => $request->zip ?? $shipping->zip,
            'state' => $request->state ?? $shipping->state,
        ]);

        return $shipping;
    }

    public static function userShipping(int $userId){
        $shipping = Shipping::where('user_id', $userId)->get();

        if ($shipping->isEmpty()) {
            return response()->json(['message' => 'No shipping information found for this user.'], 404);
        }

        return response()->json($shipping);
    }

    //-----relationships----
    public function user(){
        return $this->hasOne(User::class);
    }

    public function order(){
        return $this->hasOne(Order::class);
    }
}
