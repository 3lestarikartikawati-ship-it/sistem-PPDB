<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil - SMP Muhammadiyah Kaliwiro</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-gradient-primary { background: linear-gradient(135deg, #0f172a 0%, #3b82f6 100%); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex items-center justify-center p-4">

<div class="w-full max-w-3xl">
    <!-- Logo -->
    <div class="text-center mb-8">
        <a href="{{ url('/') }}" class="inline-block">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-20 h-20 mx-auto mb-4 drop-shadow-md hover:scale-110 transition-transform">
        </a>
        <h1 class="text-2xl font-bold text-blue-900 tracking-tight">SMP Muhammadiyah Kaliwiro</h1>
    </div>

    <div class="bg-white overflow-hidden shadow-2xl rounded-[2.5rem] border border-gray-100 text-center relative">
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-primary"></div>
        
        <div class="relative z-10 pt-16 px-8 pb-12">
            <div class="w-24 h-24 bg-white rounded-full mx-auto flex items-center justify-center shadow-lg border-4 border-white mb-6">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            
            <h2 class="text-3xl font-black text-gray-900 mb-2">Pendaftaran Berhasil!</h2>
            <p class="text-gray-600 mb-8">Terima kasih, <span class="font-bold">{{ $nama }}</span>. Data pendaftaran Anda telah kami terima.</p>
            
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-8 mb-8 text-left max-w-md mx-auto relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-full blur-3xl opacity-50 -mt-10 -mr-10"></div>
                
                <h3 class="text-blue-900 font-bold mb-4 text-center border-b border-blue-200 pb-3">Informasi Login Anda</h3>
                <p class="text-sm text-gray-600 mb-6 text-center">Harap simpan informasi di bawah ini. Anda membutuhkannya untuk masuk ke Dashboard Siswa.</p>
                
                <div class="space-y-4 relative z-10">
                    <div>
                        <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Username (NISN)</span>
                        <div class="bg-white border border-gray-200 px-4 py-3 rounded-xl font-mono text-lg font-bold text-gray-800 shadow-sm flex justify-between items-center">
                            <span id="nisnVal">{{ $nisn }}</span>
                            <button onclick="navigator.clipboard.writeText('{{ $nisn }}'); alert('NISN disalin!')" class="text-blue-500 hover:text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Password (Tgl Lahir)</span>
                        <div class="bg-white border border-gray-200 px-4 py-3 rounded-xl font-mono text-lg font-bold text-gray-800 shadow-sm flex justify-between items-center">
                            <span id="passVal">{{ $password }}</span>
                            <button onclick="navigator.clipboard.writeText('{{ $password }}'); alert('Password disalin!')" class="text-blue-500 hover:text-blue-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg transition transform hover:-translate-y-0.5">
                    Login Sekarang
                </a>
                <a href="{{ url('/') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-8 py-3.5 rounded-xl font-bold transition">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
