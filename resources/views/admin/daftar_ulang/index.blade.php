<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Verifikasi Daftar Ulang') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <!-- Total Students -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 hover:-translate-y-1 transition transform duration-300">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-0.5">Total Siswa Lulus</span>
                        <span class="text-2xl font-black text-gray-800">{{ $counts['total'] }}</span>
                    </div>
                </div>

                <!-- Total Menunggu -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 relative hover:-translate-y-1 transition transform duration-300">
                    @if($counts['menunggu'] > 0)
                        <span class="absolute top-3 right-3 flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                        </span>
                    @endif
                    <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-0.5">Perlu Verifikasi</span>
                        <span class="text-2xl font-black text-yellow-600">{{ $counts['menunggu'] }}</span>
                    </div>
                </div>

                <!-- Total Revisi -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 relative hover:-translate-y-1 transition transform duration-300">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-0.5">Revisi</span>
                        <span class="text-2xl font-black text-orange-600">{{ $counts['revisi'] }}</span>
                    </div>
                </div>

                <!-- Total Aktif -->
                <div class="bg-white rounded-[2rem] p-6 border border-gray-100 shadow-xl flex items-center gap-4 hover:-translate-y-1 transition transform duration-300">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl shadow-inner shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest block mb-0.5">Selesai (Aktif)</span>
                        <span class="text-2xl font-black text-emerald-600">{{ $counts['aktif'] }}</span>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-3xl p-4 sm:p-6 mb-8 border border-gray-100 shadow-xl flex flex-col sm:flex-row gap-4 items-center justify-between">
                <form action="{{ route('admin.daftar_ulang.index') }}" method="GET" class="w-full flex flex-col sm:flex-row gap-4 items-center">
                    <div class="relative w-full sm:max-w-xs">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors bg-gray-50 hover:bg-white focus:bg-white" placeholder="Cari nama siswa / no pendaftaran...">
                    </div>
                    
                    <select name="status" class="w-full sm:w-auto block py-3 px-4 border border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm transition-colors bg-gray-50 hover:bg-white focus:bg-white font-medium text-gray-700 appearance-none">
                        <option value="">Semua Status</option>
                        <option value="lulus_pendaftaran" {{ request('status') == 'lulus_pendaftaran' ? 'selected' : '' }}>Belum Upload Daftar Ulang</option>
                        <option value="menunggu_daftar_ulang" {{ request('status') == 'menunggu_daftar_ulang' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="revisi_daftar_ulang" {{ request('status') == 'revisi_daftar_ulang' ? 'selected' : '' }}>Revisi Daftar Ulang</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    </select>

                    <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-lg shadow-blue-600/20 active:scale-95 whitespace-nowrap text-sm">
                        FILTER
                    </button>
                    
                    @if(request()->anyFilled(['search', 'status']))
                        <a href="{{ route('admin.daftar_ulang.index') }}" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-3 px-6 rounded-xl transition active:scale-95 whitespace-nowrap text-sm text-center">
                            RESET
                        </a>
                    @endif
                </form>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-xl overflow-hidden">
                <div class="p-6 sm:px-8 sm:py-6 border-b border-gray-100 bg-gradient-to-r from-blue-900 to-blue-800 text-white flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center backdrop-blur-sm border border-white/20">
                            <svg class="w-5 h-5 text-blue-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold">Data Verifikasi Daftar Ulang</h3>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] text-gray-400 uppercase font-black bg-gray-50/50 border-b border-gray-100 tracking-wider">
                            <tr>
                                <th class="px-6 py-5 rounded-tl-3xl">NO REGISTRASI</th>
                                <th class="px-6 py-5">CALON SISWA</th>
                                <th class="px-6 py-5">JALUR</th>
                                <th class="px-6 py-5">STATUS DAFTAR ULANG</th>
                                <th class="px-6 py-5 text-right rounded-tr-3xl">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($students as $student)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">
                                    {{ $student->nomor_pendaftaran }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $student->nama_lengkap }}</span>
                                        <span class="text-gray-500 text-xs">{{ $student->asal_sekolah }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-gray-100 text-gray-700">
                                        {{ $student->jalur_pendaftaran }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($student->status == 'lulus_pendaftaran')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-gray-50 text-gray-500 border border-gray-200/50 shadow-sm">
                                             Belum Upload
                                        </span>
                                    @elseif($student->status == 'menunggu_daftar_ulang')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-yellow-50 text-yellow-700 border border-yellow-200/50 shadow-sm">
                                             <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Perlu Verifikasi
                                        </span>
                                    @elseif($student->status == 'revisi_daftar_ulang')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-orange-50 text-orange-700 border border-orange-200/50 shadow-sm">
                                             <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span> Revisi Berkas
                                        </span>
                                    @elseif($student->status == 'aktif')
                                        <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-[11px] font-black bg-emerald-50 text-emerald-700 border border-emerald-200/50 shadow-sm">
                                             <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <a href="{{ route('admin.daftar_ulang.show', $student->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-blue-600 text-blue-600 hover:text-white border border-blue-100 hover:border-blue-600 font-bold text-[11px] px-4 py-2 rounded-xl transition-all duration-200 shadow-sm group-hover:shadow hover:shadow-md active:scale-95 uppercase tracking-wider">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Verifikasi
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
                                    <p class="text-gray-500">Belum ada siswa di tahap daftar ulang.</p>
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
