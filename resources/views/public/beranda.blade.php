@extends('layouts.public')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-primary text-white py-20 lg:py-32 relative overflow-hidden">
    <div class="absolute inset-0 bg-black opacity-10"></div>
    
    <!-- Decorative Elements -->
    <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-600/10 skew-x-12 transform translate-x-32 hidden lg:block"></div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-blue-500/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="text-center lg:text-left">
                <div class="inline-block px-4 py-1.5 mb-6 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-sm font-semibold tracking-wide text-highlight animate-pulse">
                    Penerimaan Siswa Baru T.A 2026/2027
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
                    {{ $content->title ?? 'Selamat Datang di PPDB SMP Muhammadiyah Kaliwiro' }}
                </h1>
                <p class="text-lg md:text-xl text-blue-100 mb-10 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    {!! $content->body ?? 'Wujudkan impian putra-putri Anda menjadi generasi Islami yang cerdas, berprestasi, dan berakhlak mulia.' !!}
                </p>
                <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                    <a href="{{ url('/pendaftaran') }}" class="bg-highlight hover:bg-yellow-400 text-blue-900 px-10 py-4 rounded-full font-bold shadow-[0_10px_20px_rgba(251,191,36,0.3)] transition transform hover:-translate-y-1 text-center">Daftar Sekarang</a>
                    <a href="#tentang" class="bg-white/10 hover:bg-white/20 backdrop-blur-sm text-white px-10 py-4 rounded-full font-bold border border-white/20 transition text-center">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="relative hidden lg:block">
                <!-- Image Wrapper with Effects -->
                <div class="relative z-10 group">
                    <div class="absolute -inset-4 bg-highlight/20 rounded-[3rem] blur-2xl group-hover:bg-highlight/30 transition duration-500"></div>
                    <div class="relative">
                        <img src="{{ asset('images/gambar sekolah.png') }}" 
                             alt="Gedung SMP Muhammadiyah Kaliwiro" 
                             class="rounded-[2.5rem] shadow-2xl border-4 border-white/20 w-full aspect-[4/3] object-cover transform -rotate-2 group-hover:rotate-0 transition duration-700 ease-out">
                        
                        <!-- Floating Badge -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-5 rounded-2xl shadow-xl flex items-center gap-4 animate-bounce-slow">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <div class="text-blue-900 font-bold">Terakreditasi A</div>
                                <div class="text-xs text-gray-500">Unggul & Berprestasi</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Extra Decorative Card -->
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Section -->
<div id="tentang" class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-highlight rounded-3xl -z-10 animate-pulse"></div>
                <img src="{{ $about && $about->image ? asset('storage/' . $about->image) : asset('images/gambar sekolah.png') }}" alt="Tentang Sekolah" class="rounded-3xl shadow-2xl w-full h-[400px] object-cover">
                <div class="absolute -bottom-6 -right-6 bg-blue-600 p-8 rounded-3xl shadow-xl text-white">
                    <div class="text-4xl font-black mb-1">25+</div>
                    <div class="text-sm font-medium opacity-80">Tahun Pengalaman</div>
                </div>
            </div>
            <div>
                <h2 class="text-3xl font-bold text-blue-900 mb-6">{{ $about->title ?? 'Membangun Masa Depan Bersama SMP Muhammadiyah Kaliwiro' }}</h2>
                <div class="w-20 h-1.5 bg-highlight rounded mb-8"></div>
                <div class="text-gray-600 text-lg leading-relaxed mb-8 prose prose-blue max-w-none">
                    {!! $about->body ?? 'Kami berkomitmen untuk menyelenggarakan pendidikan yang memadukan nilai-nilai keislaman dengan keunggulan akademik dan pengembangan karakter.' !!}
                </div>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-700">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Pembelajaran berbasis IT
                    </li>
                    <li class="flex items-center text-gray-700">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Ekstrakurikuler beragam
                    </li>
                    <li class="flex items-center text-gray-700">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Program Tahfidz Al-Quran
                    </li>
                </ul>
        </div>
    </div>
</section>

@if(!empty($settings['tgl_mulai_gel1']))
<!-- Jadwal PPDB Section -->
<section class="py-24 bg-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Jadwal Penting PPDB</h2>
            <div class="w-20 h-1.5 bg-highlight rounded mx-auto mb-6"></div>
            <p class="text-gray-600 max-w-2xl mx-auto">Catat tanggal-tanggal penting agar tidak terlewatkan proses pendaftaran putra-putri Anda.</p>
        </div>

        <div class="grid md:grid-cols-5 gap-6 relative">
            <!-- Connector Line (Desktop) -->
            <div class="absolute top-1/2 left-0 w-full h-0.5 bg-blue-200 -z-10 hidden md:block transform -translate-y-1/2"></div>

            <!-- Item 1: Gelombang 1 -->
            <div class="bg-white p-6 rounded-3xl shadow-lg border-b-4 border-blue-500 relative transform hover:-translate-y-2 transition duration-300">
                <div class="w-12 h-12 bg-blue-600 text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-blue-200">
                    <span class="font-black text-lg">1</span>
                </div>
                <h4 class="text-lg font-bold text-blue-900 mb-1">Gelombang 1</h4>
                <p class="text-[10px] text-gray-500 mb-3 italic">Pendaftaran Awal</p>
                <div class="bg-blue-50 p-3 rounded-2xl">
                    <div class="text-blue-600 font-bold text-sm">
                        {{ \Carbon\Carbon::parse($settings['tgl_mulai_gel1'] ?? now())->translatedFormat('d M Y') }}
                    </div>
                    <div class="text-gray-400 text-[10px] font-bold uppercase tracking-widest my-0.5">S.D</div>
                    <div class="text-blue-600 font-bold text-sm">
                        {{ \Carbon\Carbon::parse($settings['tgl_selesai_gel1'] ?? now())->translatedFormat('d M Y') }}
                    </div>
                    <div class="mt-3 pt-3 border-t border-blue-100 flex justify-between items-center">
                        <span class="text-[10px] font-bold text-blue-400 uppercase">Kuota</span>
                        <span class="text-xs font-black text-blue-700">{{ $settings['quota_gel1'] ?? '0' }} Siswa</span>
                    </div>
                </div>
            </div>

            <!-- Item 2: Gelombang 2 -->
            <div class="bg-white p-6 rounded-3xl shadow-lg border-b-4 border-indigo-500 relative transform hover:-translate-y-2 transition duration-300">
                <div class="w-12 h-12 bg-indigo-600 text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-indigo-200">
                    <span class="font-black text-lg">2</span>
                </div>
                <h4 class="text-lg font-bold text-blue-900 mb-1">Gelombang 2</h4>
                <p class="text-[10px] text-gray-500 mb-3 italic">Pendaftaran Lanjutan</p>
                <div class="bg-indigo-50 p-3 rounded-2xl">
                    <div class="text-indigo-600 font-bold text-sm">
                        {{ \Carbon\Carbon::parse($settings['tgl_mulai_gel2'] ?? now())->translatedFormat('d M Y') }}
                    </div>
                    <div class="text-gray-400 text-[10px] font-bold uppercase tracking-widest my-0.5">S.D</div>
                    <div class="text-indigo-600 font-bold text-sm">
                        {{ \Carbon\Carbon::parse($settings['tgl_selesai_gel2'] ?? now())->translatedFormat('d M Y') }}
                    </div>
                    <div class="mt-3 pt-3 border-t border-indigo-100 flex justify-between items-center">
                        <span class="text-[10px] font-bold text-indigo-400 uppercase">Kuota</span>
                        <span class="text-xs font-black text-indigo-700">{{ $settings['quota_gel2'] ?? '0' }} Siswa</span>
                    </div>
                </div>
            </div>

            <!-- Item 3: Verifikasi -->
            <div class="bg-white p-6 rounded-3xl shadow-lg border-b-4 border-amber-500 relative transform hover:-translate-y-2 transition duration-300">
                <div class="w-12 h-12 bg-amber-500 text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-amber-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h4 class="text-lg font-bold text-blue-900 mb-1">Verifikasi</h4>
                <p class="text-[10px] text-gray-500 mb-3 italic">Cek Berkas & Data</p>
                <div class="bg-amber-50 p-3 rounded-2xl">
                    <div class="text-amber-600 font-bold text-sm italic">Oleh Panitia</div>
                    <div class="text-amber-800 text-[10px] mt-2 font-medium leading-tight">Secara berkala di jam kerja sekolah</div>
                </div>
            </div>

            <!-- Item 4: Pengumuman -->
            <div class="bg-white p-6 rounded-3xl shadow-lg border-b-4 border-emerald-500 relative transform hover:-translate-y-2 transition duration-300">
                <div class="w-12 h-12 bg-emerald-600 text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-emerald-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <h4 class="text-lg font-bold text-blue-900 mb-1">Pengumuman</h4>
                <p class="text-[10px] text-gray-500 mb-3 italic">Hasil Akhir Seleksi</p>
                <div class="bg-emerald-50 p-3 rounded-2xl">
                    <div class="text-emerald-600 font-bold text-sm">
                        {{ \Carbon\Carbon::parse($settings['tgl_pengumuman'] ?? now())->translatedFormat('d M Y') }}
                    </div>
                    <div class="text-emerald-800 text-[10px] mt-2 font-medium leading-tight">Melalui Portal Siswa</div>
                </div>
            </div>

            <!-- Item 5: Daftar Ulang -->
            <div class="bg-white p-6 rounded-3xl shadow-lg border-b-4 border-cyan-500 relative transform hover:-translate-y-2 transition duration-300">
                <div class="w-12 h-12 bg-cyan-600 text-white rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-cyan-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h4 class="text-lg font-bold text-blue-900 mb-1">Daftar Ulang</h4>
                <p class="text-[10px] text-gray-500 mb-3 italic">Pemberkasan Akhir</p>
                <div class="bg-cyan-50 p-3 rounded-2xl">
                    <div class="text-cyan-600 font-bold text-sm">
                        {{ \Carbon\Carbon::parse($settings['tgl_mulai_daftar_ulang'] ?? now())->translatedFormat('d M Y') }}
                    </div>
                    <div class="text-gray-400 text-[10px] font-bold uppercase tracking-widest my-0.5">S.D</div>
                    <div class="text-cyan-600 font-bold text-sm">
                        {{ \Carbon\Carbon::parse($settings['tgl_selesai_daftar_ulang'] ?? now())->translatedFormat('d M Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($faqs->count() > 0)
<!-- FAQ Section -->
<section class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-blue-900 mb-4">Tanya Jawab (FAQ)</h2>
            <div class="w-20 h-1.5 bg-highlight rounded mx-auto mb-6"></div>
            <p class="text-gray-600">Punya pertanyaan? Mungkin jawabannya sudah ada di sini.</p>
        </div>

        <div class="space-y-4" x-data="{ active: null }">
            @foreach($faqs as $faq)
            <div class="border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                <button 
                    @click="active = (active === {{ $faq->id }} ? null : {{ $faq->id }})"
                    class="w-full flex items-center justify-between p-6 text-left focus:outline-none bg-white transition-colors"
                    :class="active === {{ $faq->id }} ? 'bg-blue-50/50' : ''"
                >
                    <span class="text-lg font-bold text-blue-900">{{ $faq->question }}</span>
                    <svg 
                        class="w-6 h-6 text-blue-500 transition-transform duration-300" 
                        :class="active === {{ $faq->id }} ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div 
                    x-show="active === {{ $faq->id }}" 
                    x-collapse
                    class="px-6 pb-6 text-gray-600 leading-relaxed border-t border-gray-50 bg-white"
                    style="display: none;"
                >
                    <div class="pt-4">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Statistik -->
<section class="py-16 bg-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 transform hover:-translate-y-2 transition">
                <div class="text-4xl font-bold text-blue-600 mb-2">30+</div>
                <div class="text-gray-600 font-medium">Siswa Aktif</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 transform hover:-translate-y-2 transition">
                <div class="text-4xl font-bold text-blue-600 mb-2">11</div>
                <div class="text-gray-600 font-medium">Guru Profesional</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 transform hover:-translate-y-2 transition">
                <div class="text-4xl font-bold text-blue-600 mb-2">3</div>
                <div class="text-gray-600 font-medium">Ekstrakurikuler</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-blue-100 transform hover:-translate-y-2 transition">
                <div class="text-4xl font-bold text-blue-600 mb-2">100%</div>
                <div class="text-gray-600 font-medium">Lulusan Terbaik</div>
            </div>
        </div>
    </div>
</section>
@endsection
