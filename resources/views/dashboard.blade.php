@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Alerts & Notifications Panel -->
@if(count($alerts) > 0)
<div class="mb-6">
    <div class="relative flex flex-col min-w-0 break-words bg-gradient-to-r from-blue-50 to-purple-50 border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-l-blue-500">
        <div class="p-4">
            <div class="flex items-center justify-between mb-3">
                <h6 class="mb-0 font-bold text-slate-800 flex items-center">
                    <i class="fas fa-bell mr-2 text-blue-600"></i>
                    Alerts & Notifications
                </h6>
                <span class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-800">
                    {{ count($alerts) }} Alert{{ count($alerts) > 1 ? 's' : '' }}
                </span>
            </div>
            <div class="space-y-2">
                @foreach($alerts as $alert)
                <div class="flex items-center justify-between p-3 bg-white rounded-lg border-l-4 @if($alert['type'] == 'danger') border-red-500 @elseif($alert['type'] == 'warning') border-yellow-500 @elseif($alert['type'] == 'info') border-blue-500 @else border-green-500 @endif">
                    <div class="flex items-center flex-1">
                        <i class="fas {{ $alert['icon'] }} text-lg mr-3 @if($alert['type'] == 'danger') text-red-600 @elseif($alert['type'] == 'warning') text-yellow-600 @elseif($alert['type'] == 'info') text-blue-600 @else text-green-600 @endif"></i>
                        <span class="text-sm text-slate-700">{{ $alert['message'] }}</span>
                    </div>
                    <a href="{{ $alert['action_url'] }}" class="ml-4 px-3 py-1 text-xs font-semibold rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 text-white hover:scale-105 transition-all">
                        {{ $alert['action_text'] }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- Quick Actions Dropdown -->
<div class="mb-6">
    <div class="relative inline-block">
        <button id="quickActionsBtn" type="button" class="">
            <i class="fas fa-bolt mr-2 text-lg"></i>
            <span>Quick Actions</span>
            <i class="fas fa-chevron-down ml-2 text-sm transition-transform duration-300" id="quickActionsChevron"></i>
        </button>
        
        <!-- Dropdown Menu -->
        <div id="quickActionsMenu" class="hidden absolute left-0 mt-2 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
            <div class="p-2">
                <div class="px-3 py-2 border-b border-gray-100">
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Pilih Aksi Cepat</p>
                </div>
                
                <a href="{{ route('kelola-transaksi.create') }}" class="flex items-center px-3 py-3 mt-1 rounded-lg hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 transition-all duration-200 group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 group-hover:scale-110 transition-transform duration-200">
                        <i class="fas fa-plus-circle text-white text-lg"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-semibold text-slate-700 group-hover:text-green-600">Transaksi Baru</div>
                        <div class="text-xs text-slate-500">Buat transaksi penjualan baru</div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-green-500 text-sm"></i>
                </a>
                
                <a href="{{ route('kelola-pengeluaran.create') }}" class="flex items-center px-3 py-3 mt-1 rounded-lg hover:bg-gradient-to-r hover:from-orange-50 hover:to-amber-50 transition-all duration-200 group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-tl from-red-600 to-yellow-400 group-hover:scale-110 transition-transform duration-200">
                        <i class="fas fa-wallet text-white text-lg"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-semibold text-slate-700 group-hover:text-orange-600">Catat Pengeluaran</div>
                        <div class="text-xs text-slate-500">Input pengeluaran operasional</div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-orange-500 text-sm"></i>
                </a>
                
                <a href="{{ route('kelola-kapster.create') }}" class="flex items-center px-3 py-3 mt-1 rounded-lg hover:bg-gradient-to-r hover:from-blue-50 hover:to-cyan-50 transition-all duration-200 group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 group-hover:scale-110 transition-transform duration-200">
                        <i class="fas fa-user-plus text-white text-lg"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-semibold text-slate-700 group-hover:text-blue-600">Tambah Kapster</div>
                        <div class="text-xs text-slate-500">Daftarkan kapster baru</div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-blue-500 text-sm"></i>
                </a>
                
                <a href="{{ route('kelola-inventaris.create') }}" class="flex items-center px-3 py-3 mt-1 rounded-lg hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 transition-all duration-200 group">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-tl from-green-600 to-yellow-400 group-hover:scale-110 transition-transform duration-200">
                        <i class="fas fa-box text-white text-lg"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="text-sm font-semibold text-slate-700 group-hover:text-purple-600">Update Stok</div>
                        <div class="text-xs text-slate-500">Kelola inventaris barang</div>
                    </div>
                    <i class="fas fa-chevron-right text-slate-300 group-hover:text-purple-500 text-sm"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
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
                                Rp {{ number_format($statistics['pendapatan_hari_ini']['value'], 0, ',', '.') }}
                                <span class="text-sm leading-normal font-semibold {{ $statistics['pendapatan_hari_ini']['is_increase'] ? 'text-lime-500' : 'text-red-500' }} ml-2">
                                    <i class="fas fa-arrow-{{ $statistics['pendapatan_hari_ini']['is_increase'] ? 'up' : 'down' }}"></i>
                                    {{ abs($statistics['pendapatan_hari_ini']['percentage']) }}%
                                </span>
                            </h5>
                            <p class="text-xs text-slate-500 mt-1">vs kemarin: Rp {{ number_format($statistics['pendapatan_hari_ini']['vs_yesterday'], 0, ',', '.') }}</p>
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
                                {{ $statistics['transaksi_hari_ini']['value'] }} transaksi
                                <span class="text-sm leading-normal font-semibold {{ $statistics['transaksi_hari_ini']['is_increase'] ? 'text-lime-500' : 'text-red-500' }} ml-2">
                                    <i class="fas fa-arrow-{{ $statistics['transaksi_hari_ini']['is_increase'] ? 'up' : 'down' }}"></i>
                                    {{ abs($statistics['transaksi_hari_ini']['percentage']) }}%
                                </span>
                            </h5>
                            <p class="text-xs text-slate-500 mt-1">vs kemarin: {{ $statistics['transaksi_hari_ini']['vs_yesterday'] }} transaksi</p>
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
                                Rp {{ number_format($statistics['pendapatan_bulanan']['value'], 0, ',', '.') }}
                                <span class="text-sm leading-normal font-semibold {{ $statistics['pendapatan_bulanan']['is_increase'] ? 'text-lime-500' : 'text-red-500' }} ml-2">
                                    <i class="fas fa-arrow-{{ $statistics['pendapatan_bulanan']['is_increase'] ? 'up' : 'down' }}"></i>
                                    {{ abs($statistics['pendapatan_bulanan']['percentage']) }}%
                                </span>
                            </h5>
                            <p class="text-xs text-slate-500 mt-1">vs bulan lalu</p>
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
                                {{ $statistics['transaksi_bulanan']['value'] }} transaksi
                                <span class="text-sm leading-normal font-semibold {{ $statistics['transaksi_bulanan']['is_increase'] ? 'text-lime-500' : 'text-red-500' }} ml-2">
                                    <i class="fas fa-arrow-{{ $statistics['transaksi_bulanan']['is_increase'] ? 'up' : 'down' }}"></i>
                                    {{ abs($statistics['transaksi_bulanan']['percentage']) }}%
                                </span>
                            </h5>
                            <p class="text-xs text-slate-500 mt-1">vs bulan lalu</p>
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
        <!-- Top-Left Column - Financial Overview -->
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
                        <i class="fa fa-chart-line text-green-500 mr-1"></i>
                        <span class="font-semibold">Trend pendapatan minggu ini</span>
                    </p>
                </div>
                <div class="flex-auto p-4">
                    <div class="relative">
                        <canvas id="chart-lines" class="chart-canvas" height="170" style="display: block; box-sizing: border-box; height: 170px; width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Grid 2x2 Mini Cards - Financial Summary -->
            <div class="grid grid-cols-2 gap-4">
                <!-- Target Bulanan (Compact) -->
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-l-purple-500">
                    <div class="p-4">
                        <h6 class="font-bold text-slate-800 mb-3 flex items-center text-sm">
                            <i class="fas fa-bullseye text-purple-600 mr-2"></i>
                            Target Bulanan
                        </h6>
                        <div class="mb-3">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-xs font-medium text-slate-600">Tercapai</span>
                                <span class="text-xs font-bold text-green-600">Rp {{ number_format($targetAchievement['tercapai'], 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-medium text-slate-600">Target</span>
                                <span class="text-xs font-bold text-slate-800">Rp {{ number_format($targetAchievement['target'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="relative mb-3">
                            <div class="w-full bg-gray-200 rounded-full h-5">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-5 rounded-full flex items-center justify-center text-xs font-bold text-white" style="width: {{ min($targetAchievement['percentage'], 100) }}%">
                                    {{ number_format($targetAchievement['percentage'], 1) }}%
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-2 rounded-lg {{ $targetAchievement['status'] == 'achieved' ? 'bg-green-50' : ($targetAchievement['status'] == 'on_track' ? 'bg-blue-50' : 'bg-orange-50') }}">
                            <div class="text-xs text-slate-600">
                                <span class="font-bold text-orange-600">Rp {{ number_format($targetAchievement['perlu_per_hari'], 0, ',', '.') }}/hari</span> 
                                untuk {{ $targetAchievement['sisa_hari'] }} hari
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Kapster Hari Ini (Compact) -->
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-l-yellow-500">
                    <div class="p-4">
                        <h6 class="font-bold text-slate-800 mb-3 flex items-center text-sm">
                            <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                            Top Kapster Hari Ini
                        </h6>
                        
                        @if($topKapster['has_data'])
                        <div class="space-y-2">
                            @foreach($topKapster['top_3'] as $index => $kapster)
                            <div class="flex items-center justify-between p-2 rounded-lg {{ $index == 0 ? 'bg-gradient-to-r from-yellow-50 to-yellow-100' : 'bg-gray-50' }}">
                                <div class="flex items-center">
                                    @if($index == 0)
                                        <span class="text-lg mr-2">🥇</span>
                                    @elseif($index == 1)
                                        <span class="text-lg mr-2">🥈</span>
                                    @else
                                        <span class="text-lg mr-2">🥉</span>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-xs text-slate-800">{{ $kapster['nama'] }}</div>
                                        <div class="text-xs text-slate-500">{{ $kapster['cabang'] }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-bold text-green-600">{{ $kapster['total_transaksi'] }}x</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($topKapster['tidak_aktif']->count() > 0)
                        <div class="mt-3 p-2 bg-orange-50 border-l-2 border-orange-500 rounded">
                            <p class="text-xs text-orange-700">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                {{ $topKapster['tidak_aktif']->count() }} kapster belum aktif
                            </p>
                        </div>
                        @endif
                        @else
                        <div class="text-center py-4">
                            <div class="text-3xl mb-2">😴</div>
                            <p class="text-xs text-slate-500">Belum ada transaksi</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Cash Flow Hari Ini (Compact) -->
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-l-blue-500">
                    <div class="p-4">
                        <h6 class="font-bold text-slate-800 mb-3 flex items-center text-sm">
                            <i class="fas fa-coins text-blue-600 mr-2"></i>
                            Cash Flow Hari Ini
                        </h6>
                        
                        <div class="space-y-2 mb-3">
                            <div class="flex items-center justify-between p-2 bg-green-50 rounded-lg">
                                <span class="text-xs font-medium text-slate-700">Kas Masuk</span>
                                <span class="text-xs font-bold text-green-600">Rp {{ number_format($cashFlow['kas_masuk'], 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-2 bg-red-50 rounded-lg">
                                <span class="text-xs font-medium text-slate-700">Kas Keluar</span>
                                <span class="text-xs font-bold text-red-600">Rp {{ number_format($cashFlow['kas_keluar'], 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-2 bg-{{ $cashFlow['is_positive'] ? 'blue' : 'orange' }}-50 rounded-lg border-2 border-{{ $cashFlow['is_positive'] ? 'blue' : 'orange' }}-300">
                                <span class="text-xs font-bold text-slate-700">Net Flow</span>
                                <span class="text-sm font-bold text-{{ $cashFlow['is_positive'] ? 'blue' : 'orange' }}-600">
                                    Rp {{ number_format($cashFlow['net_flow'], 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        
                        @if($cashFlow['metode_pembayaran']->count() > 0)
                        <div class="pt-2 border-t">
                            <p class="text-xs font-semibold text-slate-600 mb-1">Metode:</p>
                            <div class="flex gap-2 flex-wrap">
                                @foreach($cashFlow['metode_pembayaran'] as $metode)
                                <span class="text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded">
                                    @if($metode['metode'] == 'cash') 💵
                                    @elseif($metode['metode'] == 'transfer') 💳
                                    @elseif($metode['metode'] == 'e-wallet') 📱
                                    @else 💰
                                    @endif
                                    {{ $metode['percentage'] }}%
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Pengeluaran Bulan Ini (Compact) -->
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-l-red-500">
                    <div class="p-4">
                        <h6 class="font-bold text-slate-800 mb-3 flex items-center text-sm">
                            <i class="fas fa-wallet text-red-600 mr-2"></i>
                            Pengeluaran Bulan Ini
                        </h6>
                        
                        <div class="mb-3">
                            <h5 class="mb-1 font-bold text-xl text-red-600">
                                Rp {{ number_format($pengeluaran['total'], 0, ',', '.') }}
                            </h5>
                            <p class="text-xs text-slate-500 flex items-center">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium {{ $pengeluaran['is_increase'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    <i class="fas fa-arrow-{{ $pengeluaran['is_increase'] ? 'up' : 'down' }} mr-1"></i>
                                    {{ abs($pengeluaran['percentage']) }}%
                                </span>
                                <span class="ml-1">vs bulan lalu</span>
                            </p>
                        </div>
                        
                        @if($pengeluaran['breakdown']->count() > 0)
                        <div class="space-y-2">
                            @foreach($pengeluaran['breakdown']->take(3) as $index => $item)
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-medium text-slate-700">{{ Str::limit($item['nama'], 15) }}</span>
                                    <span class="text-xs font-bold text-slate-800">{{ $item['percentage'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-1.5">
                                    <div class="h-1.5 rounded-full" 
                                         style="width: {{ $item['percentage'] }}%; background: linear-gradient(to right, 
                                         @if($index == 0) #f87171, #ef4444
                                         @elseif($index == 1) #fb923c, #f97316
                                         @else #f472b6, #ec4899
                                         @endif);">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-xs text-slate-500 text-center py-2">Belum ada data</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Top-Right Column - Services & Activity -->
        <div class="flex flex-col gap-6 min-h-0">
            <!-- Layanan Terlaris Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border" style="flex: 1;">
                <!-- Header -->
                <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="mb-0 font-bold text-slate-800">Layanan Terlaris</h6>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ date('F Y') }}
                        </span>
                    </div>
                    <p class="text-sm leading-normal text-slate-500 mb-0">
                        <i class="fa fa-chart-pie text-blue-500 mr-1"></i>
                        Komposisi layanan berdasarkan jumlah transaksi
                    </p>
                </div>

                <!-- Content -->
                <div class="flex-auto p-4" id="services-content">
                    @if($layananTerlaris['has_data'])
                    <!-- Data Available State -->
                    <div id="services-data" class="h-full flex flex-col items-center justify-start pt-6">
                        <!-- Chart Section -->
                        <div class="flex items-center justify-center mb-6">
                            <div class="relative w-full max-w-[200px]">
                                <div class="aspect-square relative">
                                    <canvas id="chart-services" class="w-full h-full"></canvas>
                                    <!-- Center Value -->
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <div class="text-center">
                                            <span class="block text-xs font-medium text-slate-500 mb-1">Teratas</span>
                                            <span id="top-service-name" class="block text-sm font-bold text-slate-800">{{ $layananTerlaris['top_service']['label'] ?? '-' }}</span>
                                            <span id="top-service-percentage" class="block text-xl font-bold text-blue-600">{{ $layananTerlaris['top_service']['value'] ?? 0 }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Legend Section -->
                        <div id="services-legend" class="space-y-2 w-full px-2">
                            @foreach($layananTerlaris['data'] as $index => $layanan)
                            <div class="flex items-center justify-between p-2 rounded text-sm transition-colors duration-200 {{ $index == 0 ? 'bg-blue-50 border-l-2 border-blue-500' : 'hover:bg-gray-50' }}">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full mr-2 flex-shrink-0" style="background-color: {{ $layanan['color'] }}"></div>
                                    <span class="font-medium text-slate-700 text-xs">{{ $layanan['label'] }}</span>
                                </div>
                                <span class="font-bold text-slate-800 text-xs">{{ $layanan['value'] }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="h-full flex flex-col items-center justify-center text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fa fa-chart-pie text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-700 mb-2">Belum Ada Transaksi</h3>
                        <p class="text-sm text-slate-500 max-w-xs">
                            Belum ada transaksi bulan ini. 
                            Data akan muncul setelah ada transaksi layanan.
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Aktivitas Transaksi Terakhir Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border" style="flex: 1;">
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
                        5 aktivitas terbaru dalam sistem
                    </p>
                </div>

                <!-- Content -->
                <div class="flex flex-col flex-auto min-h-0 p-4" id="transaction-content">
                    @if($transaksiTerakhir['has_data'])
                    <!-- Data Available State -->
                    <div class="flex flex-col h-full min-h-0">
                        <!-- Timeline with Scroll -->
                        <div class="flex-auto min-h-0 overflow-y-auto pr-2 space-y-4">
                            @foreach($transaksiTerakhir['data'] as $item)
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-3">
                                    <span class="inline-flex items-center justify-center w-2.5 h-2.5 rounded-full {{ $item['type'] == 'income' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-medium text-slate-800 mb-1">
                                        <span class="font-bold {{ $item['type'] == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $item['type'] == 'income' ? '+' : '-' }}Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                        </span> - {{ $item['description'] }}
                                    </div>
                                    <div class="text-xs text-slate-500">
                                        <i class="fa fa-calendar mr-1"></i>
                                        {{ $item['date_relative'] }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Footer Action -->
                        <div class="mt-auto pt-3 border-t border-gray-100">
                            <div class="text-center">
                                <a href="{{ route('kelola-transaksi.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                    <i class="fa fa-list mr-2"></i>
                                    Lihat Semua Transaksi
                                    <i class="fa fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="h-full flex flex-col items-center justify-center text-center py-6">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fa fa-receipt text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-700 mb-2">Belum Ada Transaksi</h3>
                        <p class="text-sm text-slate-500 max-w-xs">
                            Belum ada aktivitas transaksi yang tercatat. 
                            Transaksi akan muncul di sini setelah ada aktivitas.
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row - Branch Performance -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Performa Cabang (Bulan Ini) Card - Full Width -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border h-full border-l-4 border-l-blue-500">
            <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                <div class="flex items-center justify-between mb-2">
                    <h6 class="mb-0 font-bold text-slate-800">Performa Cabang (Bulan Ini)</h6>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ date('F Y') }}
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
                            @foreach($performaCabang as $index => $cabang)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="py-3 pl-2 pr-4">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full text-xs font-bold {{ $index == 0 ? 'bg-blue-100 text-blue-800' : ($index == 1 ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }} mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        <div>
                                            <div class="font-medium text-slate-800">{{ $cabang['nama_cabang'] }}</div>
                                            <div class="text-xs text-slate-500">{{ $cabang['alamat'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-800">Rp {{ number_format($cabang['pendapatan'], 0, ',', '.') }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-slate-700">{{ $cabang['jumlah_transaksi'] }}</span>
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="font-medium text-green-600">Rp {{ number_format($cabang['rata_rata'], 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="border-t-2 border-slate-200">
                            <tr class="bg-slate-50">
                                <td class="py-3 pl-2 pr-4 font-bold text-slate-800">
                                    Total Semua Cabang
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-200 text-slate-600 ml-2">
                                        {{ $performaCabang->count() }} Cabang
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">Rp {{ number_format($performaCabang->sum('pendapatan'), 0, ',', '.') }}</td>
                                <td class="py-3 px-4 text-center font-bold text-slate-800">{{ $performaCabang->sum('jumlah_transaksi') }}</td>
                                <td class="py-3 px-4 text-center font-bold text-green-600">
                                    Rp {{ $performaCabang->sum('jumlah_transaksi') > 0 ? number_format($performaCabang->sum('pendapatan') / $performaCabang->sum('jumlah_transaksi'), 0, ',', '.') : 0 }}
                                </td>
                            </tr>
                        </tfoot>
                </table>
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
// Chart.js Horizontal Bar Chart Configuration for Daily Revenue
var ctx = document.getElementById("chart-lines").getContext("2d");

// Data from backend
var grafikData = @json($grafikPendapatan);

// Find max value and current day index
var maxValue = Math.max(...grafikData.data);
var today = new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });

// Create dynamic colors - highlight max and today
var backgroundColors = grafikData.data.map((value, index) => {
    if (value === maxValue && value > 0) {
        return 'rgba(34, 197, 94, 1)'; // Brightest for highest
    } else if (grafikData.labels[index] === today) {
        return 'rgba(59, 130, 246, 0.8)'; // Blue for today
    } else if (value === 0) {
        return 'rgba(203, 213, 225, 0.5)'; // Gray for no data
    } else {
        return 'rgba(34, 197, 94, 0.7)'; // Normal green
    }
});

var borderColors = grafikData.data.map((value, index) => {
    if (value === maxValue && value > 0) {
        return '#16a34a';
    } else if (grafikData.labels[index] === today) {
        return '#2563eb';
    } else if (value === 0) {
        return '#cbd5e1';
    } else {
        return '#22c55e';
    }
});

new Chart(ctx, {
    type: "bar",
    data: {
        labels: grafikData.labels,
        datasets: [{
            label: "Pendapatan Harian",
            data: grafikData.data,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
            borderWidth: 2,
            borderRadius: 8,
            barThickness: 'flex',
            maxBarThickness: 35,
            minBarLength: 2
        }],
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: {
                right: 80, // Space for labels
                left: 10,
                top: 5,
                bottom: 5
            }
        },
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                enabled: true,
                callbacks: {
                    title: function(context) {
                        return context[0].label;
                    },
                    label: function(context) {
                        var value = context.parsed.x;
                        if (value === 0) {
                            return 'Tidak ada transaksi';
                        }
                        
                        // Calculate percentage change
                        var index = context.dataIndex;
                        if (index > 0 && grafikData.data[index - 1] > 0) {
                            var prevValue = grafikData.data[index - 1];
                            var change = ((value - prevValue) / prevValue * 100).toFixed(1);
                            var changeText = change >= 0 ? '↑ +' + change + '%' : '↓ ' + change + '%';
                            return [
                                'Pendapatan: Rp ' + value.toLocaleString('id-ID'),
                                'Perubahan: ' + changeText
                            ];
                        }
                        return 'Pendapatan: Rp ' + value.toLocaleString('id-ID');
                    },
                    footer: function(context) {
                        var value = context[0].parsed.x;
                        if (value === maxValue && value > 0) {
                            return '🏆 Pendapatan Tertinggi';
                        } else if (context[0].label === today) {
                            return '📅 Hari Ini';
                        }
                        return '';
                    }
                },
                backgroundColor: 'rgba(0, 0, 0, 0.9)',
                titleColor: 'white',
                bodyColor: 'white',
                footerColor: '#fbbf24',
                borderColor: 'rgba(34, 197, 94, 0.5)',
                borderWidth: 1,
                cornerRadius: 8,
                padding: 12,
                displayColors: true,
                boxPadding: 6
            },
            datalabels: {
                display: false
            }
        },
        interaction: {
            intersect: false,
            mode: 'nearest',
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    display: true,
                    drawOnChartArea: true,
                    drawTicks: false,
                    borderDash: [5, 5],
                    color: 'rgba(0, 0, 0, .08)'
                },
                ticks: {
                    padding: 10,
                    color: "#64748b",
                    font: {
                        size: 11
                    },
                    callback: function(value) {
                        if (value === 0) return 'Rp 0';
                        if (value >= 1000000) {
                            return 'Rp ' + (value / 1000000).toFixed(1) + 'jt';
                        }
                        return 'Rp ' + (value / 1000).toFixed(0) + 'k';
                    }
                },
            },
            y: {
                grid: {
                    drawBorder: false,
                    display: false,
                    drawOnChartArea: false,
                    drawTicks: false,
                },
                ticks: {
                    display: true,
                    color: function(context) {
                        var label = context.tick.label;
                        if (label === today) {
                            return '#2563eb'; // Blue for today
                        }
                        return '#64748b';
                    },
                    padding: 12,
                    font: function(context) {
                        var label = context.tick.label;
                        if (label === today) {
                            return {
                                size: 12,
                                weight: 'bold'
                            };
                        }
                        return {
                            size: 11,
                            weight: 'normal'
                        };
                    },
                    callback: function(value, index) {
                        var label = this.getLabelForValue(value);
                        var dataValue = grafikData.data[index];
                        
                        // Add indicator for today
                        if (label === today) {
                            return '📍 ' + label;
                        }
                        
                        // Add indicator for highest
                        if (dataValue === maxValue && dataValue > 0) {
                            return '⭐ ' + label;
                        }
                        
                        // Add indicator for no data
                        if (dataValue === 0) {
                            return '○ ' + label;
                        }
                        
                        return label;
                    }
                },
            },
        },
        animation: {
            duration: 1000,
            easing: 'easeInOutQuart'
        }
    },
    plugins: [{
        afterDatasetDraw: function(chart) {
            var ctx = chart.ctx;
            chart.data.datasets.forEach(function(dataset, i) {
                var meta = chart.getDatasetMeta(i);
                if (!meta.hidden) {
                    meta.data.forEach(function(element, index) {
                        var dataValue = dataset.data[index];
                        if (dataValue > 0) {
                            ctx.fillStyle = '#1e293b';
                            ctx.font = 'bold 11px sans-serif';
                            ctx.textAlign = 'left';
                            ctx.textBaseline = 'middle';
                            
                            var position = element.tooltipPosition();
                            var label = 'Rp ' + (dataValue / 1000000).toFixed(2) + 'jt';
                            
                            // Draw label at the end of bar
                            ctx.fillText(label, position.x + 8, position.y);
                        }
                    });
                }
            });
        }
    }]
});

// Chart.js Donut Chart Configuration for Services
@if($layananTerlaris['has_data'])
var ctxServices = document.getElementById("chart-services").getContext("2d");

// Data from backend
var servicesData = @json($layananTerlaris['data']);

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
@endif

// Chart.js Bar Chart Configuration for Daily Pattern
@if($dailyPattern['has_data'])
var ctxDaily = document.getElementById("chart-daily-pattern").getContext("2d");

// Data from backend
var dailyData = @json($dailyPattern);

new Chart(ctxDaily, {
    type: "bar",
    data: {
        labels: dailyData.labels,
        datasets: [{
            label: "Transaksi",
            data: dailyData.transaksi,
            backgroundColor: "rgba(139, 92, 246, 0.8)",
            borderColor: "#8b5cf6",
            borderWidth: 2,
            borderRadius: 6,
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
                        var label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += context.parsed.y + ' transaksi';
                        return label;
                    },
                    afterLabel: function(context) {
                        var pendapatan = dailyData.pendapatan[context.dataIndex];
                        return 'Pendapatan: Rp ' + pendapatan.toLocaleString('id-ID');
                    }
                },
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: 'white',
                bodyColor: 'white',
                borderColor: 'rgba(139, 92, 246, 0.5)',
                borderWidth: 1,
                cornerRadius: 6,
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    drawBorder: false,
                    display: true,
                    color: 'rgba(0, 0, 0, .1)'
                },
                ticks: {
                    color: "#64748b",
                    padding: 10,
                    stepSize: 5
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: "#64748b",
                    padding: 10
                }
            }
        }
    }
});
@endif

</script>

<script>
// Quick Actions Dropdown Toggle
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Loaded - Quick Actions Script Running');
    
    const quickActionsBtn = document.getElementById('quickActionsBtn');
    const quickActionsMenu = document.getElementById('quickActionsMenu');
    const quickActionsChevron = document.getElementById('quickActionsChevron');
    
    console.log('Button:', quickActionsBtn);
    console.log('Menu:', quickActionsMenu);
    console.log('Chevron:', quickActionsChevron);
    
    if (quickActionsBtn && quickActionsMenu && quickActionsChevron) {
        console.log('All elements found! Setting up event listeners...');
        
        // Toggle dropdown
        quickActionsBtn.addEventListener('click', function(e) {
            console.log('Button clicked!');
            e.preventDefault();
            e.stopPropagation();
            quickActionsMenu.classList.toggle('hidden');
            quickActionsChevron.classList.toggle('rotate-180');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!quickActionsBtn.contains(e.target) && !quickActionsMenu.contains(e.target)) {
                quickActionsMenu.classList.add('hidden');
                quickActionsChevron.classList.remove('rotate-180');
            }
        });
        
        // Close dropdown when pressing Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                quickActionsMenu.classList.add('hidden');
                quickActionsChevron.classList.remove('rotate-180');
            }
        });
    } else {
        console.error('Some elements not found!');
    }
});
</script>
@endpush
