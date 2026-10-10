<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-gradient-primary rounded-[2.5rem] shadow-2xl p-10 mb-10 text-white relative overflow-hidden">
                <div class="relative z-10 flex items-center gap-6">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shadow-[0_0_15px_rgba(251,191,36,0.3)] shrink-0">
                        <svg class="w-8 h-8 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h3>
                        <p class="text-white/90 font-medium">Kelola data seluruh siswa aktif kelas 7, 8, dan 9 secara terpusat.</p>
                    </div>
                </div>
                <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-10">
                <!-- Total Pendaftar -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mr-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Pendaftar</div>
                        <div class="text-2xl font-black text-gray-800">{{ $totalPendaftar }}</div>
                    </div>
                </div>
                <!-- Total Siswa Aktif -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mr-4">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Siswa Aktif</div>
                        <div class="text-2xl font-black text-gray-800">{{ $totalSiswa }}</div>
                    </div>
                </div>

                <!-- Kelas 7 -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mr-4">
                        <span class="font-black text-2xl">7</span>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Siswa Kelas 7</div>
                        <div class="text-xl font-black text-gray-800">{{ $kelas7 }}</div>
                    </div>
                </div>

                <!-- Kelas 8 -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mr-4">
                        <span class="font-black text-2xl">8</span>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Siswa Kelas 8</div>
                        <div class="text-xl font-black text-gray-800">{{ $kelas8 }}</div>
                    </div>
                </div>

                <!-- Kelas 9 -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 p-6 flex items-center hover:-translate-y-1 transition transform duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mr-4">
                        <span class="font-black text-2xl">9</span>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Siswa Kelas 9</div>
                        <div class="text-xl font-black text-gray-800">{{ $kelas9 }}</div>
                    </div>
                </div>
            </div>

            <!-- Recent Data Split -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Pendaftar -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-indigo-50/50">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-6 bg-indigo-600 rounded-full"></span>
                            5 Pendaftar Baru (Calon Siswa)
                        </h3>
                        <a href="{{ route('admin.students.index') }}" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-4 py-2 rounded-xl transition uppercase tracking-widest">Lihat Semua</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentPendaftar as $student)
                        <div class="p-4 hover:bg-indigo-50/30 transition flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-full flex items-center justify-center text-indigo-600 font-black shadow-sm">
                                    {{ substr($student->nama_lengkap, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="font-bold text-gray-800">{{ $student->nama_lengkap }}</div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase mt-0.5">Reg: {{ $student->nomor_pendaftaran }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-[10px] font-black rounded-full">{{ str_replace('_', ' ', $student->status) }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center text-gray-400 font-medium italic">Belum ada pendaftar baru.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Siswa Aktif -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-emerald-50/50">
                        <h3 class="text-lg font-black text-gray-800 flex items-center gap-2">
                            <span class="w-2 h-6 bg-emerald-500 rounded-full"></span>
                            5 Siswa Aktif Baru
                        </h3>
                        <a href="{{ route('admin.active_students.index') }}" class="text-[10px] font-black text-emerald-600 hover:text-emerald-800 bg-emerald-50 px-4 py-2 rounded-xl transition uppercase tracking-widest">Lihat Semua</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentSiswaAktif as $student)
                        <div class="p-4 hover:bg-emerald-50/30 transition flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-emerald-50 to-teal-50 rounded-full flex items-center justify-center text-emerald-600 font-black shadow-sm">
                                    {{ substr($student->nama_lengkap, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="font-bold text-gray-800">{{ $student->nama_lengkap }}</div>
                                    <div class="text-[10px] text-gray-400 font-bold uppercase mt-0.5">NISN: {{ $student->nisn }}</div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-3 py-1 bg-gray-100 text-gray-600 text-[10px] font-black rounded-full">Kelas {{ $student->kelas }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center text-gray-400 font-medium italic">Belum ada siswa aktif.</div>
                        @endforelse
                    </div>
                </div>
            </div>
            
        </div>
    </div>

</x-app-layout>
