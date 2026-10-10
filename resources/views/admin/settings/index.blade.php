<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Pengaturan Sistem PPDB') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100">
                <div class="bg-gradient-primary p-8 md:p-10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="relative z-10 flex items-center gap-5">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-[0_0_15px_rgba(251,191,36,0.3)] shrink-0">
                            <svg class="w-7 h-7 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-white">Konfigurasi PPDB</h3>
                            <p class="text-sm text-white/90 mt-1 font-medium">Atur kuota dan jadwal pendaftaran untuk tahun ajaran ini.</p>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf
                    <div class="space-y-8">
                        @php
                            $systemSettings = $settings->filter(fn($s) => !str_starts_with($s->key, 'kepsek_') && !str_starts_with($s->key, 'sekolah_') && !str_starts_with($s->key, 'jalur_'));
                            $identitySettings = $settings->filter(fn($s) => str_starts_with($s->key, 'kepsek_') || str_starts_with($s->key, 'sekolah_'));
                            $jalurSettings = $settings->filter(fn($s) => str_starts_with($s->key, 'jalur_'));
                        @endphp

                        <!-- Jadwal & Kuota -->
                        <div>
                            <h4 class="text-sm font-black text-blue-900 uppercase tracking-widest mb-6 pb-2 border-b-2 border-blue-100">Jadwal & Kuota PPDB</h4>
                            <div class="space-y-8">
                                @foreach($systemSettings as $setting)
                                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-12">
                                    <div class="md:w-1/3">
                                        <label for="{{ $setting->key }}" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-1">
                                            {{ $setting->name }}
                                        </label>
                                        <p class="text-[10px] text-gray-400 font-medium">Update secara berkala sesuai kebijakan sekolah.</p>
                                    </div>
                                    <div class="md:w-2/3">
                                        @if($setting->type == 'number')
                                            <input type="number" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ $setting->value }}" 
                                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                        @elseif($setting->type == 'date')
                                            <input type="date" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ $setting->value }}" 
                                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                        @elseif($setting->type == 'boolean')
                                            <select name="{{ $setting->key }}" id="{{ $setting->key }}" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                                <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Aktif / Wajib</option>
                                                <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Nonaktif / Tidak Wajib</option>
                                            </select>
                                        @else
                                            <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ $setting->value }}" 
                                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                        @endif
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="border-gray-50">
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Pengaturan Jalur Pendaftaran & Dokumen -->
                        <div class="pt-8">
                            <h4 class="text-sm font-black text-blue-900 uppercase tracking-widest mb-6 pb-2 border-b-2 border-blue-100">Pengaturan Jalur & Dokumen Pendaftaran</h4>
                            <div class="space-y-8">
                                @foreach($jalurSettings as $setting)
                                <div class="flex flex-col md:flex-row md:items-center gap-4 md:gap-12">
                                    <div class="md:w-1/3">
                                        <label for="{{ $setting->key }}" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-1">
                                            {{ $setting->name }}
                                        </label>
                                        <p class="text-[10px] text-gray-400 font-medium">Buka/Tutup Jalur atau ubah kelengkapan dokumen.</p>
                                    </div>
                                    <div class="md:w-2/3">
                                        <select name="{{ $setting->key }}" id="{{ $setting->key }}" class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                            <option value="1" {{ $setting->value == '1' ? 'selected' : '' }}>Aktif / Wajib</option>
                                            <option value="0" {{ $setting->value == '0' ? 'selected' : '' }}>Nonaktif / Tidak Wajib</option>
                                        </select>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="border-gray-50">
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Identitas Sekolah & Kepala Sekolah -->
                        <div class="pt-8">
                            <h4 class="text-sm font-black text-blue-900 uppercase tracking-widest mb-6 pb-2 border-b-2 border-blue-100">Identitas Cetak & Kepala Sekolah</h4>
                            <div class="space-y-8">
                                @foreach($identitySettings as $setting)
                                <div class="flex flex-col md:flex-row md:items-start gap-4 md:gap-12">
                                    <div class="md:w-1/3 pt-2">
                                        <label for="{{ $setting->key }}" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-1">
                                            {{ $setting->name }}
                                        </label>
                                        <p class="text-[10px] text-gray-400 font-medium">Ditampilkan pada Kuitansi dan SK Kelulusan.</p>
                                    </div>
                                    <div class="md:w-2/3">
                                        @if($setting->type == 'file')
                                            <div class="flex flex-col gap-3">
                                                @if($setting->value)
                                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 inline-block">
                                                        <p class="text-[10px] text-gray-500 font-bold mb-2 uppercase tracking-widest">Gambar Saat Ini:</p>
                                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->name }}" class="h-24 object-contain">
                                                    </div>
                                                @endif
                                                <input type="file" name="{{ $setting->key }}" id="{{ $setting->key }}" accept="image/*"
                                                       class="w-full border border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                                <p class="text-[10px] text-gray-500 italic">Gunakan gambar PNG transparan untuk hasil cetak yang baik.</p>
                                            </div>
                                        @else
                                            <input type="text" name="{{ $setting->key }}" id="{{ $setting->key }}" value="{{ $setting->value }}" 
                                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                        @endif
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="border-gray-50">
                                @endif
                                @endforeach
                            </div>
                        </div>

                    </div>
                </form>

                <!-- Footer Buttons (Outside Form to allow separate Reset Form) -->
                <div class="p-8 bg-gray-50/30 border-t border-gray-50 flex items-center justify-end gap-4">
                    <form action="{{ route('admin.settings.reset') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan semua jadwal dan kuota? Ini akan menyembunyikan jadwal dari halaman depan.')">
                        @csrf
                        <button type="submit" class="px-6 py-3 rounded-2xl font-bold text-red-500 hover:bg-red-50 transition">
                            Kosongkan Jadwal
                        </button>
                    </form>
                    <button type="submit" form="settings-form" class="bg-highlight hover:bg-yellow-400 text-blue-900 px-10 py-4 rounded-2xl font-black shadow-[0_5px_15px_rgba(251,191,36,0.3)] transition-all active:scale-95 flex items-center gap-3 text-xs tracking-wider uppercase">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mt-8 bg-amber-50 rounded-[2rem] p-6 border border-amber-100 flex items-start gap-4 shadow-md">
                <div class="p-3 bg-amber-500 text-white rounded-2xl shadow-[0_0_15px_rgba(245,158,11,0.4)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-black text-amber-900 uppercase tracking-widest text-xs mb-1">Catatan Penting</h4>
                    <p class="text-sm text-amber-800 leading-relaxed font-medium">Perubahan pada **Kuota Pendaftaran** akan langsung berdampak pada bilah progres di Dashboard Utama. Pastikan **Tanggal Selesai** diatur setelah **Tanggal Mulai** untuk menghindari kesalahan sistem pada Landing Page.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
