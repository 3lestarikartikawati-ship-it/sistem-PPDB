<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Tanya Panitia PPDB') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-[calc(100vh-64px)] flex flex-col">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex-grow flex flex-col">
            
            <!-- Chat Container -->
            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100 flex flex-col flex-grow h-[600px] mb-6 relative">
                <!-- Background Decoration -->
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Chat Header -->
                <div class="bg-gradient-primary p-6 flex items-center gap-4 relative overflow-hidden z-10">
                    <div class="absolute inset-0 bg-black opacity-10"></div>
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-highlight shadow-[0_0_15px_rgba(251,191,36,0.3)] border border-white/20 shrink-0 relative z-10">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path></svg>
                    </div>
                    <div class="relative z-10">
                        <h3 class="text-xl font-extrabold text-white">Panitia PPDB</h3>
                        <p class="text-xs text-white/90 font-medium flex items-center gap-1.5 mt-0.5">
                            <span class="w-2.5 h-2.5 bg-highlight rounded-full animate-pulse shadow-[0_0_8px_rgba(251,191,36,0.8)]"></span>
                            Online | Siap Membantu
                        </p>
                    </div>
                </div>

                <!-- Message List -->
                <div class="flex-grow overflow-y-auto p-6 md:p-8 space-y-6 bg-gray-50/50 z-10" id="chat-box">
                    @forelse($messages as $message)
                        <div class="flex {{ $message->sender === 'student' ? 'justify-end' : 'justify-start' }} animate-[toast-slide-in_0.3s_ease-out]">
                            <div class="max-w-[85%] md:max-w-[70%] {{ $message->sender === 'student' ? 'bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-l-3xl rounded-tr-3xl shadow-md shadow-blue-500/20' : 'bg-white text-gray-800 rounded-r-3xl rounded-tl-3xl shadow-md border border-gray-100' }} p-5 relative group">
                                <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                                <div class="text-[10px] mt-2 opacity-60 flex {{ $message->sender === 'student' ? 'justify-end' : 'justify-start' }} items-center gap-1">
                                    {{ $message->created_at->format('H:i') }}
                                    @if($message->sender === 'student')
                                        <svg class="w-3 h-3 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center h-full text-center p-12">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-50 to-indigo-50 text-blue-300 rounded-full flex items-center justify-center mb-6 shadow-inner border border-white">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-700 mb-2">Belum Ada Percakapan</h4>
                            <p class="text-sm text-gray-400 max-w-xs">Silakan ketik pertanyaan Anda di bawah ini, tim panitia PPDB akan segera membalasnya.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                <div class="p-4 md:p-6 bg-white border-t border-gray-50 z-10 rounded-b-[2.5rem]">
                    <form action="{{ route('siswa.messages.store') }}" method="POST" class="flex gap-3 md:gap-4 items-center">
                        @csrf
                        <div class="relative flex-grow">
                            <input type="text" name="message" required 
                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-3xl shadow-inner text-sm px-6 py-4 bg-gray-50/80 transition"
                                   placeholder="Ketik pesan Anda di sini...">
                        </div>
                        <button type="submit" class="bg-highlight hover:bg-yellow-400 text-blue-900 w-14 h-14 rounded-full shadow-[0_5px_15px_rgba(251,191,36,0.3)] flex items-center justify-center transition transform hover:scale-105 active:scale-95 shrink-0 group">
                            <svg class="w-6 h-6 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Hint -->
            <div class="mt-6 bg-blue-50 rounded-2xl p-4 border border-blue-100 flex items-center gap-3">
                <div class="text-blue-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <p class="text-xs text-blue-700 font-medium">Panitia akan menjawab pertanyaan Anda pada jam kerja (08:00 - 15:00). Anda akan menerima notifikasi jika ada balasan baru.</p>
            </div>
        </div>
    </div>

    <script>
        // Scroll to bottom of chat box
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</x-app-layout>
