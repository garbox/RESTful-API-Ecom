<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipping>
 */
class ShippingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a unique list of order IDs
        static $orderIds = [];
    
        if (empty($orderIds)) {
            // Fetch all Order IDs once and shuffle them to randomize
            $orderIds = Order::pluck('id')->shuffle()->toArray();
        }
    
        // Pop the first ID from the list to ensure uniqueness for each shipping record
        $orderId = array_pop($orderIds);
    
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zip' => $this->faker->numerify('7####'),
            'order_id' => $orderId,
            'user_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
