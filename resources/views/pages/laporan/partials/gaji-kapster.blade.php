<!-- Laporan Gaji & Komisi Kapster -->
<div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
    <div class="p-6 pb-0 mb-0 bg-white border-b border-gray-100 rounded-t-2xl">
        <div class="flex items-center justify-between mb-2">
            <div>
                <h6 class="mb-0 font-bold text-slate-800">💰 Laporan Gaji & Komisi Kapster</h6>
                <p class="text-sm leading-normal text-slate-500 mb-0 mt-1">
                    Periode: {{ $laporanGaji['periode']['bulan_nama'] }}
                </p>
            </div>
            <div class="flex space-x-2">
                <button onclick="exportAllSlipGaji()" class="inline-block px-4 py-2 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft shadow-soft-md hover:scale-102">
                    <i class="fas fa-file-pdf mr-1"></i>Export Semua Slip
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="p-6 pt-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <p class="text-xs font-semibold text-blue-600 mb-1">Total Kapster</p>
                <h5 class="text-2xl font-bold text-blue-700">{{ $laporanGaji['summary']['total_kapster'] }}</h5>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <p class="text-xs font-semibold text-green-600 mb-1">Total Transaksi</p>
                <h5 class="text-2xl font-bold text-green-700">{{ number_format($laporanGaji['summary']['total_transaksi']) }}</h5>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200">
                <p class="text-xs font-semibold text-purple-600 mb-1">Total Komisi</p>
                <h5 class="text-xl font-bold text-purple-700">Rp {{ number_format($laporanGaji['summary']['total_gaji_komisi'], 0, ',', '.') }}</h5>
            </div>
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-4 border border-orange-200">
                <p class="text-xs font-semibold text-orange-600 mb-1">Total Gaji</p>
                <h5 class="text-xl font-bold text-orange-700">Rp {{ number_format($laporanGaji['summary']['total_gaji_keseluruhan'], 0, ',', '.') }}</h5>
            </div>
        </div>

        <!-- Tabel Gaji Kapster -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm align-middle">
                <thead class="align-bottom">
                    <tr class="border-b-2 border-gray-200">
                        <th class="pb-3 pl-2 pr-4 text-left font-bold text-slate-700">Kapster</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Cabang</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Total Transaksi</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Nilai Transaksi</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Komisi %</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Gaji Komisi</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Total Gaji</th>
                        <th class="pb-3 px-4 text-center font-bold text-slate-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporanGaji['data'] as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="py-4 pl-2 pr-4">
                            <div class="flex items-center">
                                <div class="inline-flex items-center justify-center w-10 h-10 rounded-full text-sm font-bold bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-3">
                                    {{ substr($item['nama_kapster'], 0, 2) }}
                                </div>
                                <div>
                                    <div class="font-semibold text-slate-800">{{ $item['nama_kapster'] }}</div>
                                    <div class="text-xs text-slate-500">{{ $item['spesialisasi'] ?? 'General' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                {{ $item['cabang'] }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-semibold text-slate-800">{{ $item['total_transaksi'] }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-semibold text-green-600">Rp {{ number_format($item['total_nilai_transaksi'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="px-2 py-1 text-xs font-bold rounded bg-purple-100 text-purple-800">
                                {{ number_format($item['komisi_persen'], 1) }}%
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-bold text-purple-600">Rp {{ number_format($item['gaji_komisi'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="font-bold text-orange-600 text-lg">Rp {{ number_format($item['total_gaji'], 0, ',', '.') }}</span>
                        </td>
                        <td class="py-4 px-4 text-center">
                            <button onclick="exportSlipGaji({{ $item['id'] }})" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg bg-gradient-to-tl from-red-500 to-orange-400 text-white hover:scale-105 transition-all">
                                <i class="fas fa-file-pdf mr-1"></i>
                                Slip Gaji
                            </button>
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
                    <tr class="bg-slate-50">
                        <td colspan="2" class="py-4 pl-2 pr-4 font-bold text-slate-800">
                            TOTAL KESELURUHAN
                        </td>
                        <td class="py-4 px-4 text-center font-bold text-slate-800">
                            {{ number_format($laporanGaji['summary']['total_transaksi']) }}
                        </td>
                        <td class="py-4 px-4 text-center font-bold text-green-600">
                            Rp {{ number_format($laporanGaji['summary']['total_nilai_transaksi'], 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-4 text-center">-</td>
                        <td class="py-4 px-4 text-center font-bold text-purple-600">
                            Rp {{ number_format($laporanGaji['summary']['total_gaji_komisi'], 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-4 text-center font-bold text-orange-600 text-lg">
                            Rp {{ number_format($laporanGaji['summary']['total_gaji_keseluruhan'], 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-4"></td>
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
    alert('Fitur export semua slip gaji akan segera ditambahkan');
}
</script>
