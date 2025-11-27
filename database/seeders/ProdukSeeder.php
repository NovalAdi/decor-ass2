<?php

namespace Database\Seeders;

use App\Models\GambarProduk;
use App\Models\GambarReview;
use App\Models\Produk;
use App\Models\Review;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::factory()
            ->count(20)
            ->create()
            ->each(function (Produk $produk) {
                $jumlahGambar = rand(3, 4);

                GambarProduk::factory()
                    ->count($jumlahGambar)
                    ->create([
                        'produk_id' => $produk->id,
                    ]);

                Review::factory()
                    ->count(rand(1, 5))
                    ->create([
                        'produk_id' => $produk->id,
                        'user_id' => rand(2, 10),
                    ])
                    ->each(function ($review) {
                        GambarReview::factory()
                            ->count(rand(1, 3))
                            ->create([
                                'review_id' => $review->id,
                            ]);
                    });

                $tagIds = Tag::inRandomOrder()->take(2)->pluck('id');
                $produk->tags()->attach($tagIds);
            });
    }
}
