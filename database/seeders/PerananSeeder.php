<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PerananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seed the 9 default roles and their permission assignments.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Define the 9 default roles
        $roles = [
            [
                'kod_peranan' => 'super_admin',
                'nama_peranan' => 'Super Admin Negeri',
                'penerangan' => 'Pentadbir tertinggi sistem dengan akses penuh ke semua fungsi dan data di seluruh negeri',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 1,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kod_peranan' => 'admin_negeri',
                'nama_peranan' => 'Pegawai Pentadbir Negeri',
                'penerangan' => 'Pentadbir negeri dengan akses penuh kepada data dan fungsi pentadbiran peringkat negeri',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 2,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kod_peranan' => 'admin_jabatan',
                'nama_peranan' => 'Pentadbir Jabatan',
                'penerangan' => 'Pentadbir jabatan dengan akses penuh kepada data dan fungsi dalam jabatan sendiri',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 3,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kod_peranan' => 'penyelaras',
                'nama_peranan' => 'Penyelaras Latihan',
                'penerangan' => 'Penyelaras acara latihan yang boleh mencipta dan mengurus acara serta peserta',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 4,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kod_peranan' => 'pengerusi_acara',
                'nama_peranan' => 'Pengerusi Acara',
                'penerangan' => 'Pengerusi acara yang bertanggungjawab mempengerusikan dan mengurus acara tertentu',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 5,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kod_peranan' => 'ketua_jabatan',
                'nama_peranan' => 'Ketua Jabatan / Pengarah',
                'penerangan' => 'Ketua jabatan yang boleh melihat laporan dan analitik jabatan',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 6,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kod_peranan' => 'pegawai_penilai',
                'nama_peranan' => 'Pegawai Penilai',
                'penerangan' => 'Pegawai penilai yang boleh melihat dan menilai prestasi latihan',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 7,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kod_peranan' => 'auditor',
                'nama_peranan' => 'Auditor Negeri',
                'penerangan' => 'Auditor dengan akses baca sahaja kepada semua data untuk tujuan audit dan pematuhan',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 8,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'kod_peranan' => 'peserta',
                'nama_peranan' => 'Peserta / Penjawat Awam',
                'penerangan' => 'Peranan lalai untuk semua penjawat awam sebagai peserta acara',
                'adalah_lalai_sistem' => true,
                'boleh_dipadam' => false,
                'tahap_hierarki' => 9,
                'dicipta_oleh' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert roles and get their IDs
        foreach ($roles as $role) {
            DB::table('peranan')->insert($role);
        }

        $this->command->info('Seeded ' . count($roles) . ' roles successfully.');

        // Now assign permissions to roles
        $this->assignPermissionsToRoles();
    }

    /**
     * Assign permissions to each role based on their responsibilities.
     */
    private function assignPermissionsToRoles(): void
    {
        $now = Carbon::now();

        // Get all permissions
        $permissions = DB::table('kebenaran')->get()->keyBy('kod_kebenaran');

        // Get all roles
        $roles = DB::table('peranan')->get()->keyBy('kod_peranan');

        // Define permission assignments for each role
        $rolePermissions = [
            // 1. SUPER ADMIN - Gets ALL permissions
            'super_admin' => $permissions->pluck('id')->all(),

            // 2. ADMIN NEGERI - All except system critical operations
            'admin_negeri' => $permissions->filter(function ($perm) {
                return !in_array($perm->kod_kebenaran, [
                    'system.backup_restore',
                    'system.maintenance_mode',
                ]);
            })->pluck('id')->all(),

            // 3. ADMIN JABATAN - Department-level admin
            'admin_jabatan' => $permissions->filter(function ($perm) {
                return in_array($perm->kod_kebenaran, [
                    // User management (jabatan scope)
                    'user.view_jabatan', 'user.create', 'user.update_jabatan', 'user.activate_deactivate', 'user.sync_epsm',
                    // Event management (full)
                    'event.view_jabatan', 'event.create', 'event.update_jabatan', 'event.delete', 'event.activate',
                    'event.cancel', 'event.manage_participants', 'event.generate_qr',
                    // Session management
                    'session.view', 'session.create', 'session.update', 'session.delete', 'session.generate_qr',
                    // Attendance management
                    'attendance.view_jabatan', 'attendance.manual_checkin', 'attendance.update', 'attendance.delete',
                    // Substitution management
                    'substitution.view_event', 'substitution.approve', 'substitution.reject',
                    // Certificate management
                    'certificate.view_jabatan', 'certificate.generate', 'certificate.regenerate', 'certificate.download',
                    'certificate.verify', 'certificate.revoke',
                    // Reports
                    'report.view_jabatan', 'report.export', 'report.attendance_summary', 'report.training_hours',
                    'report.department_analytics',
                    // Training hours
                    'training_hours.view_jabatan', 'training_hours.adjust', 'training_hours.export_lnpt',
                    // RBAC
                    'rbac.view_roles', 'rbac.assign_role', 'rbac.revoke_role', 'rbac.view_permissions',
                    // System
                    'system.view_settings',
                ]);
            })->pluck('id')->all(),

            // 4. PENYELARAS - Event organizer/coordinator
            'penyelaras' => $permissions->filter(function ($perm) {
                return in_array($perm->kod_kebenaran, [
                    // User - limited
                    'user.view_jabatan', 'user.view_self', 'user.update_self',
                    // Event management (full)
                    'event.view_jabatan', 'event.view_own', 'event.create', 'event.update_own', 'event.activate',
                    'event.cancel', 'event.manage_participants', 'event.generate_qr',
                    // Session management
                    'session.view', 'session.create', 'session.update', 'session.delete', 'session.generate_qr',
                    // Attendance
                    'attendance.view_event', 'attendance.manual_checkin', 'attendance.update',
                    // Substitution
                    'substitution.view_event', 'substitution.approve', 'substitution.reject',
                    // Certificate
                    'certificate.view_jabatan', 'certificate.generate', 'certificate.download', 'certificate.verify',
                    // Reports
                    'report.view_jabatan', 'report.export', 'report.attendance_summary',
                    // Training hours
                    'training_hours.view_jabatan',
                ]);
            })->pluck('id')->all(),

            // 5. PENGERUSI ACARA - Event chair (similar to penyelaras but more limited)
            'pengerusi_acara' => $permissions->filter(function ($perm) {
                return in_array($perm->kod_kebenaran, [
                    // User
                    'user.view_jabatan', 'user.view_self', 'user.update_self',
                    // Event
                    'event.view_jabatan', 'event.view_own', 'event.update_own', 'event.manage_participants', 'event.generate_qr',
                    // Session
                    'session.view', 'session.update',
                    // Attendance
                    'attendance.view_event', 'attendance.manual_checkin',
                    // Substitution
                    'substitution.view_event', 'substitution.approve', 'substitution.reject',
                    // Certificate
                    'certificate.view_jabatan', 'certificate.download', 'certificate.verify',
                    // Reports
                    'report.view_jabatan', 'report.export', 'report.attendance_summary',
                ]);
            })->pluck('id')->all(),

            // 6. KETUA JABATAN - Department head (view and reports focused)
            'ketua_jabatan' => $permissions->filter(function ($perm) {
                return in_array($perm->kod_kebenaran, [
                    // User
                    'user.view_jabatan', 'user.view_self', 'user.update_self',
                    // Event
                    'event.view_jabatan', 'event.view_invited',
                    // Session
                    'session.view',
                    // Attendance
                    'attendance.view_jabatan', 'attendance.view_self', 'attendance.scan_qr',
                    // Substitution
                    'substitution.view_event', 'substitution.request',
                    // Certificate
                    'certificate.view_jabatan', 'certificate.view_self', 'certificate.download', 'certificate.verify',
                    // Reports (full access)
                    'report.view_jabatan', 'report.export', 'report.attendance_summary', 'report.training_hours',
                    'report.department_analytics',
                    // Training hours
                    'training_hours.view_jabatan', 'training_hours.view_self', 'training_hours.export_lnpt',
                ]);
            })->pluck('id')->all(),

            // 7. PEGAWAI PENILAI - Evaluator (view and assessment)
            'pegawai_penilai' => $permissions->filter(function ($perm) {
                return in_array($perm->kod_kebenaran, [
                    // User
                    'user.view_jabatan', 'user.view_self', 'user.update_self',
                    // Event
                    'event.view_jabatan', 'event.view_invited',
                    // Session
                    'session.view',
                    // Attendance
                    'attendance.view_jabatan', 'attendance.view_self', 'attendance.scan_qr',
                    // Certificate
                    'certificate.view_jabatan', 'certificate.view_self', 'certificate.download', 'certificate.verify',
                    // Reports
                    'report.view_jabatan', 'report.export', 'report.attendance_summary', 'report.training_hours',
                    // Training hours
                    'training_hours.view_jabatan', 'training_hours.view_self', 'training_hours.export_lnpt',
                ]);
            })->pluck('id')->all(),

            // 8. AUDITOR - Read-only access to all data
            'auditor' => $permissions->filter(function ($perm) {
                // Only view permissions, no create/update/delete
                return str_contains($perm->kod_kebenaran, 'view') ||
                       str_contains($perm->kod_kebenaran, 'verify') ||
                       $perm->kod_kebenaran === 'system.view_audit_log';
            })->pluck('id')->all(),

            // 9. PESERTA - Default role with minimal permissions
            'peserta' => $permissions->filter(function ($perm) {
                return in_array($perm->kod_kebenaran, [
                    // User - self only
                    'user.view_self', 'user.update_self', 'user.sync_epsm',
                    // Event - invited events only
                    'event.view_invited',
                    // Session
                    'session.view',
                    // Attendance - self only
                    'attendance.view_self', 'attendance.scan_qr', 'attendance.verify_continuous',
                    // Substitution
                    'substitution.request',
                    // Certificate - self only
                    'certificate.view_self', 'certificate.download', 'certificate.verify',
                    // Reports - self only
                    'report.view_self', 'report.export',
                    // Training hours - self only
                    'training_hours.view_self', 'training_hours.export_lnpt',
                ]);
            })->pluck('id')->all(),
        ];

        // Insert role-permission mappings
        $insertData = [];
        foreach ($rolePermissions as $roleCode => $permissionIds) {
            $roleId = $roles[$roleCode]->id;

            foreach ($permissionIds as $permissionId) {
                $insertData[] = [
                    'peranan_id' => $roleId,
                    'kebenaran_id' => $permissionId,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Batch insert for performance
        foreach (array_chunk($insertData, 100) as $chunk) {
            DB::table('peranan_kebenaran')->insert($chunk);
        }

        $this->command->info('Assigned permissions to roles successfully.');
        $this->command->info('Total role-permission mappings: ' . count($insertData));
    }
}
