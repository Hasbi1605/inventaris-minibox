@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<!-- Page Header -->
<div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
    <div class="w-full max-w-full px-3 lg:w-1/2 lg:flex-none">
        <h6 class="mb-0 font-bold text-slate-800">
            <i class="fas fa-edit mr-2 text-slate-600"></i>
            Edit Kategori
        </h6>
        <p class="text-sm leading-normal text-slate-500">
            Perbarui detail untuk kategori: <span class="font-semibold text-slate-700">{{ $kategori->nama_kategori }}</span>
        </p>
    </div>
    <div class="w-full max-w-full px-3 mt-4 lg:mt-0 lg:w-1/2 lg:flex-none">
        <div class="flex justify-end">
            <a href="{{ route('kelola-kategori.index', ['jenis' => $kategori->jenis_kategori]) }}" 
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

                <form action="{{ route('kelola-kategori.update', $kategori->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Nama & Kode Kategori -->
                    <div class="flex flex-wrap -mx-3 mb-4">
                        <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                            <label for="nama_kategori" class="block text-sm font-medium text-slate-700 mb-2">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama_kategori" 
                                   name="nama_kategori" 
                                   value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                   required 
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
                                   value="{{ old('kode_kategori', $kategori->kode_kategori) }}" 
                                   class="form-input w-full bg-slate-100 cursor-not-allowed @error('kode_kategori') border-red-500 @enderror" 
                                   readonly>
                            <p class="text-xs text-slate-500 mt-1">
                                <i class="fas fa-lock mr-1"></i>
                                Kode tidak dapat diubah setelah dibuat
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
                                @foreach($jenisOptions as $key => $label)
                                    <option value="{{ $key }}" {{ old('jenis_kategori', $kategori->jenis_kategori) === $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @if($kategori->children && $kategori->children->count() > 0)
                                <p class="text-xs text-orange-500 mt-1">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Perubahan akan mempengaruhi {{ $kategori->children->count() }} sub-kategori
                                </p>
                            @endif
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
                                    <option value="{{ $parent->id }}" {{ old('parent_id', $kategori->parent_id) == $parent->id ? 'selected' : '' }}>
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
                                  class="form-textarea w-full @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
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
                                   value="{{ old('urutan', $kategori->urutan) }}" 
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
                                       value="{{ old('warna', $kategori->warna ?: '#4a90e2') }}" 
                                       class="h-10 w-16 p-1 rounded-lg border border-gray-300">
                                <input type="text" 
                                       id="warnaText" 
                                       value="{{ old('warna', $kategori->warna ?: '#4a90e2') }}" 
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
                                       value="{{ old('ikon', $kategori->ikon) }}" 
                                       placeholder="fas fa-tag" 
                                       class="form-input w-full pl-10 @error('ikon') border-red-500 @enderror">
                                <div id="ikonPreview" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="{{ $kategori->ikon ?: 'fas fa-tag' }} text-slate-400"></i>
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
                                   {{ old('status', $kategori->status) ? 'checked' : '' }} 
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
                        <a href="{{ route('kelola-kategori.index', ['jenis' => $kategori->jenis_kategori]) }}" 
                           class="inline-block px-5 py-2.5 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer border-slate-200 leading-normal text-sm ease-in shadow-none bg-150 hover:bg-slate-100 hover:shadow-sm active:opacity-85 hover:-translate-y-px tracking-tight-rem">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="inline-block px-5 py-2.5 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-normal text-sm ease-in shadow-md bg-150 hover:shadow-lg active:opacity-85 hover:-translate-y-px tracking-tight-rem">
                            <i class="fas fa-save mr-2"></i>
                            Perbarui Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Section -->
    <div class="w-full max-w-full px-3 lg:w-1/3 lg:flex-none">
        <div class="sticky top-6">
            <!-- Current Info Card -->
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border mb-6">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-semibold text-slate-800">
                        <i class="fas fa-info-circle mr-2 text-slate-600"></i>
                        Informasi Saat Ini
                    </h6>
                </div>
                <div class="flex-auto p-4 pt-2">
                    <div class="flex items-center mb-4 p-3 rounded-lg bg-gray-50">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-3" style="background-color: {{ $kategori->warna ?: '#e2e8f0' }};">
                            <i class="{{ $kategori->ikon ?: 'fas fa-tag' }} text-xl text-white"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 font-semibold text-slate-700">{{ $kategori->nama_kategori }}</h6>
                            <p class="text-xs text-slate-500 font-mono mb-0">{{ $kategori->kode_kategori }}</p>
                            <p class="text-xs text-slate-500 mb-0">
                                <i class="fas fa-layer-group mr-1"></i>
                                {{ ucfirst($kategori->jenis_kategori) }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="text-sm font-semibold text-slate-700 mb-2">Statistik Penggunaan:</h6>
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="py-3 rounded-lg bg-blue-50 border border-blue-200">
                                <p class="text-lg font-bold text-blue-600 mb-0">{{ optional($kategori->inventaris)->count() ?? 0 }}</p>
                                <p class="text-xs text-blue-600 mb-0">Inventaris</p>
                            </div>
                            <div class="py-3 rounded-lg bg-green-50 border border-green-200">
                                <p class="text-lg font-bold text-green-600 mb-0">{{ optional($kategori->layanan)->count() ?? 0 }}</p>
                                <p class="text-xs text-green-600 mb-0">Layanan</p>
                            </div>
                            <div class="py-3 rounded-lg bg-red-50 border border-red-200">
                                <p class="text-lg font-bold text-red-600 mb-0">{{ optional($kategori->pengeluaran)->count() ?? 0 }}</p>
                                <p class="text-xs text-red-600 mb-0">Pengeluaran</p>
                            </div>
                        </div>
                    </div>

                    @if($kategori->parent)
                        <div class="mb-3">
                            <p class="text-sm text-slate-600">
                                <i class="fas fa-sitemap mr-1"></i>
                                <strong>Parent:</strong> {{ $kategori->parent->nama_kategori }}
                            </p>
                        </div>
                    @endif

                    @if($kategori->children && $kategori->children->count() > 0)
                        <div class="mb-3">
                            <p class="text-sm text-slate-600">
                                <i class="fas fa-code-branch mr-1"></i>
                                <strong>Sub-kategori:</strong> {{ $kategori->children->count() }} item
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Child Categories Warning -->
            @if($kategori->children && $kategori->children->count() > 0)
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-orange-400 mb-6">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-semibold text-slate-800">
                        <i class="fas fa-exclamation-triangle mr-2 text-orange-500"></i>
                        Perhatian
                    </h6>
                </div>
                <div class="flex-auto p-4 pt-2">
                    <p class="text-sm text-slate-600 mb-3">
                        Kategori ini memiliki <strong>{{ $kategori->children->count() }} sub-kategori</strong>. 
                        Perubahan jenis akan mempengaruhi semua sub-kategori.
                    </p>
                    <div class="max-h-32 overflow-y-auto">
                        <ul class="space-y-1">
                            @foreach($kategori->children->take(5) as $child)
                                <li class="flex items-center text-sm text-slate-600">
                                    <i class="fas fa-arrow-right text-xs text-slate-400 mr-2"></i>
                                    {{ $child->nama_kategori }}
                                </li>
                            @endforeach
                            @if($kategori->children->count() > 5)
                                <li class="text-xs text-slate-500 italic pl-4">
                                    dan {{ $kategori->children->count() - 5 }} sub-kategori lainnya...
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const warnaInput = document.getElementById('warna');
    const warnaText = document.getElementById('warnaText');
    const ikonInput = document.getElementById('ikon');
    const ikonPreview = document.getElementById('ikonPreview');

    ikonInput.addEventListener('input', function() {
        ikonPreview.innerHTML = `<i class="${this.value || 'fas fa-tag'} text-slate-400"></i>`;
    });

    warnaInput.addEventListener('input', function() {
        warnaText.value = this.value;
    });

    window.loadParentKategoris = function() {
        const jenisKategori = document.getElementById('jenis_kategori').value;
        const parentSelect = document.getElementById('parent_id');
        const currentParentId = {{ $kategori->parent_id ?? 'null' }};
        const currentKategoriId = {{ $kategori->id }};

        parentSelect.innerHTML = '<option value="">Tanpa Parent (Kategori Utama)</option>';

        if (jenisKategori) {
            fetch(`{{ route('kelola-kategori.getByJenis') }}?jenis=${jenisKategori}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.data.forEach(kategori => {
                            if (kategori.id !== currentKategoriId) {
                                const option = new Option(kategori.nama_lengkap, kategori.id);
                                if (kategori.id === currentParentId) {
                                    option.selected = true;
                                }
                                parentSelect.add(option);
                            }
                        });
                    }
                })
                .catch(error => console.error('Error loading parent categories:', error));
        }
    };
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
    
    .form-check-input:checked {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='m13.854 3.646-7.5 7.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6 10.293l7.146-7.147a.5.5 0 0 1 .708.708z'/%3e%3c/svg%3e");
    }
</style>
@endpush
