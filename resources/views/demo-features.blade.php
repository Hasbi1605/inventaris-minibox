@extends('layouts.app')

@section('title', 'Demo Features - Barbershop Management')

@section('content')
<div class="mb-4">
    <h1><i class="fas fa-star me-2"></i>Demo Fitur Sistem Barbershop</h1>
    <p class="text-muted">Sistem Kasir dan Inventaris Barbershop yang lengkap dengan analisis mingguan dan bulanan</p>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-cash-register me-2"></i>Sistem Kasir</h5>
            </div>
            <div class="card-body">
                <h6>Fitur Utama:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>POS (Point of Sale) lengkap</li>
                    <li><i class="fas fa-check text-success me-2"></i>Multi payment method</li>
                    <li><i class="fas fa-check text-success me-2"></i>Receipt printing</li>
                    <li><i class="fas fa-check text-success me-2"></i>Customer management</li>
                    <li><i class="fas fa-check text-success me-2"></i>Loyalty points system</li>
                    <li><i class="fas fa-check text-success me-2"></i>Transaction history</li>
                </ul>
                <h6>Kemampuan:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-arrow-right text-primary me-2"></i>Jual produk & layanan</li>
                    <li><i class="fas fa-arrow-right text-primary me-2"></i>Hitung otomatis kembalian</li>
                    <li><i class="fas fa-arrow-right text-primary me-2"></i>Diskon & pajak</li>
                    <li><i class="fas fa-arrow-right text-primary me-2"></i>Batalkan transaksi</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-boxes me-2"></i>Manajemen Inventaris</h5>
            </div>
            <div class="card-body">
                <h6>Fitur Utama:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Product management</li>
                    <li><i class="fas fa-check text-success me-2"></i>Stock tracking</li>
                    <li><i class="fas fa-check text-success me-2"></i>Low stock alerts</li>
                    <li><i class="fas fa-check text-success me-2"></i>Inventory movements</li>
                    <li><i class="fas fa-check text-success me-2"></i>Barcode support</li>
                    <li><i class="fas fa-check text-success me-2"></i>Category management</li>
                </ul>
                <h6>Kemampuan:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-arrow-right text-success me-2"></i>Auto stock update saat jual</li>
                    <li><i class="fas fa-arrow-right text-success me-2"></i>Manual stock adjustment</li>
                    <li><i class="fas fa-arrow-right text-success me-2"></i>Purchase price tracking</li>
                    <li><i class="fas fa-arrow-right text-success me-2"></i>Profit calculation</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Analisis & Laporan</h5>
            </div>
            <div class="card-body">
                <h6>Fitur Utama:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Dashboard real-time</li>
                    <li><i class="fas fa-check text-success me-2"></i>Laporan harian</li>
                    <li><i class="fas fa-check text-success me-2"></i>Laporan mingguan</li>
                    <li><i class="fas fa-check text-success me-2"></i>Laporan bulanan</li>
                    <li><i class="fas fa-check text-success me-2"></i>Profit analysis</li>
                    <li><i class="fas fa-check text-success me-2"></i>Best selling items</li>
                </ul>
                <h6>Metrik yang Dilacak:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Total penjualan</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Total keuntungan</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Jumlah transaksi</li>
                    <li><i class="fas fa-arrow-right text-warning me-2"></i>Customer retention</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-scissors me-2"></i>Manajemen Layanan</h5>
            </div>
            <div class="card-body">
                <h6>Fitur:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Service catalog</li>
                    <li><i class="fas fa-check text-success me-2"></i>Pricing management</li>
                    <li><i class="fas fa-check text-success me-2"></i>Service duration tracking</li>
                    <li><i class="fas fa-check text-success me-2"></i>Cost calculation</li>
                </ul>
                
                <h6>Contoh Layanan:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Layanan</th>
                                <th>Harga</th>
                                <th>Durasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Potong Rambut Classic</td>
                                <td>Rp 25.000</td>
                                <td>30 menit</td>
                            </tr>
                            <tr>
                                <td>Potong Rambut Modern</td>
                                <td>Rp 35.000</td>
                                <td>45 menit</td>
                            </tr>
                            <tr>
                                <td>Hair Treatment</td>
                                <td>Rp 40.000</td>
                                <td>45 menit</td>
                            </tr>
                            <tr>
                                <td>Beard Trim</td>
                                <td>Rp 20.000</td>
                                <td>25 menit</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Manajemen Produk</h5>
            </div>
            <div class="card-body">
                <h6>Fitur:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Product catalog</li>
                    <li><i class="fas fa-check text-success me-2"></i>SKU & barcode support</li>
                    <li><i class="fas fa-check text-success me-2"></i>Multi-unit management</li>
                    <li><i class="fas fa-check text-success me-2"></i>Profit margin tracking</li>
                </ul>
                
                <h6>Contoh Produk:</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Shampo Anti Ketombe</td>
                                <td>Rp 50.000</td>
                                <td>50 botol</td>
                            </tr>
                            <tr>
                                <td>Pomade Classic</td>
                                <td>Rp 40.000</td>
                                <td>40 jar</td>
                            </tr>
                            <tr>
                                <td>Beard Oil</td>
                                <td>Rp 70.000</td>
                                <td>20 botol</td>
                            </tr>
                            <tr>
                                <td>Hair Wax</td>
                                <td>Rp 45.000</td>
                                <td>25 jar</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="fas fa-cogs me-2"></i>Teknologi & Fitur Teknis</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <h6>Backend Technology:</h6>
                <ul class="list-unstyled">
                    <li><i class="fab fa-php me-2"></i>Laravel 12</li>
                    <li><i class="fas fa-database me-2"></i>MySQL Database</li>
                    <li><i class="fas fa-server me-2"></i>Eloquent ORM</li>
                    <li><i class="fas fa-shield-alt me-2"></i>Built-in Security</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Frontend Technology:</h6>
                <ul class="list-unstyled">
                    <li><i class="fab fa-bootstrap me-2"></i>Bootstrap 5</li>
                    <li><i class="fab fa-js-square me-2"></i>JavaScript ES6+</li>
                    <li><i class="fas fa-chart-bar me-2"></i>Chart.js</li>
                    <li><i class="fas fa-mobile-alt me-2"></i>Responsive Design</li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Key Features:</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-users me-2"></i>Multi-user support</li>
                    <li><i class="fas fa-lock me-2"></i>Role-based access</li>
                    <li><i class="fas fa-cloud me-2"></i>Cloud-ready</li>
                    <li><i class="fas fa-sync me-2"></i>Real-time updates</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-rocket me-2"></i>Keunggulan Sistem</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3 text-center">
                <i class="fas fa-tachometer-alt fa-3x text-primary mb-3"></i>
                <h5>Performance</h5>
                <p class="text-muted">Sistem yang cepat dan responsive untuk operasional harian barbershop</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-chart-line fa-3x text-success mb-3"></i>
                <h5>Analytics</h5>
                <p class="text-muted">Analisis mendalam untuk keputusan bisnis yang lebih baik</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-mobile-alt fa-3x text-info mb-3"></i>
                <h5>Mobile Friendly</h5>
                <p class="text-muted">Dapat diakses dari berbagai device untuk fleksibilitas maksimal</p>
            </div>
            <div class="col-md-3 text-center">
                <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                <h5>Secure</h5>
                <p class="text-muted">Keamanan data terjamin dengan enkripsi dan best practices</p>
            </div>
        </div>
    </div>
</div>

<div class="text-center mt-4">
    <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-eye me-2"></i>Lihat Dashboard Demo
    </a>
</div>
@endsection
