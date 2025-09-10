@extends('layouts.admin')

@section('title', 'Tambah Layanan')
@section('page-title', 'Tambah Layanan')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Tambah Layanan</h4>
            <p class="mb-0 text-sm text-slate-500">Tambahkan layanan baru untuk barbershop Anda</p>
        </div>
        <div>
            <a href="{{ route('kelola-layanan.index') }}" 
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
                    <h6 class="font-bold">Form Tambah Layanan</h6>
                    <p class="text-sm leading-normal text-slate-400">Isi form di bawah untuk menambahkan layanan baru</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-layanan.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Layanan -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="nama_layanan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Nama Layanan <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_layanan" 
                                    id="nama_layanan"
                                    value="{{ old('nama_layanan') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_layanan') border-red-500 @enderror"
                                    placeholder="Masukkan nama layanan"
                                    required
                                />
                                @error('nama_layanan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Kategori
                                </label>
                                <select 
                                    name="kategori" 
                                    id="kategori"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('kategori') border-red-500 @enderror"
                                >
                                    <option value="">Pilih Kategori (Opsional)</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('kategori') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                    <option value="other">Kategori Lain</option>
                                </select>
                                <input 
                                    type="text" 
                                    name="kategori_custom" 
                                    id="kategori_custom"
                                    value="{{ old('kategori_custom') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow mt-2 hidden"
                                    placeholder="Masukkan kategori baru"
                                />
                                @error('kategori')
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
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non-aktif</option>
                                </select>
                                @error('status')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Harga -->
                            <div>
                                <label for="harga" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Harga <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                    <input 
                                        type="number" 
                                        name="harga" 
                                        id="harga"
                                        value="{{ old('harga') }}"
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding pl-8 pr-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('harga') border-red-500 @enderror"
                                        placeholder="0"
                                        min="0"
                                        step="1000"
                                        required
                                    />
                                </div>
                                @error('harga')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Durasi Estimasi -->
                            <div>
                                <label for="durasi_estimasi" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Durasi Estimasi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        name="durasi_estimasi" 
                                        id="durasi_estimasi"
                                        value="{{ old('durasi_estimasi') }}"
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 pr-16 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('durasi_estimasi') border-red-500 @enderror"
                                        placeholder="30"
                                        min="1"
                                        max="480"
                                        required
                                    />
                                    <span class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">menit</span>
                                </div>
                                @error('durasi_estimasi')
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
                                    placeholder="Masukkan deskripsi layanan (opsional)"
                                >{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('kelola-layanan.index') }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Layanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const kategoriSelect = document.getElementById('kategori');
    const kategoriCustomInput = document.getElementById('kategori_custom');
    
    kategoriSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            kategoriCustomInput.classList.remove('hidden');
            kategoriCustomInput.required = true;
            kategoriCustomInput.name = 'kategori';
            kategoriSelect.name = 'kategori_select';
        } else {
            kategoriCustomInput.classList.add('hidden');
            kategoriCustomInput.required = false;
            kategoriCustomInput.name = 'kategori_custom';
            kategoriSelect.name = 'kategori';
        }
    });
});
</script>
@endsection
