@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Kelola Kategori</h4>
            <p class="mb-0 text-sm text-slate-500">Atur kategori untuk inventaris, layanan, pengeluaran, dan modul lainnya dalam satu tempat</p>
        </div>
        <div>
            <a href="{{ route('kelola-kategori.create') }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-plus mr-2"></i>
                Tambah Kategori
            </a>
        </div>
    </div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="relative p-4 mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <span class="font-medium">{{ session('success') }}</span>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-100 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8 items-center justify-center" onclick="this.parentElement.parentElement.style.display='none'">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="relative p-4 mb-4 text-red-700 bg-red-100 border border-red-300 rounded-lg" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <span class="font-medium">{{ session('error') }}</span>
            <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-100 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex h-8 w-8 items-center justify-center" onclick="this.parentElement.parentElement.style.display='none'">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
    </div>
@endif

<!-- Collapsible Filter Section -->
<div class="flex flex-wrap -mx-3 mb-6">
    <div class="flex-none w-full max-w-full px-3">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-4 bg-white rounded-t-2xl cursor-pointer hover:bg-gray-50 transition-colors" onclick="toggleFilter()">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-filter text-slate-700 mr-3"></i>
                        <h6 class="font-bold text-slate-700">Filter & Pencarian</h6>
                        @if($jenisKategori || $includeInactive)
                            <span class="ml-3 px-2 py-1 text-xs font-semibold text-white bg-blue-600 rounded-full">
                                {{ collect([$jenisKategori, $includeInactive])->filter()->count() }} aktif
                            </span>
                        @endif
                    </div>
                    <i id="filter-icon" class="fas fa-chevron-down text-slate-700 transition-transform duration-200"></i>
                </div>
            </div>
            <div id="filter-content" class="hidden border-t border-gray-200">
                <div class="p-6">
                <form method="GET" action="{{ route('kelola-kategori.index') }}" class="flex flex-wrap items-end gap-4">
                    <div class="flex-1 min-w-48">
                        <label for="jenis" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            <i class="fas fa-tags mr-1"></i>Jenis Kategori
                        </label>
                        <select name="jenis" id="jenis" 
                                class="form-select w-full text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" 
                                onchange="this.form.submit()">
                            <option value="">Semua Jenis</option>
                            @foreach($jenisOptions as $key => $label)
                                <option value="{{ $key }}" {{ $jenisKategori === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <div class="form-check min-h-6 pl-0 mb-0.5">
                            <input type="checkbox" name="include_inactive" id="include_inactive"
                                   class="form-check-input w-4 h-4 ease-soft rounded checked:bg-gradient-to-tl checked:from-blue-600 checked:to-cyan-400 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out" 
                                   value="1" 
                                   {{ $includeInactive ? 'checked' : '' }}
                                   onchange="this.form.submit()">
                            <label for="include_inactive" class="mb-0 ml-2 text-sm font-normal cursor-pointer select-none text-slate-700">
                                <i class="fas fa-eye-slash mr-1 text-slate-400"></i>
                                Tampilkan Non-Aktif
                            </label>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Grid -->
<div class="flex flex-wrap -mx-3">
    @foreach($jenisOptions as $jenis => $jenisLabel)
        @php
            $kategoriByJenis = collect($kategoris)->where('jenis_kategori', $jenis)->values();
        @endphp
        
        <div class="w-full max-w-full px-3 mb-6 lg:w-1/2 lg:flex-none">
            <!-- Kategori {{ $jenisLabel }} -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border h-full">
                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-600 to-cyan-400 text-white rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-lg bg-white bg-opacity-25 text-center shadow-sm">
                            <i class="fas {{ $jenis === 'inventaris' ? 'fa-boxes' : ($jenis === 'layanan' ? 'fa-cut' : ($jenis === 'pengeluaran' ? 'fa-money-bill-wave' : 'fa-tags')) }} text-blue-700 text-base font-bold"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 text-white font-semibold">{{ $jenisLabel }}</h6>
                            <p class="text-xs text-white text-opacity-80 mb-0">{{ $kategoriByJenis->count() }} kategori</p>
                        </div>
                    </div>
                
                </div>
                
                <div class="flex-auto p-0">
                    @if($kategoriByJenis->count() > 0)
                        <div class="overflow-hidden">
                            <div class="max-h-96 overflow-y-auto">
                                @foreach($kategoriByJenis as $kategori)
                                    <div class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <h6 class="mb-1 font-medium text-slate-800">{{ $kategori->nama_kategori }}</h6>
                                                    <p class="text-sm text-slate-500 mb-0">{{ $kategori->kode_kategori }}</p>
                                                </div>
                                                <div class="flex items-center gap-2 ml-4">
                                                    <a href="{{ route('kelola-kategori.edit', $kategori) }}" 
                                                       class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md" 
                                                       title="Edit">
                                                        <i class="fas fa-edit text-sm"></i>
                                                    </a>
                                                    @php
                                                        $hasUsage = ($kategori->inventarises_count + $kategori->layanan_count + $kategori->pengeluarans_count) > 0;
                                                    @endphp
                                                    @if(!$hasUsage)
                                                        <form action="{{ route('kelola-kategori.destroy', $kategori) }}" 
                                                              method="POST" 
                                                              class="inline"
                                                              onsubmit="return confirm('Yakin ingin menghapus kategori {{ $kategori->nama_kategori }}?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-red-600 to-yellow-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md" 
                                                                    title="Hapus">
                                                                <i class="fas fa-trash text-sm"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 text-gray-400" 
                                                             title="Tidak dapat dihapus - digunakan di {{ $kategori->inventarises_count }} inventaris, {{ $kategori->layanan_count }} layanan, {{ $kategori->pengeluarans_count }} pengeluaran">
                                                            <i class="fas fa-lock text-sm"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-slate-400 mb-4">
                                <i class="fas {{ $jenis === 'inventaris' ? 'fa-boxes' : ($jenis === 'layanan' ? 'fa-cut' : ($jenis === 'pengeluaran' ? 'fa-money-bill-wave' : 'fa-tags')) }} text-4xl"></i>
                            </div>
                            <h5 class="mb-2 text-slate-600 font-medium">Belum Ada Kategori {{ $jenisLabel }}</h5>
                            <p class="text-sm text-slate-500 mb-4">Mulai dengan membuat kategori {{ strtolower($jenisLabel) }} pertama Anda</p>
                            <a href="{{ route('kelola-kategori.create', ['jenis' => $jenis]) }}" 
                               class="inline-block px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                                <i class="fas fa-plus mr-1"></i>
                                Buat Kategori
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
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