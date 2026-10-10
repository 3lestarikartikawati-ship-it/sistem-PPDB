<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-blue-500 mb-2">Daftar Akun Baru</h2>
        <p class="text-gray-400 text-sm font-medium">Buat akun untuk memulai proses pendaftaran siswa baru.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div class="space-y-1.5">
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <x-text-input id="name" class="block w-full pl-11 py-2.5 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap calon siswa" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="space-y-1.5 mt-5">
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="email" class="block w-full pl-11 py-2.5 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Alamat email aktif" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- No HP -->
        <div class="space-y-1.5 mt-5">
            <x-input-label for="no_hp" value="No. WhatsApp / HP Aktif" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <x-text-input id="no_hp" class="block w-full pl-11 py-2.5 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors" type="text" name="no_hp" :value="old('no_hp')" required placeholder="Contoh: 08123456789" />
            </div>
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5 mt-5">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full pl-11 py-2.5 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="Minimal 8 karakter" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-1.5 mt-5">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password_confirmation" class="block w-full pl-11 py-2.5 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-6">
            <button type="submit" class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-xl shadow-[0_4px_14px_0_rgba(59,130,246,0.39)] text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all transform hover:-translate-y-0.5 active:scale-95">
                {{ __('Daftar Sekarang') }}
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </button>
        </div>

        <div class="relative flex items-center justify-center my-6">
            <hr class="w-full border-gray-300">
            <span class="absolute px-3 bg-white text-gray-500 text-sm font-medium">ATAU</span>
        </div>

        <div>
            <a href="{{ route('auth.google.redirect') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-xl shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition transform hover:-translate-y-0.5 active:scale-95">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Daftar dengan Google
            </a>
        </div>

        <div class="mt-6 text-center pt-4 border-t border-gray-100">
            <p class="text-gray-600 text-sm">Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Login di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>
