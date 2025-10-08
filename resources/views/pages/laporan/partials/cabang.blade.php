<!-- Laporan Per Cabang -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <h6 class="mb-0 font-bold text-slate-800">🏪 Laporan Performa Per Cabang</h6>
        <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
            Periode: {{ \Carbon\Carbon::parse($laporanCabang['periode']['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporanCabang['periode']['end_date'])->format('d M Y') }}
        </p>
    </div>

    <div class="p-6">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <p class="text-xs font-semibold text-purple-600 mb-1">Total Cabang</p>
                <h5 class="text-2xl font-bold text-purple-700">{{ $laporanCabang['data']->count() }}</h5>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <p class="text-xs font-semibold text-green-600 mb-1">Total Pendapatan</p>
                <h5 class="text-lg font-bold text-green-700">Rp {{ number_format($laporanCabang['summary']['total_pendapatan'], 0, ',', '.') }}</h5>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <p class="text-xs font-semibold text-blue-600 mb-1">Total Transaksi</p>
                <h5 class="text-2xl font-bold text-blue-700">{{ number_format($laporanCabang['summary']['total_transaksi']) }}</h5>
            </div>
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                <p class="text-xs font-semibold text-orange-600 mb-1">Total Laba</p>
                <h5 class="text-lg font-bold text-orange-700">Rp {{ number_format($laporanCabang['summary']['total_laba'], 0, ',', '.') }}</h5>
            </div>
        </div>

        <!-- Tabel Cabang -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm align-middle">
                <thead class="align-bottom">
                    <tr class="border-b-2 border-gray-200">
                        <th class="pb-3 pl-2 pr-4 text-left font-bold text-slate-700">Ranking</th>
                        <th class="pb-3 px-4 text-left font-bold text-slate-700">Nama Cabang</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Pendapatan</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Pengeluaran</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Laba</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Transaksi</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Rata-rata</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Margin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($laporanCabang['data'] as $index => $cabang)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-4 pl-2 pr-4">
                            <div class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold 
                                @if($index == 0) bg-gradient-to-tl from-yellow-400 to-yellow-600 text-white
                                @elseif($index == 1) bg-gradient-to-tl from-gray-300 to-gray-500 text-white
                                @elseif($index == 2) bg-gradient-to-tl from-orange-400 to-orange-600 text-white
                                @else bg-gray-200 text-gray-600
                                @endif">
                                {{ $index + 1 }}
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $cabang['nama_cabang'] }}</div>
                                <div class="text-xs text-slate-500">{{ $cabang['alamat'] }}</div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-semibold text-green-600">Rp {{ number_format($cabang['pendapatan'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-semibold text-red-600">Rp {{ number_format($cabang['pengeluaran'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-bold {{ $cabang['laba'] >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                                Rp {{ number_format($cabang['laba'], 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-semibold text-slate-800">{{ number_format($cabang['jumlah_transaksi']) }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-medium text-slate-700">Rp {{ number_format($cabang['rata_rata_per_transaksi'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2 py-1 text-xs font-bold rounded {{ $cabang['margin_laba_persen'] >= 30 ? 'bg-green-100 text-green-800' : ($cabang['margin_laba_persen'] >= 15 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ number_format($cabang['margin_laba_persen'], 2) }}%
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Visual Comparison -->
        <div class="mt-8 p-6 bg-gray-50 rounded-lg">
            <h6 class="font-bold text-slate-800 mb-4">Perbandingan Visual Pendapatan</h6>
            <div class="space-y-4">
                @foreach($laporanCabang['data'] as $cabang)
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-slate-700">{{ $cabang['nama_cabang'] }}</span>
                        <span class="text-sm font-bold text-green-600">Rp {{ number_format($cabang['pendapatan'], 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-3 rounded-full transition-all duration-500" 
                             style="width: {{ $laporanCabang['summary']['total_pendapatan'] > 0 ? ($cabang['pendapatan'] / $laporanCabang['summary']['total_pendapatan'] * 100) : 0 }}%">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
