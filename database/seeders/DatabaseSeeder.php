<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Super Admin (Full access to all modules, settings & permissions)
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Supreme Admin',
                'is_super_admin' => 1,
                'password' => Hash::make('Admin@123'),
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('Supreme Admin ready: admin@gmail.com / Admin@123');

        // 2. Medium Role: Store Manager (Restricted/Operational access)
        $manager = User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Store Manager',
                'is_super_admin' => 0,
                'password' => Hash::make('Manager@123'),
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('Medium Role ready: manager@gmail.com / Manager@123');

        // Setup Roles and Permissions if spatie package tables exist
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
                $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
                $managerRole = \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Store Manager', 'guard_name' => 'web']);

                // Assign roles
                if (method_exists($superAdmin, 'assignRole')) {
                    $superAdmin->syncRoles([$superAdminRole]);
                    $manager->syncRoles([$managerRole]);
                }
            }
        } catch (\Throwable $e) {
            $this->command->warn('Role assignment skipped: ' . $e->getMessage());
        }

        // 3. Complete Showcase Demo Data (Permissions, Categories, Products, Customers, Orders, Banners, Stores)
        try {
            $this->call(ShowcaseDemoSeeder::class);
        } catch (\Throwable $e) {
            $this->command->warn('ShowcaseDemoSeeder notice: ' . $e->getMessage());
        }
    }
}
