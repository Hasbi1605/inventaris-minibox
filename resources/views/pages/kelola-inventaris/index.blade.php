@extends('layouts.admin')

@section('title', 'Kelola Inventaris')

@section('page-title', 'Kelola Inventaris')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Kelola Inventaris</h4>
            <p class="mb-0 text-sm text-slate-500">Kelola semua inventaris barbershop Anda</p>
        </div>
        <div>
            <a href="{{ route('kelola-inventaris.create') }}"
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-plus mr-2"></i>
                Tambah Inventaris
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
                    @if(request('search') || request('kategori') || request('status'))
                        <span class="ml-3 px-2 py-1 text-xs font-semibold text-white bg-blue-600 rounded-full">
                            {{ collect([request('search'), request('kategori'), request('status')])->filter()->count() }} aktif
                        </span>
                    @endif
                </div>
                <i id="filter-icon" class="fas fa-chevron-down text-slate-700 transition-transform duration-200"></i>
            </div>
        </div>
        <div id="filter-content" class="hidden border-t border-gray-200">
            <div class="p-6">
                <form method="GET" action="{{ route('kelola-inventaris.index') }}">
                    <div class="flex items-end gap-3">
                        <!-- Kategori -->
                        <div class="flex-1">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                <i class="fas fa-tags mr-1"></i>Kategori
                            </label>
                            <select name="kategori" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $id => $nama)
                                <option value="{{ $id }}" {{ (request('kategori') == $id) ? 'selected' : '' }}>{{ $nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div class="flex-1">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                <i class="fas fa-circle-check mr-1"></i>Status
                            </label>
                            <select name="status" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                                <option value="">Semua Status</option>
                                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="hampir_habis" {{ request('status') == 'hampir_habis' ? 'selected' : '' }}>Hampir Habis</option>
                                <option value="habis" {{ request('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                                <option value="discontinued" {{ request('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                            </select>
                        </div>

                        <!-- Pencarian -->
                        <div class="flex-1">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                <i class="fas fa-search mr-1"></i>Cari Inventaris
                            </label>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama barang..." class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('kelola-inventaris.index') }}" class="inline-block px-6 py-2 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs whitespace-nowrap">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                            <button type="submit" class="inline-block px-6 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs whitespace-nowrap">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                        </div>
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
        <button onclick="showCabangTab('cabang-{{ $cabang->id }}')" 
                id="tab-cabang-cabang-{{ $cabang->id }}" 
                class="px-6 py-3 font-semibold text-sm border-b-2 whitespace-nowrap transition-all duration-200 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100">
            <i class="fas fa-store mr-2"></i>{{ $cabang->nama_cabang }}
        </button>
        @endforeach
    </div>

    {{-- Tab Content Semua Cabang --}}
    @include('pages.kelola-inventaris.partials.tab-semua-cabang', [
        'inventaris' => $semuaInventaris,
        'statistics' => $statisticsSemuaCabang
    ])

    {{-- Tab Content Per Cabang --}}
    @foreach($cabangList as $cabang)
        @include('pages.kelola-inventaris.partials.tab-per-cabang', [
            'cabangId' => $cabang->id,
            'cabangNama' => $cabang->nama_cabang,
            'inventaris' => $inventarisPerCabang[$cabang->id],
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
    
    // Reset all cabang buttons to inactive state
    document.querySelectorAll('[id^="tab-cabang-"]').forEach(button => {
        button.classList.remove('border-blue-600', 'text-blue-600', 'bg-white', 'shadow-sm');
        button.classList.add('border-transparent', 'text-gray-500', 'hover:bg-gray-100');
    });
    
    // Show selected cabang content
    document.getElementById('content-cabang-' + cabangTab).classList.remove('hidden');
    
    // Highlight active cabang button
    const activeButton = document.getElementById('tab-cabang-' + cabangTab);
    activeButton.classList.remove('border-transparent', 'text-gray-500', 'hover:bg-gray-100');
    activeButton.classList.add('border-blue-600', 'text-blue-600', 'bg-white', 'shadow-sm');
}

function toggleFilter() {
    const filterContent = document.getElementById('filter-content');
    const filterIcon = document.getElementById('filter-icon');
    
    if (filterContent.classList.contains('hidden')) {
        filterContent.classList.remove('hidden');
        filterIcon.classList.add('rotate-180');
    } else {
        filterContent.classList.add('hidden');
        filterIcon.classList.remove('rotate-180');
    }
}

// Auto-expand filter if there are active filters
document.addEventListener('DOMContentLoaded', function() {
    const hasActiveFilters = {{ (request('search') || request('kategori') || request('status')) ? 'true' : 'false' }};
    if (hasActiveFilters) {
        toggleFilter();
    }
});
</script>

@endsection
