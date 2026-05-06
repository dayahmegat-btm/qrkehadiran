<?php

namespace Database\Factories;

use App\Models\Kebenaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kebenaran>
 */
class KebenaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Sample permissions across different modules
        $permissions = [
            ['kod' => 'user.create', 'nama' => 'Cipta Pengguna', 'modul' => 'user', 'sensitif' => false],
            ['kod' => 'user.update', 'nama' => 'Kemaskini Pengguna', 'modul' => 'user', 'sensitif' => false],
            ['kod' => 'user.delete', 'nama' => 'Padam Pengguna', 'modul' => 'user', 'sensitif' => true],
            ['kod' => 'event.create', 'nama' => 'Cipta Acara', 'modul' => 'event', 'sensitif' => false],
            ['kod' => 'event.update', 'nama' => 'Kemaskini Acara', 'modul' => 'event', 'sensitif' => false],
            ['kod' => 'event.delete', 'nama' => 'Padam Acara', 'modul' => 'event', 'sensitif' => true],
            ['kod' => 'event.view_all', 'nama' => 'Lihat Semua Acara', 'modul' => 'event', 'sensitif' => false],
            ['kod' => 'attendance.mark', 'nama' => 'Tandakan Kehadiran', 'modul' => 'attendance', 'sensitif' => false],
            ['kod' => 'attendance.view', 'nama' => 'Lihat Kehadiran', 'modul' => 'attendance', 'sensitif' => false],
            ['kod' => 'certificate.generate', 'nama' => 'Jana Sijil', 'modul' => 'certificate', 'sensitif' => false],
            ['kod' => 'certificate.revoke', 'nama' => 'Batalkan Sijil', 'modul' => 'certificate', 'sensitif' => true],
            ['kod' => 'report.view', 'nama' => 'Lihat Laporan', 'modul' => 'report', 'sensitif' => false],
            ['kod' => 'rbac.assign_role', 'nama' => 'Berikan Peranan', 'modul' => 'rbac', 'sensitif' => true],
            ['kod' => 'system.configure', 'nama' => 'Konfigurasi Sistem', 'modul' => 'system', 'sensitif' => true],
        ];

        $permission = $this->faker->randomElement($permissions);

        return [
            'kod_kebenaran' => $permission['kod'],
            'nama_kebenaran' => $permission['nama'],
            'kategori_modul' => $permission['modul'],
            'penerangan' => 'Kebenaran untuk ' . strtolower($permission['nama']),
            'adalah_sensitif' => $permission['sensitif'],
        ];
    }
}
