<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController; // <-- Tambahkan ini
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Depan (Bisa diakses siapa saja)
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::prefix('admin')->middleware('auth')->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Route untuk Kelola Menu (CRUD) <-- TAMBAHKAN INI
        Route::resource('menus', \App\Http\Controllers\MenuController::class);

    });

// Group untuk User yang SUDAH LOGIN
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard User Biasa (Peminjam)
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- AREA KHUSUS ADMIN (Sesuai PDF Point 8) ---
    // Kita kasih prefix 'admin' supaya URL-nya jadi: project-empang.com/admin/dashboard
    Route::prefix('admin')->middleware('auth')->group(function () {

        // Dashboard Admin
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Nanti kita tambah route menu kopi & booking di sini...
    });
});

require __DIR__.'/auth.php';
