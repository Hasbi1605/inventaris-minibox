@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')

@section('content')
<!-- Header Section -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
    <div class="p-6">
        <div class="flex justify-between items-center">
            <div>
                <h4 class="mb-0 font-bold text-slate-800">Kelola Kategori</h4>
                <p class="text-sm text-slate-500 mb-0">Atur kategori untuk inventaris, layanan, pengeluaran, dan modul lainnya dalam satu tempat</p>
            </div>
            <a href="{{ route('kelola-kategori.create') }}" class="inline-block px-5 py-2.5 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-normal text-sm ease-in shadow-md bg-150 hover:shadow-lg active:opacity-85 hover:-translate-y-px tracking-tight-rem">
                <i class="fas fa-plus mr-2"></i>
                Tambah Kategori
            </a>
        </div>
    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
    <div class="relative p-4 pr-12 mb-4 text-white bg-green-500 border border-solid rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="box-content w-4 h-4 p-1 ml-auto -mx-1.5 -my-1.5 text-white border-none rounded-md focus:ring-2 focus:ring-white hover:bg-white/10 absolute top-2 right-2" onclick="this.parentElement.style.display='none'">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="relative p-4 pr-12 mb-4 text-white bg-red-500 border border-solid rounded-lg bg-gradient-to-tl from-red-600 to-rose-400">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        <button type="button" class="box-content w-4 h-4 p-1 ml-auto -mx-1.5 -my-1.5 text-white border-none rounded-md focus:ring-2 focus:ring-white hover:bg-white/10 absolute top-2 right-2" onclick="this.parentElement.style.display='none'">
            <i class="fas fa-times text-lg"></i>
        </button>
    </div>
@endif

<!-- Filter Section -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
    <div class="p-6">
        <form method="GET" action="{{ route('kelola-kategori.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-48">
                <label for="jenis" class="block text-sm font-medium text-slate-700 mb-1">Filter Jenis Kategori</label>
                <select name="jenis" id="jenis" class="form-select w-full text-sm focus:shadow-soft-primary-outline leading-5.6 ease-soft block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    @foreach($jenisOptions as $key => $label)
                        <option value="{{ $key }}" {{ $jenisKategori === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center">
                <div class="form-check min-h-6 pl-7 mb-0.5">
                    <input type="checkbox" name="include_inactive" id="include_inactive"
                           class="form-check-input w-4.5 h-4.5 ease-soft -ml-7 rounded-1.4 checked:bg-gradient-to-tl checked:from-green-600 checked:to-lime-400 after:text-xxs after:font-awesome after:duration-250 after:ease-soft-in-out" 
                           value="1" 
                           {{ $includeInactive ? 'checked' : '' }}
                           onchange="this.form.submit()">
                    <label for="include_inactive" class="mb-0 ml-1 text-sm font-normal cursor-pointer select-none text-slate-700">
                        Tampilkan Non-Aktif
                    </label>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Categories Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @foreach($jenisOptions as $jenis => $jenisLabel)
        @php
            $kategoriByJenis = collect($kategoris)->where('jenis_kategori', $jenis)->values();
        @endphp
        
        <!-- Kategori {{ $jenisLabel }} -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border h-100">
            <div class="flex items-center justify-between p-4 bg-gradient-to-r {{ $jenis === 'inventaris' ? 'from-blue-500 to-cyan-400' : ($jenis === 'layanan' ? 'from-green-500 to-teal-400' : ($jenis === 'pengeluaran' ? 'from-red-500 to-pink-400' : 'from-purple-500 to-indigo-400')) }} text-white rounded-t-2xl">
                <h6 class="mb-0 text-white font-semibold">
                    <i class="fas {{ $jenis === 'inventaris' ? 'fa-boxes' : ($jenis === 'layanan' ? 'fa-cut' : ($jenis === 'pengeluaran' ? 'fa-money-bill-wave' : 'fa-tags')) }} mr-2"></i>
                    {{ $jenisLabel }}
                </h6>
                <a href="{{ route('kelola-kategori.create', ['jenis' => $jenis]) }}" 
                   class="text-white hover:text-gray-200 transition-colors" 
                   title="Tambah {{ $jenisLabel }}">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="flex-auto p-4">
                @if($kategoriByJenis->count() > 0)
                    <div class="table-responsive">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-2 px-1 font-semibold text-slate-600 text-xs">Nama</th>
                                    <th class="text-left py-2 px-1 font-semibold text-slate-600 text-xs">Kode</th>
                                    <th class="text-center py-2 px-1 font-semibold text-slate-600 text-xs w-20">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kategoriByJenis as $kategori)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="py-2 px-1">
                                            <div class="flex items-center">
                                                @if($kategori->warna)
                                                    <div class="w-3 h-3 rounded-full mr-2 flex-shrink-0" style="background-color: {{ $kategori->warna }}"></div>
                                                @endif
                                                @if($kategori->ikon)
                                                    <i class="{{ $kategori->ikon }} mr-2 text-slate-600 text-sm"></i>
                                                @endif
                                                <span class="font-medium text-slate-700">{{ $kategori->nama_kategori }}</span>
                                            </div>
                                            @if($kategori->deskripsi)
                                                <div class="text-xs text-slate-500 mt-1">{{ Str::limit($kategori->deskripsi, 30) }}</div>
                                            @endif
                                        </td>
                                        <td class="py-2 px-1">
                                            <code class="text-xs bg-gray-100 text-slate-600 rounded px-1">{{ $kategori->kode_kategori }}</code>
                                        </td>
                                        <td class="py-2 px-1 text-center">
                                            <div class="flex items-center justify-center gap-1">
                                                <a href="{{ route('kelola-kategori.edit', $kategori) }}" 
                                                   class="text-slate-500 hover:text-blue-600 transition-colors" 
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
                                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="text-slate-500 hover:text-red-600 transition-colors" 
                                                                title="Hapus">
                                                            <i class="fas fa-trash text-sm"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-slate-400 mb-2">
                            <i class="fas fa-inbox text-2xl"></i>
                        </div>
                        <p class="text-sm text-slate-500">Tidak ada kategori {{ $jenisLabel }}</p>
                        <a href="{{ route('kelola-kategori.create', ['jenis' => $jenis]) }}" 
                           class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">
                            Buat kategori pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection