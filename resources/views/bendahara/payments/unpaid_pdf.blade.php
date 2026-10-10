<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa Belum Lunas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            color: #444;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .bg-red { background-color: #fee2e2; color: #991b1b; }
        .bg-yellow { background-color: #fef3c7; color: #92400e; }
        .bg-gray { background-color: #f3f4f6; color: #374151; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Data Calon Siswa (Belum Lunas Pembayaran)</h2>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="15%">No Registrasi</th>
                <th width="25%">Nama Lengkap</th>
                <th width="20%">Asal Sekolah</th>
                <th width="10%">Jalur</th>
                <th width="12%">No HP</th>
                <th width="13%" class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $student->nomor_pendaftaran }}</td>
                <td>{{ $student->nama_lengkap }}</td>
                <td>{{ $student->asal_sekolah }}</td>
                <td>{{ $student->jalur_pendaftaran }}</td>
                <td>{{ $student->user->no_hp ?? '-' }}</td>
                <td class="text-center">
                    @if(!$student->payment)
                        <span class="badge bg-gray">Belum Bayar</span>
                    @elseif($student->payment->status === 'menunggu')
                        <span class="badge bg-yellow">Menunggu</span>
                    @elseif($student->payment->status === 'ditolak')
                        <span class="badge bg-red">Ditolak</span>
                    @endif
                </td>
            </tr>
            @endforeach
            @if($students->isEmpty())
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data siswa yang belum lunas.</td>
            </tr>
            @endif
        </tbody>
    </table>

</body>
</html>
