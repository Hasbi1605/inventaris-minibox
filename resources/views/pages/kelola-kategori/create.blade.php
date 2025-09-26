@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<!-- Page Header -->
<div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
    <div class="w-full max-w-full px-3 lg:w-1/2 lg:flex-none">
        <h6 class="mb-0 font-bold text-slate-800">
            <i class="fas fa-plus-circle mr-2 text-slate-600"></i>
            Tambah Kategori Baru
        </h6>
        <p class="text-sm leading-normal text-slate-500">
            Buat kategori baru untuk digunakan di seluruh aplikasi inventaris.
        </p>
    </div>
    <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-1/2 lg:flex-none">
        <div class="flex justify-end">
            <a href="{{ route('kelola-kategori.index', ['jenis' => $jenisKategori]) }}" 
               class="inline-block px-5 py-2.5 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer border-slate-200 leading-normal text-sm ease-in shadow-none bg-150 hover:bg-slate-100 hover:shadow-sm active:opacity-85 hover:-translate-y-px tracking-tight-rem">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
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

<div class="flex flex-wrap -mx-3">
    <!-- Main Form Section -->
    <div class="w-full max-w-full px-3 lg:w-2/3 lg:flex-none">
        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
            <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                <h6 class="mb-0 font-semibold text-slate-800">
                    <i class="fas fa-edit mr-2 text-slate-600"></i>
                    Informasi Kategori
                </h6>
            </div>
            <div class="flex-auto p-4 pt-2">

                <form action="{{ route('kelola-kategori.store') }}" method="POST">
                    @csrf
                    <!-- Nama & Kode Kategori -->
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                            <label for="nama_kategori" class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_kategori" 
                                   name="nama_kategori" 
                                   value="{{ old('nama_kategori') }}" 
                                   required 
                                   placeholder="Contoh: Potong Rambut" 
                                   class="form-input w-full @error('nama_kategori') border-red-500 @enderror">
                            @error('nama_kategori') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label for="kode_kategori" class="block text-sm font-medium text-slate-700 mb-2">
                                Kode Kategori
                            </label>
                            <input type="text" 
                                   id="kode_kategori" 
                                   name="kode_kategori" 
                                   value="{{ old('kode_kategori') }}" 
                                   placeholder="Otomatis jika kosong" 
                                   class="form-input w-full @error('kode_kategori') border-red-500 @enderror">
                            <p class="text-xs text-slate-500 mt-1">
                                <i class="fas fa-info-circle mr-1"></i>
                                Biarkan kosong untuk generate otomatis
                            </p>
                            @error('kode_kategori') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>

                    <!-- Jenis & Parent Kategori -->
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                            <label for="jenis_kategori" class="block text-sm font-medium text-slate-700 mb-2">
                                Jenis Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="jenis_kategori" 
                                    name="jenis_kategori" 
                                    required 
                                    class="form-select w-full @error('jenis_kategori') border-red-500 @enderror" 
                                    onchange="loadParentKategoris()">
                                <option value="">Pilih Jenis Kategori</option>
                                @foreach($jenisOptions as $key => $label)
                                    <option value="{{ $key }}" {{ (old('jenis_kategori') ?? $jenisKategori) === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_kategori') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div class="w-full md:w-1/2 px-3">
                            <label for="parent_id" class="block text-sm font-medium text-slate-700 mb-2">
                                Parent Kategori
                            </label>
                            <select id="parent_id" 
                                    name="parent_id" 
                                    class="form-select w-full @error('parent_id') border-red-500 @enderror">
                                <option value="">Tanpa Parent (Kategori Utama)</option>
                                @foreach($parentKategoris as $parent)
                                    <option value="{{ $parent->id }}" {{ (old('parent_id') ?? $parentId) == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-slate-500 mt-1">
                                <i class="fas fa-sitemap mr-1"></i>
                                Pilih parent untuk membuat sub-kategori
                            </p>
                            @error('parent_id') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" 
                                  name="deskripsi" 
                                  rows="3" 
                                  placeholder="Deskripsi singkat kategori (opsional)" 
                                  class="form-textarea w-full @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') 
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                        @enderror
                    </div>

                    <!-- Urutan, Warna, Ikon -->
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                            <label for="urutan" class="block text-sm font-medium text-slate-700 mb-2">
                                Urutan Tampilan
                            </label>
                            <input type="number" 
                                   id="urutan" 
                                   name="urutan" 
                                   value="{{ old('urutan', 0) }}" 
                                   min="0" 
                                   class="form-input w-full @error('urutan') border-red-500 @enderror"
                                   placeholder="0">
                            <p class="text-xs text-slate-500 mt-1">
                                <i class="fas fa-sort mr-1"></i>
                                Angka kecil akan tampil lebih dulu
                            </p>
                            @error('urutan') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-3 mb-4 md:mb-0">
                            <label for="warna" class="block text-sm font-medium text-slate-700 mb-2">
                                Warna Kategori
                            </label>
                            <div class="flex items-center space-x-2">
                                <input type="color" 
                                       id="warna" 
                                       name="warna" 
                                       value="{{ old('warna', '#4a90e2') }}" 
                                       class="h-10 w-16 p-1 rounded-lg border border-gray-300">
                                <input type="text" 
                                       id="warnaText" 
                                       value="{{ old('warna', '#4a90e2') }}" 
                                       readonly 
                                       class="form-input flex-1 bg-gray-50">
                            </div>
                            @error('warna') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div class="w-full md:w-1/3 px-3">
                            <label for="ikon" class="block text-sm font-medium text-slate-700 mb-2">
                                Ikon FontAwesome
                            </label>
                            <div class="relative">
                                <input type="text" 
                                       id="ikon" 
                                       name="ikon" 
                                       value="{{ old('ikon') }}" 
                                       placeholder="fas fa-tag" 
                                       class="form-input w-full pl-10 @error('ikon') border-red-500 @enderror">
                                <div id="ikonPreview" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-tag text-slate-400"></i>
                                </div>
                            </div>
                            <p class="text-xs text-slate-500 mt-1">
                                <i class="fas fa-icons mr-1"></i>
                                Gunakan class FontAwesome (opsional)
                            </p>
                            @error('ikon') 
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-slate-700 mb-3">Status Kategori</label>
                        <div class="flex items-center">
                            <input id="status" 
                                   name="status" 
                                   type="checkbox" 
                                   value="1" 
                                   {{ old('status', true) ? 'checked' : '' }} 
                                   class="form-check-input w-4 h-4 text-green-600 border-2 border-gray-300 rounded focus:ring-green-500 focus:ring-2">
                            <label for="status" class="ml-3 text-sm font-medium cursor-pointer select-none text-slate-700 flex items-center">
                                <i class="fas fa-toggle-on mr-2 text-green-500"></i>
                                Aktifkan Kategori
                            </label>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 ml-7">
                            Kategori yang tidak aktif tidak akan muncul dalam pilihan
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('kelola-kategori.index', ['jenis' => $jenisKategori]) }}" 
                           class="inline-block px-5 py-2.5 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer border-slate-200 leading-normal text-sm ease-in shadow-none bg-150 hover:bg-slate-100 hover:shadow-sm active:opacity-85 hover:-translate-y-px tracking-tight-rem">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-block px-5 py-2.5 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-normal text-sm ease-in shadow-md bg-150 hover:shadow-lg active:opacity-85 hover:-translate-y-px tracking-tight-rem">
                            <i class="fas fa-save mr-2"></i>
                            Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Section -->
    <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
        <div class="sticky top-6">
            <!-- Preview Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-semibold text-slate-800">
                        <i class="fas fa-eye mr-2 text-slate-600"></i>
                        Live Preview
                    </h6>
                </div>
                <div class="flex-auto p-4 pt-2">
                    <div id="kategoriPreview" class="text-center p-6 rounded-lg transition-all duration-300 border-2 border-dashed border-gray-200">
                        <div id="previewIcon" class="mb-3">
                            <i class="fas fa-tag text-4xl text-slate-400"></i>
                        </div>
                        <h5 id="previewNama" class="font-bold text-lg text-slate-800 mb-1">Nama Kategori</h5>
                        <p id="previewKode" class="text-sm text-slate-500 font-mono mb-3">KODE</p>
                        <div id="previewJenis">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Jenis Kategori
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bantuan Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-semibold text-slate-800">
                        <i class="fas fa-question-circle mr-2 text-slate-600"></i>
                        Panduan Pengisian
                    </h6>
                </div>
                <div class="flex-auto p-4 pt-2">
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <i class="fas fa-circle text-xs text-blue-500 mr-3 mt-1.5"></i>
                            <div>
                                <p class="text-sm font-medium text-slate-700 mb-1">Nama Kategori</p>
                                <p class="text-xs text-slate-500">Nama yang akan ditampilkan di seluruh aplikasi</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-circle text-xs text-green-500 mr-3 mt-1.5"></i>
                            <div>
                                <p class="text-sm font-medium text-slate-700 mb-1">Kode Kategori</p>
                                <p class="text-xs text-slate-500">Pengenal unik, akan dibuat otomatis jika kosong</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-circle text-xs text-purple-500 mr-3 mt-1.5"></i>
                            <div>
                                <p class="text-sm font-medium text-slate-700 mb-1">Parent Kategori</p>
                                <p class="text-xs text-slate-500">Pilih untuk membuat sub-kategori (hierarki)</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <i class="fas fa-circle text-xs text-orange-500 mr-3 mt-1.5"></i>
                            <div>
                                <p class="text-sm font-medium text-slate-700 mb-1">Warna & Ikon</p>
                                <p class="text-xs text-slate-500">Membantu identifikasi visual kategori</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaInput = document.getElementById('nama_kategori');
    const kodeInput = document.getElementById('kode_kategori');
    const jenisSelect = document.getElementById('jenis_kategori');
    const warnaInput = document.getElementById('warna');
    const warnaText = document.getElementById('warnaText');
    const ikonInput = document.getElementById('ikon');
    const ikonPreview = document.getElementById('ikonPreview');
    const previewCard = document.getElementById('kategoriPreview');
    const previewIcon = document.getElementById('previewIcon');
    const previewNama = document.getElementById('previewNama');
    const previewKode = document.getElementById('previewKode');
    const previewJenis = document.getElementById('previewJenis');

    function updatePreview() {
        const nama = namaInput.value || 'Nama Kategori';
        const kode = kodeInput.value || 'KODE';
        const jenisText = jenisSelect.options[jenisSelect.selectedIndex].text;
        const warna = warnaInput.value;
        const ikon = ikonInput.value || 'fas fa-tag';

        previewNama.textContent = nama;
        previewKode.textContent = kode;
        previewJenis.innerHTML = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">${jenisText}</span>`;
        previewIcon.innerHTML = `<i class="${ikon} text-4xl" style="color: ${warna}"></i>`;
        
        // Update preview card styling
        previewCard.style.borderColor = warna;
        previewCard.style.backgroundColor = warna + '10'; // Hex with light alpha
        
        // Update icon preview in form
        ikonPreview.innerHTML = `<i class="${ikonInput.value || 'fas fa-tag'} text-slate-400"></i>`;
    }

    namaInput.addEventListener('input', updatePreview);
    kodeInput.addEventListener('input', updatePreview);
    jenisSelect.addEventListener('change', updatePreview);
    ikonInput.addEventListener('input', updatePreview);
    warnaInput.addEventListener('input', function() {
        warnaText.value = this.value;
        updatePreview();
    });

    // Load parent categories based on selected jenis
    window.loadParentKategoris = function() {
        const jenisKategori = jenisSelect.value;
        const parentSelect = document.getElementById('parent_id');
        parentSelect.innerHTML = '<option value="">Tanpa Parent (Kategori Utama)</option>';

        if (jenisKategori) {
            fetch(`{{ route('kelola-kategori.getByJenis') }}?jenis=${jenisKategori}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.data.forEach(kategori => {
                            const option = new Option(kategori.nama_lengkap, kategori.id);
                            parentSelect.add(option);
                        });
                    }
                })
                .catch(error => console.error('Error loading parent categories:', error));
        }
    };

    updatePreview(); // Initial call
});
</script>
@endpush

@push('styles')
<style>
    .form-input, .form-select, .form-textarea {
        @apply focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none;
    }
    
    .sticky {
        position: -webkit-sticky;
        position: sticky;
    }
    
    #kategoriPreview {
        transition: all 0.3s ease;
    }
    
    .form-check-input:checked {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='m13.854 3.646-7.5 7.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6 10.293l7.146-7.147a.5.5 0 0 1 .708.708z'/%3e%3c/svg%3e");
    }
</style>
@endpush
