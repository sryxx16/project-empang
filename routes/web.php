<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;
use App\Models\Setting;
use App\Models\Gallery;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HALAMAN DEPAN (PUBLIC) ---
Route::get('/', function () {
    // Ambil Data dari Database (Profil & Galeri)
    $settings = Setting::all()->pluck('value', 'key');
    $galleries = Gallery::latest()->take(4)->get();

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'landingData' => [
            'jam_buka' => $settings['jam_buka'] ?? '-',
            'harga_tiket' => $settings['harga_tiket'] ?? '0',
            'about_us' => $settings['about_us'] ?? 'Belum ada deskripsi.',
            'galleries' => $galleries
        ]
    ]);
});
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// --- DASHBOARD USER (PEMANCING) ---
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// --- PROFILE USER ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- AREA KHUSUS ADMIN (JURAGAN) ---
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {

    // 1. Dashboard Utama
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // 2. Kelola Menu Minuman (CRUD)
    Route::resource('menus', MenuController::class);

    // 3. Kasir / POS
    Route::get('/pos', [PosController::class, 'index'])->name('admin.pos');
    Route::post('/pos', [PosController::class, 'store'])->name('admin.pos.store');

    // 4. Laporan Harian & Kocokan (Nanti kita buat Controllernya)
    Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports');
    Route::post('/reports/{id}/update', [ReportController::class, 'updateLapak'])->name('admin.reports.update');
    // Route::get('/daily-report', [AdminController::class, 'dailyReport'])->name('admin.daily');
});

require __DIR__.'/auth.php';
