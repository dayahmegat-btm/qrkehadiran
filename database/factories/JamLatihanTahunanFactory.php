<?php

namespace Database\Factories;

use App\Models\JamLatihanTahunan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JamLatihanTahunan>
 */
class JamLatihanTahunanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate realistic training hours breakdown
        $jamKursusWajib = $this->faker->randomFloat(2, 0, 30.00);
        $jamKursusSukarela = $this->faker->randomFloat(2, 0, 20.00);
        $jamMesyuarat = $this->faker->randomFloat(2, 0, 15.00);
        $jamBengkel = $this->faker->randomFloat(2, 0, 10.00);
        $jamSeminar = $this->faker->randomFloat(2, 0, 10.00);
        $jamLatihanKhusus = $this->faker->randomFloat(2, 0, 5.00);

        // Calculate total hours
        $jumlahJam = round(
            $jamKursusWajib +
            $jamKursusSukarela +
            $jamMesyuarat +
            $jamBengkel +
            $jamSeminar +
            $jamLatihanKhusus,
            2
        );

        // Default target is 56 hours (as per LNPT requirement)
        $sasaranJam = 56.00;

        // Calculate achievement percentage
        $peratusPencapaian = $jumlahJam > 0
            ? round(($jumlahJam / $sasaranJam) * 100, 2)
            : 0;

        // Year (current year or previous years)
        $tahun = $this->faker->numberBetween(date('Y') - 2, date('Y'));

        return [
            'pengguna_id' => null, // Must be set via relationship
            'tahun' => $tahun,
            'jumlah_jam' => $jumlahJam,
            'jam_kursus_wajib' => round($jamKursusWajib, 2),
            'jam_kursus_sukarela' => round($jamKursusSukarela, 2),
            'jam_mesyuarat' => round($jamMesyuarat, 2),
            'jam_bengkel' => round($jamBengkel, 2),
            'jam_seminar' => round($jamSeminar, 2),
            'jam_latihan_khusus' => round($jamLatihanKhusus, 2),
            'sasaran_jam' => $sasaranJam,
            'peratus_pencapaian' => min($peratusPencapaian, 999.99), // Cap at max decimal(5,2)
            'dikemaskini_pada' => now(),
        ];
    }
}
