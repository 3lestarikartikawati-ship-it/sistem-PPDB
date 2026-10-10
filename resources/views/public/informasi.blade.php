@extends('layouts.public')

@section('content')
<div class="bg-blue-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl shadow-lg p-8 md:p-12">
            <h1 class="text-4xl font-bold text-blue-900 mb-6 text-center">{{ $content->title ?? 'Informasi Pendaftaran' }}</h1>
            <div class="w-24 h-1 bg-highlight mx-auto rounded mb-10"></div>

            <div class="grid md:grid-cols-3 gap-12">
                <!-- Syarat Pendaftaran -->
                <div>
                    <div class="bg-blue-900 text-white p-4 rounded-t-xl">
                        <h3 class="text-xl font-bold">Syarat Pendaftaran</h3>
                    </div>
                    <div class="border border-t-0 border-gray-200 p-6 rounded-b-xl h-full">
                        <div class="prose max-w-none text-gray-700 space-y-3">
                            {!! $content->body ?? '<ul><li>Scan Kartu Keluarga</li><li>Scan Akta Kelahiran</li><li>Scan Ijazah SD/MI atau SKL</li><li>Pas Foto 3x4 (Background Biru)</li></ul>' !!}
                        </div>
                    </div>
                </div>

                <!-- Alur Pendaftaran -->
                <div>
                    <div class="bg-amber-500 text-white p-4 rounded-t-xl">
                        <h3 class="text-xl font-bold">Alur Pendaftaran</h3>
                    </div>
                    <div class="border border-t-0 border-gray-200 p-6 rounded-b-xl h-full">
                        <ol class="list-decimal list-inside text-gray-700 space-y-3">
                            <li>Klik tombol <span class="font-bold">Daftar Sekarang</span>.</li>
                            <li>Isi formulir dan unggah berkas pendaftaran awal.</li>
                            <li>Tunggu <b>Verifikasi Tahap 1</b> oleh Admin (Pengumuman Lulus Pendaftaran).</li>
                            <li>Jika lulus, perhatikan Tanggal Daftar Ulang di Jadwal PPDB.</li>
                            <li>Pada tanggal yang ditentukan, unggah <b>Berkas Daftar Ulang</b> (Akte, KK, SKL).</li>
                            <li>Tunggu <b>Verifikasi Tahap 2</b>. Jika disetujui, Anda resmi menjadi siswa aktif.</li>
                        </ol>
                    </div>
                </div>

                @if(!empty($settings['tgl_mulai_gel1']))
                <!-- Jadwal PPDB -->
                <div>
                    <div class="bg-emerald-600 text-white p-4 rounded-t-xl">
                        <h3 class="text-xl font-bold">Jadwal PPDB</h3>
                    </div>
                    <div class="border border-t-0 border-gray-200 p-6 rounded-b-xl h-full">
                        <div class="space-y-4">
                            <div>
                                <div class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Gelombang 1</div>
                                <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($settings['tgl_mulai_gel1'] ?? now())->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($settings['tgl_selesai_gel1'] ?? now())->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-blue-400 font-bold mt-1">Kuota: {{ $settings['quota_gel1'] ?? '0' }} Siswa</div>
                            </div>
                            <hr class="border-gray-50">
                            <div>
                                <div class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Gelombang 2</div>
                                <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($settings['tgl_mulai_gel2'] ?? now())->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($settings['tgl_selesai_gel2'] ?? now())->translatedFormat('d M Y') }}</div>
                                <div class="text-[10px] text-indigo-400 font-bold mt-1">Kuota: {{ $settings['quota_gel2'] ?? '0' }} Siswa</div>
                            </div>
                            <hr class="border-gray-50">
                            <div>
                                <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Pengumuman Akhir</div>
                                <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($settings['tgl_pengumuman'] ?? now())->translatedFormat('d F Y') }}</div>
                            </div>
                            <hr class="border-gray-50">
                            @if(!empty($settings['tgl_mulai_daftar_ulang']))
                            <div>
                                <div class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Jadwal Daftar Ulang</div>
                                <div class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($settings['tgl_mulai_daftar_ulang'])->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($settings['tgl_selesai_daftar_ulang'] ?? now())->translatedFormat('d M Y') }}</div>
                            </div>
                            @endif
                            <div class="bg-blue-50 p-3 rounded-xl mt-4">
                                <p class="text-[10px] text-blue-700 leading-tight italic">Siswa disarankan mendaftar di Gelombang 1 untuk prioritas kuota.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Kontak Panitia -->
            <div class="mt-16 bg-emerald-50 rounded-2xl p-8 border border-emerald-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-800">Butuh Bantuan Pendaftaran?</h4>
                        <p class="text-gray-600">Hubungi panitia PPDB kami via WhatsApp untuk respon cepat.</p>
                    </div>
                </div>
                <a href="https://wa.me/6282224215722" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-xl font-bold shadow-md transition transform hover:-translate-y-1">Chat WhatsApp Panitia</a>
            </div>
        </div>
    </div>
</div>
@endsection
