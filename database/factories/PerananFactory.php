<?php

namespace Database\Factories;

use App\Models\Peranan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peranan>
 */
class PerananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Default system roles as per ERD
        $roles = [
            ['kod' => 'super_admin', 'nama' => 'Super Admin Negeri', 'hierarki' => 1],
            ['kod' => 'admin_negeri', 'nama' => 'Pegawai Pentadbir Negeri', 'hierarki' => 2],
            ['kod' => 'admin_jabatan', 'nama' => 'Pentadbir Jabatan', 'hierarki' => 3],
            ['kod' => 'penyelaras', 'nama' => 'Penyelaras Latihan', 'hierarki' => 4],
            ['kod' => 'pengerusi_acara', 'nama' => 'Pengerusi Acara', 'hierarki' => 5],
            ['kod' => 'ketua_jabatan', 'nama' => 'Ketua Jabatan / Pengarah', 'hierarki' => 6],
            ['kod' => 'pegawai_penilai', 'nama' => 'Pegawai Penilai', 'hierarki' => 7],
            ['kod' => 'auditor', 'nama' => 'Auditor Negeri', 'hierarki' => 8],
            ['kod' => 'peserta', 'nama' => 'Peserta / Penjawat Awam', 'hierarki' => 9],
        ];

        $role = $this->faker->randomElement($roles);

        return [
            'kod_peranan' => $role['kod'],
            'nama_peranan' => $role['nama'],
            'penerangan' => 'Peranan ' . $role['nama'] . ' untuk sistem e-DAFTAR Kedah',
            'adalah_lalai_sistem' => true, // Default system roles
            'boleh_dipadam' => false, // System roles cannot be deleted
            'tahap_hierarki' => $role['hierarki'],
            'dicipta_oleh' => null, // System-created
        ];
    }
}
