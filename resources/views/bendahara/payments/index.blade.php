<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Kelola Pembayaran Siswa') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-700">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-bold text-sm">Terjadi Kesalahan:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm font-medium ml-8">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
                <!-- Total Siswa -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 hover:-translate-y-1 transition transform duration-300">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Total Siswa</span>
                        <span class="text-2xl font-black text-gray-800">{{ $totalAccepted }}</span>
                    </div>
                </div>

                <!-- Total Infak -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 hover:-translate-y-1 transition transform duration-300">
                    <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Total Infak</span>
                        <span class="text-lg font-black text-amber-700">Rp {{ number_format($students->sum(fn($s) => $s->studentPayments->where('type', 'infak')->sum('amount')), 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Total LK -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 relative hover:-translate-y-1 transition transform duration-300">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block font-medium">Total LK</span>
                        <span class="text-lg font-black text-blue-600">Rp {{ number_format($students->sum(fn($s) => $s->studentPayments->where('type', 'lk')->sum('amount')), 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Total Seragam -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 hover:-translate-y-1 transition transform duration-300">
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Total Seragam</span>
                        <span class="text-lg font-black text-rose-600">Rp {{ number_format($students->sum(fn($s) => $s->studentPayments->where('type', 'seragam')->sum('amount')), 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Total Funds Collected -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 sm:col-span-2 lg:col-span-1 hover:-translate-y-1 transition transform duration-300">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <span class="font-black text-sm">Rp</span>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block">Semua Masuk</span>
                        <span class="text-lg font-black text-emerald-800 block">Rp {{ number_format($totalFunds, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Filters Bar -->
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-xl p-6 mb-10 flex flex-col md:flex-row items-center justify-between gap-4">
                <form action="{{ route('bendahara.payments.index') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-4">
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-80">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..." 
                               class="w-full pl-11 border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-sm p-4 bg-gray-50/50">
                    </div>

                    <!-- Kelas Selector -->
                    <div class="w-full sm:w-48">
                        <select name="kelas" onchange="this.form.submit()" 
                                class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-sm p-4 bg-gray-50/50 text-gray-700 font-bold">
                            <option value="">Semua Kelas</option>
                            <option value="7" {{ request('kelas') === '7' ? 'selected' : '' }}>Kelas 7</option>
                            <option value="8" {{ request('kelas') === '8' ? 'selected' : '' }}>Kelas 8</option>
                            <option value="9" {{ request('kelas') === '9' ? 'selected' : '' }}>Kelas 9</option>
                        </select>
                    </div>

                    <!-- Submit and Clear -->
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-4 rounded-2xl text-sm font-bold shadow-md transition w-full sm:w-auto">Filter</button>
                        @if(request('search') || request('kelas'))
                            <a href="{{ route('bendahara.payments.index') }}" class="border border-gray-200 text-gray-500 hover:bg-gray-50 px-6 py-4 rounded-2xl text-sm font-bold transition text-center w-full sm:w-auto">Reset</a>
                        @endif
                    </div>
                </form>

                <!-- Export Buttons -->
                <div class="flex items-center gap-2 w-full sm:w-auto flex-wrap">
                    <a href="{{ route('bendahara.payments.export.pdf', request()->query()) }}" target="_blank" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-4 rounded-2xl text-sm font-bold shadow-md transition w-full sm:w-auto justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        Cetak PDF
                    </a>
                    <a href="{{ route('bendahara.payments.export.belum_lunas', request()->query()) }}" target="_blank" class="flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white px-5 py-4 rounded-2xl text-sm font-bold shadow-md transition w-full sm:w-auto justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                        Unduh Belum Lunas
                    </a>
                </div>
            </div>

            <!-- Table Card -->
            <div class="bg-white shadow-2xl rounded-[2.5rem] border border-gray-100 overflow-hidden mb-10 relative">
                
                <div class="bg-gradient-primary p-8 flex items-center justify-between relative overflow-hidden">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl"></div>
                    <h3 class="text-2xl font-extrabold text-white flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center shadow-[0_0_15px_rgba(251,191,36,0.3)]">
                            <svg class="w-6 h-6 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        Data Keuangan Siswa
                    </h3>
                </div>
                
                <!-- Filter Tabs -->
                <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap gap-2">
                    <a href="{{ route('bendahara.payments.index', request()->except('kelas')) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ !request('kelas') ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua Kelas ({{ $counts['semua'] }})
                    </a>
                    <a href="{{ route('bendahara.payments.index', array_merge(request()->query(), ['kelas' => '7'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('kelas') == '7' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Kelas 7 ({{ $counts['7'] }})
                    </a>
                    <a href="{{ route('bendahara.payments.index', array_merge(request()->query(), ['kelas' => '8'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('kelas') == '8' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Kelas 8 ({{ $counts['8'] }})
                    </a>
                    <a href="{{ route('bendahara.payments.index', array_merge(request()->query(), ['kelas' => '9'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('kelas') == '9' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Kelas 9 ({{ $counts['9'] }})
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 border-b border-gray-100 text-gray-400 font-black text-[10px] uppercase tracking-widest">
                                <th class="p-5 text-center" style="width: 60px;">No</th>
                                <th class="p-5">Data Siswa</th>
                                <th class="p-5 text-center">Infak</th>
                                <th class="p-5 text-center">LK</th>
                                <th class="p-5 text-center">Seragam</th>
                                <th class="p-5 text-center">Total Progres</th>
                                <th class="p-5 text-center" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            @forelse($students as $index => $student)
                                @php
                                    $infak = $student->studentPayments->where('type', 'infak')->sum('amount');
                                    $lk = $student->studentPayments->where('type', 'lk')->sum('amount');
                                    $seragam = $student->studentPayments->where('type', 'seragam')->sum('amount');
                                    $total = $infak + $lk + $seragam;
                                    
                                    $targetInfak = $student->target_infak;
                                    $targetLk = $student->target_lk;
                                    $targetSeragam = $student->target_seragam;
                                    $totalTarget = $student->total_target;

                                    $pctInfak = $targetInfak > 0 ? min(100, round(($infak / $targetInfak) * 100)) : 0;
                                    $pctLk = $targetLk > 0 ? min(100, round(($lk / $targetLk) * 100)) : 0;
                                    $pctSeragam = $targetSeragam > 0 ? min(100, round(($seragam / $targetSeragam) * 100)) : 0;
                                    $pctTotal = $totalTarget > 0 ? min(100, round(($total / $totalTarget) * 100)) : 0;
                                @endphp
                                <tr class="hover:bg-emerald-50/40 transition-all duration-200 group border-b border-gray-50 last:border-0">
                                    <td class="p-5 text-center font-bold text-gray-400">{{ $students->firstItem() + $index }}</td>
                                    <td class="p-5">
                                        <div class="flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 border border-emerald-200 flex items-center justify-center shrink-0">
                                                <span class="font-black text-emerald-700">{{ substr($student->nama_lengkap, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <div class="font-black text-gray-900">{{ $student->nama_lengkap }}</div>
                                                <div class="text-[11px] font-medium text-gray-500 mt-1 flex items-center gap-2">
                                                    <span class="font-mono bg-gray-50 px-1.5 py-0.5 rounded border border-gray-100">Kelas {{ $student->kelas ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <div class="font-bold text-amber-600 bg-amber-50 inline-block px-3 py-1 rounded-xl border border-amber-100 mb-2">Rp {{ number_format($infak, 0, ',', '.') }}</div>
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $pctInfak }}%"></div>
                                        </div>
                                        <div class="text-[10px] font-bold text-gray-400 mt-1">{{ $pctInfak }}% (Target: Rp {{ number_format($targetInfak, 0, ',', '.') }})</div>
                                    </td>
                                    <td class="p-5 text-center">
                                        @if($pctLk == 100)
                                            <div class="font-bold text-emerald-600 bg-emerald-50 inline-block px-3 py-1 rounded-xl border border-emerald-100 mb-2">LUNAS</div>
                                        @else
                                            <div class="font-bold text-blue-600 bg-blue-50 inline-block px-3 py-1 rounded-xl border border-blue-100 mb-2">Rp {{ number_format($lk, 0, ',', '.') }}</div>
                                        @endif
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $pctLk }}%"></div>
                                        </div>
                                        <div class="text-[10px] font-bold text-gray-400 mt-1">{{ $pctLk }}% (Target: Rp {{ number_format($targetLk, 0, ',', '.') }})</div>
                                    </td>
                                    <td class="p-5 text-center">
                                        @if($pctSeragam == 100)
                                            <div class="font-bold text-emerald-600 bg-emerald-50 inline-block px-3 py-1 rounded-xl border border-emerald-100 mb-2">LUNAS</div>
                                        @else
                                            <div class="font-bold text-rose-600 bg-rose-50 inline-block px-3 py-1 rounded-xl border border-rose-100 mb-2">Rp {{ number_format($seragam, 0, ',', '.') }}</div>
                                        @endif
                                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                            <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $pctSeragam }}%"></div>
                                        </div>
                                        <div class="text-[10px] font-bold text-gray-400 mt-1">{{ $pctSeragam }}% (Target: Rp {{ number_format($targetSeragam, 0, ',', '.') }})</div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <div class="font-black text-emerald-700 bg-emerald-50 inline-block px-3 py-1 rounded-xl border border-emerald-100 mb-2">Rp {{ number_format($total, 0, ',', '.') }}</div>
                                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1 shadow-inner">
                                            <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $pctTotal }}%"></div>
                                        </div>
                                        <div class="text-[10px] font-black text-emerald-600 mt-1">{{ $pctTotal }}% DARI TOTAL</div>
                                    </td>
                                    <td class="p-5 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button" 
                                                    onclick="openHistoryModal(
                                                        '{{ addslashes($student->nama_lengkap) }}',
                                                        {{ $student->studentPayments->toJson() }}
                                                    )"
                                                    class="bg-white border border-blue-100 hover:bg-blue-600 hover:border-blue-600 text-blue-600 hover:text-white px-3 py-2 rounded-xl text-[11px] font-black transition-all duration-200 shadow-sm group-hover:shadow hover:shadow-md active:scale-95 uppercase tracking-wider flex items-center gap-1" title="Lihat Riwayat">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </button>
                                            <button type="button" 
                                                    onclick="openPaymentModal(
                                                        '{{ addslashes($student->nama_lengkap) }}',
                                                        '{{ $student->kelas ?? '-' }}',
                                                        '{{ route('bendahara.payments.store', $student->id) }}',
                                                        {{ $pctLk }}, {{ $targetLk }}, {{ $targetLk - $lk }},
                                                        {{ $pctSeragam }}, {{ $targetSeragam }}, {{ $targetSeragam - $seragam }},
                                                        {{ $pctInfak }}, {{ $targetInfak - $infak }}
                                                    )"
                                                    class="bg-white border border-emerald-100 hover:bg-emerald-600 hover:border-emerald-600 text-emerald-600 hover:text-white px-4 py-2 rounded-xl text-[11px] font-black transition-all duration-200 shadow-sm group-hover:shadow hover:shadow-md active:scale-95 uppercase tracking-wider">
                                                Input Bayar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-12 text-center text-gray-400 font-bold">
                                        Tidak ada data siswa ditemukan di kelas ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="p-8 border-t border-gray-50">
                    {{ $students->links() }}
                </div>
            </div>

        </div>
    </div>

    <!-- History Modal -->
    <div id="history-modal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-md overflow-y-auto flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-2xl w-full overflow-hidden border border-gray-100 transform transition-all scale-100">
            <div class="p-8">
                <!-- Close button header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-gray-800">Riwayat Pembayaran</h3>
                    <button onclick="closeHistoryModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <!-- Student Details -->
                <div class="bg-blue-50 rounded-2xl p-4 border border-blue-100 space-y-1 mb-6">
                    <div class="text-xs font-bold text-blue-400 uppercase tracking-wider">Data Siswa</div>
                    <div id="history-student-name" class="text-base font-black text-blue-900">Nama Siswa</div>
                </div>
                <!-- Table -->
                <div class="overflow-x-auto rounded-2xl border border-gray-100 max-h-64 overflow-y-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-gray-50 border-b border-gray-100">
                            <tr class="text-gray-400 font-black text-[10px] uppercase tracking-widest">
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Jenis</th>
                                <th class="p-4 text-right">Nominal</th>
                                <th class="p-4 text-center">Bukti</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="history-table-body" class="divide-y divide-gray-100 text-sm text-gray-700 bg-white">
                            <!-- Rows rendered via JS -->
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeHistoryModal()" class="px-5 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-50 text-sm transition">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden form for deleting payment -->
    <form id="delete-payment-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <!-- Input Payment Modal -->
    <div id="payment-modal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-md overflow-y-auto flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full overflow-hidden border border-gray-100 transform transition-all scale-100">
            
            <div class="p-8">
                <!-- Close button header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-black text-gray-800">Input Cicilan Pembayaran</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Student Details -->
                <div class="bg-gray-50 rounded-2xl p-4 border border-gray-100 space-y-3 mb-6">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Siswa</div>
                    <div id="modal-student-name" class="text-base font-black text-gray-800">Nama Siswa</div>
                    <div id="modal-student-kelas" class="text-sm font-bold text-gray-500">Kelas</div>
                </div>

                <!-- Action form -->
                <form id="modal-form" action="" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Jenis Pembayaran</label>
                        <select name="type" id="modal-type-select" required onchange="handleTypeChange()" class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-sm p-4 bg-gray-50/50 text-gray-700 font-bold">
                            <option value="">Pilih Jenis</option>
                            <option value="infak" id="opt-infak">Infak</option>
                            <option value="lk" id="opt-lk">Lembar Kerja (LK)</option>
                            <option value="seragam" id="opt-seragam">Seragam</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Nominal (Rp)</label>
                        <input type="text" inputmode="numeric" name="amount" id="modal-amount-input" required placeholder="Contoh: 50000" class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-sm p-4 bg-gray-50/50" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');">
                        <div id="amount-helper" class="text-[10px] text-gray-400 mt-2 font-medium"></div>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Tanggal Bayar</label>
                        <input type="date" name="paid_at" required value="{{ date('Y-m-d') }}" class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-sm p-4 bg-gray-50/50">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" rows="2" placeholder="Catatan opsional..." class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-sm p-4 bg-gray-50/50"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-400 mb-2">Bukti Pembayaran (Wajib, JPG/PNG, Maks 5MB)</label>
                        <input type="file" name="bukti_pembayaran" required accept=".jpg,.jpeg,.png" class="w-full border-gray-200 focus:border-emerald-500 focus:ring-emerald-500 rounded-2xl shadow-sm text-sm p-3 bg-gray-50/50 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 transition">
                    </div>

                    <!-- Footer buttons -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
                        <button type="button" onclick="closeModal()" class="px-5 py-3 rounded-xl font-bold text-gray-500 hover:bg-gray-50 text-sm transition">Batal</button>
                        <button type="submit" id="modal-submit-btn" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-xl font-black text-sm transition shadow-md active:scale-95">Simpan Pembayaran</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <!-- JS Helper for Modal -->
    <script>
        let currentStudentData = {};

        function openPaymentModal(studentName, kelas, storeUrl, pctLk, targetLk, sisaLk, pctSeragam, targetSeragam, sisaSeragam, pctInfak, sisaInfak) {
            document.getElementById('modal-student-name').innerText = studentName;
            document.getElementById('modal-student-kelas').innerText = 'Kelas ' + kelas;
            document.getElementById('modal-form').action = storeUrl;
            document.getElementById('modal-form').reset();
            
            // Save data for type change handler
            currentStudentData = {
                pctLk: pctLk,
                targetLk: targetLk,
                sisaLk: sisaLk,
                pctSeragam: pctSeragam,
                targetSeragam: targetSeragam,
                sisaSeragam: sisaSeragam,
                pctInfak: pctInfak,
                sisaInfak: sisaInfak
            };

            // Reset UI
            document.getElementById('modal-amount-input').readOnly = false;
            document.getElementById('modal-amount-input').value = '';
            document.getElementById('amount-helper').innerText = '';
            document.getElementById('modal-submit-btn').disabled = false;
            
            // Hide/Show options based on lunas status
            let optLk = document.getElementById('opt-lk');
            let optSeragam = document.getElementById('opt-seragam');
            let optInfak = document.getElementById('opt-infak');

            optLk.style.display = (pctLk >= 100) ? 'none' : 'block';
            optSeragam.style.display = (pctSeragam >= 100) ? 'none' : 'block';
            optInfak.style.display = (pctInfak >= 100) ? 'none' : 'block';
            
            if (pctLk >= 100 && pctSeragam >= 100 && pctInfak >= 100) {
                document.getElementById('modal-submit-btn').disabled = true;
                document.getElementById('amount-helper').innerText = 'Siswa ini sudah melunasi semua tagihan!';
                document.getElementById('amount-helper').classList.add('text-emerald-500');
            } else {
                document.getElementById('amount-helper').classList.remove('text-emerald-500');
            }

            document.getElementById('payment-modal').classList.remove('hidden');
        }

        function handleTypeChange() {
            let type = document.getElementById('modal-type-select').value;
            let inputAmount = document.getElementById('modal-amount-input');
            let helper = document.getElementById('amount-helper');
            
            inputAmount.readOnly = false;
            inputAmount.value = '';
            helper.innerText = '';
            helper.className = 'text-[10px] mt-2 font-medium text-gray-400';

            if (type === 'lk') {
                helper.innerText = '*Bisa dicicil. Sisa target LK: Rp ' + currentStudentData.sisaLk.toLocaleString('id-ID');
            } else if (type === 'seragam') {
                helper.innerText = '*Bisa dicicil. Sisa target seragam: Rp ' + currentStudentData.sisaSeragam.toLocaleString('id-ID');
            } else if (type === 'infak') {
                helper.innerText = '*Bisa dicicil. Sisa target infak: Rp ' + currentStudentData.sisaInfak.toLocaleString('id-ID');
            }
        }

        function closeModal() {
            document.getElementById('payment-modal').classList.add('hidden');
        }

        function openHistoryModal(studentName, payments) {
            document.getElementById('history-student-name').innerText = studentName;
            let tbody = document.getElementById('history-table-body');
            tbody.innerHTML = '';
            
            if (payments.length === 0) {
                tbody.innerHTML = '<tr><td colspan="4" class="p-8 text-center text-gray-400 font-bold">Belum ada riwayat pembayaran.</td></tr>';
            } else {
                payments.forEach(payment => {
                    let typeLabel = payment.type === 'infak' ? 'Infak' : (payment.type === 'lk' ? 'Lembar Kerja' : 'Seragam');
                    
                    let badgeClass = '';
                    if (payment.type === 'infak') badgeClass = 'bg-amber-50 text-amber-600 border-amber-100';
                    else if (payment.type === 'lk') badgeClass = 'bg-blue-50 text-blue-600 border-blue-100';
                    else badgeClass = 'bg-rose-50 text-rose-600 border-rose-100';

                    let amount = new Intl.NumberFormat('id-ID').format(payment.amount);
                    let dateObj = new Date(payment.paid_at);
                    let date = isNaN(dateObj) ? payment.paid_at : dateObj.toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'});
                    
                    let deleteUrl = "{{ route('bendahara.payments.destroy', ':id') }}".replace(':id', payment.id);
                    let buktiHtml = payment.bukti_pembayaran 
                        ? `<a href="/storage/${payment.bukti_pembayaran}" target="_blank" class="text-emerald-500 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-lg text-xs font-bold transition border border-emerald-100 block w-full text-center">Lihat</a>` 
                        : `<span class="text-gray-400 text-[10px] font-bold">-</span>`;
                    
                    let tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-50/50 transition';
                    tr.innerHTML = `
                        <td class="p-4 font-medium text-gray-600">${date}</td>
                        <td class="p-4">
                            <span class="${badgeClass} px-2.5 py-1 rounded-lg text-xs font-bold border">${typeLabel}</span>
                        </td>
                        <td class="p-4 text-right font-black text-gray-800">Rp ${amount}</td>
                        <td class="p-4 text-center">${buktiHtml}</td>
                        <td class="p-4 text-center">
                            <button type="button" onclick="deletePayment('${deleteUrl}')" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 p-2 rounded-lg transition shadow-sm border border-rose-100" title="Hapus Pembayaran">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            }
            
            document.getElementById('history-modal').classList.remove('hidden');
        }

        function closeHistoryModal() {
            document.getElementById('history-modal').classList.add('hidden');
        }

        function deletePayment(url) {
            if (confirm('Yakin ingin menghapus riwayat pembayaran ini? Saldo dan progres pembayaran siswa akan otomatis disesuaikan kembali.')) {
                let form = document.getElementById('delete-payment-form');
                form.action = url;
                form.submit();
            }
        }
    </script>
</x-app-layout>
