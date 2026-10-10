<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Pengaturan Keuangan Sekolah') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100 mb-10">
                <div class="bg-gradient-primary p-8 md:p-10 relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="relative z-10 flex items-center gap-5">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-[0_0_15px_rgba(251,191,36,0.3)] shrink-0">
                            <svg class="w-7 h-7 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-white">Konfigurasi Keuangan</h3>
                            <p class="text-sm text-white/90 mt-1 font-medium">Atur rekening bank penerima dan QRIS resmi sekolah. Perubahan akan langsung tampil di halaman pembayaran siswa.</p>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <form id="settings-form" action="{{ route('bendahara.settings.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                    @csrf

                    @php
                        $s = $settings->pluck('value', 'key');
                    @endphp

                    {{-- ==================== BANK 1 (UTAMA) ==================== --}}
                    <div class="mb-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-xl flex items-center justify-center font-black text-sm shadow-md">1</div>
                            <div>
                                <h4 class="font-black text-gray-800 text-lg">Rekening Bank Utama</h4>
                                <p class="text-[11px] text-gray-400 font-medium">Rekening utama yang ditampilkan pertama di halaman siswa.</p>
                            </div>
                        </div>
                        <div class="space-y-5 pl-4 border-l-4 border-blue-100 ml-4">
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_bank" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">Nama Bank</label>
                                <input type="text" name="payment_bank" id="payment_bank" value="{{ $s['payment_bank'] ?? '' }}" placeholder="Contoh: Bank Syariah Indonesia (BSI)"
                                       class="flex-1 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_rekening" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">No. Rekening</label>
                                <input type="text" name="payment_rekening" id="payment_rekening" value="{{ $s['payment_rekening'] ?? '' }}" placeholder="Contoh: 7149028882"
                                       class="flex-1 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50 font-mono">
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_penerima" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">Atas Nama</label>
                                <input type="text" name="payment_penerima" id="payment_penerima" value="{{ $s['payment_penerima'] ?? '' }}" placeholder="Contoh: Panitia PPDB"
                                       class="flex-1 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-8">

                    {{-- ==================== BANK 2 ==================== --}}
                    <div class="mb-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-emerald-600 text-white rounded-xl flex items-center justify-center font-black text-sm shadow-md">2</div>
                            <div>
                                <h4 class="font-black text-gray-800 text-lg">Rekening Bank Kedua</h4>
                                <p class="text-[11px] text-gray-400 font-medium">Opsional. Kosongkan jika hanya menggunakan 1 bank.</p>
                            </div>
                        </div>
                        <div class="space-y-5 pl-4 border-l-4 border-emerald-100 ml-4">
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_bank_2" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">Nama Bank</label>
                                <input type="text" name="payment_bank_2" id="payment_bank_2" value="{{ $s['payment_bank_2'] ?? '' }}" placeholder="Contoh: Bank BRI"
                                       class="flex-1 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_rekening_2" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">No. Rekening</label>
                                <input type="text" name="payment_rekening_2" id="payment_rekening_2" value="{{ $s['payment_rekening_2'] ?? '' }}" placeholder="Contoh: 1234567890"
                                       class="flex-1 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50 font-mono">
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_penerima_2" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">Atas Nama</label>
                                <input type="text" name="payment_penerima_2" id="payment_penerima_2" value="{{ $s['payment_penerima_2'] ?? '' }}" placeholder="Contoh: Panitia PPDB"
                                       class="flex-1 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-8">

                    {{-- ==================== BANK 3 ==================== --}}
                    <div class="mb-10">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-amber-500 text-white rounded-xl flex items-center justify-center font-black text-sm shadow-md">3</div>
                            <div>
                                <h4 class="font-black text-gray-800 text-lg">Rekening Bank Ketiga</h4>
                                <p class="text-[11px] text-gray-400 font-medium">Opsional. Kosongkan jika hanya menggunakan 1-2 bank.</p>
                            </div>
                        </div>
                        <div class="space-y-5 pl-4 border-l-4 border-amber-100 ml-4">
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_bank_3" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">Nama Bank</label>
                                <input type="text" name="payment_bank_3" id="payment_bank_3" value="{{ $s['payment_bank_3'] ?? '' }}" placeholder="Contoh: Bank Jateng"
                                       class="flex-1 border-gray-200 focus:border-amber-500 focus:ring-amber-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_rekening_3" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">No. Rekening</label>
                                <input type="text" name="payment_rekening_3" id="payment_rekening_3" value="{{ $s['payment_rekening_3'] ?? '' }}" placeholder="Contoh: 0987654321"
                                       class="flex-1 border-gray-200 focus:border-amber-500 focus:ring-amber-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50 font-mono">
                            </div>
                            <div class="flex flex-col md:flex-row md:items-center gap-3 md:gap-8">
                                <label for="payment_penerima_3" class="md:w-56 text-sm font-bold text-gray-600 shrink-0">Atas Nama</label>
                                <input type="text" name="payment_penerima_3" id="payment_penerima_3" value="{{ $s['payment_penerima_3'] ?? '' }}" placeholder="Contoh: Panitia PPDB"
                                       class="flex-1 border-gray-200 focus:border-amber-500 focus:ring-amber-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                            </div>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-8">

                    {{-- ==================== QRIS ==================== --}}
                    <div class="mb-4">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-black text-sm shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-black text-gray-800 text-lg">Kode QRIS Sekolah</h4>
                                <p class="text-[11px] text-gray-400 font-medium">Unggah gambar QRIS statik sekolah untuk pembayaran via e-wallet.</p>
                            </div>
                        </div>
                        <div class="pl-4 border-l-4 border-indigo-100 ml-4">
                            <div class="flex flex-col md:flex-row items-start gap-6">
                                @if($s['payment_qris_image'] ?? false)
                                    <div class="shrink-0">
                                        <p class="text-xs text-gray-400 mb-2 font-bold">QR Code Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $s['payment_qris_image']) }}" alt="QRIS Code" class="w-36 h-36 object-cover rounded-2xl border-2 border-indigo-100 shadow-md bg-white p-1">
                                    </div>
                                @endif
                                <div class="flex-1 w-full">
                                    <input type="file" name="payment_qris_image" id="payment_qris_image" accept="image/*"
                                           class="w-full border border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                    <p class="text-[10px] text-gray-500 italic mt-2">Harap unggah gambar QRIS berformat JPG/PNG dengan resolusi persegi yang jelas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Footer Buttons -->
                <div class="p-8 bg-gray-50/30 border-t border-gray-50 flex items-center justify-end gap-4">
                    <button type="submit" form="settings-form" class="bg-highlight hover:bg-yellow-400 text-blue-900 px-10 py-4 rounded-2xl font-black shadow-[0_5px_15px_rgba(251,191,36,0.3)] transition-all active:scale-95 flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        SIMPAN PERUBAHAN
                    </button>
                </div>
            </div>

            <!-- Info Card -->
            <div class="mt-8 bg-amber-50 rounded-3xl p-6 border border-amber-100 flex items-start gap-4">
                <div class="p-3 bg-amber-500 text-white rounded-2xl shadow-lg shadow-amber-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="font-black text-amber-900 uppercase tracking-widest text-xs mb-1">Catatan Penting</h4>
                    <p class="text-sm text-amber-800 leading-relaxed">Rekening bank yang kosong tidak akan ditampilkan di halaman pembayaran siswa. Untuk pengaturan <strong>rincian biaya per jalur</strong> (Reguler, Prestasi, Afirmasi), gunakan menu <a href="{{ route('bendahara.items.index') }}" class="text-blue-700 font-bold underline hover:text-blue-900">Rincian Biaya Item</a>.</p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
