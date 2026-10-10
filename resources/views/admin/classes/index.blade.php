<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Pembagian Kelas Siswa') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header Card -->
            <div class="bg-gradient-primary rounded-[2.5rem] p-8 md:p-10 flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-2xl text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10 flex items-center gap-5">
                    <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shrink-0 shadow-[0_0_15px_rgba(251,191,36,0.3)]">
                        <svg class="w-8 h-8 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-xl md:text-2xl font-extrabold text-white">Plotting Rombongan Belajar</h3>
                        <p class="text-sm text-white/90 mt-1 font-medium">Bagi siswa yang telah lulus dan melunasi daftar ulang ke dalam kelas.</p>
                    </div>
                </div>
                
                <div class="relative z-10 flex gap-4">
                    <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-2xl border border-white/20 text-center">
                        <div class="text-[10px] font-black uppercase tracking-widest text-white/70">Siswa Antre</div>
                        <div class="text-2xl font-black text-white mt-1">{{ $unassignedStudents->count() }}</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm px-6 py-3 rounded-2xl border border-white/20 text-center">
                        <div class="text-[10px] font-black uppercase tracking-widest text-white/70">Total Kelas</div>
                        <div class="text-2xl font-black text-white mt-1">{{ $assignedStudents->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- Validation Errors & Success -->
            @if(session('success'))
                <div class="bg-emerald-50 text-emerald-600 px-6 py-4 rounded-2xl border border-emerald-100 flex items-center gap-3 font-bold shadow-sm">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 text-red-600 px-6 py-4 rounded-2xl border border-red-100 flex items-start gap-3 font-bold shadow-sm">
                    <svg class="w-6 h-6 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Kiri: Siswa Belum Dapat Kelas -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden flex flex-col h-[800px]">
                    <div class="p-6 md:p-8 bg-gray-50/50 border-b border-gray-100 shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-2 h-8 bg-blue-600 rounded-full"></span>
                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-wide">Siswa Menunggu Kelas</h3>
                            <span class="ml-auto bg-blue-100 text-blue-700 text-xs font-black px-3 py-1 rounded-full">{{ $unassignedStudents->count() }} Orang</span>
                        </div>
                        <p class="text-xs text-gray-500 font-medium">Pilih siswa di bawah ini, ketik nama kelas, lalu klik "Masukkan ke Kelas".</p>
                    </div>

                    <form action="{{ route('admin.classes.assign') }}" method="POST" class="flex flex-col flex-1 overflow-hidden" id="assignForm">
                        @csrf
                        
                        <!-- Form Kelas (Sticky Header) -->
                        <div class="p-6 border-b border-gray-100 bg-white shrink-0 shadow-sm z-10 flex gap-4">
                            <div class="flex-1">
                                <input type="text" name="kelas" value="7" readonly
                                       class="w-full border-gray-200 bg-gray-100 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-inner font-black text-gray-700 uppercase p-3 transition cursor-not-allowed" title="Siswa PPDB baru otomatis masuk ke Kelas 7">
                                <p class="text-[10px] text-gray-500 mt-1 ml-2 font-bold">*Siswa baru (PPDB) otomatis diplot ke Kelas 7.</p>
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 rounded-xl font-black transition active:scale-95 shadow-md flex items-center gap-2 whitespace-nowrap">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                MASUKKAN
                            </button>
                        </div>

                        <!-- Daftar Siswa (Scrollable) -->
                        <div class="flex-1 overflow-y-auto p-2" style="scrollbar-width: thin;">
                            @if($unassignedStudents->isEmpty())
                                <div class="h-full flex flex-col items-center justify-center text-center p-8">
                                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <h4 class="text-gray-500 font-bold">Semua Lunas Sudah Dapat Kelas</h4>
                                    <p class="text-xs text-gray-400 mt-2">Tidak ada siswa berstatus Diterima & Lunas yang mengantre.</p>
                                </div>
                            @else
                                <div class="space-y-2 p-4">
                                    <div class="flex items-center gap-3 px-4 py-2 bg-gray-50 rounded-lg mb-2">
                                        <input type="checkbox" id="selectAll" class="w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer">
                                        <label for="selectAll" class="text-xs font-bold text-gray-600 cursor-pointer select-none">Pilih Semua</label>
                                    </div>
                                    @foreach($unassignedStudents as $student)
                                        <label class="flex items-start gap-4 p-4 rounded-2xl border border-gray-100 hover:border-blue-300 hover:bg-blue-50/30 cursor-pointer transition group">
                                            <div class="pt-1">
                                                <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" class="student-checkbox w-5 h-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500 cursor-pointer">
                                            </div>
                                            <div class="flex-1">
                                                <h4 class="font-bold text-gray-800 group-hover:text-blue-700 transition">{{ $student->nama_lengkap }}</h4>
                                                <div class="flex flex-wrap items-center gap-2 mt-1">
                                                    <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded font-mono">{{ $student->nisn }}</span>
                                                    <span class="text-[10px] font-black uppercase bg-purple-50 text-purple-600 border border-purple-100 px-2 py-0.5 rounded">{{ $student->jenis_kelamin }}</span>
                                                    <span class="text-[10px] font-black uppercase bg-emerald-50 text-emerald-600 border border-emerald-100 px-2 py-0.5 rounded">{{ $student->jalur_pendaftaran }}</span>
                                                </div>
                                                <p class="text-[10px] text-gray-400 mt-1 truncate max-w-xs" title="{{ $student->asal_sekolah }}"><i class="fas fa-school mr-1"></i> {{ $student->asal_sekolah }}</p>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Kanan: Daftar Kelas -->
                <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden flex flex-col h-[800px]">
                    <div class="p-6 md:p-8 bg-gray-50/50 border-b border-gray-100 shrink-0">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-2 h-8 bg-emerald-500 rounded-full"></span>
                            <h3 class="text-lg font-black text-gray-800 uppercase tracking-wide">Daftar Rombel</h3>
                        </div>
                        <p class="text-xs text-gray-500 font-medium">Klik pada nama kelas untuk melihat daftar siswa atau mencetak PDF.</p>
                    </div>

                    <div class="flex-1 overflow-y-auto p-6 space-y-6" style="scrollbar-width: thin;" x-data="{ openClass: null }">
                        @if($assignedStudents->isEmpty())
                            <div class="h-full flex flex-col items-center justify-center text-center p-8">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <h4 class="text-gray-500 font-bold">Belum Ada Kelas Terbentuk</h4>
                                <p class="text-xs text-gray-400 mt-2">Silakan plot siswa dari panel sebelah kiri terlebih dahulu.</p>
                            </div>
                        @else
                            @foreach($assignedStudents as $kelasName => $studentsInClass)
                                <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300 bg-white shadow-sm hover:shadow-md">
                                    <!-- Accordion Header -->
                                    <button @click="openClass === '{{ $kelasName }}' ? openClass = null : openClass = '{{ $kelasName }}'" 
                                            class="w-full flex items-center justify-between p-5 bg-gray-50/50 hover:bg-gray-100 transition focus:outline-none">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-xl flex items-center justify-center font-black text-xl shadow-inner border border-emerald-200">
                                                {{ $kelasName }}
                                            </div>
                                            <div class="text-left">
                                                <h4 class="font-black text-gray-800 text-lg uppercase">Kelas {{ $kelasName }}</h4>
                                                <p class="text-xs text-gray-500 font-bold mt-0.5">{{ $studentsInClass->count() }} Siswa Terdaftar</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('admin.classes.export.pdf', $kelasName) }}" target="_blank" @click.stop class="bg-highlight hover:bg-yellow-400 text-blue-900 p-2 rounded-lg transition shadow-sm" title="Cetak PDF">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                            </a>
                                            <svg class="w-6 h-6 text-gray-400 transform transition-transform duration-300" :class="{'rotate-180': openClass === '{{ $kelasName }}'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                    </button>

                                    <!-- Accordion Content -->
                                    <div x-show="openClass === '{{ $kelasName }}'" x-collapse x-cloak>
                                        <div class="p-5 border-t border-gray-100 divide-y divide-gray-100">
                                            @foreach($studentsInClass as $index => $s)
                                                <div class="py-3 flex items-center justify-between group">
                                                    <div class="flex items-center gap-3">
                                                        <span class="text-xs font-bold text-gray-400 w-5">{{ $index + 1 }}.</span>
                                                        <div>
                                                            <div class="text-sm font-bold text-gray-800">{{ $s->nama_lengkap }}</div>
                                                            <div class="text-[10px] text-gray-500 font-mono mt-0.5">{{ $s->nisn }} | {{ $s->jenis_kelamin }}</div>
                                                        </div>
                                                    </div>
                                                    <form action="{{ route('admin.classes.remove') }}" method="POST" onsubmit="return confirm('Keluarkan {{ $s->nama_lengkap }} dari kelas ini?');">
                                                        @csrf
                                                        <input type="hidden" name="student_id" value="{{ $s->id }}">
                                                        <button type="submit" class="text-xs font-bold text-red-500 bg-red-50 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg transition opacity-0 group-hover:opacity-100">Keluarkan</button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Script for Select All -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllBtn = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.student-checkbox');
            
            if(selectAllBtn) {
                selectAllBtn.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = selectAllBtn.checked;
                    });
                });
            }
        });
    </script>
</x-app-layout>
