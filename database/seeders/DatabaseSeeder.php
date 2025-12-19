<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Barang
        \App\Models\Barang::factory(20)->create();

        // Dokter
        \App\Models\Dokter::factory(5)->create();

        // Pelanggan & Hewan
        \App\Models\Pelanggan::factory(10)->create()->each(function ($pelanggan) {
            \App\Models\Hewan::factory(rand(1, 3))->create([
                'pelanggan_id' => $pelanggan->id
            ]);
        });
    }
}
