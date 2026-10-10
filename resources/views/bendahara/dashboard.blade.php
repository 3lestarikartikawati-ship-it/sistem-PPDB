<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Dashboard Keuangan Siswa') }}
            </h2>
            <div class="text-sm text-gray-500 font-medium">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Welcome Banner -->
            <div class="bg-gradient-primary rounded-[2.5rem] shadow-2xl p-10 mb-10 text-white relative overflow-hidden">
                <div class="relative z-10 flex items-center gap-6">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-[0_0_15px_rgba(251,191,36,0.3)] shrink-0">
                        <svg class="w-8 h-8 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-white/90 text-sm md:text-base font-medium">Pantau dan kelola pencatatan pembayaran Infak, LK, dan Seragam untuk siswa kelas 7, 8, dan 9 secara realtime.</p>
                    </div>
                </div>
                <!-- Decorative Elements -->
                <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Dana Terkumpul -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-white flex items-center justify-center mr-4 shadow-lg shadow-emerald-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Dana Masuk</div>
                        <div class="text-2xl font-black text-gray-800">Rp {{ number_format($totalFunds, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Total Infak -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-600 text-white flex items-center justify-center mr-4 shadow-lg shadow-amber-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Infak</div>
                        <div class="text-xl font-black text-gray-800">Rp {{ number_format($totalInfak, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Total LK -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 text-white flex items-center justify-center mr-4 shadow-lg shadow-blue-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Lembar Kerja</div>
                        <div class="text-xl font-black text-gray-800">Rp {{ number_format($totalLk, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Total Seragam -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rose-400 to-rose-600 text-white flex items-center justify-center mr-4 shadow-lg shadow-rose-500/30">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Seragam</div>
                        <div class="text-xl font-black text-gray-800">Rp {{ number_format($totalSeragam, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
                <!-- Trend Chart -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black text-gray-800">Tren Pemasukan</h3>
                        <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-widest">7 Hari Terakhir</span>
                    </div>
                    <div class="h-64">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Payment Method Chart -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black text-gray-800">Rincian Dana Masuk</h3>
                        <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-widest">Berdasarkan Jenis</span>
                    </div>
                    <div class="h-64">
                        <canvas id="methodChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Progress & Recent -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
                <!-- Progress Card -->
                <div class="lg:col-span-1 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2rem] shadow-xl border border-gray-100 p-8 flex flex-col relative overflow-hidden group text-white">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="relative z-10">
                        <h4 class="text-[10px] font-black text-blue-200 uppercase tracking-widest mb-6">Siswa Aktif Terkelola</h4>
                        <div class="flex items-end justify-between mb-4">
                            <div class="text-5xl font-black text-white">
                                {{ $totalAccepted }}<span class="text-2xl text-blue-200 ml-2">Siswa</span>
                            </div>
                        </div>
                        <p class="text-[11px] text-white/80 leading-relaxed mt-4">Merupakan total jumlah siswa dari kelas 7, 8, dan 9 yang dikelola pencatatan pembayarannya saat ini.</p>
                    </div>
                    <div class="absolute -right-8 -bottom-8 opacity-[0.05] group-hover:opacity-[0.1] transition-opacity duration-500 pointer-events-none">
                        <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                            Cicilan Pembayaran Terbaru
                        </h3>
                        <a href="{{ route('bendahara.payments.index') }}" class="text-[10px] font-black text-blue-600 hover:text-blue-800 bg-blue-50 px-4 py-2 rounded-xl transition uppercase tracking-widest">Kelola Siswa</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentPayments as $payment)
                        <div class="p-4 hover:bg-blue-50/30 transition flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl flex items-center justify-center text-blue-600 font-black shadow-sm group-hover:scale-110 transition duration-300">
                                    {{ substr($payment->student->nama_lengkap ?? 'S', 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="font-bold text-gray-800 group-hover:text-blue-700 transition">{{ $payment->student->nama_lengkap ?? 'Siswa' }} <span class="text-xs text-gray-400 font-normal ml-2">Kelas {{ $payment->student->kelas ?? '-' }}</span></div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Rp {{ number_format($payment->amount, 0, ',', '.') }} • {{ $payment->paid_at->format('d M Y') }}</div>
                                </div>
                            </div>
                            <div class="text-right flex items-center gap-2">
                                @if($payment->type == 'infak')
                                    <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[9px] font-black rounded-full uppercase tracking-widest">INFAK</span>
                                @elseif($payment->type == 'lk')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 text-[9px] font-black rounded-full uppercase tracking-widest">LK</span>
                                @else
                                    <span class="px-3 py-1 bg-rose-100 text-rose-700 text-[9px] font-black rounded-full uppercase tracking-widest">SERAGAM</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center text-gray-400 font-medium italic">Belum ada riwayat pembayaran yang dicatat.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                        <span class="w-2 h-6 bg-amber-500 rounded-full"></span>
                        Aksi Cepat
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('bendahara.payments.index') }}" class="group p-6 bg-white rounded-3xl border border-gray-100 hover:border-blue-200 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300">
                        <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-blue-600 group-hover:text-white transition duration-300 shadow-sm">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h5 class="font-black text-gray-800 mb-1">Catat Cicilan Pembayaran</h5>
                        <p class="text-xs text-gray-500">Input nominal pembayaran Infak, LK, atau Seragam siswa</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts for Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trend Chart
            const ctxTrend = document.getElementById('trendChart').getContext('2d');
            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: @js($labels),
                    datasets: [{
                        label: 'Pemasukan (Rp)',
                        data: @js($totals),
                        borderColor: '#2563eb', // blue-600
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#2563eb',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { display: false } },
                        x: { grid: { display: false } }
                    }
                }
            });

            // Method Distribution Chart
            const ctxMethod = document.getElementById('methodChart').getContext('2d');
            new Chart(ctxMethod, {
                type: 'doughnut',
                data: {
                    labels: @js($methodData->pluck('type')->map(fn($m) => strtoupper($m))),
                    datasets: [{
                        data: @js($methodData->pluck('total')),
                        backgroundColor: ['#f59e0b', '#3b82f6', '#f43f5e'], // amber, blue, rose
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, font: { size: 10 } } }
                    },
                    cutout: '70%'
                }
            });
        });
    </script>
</x-app-layout>
