<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Daftar Ulang') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Back to Dashboard -->
            <div class="mb-6">
                <a href="{{ route('siswa.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Main Status Card -->
            @php
                $status = $student->status;
                $tgl_mulai_du = $settings['tgl_mulai_daftar_ulang'] ?? '9999-12-31';
                $tgl_selesai_du = $settings['tgl_selesai_daftar_ulang'] ?? '0000-01-01';
                $now = now()->format('Y-m-d');
                $inDaftarUlang = ($now >= $tgl_mulai_du && $now <= $tgl_selesai_du);
            @endphp

            @if($status === 'aktif')
                <div class="mb-10 overflow-hidden rounded-[2.5rem] shadow-xl border-2 bg-gradient-to-r from-emerald-50 to-green-100 border-emerald-200 text-emerald-900 p-8 md:p-10 relative">
                    <div class="absolute inset-0 bg-white/40 backdrop-blur-sm z-0"></div>
                    <div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shrink-0 bg-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black uppercase tracking-tight">Status: RESMI AKTIF</h3>
                            <p class="text-sm font-medium mt-1 opacity-90 leading-relaxed">
                                Selamat! Berkas daftar ulang Anda telah diverifikasi dan Anda telah resmi menjadi siswa aktif.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($status === 'menunggu_daftar_ulang')
                <div class="mb-10 overflow-hidden rounded-[2.5rem] shadow-xl border-2 bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 text-blue-900 p-8 md:p-10 relative">
                    <div class="absolute inset-0 bg-white/40 backdrop-blur-sm z-0"></div>
                    <div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shrink-0 bg-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-black uppercase tracking-tight">Status: MENUNGGU VERIFIKASI</h3>
                            <p class="text-sm font-medium mt-1 opacity-90 leading-relaxed">
                                Berkas daftar ulang Anda sedang diperiksa oleh panitia. Mohon tunggu informasi selanjutnya.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if(in_array($status, ['lulus_pendaftaran', 'revisi_daftar_ulang']))
                <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 mb-12">
                    
                    <!-- Header -->
                    <div class="bg-gradient-primary p-10 text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10"></div>
                        <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-500/10 skew-x-12 transform translate-x-16"></div>
                        <div class="relative z-10 flex items-center gap-6">
                            <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 flex items-center justify-center shrink-0 shadow-[0_0_20px_rgba(59,130,246,0.3)]">
                                <svg class="w-8 h-8 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-3xl font-extrabold tracking-tight mb-2">Formulir Daftar Ulang</h3>
                                <p class="text-white/90 text-sm md:text-base font-medium">Silakan lengkapi dan unggah berkas-berkas persyaratan untuk proses daftar ulang.</p>
                            </div>
                        </div>
                    </div>

                    @if($status === 'revisi_daftar_ulang')
                        <div class="p-8 pb-0">
                            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 flex items-start gap-4">
                                <div class="bg-red-100 text-red-600 rounded-lg p-2 shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-red-900 mb-1">Catatan Revisi dari Panitia:</h4>
                                    <p class="text-sm text-red-800">{{ $student->catatan ?? 'Terdapat berkas yang tidak valid atau kurang jelas. Silakan unggah ulang berkas yang benar.' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($inDaftarUlang)
                        <form action="{{ route('siswa.daftar_ulang.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                            @csrf
                            
                            <div class="space-y-6">
                                <!-- Akte Kelahiran -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">1. Scan Akte Kelahiran Asli <span class="text-red-500">*</span></label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 hover:border-blue-500 transition-colors bg-gray-50 text-center relative">
                                        <input type="file" name="daftar_ulang_akte" id="file_akte" accept=".pdf,image/jpeg,image/png,image/jpg" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(this, 'name_akte')">
                                        <p id="name_akte" class="text-gray-500 text-sm font-medium">Pilih berkas Akte Kelahiran (Format: PDF, JPG, PNG)</p>
                                    </div>
                                    @error('daftar_ulang_akte') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    @if($student->daftar_ulang_akte)
                                        <p class="text-xs text-emerald-600 mt-2 font-medium">✓ Berkas sudah diunggah. Pilih berkas baru jika ingin mengganti.</p>
                                    @endif
                                </div>

                                <!-- KK -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">2. Scan Kartu Keluarga (KK) Asli <span class="text-red-500">*</span></label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 hover:border-blue-500 transition-colors bg-gray-50 text-center relative">
                                        <input type="file" name="daftar_ulang_kk" id="file_kk" accept=".pdf,image/jpeg,image/png,image/jpg" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(this, 'name_kk')">
                                        <p id="name_kk" class="text-gray-500 text-sm font-medium">Pilih berkas Kartu Keluarga (Format: PDF, JPG, PNG)</p>
                                    </div>
                                    @error('daftar_ulang_kk') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    @if($student->daftar_ulang_kk)
                                        <p class="text-xs text-emerald-600 mt-2 font-medium">✓ Berkas sudah diunggah. Pilih berkas baru jika ingin mengganti.</p>
                                    @endif
                                </div>

                                <!-- SKL -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">3. Scan Surat Keterangan Lulus (SKL) Asli <span class="text-red-500">*</span></label>
                                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-4 hover:border-blue-500 transition-colors bg-gray-50 text-center relative">
                                        <input type="file" name="daftar_ulang_skl" id="file_skl" accept=".pdf,image/jpeg,image/png,image/jpg" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="updateFileName(this, 'name_skl')">
                                        <p id="name_skl" class="text-gray-500 text-sm font-medium">Pilih berkas SKL (Format: PDF, JPG, PNG)</p>
                                    </div>
                                    @error('daftar_ulang_skl') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    @if($student->daftar_ulang_skl)
                                        <p class="text-xs text-emerald-600 mt-2 font-medium">✓ Berkas sudah diunggah. Pilih berkas baru jika ingin mengganti.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-10 flex justify-end">
                                <button type="submit" class="bg-highlight hover:bg-yellow-400 text-blue-900 px-10 py-4 rounded-2xl font-black shadow-[0_10px_20px_rgba(251,191,36,0.3)] transition transform hover:-translate-y-1 flex items-center gap-3">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    <span>KIRIM BERKAS DAFTAR ULANG</span>
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="p-8">
                            <div class="bg-amber-100 p-8 rounded-2xl border border-amber-200 text-center">
                                <span class="text-5xl block mb-4">🗓️</span>
                                <h6 class="text-xl font-bold text-amber-900 mb-2">Jadwal Daftar Ulang Belum Dibuka / Sudah Ditutup</h6>
                                <p class="text-sm text-amber-800">Jadwal resmi Daftar Ulang: <br> <b>{{ \Carbon\Carbon::parse($tgl_mulai_du)->translatedFormat('d F Y') }}</b> s/d <b>{{ \Carbon\Carbon::parse($tgl_selesai_du)->translatedFormat('d F Y') }}</b></p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

    <script>
        function updateFileName(input, textId) {
            const textElement = document.getElementById(textId);
            if (input.files && input.files.length > 0) {
                textElement.innerHTML = '<span class="text-blue-600 font-bold">📄 ' + input.files[0].name + '</span>';
            } else {
                // Default text fallback if cancelled
                if (textId === 'name_akte') textElement.innerText = 'Pilih berkas Akte Kelahiran (Format: PDF, JPG, PNG)';
                else if (textId === 'name_kk') textElement.innerText = 'Pilih berkas Kartu Keluarga (Format: PDF, JPG, PNG)';
                else textElement.innerText = 'Pilih berkas SKL (Format: PDF, JPG, PNG)';
            }
        }
    </script>
</x-app-layout>
