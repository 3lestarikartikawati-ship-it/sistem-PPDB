<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Pesan dari Pendaftar') }}
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
                            <svg class="w-6 h-6 text-highlight" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-extrabold text-white">Daftar Pertanyaan Masuk</h3>
                            <p class="text-sm text-white/90 font-medium font-medium">Pantau dan balas pesan serta konsultasi dari calon pendaftar.</p>
                        </div>
                    </div>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($students as $student)
                        <a href="{{ route('admin.messages.show', $student->id) }}" class="block p-6 hover:bg-blue-50/30 transition group">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl font-black shadow-inner">
                                        {{ substr($student->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="font-bold text-gray-800 group-hover:text-blue-600 transition">{{ $student->nama_lengkap }}</h4>
                                            @if($student->unread_count > 0)
                                                <span class="bg-red-500 text-white text-[10px] font-black px-2 py-0.5 rounded-full ring-4 ring-red-50">
                                                    {{ $student->unread_count }} PESAN BARU
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm text-gray-500 line-clamp-1 italic">
                                            "{{ $student->messages->first()->message }}"
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs font-bold text-gray-400 mb-1">TERAKHIR</div>
                                    <div class="text-sm font-medium text-gray-600">{{ $student->messages->first()->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-12 text-center text-gray-400 italic">
                            Belum ada pesan yang masuk.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
