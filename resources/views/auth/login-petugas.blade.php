<x-guest-layout>
    <div class="mb-3 text-center">
        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-2">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
        </div>
        <h2 class="text-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-orange-500 mb-0.5">Login Petugas</h2>
        <p class="text-gray-400 text-[11px] font-medium">Khusus Admin dan Bendahara</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if ($errors->has('identifier'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline text-sm">{{ $errors->first('identifier') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="login_type" value="petugas">

        <!-- Email -->
        <div class="space-y-1.5">
            <x-input-label for="identifier" value="Email" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <x-text-input id="identifier" class="block w-full pl-10 py-2 border-gray-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors text-sm" type="email" name="identifier" :value="old('identifier')" required autofocus autocomplete="username" placeholder="Masukkan email" />
            </div>
            <x-input-error :messages="$errors->get('identifier')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-1.5">
            <x-input-label for="password" value="Password" class="text-gray-700 font-bold text-sm" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <x-text-input id="password" class="block w-full pl-10 py-2 border-gray-200 focus:border-amber-500 focus:ring-amber-500 rounded-xl bg-gray-50/50 hover:bg-gray-50 transition-colors text-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Masukkan password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="w-full flex justify-center items-center py-2.5 px-4 border border-transparent rounded-xl shadow-[0_4px_14px_0_rgba(245,158,11,0.39)] text-sm font-bold text-white bg-gradient-to-r from-amber-600 to-orange-500 hover:from-amber-700 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all transform hover:-translate-y-0.5 active:scale-95">
                {{ __('Masuk') }}
                <svg class="ml-2 w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>

    </form>
</x-guest-layout>
