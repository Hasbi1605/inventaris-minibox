@extends('layouts.admin')

@section('title', 'Tambah Pengeluaran')
@section('page-title', 'Tambah Pengeluaran')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Tambah Pengeluaran</h4>
            <p class="mb-0 text-sm text-slate-500">Tambahkan catatan pengeluaran baru</p>
        </div>
        <div>
            <a href="{{ route('kelola-pengeluaran.index') }}" 
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
                    <h6 class="font-bold">Form Tambah Pengeluaran</h6>
                    <p class="text-sm leading-normal text-slate-400">Isi form di bawah untuk mencatat pengeluaran</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-pengeluaran.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4">
                            <!-- Deskripsi -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="deskripsi" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Deskripsi Pengeluaran <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="deskripsi" 
                                    id="deskripsi"
                                    value="{{ old('deskripsi') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('deskripsi') border-red-500 @enderror"
                                    placeholder="Contoh: Pembelian pomade"
                                    required
                                />
                                @error('deskripsi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jumlah -->
                            <div>
                                <label for="jumlah" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Jumlah Pengeluaran <span class="text-red-500">*</span>
                                </label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 text-sm text-gray-700 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg">
                                        Rp
                                    </span>
                                    <input 
                                        type="number" 
                                        name="jumlah" 
                                        id="jumlah"
                                        value="{{ old('jumlah') }}"
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-none rounded-r-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('jumlah') border-red-500 @enderror"
                                        placeholder="0"
                                        min="0"
                                        step="1000"
                                        required
                                    />
                                </div>
                                @error('jumlah')
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
                                        <option value="{{ $id }}" {{ old('kategori_id') == $id ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>
                                <div class="text-xs text-slate-500 mt-1">
                                    Tidak ada kategori yang sesuai? 
                                    <a href="{{ route('kelola-kategori.create', ['jenis' => 'pengeluaran']) }}" target="_blank" class="text-blue-500 hover:underline">
                                        Tambah kategori baru
                                    </a>
                                </div>
                                @error('kategori_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Pengeluaran -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="tanggal_pengeluaran" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Tanggal Pengeluaran <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="tanggal_pengeluaran" 
                                    id="tanggal_pengeluaran"
                                    value="{{ old('tanggal_pengeluaran', date('Y-m-d')) }}"
                                    max="{{ date('Y-m-d') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('tanggal_pengeluaran') border-red-500 @enderror"
                                    required
                                />
                                @error('tanggal_pengeluaran')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Catatan -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="catatan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Catatan (Opsional)
                                </label>
                                <textarea 
                                    name="catatan" 
                                    id="catatan"
                                    rows="4"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('catatan') border-red-500 @enderror"
                                    placeholder="Catatan tambahan tentang pengeluaran ini..."
                                >{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('kelola-pengeluaran.index') }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Pengeluaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection