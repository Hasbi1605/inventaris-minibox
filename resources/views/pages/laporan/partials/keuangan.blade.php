<!-- Laporan Keuangan (Laba Rugi) -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <h6 class="mb-0 font-bold text-slate-800">📊 Laporan Laba Rugi</h6>
        <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
            Periode: {{ \Carbon\Carbon::parse($laporanKeuangan['periode']['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporanKeuangan['periode']['end_date'])->format('d M Y') }}
        </p>
    </div>

    <div class="p-6">
        <!-- Financial Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 border border-green-200">
                <p class="text-sm font-semibold text-green-600 mb-2">💰 Total Pendapatan</p>
                <h4 class="text-2xl font-bold text-green-700 mb-1">Rp {{ number_format($laporanKeuangan['pendapatan']['total'], 0, ',', '.') }}</h4>
                <p class="text-xs text-green-600">{{ number_format($laporanKeuangan['pendapatan']['jumlah_transaksi']) }} transaksi</p>
            </div>
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg p-6 border border-red-200">
                <p class="text-sm font-semibold text-red-600 mb-2">📤 Total Beban</p>
                <h4 class="text-2xl font-bold text-red-700 mb-1">Rp {{ number_format($laporanKeuangan['beban']['total_beban'], 0, ',', '.') }}</h4>
                <p class="text-xs text-red-600">Operasional + Gaji + Inventaris</p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 border border-blue-200">
                <p class="text-sm font-semibold text-blue-600 mb-2">📈 Laba Bersih</p>
                <h4 class="text-2xl font-bold {{ $laporanKeuangan['laba_rugi']['laba_bersih'] >= 0 ? 'text-blue-700' : 'text-red-700' }} mb-1">
                    Rp {{ number_format($laporanKeuangan['laba_rugi']['laba_bersih'], 0, ',', '.') }}
                </h4>
                <p class="text-xs {{ $laporanKeuangan['laba_rugi']['margin_laba_persen'] >= 0 ? 'text-blue-600' : 'text-red-600' }}">
                    Margin: {{ number_format($laporanKeuangan['laba_rugi']['margin_laba_persen'], 2) }}%
                </p>
            </div>
        </div>

        <!-- Detailed Income Statement -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h6 class="text-white font-bold mb-0">Laporan Laba Rugi Detail</h6>
            </div>
            
            <div class="p-6">
                <!-- Pendapatan Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between py-3 border-b-2 border-green-200 bg-green-50 px-4 rounded-t-lg">
                        <span class="font-bold text-green-700">PENDAPATAN</span>
                        <span class="font-bold text-green-700">Rp {{ number_format($laporanKeuangan['pendapatan']['total'], 0, ',', '.') }}</span>
                    </div>
                    <div class="px-4 py-2 bg-gray-50">
                        <div class="flex justify-between text-sm text-slate-600">
                            <span>Jumlah Transaksi</span>
                            <span>{{ number_format($laporanKeuangan['pendapatan']['jumlah_transaksi']) }} transaksi</span>
                        </div>
                        <div class="flex justify-between text-sm text-slate-600 mt-1">
                            <span>Rata-rata per Transaksi</span>
                            <span>Rp {{ number_format($laporanKeuangan['pendapatan']['rata_rata_per_transaksi'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Beban Section -->
                <div class="mb-6">
                    <div class="flex items-center justify-between py-3 border-b-2 border-red-200 bg-red-50 px-4 rounded-t-lg">
                        <span class="font-bold text-red-700">BEBAN USAHA</span>
                        <span class="font-bold text-red-700">Rp {{ number_format($laporanKeuangan['beban']['total_beban'], 0, ',', '.') }}</span>
                    </div>
                    
                    <!-- Breakdown Beban -->
                    <div class="space-y-2 px-4 py-3 bg-gray-50">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-700">1. Pengeluaran Operasional</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($laporanKeuangan['beban']['pengeluaran_operasional'], 0, ',', '.') }}</span>
                        </div>
                        
                        <!-- Sub-kategori pengeluaran -->
                        @if($laporanKeuangan['pengeluaran_per_kategori']->count() > 0)
                        <div class="ml-6 space-y-1">
                            @foreach($laporanKeuangan['pengeluaran_per_kategori'] as $kategori)
                            <div class="flex justify-between text-xs text-slate-600">
                                <span>- {{ $kategori->kategori->nama_kategori ?? 'Lainnya' }}</span>
                                <span>Rp {{ number_format($kategori->total, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        
                        <div class="flex justify-between text-sm pt-2 border-t">
                            <span class="text-slate-700">2. Gaji & Komisi Karyawan</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($laporanKeuangan['beban']['gaji_karyawan'], 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-700">3. Pembelian Inventaris</span>
                            <span class="font-semibold text-slate-800">Rp {{ number_format($laporanKeuangan['beban']['pembelian_inventaris'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Laba Rugi Section -->
                <div class="border-t-4 border-slate-300 pt-4">
                    <div class="flex items-center justify-between py-4 {{ $laporanKeuangan['laba_rugi']['laba_bersih'] >= 0 ? 'bg-blue-50 border-blue-200' : 'bg-red-50 border-red-200' }} px-4 rounded-lg border-2">
                        <span class="font-bold text-lg {{ $laporanKeuangan['laba_rugi']['laba_bersih'] >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                            LABA (RUGI) BERSIH
                        </span>
                        <span class="font-bold text-2xl {{ $laporanKeuangan['laba_rugi']['laba_bersih'] >= 0 ? 'text-blue-700' : 'text-red-700' }}">
                            Rp {{ number_format($laporanKeuangan['laba_rugi']['laba_bersih'], 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-end mt-2 px-4">
                        <span class="text-sm {{ $laporanKeuangan['laba_rugi']['margin_laba_persen'] >= 0 ? 'text-blue-600' : 'text-red-600' }} font-medium">
                            Margin Laba: {{ number_format($laporanKeuangan['laba_rugi']['margin_laba_persen'], 2) }}%
                        </span>
                    </div>
                </div>

                <!-- Financial Ratio Analysis -->
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs text-slate-500 mb-1">Rasio Beban terhadap Pendapatan</p>
                        <p class="text-lg font-bold text-slate-700">
                            {{ $laporanKeuangan['pendapatan']['total'] > 0 ? number_format(($laporanKeuangan['beban']['total_beban'] / $laporanKeuangan['pendapatan']['total']) * 100, 2) : 0 }}%
                        </p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs text-slate-500 mb-1">Efisiensi Operasional</p>
                        <p class="text-lg font-bold text-slate-700">
                            {{ $laporanKeuangan['pendapatan']['total'] > 0 ? number_format(($laporanKeuangan['laba_rugi']['laba_bersih'] / $laporanKeuangan['pendapatan']['total']) * 100, 2) : 0 }}%
                        </p>
                    </div>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <p class="text-xs text-slate-500 mb-1">Break Even Point</p>
                        <p class="text-lg font-bold text-slate-700">
                            Rp {{ number_format($laporanKeuangan['beban']['total_beban'], 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
