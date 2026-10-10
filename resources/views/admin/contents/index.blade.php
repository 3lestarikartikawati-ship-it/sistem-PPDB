<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Manajemen Konten Website') }}
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
                            <svg class="w-6 h-6 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-white">Daftar Konten Publik</h3>
                            <p class="text-sm text-white/90 font-medium">Kelola teks dan gambar untuk seluruh halaman utama website.</p>
                        </div>
                    </div>
                    
                    <div class="relative z-10 flex items-center gap-3 w-full md:w-auto">
                        <a href="{{ route('admin.contents.create') }}" class="flex items-center justify-center gap-2 bg-highlight hover:bg-yellow-400 text-blue-900 px-6 py-4 rounded-2xl font-black transition shadow-[0_5px_15px_rgba(251,191,36,0.3)] w-full md:w-auto active:scale-95 text-xs tracking-wider uppercase">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Konten Baru
                        </a>
                    </div>
                </div>



                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-200">
                                <th class="p-4 font-semibold text-gray-600 text-sm uppercase tracking-wider">Tipe</th>
                                <th class="p-4 font-semibold text-gray-600 text-sm uppercase tracking-wider">Konten</th>
                                <th class="p-4 font-semibold text-gray-600 text-sm uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($contents as $content)
                            <tr class="hover:bg-blue-50/50 transition duration-150">
                                <td class="p-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200 capitalize w-fit">
                                            {{ str_replace('_', ' ', $content->type) }}
                                        </span>
                                        @if($content->image)
                                            <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                Ada Gambar
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $content->title }}</div>
                                    <div class="text-sm text-gray-500 mt-1 truncate max-w-md">{{ strip_tags($content->body) }}</div>
                                </td>
                                <td class="p-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.contents.edit', $content->id) }}" class="inline-flex items-center justify-center w-10 h-10 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl transition shadow-md active:scale-95" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('admin.contents.destroy', $content->id) }}" method="POST" onsubmit="return confirm('Hapus konten ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center justify-center w-10 h-10 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-xl transition shadow-md active:scale-95" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
