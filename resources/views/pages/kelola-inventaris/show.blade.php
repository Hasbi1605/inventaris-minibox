@extends('layouts.admin')

@section('title', 'Detail Inventaris')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Detail Inventaris: {{ $inventaris->nama_barang }}</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('kelola-inventaris.edit', $inventaris->id) }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('kelola-inventaris.index') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Content -->
        <div class="flex flex-wrap -mx-3">
            <!-- Main Info -->
            <div class="w-full max-w-full px-3 lg:w-2/3 lg:flex-none">
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Informasi Barang</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Barang</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $inventaris->nama_barang }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Kategori</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $inventaris->kategori }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Merek</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $inventaris->merek ?? '-' }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Satuan</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ ucfirst($inventaris->satuan) }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3 min-h-[80px]">
                                    {{ $inventaris->deskripsi ?? 'Tidak ada deskripsi' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stock & Status Info -->
            <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
                <!-- Stock Information -->
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Informasi Stok</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Stok Saat Ini</label>
                            <div class="text-2xl font-bold {{ $inventaris->stok_saat_ini <= $inventaris->stok_minimal ? 'text-red-500' : 'text-green-500' }}">
                                {{ $inventaris->stok_saat_ini }} {{ $inventaris->satuan }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Stok Minimal</label>
                            <div class="text-lg text-slate-600">
                                {{ $inventaris->stok_minimal }} {{ $inventaris->satuan }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status</label>
                            <div>
                                <span class="bg-gradient-to-tl @if($inventaris->status == 'tersedia') from-green-600 to-lime-400 @elseif($inventaris->status == 'habis') from-red-600 to-rose-400 @else from-gray-600 to-slate-400 @endif px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                    {{ ucfirst($inventaris->status) }}
                                </span>
                            </div>
                        </div>
                        @if($inventaris->stok_saat_ini <= $inventaris->stok_minimal)
                        <div class="p-3 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span class="font-medium">Stok Rendah!</span>
                            </div>
                            <div class="mt-1">Stok saat ini sudah mencapai atau di bawah batas minimal.</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Price & Date Information -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Informasi Harga & Tanggal</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Harga Satuan</label>
                            <div class="text-xl font-bold text-green-600">
                                {{ $inventaris->formatted_harga }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Total Nilai Stok</label>
                            <div class="text-lg text-slate-600">
                                Rp {{ number_format($inventaris->stok_saat_ini * $inventaris->harga_satuan, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Kadaluarsa</label>
                            <div class="text-sm text-slate-600">
                                @if($inventaris->tanggal_kadaluarsa)
                                    {{ $inventaris->tanggal_kadaluarsa->format('d F Y') }}
                                    @if($inventaris->tanggal_kadaluarsa->isPast())
                                        <span class="ml-2 text-red-500 font-semibold">(Expired)</span>
                                    @elseif($inventaris->tanggal_kadaluarsa->diffInDays() <= 30)
                                        <span class="ml-2 text-orange-500 font-semibold">({{ $inventaris->tanggal_kadaluarsa->diffInDays() }} hari lagi)</span>
                                    @endif
                                @else
                                    <span class="text-gray-400">Tidak ada tanggal kadaluarsa</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Dibuat</label>
                            <div class="text-sm text-slate-600">
                                {{ $inventaris->created_at->format('d F Y H:i') }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Terakhir Update</label>
                            <div class="text-sm text-slate-600">
                                {{ $inventaris->updated_at->format('d F Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
