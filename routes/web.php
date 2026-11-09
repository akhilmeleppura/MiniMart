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
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        \Illuminate\Support\Facades\Artisan::call('module:migrate', ['--force' => true]);

        // Safety check: ensure is_super_admin column exists
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'is_super_admin')) {
            \Illuminate\Support\Facades\Schema::table('users', function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->boolean('is_super_admin')->default(false)->after('email');
            });
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

        return response()->json([
            'status' => 'success',
            'message' => 'Showcase database migrated & seeded successfully!',
            'supreme_admin' => [
                'email' => 'admin@gmail.com',
                'password' => 'Admin@123',
                'is_super_admin' => $admin->is_super_admin,
            ],
            'medium_role' => [
                'email' => 'manager@gmail.com',
                'password' => 'Manager@123',
                'is_super_admin' => $manager->is_super_admin,
            ],
            'login_url' => url('/login')
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
