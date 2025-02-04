<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'password' => bcrypt('password'), // Default password
            'remember_token' => \Str::random(10),
        ];
    }
}
