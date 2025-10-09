<!-- Laporan Cash Flow -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <h6 class="mb-0 font-bold text-slate-800">
            <i class="fas fa-chart-line text-blue-600 mr-2"></i>Laporan Arus Kas (Cash Flow)
        </h6>
        <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
            Periode: {{ \Carbon\Carbon::parse($laporanCashFlow['periode']['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporanCashFlow['periode']['end_date'])->format('d M Y') }}
        </p>
    </div>

    <div class="p-6">
        <!-- Main Cash Flow Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Kas Masuk</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanCashFlow['kas_masuk']['total'], 0, ',', '.') }}</h5>
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
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Kas Keluar</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanCashFlow['kas_keluar']['total'], 0, ',', '.') }}</h5>
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
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Net Cash Flow</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanCashFlow['net_cash_flow'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-balance-scale text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Kas Masuk Detail -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-6">
                    <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                        <div class="inline-block w-8 h-8 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center mr-2 shadow-soft-md">
                            <i class="fas fa-money-bill-wave text-sm text-white"></i>
                        </div>
                        Detail Kas Masuk
                    </h6>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            @foreach($laporanCashFlow['kas_masuk']['per_metode'] as $metode)
                            <div class="flex items-center justify-between py-2 border-b border-gray-200 last:border-0">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-2 h-2 mr-2 rounded-full bg-blue-500"></span>
                                    <span class="text-sm text-slate-700 capitalize font-medium">{{ $metode->metode_pembayaran }}</span>
                                </div>
                                <span class="text-sm font-bold text-slate-700">Rp {{ number_format($metode->total, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg p-4 text-white shadow-soft-md">
                            <p class="text-xs opacity-90 mb-1 font-semibold">Total Kas Masuk</p>
                            <p class="text-xl font-bold">Rp {{ number_format($laporanCashFlow['kas_masuk']['total'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kas Keluar Detail -->
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-6">
                    <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                        <div class="inline-block w-8 h-8 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center mr-2 shadow-soft-md">
                            <i class="fas fa-receipt text-sm text-white"></i>
                        </div>
                        Detail Kas Keluar
                    </h6>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                            <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-2 h-2 mr-2 rounded-full bg-blue-500"></span>
                                    <span class="text-sm text-slate-700 font-medium">Pengeluaran Operasional</span>
                                </div>
                                <span class="text-sm font-bold text-slate-700">Rp {{ number_format($laporanCashFlow['kas_keluar']['pengeluaran_operasional'], 0, ',', '.') }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between py-2">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center justify-center w-2 h-2 mr-2 rounded-full bg-blue-500"></span>
                                    <span class="text-sm text-slate-700 font-medium">Gaji & Komisi Karyawan</span>
                                </div>
                                <span class="text-sm font-bold text-slate-700">Rp {{ number_format($laporanCashFlow['kas_keluar']['gaji_karyawan'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="bg-gradient-to-tl from-blue-600 to-cyan-400 rounded-lg p-4 text-white shadow-soft-md">
                            <p class="text-xs opacity-90 mb-1 font-semibold">Total Kas Keluar</p>
                            <p class="text-xl font-bold">Rp {{ number_format($laporanCashFlow['kas_keluar']['total'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visual Cash Flow -->
        <div class="mt-6 p-6 bg-white rounded-lg border border-gray-100 shadow-soft-xl">
            <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                <div class="inline-block w-8 h-8 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center mr-2 shadow-soft-md">
                    <i class="fas fa-chart-bar text-sm text-white"></i>
                </div>
                Visualisasi Arus Kas
            </h6>
            <div class="space-y-4">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600">Kas Masuk</span>
                        <span class="text-sm font-bold text-slate-700">Rp {{ number_format($laporanCashFlow['kas_masuk']['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-cyan-400 h-4 rounded-full transition-all duration-500 ease-out" 
                             style="width: {{ $laporanCashFlow['kas_masuk']['total'] > 0 ? min(100, ($laporanCashFlow['kas_masuk']['total'] / max($laporanCashFlow['kas_masuk']['total'], $laporanCashFlow['kas_keluar']['total']) * 100)) : 0 }}%">
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-semibold text-slate-600">Kas Keluar</span>
                        <span class="text-sm font-bold text-slate-700">Rp {{ number_format($laporanCashFlow['kas_keluar']['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-cyan-400 h-4 rounded-full transition-all duration-500 ease-out" 
                             style="width: {{ $laporanCashFlow['kas_keluar']['total'] > 0 ? min(100, ($laporanCashFlow['kas_keluar']['total'] / max($laporanCashFlow['kas_masuk']['total'], $laporanCashFlow['kas_keluar']['total']) * 100)) : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
