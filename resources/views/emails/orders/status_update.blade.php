<x-mail::message>
# Halo, {{ $order->nama_pembeli }}!

Kami ingin menginformasikan bahwa status pesanan Anda dengan nomor **#{{ $order->nomor_pesanan }}** telah diperbarui menjadi:

<x-mail::panel>
## {{ strtoupper($order->status) }}
</x-mail::panel>

### Detail Pesanan:
- **Total Pembayaran:** Rp {{ number_format($order->total, 0, ',', '.') }}
- **Metode Pembayaran:** {{ strtoupper(str_replace('_', ' ', $order->metode_pembayaran)) }}
- **Tanggal Pesanan:** {{ $order->created_at->format('d F Y') }}

Terima kasih telah mempercayakan kebutuhan tempe Anda kepada **Tempe 3 Puteri**. Anda dapat melihat riwayat pesanan Anda melalui tombol di bawah ini:

<x-mail::button :url="route('history.index')">
Lihat Riwayat Pesanan
</x-mail::button>

Jika ada pertanyaan, silakan hubungi kami.

Salam hangat,<br>
**{{ config('mail.from.name', 'Tempe 3 Puteri') }}**
</x-mail::message>
