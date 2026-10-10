<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Manajemen FAQ') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100 mb-10">
                <div class="bg-gradient-primary p-8 md:p-10 flex flex-col md:flex-row justify-between items-center relative overflow-hidden gap-6">
                    <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center shadow-[0_0_15px_rgba(251,191,36,0.3)]">
                            <svg class="w-6 h-6 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-white">Daftar Tanya Jawab Umum</h3>
                            <p class="text-sm text-white/90 font-medium">Kelola pertanyaan yang sering diajukan untuk ditampilkan di landing page.</p>
                        </div>
                    </div>
                    
                    <div class="relative z-10 flex items-center gap-3 w-full md:w-auto">
                        <a href="{{ route('admin.faqs.create') }}" class="flex items-center justify-center gap-2 bg-highlight hover:bg-yellow-400 text-blue-900 px-6 py-4 rounded-2xl font-black transition shadow-[0_5px_15px_rgba(251,191,36,0.3)] w-full md:w-auto active:scale-95 text-xs tracking-wider uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah FAQ
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 font-black text-gray-400 text-[10px] uppercase tracking-[0.2em] w-20 text-center">Urutan</th>
                                <th class="p-4 font-black text-gray-400 text-[10px] uppercase tracking-[0.2em]">Pertanyaan</th>
                                <th class="p-4 font-black text-gray-400 text-[10px] uppercase tracking-[0.2em]">Jawaban</th>
                                <th class="p-4 font-black text-gray-400 text-[10px] uppercase tracking-[0.2em] text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($faqs as $faq)
                            <tr class="hover:bg-blue-50/30 transition">
                                <td class="p-4 text-center">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-gray-600 font-bold text-xs">{{ $faq->order }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $faq->question }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm text-gray-500 line-clamp-2 max-w-md">{{ strip_tags($faq->answer) }}</div>
                                </td>
                                <td class="p-4 text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="inline-flex items-center justify-center w-10 h-10 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl transition shadow-md active:scale-95" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus FAQ ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-10 h-10 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-xl transition shadow-md active:scale-95" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-12 text-center text-gray-400 italic">Belum ada FAQ yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
