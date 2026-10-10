<x-mail::message>
# Pendaftaran PPDB Berhasil

Halo **{{ $student->nama_lengkap }}**,

Terima kasih telah mendaftar di SMP Muhammadiyah Kaliwiro. Pendaftaran Anda telah kami terima dengan detail sebagai berikut:

- **Nomor Pendaftaran:** {{ $student->nomor_pendaftaran }}
- **Jalur Pendaftaran:** {{ strtoupper($student->jalur_pendaftaran) }}
- **Asal Sekolah:** {{ $student->asal_sekolah }}

<x-mail::button :url="route('login')">
Login ke Dashboard
</x-mail::button>

Silakan pantau dashboard Anda secara berkala untuk mengetahui informasi kelulusan dan tahapan selanjutnya.

Terima kasih,<br>
Panitia PPDB {{ config('app.name') }}
</x-mail::message>
