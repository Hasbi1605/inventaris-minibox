<!-- Laporan Inventaris & Stok -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-board">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h6 class="mb-0 font-bold text-slate-800">
                    <i class="fas fa-boxes text-blue-600 mr-2"></i>Laporan Inventaris & Stok
                </h6>
                <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">Monitoring stok dan nilai inventaris</p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="p-6 pt-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Item</p>
                            <h5 class="mb-0 font-bold text-slate-700">{{ $laporanInventaris['summary']['total_item'] }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-list text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Nilai Total Inventaris</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanInventaris['summary']['total_nilai_inventaris'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-dollar-sign text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Stok Menipis</p>
                            <h5 class="mb-0 font-bold text-slate-700">{{ $laporanInventaris['summary']['item_menipis'] }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-exclamation-triangle text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Per Kategori -->
        <div class="mb-6">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="p-4 pb-0 mb-0 bg-white border-b border-gray-100">
                    <h6 class="mb-0 font-bold text-slate-800">
                        <i class="fas fa-chart-bar text-blue-600 mr-2"></i>Ringkasan Per Kategori
                    </h6>
                </div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($laporanInventaris['per_kategori'] as $kategori)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="flex items-center justify-between mb-2">
                                <h6 class="font-semibold text-slate-700">{{ $kategori['nama_kategori'] }}</h6>
                                <span class="inline-block px-2 py-1 text-xs font-semibold leading-tight text-blue-600 bg-blue-100 rounded-lg">
                                    {{ $kategori['jumlah_item'] }} item
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 mb-1">Total Stok: <span class="font-semibold text-slate-700">{{ number_format($kategori['total_stok']) }}</span></p>
                            <p class="text-sm font-bold text-slate-700">Nilai: Rp {{ number_format($kategori['nilai_total'], 0, ',', '.') }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Stok Menipis -->
        @if($laporanInventaris['summary']['item_menipis'] > 0)
        <div class="mb-6">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="p-4 bg-blue-50 rounded-2xl border-l-4 border-blue-600">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                <i class="fas fa-exclamation-triangle text-lg"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h6 class="font-bold text-slate-800">Perhatian: Stok Menipis!</h6>
                            <p class="text-sm text-slate-600">Terdapat {{ $laporanInventaris['summary']['item_menipis'] }} produk yang perlu segera direstock.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Tabel Detail -->
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom">
                    <tr>
                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Produk</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Kategori</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Cabang</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Stok</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Harga Satuan</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Nilai Total</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanInventaris['data'] as $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">{{ $item['nama_produk'] }}</h6>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="inline-block px-2 py-1 text-xs font-semibold leading-tight text-blue-600 bg-blue-100 rounded-lg">
                                {{ $item['kategori'] }}
                            </span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">{{ $item['cabang'] }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">
                                {{ number_format($item['stok']) }} {{ $item['satuan'] }}
                            </span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">Rp {{ number_format($item['harga_satuan'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-sm font-bold leading-tight text-slate-700">Rp {{ number_format($item['nilai_total'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="inline-block px-2 py-1 text-xs font-semibold leading-tight text-blue-600 bg-blue-100 rounded-lg">
                                {{ $item['status_stok'] }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-8 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-boxes text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Tidak ada data inventaris untuk periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($laporanInventaris['data']->count() > 0)
                <tfoot class="border-t-2 border-slate-200">
                    <tr class="bg-gray-50">
                        <td colspan="3" class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-700">TOTAL KESELURUHAN</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-400">-</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-400">-</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-sm font-bold leading-tight text-slate-700">Rp {{ number_format($laporanInventaris['summary']['total_nilai_inventaris'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-400">-</span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
