<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan - Tempe 3 Puteri</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1f2937;
            line-height: 1.5;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #2E5635;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #2E5635;
            margin: 0 0 5px 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header p {
            margin: 0;
            color: #6b7280;
            font-size: 11px;
        }

        .summary-box {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
        }

        .summary-row {
            margin-bottom: 8px;
            font-size: 13px;
        }

        .summary-row.total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #d1d5db;
            font-size: 16px;
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #2E5635;
            margin: 30px 0 10px 0;
            text-transform: uppercase;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background: #2E5635;
            color: white;
            text-align: left;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
        }

        td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
            color: #374151;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .income {
            color: #059669;
        }

        .expense {
            color: #dc2626;
        }

        .font-bold {
            font-weight: bold;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 9px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Tempe 3 Puteri</h1>
        <p>Laporan Laba Rugi Periodik</p>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{
            \Carbon\Carbon::parse($endDate)->format('d F Y') }}</p>
    </div>

    <div class="summary-box">
        <table style="width: 100%; border: none;">
            <tr style="background: transparent;">
                <td style="border: none; padding: 5px 0;">Total Pemasukan</td>
                <td style="border: none; padding: 5px 0;" class="text-right income font-bold">Rp {{
                    number_format($totalIncome, 0, ',', '.') }}</td>
            </tr>
            <tr style="background: transparent;">
                <td style="border: none; padding: 5px 0;">Total Pengeluaran</td>
                <td style="border: none; padding: 5px 0;" class="text-right expense font-bold">(Rp {{
                    number_format($totalExpense, 0, ',', '.') }})</td>
            </tr>
            <tr style="background: transparent;">
                <td
                    style="border: none; padding: 15px 0 0; border-top: 1px dashed #ccc; font-weight: bold; font-size: 14px;">
                    LABA BERSIH</td>
                <td style="border: none; padding: 15px 0 0; border-top: 1px dashed #ccc;"
                    class="text-right font-bold {{ $profit >= 0 ? 'income' : 'expense' }} behavior: font-size: 14px;">
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

    <div class="section-title">Log Transaksi (Kronologis)</div>
    <table>
        <thead>
            <tr>
                <th width="15%">Tanggal</th>
                <th width="15%">Tipe</th>
                <th>Keterangan</th>
                <th width="20%" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php
            $allRecords = $income->concat($expenses)->sortBy('tanggal');
            @endphp
            @foreach($allRecords as $record)
            <tr>
                <td>{{ $record->tanggal->format('d/m/Y') }}</td>
                <td>{{ ucfirst($record->tipe) }}</td>
                <td>
                    {{ $record->kategori ? $record->kategori . ' - ' : '' }}
                    {{ $record->deskripsi }}
                </td>
                <td class="text-right {{ $record->tipe === 'pemasukan' ? 'income' : 'expense' }}">
                    Rp {{ number_format($record->jumlah, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak otomatis pada: {{ now()->format('d/m/Y H:i:s') }} oleh Sistem ERP Tempe 3 Puteri
    </div>
</body>

</html>