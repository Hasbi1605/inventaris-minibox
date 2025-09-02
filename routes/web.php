<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard tanpa auth untuk demo
Route::get('/dashboard', function () {
    // Data dummy untuk demo
    $todayStats = [
        'total_sales' => 850000,
        'total_profit' => 425000,
        'transaction_count' => 12,
        'customer_count' => 8
    ];

    $weekStats = [
        'total_sales' => 4200000,
        'total_profit' => 2100000,
        'transaction_count' => 58,
        'customer_count' => 32
    ];

    $monthStats = [
        'total_sales' => 18500000,
        'total_profit' => 9250000,
        'transaction_count' => 245,
        'customer_count' => 128
    ];

    $salesChart = [
        ['date' => 'Aug 27', 'sales' => 650000],
        ['date' => 'Aug 28', 'sales' => 720000],
        ['date' => 'Aug 29', 'sales' => 890000],
        ['date' => 'Aug 30', 'sales' => 560000],
        ['date' => 'Aug 31', 'sales' => 780000],
        ['date' => 'Sep 01', 'sales' => 920000],
        ['date' => 'Sep 02', 'sales' => 850000],
    ];

    $lowStockProducts = collect([
        (object) ['name' => 'Shampo Anti Ketombe', 'stock_quantity' => 3, 'unit' => 'botol'],
        (object) ['name' => 'Hair Wax', 'stock_quantity' => 2, 'unit' => 'jar'],
        (object) ['name' => 'Beard Oil', 'stock_quantity' => 1, 'unit' => 'botol'],
    ]);

    $recentTransactions = collect([
        (object) [
            'transaction_number' => 'TRX20250902001',
            'customer' => (object) ['name' => 'John Doe'],
            'total' => 75000,
            'payment_method' => 'cash',
            'status' => 'completed',
            'transaction_date' => now()->subHours(2)
        ],
        (object) [
            'transaction_number' => 'TRX20250902002',
            'customer' => null,
            'total' => 45000,
            'payment_method' => 'card',
            'status' => 'completed',
            'transaction_date' => now()->subHours(3)
        ],
    ]);

    return view('dashboard', compact(
        'todayStats',
        'weekStats',
        'monthStats',
        'salesChart',
        'lowStockProducts',
        'recentTransactions'
    ));
})->name('dashboard');

// Routes lainnya bisa ditambahkan nanti setelah sistem selesai
Route::get('/demo-features', function () {
    return view('demo-features');
});

// Placeholder routes untuk navigation
Route::get('/transactions', function () {
    return 'Transactions Module - Coming Soon';
})->name('transactions.index');
Route::get('/transactions/create', function () {
    return 'Create Transaction - Coming Soon';
})->name('transactions.create');
Route::get('/transactions/{id}', function ($id) {
    return 'Transaction Details - Coming Soon';
})->name('transactions.show');
Route::get('/products', function () {
    return 'Products Module - Coming Soon';
})->name('products.index');
Route::get('/products/create', function () {
    return 'Create Product - Coming Soon';
})->name('products.create');
Route::get('/products/low-stock', function () {
    return 'Low Stock Products - Coming Soon';
})->name('products.low-stock');
Route::get('/services', function () {
    return 'Services Module - Coming Soon';
})->name('services.index');
Route::get('/customers', function () {
    return 'Customers Module - Coming Soon';
})->name('customers.index');
Route::get('/customers/create', function () {
    return 'Create Customer - Coming Soon';
})->name('customers.create');
Route::get('/reports/weekly', function () {
    return 'Weekly Report - Coming Soon';
})->name('reports.weekly');
Route::get('/reports/monthly', function () {
    return 'Monthly Report - Coming Soon';
})->name('reports.monthly');
