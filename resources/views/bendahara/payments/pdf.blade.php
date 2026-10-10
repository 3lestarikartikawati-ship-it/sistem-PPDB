<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Pembayaran Siswa</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #333;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 16px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .header h2 {
            font-size: 13px;
            margin: 5px 0 0;
            font-weight: normal;
        }
        .header p {
            font-size: 9px;
            color: #666;
            margin: 5px 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 8px;
            text-align: center;
        }
        th {
            background-color: #2c3e50;
            color: white;
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            font-size: 9px;
        }
        .text-left {
            text-align: left;
        }
        .text-right {
            text-align: right;
        }
        .lunas {
            background-color: #d4edda;
            color: #155724;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
        }
        .belum {
            background-color: #fff3cd;
            color: #856404;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
        }
        .footer-row td {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 10px;
        }
        .meta-info {
            font-size: 9px;
            color: #666;
            margin-top: 15px;
        }
        .summary-box {
            margin-top: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }
        .summary-box h4 {
            margin: 0 0 8px 0;
            font-size: 11px;
        }
        .summary-box table {
            width: auto;
            margin-top: 5px;
        }
        .summary-box td {
            border: none;
            text-align: left;
            padding: 3px 10px 3px 0;
            font-size: 10px;
        }
        .summary-box td.val {
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SMP Muhammadiyah Kaliwiro</h1>
        <h2>Laporan Rekapitulasi Pembayaran Siswa</h2>
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:30px;">No</th>
                <th style="width:35px;">Kelas</th>
                <th>NISN</th>
                <th class="text-left">Nama Siswa</th>
                <th>Target Infak</th>
                <th>Terbayar Infak</th>
                <th>Target LKS</th>
                <th>Terbayar LKS</th>
                <th>Target Seragam</th>
                <th>Terbayar Seragam</th>
                <th>Total Dibayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotalInfak = 0;
                $grandTotalLk = 0;
                $grandTotalSeragam = 0;
                $grandTotal = 0;
                $grandTarget = 0;
            @endphp

            @foreach($students as $index => $s)
                @php
                    $infak = $s->studentPayments->where('type', 'infak')->sum('amount');
                    $lk = $s->studentPayments->where('type', 'lk')->sum('amount');
                    $seragam = $s->studentPayments->where('type', 'seragam')->sum('amount');
                    $total = $infak + $lk + $seragam;
                    $target = $s->total_target;

                    $grandTotalInfak += $infak;
                    $grandTotalLk += $lk;
                    $grandTotalSeragam += $seragam;
                    $grandTotal += $total;
                    $grandTarget += $target;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->kelas }}</td>
                    <td style="font-family: monospace;">{{ $s->nisn }}</td>
                    <td class="text-left">{{ $s->nama_lengkap }}</td>
                    <td class="text-right">Rp {{ number_format($s->target_infak, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($infak, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($s->target_lk, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($lk, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($s->target_seragam, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($seragam, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: bold;">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td>
                        @if($total >= $target)
                            <span class="lunas">LUNAS</span>
                        @else
                            <span class="belum">BELUM</span>
                        @endif
                    </td>
                </tr>
            @endforeach

            <tr class="footer-row">
                <td colspan="4" class="text-right" style="font-size: 10px;">TOTAL KESELURUHAN</td>
                <td class="text-right">-</td>
                <td class="text-right">Rp {{ number_format($grandTotalInfak, 0, ',', '.') }}</td>
                <td class="text-right">-</td>
                <td class="text-right">Rp {{ number_format($grandTotalLk, 0, ',', '.') }}</td>
                <td class="text-right">-</td>
                <td class="text-right">Rp {{ number_format($grandTotalSeragam, 0, ',', '.') }}</td>
                <td class="text-right" style="font-size: 11px;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                <td>{{ $students->count() }} Siswa</td>
            </tr>
        </tbody>
    </table>

    <div class="summary-box">
        <h4>Ringkasan Keuangan</h4>
        <table>
            <tr><td>Total Pemasukan Infak</td><td class="val">Rp {{ number_format($grandTotalInfak, 0, ',', '.') }}</td></tr>
            <tr><td>Total Pemasukan LKS</td><td class="val">Rp {{ number_format($grandTotalLk, 0, ',', '.') }}</td></tr>
            <tr><td>Total Pemasukan Seragam</td><td class="val">Rp {{ number_format($grandTotalSeragam, 0, ',', '.') }}</td></tr>
            <tr style="border-top: 1px solid #999;"><td><strong>Grand Total Pemasukan</strong></td><td class="val" style="font-size: 12px;">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td></tr>
            <tr><td>Sisa Piutang (Belum Terbayar)</td><td class="val" style="color: #c0392b;">Rp {{ number_format($grandTarget - $grandTotal, 0, ',', '.') }}</td></tr>
        </table>
    </div>

    <div class="meta-info" style="margin-top: 30px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; text-align: left; width: 50%; vertical-align: top;">
                    <p>Jumlah Siswa: {{ $students->count() }} orang</p>
                </td>
                <td style="border: none; text-align: center; width: 50%; vertical-align: top;">
                    <p>Kaliwiro, {{ date('d F Y') }}</p>
                    <p>Bendahara</p>
                    <br><br><br>
                    <p>(_________________________)</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
