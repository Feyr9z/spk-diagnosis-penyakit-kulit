<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\NilaiKecocokanController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'role:super_admin,admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');

    Route::resource('gejala', GejalaController::class)->except(['show']);
    Route::resource('penyakit', PenyakitController::class)->except(['show']);
    Route::post('nilai-kecocokan/matrix', [NilaiKecocokanController::class, 'updateMatrix'])->name('nilai-kecocokan.matrix');
    Route::resource('nilai-kecocokan', NilaiKecocokanController::class)->except(['show']);

    Route::get('/diagnosis', [DiagnosisController::class, 'index'])->name('diagnosis.index');
    Route::get('/diagnosis/create', [DiagnosisController::class, 'create'])->name('diagnosis.create');
    Route::post('/diagnosis', [DiagnosisController::class, 'store'])->name('diagnosis.store');
    Route::get('/diagnosis/{diagnosis}', [DiagnosisController::class, 'show'])->name('diagnosis.show');

    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{diagnosis}', [RiwayatController::class, 'show'])->name('riwayat.show');
    Route::delete('/riwayat/{diagnosis}', [RiwayatController::class, 'destroy'])->name('riwayat.destroy');
});

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
