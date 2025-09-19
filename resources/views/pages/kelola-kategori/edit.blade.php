@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')

@section('content')
<div class="flex flex-col gap-6">
    <!-- Form Card -->
    <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-6">
            <!-- Page Header -->
            <div class="flex flex-wrap items-center justify-between mb-6 -mx-3">
                <div class="w-full max-w-full px-3 sm:w-auto">
                    <h6 class="mb-0 font-bold text-slate-800">
                        Formulir Edit Kategori
                    </h6>
                    <p class="text-sm leading-normal text-slate-500">
                        Perbarui detail untuk kategori: <span class="font-semibold">{{ $kategori->nama_kategori }}</span>
                    </p>
                </div>
                <div class="w-full max-w-full px-3 mt-4 sm:mt-0 sm:w-auto">
                    <a href="{{ route('kelola-kategori.index', ['jenis' => $kategori->jenis_kategori]) }}" 
                       class="btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>

            <form action="{{ route('kelola-kategori.update', $kategori->id) }}" method="POST" class="flex flex-wrap -mx-3">
                @csrf
                @method('PUT')
                <div class="w-full lg:w-2/3 px-3">
                    <div class="flex flex-col gap-6">
                        <!-- Nama & Kode Kategori -->
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="nama_kategori" class="block text-sm font-medium text-slate-700 mb-1">Nama Kategori <span class="text-red-500">*</span></label>
                                <input type="text" id="nama_kategori" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required class="form-input w-full @error('nama_kategori') border-red-500 @enderror">
                                @error('nama_kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label for="kode_kategori" class="block text-sm font-medium text-slate-700 mb-1">Kode Kategori</label>
                                <input type="text" id="kode_kategori" name="kode_kategori" value="{{ old('kode_kategori', $kategori->kode_kategori) }}" class="form-input w-full bg-slate-100 @error('kode_kategori') border-red-500 @enderror" readonly>
                                <p class="text-xs text-slate-500 mt-1">Kode tidak dapat diubah.</p>
                                @error('kode_kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Jenis & Parent Kategori -->
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                                <label for="jenis_kategori" class="block text-sm font-medium text-slate-700 mb-1">Jenis Kategori <span class="text-red-500">*</span></label>
                                <select id="jenis_kategori" name="jenis_kategori" required class="form-select w-full @error('jenis_kategori') border-red-500 @enderror" onchange="loadParentKategoris()">
                                    @foreach($jenisOptions as $key => $label)
                                        <option value="{{ $key }}" {{ old('jenis_kategori', $kategori->jenis_kategori) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('jenis_kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-full md:w-1/2 px-3">
                                <label for="parent_id" class="block text-sm font-medium text-slate-700 mb-1">Parent Kategori</label>
                                <select id="parent_id" name="parent_id" class="form-select w-full @error('parent_id') border-red-500 @enderror">
                                    <option value="">Tanpa Parent (Kategori Utama)</option>
                                    @foreach($parentKategoris as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $kategori->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->nama_lengkap }}</option>
                                    @endforeach
                                </select>
                                @error('parent_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-1">Deskripsi</label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="form-textarea w-full @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                            @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Urutan, Warna, Ikon -->
                        <div class="flex flex-wrap -mx-3">
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <label for="urutan" class="block text-sm font-medium text-slate-700 mb-1">Urutan</label>
                                <input type="number" id="urutan" name="urutan" value="{{ old('urutan', $kategori->urutan) }}" min="0" class="form-input w-full @error('urutan') border-red-500 @enderror">
                                @error('urutan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                                <label for="warna" class="block text-sm font-medium text-slate-700 mb-1">Warna</label>
                                <div class="flex items-center">
                                    <input type="color" id="warna" name="warna" value="{{ old('warna', $kategori->warna ?: '#4a90e2') }}" class="h-10 p-1 rounded-lg">
                                    <input type="text" id="warnaText" value="{{ old('warna', $kategori->warna ?: '#4a90e2') }}" readonly class="form-input w-full ml-2">
                                </div>
                                @error('warna') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="w-full md:w-1/3 px-3">
                                <label for="ikon" class="block text-sm font-medium text-slate-700 mb-1">Ikon</label>
                                <div class="relative">
                                    <input type="text" id="ikon" name="ikon" value="{{ old('ikon', $kategori->ikon) }}" placeholder="fas fa-tag" class="form-input w-full pl-10 @error('ikon') border-red-500 @enderror">
                                    <div id="ikonPreview" class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="{{ $kategori->ikon ?: 'fas fa-tag' }} text-slate-400"></i>
                                    </div>
                                </div>
                                @error('ikon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <div class="form-check form-switch pl-0">
                                <input id="status" name="status" type="checkbox" value="1" {{ old('status', $kategori->status) ? 'checked' : '' }} class="form-check-input w-10 h-5 m-0 align-top bg-center bg-no-repeat bg-contain border-2 border-solid rounded-full appearance-none cursor-pointer border-slate-200 checked:bg-gradient-to-tl checked:from-green-600 checked:to-lime-400 checked:border-green-500">
                                <label for="status" class="ml-3 text-sm font-normal cursor-pointer select-none text-slate-700">Aktifkan Kategori</label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-4 pt-4 border-t border-gray-200 mt-6">
                            <a href="{{ route('kelola-kategori.index', ['jenis' => $kategori->jenis_kategori]) }}" class="btn-secondary">Batal</a>
                            <button type="submit" class="btn-primary">Perbarui Kategori</button>
                        </div>
                    </div>
                </div>

                <!-- Side Info -->
                <div class="w-full lg:w-1/3 px-3 mt-6 lg:mt-0">
                    <div class="sticky top-6 flex flex-col gap-6">
                        <!-- Current Info Card -->
                        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                            <div class="p-4">
                                <h6 class="font-bold text-slate-800 mb-4">Informasi Saat Ini</h6>
                                <div class="flex items-center mb-4">
                                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4" style="background-color: {{ $kategori->warna ?: '#e2e8f0' }};">
                                        <i class="{{ $kategori->ikon ?: 'fas fa-tag' }} text-xl" style="color: white;"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-semibold text-slate-700">{{ $kategori->nama_kategori }}</h6>
                                        <p class="text-sm text-slate-500 font-mono">{{ $kategori->kode_kategori }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-2 text-center">
                                    <div class="py-2 rounded-lg bg-slate-50">
                                        <p class="text-sm font-semibold text-slate-700 mb-0">{{ $kategori->inventaris->count() }}</p>
                                        <p class="text-xs text-slate-500 mb-0">Inventaris</p>
                                    </div>
                                    <div class="py-2 rounded-lg bg-slate-50">
                                        <p class="text-sm font-semibold text-slate-700 mb-0">{{ $kategori->layanan->count() }}</p>
                                        <p class="text-xs text-slate-500 mb-0">Layanan</p>
                                    </div>
                                    <div class="py-2 rounded-lg bg-slate-50">
                                        <p class="text-sm font-semibold text-slate-700 mb-0">{{ $kategori->pengeluaran->count() }}</p>
                                        <p class="text-xs text-slate-500 mb-0">Pengeluaran</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Child Categories Warning -->
                        @if($kategori->children->count() > 0)
                        <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-soft-xl rounded-2xl bg-clip-border border-l-4 border-yellow-400">
                            <div class="p-4">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                                    <h6 class="font-bold text-slate-800 mb-0">Perhatian</h6>
                                </div>
                                <p class="text-sm text-slate-600 mb-2">Kategori ini memiliki {{ $kategori->children->count() }} sub-kategori. Perubahan jenis akan mempengaruhi semua sub-kategori.</p>
                                <ul class="list-disc list-inside text-sm text-slate-600 space-y-1 pl-2">
                                    @foreach($kategori->children->take(3) as $child)
                                        <li>{{ $child->nama_kategori }}</li>
                                    @endforeach
                                    @if($kategori->children->count() > 3)
                                        <li class="text-slate-500">dan {{ $kategori->children->count() - 3 }} lainnya...</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        @endif
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
    .btn-primary {
        @apply inline-block px-5 py-2.5 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-normal text-sm ease-in shadow-md bg-150 hover:shadow-lg active:opacity-85 hover:-translate-y-px tracking-tight-rem;
    }
    .btn-secondary {
        @apply inline-block px-5 py-2.5 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg cursor-pointer border-slate-200 leading-normal text-sm ease-in shadow-none bg-150 hover:bg-slate-100 hover:shadow-sm active:opacity-85 hover:-translate-y-px tracking-tight-rem;
    }
</style>
@endpush
