<?php

namespace Database\Factories;

use App\Models\Sijil;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sijil>
 */
class SijilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate unique certificate verification code
        // Format: CERT + YEAR + 6-character alphanumeric
        $year = date('Y');
        $code = 'CERT' . $year . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        // Attendance percentage determines certificate status
        $peratusKehadiran = $this->faker->randomFloat(2, 50.00, 100.00);

        if ($peratusKehadiran >= 80) {
            $statusKehadiran = 'penuh';
            $jenisSijil = 'peserta_penuh';
        } else {
            $statusKehadiran = 'sebahagian';
            $jenisSijil = $this->faker->randomElement(['peserta_sebahagian', 'wakil_gantian']);
        }

        // For partial certificates, generate list of attended sessions
        $senarai_sesi = null;
        if ($statusKehadiran === 'sebahagian') {
            $senarai_sesi = [
                ['sesi' => 'Sesi 1', 'tarikh' => $this->faker->date(), 'jam' => 3.0],
                ['sesi' => 'Sesi 2', 'tarikh' => $this->faker->date(), 'jam' => 2.5],
                ['sesi' => 'Sesi 4', 'tarikh' => $this->faker->date(), 'jam' => 3.5],
            ];
        }

        // Certificate PDF URL (MinIO/S3 path)
        $month = str_pad(date('m'), 2, '0', STR_PAD_LEFT);
        $uuid = $this->faker->uuid();
        $urlPdf = "certificates/{$year}/{$month}/{$uuid}.pdf";

        return [
            'kehadiran_id' => null, // Must be set via relationship
            'url_pdf' => $urlPdf,
            'kod_pengesahan' => $code,
            'dijana_pada' => now(),
            'status_kehadiran' => $statusKehadiran,
            'peratus_kehadiran' => $peratusKehadiran,
            'jenis_sijil' => $jenisSijil,
            'senarai_sesi_dihadiri_json' => $senarai_sesi ? json_encode($senarai_sesi) : null,
        ];
    }
}
