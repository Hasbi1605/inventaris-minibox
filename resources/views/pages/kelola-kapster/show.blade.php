@extends('layouts.admin')

@section('title', 'Detail Kapster')
@section('page-title', 'Detail Kapster')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Detail Kapster</h4>
            <p class="mb-0 text-sm text-slate-500">Informasi lengkap kapster {{ $kelola_kapster->nama_kapster }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('kelola-kapster.edit', $kelola_kapster->id) }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-edit mr-2"></i>
                Edit
            </a>
            <a href="{{ route('kelola-kapster.index') }}" 
                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Kapster Info Card -->
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6">
                    <div class="flex flex-wrap -mx-3">
                        <!-- Left Column -->
                        <div class="w-full max-w-full px-3 lg:w-1/2">
                            <h6 class="mb-4 font-bold text-slate-700">Informasi Kapster</h6>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold uppercase text-slate-400">Nama Kapster</label>
                                    <p class="text-sm font-semibold text-slate-700">{{ $kelola_kapster->nama_kapster }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-slate-400">Cabang</label>
                                    <p class="text-sm font-semibold text-slate-700">{{ $kelola_kapster->cabang->nama_cabang }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-slate-400">Status</label>
                                    <div class="mt-1">
                                        <span class="bg-gradient-to-tl {{ $kelola_kapster->status === 'aktif' ? 'from-green-600 to-lime-400' : 'from-red-600 to-rose-400' }} px-3 py-1 text-xs rounded-lg font-bold uppercase text-white">
                                            {{ $kelola_kapster->status }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-slate-400">Spesialisasi</label>
                                    <p class="text-sm font-semibold text-slate-700">{{ $kelola_kapster->spesialisasi ?: '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="w-full max-w-full px-3 lg:w-1/2">
                            <h6 class="mb-4 font-bold text-slate-700">Kontak & Komisi</h6>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold uppercase text-slate-400">No. Telepon</label>
                                    <p class="text-sm font-semibold text-slate-700">
                                        @if($kelola_kapster->telepon)
                                            <i class="fas fa-phone text-xs mr-2"></i>
                                            {{ $kelola_kapster->telepon }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-slate-400">Komisi</label>
                                    <p class="text-sm font-semibold text-slate-700">
                                        @if($kelola_kapster->komisi_persen)
                                            <span class="bg-gradient-to-tl from-purple-600 to-pink-400 px-2 py-1 text-xs rounded font-bold text-white">
                                                {{ $kelola_kapster->komisi_persen }}%
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-slate-400">Bergabung Sejak</label>
                                    <p class="text-sm font-semibold text-slate-700">{{ $kelola_kapster->created_at->format('d M Y') }}</p>
                                </div>

                                <div>
                                    <label class="text-xs font-bold uppercase text-slate-400">Terakhir Diperbarui</label>
                                    <p class="text-sm font-semibold text-slate-700">{{ $kelola_kapster->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Transaksi Terbaru</h6>
                    <p class="text-sm leading-normal text-slate-400">
                        10 transaksi terakhir yang dilakukan oleh {{ $kelola_kapster->nama_kapster }}
                    </p>
                </div>
                
                <div class="flex-auto px-0 pt-0 pb-2">
                    <div class="p-0 overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        No. Transaksi
                                    </th>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Pelanggan
                                    </th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Tanggal
                                    </th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Total
                                    </th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kelola_kapster->transaksi as $transaksi)
                                <tr>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-sm font-semibold leading-tight text-slate-600">
                                            {{ $transaksi->nomor_transaksi }}
                                        </span>
                                    </td>
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold leading-tight text-slate-700">
                                                {{ $transaksi->nama_pelanggan }}
                                            </span>
                                            @if($transaksi->telepon_pelanggan)
                                                <span class="text-xs text-slate-400">
                                                    {{ $transaksi->telepon_pelanggan }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight text-slate-600">
                                            {{ $transaksi->tanggal_transaksi->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-sm font-semibold leading-tight text-slate-700">
                                            {{ $transaksi->formatted_total_harga }}
                                        </span>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="bg-gradient-to-tl {{ $transaksi->status_badge_color }} px-2 py-1 text-xs rounded font-bold uppercase text-white">
                                            {{ $transaksi->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex flex-col items-center justify-center space-y-3">
                                            <i class="fas fa-receipt text-4xl text-slate-300"></i>
                                            <p class="text-sm text-slate-500">Belum ada transaksi</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection