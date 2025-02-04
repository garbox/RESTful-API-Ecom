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

    public static function edit(int $id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state_id' => 'nullable|integer|exists:states,id',
            'zip' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'address' => $request->address ?? $user->address,
            'city' => $request->city ?? $user->city,
            'state_id' => $request->state_id ?? $user->state_id,
            'zip' => $request->zip ?? $user->zip,
            'phone' => $request->phone ?? $user->phone,
        ]);

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    public static function get(int $userId){
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        return response()->json($user);
    }

    public static function updateUser(int $id, array $data){
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->update($data);

        return response()->json([
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }

    public static function destory(int $userId){
        $user = User::find($userId);

        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User has successfully been deleted.']);
        } else {
            return response()->json(['message' => 'User was not found.'], 404);
        }
    }

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
