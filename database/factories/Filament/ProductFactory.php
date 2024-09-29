<?php

namespace Database\Factories\Filament;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Filament\Product>
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
            'stripe_product_id' => $this->faker->uuid,
            'name' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
