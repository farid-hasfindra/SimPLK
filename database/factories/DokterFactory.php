<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokter>
 */
class DokterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->state(['role' => 'dokter']),
            'spesialisasi' => $this->faker->randomElement(['Umum', 'Bedah', 'Kulit', 'Gigi']),
            'no_sip' => $this->faker->numerify('SIP-####-####'),
            'tarif_dasar' => $this->faker->numberBetween(50, 200) * 1000,
        ];
    }
}
