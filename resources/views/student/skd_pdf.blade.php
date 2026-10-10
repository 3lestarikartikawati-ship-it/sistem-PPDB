<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Diterima - {{ $student->nama_lengkap }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #000;
            line-height: 1.5;
            padding: 30px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
            position: relative;
        }
        .header img.logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header p {
            margin: 3px 0;
            font-size: 13px;
        }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 5px;
        }
        .nomor-surat {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            margin-bottom: 20px;
            text-align: justify;
        }
        .biodata {
            margin-left: 40px;
            margin-bottom: 20px;
        }
        .biodata table {
            width: 100%;
        }
        .biodata td {
            padding: 4px 0;
            vertical-align: top;
        }
        .biodata td:first-child {
            width: 150px;
        }
        .biodata td:nth-child(2) {
            width: 20px;
        }
        .signature-box {
            float: right;
            width: 250px;
            text-align: left;
            margin-top: 40px;
            position: relative;
        }
        .signature-box p {
            margin: 0;
            line-height: 1.2;
        }
        .ttd-image {
            height: 100px;
            margin: 10px 0;
            position: relative;
            z-index: 2;
        }
        .stempel-image {
            position: absolute;
            left: -50px;
            top: 20px;
            width: 120px;
            opacity: 0.8;
            z-index: 1;
        }
        .nama-kepsek {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="header">
        @if(public_path('images/logo.png') && file_exists(public_path('images/logo.png')))
            <img src="{{ public_path('images/logo.png') }}" class="logo" alt="Logo">
        @endif
        <h1>{{ $settings['sekolah_yayasan'] ?? 'MAJELIS PENDIDIKAN DASAR DAN MENENGAH' }}<br>{{ $settings['sekolah_nama'] ?? 'SMP MUHAMMADIYAH KALIWIRO' }}</h1>
        <p>{{ $settings['sekolah_status'] ?? 'Status Terakreditasi B • NPSN: 20306634' }}</p>
        <p>{{ $settings['sekolah_alamat'] ?? 'Jl. Raya Wadaslintang Km. 01, Kaliwiro, Wonosobo, Jawa Tengah 56364' }}</p>
        <p>{{ $settings['sekolah_email'] ?? 'Email: smpmuhkaliwiro@yahoo.co.id' }}</p>
    </div>

    <div class="title">SURAT KETERANGAN DITERIMA</div>
    <div class="nomor-surat">Nomor: 421.3/PPDB/{{ date('Y') }}/{{ str_pad($student->id, 3, '0', STR_PAD_LEFT) }}</div>

    <div class="content">
        Yang bertanda tangan di bawah ini, Kepala {{ ucwords(strtolower($settings['sekolah_nama'] ?? 'SMP Muhammadiyah Kaliwiro')) }}, Kabupaten Wonosobo, dengan ini menerangkan bahwa:
    </div>

    <div class="biodata">
        <table>
            <tr>
                <td>Nomor Pendaftaran</td>
                <td>:</td>
                <td><strong>{{ $student->nomor_pendaftaran }}</strong></td>
            </tr>
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ strtoupper($student->nama_lengkap) }}</strong></td>
            </tr>
            <tr>
                <td>NISN</td>
                <td>:</td>
                <td>{{ $student->nisn }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $student->tempat_lahir }}, {{ \Carbon\Carbon::parse($student->tanggal_lahir)->locale('id')->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td>Asal Sekolah</td>
                <td>:</td>
                <td>{{ $student->asal_sekolah }}</td>
            </tr>
            <tr>
                <td>Jalur Pendaftaran</td>
                <td>:</td>
                <td>{{ $student->jalur_pendaftaran }}</td>
            </tr>
        </table>
    </div>

    <div class="content">
        Berdasarkan hasil seleksi Penerimaan Peserta Didik Baru (PPDB) {{ ucwords(strtolower($settings['sekolah_nama'] ?? 'SMP Muhammadiyah Kaliwiro')) }} Tahun Ajaran {{ date('Y') }}/{{ date('Y')+1 }}, maka siswa tersebut di atas dinyatakan <strong>DITERIMA</strong> sebagai calon peserta didik baru kelas VII (Tujuh).
        <br><br>
        Demikian Surat Keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya untuk proses Daftar Ulang dan Administrasi sekolah selanjutnya.
    </div>

    <div class="signature-box">
        <p>Kaliwiro, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}<br>Kepala Sekolah,</p>
        
        <!-- Stempel (if exists) -->
        @if(!empty($settings['sekolah_stempel']) && file_exists(public_path('storage/' . $settings['sekolah_stempel'])))
            <img src="{{ public_path('storage/' . $settings['sekolah_stempel']) }}" class="stempel-image" alt="Stempel">
        @endif

        <!-- Tanda Tangan (if exists) -->
        @if(!empty($settings['kepsek_ttd']) && file_exists(public_path('storage/' . $settings['kepsek_ttd'])))
            <img src="{{ public_path('storage/' . $settings['kepsek_ttd']) }}" class="ttd-image" alt="Tanda Tangan">
        @else
            <div style="height: 80px;"></div> <!-- Spacer jika tidak ada TTD -->
        @endif

        <p class="nama-kepsek">{{ $settings['kepsek_nama'] ?? 'Drs. M. FULAN, M.Pd.' }}</p>
        <p>{{ $settings['kepsek_nip'] ?? 'NBM. 1234567' }}</p>
    </div>

</body>
</html>
