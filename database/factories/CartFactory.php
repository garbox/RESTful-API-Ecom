<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user =  User::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();
        return [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'session_id' => $user->api_token,
            'price' => $product->price,
            'quantity' => 2,
        ];
    }
}
