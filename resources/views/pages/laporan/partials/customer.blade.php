<!-- Laporan Customer Behavior -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <h6 class="mb-0 font-bold text-slate-800"><i class="fas fa-chart-pie text-blue-600 mr-2"></i>Laporan Customer Behavior</h6>
        <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
            Periode: {{ 
Carbon\Carbon::parse($laporanCustomer['periode']['start_date'])->format('d M Y') }} - {{ 
Carbon\Carbon::parse($laporanCustomer['periode']['end_date'])->format('d M Y') }}
        </p>
    </div>

    <div class="p-6">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Transaksi</p>
                            <h5 class="mb-0 font-bold text-slate-700">{{ number_format($laporanCustomer['summary']['total_transaksi']) }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-receipt text-lg text-white"></i>
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
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanCustomer['summary']['total_pendapatan'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-money-bill-wave text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Rata-rata per Transaksi</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanCustomer['summary']['rata_rata_per_transaksi'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-chart-line text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Peak Days & Payment Methods -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
            <!-- Peak Days -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-6">
                    <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                        <div class="inline-block w-8 h-8 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center mr-2 shadow-soft-md">
                            <i class="fas fa-calendar-day text-sm text-white"></i>
                        </div>
                        Hari Tersibuk
                    </h6>
                    <div class="overflow-x-auto">
                        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                            <thead class="align-bottom">
                                <tr>
                                    <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Hari</th>
                                    <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Jumlah Transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanCustomer['peak_days']->take(7) as $day)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <div class="flex px-2 py-1">
                                            <div class="flex flex-col justify-center">
                                                <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">{{ $day['hari'] }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                                        <span class="text-xs font-semibold leading-tight text-slate-400">{{ $day['jumlah_transaksi'] }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="py-8 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <i class="fas fa-calendar text-lg text-gray-400"></i>
                                            </div>
                                            <p class="text-slate-500 text-sm">Data tidak tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-6">
                    <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                        <div class="inline-block w-8 h-8 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center mr-2 shadow-soft-md">
                            <i class="fas fa-credit-card text-sm text-white"></i>
                        </div>
                        Metode Pembayaran Favorit
                    </h6>
                    <div class="space-y-3">
                        @forelse($laporanCustomer['metode_pembayaran'] as $metode)
                        <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-slate-700 capitalize">{{ $metode['metode'] }}</span>
                                <span class="text-xs font-bold text-slate-600">{{ number_format($metode['persentase'], 1) }}%</span>
                            </div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs text-slate-500">{{ $metode['jumlah_transaksi'] }} transaksi</span>
                                <span class="text-xs text-slate-500">Rp {{ number_format($metode['total_pendapatan'], 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-600 to-cyan-400 h-2 rounded-full transition-all duration-500" style="width: {{ $metode['persentase'] }}%"></div>
                            </div>
                        </div>
                        @empty
                        <div class="py-8 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-credit-card text-lg text-gray-400"></i>
                                </div>
                                <p class="text-slate-500 text-sm">Data tidak tersedia</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Insights & Recommendations -->
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
            <div class="flex-auto p-6">
                <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                    <div class="inline-block w-8 h-8 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center mr-2 shadow-soft-md">
                        <i class="fas fa-lightbulb text-sm text-white"></i>
                    </div>
                    Insights & Rekomendasi
                </h6>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if($laporanCustomer['peak_days']->count() > 0)
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-500 text-white mr-3">
                                    <i class="fas fa-calendar-check text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-blue-700 mb-1">Hari Tersibuk</p>
                                <p class="text-sm text-slate-700">
                                    {{ $laporanCustomer['peak_days']->first()['hari'] }} adalah hari dengan transaksi tertinggi. Pastikan kapster tersedia optimal.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-500 text-white mr-3">
                                    <i class="fas fa-chart-line text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-blue-700 mb-1">Rata-rata Spending</p>
                                <p class="text-sm text-slate-700">
                                    Customer rata-rata menghabiskan Rp {{ number_format($laporanCustomer['summary']['rata_rata_per_transaksi'], 0, ',', '.') }} per kunjungan.
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($laporanCustomer['metode_pembayaran']->count() > 0)
                    <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-500 text-white mr-3">
                                    <i class="fas fa-credit-card text-sm"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-blue-700 mb-1">Metode Favorit</p>
                                <p class="text-sm text-slate-700">
                                    {{ ucfirst($laporanCustomer['metode_pembayaran']->first()['metode']) }} adalah metode pembayaran paling populer ({{ number_format($laporanCustomer['metode_pembayaran']->first()['persentase'], 1) }}%).
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>