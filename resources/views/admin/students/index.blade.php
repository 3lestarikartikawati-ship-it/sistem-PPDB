<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Data Pendaftar') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100 mb-10">
                <!-- Header / Toolbar -->
                <div class="bg-gradient-primary p-8 md:p-10 flex flex-col md:flex-row justify-between items-center relative overflow-hidden gap-6">
                    <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center shadow-[0_0_15px_rgba(251,191,36,0.3)]">
                            <svg class="w-6 h-6 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-white">Daftar Calon Siswa Baru</h3>
                            <p class="text-sm text-white/90 font-medium">Kelola dan verifikasi status pendaftaran calon siswa.</p>
                        </div>
                    </div>
                    
                    <div class="relative z-10 flex items-center gap-3 w-full md:w-auto">
                        <a href="{{ route('admin.students.export.pdf') }}" class="flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white px-6 py-4 rounded-2xl font-black transition shadow-[0_5px_15px_rgba(239,68,68,0.3)] w-full md:w-auto active:scale-95 text-xs tracking-wider uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            Export PDF
                        </a>
                        <a href="{{ route('admin.students.export') }}" class="flex items-center justify-center gap-2 bg-highlight hover:bg-yellow-400 text-blue-900 px-6 py-4 rounded-2xl font-black transition shadow-[0_5px_15px_rgba(251,191,36,0.3)] w-full md:w-auto active:scale-95 text-xs tracking-wider uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export CSV
                        </a>
                    </div>
                </div>
                
                <!-- Filter Tabs -->
                <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap gap-2">
                    <a href="{{ route('admin.students.index', request()->except('jalur')) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ !request('jalur') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua Pendaftar ({{ $counts['semua'] }})
                    </a>
                    <a href="{{ route('admin.students.index', array_merge(request()->query(), ['jalur' => 'Reguler'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('jalur') == 'Reguler' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Jalur Reguler ({{ $counts['Reguler'] }})
                    </a>
                    <a href="{{ route('admin.students.index', array_merge(request()->query(), ['jalur' => 'Prestasi'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('jalur') == 'Prestasi' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Jalur Prestasi ({{ $counts['Prestasi'] }})
                    </a>
                    <a href="{{ route('admin.students.index', array_merge(request()->query(), ['jalur' => 'Afirmasi'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('jalur') == 'Afirmasi' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Jalur Afirmasi/Beasiswa ({{ $counts['Afirmasi'] }})
                    </a>
                </div>

                <!-- Filters Bar -->
                <div class="p-6 bg-gray-50/50 border-b border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                    <form action="{{ route('admin.students.index') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-4">
                        @if(request('jalur'))
                            <input type="hidden" name="jalur" value="{{ request('jalur') }}">
                        @endif
                        
                        <!-- Search Input -->
                        <div class="relative w-full sm:w-80">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa / no pendaftaran..." 
                                   class="w-full pl-11 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-sm p-3.5 bg-white">
                        </div>

                        <!-- Status Selector -->
                        <div class="w-full sm:w-48">
                            <select name="status" onchange="this.form.submit()" 
                                    class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-sm p-3.5 bg-white text-gray-700 font-bold">
                                <option value="">Semua Status</option>
                                <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="revisi_pendaftaran" {{ request('status') === 'revisi_pendaftaran' ? 'selected' : '' }}>Revisi Pendaftaran</option>
                                <option value="lulus_pendaftaran" {{ request('status') === 'lulus_pendaftaran' ? 'selected' : '' }}>Lulus Pendaftaran</option>
                                <option value="menunggu_daftar_ulang" {{ request('status') === 'menunggu_daftar_ulang' ? 'selected' : '' }}>Menunggu Daftar Ulang</option>
                                <option value="revisi_daftar_ulang" {{ request('status') === 'revisi_daftar_ulang' ? 'selected' : '' }}>Revisi Daftar Ulang</option>
                                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="cadangan" {{ request('status') === 'cadangan' ? 'selected' : '' }}>Cadangan</option>
                                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <!-- Submit and Clear -->
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-2xl text-sm font-bold shadow-md transition w-full sm:w-auto">Cari</button>
                            @if(request('search') || request('status') || request('jalur'))
                                <a href="{{ route('admin.students.index') }}" class="border border-gray-200 text-gray-500 hover:bg-gray-100 px-6 py-3.5 rounded-2xl text-sm font-bold transition text-center w-full sm:w-auto bg-white shadow-sm">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 border-b border-gray-100">
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest">No Registrasi</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest">Calon Siswa</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest">Asal Sekolah</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest">Status Lulus</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($students as $student)
                            <tr class="hover:bg-blue-50/40 transition-all duration-200 group border-b border-gray-50 last:border-0">
                                <td class="p-5 whitespace-nowrap">
                                    <span class="font-bold text-gray-800 font-mono text-sm bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">{{ $student->nomor_pendaftaran }}</span>
                                </td>
                                <td class="p-5">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 border border-blue-200 flex items-center justify-center shrink-0">
                                            <span class="font-black text-blue-700">{{ substr($student->nama_lengkap, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900">{{ $student->nama_lengkap }}</div>
                                            <div class="text-[11px] font-medium text-gray-500 mt-1 flex items-center gap-2">
                                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg> {{ $student->user->no_hp ?? '-' }}</span>
                                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                <span class="text-blue-600 font-bold bg-blue-50 px-2 py-0.5 rounded-md uppercase tracking-wider text-[9px] border border-blue-100">{{ $student->jalur_pendaftaran }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5">
                                    <div class="text-sm font-bold text-gray-700 bg-gray-50 inline-block px-3 py-1.5 rounded-xl border border-gray-100">{{ $student->asal_sekolah }}</div>
                                </td>
                                <td class="p-5 whitespace-nowrap">
                                    @if($student->status == 'menunggu')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-yellow-50 text-yellow-700 border border-yellow-200/50 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Menunggu
                                        </span>
                                    @elseif($student->status == 'revisi_pendaftaran')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-orange-50 text-orange-700 border border-orange-200/50 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Revisi
                                        </span>
                                    @elseif($student->status == 'lulus_pendaftaran')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lulus Tahap 1
                                        </span>
                                    @elseif($student->status == 'menunggu_daftar_ulang')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-blue-50 text-blue-700 border border-blue-200/50 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> Verif. Tahap 2
                                        </span>
                                    @elseif($student->status == 'revisi_daftar_ulang')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-orange-50 text-orange-700 border border-orange-200/50 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Revisi DU
                                        </span>
                                    @elseif($student->status == 'aktif')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                        </span>
                                    @elseif($student->status == 'cadangan')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-blue-50 text-blue-700 border border-blue-200/50 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Cadangan
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-red-50 text-red-700 border border-red-200/50 shadow-sm">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="p-5 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.students.show', $student->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-blue-600 text-blue-600 hover:text-white border border-blue-100 hover:border-blue-600 font-bold text-[11px] px-4 py-2 rounded-xl transition-all duration-200 shadow-sm group-hover:shadow hover:shadow-md active:scale-95 uppercase tracking-wider">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada data</h3>
                                    <p class="text-gray-500">Belum ada calon siswa yang mendaftar saat ini.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($students->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50">
                    {{ $students->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
