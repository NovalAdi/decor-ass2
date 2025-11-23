<?php

namespace Database\Seeders;

use App\Models\GambarProduk;
use App\Models\Produk;
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
            });
    }
}
