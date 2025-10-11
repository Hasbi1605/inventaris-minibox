<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $kapster['nama_kapster'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            color: #666;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .info-label {
            width: 150px;
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            flex: 1;
            color: #333;
        }
        
        .summary-box {
            background-color: #f8fafc;
            border: 2px solid #2563eb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 8px 0;
        }
        
        .summary-row:not(:last-child) {
            border-bottom: 1px dashed #cbd5e1;
        }
        
        .summary-label {
            font-weight: bold;
            color: #555;
        }
        
        .summary-value {
            font-weight: bold;
            color: #2563eb;
        }
        
        .summary-total {
            background-color: #2563eb;
            color: white;
            margin: -15px -15px -15px -15px;
            margin-top: 15px;
            padding: 15px;
            border-radius: 0 0 6px 6px;
        }
        
        .summary-total .summary-label,
        .summary-total .summary-value {
            color: white;
            font-size: 16px;
        }
        
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .transaction-table th {
            background-color: #2563eb;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        .transaction-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11px;
        }
        
        .transaction-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
            margin: 25px 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #2563eb;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #cbd5e1;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        
        .signature-box {
            width: 45%;
            text-align: center;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>SLIP GAJI & KOMISI</h1>
        <p>Minibox Barbershop - Periode {{ $periode }}</p>
    </div>

    <!-- Info Kapster -->
    <div class="info-section">
        <div class="info-row">
            <div class="info-label">Nama Kapster:</div>
            <div class="info-value">{{ $kapster['nama_kapster'] }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Cabang:</div>
            <div class="info-value">{{ $kapster['cabang'] }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Periode:</div>
            <div class="info-value">{{ $periode }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Tanggal Cetak:</div>
            <div class="info-value">{{ now()->format('d F Y') }}</div>
        </div>
    </div>

    <!-- Summary Box -->
    <div class="summary-box">
        <div class="summary-row">
            <div class="summary-label">Total Transaksi</div>
            <div class="summary-value">{{ number_format($kapster['total_transaksi']) }} transaksi</div>
        </div>
        <div class="summary-row">
            <div class="summary-label">Nilai Transaksi</div>
            <div class="summary-value">Rp {{ number_format($kapster['total_nilai_transaksi'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-row" style="border-top: 2px solid #cbd5e1; margin-top: 10px; padding-top: 10px;">
            <div class="summary-label" style="color: #16a34a;">Komisi Potong Rambut ({{ number_format($kapster['persen_komisi_potong_rambut'], 0) }}%)</div>
            <div class="summary-value" style="color: #16a34a;">Rp {{ number_format($kapster['komisi_layanan_potong_rambut'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label" style="color: #ea580c;">Komisi Layanan Lain ({{ number_format($kapster['persen_komisi_layanan_lain'], 0) }}%)</div>
            <div class="summary-value" style="color: #ea580c;">Rp {{ number_format($kapster['komisi_layanan_lain'], 0, ',', '.') }}</div>
        </div>
        <div class="summary-row">
            <div class="summary-label" style="color: #9333ea;">Komisi Produk ({{ number_format($kapster['persen_komisi_produk'], 0) }}%)</div>
            <div class="summary-value" style="color: #9333ea;">Rp {{ number_format($kapster['komisi_produk'], 0, ',', '.') }}</div>
        </div>
        
        <div class="summary-total">
            <div class="summary-row" style="margin-bottom: 0; padding: 0; border: none;">
                <div class="summary-label">TOTAL GAJI</div>
                <div class="summary-value">Rp {{ number_format($kapster['total_gaji'], 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Detail Transaksi -->
    @if(isset($transaksi) && $transaksi->count() > 0)
    
    <!-- Detail Layanan -->
    <div class="section-title">Detail Layanan</div>
    <table class="transaction-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 25%;">Layanan</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 18%;">Customer</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 15%; text-align: right;">Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($transaksi as $trx)
                @if($trx->layanan)
                @php
                    // Hitung harga layanan dari total_harga dikurangi harga produk
                    $hargaLayanan = $trx->total_harga;
                    
                    // Kurangi harga produk jika ada
                    if($trx->produk && $trx->produk->count() > 0) {
                        $totalProduk = 0;
                        foreach($trx->produk as $prod) {
                            $totalProduk += $prod->pivot->subtotal;
                        }
                        $hargaLayanan = $trx->total_harga - $totalProduk;
                    }
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d/m/Y') }}</td>
                    <td>{{ $trx->layanan->nama_layanan }}</td>
                    <td>{{ $trx->layanan->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $trx->nama_customer ?? 'Walk-in' }}</td>
                    <td>
                        @if($trx->status == 'selesai')
                            Selesai
                        @elseif($trx->status == 'sedang_proses')
                            Proses
                        @else
                            {{ ucfirst($trx->status) }}
                        @endif
                    </td>
                    <td style="text-align: right;">Rp {{ number_format($hargaLayanan, 0, ',', '.') }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <!-- Detail Produk -->
    @php 
        $hasProduk = false;
        foreach($transaksi as $trx) {
            if($trx->produk && $trx->produk->count() > 0) {
                $hasProduk = true;
                break;
            }
        }
    @endphp
    
    @if($hasProduk)
    <div class="section-title" style="margin-top: 30px;">Detail Produk yang Terjual</div>
    <table class="transaction-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 30%;">Produk</th>
                <th style="width: 10%;">Qty</th>
                <th style="width: 15%;">Harga Satuan</th>
                <th style="width: 18%;">Customer</th>
                <th style="width: 10%; text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $noProduk = 1; @endphp
            @foreach($transaksi as $trx)
                @if($trx->produk && $trx->produk->count() > 0)
                    @foreach($trx->produk as $produk)
                    <tr>
                        <td>{{ $noProduk++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('d/m/Y') }}</td>
                        <td>{{ $produk->nama_barang }}</td>
                        <td>{{ $produk->pivot->quantity }}</td>
                        <td>Rp {{ number_format($produk->pivot->harga_satuan, 0, ',', '.') }}</td>
                        <td>{{ $trx->nama_customer ?? 'Walk-in' }}</td>
                        <td style="text-align: right;">Rp {{ number_format($produk->pivot->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
    @endif
    
    @endif

    <!-- Signature Section -->
    <div class="signature-section">
        <div class="signature-box">
            <p><strong>Kapster</strong></p>
            <div class="signature-line">
                {{ $kapster['nama_kapster'] }}
            </div>
        </div>
        <div class="signature-box">
            <p><strong>Pemilik/Manager</strong></p>
            <div class="signature-line">
                (&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem Minibox Barbershop</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>
</body>
</html>
