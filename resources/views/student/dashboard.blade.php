<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Calon Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Banner -->
            <div class="bg-gradient-primary overflow-hidden shadow-2xl sm:rounded-[2.5rem] border border-blue-800/50 relative mb-10">
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-black opacity-10"></div>
                <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-500/10 skew-x-12 transform translate-x-16"></div>
                <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl"></div>
                
                <div class="p-8 md:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-8 relative z-10">
                    <div class="flex items-center gap-6 w-full md:w-auto">
                        <div class="w-20 h-20 bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 flex items-center justify-center text-white text-3xl font-black shadow-[0_0_30px_rgba(59,130,246,0.3)] shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-3xl font-extrabold mb-2 text-white tracking-tight">Halo, {{ auth()->user()->name }}!</h3>
                            <p class="text-white/90 text-sm md:text-base max-w-md font-medium">Selamat datang di portal pendaftaran SMP Muhammadiyah Kaliwiro. Pantau terus status pendaftaran & daftar ulang Anda di sini.</p>
                        </div>
                    </div>
                    @if ($student)
                    <div class="bg-white/10 backdrop-blur-md px-8 py-5 rounded-3xl border border-white/20 text-center shadow-xl w-full md:w-auto transform hover:scale-105 transition duration-300">
                        <div class="text-xs font-bold text-highlight uppercase tracking-widest mb-1.5">Nomor Pendaftaran</div>
                        <div class="text-2xl font-black text-white font-mono">{{ $student->nomor_pendaftaran }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Status Stepper Section -->
            <div class="mt-8 bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden transform hover:shadow-2xl transition duration-500 relative">
                <div class="p-8 border-b border-gray-50 flex items-center gap-4 bg-gray-50/50">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-blue-900">Alur Pendaftaran Anda</h3>
                </div>
                <div class="p-10">
                    <div class="relative">
                        <!-- Progress Line Background -->
                        <div class="absolute top-1/2 left-0 w-full h-1.5 bg-gray-100 -translate-y-1/2 hidden md:block rounded-full"></div>
                        
                        <!-- Progress Line Active -->
                        @php
                            $progress = 20;
                            if($student) $progress = 40; // Step 2 (Isi Biodata Done)
                            if($student && in_array($student->status, ['lulus_pendaftaran', 'menunggu_daftar_ulang', 'revisi_daftar_ulang', 'aktif'])) $progress = 60; // Lulus Tahap 1
                            if($student && in_array($student->status, ['menunggu_daftar_ulang', 'revisi_daftar_ulang', 'aktif'])) $progress = 80;
                            if($student && $student->status == 'aktif') $progress = 100;
                            
                            $tgl_mulai_du = \App\Models\Setting::where('key', 'tgl_mulai_daftar_ulang')->value('value');
                            $tgl_selesai_du = \App\Models\Setting::where('key', 'tgl_selesai_daftar_ulang')->value('value');
                            $now = now()->format('Y-m-d');
                            $inDaftarUlang = ($tgl_mulai_du && $now >= $tgl_mulai_du && $now <= $tgl_selesai_du);
                        @endphp
                        <div class="absolute top-1/2 left-0 h-1.5 bg-highlight -translate-y-1/2 hidden md:block rounded-full transition-all duration-1000 ease-out" style="width: {{ $progress }}%; box-shadow: 0 0 10px rgba(251,191,36,0.5);"></div>

                        <div class="grid grid-cols-1 md:grid-cols-5 gap-8 relative z-10">
                            <!-- Step 1: Registrasi Akun -->
                            <div class="flex flex-col items-center group">
                                <div class="w-14 h-14 rounded-full bg-highlight text-blue-900 flex items-center justify-center shadow-[0_0_15px_rgba(251,191,36,0.4)] mb-4 ring-8 ring-white z-10">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <h4 class="text-xs font-black uppercase tracking-widest text-highlight mb-1.5">Step 1</h4>
                                <p class="text-sm font-bold text-gray-800 text-center">Registrasi Akun</p>
                            </div>

                            <!-- Step 2: Lengkapi Biodata -->
                            <div class="flex flex-col items-center group">
                                <div class="w-14 h-14 rounded-full {{ $student ? 'bg-highlight text-blue-900 shadow-[0_0_15px_rgba(251,191,36,0.4)]' : 'bg-gradient-primary text-white animate-bounce-slow shadow-[0_0_15px_rgba(59,130,246,0.4)]' }} flex items-center justify-center mb-4 ring-8 ring-white z-10">
                                    @if($student)
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <span class="font-black text-xl">2</span>
                                    @endif
                                </div>
                                <h4 class="text-xs font-black uppercase tracking-widest {{ $student ? 'text-highlight' : 'text-blue-600' }} mb-1.5">Step 2</h4>
                                <p class="text-sm font-bold {{ $student ? 'text-gray-800' : 'text-blue-700' }} text-center">Lengkapi Biodata</p>
                            </div>

                            <!-- Step 3: Verifikasi Tahap 1 -->
                            <div class="flex flex-col items-center group">
                                <div class="w-14 h-14 rounded-full {{ $progress >= 60 ? 'bg-highlight text-blue-900 shadow-[0_0_15px_rgba(251,191,36,0.4)]' : ($student ? 'bg-gradient-primary text-white animate-bounce-slow shadow-[0_0_15px_rgba(59,130,246,0.4)]' : 'bg-gray-100 text-gray-400') }} flex items-center justify-center mb-4 ring-8 ring-white z-10">
                                    @if($progress >= 60)
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <span class="font-black text-xl">3</span>
                                    @endif
                                </div>
                                <h4 class="text-xs font-black uppercase tracking-widest {{ $progress >= 60 ? 'text-highlight' : ($student ? 'text-blue-600' : 'text-gray-400') }} mb-1.5">Step 3</h4>
                                <p class="text-sm font-bold {{ $student ? 'text-gray-800' : 'text-gray-400' }} text-center">Verifikasi Pendaftaran</p>
                            </div>

                            <!-- Step 4: Daftar Ulang -->
                            <div class="flex flex-col items-center group">
                                <div class="w-14 h-14 rounded-full {{ $progress >= 80 ? 'bg-highlight text-blue-900 shadow-[0_0_15px_rgba(251,191,36,0.4)]' : ($progress >= 60 ? 'bg-gradient-primary text-white animate-bounce-slow' : 'bg-gray-100 text-gray-400') }} flex items-center justify-center mb-4 ring-8 ring-white z-10">
                                    @if($progress >= 80)
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <span class="font-black text-xl">4</span>
                                    @endif
                                </div>
                                <h4 class="text-xs font-black uppercase tracking-widest {{ $progress >= 80 ? 'text-highlight' : ($progress >= 60 ? 'text-blue-600' : 'text-gray-400') }} mb-1.5">Step 4</h4>
                                <p class="text-sm font-bold {{ $progress >= 60 ? 'text-gray-800' : 'text-gray-400' }} text-center">Upload Daftar Ulang</p>
                            </div>

                            <!-- Step 5: Siswa Aktif -->
                            <div class="flex flex-col items-center group">
                                <div class="w-14 h-14 rounded-full {{ $progress == 100 ? 'bg-highlight text-blue-900 shadow-[0_0_15px_rgba(251,191,36,0.4)]' : ($progress >= 80 ? 'bg-gradient-primary text-white animate-bounce-slow' : 'bg-gray-100 text-gray-400') }} flex items-center justify-center mb-4 ring-8 ring-white z-10">
                                    @if($progress == 100)
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    @else
                                        <span class="font-black text-xl">5</span>
                                    @endif
                                </div>
                                <h4 class="text-xs font-black uppercase tracking-widest {{ $progress == 100 ? 'text-highlight' : ($progress >= 80 ? 'text-blue-600' : 'text-gray-400') }} mb-1.5">Step 5</h4>
                                <p class="text-sm font-bold {{ $progress >= 80 ? 'text-gray-800' : 'text-gray-400' }} text-center">Resmi Aktif</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informational Alerts Based on Status -->
                    <div class="mt-14">
                        @if(!$student)
                            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl p-8 border border-white/10 flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl text-white relative overflow-hidden">
                                <div class="absolute -right-20 -top-20 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl"></div>
                                <div class="flex items-center gap-6 relative z-10">
                                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md text-white rounded-2xl flex items-center justify-center shadow-lg border border-white/30 shrink-0">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <h5 class="text-xl font-black text-white mb-1">Pendaftaran Belum Ditemukan</h5>
                                        <p class="text-sm text-white/90 font-medium">Akun Anda belum terhubung dengan data pendaftaran. Silakan daftar melalui halaman Pendaftaran.</p>
                                    </div>
                                </div>
                                <a href="{{ route('beranda') }}" class="bg-highlight hover:bg-yellow-400 text-blue-900 px-8 py-4 rounded-2xl font-bold transition transform hover:scale-105 shadow-[0_10px_20px_rgba(251,191,36,0.3)] whitespace-nowrap relative z-10 text-center w-full md:w-auto">Ke Beranda</a>
                            </div>

                        @elseif($student->status == 'menunggu')
                            <div class="bg-amber-50 rounded-2xl p-6 border border-amber-100 flex items-center gap-6">
                                <div class="w-12 h-12 bg-amber-500 text-white rounded-xl flex items-center justify-center shadow-lg shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="font-black text-amber-900 uppercase tracking-wider text-sm mb-1">Sedang Diverifikasi (Tahap 1)</h5>
                                    <p class="text-sm text-amber-800 leading-relaxed">Formulir Pendaftaran awal Anda sedang diperiksa oleh Panitia. Mohon cek halaman ini secara berkala.</p>
                                </div>
                            </div>
                        
                        @elseif($student->status == 'revisi_pendaftaran')
                            <div class="bg-red-50 rounded-2xl p-8 border border-red-100">
                                <div class="flex flex-col md:flex-row items-start gap-6">
                                    <div class="w-16 h-16 bg-red-600 text-white rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="text-xl font-black text-red-900 mb-2 uppercase tracking-tight">Mohon Maaf, Berkas Pendaftaran Perlu Perbaikan</h5>
                                        <div class="bg-white/60 rounded-xl p-4 border border-red-200 mb-6">
                                            <p class="text-xs font-black text-red-400 uppercase tracking-widest mb-1">Catatan Admin:</p>
                                            <p class="text-gray-800 font-medium italic">"{{ $student->catatan ?? 'Terdapat berkas persyaratan yang kurang atau tidak valid.' }}"</p>
                                        </div>
                                        <p class="text-sm text-red-700 mb-4">Silakan hubungi panitia PPDB untuk informasi lebih lanjut mengenai perbaikan berkas.</p>
                                        <div class="flex flex-col sm:flex-row items-center gap-4">
                                            <a href="{{ route('siswa.pendaftaran.edit') }}" class="bg-red-600 hover:bg-red-700 text-white px-8 py-3 rounded-xl font-bold transition shadow-lg w-full sm:w-auto text-center">
                                                Revisi Data Pendaftaran
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        @elseif(in_array($student->status, ['lulus_pendaftaran', 'ditolak', 'cadangan']) && $tgl_pengumuman && now()->format('Y-m-d') < $tgl_pengumuman)
                            <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100 flex items-center gap-6 shadow-sm">
                                <div class="w-12 h-12 bg-indigo-500 text-white rounded-xl flex items-center justify-center shadow-lg shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="font-black text-indigo-900 uppercase tracking-wider text-sm mb-1">Menunggu Pengumuman Kelulusan</h5>
                                    <p class="text-sm text-indigo-800 leading-relaxed">Pengumuman kelulusan pendaftaran akan dibuka pada tanggal <b>{{ \Carbon\Carbon::parse($tgl_pengumuman)->translatedFormat('d F Y') }}</b>. Silakan kembali lagi pada tanggal tersebut.</p>
                                </div>
                            </div>
                            
                        @elseif(in_array($student->status, ['lulus_pendaftaran', 'revisi_daftar_ulang']))
                            <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-[2.5rem] p-10 border border-emerald-200 relative overflow-hidden shadow-xl">
                                <div class="relative z-10">
                                    <div class="text-center mb-8">
                                        <div class="inline-flex w-20 h-20 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-full items-center justify-center shadow-[0_0_40px_rgba(16,185,129,0.4)] mx-auto mb-4 ring-8 ring-white animate-bounce-slow">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <h5 class="text-3xl font-black text-emerald-900 mb-2">Lulus Verifikasi Pendaftaran! 🎉</h5>
                                        <p class="text-emerald-800 font-medium text-lg mb-6">Langkah selanjutnya adalah melakukan <b>Daftar Ulang</b>.</p>
                                        
                                        <a href="{{ route('siswa.cetak_skd') }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg text-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Cetak Surat Kelulusan (SKD)
                                        </a>
                                    </div>
                                    
                                    <div class="bg-white rounded-3xl p-8 border border-emerald-100 shadow-sm max-w-3xl mx-auto">
                                        @if($student->status == 'revisi_daftar_ulang')
                                            <div class="bg-red-50 text-red-800 p-4 rounded-xl border border-red-200 mb-6 text-sm">
                                                <b>Catatan Revisi Daftar Ulang:</b><br>
                                                {{ $student->catatan ?? 'Ada berkas daftar ulang yang salah.' }}
                                            </div>
                                        @endif

                                        <h6 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Silakan Upload Berkas Daftar Ulang:</h6>
                                        <p class="text-xs text-gray-500 mb-6">Berkas yang diperlukan: Scan Akte Kelahiran, Scan Kartu Keluarga, dan Scan SKL.</p>
                                        
                                        @if($inDaftarUlang)
                                            <form action="{{ route('siswa.daftar_ulang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                                @csrf
                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700 mb-1">Akte Kelahiran</label>
                                                    <input type="file" name="daftar_ulang_akte" accept=".pdf,image/*" required class="w-full border-gray-300 rounded-lg p-2 bg-gray-50 text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700 mb-1">Kartu Keluarga (KK)</label>
                                                    <input type="file" name="daftar_ulang_kk" accept=".pdf,image/*" required class="w-full border-gray-300 rounded-lg p-2 bg-gray-50 text-sm">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-bold text-gray-700 mb-1">Surat Keterangan Lulus (SKL)</label>
                                                    <input type="file" name="daftar_ulang_skl" accept=".pdf,image/*" required class="w-full border-gray-300 rounded-lg p-2 bg-gray-50 text-sm">
                                                </div>
                                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl shadow-lg transition">Kirim Berkas Daftar Ulang</button>
                                            </form>
                                        @else
                                            <div class="bg-amber-100 p-5 rounded-xl border border-amber-200 text-center">
                                                <span class="text-4xl block mb-2">🗓️</span>
                                                <h6 class="font-bold text-amber-900">Jadwal Daftar Ulang Belum Dibuka</h6>
                                                <p class="text-sm text-amber-800 mt-1">Jadwal Daftar Ulang akan berlangsung pada: <br> <b>{{ \Carbon\Carbon::parse($tgl_mulai_du)->translatedFormat('d F Y') }}</b> s/d <b>{{ \Carbon\Carbon::parse($tgl_selesai_du)->translatedFormat('d F Y') }}</b></p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                        @elseif($student->status == 'menunggu_daftar_ulang')
                            <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 flex items-center gap-6">
                                <div class="w-12 h-12 bg-blue-500 text-white rounded-xl flex items-center justify-center shadow-lg shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="font-black text-blue-900 uppercase tracking-wider text-sm mb-1">Menunggu Verifikasi Tahap 2</h5>
                                    <p class="text-sm text-blue-800 leading-relaxed">Berkas Daftar Ulang Anda sedang diperiksa oleh Panitia. Jika telah disetujui, status Anda akan berubah menjadi Aktif.</p>
                                </div>
                            </div>
                            
                        @elseif($student->status == 'aktif')
                            <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-[2.5rem] p-10 border border-emerald-200 text-center shadow-xl">
                                <div class="w-24 h-24 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-full flex items-center justify-center shadow-[0_0_40px_rgba(16,185,129,0.4)] mx-auto mb-8 ring-8 ring-white">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h5 class="text-3xl font-black text-emerald-900 mb-3">Selamat, Anda Resmi Menjadi Siswa Aktif! 🎉</h5>
                                <p class="text-emerald-800 max-w-2xl mx-auto mb-10 font-medium text-lg leading-relaxed">Semua proses pendaftaran dan daftar ulang telah selesai. Selamat bergabung di keluarga besar SMP Muhammadiyah Kaliwiro.</p>
                                <div class="flex flex-col lg:flex-row items-center justify-center gap-5">
                                    <a href="{{ route('siswa.cetak_bukti') }}" target="_blank" class="bg-white hover:bg-gray-50 text-emerald-700 px-8 py-4 rounded-2xl font-bold transition transform hover:-translate-y-1 shadow-lg flex items-center gap-3 justify-center border border-emerald-200">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                        Cetak Bukti Pendaftaran
                                    </a>
                                    <a href="{{ route('siswa.cetak_skd') }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-bold transition transform hover:-translate-y-1 shadow-lg flex items-center gap-3 justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Cetak SK Diterima (SKD)
                                    </a>
                                </div>
                            </div>
                            
                        @elseif($student->status == 'ditolak')
                            <div class="bg-red-50 rounded-2xl p-8 border border-red-100 flex gap-6">
                                <div class="w-16 h-16 bg-red-600 text-white rounded-2xl flex items-center justify-center shadow-lg shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="text-xl font-black text-red-900 mb-2 uppercase tracking-tight">Pendaftaran Ditolak</h5>
                                    <p class="text-red-800">Mohon maaf, pendaftaran Anda ditolak secara permanen. Catatan: {{ $student->catatan }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
