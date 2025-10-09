<!-- Laporan Keuangan (Laba Rugi) -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-board">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h6 class="mb-0 font-bold text-slate-800">
                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>Laporan Laba Rugi
                </h6>
                <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
                    Periode: {{ \Carbon\Carbon::parse($laporanKeuangan['periode']['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporanKeuangan['periode']['end_date'])->format('d M Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="p-6 pt-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Pendapatan</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanKeuangan['pendapatan']['total'], 0, ',', '.') }}</h5>
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
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Beban</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanKeuangan['beban']['total_beban'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-arrow-down text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Laba Bersih</p>
                            <h5 class="mb-0 font-bold text-slate-700">
                                Rp {{ number_format($laporanKeuangan['laba_rugi']['laba_bersih'], 0, ',', '.') }}
                            </h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-chart-line text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Margin Laba</p>
                            <h5 class="mb-0 font-bold text-slate-700">{{ number_format($laporanKeuangan['laba_rugi']['margin_laba_persen'], 2) }}%</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-percentage text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Income Statement Table -->
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom">
                    <tr>
                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                            Keterangan
                        </th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                            Kategori
                        </th>
                        <th class="px-6 py-3 font-bold text-right uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                            Jumlah (Rp)
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PENDAPATAN Section -->
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex-shrink-0">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                        <i class="fas fa-arrow-up"></i>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">Pendapatan Usaha</h6>
                                    <p class="mb-0 leading-tight text-xs text-slate-400">{{ number_format($laporanKeuangan['pendapatan']['jumlah_transaksi']) }} transaksi</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="inline-block px-2 py-1 text-xs font-semibold leading-tight text-blue-600 bg-blue-100 rounded-lg">
                                Pendapatan
                            </span>
                        </td>
                        <td class="p-2 text-right align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <p class="mb-0 text-sm font-bold leading-tight text-slate-700">
                                Rp {{ number_format($laporanKeuangan['pendapatan']['total'], 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Divider Row -->
                    <tr>
                        <td colspan="3" class="px-6 py-2 bg-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 mr-3"></div>
                                <h6 class="mb-0 text-xs font-bold text-slate-600 uppercase">Beban Usaha</h6>
                            </div>
                        </td>
                    </tr>

                    <!-- Beban Details -->
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex-shrink-0">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                        <i class="fas fa-receipt"></i>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">Pengeluaran Operasional</h6>
                                    @if($laporanKeuangan['pengeluaran_per_kategori']->count() > 0)
                                    <p class="mb-0 leading-tight text-xs text-slate-400">
                                        {{ $laporanKeuangan['pengeluaran_per_kategori']->pluck('kategori.nama_kategori')->filter()->implode(', ') }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="inline-block px-2 py-1 text-xs font-semibold leading-tight text-slate-600 bg-slate-100 rounded-lg">
                                Operasional
                            </span>
                        </td>
                        <td class="p-2 text-right align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <p class="mb-0 text-sm font-semibold leading-tight text-slate-700">
                                Rp {{ number_format($laporanKeuangan['beban']['pengeluaran_operasional'], 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex-shrink-0">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">Gaji & Komisi Karyawan</h6>
                                    <p class="mb-0 leading-tight text-xs text-slate-400">Biaya gaji dan komisi kapster</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="inline-block px-2 py-1 text-xs font-semibold leading-tight text-slate-600 bg-slate-100 rounded-lg">
                                Gaji
                            </span>
                        </td>
                        <td class="p-2 text-right align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <p class="mb-0 text-sm font-semibold leading-tight text-slate-700">
                                Rp {{ number_format($laporanKeuangan['beban']['gaji_karyawan'], 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>

                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex-shrink-0">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                        <i class="fas fa-boxes"></i>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">Pembelian Inventaris</h6>
                                    <p class="mb-0 leading-tight text-xs text-slate-400">Biaya pembelian perlengkapan</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="inline-block px-2 py-1 text-xs font-semibold leading-tight text-slate-600 bg-slate-100 rounded-lg">
                                Inventaris
                            </span>
                        </td>
                        <td class="p-2 text-right align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <p class="mb-0 text-sm font-semibold leading-tight text-slate-700">
                                Rp {{ number_format($laporanKeuangan['beban']['pembelian_inventaris'], 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Total Beban -->
                    <tr class="bg-gray-50">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex-shrink-0 w-10 h-10 mr-3"></div>
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-bold text-slate-700">Total Beban Usaha</h6>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">-</span>
                        </td>
                        <td class="p-2 text-right align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <p class="mb-0 text-sm font-bold leading-tight text-slate-700">
                                Rp {{ number_format($laporanKeuangan['beban']['total_beban'], 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>
                </tbody>
                <tfoot class="border-t-2 border-slate-200">
                    <tr class="bg-gray-50">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex-shrink-0">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-bold text-slate-700">LABA (RUGI) BERSIH</h6>
                                    <p class="mb-0 leading-tight text-xs text-slate-400">Margin: {{ number_format($laporanKeuangan['laba_rugi']['margin_laba_persen'], 2) }}%</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">-</span>
                        </td>
                        <td class="p-2 text-right align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <p class="mb-0 text-sm font-bold leading-tight text-slate-700">
                                Rp {{ number_format($laporanKeuangan['laba_rugi']['laba_bersih'], 0, ',', '.') }}
                            </p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Financial Ratio Cards -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center">
                        <div class="flex items-center justify-center w-12 h-12 mr-4 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                            <i class="fas fa-percentage text-lg text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Rasio Beban / Pendapatan</p>
                            <h5 class="mb-0 font-bold text-slate-700">
                                {{ $laporanKeuangan['pendapatan']['total'] > 0 ? number_format(($laporanKeuangan['beban']['total_beban'] / $laporanKeuangan['pendapatan']['total']) * 100, 2) : 0 }}%
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center">
                        <div class="flex items-center justify-center w-12 h-12 mr-4 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                            <i class="fas fa-chart-pie text-lg text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Transaksi</p>
                            <h5 class="mb-0 font-bold text-slate-700">
                                {{ number_format($laporanKeuangan['pendapatan']['jumlah_transaksi']) }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center">
                        <div class="flex items-center justify-center w-12 h-12 mr-4 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                            <i class="fas fa-calculator text-lg text-white"></i>
                        </div>
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Avg per Transaksi</p>
                            <h5 class="mb-0 font-bold text-slate-700">
                                Rp {{ number_format($laporanKeuangan['pendapatan']['rata_rata_per_transaksi'], 0, ',', '.') }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
