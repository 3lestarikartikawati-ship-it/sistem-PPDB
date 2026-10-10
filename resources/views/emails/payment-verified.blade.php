<x-mail::message>
# Notifikasi Pembayaran Daftar Ulang PPDB

Halo **{{ $payment->student->nama_lengkap }}**,

Status pembayaran daftar ulang Anda baru saja diperbarui oleh Panitia/Bendahara PPDB.

- **Nominal:** Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}
- **Tanggal Pembayaran:** {{ $payment->tanggal_bayar->format('d M Y') }}
- **Status Pembayaran:** **{{ strtoupper($payment->status) }}**

@if($payment->status === 'ditolak' && $payment->catatan)
<x-mail::panel>
**Catatan Panitia:**
{{ $payment->catatan }}
</x-mail::panel>

Harap segera memperbaiki dan mengunggah ulang bukti pembayaran di dashboard Anda.
@endif

@if($payment->status === 'lunas')
Pembayaran Anda telah kami verifikasi dan dinyatakan **LUNAS**. Anda dapat mengunduh dan mencetak kuitansi resmi melalui dashboard.
@endif

<x-mail::button :url="route('login')">
Cek Status Pembayaran
</x-mail::button>

Terima kasih,<br>
Panitia PPDB {{ config('app.name') }}
</x-mail::message>
