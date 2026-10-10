<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                    {{ __('Verifikasi Pendaftar') }}
                </h2>
                <div class="text-sm text-gray-500 font-medium mt-1">
                    {{ $student->nama_lengkap }} ({{ $student->nomor_pendaftaran }})
                </div>
            </div>
            <a href="{{ route('admin.students.index') }}" class="inline-flex items-center gap-2 bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-md active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen" x-data="{ 
        showPreview: false, 
        previewUrl: '', 
        previewTitle: '',
        isPdf: false,
        openPreview(url, title) {
            this.previewUrl = url;
            this.previewTitle = title;
            this.isPdf = url.toLowerCase().endsWith('.pdf');
            this.showPreview = true;
        }
    }">
        <style>
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background-color: #cbd5e1;
                border-radius: 10px;
            }
        </style>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid lg:grid-cols-3 gap-8 lg:items-start">
                
                <!-- Kolom Kiri: Biodata -->
                <div class="lg:col-span-2 space-y-8 lg:max-h-[calc(100vh-7rem)] lg:overflow-y-auto lg:pr-4 custom-scrollbar pb-10">
                    <!-- Card Biodata -->
                    <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                        <div class="bg-gradient-primary px-8 py-6 flex justify-between items-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                            <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                            
                            <h3 class="text-xl font-extrabold text-white flex items-center gap-3 relative z-10">
                                <div class="w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                Informasi Siswa
                            </h3>
                            @if($student->status == 'menunggu' || $student->status == 'revisi_pendaftaran')
                                <span class="bg-yellow-400 text-yellow-900 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm relative z-10">Tahap 1</span>
                            @elseif(in_array($student->status, ['lulus_pendaftaran', 'menunggu_daftar_ulang', 'revisi_daftar_ulang']))
                                <span class="bg-blue-400 text-blue-950 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm relative z-10">Tahap 2</span>
                            @elseif($student->status == 'aktif')
                                <span class="bg-emerald-400 text-emerald-950 px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm relative z-10">Aktif</span>
                            @else
                                <span class="bg-red-400 text-white px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest shadow-sm relative z-10">Ditolak/Cadangan</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No Registrasi</div><div class="font-medium text-gray-900">{{ $student->nomor_pendaftaran }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NISN</div><div class="font-medium text-gray-900">{{ $student->nisn }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</div><div class="font-medium text-gray-900">{{ $student->nama_lengkap }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jenis Kelamin</div><div class="font-medium text-gray-900">{{ $student->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</div><div class="font-medium text-gray-900">{{ $student->tempat_lahir }}, {{ \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d F Y') }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Agama</div><div class="font-medium text-gray-900">{{ $student->agama }}</div></div>
                                <div class="md:col-span-2"><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Lengkap</div><div class="font-medium text-gray-900">{{ $student->alamat }}</div></div>
                            </div>

                            <hr class="my-6 border-gray-100">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Asal Sekolah (SD/MI)</div><div class="font-medium text-gray-900">{{ $student->asal_sekolah }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jalur Pendaftaran</div><div class="font-medium text-gray-900 uppercase">{{ $student->jalur_pendaftaran }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nilai Rapor</div><div class="font-medium text-gray-900">{{ $student->nilai_rapor ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Prestasi</div><div class="font-medium text-gray-900">{{ $student->prestasi ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nomor KIP/SKTM</div><div class="font-medium text-gray-900">{{ $student->nomor_kip ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Orang Tua (Ayah / Ibu)</div><div class="font-medium text-gray-900">{{ $student->nama_ayah }} / {{ $student->nama_ibu }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pekerjaan Orang Tua</div><div class="font-medium text-gray-900">{{ $student->pekerjaan_orang_tua }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kontak / No HP</div><div class="font-medium text-gray-900">{{ $student->user->no_hp ?? '-' }} / {{ $student->no_hp_orang_tua }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Email Siswa / Orang Tua</div><div class="font-medium text-gray-900">{{ $student->email_siswa ?? '-' }} / {{ $student->email_orang_tua ?? '-' }}</div></div>
                            </div>
                            <hr class="my-6 border-gray-100">
                            
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Informasi Detail Pribadi & Keluarga</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-8">
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NIK</div><div class="font-medium text-gray-900">{{ $student->nik ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kewarganegaraan</div><div class="font-medium text-gray-900">{{ $student->kewarganegaraan ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Suku</div><div class="font-medium text-gray-900">{{ $student->suku ?? '-' }}</div></div>
                                
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">No Ujian / SKHU / Ijazah</div><div class="font-medium text-gray-900">{{ $student->no_ujian ?? '-' }} / {{ $student->no_skhu ?? '-' }} / {{ $student->no_ijazah ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Status Anak</div><div class="font-medium text-gray-900">{{ $student->status_anak ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Kondisi Anak</div><div class="font-medium text-gray-900">{{ $student->kondisi_anak ?? '-' }}</div></div>
                                
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Keadaan Orang Tua</div><div class="font-medium text-gray-900">{{ $student->keadaan_orang_tua ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Status Dlm Keluarga</div><div class="font-medium text-gray-900">{{ $student->status_dalam_keluarga ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tinggal Bersama</div><div class="font-medium text-gray-900">{{ $student->tinggal_bersama ?? '-' }}</div></div>
                                
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Anak Ke / Dari</div><div class="font-medium text-gray-900">{{ $student->anak_ke ?? '-' }} dari {{ $student->dari_bersaudara ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Bahasa Sehari-hari</div><div class="font-medium text-gray-900">{{ $student->bahasa_sehari_hari ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Golongan Darah</div><div class="font-medium text-gray-900">{{ $student->golongan_darah ?? '-' }}</div></div>
                                
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tinggi / Berat Badan</div><div class="font-medium text-gray-900">{{ $student->tinggi_badan ?? '-' }} cm / {{ $student->berat_badan ?? '-' }} kg</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Riwayat Penyakit</div><div class="font-medium text-gray-900">{{ $student->riwayat_penyakit ?? '-' }}</div></div>
                            </div>

                            <hr class="my-6 border-gray-100">
                            
                            <h4 class="text-lg font-bold text-gray-800 mb-4">Informasi Detail Orang Tua & Wali</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pendidikan Ayah / Ibu</div><div class="font-medium text-gray-900">{{ $student->pendidikan_ayah ?? '-' }} / {{ $student->pendidikan_ibu ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Penghasilan Ayah / Ibu</div><div class="font-medium text-gray-900">{{ $student->penghasilan_ayah ?? '-' }} / {{ $student->penghasilan_ibu ?? '-' }}</div></div>
                                
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Wali</div><div class="font-medium text-gray-900">{{ $student->nama_wali ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Wali</div><div class="font-medium text-gray-900">{{ $student->alamat_wali ?? '-' }}</div></div>
                                
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Penghubung Ortua</div><div class="font-medium text-gray-900">{{ $student->alamat_penghubung_orang_tua ?? '-' }}</div></div>
                                <div><div class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat Penghubung Wali</div><div class="font-medium text-gray-900">{{ $student->alamat_penghubung_wali ?? '-' }}</div></div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Berkas Pendaftaran Awal -->
                    <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                        <div class="bg-slate-700 px-8 py-6 flex items-center relative overflow-hidden">
                            <h3 class="text-xl font-extrabold text-white flex items-center gap-3 relative z-10">
                                Berkas Pendaftaran Awal (Tahap 1)
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Foto -->
                                <div class="border border-gray-200 rounded-xl p-5 text-center flex flex-col items-center justify-between group hover:border-blue-300 transition">
                                    <span class="block font-bold text-gray-800 mb-2">Pas Foto</span>
                                    @if($student->pas_foto)
                                        <button @click="openPreview('{{ route('secure.file', $student->pas_foto) }}', 'Pas Foto')" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center gap-1 mx-auto">Preview</button>
                                    @else
                                        <span class="text-red-500 font-medium text-sm">Belum Upload</span>
                                    @endif
                                </div>
                                <!-- Rapor -->
                                <div class="border border-gray-200 rounded-xl p-5 text-center flex flex-col items-center justify-between group hover:border-blue-300 transition">
                                    <span class="block font-bold text-gray-800 mb-2">Bukti Rapor</span>
                                    @if($student->bukti_rapor)
                                        <button @click="openPreview('{{ route('secure.file', $student->bukti_rapor) }}', 'Bukti Rapor')" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center gap-1 mx-auto">Preview</button>
                                    @else
                                        <span class="text-red-500 font-medium text-sm">Belum Upload</span>
                                    @endif
                                </div>
                                <!-- Prestasi -->
                                @if($student->jalur_pendaftaran == 'Prestasi')
                                <div class="border border-gray-200 rounded-xl p-5 text-center flex flex-col items-center justify-between group hover:border-blue-300 transition">
                                    <span class="block font-bold text-gray-800 mb-2">Bukti Prestasi</span>
                                    @if($student->bukti_prestasi)
                                        <button @click="openPreview('{{ route('secure.file', $student->bukti_prestasi) }}', 'Bukti Prestasi')" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center gap-1 mx-auto">Preview</button>
                                    @else
                                        <span class="text-red-500 font-medium text-sm">Belum Upload</span>
                                    @endif
                                </div>
                                @endif
                                <!-- Afirmasi -->
                                @if($student->jalur_pendaftaran == 'Afirmasi')
                                <div class="border border-gray-200 rounded-xl p-5 text-center flex flex-col items-center justify-between group hover:border-blue-300 transition">
                                    <span class="block font-bold text-gray-800 mb-2">Bukti Beasiswa/KIP</span>
                                    @if($student->bukti_beasiswa)
                                        <button @click="openPreview('{{ route('secure.file', $student->bukti_beasiswa) }}', 'Bukti Beasiswa/KIP')" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center gap-1 mx-auto">Preview</button>
                                    @else
                                        <span class="text-red-500 font-medium text-sm">Belum Upload</span>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Card Berkas Daftar Ulang -->
                    <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                        <div class="bg-blue-800 px-8 py-6 flex items-center relative overflow-hidden">
                            <h3 class="text-xl font-extrabold text-white flex items-center gap-3 relative z-10">
                                Berkas Daftar Ulang (Tahap 2)
                            </h3>
                        </div>
                        <div class="p-6">
                            @if(in_array($student->status, ['menunggu_daftar_ulang', 'revisi_daftar_ulang', 'aktif']))
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                <!-- Akte -->
                                <div class="border border-gray-200 rounded-xl p-5 text-center flex flex-col items-center justify-between group hover:border-blue-300 transition">
                                    <span class="block font-bold text-gray-800 mb-2">Akte Kelahiran</span>
                                    @if($student->daftar_ulang_akte)
                                        <button @click="openPreview('{{ route('secure.file', $student->daftar_ulang_akte) }}', 'Akte Kelahiran')" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center gap-1 mx-auto">Preview</button>
                                    @else
                                        <span class="text-red-500 font-medium text-sm">Belum Upload</span>
                                    @endif
                                </div>
                                <!-- KK -->
                                <div class="border border-gray-200 rounded-xl p-5 text-center flex flex-col items-center justify-between group hover:border-blue-300 transition">
                                    <span class="block font-bold text-gray-800 mb-2">Kartu Keluarga</span>
                                    @if($student->daftar_ulang_kk)
                                        <button @click="openPreview('{{ route('secure.file', $student->daftar_ulang_kk) }}', 'Kartu Keluarga')" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center gap-1 mx-auto">Preview</button>
                                    @else
                                        <span class="text-red-500 font-medium text-sm">Belum Upload</span>
                                    @endif
                                </div>
                                <!-- SKL -->
                                <div class="border border-gray-200 rounded-xl p-5 text-center flex flex-col items-center justify-between group hover:border-blue-300 transition">
                                    <span class="block font-bold text-gray-800 mb-2">Ijazah / SKL</span>
                                    @if($student->daftar_ulang_skl)
                                        <button @click="openPreview('{{ route('secure.file', $student->daftar_ulang_skl) }}', 'Ijazah / SKL')" class="text-blue-600 hover:text-blue-800 font-bold text-sm flex items-center gap-1 mx-auto">Preview</button>
                                    @else
                                        <span class="text-red-500 font-medium text-sm">Belum Upload</span>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="text-center py-10">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-bold">Siswa Belum Melakukan Daftar Ulang</p>
                                <p class="text-gray-400 text-sm mt-1">Berkas daftar ulang akan muncul setelah siswa lulus verifikasi Tahap 1 dan mengirimkan berkas daftar ulang.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Verifikasi -->
                <div class="lg:max-h-[calc(100vh-7rem)] lg:overflow-y-auto lg:pl-2 custom-scrollbar lg:sticky lg:top-24 pb-10">
                    <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100 mb-10">
                        <div class="bg-gradient-primary px-8 py-6 flex items-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                            <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                            
                            <h3 class="text-xl font-extrabold text-white flex items-center gap-3 relative z-10">
                                <div class="w-10 h-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                Proses Verifikasi
                            </h3>
                        </div>
                        <div class="p-6">
                            
                            <form action="{{ route('admin.students.verify', $student->id) }}" method="POST">
                                @csrf
                                
                                <div x-data="{ tab: '{{ in_array($student->status, ['lulus_pendaftaran', 'menunggu_daftar_ulang', 'revisi_daftar_ulang', 'aktif']) ? 'tahap2' : 'tahap1' }}' }">
                                    <!-- Tabs -->
                                    <div class="flex gap-2 mb-6 border-b pb-2">
                                        <button type="button" @click="tab = 'tahap1'" :class="tab == 'tahap1' ? 'bg-slate-700 text-white' : 'bg-gray-100 text-gray-600'" class="flex-1 py-2 rounded-lg font-bold text-xs transition">Tahap 1 (Pendaftaran)</button>
                                        <button type="button" @click="tab = 'tahap2'" :class="tab == 'tahap2' ? 'bg-blue-800 text-white' : 'bg-gray-100 text-gray-600'" class="flex-1 py-2 rounded-lg font-bold text-xs transition">Tahap 2 (Daftar Ulang)</button>
                                    </div>

                                    <!-- Tahap 1 -->
                                    <div x-show="tab == 'tahap1'">
                                        <div class="space-y-3 mb-6">
                                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-yellow-50 transition {{ $student->status == 'menunggu' ? 'bg-yellow-50 border-yellow-300 ring-1 ring-yellow-300' : '' }}">
                                                <input type="radio" name="status" value="menunggu" class="w-4 h-4 text-yellow-600" {{ $student->status == 'menunggu' ? 'checked' : '' }}>
                                                <span class="ml-3 font-medium text-yellow-800 text-sm">Menunggu (Belum Diverifikasi)</span>
                                            </label>
                                            
                                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-emerald-50 transition {{ $student->status == 'lulus_pendaftaran' ? 'bg-emerald-50 border-emerald-300 ring-1 ring-emerald-300' : '' }}">
                                                <input type="radio" name="status" value="lulus_pendaftaran" class="w-4 h-4 text-emerald-600" {{ $student->status == 'lulus_pendaftaran' ? 'checked' : '' }}>
                                                <span class="ml-3 font-medium text-emerald-800 text-sm">Lulus Pendaftaran</span>
                                            </label>

                                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-red-50 transition {{ $student->status == 'revisi_pendaftaran' ? 'bg-red-50 border-red-300 ring-1 ring-red-300' : '' }}">
                                                <input type="radio" name="status" value="revisi_pendaftaran" class="w-4 h-4 text-red-600" {{ $student->status == 'revisi_pendaftaran' ? 'checked' : '' }}>
                                                <span class="ml-3 font-medium text-red-800 text-sm">Revisi Berkas</span>
                                            </label>

                                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-blue-50 transition {{ $student->status == 'cadangan' ? 'bg-blue-50 border-blue-300 ring-1 ring-blue-300' : '' }}">
                                                <input type="radio" name="status" value="cadangan" class="w-4 h-4 text-blue-600" {{ $student->status == 'cadangan' ? 'checked' : '' }}>
                                                <span class="ml-3 font-medium text-blue-800 text-sm">Cadangan</span>
                                            </label>

                                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-red-50 transition {{ $student->status == 'ditolak' ? 'bg-red-50 border-red-300 ring-1 ring-red-300' : '' }}">
                                                <input type="radio" name="status" value="ditolak" class="w-4 h-4 text-red-600" {{ $student->status == 'ditolak' ? 'checked' : '' }}>
                                                <span class="ml-3 font-medium text-red-800 text-sm">Ditolak Permanen</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Tahap 2 -->
                                    <div x-show="tab == 'tahap2'" style="display: none;">
                                        <div class="space-y-3 mb-6">
                                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-yellow-50 transition {{ $student->status == 'menunggu_daftar_ulang' ? 'bg-yellow-50 border-yellow-300 ring-1 ring-yellow-300' : '' }}">
                                                <input type="radio" name="status" value="menunggu_daftar_ulang" class="w-4 h-4 text-yellow-600" {{ $student->status == 'menunggu_daftar_ulang' ? 'checked' : '' }}>
                                                <span class="ml-3 font-medium text-yellow-800 text-sm">Menunggu Daftar Ulang</span>
                                            </label>
                                            
                                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-emerald-50 transition {{ $student->status == 'aktif' ? 'bg-emerald-50 border-emerald-300 ring-1 ring-emerald-300' : '' }}">
                                                <input type="radio" name="status" value="aktif" class="w-4 h-4 text-emerald-600" {{ $student->status == 'aktif' ? 'checked' : '' }}>
                                                <span class="ml-3 font-medium text-emerald-800 text-sm">Siswa Aktif (Lulus Daftar Ulang)</span>
                                            </label>

                                            <label class="flex items-center p-3 border rounded-xl cursor-pointer hover:bg-red-50 transition {{ $student->status == 'revisi_daftar_ulang' ? 'bg-red-50 border-red-300 ring-1 ring-red-300' : '' }}">
                                                <input type="radio" name="status" value="revisi_daftar_ulang" class="w-4 h-4 text-red-600" {{ $student->status == 'revisi_daftar_ulang' ? 'checked' : '' }}>
                                                <span class="ml-3 font-medium text-red-800 text-sm">Revisi Berkas Daftar Ulang</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-6">
                                    <label for="catatan" class="block text-sm font-bold text-gray-700 mb-2">Catatan / Alasan Revisi:</label>
                                    <textarea id="catatan" name="catatan" rows="4" class="w-full border-gray-300 focus:border-blue-500 rounded-xl p-4 text-sm" placeholder="Contoh: Foto KK buram, mohon upload ulang.">{{ old('catatan', $student->catatan) }}</textarea>
                                </div>
                                
                                <button type="submit" class="w-full flex justify-center items-center gap-2 bg-highlight hover:bg-yellow-400 text-blue-900 font-black py-4 px-6 rounded-2xl transition shadow-[0_5px_15px_rgba(251,191,36,0.3)] active:scale-95">
                                    Simpan Status
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Preview Modal -->
        <div x-show="showPreview" 
             class="fixed inset-0 z-[100] overflow-y-auto" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm" @click="showPreview = false"></div>

                <div class="relative z-10 bg-white rounded-[2.5rem] shadow-2xl w-full max-w-5xl overflow-hidden transition-all duration-300">
                    <div class="bg-gradient-primary p-6 md:p-8 flex justify-between items-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                        <h3 class="text-xl font-extrabold text-white relative z-10">Preview: <span x-text="previewTitle"></span></h3>
                        <button @click="showPreview = false" class="bg-white/15 hover:bg-red-500 text-white p-3 rounded-2xl relative z-10 font-black text-xs uppercase">Kembali</button>
                    </div>
                    <div class="p-6 bg-gray-50 flex justify-center items-center overflow-auto" style="min-height: 500px; max-height: 70vh;">
                        <template x-if="!isPdf"><img :src="previewUrl" class="max-w-full h-auto rounded-2xl shadow-xl"></template>
                        <template x-if="isPdf"><iframe :src="previewUrl" class="w-full h-[60vh] rounded-2xl border-0 shadow-xl"></iframe></template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
