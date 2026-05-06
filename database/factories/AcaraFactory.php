<?php

namespace Database\Factories;

use App\Models\Acara;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Acara>
 */
class AcaraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Event categories
        $categories = [
            ['kategori' => 'kursus', 'prefix' => 'KURSUS'],
            ['kategori' => 'mesyuarat', 'prefix' => 'MESYUARAT'],
            ['kategori' => 'bengkel', 'prefix' => 'BENGKEL'],
            ['kategori' => 'seminar', 'prefix' => 'SEMINAR'],
            ['kategori' => 'latihan', 'prefix' => 'LATIH'],
        ];

        $category = $this->faker->randomElement($categories);
        $year = date('Y');
        $sequence = str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT);

        // Realistic event titles
        $eventTitles = [
            'Kursus Pengurusan Masa dan Produktiviti',
            'Bengkel Transformasi Digital Sektor Awam',
            'Seminar Integriti dan Tadbir Urus yang Baik',
            'Kursus Kepimpinan Strategik',
            'Mesyuarat Penyelarasan Bulanan',
            'Bengkel Inovasi Perkhidmatan Awam',
            'Kursus Pengurusan Kewangan Kerajaan',
            'Seminar Kecemerlangan Perkhidmatan',
        ];

        $startDate = $this->faker->dateTimeBetween('now', '+6 months');
        $endDate = (clone $startDate)->modify('+' . $this->faker->numberBetween(1, 5) . ' days');

        // Kedah coordinates (realistic range)
        $kedahLat = $this->faker->randomFloat(6, 5.5, 6.5);
        $kedahLng = $this->faker->randomFloat(6, 100.0, 101.0);

        $jenisAcara = $this->faker->randomElement(['fizikal', 'dalam_talian', 'hibrid']);

        return [
            'no_rujukan' => 'KEDAH-' . $year . '-' . $category['prefix'] . '-' . $sequence,
            'tajuk' => $this->faker->randomElement($eventTitles),
            'kategori' => $category['kategori'],
            'penerangan' => $this->faker->paragraph(3),
            'tarikh_mula' => $startDate,
            'tarikh_tamat' => $endDate,
            'lokasi' => $jenisAcara !== 'dalam_talian' ? 'Dewan Serbaguna, ' . $this->faker->city() . ', Kedah' : null,
            'jenis_acara' => $jenisAcara,
            'kuota' => $this->faker->optional(0.7)->numberBetween(20, 200),
            'status' => $this->faker->randomElement(['draf', 'aktif', 'selesai']),
            'dicipta_oleh' => null, // Must be set via relationship
            'jabatan_id' => null, // Must be set via relationship
            'qr_token' => null, // Generated separately
            'qr_mod' => $this->faker->randomElement(['statik', 'dinamik']),
            'radius_geo_meter' => $jenisAcara === 'fizikal' ? $this->faker->numberBetween(50, 500) : 100,
            'koordinat_lat' => $jenisAcara !== 'dalam_talian' ? $kedahLat : null,
            'koordinat_lng' => $jenisAcara !== 'dalam_talian' ? $kedahLng : null,
            'mod_gantian' => $this->faker->randomElement(['tidak_dibenarkan', 'dengan_kelulusan', 'terbuka']),
            'pengesahan_berterusan_aktif' => $jenisAcara === 'dalam_talian' ? $this->faker->boolean(60) : false,
            'bilangan_check_in_rawak' => $this->faker->numberBetween(2, 3),
            'ambang_kehadiran_sebahagian' => $this->faker->randomFloat(2, 70.00, 80.00),
            'pautan_meeting_url' => $jenisAcara !== 'fizikal' ? $this->faker->randomElement([
                'https://zoom.us/j/' . $this->faker->numerify('###########'),
                'https://teams.microsoft.com/l/meetup-join/' . $this->faker->uuid(),
            ]) : null,
            'adalah_berbilang_hari' => $this->faker->boolean(40),
            'ambang_sijil_peratus' => $this->faker->randomFloat(2, 75.00, 85.00),
            'kategori_jam_latihan' => $this->faker->randomElement(['kursus_wajib', 'kursus_sukarela', 'mesyuarat', 'bengkel', 'seminar', 'latihan_khusus']),
            'adalah_siri' => $this->faker->boolean(20),
            'id_acara_induk_siri' => null, // Can be set for recurring events
        ];
    }
}
