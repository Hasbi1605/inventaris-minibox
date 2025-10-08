<!-- Laporan Cash Flow -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <h6 class="mb-0 font-bold text-slate-800">💸 Laporan Arus Kas (Cash Flow)</h6>
        <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
            Periode: {{ \Carbon\Carbon::parse($laporanCashFlow['periode']['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporanCashFlow['periode']['end_date'])->format('d M Y') }}
        </p>
    </div>

    <div class="p-6">
        <!-- Main Cash Flow Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border-2 border-green-300">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-semibold text-green-700">💵 Kas Masuk</p>
                    <i class="fas fa-arrow-down text-2xl text-green-600"></i>
                </div>
                <h4 class="text-2xl font-bold text-green-700">Rp {{ number_format($laporanCashFlow['kas_masuk']['total'], 0, ',', '.') }}</h4>
            </div>
            
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-6 border-2 border-red-300">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-semibold text-red-700">💸 Kas Keluar</p>
                    <i class="fas fa-arrow-up text-2xl text-red-600"></i>
                </div>
                <h4 class="text-2xl font-bold text-red-700">Rp {{ number_format($laporanCashFlow['kas_keluar']['total'], 0, ',', '.') }}</h4>
            </div>
            
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border-2 border-blue-300">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-semibold text-blue-700">📊 Net Cash Flow</p>
                    <i class="fas fa-balance-scale text-2xl text-blue-600"></i>
                </div>
                <h4 class="text-2xl font-bold {{ $laporanCashFlow['net_cash_flow'] >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                    Rp {{ number_format($laporanCashFlow['net_cash_flow'], 0, ',', '.') }}
                </h4>
            </div>
        </div>

        <!-- Detailed Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Kas Masuk Detail -->
            <div class="border border-green-200 rounded-lg p-6 bg-green-50">
                <h6 class="font-bold text-green-800 mb-4 flex items-center">
                    <i class="fas fa-money-bill-wave mr-2"></i>
                    Detail Kas Masuk
                </h6>
                
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4">
                        <p class="text-sm font-semibold text-slate-700 mb-3">Per Metode Pembayaran</p>
                        @foreach($laporanCashFlow['kas_masuk']['per_metode'] as $metode)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div class="flex items-center">
                                <i class="fas fa-circle text-xs text-green-500 mr-2"></i>
                                <span class="text-sm text-slate-700 capitalize">{{ $metode->metode_pembayaran }}</span>
                            </div>
                            <span class="text-sm font-bold text-green-600">Rp {{ number_format($metode->total, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 text-white">
                        <p class="text-xs opacity-90 mb-1">Total Kas Masuk</p>
                        <p class="text-2xl font-bold">Rp {{ number_format($laporanCashFlow['kas_masuk']['total'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <!-- Kas Keluar Detail -->
            <div class="border border-red-200 rounded-lg p-6 bg-red-50">
                <h6 class="font-bold text-red-800 mb-4 flex items-center">
                    <i class="fas fa-receipt mr-2"></i>
                    Detail Kas Keluar
                </h6>
                
                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 space-y-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-tools text-orange-500 mr-2"></i>
                                <span class="text-sm text-slate-700">Pengeluaran Operasional</span>
                            </div>
                            <span class="text-sm font-bold text-red-600">Rp {{ number_format($laporanCashFlow['kas_keluar']['pengeluaran_operasional'], 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-user-tie text-blue-500 mr-2"></i>
                                <span class="text-sm text-slate-700">Gaji & Komisi Karyawan</span>
                            </div>
                            <span class="text-sm font-bold text-red-600">Rp {{ number_format($laporanCashFlow['kas_keluar']['gaji_karyawan'], 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white">
                        <p class="text-xs opacity-90 mb-1">Total Kas Keluar</p>
                        <p class="text-2xl font-bold">Rp {{ number_format($laporanCashFlow['kas_keluar']['total'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visual Cash Flow -->
        <div class="mt-6 p-6 bg-gray-50 rounded-lg">
            <h6 class="font-bold text-slate-800 mb-4">Visualisasi Arus Kas</h6>
            <div class="space-y-3">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-green-700">Kas Masuk</span>
                        <span class="text-sm font-bold text-green-600">Rp {{ number_format($laporanCashFlow['kas_masuk']['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-green-400 to-green-600 h-4 rounded-full" 
                             style="width: {{ $laporanCashFlow['kas_masuk']['total'] > 0 ? min(100, ($laporanCashFlow['kas_masuk']['total'] / max($laporanCashFlow['kas_masuk']['total'], $laporanCashFlow['kas_keluar']['total']) * 100)) : 0 }}%">
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-red-700">Kas Keluar</span>
                        <span class="text-sm font-bold text-red-600">Rp {{ number_format($laporanCashFlow['kas_keluar']['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="bg-gradient-to-r from-red-400 to-red-600 h-4 rounded-full" 
                             style="width: {{ $laporanCashFlow['kas_keluar']['total'] > 0 ? min(100, ($laporanCashFlow['kas_keluar']['total'] / max($laporanCashFlow['kas_masuk']['total'], $laporanCashFlow['kas_keluar']['total']) * 100)) : 0 }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
