@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Row 1 - Statistics Cards -->
<div class="flex flex-wrap -mx-3 mb-6 items-stretch">
    <!-- Card 1 - Pendapatan Hari Ini -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
            <div class="flex-auto p-4">
                <div class="flex flex-row items-center justify-between">
                    <div class="flex-1">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pendapatan Hari Ini</p>
                            <h5 class="mb-0 font-bold text-lg">
                                Rp 1.200.000
                                <span class="text-sm leading-normal font-semibold text-lime-500 ml-2">+10%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                            <i class="ni ni-money-coins text-lg relative top-3.5 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 2 - Transaksi Hari Ini -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
            <div class="flex-auto p-4">
                <div class="flex flex-row items-center justify-between">
                    <div class="flex-1">
                        <div>
                                                        <p class="mb-0 font-sans text-sm font-semibold leading-normal">Transaksi Hari Ini</p>
                            <h5 class="mb-0 font-bold text-lg">
                                35 transaksi
                                <span class="text-sm leading-normal font-semibold text-lime-500 ml-2">+3%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                            <i class="ni ni-scissors text-lg relative top-3.5 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 3 - Pendapatan Bulanan -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
            <div class="flex-auto p-4">
                <div class="flex flex-row items-center justify-between">
                    <div class="flex-1">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Pendapatan Bulanan</p>
                            <h5 class="mb-0 font-bold text-lg">
                                Rp 25.300.000
                                <span class="text-sm leading-normal font-semibold text-lime-500 ml-2">+8%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                            <i class="ni ni-chart-bar-32 text-lg relative top-3.5 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card 4 - Transaksi Bulanan -->
    <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
            <div class="flex-auto p-4">
                <div class="flex flex-row items-center justify-between">
                    <div class="flex-1">
                        <div>
                            <p class="mb-0 font-sans text-sm font-semibold leading-normal">Transaksi Bulanan</p>
                            <h5 class="mb-0 font-bold text-lg">
                                725 transaksi
                                <span class="text-sm leading-normal font-semibold text-lime-500 ml-2">+5%</span>
                            </h5>
                        </div>
                    </div>
                    <div class="text-right ml-4">
                        <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                            <i class="ni ni-archive-2 text-lg relative top-3.5 text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content - Restructured with flex-col -->
<div class="flex flex-col gap-6">
    <!-- Top Row -->
    <div class="grid grid-cols-1 lg:grid-cols-[7fr_5fr] gap-6 min-h-[400px] auto-rows-fr">
        <!-- Top-Left Column -->
        <div class="flex flex-col gap-6 min-h-0">
            <!-- Grafik Pendapatan Harian Chart -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="mb-0 font-bold text-slate-800">Grafik Pendapatan Harian</h6>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            7 Hari Terakhir
                        </span>
                    </div>
                    <p class="text-sm leading-normal text-slate-500 mb-0">
                        <i class="fa fa-arrow-up text-lime-500 mr-1"></i>
                        <span class="font-semibold">12% lebih tinggi</span> dari minggu lalu
                    </p>
                </div>
                <div class="flex-auto p-4">
                    <div class="relative">
                        <canvas id="chart-lines" class="chart-canvas" height="170" style="display: block; box-sizing: border-box; height: 170px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Pengeluaran Bulan Ini Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-l-red-500">
                <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="mb-0 font-bold text-slate-800">Pengeluaran Bulan Ini</h6>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            +15%
                        </span>
                    </div>
                    <p class="text-sm leading-normal text-slate-500 mb-0">
                        <i class="fa fa-arrow-down text-red-500 mr-1"></i>
                        <span class="font-semibold">Naik 15% dibanding bulan lalu</span>
                    </p>
                </div>
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3 mb-6">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <h5 class="mb-1 font-bold text-2xl text-red-600">
                                    Rp 3.500.000
                                </h5>
                                <p class="mt-1 text-xs text-slate-500">
                                    <i class="fa fa-info-circle text-slate-400 mr-1"></i>
                                    Mayoritas pengeluaran di gaji karyawan
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Breakdown pengeluaran -->
                    <div class="space-y-3">
                        <!-- Gaji Karyawan -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">👔</span>
                                    <span class="text-sm font-medium text-slate-700">Gaji Karyawan</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-slate-800">Rp 1.800.000</span>
                                    <span class="text-xs text-slate-500 ml-1">(51%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                <div class="bg-gradient-to-r from-red-400 to-red-500 h-2 rounded-full" style="width: 51%"></div>
                            </div>
                        </div>
                        
                        <!-- Pembelian Produk -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">📦</span>
                                    <span class="text-sm font-medium text-slate-700">Pembelian Produk</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-slate-800">Rp 950.000</span>
                                    <span class="text-xs text-slate-500 ml-1">(27%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                <div class="bg-gradient-to-r from-orange-400 to-orange-500 h-2 rounded-full" style="width: 27%"></div>
                            </div>
                        </div>
                        
                        <!-- Operasional -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">⚙️</span>
                                    <span class="text-sm font-medium text-slate-700">Operasional</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-slate-800">Rp 550.000</span>
                                    <span class="text-xs text-slate-500 ml-1">(16%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                <div class="bg-gradient-to-r from-pink-400 to-pink-500 h-2 rounded-full" style="width: 16%"></div>
                            </div>
                        </div>
                        
                        <!-- Lainnya -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">📊</span>
                                    <span class="text-sm font-medium text-slate-700">Lainnya</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-slate-800">Rp 200.000</span>
                                    <span class="text-xs text-slate-500 ml-1">(6%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-purple-400 to-purple-500 h-2 rounded-full" style="width: 6%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top-Right Column -->
        <div class="flex flex-col min-h-0">
            <!-- Layanan Terlaris Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <!-- Header -->
                <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="mb-0 font-bold text-slate-800">Layanan Terlaris</h6>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            September 2025
                        </span>
                    </div>
                    <p class="text-sm leading-normal text-slate-500 mb-0">
                        <i class="fa fa-chart-pie text-blue-500 mr-1"></i>
                        Komposisi layanan berdasarkan jumlah transaksi
                    </p>
                </div>

                <!-- Content -->
                <div class="flex-auto p-4" id="services-content">
                    <!-- Data Available State -->
                    <div id="services-data" class="h-full flex flex-col items-center justify-start pt-12">
                        <!-- Chart Section -->
                        <div class="flex items-center justify-center mb-10">
                            <div class="relative w-full max-w-[240px]">
                                <div class="aspect-square relative">
                                    <canvas id="chart-services" class="w-full h-full"></canvas>
                                    <!-- Center Value -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <div class="text-center">
                                            <span class="block text-xs font-medium text-slate-500 mb-1">Teratas</span>
                                            <span id="top-service-name" class="block text-sm font-bold text-slate-800">Potong Rambut</span>
                                            <span id="top-service-percentage" class="block text-xl font-bold text-blue-600">65%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Legend Section -->
                        <div id="services-legend" class="space-y-3 w-full px-4">
                            <!-- Legend items will be generated by JavaScript -->
                        </div>
                    </div>

                    <!-- Empty State (hidden by default) -->
                    <div id="services-empty" class="hidden h-full flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fa fa-chart-pie text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-700 mb-2">Belum Ada Transaksi</h3>
                        <p class="text-sm text-slate-500 max-w-xs">
                            Belum ada transaksi bulan ini. 
                            Data akan muncul setelah ada transaksi layanan.
                        </p>
                        <div class="mt-4">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">
                                <i class="fa fa-clock mr-1"></i>
                                Menunggu data transaksi
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-[7fr_5fr] gap-6 min-h-[500px] auto-rows-fr">
        <!-- Performa Cabang (Bulan Ini) Card -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-blue-500">
            <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                <div class="flex items-center justify-between mb-2">
                    <h6 class="mb-0 font-bold text-slate-800">Performa Cabang (Bulan Ini)</h6>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        September 2025
                    </span>
                </div>
                <p class="text-sm leading-normal text-slate-500 mb-0">
                    <i class="fa fa-chart-line text-blue-500 mr-1"></i>
                    <span class="font-semibold">Perbandingan performa antar cabang</span>
                </p>
            </div>
            <div class="flex-auto p-4">
                <div class="overflow-x-auto">
                <table class="w-full text-sm align-middle min-w-[600px]">
                        <thead class="align-bottom">
                            <tr class="border-b border-gray-200">
                                <th class="pb-3 pl-2 pr-4 text-left font-semibold text-slate-700">Nama Cabang</th>
                                <th class="pb-3 px-4 text-center font-semibold text-slate-700">Total Pendapatan</th>
                                <th class="pb-3 px-4 text-center font-semibold text-slate-700">Jumlah Transaksi</th>
                                <th class="pb-3 px-4 text-center font-semibold text-slate-700">Rata-rata per Transaksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <!-- Cabang Utama -->
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-3 pl-2 pr-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-blue-100 text-blue-800 mr-3">
                                            1
                                        </span>
                                        <div>
                                            <div class="font-medium text-slate-800">Cabang Utama</div>
                                            <div class="text-xs text-slate-500">Jl. Sudirman No. 123</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-800">Rp 15.800.000</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-700">425</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-green-600">Rp 37.176</span>
                                </td>
                            </tr>
                            
                            <!-- Cabang Timur -->
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-3 pl-2 pr-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-green-100 text-green-800 mr-3">
                                            2
                                        </span>
                                        <div>
                                            <div class="font-medium text-slate-800">Cabang Timur</div>
                                            <div class="text-xs text-slate-500">Jl. Ahmad Yani No. 45</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-800">Rp 9.500.000</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-700">300</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-green-600">Rp 31.667</span>
                                </td>
                            </tr>
                            
                            <!-- Cabang Barat -->
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-3 pl-2 pr-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-purple-100 text-purple-800 mr-3">
                                            3
                                        </span>
                                        <div>
                                            <div class="font-medium text-slate-800">Cabang Barat</div>
                                            <div class="text-xs text-slate-500">Jl. Gatot Subroto No. 78</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-800">Rp 7.200.000</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-700">220</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-green-600">Rp 32.727</span>
                                </td>
                            </tr>
                            
                            <!-- Cabang Selatan -->
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-3 pl-2 pr-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold bg-orange-100 text-orange-800 mr-3">
                                            4
                                        </span>
                                        <div>
                                            <div class="font-medium text-slate-800">Cabang Selatan</div>
                                            <div class="text-xs text-slate-500">Jl. Diponegoro No. 56</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-800">Rp 5.300.000</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-700">180</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-green-600">Rp 29.444</span>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="border-t-2 border-slate-200">
                            <tr class="bg-slate-50">
                                <td class="py-3 pl-2 pr-4 font-bold text-slate-800">
                                    Total Semua Cabang
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-200 text-slate-600 ml-2">
                                        4 Cabang
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">Rp 37.800.000</td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">1.125</td>
                                <td class="py-3 px-4 text-center font-bold text-green-600">Rp 33.600</td>
                            </tr>
                        </tfoot>
                </table>
                </div>
            </div>
        </div>

        <!-- Aktivitas Transaksi Terakhir Card -->
        <div class="relative h-full min-h-0 flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <!-- Header -->
            <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                <div class="flex items-center justify-between mb-2">
                    <h6 class="mb-0 font-bold text-slate-800">Aktivitas Transaksi Terakhir</h6>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Real-time
                    </span>
                </div>
                <p class="text-sm leading-normal text-slate-500 mb-0">
                    <i class="fa fa-clock text-blue-500 mr-1"></i>
                    5 transaksi terbaru dalam sistem
                </p>
            </div>

            <!-- Content -->
            <div class="flex flex-col flex-auto min-h-0 p-4" id="transaction-content">
                <!-- Data Available State -->
                <div id="transaction-data" class="flex flex-col h-full min-h-0">
                    <!-- Timeline with Scroll -->
                    <div class="flex-auto min-h-0 overflow-y-auto pr-2 space-y-5">
                        <!-- Transaction Item 1 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <span class="inline-flex items-center justify-center w-3 h-3 rounded-full bg-green-500"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-slate-800 mb-1">
                                    <span class="font-bold text-green-600">+Rp 35.000</span> - Potong Rambut + Shaving
                                </div>
                                <div class="text-xs text-slate-500">
                                    <i class="fa fa-calendar mr-1"></i>
                                    4 Sep 2025, 14:30 WIB
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transaction Item 2 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <span class="inline-flex items-center justify-center w-3 h-3 rounded-full bg-green-500"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-slate-800 mb-1">
                                    <span class="font-bold text-green-600">+Rp 25.000</span> - Potong Rambut
                                </div>
                                <div class="text-xs text-slate-500">
                                    <i class="fa fa-calendar mr-1"></i>
                                    4 Sep 2025, 13:45 WIB
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transaction Item 3 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <span class="inline-flex items-center justify-center w-3 h-3 rounded-full bg-red-500"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-slate-800 mb-1">
                                    <span class="font-bold text-red-600">-Rp 150.000</span> - Pembelian Shampo & Kondisioner
                                </div>
                                <div class="text-xs text-slate-500">
                                    <i class="fa fa-calendar mr-1"></i>
                                    4 Sep 2025, 12:20 WIB
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transaction Item 4 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <span class="inline-flex items-center justify-center w-3 h-3 rounded-full bg-green-500"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-slate-800 mb-1">
                                    <span class="font-bold text-green-600">+Rp 50.000</span> - Potong Rambut + Creambath
                                </div>
                                <div class="text-xs text-slate-500">
                                    <i class="fa fa-calendar mr-1"></i>
                                    4 Sep 2025, 11:15 WIB
                                </div>
                            </div>
                        </div>
                        
                        <!-- Transaction Item 5 -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <span class="inline-flex items-center justify-center w-3 h-3 rounded-full bg-green-500"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-slate-800 mb-1">
                                    <span class="font-bold text-green-600">+Rp 30.000</span> - Potong Rambut + Styling
                                </div>
                                <div class="text-xs text-slate-500">
                                    <i class="fa fa-calendar mr-1"></i>
                                    4 Sep 2025, 10:30 WIB
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer Action -->
                    <div class="mt-auto pt-4 border-t border-gray-100">
                        <div class="text-center">
                            <a href="#" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                <i class="fa fa-list mr-2"></i>
                                Lihat Semua Transaksi
                                <i class="fa fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Empty State (hidden by default) -->
                <div id="transaction-empty" class="hidden h-full flex flex-col items-center justify-center text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fa fa-receipt text-2xl text-gray-400"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-700 mb-2">Belum Ada Transaksi</h3>
                    <p class="text-sm text-slate-500 max-w-xs">
                        Belum ada aktivitas transaksi yang tercatat. 
                        Transaksi akan muncul di sini setelah ada aktivitas.
                    </p>
                    <div class="mt-4">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-gray-100 text-gray-600">
                            <i class="fa fa-clock mr-1"></i>
                            Menunggu transaksi baru
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
// Chart.js Line Chart Configuration for Daily Revenue
var ctx = document.getElementById("chart-lines").getContext("2d");

new Chart(ctx, {
    type: "line",
    data: {
        labels: ["29 Ags", "30 Ags", "31 Ags", "1 Sep", "2 Sep", "3 Sep", "4 Sep"],
        datasets: [{
            label: "Pendapatan Harian",
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderColor: "#22c55e",
            backgroundColor: "rgba(34, 197, 94, 0.1)",
            data: [800000, 1200000, 950000, 1350000, 1100000, 1400000, 1200000],
            fill: true
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString('id-ID');
                    }
                }
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
                    color: 'rgba(0, 0, 0, .1)'
                },
                ticks: {
                    suggestedMin: 0,
                    suggestedMax: 1600000,
                    beginAtZero: true,
                    padding: 10,
                    fontSize: 11,
                    fontColor: "#64748b",
                    lineHeight: 2,
                    color: "#64748b",
                    callback: function(value) {
                        return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                    }
                },
            },
            x: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                },
                ticks: {
                    display: true,
                    color: "#64748b",
                    padding: 10,
                    fontSize: 11,
                    lineHeight: 2
                },
            },
        },
    },
});

// Chart.js Donut Chart Configuration for Services
var ctxServices = document.getElementById("chart-services").getContext("2d");

// Sample data - replace with actual data from backend
var servicesData = [
    { label: "Potong Rambut", value: 65, color: "#3B82F6" },
    { label: "Shaving", value: 20, color: "#22C55E" },
    { label: "Creambath", value: 10, color: "#9333EA" },
    { label: "Lainnya", value: 5, color: "#F97316" }
];

// Check if there's data
var hasData = servicesData.some(item => item.value > 0);

if (hasData) {
    // Show data state
    document.getElementById('services-data').style.display = 'block';
    document.getElementById('services-empty').style.display = 'none';
    
    // Sort data by value (descending)
    servicesData.sort((a, b) => b.value - a.value);
    
    // Create chart
    var servicesChart = new Chart(ctxServices, {
        type: "doughnut",
        data: {
            labels: servicesData.map(item => item.label),
            datasets: [{
                data: servicesData.map(item => item.value),
                backgroundColor: servicesData.map(item => item.color),
                borderColor: servicesData.map(item => item.color),
                borderWidth: 0,
                cutout: "72%",
                spacing: 2,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + '%'
                        }
                    },
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.1)',
                    borderWidth: 1,
                    cornerRadius: 6,
                    displayColors: true
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true,
                duration: 1000,
                easing: 'easeOutQuart'
            },
            hover: {
                animationDuration: 200
            },
            elements: {
                arc: {
                    borderWidth: 0,
                    hoverBorderWidth: 2
                }
            }
        }
    });

    // Update center text
    function updateCenterText() {
        var topService = servicesData[0];
        document.getElementById('top-service-name').textContent = topService.label;
        document.getElementById('top-service-percentage').textContent = topService.value + '%';
    }
    
    updateCenterText();
    
    // Generate custom legend
    function generateLegend() {
        var legendContainer = document.getElementById('services-legend');
        var legendHTML = '';
        
        servicesData.forEach(function(item, index) {
            var isTop = index === 0;
            var itemClass = isTop ? 'bg-blue-50 border-l-2 border-blue-500' : 'hover:bg-gray-50';
            
            legendHTML += `
                <div class="flex items-center justify-between p-3 rounded text-sm transition-colors duration-200 ${itemClass}">
                    <div class="flex items-center">
                        <div class="w-3.5 h-3.5 rounded-full mr-3 flex-shrink-0" style="background-color: ${item.color}"></div>
                        <span class="font-medium text-slate-700">${item.label}</span>
                    </div>
                    <span class="font-bold text-slate-800">${item.value}%</span>
                </div>
            `;
        });
        
        legendContainer.innerHTML = legendHTML;
    }
    
    generateLegend();
    
} else {
    // Show empty state
    document.getElementById('services-data').style.display = 'none';
    document.getElementById('services-empty').style.display = 'flex';
}

// Function to toggle between states (for demo purposes)
function toggleServicesState() {
    var dataElement = document.getElementById('services-data');
    var emptyElement = document.getElementById('services-empty');
    
    if (dataElement.style.display === 'none') {
        dataElement.style.display = 'block';
        emptyElement.style.display = 'none';
    } else {
        dataElement.style.display = 'none';
        emptyElement.style.display = 'flex';
    }
}

// Transaction Activities State Management
// Sample transaction data - replace with actual data from backend
var transactionData = [
    { type: 'income', amount: 35000, description: 'Potong Rambut + Shaving', date: '4 Sep 2025, 14:30 WIB' },
    { type: 'income', amount: 25000, description: 'Potong Rambut', date: '4 Sep 2025, 13:45 WIB' },
    { type: 'expense', amount: 150000, description: 'Pembelian Shampo & Kondisioner', date: '4 Sep 2025, 12:20 WIB' },
    { type: 'income', amount: 50000, description: 'Potong Rambut + Creambath', date: '4 Sep 2025, 11:15 WIB' },
    { type: 'income', amount: 30000, description: 'Potong Rambut + Styling', date: '4 Sep 2025, 10:30 WIB' }
];

// Check if there's transaction data
var hasTransactionData = transactionData && transactionData.length > 0;

if (hasTransactionData) {
    // Show data state
    document.getElementById('transaction-data').style.display = 'flex';
    document.getElementById('transaction-empty').style.display = 'none';
} else {
    // Show empty state
    document.getElementById('transaction-data').style.display = 'none';
    document.getElementById('transaction-empty').style.display = 'flex';
}

// Function to toggle transaction states (for demo purposes)
function toggleTransactionState() {
    var dataElement = document.getElementById('transaction-data');
    var emptyElement = document.getElementById('transaction-empty');
    
    if (dataElement.style.display === 'none') {
        dataElement.style.display = 'flex';
        emptyElement.style.display = 'none';
    } else {
        dataElement.style.display = 'none';
        emptyElement.style.display = 'flex';
    }
}

// Function to format currency (helper function)
function formatCurrency(amount) {
    return 'Rp ' + amount.toLocaleString('id-ID');
}

// Function to dynamically update transaction list (for future API integration)
function updateTransactionList(newTransactionData) {
    transactionData = newTransactionData;
    
    if (newTransactionData && newTransactionData.length > 0) {
        // Generate HTML for transaction items
        var transactionHTML = '';
        newTransactionData.slice(0, 5).forEach(function(transaction) {
            var colorClass = transaction.type === 'income' ? 'green' : 'red';
            var sign = transaction.type === 'income' ? '+' : '-';
            
            transactionHTML += `
                <div class="flex items-start">
                    <div class="flex-shrink-0 mr-4">
                        <span class="inline-flex items-center justify-center w-3 h-3 rounded-full bg-${colorClass}-500"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-slate-800 mb-1">
                            <span class="font-bold text-${colorClass}-600">${sign}${formatCurrency(transaction.amount)}</span> - ${transaction.description}
                        </div>
                        <div class="text-xs text-slate-500">
                            <i class="fa fa-calendar mr-1"></i>
                            ${transaction.date}
                        </div>
                    </div>
                </div>
            `;
        });
        
        // Update the timeline container (now with scrollable wrapper)
        var timelineContainer = document.querySelector('#transaction-data .flex-auto.max-h-\[min\(50vh\,32rem\)\]');
        if (timelineContainer) {
            timelineContainer.innerHTML = transactionHTML;
        }
        
        // Show data state
        document.getElementById('transaction-data').style.display = 'flex';
        document.getElementById('transaction-empty').style.display = 'none';
    } else {
        // Show empty state
        document.getElementById('transaction-data').style.display = 'none';
        document.getElementById('transaction-empty').style.display = 'flex';
    }
}
</script>
@endpush
