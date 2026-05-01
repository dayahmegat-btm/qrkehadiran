<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seed sample departments for Kedah state government.
     */
    public function run(): void
    {
        // First, insert the parent department (Pejabat SUK Kedah)
        $sukId = DB::table('jabatan')->insertGetId([
            'kod_jabatan' => 'SUK-KEDAH',
            'nama_jabatan' => 'Pejabat Setiausaha Kerajaan Negeri Kedah',
            'ptj_induk' => null,
            'alamat' => 'Aras 1-6, Wisma Darul Aman, Kompleks Darul Aman, 05503 Alor Setar, Kedah Darul Aman',
            'logo_url' => null,
        ]);

        // Now insert child departments under SUK Kedah
        $departments = [
            [
                'kod_jabatan' => 'JKN-KEDAH',
                'nama_jabatan' => 'Jabatan Kesihatan Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Simpang Kuala, 05400 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JPP-KEDAH',
                'nama_jabatan' => 'Jabatan Pengairan dan Saliran Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Jalan Sultan Badlishah, 05000 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JKR-KEDAH',
                'nama_jabatan' => 'Jabatan Kerja Raya Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Jalan Raja, 05000 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JPJ-KEDAH',
                'nama_jabatan' => 'Jabatan Pengangkutan Jalan Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Kompleks JPJ, Jalan Kuala Kedah, 06600 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JPBD-KEDAH',
                'nama_jabatan' => 'Jabatan Perancangan Bandar dan Desa Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Wisma Darul Aman, Kompleks Darul Aman, 05503 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JPAN-KEDAH',
                'nama_jabatan' => 'Jabatan Pertanian Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Kompleks Pertanian, Jalan Teluk Wan Jah, 06000 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JPNIN-KEDAH',
                'nama_jabatan' => 'Jabatan Perikanan Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Kompleks Tun Abdul Razak, 05000 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JHUTAN-KEDAH',
                'nama_jabatan' => 'Jabatan Hutan Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Wisma Sumber Asli, Kompleks Darul Aman, 05503 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JPN-KEDAH',
                'nama_jabatan' => 'Jabatan Pelajaran Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Kompleks Darul Aman, 05503 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'JTMK-KEDAH',
                'nama_jabatan' => 'Jabatan Tenaga Manusia Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Tingkat 3, Wisma Persekutuan, Jalan Kampung Baru, 05000 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'BAITULMAL-KEDAH',
                'nama_jabatan' => 'Baitul Mal Negeri Kedah',
                'ptj_induk' => $sukId,
                'alamat' => 'Jalan Teluk Wan Jah, 05000 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'PBT-AS',
                'nama_jabatan' => 'Majlis Bandaraya Alor Setar',
                'ptj_induk' => $sukId,
                'alamat' => 'Jalan Rajawali, 05350 Alor Setar, Kedah',
                'logo_url' => null,
            ],
            [
                'kod_jabatan' => 'PKN-DIGITAL',
                'nama_jabatan' => 'Unit Digital Pejabat Setiausaha Kerajaan Negeri',
                'ptj_induk' => $sukId,
                'alamat' => 'Wisma Darul Aman, Kompleks Darul Aman, 05503 Alor Setar, Kedah',
                'logo_url' => null,
            ],
        ];

        DB::table('jabatan')->insert($departments);

        $this->command->info('Seeded ' . (count($departments) + 1) . ' departments successfully.');
        $this->command->info('Parent: Pejabat SUK Kedah');
        $this->command->info('Child departments: ' . count($departments));
    }
}
