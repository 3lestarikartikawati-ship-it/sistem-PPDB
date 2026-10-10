<x-guest-layout>
    <div class="mb-3 text-center">
        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <h2 class="text-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-blue-500 mb-0.5">Login Siswa</h2>
        <p class="text-gray-400 text-[11px] font-medium">Masuk menggunakan NISN dan Tanggal Lahir Anda</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->has('identifier') || $errors->has('password'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline text-sm">NISN atau Password yang Anda masukkan tidak sesuai.</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="login_type" value="siswa">

        <!-- NISN -->
        <div class="space-y-1.5">
            <x-input-label for="identifier" value="NISN" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                </div>
                <x-text-input id="identifier" class="block w-full pl-10 py-2 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors text-sm" type="text" name="identifier" :value="old('identifier')" required autofocus autocomplete="username" placeholder="Masukkan NISN" maxlength="10" />
            </div>
        </div>

        <!-- Password (Tanggal Lahir) -->
        <div class="space-y-1.5">
            <x-input-label for="password" value="Password (Tanggal Lahir)" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full pl-10 py-2 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors text-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Contoh: 2008-12-31" />
            </div>
        </div>

        <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-xl shadow-[0_4px_14px_0_rgba(59,130,246,0.39)] text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5 active:scale-95">
                {{ __('Masuk') }}
                <svg class="ml-2 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

        <div class="mt-4 text-center pt-3 border-t border-gray-100">
            <p class="text-gray-600 text-[12px] mb-2">Belum mendaftar? 
                <a href="{{ url('/pendaftaran') }}" class="text-blue-600 font-bold hover:underline">Daftar di sini</a>
            </p>
            <p class="text-gray-400 text-[11px]">
                <a href="{{ route('login', ['type' => 'petugas']) }}" class="text-gray-500 hover:text-blue-600 font-medium transition">Login sebagai Petugas →</a>
            </p>
        </div>
    </form>
</x-guest-layout>
