<?php

namespace Database\Factories;

use App\Models\Jabatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Jabatan>
 */
class JabatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Realistic Kedah government department codes
        $deptPrefixes = ['SUK', 'JKN', 'JPP', 'JKR', 'JPN', 'JPBD', 'PBTK', 'PBTKS', 'MBKS', 'MDAS'];
        $prefix = $this->faker->randomElement($deptPrefixes);
        $suffix = $this->faker->numberBetween(1000, 9999);

        $deptNames = [
            'Pejabat Setiausaha Kerajaan Negeri',
            'Jabatan Kesihatan Negeri',
            'Jabatan Pendidikan Negeri',
            'Jabatan Kerja Raya',
            'Jabatan Pengairan dan Saliran',
            'Jabatan Perancangan Bandar dan Desa',
            'Perbadanan Bukit Kayu Hitam',
            'Pejabat Tanah dan Galian',
            'Majlis Bandaraya Kulim',
            'Majlis Daerah Langkawi'
        ];

        return [
            'kod_jabatan' => $prefix . '-KEDAH-' . $suffix,
            'nama_jabatan' => $this->faker->randomElement($deptNames) . ' ' . $this->faker->city(),
            'ptj_induk' => null, // Can be set via state method for sub-departments
            'alamat' => $this->faker->address() . ', ' . $this->faker->numberBetween(5000, 9999) . ' ' . $this->faker->city() . ', Kedah',
            'logo_url' => null, // Optional: can be set separately
        ];
    }
}
