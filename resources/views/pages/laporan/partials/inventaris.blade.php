<!-- Laporan Inventaris & Stok -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <h6 class="mb-0 font-bold text-slate-800">📦 Laporan Inventaris & Stok</h6>
        <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">Monitoring stok dan nilai inventaris</p>
    </div>

    <div class="p-6">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <p class="text-xs font-semibold text-blue-600 mb-1">Total Item</p>
                <h5 class="text-2xl font-bold text-blue-700">{{ $laporanInventaris['summary']['total_item'] }}</h5>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <p class="text-xs font-semibold text-green-600 mb-1">Nilai Total Inventaris</p>
                <h5 class="text-lg font-bold text-green-700">Rp {{ number_format($laporanInventaris['summary']['total_nilai_inventaris'], 0, ',', '.') }}</h5>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-4 border border-red-200">
                <p class="text-xs font-semibold text-red-600 mb-1">⚠️ Stok Menipis</p>
                <h5 class="text-2xl font-bold text-red-700">{{ $laporanInventaris['summary']['item_menipis'] }}</h5>
            </div>
        </div>

        <!-- Per Kategori -->
        <div class="mb-6">
            <h6 class="font-bold text-slate-700 mb-4">📊 Ringkasan Per Kategori</h6>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($laporanInventaris['per_kategori'] as $kategori)
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-2">
                        <h6 class="font-semibold text-slate-800">{{ $kategori['nama_kategori'] }}</h6>
                        <span class="px-2 py-1 text-xs font-bold rounded bg-blue-100 text-blue-800">
                            {{ $kategori['jumlah_item'] }} item
                        </span>
                    </div>
                    <p class="text-sm text-slate-600 mb-1">Total Stok: <span class="font-semibold">{{ number_format($kategori['total_stok']) }}</span></p>
                    <p class="text-sm text-green-600 font-bold">Nilai: Rp {{ number_format($kategori['nilai_total'], 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Alert Stok Menipis -->
        @if($laporanInventaris['summary']['item_menipis'] > 0)
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h6 class="font-bold text-red-800">Perhatian: Stok Menipis!</h6>
                    <p class="text-sm text-red-700">Terdapat {{ $laporanInventaris['summary']['item_menipis'] }} produk yang perlu segera direstock.</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabel Detail -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm align-middle">
                <thead class="align-bottom">
                    <tr class="border-b-2 border-gray-200 bg-gray-50">
                        <th class="pb-3 pl-2 pr-4 text-left font-bold text-slate-700">Produk</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Kategori</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Cabang</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Stok</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Harga Satuan</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Nilai Total</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($laporanInventaris['data'] as $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-200 {{ $item['status_stok'] == 'Menipis' ? 'bg-red-50' : '' }}">
                        <td class="py-3 pl-2 pr-4">
                            <span class="font-medium text-slate-800">{{ $item['nama_produk'] }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2 py-1 text-xs font-medium rounded bg-purple-100 text-purple-800">
                                {{ $item['kategori'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="text-slate-700">{{ $item['cabang'] }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="font-semibold {{ $item['status_stok'] == 'Menipis' ? 'text-red-600' : 'text-slate-800' }}">
                                {{ number_format($item['stok']) }} {{ $item['satuan'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="text-slate-700">Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="font-bold text-green-600">Rp {{ number_format($item['nilai_total'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="px-2 py-1 text-xs font-bold rounded 
                                @if($item['status_stok'] == 'Menipis') bg-red-100 text-red-800
                                @elseif($item['status_stok'] == 'Normal') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ $item['status_stok'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
