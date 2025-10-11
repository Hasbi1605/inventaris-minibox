<!-- Laporan Gaji & Komisi Kapster -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-board">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h6 class="mb-0 font-bold text-slate-800">
                    <i class="fas fa-hand-holding-usd text-blue-600 mr-2"></i>Laporan Gaji & Komisi Kapster
                </h6>
                <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
                    Periode: {{ $laporanGaji['periode']['bulan_nama'] }}
                </p>
            </div>
            <div class="flex space-x-2">
                <button onclick="exportAllSlipGaji()" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md hover:scale-102">
                    <i class="fas fa-file-pdf mr-1"></i>Export Semua Slip
                </button>
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
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Kapster</p>
                            <h5 class="mb-0 font-bold text-slate-700">{{ $laporanGaji['summary']['total_kapster'] }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-users text-lg text-white"></i>
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
                            <h5 class="mb-0 font-bold text-slate-700">{{ number_format($laporanGaji['summary']['total_transaksi']) }}</h5>
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
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Komisi</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanGaji['summary']['total_gaji_komisi'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-percentage text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border border border-gray-100">
                <div class="flex-auto p-4">
                    <div class="flex flex-row items-center justify-between">
                        <div class="flex-1">
                            <p class="mb-0 font-sans text-xs font-semibold leading-normal text-slate-500">Total Gaji</p>
                            <h5 class="mb-0 font-bold text-slate-700">Rp {{ number_format($laporanGaji['summary']['total_gaji_keseluruhan'], 0, ',', '.') }}</h5>
                        </div>
                        <div class="text-right ml-4">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center shadow-soft-md">
                                <i class="fas fa-money-bill-wave text-lg text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Gaji Kapster -->
        <div class="overflow-x-auto">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
                <thead class="align-bottom">
                    <tr>
                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Kapster</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Cabang</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total Transaksi</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Komisi Potong Rambut</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Komisi Layanan Lain</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Komisi Produk</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total Gaji</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanGaji['data'] as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex px-2 py-1">
                                <div class="flex-shrink-0">
                                    <div class="inline-flex items-center justify-center w-10 h-10 rounded-lg text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                        {{ substr($item['nama_kapster'], 0, 2) }}
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h6 class="mb-0 leading-normal text-sm font-semibold text-slate-700">{{ $item['nama_kapster'] }}</h6>
                                    <p class="mb-0 leading-tight text-xs text-slate-400">{{ $item['spesialisasi'] ?? 'General' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">
                                {{ $item['cabang'] }}
                            </span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-slate-400">{{ $item['total_transaksi'] }}</span>
                            <p class="mb-0 text-xs text-slate-300">Rp {{ number_format($item['total_nilai_transaksi'], 0, ',', '.') }}</p>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-black-600">Rp {{ number_format($item['komisi_layanan_potong_rambut'], 0, ',', '.') }}</span>
                            <p class="mb-0 text-xs text-slate-300">{{ $item['jumlah_transaksi_potong_rambut'] }}x ({{ number_format($item['persen_komisi_potong_rambut'], 0) }}%)</p>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-black-600">Rp {{ number_format($item['komisi_layanan_lain'], 0, ',', '.') }}</span>
                            <p class="mb-0 text-xs text-slate-300">{{ $item['jumlah_transaksi_layanan_lain'] }}x ({{ number_format($item['persen_komisi_layanan_lain'], 0) }}%)</p>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-semibold leading-tight text-black-600">Rp {{ number_format($item['komisi_produk'], 0, ',', '.') }}</span>
                            <p class="mb-0 text-xs text-slate-300">{{ $item['jumlah_produk_terjual'] }}x ({{ number_format($item['persen_komisi_produk'], 0) }}%)</p>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-sm font-bold leading-tight text-slate-700">Rp {{ number_format($item['total_gaji'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <div class="flex justify-center">
                                <button onclick="exportSlipGaji({{ $item['id'] }})" class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gradient-to-tl from-red-600 to-yellow-400 rounded-lg hover:scale-102 hover:shadow-soft-xs transition-all duration-200 shadow-soft-md" title="Export Slip Gaji">
                                    <i class="fas fa-file-pdf"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fas fa-users text-2xl text-gray-400"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Tidak ada data gaji untuk periode ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($laporanGaji['data']->count() > 0)
                <tfoot class="border-t-2 border-slate-200">
                    <tr class="bg-gray-50">
                        <td colspan="2" class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-700">TOTAL KESELURUHAN</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-slate-700">{{ number_format($laporanGaji['summary']['total_transaksi']) }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-black-600">Rp {{ number_format($laporanGaji['summary']['total_komisi_potong_rambut'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-black-600">Rp {{ number_format($laporanGaji['summary']['total_komisi_layanan_lain'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-xs font-bold leading-tight text-black-600">Rp {{ number_format($laporanGaji['summary']['total_komisi_produk'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                            <span class="text-sm font-bold leading-tight text-slate-700">Rp {{ number_format($laporanGaji['summary']['total_gaji_keseluruhan'], 0, ',', '.') }}</span>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<script>
function exportSlipGaji(kapsterId) {
    const bulan = document.getElementById('bulan').value;
    const tahun = document.getElementById('tahun').value;
    window.location.href = `/laporan/slip-gaji/${kapsterId}?bulan=${bulan}&tahun=${tahun}`;
}

function exportAllSlipGaji() {
    const bulan = document.getElementById('bulan').value;
    const tahun = document.getElementById('tahun').value;
    const cabangId = document.getElementById('cabang_id').value;
    
    let url = `/laporan/export-all-slip?bulan=${bulan}&tahun=${tahun}`;
    if (cabangId) {
        url += `&cabang_id=${cabangId}`;
    }
    
    // Show loading indicator
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Memproses...';
    
    // Trigger download
    window.location.href = url;
    
    // Reset button after 3 seconds
    setTimeout(() => {
        button.disabled = false;
        button.innerHTML = originalText;
    }, 3000);
}
</script>
