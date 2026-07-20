<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\NilaiKecocokanController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        // 'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class);
    Route::resource('gejala', GejalaController::class)->except(['show']);
    Route::resource('penyakit', PenyakitController::class)->except(['show']);
    Route::resource('nilai-kecocokan', NilaiKecocokanController::class)->except(['show']);

    Route::get('/diagnosis', [DiagnosisController::class, 'index'])->name('diagnosis.index');
    Route::get('/diagnosis/create', [DiagnosisController::class, 'create'])->name('diagnosis.create');
    Route::post('/diagnosis', [DiagnosisController::class, 'store'])->name('diagnosis.store');
    Route::get('/diagnosis/{diagnosis}', [DiagnosisController::class, 'show'])->name('diagnosis.show');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{diagnosis}', [RiwayatController::class, 'show'])->name('riwayat.show');
    Route::delete('/riwayat/{diagnosis}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
});

require __DIR__.'/auth.php';
