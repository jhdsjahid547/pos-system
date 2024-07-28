<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

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
            'user_id' => 1,
            'category_id' => CategoryFactory::new(),
            'barcode' => fake()->unique()->ean8(),
            'name' => fake()->firstName(),
            'description' => fake()->sentence(),
            'stock' => fake()->numberBetween(1, 10),
            'purchase_price' => fake()->numberBetween(100, 10000),
            'sell_price' => fake()->numberBetween(100, 10000),
            'image' => fake()->unique()->url(),
            'status' => fake()->numberBetween(0, 1)
        ];
    }
}
