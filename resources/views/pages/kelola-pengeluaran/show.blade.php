@extends('layouts.admin')

@section('title', 'Detail Pengeluaran')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Detail Pengeluaran</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('kelola-pengeluaran.edit', $pengeluaran->id) }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('kelola-pengeluaran.index') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
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
                        <h6 class="mb-0 text-slate-700">Informasi Pengeluaran</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi</label>
                                <div class="text-lg font-semibold text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $pengeluaran->deskripsi }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Kategori</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="bg-gradient-to-tl {{ $pengeluaran->kategori_badge_color }} px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        {{ ucfirst(str_replace('_', ' ', $pengeluaran->kategori)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jumlah</label>
                                <div class="text-2xl font-bold text-red-600 bg-gray-50 rounded-lg p-3">
                                    {{ $pengeluaran->formatted_jumlah }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Pengeluaran</label>
                                <div class="text-lg font-semibold text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $pengeluaran->tanggal_pengeluaran->format('d F Y') }}
                                    <div class="text-xs text-slate-400 mt-1">
                                        {{ $pengeluaran->tanggal_pengeluaran->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Hari dalam Seminggu</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $pengeluaran->tanggal_pengeluaran->locale('id')->dayName }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Catatan</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3 min-h-[80px]">
                                    {{ $pengeluaran->catatan ?? 'Tidak ada catatan' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary & Timeline Info -->
            <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
                <!-- Quick Stats -->
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Ringkasan</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status Pengeluaran</label>
                            <div class="text-sm text-slate-600">
                                @if($pengeluaran->tanggal_pengeluaran->isToday())
                                    <span class="bg-gradient-to-tl from-blue-600 to-cyan-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        Hari Ini
                                    </span>
                                @elseif($pengeluaran->tanggal_pengeluaran->isCurrentMonth())
                                    <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        Bulan Ini
                                    </span>
                                @else
                                    <span class="bg-gradient-to-tl from-gray-600 to-slate-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        Masa Lalu
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Dalam Angka</label>
                            <div class="text-xs text-slate-600">
                                <div class="flex justify-between py-1">
                                    <span>Jumlah Digit:</span>
                                    <span class="font-semibold">{{ strlen((string)$pengeluaran->jumlah) }}</span>
                                </div>
                                <div class="flex justify-between py-1">
                                    <span>Dalam Ribu:</span>
                                    <span class="font-semibold">{{ number_format($pengeluaran->jumlah / 1000, 1) }}K</span>
                                </div>
                                @if($pengeluaran->jumlah >= 1000000)
                                <div class="flex justify-between py-1">
                                    <span>Dalam Juta:</span>
                                    <span class="font-semibold">{{ number_format($pengeluaran->jumlah / 1000000, 2) }}Jt</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline Information -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Timeline</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Dibuat</label>
                            <div class="text-sm text-slate-600">
                                {{ $pengeluaran->created_at->format('d F Y H:i') }}
                                <div class="text-xs text-slate-400">
                                    {{ $pengeluaran->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Terakhir Diperbarui</label>
                            <div class="text-sm text-slate-600">
                                {{ $pengeluaran->updated_at->format('d F Y H:i') }}
                                <div class="text-xs text-slate-400">
                                    {{ $pengeluaran->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">ID Record</label>
                            <div class="text-sm text-slate-600 font-mono">
                                #{{ str_pad($pengeluaran->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        @if($pengeluaran->created_at != $pengeluaran->updated_at)
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status</label>
                            <div class="text-xs">
                                <span class="bg-gradient-to-tl from-orange-600 to-yellow-400 px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                    Telah Diperbarui
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-slate-700">Aksi</h6>
            </div>
            <div class="flex-auto p-6">
                <div class="flex gap-3">
                    <a href="{{ route('kelola-pengeluaran.edit', $pengeluaran->id) }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                        <i class="fas fa-edit mr-2"></i>Edit Pengeluaran
                    </a>
                    <form action="{{ route('kelola-pengeluaran.destroy', $pengeluaran->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini? Tindakan ini tidak dapat dibatalkan.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-red-600 to-rose-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-trash mr-2"></i>Hapus Pengeluaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
