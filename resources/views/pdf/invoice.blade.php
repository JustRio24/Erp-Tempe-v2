<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->nomor_pesanan }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        .header { display: flex; justify-content: space-between; margin-bottom: 20px; border-bottom: 2px solid #2E5635; padding-bottom: 10px; }
        .company-info h2 { color: #2E5635; margin: 0; }
        .order-info { margin-bottom: 20px; }
        .details-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .details-table th { background: #f9fafb; border-bottom: 2px solid #eee; padding: 10px; text-align: left; }
        .details-table td { border-bottom: 1px solid #eee; padding: 10px; }
        .total-section { margin-top: 30px; text-align: right; }
        .total-amount { font-size: 1.25rem; font-weight: bold; color: #2E5635; }
        .footer { margin-top: 50px; text-align: center; color: #777; font-size: 0.8rem; }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table width="100%">
            <tr>
                <td style="vertical-align: top;">
                    <h2 style="color: #2E5635; margin: 0;">Tempe 3 Puteri</h2>
                    <p style="font-size: 0.8rem; margin: 5px 0;">Sumatera Selatan, Indonesia<br>bussiness@tempe3puteri.com</p>
                </td>
                <td style="text-align: right; vertical-align: top;">
                    <h1 style="margin: 0; color: #777;">INVOICE</h1>
                    <p style="margin: 5px 0;">No: {{ $order->nomor_pesanan }}<br>Tanggal: {{ $order->created_at->format('d/m/Y') }}</p>
                </td>
            </tr>
        </table>

        <div style="margin-top: 30px;">
            <table width="100%">
                <tr>
                    <td width="50%" style="vertical-align: top;">
                        <strong>Ditagihkan Kepada:</strong><br>
                        {{ $order->nama_pembeli }}<br>
                        {{ $order->telepon_pembeli }}<br>
                        {{ $order->alamat_pembeli }}
                    </td>
                    <td width="50%" style="text-align: right; vertical-align: top;">
                        <strong>Metode Pembayaran:</strong><br>
                        {{ strtoupper(str_replace('_', ' ', $order->metode_pembayaran)) }}<br>
                        Status: {{ strtoupper($order->status) }}
                    </td>
                </tr>
            </table>
        </div>

        <table class="details-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th style="text-align: center;">Jumlah</th>
                    <th style="text-align: right;">Harga Satuan</th>
                    <th style="text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->nama }}</td>
                    <td style="text-align: center;">{{ $item->jumlah }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                    <td style="text-align: right;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <table width="100%">
                <tr>
                    <td width="70%" style="text-align: right; padding: 5px;">Subtotal:</td>
                    <td style="text-align: right; padding: 5px;">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="text-align: right; padding: 5px;">Ongkos Kirim:</td>
                    <td style="text-align: right; padding: 5px;">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td style="text-align: right; padding: 10px; border-top: 2px solid #eee;">TOTAL:</td>
                    <td style="text-align: right; padding: 10px; border-top: 2px solid #eee;" class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Terima kasih telah berbelanja di Tempe 3 Puteri.<br>Simpan invoice ini sebagai bukti pembelian yang sah.</p>
        </div>
    </div>
</body>
</html>
