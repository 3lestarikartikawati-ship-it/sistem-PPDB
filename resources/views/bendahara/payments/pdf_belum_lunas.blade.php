<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa Belum Lunas</title>
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
            background-color: #c0392b;
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
        .sisa {
            color: #c0392b;
            font-weight: bold;
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
            background-color: #fff5f5;
        }
        .summary-box h4 {
            margin: 0 0 8px 0;
            font-size: 11px;
            color: #c0392b;
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
        <h2>Daftar Siswa Belum Lunas Pembayaran</h2>
        <p>Dicetak pada: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:30px;">No</th>
                <th style="width:35px;">Kelas</th>
                <th>NISN</th>
                <th class="text-left">Nama Siswa</th>
                <th>Target Total</th>
                <th>Total Terbayar</th>
                <th>Sisa Kekurangan</th>
                <th>Sisa Infak</th>
                <th>Sisa LKS</th>
                <th>Sisa Seragam</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTarget = 0;
                $grandPaid = 0;
                $grandSisa = 0;
            @endphp

            @foreach($students as $index => $s)
                @php
                    $infak = $s->studentPayments->where('type', 'infak')->sum('amount');
                    $lk = $s->studentPayments->where('type', 'lk')->sum('amount');
                    $seragam = $s->studentPayments->where('type', 'seragam')->sum('amount');
                    $total = $infak + $lk + $seragam;
                    $target = $s->total_target;
                    $sisa = $target - $total;

                    $sisaInfak = $s->target_infak - $infak;
                    $sisaLk = $s->target_lk - $lk;
                    $sisaSeragam = $s->target_seragam - $seragam;

                    $grandTarget += $target;
                    $grandPaid += $total;
                    $grandSisa += $sisa;
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $s->kelas }}</td>
                    <td style="font-family: monospace;">{{ $s->nisn }}</td>
                    <td class="text-left">{{ $s->nama_lengkap }}</td>
                    <td class="text-right">Rp {{ number_format($target, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td class="text-right sisa">Rp {{ number_format($sisa, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $sisaInfak > 0 ? 'Rp ' . number_format($sisaInfak, 0, ',', '.') : '✓' }}</td>
                    <td class="text-right">{{ $sisaLk > 0 ? 'Rp ' . number_format($sisaLk, 0, ',', '.') : '✓' }}</td>
                    <td class="text-right">{{ $sisaSeragam > 0 ? 'Rp ' . number_format($sisaSeragam, 0, ',', '.') : '✓' }}</td>
                </tr>
            @endforeach

            <tr class="footer-row">
                <td colspan="4" class="text-right" style="font-size: 10px;">TOTAL</td>
                <td class="text-right">Rp {{ number_format($grandTarget, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($grandPaid, 0, ',', '.') }}</td>
                <td class="text-right sisa" style="font-size: 11px;">Rp {{ number_format($grandSisa, 0, ',', '.') }}</td>
                <td colspan="3">{{ $students->count() }} Siswa</td>
            </tr>
        </tbody>
    </table>

    <div class="summary-box">
        <h4>Ringkasan Tunggakan</h4>
        <table>
            <tr><td>Jumlah Siswa Belum Lunas</td><td class="val">{{ $students->count() }} orang</td></tr>
            <tr><td>Total Piutang yang Harus Ditagih</td><td class="val" style="font-size: 12px; color: #c0392b;">Rp {{ number_format($grandSisa, 0, ',', '.') }}</td></tr>
        </table>
    </div>

    <div class="meta-info" style="margin-top: 30px;">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; text-align: left; width: 50%; vertical-align: top;">
                    <p>Data ini hanya menampilkan siswa yang belum menyelesaikan seluruh tagihan.</p>
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
