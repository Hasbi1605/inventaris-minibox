<!-- Laporan Customer Behavior -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <h6 class="mb-0 font-bold text-slate-800">👥 Laporan Customer Behavior</h6>
        <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
            Periode: {{ \Carbon\Carbon::parse($laporanCustomer['periode']['start_date'])->format('d M Y') }} - {{ \Carbon\Carbon::parse($laporanCustomer['periode']['end_date'])->format('d M Y') }}
        </p>
    </div>

    <div class="p-6">
        <!-- Summary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <p class="text-xs font-semibold text-purple-600 mb-1">Total Transaksi</p>
                <h5 class="text-2xl font-bold text-purple-700">{{ number_format($laporanCustomer['summary']['total_transaksi']) }}</h5>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <p class="text-xs font-semibold text-green-600 mb-1">Total Pendapatan</p>
                <h5 class="text-lg font-bold text-green-700">Rp {{ number_format($laporanCustomer['summary']['total_pendapatan'], 0, ',', '.') }}</h5>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <p class="text-xs font-semibold text-blue-600 mb-1">Rata-rata per Transaksi</p>
                <h5 class="text-lg font-bold text-blue-700">Rp {{ number_format($laporanCustomer['summary']['rata_rata_per_transaksi'], 0, ',', '.') }}</h5>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Peak Hours -->
            <div class="border border-gray-200 rounded-lg p-6 bg-gradient-to-br from-blue-50 to-blue-100">
                <h6 class="font-bold text-blue-800 mb-4 flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    🕐 Peak Hours (Jam Tersibuk)
                </h6>
                
                <div class="space-y-3">
                    @foreach($laporanCustomer['peak_hours']->take(5) as $index => $hour)
                    <div class="bg-white rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold bg-gradient-to-tl from-blue-400 to-blue-600 text-white mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-semibold text-slate-800">{{ $hour['jam'] }}</span>
                            </div>
                            <span class="text-sm font-bold text-blue-600">{{ $hour['jumlah_transaksi'] }} transaksi</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-2 rounded-full" 
                                 style="width: {{ $laporanCustomer['summary']['total_transaksi'] > 0 ? ($hour['jumlah_transaksi'] / $laporanCustomer['summary']['total_transaksi'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Peak Days -->
            <div class="border border-gray-200 rounded-lg p-6 bg-gradient-to-br from-green-50 to-green-100">
                <h6 class="font-bold text-green-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    📅 Peak Days (Hari Tersibuk)
                </h6>
                
                <div class="space-y-3">
                    @foreach($laporanCustomer['peak_days']->take(5) as $index => $day)
                    <div class="bg-white rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-sm font-bold bg-gradient-to-tl from-green-400 to-green-600 text-white mr-3">
                                    {{ $index + 1 }}
                                </span>
                                <span class="font-semibold text-slate-800">{{ $day['hari'] }}</span>
                            </div>
                            <span class="text-sm font-bold text-green-600">{{ $day['jumlah_transaksi'] }} transaksi</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-400 to-green-600 h-2 rounded-full" 
                                 style="width: {{ $laporanCustomer['summary']['total_transaksi'] > 0 ? ($day['jumlah_transaksi'] / $laporanCustomer['summary']['total_transaksi'] * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Metode Pembayaran Favorit -->
        <div class="mt-6 border border-gray-200 rounded-lg p-6 bg-purple-50">
            <h6 class="font-bold text-purple-800 mb-4 flex items-center">
                <i class="fas fa-credit-card mr-2"></i>
                💳 Metode Pembayaran Favorit
            </h6>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @foreach($laporanCustomer['metode_pembayaran'] as $metode)
                <div class="bg-white rounded-lg p-4 border-2 border-purple-200 hover:border-purple-400 transition-colors">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-semibold text-slate-800 capitalize">{{ $metode['metode'] }}</span>
                        <span class="px-2 py-1 text-xs font-bold rounded bg-purple-100 text-purple-800">
                            {{ number_format($metode['persentase'], 1) }}%
                        </span>
                    </div>
                    <p class="text-sm text-slate-600 mb-2">
                        <span class="font-semibold text-purple-600">{{ $metode['jumlah_transaksi'] }}</span> transaksi
                    </p>
                    <p class="text-sm font-bold text-green-600">
                        Rp {{ number_format($metode['total_pendapatan'], 0, ',', '.') }}
                    </p>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                        <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-2 rounded-full" 
                             style="width: {{ $metode['persentase'] }}%">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Insights & Recommendations -->
        <div class="mt-6 p-6 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-200">
            <h6 class="font-bold text-slate-800 mb-4 flex items-center">
                <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                💡 Insights & Rekomendasi
            </h6>
            
            <div class="space-y-3">
                @if($laporanCustomer['peak_hours']->count() > 0)
                <div class="bg-white rounded-lg p-4 border-l-4 border-blue-500">
                    <p class="text-sm text-slate-700">
                        <span class="font-bold text-blue-600">Jam Tersibuk:</span> 
                        Pastikan kapster tersedia pada jam {{ $laporanCustomer['peak_hours']->first()['jam'] }} untuk melayani peak hours.
                    </p>
                </div>
                @endif
                
                @if($laporanCustomer['peak_days']->count() > 0)
                <div class="bg-white rounded-lg p-4 border-l-4 border-green-500">
                    <p class="text-sm text-slate-700">
                        <span class="font-bold text-green-600">Hari Tersibuk:</span> 
                        {{ $laporanCustomer['peak_days']->first()['hari'] }} adalah hari dengan transaksi tertinggi. Pertimbangkan promosi khusus di hari-hari sepi.
                    </p>
                </div>
                @endif
                
                <div class="bg-white rounded-lg p-4 border-l-4 border-purple-500">
                    <p class="text-sm text-slate-700">
                        <span class="font-bold text-purple-600">Rata-rata Spending:</span> 
                        Customer rata-rata menghabiskan Rp {{ number_format($laporanCustomer['summary']['rata_rata_per_transaksi'], 0, ',', '.') }} per kunjungan. 
                        Pertimbangkan paket bundling untuk meningkatkan nilai transaksi.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
