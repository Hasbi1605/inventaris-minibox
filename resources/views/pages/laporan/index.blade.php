@extends('layouts.admin')

@section('title', 'Laporan Lengkap')
@section('page-title', 'Laporan Lengkap')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Laporan Lengkap</h4>
            <p class="mb-0 text-sm text-slate-500">Analisis komprehensif gaji, keuangan, dan operasional barbershop</p>
        </div>
        <div class="flex space-x-2">
            <button id="export-pdf-btn" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-yellow-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-file-pdf mr-2"></i>Export PDF
            </button>
            <button id="export-excel-btn" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-file-excel mr-2"></i>Export Excel
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Pendapatan -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Pendapatan</p>
                                <h5 class="mb-0 font-bold text-lg">Rp {{ number_format($statistics['total_pendapatan'], 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-money-bill-wave text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pengeluaran -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Pengeluaran</p>
                                <h5 class="mb-0 font-bold text-lg">Rp {{ number_format($statistics['total_pengeluaran'], 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-600 to-orange-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-shopping-cart text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendapatan Bersih -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pendapatan Bersih</p>
                                <h5 class="mb-0 font-bold text-lg">Rp {{ number_format($statistics['pendapatan_bersih'], 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-chart-line text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Transaksi</p>
                                <h5 class="mb-0 font-bold text-lg">{{ number_format($statistics['total_transaksi'], 0, ',', '.') }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-receipt text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6">
            <h6 class="font-bold mb-4">Filter Laporan</h6>
            <form method="GET" action="{{ route('laporan') }}" id="filter-form">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            <i class="fas fa-calendar mr-1"></i>Bulan
                        </label>
                        <select name="bulan" id="bulan" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            <i class="fas fa-calendar-alt mr-1"></i>Tahun
                        </label>
                        <select name="tahun" id="tahun" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none">
                            @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            <i class="fas fa-store mr-1"></i>Cabang
                        </label>
                        <select name="cabang_id" id="cabang_id" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none">
                            <option value="">Semua Cabang</option>
                            @foreach($cabangList as $cabang)
                                <option value="{{ $cabang->id }}" {{ $cabangId == $cabang->id ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-block w-full px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md hover:scale-102 active:opacity-85">
                            <i class="fas fa-filter mr-2"></i>Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-4 overflow-x-auto" aria-label="Tabs">
                <button class="tab-button active whitespace-nowrap py-4 px-6 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="gaji">
                    <i class="fas fa-hand-holding-usd mr-2"></i>Gaji & Komisi
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="keuangan">
                    <i class="fas fa-chart-pie mr-2"></i>Laba Rugi
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="cabang">
                    <i class="fas fa-store-alt mr-2"></i>Per Cabang
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="layanan">
                    <i class="fas fa-cut mr-2"></i>Layanan
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="inventaris">
                    <i class="fas fa-box mr-2"></i>Inventaris
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="cashflow">
                    <i class="fas fa-money-bill-wave mr-2"></i>Cash Flow
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="customer">
                    <i class="fas fa-users mr-2"></i>Customer
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Contents -->
    <div class="tab-contents">
        <!-- Tab 1: Gaji & Komisi Kapster -->
        <div class="tab-content active" id="tab-gaji">
            @include('pages.laporan.partials.gaji-kapster')
        </div>

        <!-- Tab 2: Laporan Keuangan (Laba Rugi) -->
        <div class="tab-content hidden" id="tab-keuangan">
            @include('pages.laporan.partials.keuangan')
        </div>

        <!-- Tab 3: Laporan Per Cabang -->
        <div class="tab-content hidden" id="tab-cabang">
            @include('pages.laporan.partials.cabang')
        </div>

        <!-- Tab 4: Laporan Layanan -->
        <div class="tab-content hidden" id="tab-layanan">
            @include('pages.laporan.partials.layanan-detail')
        </div>

        <!-- Tab 5: Laporan Inventaris -->
        <div class="tab-content hidden" id="tab-inventaris">
            @include('pages.laporan.partials.inventaris')
        </div>

        <!-- Tab 6: Cash Flow -->
        <div class="tab-content hidden" id="tab-cashflow">
            @include('pages.laporan.partials.cashflow')
        </div>

        <!-- Tab 7: Customer Behavior -->
        <div class="tab-content hidden" id="tab-customer">
            @include('pages.laporan.partials.customer')
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Tab switching functionality
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', function() {
        const tabName = this.dataset.tab;
        
        // Remove active class from all buttons and contents
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active', 'border-blue-500', 'text-blue-600');
            btn.classList.add('border-transparent', 'text-gray-500');
        });
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
            content.classList.remove('active');
        });
        
        // Add active class to clicked button and corresponding content
        this.classList.add('active', 'border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById(`tab-${tabName}`).classList.remove('hidden');
        document.getElementById(`tab-${tabName}`).classList.add('active');
    });
});

// Auto-submit filter form on change
document.getElementById('bulan').addEventListener('change', function() {
    document.getElementById('filter-form').submit();
});
document.getElementById('tahun').addEventListener('change', function() {
    document.getElementById('filter-form').submit();
});
document.getElementById('cabang_id').addEventListener('change', function() {
    document.getElementById('filter-form').submit();
});

// Export functionality
document.getElementById('export-pdf-btn').addEventListener('click', function() {
    alert('Export PDF functionality will be implemented');
});

document.getElementById('export-excel-btn').addEventListener('click', function() {
    alert('Export Excel functionality will be implemented');
});
</script>
@endpush
