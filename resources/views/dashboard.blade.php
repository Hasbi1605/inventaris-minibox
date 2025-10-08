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

<!-- Quick Actions -->
<div class="mb-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('kelola-transaksi.create') }}" class="flex items-center justify-left p-4 bg-gradient-to-tl from-green-600 to-lime-400 text-white rounded-xl shadow-md hover:scale-105 transition-all">
            <i class="fas fa-plus-circle text-2xl mr-3"></i>
            <div>
                <div class="font-bold text-sm">Transaksi Baru</div>
                <div class="text-xs opacity-90">Buat transaksi</div>
            </div>
        </a>
        <a href="{{ route('kelola-pengeluaran.create') }}" class="flex items-center justify-left p-4 bg-gradient-to-tl from-green-600 to-lime-400 text-white rounded-xl shadow-md hover:scale-105 transition-all">
            <i class="fas fa-wallet text-2xl mr-3"></i>
            <div>
                <div class="font-bold text-sm">Catat Pengeluaran</div>
                <div class="text-xs opacity-90">Input pengeluaran</div>
            </div>
        </a>
        <a href="{{ route('kelola-kapster.create') }}" class="flex items-center justify-left p-4 bg-gradient-to-tl from-green-600 to-lime-400 text-white rounded-xl shadow-md hover:scale-105 transition-all">
            <i class="fas fa-user-plus text-2xl mr-3"></i>
            <div>
                <div class="font-bold text-sm">Tambah Kapster</div>
                <div class="text-xs opacity-90">Kapster baru</div>
            </div>
        </a>
        <a href="{{ route('kelola-inventaris.create') }}" class="flex items-center justify-left p-4 bg-gradient-to-tl from-green-600 to-lime-400 text-white rounded-xl shadow-md hover:scale-105 transition-all">
            <i class="fas fa-box text-2xl mr-3"></i>
            <div>
                <div class="font-bold text-sm">Update Stok</div>
                <div class="text-xs opacity-90">Kelola inventaris</div>
            </div>
        </a>
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

<!-- Row 2: Target Achievement & Top Kapster & Cash Flow -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Target Achievement -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6">
            <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                <i class="fas fa-bullseye text-purple-600 mr-2"></i>
                Target Bulanan
            </h6>
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-slate-600">Target</span>
                    <span class="text-sm font-bold text-slate-800">Rp {{ number_format($targetAchievement['target'], 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-slate-600">Tercapai</span>
                    <span class="text-sm font-bold text-green-600">Rp {{ number_format($targetAchievement['tercapai'], 0, ',', '.') }}</span>
                </div>
            </div>
            
            <div class="relative">
                <div class="w-full bg-gray-200 rounded-full h-6 mb-2">
                    <div class="bg-gradient-to-r from-green-400 to-green-600 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white" style="width: {{ min($targetAchievement['percentage'], 100) }}%">
                        {{ number_format($targetAchievement['percentage'], 1) }}%
                    </div>
                </div>
            </div>
            
            <div class="mt-4 p-3 rounded-lg {{ $targetAchievement['status'] == 'achieved' ? 'bg-green-50' : ($targetAchievement['status'] == 'on_track' ? 'bg-blue-50' : 'bg-orange-50') }}">
                <div class="text-xs text-slate-600">Sisa: <span class="font-bold">Rp {{ number_format($targetAchievement['sisa'], 0, ',', '.') }}</span></div>
                <div class="text-xs text-slate-600">{{ $targetAchievement['sisa_hari'] }} hari lagi</div>
                <div class="text-xs text-slate-600 mt-1">Perlu: <span class="font-bold text-orange-600">Rp {{ number_format($targetAchievement['perlu_per_hari'], 0, ',', '.') }}/hari</span></div>
            </div>
        </div>
    </div>

    <!-- Top Kapster Hari Ini -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6">
            <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                Top Kapster Hari Ini
            </h6>
            
            @if($topKapster['has_data'])
            <div class="space-y-3">
                @foreach($topKapster['top_3'] as $index => $kapster)
                <div class="flex items-center justify-between p-3 rounded-lg {{ $index == 0 ? 'bg-gradient-to-r from-yellow-50 to-yellow-100 border border-yellow-200' : 'bg-gray-50' }}">
                    <div class="flex items-center">
                        @if($index == 0)
                            <span class="text-2xl mr-3">🥇</span>
                        @elseif($index == 1)
                            <span class="text-2xl mr-3">🥈</span>
                        @elseif($index == 2)
                            <span class="text-2xl mr-3">🥉</span>
                        @endif
                        <div>
                            <div class="font-semibold text-sm text-slate-800">{{ $kapster['nama'] }}</div>
                            <div class="text-xs text-slate-500">{{ $kapster['cabang'] }}</div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-bold text-green-600">{{ $kapster['total_transaksi'] }} transaksi</div>
                        <div class="text-xs text-slate-600">Rp {{ number_format($kapster['total_pendapatan'], 0, ',', '.') }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            @if($topKapster['tidak_aktif']->count() > 0)
            <div class="mt-4 p-3 bg-orange-50 border-l-4 border-orange-500 rounded">
                <p class="text-xs text-orange-700">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    <span class="font-semibold">{{ $topKapster['tidak_aktif']->count() }} kapster</span> belum ada transaksi hari ini
                </p>
            </div>
            @endif
            @else
            <div class="text-center py-6">
                <div class="text-4xl mb-2">😴</div>
                <p class="text-sm text-slate-500">Belum ada transaksi hari ini</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Cash Flow Summary -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6">
            <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                <i class="fas fa-coins text-blue-600 mr-2"></i>
                Cash Flow Hari Ini
            </h6>
            
            <div class="space-y-3 mb-4">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex items-center">
                        <i class="fas fa-arrow-down text-green-600 text-xl mr-3"></i>
                        <span class="text-sm font-medium text-slate-700">Kas Masuk</span>
                    </div>
                    <span class="text-sm font-bold text-green-600">Rp {{ number_format($cashFlow['kas_masuk'], 0, ',', '.') }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-200">
                    <div class="flex items-center">
                        <i class="fas fa-arrow-up text-red-600 text-xl mr-3"></i>
                        <span class="text-sm font-medium text-slate-700">Kas Keluar</span>
                    </div>
                    <span class="text-sm font-bold text-red-600">Rp {{ number_format($cashFlow['kas_keluar'], 0, ',', '.') }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-{{ $cashFlow['is_positive'] ? 'blue' : 'orange' }}-50 rounded-lg border-2 border-{{ $cashFlow['is_positive'] ? 'blue' : 'orange' }}-300">
                    <div class="flex items-center">
                        <i class="fas fa-balance-scale text-{{ $cashFlow['is_positive'] ? 'blue' : 'orange' }}-600 text-xl mr-3"></i>
                        <span class="text-sm font-bold text-slate-700">Net Flow</span>
                    </div>
                    <span class="text-base font-bold text-{{ $cashFlow['is_positive'] ? 'blue' : 'orange' }}-600">
                        Rp {{ number_format($cashFlow['net_flow'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
            
            @if($cashFlow['metode_pembayaran']->count() > 0)
            <div class="border-t pt-3">
                <p class="text-xs font-semibold text-slate-600 mb-2">Metode Pembayaran:</p>
                <div class="space-y-2">
                    @foreach($cashFlow['metode_pembayaran'] as $metode)
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-slate-600 capitalize">
                            @if($metode['metode'] == 'cash') 💵
                            @elseif($metode['metode'] == 'transfer') 💳
                            @elseif($metode['metode'] == 'e-wallet') 📱
                            @else 💰
                            @endif
                            {{ $metode['metode'] }}
                        </span>
                        <span class="text-xs font-bold text-slate-700">{{ $metode['percentage'] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
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
            
            <!-- Pengeluaran Bulan Ini Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-l-red-500">
                <div class="p-4 pb-3 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="mb-0 font-bold text-slate-800">Pengeluaran Bulan Ini</h6>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $pengeluaran['is_increase'] ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                            <i class="fas fa-arrow-{{ $pengeluaran['is_increase'] ? 'up' : 'down' }} mr-1"></i>
                            {{ abs($pengeluaran['percentage']) }}%
                        </span>
                    </div>
                    <p class="text-sm leading-normal text-slate-500 mb-0">
                        <i class="fa fa-info-circle text-slate-400 mr-1"></i>
                        <span class="font-semibold">{{ $pengeluaran['is_increase'] ? 'Naik' : 'Turun' }} {{ abs($pengeluaran['percentage']) }}% dibanding bulan lalu</span>
                    </p>
                </div>
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3 mb-6">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <h5 class="mb-1 font-bold text-2xl text-red-600">
                                    Rp {{ number_format($pengeluaran['total'], 0, ',', '.') }}
                                </h5>
                                <p class="mt-1 text-xs text-slate-500">
                                    <i class="fa fa-info-circle text-slate-400 mr-1"></i>
                                    Total pengeluaran bulan {{ date('F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Breakdown pengeluaran -->
                    @if($pengeluaran['breakdown']->count() > 0)
                    <div class="space-y-3">
                        @foreach($pengeluaran['breakdown']->take(4) as $index => $item)
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center">
                                    <span class="text-lg mr-3">
                                        @if($index == 0) 👔
                                        @elseif($index == 1) 📦
                                        @elseif($index == 2) ⚙️
                                        @else 📊
                                        @endif
                                    </span>
                                    <span class="text-sm font-medium text-slate-700">{{ $item['nama'] }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-slate-800">Rp {{ number_format($item['total'], 0, ',', '.') }}</span>
                                    <span class="text-xs text-slate-500 ml-1">({{ $item['percentage'] }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                <div class="h-2 rounded-full" 
                                     style="width: {{ $item['percentage'] }}%; background: linear-gradient(to right, 
                                     @if($index == 0) #f87171, #ef4444
                                     @elseif($index == 1) #fb923c, #f97316
                                     @elseif($index == 2) #f472b6, #ec4899
                                     @else #a78bfa, #8b5cf6
                                     @endif);">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-4">
                        <p class="text-sm text-slate-500">Belum ada data pengeluaran bulan ini</p>
                    </div>
                    @endif
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
                                            <span id="top-service-name" class="block text-sm font-bold text-slate-800">{{ $layananTerlaris['top_service']['label'] ?? '-' }}</span>
                                            <span id="top-service-percentage" class="block text-xl font-bold text-blue-600">{{ $layananTerlaris['top_service']['value'] ?? 0 }}%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Legend Section -->
                        <div id="services-legend" class="space-y-3 w-full px-4">
                            @foreach($layananTerlaris['data'] as $index => $layanan)
                            <div class="flex items-center justify-between p-3 rounded text-sm transition-colors duration-200 {{ $index == 0 ? 'bg-blue-50 border-l-2 border-blue-500' : 'hover:bg-gray-50' }}">
                                <div class="flex items-center">
                                    <div class="w-3.5 h-3.5 rounded-full mr-3 flex-shrink-0" style="background-color: {{ $layanan['color'] }}"></div>
                                    <span class="font-medium text-slate-700">{{ $layanan['label'] }}</span>
                                </div>
                                <span class="font-bold text-slate-800">{{ $layanan['value'] }}%</span>
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
                    5 aktivitas terbaru dalam sistem
                </p>
            </div>

            <!-- Content -->
            <div class="flex flex-col flex-auto min-h-0 p-4" id="transaction-content">
                @if($transaksiTerakhir['has_data'])
                <!-- Data Available State -->
                <div class="flex flex-col h-full min-h-0">
                    <!-- Timeline with Scroll -->
                    <div class="flex-auto min-h-0 overflow-y-auto pr-2 space-y-5">
                        @foreach($transaksiTerakhir['data'] as $item)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <span class="inline-flex items-center justify-center w-3 h-3 rounded-full {{ $item['type'] == 'income' ? 'bg-green-500' : 'bg-red-500' }}"></span>
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
                    <div class="mt-auto pt-4 border-t border-gray-100">
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
                <div class="h-full flex flex-col items-center justify-center text-center py-8">
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


</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
<script>
// Chart.js Line Chart Configuration for Daily Revenue
var ctx = document.getElementById("chart-lines").getContext("2d");

// Data from backend
var grafikData = @json($grafikPendapatan);

new Chart(ctx, {
    type: "line",
    data: {
        labels: grafikData.labels,
        datasets: [{
            label: "Pendapatan Harian",
            tension: 0.4,
            borderWidth: 3,
            pointRadius: 4,
            pointHoverRadius: 6,
            borderColor: "#22c55e",
            backgroundColor: "rgba(34, 197, 94, 0.1)",
            data: grafikData.data,
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
@endpush
