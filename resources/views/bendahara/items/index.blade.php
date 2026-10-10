<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Kelola Rincian Biaya') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Total Biaya Header -->
            <div class="mb-10 bg-gradient-primary rounded-[2.5rem] p-8 md:p-10 flex flex-col gap-6 shadow-2xl text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/20 shrink-0 shadow-[0_0_15px_rgba(251,191,36,0.3)]">
                            <svg class="w-8 h-8 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-xl md:text-2xl font-extrabold text-white">Total Biaya Daftar Ulang</h3>
                            <p class="text-sm text-white/90 mt-1 font-medium">Dihitung otomatis dari penjumlahan semua item yang aktif.</p>
                        </div>
                    </div>
                    <div class="relative z-10 text-3xl md:text-4xl font-black text-white bg-white/10 backdrop-blur-sm px-8 py-4 rounded-3xl border border-white/20 shadow-lg">
                        Rp {{ number_format($totalAmount, 0, ',', '.') }}
                    </div>
                </div>

                {{-- Per-Jalur Breakdown --}}
                @php
                    $totalSemua = $items->where('is_active', true)->where('jalur', 'Semua')->sum('amount');
                    $totalReguler = $totalSemua + $items->where('is_active', true)->where('jalur', 'Reguler')->sum('amount');
                    $totalPrestasi = $totalSemua + $items->where('is_active', true)->where('jalur', 'Prestasi')->sum('amount');
                    $totalAfirmasi = $totalSemua + $items->where('is_active', true)->where('jalur', 'Afirmasi')->sum('amount');
                @endphp
                <div class="relative z-10 grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-3 border border-white/15">
                        <div class="text-[10px] font-black uppercase tracking-widest text-white/70">Jalur Reguler</div>
                        <div class="text-lg font-black text-white mt-0.5">Rp {{ number_format($totalReguler, 0, ',', '.') }}</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-3 border border-white/15">
                        <div class="text-[10px] font-black uppercase tracking-widest text-white/70">Jalur Prestasi</div>
                        <div class="text-lg font-black text-white mt-0.5">Rp {{ number_format($totalPrestasi, 0, ',', '.') }}</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-3 border border-white/15">
                        <div class="text-[10px] font-black uppercase tracking-widest text-white/70">Jalur Afirmasi/Beasiswa</div>
                        <div class="text-lg font-black text-white mt-0.5">Rp {{ number_format($totalAfirmasi, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Add New Item Form -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden sticky top-8">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                            <h3 class="font-black text-gray-800 flex items-center gap-2">
                                <span class="w-2 h-6 bg-highlight rounded-full"></span>
                                Tambah Rincian Baru
                            </h3>
                        </div>
                        <form action="{{ route('bendahara.items.store') }}" method="POST" class="p-6">
                            @csrf
                            <div class="space-y-5">
                                <div>
                                    <label for="name" class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Nama Item</label>
                                    <input type="text" name="name" id="name" placeholder="Misal: Seragam Olahraga" required
                                           class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-inner text-sm p-4 bg-gray-50/50 transition">
                                </div>
                                <div>
                                    <label for="amount" class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Harga (Rp)</label>
                                    <input type="text" name="amount" id="amount" placeholder="Misal: 150000 atau 150.000" required
                                           class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-inner text-sm p-4 bg-gray-50/50 transition">
                                </div>
                                <div>
                                    <label for="jalur" class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-2">Berlaku Untuk Jalur</label>
                                    <select name="jalur" id="jalur" required
                                            class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-inner text-sm p-4 bg-gray-50/50 transition font-bold text-gray-700">
                                        <option value="Semua">Semua Jalur</option>
                                        <option value="Reguler">Jalur Reguler</option>
                                        <option value="Prestasi">Jalur Prestasi</option>
                                        <option value="Afirmasi">Jalur Afirmasi/Beasiswa</option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-3 pt-2">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded-md text-blue-600 focus:ring-blue-500 border-gray-300 w-5 h-5 transition">
                                    <label for="is_active" class="text-sm font-bold text-gray-700 cursor-pointer">Item Aktif (Ditagihkan)</label>
                                </div>
                            </div>
                            <div class="mt-8">
                                <button type="submit" class="w-full bg-highlight hover:bg-yellow-400 text-blue-900 px-6 py-4 rounded-2xl font-black transition shadow-[0_5px_15px_rgba(251,191,36,0.3)] active:scale-95 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tambahkan Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Items List -->
                <div class="md:col-span-2">
                    <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-black text-gray-800 flex items-center gap-2">
                                <span class="w-2 h-6 bg-blue-600 rounded-full"></span>
                                Daftar Rincian Biaya
                            </h3>
                            <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-xl uppercase tracking-widest">{{ $items->count() }} Item</span>
                        </div>
                        
                        <div class="divide-y divide-gray-50">
                            @forelse($items as $item)
                                <div class="p-6 hover:bg-gray-50/50 transition" x-data="{ editing: false }">
                                    <!-- View Mode -->
                                    <div x-show="!editing" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-2 h-10 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-gray-300' }}"></div>
                                            <div>
                                                <h4 class="font-bold text-gray-800 {{ $item->is_active ? '' : 'line-through text-gray-400' }}">{{ $item->name }}</h4>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="text-xs font-bold text-gray-500">Rp {{ number_format($item->amount, 0, ',', '.') }}</span>
                                                    <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-blue-50 text-blue-600 border border-blue-100">{{ $item->jalur == 'Semua' ? 'Semua Jalur' : 'Jalur ' . $item->jalur }}</span>
                                                    @if($item->is_active)
                                                        <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-100">Aktif</span>
                                                    @else
                                                        <span class="text-[9px] font-black uppercase tracking-wider px-2 py-0.5 rounded bg-gray-100 text-gray-500 border border-gray-200">Nonaktif</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button @click="editing = true" class="text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">Edit</button>
                                            <form action="{{ route('bendahara.items.destroy', $item) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus rincian biaya ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">Hapus</button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Edit Mode -->
                                    <form x-show="editing" x-cloak action="{{ route('bendahara.items.update', $item) }}" method="POST" class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Nama Item</label>
                                                <input type="text" name="name" value="{{ $item->name }}" required class="w-full border-gray-200 focus:border-blue-500 rounded-lg text-sm p-2">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Harga (Rp)</label>
                                                <input type="text" name="amount" value="{{ round($item->amount) }}" required class="w-full border-gray-200 focus:border-blue-500 rounded-lg text-sm p-2">
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-black text-gray-500 uppercase tracking-widest mb-1">Jalur</label>
                                                <select name="jalur" required class="w-full border-gray-200 focus:border-blue-500 rounded-lg text-sm p-2 font-bold text-gray-700">
                                                    <option value="Semua" {{ $item->jalur === 'Semua' ? 'selected' : '' }}>Semua Jalur</option>
                                                    <option value="Reguler" {{ $item->jalur === 'Reguler' ? 'selected' : '' }}>Reguler</option>
                                                    <option value="Prestasi" {{ $item->jalur === 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                                                    <option value="Afirmasi" {{ $item->jalur === 'Afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" name="is_active" id="edit_active_{{ $item->id }}" value="1" {{ $item->is_active ? 'checked' : '' }} class="rounded text-blue-600 focus:ring-blue-500 border-gray-300">
                                                <label for="edit_active_{{ $item->id }}" class="text-xs font-bold text-gray-700 cursor-pointer">Item Aktif</label>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button type="button" @click="editing = false" class="text-xs font-bold text-gray-500 hover:text-gray-700 px-3 py-1.5">Batal</button>
                                                <button type="submit" class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-4 py-1.5 rounded-lg shadow-md">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <div class="w-16 h-16 bg-gray-100 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada rincian biaya yang ditambahkan.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
