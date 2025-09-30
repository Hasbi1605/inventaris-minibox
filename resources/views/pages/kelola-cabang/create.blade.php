@extends('layouts.admin')

@section('title', 'Tambah Cabang')
@section('page-title', 'Tambah Cabang')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Tambah Cabang</h4>
            <p class="mb-0 text-sm text-slate-500">Tambahkan cabang baru untuk barbershop Anda</p>
        </div>
        <div>
            <a href="{{ route('kelola-cabang.index') }}" 
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
                    <h6 class="font-bold">Form Tambah Cabang</h6>
                    <p class="text-sm leading-normal text-slate-400">Isi form di bawah untuk menambahkan cabang baru</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-cabang.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Cabang -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="nama_cabang" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Nama Cabang <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_cabang" 
                                    id="nama_cabang"
                                    value="{{ old('nama_cabang') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_cabang') border-red-500 @enderror"
                                    placeholder="Masukkan nama cabang"
                                    required
                                />
                                @error('nama_cabang')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Manager -->
                            <div>
                                <label for="manager" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Manager <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="manager" 
                                    id="manager"
                                    value="{{ old('manager') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('manager') border-red-500 @enderror"
                                    placeholder="Masukkan nama manager"
                                    required
                                />
                                @error('manager')
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
                                    @foreach($statusOptions as $key => $value)
                                        <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('status')
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
                                    @foreach($kategori as $item)
                                        <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Alamat -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="alamat" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Alamat <span class="text-red-500">*</span>
                                </label>
                                <textarea 
                                    name="alamat" 
                                    id="alamat"
                                    rows="4"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('alamat') border-red-500 @enderror"
                                    placeholder="Masukkan alamat lengkap cabang"
                                    required
                                >{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jam Operasional Buka -->
                            <div>
                                <label for="jam_operasional_buka" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Jam Buka (Opsional)
                                </label>
                                <input 
                                    type="time" 
                                    name="jam_operasional_buka" 
                                    id="jam_operasional_buka"
                                    value="{{ old('jam_operasional_buka', '09:00') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('jam_operasional_buka') border-red-500 @enderror"
                                />
                                @error('jam_operasional_buka')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jam Operasional Tutup -->
                            <div>
                                <label for="jam_operasional_tutup" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Jam Tutup (Opsional)
                                </label>
                                <input 
                                    type="time" 
                                    name="jam_operasional_tutup" 
                                    id="jam_operasional_tutup"
                                    value="{{ old('jam_operasional_tutup', '21:00') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('jam_operasional_tutup') border-red-500 @enderror"
                                />
                                @error('jam_operasional_tutup')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Deskripsi -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="deskripsi" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Deskripsi (Opsional)
                                </label>
                                <textarea 
                                    name="deskripsi" 
                                    id="deskripsi"
                                    rows="4"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('deskripsi') border-red-500 @enderror"
                                    placeholder="Masukkan deskripsi atau catatan tambahan"
                                >{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('kelola-cabang.index') }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Cabang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection