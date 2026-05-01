<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * Seeders are called in dependency order:
     * 1. Jabatan (no dependencies)
     * 2. Kebenaran (no dependencies)
     * 3. Peranan + Peranan_Kebenaran (depends on Kebenaran)
     */
    public function run(): void
    {
        $this->command->info('Starting e-DAFTAR Kedah database seeding...');
        $this->command->newLine();

        // Seed departments first (no dependencies)
        $this->command->info('=== Seeding Departments ===');
        $this->call(JabatanSeeder::class);
        $this->command->newLine();

        // Seed permissions (no dependencies)
        $this->command->info('=== Seeding Permissions ===');
        $this->call(KebenaranSeeder::class);
        $this->command->newLine();

        // Seed roles and role-permission mappings (depends on permissions)
        $this->command->info('=== Seeding Roles & Role-Permission Mappings ===');
        $this->call(PerananSeeder::class);
        $this->command->newLine();

        $this->command->info('✓ Database seeding completed successfully!');
        $this->command->newLine();
        $this->command->info('Summary:');
        $this->command->info('- Departments: 14 (1 parent + 13 child departments)');
        $this->command->info('- Permissions: 73 permissions across 10 modules');
        $this->command->info('- Roles: 9 default roles with hierarchy levels');
        $this->command->info('- Role-Permission mappings created for all roles');
    }
}
