@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Detail Transaksi: {{ $transaksi->nomor_transaksi }}</h6>
                    <div class="flex gap-2">
                        <a href="{{ route('kelola-transaksi.edit', $transaksi->id) }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('kelola-transaksi.index') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
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
                        <h6 class="mb-0 text-slate-700">Informasi Transaksi</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nomor Transaksi</label>
                                <div class="text-lg font-bold text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $transaksi->nomor_transaksi }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Status</label>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <span class="bg-gradient-to-tl {{ $transaksi->status_badge_color }} px-3.6 text-xs rounded-1.8 py-2.2 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                                        {{ str_replace('_', ' ', ucfirst($transaksi->status)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nama Pelanggan</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $transaksi->nama_pelanggan }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Telepon Pelanggan</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $transaksi->telepon_pelanggan ?? '-' }}
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Layanan</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3">
                                    {{ $transaksi->layanan->nama_layanan ?? 'Layanan tidak ditemukan' }}
                                    @if($transaksi->layanan)
                                        <p class="text-xs text-slate-400 mt-1">{{ $transaksi->layanan->deskripsi }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="w-full max-w-full px-3 mb-4">
                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Catatan</label>
                                <div class="text-sm text-slate-600 bg-gray-50 rounded-lg p-3 min-h-[80px]">
                                    {{ $transaksi->catatan ?? 'Tidak ada catatan' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment & Schedule Info -->
            <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
                <!-- Payment Information -->
                <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Informasi Pembayaran</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Total Harga</label>
                            <div class="text-2xl font-bold text-green-600">
                                {{ $transaksi->formatted_total_harga }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Metode Pembayaran</label>
                            <div class="text-sm text-slate-600 capitalize">
                                {{ str_replace('_', ' ', $transaksi->metode_pembayaran) }}
                            </div>
                        </div>
                        @if($transaksi->layanan)
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Harga Layanan</label>
                            <div class="text-lg text-slate-600">
                                {{ $transaksi->layanan->formatted_harga }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Durasi Estimasi</label>
                            <div class="text-sm text-slate-600">
                                {{ $transaksi->layanan->durasi_estimasi }} menit
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Schedule Information -->
                <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h6 class="mb-0 text-slate-700">Jadwal Layanan</h6>
                    </div>
                    <div class="flex-auto p-6">
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal</label>
                            <div class="text-lg font-semibold text-slate-600">
                                {{ $transaksi->tanggal_transaksi->format('d F Y') }}
                            </div>
                            <div class="text-xs text-slate-400">
                                {{ $transaksi->tanggal_transaksi->diffForHumans() }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Waktu Mulai</label>
                            <div class="text-lg text-slate-600">
                                {{ $transaksi->waktu_mulai }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Waktu Selesai</label>
                            <div class="text-lg text-slate-600">
                                {{ $transaksi->waktu_selesai ?? 'Belum selesai' }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Dibuat</label>
                            <div class="text-sm text-slate-600">
                                {{ $transaksi->created_at->format('d F Y H:i') }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Terakhir Update</label>
                            <div class="text-sm text-slate-600">
                                {{ $transaksi->updated_at->format('d F Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        @if($transaksi->status !== 'selesai' && $transaksi->status !== 'dibatalkan')
        <div class="relative flex flex-col min-w-0 mt-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-slate-700">Aksi Cepat</h6>
            </div>
            <div class="flex-auto p-6">
                <div class="flex gap-3">
                    @if($transaksi->status === 'pending')
                    <form action="{{ route('kelola-transaksi.update', $transaksi->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="sedang_proses">
                        <input type="hidden" name="nama_pelanggan" value="{{ $transaksi->nama_pelanggan }}">
                        <input type="hidden" name="telepon_pelanggan" value="{{ $transaksi->telepon_pelanggan }}">
                        <input type="hidden" name="layanan_id" value="{{ $transaksi->layanan_id }}">
                        <input type="hidden" name="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi->format('Y-m-d') }}">
                        <input type="hidden" name="waktu_mulai" value="{{ $transaksi->waktu_mulai }}">
                        <input type="hidden" name="waktu_selesai" value="{{ $transaksi->waktu_selesai }}">
                        <input type="hidden" name="total_harga" value="{{ $transaksi->total_harga }}">
                        <input type="hidden" name="metode_pembayaran" value="{{ $transaksi->metode_pembayaran }}">
                        <input type="hidden" name="catatan" value="{{ $transaksi->catatan }}">
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-blue-600 to-cyan-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-play mr-2"></i>Mulai Proses
                        </button>
                    </form>
                    @endif

                    @if($transaksi->status === 'sedang_proses')
                    <form action="{{ route('kelola-transaksi.update', $transaksi->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="selesai">
                        <input type="hidden" name="nama_pelanggan" value="{{ $transaksi->nama_pelanggan }}">
                        <input type="hidden" name="telepon_pelanggan" value="{{ $transaksi->telepon_pelanggan }}">
                        <input type="hidden" name="layanan_id" value="{{ $transaksi->layanan_id }}">
                        <input type="hidden" name="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi->format('Y-m-d') }}">
                        <input type="hidden" name="waktu_mulai" value="{{ $transaksi->waktu_mulai }}">
                        <input type="hidden" name="waktu_selesai" value="{{ date('H:i') }}">
                        <input type="hidden" name="total_harga" value="{{ $transaksi->total_harga }}">
                        <input type="hidden" name="metode_pembayaran" value="{{ $transaksi->metode_pembayaran }}">
                        <input type="hidden" name="catatan" value="{{ $transaksi->catatan }}">
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-check mr-2"></i>Selesai
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('kelola-transaksi.update', $transaksi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="dibatalkan">
                        <input type="hidden" name="nama_pelanggan" value="{{ $transaksi->nama_pelanggan }}">
                        <input type="hidden" name="telepon_pelanggan" value="{{ $transaksi->telepon_pelanggan }}">
                        <input type="hidden" name="layanan_id" value="{{ $transaksi->layanan_id }}">
                        <input type="hidden" name="tanggal_transaksi" value="{{ $transaksi->tanggal_transaksi->format('Y-m-d') }}">
                        <input type="hidden" name="waktu_mulai" value="{{ $transaksi->waktu_mulai }}">
                        <input type="hidden" name="waktu_selesai" value="{{ $transaksi->waktu_selesai }}">
                        <input type="hidden" name="total_harga" value="{{ $transaksi->total_harga }}">
                        <input type="hidden" name="metode_pembayaran" value="{{ $transaksi->metode_pembayaran }}">
                        <input type="hidden" name="catatan" value="{{ $transaksi->catatan }}">
                        <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-red-600 to-rose-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-times mr-2"></i>Batalkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
