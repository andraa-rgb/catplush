<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminExamController;
use App\Http\Controllers\SuperAdminController; // (Opsional: Jika nanti buat controller user)

Route::get('/', function () {
    return view('welcome');
});

/// ... Routes Profile ...

// ----------------------------------------------------------------------
// 1. FITUR MENGERJAKAN UJIAN (BISA UNTUK SEMUA ROLE)
// ----------------------------------------------------------------------
// Pindahkan route ini KELUAR dari middleware role:student
// Taruh di dalam group middleware(['auth', 'verified']) biasa

Route::get('/dashboard', [ExamController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route Ujian (Start, Show, Finish, Result)
// Sekarang Admin/Super Admin juga bisa akses URL ini tanpa error 403
Route::post('/exams/{id}/start', [ExamController::class, 'startExam'])->name('exams.start');
Route::get('/exams/session/{session}', [ExamController::class, 'showQuestion'])->name('exams.show');
Route::post('/exams/answer', [ExamController::class, 'storeAnswer'])->name('exams.store_answer');
Route::post('/exams/finish/{session}', [ExamController::class, 'finishExam'])->name('exams.finish');
Route::get('/exams/result/{session}', [ExamController::class, 'result'])->name('exams.result');
Route::get('/history', [ExamController::class, 'history'])->name('exams.history');

// ----------------------------------------------------------------------
// 2. AREA ADMIN OPERASIONAL (Admin Ujian & Super Admin)
// ----------------------------------------------------------------------
// Role 'admin' DAN 'super_admin' boleh akses ini (Manajemen Soal)
Route::middleware(['auth', 'verified', 'role:super_admin,admin'])->prefix('admin')->group(function () {
    
    // Dashboard Admin
    Route::get('/exams', [AdminExamController::class, 'index'])->name('admin.exams.index');
    
    // Manajemen Ujian
    Route::get('/exams/create', [AdminExamController::class, 'create'])->name('admin.exams.create');
    Route::post('/exams', [AdminExamController::class, 'store'])->name('admin.exams.store');
    Route::get('/exams/{id}', [AdminExamController::class, 'show'])->name('admin.exams.show');
    Route::delete('/exams/{id}', [AdminExamController::class, 'destroy'])->name('admin.exams.destroy');
    
    // Manajemen Soal
    Route::post('/exams/{id}/questions', [AdminExamController::class, 'storeQuestion'])->name('admin.exams.questions.store');
    Route::delete('/questions/{id}', [AdminExamController::class, 'destroyQuestion'])->name('admin.exams.questions.destroy');
    Route::get('/questions/{id}/edit', [AdminExamController::class, 'editQuestion'])->name('admin.questions.edit');
    Route::put('/questions/{id}', [AdminExamController::class, 'updateQuestion'])->name('admin.questions.update');

    // Fitur Tambahan (Reset, Import, AI)
    Route::delete('/sessions/{id}/reset', [AdminExamController::class, 'resetSession'])->name('admin.sessions.reset');
    Route::post('/exams/{id}/import', [AdminExamController::class, 'importQuestions'])->name('admin.exams.import');
    Route::post('/exams/{id}/generate', [AdminExamController::class, 'generateQuestions'])->name('admin.exams.generate');
    // TAMBAHKAN INI: Route Edit & Update Ujian
    Route::get('/exams/{id}/edit', [AdminExamController::class, 'edit'])->name('admin.exams.edit');
    Route::put('/exams/{id}', [AdminExamController::class, 'update'])->name('admin.exams.update');

});

// ----------------------------------------------------------------------
// 3. AREA KHUSUS SUPER ADMIN
// ----------------------------------------------------------------------
// Hanya 'super_admin' yang boleh masuk. (Misal: Manajemen User Admin Lain)
Route::middleware(['auth', 'verified', 'role:super_admin'])->prefix('super')->name('super.')->group(function() {
    
    // Resource route otomatis membuat url index, create, store, edit, update, destroy
    Route::resource('users', SuperAdminController::class);
});

require __DIR__.'/auth.php';