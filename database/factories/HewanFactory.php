<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hewan>
 */
class HewanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jenis = $this->faker->randomElement(['Kucing', 'Anjing', 'Kelinci', 'Hamster']);

        $ras = match($jenis) {
            'Kucing' => $this->faker->randomElement(['Persia', 'Anggora', 'Domestik', 'Maine Coon']),
            'Anjing' => $this->faker->randomElement(['Bulldog', 'Poodle', 'Golden Retriever', 'Husky']),
            'Kelinci' => $this->faker->randomElement(['Anggora', 'Rex', 'Flemish Giant']),
            'Hamster' => $this->faker->randomElement(['Syrian', 'Roborovski', 'Winter White']),
            default => 'Campuran',
        };

        return [
            'pelanggan_id' => Pelanggan::factory(),
            'nama_hewan' => $this->faker->firstName(),
            'jenis_hewan' => $jenis,
            'ras' => $ras,
            'tanggal_lahir' => $this->faker->date(),
        ];
    }
}
