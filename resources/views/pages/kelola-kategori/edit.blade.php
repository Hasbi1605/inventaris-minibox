@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Edit Kategori</h4>
            <p class="mb-0 text-sm text-slate-500">Perbarui kategori: {{ $kategori->nama_kategori }}</p>
        </div>
        <div>
            <a href="{{ route('kelola-kategori.index', ['jenis' => $kategori->jenis_kategori]) }}" 
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
                    <h6 class="font-bold">Form Edit Kategori</h6>
                    <p class="text-sm leading-normal text-slate-400">Perbarui informasi kategori di bawah</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">

                    <form action="{{ route('kelola-kategori.update', $kategori->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Kategori -->
                            <div>
                                <label for="nama_kategori" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Nama Kategori <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_kategori" 
                                    id="nama_kategori"
                                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_kategori') border-red-500 @enderror"
                                    placeholder="Contoh: Potong Rambut"
                                    required
                                />
                                @error('nama_kategori')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kode Kategori -->
                            <div>
                                <label for="kode_kategori" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Kode Kategori
                                </label>
                                <input 
                                    type="text" 
                                    id="kode_kategori"
                                    value="{{ $kategori->kode_kategori }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all cursor-not-allowed"
                                    readonly
                                    disabled
                                />
                                <!-- Hidden input untuk menyimpan kode kategori asli -->
                                <input type="hidden" name="kode_kategori" value="{{ $kategori->kode_kategori }}" />
                                <div class="text-xs text-slate-500 mt-1">
                                    <i class="fas fa-lock mr-1"></i>
                                    Kode tidak dapat diubah setelah dibuat
                                </div>
                                @error('kode_kategori')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Jenis Kategori -->
                            <div>
                                <label for="jenis_kategori" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Jenis Kategori <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="jenis_kategori" 
                                    id="jenis_kategori"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('jenis_kategori') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Jenis Kategori</option>
                                    @foreach($jenisOptions as $key => $label)
                                        <option value="{{ $key }}" {{ old('jenis_kategori', $kategori->jenis_kategori) == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_kategori')
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
                                    <option value="1" {{ old('status', $kategori->status) == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('status', $kategori->status) == '0' ? 'selected' : '' }}>Non-aktif</option>
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
                                    rows="3"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('deskripsi') border-red-500 @enderror"
                                    placeholder="Deskripsi singkat kategori (opsional)"
                                >{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('kelola-kategori.index', ['jenis' => $kategori->jenis_kategori]) }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Kategori
                            </button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection

