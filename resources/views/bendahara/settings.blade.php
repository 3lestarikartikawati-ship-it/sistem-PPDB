<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Rincian Biaya Item') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Flash Success --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
                    <svg class="w-6 h-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                {{-- Header Banner --}}
                <div class="bg-gradient-primary p-8 md:p-10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="relative z-10 flex items-center gap-5">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-[0_0_15px_rgba(251,191,36,0.3)] shrink-0">
                            <svg class="w-7 h-7 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-white">Konfigurasi Rincian Biaya</h3>
                            <p class="text-sm text-white/90 mt-1 font-medium">Atur nominal biaya Infak, LKS, dan Seragam untuk siswa.</p>
                        </div>
                    </div>
                </div>

                {{-- Form --}}
                <form action="{{ route('bendahara.settings.update') }}" method="POST" class="p-8">
                    @csrf
                    <div class="space-y-8">

                        {{-- Infak --}}
                        <div>
                            <h4 class="text-sm font-black text-blue-900 uppercase tracking-widest mb-6 pb-2 border-b-2 border-blue-100">Biaya Infak</h4>
                            <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-12">
                                <div class="md:w-1/3">
                                    <label for="biaya_infak" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-1">Infak (6 Bulan)</label>
                                    <p class="text-[10px] text-gray-400 font-medium">Total biaya infak untuk 6 bulan.</p>
                                </div>
                                <div class="md:w-2/3">
                                    <input type="number" name="biaya_infak" id="biaya_infak" value="{{ $settings['biaya_infak'] ?? 180000 }}" 
                                           class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                </div>
                            </div>
                        </div>

                        {{-- LKS per Kelas --}}
                        <div class="pt-4">
                            <h4 class="text-sm font-black text-blue-900 uppercase tracking-widest mb-6 pb-2 border-b-2 border-blue-100">Biaya LKS per Kelas</h4>
                            <div class="space-y-8">
                                @foreach(['7' => 'Kelas 7', '8' => 'Kelas 8', '9' => 'Kelas 9'] as $kelas => $label)
                                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-12">
                                    <div class="md:w-1/3">
                                        <label for="biaya_lk_{{ $kelas }}" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-1">LKS {{ $label }}</label>
                                        <p class="text-[10px] text-gray-400 font-medium">Biaya LKS untuk siswa {{ $label }}.</p>
                                    </div>
                                    <div class="md:w-2/3">
                                        @php $defaults = ['7' => 157000, '8' => 154000, '9' => 275000]; @endphp
                                        <input type="number" name="biaya_lk_{{ $kelas }}" id="biaya_lk_{{ $kelas }}" 
                                               value="{{ $settings['biaya_lk_'.$kelas] ?? $defaults[$kelas] }}" 
                                               class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                    </div>
                                </div>
                                @if(!$loop->last)<hr class="border-gray-50">@endif
                                @endforeach
                            </div>
                        </div>

                        {{-- Seragam (4 Jenis) --}}
                        <div class="pt-4">
                            <h4 class="text-sm font-black text-blue-900 uppercase tracking-widest mb-6 pb-2 border-b-2 border-blue-100">Biaya Seragam (4 Jenis)</h4>
                            <div class="space-y-8">
                                @php
                                    $seragamItems = [
                                        'biaya_seragam_osis' => ['label' => 'Seragam OSIS', 'desc' => 'Biaya seragam OSIS per siswa.', 'default' => 0],
                                        'biaya_seragam_olahraga' => ['label' => 'Seragam Olahraga', 'desc' => 'Biaya seragam olahraga per siswa.', 'default' => 0],
                                        'biaya_seragam_batik' => ['label' => 'Seragam Batik', 'desc' => 'Biaya seragam batik per siswa.', 'default' => 0],
                                        'biaya_seragam_identitas' => ['label' => 'Seragam Identitas', 'desc' => 'Biaya seragam identitas per siswa.', 'default' => 0],
                                    ];
                                @endphp
                                @foreach($seragamItems as $key => $item)
                                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-12">
                                    <div class="md:w-1/3">
                                        <label for="{{ $key }}" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-1">{{ $item['label'] }}</label>
                                        <p class="text-[10px] text-gray-400 font-medium">{{ $item['desc'] }}</p>
                                    </div>
                                    <div class="md:w-2/3">
                                        <input type="number" name="{{ $key }}" id="{{ $key }}" value="{{ $settings[$key] ?? $item['default'] }}" 
                                               class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                    </div>
                                </div>
                                @if(!$loop->last)<hr class="border-gray-50">@endif
                                @endforeach
                            </div>
                            <div class="mt-4 p-4 bg-amber-50 border border-amber-100 rounded-2xl">
                                <p class="text-xs font-bold text-amber-700">💡 Total dari keempat jenis seragam akan menjadi target biaya seragam siswa.</p>
                            </div>
                        </div>

                    </div>

                    {{-- Save Button --}}
                    <div class="mt-10 flex justify-end">
                        <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-10 rounded-2xl shadow-xl shadow-blue-500/25 transition-all duration-200 hover:shadow-2xl hover:shadow-blue-500/40 hover:-translate-y-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
