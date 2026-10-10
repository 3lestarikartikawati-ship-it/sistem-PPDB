<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Pendaftaran - {{ $student->nama_lengkap }}</title>
    <style>
        @page { size: A4; margin: 0; }
        body { font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 13px; line-height: 1.6; color: #1e293b; margin: 0; padding: 40px; background: #f8fafc; }
        .page { width: 210mm; min-height: 297mm; padding: 20px; margin: auto; background: white; position: relative; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        
        .header { display: flex; align-items: center; border-bottom: 4px double #0f172a; padding-bottom: 20px; margin-bottom: 30px; }
        .logo { width: 80px; height: 80px; margin-right: 25px; }
        .header-text { flex: 1; text-align: center; }
        .header-text h1 { margin: 0; font-size: 20px; color: #0f172a; font-weight: 800; letter-spacing: 1px; }
        .header-text h2 { margin: 5px 0; font-size: 18px; color: #1e40af; font-weight: 700; }
        .header-text p { margin: 2px 0; font-size: 11px; color: #64748b; }

        .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 120px; color: rgba(15, 23, 42, 0.03); font-weight: 900; z-index: 0; pointer-events: none; }

        .main-title { text-align: center; font-size: 16px; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 30px; letter-spacing: 2px; }

        .content-grid { display: flex; gap: 40px; z-index: 10; position: relative; }
        .left-col { width: 140px; }
        .right-col { flex: 1; }

        .photo-container { width: 130px; height: 170px; border: 4px solid #f1f5f9; border-radius: 12px; overflow: hidden; background: #f8fafc; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .photo-container img { width: 100%; height: 100%; object-fit: cover; }
        .photo-placeholder { height: 100%; display: flex; align-items: center; justify-content: center; color: #cbd5e1; font-weight: 700; text-align: center; font-size: 10px; }

        .reg-number-badge { background: #eff6ff; border: 1px solid #bfdbfe; padding: 10px 20px; border-radius: 8px; margin-bottom: 25px; display: inline-block; }
        .reg-number-badge label { display: block; font-size: 10px; font-weight: 800; color: #3b82f6; text-transform: uppercase; margin-bottom: 2px; }
        .reg-number-badge span { font-family: monospace; font-size: 18px; font-weight: 900; color: #1e3a8a; }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { padding: 8px 0; border-bottom: 1px solid #f1f5f9; vertical-align: top; }
        .label { width: 160px; font-weight: 700; color: #64748b; font-size: 11px; text-transform: uppercase; }
        .value { font-weight: 600; color: #0f172a; }

        .footer { margin-top: 60px; display: flex; justify-content: space-between; align-items: flex-end; }
        .instruction-box { width: 350px; background: #fffbeb; border: 1px solid #fef3c7; padding: 15px; border-radius: 12px; }
        .instruction-box h4 { margin: 0 0 5px; font-size: 11px; color: #92400e; font-weight: 800; text-transform: uppercase; }
        .instruction-box ul { margin: 0; padding-left: 15px; font-size: 10px; color: #b45309; }

        .signature { text-align: center; width: 200px; }
        .signature-date { font-size: 12px; margin-bottom: 10px; }
        .signature-role { font-weight: 700; margin-bottom: 60px; }
        .signature-name { font-weight: 800; text-decoration: underline; }

        @media print {
            body { background: white; padding: 0; }
            .page { box-shadow: none; width: 100%; padding: 40px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page">
        <div class="watermark">PPDB {{ date('Y') }}</div>
        
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo">
            <div class="header-text">
                <p>PANITIA PENERIMAAN PESERTA DIDIK BARU</p>
                <h1>SMP MUHAMMADIYAH KALIWIRO</h1>
                <p>Akreditasi B • Jl. Kauman No. 1, Kaliwiro, Wonosobo 56364</p>
                <p>Email: smpmuhkaliwiro@gmail.com • Website: ppdb.smpmuhkaliwiro.sch.id</p>
            </div>
        </div>

        <div class="main-title">Kartu Bukti Pendaftaran Online</div>

        <div class="content-grid">
            <div class="left-col">
                <div class="photo-container">
                    @if($student->pas_foto)
                        <img src="{{ route('secure.file', $student->pas_foto) }}" alt="Foto">
                    @else
                        <div class="photo-placeholder">PAS FOTO<br>3 X 4</div>
                    @endif
                </div>
                
                <div style="text-align: center; margin-top: 10px;">
                    <span style="font-size: 9px; font-weight: 800; padding: 4px 10px; border-radius: 4px; color: white; background: {{ in_array($student->status, ['aktif', 'lulus_pendaftaran', 'menunggu_daftar_ulang', 'revisi_daftar_ulang']) ? '#059669' : ($student->status == 'ditolak' ? '#dc2626' : '#d97706') }}">
                        {{ strtoupper($student->status) }}
                    </span>
                </div>
            </div>

            <div class="right-col">
                <div class="reg-number-badge">
                    <label>Nomor Registrasi</label>
                    <span>{{ $student->nomor_pendaftaran }}</span>
                </div>

                <table class="data-table">
                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td class="value">{{ $student->nama_lengkap }}</td>
                    </tr>
                    <tr>
                        <td class="label">NISN / NIK</td>
                        <td class="value">{{ $student->nisn }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tempat, Tgl Lahir</td>
                        <td class="value">{{ $student->tempat_lahir }}, {{ \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td class="value">{{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Asal Sekolah</td>
                        <td class="value">{{ $student->asal_sekolah }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama Orang Tua</td>
                        <td class="value">{{ $student->nama_ayah }} (Ayah) / {{ $student->nama_ibu }} (Ibu)</td>
                    </tr>
                    <tr>
                        <td class="label">Kontak Wali</td>
                        <td class="value">{{ $student->no_hp_orang_tua }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal Daftar</td>
                        <td class="value">{{ $student->created_at->translatedFormat('d F Y • H:i') }} WIB</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="footer">
            <div class="instruction-box">
                <h4>Instruksi Penting:</h4>
                <ul>
                    <li>Simpan kartu ini sebagai bukti sah pendaftaran online.</li>
                    <li>Bawalah fotokopi KK, Akta Kelahiran, dan Ijazah/SKL saat verifikasi.</li>
                    <li>Pantau terus pengumuman terbaru di dashboard pendaftar.</li>
                    <li>Gunakan Nomor Registrasi untuk pengecekan status seleksi.</li>
                </ul>
            </div>

            <div class="signature">
                <div class="signature-date">Kaliwiro, {{ date('d F Y') }}</div>
                <div class="signature-role">Panitia PPDB,</div>
                <div style="height: 60px;"></div>
                <div class="signature-name">( ____________________ )</div>
            </div>
        </div>

        <div style="margin-top: 30px; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #f1f5f9; padding-top: 10px;">
            Dicetak secara otomatis oleh Sistem Informasi PPDB SMP Muhammadiyah Kaliwiro pada {{ date('d/m/Y H:i:s') }}
        </div>
    </div>
</body>
</html>
