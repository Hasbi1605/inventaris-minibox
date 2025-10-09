@extends('layouts.admin')

@section('title', 'Detail Layanan')
@section('page-title', 'Detail Layanan')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Detail Layanan</h4>
            <p class="mb-0 text-sm text-slate-500">Informasi lengkap layanan: {{ $layanan->nama_layanan }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('kelola-layanan.edit', $layanan->id) }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-edit mr-2"></i>
                Edit Layanan
            </a>
            <a href="{{ route('kelola-layanan.index') }}" 
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
                        <h6 class="font-bold">Informasi Layanan</h6>
                        <span class="bg-gradient-to-tl {{ $layanan->status == 'aktif' ? 'from-blue-600 to-cyan-400' : 'from-slate-600 to-slate-400' }} px-3 text-xs rounded-1.8 py-1.5 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                            {{ ucfirst($layanan->status) }}
                        </span>
                    </div>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Nama Layanan -->
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Layanan</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <h5 class="mb-0 font-semibold text-slate-700">{{ $layanan->nama_layanan }}</h5>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Kategori</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600">{{ $layanan->kategori->nama_kategori ?? 'Tidak ada kategori' }}</p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <span class="inline-flex items-center">
                                    <i class="fas fa-circle text-xs {{ $layanan->status == 'aktif' ? 'text-green-500' : 'text-gray-500' }} mr-2"></i>
                                    {{ ucfirst($layanan->status) }}
                                </span>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Harga</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600 font-semibold text-lg">{{ $layanan->formatted_harga }}</p>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        @if($layanan->deskripsi)
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600 leading-relaxed">{{ $layanan->deskripsi }}</p>
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
                        <!-- Status Visual -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Status Layanan</span>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ $layanan->status == 'aktif' ? 'bg-green-500' : 'bg-gray-500' }} mr-2"></div>
                                <span class="text-sm font-semibold">{{ ucfirst($layanan->status) }}</span>
                            </div>
                        </div>

                        <!-- Price Range Indicator -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Kategori Harga</span>
                            <span class="text-sm font-semibold">
                                @if($layanan->harga < 50000)
                                    <span class="text-black-600">Ekonomis</span>
                                @elseif($layanan->harga < 100000)
                                    <span class="text-black-600">Standar</span>
                                @else
                                    <span class="text-black-600">Premium</span>
                                @endif
                            </span>
                        </div>
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
                        <a href="{{ route('kelola-layanan.edit', $layanan->id) }}" 
                            class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Layanan
                        </a>

                        <!-- Delete Action -->
                        <form action="{{ route('kelola-layanan.destroy', $layanan->id) }}" method="POST" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini? Tindakan ini tidak dapat dibatalkan.')" 
                            class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-yellow-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Layanan
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
                            <span class="text-slate-600">ID Layanan:</span>
                            <span class="font-mono text-slate-800">#{{ $layanan->sequential_number }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Dibuat:</span>
                            <span class="text-slate-800">{{ $layanan->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Diperbarui:</span>
                            <span class="text-slate-800">{{ $layanan->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
