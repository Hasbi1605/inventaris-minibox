<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TablesController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\VirtualRealityController;
use App\Http\Controllers\RtlController;
use App\Http\Controllers\ProfileController;

Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/tables', [TablesController::class, 'index'])->name('tables');
Route::get('/billing', [BillingController::class, 'index'])->name('billing');
Route::get('/virtual-reality', [VirtualRealityController::class, 'index'])->name('virtual-reality');
Route::get('/rtl', [RtlController::class, 'index'])->name('rtl');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Auth routes placeholder
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
