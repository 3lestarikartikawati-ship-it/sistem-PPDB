<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisi Formulir Pendaftaran - SMP Muhammadiyah Kaliwiro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-gradient-primary { background: linear-gradient(135deg, #0f172a 0%, #3b82f6 100%); }
        .text-highlight { color: #fbbf24; }
        .bg-highlight { background-color: #fbbf24; }
        .hover-highlight:hover { background-color: #f59e0b; }
        [x-cloak] { display: none !important; }
        .form-section-title {
            background-color: #334155;
            color: white;
            font-weight: bold;
            padding: 8px 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        .field-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
            display: block;
        }
        .form-input {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .form-input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased min-h-screen pb-12">

<div class="pt-8 pb-4" x-data="registrationForm()">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight uppercase">Majelis Pendidikan Dasar dan Menengah</h1>
            <h2 class="text-xl font-bold text-gray-800 tracking-tight uppercase">Pimpinan Daerah Muhammadiyah Wonosobo</h2>
            <h1 class="text-3xl font-bold text-blue-900 tracking-tight uppercase mt-2">SMP Muhammadiyah 05 Kaliwiro</h1>
            <p class="text-gray-600 font-medium text-sm mt-1">Jl. Raya Selomanik DS. Selomanik, Kec. Kaliwiro, Kab. Wonosobo 56364 Tlp. 081328675147</p>
        </div>

        <div class="bg-white shadow-lg border border-gray-200">
            
            <div class="bg-gray-800 text-white p-3 text-center text-sm italic font-bold">
                Mohon data di bawah ini dilengkapi dengan huruf kapital
            </div>
    <div class="px-6 pt-4 pb-0">
        <a href="{{ route('siswa.dashboard') }}" class="text-blue-600 hover:underline font-bold text-sm">&larr; Kembali ke Dashboard</a>
    </div>

            <div class="p-6 md:p-8">
            
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6">
                    <strong class="font-bold">Ada kesalahan!</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="registrationForm" action="{{ route('siswa.pendaftaran.update') }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
                @csrf

                <!-- A. DATA PRIBADI -->
                <div class="mb-8">
                    <div class="form-section-title">A. DATA PRIBADI CALON PESERTA DIDIK</div>
                    
                    <div class="grid grid-cols-12 gap-x-4 gap-y-3 items-center">
                        <div class="col-span-12 md:col-span-4"><label class="field-label">1. Nama Lengkap *</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="nama_lengkap" type="text" class="form-input uppercase" value="{{ old('nama_lengkap', $student->nama_lengkap ?? '') }}" required /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">2. NISN *</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="nisn" type="text" class="form-input" value="{{ old('nisn', $student->nisn ?? '') }}" pattern="\d{10}" minlength="10" maxlength="10" title="NISN harus berisi tepat 10 digit angka" required /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">3. NIK</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="nik" type="text" class="form-input" value="{{ old('nik', $student->nik ?? '') }}" pattern="\d{16}" minlength="16" maxlength="16" title="NIK harus berisi tepat 16 digit angka" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">4. Asal Sekolah *</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="asal_sekolah" type="text" class="form-input uppercase" value="{{ old('asal_sekolah', $student->asal_sekolah ?? '') }}" required /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">5. No. Ujian</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="no_ujian" type="text" class="form-input" value="{{ old('no_ujian', $student->no_ujian ?? '') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">6. No. SKHU</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="no_skhu" type="text" class="form-input" value="{{ old('no_skhu', $student->no_skhu ?? '') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">7. No. Ijazah</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="no_ijazah" type="text" class="form-input" value="{{ old('no_ijazah', $student->no_ijazah ?? '') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">8. Jenis Kelamin *</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-4">
                            <label><input type="radio" name="jenis_kelamin" value="L" {{ old('jenis_kelamin', $student->jenis_kelamin ?? '') == 'L' ? 'checked' : '' }} required> Laki-laki</label>
                            <label><input type="radio" name="jenis_kelamin" value="P" {{ old('jenis_kelamin', $student->jenis_kelamin ?? '') == 'P' ? 'checked' : '' }} required> Perempuan</label>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">9. Tempat, Tanggal Lahir *</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-2">
                            <input name="tempat_lahir" type="text" class="form-input uppercase w-1/2" placeholder="Tempat" value="{{ old('tempat_lahir', $student->tempat_lahir ?? '') }}" required />
                            <input name="tanggal_lahir" type="date" class="form-input w-1/2" value="{{ old('tanggal_lahir', $student->tanggal_lahir ?? '') }}" required />
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">10. Agama *</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="agama" type="text" class="form-input uppercase" value="{{ old('agama', $student->agama ?? 'ISLAM') }}" required /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">11. Suku</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="suku" type="text" class="form-input uppercase" value="{{ old('suku', $student->suku ?? '') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">12. Status</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-4 flex-wrap">
                            <label><input type="radio" name="status_anak" value="Pelajar" {{ old('status_anak', $student->status_anak ?? '') == 'Pelajar' ? 'checked' : '' }}> Pelajar</label>
                            <label><input type="radio" name="status_anak" value="Person" {{ old('status_anak', $student->status_anak ?? '') == 'Person' ? 'checked' : '' }}> Person</label>
                            <label><input type="radio" name="status_anak" value="CKM" {{ old('status_anak', $student->status_anak ?? '') == 'CKM' ? 'checked' : '' }}> CKM</label>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">13. Kondisi</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-4 flex-wrap">
                            <label><input type="radio" name="kondisi_anak" value="Berkecukupan" {{ old('kondisi_anak', $student->kondisi_anak ?? '') == 'Berkecukupan' ? 'checked' : '' }}> Berkecukupan</label>
                            <label><input type="radio" name="kondisi_anak" value="Kurang Mampu" {{ old('kondisi_anak', $student->kondisi_anak ?? '') == 'Kurang Mampu' ? 'checked' : '' }}> Kurang Mampu</label>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">14. Keadaan Orang Tua</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-4 flex-wrap">
                            <label><input type="radio" name="keadaan_orang_tua" value="Lengkap" {{ old('keadaan_orang_tua', $student->keadaan_orang_tua ?? '') == 'Lengkap' ? 'checked' : '' }}> Lengkap</label>
                            <label><input type="radio" name="keadaan_orang_tua" value="Yatim" {{ old('keadaan_orang_tua', $student->keadaan_orang_tua ?? '') == 'Yatim' ? 'checked' : '' }}> Yatim</label>
                            <label><input type="radio" name="keadaan_orang_tua" value="Piatu" {{ old('keadaan_orang_tua', $student->keadaan_orang_tua ?? '') == 'Piatu' ? 'checked' : '' }}> Piatu</label>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">15. Status dalam Keluarga</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-4 flex-wrap">
                            <label><input type="radio" name="status_dalam_keluarga" value="Anak Kandung" {{ old('status_dalam_keluarga', $student->status_dalam_keluarga ?? '') == 'Anak Kandung' ? 'checked' : '' }}> Anak Kandung</label>
                            <label><input type="radio" name="status_dalam_keluarga" value="Anak Tiri" {{ old('status_dalam_keluarga', $student->status_dalam_keluarga ?? '') == 'Anak Tiri' ? 'checked' : '' }}> Anak Tiri</label>
                            <label><input type="radio" name="status_dalam_keluarga" value="Anak Angkat" {{ old('status_dalam_keluarga', $student->status_dalam_keluarga ?? '') == 'Anak Angkat' ? 'checked' : '' }}> Anak Angkat</label>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">16. Tinggal Bersama</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-4 flex-wrap">
                            <label><input type="radio" name="tinggal_bersama" value="Orang tua" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '') == 'Orang tua' ? 'checked' : '' }}> Orang tua</label>
                            <label><input type="radio" name="tinggal_bersama" value="Kakek/Nenek" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '') == 'Kakek/Nenek' ? 'checked' : '' }}> Kakek/Nenek</label>
                            <label><input type="radio" name="tinggal_bersama" value="Paman/bibi" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '') == 'Paman/bibi' ? 'checked' : '' }}> Paman/bibi</label>
                            <label><input type="radio" name="tinggal_bersama" value="Saudara Kandung" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '') == 'Saudara Kandung' ? 'checked' : '' }}> Saudara Kandung</label>
                            <label><input type="radio" name="tinggal_bersama" value="Kerabat" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '') == 'Kerabat' ? 'checked' : '' }}> Kerabat</label>
                            <label><input type="radio" name="tinggal_bersama" value="Panti/Pontren" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '') == 'Panti/Pontren' ? 'checked' : '' }}> Panti/Pontren</label>
                            <label><input type="radio" name="tinggal_bersama" value="Lainnya" {{ old('tinggal_bersama', $student->tinggal_bersama ?? '') == 'Lainnya' ? 'checked' : '' }}> Lainnya</label>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">17. Kewarganegaraan</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="kewarganegaraan" type="text" class="form-input uppercase" value="{{ old('kewarganegaraan', $student->kewarganegaraan ?? 'WNI') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">18. Anak ke-</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-2 items-center text-sm">
                            <input name="anak_ke" type="number" class="form-input w-20" value="{{ old('anak_ke', $student->anak_ke ?? '') }}" />
                            <span>dari</span>
                            <input name="dari_bersaudara" type="number" class="form-input w-20" value="{{ old('dari_bersaudara', $student->dari_bersaudara ?? '') }}" />
                            <span>bersaudara</span>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">19. Bahasa sehari-hari</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="bahasa_sehari_hari" type="text" class="form-input uppercase" value="{{ old('bahasa_sehari_hari', $student->bahasa_sehari_hari ?? 'INDONESIA') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">20. Alamat *</label></div>
                        <div class="col-span-12 md:col-span-8">
                            <div class="grid grid-cols-12 gap-2">
                                <div class="col-span-12 flex gap-2 items-center">
                                    <span class="text-sm mt-1 w-16">Jalan:</span>
                                    <input name="jalan" type="text" class="form-input uppercase flex-1" value="{{ old('jalan', $student->jalan ?? '') }}" />
                                </div>
                                <div class="col-span-6 flex gap-2 items-center">
                                    <span class="text-sm mt-1 w-16">RT:</span>
                                    <input name="rt" type="text" class="form-input" value="{{ old('rt', $student->rt ?? '') }}" />
                                </div>
                                <div class="col-span-6 flex gap-2 items-center">
                                    <span class="text-sm mt-1 w-12">RW:</span>
                                    <input name="rw" type="text" class="form-input" value="{{ old('rw', $student->rw ?? '') }}" />
                                </div>
                                <div class="col-span-12 flex gap-2 items-center">
                                    <span class="text-sm mt-1 w-16">Desa/Kel:</span>
                                    <input name="desa_kelurahan" type="text" class="form-input uppercase flex-1" value="{{ old('desa_kelurahan', $student->desa_kelurahan ?? '') }}" />
                                </div>
                                <div class="col-span-12 flex gap-2 items-center">
                                    <span class="text-sm mt-1 w-16">Kec:</span>
                                    <input name="kecamatan" type="text" class="form-input uppercase flex-1" value="{{ old('kecamatan', $student->kecamatan ?? '') }}" />
                                </div>
                                <div class="col-span-12 flex gap-2 items-center">
                                    <span class="text-sm mt-1 w-16">Kab:</span>
                                    <input name="kabupaten" type="text" class="form-input uppercase flex-1" value="{{ old('kabupaten', $student->kabupaten ?? '') }}" />
                                </div>
                                <div class="col-span-12 flex gap-2 items-center">
                                    <span class="text-sm mt-1 w-16">Prop:</span>
                                    <input name="provinsi" type="text" class="form-input uppercase flex-1" value="{{ old('provinsi', $student->provinsi ?? 'JAWA TENGAH') }}" />
                                </div>
                                <div class="col-span-12 flex gap-2 items-center">
                                    <span class="text-sm mt-1 w-16 shrink-0">Kode Pos:</span>
                                    <input name="kode_pos" type="text" class="form-input w-24" value="{{ old('kode_pos', $student->kode_pos ?? '') }}" />
                                </div>
                                <input type="hidden" name="alamat" value="Alamat Detail" /> <!-- Legacy fallback -->
                            </div>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">21. Email</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="email_siswa" type="email" class="form-input" value="{{ old('email_siswa', $student->email_siswa ?? '') }}" /></div>
                    </div>
                </div>

                <!-- B. DATA ORANG TUA -->
                <div class="mb-8">
                    <div class="form-section-title">B. DATA ORANG TUA</div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-2 py-2 border w-1/4">Keterangan</th>
                                    <th class="px-2 py-2 border text-center w-3/8">Ayah</th>
                                    <th class="px-2 py-2 border text-center w-3/8">Ibu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-2 py-2 border font-bold">1. Nama</td>
                                    <td class="px-2 py-1 border"><input name="nama_ayah" type="text" class="form-input uppercase" value="{{ old('nama_ayah', $student->nama_ayah ?? '') }}" /></td>
                                    <td class="px-2 py-1 border"><input name="nama_ibu" type="text" class="form-input uppercase" value="{{ old('nama_ibu', $student->nama_ibu ?? '') }}" /></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 border font-bold">2. Pendidikan</td>
                                    <td class="px-2 py-1 border"><input name="pendidikan_ayah" type="text" class="form-input uppercase" value="{{ old('pendidikan_ayah', $student->pendidikan_ayah ?? '') }}" /></td>
                                    <td class="px-2 py-1 border"><input name="pendidikan_ibu" type="text" class="form-input uppercase" value="{{ old('pendidikan_ibu', $student->pendidikan_ibu ?? '') }}" /></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 border font-bold">3. Pekerjaan</td>
                                    <td class="px-2 py-1 border" colspan="2"><input name="pekerjaan_orang_tua" type="text" class="form-input uppercase" value="{{ old('pekerjaan_orang_tua', $student->pekerjaan_orang_tua ?? '') }}" placeholder="Pekerjaan Ayah / Ibu" required/></td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-2 border font-bold">4. Penghasilan</td>
                                    <td class="px-2 py-1 border"><input name="penghasilan_ayah" type="text" class="form-input" value="{{ old('penghasilan_ayah', $student->penghasilan_ayah ?? '') }}" /></td>
                                    <td class="px-2 py-1 border"><input name="penghasilan_ibu" type="text" class="form-input" value="{{ old('penghasilan_ibu', $student->penghasilan_ibu ?? '') }}" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="grid grid-cols-12 gap-x-4 gap-y-3 items-center mt-4">
                        <div class="col-span-12 md:col-span-4"><label class="field-label">5. Email Orang Tua</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="email_orang_tua" type="email" class="form-input" value="{{ old('email_orang_tua', $student->email_orang_tua ?? '') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">6. Nama Wali</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="nama_wali" type="text" class="form-input uppercase" value="{{ old('nama_wali', $student->nama_wali ?? '') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">7. Alamat Orang Tua / Wali</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="alamat_wali" type="text" class="form-input uppercase" value="{{ old('alamat_wali', $student->alamat_wali ?? '') }}" /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">8. Telepon/HP Orang Tua *</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="no_hp_orang_tua" type="text" class="form-input" value="{{ old('no_hp_orang_tua', $student->no_hp_orang_tua ?? '') }}" required /></div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">9. Alamat Penghubung Orang Tua</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-2">
                            <input name="alamat_penghubung_orang_tua" type="text" class="form-input uppercase w-full" value="{{ old('alamat_penghubung_orang_tua', $student->alamat_penghubung_orang_tua ?? '') }}" placeholder="Kelmpk, Daerah, Desa" />
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">10. Alamat Penghubung Penanggung Jawab</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-2">
                            <input name="alamat_penghubung_wali" type="text" class="form-input uppercase w-full" value="{{ old('alamat_penghubung_wali', $student->alamat_penghubung_wali ?? '') }}" placeholder="Kelmpk, Daerah, Desa" />
                        </div>
                    </div>
                </div>

                <!-- C. RIWAYAT KESEHATAN -->
                <div class="mb-8">
                    <div class="form-section-title">C. RIWAYAT KESEHATAN CALON PESERTA DIDIK</div>
                    <div class="grid grid-cols-12 gap-x-4 gap-y-3 items-center">
                        <div class="col-span-12 md:col-span-4"><label class="field-label">1. Golongan Darah</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-4 flex-wrap">
                            <label><input type="radio" name="golongan_darah" value="A" {{ old('golongan_darah', $student->golongan_darah ?? '') == 'A' ? 'checked' : '' }}> A</label>
                            <label><input type="radio" name="golongan_darah" value="B" {{ old('golongan_darah', $student->golongan_darah ?? '') == 'B' ? 'checked' : '' }}> B</label>
                            <label><input type="radio" name="golongan_darah" value="AB" {{ old('golongan_darah', $student->golongan_darah ?? '') == 'AB' ? 'checked' : '' }}> AB</label>
                            <label><input type="radio" name="golongan_darah" value="O" {{ old('golongan_darah', $student->golongan_darah ?? '') == 'O' ? 'checked' : '' }}> O</label>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">2. Berat dan Tinggi Badan</label></div>
                        <div class="col-span-12 md:col-span-8 flex gap-4 items-center">
                            <span>BB:</span> <input name="berat_badan" type="text" class="form-input w-16" value="{{ old('berat_badan', $student->berat_badan ?? '') }}" /> <span>kg</span>
                            <span class="ml-4">TB:</span> <input name="tinggi_badan" type="text" class="form-input w-16" value="{{ old('tinggi_badan', $student->tinggi_badan ?? '') }}" /> <span>cm</span>
                        </div>

                        <div class="col-span-12 md:col-span-4"><label class="field-label">3. Riwayat Penyakit</label></div>
                        <div class="col-span-12 md:col-span-8"><input name="riwayat_penyakit" type="text" class="form-input uppercase" value="{{ old('riwayat_penyakit', $student->riwayat_penyakit ?? '') }}" /></div>
                    </div>
                </div>

                <!-- JALUR DAN BERKAS (Legacy Requirement) -->
                <div class="mb-8 border-t-2 border-gray-300 pt-6">
                    <div class="form-section-title bg-gray-500">D. JALUR PENDAFTARAN & BERKAS WAJIB</div>
                    <div class="grid grid-cols-12 gap-x-4 gap-y-4">
                        <div class="col-span-12 md:col-span-6">
                            <label class="field-label">Jalur Pendaftaran *</label>
                            <select name="jalur_pendaftaran" x-model="jalur" class="form-input" required>
                                <option value="Reguler">Reguler</option>
                                <option value="Prestasi">Prestasi</option>
                                <option value="Afirmasi">Afirmasi / Beasiswa</option>
                            </select>
                        </div>

                        <div class="col-span-12 md:col-span-6" x-show="jalur === 'Reguler' || jalur === 'Prestasi'">
                            <label class="field-label">Rata-rata Nilai Rapor</label>
                            <input name="nilai_rapor" type="number" step="0.01" class="form-input" value="{{ old('nilai_rapor', $student->nilai_rapor ?? '') }}" />
                        </div>

                        <div class="col-span-12" x-show="jalur === 'Prestasi'">
                            <label class="field-label">Prestasi Non-Akademik</label>
                            <input name="prestasi" type="text" class="form-input uppercase mb-2" value="{{ old('prestasi', $student->prestasi ?? '') }}" />
                            <label class="field-label text-xs">Upload Piagam/Sertifikat Prestasi</label>
                            <input type="file" name="bukti_prestasi" class="text-xs w-full max-w-xs mt-1" accept=".pdf,image/*">
                        </div>

                        <div class="col-span-12" x-show="jalur === 'Afirmasi'">
                            <label class="field-label">Nomor KIP / SKTM</label>
                            <input name="nomor_kip" type="text" class="form-input uppercase mb-2" value="{{ old('nomor_kip', $student->nomor_kip ?? '') }}" />
                            <label class="field-label text-xs">Upload Bukti KIP/SKTM</label>
                            <input type="file" name="bukti_beasiswa" class="text-xs w-full max-w-xs mt-1" accept=".pdf,image/*">
                        </div>

                        <!-- Uploads -->
                        <div class="col-span-12 mt-4">
                            <label class="field-label text-xs">Pas Foto 3x4 *</label>
                            <input type="file" name="pas_foto" class="text-xs w-full max-w-xs mt-1" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="flex items-start gap-2">
                        <input type="checkbox" name="setuju" class="mt-1" required>
                        <span class="text-sm font-bold">Saya menyatakan dengan sesungguhnya bahwa data yang saya isikan dalam formulir ini adalah benar.</span>
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded shadow-lg text-lg w-full md:w-auto">
                        SIMPAN & DAFTAR
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('registrationForm', () => ({
            jalur: '{{ old('jalur_pendaftaran', $student->jalur_pendaftaran ?? 'Reguler') }}',
        }))
    })
</script>
</body>
</html>
