@extends('layouts.admin')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Detail Transaksi</h4>
            <p class="mb-0 text-sm text-slate-500">Informasi lengkap transaksi: {{ $transaksi->nomor_transaksi }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('kelola-transaksi.edit', $transaksi->id) }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-edit mr-2"></i>
                Edit Transaksi
            </a>
            <a href="{{ route('kelola-transaksi.index') }}" 
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
                        <h6 class="font-bold">Informasi Transaksi</h6>
                        <span class="bg-gradient-to-tl {{ $transaksi->status_badge_color }} px-3 text-xs rounded-1.8 py-1.5 inline-block whitespace-nowrap text-center align-baseline font-bold uppercase leading-none text-white">
                            {{ str_replace('_', ' ', ucfirst($transaksi->status)) }}
                        </span>
                    </div>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                        <!-- Nomor Transaksi -->
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Nomor Transaksi</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <h5 class="mb-0 font-semibold text-slate-700">{{ $transaksi->nomor_transaksi }}</h5>
                            </div>
                        </div>

                        <!-- Layanan -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Layanan</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600 font-semibold">{{ $transaksi->layanan->nama_layanan ?? 'Layanan tidak ditemukan' }}</p>
                            </div>
                        </div>

                        <!-- Total Harga -->
                        <div>
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Total Harga</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600 font-semibold text-lg">{{ $transaksi->formatted_total_harga }}</p>
                            </div>
                        </div>

                        <!-- Catatan -->
                        @if($transaksi->catatan)
                        <div class="md:col-span-2">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Catatan</label>
                            <div class="p-3 bg-gray-50 rounded-lg border">
                                <p class="mb-0 text-slate-600 leading-relaxed">{{ $transaksi->catatan }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Produk Information -->
            @if($transaksi->produk->count() > 0)
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Produk Tambahan</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-3 mt-4">
                        @foreach($transaksi->produk as $produk)
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h6 class="text-sm font-semibold text-slate-700">{{ $produk->nama_barang }}</h6>
                                    <p class="text-xs text-slate-400">{{ $produk->pivot->quantity }} x Rp {{ number_format($produk->pivot->harga_satuan, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-700">Rp {{ number_format($produk->pivot->subtotal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Quick Stats & Actions -->
        <div class="lg:col-span-1">
            <!-- Quick Stats -->
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Informasi Pembayaran</h6>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <div class="space-y-4 mt-4">
                        <!-- Total Harga -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Total Harga</span>
                            <div class="text-right">
                                <div class="text-lg font-bold text-green-600">{{ $transaksi->formatted_total_harga }}</div>
                            </div>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Metode Pembayaran</span>
                            <span class="text-sm font-semibold capitalize">{{ str_replace('_', ' ', $transaksi->metode_pembayaran) }}</span>
                        </div>

                        <!-- Status Visual -->
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-sm font-medium text-slate-600">Status Transaksi</span>
                            <div class="flex items-center">
                                <div class="w-3 h-3 rounded-full {{ $transaksi->status == 'selesai' ? 'bg-green-500' : ($transaksi->status == 'sedang_proses' ? 'bg-blue-500' : ($transaksi->status == 'pending' ? 'bg-yellow-500' : 'bg-red-500')) }} mr-2"></div>
                                <span class="text-sm font-semibold">{{ str_replace('_', ' ', ucfirst($transaksi->status)) }}</span>
                            </div>
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
                        @if($transaksi->status === 'pending')
                            <!-- Mulai Proses Action -->
                            <form action="{{ route('kelola-transaksi.update', $transaksi->id) }}" method="POST" class="w-full">
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
                                <button type="submit" 
                                    class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                    <i class="fas fa-play mr-2"></i>
                                    Mulai Proses
                                </button>
                            </form>
                        @endif

                        @if($transaksi->status === 'sedang_proses')
                            <!-- Selesai Action -->
                            <form action="{{ route('kelola-transaksi.update', $transaksi->id) }}" method="POST" class="w-full">
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
                                <button type="submit" 
                                    class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                    <i class="fas fa-check mr-2"></i>
                                    Selesai
                                </button>
                            </form>
                        @endif

                        @if($transaksi->status !== 'selesai' && $transaksi->status !== 'dibatalkan')
                            <!-- Edit Action -->
                            <a href="{{ route('kelola-transaksi.edit', $transaksi->id) }}" 
                                class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Transaksi
                            </a>

                            <!-- Batalkan Action -->
                            <form action="{{ route('kelola-transaksi.update', $transaksi->id) }}" method="POST" 
                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan transaksi ini? Tindakan ini tidak dapat dibatalkan.')" 
                                class="w-full">
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
                                <button type="submit" 
                                    class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-yellow-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                    <i class="fas fa-times mr-2"></i>
                                    Batalkan Transaksi
                                </button>
                            </form>
                        @endif

                        @if($transaksi->status === 'selesai')
                            <!-- Print Receipt Action -->
                            <a href="#" onclick="alert('Fitur cetak struk belum tersedia.')" 
                                class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-print mr-2"></i>
                                Cetak Struk
                            </a>
                        @endif

                        <!-- Delete Action -->
                        <form action="{{ route('kelola-transaksi.destroy', $transaksi->id) }}" method="POST" 
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat dibatalkan.')" 
                            class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="flex items-center justify-center w-full px-4 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-yellow-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-trash mr-2"></i>
                                Hapus Transaksi
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
                            <span class="text-slate-600">ID Transaksi:</span>
                            <span class="font-mono text-slate-800">#{{ $transaksi->sequential_number }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Dibuat:</span>
                            <span class="text-slate-800">{{ $transaksi->created_at->format('d M Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-600">Diperbarui:</span>
                            <span class="text-slate-800">{{ $transaksi->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
