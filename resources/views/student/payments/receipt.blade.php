<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Daftar Ulang - {{ $student->nama_lengkap }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 20px;
            font-size: 14px;
            line-height: 1.4;
        }
        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .header {
            display: flex;
            align-items: center;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-logo {
            width: 80px;
            height: 80px;
            background-color: #1e3a8a;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: bold;
            font-size: 24px;
            margin-right: 20px;
        }
        .header-text {
            flex-grow: 1;
        }
        .header-text h1 {
            margin: 0 0 5px 0;
            font-size: 20px;
            color: #1e3a8a;
            font-weight: 800;
            letter-spacing: 0.5px;
        }
        .header-text p {
            margin: 0;
            font-size: 11px;
            color: #666;
        }
        .title {
            text-align: center;
            margin-bottom: 30px;
        }
        .title h2 {
            margin: 0 0 5px 0;
            font-size: 18px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .title p {
            margin: 0;
            font-family: monospace;
            font-size: 13px;
            color: #555;
        }
        .grid-info {
            display: grid;
            grid-template-cols: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-box td {
            padding: 4px 0;
            vertical-align: top;
        }
        .info-box td.label {
            width: 130px;
            color: #666;
            font-weight: bold;
        }
        .info-box td.value {
            font-weight: bold;
        }
        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-items th {
            background-color: #f3f4f6;
            border-top: 1px solid #d1d5db;
            border-bottom: 1px solid #d1d5db;
            padding: 10px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
        }
        .table-items td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        .table-items tr.total-row td {
            border-top: 2px solid #333;
            border-bottom: none;
            font-weight: 900;
            font-size: 15px;
        }
        .terbilang-box {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 30px;
            font-style: italic;
        }
        .terbilang-box span {
            font-weight: bold;
            color: #666;
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 5px;
            font-style: normal;
        }
        .footer-sig {
            display: flex;
            justify-content: space-between;
            margin-top: 50px;
        }
        .sig-box {
            text-align: center;
            width: 200px;
        }
        .sig-space {
            height: 70px;
        }
        .sig-name {
            font-weight: bold;
            text-decoration: underline;
        }
        .sig-role {
            font-size: 11px;
            color: #666;
        }
        .btn-print {
            background-color: #1e3a8a;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.2s;
        }
        .btn-print:hover {
            background-color: #1d4ed8;
        }
        
        @media print {
            .btn-print {
                display: none;
            }
            body {
                padding: 0;
            }
            .receipt-container {
                border: none;
                box-shadow: none;
                padding: 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    @php
    function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut(floor($nilai / 10)) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut(floor($nilai / 100)) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut(floor($nilai / 1000)) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut(floor($nilai / 1000000)) . " juta" . penyebut($nilai % 1000000);
        }
        return $temp;
    }

    function terbilang($nilai) {
        if($nilai < 0) {
            $hasil = "minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }     
        return ucwords($hasil) . " Rupiah";
    }
    @endphp

    <div style="max-width: 800px; margin: 0 auto; text-align: right;">
        <button onclick="window.print()" class="btn-print">
            <svg style="width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Cetak Kuitansi
        </button>
    </div>

    <div class="receipt-container">
        <!-- Header Kop Surat -->
        <div class="header">
            <div class="header-logo">
                SMPM
            </div>
            <div class="header-text">
                <h1>SMP MUHAMMADIYAH KALIWIRO</h1>
                <p>Status Terakreditasi B • NPSN: 20306634</p>
                <p>Alamat: Jl. Raya Wadaslintang Km. 01, Kaliwiro, Wonosobo, Jawa Tengah 56364</p>
                <p>Telp: (0286) 611234 • Email: smpmkaliwiro@gmail.com</p>
            </div>
        </div>

        <!-- Title -->
        <div class="title">
            <h2>Kuitansi Pembayaran Daftar Ulang</h2>
            <p>NOMOR: KWT/PPDB/{{ date('Y', strtotime($payment->verified_at)) }}/{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</p>
        </div>

        <!-- Info Grid -->
        <div class="grid-info">
            <div class="info-box">
                <table>
                    <tr>
                        <td class="label">No. Pendaftaran</td>
                        <td>:</td>
                        <td class="value">{{ $student->nomor_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td>:</td>
                        <td class="value">{{ $student->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="label">NISN</td>
                        <td>:</td>
                        <td class="value font-mono">{{ $student->nisn }}</td>
                    </tr>
                </table>
            </div>
            <div class="info-box">
                <table>
                    <tr>
                        <td class="label">Asal Sekolah</td>
                        <td>:</td>
                        <td class="value">{{ $student->asal_sekolah }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jalur Pendaftaran</td>
                        <td>:</td>
                        <td class="value">{{ $student->jalur_pendaftaran }}</td>
                    </tr>
                    <tr>
                        <td class="label">Gelombang</td>
                        <td>:</td>
                        <td class="value">Gelombang {{ $student->gelombang }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Cetak</td>
                        <td>:</td>
                        <td class="value">{{ date('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Table Items -->
        <table class="table-items">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Deskripsi Pembayaran</th>
                    <th style="width: 100px;">Metode</th>
                    <th style="width: 180px; text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentItems as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        @if($index === 0)
                        <div style="font-size: 11px; color: #666; margin-top: 4px;">Penerimaan peserta didik baru tahun ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</div>
                        @endif
                    </td>
                    <td style="text-transform: uppercase;">{{ $payment->metode_pembayaran }}</td>
                    <td style="text-align: right; font-weight: bold;">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">TOTAL PEMBAYARAN</td>
                    <td style="text-align: right; color: #1e3a8a;">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Terbilang Box -->
        <div class="terbilang-box">
            <span>Terbilang</span>
            "{{ terbilang($payment->jumlah_bayar) }}"
        </div>

        <!-- Footer Signatures -->
        <div class="footer-sig">
            <div class="sig-box">
                <p>Wali Murid / Pembayar</p>
                <div class="sig-space"></div>
                <p class="sig-name">{{ $student->nama_ayah ?? $student->nama_ibu ?? 'Wali Siswa' }}</p>
                <p class="sig-role">Orang Tua/Wali Calon Siswa</p>
            </div>
            <div class="sig-box">
                <p>Kaliwiro, {{ $payment->verified_at->format('d F Y') }}</p>
                <p>Penerima / Bendahara</p>
                <div class="sig-space"></div>
                <p class="sig-name">{{ $payment->verifiedBy->name ?? 'Panitia PPDB' }}</p>
                <p class="sig-role">Panitia Keuangan PPDB</p>
            </div>
        </div>
    </div>

</body>
</html>
