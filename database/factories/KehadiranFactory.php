<?php

namespace Database\Factories;

use App\Models\Kehadiran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kehadiran>
 */
class KehadiranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Total mandatory sessions (for multi-day events)
        $jumlahSesiWajib = $this->faker->numberBetween(5, 12);

        // Sessions attended (must be <= total mandatory sessions)
        $sesiWajibDihadiri = $this->faker->numberBetween(0, $jumlahSesiWajib);

        // Calculate attendance percentage
        $peratusKehadiran = $jumlahSesiWajib > 0
            ? round(($sesiWajibDihadiri / $jumlahSesiWajib) * 100, 2)
            : 0;

        // Determine certificate eligibility based on percentage
        if ($peratusKehadiran >= 80) {
            $statusKelayakanSijil = 'penuh';
        } elseif ($peratusKehadiran >= 50) {
            $statusKelayakanSijil = 'sebahagian';
        } else {
            $statusKelayakanSijil = 'tidak_layak';
        }

        // Calculate total training hours (assuming 3 hours per session average)
        $jumlahJamLatihan = $sesiWajibDihadiri * $this->faker->randomFloat(2, 2.5, 4.0);

        return [
            'acara_id' => null, // Must be set via relationship
            'pengguna_id' => null, // Must be set via relationship
            'jumlah_sesi_wajib' => $jumlahSesiWajib,
            'sesi_wajib_dihadiri' => $sesiWajibDihadiri,
            'peratus_kehadiran_dikira' => $peratusKehadiran,
            'jumlah_jam_latihan_acara' => round($jumlahJamLatihan, 2),
            'status_kelayakan_sijil' => $statusKelayakanSijil,
            'tarikh_dikira' => now(),
        ];
    }
}
