<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KebenaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seed all system permissions based on ERD.md permission categories.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $permissions = [
            // USER MODULE - User Management Permissions
            [
                'kod_kebenaran' => 'user.view_all',
                'nama_kebenaran' => 'Lihat Semua Pengguna',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh melihat senarai semua pengguna dalam sistem',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'user.view_jabatan',
                'nama_kebenaran' => 'Lihat Pengguna Jabatan',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh melihat pengguna dalam jabatan sendiri sahaja',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'user.view_self',
                'nama_kebenaran' => 'Lihat Profil Sendiri',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh melihat profil sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'user.create',
                'nama_kebenaran' => 'Cipta Pengguna',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh mendaftar pengguna baru',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'user.update_all',
                'nama_kebenaran' => 'Kemaskini Semua Pengguna',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh mengemaskini maklumat mana-mana pengguna',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'user.update_jabatan',
                'nama_kebenaran' => 'Kemaskini Pengguna Jabatan',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh mengemaskini pengguna dalam jabatan sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'user.update_self',
                'nama_kebenaran' => 'Kemaskini Profil Sendiri',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh mengemaskini profil sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'user.delete',
                'nama_kebenaran' => 'Padam Pengguna',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh memadam pengguna dari sistem',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'user.activate_deactivate',
                'nama_kebenaran' => 'Aktif/Nyahaktif Pengguna',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh mengaktifkan atau menyahaktifkan akaun pengguna',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'user.sync_epsm',
                'nama_kebenaran' => 'Segerakkan EPSM',
                'kategori_modul' => 'user',
                'penerangan' => 'Boleh menyegerakkan data pengguna dengan API EPSM',
                'adalah_sensitif' => false,
            ],

            // EVENT MODULE - Event Management Permissions
            [
                'kod_kebenaran' => 'event.view_all',
                'nama_kebenaran' => 'Lihat Semua Acara',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh melihat semua acara dalam sistem',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.view_jabatan',
                'nama_kebenaran' => 'Lihat Acara Jabatan',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh melihat acara jabatan sendiri sahaja',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.view_own',
                'nama_kebenaran' => 'Lihat Acara Sendiri',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh melihat acara yang dicipta sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.view_invited',
                'nama_kebenaran' => 'Lihat Acara Dijemput',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh melihat acara yang dijemput sebagai peserta',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.create',
                'nama_kebenaran' => 'Cipta Acara',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh mencipta acara baharu',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.update_all',
                'nama_kebenaran' => 'Kemaskini Semua Acara',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh mengemaskini mana-mana acara',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'event.update_jabatan',
                'nama_kebenaran' => 'Kemaskini Acara Jabatan',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh mengemaskini acara jabatan sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.update_own',
                'nama_kebenaran' => 'Kemaskini Acara Sendiri',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh mengemaskini acara yang dicipta sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.delete',
                'nama_kebenaran' => 'Padam Acara',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh memadam acara',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'event.activate',
                'nama_kebenaran' => 'Aktifkan Acara',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh mengaktifkan acara dari draf',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.cancel',
                'nama_kebenaran' => 'Batalkan Acara',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh membatalkan acara',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'event.manage_participants',
                'nama_kebenaran' => 'Urus Peserta',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh menambah/mengeluarkan peserta acara',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'event.generate_qr',
                'nama_kebenaran' => 'Jana Kod QR',
                'kategori_modul' => 'event',
                'penerangan' => 'Boleh menjana kod QR untuk acara',
                'adalah_sensitif' => false,
            ],

            // SESSION MODULE - Session Management Permissions
            [
                'kod_kebenaran' => 'session.view',
                'nama_kebenaran' => 'Lihat Sesi',
                'kategori_modul' => 'session',
                'penerangan' => 'Boleh melihat sesi acara',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'session.create',
                'nama_kebenaran' => 'Cipta Sesi',
                'kategori_modul' => 'session',
                'penerangan' => 'Boleh mencipta sesi untuk acara berbilang hari',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'session.update',
                'nama_kebenaran' => 'Kemaskini Sesi',
                'kategori_modul' => 'session',
                'penerangan' => 'Boleh mengemaskini maklumat sesi',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'session.delete',
                'nama_kebenaran' => 'Padam Sesi',
                'kategori_modul' => 'session',
                'penerangan' => 'Boleh memadam sesi',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'session.generate_qr',
                'nama_kebenaran' => 'Jana Kod QR Sesi',
                'kategori_modul' => 'session',
                'penerangan' => 'Boleh menjana kod QR khusus untuk sesi',
                'adalah_sensitif' => false,
            ],

            // ATTENDANCE MODULE - Attendance Management Permissions
            [
                'kod_kebenaran' => 'attendance.view_all',
                'nama_kebenaran' => 'Lihat Semua Kehadiran',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh melihat rekod kehadiran semua pengguna',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'attendance.view_jabatan',
                'nama_kebenaran' => 'Lihat Kehadiran Jabatan',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh melihat kehadiran pengguna dalam jabatan sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'attendance.view_event',
                'nama_kebenaran' => 'Lihat Kehadiran Acara',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh melihat kehadiran untuk acara tertentu',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'attendance.view_self',
                'nama_kebenaran' => 'Lihat Kehadiran Sendiri',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh melihat rekod kehadiran sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'attendance.scan_qr',
                'nama_kebenaran' => 'Imbas Kod QR',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh mengimbas kod QR untuk daftar kehadiran',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'attendance.manual_checkin',
                'nama_kebenaran' => 'Daftar Manual',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh mendaftar kehadiran secara manual untuk peserta',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'attendance.update',
                'nama_kebenaran' => 'Kemaskini Kehadiran',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh mengemaskini rekod kehadiran',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'attendance.delete',
                'nama_kebenaran' => 'Padam Kehadiran',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh memadam rekod kehadiran',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'attendance.verify_continuous',
                'nama_kebenaran' => 'Sahkan Pengesahan Berterusan',
                'kategori_modul' => 'attendance',
                'penerangan' => 'Boleh mengesahkan pengesahan berterusan untuk acara dalam talian',
                'adalah_sensitif' => false,
            ],

            // SUBSTITUTION MODULE - Substitution Management Permissions
            [
                'kod_kebenaran' => 'substitution.view_all',
                'nama_kebenaran' => 'Lihat Semua Gantian',
                'kategori_modul' => 'substitution',
                'penerangan' => 'Boleh melihat semua permohonan gantian',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'substitution.view_event',
                'nama_kebenaran' => 'Lihat Gantian Acara',
                'kategori_modul' => 'substitution',
                'penerangan' => 'Boleh melihat gantian untuk acara tertentu',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'substitution.request',
                'nama_kebenaran' => 'Mohon Gantian',
                'kategori_modul' => 'substitution',
                'penerangan' => 'Boleh membuat permohonan gantian',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'substitution.approve',
                'nama_kebenaran' => 'Lulus Gantian',
                'kategori_modul' => 'substitution',
                'penerangan' => 'Boleh meluluskan permohonan gantian',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'substitution.reject',
                'nama_kebenaran' => 'Tolak Gantian',
                'kategori_modul' => 'substitution',
                'penerangan' => 'Boleh menolak permohonan gantian',
                'adalah_sensitif' => true,
            ],

            // CERTIFICATE MODULE - Certificate Management Permissions
            [
                'kod_kebenaran' => 'certificate.view_all',
                'nama_kebenaran' => 'Lihat Semua Sijil',
                'kategori_modul' => 'certificate',
                'penerangan' => 'Boleh melihat semua sijil dalam sistem',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'certificate.view_jabatan',
                'nama_kebenaran' => 'Lihat Sijil Jabatan',
                'kategori_modul' => 'certificate',
                'penerangan' => 'Boleh melihat sijil dalam jabatan sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'certificate.view_self',
                'nama_kebenaran' => 'Lihat Sijil Sendiri',
                'kategori_modul' => 'certificate',
                'penerangan' => 'Boleh melihat sijil sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'certificate.generate',
                'nama_kebenaran' => 'Jana Sijil',
                'kategori_modul' => 'certificate',
                'penerangan' => 'Boleh menjana sijil kehadiran',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'certificate.regenerate',
                'nama_kebenaran' => 'Jana Semula Sijil',
                'kategori_modul' => 'certificate',
                'penerangan' => 'Boleh menjana semula sijil yang telah sedia ada',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'certificate.download',
                'nama_kebenaran' => 'Muat Turun Sijil',
                'kategori_modul' => 'certificate',
                'penerangan' => 'Boleh memuat turun sijil dalam format PDF',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'certificate.verify',
                'nama_kebenaran' => 'Sahkan Sijil',
                'kategori_modul' => 'certificate',
                'penerangan' => 'Boleh mengesahkan kesahihan sijil',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'certificate.revoke',
                'nama_kebenaran' => 'Batalkan Sijil',
                'kategori_modul' => 'certificate',
                'penerangan' => 'Boleh membatalkan sijil yang telah dikeluarkan',
                'adalah_sensitif' => true,
            ],

            // REPORT MODULE - Report Access Permissions
            [
                'kod_kebenaran' => 'report.view_all',
                'nama_kebenaran' => 'Lihat Semua Laporan',
                'kategori_modul' => 'report',
                'penerangan' => 'Boleh melihat semua jenis laporan',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'report.view_jabatan',
                'nama_kebenaran' => 'Lihat Laporan Jabatan',
                'kategori_modul' => 'report',
                'penerangan' => 'Boleh melihat laporan jabatan sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'report.view_self',
                'nama_kebenaran' => 'Lihat Laporan Sendiri',
                'kategori_modul' => 'report',
                'penerangan' => 'Boleh melihat laporan peribadi',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'report.export',
                'nama_kebenaran' => 'Eksport Laporan',
                'kategori_modul' => 'report',
                'penerangan' => 'Boleh mengeksport laporan ke PDF/Excel',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'report.attendance_summary',
                'nama_kebenaran' => 'Laporan Ringkasan Kehadiran',
                'kategori_modul' => 'report',
                'penerangan' => 'Boleh melihat laporan ringkasan kehadiran',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'report.training_hours',
                'nama_kebenaran' => 'Laporan Jam Latihan',
                'kategori_modul' => 'report',
                'penerangan' => 'Boleh melihat laporan jam latihan tahunan',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'report.department_analytics',
                'nama_kebenaran' => 'Analitik Jabatan',
                'kategori_modul' => 'report',
                'penerangan' => 'Boleh melihat analitik prestasi jabatan',
                'adalah_sensitif' => false,
            ],

            // TRAINING HOURS MODULE - Training Hours Permissions
            [
                'kod_kebenaran' => 'training_hours.view_all',
                'nama_kebenaran' => 'Lihat Semua Jam Latihan',
                'kategori_modul' => 'training_hours',
                'penerangan' => 'Boleh melihat jam latihan semua pengguna',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'training_hours.view_jabatan',
                'nama_kebenaran' => 'Lihat Jam Latihan Jabatan',
                'kategori_modul' => 'training_hours',
                'penerangan' => 'Boleh melihat jam latihan dalam jabatan sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'training_hours.view_self',
                'nama_kebenaran' => 'Lihat Jam Latihan Sendiri',
                'kategori_modul' => 'training_hours',
                'penerangan' => 'Boleh melihat jam latihan sendiri',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'training_hours.adjust',
                'nama_kebenaran' => 'Laras Jam Latihan',
                'kategori_modul' => 'training_hours',
                'penerangan' => 'Boleh melaraskan jam latihan pengguna',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'training_hours.export_lnpt',
                'nama_kebenaran' => 'Eksport LNPT',
                'kategori_modul' => 'training_hours',
                'penerangan' => 'Boleh mengeksport penyata LNPT',
                'adalah_sensitif' => false,
            ],

            // RBAC MODULE - Role & Permission Management Permissions
            [
                'kod_kebenaran' => 'rbac.view_roles',
                'nama_kebenaran' => 'Lihat Peranan',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh melihat senarai peranan',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'rbac.create_role',
                'nama_kebenaran' => 'Cipta Peranan',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh mencipta peranan baru',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'rbac.update_role',
                'nama_kebenaran' => 'Kemaskini Peranan',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh mengemaskini peranan',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'rbac.delete_role',
                'nama_kebenaran' => 'Padam Peranan',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh memadam peranan (kecuali peranan lalai)',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'rbac.assign_role',
                'nama_kebenaran' => 'Lantik Peranan',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh melantik peranan kepada pengguna',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'rbac.revoke_role',
                'nama_kebenaran' => 'Cabut Peranan',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh mencabut peranan pengguna',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'rbac.view_permissions',
                'nama_kebenaran' => 'Lihat Kebenaran',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh melihat senarai kebenaran',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'rbac.manage_permissions',
                'nama_kebenaran' => 'Urus Kebenaran',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh mengurus kebenaran untuk peranan',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'rbac.delegate_role',
                'nama_kebenaran' => 'Delegasi Peranan',
                'kategori_modul' => 'rbac',
                'penerangan' => 'Boleh mendelegasikan peranan secara sementara',
                'adalah_sensitif' => true,
            ],

            // SYSTEM MODULE - System Configuration Permissions
            [
                'kod_kebenaran' => 'system.view_settings',
                'nama_kebenaran' => 'Lihat Tetapan Sistem',
                'kategori_modul' => 'system',
                'penerangan' => 'Boleh melihat tetapan sistem',
                'adalah_sensitif' => false,
            ],
            [
                'kod_kebenaran' => 'system.update_settings',
                'nama_kebenaran' => 'Kemaskini Tetapan Sistem',
                'kategori_modul' => 'system',
                'penerangan' => 'Boleh mengemaskini konfigurasi sistem',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'system.view_audit_log',
                'nama_kebenaran' => 'Lihat Log Audit',
                'kategori_modul' => 'system',
                'penerangan' => 'Boleh melihat log audit sistem',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'system.manage_departments',
                'nama_kebenaran' => 'Urus Jabatan',
                'kategori_modul' => 'system',
                'penerangan' => 'Boleh mengurus jabatan/PTJ',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'system.backup_restore',
                'nama_kebenaran' => 'Backup & Restore',
                'kategori_modul' => 'system',
                'penerangan' => 'Boleh melakukan backup dan restore data',
                'adalah_sensitif' => true,
            ],
            [
                'kod_kebenaran' => 'system.maintenance_mode',
                'nama_kebenaran' => 'Mod Penyelenggaraan',
                'kategori_modul' => 'system',
                'penerangan' => 'Boleh mengaktifkan/menyahaktifkan mod penyelenggaraan',
                'adalah_sensitif' => true,
            ],
        ];

        DB::table('kebenaran')->insert($permissions);

        $this->command->info('Seeded ' . count($permissions) . ' permissions successfully.');
    }
}
