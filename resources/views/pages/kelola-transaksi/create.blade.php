@extends('layouts.admin')

@section('title', 'Tambah Transaksi')
@section('page-title', 'Tambah Transaksi')

@section('content')
<div class="w-full max-w-full min-h-screen">
    <!-- Page Header -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div>
            <h4 class="mb-0 font-bold text-slate-700">Tambah Transaksi</h4>
            <p class="mb-0 text-sm text-slate-500">Tambahkan transaksi baru untuk barbershop Anda</p>
        </div>
        <div>
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
                    <h6 class="font-bold">Form Tambah Transaksi</h6>
                    <p class="text-sm leading-normal text-slate-400">Isi form di bawah untuk menambahkan transaksi baru</p>
                </div>
                <div class="flex-auto px-6 pt-0 pb-6">
                    <form action="{{ route('kelola-transaksi.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Pelanggan -->
                            <div class="col-span-1">
                                <label for="nama_pelanggan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Nama Pelanggan <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_pelanggan" 
                                    id="nama_pelanggan"
                                    value="{{ old('nama_pelanggan') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('nama_pelanggan') border-red-500 @enderror"
                                    placeholder="Masukkan nama pelanggan"
                                    required
                                />
                                @error('nama_pelanggan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Telepon Pelanggan -->
                            <div class="col-span-1">
                                <label for="telepon_pelanggan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Telepon Pelanggan
                                </label>
                                <input 
                                    type="text" 
                                    name="telepon_pelanggan" 
                                    id="telepon_pelanggan"
                                    value="{{ old('telepon_pelanggan') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('telepon_pelanggan') border-red-500 @enderror"
                                    placeholder="Masukkan nomor telepon (opsional)"
                                />
                                @error('telepon_pelanggan')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Layanan -->
                            <div class="col-span-1">
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
                                        <option value="{{ $service->id }}" data-harga="{{ $service->harga }}" {{ old('layanan_id') == $service->id ? 'selected' : '' }}>
                                            {{ $service->nama_layanan }} - {{ $service->formatted_harga }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('layanan_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Kapster -->
                            <div class="col-span-1">
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
                                        <option value="{{ $k->id }}" {{ old('kapster_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kapster }} - {{ $k->cabang->nama_cabang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kapster_id')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Subtotal Layanan -->
                            <div class="col-span-1">
                                <label for="subtotal_layanan" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Subtotal Layanan
                                </label>
                                <input 
                                    type="number" 
                                    name="subtotal_layanan" 
                                    id="subtotal_layanan"
                                    value="{{ old('subtotal_layanan') }}"
                                    min="0" 
                                    step="0.01"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                    placeholder="0.00"
                                    readonly
                                />
                            </div>
                        </div>

                        <!-- Produk Section -->
                        <div class="mt-8 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h6 class="text-base font-bold text-slate-700">
                                    <i class="fas fa-shopping-cart mr-2 text-blue-500"></i>
                                    Produk Tambahan (Opsional)
                                </h6>
                                <button type="button" id="addProduk" class="inline-block px-4 py-2 text-xs font-bold text-center text-white uppercase transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro ease-soft-in tracking-tight-soft shadow-soft-md bg-150 bg-x-25 hover:scale-102 active:opacity-85 hover:shadow-soft-xs">
                                    <i class="fas fa-plus mr-1"></i>
                                    Tambah Produk
                                </button>
                            </div>

                            <div id="produkContainer" class="space-y-4">
                                <!-- Dynamic product items will be added here -->
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Subtotal Produk -->
                            <div class="col-span-1">
                                <label for="subtotal_produk" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Subtotal Produk
                                </label>
                                <input 
                                    type="number" 
                                    name="subtotal_produk" 
                                    id="subtotal_produk"
                                    value="{{ old('subtotal_produk', 0) }}"
                                    min="0" 
                                    step="0.01"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-gray-100 bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                                    placeholder="0.00"
                                    readonly
                                />
                            </div>

                            <!-- Total Harga -->
                            <div class="col-span-1">
                                <label for="total_harga" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    <strong>Total Harga <span class="text-red-500">*</span></strong>
                                </label>
                                <input 
                                    type="number" 
                                    name="total_harga" 
                                    id="total_harga"
                                    value="{{ old('total_harga') }}"
                                    min="0" 
                                    step="0.01"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-yellow-50 bg-clip-padding px-3 py-2 font-bold text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('total_harga') border-red-500 @enderror"
                                    placeholder="0.00"
                                    readonly
                                    required
                                />
                                @error('total_harga')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tanggal Transaksi -->
                            <div class="col-span-1">
                                <label for="tanggal_transaksi" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Tanggal Transaksi <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="date" 
                                    name="tanggal_transaksi" 
                                    id="tanggal_transaksi"
                                    value="{{ old('tanggal_transaksi', date('Y-m-d')) }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('tanggal_transaksi') border-red-500 @enderror"
                                    required
                                />
                                @error('tanggal_transaksi')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Waktu Mulai -->
                            <div class="col-span-1">
                                <label for="waktu_mulai" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Waktu Mulai <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="time" 
                                    name="waktu_mulai" 
                                    id="waktu_mulai"
                                    value="{{ old('waktu_mulai') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('waktu_mulai') border-red-500 @enderror"
                                    required
                                />
                                @error('waktu_mulai')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Waktu Selesai -->
                            <div class="col-span-1">
                                <label for="waktu_selesai" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                                    Waktu Selesai
                                </label>
                                <input 
                                    type="time" 
                                    name="waktu_selesai" 
                                    id="waktu_selesai"
                                    value="{{ old('waktu_selesai') }}"
                                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow @error('waktu_selesai') border-red-500 @enderror"
                                />
                                @error('waktu_selesai')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Metode Pembayaran -->
                            <div class="col-span-1">
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
                                    <option value="tunai" {{ old('metode_pembayaran') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                                    <option value="kartu_debit" {{ old('metode_pembayaran') == 'kartu_debit' ? 'selected' : '' }}>Kartu Debit</option>
                                    <option value="kartu_kredit" {{ old('metode_pembayaran') == 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                                    <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                    <option value="ewallet" {{ old('metode_pembayaran') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                                </select>
                                @error('metode_pembayaran')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-span-1">
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
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="sedang_proses" {{ old('status') == 'sedang_proses' ? 'selected' : '' }}>Sedang Proses</option>
                                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                </select>
                                @error('status')
                                    <div class="text-xs text-red-500 mt-1">{{ $message }}</div>
                                @enderror
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
                                >{{ old('catatan') }}</textarea>
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
                                Simpan Transaksi
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let produkCounter = 0;
    const availableProduk = @json($inventaris ?? []);

    document.addEventListener('DOMContentLoaded', function() {
        // Auto fill subtotal layanan when layanan is selected
        document.getElementById('layanan_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const harga = selectedOption.getAttribute('data-harga');
            if (harga) {
                document.getElementById('subtotal_layanan').value = harga;
                calculateTotal();
            }
        });

        // Add product functionality
        document.getElementById('addProduk').addEventListener('click', function() {
            addProdukRow();
        });

        // Initial calculation
        calculateTotal();
    });

    function addProdukRow() {
        produkCounter++;
        const container = document.getElementById('produkContainer');
        
        const produkRow = document.createElement('div');
        produkRow.className = 'produk-row bg-gray-50 p-4 rounded-lg border border-gray-200';
        produkRow.setAttribute('data-index', produkCounter);
        
        produkRow.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div class="col-span-1 md:col-span-2">
                    <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">
                        Produk <span class="text-red-500">*</span>
                    </label>
                    <select name="produk[${produkCounter}][inventaris_id]" 
                            class="produk-select focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                            data-index="${produkCounter}" required>
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
                        Qty <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="produk[${produkCounter}][quantity]" 
                           class="qty-input focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:outline-none focus:transition-shadow"
                           data-index="${produkCounter}"
                           min="1" value="1" required>
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
        const subtotalLayanan = parseFloat(document.getElementById('subtotal_layanan').value) || 0;
        
        // Calculate subtotal produk
        let subtotalProduk = 0;
        document.querySelectorAll('.subtotal-produk').forEach(input => {
            subtotalProduk += parseFloat(input.value) || 0;
        });
        
        document.getElementById('subtotal_produk').value = subtotalProduk.toFixed(2);
        
        // Calculate total
        const total = subtotalLayanan + subtotalProduk;
        document.getElementById('total_harga').value = total.toFixed(2);
    }

    function number_format(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }
</script>
@endpush
