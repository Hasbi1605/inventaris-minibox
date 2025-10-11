@extends('layouts.admin')

@section('title', 'Detail Inventaris')
@section('page-title', 'Detail Inventaris')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Detail Inventaris</h4>
            <p class="mb-0 text-sm text-slate-500">Informasi lengkap barang: {{ $inventaris->nama_barang }}</p>
        </div>
        <div class="flex space-x-2">
           {{--  <a href="{{ route('kelola-inventaris.edit', $inventaris->id) }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-edit mr-2"></i>
                Edit Inventaris
            </a> --}}
            <a href="{{ route('kelola-inventaris.index') }}" 
                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information Card -->
        <div class="lg:col-span-2">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex items-center justify-between">
                        <h6 class="font-bold">Informasi Barang</h6>
                        <span class="bg-gradient-to-tl @if($inventaris->status == 'tersedia') from-blue-600 to-cyan-400 @elseif($inventaris->status == 'habis') from-red-600 to-rose-400 @else from-gray-600 to-slate-400 @endif px-3 text-xs rounded-1.8 py-1.5 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                            {{ ucfirst($inventaris->status) }}
                        </span>
                    </div>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Nama Barang -->
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Barang</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <h5 class="mb-0 font-semibold text-slate-700">{{ $inventaris->nama_barang }}</h5>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Kategori</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600">{{ $inventaris->nama_kategori }}</p>
                            </div>
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Satuan</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600">{{ ucfirst($inventaris->satuan) }}</p>
                            </div>
                        </div>

                        <!-- Harga Satuan -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Harga Satuan</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600 font-semibold text-lg">{{ $inventaris->formatted_harga }}</p>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        @if($inventaris->deskripsi)
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600 leading-relaxed">{{ $inventaris->deskripsi }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats & Actions -->
        <div class="lg:col-span-1">
            <!-- Quick Stats -->
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Statistik Cepat</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-4 mt-4">
                        <!-- Stok Saat Ini -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Stok Saat Ini</span>
                            <div class="text-right">
                                <div class="text-lg font-bold {{ $inventaris->stok_saat_ini <= $inventaris->stok_minimal ? 'text-red-500' : 'text-green-500' }}">
                                    {{ $inventaris->stok_saat_ini }} {{ $inventaris->satuan }}
                                </div>
                                <div class="text-xs text-slate-400">Minimal: {{ $inventaris->stok_minimal }}</div>
                            </div>
                        </div>

                        <!-- Total Nilai Stok -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Total Nilai Stok</span>
                            <span class="text-sm font-semibold">
                                Rp {{ number_format($inventaris->stok_saat_ini * $inventaris->harga_satuan, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- Status -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Status</span>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full @if($inventaris->status == 'tersedia') bg-green-500 @elseif($inventaris->status == 'habis') bg-red-500 @else bg-gray-500 @endif mr-2"></div>
                                <span class="text-sm font-semibold">{{ ucfirst($inventaris->status) }}</span>
                            </div>
                        </div>
                        
                        @if($inventaris->stok_saat_ini <= $inventaris->stok_minimal)
                        <div class="p-3 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span class="font-medium">Stok Rendah!</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions Card -->
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Aksi Cepat</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-3 mt-4">
                        <!-- Edit Action -->
                        <a href="{{ route('kelola-inventaris.edit', $inventaris->id) }}" 
                            class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Inventaris
                        </a>

                        <!-- Delete Action -->
                        <form action="{{ route('kelola-inventaris.destroy', $inventaris->id) }}" method="POST" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini? Tindakan ini tidak dapat dibatalkan.')" 
                            class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-yellow-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Inventaris
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Metadata Card -->
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Informasi Sistem</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-3 mt-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">ID Barang:</span>
                            <span class="font-mono text-slate-800">#{{ $inventaris->id }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Dibuat:</span>
                            <span class="text-slate-800">{{ $inventaris->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Diperbarui:</span>
                            <span class="text-slate-800">{{ $inventaris->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection