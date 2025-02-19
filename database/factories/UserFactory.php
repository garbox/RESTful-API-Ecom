<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    // Define the corresponding model
    protected $model = User::class;

    // Define the factory's default state
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'zip' => $this->faker->numerify('7####'),
            'api_token' => Str::random(34),
            'password' => bcrypt('password'), // Default password
        ];
    }
}
