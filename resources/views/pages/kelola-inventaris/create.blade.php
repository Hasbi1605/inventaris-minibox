@extends('layouts.admin')

@section('title', 'Tambah Inventaris')

@section('content')
<div class="flex flex-wrap -mx-3">
    <div class="flex-none w-full max-w-full px-3">
        <!-- Header -->
        <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="p-6 pb-0 mb-0 bg-white rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h6 class="mb-0 text-slate-700">Tambah Inventaris Baru</h6>
                    <a href="{{ route('kelola-inventaris.index') }}" class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer leading-pro text-xs ease-soft-in shadow-soft-md bg-150 bg-gradient-to-tl from-gray-900 to-slate-800 hover:shadow-soft-xs active:opacity-85 hover:scale-102">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex-auto p-6">
                <form action="{{ route('kelola-inventaris.store') }}" method="POST">
                    @csrf
                    <div class="flex flex-wrap -mx-3">
                        <!-- Nama Barang -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Nama Barang <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_barang" value="{{ old('nama_barang') }}" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_barang') border-red-500 @enderror" 
                                placeholder="Masukkan nama barang" required>
                            @error('nama_barang')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select name="kategori" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('kategori') border-red-500 @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ old('kategori') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                @endforeach
                                <option value="Peralatan Cukur" {{ old('kategori') == 'Peralatan Cukur' ? 'selected' : '' }}>Peralatan Cukur</option>
                                <option value="Produk Perawatan" {{ old('kategori') == 'Produk Perawatan' ? 'selected' : '' }}>Produk Perawatan</option>
                                <option value="Peralatan Salon" {{ old('kategori') == 'Peralatan Salon' ? 'selected' : '' }}>Peralatan Salon</option>
                                <option value="Bahan Kimia" {{ old('kategori') == 'Bahan Kimia' ? 'selected' : '' }}>Bahan Kimia</option>
                                <option value="Aksesoris" {{ old('kategori') == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                                <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('kategori')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Merek -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Merek
                            </label>
                            <input type="text" name="merek" value="{{ old('merek') }}" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('merek') border-red-500 @enderror" 
                                placeholder="Masukkan merek">
                            @error('merek')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Satuan -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Satuan <span class="text-red-500">*</span>
                            </label>
                            <select name="satuan" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('satuan') border-red-500 @enderror" required>
                                <option value="">Pilih Satuan</option>
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>Botol</option>
                                <option value="tube" {{ old('satuan') == 'tube' ? 'selected' : '' }}>Tube</option>
                                <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                                <option value="ml" {{ old('satuan') == 'ml' ? 'selected' : '' }}>ML</option>
                                <option value="gram" {{ old('satuan') == 'gram' ? 'selected' : '' }}>Gram</option>
                                <option value="kg" {{ old('satuan') == 'kg' ? 'selected' : '' }}>Kg</option>
                                <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>Set</option>
                                <option value="pack" {{ old('satuan') == 'pack' ? 'selected' : '' }}>Pack</option>
                            </select>
                            @error('satuan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok Minimal -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Stok Minimal <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stok_minimal" value="{{ old('stok_minimal') }}" min="0"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('stok_minimal') border-red-500 @enderror" 
                                placeholder="0" required>
                            @error('stok_minimal')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok Saat Ini -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Stok Saat Ini <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stok_saat_ini" value="{{ old('stok_saat_ini') }}" min="0"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('stok_saat_ini') border-red-500 @enderror" 
                                placeholder="0" required>
                            @error('stok_saat_ini')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga Satuan -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/3 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Harga Satuan <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="harga_satuan" value="{{ old('harga_satuan') }}" min="0" step="0.01"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('harga_satuan') border-red-500 @enderror" 
                                placeholder="0.00" required>
                            @error('harga_satuan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Kadaluarsa -->
                        <div class="w-full max-w-full px-3 mb-4 md:w-1/2 md:flex-none">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Tanggal Kadaluarsa
                            </label>
                            <input type="date" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('tanggal_kadaluarsa') border-red-500 @enderror">
                            @error('tanggal_kadaluarsa')
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
                                <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                                <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="w-full max-w-full px-3 mb-4">
                            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                Deskripsi
                            </label>
                            <textarea name="deskripsi" rows="4" 
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('deskripsi') border-red-500 @enderror" 
                                placeholder="Masukkan deskripsi barang (opsional)">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
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
