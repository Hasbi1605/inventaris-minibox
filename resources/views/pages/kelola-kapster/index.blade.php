@extends('layouts.admin')

@section('title', 'Kelola Kapster')
@section('page-title', 'Kelola Kapster')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Kelola Kapster</h4>
            <p class="mb-0 text-sm text-slate-500">Kelola semua kapster barbershop Anda</p>
        </div>
        <div>
            <a href="{{ route('kelola-kapster.create') }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-plus mr-2"></i>
                Tambah Kapster
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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Kapster -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Total Kapster</p>
                                <h5 class="mb-0 font-bold text-lg">{{ $statistics['total_kapster'] }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-users text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kapster Aktif -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Kapster Aktif</p>
                                <h5 class="mb-0 font-bold text-lg">{{ $statistics['kapster_aktif'] }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-check-circle text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kapster Tidak Aktif -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Tidak Aktif</p>
                                <h5 class="mb-0 font-bold text-lg">{{ $statistics['kapster_tidak_aktif'] }}</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-times-circle text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Komisi -->
        <div class="w-full">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <div>
                                <p class="mb-0 font-sans text-sm font-semibold leading-normal">Rata-rata Komisi</p>
                                @php
                                    $avgKomisi = ($statistics['rata_rata_komisi']['potong_rambut'] + 
                                                  $statistics['rata_rata_komisi']['layanan_lain'] + 
                                                  $statistics['rata_rata_komisi']['produk']) / 3;
                                @endphp
                                <h5 class="mb-0 font-bold text-lg">{{ number_format($avgKomisi, 1) }}%</h5>
                            </div>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-percentage text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collapsible Filter & Search -->
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-4 bg-white rounded-t-2xl cursor-pointer hover:bg-gray-50 transition-colors" onclick="toggleFilter()">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-filter text-slate-700 mr-3"></i>
                    <h6 class="font-bold text-slate-700">Filter & Pencarian</h6>
                    @if(request('search') || request('cabang_id') || request('status'))
                        <span class="ml-3 px-2 py-1 text-xs font-semibold text-white bg-blue-600 rounded-full">
                            {{ collect([request('search'), request('cabang_id'), request('status')])->filter()->count() }} aktif
                        </span>
                    @endif
                </div>
                <i id="filter-icon" class="fas fa-chevron-down text-slate-700 transition-transform duration-200"></i>
            </div>
        </div>
        <div id="filter-content" class="hidden border-t border-gray-200">
            <div class="p-6">
            <form method="GET" action="{{ route('kelola-kapster.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Cabang -->
                    <div class="lg:col-span-1">
                        <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            <i class="fas fa-store mr-1"></i>Cabang
                        </label>
                        <select name="cabang_id" 
                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                            <option value="">Semua Cabang</option>
                            @foreach($cabang as $item)
                                <option value="{{ $item->id }}" {{ request('cabang_id') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_cabang }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Status -->
                    <div class="lg:col-span-1">
                        <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            <i class="fas fa-circle-check mr-1"></i>Status
                        </label>
                        <select name="status" 
                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                            <option value="">Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                    
                    <!-- Pencarian -->
                    <div class="lg:col-span-1">
                        <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            <i class="fas fa-search mr-1"></i>Cari Kapster
                        </label>
                        <input type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari nama kapster..."
                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow">
                    </div>
                </div>
                <div class="flex justify-end mt-4 space-x-2">
                    <a href="{{ route('kelola-kapster.index') }}" 
                        class="inline-block px-6 py-2 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs whitespace-nowrap">
                        <i class="fas fa-undo mr-2"></i>Reset
                    </a>
                    <button type="submit" 
                        class="inline-block px-6 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs whitespace-nowrap">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <h6 class="font-bold">Data Kapster</h6>
        </div>
                
        <div class="flex-auto px-0 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                    <thead class="align-bottom">
                        <tr>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Kapster
                            </th>
                            <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Cabang
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Spesialisasi
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Status
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                <span class="whitespace-nowrap">Komisi Potong Rambut</span>
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                <span class="whitespace-nowrap">Komisi Layanan Lain</span>
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                <span class="whitespace-nowrap">Komisi Produk</span>
                            </th>
                            <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kapster as $item)
                        <tr>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-0 text-sm font-semibold leading-normal text-slate-700">
                                            {{ $item->nama_kapster }}
                                        </h6>
                                        @if($item->telepon)
                                            <p class="mb-0 text-xs leading-tight text-slate-400">
                                                <i class="fas fa-phone text-xs mr-1"></i>
                                                {{ $item->telepon }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-sm font-semibold leading-tight text-slate-600">
                                    {{ $item->cabang->nama_cabang }}
                                </span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-xs font-semibold leading-tight text-slate-600">
                                    {{ $item->spesialisasi ?: '-' }}
                                </span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="bg-gradient-to-tl {{ $item->status === 'aktif' ? 'from-green-600 to-lime-400' : 'from-red-600 to-rose-400' }} px-3 py-1 text-xs rounded-lg font-bold uppercase text-white">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-xs font-semibold leading-tight text-black-600">{{ number_format($item->komisi_potong_rambut ?? 40, 0) }}%</span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-xs font-semibold leading-tight text-black-600">{{ number_format($item->komisi_layanan_lain ?? 25, 0) }}%</span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <span class="text-xs font-semibold leading-tight text-black-600">{{ number_format($item->komisi_produk ?? 25, 0) }}%</span>
                            </td>
                            <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex items-center justify-center space-x-3">
                                    <!-- Tombol Lihat -->
                                    <a href="{{ route('kelola-kapster.show', $item->id) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-green-600 to-lime-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('kelola-kapster.edit', $item->id) }}" 
                                       class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                       title="Edit Kapster">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Tombol Hapus -->
                                    <form action="{{ route('kelola-kapster.destroy', $item->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kapster {{ $item->nama_kapster }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-red-600 to-yellow-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md"
                                                title="Hapus Kapster">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                <div class="flex flex-col items-center justify-center space-y-3">
                                    <i class="fas fa-users text-4xl text-slate-300"></i>
                                    <p class="text-sm text-slate-500">Belum ada data kapster</p>
                                    <a href="{{ route('kelola-kapster.create') }}" 
                                        class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Kapster Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($kapster->hasPages())
                <div class="px-6 py-4">
                    {{ $kapster->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
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

// Auto hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.relative.p-4.mb-4');
    alerts.forEach(alert => {
        if (alert.classList.contains('text-green-700') || alert.classList.contains('text-red-700')) {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.5s ease-in-out';
            setTimeout(() => alert.remove(), 500);
        }
    });
}, 5000);
</script>
@endpush
@endsection