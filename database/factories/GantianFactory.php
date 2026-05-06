<?php

namespace Database\Factories;

use App\Models\Gantian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Gantian>
 */
class GantianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Substitution reasons in Malay
        $reasons = [
            'Sakit mendadak',
            'Urusan keluarga kecemasan',
            'Cuti kecemasan',
            'Tugas rasmi lain yang bertindih',
            'Urusan perubatan',
            'Kenduri keluarga',
            'Mesyuarat penting',
            'Tidak dapat hadir atas sebab peribadi',
        ];

        $jenisGantian = $this->faker->randomElement(['pra_acara', 'walk_in', 'auto_terbuka', 'per_sesi']);
        $status = $this->faker->randomElement(['menunggu', 'diluluskan', 'ditolak']);

        $masaPermohonan = $this->faker->dateTimeBetween('-7 days', 'now');
        $masaKeputusan = null;
        $penyelarasLulusId = null;
        $ulasanPenyelaras = null;

        // If approved or rejected, set decision details
        if ($status !== 'menunggu') {
            $masaKeputusan = (clone $masaPermohonan)->modify('+' . $this->faker->numberBetween(1, 48) . ' hours');
            $penyelarasLulusId = null; // Must be set via relationship

            if ($status === 'ditolak') {
                $ulasanPenyelaras = $this->faker->randomElement([
                    'Kuota penuh untuk acara ini',
                    'Wakil tidak memenuhi kriteria',
                    'Permohonan lewat',
                    'Alasan tidak mencukupi',
                ]);
            } else {
                $ulasanPenyelaras = $this->faker->optional(0.3)->randomElement([
                    'Diluluskan',
                    'Sila pastikan wakil hadir tepat pada masa',
                ]);
            }
        }

        return [
            'acara_id' => null, // Must be set via relationship
            'sesi_id' => $jenisGantian === 'per_sesi' ? null : null, // Set via relationship for per-session substitution
            'peserta_asal_id' => null, // Must be set via relationship
            'wakil_id' => null, // Must be set via relationship
            'alasan' => $this->faker->randomElement($reasons),
            'jenis_gantian' => $jenisGantian,
            'status' => $status,
            'penyelaras_lulus_id' => $penyelarasLulusId,
            'masa_permohonan' => $masaPermohonan,
            'masa_keputusan' => $masaKeputusan,
            'ulasan_penyelaras' => $ulasanPenyelaras,
        ];
    }
}
