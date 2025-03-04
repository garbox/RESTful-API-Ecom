<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(), 
            'short_description' => $this->faker->sentence(), 
            'price' => $this->faker->randomFloat(0, 500, 50000), 
            'category_id' => Category::inRandomOrder()->first()->id,
            'long_description' => $this->faker->paragraph(), 
            'featured' => 1,
            'available' => 1,
        ];
    }
}
