@extends('layouts.admin')

@section('title', 'Tambah Kapster')
@section('page-title', 'Tambah Kapster')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Tambah Kapster</h4>
            <p class="mb-0 text-sm text-slate-500">Tambahkan kapster baru untuk barbershop Anda</p>
        </div>
        <div>
            <a href="{{ route('kelola-kapster.index') }}" 
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
                    <h6 class="font-bold">Form Tambah Kapster</h6>
                    <p class="text-sm leading-normal text-slate-400">Isi form di bawah untuk menambahkan kapster baru</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-kapster.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Kapster -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="nama_kapster" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Nama Kapster <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_kapster" 
                                    id="nama_kapster"
                                    value="{{ old('nama_kapster') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_kapster') border-red-500 @enderror"
                                    placeholder="Masukkan nama kapster"
                                    required
                                />
                                @error('nama_kapster')
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
                                    @foreach($cabang as $item)
                                        <option value="{{ $item->id }}" {{ old('cabang_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama_cabang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cabang_id')
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

                            <!-- Spesialisasi -->
                            <div>
                                <label for="spesialisasi" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Spesialisasi (Opsional)
                                </label>
                                <input 
                                    type="text" 
                                    name="spesialisasi" 
                                    id="spesialisasi"
                                    value="{{ old('spesialisasi') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('spesialisasi') border-red-500 @enderror"
                                    placeholder="Contoh: Potongan rambut, Beard styling"
                                />
                                @error('spesialisasi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telepon -->
                            <div>
                                <label for="telepon" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    No. Telepon (Opsional)
                                </label>
                                <input 
                                    type="tel" 
                                    name="telepon" 
                                    id="telepon"
                                    value="{{ old('telepon') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('telepon') border-red-500 @enderror"
                                    placeholder="081234567890"
                                />
                                @error('telepon')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Komisi -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="komisi_persen" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Komisi (%) (Opsional)
                                </label>
                                <div class="flex">
                                    <input 
                                        type="number" 
                                        name="komisi_persen" 
                                        id="komisi_persen"
                                        value="{{ old('komisi_persen') }}"
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-l-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('komisi_persen') border-red-500 @enderror"
                                        placeholder="10"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                    />
                                    <span class="inline-flex items-center px-3 text-sm text-gray-700 bg-gray-200 border border-l-0 border-gray-300 rounded-r-lg">
                                        %
                                    </span>
                                </div>
                                <div class="text-xs text-slate-500 mt-1">
                                    Persentase komisi yang diterima kapster dari setiap transaksi
                                </div>
                                @error('komisi_persen')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('kelola-kapster.index') }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Kapster
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection