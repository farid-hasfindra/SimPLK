<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori = $this->faker->randomElement(['obat', 'makanan', 'aksesoris', 'vaksin']);
        
        $namaBarang = match($kategori) {
            'obat' => $this->faker->randomElement(['Paracetamol Cat', 'Amoxicillin Pet', 'Vitamin C Dog', 'Obat Cacing', 'Salep Kulit']),
            'makanan' => $this->faker->randomElement(['Royal Canin', 'Whiskas', 'Pedigree', 'Me-O', 'Pro Plan']),
            'aksesoris' => $this->faker->randomElement(['Kalung Kucing', 'Mainan Tulang', 'Tempat Makan', 'Kandang Lipat', 'Sisir Bulu']),
            'vaksin' => $this->faker->randomElement(['Vaksin Rabies', 'Vaksin F3', 'Vaksin F4', 'Vaksin Distemper']),
        };

        return [
            'nama_barang' => $namaBarang . ' ' . $this->faker->word(),
            'kategori' => $kategori,
            'stok' => $this->faker->numberBetween(10, 100),
            'harga_satuan' => $this->faker->numberBetween(10, 500) * 1000,
            'satuan' => $this->faker->randomElement(['Pcs', 'Botol', 'Kaleng', 'Sachet']),
        ];
    }
}
