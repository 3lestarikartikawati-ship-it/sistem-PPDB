<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PublicRegistrationController;
use Illuminate\Support\Facades\Route;

// Public Registration
Route::get('/pendaftaran', [PublicRegistrationController::class, 'create'])->name('pendaftaran.public');
Route::post('/pendaftaran', [PublicRegistrationController::class, 'store']);
Route::get('/pendaftaran/sukses', [PublicRegistrationController::class, 'sukses'])->name('pendaftaran.sukses');

// Public Routes
Route::get('/', [PublicController::class, 'index'])->name('beranda');
Route::get('/profil', [PublicController::class, 'profil'])->name('profil');
Route::get('/kegiatan', [PublicController::class, 'kegiatan'])->name('kegiatan');
Route::get('/prestasi', [PublicController::class, 'prestasi'])->name('prestasi');
Route::get('/berita', [PublicController::class, 'berita'])->name('berita');
Route::get('/informasi', [PublicController::class, 'informasi'])->name('informasi');

// Standalone Web Simulator Routes (Gateway Mock Sites)
Route::get('/simulator/bsi', [App\Http\Controllers\PaymentController::class, 'bsiSimulatorPage'])->name('simulator.bsi');
Route::post('/simulator/bsi/bayar', [App\Http\Controllers\PaymentController::class, 'bsiSimulatorProcess'])->name('simulator.bsi.pay');
Route::get('/simulator/qris', [App\Http\Controllers\PaymentController::class, 'qrisSimulatorPage'])->name('simulator.qris');
Route::post('/simulator/qris/bayar', [App\Http\Controllers\PaymentController::class, 'qrisSimulatorProcess'])->name('simulator.qris.pay');
// Midtrans Webhook
Route::post('/api/midtrans/webhook', [App\Http\Controllers\PaymentController::class, 'midtransWebhook'])->name('midtrans.webhook');


// Auth Dashboard Redirect
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif (auth()->user()->role === 'bendahara') {
        return redirect()->route('bendahara.dashboard');
    }
    return redirect()->route('siswa.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Siswa Routes
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/pendaftaran/revisi', [StudentController::class, 'edit'])->name('pendaftaran.edit');
    Route::put('/pendaftaran/revisi', [StudentController::class, 'update'])->name('pendaftaran.update');
    Route::get('/cetak-bukti', [StudentController::class, 'printPdf'])->name('cetak_bukti');
    Route::get('/cetak-skd', [StudentController::class, 'printSkd'])->name('cetak_skd');
    
    // Daftar Ulang (Upload Berkas)
    Route::get('/daftar-ulang', [StudentController::class, 'daftarUlangIndex'])->name('daftar_ulang.index');
    Route::post('/daftar-ulang', [StudentController::class, 'storeDaftarUlang'])->name('daftar_ulang.store');


});

// Bendahara Routes
Route::middleware(['auth', 'role:bendahara'])->prefix('bendahara')->name('bendahara.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\BendaharaController::class, 'dashboard'])->name('dashboard');
    Route::get('/payments', [App\Http\Controllers\BendaharaController::class, 'paymentsIndex'])->name('payments.index');
    Route::get('/payments/export/pdf', [App\Http\Controllers\BendaharaController::class, 'exportPdf'])->name('payments.export.pdf');
    Route::get('/payments/export-belum-lunas', [App\Http\Controllers\BendaharaController::class, 'exportBelumLunasPdf'])->name('payments.export.belum_lunas');
    Route::post('/payments/{student}/store', [App\Http\Controllers\BendaharaController::class, 'storePayment'])->name('payments.store');
    Route::delete('/payments/history/{payment}', [App\Http\Controllers\BendaharaController::class, 'destroyPayment'])->name('payments.destroy');
    Route::get('/settings', [App\Http\Controllers\BendaharaController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\BendaharaController::class, 'updateSettings'])->name('settings.update');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Kelola Pendaftar PPDB (Sistem Lama)
    Route::get('/students', [AdminController::class, 'students'])->name('students.index');
    Route::get('/students/{student}', [AdminController::class, 'showStudent'])->name('students.show');
    Route::post('/students/{student}/verify', [AdminController::class, 'verifyStudent'])->name('students.verify');
    Route::get('/export/students', [AdminController::class, 'exportStudents'])->name('students.export');
    Route::get('/export/students/pdf', [AdminController::class, 'exportPdf'])->name('students.export.pdf');

    // Data Siswa Aktif (Kelas 7, 8, 9)
    Route::get('/active-students', [AdminController::class, 'activeStudents'])->name('active_students.index');
    Route::post('/active-students/store', [AdminController::class, 'storeStudent'])->name('active_students.store');
    Route::post('/active-students/import', [AdminController::class, 'importExcel'])->name('active_students.import');
    Route::delete('/active-students/{student}', [AdminController::class, 'destroyStudent'])->name('active_students.destroy');
    
    // CMS Konten
    Route::resource('contents', App\Http\Controllers\ContentController::class)->except(['show']);

    // Pengaturan Sistem
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/settings/reset', [AdminController::class, 'resetSettings'])->name('settings.reset');

    // FAQ Management
    Route::resource('faqs', FaqController::class)->except(['show']);

    // Pembagian Kelas (Plotting)
    Route::get('/classes', [AdminController::class, 'classesIndex'])->name('classes.index');
    Route::post('/classes/assign', [AdminController::class, 'assignClass'])->name('classes.assign');
    Route::post('/classes/remove', [AdminController::class, 'removeClass'])->name('classes.remove');
    Route::get('/classes/export-pdf/{kelas}', [AdminController::class, 'exportClassPdf'])->name('classes.export.pdf');

    // Admin Messages
    Route::get('/messages', [MessageController::class, 'adminIndex'])->name('messages.index');
    Route::get('/messages/{student}', [MessageController::class, 'adminShow'])->name('messages.show');
    Route::post('/messages/{student}', [MessageController::class, 'adminStore'])->name('messages.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Secure File Access
    Route::get('/secure-file/{path}', [FileController::class, 'show'])->where('path', '.*')->name('secure.file');

    // Student Messages
    Route::get('/siswa/pesan', [MessageController::class, 'studentIndex'])->name('siswa.messages.index');
    Route::post('/siswa/pesan', [MessageController::class, 'studentStore'])->name('siswa.messages.store');
});

// Google OAuth Routes
Route::get('/auth/google/redirect', [App\Http\Controllers\Auth\ProviderController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [App\Http\Controllers\Auth\ProviderController::class, 'callback'])->name('auth.google.callback');

require __DIR__.'/auth.php';
