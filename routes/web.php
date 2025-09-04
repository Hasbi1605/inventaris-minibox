<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelolaLayananController;
use App\Http\Controllers\KelolaTransaksiController;
use App\Http\Controllers\KelolaPengeluaranController;
use App\Http\Controllers\KelolaInventarisController;
use App\Http\Controllers\KelolaCabangController;
use App\Http\Controllers\LaporanController;

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/kelola-layanan', [KelolaLayananController::class, 'index'])->name('kelola-layanan');
Route::get('/kelola-transaksi', [KelolaTransaksiController::class, 'index'])->name('kelola-transaksi');
Route::get('/kelola-pengeluaran', [KelolaPengeluaranController::class, 'index'])->name('kelola-pengeluaran');
Route::get('/kelola-inventaris', [KelolaInventarisController::class, 'index'])->name('kelola-inventaris');
Route::get('/kelola-cabang', [KelolaCabangController::class, 'index'])->name('kelola-cabang');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

// Auth routes placeholder
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
