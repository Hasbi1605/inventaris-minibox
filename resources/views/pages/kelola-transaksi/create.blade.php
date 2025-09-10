@extends('layouts.admin')

@section('title', 'Tambah Transaksi')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Tambah Transaksi Baru</h6>
                    <a href="{{ route('kelola-transaksi.index') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-6">
                <form action="{{ route('kelola-transaksi.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap -mx-3">
                        <!-- Nama Pelanggan -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Nama Pelanggan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_pelanggan') border-red-500 @enderror" 
                                placeholder="Masukkan nama pelanggan" required>
                            @error('nama_pelanggan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Telepon Pelanggan -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Telepon Pelanggan
                            </label>
                            <input type="text" name="telepon_pelanggan" value="{{ old('telepon_pelanggan') }}" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('telepon_pelanggan') border-red-500 @enderror" 
                                placeholder="Masukkan nomor telepon (opsional)">
                            @error('telepon_pelanggan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Layanan -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Layanan <span class="text-red-500">*</span>
                            </label>
                            <select name="layanan_id" id="layanan_id"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('layanan_id') border-red-500 @enderror" required>
                                <option value="">Pilih Layanan</option>
                                @foreach($layanan as $service)
                                    <option value="{{ $service->id }}" data-harga="{{ $service->harga }}" {{ old('layanan_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->nama_layanan }} - {{ $service->formatted_harga }}
                                    </option>
                                @endforeach
                            </select>
                            @error('layanan_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Harga -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Total Harga <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="total_harga" id="total_harga" value="{{ old('total_harga') }}" min="0" step="0.01"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('total_harga') border-red-500 @enderror" 
                                placeholder="0.00" required>
                            @error('total_harga')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Transaksi -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Tanggal Transaksi <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_transaksi" value="{{ old('tanggal_transaksi', date('Y-m-d')) }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('tanggal_transaksi') border-red-500 @enderror" required>
                            @error('tanggal_transaksi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Mulai -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Waktu Mulai <span class="text-red-500">*</span>
                            </label>
                            <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('waktu_mulai') border-red-500 @enderror" required>
                            @error('waktu_mulai')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Waktu Selesai -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Waktu Selesai
                            </label>
                            <input type="time" name="waktu_selesai" value="{{ old('waktu_selesai') }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('waktu_selesai') border-red-500 @enderror">
                            @error('waktu_selesai')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Metode Pembayaran <span class="text-red-500">*</span>
                            </label>
                            <select name="metode_pembayaran" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('metode_pembayaran') border-red-500 @enderror" required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                <option value="kartu_debit" {{ old('metode_pembayaran') == 'kartu_debit' ? 'selected' : '' }}>Kartu Debit</option>
                                <option value="kartu_kredit" {{ old('metode_pembayaran') == 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="ewallet" {{ old('metode_pembayaran') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                            </select>
                            @error('metode_pembayaran')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('status') border-red-500 @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="sedang_proses" {{ old('status') == 'sedang_proses' ? 'selected' : '' }}>Sedang Proses</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="w-full max-w-full px-3 mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Catatan
                            </label>
                            <textarea name="catatan" rows="4" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('catatan') border-red-500 @enderror" 
                                placeholder="Masukkan catatan tambahan (opsional)">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end mt-6">
                        <button type="submit" class="inline-block px-8 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto fill total harga when layanan is selected
    document.getElementById('layanan_id').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const harga = selectedOption.getAttribute('data-harga');
        if (harga) {
            document.getElementById('total_harga').value = harga;
        }
    });
</script>
@endpush
