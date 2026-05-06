<?php

namespace Database\Factories;

use App\Models\KehadiranSesi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KehadiranSesi>
 */
class KehadiranSesiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate check-in timestamp
        $masaDaftarMasuk = $this->faker->dateTimeBetween('-30 days', 'now');

        // 80% of records have check-out, 20% don't
        $masaDaftarKeluar = $this->faker->boolean(80)
            ? (clone $masaDaftarMasuk)->modify('+' . $this->faker->numberBetween(2, 4) . ' hours')
            : null;

        // Kedah GPS coordinates (realistic range)
        $koordinatLat = $this->faker->randomFloat(8, 5.5, 6.5);
        $koordinatLng = $this->faker->randomFloat(8, 100.0, 101.0);

        // Attendance method
        $kaedahKehadiran = $this->faker->randomElement([
            'qr_fizikal',
            'qr_skrin',
            'pautan_unik',
            'pengesahan_berterusan',
            'api_meeting'
        ]);

        // Is this a substitute attendance?
        $adalaWakilGantian = $this->faker->boolean(10); // 10% are substitutes

        // Calculate training hours credited
        if ($masaDaftarKeluar) {
            $hoursDiff = ($masaDaftarKeluar->getTimestamp() - $masaDaftarMasuk->getTimestamp()) / 3600;
            $jamLatihanDikreditkan = round($hoursDiff, 2);
        } else {
            // If no check-out, credit based on session duration (typically 3 hours)
            $jamLatihanDikreditkan = $this->faker->randomFloat(2, 2.5, 4.0);
        }

        // Verification percentage (for continuous verification)
        $peratusPengesahan = $kaedahKehadiran === 'pengesahan_berterusan'
            ? $this->faker->randomFloat(2, 75.00, 100.00)
            : 100.00;

        // User agents (realistic device types)
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X)',
            'Mozilla/5.0 (iPad; CPU OS 16_0 like Mac OS X)',
            'Mozilla/5.0 (Android 13; Mobile)',
        ];

        return [
            'sesi_id' => null, // Must be set via relationship
            'pengguna_id' => null, // Must be set via relationship
            'peserta_acara_id' => null, // Must be set via relationship
            'masa_daftar_masuk' => $masaDaftarMasuk,
            'masa_daftar_keluar' => $masaDaftarKeluar,
            'koordinat_imbas_lat' => $koordinatLat,
            'koordinat_imbas_lng' => $koordinatLng,
            'alat_imbas' => $this->faker->randomElement($userAgents),
            'ip_imbas' => $this->faker->ipv4(),
            'status_sah' => $this->faker->boolean(95), // 95% valid attendance
            'kaedah_kehadiran' => $kaedahKehadiran,
            'adalah_wakil_gantian' => $adalaWakilGantian,
            'id_peserta_asal' => $adalaWakilGantian ? null : null, // Set via relationship if substitute
            'jam_latihan_dikreditkan' => $jamLatihanDikreditkan,
            'peratus_pengesahan' => $peratusPengesahan,
        ];
    }
}
