<!DOCTYPE html>
<html>
<head>
    <title>Data Pendaftar PPDB</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #333;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Data Calon Pendaftar PPDB</h2>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%" class="text-center">No</th>
                <th width="12%">No Registrasi</th>
                <th width="10%">NISN</th>
                <th width="20%">Nama Lengkap</th>
                <th width="5%">L/P</th>
                <th width="20%">Asal Sekolah</th>
                <th width="10%">Jalur</th>
                <th width="10%">No HP</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $student->nomor_pendaftaran }}</td>
                <td>{{ $student->nisn }}</td>
                <td>{{ $student->nama_lengkap }}</td>
                <td class="text-center">{{ $student->jenis_kelamin }}</td>
                <td>{{ $student->asal_sekolah }}</td>
                <td>{{ $student->jalur_pendaftaran }}</td>
                <td>{{ $student->user->no_hp ?? '-' }}</td>
                <td>
                    {{ strtoupper($student->status) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
