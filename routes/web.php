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
        // Run standard migrations
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);

        // Direct DB alter safety check: ensure is_super_admin column exists
        try {
            $hasColumn = \Illuminate\Support\Facades\DB::select("SHOW COLUMNS FROM `users` LIKE 'is_super_admin'");
            if (empty($hasColumn)) {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE `users` ADD COLUMN `is_super_admin` TINYINT(1) DEFAULT 0 AFTER `email`");
            }
        } catch (\Throwable $e) {}

        // Run module migrations across each active module without interactive prompts
        try {
            $modules = \Nwidart\Modules\Facades\Module::allEnabled();
            foreach ($modules as $module) {
                \Illuminate\Support\Facades\Artisan::call('module:migrate', [
                    'module' => $module->getName(),
                    '--force' => true
                ]);
            }
        } catch (\Throwable $e) {}

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
        try {
            $controller = new \Modules\Dashboard\Http\Controllers\DashboardController();
            $view = $controller->index();
            $rendered = $view->render();
        } catch (\Throwable $e) {
            $viewError = $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
        }

        return response()->json([
            'status' => 'success',
            'login_attempt' => $loginAttempt,
            'login_error' => $loginError,
            'dashboard_view_error' => $viewError,
            'session_driver' => config('session.driver'),
            'session_table_exists' => \Illuminate\Support\Facades\Schema::hasTable('sessions'),
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
