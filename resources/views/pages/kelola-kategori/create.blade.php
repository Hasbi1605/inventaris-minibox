@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Form Card -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6">
            <!-- Page Header -->
            <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
                <div class="w-full max-w-full px-3 sm:w-auto">
                    <h6 class="mb-0 font-bold text-slate-800">
                        Formulir Tambah Kategori
                    </h6>
                    <p class="text-sm leading-normal text-slate-500">
                        Buat kategori baru untuk digunakan di seluruh aplikasi.
                    </p>
                </div>
                <div class="w-full max-w-full px-3 mt-4 sm:mt-0 sm:w-auto">
                    <a href="{{ route('kelola-kategori.index', ['jenis' => $jenisKategori]) }}" 
                       class="inline-block px-5 py-2.5 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer border-slate-200 leading-normal text-sm ease-in shadow-none bg-150 hover:bg-slate-100 hover:shadow-sm active:opacity-85 hover:-translate-y-px tracking-tight-rem">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>

            <form action="{{ route('kelola-kategori.store') }}" method="POST" class="flex flex-wrap -mx-3">
                @csrf
                <div class="w-full lg:w-2/3 px-3">
                    <div class="flex flex-col gap-6">
                        <!-- Nama & Kode Kategori -->
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="nama_kategori" class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                                <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori') }}" required placeholder="Contoh: Potong Rambut" class="form-input w-full @error('nama_kategori') border-red-500 @enderror">
                                @error('nama_kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label for="kode_kategori" class="block text-sm font-medium text-slate-700 mb-1">Kode Kategori</label>
                                <input type="text" id="kode_kategori" name="kode_kategori" value="{{ old('kode_kategori') }}" placeholder="Otomatis jika kosong" class="form-input w-full @error('kode_kategori') border-red-500 @enderror">
                                <p class="text-xs text-slate-500 mt-1">Biarkan kosong untuk generate otomatis.</p>
                                @error('kode_kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Jenis & Parent Kategori -->
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="jenis_kategori" class="block text-sm font-medium text-slate-700 mb-1">Jenis Kategori <span class="text-red-500">*</span></label>
                                <select id="jenis_kategori" name="jenis_kategori" required class="form-select w-full @error('jenis_kategori') border-red-500 @enderror" onchange="loadParentKategoris()">
                                    <option value="">Pilih Jenis</option>
                                    @foreach($jenisOptions as $key => $label)
                                        <option value="{{ $key }}" {{ (old('jenis_kategori') ?? $jenisKategori) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label for="parent_id" class="block text-sm font-medium text-slate-700 mb-1">Parent Kategori</label>
                                <select id="parent_id" name="parent_id" class="form-select w-full @error('parent_id') border-red-500 @enderror">
                                    <option value="">Tanpa Parent (Kategori Utama)</option>
                                    @foreach($parentKategoris as $parent)
                                        <option value="{{ $parent->id }}" {{ (old('parent_id') ?? $parentId) == $parent->id ? 'selected' : '' }}>{{ $parent->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi singkat kategori (opsional)" class="form-textarea w-full @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Urutan, Warna, Ikon -->
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <label for="urutan" class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                                <input type="number" id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0" class="form-input w-full @error('urutan') border-red-500 @enderror">
                                @error('urutan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <label for="warna" class="block text-sm font-medium text-slate-700 mb-1">Warna</label>
                                <div class="flex items-center">
                                    <input type="color" id="warna" name="warna" value="{{ old('warna', '#4a90e2') }}" class="h-10 p-1 rounded-lg">
                                    <input type="text" id="warnaText" value="{{ old('warna', '#4a90e2') }}" readonly class="form-input w-full ml-2">
                                </div>
                                @error('warna') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-full md:w-1/3 px-3">
                                <label for="ikon" class="block text-sm font-medium text-slate-700 mb-1">Ikon</label>
                                <div class="relative">
                                    <input type="text" id="ikon" name="ikon" value="{{ old('ikon') }}" placeholder="fas fa-tag" class="form-input w-full pl-10 @error('ikon') border-red-500 @enderror">
                                    <div id="ikonPreview" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-tag text-slate-400"></i>
                                    </div>
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Gunakan class FontAwesome.</p>
                                @error('ikon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <div class="form-check form-switch pl-0">
                                <input id="status" name="status" type="checkbox" value="1" {{ old('status', true) ? 'checked' : '' }} class="form-check-input w-10 h-5 m-0 align-top bg-center bg-no-repeat bg-contain border-2 border-solid rounded-full appearance-none cursor-pointer border-slate-200 checked:bg-gradient-to-tl checked:from-green-600 checked:to-lime-400 checked:border-green-500">
                                <label for="status" class="ml-3 text-sm font-normal cursor-pointer select-none text-slate-700">Aktifkan Kategori</label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-4 pt-4 border-t border-gray-200 mt-6">
                            <a href="{{ route('kelola-kategori.index', ['jenis' => $jenisKategori]) }}" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">Simpan Kategori</button>
                        </div>
                    </div>
                </div>

                <!-- Preview & Bantuan -->
                <div class="w-full lg:w-1/3 px-3 mt-6 lg:mt-0">
                    <div class="sticky top-6 flex flex-col gap-6">
                        <!-- Preview Card -->
                        <div class="relative flex flex-col min-w-0 break-words bg-slate-50 border border-solid shadow-none rounded-2xl border-slate-200 bg-clip-border">
                            <div class="p-4">
                                <h6 class="font-bold text-slate-800 mb-4">Preview</h6>
                                <div id="kategoriPreview" class="text-center p-6 rounded-lg transition-all duration-300" style="border: 2px dashed #e2e8f0;">
                                    <div id="previewIcon" class="mb-3">
                                        <i class="fas fa-tag text-4xl text-slate-400"></i>
                                    </div>
                                    <h5 id="previewNama" class="font-bold text-lg text-slate-800">Nama Kategori</h5>
                                    <p id="previewKode" class="text-sm text-slate-500 font-mono">KODE</p>
                                    <div id="previewJenis" class="mt-3">
                                        <span class="badge-secondary">Jenis Kategori</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Bantuan Card -->
                        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="p-4">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                    <h6 class="font-bold text-slate-800 mb-0">Bantuan</h6>
                                </div>
                                <ul class="list-disc list-inside text-sm text-slate-600 space-y-2 pl-2">
                                    <li><strong>Nama Kategori</strong> adalah nama yang akan ditampilkan di seluruh aplikasi.</li>
                                    <li><strong>Kode Kategori</strong> adalah pengenal unik. Jika dikosongkan, akan dibuat otomatis.</li>
                                    <li><strong>Parent Kategori</strong> digunakan untuk membuat sub-kategori (hierarki).</li>
                                    <li><strong>Warna & Ikon</strong> membantu identifikasi visual kategori.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
        previewJenis.innerHTML = `<span class="badge-secondary">${jenisText}</span>`;
        previewIcon.innerHTML = `<i class="${ikon} text-4xl" style="color: ${warna}"></i>`;
        previewCard.style.borderColor = warna;
        previewCard.style.backgroundColor = warna + '1A'; // Hex with alpha
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
    .btn-primary {
        @apply inline-block px-5 py-2.5 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-normal text-sm ease-in shadow-md bg-150 hover:shadow-lg active:opacity-85 hover:-translate-y-px tracking-tight-rem;
    }
    .btn-secondary {
        @apply inline-block px-5 py-2.5 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer border-slate-200 leading-normal text-sm ease-in shadow-none bg-150 hover:bg-slate-100 hover:shadow-sm active:opacity-85 hover:-translate-y-px tracking-tight-rem;
    }
    .badge-secondary {
        @apply inline-block px-2 py-1 text-xs font-semibold leading-tight text-center text-slate-600 uppercase align-baseline rounded-lg bg-gray-200;
    }
</style>
@endpush
