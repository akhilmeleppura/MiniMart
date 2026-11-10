<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

// Route::get('/da', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('old.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('switch-language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        Session::put('locale', $locale);
    }
    return Redirect::back();
})->name('switch.language');

// One-click setup/seed route for showcase demos
Route::get('/setup-showcase', function () {
    try {
        // Run standard migrations safely
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        } catch (\Throwable $e) {}

        // Direct DB alter safety check: ensure is_super_admin column exists
        try {
            $hasColumn = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM `users` LIKE 'is_super_admin'");
            if (empty($hasColumn)) {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE `users` ADD COLUMN `is_super_admin` TINYINT(1) DEFAULT 0 AFTER `email`");
            }
        } catch (\Throwable $e) {}

        // Ensure category_products table exists (fixes dashboard category widget query)
        try {
            $hasCatProd = \Illuminate\Support\Facades\DB::select("SHOW TABLES LIKE 'category_products'");
            if (empty($hasCatProd)) {
                \Illuminate\Support\Facades\DB::statement("
                    CREATE TABLE IF NOT EXISTS `category_products` (
                        `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                        `category_id` bigint unsigned DEFAULT NULL,
                        `product_id` bigint unsigned DEFAULT NULL,
                        `created_at` timestamp NULL DEFAULT NULL,
                        `updated_at` timestamp NULL DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        KEY `category_products_category_id_foreign` (`category_id`),
                        KEY `category_products_product_id_foreign` (`product_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
                ");
            }
        } catch (\Throwable $e) {}

        // Run migrations for all modules directly using absolute path to guarantee execution
        $modules = [
            'StoreManagement',
            'Category',
            'Products',
            'Customer',
            'OrderManagement',
            'CMS',
            'TaxManagement',
            'ShippingMethode',
            'PaymentManagement',
            'PaymentMethod',
            'PriceRuleManagement',
            'ProductAttributes',
            'Cart',
            'UserPermission',
            'WebConfigurationManagement',
            'URLRewrite',
            'NewsLetter',
            'Dashboard',
            'Base',
            'Api',
        ];

        $migrationLogs = [];
        foreach ($modules as $mod) {
            $absPath = base_path("Modules/{$mod}/database/migrations");
            if (is_dir($absPath)) {
                try {
                    \Illuminate\Support\Facades\Artisan::call('migrate', [
                        '--path' => "Modules/{$mod}/database/migrations",
                        '--realpath' => true,
                        '--force' => true
                    ]);
                    $migrationLogs[$mod] = 'migrated';
                } catch (\Throwable $e) {
                    $migrationLogs[$mod] = 'error: ' . $e->getMessage();
                }
            }
        }

        \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
        
        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Supreme Admin',
                'is_super_admin' => 1,
                'password' => \Illuminate\Support\Facades\Hash::make('Admin@123'),
                'email_verified_at' => now(),
            ]
        );

        $manager = \App\Models\User::updateOrCreate(
            ['email' => 'manager@gmail.com'],
            [
                'name' => 'Store Manager',
                'is_super_admin' => 0,
                'password' => \Illuminate\Support\Facades\Hash::make('Manager@123'),
                'email_verified_at' => now(),
            ]
        );

        // Test dashboard queries
        $dashboardErrors = [];
        try { \Modules\Customer\Models\Customer::count(); } catch (\Throwable $e) { $dashboardErrors['Customer'] = $e->getMessage(); }
        try { \Modules\Products\Models\Product::count(); } catch (\Throwable $e) { $dashboardErrors['Product'] = $e->getMessage(); }
        try { \Modules\OrderManagement\Models\Order::count(); } catch (\Throwable $e) { $dashboardErrors['Order'] = $e->getMessage(); }
        try {
            \Illuminate\Support\Facades\DB::table('category_products')
                ->join('categories', 'categories.id', '=', 'category_products.category_id')
                ->whereNull('categories.parent_id')
                ->select('categories.name as category', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
                ->groupBy('categories.name')->get();
        } catch (\Throwable $e) { $dashboardErrors['categories'] = $e->getMessage(); }

        // Test login simulation
        $loginAttempt = false;
        $loginError = null;
        try {
            $loginAttempt = \Illuminate\Support\Facades\Auth::attempt(['email' => 'admin@gmail.com', 'password' => 'Admin@123']);
        } catch (\Throwable $e) {
            $loginError = $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
        }

        // Test dashboard view render
        $viewError = null;
        $viewTrace = null;
        try {
            $controller = new \Modules\Dashboard\Http\Controllers\DashboardController();
            $view = $controller->index();
            $rendered = $view->render();
        } catch (\Throwable $e) {
            $viewError = $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
            $viewTrace = explode("\n", $e->getTraceAsString());
        }

        $finderHints = [];
        try {
            $finderHints = array_keys(app('view')->getFinder()->getHints());
        } catch (\Throwable $e) {}

        return response()->json([
            'status' => 'success',
            'git_commit' => trim(shell_exec('git log -1 --format=%h') ?? 'unknown'),
            'counts' => [
                'users' => \App\Models\User::count(),
                'customers' => \Illuminate\Support\Facades\Schema::hasTable('customers') ? DB::table('customers')->count() : 0,
                'products' => \Illuminate\Support\Facades\Schema::hasTable('products') ? DB::table('products')->count() : 0,
                'categories' => \Illuminate\Support\Facades\Schema::hasTable('categories') ? DB::table('categories')->count() : 0,
                'orders' => \Illuminate\Support\Facades\Schema::hasTable('orders') ? DB::table('orders')->count() : 0,
                'permissions' => \Illuminate\Support\Facades\Schema::hasTable('permissions') ? DB::table('permissions')->count() : 0,
                'roles' => \Illuminate\Support\Facades\Schema::hasTable('roles') ? DB::table('roles')->count() : 0,
                'stores' => \Illuminate\Support\Facades\Schema::hasTable('stores') ? DB::table('stores')->count() : 0,
            ],
            'login_attempt' => $loginAttempt,
            'login_error' => $loginError,
            'dashboard_view_error' => $viewError,
            'dashboard_queries' => empty($dashboardErrors) ? 'All passed' : $dashboardErrors,
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'error' => $e->getMessage(),
            'trace' => $e->getFile() . ':' . $e->getLine()
        ], 500);
    }
});

require __DIR__.'/auth.php';
