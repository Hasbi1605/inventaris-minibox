@extends('layouts.app')

@section('title', 'Dashboard - Barbershop Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h1>
    <div class="text-muted">
        {{ now()->format('l, d F Y') }}
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Penjualan Hari Ini</h6>
                        <h4 class="mb-0">Rp {{ number_format($todayStats['total_sales'] ?? 0, 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card profit-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Keuntungan Hari Ini</h6>
                        <h4 class="mb-0">Rp {{ number_format($todayStats['total_profit'] ?? 0, 0, ',', '.') }}</h4>
                    </div>
                    <i class="fas fa-chart-line fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card transaction-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Transaksi Hari Ini</h6>
                        <h4 class="mb-0">{{ $todayStats['transaction_count'] ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-receipt fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card customer-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title mb-1">Pelanggan Hari Ini</h6>
                        <h4 class="mb-0">{{ $todayStats['customer_count'] ?? 0 }}</h4>
                    </div>
                    <i class="fas fa-users fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weekly and Monthly Stats -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-week me-2"></i>Statistik Minggu Ini</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h6 class="text-muted">Total Penjualan</h6>
                            <h4 class="text-primary">Rp {{ number_format($weekStats['total_sales'] ?? 0, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h6 class="text-muted">Total Keuntungan</h6>
                            <h4 class="text-success">Rp {{ number_format($weekStats['total_profit'] ?? 0, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Transaksi: {{ $weekStats['transaction_count'] ?? 0 }}</small>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Pelanggan: {{ $weekStats['customer_count'] ?? 0 }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Statistik Bulan Ini</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h6 class="text-muted">Total Penjualan</h6>
                            <h4 class="text-primary">Rp {{ number_format($monthStats['total_sales'] ?? 0, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h6 class="text-muted">Total Keuntungan</h6>
                            <h4 class="text-success">Rp {{ number_format($monthStats['total_profit'] ?? 0, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Transaksi: {{ $monthStats['transaction_count'] ?? 0 }}</small>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Pelanggan: {{ $monthStats['customer_count'] ?? 0 }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Quick Actions -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-chart-area me-2"></i>Penjualan 7 Hari Terakhir</h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Stok Rendah</h5>
            </div>
            <div class="card-body">
                @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                    @foreach($lowStockProducts as $product)
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <div class="fw-bold">{{ $product->name }}</div>
                                <small class="text-muted">Stok: {{ $product->stock_quantity }}</small>
                            </div>
                            <span class="badge bg-warning">{{ $product->unit }}</span>
                        </div>
                    @endforeach
                    <a href="/products/low-stock" class="btn btn-sm btn-outline-warning">Lihat Semua</a>
                @else
                    <p class="text-muted mb-0">Tidak ada produk dengan stok rendah.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="/transactions/create" class="btn btn-primary">
                        <i class="fas fa-cash-register me-2"></i>Transaksi Baru
                    </a>
                    <a href="/products/create" class="btn btn-outline-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Produk
                    </a>
                    <a href="/customers/create" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus me-2"></i>Tambah Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Transaksi Terbaru</h5>
    </div>
    <div class="card-body">
        @if(isset($recentTransactions) && $recentTransactions->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Metode Bayar</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                            <tr>
                                <td>
                                    <a href="/transactions/{{ $loop->index + 1 }}" class="text-decoration-none">
                                        {{ $transaction->transaction_number }}
                                    </a>
                                </td>
                                <td>{{ $transaction->customer ? $transaction->customer->name : 'Walk-in' }}</td>
                                <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($transaction->payment_method) }}</span>
                                </td>
                                <td>
                                    @if($transaction->status === 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>{{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <a href="/transactions" class="btn btn-outline-primary">Lihat Semua Transaksi</a>
            </div>
        @else
            <p class="text-muted text-center">Belum ada transaksi hari ini.</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesChart ?? []);
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(item => item.date),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: salesData.map(item => item.sales),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush
