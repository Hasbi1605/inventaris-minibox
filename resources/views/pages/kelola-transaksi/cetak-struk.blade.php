<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Transaksi - {{ $transaksi->nomor_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .receipt-container {
            max-width: 300px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            margin: 2px 0;
        }

        .section {
            margin-bottom: 15px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 8px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            width: 40%;
        }

        .info-value {
            text-align: right;
            width: 60%;
        }

        .items-table {
            width: 100%;
            margin-bottom: 10px;
        }

        .items-table th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            font-weight: bold;
        }

        .items-table td {
            padding: 5px 0;
            border-bottom: 1px dashed #ccc;
        }

        .items-table .item-name {
            width: 60%;
        }

        .items-table .item-qty {
            width: 15%;
            text-align: center;
        }

        .items-table .item-price {
            width: 25%;
            text-align: right;
        }

        .total-section {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 10px 0;
            margin: 15px 0;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .grand-total {
            font-size: 16px;
            margin-top: 8px;
        }

        .payment-info {
            margin: 15px 0;
        }

        .footer {
            text-align: center;
            border-top: 2px dashed #000;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 10px;
        }

        .footer p {
            margin: 3px 0;
        }

        .print-button {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: gray;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 20px;
            font-family: Arial, sans-serif;
        }

        .print-button:hover {
            background-color: #2563eb;
        }

        @media print {
            body {
                padding: 0;
                background-color: white;
            }

            .receipt-container {
                box-shadow: none;
                max-width: 100%;
            }

            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            <h1>MINIBOX BARBERSHOP</h1>
            <p>{{ $transaksi->cabang->nama_cabang ?? 'Cabang' }}</p>
            <p>{{ $transaksi->cabang->alamat ?? 'Alamat Cabang' }}</p>
            <p>Telp: {{ $transaksi->cabang->telepon ?? '-' }}</p>
        </div>

        <!-- Transaction Info -->
        <div class="section">
            <div class="info-row">
                <span class="info-label">No. Transaksi</span>
                <span class="info-value">{{ $transaksi->nomor_transaksi }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal</span>
                <span class="info-value">{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Waktu</span>
                <span class="info-value">{{ $transaksi->waktu_mulai }} - {{ $transaksi->waktu_selesai }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Kapster</span>
                <span class="info-value">{{ $transaksi->kapster->nama_kapster ?? '-' }}</span>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="section">
            <div class="section-title">PELANGGAN</div>
            <div class="info-row">
                <span class="info-label">Nama</span>
                <span class="info-value">{{ $transaksi->nama_pelanggan }}</span>
            </div>
            @if($transaksi->telepon_pelanggan)
            <div class="info-row">
                <span class="info-label">Telepon</span>
                <span class="info-value">{{ $transaksi->telepon_pelanggan }}</span>
            </div>
            @endif
        </div>

        <!-- Items -->
        <div class="section">
            <div class="section-title">RINCIAN</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th class="item-name">Item</th>
                        <th class="item-qty">Qty</th>
                        <th class="item-price">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Layanan -->
                    <tr>
                        <td class="item-name">{{ $transaksi->layanan->nama_layanan ?? 'Layanan' }}</td>
                        <td class="item-qty">1</td>
                        <td class="item-price">{{ number_format($transaksi->total_harga - $transaksi->produk->sum('pivot.subtotal'), 0, ',', '.') }}</td>
                    </tr>
                    
                    <!-- Produk (if any) -->
                    @foreach($transaksi->produk as $produk)
                    <tr>
                        <td class="item-name">{{ $produk->nama_produk }}</td>
                        <td class="item-qty">{{ $produk->pivot->quantity }}</td>
                        <td class="item-price">{{ number_format($produk->pivot->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span>SUBTOTAL</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="info-row">
                <span class="info-label">Metode Bayar</span>
                <span class="info-value">{{ strtoupper(str_replace('_', ' ', $transaksi->metode_pembayaran)) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status</span>
                <span class="info-value">{{ strtoupper(str_replace('_', ' ', $transaksi->status)) }}</span>
            </div>
        </div>

        @if($transaksi->catatan)
        <!-- Notes -->
        <div class="section">
            <div class="section-title">CATATAN</div>
            <p style="font-size: 10px;">{{ $transaksi->catatan }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Struk ini adalah bukti pembayaran yang sah</p>
            <p>Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <!-- Print Button -->
    <button class="print-button" onclick="window.print()">
        🖨️ CETAK STRUK
    </button>

    <script>
        // Auto focus for better UX
        window.onload = function() {
            document.querySelector('.print-button').focus();
        }

        // Keyboard shortcut: Ctrl+P or Cmd+P
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                window.print();
            }
        });

        // Optional: Auto print on load (uncomment if needed)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
