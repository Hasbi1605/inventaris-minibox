@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Laporan</h4>
            <p class="mb-0 text-sm text-slate-500">Analisis pendapatan, layanan, dan operasional</p>
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

    <!-- Filter Card -->
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Filter Laporan</h6>
            <p class="text-sm leading-normal text-slate-400">Pilih periode dan cabang untuk filter laporan</p>
        </div>
        <div class="flex-auto p-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Quick Date Range -->
                <div class="lg:col-span-4">
                    <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Periode Cepat</label>
                    <div class="flex flex-wrap gap-2">
                        <button class="quick-date-btn active px-4 py-2 text-sm font-medium text-white bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg transition-all hover:scale-102" data-period="today">Hari Ini</button>
                        <button class="quick-date-btn px-4 py-2 text-sm font-medium text-slate-700 bg-gray-100 rounded-lg transition-all hover:bg-gray-200" data-period="this-week">Minggu Ini</button>
                        <button class="quick-date-btn px-4 py-2 text-sm font-medium text-slate-700 bg-gray-100 rounded-lg transition-all hover:bg-gray-200" data-period="this-month">Bulan Ini</button>
                        <button class="quick-date-btn px-4 py-2 text-sm font-medium text-slate-700 bg-gray-100 rounded-lg transition-all hover:bg-gray-200" data-period="this-year">Tahun Ini</button>
                        <button class="quick-date-btn px-4 py-2 text-sm font-medium text-slate-700 bg-gray-100 rounded-lg transition-all hover:bg-gray-200" data-period="custom">Kustom</button>
                    </div>
                </div>
                <!-- Custom Date Range -->
                <div id="custom-date-range" class="lg:col-span-4 grid grid-cols-1 lg:grid-cols-3 gap-6 hidden">
                    <div>
                        <label for="start-date" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Mulai</label>
                        <input type="date" id="start-date" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none" value="2024-09-01">
                    </div>
                    <div>
                        <label for="end-date" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Akhir</label>
                        <input type="date" id="end-date" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none" value="2024-09-30">
                    </div>
                    <div>
                        <label for="branch-filter" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Filter Cabang</label>
                        <select id="branch-filter" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none">
                            <option value="all">Semua Cabang</option>
                            <option value="cabang-utama">Cabang Utama</option>
                            <option value="cabang-timur">Cabang Timur</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button class="tab-btn active whitespace-nowrap py-4 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600" data-tab="pendapatan">
                    <i class="fas fa-chart-line mr-2"></i>Laporan Pendapatan
                </button>
                <button class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="layanan">
                    <i class="fas fa-cut mr-2"></i>Layanan & Produk
                </button>
                <button class="tab-btn whitespace-nowrap py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="operasional">
                    <i class="fas fa-cogs mr-2"></i>Operasional
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Tab Pendapatan -->
        <div id="tab-pendapatan" class="tab-panel active">
            @include('pages.laporan.partials.pendapatan')
        </div>

        <!-- Tab Layanan & Produk -->
        <div id="tab-layanan" class="tab-panel hidden">
            @include('pages.laporan.partials.layanan')
        </div>

        <!-- Tab Operasional -->
        <div id="tab-operasional" class="tab-panel hidden">
            @include('pages.laporan.partials.operasional')
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab functionality
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanels = document.querySelectorAll('.tab-panel');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                tabBtns.forEach(b => {
                    b.classList.remove('active', 'border-blue-500', 'text-blue-600');
                    b.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                });
                tabPanels.forEach(p => p.classList.add('hidden'));
                
                this.classList.add('active', 'border-blue-500', 'text-blue-600');
                this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                
                document.getElementById('tab-' + targetTab).classList.remove('hidden');
            });
        });

        // Quick date range functionality
        const quickDateBtns = document.querySelectorAll('.quick-date-btn');
        const customDateRange = document.getElementById('custom-date-range');
        
        quickDateBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const period = this.getAttribute('data-period');
                
                quickDateBtns.forEach(b => {
                    b.classList.remove('active', 'bg-gradient-to-tl', 'from-blue-600', 'to-cyan-400', 'text-white');
                    b.classList.add('bg-gray-100', 'text-slate-700');
                });
                
                this.classList.add('active', 'bg-gradient-to-tl', 'from-blue-600', 'to-cyan-400', 'text-white');
                this.classList.remove('bg-gray-100', 'text-slate-700');
                
                if (period === 'custom') {
                    customDateRange.classList.remove('hidden');
                } else {
                    customDateRange.classList.add('hidden');
                }
            });
        });
    });
</script>
@endsection
@endsection