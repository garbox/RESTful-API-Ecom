<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;
use App\Models\Order;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    public function definition(): array
    {   
        $faker = Faker::create();
        $product = Product::inRandomOrder()->first();
        $order = Order::inRandomOrder()->first();
        return [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $faker->randomNumber(1),
            'price' => $product->price,
        ];
    }
}
