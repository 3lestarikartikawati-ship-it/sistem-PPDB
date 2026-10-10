<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PPDB - SMP Muhammadiyah Kaliwiro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        .bg-gradient-primary { background: linear-gradient(135deg, #0f172a 0%, #3b82f6 100%); }
        .text-highlight { color: #fbbf24; }
        .bg-highlight { background-color: #fbbf24; }
        .hover-highlight:hover { background-color: #f59e0b; }
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
            50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
        }
        .animate-bounce-slow { animation: bounce-slow 3s infinite; }
        [x-cloak] { display: none !important; }

        /* === GLOBAL SMOOTH TRANSITIONS === */
        @keyframes pageIn {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .page-transition {
            animation: pageIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes revealUp {
            from { opacity: 0; transform: translateY(40px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes revealLeft {
            from { opacity: 0; transform: translateX(-40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes revealRight {
            from { opacity: 0; transform: translateX(40px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes revealScale {
            from { opacity: 0; transform: scale(0.9); }
            to   { opacity: 1; transform: scale(1); }
        }

        .reveal { opacity: 0; }
        .reveal.revealed { animation: revealUp 0.65s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .reveal-left.revealed { animation: revealLeft 0.65s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .reveal-right.revealed { animation: revealRight 0.65s cubic-bezier(0.22, 1, 0.36, 1) both; }
        .reveal-scale.revealed { animation: revealScale 0.65s cubic-bezier(0.22, 1, 0.36, 1) both; }

        .reveal-stagger > *:nth-child(1) { animation-delay: 0.05s; }
        .reveal-stagger > *:nth-child(2) { animation-delay: 0.12s; }
        .reveal-stagger > *:nth-child(3) { animation-delay: 0.19s; }
        .reveal-stagger > *:nth-child(4) { animation-delay: 0.26s; }
        .reveal-stagger > *:nth-child(5) { animation-delay: 0.33s; }
        .reveal-stagger > *:nth-child(6) { animation-delay: 0.40s; }

        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.1);
        }

        .page-leaving {
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen" x-data="{ lightboxOpen: false, lightboxSrc: '' }">
    
    <!-- Navbar -->
    <nav class="bg-slate-900/95 backdrop-blur-md border-b border-white/10 fixed w-full z-50 top-0 shadow-2xl transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
                        <div class="bg-white p-1.5 rounded-xl group-hover:scale-110 transition-transform duration-300">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo SMP Muhammadiyah Kaliwiro" class="w-10 h-10 object-contain">
                        </div>
                        <span class="font-bold text-xl text-white tracking-tight">SMP Muhammadiyah Kaliwiro</span>
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    @foreach([
                        ['route' => 'beranda', 'label' => 'Beranda'],
                        ['route' => 'profil', 'label' => 'Profil'],
                        ['route' => 'kegiatan', 'label' => 'Kegiatan'],
                        ['route' => 'prestasi', 'label' => 'Prestasi'],
                        ['route' => 'berita', 'label' => 'Berita'],
                        ['route' => 'informasi', 'label' => 'Info Pendaftaran']
                    ] as $item)
                    <a href="{{ route($item['route']) }}" 
                       class="{{ request()->routeIs($item['route']) ? 'text-highlight' : 'text-blue-100' }} hover:text-highlight font-medium transition-colors duration-200 text-sm uppercase tracking-wider">
                        {{ $item['label'] }}
                    </a>
                    @endforeach
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-highlight font-semibold bg-white/10 px-5 py-2 rounded-xl transition">Dashboard</a>
                    @else
                        <div class="relative" x-data="{ loginOpen: false }" @click.away="loginOpen = false">
                            <button @click="loginOpen = !loginOpen" class="text-white hover:text-highlight font-medium transition flex items-center gap-1 focus:outline-none">
                                Login
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': loginOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="loginOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl overflow-hidden py-2 border border-gray-100" style="display: none;">
                                <a href="{{ route('login') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 font-medium transition-colors">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                                        Siswa
                                    </div>
                                </a>
                                <a href="{{ route('login.petugas') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-700 font-medium transition-colors border-t border-gray-50">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        Petugas
                                    </div>
                                </a>
                            </div>
                        </div>
                        <a href="{{ url('/pendaftaran') }}" class="bg-highlight hover:bg-yellow-400 text-blue-900 px-6 py-2.5 rounded-full font-bold shadow-[0_4px_20px_rgba(251,191,36,0.3)] transition transform hover:-translate-y-1">Daftar Sekarang</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-20 relative">
        <!-- Toast Notification (Session Messages) -->
        @if(session('success') || session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" 
                 class="absolute top-4 left-1/2 transform -translate-x-1/2 z-50 flex items-center px-6 py-3 rounded-xl shadow-2xl border text-white font-medium 
                 {{ session('success') ? 'bg-green-500 border-green-600' : 'bg-red-500 border-red-600' }}"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4">
                
                @if(session('success'))
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                @endif
                
                @if(session('error'))
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                @endif
                
                <button @click="show = false" class="ml-4 hover:text-gray-200 focus:outline-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        @endif

        <div class="page-transition">
            @yield('content')
        </div>
    </main>

    <!-- Global Lightbox Modal -->
    <div x-show="lightboxOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-90 p-4"
         style="display: none;"
         @keydown.escape.window="lightboxOpen = false">
        
        <button @click="lightboxOpen = false" class="absolute top-6 right-6 text-white hover:text-gray-300 transition-colors">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <img :src="lightboxSrc" class="max-w-full max-h-full rounded-lg shadow-2xl object-contain" @click.away="lightboxOpen = false">
    </div>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-12">
            <div>
                <h3 class="text-2xl font-bold mb-4 text-highlight">SMP Muhammadiyah Kaliwiro</h3>
                <p class="text-blue-200 leading-relaxed">Membangun generasi unggul yang berakhlak mulia, cerdas, dan siap menghadapi tantangan global.</p>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Tautan Cepat</h4>
                <ul class="space-y-2 text-blue-200">
                    <li><a href="{{ route('beranda') }}" class="hover:text-highlight transition">Beranda</a></li>
                    <li><a href="{{ route('profil') }}" class="hover:text-highlight transition">Profil Sekolah</a></li>
                    <li><a href="{{ route('informasi') }}" class="hover:text-highlight transition">Informasi Pendaftaran</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-bold mb-4">Kontak Kami</h4>
                <p class="text-blue-200 mb-2">Jl. Kauman No. 1, Kaliwiro, Wonosobo</p>
                <p class="text-blue-200 mb-2">Telp: 082224215722</p>
                <p class="text-blue-200">Email: info@smpmkaliwiro.sch.id</p>
            </div>
        </div>
        <div class="border-t border-blue-800 mt-12 pt-8 text-center text-blue-300">
            &copy; {{ date('Y') }} SMP Muhammadiyah Kaliwiro. All rights reserved.
        </div>
    </footer>

    {{-- Global Smooth Transition Engine --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // === Scroll-triggered Reveal ===
        var allReveal = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
        if (allReveal.length > 0) {
            var obs = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });
            allReveal.forEach(function(el) { obs.observe(el); });
        }

        // === Auto-detect sections for reveal ===
        var selectors = [
            'main section',
            'main .bg-white',
            'main .bg-gray-50',
            'main .rounded-2xl',
            'main .rounded-3xl',
            'main .grid > div',
            'main .space-y-6 > div',
            'main .space-y-8 > div',
            'main .mb-16',
            'main .mb-20',
            'main .py-16',
            'main .py-20',
            'main .py-24'
        ];
        var autoEls = document.querySelectorAll(selectors.join(', '));
        var delay = 0;
        var autoObs = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var d = parseFloat(entry.target.getAttribute('data-reveal-delay') || '0');
                    entry.target.style.animation = 'revealUp 0.6s cubic-bezier(0.22,1,0.36,1) ' + d + 's both';
                    autoObs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.05 });
        autoEls.forEach(function(el, i) {
            if (!el.classList.contains('reveal') && !el.classList.contains('revealed')) {
                el.style.opacity = '0';
                el.setAttribute('data-reveal-delay', (Math.min(i * 0.06, 0.3)).toFixed(2));
                autoObs.observe(el);
            }
        });

        // === Smooth page-leave transition ===
        var pageContent = document.querySelector('.page-transition');
        document.querySelectorAll('a[href]').forEach(function(link) {
            if (link.hostname !== window.location.hostname) return;
            if (link.getAttribute('href').startsWith('#')) return;
            if (link.getAttribute('target') === '_blank') return;
            if (link.closest('form')) return;

            link.addEventListener('click', function(e) {
                var href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;
                e.preventDefault();
                if (pageContent) pageContent.classList.add('page-leaving');
                setTimeout(function() { window.location.href = href; }, 250);
            });
        });
    });
    </script>
</body>
</html>
