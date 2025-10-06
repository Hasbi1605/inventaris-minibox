@extends('layouts.admin')

@section('title', 'Tambah Inventaris')

@section('page-title', 'Tambah Inventaris')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Tambah Inventaris</h4>
            <p class="mb-0 text-sm text-slate-500">Tambahkan inventaris baru untuk barbershop Anda</p>
        </div>
        <div>
            <a href="{{ route('kelola-inventaris.index') }}"
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

    <!-- Form Card -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Form Tambah Inventaris</h6>
                    <p class="text-sm leading-normal text-slate-400">Isi form di bawah untuk menambahkan inventaris baru</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-inventaris.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4">
                            <!-- Nama Barang -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="nama_barang" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Nama Barang <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nama_barang"
                                    id="nama_barang"
                                    value="{{ old('nama_barang') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_barang') border-red-500 @enderror"
                                    placeholder="Masukkan nama barang"
                                    required
                                />
                                @error('nama_barang')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori_id" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="kategori_id"
                                    id="kategori_id"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('kategori_id') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $id => $nama)
                                        <option value="{{ $id }}" {{ old('kategori_id') == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-xs text-slate-500 mt-1">
                                    Tidak ada kategori yang sesuai? 
                                    <a href="{{ route('kelola-kategori.create', ['jenis' => 'inventaris']) }}" target="_blank" class="text-blue-500 hover:underline">
                                        Tambah kategori baru
                                    </a>
                                </div>
                                @error('kategori_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Cabang -->
                            <div>
                                <label for="cabang_id" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Cabang <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="cabang_id"
                                    id="cabang_id"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('cabang_id') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Cabang</option>
                                    @foreach($cabangList as $cabang)
                                        <option value="{{ $cabang->id }}" {{ old('cabang_id') == $cabang->id ? 'selected' : '' }}>
                                            {{ $cabang->nama_cabang }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-xs text-slate-500 mt-1">
                                    Stok inventaris terkait dengan cabang ini
                                </div>
                                @error('cabang_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Satuan -->
                            <div>
                                <label for="satuan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Satuan <span class="text-red-500">*</span>
                                </label>
                                <select
                                    name="satuan"
                                    id="satuan"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('satuan') border-red-500 @enderror"
                                    required
                                >
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
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stok Minimal -->
                            <div>
                                <label for="stok_minimal" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Stok Minimal <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="stok_minimal"
                                    id="stok_minimal"
                                    value="{{ old('stok_minimal') }}"
                                    min="0"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('stok_minimal') border-red-500 @enderror"
                                    placeholder="0"
                                    required
                                />
                                @error('stok_minimal')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Stok Saat Ini -->
                            <div>
                                <label for="stok_saat_ini" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Stok Saat Ini <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="stok_saat_ini"
                                    id="stok_saat_ini"
                                    value="{{ old('stok_saat_ini') }}"
                                    min="0"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('stok_saat_ini') border-red-500 @enderror"
                                    placeholder="0"
                                    required
                                />
                                @error('stok_saat_ini')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga Satuan -->
                            <div>
                                <label for="harga_satuan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Harga Satuan <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    name="harga_satuan" 
                                    id="harga_satuan"
                                    value="{{ old('harga_satuan') }}" 
                                    min="0" 
                                    step="0.01"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('harga_satuan') border-red-500 @enderror"
                                    placeholder="0.00"
                                    required
                                />
                                @error('harga_satuan')
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
                                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="habis" {{ old('status') == 'habis' ? 'selected' : '' }}>Habis</option>
                                    <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                                </select>
                                @error('status')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="deskripsi" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Deskripsi
                                </label>
                                <textarea 
                                    name="deskripsi" 
                                    id="deskripsi"
                                    rows="4"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('deskripsi') border-red-500 @enderror"
                                    placeholder="Masukkan deskripsi barang (opsional)"
                                >{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end mt-6 gap-3">
                            <a href="{{ route('kelola-inventaris.index') }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" 
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Inventaris
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection
