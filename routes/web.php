<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KaryawanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'karyawan') {
        return redirect()->route('karyawan.dashboard');
    }

    return abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    // ADMIN IT ROUTES
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/tambah-perangkat', [AdminController::class, 'perangkat'])->name('perangkat');
        Route::post('/tambah-perangkat', [AdminController::class, 'storePerangkat'])->name('perangkat.store');
        Route::get('/perangkat/{id}/edit', [AdminController::class, 'editPerangkat'])->name('perangkat.edit');
        Route::put('/perangkat/{id}', [AdminController::class, 'updatePerangkat'])->name('perangkat.update');
        Route::delete('/perangkat/{id}', [AdminController::class, 'destroyPerangkat'])->name('perangkat.destroy');
        Route::get('/verifikasi-pengajuan', [AdminController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/verifikasi/{id}/approve', [AdminController::class, 'approve'])->name('verifikasi.approve');
        Route::post('/verifikasi/{id}/reject', [AdminController::class, 'reject'])->name('verifikasi.reject');
        Route::get('/verifikasi/{id}/pdf', [AdminController::class, 'downloadPdf'])->name('verifikasi.pdf');        
        Route::get('/proses-pengembalian', [AdminController::class, 'pengembalian'])->name('pengembalian');
        Route::post('/proses-pengembalian/{id}', [AdminController::class, 'prosesPengembalian'])->name('pengembalian.proses');        
        Route::get('/rekap-laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::get('/pengaturan', [ProfileController::class, 'edit'])->name('pengaturan');
        Route::patch('/pengaturan', [ProfileController::class, 'update'])->name('pengaturan.update');
        Route::get('/laporan/export/excel', [AdminController::class, 'exportExcel'])->name('laporan.export.excel');
        Route::get('/laporan/export/pdf', [AdminController::class, 'exportPdf'])->name('laporan.export.pdf');
    });

    // KARYAWAN ROUTES
    Route::middleware(['role:karyawan'])->prefix('karyawan')->name('karyawan.')->group(function () {
        Route::get('/dashboard', [KaryawanController::class, 'dashboard'])->name('dashboard');
        Route::get('/peminjaman', [KaryawanController::class, 'peminjaman'])->name('peminjaman');
        Route::get('/peminjaman/tambah', [KaryawanController::class, 'createPeminjaman'])->name('peminjaman.create');
        Route::post('/peminjaman/tambah', [KaryawanController::class, 'storePeminjaman'])->name('peminjaman.store');
        Route::get('/pengembalian', [KaryawanController::class, 'pengembalian'])->name('pengembalian');
        Route::post('/pengembalian/{id}', [KaryawanController::class, 'submitPengembalian'])->name('pengembalian.submit');
        Route::get('/pengembalian/pdf', [KaryawanController::class, 'cetakPdfPengembalian'])->name('pengembalian.pdf');        
        Route::get('/riwayat', [KaryawanController::class, 'riwayat'])->name('riwayat');
        Route::get('/pengaturan', [ProfileController::class, 'edit'])->name('pengaturan');
        Route::patch('/pengaturan', [ProfileController::class, 'update'])->name('pengaturan.update');
        Route::get('/riwayat/export/pdf', [KaryawanController::class, 'exportRiwayatPdf'])->name('export.pdf');
    });
});

require __DIR__.'/auth.php';
