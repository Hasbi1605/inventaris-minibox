@extends('layouts.admin')

@section('title', 'Kelola Transaksi')
@section('page-title', 'Kelola Transaksi')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Kelola Transaksi</h4>
            <p class="mb-0 text-sm text-slate-500">Kelola semua transaksi barbershop Anda</p>
        </div>
        <div>
            <a href="{{ route('kelola-transaksi.create') }}"
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-plus mr-2"></i>
                Tambah Transaksi
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="relative p-4 mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="relative p-4 mb-4 text-red-700 bg-red-100 border border-red-300 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Collapsible Filter & Search -->
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-4 bg-white rounded-t-2xl cursor-pointer hover:bg-gray-50 transition-colors" onclick="toggleFilter()">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-filter text-slate-700 mr-3"></i>
                    <h6 class="font-bold text-slate-700">Filter & Pencarian</h6>
                    @if(request('search') || request('kategori') || request('status') || request('tanggal_dari') || request('tanggal_sampai'))
                        <span class="ml-3 px-2 py-1 text-xs font-semibold text-white bg-blue-600 rounded-full">
                            {{ collect([request('search'), request('kategori'), request('status'), request('tanggal_dari'), request('tanggal_sampai')])->filter()->count() }} aktif
                        </span>
                    @endif
                </div>
                <i id="filter-icon" class="fas fa-chevron-down text-slate-700 transition-transform duration-200"></i>
            </div>
        </div>
        <div id="filter-content" class="hidden border-t border-gray-200">
            <div class="p-6">
                <form method="GET" action="{{ route('kelola-transaksi.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Layanan -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                <i class="fas fa-cut mr-1"></i>Layanan
                            </label>
                            <select name="kategori" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                                <option value="">Semua Layanan</option>
                                @foreach($categories as $id => $nama)
                                <option value="{{ $id }}" {{ (request('kategori') == $id) ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                <i class="fas fa-circle-check mr-1"></i>Status
                            </label>
                            <select name="status" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="sedang_proses" {{ request('status') == 'sedang_proses' ? 'selected' : '' }}>Sedang Proses</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <!-- Dari Tanggal -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                <i class="fas fa-calendar-alt mr-1"></i>Dari Tanggal
                            </label>
                            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <!-- Sampai Tanggal -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                <i class="fas fa-calendar-alt mr-1"></i>Sampai Tanggal
                            </label>
                            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>
                    </div>

                    <!-- Pencarian -->
                    <div class="mb-4">
                        <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            <i class="fas fa-search mr-1"></i>Cari Transaksi
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berdasarkan no. transaksi atau nama pelanggan..." class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('kelola-transaksi.index') }}" class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </a>
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Tab Navigation untuk Cabang -->
    <div class="flex border-b border-gray-200 mb-6 bg-gray-50 rounded-t-lg overflow-x-auto">
        <!-- Tab Semua Cabang -->
        <button onclick="showCabangTab('semua-cabang')" 
                id="tab-cabang-semua-cabang" 
                class="px-6 py-3 font-semibold text-sm border-b-2 whitespace-nowrap transition-all duration-200 border-blue-600 text-blue-600 bg-white shadow-sm rounded-tl-lg">
            <i class="fas fa-building mr-2"></i>Semua Cabang
        </button>
        
        <!-- Tab Per Cabang -->
        @foreach($cabangList as $cabang)
        <button onclick="showCabangTab('{{ $cabang->id }}')" 
                id="tab-cabang-{{ $cabang->id }}" 
                class="px-6 py-3 font-semibold text-sm border-b-2 whitespace-nowrap transition-all duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100">
            <i class="fas fa-store mr-2"></i>{{ $cabang->nama_cabang }}
        </button>
        @endforeach
    </div>

    {{-- Tab Content Semua Cabang --}}
    @include('pages.kelola-transaksi.partials.tab-semua-cabang', [
        'transaksi' => $semuaTransaksi,
        'statistics' => $statisticsSemuaCabang
    ])

    {{-- Tab Content Per Cabang --}}
    @foreach($cabangList as $cabang)
        @include('pages.kelola-transaksi.partials.tab-per-cabang', [
            'cabangId' => $cabang->id,
            'cabangNama' => $cabang->nama_cabang,
            'transaksi' => $transaksiPerCabang[$cabang->id],
            'statistics' => $statisticsPerCabang[$cabang->id]
        ])
    @endforeach
</div>

<script>
function showCabangTab(cabangTab) {
    // Hide all cabang content
    document.querySelectorAll('[id^="content-cabang-"]').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('[id^="tab-cabang-"]').forEach(tab => {
        tab.classList.remove('border-blue-600', 'text-blue-600', 'bg-white', 'shadow-sm');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected cabang content
    const selectedContent = document.getElementById('content-cabang-' + cabangTab);
    if (selectedContent) {
        selectedContent.classList.remove('hidden');
    }
    
    // Add active state to selected tab
    const selectedTab = document.getElementById('tab-cabang-' + cabangTab);
    if (selectedTab) {
        selectedTab.classList.remove('border-transparent', 'text-gray-500');
        selectedTab.classList.add('border-blue-600', 'text-blue-600', 'bg-white', 'shadow-sm');
    }
}

function toggleFilter() {
    const filterContent = document.getElementById('filter-content');
    const filterIcon = document.getElementById('filter-icon');
    
    if (filterContent.classList.contains('hidden')) {
        filterContent.classList.remove('hidden');
        filterIcon.classList.add('fa-chevron-up');
        filterIcon.classList.remove('fa-chevron-down');
    } else {
        filterContent.classList.add('hidden');
        filterIcon.classList.remove('fa-chevron-up');
        filterIcon.classList.add('fa-chevron-down');
    }
}

// Auto hide alerts after 3 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.relative.p-4.mb-4');
    alerts.forEach(alert => {
        if (alert.classList.contains('text-green-700') || alert.classList.contains('text-red-700')) {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s ease';
            setTimeout(() => alert.remove(), 300);
        }
    });
}, 3000);
</script>
@endsection
