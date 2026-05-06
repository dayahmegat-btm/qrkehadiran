<?php

namespace Database\Factories;

use App\Models\Sesi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sesi>
 */
class SesiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Session titles
        $sessionTitles = [
            'Sesi Pagi - Pengenalan',
            'Sesi Petang - Praktikal',
            'Hari 1 - Teori Asas',
            'Hari 2 - Kajian Kes',
            'Sesi 1 - Pembentangan',
            'Sesi 2 - Perbincangan Kumpulan',
            'Sesi Slot 1',
            'Sesi Slot 2',
        ];

        $masaMula = $this->faker->time('H:i:s', '16:00:00'); // Between 08:00 and 16:00
        $duration = $this->faker->numberBetween(2, 4); // 2-4 hours
        $masaTamat = date('H:i:s', strtotime($masaMula . ' +' . $duration . ' hours'));

        // Calculate training hours
        $jamLatihan = $duration + ($this->faker->boolean(30) ? 0.5 : 0); // Sometimes add 0.5 hours

        return [
            'acara_id' => null, // Must be set via relationship
            'urutan_sesi' => $this->faker->numberBetween(1, 10),
            'tajuk_sesi' => $this->faker->randomElement($sessionTitles),
            'tarikh' => $this->faker->dateTimeBetween('now', '+6 months'),
            'masa_mula' => $masaMula,
            'masa_tamat' => $masaTamat,
            'lokasi_sesi' => $this->faker->optional(0.5)->randomElement([
                'Bilik Mesyuarat 1',
                'Dewan Utama',
                'Bilik Latihan A',
                'Auditorium',
            ]),
            'jam_latihan_dikira' => $jamLatihan,
            'qr_token_sesi' => null, // Generated separately
            'qr_mod_sesi' => $this->faker->randomElement(['statik', 'dinamik']),
            'adalah_wajib' => $this->faker->boolean(80), // 80% mandatory
            'tempoh_sah_imbas_sebelum_minit' => $this->faker->numberBetween(15, 30),
            'tempoh_sah_imbas_selepas_minit' => $this->faker->numberBetween(15, 30),
            'status_sesi' => $this->faker->randomElement(['akan_datang', 'aktif', 'selesai']),
        ];
    }
}
