@extends('layouts.admin')

@section('title', 'Edit Transaksi')
@section('page-title', 'Edit Transaksi')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Edit Transaksi</h4>
            <p class="mb-0 text-sm text-slate-500">Perbarui informasi transaksi: {{ $transaksi->nomor_transaksi }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('kelola-transaksi.show', $transaksi->id) }}" 
                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                <i class="fas fa-eye mr-2"></i>
                Lihat Detail
            </a>
            <a href="{{ route('kelola-transaksi.index') }}" 
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
                    <h6 class="font-bold">Form Edit Transaksi</h6>
                    <p class="text-sm leading-normal text-slate-400">Perbarui informasi transaksi di bawah ini</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-transaksi.update', $transaksi->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4">
                            <!-- Cabang (Read-only) -->
                            <div>
                                <label for="cabang_display" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Cabang
                                </label>
                                <input 
                                    type="text" 
                                    id="cabang_display" 
                                    value="{{ $transaksi->cabang->nama_cabang }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all cursor-not-allowed"
                                    readonly
                                    disabled
                                >
                                <input type="hidden" name="cabang_id" value="{{ $transaksi->cabang_id }}">
                                <p class="text-xs text-slate-400 mt-1">Cabang tidak dapat diubah setelah transaksi dibuat</p>
                            </div>

                            <!-- Layanan -->
                            <div>
                                <label for="layanan_id" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Layanan <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="layanan_id" 
                                    id="layanan_id"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('layanan_id') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Layanan</option>
                                    @foreach($layanan as $service)
                                        <option value="{{ $service->id }}" data-harga="{{ $service->harga }}" {{ old('layanan_id', $transaksi->layanan_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->nama_layanan }} - {{ $service->formatted_harga }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('layanan_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kapster -->
                            <div>
                                <label for="kapster_id" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Kapster <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="kapster_id" 
                                    id="kapster_id"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('kapster_id') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Kapster</option>
                                    @foreach($kapster as $k)
                                        <option value="{{ $k->id }}" {{ old('kapster_id', $transaksi->kapster_id) == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kapster }} - {{ $k->cabang->nama_cabang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kapster_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Produk Tambahan -->
                            <div class="col-span-1 lg:col-span-2" id="produkSection">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="inline-block ml-1 font-bold text-xs text-slate-700">
                                        Produk Tambahan <span class="text-xs text-slate-400">(Opsional)</span>
                                    </label>
                                    <div class="flex gap-2">
                                        <button type="button" 
                                            id="closeProdukSection"
                                            class="{{ $transaksi->produk->count() > 0 ? '' : 'hidden' }} inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-red-600 to-yellow-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                            <i class="fas fa-times mr-2"></i>
                                            Tutup
                                        </button>
                                        <button type="button" 
                                            id="addProduk"
                                            class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Produk
                                        </button>
                                    </div>
                                </div>
                                <div id="produkContainer" class="space-y-4">
                                    @foreach($transaksi->produk as $index => $produk)
                                    <div class="produk-row bg-gray-50 p-4 rounded-lg border border-gray-200" data-index="{{ $index }}">
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                                            <div class="col-span-1 md:col-span-2">
                                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                                    Produk
                                                </label>
                                                <select name="produk[{{ $index }}][inventaris_id]" 
                                                        class="produk-select focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                                        data-index="{{ $index }}">
                                                    <option value="">Pilih Produk</option>
                                                    @foreach($inventaris as $item)
                                                        <option value="{{ $item->id }}" 
                                                                data-harga="{{ $item->harga_satuan }}" 
                                                                data-stok="{{ $item->stok_saat_ini }}"
                                                                {{ $produk->id == $item->id ? 'selected' : '' }}>
                                                            {{ $item->nama_barang }} - Rp {{ number_format($item->harga_satuan, 0, ',', '.') }} (Stok: {{ $item->stok_saat_ini }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                                    Qty
                                                </label>
                                                <input type="number" 
                                                       name="produk[{{ $index }}][quantity]" 
                                                       class="qty-input focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                                       data-index="{{ $index }}"
                                                       min="1" 
                                                       value="{{ $produk->pivot->quantity }}">
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                <div class="flex-1">
                                                    <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                                        Subtotal
                                                    </label>
                                                    <input type="number" 
                                                           class="subtotal-produk focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-padding px-3 py-2 font-normal text-gray-700"
                                                           data-index="{{ $index }}"
                                                           value="{{ $produk->pivot->subtotal }}"
                                                           readonly>
                                                </div>
                                                <button type="button" 
                                                        class="remove-produk bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm"
                                                        data-index="{{ $index }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Metode Pembayaran -->
                            <div>
                                <label for="metode_pembayaran" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Metode Pembayaran <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="metode_pembayaran" 
                                    id="metode_pembayaran"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('metode_pembayaran') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Metode Pembayaran</option>
                                    <option value="tunai" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                    <option value="kartu_debit" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'kartu_debit' ? 'selected' : '' }}>Kartu Debit</option>
                                    <option value="kartu_kredit" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                    <option value="transfer" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="ewallet" {{ old('metode_pembayaran', $transaksi->metode_pembayaran) == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                                </select>
                                @error('metode_pembayaran')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Status Transaksi <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    name="status" 
                                    id="status"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('status') border-red-500 @enderror"
                                    required
                                >
                                    <option value="">Pilih Status</option>
                                    <option value="pending" {{ old('status', $transaksi->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="sedang_proses" {{ old('status', $transaksi->status) == 'sedang_proses' ? 'selected' : '' }}>Sedang Proses</option>
                                    <option value="selesai" {{ old('status', $transaksi->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ old('status', $transaksi->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Transaksi -->
                            <div>
                                <label for="tanggal_transaksi" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Tanggal Transaksi <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="tanggal_transaksi" 
                                    id="tanggal_transaksi"
                                    value="{{ old('tanggal_transaksi', $transaksi->tanggal_transaksi->format('Y-m-d')) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('tanggal_transaksi') border-red-500 @enderror"
                                    required
                                />
                                @error('tanggal_transaksi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Total Harga -->
                            <div>
                                <label for="total_harga" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Total Harga <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-700 font-semibold pointer-events-none">
                                        Rp
                                    </span>
                                    <input 
                                        type="number" 
                                        name="total_harga" 
                                        id="total_harga"
                                        step="0.01"
                                        class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-padding pl-12 pr-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                        readonly
                                    />
                                </div>
                            </div>

                            <!-- Catatan -->
                            <div class="col-span-1 lg:col-span-2">
                                <label for="catatan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Catatan
                                </label>
                                <textarea 
                                    name="catatan" 
                                    id="catatan"
                                    rows="4"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('catatan') border-red-500 @enderror"
                                    placeholder="Masukkan catatan tambahan (opsional)"
                                >{{ old('catatan', $transaksi->catatan) }}</textarea>
                                @error('catatan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end mt-6 gap-3">
                            <a href="{{ route('kelola-transaksi.index') }}" 
                                class="inline-block px-6 py-3 font-bold text-center text-slate-700 uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-gray-100 to-gray-200 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit" 
                                class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                <i class="fas fa-save mr-2"></i>
                                Perbarui Transaksi
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
    let produkCounter = {{ $transaksi->produk->count() }};
    const availableProduk = @json($inventaris ?? []);

    document.addEventListener('DOMContentLoaded', function() {
        // Auto calculate total when layanan is selected
        document.getElementById('layanan_id').addEventListener('change', function() {
            calculateTotal();
        });

        // Add product functionality
        document.getElementById('addProduk').addEventListener('click', function() {
            addProdukRow();
            // Show close button when first product is added
            document.getElementById('closeProdukSection').classList.remove('hidden');
        });

        // Close product section functionality
        document.getElementById('closeProdukSection').addEventListener('click', function() {
            // Remove all product rows
            document.getElementById('produkContainer').innerHTML = '';
            // Hide close button
            this.classList.add('hidden');
            // Reset counter
            produkCounter = 0;
            // Recalculate total
            calculateTotal();
        });

        // Add event listeners to existing produk rows
        document.querySelectorAll('.produk-row').forEach(row => {
            const index = row.getAttribute('data-index');
            const select = row.querySelector('.produk-select');
            const qtyInput = row.querySelector('.qty-input');
            const removeBtn = row.querySelector('.remove-produk');
            
            select.addEventListener('change', function() {
                calculateProdukSubtotal(index);
                calculateTotal();
            });
            
            qtyInput.addEventListener('input', function() {
                calculateProdukSubtotal(index);
                calculateTotal();
            });
            
            removeBtn.addEventListener('click', function() {
                removeProdukRow(index);
            });
        });

        // Show close button if there are existing products
        if (document.querySelectorAll('.produk-row').length > 0) {
            document.getElementById('closeProdukSection').classList.remove('hidden');
        }

        // Initial calculation
        calculateTotal();
    });

    function addProdukRow() {
        produkCounter++;
        const container = document.getElementById('produkContainer');
        
        const produkRow = document.createElement('div');
        produkRow.className = 'produk-row bg-gray-50 p-4 rounded-lg border border-gray-200';
        produkRow.setAttribute('data-index', produkCounter);
        produkRow.setAttribute('data-new', 'true');
        
        produkRow.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="col-span-1 md:col-span-2">
                    <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                        Produk
                    </label>
                    <select name="produk[${produkCounter}][inventaris_id]" 
                            class="produk-select focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                            data-index="${produkCounter}">
                        <option value="">Pilih Produk</option>
                        ${availableProduk.map(item => `
                            <option value="${item.id}" data-harga="${item.harga_satuan}" data-stok="${item.stok_saat_ini}">
                                ${item.nama_barang} - Rp ${number_format(item.harga_satuan)} (Stok: ${item.stok_saat_ini})
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div>
                    <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                        Qty
                    </label>
                    <input type="number" 
                           name="produk[${produkCounter}][quantity]" 
                           class="qty-input focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                           data-index="${produkCounter}"
                           min="1" value="1">
                </div>
                <div class="flex items-center space-x-2">
                    <div class="flex-1">
                        <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                            Subtotal
                        </label>
                        <input type="number" 
                               class="subtotal-produk focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-padding px-3 py-2 font-normal text-gray-700"
                               data-index="${produkCounter}"
                               readonly>
                    </div>
                    <button type="button" 
                            class="remove-produk bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm"
                            data-index="${produkCounter}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        
        container.appendChild(produkRow);
        
        // Add event listeners for the new row
        const select = produkRow.querySelector('.produk-select');
        const qtyInput = produkRow.querySelector('.qty-input');
        const removeBtn = produkRow.querySelector('.remove-produk');
        
        select.addEventListener('change', function() {
            calculateProdukSubtotal(produkCounter);
            calculateTotal();
        });
        
        qtyInput.addEventListener('input', function() {
            calculateProdukSubtotal(produkCounter);
            calculateTotal();
        });
        
        removeBtn.addEventListener('click', function() {
            removeProdukRow(produkCounter);
        });
    }

    function removeProdukRow(index) {
        const row = document.querySelector(`[data-index="${index}"]`);
        if (row) {
            row.remove();
            calculateTotal();
            
            // Hide close button if no products left
            const remainingRows = document.querySelectorAll('.produk-row');
            if (remainingRows.length === 0) {
                document.getElementById('closeProdukSection').classList.add('hidden');
            }
        }
    }

    function calculateProdukSubtotal(index) {
        const select = document.querySelector(`select[data-index="${index}"]`);
        const qtyInput = document.querySelector(`input[data-index="${index}"]`);
        const subtotalInput = document.querySelector(`.subtotal-produk[data-index="${index}"]`);
        
        if (select && qtyInput && subtotalInput) {
            const selectedOption = select.options[select.selectedIndex];
            const harga = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
            const qty = parseInt(qtyInput.value) || 0;
            const subtotal = harga * qty;
            
            subtotalInput.value = subtotal.toFixed(2);
        }
    }

    function calculateTotal() {
        // Calculate subtotal layanan
        let totalLayanan = 0;
        const layananSelect = document.getElementById('layanan_id');
        if (layananSelect && layananSelect.value) {
            const selectedOption = layananSelect.options[layananSelect.selectedIndex];
            totalLayanan = parseFloat(selectedOption.getAttribute('data-harga')) || 0;
        }
        
        // Calculate subtotal produk
        let totalProduk = 0;
        document.querySelectorAll('.subtotal-produk').forEach(input => {
            totalProduk += parseFloat(input.value) || 0;
        });
        
        // Calculate total
        const total = totalLayanan + totalProduk;
        document.getElementById('total_harga').value = total.toFixed(2);
    }

    function number_format(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
</script>
@endpush

