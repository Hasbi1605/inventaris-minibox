@extends('layouts.admin')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
<!-- Global Controls Section -->
<div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h6 class="mb-0 font-bold text-slate-800">Filter & Kontrol Laporan</h6>
                        <p class="text-sm leading-normal text-slate-500 mb-0">
                            Pilih periode dan cabang untuk memfilter semua laporan di bawah
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <button id="export-pdf-btn" class="inline-block px-4 py-2 mr-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="ni ni-single-copy-04 mr-2"></i>Export PDF
                        </button>
                        <button id="export-excel-btn" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="ni ni-archive-2 mr-2"></i>Export Excel
                        </button>
                    </div>
                </div>
            </div>
            <div class="flex-auto p-6">
                <div class="flex flex-wrap -mx-3 gap-y-4">
                    <!-- Quick Date Range Buttons -->
                    <div class="w-full max-w-full px-3 mb-4">
                        <label class="block mb-3 text-xs font-bold text-slate-700 uppercase">Periode Cepat</label>
                        <div class="flex flex-wrap gap-2">
                            <button class="quick-date-btn active px-4 py-2 text-sm font-medium text-white bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg transition-all hover:scale-102" data-period="today">
                                Hari Ini
                            </button>
                            <button class="quick-date-btn px-4 py-2 text-sm font-medium text-slate-700 bg-gray-100 rounded-lg transition-all hover:bg-gray-200" data-period="this-week">
                                Minggu Ini
                            </button>
                            <button class="quick-date-btn px-4 py-2 text-sm font-medium text-slate-700 bg-gray-100 rounded-lg transition-all hover:bg-gray-200" data-period="this-month">
                                Bulan Ini
                            </button>
                            <button class="quick-date-btn px-4 py-2 text-sm font-medium text-slate-700 bg-gray-100 rounded-lg transition-all hover:bg-gray-200" data-period="this-year">
                                Tahun Ini
                            </button>
                            <button class="quick-date-btn px-4 py-2 text-sm font-medium text-slate-700 bg-gray-100 rounded-lg transition-all hover:bg-gray-200" data-period="custom">
                                Kustom
                            </button>
                        </div>
                    </div>
                    
                    <!-- Custom Date Range -->
                    <div id="custom-date-range" class="w-full hidden">
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Tanggal Mulai</label>
                                <input type="date" id="start-date" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" value="2024-09-01">
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Tanggal Akhir</label>
                                <input type="date" id="end-date" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" value="2024-09-30">
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                                <label class="block mb-2 text-xs font-bold text-slate-700 uppercase">Filter Cabang</label>
                                <select id="branch-filter" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all focus:border-fuchsia-300 focus:outline-none">
                                    <option value="all">Semua Cabang</option>
                                    <option value="cabang-utama">Cabang Utama</option>
                                    <option value="cabang-timur">Cabang Timur</option>
                                    <option value="cabang-barat">Cabang Barat</option>
                                    <option value="cabang-selatan">Cabang Selatan</option>
                                    <option value="cabang-utara">Cabang Utara</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tab Navigation -->
<div class="flex flex-wrap -mx-3 mb-6">
    <div class="w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0">
                <div class="flex flex-wrap border-b border-gray-200">
                    <button class="tab-btn active mr-8 pb-4 text-sm font-semibold text-blue-600 border-b-2 border-blue-600" data-tab="pendapatan">
                        <i class="ni ni-money-coins mr-2"></i>Laporan Pendapatan
                    </button>
                    <button class="tab-btn mr-8 pb-4 text-sm font-semibold text-slate-500 hover:text-slate-700 transition-colors" data-tab="layanan">
                        <i class="ni ni-scissors mr-2"></i>Layanan & Produk
                    </button>
                    <button class="tab-btn mr-8 pb-4 text-sm font-semibold text-slate-500 hover:text-slate-700 transition-colors" data-tab="operasional">
                        <i class="ni ni-settings mr-2"></i>Operasional
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tab Content -->
<div class="tab-content">
    <!-- Tab Pendapatan -->
    <div id="tab-pendapatan" class="tab-panel active">
        <!-- Kartu Metrik Utama Pendapatan -->
        <div class="flex flex-wrap -mx-3 mb-6 items-stretch">
            <!-- Pendapatan Kotor -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-green-500">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pendapatan Kotor</p>
                                    <h5 class="mb-0 font-bold text-2xl text-green-600" id="gross-revenue">
                                        Rp 15.400.000
                                    </h5>
                                    <div class="mt-1">
                                        <span class="text-sm leading-normal font-semibold text-lime-500">
                                            <i class="fa fa-arrow-up mr-1"></i>+12%
                                        </span>
                                        <span class="text-xs text-slate-500 ml-1">vs periode sebelumnya</span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                                    <i class="ni ni-money-coins text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Bersih -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-blue-500">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pendapatan Bersih</p>
                                    <h5 class="mb-0 font-bold text-2xl text-blue-600" id="net-revenue">
                                        Rp 12.200.000
                                    </h5>
                                    <div class="mt-1">
                                        <span class="text-sm leading-normal font-semibold text-lime-500">
                                            <i class="fa fa-arrow-up mr-1"></i>+8%
                                        </span>
                                        <span class="text-xs text-slate-500 ml-1">margin 79%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                    <i class="ni ni-chart-pie-35 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Target Bulanan -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-purple-500">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Progress Target</p>
                                    <h5 class="mb-0 font-bold text-2xl text-purple-600">
                                        77%
                                    </h5>
                                    <div class="mt-1">
                                        <span class="text-xs text-slate-500">Target: Rp 20.000.000</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: 77%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-400">
                                    <i class="ni ni-trophy text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik dan Tabel Pendapatan -->
        <div class="flex flex-col gap-6">
            <!-- Top Row -->
            <div class="grid grid-cols-[7fr_5fr] gap-6 auto-rows-fr">
                <!-- Grafik Tren Pendapatan -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <h6 class="mb-0 font-bold text-slate-800">Tren Pendapatan</h6>
                            <div class="flex gap-2">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Periode Terpilih
                                </span>
                            </div>
                        </div>
                        <p class="text-sm leading-normal text-slate-500 mb-0">
                            <i class="fa fa-chart-line text-green-500 mr-1"></i>
                            <span class="font-semibold">Analisis performa pendapatan per periode</span>
                        </p>
                    </div>
                    <div class="flex-auto p-4">
                        <div class="relative">
                            <canvas id="revenue-trend-chart" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Perbandingan Pendapatan per Cabang -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <h6 class="mb-0 font-bold text-slate-800">Pendapatan per Cabang</h6>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                5 Cabang
                            </span>
                        </div>
                        <p class="text-sm leading-normal text-slate-500 mb-0">
                            <i class="fa fa-chart-bar text-blue-500 mr-1"></i>
                            <span class="font-semibold">Perbandingan performa cabang</span>
                        </p>
                    </div>
                    <div class="flex-auto p-4">
                        <div class="relative">
                            <canvas id="branch-revenue-chart" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Peringkat Barber -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-board">
                <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="mb-0 font-bold text-slate-800">Peringkat Performa Barber</h6>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Top Performers
                        </span>
                    </div>
                    <p class="text-sm leading-normal text-slate-500 mb-0">
                        <i class="fa fa-user-friends text-yellow-500 mr-1"></i>
                        <span class="font-semibold">Berdasarkan total pendapatan yang dihasilkan</span>
                    </p>
                </div>
                <div class="flex-auto p-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm align-middle">
                            <thead class="align-bottom">
                                <tr class="border-b border-gray-200">
                                    <th class="py-3 px-4 text-left font-semibold text-slate-700">#</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-700">Nama Barber</th>
                                    <th class="py-3 px-4 text-left font-semibold text-slate-700">Cabang</th>
                                    <th class="py-3 px-4 text-right font-semibold text-slate-700">Total Pendapatan</th>
                                    <th class="py-3 px-4 text-right font-semibold text-slate-700">Jumlah Transaksi</th>
                                    <th class="py-3 px-4 text-right font-semibold text-slate-700">Rata-rata/Transaksi</th>
                                    <th class="py-3 px-4 text-center font-semibold text-slate-700">Performa</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100" id="barber-performance-table">
                                <!-- Data akan dimuat via JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Layanan & Produk -->
    <div id="tab-layanan" class="tab-panel hidden">
        <!-- Kartu Metrik Layanan -->
        <div class="flex flex-wrap -mx-3 mb-6 items-stretch">
            <!-- Total Layanan Terjual -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-blue-500">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Layanan</p>
                                    <h5 class="mb-0 font-bold text-2xl text-blue-600">
                                        245
                                    </h5>
                                    <div class="mt-1">
                                        <span class="text-sm leading-normal font-semibold text-lime-500">
                                            <i class="fa fa-arrow-up mr-1"></i>+15%
                                        </span>
                                        <span class="text-xs text-slate-500 ml-1">layanan terjual</span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                    <i class="ni ni-scissors text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk Retail Terjual -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-orange-500">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Produk Retail</p>
                                    <h5 class="mb-0 font-bold text-2xl text-orange-600">
                                        156
                                    </h5>
                                    <div class="mt-1">
                                        <span class="text-sm leading-normal font-semibold text-lime-500">
                                            <i class="fa fa-arrow-up mr-1"></i>+8%
                                        </span>
                                        <span class="text-xs text-slate-500 ml-1">produk terjual</span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-orange-600 to-yellow-400">
                                    <i class="ni ni-bag-17 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Paket Layanan -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-purple-500">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Paket Premium</p>
                                    <h5 class="mb-0 font-bold text-2xl text-purple-600">
                                        89
                                    </h5>
                                    <div class="mt-1">
                                        <span class="text-sm leading-normal font-semibold text-lime-500">
                                            <i class="fa fa-arrow-up mr-1"></i>+22%
                                        </span>
                                        <span class="text-xs text-slate-500 ml-1">paket terjual</span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-600 to-pink-400">
                                    <i class="ni ni-diamond text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Nilai Transaksi -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-green-500">
                    <div class="flex-auto p-4">
                        <div class="flex flex-row -mx-3">
                            <div class="flex-none w-2/3 max-w-full px-3">
                                <div>
                                    <p class="mb-0 font-sans text-sm font-semibold leading-normal">Rata-rata Transaksi</p>
                                    <h5 class="mb-0 font-bold text-2xl text-green-600">
                                        Rp 65K
                                    </h5>
                                    <div class="mt-1">
                                        <span class="text-sm leading-normal font-semibold text-lime-500">
                                            <i class="fa fa-arrow-up mr-1"></i>+5%
                                        </span>
                                        <span class="text-xs text-slate-500 ml-1">per transaksi</span>
                                    </div>
                                </div>
                            </div>
                            <div class="px-3 text-right basis-1/3">
                                <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                                    <i class="ni ni-chart-bar-32 text-lg relative top-3.5 text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik dan Tabel Layanan -->
        <div class="flex flex-col gap-6">
            <!-- Top Row -->
            <div class="grid grid-cols-[5fr_7fr] gap-6 auto-rows-fr">
                <!-- Grafik Layanan Terlaris -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <h6 class="mb-0 font-bold text-slate-800">Distribusi Layanan</h6>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Top 5
                            </span>
                        </div>
                        <p class="text-sm leading-normal text-slate-500 mb-0">
                            <i class="fa fa-chart-pie text-blue-500 mr-1"></i>
                            <span class="font-semibold">Berdasarkan jumlah transaksi</span>
                        </p>
                    </div>
                    <div class="flex-auto p-4">
                        <div class="relative">
                            <canvas id="services-distribution-chart" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Tabel Layanan Terlaris -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <h6 class="mb-0 font-bold text-slate-800">Peringkat Layanan Terlaris</h6>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Best Sellers
                            </span>
                        </div>
                        <p class="text-sm leading-normal text-slate-500 mb-0">
                            <i class="fa fa-star text-yellow-500 mr-1"></i>
                            <span class="font-semibold">Ranking berdasarkan pendapatan dan jumlah</span>
                        </p>
                    </div>
                    <div class="flex-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm align-middle">
                                <thead class="align-bottom">
                                    <tr class="border-b border-gray-200">
                                        <th class="py-3 px-4 text-left font-semibold text-slate-700">#</th>
                                        <th class="py-3 px-4 text-left font-semibold text-slate-700">Layanan</th>
                                        <th class="py-3 px-4 text-right font-semibold text-slate-700">Terjual</th>
                                        <th class="py-3 px-4 text-right font-semibold text-slate-700">Pendapatan</th>
                                        <th class="py-3 px-4 text-center font-semibold text-slate-700">Trend</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100" id="services-ranking-table">
                                    <!-- Data akan dimuat via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Row - Produk Retail dan Paket Layanan -->
            <div class="grid grid-cols-[1fr_1fr] gap-6 auto-rows-fr">
                <!-- Tabel Produk Retail Terlaris -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <h6 class="mb-0 font-bold text-slate-800">Produk Retail Terlaris</h6>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Retail
                            </span>
                        </div>
                        <p class="text-sm leading-normal text-slate-500 mb-0">
                            <i class="fa fa-shopping-bag text-orange-500 mr-1"></i>
                            <span class="font-semibold">Penjualan produk perawatan</span>
                        </p>
                    </div>
                    <div class="flex-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm align-middle">
                                <thead class="align-bottom">
                                    <tr class="border-b border-gray-200">
                                        <th class="py-3 px-4 text-left font-semibold text-slate-700">#</th>
                                        <th class="py-3 px-4 text-left font-semibold text-slate-700">Produk</th>
                                        <th class="py-3 px-4 text-right font-semibold text-slate-700">Terjual</th>
                                        <th class="py-3 px-4 text-right font-semibold text-slate-700">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100" id="retail-products-table">
                                    <!-- Data akan dimuat via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Analisis Performa Paket Layanan -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                        <div class="flex items-center justify-between mb-2">
                            <h6 class="mb-0 font-bold text-slate-800">Performa Paket Layanan</h6>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Premium
                            </span>
                        </div>
                        <p class="text-sm leading-normal text-slate-500 mb-0">
                            <i class="fa fa-gem text-purple-500 mr-1"></i>
                            <span class="font-semibold">Analisis profitabilitas paket</span>
                        </p>
                    </div>
                    <div class="flex-auto p-4">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm align-middle">
                                <thead class="align-bottom">
                                    <tr class="border-b border-gray-200">
                                        <th class="py-3 px-4 text-left font-semibold text-slate-700">Paket</th>
                                        <th class="py-3 px-4 text-right font-semibold text-slate-700">Terjual</th>
                                        <th class="py-3 px-4 text-right font-semibold text-slate-700">Margin</th>
                                        <th class="py-3 px-4 text-center font-semibold text-slate-700">ROI</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100" id="package-performance-table">
                                    <!-- Data akan dimuat via JavaScript -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab Operasional -->
    <div id="tab-operasional" class="tab-panel hidden">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6">
                <div class="text-center py-12">
                    <i class="ni ni-settings text-6xl text-slate-300 mb-4"></i>
                    <h6 class="text-slate-500 mb-2">Laporan Operasional</h6>
                    <p class="text-slate-400">Fitur ini akan segera tersedia</p>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanels = document.querySelectorAll('.tab-panel');
        
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetTab = this.getAttribute('data-tab');
                
                // Remove active class from all tabs and panels
                tabBtns.forEach(b => {
                    b.classList.remove('active', 'text-blue-600', 'border-blue-600');
                    b.classList.add('text-slate-500');
                });
                tabPanels.forEach(p => {
                    p.classList.remove('active');
                    p.classList.add('hidden');
                });
                
                // Add active class to clicked tab
                this.classList.add('active', 'text-blue-600', 'border-blue-600');
                this.classList.remove('text-slate-500');
                
                // Show corresponding panel
                const targetPanel = document.getElementById('tab-' + targetTab);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                    targetPanel.classList.remove('hidden');
                }
            });
        });
        
        // Quick date range functionality
        const quickDateBtns = document.querySelectorAll('.quick-date-btn');
        const customDateRange = document.getElementById('custom-date-range');
        
        quickDateBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const period = this.getAttribute('data-period');
                
                // Remove active class from all buttons
                quickDateBtns.forEach(b => {
                    b.classList.remove('active', 'bg-gradient-to-tl', 'from-blue-600', 'to-cyan-400', 'text-white');
                    b.classList.add('bg-gray-100', 'text-slate-700');
                });
                
                // Add active class to clicked button
                this.classList.add('active', 'bg-gradient-to-tl', 'from-blue-600', 'to-cyan-400', 'text-white');
                this.classList.remove('bg-gray-100', 'text-slate-700');
                
                // Show/hide custom date range
                if (period === 'custom') {
                    customDateRange.classList.remove('hidden');
                } else {
                    customDateRange.classList.add('hidden');
                }
            });
        });
    });

    // Chart untuk laporan keuangan
    var ctx = document.getElementById("chart-bars");
    if (ctx) {
        ctx = ctx.getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep"],
                datasets: [{
                    label: "Pendapatan",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "rgba(255, 255, 255, .8)",
                    data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    }
</script>
@endsection
@endsection
