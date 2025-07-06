<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => "product_".fake()->unique(true)->numberBetween(0,1001),
            'sku' => fake()->regexify('[A-Z0-9]{8}'),
            'description' => fake()->sentence,
        ];
    }
}
