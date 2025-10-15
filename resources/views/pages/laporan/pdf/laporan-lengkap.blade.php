<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Lengkap - Minibox Barbershop</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            padding: 15px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 10px;
        }
        
        .header h1 {
            font-size: 20px;
            color: #2563eb;
            margin-bottom: 3px;
        }
        
        .header p {
            font-size: 10px;
            color: #666;
        }
        
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
            padding: 8px 10px;
            background-color: #f0f7ff;
            border-left: 4px solid #2563eb;
        }
        
        .stats-grid {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .stat-box {
            flex: 1;
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 10px;
            text-align: center;
        }
        
        .stat-label {
            font-size: 9px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .data-table th {
            background-color: #2563eb;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
        }
        
        .data-table td {
            padding: 6px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
        }
        
        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .data-table tfoot td {
            background-color: #f1f5f9;
            font-weight: bold;
            border-top: 2px solid #2563eb;
        }
        
        .text-right {
            text-align: right;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #cbd5e1;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN LENGKAP BARBERSHOP</h1>
        <p>Minibox Barbershop - Periode {{ $periode }}</p>
        <p style="margin-top: 3px;">Dicetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="section">
        <div class="section-title">Ringkasan Statistik</div>
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-label">Total Pendapatan</div>
                <div class="stat-value">Rp {{ number_format($statistics['total_pendapatan'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Pengeluaran</div>
                <div class="stat-value">Rp {{ number_format($statistics['total_pengeluaran'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Pendapatan Bersih</div>
                <div class="stat-value">Rp {{ number_format($statistics['pendapatan_bersih'], 0, ',', '.') }}</div>
            </div>
            <div class="stat-box">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ number_format($statistics['total_transaksi']) }}</div>
            </div>
        </div>
    </div>

    <!-- Laporan Gaji & Komisi Kapster -->
    @if(isset($laporanGaji) && $laporanGaji['data']->count() > 0)
    <div class="section">
        <div class="section-title">Laporan Gaji & Komisi Kapster</div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Kapster</th>
                    <th style="width: 20%;">Cabang</th>
                    <th style="width: 10%; text-align: center;">Transaksi</th>
                    <th style="width: 15%; text-align: right;">Nilai</th>
                    <th style="width: 10%; text-align: center;">Komisi</th>
                    <th style="width: 15%; text-align: right;">Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporanGaji['data'] as $index => $data)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $data['nama_kapster'] }}</td>
                    <td>{{ $data['cabang'] }}</td>
                    <td class="text-center">{{ number_format($data['total_transaksi']) }}</td>
                    <td class="text-right">Rp {{ number_format($data['total_nilai_transaksi'], 0, ',', '.') }}</td>
                    <td class="text-center">-</td>
                    <td class="text-right">Rp {{ number_format($data['total_gaji'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">TOTAL KESELURUHAN</td>
                    <td class="text-center">{{ number_format($laporanGaji['summary']['total_transaksi']) }}</td>
                    <td class="text-right">Rp {{ number_format($laporanGaji['summary']['total_nilai_transaksi'], 0, ',', '.') }}</td>
                    <td class="text-center">-</td>
                    <td class="text-right">Rp {{ number_format($laporanGaji['summary']['total_gaji_keseluruhan'], 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

    <!-- Page Break untuk laporan panjang -->
    <div class="page-break"></div>

    <!-- Laporan Per Cabang -->
    @if(isset($laporanCabang) && $laporanCabang['data']->count() > 0)
    <div class="section">
        <div class="section-title">Laporan Performa Per Cabang</div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 30%;">Nama Cabang</th>
                    <th style="width: 15%; text-align: center;">Transaksi</th>
                    <th style="width: 20%; text-align: right;">Pendapatan</th>
                    <th style="width: 15%; text-align: right;">Pengeluaran</th>
                    <th style="width: 15%; text-align: right;">Laba Bersih</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporanCabang['data'] as $index => $cabang)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $cabang['nama_cabang'] }}</td>
                    <td class="text-center">{{ number_format($cabang['jumlah_transaksi']) }}</td>
                    <td class="text-right">Rp {{ number_format($cabang['pendapatan'], 0, ',', '.') }}</td>
                    <td class="text-right">-</td>
                    <td class="text-right">Rp {{ number_format($cabang['laba'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-right">TOTAL</td>
                    <td class="text-center">{{ number_format($laporanCabang['summary']['total_transaksi']) }}</td>
                    <td class="text-right">Rp {{ number_format($laporanCabang['summary']['total_pendapatan'], 0, ',', '.') }}</td>
                    <td class="text-right">-</td>
                    <td class="text-right">Rp {{ number_format($laporanCabang['summary']['total_laba'], 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif

    <!-- Laporan Layanan -->
    @if(isset($laporanLayanan) && $laporanLayanan['data']->count() > 0)
    <div class="section">
        <div class="section-title">Laporan Layanan Terpopuler</div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 40%;">Nama Layanan</th>
                    <th style="width: 15%; text-align: center;">Jumlah</th>
                    <th style="width: 20%; text-align: right;">Total</th>
                    <th style="width: 20%; text-align: right;">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                @foreach($laporanLayanan['data']->take(10) as $index => $layanan)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $layanan['nama_layanan'] }}</td>
                    <td class="text-center">{{ number_format($layanan['jumlah_transaksi']) }}</td>
                    <td class="text-right">Rp {{ number_format($layanan['total_pendapatan'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($layanan['rata_rata_per_transaksi'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Page Break untuk laporan panjang -->
    <div class="page-break"></div>

    <!-- Laporan Pengeluaran Lengkap -->
    @if(isset($pengeluaranDetail) && $pengeluaranDetail->count() > 0)
    <div class="section">
        <div class="section-title">Rincian Pengeluaran Lengkap</div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 12%;">Tanggal</th>
                    <th style="width: 25%;">Nama Pengeluaran</th>
                    <th style="width: 20%;">Kategori</th>
                    <th style="width: 18%;">Cabang</th>
                    <th style="width: 20%; text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @php $totalPengeluaranDetail = 0; @endphp
                @foreach($pengeluaranDetail as $index => $pengeluaran)
                @php $totalPengeluaranDetail += $pengeluaran->jumlah; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($pengeluaran->tanggal_pengeluaran)->format('d/m/Y') }}</td>
                    <td>{{ $pengeluaran->nama_pengeluaran }}</td>
                    <td>{{ $pengeluaran->kategori->nama_kategori ?? 'Tidak ada kategori' }}</td>
                    <td>{{ $pengeluaran->cabang->nama_cabang ?? 'Tidak ada cabang' }}</td>
                    <td class="text-right">Rp {{ number_format($pengeluaran->jumlah, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right"><strong>TOTAL PENGELUARAN</strong></td>
                    <td class="text-right"><strong>Rp {{ number_format($totalPengeluaranDetail, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>
        
        <!-- Ringkasan Pengeluaran per Kategori -->
        @php
            $pengeluaranPerKategori = $pengeluaranDetail->groupBy(function($item) {
                return $item->kategori->nama_kategori ?? 'Tidak ada kategori';
            })->map(function($group) {
                return [
                    'nama_kategori' => $group->first()->kategori->nama_kategori ?? 'Tidak ada kategori',
                    'total' => $group->sum('jumlah'),
                    'count' => $group->count()
                ];
            })->sortByDesc('total');
        @endphp
        
        @if($pengeluaranPerKategori->count() > 0)
        <div class="section-title" style="margin-top: 25px;">Ringkasan Pengeluaran per Kategori</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 50%;">Kategori</th>
                    <th style="width: 15%; text-align: center;">Jumlah Item</th>
                    <th style="width: 30%; text-align: right;">Total Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                 @php $noKategori = 1; @endphp
                @foreach($pengeluaranPerKategori as $index => $kategori)
                <tr>
                    <td class="text-center">{{ $noKategori++ }}</td>
                    <td>{{ $kategori['nama_kategori'] }}</td>
                    <td class="text-center">{{ number_format($kategori['count']) }}</td>
                    <td class="text-right">Rp {{ number_format($kategori['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    @endif
    <!-- Footer -->
    <div class="footer">
        <p><strong>Minibox Barbershop Management System</strong></p>
        <p>Dokumen ini dicetak secara otomatis dan sah tanpa tanda tangan</p>
    </div>
</body>
</html>
