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

// Kelola Layanan Routes
Route::resource('kelola-layanan', KelolaLayananController::class);

// Kelola Transaksi Routes
Route::resource('kelola-transaksi', KelolaTransaksiController::class);

// Kelola Pengeluaran Routes
Route::resource('kelola-pengeluaran', KelolaPengeluaranController::class);

// Kelola Inventaris Routes
Route::resource('kelola-inventaris', KelolaInventarisController::class);

// Kelola Cabang Routes
Route::resource('kelola-cabang', KelolaCabangController::class);
Route::patch('/kelola-cabang/{cabang}/toggle-status', [KelolaCabangController::class, 'toggleStatus'])->name('kelola-cabang.toggle-status');

// Laporan Routes
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

// Auth routes placeholder
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
