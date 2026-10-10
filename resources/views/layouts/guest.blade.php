<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Inter', sans-serif; }
            .bg-gradient-primary { background: linear-gradient(135deg, #0f172a 0%, #3b82f6 100%); }
            .text-highlight { color: #fbbf24; }
            .bg-highlight { background-color: #fbbf24; }
            .hover-highlight:hover { background-color: #f59e0b; }

            /* Login card entrance animation */
            @keyframes cardIn {
                from { opacity: 0; transform: translateY(30px) scale(0.96); }
                to   { opacity: 1; transform: translateY(0) scale(1); }
            }
            .card-entrance {
                animation: cardIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) 0.15s both;
            }

            /* Background fade-in */
            @keyframes bgFade {
                from { opacity: 0; }
                to   { opacity: 1; }
            }
            .bg-entrance {
                animation: bgFade 0.8s ease both;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-4 relative overflow-hidden">
            <!-- Background Image - Clearer and less blurred -->
            <div class="fixed inset-0 z-0 bg-entrance">
                <img src="{{ asset('images/gambar sekolah.png') }}" class="w-full h-full object-cover" alt="Background Sekolah">
                <div class="absolute inset-0 bg-black/30"></div> <!-- Subtle dark overlay -->
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-blue-950/20 to-blue-950/60"></div>
            </div>

            <!-- Glow Effect Behind Card -->
            <div class="absolute w-full sm:max-w-[420px] h-[500px] bg-blue-500/20 blur-[100px] rounded-full z-0 pointer-events-none"></div>

            <!-- Compact Login Card -->
            <div class="w-full sm:max-w-[420px] bg-white/95 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,0.15)] rounded-[2rem] z-10 overflow-hidden card-entrance relative border border-white/50">
                <!-- Top Gradient Accent -->
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-600 via-blue-400 to-yellow-400"></div>
                <div class="px-6 py-6">
                    <!-- Compact Branding -->
                    <div class="text-center mb-4">
                        <a href="/">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-12 h-12 mx-auto mb-2 drop-shadow-md">
                        </a>
                        <h1 class="text-xl font-bold text-blue-900 tracking-tight leading-none mb-1">PPDB ONLINE</h1>
                        <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest">SMP Muhammadiyah Kaliwiro</p>
                    </div>

                    {{ $slot }}
                </div>
            </div>
            
            <div class="mt-8 text-center z-10">
                <p class="text-white text-xs font-medium drop-shadow-md">&copy; {{ date('Y') }} SMP Muhammadiyah Kaliwiro</p>
            </div>
        </div>
    </body>
</html>
