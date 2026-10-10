<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa Kelas {{ $kelas }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            color: #000;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 5px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            text-align: center;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .signature {
            float: right;
            width: 250px;
            text-align: center;
            margin-top: 20px;
        }
        .signature .name {
            margin-top: 60px;
            font-weight: bold;
            text-decoration: underline;
        }
        .signature .nip {
            margin-top: 2px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>{{ $settings['sekolah_yayasan'] ?? 'MAJELIS PENDIDIKAN DASAR DAN MENENGAH' }}<br>{{ $settings['sekolah_nama'] ?? 'SMP MUHAMMADIYAH KALIWIRO' }}</h1>
        <p>{{ $settings['sekolah_status'] ?? 'Status Terakreditasi B • NPSN: 20306634' }}</p>
        <p>{{ $settings['sekolah_alamat'] ?? 'Jl. Raya Wadaslintang Km. 01, Kaliwiro, Wonosobo, Jawa Tengah 56364' }}</p>
        <p>{{ $settings['sekolah_email'] ?? 'Email: smpmuhkaliwiro@yahoo.co.id' }}</p>
    </div>

    <div class="title">
        DAFTAR NAMA SISWA KELAS {{ $kelas }}<br>
        TAHUN AJARAN {{ date('Y') }}/{{ date('Y')+1 }}
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No.</th>
                <th>NISN</th>
                <th>Nama Lengkap</th>
                <th style="width: 40px;">L/P</th>
                <th>Asal Sekolah</th>
                <th>Jalur Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $s)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $s->nisn }}</td>
                <td>{{ strtoupper($s->nama_lengkap) }}</td>
                <td class="text-center">{{ $s->jenis_kelamin == 'Laki-laki' ? 'L' : 'P' }}</td>
                <td>{{ $s->asal_sekolah }}</td>
                <td class="text-center">{{ $s->jalur_pendaftaran }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <p>Kaliwiro, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}<br>Kepala Sekolah</p>
        <div class="name">{{ $settings['kepsek_nama'] ?? 'Drs. M. FULAN, M.Pd.' }}</div>
        <div class="nip">{{ $settings['kepsek_nip'] ?? 'NBM. 1234567' }}</div>
    </div>

</body>
</html>
