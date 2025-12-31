<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan - Tempe 3 Puteri</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.4; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #2D5F3F; padding-bottom: 10px; }
        .header h1 { color: #2D5F3F; margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; color: #666; }
        
        .summary-box { background: #f9fafb; border: 1px solid #ddd; padding: 15px; margin-bottom: 25px; border-radius: 8px; }
        .summary-title { font-weight: bold; font-size: 14px; margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 5px; }
        .summary-row { display: block; margin-bottom: 5px; }
        .summary-label { display: inline-block; width: 200px; }
        .summary-value { font-weight: bold; text-align: right; }
        
        .section-title { font-size: 16px; font-weight: bold; color: #2D5F3F; margin-top: 25px; margin-bottom: 10px; border-left: 4px solid #2D5F3F; padding-left: 10px; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #E8F5E9; color: #2D5F3F; text-align: left; padding: 10px; border: 1px solid #ddd; font-weight: bold; }
        td { padding: 8px 10px; border: 1px solid #ddd; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .income { color: #2E7D32; }
        .expense { color: #C62828; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TEMPE 3 PUTERI</h1>
        <p>Laporan Laba Rugi Periodik</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
    </div>

    <div class="summary-box">
        <div class="summary-title">Ringkasan Laporan</div>
        <table style="border: none; margin: 0;">
            <tr style="border: none;">
                <td style="border: none; padding: 2px 0;">Total Pemasukan (Omzet)</td>
                <td style="border: none; padding: 2px 0;" class="text-right income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none; padding: 2px 0;">Total Pengeluaran</td>
                <td style="border: none; padding: 2px 0;" class="text-right expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</td>
            </tr>
            <tr style="border: none; font-weight: bold; font-size: 14px;">
                <td style="border: none; padding: 10px 0 0;">Laba/Rugi Bersih</td>
                <td style="border: none; padding: 10px 0 0;" class="text-right {{ $profit >= 0 ? 'income' : 'expense' }}">
                    Rp {{ number_format($profit, 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Rincian Pengeluaran Per Kategori</div>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th class="text-right">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expensesByCategory as $category => $amount)
                <tr>
                    <td>{{ $category }}</td>
                    <td class="text-right expense">Rp {{ number_format($amount, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Rincian Transaksi Lengkap</div>
    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="15%">Tipe</th>
                <th>Deskripsi</th>
                <th width="20%" class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @php
                $allRecords = $income->concat($expenses)->sortBy('tanggal');
            @endphp
            @foreach($allRecords as $record)
                <tr>
                    <td class="text-center">{{ $record->tanggal->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <span class="{{ $record->tipe === 'pemasukan' ? 'income' : 'expense' }}">
                            {{ ucfirst($record->tipe) }}
                        </span>
                    </td>
                    <td>{{ $record->kategori ? $record->kategori . ' - ' : '' }}{{ $record->deskripsi }}</td>
                    <td class="text-right {{ $record->tipe === 'pemasukan' ? 'income' : 'expense' }}">
                        Rp {{ number_format($record->jumlah, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }} | Sistem ERP Tempe 3 Puteri
    </div>
</body>
</html>
