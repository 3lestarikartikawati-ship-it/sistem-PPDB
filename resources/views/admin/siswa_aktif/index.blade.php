<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Kelola Data Siswa') }}
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
                            <svg class="w-6 h-6 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-white">Data Siswa Aktif</h3>
                            <p class="text-sm text-white/90 font-medium">Kelola data siswa kelas 7, 8, dan 9 secara manual atau via Import Excel.</p>
                        </div>
                    </div>
                    
                    <div class="relative z-10 flex items-center gap-3 w-full md:w-auto">
                        <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-4 rounded-2xl font-black transition shadow-[0_5px_15px_rgba(16,185,129,0.3)] w-full md:w-auto active:scale-95 text-xs tracking-wider uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Import Excel
                        </button>
                        <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="flex items-center justify-center gap-2 bg-highlight hover:bg-yellow-400 text-blue-900 px-6 py-4 rounded-2xl font-black transition shadow-[0_5px_15px_rgba(251,191,36,0.3)] w-full md:w-auto active:scale-95 text-xs tracking-wider uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Manual
                        </button>
                    </div>
                </div>
                
                <!-- Filter Tabs -->
                <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap gap-2">
                    <a href="{{ route('admin.active_students.index', request()->except('kelas')) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ !request('kelas') ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Semua Kelas ({{ $counts['semua'] }})
                    </a>
                    <a href="{{ route('admin.active_students.index', array_merge(request()->query(), ['kelas' => '7'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('kelas') == '7' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Kelas 7 ({{ $counts['7'] }})
                    </a>
                    <a href="{{ route('admin.active_students.index', array_merge(request()->query(), ['kelas' => '8'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('kelas') == '8' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Kelas 8 ({{ $counts['8'] }})
                    </a>
                    <a href="{{ route('admin.active_students.index', array_merge(request()->query(), ['kelas' => '9'])) }}" class="px-4 py-2 rounded-full text-sm font-bold transition {{ request('kelas') == '9' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        Kelas 9 ({{ $counts['9'] }})
                    </a>
                </div>

                <!-- Filters Bar -->
                <div class="p-6 bg-gray-50/50 border-b border-gray-100 flex flex-col md:flex-row items-center justify-between gap-4">
                    <form action="{{ route('admin.active_students.index') }}" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-4">
                        @if(request('kelas'))
                            <input type="hidden" name="kelas" value="{{ request('kelas') }}">
                        @endif
                        
                        <!-- Search Input -->
                        <div class="relative w-full sm:w-80">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa / NISN..." 
                                   class="w-full pl-11 border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-sm p-3.5 bg-white">
                        </div>

                        <!-- Submit and Clear -->
                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3.5 rounded-2xl text-sm font-bold shadow-md transition w-full sm:w-auto">Cari</button>
                            @if(request('search') || request('kelas'))
                                <a href="{{ route('admin.active_students.index') }}" class="border border-gray-200 text-gray-500 hover:bg-gray-100 px-6 py-3.5 rounded-2xl text-sm font-bold transition text-center w-full sm:w-auto bg-white shadow-sm">Reset</a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/80 border-b border-gray-100">
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest text-center" style="width: 50px;">No</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest">NISN</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest">Nama Lengkap</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest text-center">Kelas</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest text-center">L/P</th>
                                <th class="p-5 font-black text-gray-400 text-[10px] uppercase tracking-widest text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($students as $index => $student)
                            <tr class="hover:bg-blue-50/40 transition-all duration-200 group border-b border-gray-50 last:border-0">
                                <td class="p-5 text-center font-bold text-gray-400">{{ $students->firstItem() + $index }}</td>
                                <td class="p-5 whitespace-nowrap">
                                    <span class="font-bold text-gray-800 font-mono text-sm bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">{{ $student->nisn }}</span>
                                </td>
                                <td class="p-5">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 border border-blue-200 flex items-center justify-center shrink-0">
                                            <span class="font-black text-blue-700">{{ substr($student->nama_lengkap, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <div class="font-black text-gray-900">{{ $student->nama_lengkap }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-center">
                                    <div class="text-sm font-bold text-blue-700 bg-blue-50 inline-block px-3 py-1.5 rounded-xl border border-blue-100">Kelas {{ $student->kelas ?? '-' }}</div>
                                </td>
                                <td class="p-5 text-center">
                                    @if(strtoupper($student->jenis_kelamin) == 'L')
                                        <span class="px-3 py-1 bg-cyan-100 text-cyan-700 text-xs font-black rounded-full">L</span>
                                    @else
                                        <span class="px-3 py-1 bg-pink-100 text-pink-700 text-xs font-black rounded-full">P</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center whitespace-nowrap">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.active_students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini beserta akun dan riwayat pembayarannya?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center bg-white hover:bg-red-50 text-red-500 hover:text-red-700 border border-red-100 font-bold p-2.5 rounded-xl transition-all shadow-sm group-hover:shadow hover:shadow-md">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center">
                                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Belum ada data</h3>
                                    <p class="text-gray-500">Belum ada data siswa di kelas ini.</p>
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

    <!-- Modal Tambah Siswa -->
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-lg w-full overflow-hidden border border-gray-100 transform transition-all scale-100 my-8">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-extrabold text-gray-900">Tambah Data Siswa</h3>
                    <button onclick="document.getElementById('addModal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('admin.active_students.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">NISN</label>
                        <input type="text" name="nisn" required class="w-full border-gray-200 focus:border-blue-500 rounded-xl bg-gray-50 p-4">
                    </div>
                    <div>
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" required class="w-full border-gray-200 focus:border-blue-500 rounded-xl bg-gray-50 p-4">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="w-full border-gray-200 focus:border-blue-500 rounded-xl bg-gray-50 p-4 font-bold">
                                <option value="L">Laki-Laki (L)</option>
                                <option value="P">Perempuan (P)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Kelas</label>
                            <select name="kelas" required class="w-full border-gray-200 focus:border-blue-500 rounded-xl bg-gray-50 p-4 font-bold">
                                <option value="7">Kelas 7</option>
                                <option value="8">Kelas 8</option>
                                <option value="9">Kelas 9</option>
                            </select>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3 mt-8">
                        <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition">Batal</button>
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-black rounded-xl shadow-lg transition active:scale-95">Simpan Siswa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Import Excel -->
    <div id="importModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-md flex items-center justify-center p-4">
        <div class="bg-white rounded-[2.5rem] shadow-2xl max-w-md w-full overflow-hidden border border-gray-100 transform transition-all scale-100">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-extrabold text-gray-900">Import Data Excel</h3>
                    <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="bg-blue-50 text-blue-800 p-4 rounded-xl mb-6 text-sm border border-blue-100">
                    <p class="font-bold mb-2">Pastikan kolom baris pertama di file berisi persis:</p>
                    <code class="block bg-white p-2 rounded text-xs font-mono shadow-sm">nisn; nama_lengkap; jenis_kelamin</code>
                </div>

                <form action="{{ route('admin.active_students.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-5">
                        <label class="block text-xs font-black uppercase tracking-wider text-gray-500 mb-2">Pilih Kelas untuk Data Ini</label>
                        <select name="kelas" required class="w-full border-gray-200 focus:border-emerald-500 rounded-xl bg-gray-50 p-4 font-bold">
                            <option value="">Pilih Kelas</option>
                            <option value="7">Kelas 7</option>
                            <option value="8">Kelas 8</option>
                            <option value="9">Kelas 9</option>
                        </select>
                    </div>
                    <div class="mb-8 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-2xl hover:border-emerald-500 hover:bg-emerald-50 transition p-8 text-center" onclick="document.getElementById('fileInput').click()">
                        <svg class="w-12 h-12 text-gray-400 group-hover:text-emerald-500 mx-auto mb-4 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                        <p class="font-bold text-gray-700 group-hover:text-emerald-700">Pilih File Excel (.xlsx/.csv)</p>
                        <p id="fileName" class="text-xs text-gray-500 mt-2 truncate max-w-full">Klik untuk mencari file</p>
                        <input type="file" id="fileInput" name="file" accept=".xlsx,.xls,.csv" class="hidden" onchange="document.getElementById('fileName').innerText = this.files[0].name" required>
                    </div>
                    
                    <div class="flex justify-end gap-3 border-t border-gray-100 pt-6">
                        <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition">Batal</button>
                        <button type="submit" class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl shadow-lg transition active:scale-95">Mulai Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
