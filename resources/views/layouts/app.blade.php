<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - SMP Muhammadiyah Kaliwiro</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; scroll-behavior: smooth; }
        .bg-gradient-primary { background: linear-gradient(135deg, #0f172a 0%, #3b82f6 100%); }
        .text-highlight { color: #fbbf24; }
        .bg-highlight { background-color: #fbbf24; }
        .hover-highlight:hover { background-color: #f59e0b; }

        /* === GLOBAL SMOOTH TRANSITIONS === */

        /* Page Load Fade-in */
        @keyframes pageIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .page-transition {
            animation: pageIn 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        /* Scroll-triggered Reveal Animation */
        @keyframes revealUp {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }
        .reveal {
            opacity: 0;
        }
        .reveal.revealed {
            animation: revealUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        /* Stagger delays for child items */
        .reveal-stagger > .reveal:nth-child(1) { animation-delay: 0.05s; }
        .reveal-stagger > .reveal:nth-child(2) { animation-delay: 0.10s; }
        .reveal-stagger > .reveal:nth-child(3) { animation-delay: 0.15s; }
        .reveal-stagger > .reveal:nth-child(4) { animation-delay: 0.20s; }
        .reveal-stagger > .reveal:nth-child(5) { animation-delay: 0.25s; }
        .reveal-stagger > .reveal:nth-child(6) { animation-delay: 0.30s; }
        .reveal-stagger > .reveal:nth-child(7) { animation-delay: 0.35s; }
        .reveal-stagger > .reveal:nth-child(8) { animation-delay: 0.40s; }

        /* Enhanced hover lift for cards */
        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.22, 1, 0.36, 1), box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        /* Smooth link/button press */
        .press-effect {
            transition: transform 0.15s ease;
        }
        .press-effect:active {
            transform: scale(0.97);
        }

        /* Fade-out for page navigation */
        .page-leaving {
            opacity: 0;
            transform: translateY(-8px);
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        /* Smooth skeleton pulse for content loading */
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
    </style>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Backdrop (Mobile) -->
        <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gradient-primary text-white overflow-hidden lg:translate-x-0 lg:static lg:inset-0 flex flex-col relative border-r border-white/5">
            <!-- Background Glow Ornaments -->
            <div class="absolute inset-0 bg-black opacity-15 pointer-events-none"></div>
            <div class="absolute -left-20 -top-20 w-48 h-48 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -right-20 -bottom-20 w-48 h-48 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col h-full flex-grow">
                <!-- Logo Section -->
                <div class="flex items-center justify-center py-6 border-b border-white/10 shrink-0">
                    <a href="{{ route('beranda') }}" class="flex flex-col items-center gap-2.5">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo SMP" class="w-16 h-16 object-contain p-1.5 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-[0_0_15px_rgba(251,191,36,0.2)]">
                        <span class="text-white font-black text-sm text-center px-4 tracking-tight leading-tight">SMP Muhammadiyah<br>Kaliwiro</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-6 flex-grow px-4 space-y-2 overflow-y-auto pb-6">
                    @if(auth()->user()->role === 'admin')
                        <div class="text-[10px] font-black text-highlight uppercase tracking-widest mb-2 mt-4 px-3 opacity-90">Main Menu</div>
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        
                        <div class="text-[10px] font-black text-highlight uppercase tracking-widest mb-2 mt-6 px-3 opacity-90">Pendaftaran</div>
                        <a href="{{ route('admin.students.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.students.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Kelola Pendaftar (PPDB)
                        </a>

                        <div class="text-[10px] font-black text-highlight uppercase tracking-widest mb-2 mt-6 px-3 opacity-90">Manajemen Kelas</div>
                        <a href="{{ route('admin.active_students.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.active_students.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Data Siswa Aktif
                        </a>

                        <a href="{{ route('admin.classes.index') }}" class="flex items-center px-4 py-3 mt-1 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.classes.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Pembagian Kelas
                        </a>

                        <div class="text-[10px] font-black text-highlight uppercase tracking-widest mb-2 mt-6 px-3 opacity-90">Website</div>
                        <a href="{{ route('admin.contents.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.contents.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Manajemen Konten
                        </a>

                        <div class="text-[10px] font-black text-highlight uppercase tracking-widest mb-2 mt-6 px-3 opacity-90">Sistem</div>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Pengaturan PPDB
                        </a>

                        <a href="{{ route('admin.faqs.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.faqs.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Manajemen FAQ
                        </a>

                        <a href="{{ route('admin.messages.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.messages.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            Pesan Masuk
                        </a>
                    @elseif(auth()->user()->role === 'bendahara')
                        <a href="{{ route('bendahara.dashboard') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('bendahara.dashboard') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Dashboard Keuangan
                        </a>
                        <a href="{{ route('bendahara.payments.index') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('bendahara.payments.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Kelola Pembayaran Siswa
                        </a>
                        <a href="{{ route('bendahara.settings.index') }}" class="flex items-center px-4 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('bendahara.settings.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Rincian Biaya
                        </a>
                    @else
                        <div class="text-[10px] font-black text-highlight uppercase tracking-widest mb-2 mt-4 px-3 opacity-90">Main Menu</div>
                        <a href="{{ route('siswa.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('siswa.dashboard') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Dashboard
                        </a>
                        

                        <!-- Daftar Ulang Link -->
                        <a href="{{ route('siswa.daftar_ulang.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('siswa.daftar_ulang.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Daftar Ulang
                        </a>

                        <a href="{{ route('siswa.messages.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('siswa.messages.*') ? 'bg-white/15 text-white font-black border border-white/10 shadow-inner' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                            Tanya Panitia
                        </a>
                    @endif
                </nav>

                <!-- User Info Sidebar Footer -->
                <div class="p-4 bg-black/20 border-t border-white/10 shrink-0">
                    <div class="flex items-center px-2 py-2">
                        <div class="w-10 h-10 rounded-full bg-highlight text-blue-900 flex items-center justify-center font-black text-lg uppercase shadow-[0_0_15px_rgba(251,191,36,0.3)] shrink-0">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3 overflow-hidden">
                            <p class="text-sm font-black text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs font-semibold text-white/80 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-bold text-red-200 bg-red-500/20 border border-red-500/30 rounded-xl hover:bg-red-600 hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Header -->
            <header class="bg-white shadow-sm z-10 flex items-center justify-between px-6 py-4 lg:hidden">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <span class="ml-4 font-bold text-xl text-blue-900">Portal PPDB</span>
                </div>
            </header>

            <!-- Page Header (Optional slot provided by views) -->
            @isset($header)
                <div class="bg-white shadow-sm hidden lg:block z-10">
                    <div class="max-w-7xl mx-auto py-5 px-8">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50" style="scroll-behavior: smooth;">
                <div class="lg:hidden p-4">
                    @isset($header)
                        {{ $header }}
                    @endisset
                </div>
                <div class="page-transition">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
    <!-- Global Toast Notification -->
    <div x-data="{ 
            show: false, 
            message: '',
            type: 'success',
            init() {
                @if (session('success'))
                    this.message = '{{ session('success') }}';
                    this.type = 'success';
                    this.trigger();
                @elseif (session('error'))
                    this.message = '{{ session('error') }}';
                    this.type = 'error';
                    this.trigger();
                @endif
            },
            trigger() {
                setTimeout(() => {
                    this.show = true;
                    setTimeout(() => { this.show = false }, 5000);
                }, 500);
            }
         }"
         x-show="show"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-x-12 scale-90"
         x-transition:enter-end="opacity-100 translate-x-0 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-12"
         :class="type === 'success' ? 'bg-emerald-600 shadow-[0_20px_60px_rgba(16,185,129,0.5)]' : 'bg-red-600 shadow-[0_20px_60px_rgba(220,38,38,0.5)]'"
         class="fixed bottom-8 right-8 z-[100] max-w-sm w-full text-white rounded-2xl overflow-hidden border border-white/20"
         style="display: none;">
        <div class="p-5 flex items-center gap-4">
            <div class="bg-white/20 p-2.5 rounded-xl shadow-inner">
                <template x-if="type === 'success'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </template>
                <template x-if="type === 'error'">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </template>
            </div>
            <div class="flex-1">
                <p class="font-black text-sm uppercase tracking-widest mb-0.5" x-text="type === 'success' ? 'Berhasil!' : 'Perhatian!'"></p>
                <p class="text-[13px] font-medium leading-tight opacity-90" x-text="message"></p>
            </div>
            <button @click="show = false" class="bg-white/10 hover:bg-white/20 p-1.5 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <!-- Progress Bar -->
        <div class="h-1.5 w-full" :class="type === 'success' ? 'bg-emerald-700/50' : 'bg-red-700/50'">
            <div class="h-full bg-white/40 transition-all duration-[5000ms] ease-linear" :class="show ? 'w-0' : 'w-full'"></div>
        </div>
    </div>

    {{-- Global Smooth Transition Engine --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // === Scroll-triggered Reveal Animations ===
        const revealElements = document.querySelectorAll('.reveal');
        if (revealElements.length > 0) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
            revealElements.forEach(function(el) { observer.observe(el); });
        }

        // === Auto-detect cards/sections for reveal ===
        var autoRevealSelectors = [
            'main .bg-white.rounded-3xl',
            'main .bg-white.rounded-2xl',
            'main .bg-white.rounded-xl',
            'main .bg-gradient-to-r',
            'main .bg-gradient-to-br',
            'main .overflow-hidden.rounded',
            'main table',
            'main form'
        ];
        var autoCards = document.querySelectorAll(autoRevealSelectors.join(', '));
        var autoObserver = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'revealUp 0.55s cubic-bezier(0.22,1,0.36,1) both';
                    entry.target.style.animationDelay = (Math.random() * 0.1).toFixed(2) + 's';
                    autoObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.05 });
        autoCards.forEach(function(el) {
            if (!el.classList.contains('reveal')) {
                el.style.opacity = '0';
                autoObserver.observe(el);
            }
        });

        // === Smooth page-leave transition for internal links ===
        var pageContent = document.querySelector('.page-transition');
        document.querySelectorAll('a[href]').forEach(function(link) {
            // Skip external links, anchors, new tabs, and special actions
            if (link.hostname !== window.location.hostname) return;
            if (link.getAttribute('href').startsWith('#')) return;
            if (link.getAttribute('target') === '_blank') return;
            if (link.closest('form')) return;

            link.addEventListener('click', function(e) {
                var href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;

                e.preventDefault();
                if (pageContent) {
                    pageContent.classList.add('page-leaving');
                }
                setTimeout(function() {
                    window.location.href = href;
                }, 200);
            });
        });
    });
    </script>
    @stack('scripts')
</body>
</html>
