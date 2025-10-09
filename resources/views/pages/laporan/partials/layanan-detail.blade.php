<!-- Laporan Layanan Detail -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-board">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h6 class="mb-0 font-bold text-slate-800">
                    <i class="fas fa-cut text-blue-600 mr-2"></i>Laporan Layanan & Produk
                </h6>
                <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
                    Periode: {{ \Carbon\Carbon::parse($laporanLayanan['periode']['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporanLayanan['periode']['end_date'])->format('d M Y') }}
                </p>
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
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Jumlah Layanan</p>
                            <h5 class="mb-0 font-bold text-slate-700">{{ $laporanLayanan['summary']['jumlah_layanan'] }}</h5>
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
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Pendapatan</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanLayanan['summary']['total_pendapatan'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-arrow-up text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Transaksi</p>
                            <h5 class="mb-0 font-bold text-slate-700">{{ number_format($laporanLayanan['summary']['total_transaksi']) }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-receipt text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top & Bottom Services -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Top 5 Layanan -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="p-4 pb-0 mb-0 bg-white border-b border-gray-100">
                    <h6 class="mb-0 font-bold text-slate-800">
                        <i class="fas fa-trophy text-blue-600 mr-2"></i>Top 5 Layanan Terlaris
                    </h6>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        @foreach($laporanLayanan['data']->take(5) as $index => $layanan)
                        <div class="flex items-center hover:bg-gray-50 rounded-lg p-3 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                    #{{ $index + 1 }}
                                </div>
                            </div>
                            <div class="flex-1">
                                <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">{{ $layanan['nama_layanan'] }}</h6>
                                <p class="mb-0 leading-tight text-xs text-slate-400">{{ $layanan['jumlah_transaksi'] }} transaksi</p>
                            </div>
                            <div class="text-right">
                                <p class="mb-0 text-sm font-bold leading-tight text-slate-700">Rp {{ number_format($layanan['total_pendapatan'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Bottom 5 Layanan -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="p-4 pb-0 mb-0 bg-white border-b border-gray-100">
                    <h6 class="mb-0 font-bold text-slate-800">
                        <i class="fas fa-exclamation-circle text-blue-600 mr-2"></i>Bottom 5 Layanan
                    </h6>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        @foreach($laporanLayanan['data']->reverse()->take(5) as $layanan)
                        <div class="flex items-center hover:bg-gray-50 rounded-lg p-3 transition-colors duration-200">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                    <i class="fas fa-arrow-down text-xs"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">{{ $layanan['nama_layanan'] }}</h6>
                                <p class="mb-0 leading-tight text-xs text-slate-400">{{ $layanan['jumlah_transaksi'] }} transaksi</p>
                            </div>
                            <div class="text-right">
                                <p class="mb-0 text-sm font-bold leading-tight text-slate-700">Rp {{ number_format($layanan['total_pendapatan'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Detail -->
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom">
                    <tr>
                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Layanan</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Harga</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Jumlah Transaksi</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total Pendapatan</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Rata-rata</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanLayanan['data'] as $layanan)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">{{ $layanan['nama_layanan'] }}</h6>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">Rp {{ number_format($layanan['harga_layanan'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">{{ number_format($layanan['jumlah_transaksi']) }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-sm font-bold leading-tight text-slate-700">Rp {{ number_format($layanan['total_pendapatan'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">Rp {{ number_format($layanan['rata_rata_per_transaksi'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex items-center justify-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-gradient-to-r from-blue-600 to-cyan-400 h-2 rounded-full" style="width: {{ $layanan['persentase'] }}%"></div>
                                </div>
                                <span class="text-xs font-semibold leading-tight text-slate-400">{{ number_format($layanan['persentase'], 1) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-cut text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Tidak ada data layanan untuk periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($laporanLayanan['data']->count() > 0)
                <tfoot class="border-t-2 border-slate-200">
                    <tr class="bg-gray-50">
                        <td colspan="2" class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-700">TOTAL KESELURUHAN</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-700">{{ number_format($laporanLayanan['summary']['total_transaksi']) }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-sm font-bold leading-tight text-slate-700">Rp {{ number_format($laporanLayanan['summary']['total_pendapatan'], 0, ',', '.') }}</span>
                        </td>
                        <td colspan="2" class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-400">-</span>
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
