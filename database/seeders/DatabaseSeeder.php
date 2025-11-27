<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123'),
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => 'customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('123'),
            'is_admin' => false,
        ]);
        User::factory(8)->create();

        Tag::factory(10)->create();

        $this->call(ProdukSeeder::class);
    }
}
