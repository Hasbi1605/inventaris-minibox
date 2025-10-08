<!-- Laporan Layanan Detail -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <h6 class="mb-0 font-bold text-slate-800">💇 Laporan Layanan & Produk</h6>
        <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
            Periode: {{ \Carbon\Carbon::parse($laporanLayanan['periode']['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporanLayanan['periode']['end_date'])->format('d M Y') }}
        </p>
    </div>

    <div class="p-6">
        <!-- Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <p class="text-xs font-semibold text-blue-600 mb-1">Jumlah Layanan</p>
                <h5 class="text-2xl font-bold text-blue-700">{{ $laporanLayanan['summary']['jumlah_layanan'] }}</h5>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <p class="text-xs font-semibold text-green-600 mb-1">Total Pendapatan</p>
                <h5 class="text-lg font-bold text-green-700">Rp {{ number_format($laporanLayanan['summary']['total_pendapatan'], 0, ',', '.') }}</h5>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <p class="text-xs font-semibold text-purple-600 mb-1">Total Transaksi</p>
                <h5 class="text-2xl font-bold text-purple-700">{{ number_format($laporanLayanan['summary']['total_transaksi']) }}</h5>
            </div>
        </div>

        <!-- Top & Bottom Services -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Top 5 Layanan -->
            <div class="border border-green-200 rounded-lg p-4 bg-green-50">
                <h6 class="font-bold text-green-700 mb-4">🏆 Top 5 Layanan Terlaris</h6>
                <div class="space-y-3">
                    @foreach($laporanLayanan['data']->take(5) as $index => $layanan)
                    <div class="flex items-center bg-white rounded-lg p-3 shadow-sm">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 text-white flex items-center justify-center font-bold text-sm mr-3">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-slate-800">{{ $layanan['nama_layanan'] }}</div>
                            <div class="text-xs text-slate-500">{{ $layanan['jumlah_transaksi'] }} transaksi ({{ $layanan['persentase'] }}%)</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-green-600">Rp {{ number_format($layanan['total_pendapatan'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Bottom 5 Layanan -->
            <div class="border border-orange-200 rounded-lg p-4 bg-orange-50">
                <h6 class="font-bold text-orange-700 mb-4">⚠️ Bottom 5 Layanan (Perlu Evaluasi)</h6>
                <div class="space-y-3">
                    @foreach($laporanLayanan['data']->reverse()->take(5) as $layanan)
                    <div class="flex items-center bg-white rounded-lg p-3 shadow-sm">
                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 text-white flex items-center justify-center font-bold text-xs mr-3">
                            <i class="fas fa-exclamation"></i>
                        </div>
                        <div class="flex-1">
                            <div class="font-medium text-slate-800">{{ $layanan['nama_layanan'] }}</div>
                            <div class="text-xs text-slate-500">{{ $layanan['jumlah_transaksi'] }} transaksi ({{ $layanan['persentase'] }}%)</div>
                        </div>
                        <div class="text-right">
                            <div class="font-bold text-orange-600">Rp {{ number_format($layanan['total_pendapatan'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Tabel Detail -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm align-middle">
                <thead class="align-bottom">
                    <tr class="border-b-2 border-gray-200 bg-gray-50">
                        <th class="pb-3 pl-2 pr-4 text-left font-bold text-slate-700">Layanan</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Harga</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Jumlah Transaksi</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Total Pendapatan</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Rata-rata</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($laporanLayanan['data'] as $layanan)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-3 pl-2 pr-4">
                            <span class="font-medium text-slate-800">{{ $layanan['nama_layanan'] }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="text-slate-700">Rp {{ number_format($layanan['harga_layanan'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="font-semibold text-slate-800">{{ number_format($layanan['jumlah_transaksi']) }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="font-bold text-green-600">Rp {{ number_format($layanan['total_pendapatan'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <span class="text-slate-700">Rp {{ number_format($layanan['rata_rata_per_transaksi'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex items-center justify-center">
                                <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                    <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full" style="width: {{ $layanan['persentase'] }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-slate-700">{{ number_format($layanan['persentase'], 1) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
