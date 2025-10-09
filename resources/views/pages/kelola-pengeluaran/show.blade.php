@extends('layouts.admin')

@section('title', 'Detail Pengeluaran')
@section('page-title', 'Detail Pengeluaran')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Detail Pengeluaran</h4>
            <p class="mb-0 text-sm text-slate-500">Informasi lengkap pengeluaran: {{ $pengeluaran->nama_pengeluaran }}</p>
        </div>
        <div class="flex space-x-2">
    {{--         <a href="{{ route('kelola-pengeluaran.edit', $pengeluaran->id) }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-edit mr-2"></i>
                Edit Pengeluaran
            </a> --}}
            <a href="{{ route('kelola-pengeluaran.index') }}" 
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information Card -->
        <div class="lg:col-span-2">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex items-center justify-between">
                        <h6 class="font-bold">Informasi Pengeluaran</h6>
                        @if($pengeluaran->kategori)
                        <span class="bg-gradient-to-tl from-blue-600 to-cyan-400 px-3 text-xs rounded-1.8 py-1.5 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                            {{ $pengeluaran->kategori->nama_kategori }}
                        </span>
                        @endif
                    </div>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <h5 class="mb-0 font-semibold text-slate-700">{{ $pengeluaran->nama_pengeluaran }}</h5>
                            </div>
                        </div>

                        <!-- Jumlah -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jumlah</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-700 font-semibold text-lg text-red-600">{{ $pengeluaran->formatted_jumlah }}</p>
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Kategori</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600">{{ $pengeluaran->kategori->nama_kategori ?? 'Tidak ada kategori' }}</p>
                            </div>
                        </div>

                        <!-- Tanggal Pengeluaran -->
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Pengeluaran</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600 font-semibold">{{ $pengeluaran->tanggal_pengeluaran->format('d F Y') }} ({{ $pengeluaran->tanggal_pengeluaran->locale('id')->dayName }})</p>
                                <p class="text-sm text-slate-500">{{ $pengeluaran->tanggal_pengeluaran->diffForHumans() }}</p>
                            </div>
                        </div>

                        <!-- Catatan -->
                        @if($pengeluaran->deskripsi)
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Catatan</label>
                            <div class="p-3 bg-gray-50 rounded-lg border min-h-[80px]">
                                <p class="mb-0 text-slate-600 leading-relaxed">{{ $pengeluaran->deskripsi }}</p>
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
                    <h6 class="font-bold">Ringkasan</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-4 mt-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Status Waktu</span>
                            @if($pengeluaran->tanggal_pengeluaran->isToday())
                                <span class="px-2 py-1 text-xs font-bold text-white uppercase bg-blue-500 rounded-md">Hari Ini</span>
                            @elseif($pengeluaran->tanggal_pengeluaran->isCurrentMonth())
                                <span class="px-2 py-1 text-xs font-bold text-white uppercase bg-green-500 rounded-md">Bulan Ini</span>
                            @else
                                <span class="px-2 py-1 text-xs font-bold text-white uppercase bg-gray-500 rounded-md">Masa Lalu</span>
                            @endif
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Besaran</span>
                            <span class="text-sm font-semibold">
                                @if($pengeluaran->jumlah < 100000)
                                    <span class="text-green-600">Kecil</span>
                                @elseif($pengeluaran->jumlah < 1000000)
                                    <span class="text-orange-600">Sedang</span>
                                @else
                                    <span class="text-red-600">Besar</span>
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
                        <a href="{{ route('kelola-pengeluaran.edit', $pengeluaran->id) }}" 
                            class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Pengeluaran
                        </a>
                        <form action="{{ route('kelola-pengeluaran.destroy', $pengeluaran->id) }}" method="POST" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini? Tindakan ini tidak dapat dibatalkan.')" 
                            class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-yellow-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Pengeluaran
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
                            <span class="text-slate-600">ID Pengeluaran:</span>
                            <span class="font-mono text-slate-800">#{{ $pengeluaran->sequential_number }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Dibuat:</span>
                            <span class="text-slate-800">{{ $pengeluaran->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Diperbarui:</span>
                            <span class="text-slate-800">{{ $pengeluaran->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection