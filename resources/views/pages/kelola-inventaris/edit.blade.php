@extends('layouts.admin')

@section('title', 'Edit Inventaris')
@section('page-title', 'Edit Inventaris')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Edit Inventaris</h4>
            <p class="mb-0 text-sm text-slate-500">Perbarui item inventaris</p>
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
    @if(session('error'))
        <div class="relative p-4 mb-4 text-red-700 bg-red-100 border border-red-300 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="relative p-4 mb-4 text-green-700 bg-green-100 border border-green-300 rounded-lg" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if($errors->any())
        <div class="relative p-4 mb-4 text-red-700 bg-red-100 border border-red-300 rounded-lg" role="alert">
            <div class="font-medium mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Terdapat kesalahan dalam form:
            </div>
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Card -->
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="font-bold">Form Edit Inventaris</h6>
                    <p class="text-sm leading-normal text-slate-400">Isi form di bawah untuk memperbarui item</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-inventaris.update', $inventaris->id) }}" method="POST" id="inventaris-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Barang -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="nama_barang" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Nama Barang <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_barang" 
                                    id="nama_barang"
                                    value="{{ old('nama_barang', $inventaris->nama_barang) }}"
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
                                    onchange="handleKategoriChange()"
                                >
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $id => $nama)
                                        <option value="{{ $id }}" 
                                                data-tipe="{{ $nama }}"
                                                {{ old('kategori_id', $inventaris->kategori_id) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
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
                                        <option value="{{ $cabang->id }}" {{ old('cabang_id', $inventaris->cabang_id) == $cabang->id ? 'selected' : '' }}>{{ $cabang->nama_cabang }}</option>
                                    @endforeach
                                </select>
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
                                    @foreach($units as $unit)
                                        <option value="{{ $unit }}" {{ old('satuan', $inventaris->satuan) == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                                    @endforeach
                                </select>
                                @error('satuan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- FIELDS UNTUK PRODUK RETAIL (Conditional) -->
                            <div id="retail-fields" class="col-span-1 lg:col-span-2">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Harga Satuan -->
                                    <div>
                                        <label for="harga_satuan_formatted" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                            Harga Satuan <span class="text-red-500">*</span>
                                        </label>
                                        <div class="flex">
                                            <span class="inline-flex items-center px-3 text-sm text-gray-700 bg-gray-200 border border-r-0 border-gray-300 rounded-l-lg">Rp</span>
                                            <input 
                                                type="text" 
                                                id="harga_satuan_formatted"
                                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-none rounded-r-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('harga_satuan') border-red-500 @enderror"
                                                placeholder="0"
                                                inputmode="numeric"
                                                required
                                            />
                                        </div>
                                        <input type="hidden" name="harga_satuan" id="harga_satuan" value="{{ old('harga_satuan', $inventaris->harga_satuan) }}" required>
                                        @error('harga_satuan')
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
                                            value="{{ old('stok_minimal', $inventaris->stok_minimal) }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('stok_minimal') border-red-500 @enderror"
                                            placeholder="Masukkan stok minimal"
                                            min="0"
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
                                            value="{{ old('stok_saat_ini', $inventaris->stok_saat_ini) }}"
                                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('stok_saat_ini') border-red-500 @enderror"
                                            placeholder="Masukkan stok saat ini"
                                            min="0"
                                        />
                                        @error('stok_saat_ini')
                                            <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- FIELD UNTUK ASET OPERASIONAL (Conditional) -->
                            <div id="operasional-fields" class="hidden">
                                <label for="jumlah_aset" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Jumlah <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    name="jumlah_aset" 
                                    id="jumlah_aset"
                                    value="{{ old('jumlah_aset', $inventaris->stok_saat_ini) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('jumlah_aset') border-red-500 @enderror"
                                    placeholder="Masukkan jumlah aset"
                                    min="1"
                                />
                                @error('jumlah_aset')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                                <p class="text-xs text-slate-400 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Untuk aset operasional, cukup masukkan jumlah unit yang dimiliki
                                </p>
                            </div>

                            <!-- Status (Only for Retail Products) -->
                            <div id="status-field">
                                <label for="status" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Status
                                </label>
                                <select 
                                    name="status" 
                                    id="status"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('status') border-red-500 @enderror"
                                >
                                    <option value="tersedia" {{ old('status', $inventaris->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="habis" {{ old('status', $inventaris->status) == 'habis' ? 'selected' : '' }}>Habis</option>
                                    <option value="hampir_habis" {{ old('status', $inventaris->status) == 'hampir_habis' ? 'selected' : '' }}>Hampir Habis</option>
                                    <option value="discontinued" {{ old('status', $inventaris->status) == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                                </select>
                                <p class="text-xs text-slate-400 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Status akan otomatis disesuaikan berdasarkan jumlah stok (kecuali Discontinued)
                                </p>
                                @error('status')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('kelola-inventaris.index') }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Inventaris
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// ========== TEMPORARY DISABLE FORM VALIDATION FOR DEBUGGING ==========
// Jika form tetap tidak bisa submit, berarti masalahnya bukan di JavaScript
console.log('%c=== INVENTARIS EDIT FORM SCRIPT LOADED ===', 'color: blue; font-weight: bold;');

function handleKategoriChange() {
    const kategoriSelect = document.getElementById('kategori_id');
    const selectedOption = kategoriSelect.options[kategoriSelect.selectedIndex];
    const tipeKategori = selectedOption.getAttribute('data-tipe');
    
    const retailFields = document.getElementById('retail-fields');
    const operasionalFields = document.getElementById('operasional-fields');
    const statusField = document.getElementById('status-field');
    
    // Get all fields
    const hargaSatuan = document.getElementById('harga_satuan');
    const stokMinimal = document.getElementById('stok_minimal');
    const stokSaatIni = document.getElementById('stok_saat_ini');
    const jumlahAset = document.getElementById('jumlah_aset');
    const status = document.getElementById('status');
    
    // Check if category name contains "Operasional" or "Aset"
    const isOperasional = tipeKategori && (
        tipeKategori.toLowerCase().includes('operasional') || 
        tipeKategori.toLowerCase().includes('aset') ||
        tipeKategori.toLowerCase().includes('peralatan')
    );
    
    if (isOperasional) {
        // Show operasional fields, hide retail fields and status
        retailFields.classList.add('hidden');
        statusField.classList.add('hidden');
        operasionalFields.classList.remove('hidden');
        
        // Remove required from retail fields
        const hargaFormattedField = document.getElementById('harga_satuan_formatted');
        if (hargaFormattedField) hargaFormattedField.removeAttribute('required');
        if (hargaSatuan) hargaSatuan.removeAttribute('required');
        if (stokMinimal) stokMinimal.removeAttribute('required');
        if (stokSaatIni) stokSaatIni.removeAttribute('required');
        
        // Add required to operasional field
        jumlahAset.setAttribute('required', 'required');
        
        // Set default values for retail fields (so validation passes)
        hargaSatuan.value = hargaSatuan.value || 0;
        stokMinimal.value = 0;
        stokSaatIni.value = jumlahAset.value || 1;
        status.value = 'tersedia'; // Auto-set status to tersedia for operasional
        
    } else {
        // Show retail fields and status, hide operasional fields
        retailFields.classList.remove('hidden');
        statusField.classList.remove('hidden');
        operasionalFields.classList.add('hidden');
        
        // Add required to retail fields (but NOT status - it will be auto-determined)
        const hargaFormattedField = document.getElementById('harga_satuan_formatted');
        if (hargaFormattedField) hargaFormattedField.setAttribute('required', 'required');
        if (hargaSatuan) hargaSatuan.setAttribute('required', 'required');
        if (stokMinimal) stokMinimal.setAttribute('required', 'required');
        if (stokSaatIni) stokSaatIni.setAttribute('required', 'required');
        
        // CRITICAL FIX: Remove required from operasional field when hidden
        // Browser HTML5 won't allow form submission with required hidden fields
        if (jumlahAset) {
            jumlahAset.removeAttribute('required');
            jumlahAset.value = ''; // Clear value to avoid confusion
        }
        
        // Don't clear values on edit page, keep existing values
    }
    // Ensure status is updated whenever category changes
    updateStatusBasedOnStock();
}

// Handle jumlah_aset change for operasional
document.getElementById('jumlah_aset').addEventListener('input', function() {
    const stokSaatIni = document.getElementById('stok_saat_ini');
    stokSaatIni.value = this.value;
});

// Auto-update status based on stok changes
function updateStatusBasedOnStock() {
    const stokSaatIni = parseInt(document.getElementById('stok_saat_ini').value) || 0;
    const stokMinimal = parseInt(document.getElementById('stok_minimal').value) || 0;
    const statusSelect = document.getElementById('status');
    
    // Only auto-update if current status is not 'discontinued'
    if (statusSelect.value !== 'discontinued') {
        if (stokSaatIni <= 0) {
            statusSelect.value = 'habis';
        } else if (stokSaatIni <= stokMinimal) {
            statusSelect.value = 'hampir_habis';
        } else {
            statusSelect.value = 'tersedia';
        }
    }
}

// Add event listeners for stok changes
document.getElementById('stok_saat_ini').addEventListener('input', updateStatusBasedOnStock);
document.getElementById('stok_minimal').addEventListener('input', updateStatusBasedOnStock);

document.addEventListener('DOMContentLoaded', function() {
    console.log('%c=== DOMContentLoaded - Initializing form ===', 'color: green; font-weight: bold;');
    
    // CRITICAL FIX: Remove required from jumlah_aset on page load for retail products
    // This prevents HTML5 validation error: "An invalid form control with name='jumlah_aset' is not focusable"
    const jumlahAsetField = document.getElementById('jumlah_aset');
    const operasionalFields = document.getElementById('operasional-fields');
    
    // If operasional-fields is hidden, remove required from jumlah_aset
    if (operasionalFields && operasionalFields.classList.contains('hidden')) {
        if (jumlahAsetField) {
            jumlahAsetField.removeAttribute('required');
            console.log('✓ Removed required from jumlah_aset (retail product)');
        }
    }
    
    // Kategori change handler
    handleKategoriChange();

    // Also run on page load to set initial state correctly
    updateStatusBasedOnStock();

    // Number formatting for harga_satuan
    const hargaSatuanFormattedInput = document.getElementById('harga_satuan_formatted');
    const hargaSatuanInput = document.getElementById('harga_satuan');

    function formatNumber(value) {
        if (!value) return '';
        // Handle potential floating point values from the database
        const numberValue = parseFloat(value);
        if (isNaN(numberValue)) return '';
        return new Intl.NumberFormat('id-ID').format(numberValue);
    }

    function unformatNumber(value) {
        return value.replace(/\./g, '');
    }

    // Initialize formatted input with current value
    if (hargaSatuanInput.value) {
        hargaSatuanFormattedInput.value = formatNumber(hargaSatuanInput.value);
    } else {
        // Set default value if empty
        hargaSatuanInput.value = '0';
        hargaSatuanFormattedInput.value = '0';
    }

    hargaSatuanFormattedInput.addEventListener('input', function (e) {
        const rawValue = unformatNumber(e.target.value);
        if (isNaN(rawValue) || rawValue === '') {
            hargaSatuanInput.value = '0';
            e.target.value = '0';
        } else {
            hargaSatuanInput.value = rawValue;
            e.target.value = formatNumber(rawValue);
        }
    });

    // Form submission handler with proper validation
    const form = document.getElementById('inventaris-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('%c=== FORM SUBMISSION STARTED ===', 'color: blue; font-weight: bold;');
            
            // CRITICAL FIX: Ensure jumlah_aset doesn't have required if it's hidden
            const jumlahAsetField = document.getElementById('jumlah_aset');
            const operasionalFields = document.getElementById('operasional-fields');
            
            if (operasionalFields && operasionalFields.classList.contains('hidden')) {
                if (jumlahAsetField) {
                    jumlahAsetField.removeAttribute('required');
                    console.log('✓ Removed required from jumlah_aset before submission');
                }
            }
            
            // Update status based on stock before submission
            const statusSelect = document.getElementById('status');
            if (statusSelect && statusSelect.value !== 'discontinued') {
                updateStatusBasedOnStock();
                console.log('✓ Status updated before submission:', statusSelect.value);
            }
            
            console.log('Form data:', {
                nama_barang: document.getElementById('nama_barang')?.value,
                kategori_id: document.getElementById('kategori_id')?.value,
                cabang_id: document.getElementById('cabang_id')?.value,
                stok_saat_ini: document.getElementById('stok_saat_ini')?.value,
                stok_minimal: document.getElementById('stok_minimal')?.value,
                status: document.getElementById('status')?.value
            });
            
            console.log('%c✓ Form validation passed, submitting...', 'color: green; font-weight: bold;');
            // Let form submit naturally
            return true;
        });
        
        console.log('✓ Form submission handler attached');
    } else {
        console.error('❌ Form with id "inventaris-form" not found!');
    }
});
</script>
@endpush
