@extends('layouts.admin')

@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Tambah Pengeluaran Baru</h6>
                    <a href="{{ route('kelola-pengeluaran.index') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 text-slate-700">Informasi Pengeluaran</h6>
            </div>
            <div class="flex-auto p-6">
                <form action="{{ route('kelola-pengeluaran.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap -mx-3">
                        <!-- Deskripsi -->
                        <div class="w-full max-w-full px-3 mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Deskripsi Pengeluaran <span class="text-red-500">*</span></label>
                            <input type="text" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Contoh: Pembelian peralatan barbershop" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('deskripsi') border-red-300 @enderror" required>
                            @error('deskripsi')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('kategori') border-red-300 @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $key => $value)
                                <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                            @error('kategori')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Jumlah Pengeluaran <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-500">Rp</span>
                                <input type="text" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" placeholder="0" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding pl-8 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('jumlah') border-red-300 @enderror" required>
                            </div>
                            @error('jumlah')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Pengeluaran -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Tanggal Pengeluaran <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_pengeluaran" value="{{ old('tanggal_pengeluaran', date('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('tanggal_pengeluaran') border-red-300 @enderror" required>
                            @error('tanggal_pengeluaran')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div class="w-full max-w-full px-3 mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Catatan (Opsional)</label>
                            <textarea name="catatan" rows="4" placeholder="Catatan tambahan tentang pengeluaran ini..." class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('catatan') border-red-300 @enderror">{{ old('catatan') }}</textarea>
                            @error('catatan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="w-full px-3 flex gap-4">
                            <button type="submit" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-green-600 to-lime-400 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                <i class="fas fa-save mr-2"></i>Simpan Pengeluaran
                            </button>
                            <a href="{{ route('kelola-pengeluaran.index') }}" class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-slate-700 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for currency formatting -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jumlahInput = document.getElementById('jumlah');
    
    // Format number as currency
    function formatCurrency(value) {
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    
    // Remove currency formatting
    function unformatCurrency(value) {
        return value.replace(/\./g, '');
    }
    
    jumlahInput.addEventListener('input', function() {
        let value = this.value.replace(/\./g, '');
        if (value !== '') {
            this.value = formatCurrency(value);
        }
    });
    
    // Remove formatting before form submission
    document.querySelector('form').addEventListener('submit', function() {
        jumlahInput.value = unformatCurrency(jumlahInput.value);
    });
});
</script>
@endsection
