<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rating' => $this->faker->randomFloat(1, 1, 5), // 1.0 – 5.0
            'review' => $this->faker->paragraph(),
            'produk_id' => null, // di override dari seeder
            'user_id' => null,
        ];
    }
}
