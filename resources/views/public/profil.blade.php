@extends('layouts.public')

@section('content')
<div class="bg-blue-50 py-12" x-data="{ 
    activeTab: window.location.hash || '#sejarah',
    init() {
        window.addEventListener('hashchange', () => {
            this.activeTab = window.location.hash || '#sejarah';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar Navigation -->
            <aside class="lg:w-1/4">
                <div class="bg-white rounded-3xl shadow-lg p-6 sticky top-24">
                    <h3 class="text-xl font-bold text-blue-900 mb-6 px-2">Menu Profil</h3>
                    <nav class="space-y-2">
                        @foreach([
                            ['id' => '#sejarah', 'label' => 'Identitas Sekolah', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                            ['id' => '#kepsek', 'label' => 'Kepala Sekolah', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                            ['id' => '#visimisi', 'label' => 'Visi & Misi', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                            ['id' => '#tujuan', 'label' => 'Tujuan & Sasaran', 'icon' => 'M13 10V3L4 14h7v7l9-11h-7z'],
                            ['id' => '#struktur', 'label' => 'Struktur Organisasi', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                            ['id' => '#guru', 'label' => 'Guru & Karyawan', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z']
                        ] as $item)
                        <a href="{{ $item['id'] }}" 
                           :class="activeTab === '{{ $item['id'] }}' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-600'"
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl font-medium transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"></path></svg>
                            {{ $item['label'] }}
                        </a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="lg:w-3/4">
                <div class="bg-white rounded-3xl shadow-lg p-8 md:p-12 min-h-[600px]">
                    
                    <!-- Sejarah / Identitas -->
                    <div id="sejarah" x-show="activeTab === '#sejarah'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                        <h2 class="text-3xl font-bold text-blue-900 mb-2">Identitas Sekolah</h2>
                        <div class="w-20 h-1.5 bg-highlight rounded mb-10"></div>
                        
                        <div class="grid md:grid-cols-2 gap-12 items-start">
                            <div>
                                <div class="bg-gray-50 border border-gray-100 rounded-2xl p-6 mb-6 shadow-sm">
                                    <table class="w-full text-left text-gray-700 text-lg">
                                        <tbody>
                                            <tr class="border-b border-gray-200"><th class="py-3 font-semibold w-1/3">Nama Sekolah</th><td class="py-3">: SMP Muhammadiyah Kaliwiro</td></tr>
                                            <tr class="border-b border-gray-200"><th class="py-3 font-semibold">NPSN</th><td class="py-3">: 20306772</td></tr>
                                            <tr><th class="py-3 font-semibold align-top">Alamat</th><td class="py-3 align-top">: Dusun Selomanik, Desa Selomanik<br>&nbsp;&nbsp;Kecamatan Kaliwiro, Wonosobo<br>&nbsp;&nbsp;Kode Pos 563634</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="prose max-w-none text-gray-600 leading-relaxed text-lg">
                                    {!! $content->body ?? 'SMP Muhammadiyah Kaliwiro didirikan dengan semangat untuk mencerdaskan kehidupan bangsa melalui pendidikan yang berlandaskan nilai-nilai Islam.' !!}
                                </div>
                            </div>
                            <div class="rounded-2xl overflow-hidden shadow-xl border-4 border-white cursor-pointer group"
                                 @click="lightboxSrc = '{{ $content && $content->image ? asset('storage/' . $content->image) : asset('images/profil sekolah.jpeg') }}'; lightboxOpen = true">
                                <img src="{{ $content && $content->image ? asset('storage/' . $content->image) : asset('images/profil sekolah.jpeg') }}" class="w-full h-auto object-cover hover:scale-105 transition duration-500">
                            </div>
                        </div>
                    </div>

                    <!-- Profil Kepala Sekolah -->
                    <div id="kepsek" x-show="activeTab === '#kepsek'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                        <h2 class="text-3xl font-bold text-blue-900 mb-2">Profil Kepala Sekolah</h2>
                        <div class="w-20 h-1.5 bg-highlight rounded mb-10"></div>
                        
                        <div class="grid md:grid-cols-3 gap-12 items-center">
                            <div class="md:col-span-1">
                                <div class="relative rounded-2xl overflow-hidden shadow-lg border-4 border-white bg-gray-100 cursor-pointer group"
                                     @click="lightboxSrc = '{{ asset('images/foto kepsek.jpeg') }}'; lightboxOpen = true">
                                    <img src="{{ asset('images/foto kepsek.jpeg') }}" class="w-full h-80 object-cover object-top hover:scale-105 transition duration-500">
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <div class="bg-blue-50 border-l-4 border-blue-500 rounded-xl p-6">
                                    <table class="w-full text-left text-gray-700 text-lg">
                                        <tbody>
                                            <tr class="border-b border-blue-100"><th class="py-3 font-semibold w-1/3">Nama Lengkap</th><td class="py-3 font-bold text-blue-900">: Tabah S. Pambudi, M.I.Kom</td></tr>
                                            <tr class="border-b border-blue-100"><th class="py-3 font-semibold">Ttl.</th><td class="py-3">: 28 Januari 1989</td></tr>
                                            <tr class="border-b border-blue-100"><th class="py-3 font-semibold">Jenis Kelamin</th><td class="py-3">: Laki-laki</td></tr>
                                            <tr class="border-b border-blue-100"><th class="py-3 font-semibold">Agama</th><td class="py-3">: Islam</td></tr>
                                            <tr><th class="py-3 font-semibold">Status</th><td class="py-3">: Plt.</td></tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Visi Misi -->
                    <div id="visimisi" x-show="activeTab === '#visimisi'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                        <h2 class="text-3xl font-bold text-blue-900 mb-2">Visi & Misi</h2>
                        <div class="w-20 h-1.5 bg-highlight rounded mb-10"></div>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="bg-blue-50 p-8 rounded-2xl">
                                <h3 class="text-2xl font-bold text-blue-900 mb-6 flex items-center gap-3">
                                    <span class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center">V</span> Visi
                                </h3>
                                <p class="text-gray-700 font-bold italic text-xl text-center leading-relaxed">
                                    ”Terwujudnya Peserta Didik yang Bertaqwa, Berprestasi, Terampil dan Peduli Lingkungan”
                                </p>
                            </div>
                            <div class="bg-yellow-50 p-8 rounded-2xl">
                                <h3 class="text-2xl font-bold text-yellow-700 mb-6 flex items-center gap-3">
                                    <span class="w-10 h-10 bg-yellow-500 text-white rounded-full flex items-center justify-center">M</span> Misi
                                </h3>
                                <ul class="list-decimal list-outside ml-4 text-gray-700 space-y-3 font-medium">
                                    <li>Menumbuhkan penghayatan dan pengalaman agama islam sesuai dengan Al Qur'an dan As Sunah;</li>
                                    <li>Menumbuhkan rasa saling menghormati antar warga sekolah dan masyarakat;</li>
                                    <li>Menyelenggarakan pembelajaran secara efektif;</li>
                                    <li>Pelatihan bimbingan di bidang olahraga dan seni;</li>
                                    <li>Melaksanakan kegiatan berwawasan lingkungan.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tujuan -->
                    <div id="tujuan" x-show="activeTab === '#tujuan'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                        <h2 class="text-3xl font-bold text-blue-900 mb-2">Tujuan & Sasaran</h2>
                        <div class="w-20 h-1.5 bg-highlight rounded mb-10"></div>
                        
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="bg-indigo-50 p-8 rounded-3xl border border-indigo-100">
                                <h3 class="text-2xl font-bold text-indigo-900 mb-6">Tujuan Strategis</h3>
                                <ul class="space-y-4">
                                    @foreach(['Membentuk generasi muslim aqidah ahlussunah wal jama’ah.', 'Mewujudkan generasi berkarakter mulia.', 'Melahirkan generasi cakap berbahasa.', 'Membentuk generasi terampil teknologi.'] as $index => $item)
                                    <li class="flex gap-4">
                                        <span class="flex-shrink-0 w-8 h-8 bg-indigo-600 text-white rounded-full flex items-center justify-center font-bold text-sm">{{ $index + 1 }}</span>
                                        <p class="text-gray-700 leading-relaxed">{{ $item }}</p>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="bg-emerald-50 p-8 rounded-3xl border border-emerald-100">
                                <h3 class="text-2xl font-bold text-emerald-900 mb-6">Sasaran Utama</h3>
                                <ul class="space-y-4">
                                    @foreach(['Kehadiran warga sekolah 100%.', 'Kelengkapan sarana pembelajaran.', 'Pengembangan potensi bakat siswa.'] as $index => $item)
                                    <li class="flex gap-4">
                                        <span class="flex-shrink-0 w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center font-bold text-sm">{{ $index + 1 }}</span>
                                        <p class="text-gray-700 leading-relaxed">{{ $item }}</p>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Struktur -->
                    <div id="struktur" x-show="activeTab === '#struktur'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                        <h2 class="text-3xl font-bold text-blue-900 mb-2">Struktur Organisasi</h2>
                        <div class="w-20 h-1.5 bg-highlight rounded mb-10"></div>
                        
                        <div class="bg-white border border-gray-100 rounded-3xl p-4 shadow-xl cursor-pointer group"
                             @click="lightboxSrc = '{{ asset('images/struktur organisasi.jpeg') }}'; lightboxOpen = true">
                            <img src="{{ asset('images/struktur organisasi.jpeg') }}" class="w-full h-auto rounded-2xl transition duration-500 group-hover:scale-[1.01]">
                        </div>
                    </div>

                    <!-- Guru -->
                    <div id="guru" x-show="activeTab === '#guru'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4">
                        <h2 class="text-3xl font-bold text-blue-900 mb-2">Guru & Karyawan</h2>
                        <div class="w-20 h-1.5 bg-highlight rounded mb-10"></div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach([
                                ['name' => 'Laelatuz Zanuba K, S.Sos', 'sub' => 'Informatika'],
                                ['name' => 'Tiara Adyantika, S.Pd', 'sub' => 'PAI'],
                                ['name' => 'Maria Ulfah, S.Pd', 'sub' => 'Matematika'],
                                ['name' => 'Yogi Septiawan, S.Sos', 'sub' => 'PJOK'],
                                ['name' => 'Suradal, S.T', 'sub' => 'IPA'],
                                ['name' => 'Syarif Toharun, S.E', 'sub' => 'IPS'],
                            ] as $teacher)
                            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all flex flex-col items-center text-center group">
                                <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-600 transition-colors">
                                    <svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <h3 class="font-bold text-gray-800 leading-tight mb-2">{{ $teacher['name'] }}</h3>
                                <span class="text-sm font-medium text-blue-600">{{ $teacher['sub'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>
</div>
@endsection
