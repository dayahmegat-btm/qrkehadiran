<?php

namespace Database\Factories;

use App\Models\PesertaAcara;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PesertaAcara>
 */
class PesertaAcaraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusJemputan = $this->faker->randomElement(['dijemput', 'sah', 'tolak', 'gantian']);
        $kategoriKehadiran = $this->faker->randomElement(['fizikal', 'dalam_talian']);

        // Generate unique token for online events
        $tokenPautanUnik = null;
        $tarikhTamatToken = null;

        if ($this->faker->boolean(40)) { // 40% have unique tokens (online/hybrid events)
            $tokenPautanUnik = bin2hex(random_bytes(16)); // 32-character hex string
            $tarikhTamatToken = $this->faker->dateTimeBetween('+1 day', '+7 days');
        }

        return [
            'acara_id' => null, // Must be set via relationship
            'pengguna_id' => null, // Must be set via relationship
            'status_jemputan' => $statusJemputan,
            'kategori_kehadiran' => $kategoriKehadiran,
            'token_pautan_unik' => $tokenPautanUnik,
            'tarikh_tamat_token' => $tarikhTamatToken,
            'dicipta_pada' => now(),
        ];
    }
}
