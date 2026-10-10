<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Daftar Ulang & Administrasi Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Back to Dashboard -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-blue-600 hover:text-blue-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Main Status Card -->
            @php
                $overallStatus = 'belum';
                if ($remainingAmount <= 0) {
                    $overallStatus = 'lunas';
                } elseif ($hasPending) {
                    $overallStatus = 'menunggu';
                } elseif ($payments->where('status', 'ditolak')->isNotEmpty()) {
                    $overallStatus = 'ditolak';
                } elseif ($payments->where('status', 'lunas')->isNotEmpty()) {
                    $overallStatus = 'cicilan';
                }
            @endphp

            @if($overallStatus !== 'belum')
                <div class="mb-10 overflow-hidden rounded-[2.5rem] shadow-xl border-2 
                    @if($overallStatus === 'lunas') bg-gradient-to-r from-emerald-50 to-green-100 border-emerald-200 text-emerald-900 
                    @elseif($overallStatus === 'menunggu') bg-gradient-to-r from-blue-50 to-indigo-50 border-blue-200 text-blue-900 
                    @elseif($overallStatus === 'cicilan') bg-gradient-to-r from-amber-50 to-yellow-100 border-amber-200 text-amber-900
                    @elseif($overallStatus === 'ditolak') bg-gradient-to-r from-red-50 to-rose-100 border-red-200 text-red-900 @endif p-8 md:p-10 relative">
                    <!-- Glassmorphism overlay for status card -->
                    <div class="absolute inset-0 bg-white/40 backdrop-blur-sm z-0"></div>
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex items-start gap-5">
                            <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-white shadow-lg shrink-0
                                @if($overallStatus === 'lunas') bg-emerald-600 
                                @elseif($overallStatus === 'menunggu') bg-blue-600 
                                @elseif($overallStatus === 'cicilan') bg-amber-600
                                @elseif($overallStatus === 'ditolak') bg-red-600 @endif">
                                @if($overallStatus === 'lunas')
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($overallStatus === 'menunggu')
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($overallStatus === 'cicilan')
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                @elseif($overallStatus === 'ditolak')
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                @endif
                            </div>
                            <div class="z-10">
                                <h3 class="text-xl font-black uppercase tracking-tight">
                                    Status: 
                                    @if($overallStatus === 'lunas') LUNAS / TERDAFTAR
                                    @elseif($overallStatus === 'menunggu') MENUNGGU VERIFIKASI
                                    @elseif($overallStatus === 'cicilan') PEMBAYARAN CICILAN
                                    @elseif($overallStatus === 'ditolak') PEMBAYARAN DITOLAK
                                    @endif
                                </h3>
                                <p class="text-sm font-medium mt-1 opacity-90 leading-relaxed">
                                    @if($overallStatus === 'lunas')
                                        Selamat! Administrasi pendaftaran ulang Anda telah lunas.
                                    @elseif($overallStatus === 'menunggu')
                                        Bukti pembayaran Anda telah dikirim dan saat ini sedang diperiksa oleh bendahara sekolah. Harap periksa halaman ini secara berkala.
                                    @elseif($overallStatus === 'cicilan')
                                        Pembayaran sebagian telah diterima. Sisa tagihan Anda adalah <strong>Rp {{ number_format($remainingAmount, 0, ',', '.') }}</strong>. Silakan lunasi sisa tagihan.
                                    @elseif($overallStatus === 'ditolak')
                                        Ada kesalahan dalam konfirmasi pendaftaran ulang Anda. Harap cek catatan penolakan dan kirimkan ulang bukti bayar yang benar.
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($overallStatus === 'lunas')
                            <div class="relative z-10 mt-6 md:mt-0">
                                <a href="{{ route('siswa.payments.receipt') }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-4 rounded-2xl font-bold transition transform hover:-translate-y-1 shadow-[0_10px_20px_rgba(16,185,129,0.3)] whitespace-nowrap flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                    Cetak Kuitansi Resmi
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Form & Instructions Section -->
            @if($remainingAmount > 0 && !$hasPending)
                <div x-data="{ method: 'midtrans', showSimulator: false }" class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 mb-12">
                    
                    <!-- Header -->
                    <div class="bg-gradient-primary p-10 text-white relative overflow-hidden">
                        <div class="absolute inset-0 bg-black opacity-10"></div>
                        <div class="absolute top-0 right-0 w-1/2 h-full bg-blue-500/10 skew-x-12 transform translate-x-16"></div>
                        <div class="relative z-10 flex items-center gap-6">
                            <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 flex items-center justify-center shrink-0 shadow-[0_0_20px_rgba(59,130,246,0.3)]">
                                <svg class="w-8 h-8 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-3xl font-extrabold tracking-tight mb-2">Formulir Konfirmasi Pembayaran</h3>
                                <p class="text-white/90 text-sm md:text-base font-medium">Silakan pilih metode pembayaran dan lengkapi bukti transaksi untuk pendaftaran ulang.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Method Selector Tabs -->
                    <div class="p-8 pb-4">
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-3">Pilih Metode Pembayaran</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Otomatis Midtrans -->
                            <button type="button" @click="method = 'midtrans'" 
                                    :class="method === 'midtrans' ? 'border-blue-600 bg-blue-50/50 text-blue-900 ring-2 ring-blue-500/10' : 'border-gray-200 hover:bg-gray-50 text-gray-700'"
                                    class="border-2 p-4 rounded-2xl text-left transition flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-500 text-white flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <span class="text-sm font-black block">Otomatis</span>
                                    <span class="text-[10px] text-gray-400 font-medium">Gateway Midtrans</span>
                                </div>
                            </button>




                            <!-- Cash -->
                            <button type="button" @click="method = 'tunai'" 
                                    :class="method === 'tunai' ? 'border-blue-600 bg-blue-50/50 text-blue-900 ring-2 ring-blue-500/10' : 'border-gray-200 hover:bg-gray-50 text-gray-700'"
                                    class="border-2 p-4 rounded-2xl text-left transition flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <span class="text-sm font-black block">Bayar Tunai</span>
                                    <span class="text-[10px] text-gray-400 font-medium">Loket Keuangan</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <!-- Rincian Biaya -->
                    <div class="px-8 pb-6">
                        <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100">
                            <h4 class="text-sm font-black text-gray-800 uppercase tracking-widest flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Rincian Biaya Daftar Ulang
                                <span class="text-[9px] font-black uppercase tracking-wider px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 border border-blue-200 ml-1">Jalur {{ $student->jalur_pendaftaran }}</span>
                            </h4>
                            <div class="space-y-3">
                                @forelse($paymentItems as $item)
                                    <div class="flex justify-between items-center text-sm">
                                        <div class="text-gray-600 font-medium">{{ $item->name }}</div>
                                        <div class="text-gray-800 font-bold">Rp {{ number_format($item->amount, 0, ',', '.') }}</div>
                                    </div>
                                @empty
                                    <div class="text-sm text-gray-400 italic">Belum ada rincian biaya yang ditetapkan.</div>
                                @endforelse
                                <div class="pt-4 border-t border-gray-200 flex justify-between items-center mt-2">
                                    <div class="text-gray-800 font-black text-lg">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                                </div>
                                <div class="pt-2 flex justify-between items-center text-sm">
                                    <div class="text-gray-600 font-bold">Total Sudah Dibayar</div>
                                    <div class="text-emerald-600 font-bold">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
                                </div>
                                <div class="pt-4 border-t border-gray-200 flex justify-between items-center mt-2">
                                    <div class="text-gray-800 font-black">Sisa Tagihan</div>
                                    <div class="text-blue-600 font-black text-xl">Rp {{ number_format($remainingAmount, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Instructions Panel -->
                    <div class="px-8 py-4">
                        <!-- Midtrans Instructions -->
                        <div x-show="method === 'midtrans'" class="bg-blue-50 rounded-3xl p-6 border border-blue-100 flex flex-col items-center text-center gap-4 mb-6 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white/40 backdrop-blur-sm z-0"></div>
                            <div class="z-10 w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center text-blue-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div class="z-10 max-w-lg">
                                <h4 class="text-lg font-black text-blue-900 tracking-tight">Pembayaran Otomatis Midtrans</h4>
                                <p class="text-blue-800/80 text-sm mt-2 leading-relaxed font-medium">Anda akan diarahkan ke Payment Gateway Midtrans. Anda dapat membayar melalui berbagai metode seperti Virtual Account (BCA, Mandiri, BNI, BRI), GoPay, ShopeePay, Indomaret, dll. Pembayaran akan terverifikasi otomatis setelah sukses.</p>
                            </div>
                        </div>



                        <!-- Tunai Instructions -->
                        <div x-show="method === 'tunai'" class="bg-gray-50 rounded-3xl p-6 border border-gray-100 space-y-4">
                            <h4 class="text-sm font-black text-gray-800 uppercase tracking-widest">Pembayaran Tunai di Sekolah</h4>
                            <div class="text-sm text-gray-500 leading-relaxed space-y-2">
                                <p>Silakan lakukan pembayaran langsung secara tunai ke loket keuangan sekolah:</p>
                                <ol class="list-decimal list-inside pl-2 space-y-1 text-xs">
                                    <li>Kunjungi loket pendaftaran di sekolah pada jam kerja (Senin - Sabtu, 08.00 - 13.00 WIB).</li>
                                    <li>Tunjukkan bukti kartu pendaftaran Anda dengan nomor pendaftaran: <strong>{{ $student->nomor_pendaftaran }}</strong>.</li>
                                    <li>Lakukan pembayaran tunai (bisa dicicil, sisa: <strong>Rp {{ number_format($remainingAmount, 0, ',', '.') }}</strong>) ke bendahara sekolah.</li>
                                    <li>Mintalah kuitansi pembayaran manual yang ditandatangani bendahara.</li>
                                    <li>Ambil foto kuitansi manual tersebut dan unggah di form bawah sebagai konfirmasi di sistem online.</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Input Form -->
                    <form action="{{ route('siswa.payments.store') }}" method="POST" enctype="multipart/form-data" class="p-8 border-t border-gray-50">
                        @csrf
                        <!-- Hidden payment method field connected to Alpine -->
                        <input type="hidden" name="metode_pembayaran" :value="method">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Jumlah Bayar -->
                            <div>
                                <label for="jumlah_bayar" class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Jumlah Bayar (Rp)</label>
                                <input type="number" name="jumlah_bayar" id="jumlah_bayar" value="{{ $remainingAmount }}" max="{{ $remainingAmount }}"
                                       class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                @error('jumlah_bayar') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <!-- Tanggal Bayar -->
                            <div x-show="method !== 'midtrans'">
                                <label for="tanggal_bayar" class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Tanggal Bayar</label>
                                <input type="date" name="tanggal_bayar" id="tanggal_bayar" value="{{ date('Y-m-d') }}"
                                       class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                                @error('tanggal_bayar') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>



                            <!-- Upload Proof -->
                            <div x-show="method !== 'midtrans'" class="col-span-1 md:col-span-2">
                                <label for="bukti_transfer" class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Unggah Bukti Pembayaran</label>
                                <div class="border-2 border-dashed border-gray-200 hover:border-blue-500 rounded-3xl p-6 transition bg-gray-50/30 flex flex-col items-center justify-center text-center relative">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    <span class="text-sm font-bold text-gray-700 mb-1">Pilih berkas bukti pembayaran</span>
                                    <span class="text-[10px] text-gray-400">Dukungan format: JPG, JPEG, PNG, PDF (Maks. 5MB)</span>
                                    <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*,application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </div>
                                @error('bukti_transfer') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                
                                <div id="preview-container" class="mt-4 hidden">
                                    <p class="text-xs text-gray-400 mb-1">Preview Bukti:</p>
                                    <img id="image-preview" src="#" alt="Preview" class="w-32 h-auto object-cover rounded-xl border border-gray-200">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="bg-highlight hover:bg-yellow-400 text-blue-900 px-10 py-4 rounded-2xl font-black shadow-[0_10px_20px_rgba(251,191,36,0.3)] transition transform hover:-translate-y-1 flex items-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span x-text="method === 'midtrans' ? 'LANJUTKAN KE PEMBAYARAN MIDTRANS' : 'KIRIM KONFIRMASI PEMBAYARAN'"></span>
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Pending Midtrans Payment Card -->
            @if(isset($pendingMidtrans) && $pendingMidtrans)
                <div class="bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 rounded-[2.5rem] shadow-2xl overflow-hidden border border-white/10 mb-10 relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="absolute top-0 right-0 w-1/2 h-full bg-white/5 skew-x-12 transform translate-x-20"></div>
                    <div class="relative z-10 p-8 md:p-10">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="flex items-center gap-5">
                                <div class="w-16 h-16 bg-white/15 backdrop-blur-md rounded-2xl border border-white/20 flex items-center justify-center shrink-0 shadow-lg">
                                    <svg class="w-8 h-8 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div class="text-white">
                                    <h3 class="text-xl font-black tracking-tight">Tagihan Midtrans Menunggu Pembayaran</h3>
                                    <p class="text-white/80 text-sm mt-1 font-medium">Order ID: <span class="font-mono text-yellow-300">{{ $pendingMidtrans->midtrans_order_id }}</span></p>
                                    <p class="text-white/90 text-lg font-black mt-1">Rp {{ number_format($pendingMidtrans->jumlah_bayar, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <button onclick="syncMidtrans('{{ $pendingMidtrans->midtrans_order_id }}')" class="bg-white/20 hover:bg-white/30 text-white px-6 py-4 rounded-2xl font-bold text-sm shadow-md transition transform hover:-translate-y-1 active:scale-95 flex items-center gap-2 whitespace-nowrap">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                    CEK STATUS
                                </button>
                                <button id="pay-button" onclick="payWithMidtrans()" class="bg-yellow-400 hover:bg-yellow-300 text-blue-900 px-10 py-4 rounded-2xl font-black text-lg shadow-[0_10px_25px_rgba(251,191,36,0.4)] transition transform hover:-translate-y-1 active:scale-95 flex items-center gap-3 whitespace-nowrap">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    BAYAR SEKARANG
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Riwayat Pembayaran List -->
            @if($payments->isNotEmpty())
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden mt-8">
                    <div class="p-8 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-3">
                            <span class="w-1.5 h-6 bg-blue-600 rounded-full"></span>
                            Riwayat Pembayaran
                        </h3>
                    </div>
                    <div class="p-0">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-100 text-xs font-black tracking-widest text-gray-500 uppercase">
                                        <th class="p-4 pl-8">Tanggal</th>
                                        <th class="p-4">Metode</th>
                                        <th class="p-4">Jumlah</th>
                                        <th class="p-4">Status</th>
                                        <th class="p-4 text-center pr-8">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $pay)
                                        <tr class="border-b border-gray-50 hover:bg-blue-50/30 transition text-sm">
                                            <td class="p-4 pl-8 text-gray-800 font-medium">
                                                {{ $pay->tanggal_bayar->format('d M Y') }}
                                            </td>
                                            <td class="p-4 text-gray-800 font-bold uppercase">
                                                {{ $pay->metode_pembayaran }}
                                                @if($pay->metode_pembayaran == 'transfer')
                                                    <span class="block text-[10px] text-gray-500 font-medium normal-case">{{ $pay->bank_asal }} a.n {{ $pay->nama_rekening }}</span>
                                                @elseif($pay->metode_pembayaran == 'midtrans')
                                                    <span class="block text-[10px] text-gray-500 font-medium normal-case font-mono">{{ $pay->midtrans_order_id }}</span>
                                                @endif
                                            </td>
                                            <td class="p-4 font-black text-gray-800">
                                                Rp {{ number_format($pay->jumlah_bayar, 0, ',', '.') }}
                                            </td>
                                            <td class="p-4">
                                                @if($pay->status === 'lunas')
                                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold whitespace-nowrap">Lunas</span>
                                                @elseif($pay->status === 'menunggu')
                                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold whitespace-nowrap">Menunggu Verifikasi</span>
                                                @else
                                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold whitespace-nowrap">Ditolak</span>
                                                    @if($pay->catatan)
                                                        <div class="text-[10px] text-red-600 mt-1 max-w-[150px]">{{ $pay->catatan }}</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="p-4 text-center pr-8">
                                                @if($pay->metode_pembayaran === 'midtrans' && $pay->status === 'menunggu' && $pay->snap_token)
                                                    <div class="flex flex-col gap-2">
                                                        <button onclick="payWithMidtrans()" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-bold transition shadow-sm">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                                            Bayar
                                                        </button>
                                                        <button onclick="syncMidtrans('{{ $pay->midtrans_order_id }}')" class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-lg text-xs font-bold transition shadow-sm">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                                            Cek Status
                                                        </button>
                                                    </div>
                                                @elseif($pay->bukti_transfer)
                                                    <a href="{{ asset('storage/' . $pay->bukti_transfer) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    </a>
                                                @else
                                                    <span class="text-gray-400 text-xs">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-6 right-6 z-[999] flex flex-col gap-3" style="pointer-events: none;"></div>

    <!-- Toast CSS -->
    <style>
        @keyframes toast-slide-in {
            0% { transform: translateX(120%); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }
        @keyframes toast-slide-out {
            0% { transform: translateX(0); opacity: 1; }
            100% { transform: translateX(120%); opacity: 0; }
        }
        @keyframes toast-progress {
            0% { width: 100%; }
            100% { width: 0%; }
        }
        .toast-enter { animation: toast-slide-in 0.5s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        .toast-exit { animation: toast-slide-out 0.4s cubic-bezier(0.55, 0.085, 0.68, 0.53) forwards; }
        .toast-progress-bar { animation: toast-progress 4s linear forwards; }
    </style>

    <!-- JS Helper for Toast, Copy to Clipboard, and Image Preview -->
    <script>
        // Beautiful Toast Notification System
        function showToast(message, type = 'success') {
            var container = document.getElementById('toast-container');
            var toast = document.createElement('div');

            var colors = {
                success: { bg: 'bg-emerald-600', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>', progress: 'bg-emerald-300' },
                error:   { bg: 'bg-red-600', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>', progress: 'bg-red-300' },
                info:    { bg: 'bg-blue-600', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>', progress: 'bg-blue-300' }
            };
            var c = colors[type] || colors.success;

            toast.className = 'toast-enter';
            toast.style.pointerEvents = 'auto';
            toast.innerHTML = `
                <div class="flex items-center gap-4 ${c.bg} text-white px-5 py-4 rounded-2xl shadow-2xl shadow-gray-900/20 min-w-[320px] max-w-[420px] relative overflow-hidden backdrop-blur-sm border border-white/10">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">${c.icon}</svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-black tracking-tight leading-snug">${message}</p>
                    </div>
                    <button onclick="this.closest('.toast-enter, .toast-exit').classList.add('toast-exit'); setTimeout(() => this.closest('.toast-enter, .toast-exit')?.remove(), 400);" class="text-white/60 hover:text-white transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                    <div class="absolute bottom-0 left-0 h-1 ${c.progress} toast-progress-bar rounded-full" style="opacity: 0.6;"></div>
                </div>
            `;
            container.appendChild(toast);

            // Auto-dismiss after 4 seconds
            setTimeout(function() {
                if (toast.parentNode) {
                    toast.classList.remove('toast-enter');
                    toast.classList.add('toast-exit');
                    setTimeout(function() { toast.remove(); }, 400);
                }
            }, 4000);
        }

        // Copy Account Number with Toast
        function copyAccountNumber() {
            var text = document.getElementById("acc-num").innerText;
            var btn = event.currentTarget;
            var originalHTML = btn.innerHTML;

            navigator.clipboard.writeText(text).then(function() {
                showToast('Nomor rekening berhasil disalin ke clipboard!', 'success');
                btn.innerHTML = '✓ Tersalin!';
                btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                setTimeout(function() {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                }, 2000);
            }, function() {
                // Fallback for older browsers
                var temp = document.createElement("textarea");
                document.body.appendChild(temp);
                temp.value = text;
                temp.select();
                document.execCommand("copy");
                document.body.removeChild(temp);
                showToast('Nomor rekening berhasil disalin ke clipboard!', 'success');
                btn.innerHTML = '✓ Tersalin!';
                btn.classList.add('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                setTimeout(function() {
                    btn.innerHTML = originalHTML;
                    btn.classList.remove('bg-emerald-50', 'text-emerald-700', 'border-emerald-300');
                }, 2000);
            });
        }

        // Show flash success message from server as toast
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast(@json(session('success')), 'success');
            @endif
            @if(session('error'))
                showToast(@json(session('error')), 'error');
            @endif
        });

        // Preview uploaded image
        document.getElementById('bukti_transfer')?.addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var container = document.getElementById('preview-container');
                    var preview = document.getElementById('image-preview');
                    if (preview && container) {
                        if (file.type === 'application/pdf') {
                            preview.src = 'https://placehold.co/150x150?text=PDF+Document';
                        } else {
                            preview.src = e.target.result;
                        }
                        container.classList.remove('hidden');
                    }
                }
                reader.readAsDataURL(file);
                showToast('Berkas "' + file.name + '" berhasil dipilih!', 'info');
            }
        });
    </script>
    {{-- Midtrans Snap.js & Sync Function --}}
    <script>
        function syncMidtrans(orderId) {
            showToast('⏳ Mengecek status pembayaran ke Midtrans...', 'info');
            fetch('{{ route('siswa.payments.midtrans.sync') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ order_id: orderId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.status === 'lunas') {
                        showToast('✅ ' + data.message, 'success');
                    } else if (data.status === 'ditolak') {
                        showToast('❌ ' + data.message, 'error');
                    } else {
                        showToast('ℹ️ ' + data.message, 'info');
                    }
                    setTimeout(function() { window.location.reload(); }, 1500);
                } else {
                    showToast('⚠️ ' + data.message, 'error');
                }
            })
            .catch(error => {
                showToast('❌ Terjadi kesalahan jaringan saat mengecek status.', 'error');
            });
        }
    </script>
    
    @if(isset($pendingMidtrans) && $pendingMidtrans && $midtransClientKey)
        <script src="{{ $midtransIsProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $midtransClientKey }}"></script>
        <script>
            function payWithMidtrans() {
                window.snap.pay('{{ $pendingMidtrans->snap_token }}', {
                    onSuccess: function(result) {
                        showToast('🎉 Pembayaran berhasil di Midtrans! Menyelaraskan status...', 'success');
                        syncMidtrans(result.order_id);
                    },
                    onPending: function(result) {
                        showToast('⏳ Pembayaran menunggu konfirmasi. Silakan selesaikan pembayaran Anda.', 'info');
                        setTimeout(function() { window.location.reload(); }, 2000);
                    },
                    onError: function(result) {
                        showToast('❌ Pembayaran gagal. Silakan coba lagi.', 'error');
                        syncMidtrans(result.order_id);
                    },
                    onClose: function() {
                        showToast('Popup pembayaran ditutup. Status akan dicek...', 'info');
                        syncMidtrans('{{ $pendingMidtrans->midtrans_order_id }}');
                    }
                });
            }
        </script>
    @else
        <script>
            function payWithMidtrans() {
                showToast('Tidak ada tagihan Midtrans yang aktif saat ini.', 'error');
            }
        </script>
    @endif

</x-app-layout>

