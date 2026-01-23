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
            'name' => $this->faker->words(3, true),
            'code_number' => 'PRO-' . $this->faker->unique()->numberBetween(1000, 9999),
            'price' => $this->faker->randomElement([15000, 25000, 45000, 80000, 120000]),
            'is_available' => $this->faker->boolean(80),
            'image' => 'https://placehold.co/600x400?text=Product+Image',
            'category_id' => \App\Models\Category::factory(), // Fallback for safety
        ];
    }
}