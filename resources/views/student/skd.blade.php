<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Diterima - {{ $student->nama_lengkap }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; color: #000; margin: 0; padding: 2cm 2.5cm; background: #fff; }
        .header { text-align: center; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; position: relative; }
        .logo { position: absolute; left: 0; top: 0; width: 80px; height: 80px; }
        .header h1 { margin: 0; font-size: 16pt; text-transform: uppercase; }
        .header h2 { margin: 0; font-size: 14pt; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10pt; font-style: italic; }

        .letter-title { text-align: center; font-weight: bold; text-decoration: underline; text-transform: uppercase; margin-bottom: 5px; margin-top: 20px; }
        .letter-number { text-align: center; margin-bottom: 30px; font-size: 11pt; }

        .content { text-align: justify; }
        .content p { margin-bottom: 15px; }

        .data-table { margin: 20px 0 20px 40px; }
        .data-table td { padding: 3px 10px; vertical-align: top; }
        .label { width: 180px; }
        .colon { width: 10px; }

        .closing { margin-top: 30px; }

        .footer { margin-top: 50px; display: flex; justify-content: flex-end; }
        .signature { text-align: center; width: 250px; }
        .signature-date { margin-bottom: 10px; }
        .signature-role { font-weight: bold; margin-bottom: 70px; }
        .signature-name { font-weight: bold; text-decoration: underline; }

        .qr-code { position: absolute; left: 0; bottom: 0; width: 80px; height: 80px; border: 1px solid #eee; padding: 5px; }

        @media print {
            body { padding: 2cm 2.5cm; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo">
        <h1>MAJELIS PENDIDIKAN DASAR DAN MENENGAH</h1>
        <h2>SMP MUHAMMADIYAH KALIWIRO</h2>
        <p>Jl. Kauman No. 1, Kaliwiro, Wonosobo 56364 • Telp: (0286) 123456</p>
        <p>Email: smpmuhkaliwiro@gmail.com • Website: ppdb.smpmuhkaliwiro.sch.id</p>
    </div>

    <div class="letter-title">SURAT KETERANGAN DITERIMA</div>
    <div class="letter-number">Nomor: {{ date('Y') }}/PPDB/SKD/{{ str_pad($student->id, 4, '0', STR_PAD_LEFT) }}</div>

    <div class="content">
        <p>Kepala SMP Muhammadiyah Kaliwiro, dengan ini menerangkan bahwa berdasarkan hasil seleksi Penerimaan Peserta Didik Baru (PPDB) Tahun Pelajaran {{ date('Y') }}/{{ date('Y')+1 }}, calon siswa di bawah ini:</p>

        <table class="data-table">
            <tr>
                <td class="label">Nama Lengkap</td>
                <td class="colon">:</td>
                <td style="font-weight: bold; text-transform: uppercase;">{{ $student->nama_lengkap }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Registrasi</td>
                <td class="colon">:</td>
                <td>{{ $student->nomor_pendaftaran }}</td>
            </tr>
            <tr>
                <td class="label">Gelombang Pendaftaran</td>
                <td class="colon">:</td>
                <td>Gelombang {{ $student->gelombang ?? '1' }}</td>
            </tr>
            <tr>
                <td class="label">NISN</td>
                <td class="colon">:</td>
                <td>{{ $student->nisn }}</td>
            </tr>
            <tr>
                <td class="label">Asal Sekolah</td>
                <td class="colon">:</td>
                <td>{{ $student->asal_sekolah }}</td>
            </tr>
            <tr>
                <td class="label">Nama Orang Tua/Wali</td>
                <td class="colon">:</td>
                <td>{{ $student->nama_ayah }} / {{ $student->nama_ibu }}</td>
            </tr>
        </table>

        <p style="text-align: center; font-weight: bold; font-size: 14pt; margin: 30px 0;">DINYATAKAN: <span style="border: 2px solid #000; padding: 5px 20px;">LULUS / DITERIMA</span></p>

        <p>Sebagai peserta didik baru di SMP Muhammadiyah Kaliwiro. Selanjutnya, peserta didik yang bersangkutan diwajibkan untuk melakukan pendaftaran ulang dengan membawa dokumen persyaratan asli sesuai jadwal yang telah ditentukan.</p>

        <p>Demikian surat keterangan ini diberikan untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="footer">
        <div class="signature">
            <div class="signature-date">Kaliwiro, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</div>
            <div class="signature-role">Kepala Sekolah,</div>
            <div style="height: 60px;"></div>
            <div class="signature-name">TABAH S. PAMBUDI, M.I.Kom</div>
        </div>
    </div>

    <div style="position: relative; margin-top: 40px;">
        <div style="font-size: 8pt; color: #666;">
            * Dokumen ini diterbitkan secara elektronik melalui sistem PPDB Online SMP Muhammadiyah Kaliwiro.<br>
            * Keabsahan dokumen dapat dikonfirmasi melalui panitia PPDB.
        </div>
    </div>
</body>
</html>
