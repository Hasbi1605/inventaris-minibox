<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barbershop Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            min-height: 100vh;
            padding: 0;
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 1rem 1.5rem;
            margin: 0.25rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .profit-card {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }
        .transaction-card {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }
        .customer-card {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="text-center py-4">
                    <h4 class="text-white"><i class="fas fa-cut"></i> Barbershop</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->is('/') || request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    
                    <div class="nav-item">
                        <h6 class="nav-link text-muted small">KASIR</h6>
                    </div>
                    <a class="nav-link {{ request()->is('transactions*') ? 'active' : '' }}" href="/transactions">
                        <i class="fas fa-cash-register me-2"></i> Transaksi
                    </a>
                    <a class="nav-link" href="/transactions/create">
                        <i class="fas fa-plus-circle me-2"></i> Transaksi Baru
                    </a>
                    
                    <div class="nav-item">
                        <h6 class="nav-link text-muted small">INVENTARIS</h6>
                    </div>
                    <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}" href="/products">
                        <i class="fas fa-boxes me-2"></i> Produk
                    </a>
                    <a class="nav-link {{ request()->is('services*') ? 'active' : '' }}" href="/services">
                        <i class="fas fa-scissors me-2"></i> Layanan
                    </a>
                    <a class="nav-link" href="/products/low-stock">
                        <i class="fas fa-exclamation-triangle me-2"></i> Stok Rendah
                    </a>
                    
                    <div class="nav-item">
                        <h6 class="nav-link text-muted small">MASTER DATA</h6>
                    </div>
                    <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}" href="/customers">
                        <i class="fas fa-users me-2"></i> Pelanggan
                    </a>
                    
                    <div class="nav-item">
                        <h6 class="nav-link text-muted small">LAPORAN</h6>
                    </div>
                    <a class="nav-link" href="/reports/weekly">
                        <i class="fas fa-chart-line me-2"></i> Laporan Mingguan
                    </a>
                    <a class="nav-link" href="/reports/monthly">
                        <i class="fas fa-chart-bar me-2"></i> Laporan Bulanan
                    </a>
                    
                    <div class="nav-item">
                        <h6 class="nav-link text-muted small">INFO</h6>
                    </div>
                    <a class="nav-link" href="/demo-features">
                        <i class="fas fa-info-circle me-2"></i> Demo Features
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 main-content p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
