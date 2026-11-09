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
        // 1. Create the admin user if not exists
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'is_super_admin' => 1,
                'password' => Hash::make('Admin@123'),
            ]);
            $this->command->info('Admin user created successfully.');
        }

        // 2. Run Module Seeders for showcase display if tables are empty
        $seeders = [
            \Modules\CMS\Database\Seeders\LanguageTableSeeder::class,
            \Modules\Products\Database\Seeders\ProductTypeSeeder::class,
            \Modules\StoreManagement\Database\Seeders\StoresTableSeeder::class,
            \Modules\OrderManagement\Database\Seeders\OrderStatusSeeder::class,
            \Modules\OrderManagement\Database\Seeders\PaymentStatusSeeder::class,
            \Modules\Customer\Database\Seeders\CustomerGroupSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            if (class_exists($seeder)) {
                try {
                    $this->call($seeder);
                } catch (\Throwable $e) {
                    $this->command->warn("Notice: Seeder {$seeder} skipped: " . $e->getMessage());
                }
            }
        }
    }
}
