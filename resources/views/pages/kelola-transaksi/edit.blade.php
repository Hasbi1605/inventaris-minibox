@extends('layouts.admin')

@section('title', 'Edit Transaksi')
@section('page-title', 'Edit Transaksi')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Edit Transaksi</h4>
            <p class="mb-0 text-sm text-slate-500">Perbarui informasi transaksi: {{ $transaksi->nomor_transaksi }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('kelola-transaksi.show', $transaksi->id) }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-eye mr-2"></i>
                Lihat Detail
            </a>
            <a href="{{ route('kelola-transaksi.index') }}" 
                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="relative p-4 mb-4 text-red-700 bg-red-100 border border-red-300 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Form Edit Transaksi</h6>
                    <p class="text-sm leading-normal text-slate-400">Perbarui informasi transaksi di bawah ini</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-transaksi.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Pelanggan -->
                            <div>
                                <label for="nama_pelanggan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Nama Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_pelanggan" 
                                    id="nama_pelanggan"
                                    value="{{ old('nama_pelanggan', $transaksi->nama_pelanggan) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_pelanggan') border-red-500 @enderror"
                                    placeholder="Masukkan nama pelanggan"
                                    required
                                />
                                @error('nama_pelanggan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telepon Pelanggan -->
                            <div>
                                <label for="telepon_pelanggan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Telepon Pelanggan
                                </label>
                                <input 
                                    type="text" 
                                    name="telepon_pelanggan" 
                                    id="telepon_pelanggan"
                                    value="{{ old('telepon_pelanggan', $transaksi->telepon_pelanggan) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('telepon_pelanggan') border-red-500 @enderror"
                                    placeholder="Masukkan nomor telepon (opsional)"
                                />
                                @error('telepon_pelanggan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Layanan -->
                            <div>
                                <label for="layanan_id" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Layanan <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="layanan_id" 
                                    id="layanan_id"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('layanan_id') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Layanan</option>
                                    @foreach($layanan as $service)
                                        <option value="{{ $service->id }}" data-harga="{{ $service->harga }}" {{ old('layanan_id', $transaksi->layanan_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->nama_layanan }} - {{ $service->formatted_harga }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('layanan_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Total Harga -->
                            <div>
                                <label for="total_harga" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Total Harga <span class="text-red-500">*</span>
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 text-sm text-gray-700 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg">
                                        Rp
                                    </span>
                                    <input 
                                        type="number" 
                                        name="total_harga" 
                                        id="total_harga"
                                        value="{{ old('total_harga', $transaksi->total_harga) }}"
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-none rounded-r-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('total_harga') border-red-500 @enderror"
                                        placeholder="0"
                                        min="0"
                                        step="1000"
                                        required
                                    />
                                </div>
                                @error('total_harga')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Transaksi -->
                            <div>
                                <label for="tanggal_transaksi" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Tanggal Transaksi <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="tanggal_transaksi" 
                                    id="tanggal_transaksi"
                                    value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi->format('Y-m-d')) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('tanggal_transaksi') border-red-500 @enderror"
                                    required
                                />
                                @error('tanggal_transaksi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Waktu Mulai -->
                            <div>
                                <label for="waktu_mulai" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Waktu Mulai <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="time" 
                                    name="waktu_mulai" 
                                    id="waktu_mulai"
                                    value="{{ old('waktu_mulai', $transaksi->waktu_mulai) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('waktu_mulai') border-red-500 @enderror"
                                    required
                                />
                                @error('waktu_mulai')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Waktu Selesai -->
                            <div>
                                <label for="waktu_selesai" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Waktu Selesai
                                </label>
                                <input 
                                    type="time" 
                                    name="waktu_selesai" 
                                    id="waktu_selesai"
                                    value="{{ old('waktu_selesai', $transaksi->waktu_selesai) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('waktu_selesai') border-red-500 @enderror"
                                />
                                @error('waktu_selesai')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Metode Pembayaran -->
                            <div>
                                <label for="metode_pembayaran" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Metode Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="metode_pembayaran" 
                                    id="metode_pembayaran"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('metode_pembayaran') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="tunai" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                    <option value="kartu_debit" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'kartu_debit' ? 'selected' : '' }}>Kartu Debit</option>
                                    <option value="kartu_kredit" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                    <option value="transfer" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="ewallet" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                                </select>
                                @error('metode_pembayaran')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="status" 
                                    id="status"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('status') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Status</option>
                                    <option value="pending" {{ old('status', $transaksi->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="sedang_proses" {{ old('status', $transaksi->status) == 'sedang_proses' ? 'selected' : '' }}>Sedang Proses</option>
                                    <option value="selesai" {{ old('status', $transaksi->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ old('status', $transaksi->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Catatan -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="catatan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Catatan
                                </label>
                                <textarea 
                                    name="catatan" 
                                    id="catatan"
                                    rows="4"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('catatan') border-red-500 @enderror"
                                    placeholder="Masukkan catatan tambahan (opsional)"
                                >{{ old('catatan', $transaksi->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('kelola-transaksi.index') }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const layananSelect = document.getElementById('layanan_id');
        const totalHargaInput = document.getElementById('total_harga');

        layananSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            
            if (harga) {
                totalHargaInput.value = harga;
            } else {
                totalHargaInput.value = '';
            }
        });
    });
</script>
@endpush

