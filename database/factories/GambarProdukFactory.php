<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GambarProduk>
 */
class GambarProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $seed = $this->faker->numberBetween(1000, 1100);

        return [
            'gambar' => 'https://picsum.photos/seed/' . $seed . '/600/400',
        ];
    }
}
