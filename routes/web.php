<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// ===== PUBLIC ROUTES =====
Route::get('/', [JadwalController::class, 'home'])->name('home');
Route::get('/dosen/{id}', [JadwalController::class, 'show'])->name('dosen.show');
Route::post('/dosen/{id}/booking', [JadwalController::class, 'storeBooking'])->name('booking.store');
Route::get('/api/jadwal/{dosenId}', [JadwalController::class, 'getJadwalByDay'])->name('jadwal.getByDay');
Route::get('/api/status/{dosenId}', [JadwalController::class, 'getStatus'])->name('status.get');

// ===== AUTH REQUIRED ROUTES =====
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== ADMIN ROUTES =====
    Route::prefix('/admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/dosen/create', [AdminController::class, 'createDosen'])->name('dosen.create');
        Route::post('/dosen', [AdminController::class, 'storeDosen'])->name('dosen.store');
        Route::get('/dosen/{id}/edit', [AdminController::class, 'editDosen'])->name('dosen.edit');
        Route::put('/dosen/{id}', [AdminController::class, 'updateDosen'])->name('dosen.update');
        Route::delete('/dosen/{id}', [AdminController::class, 'deleteDosen'])->name('dosen.delete');
    });

    // Dosen Dashboard
    Route::get('/dashboard', [JadwalController::class, 'dashboard'])->name('dashboard');

    // Jadwal Management
    Route::prefix('/jadwal')->name('dosen.jadwal.')->group(function () {
        Route::get('/', [JadwalController::class, 'indexJadwal'])->name('index');
        Route::get('/create', [JadwalController::class, 'createJadwal'])->name('create');
        Route::post('/', [JadwalController::class, 'storeJadwal'])->name('store');
        Route::get('/{id}/edit', [JadwalController::class, 'editJadwal'])->name('edit');
        Route::put('/{id}', [JadwalController::class, 'updateJadwal'])->name('update');
        Route::delete('/{id}', [JadwalController::class, 'destroyJadwal'])->name('destroy');
    });

    // Booking Management
    Route::prefix('/booking')->name('dosen.booking.')->group(function () {
        Route::get('/', [JadwalController::class, 'indexBooking'])->name('index');
        Route::post('/{id}/approve', [JadwalController::class, 'approveBooking'])->name('approve');
        Route::post('/{id}/reject', [JadwalController::class, 'rejectBooking'])->name('reject');
    });

    // Status Update
    Route::post('/api/status/update', [JadwalController::class, 'updateStatus'])->name('status.update');
});

require __DIR__.'/auth.php';