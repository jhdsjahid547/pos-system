<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaxDiscount>
 */
class TaxDiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vat' => fake()->randomFloat(10, 50),
            'discount' => fake()->randomFloat(5, 80)
        ];
    }
}
