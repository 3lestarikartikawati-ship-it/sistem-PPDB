<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.messages.index') }}" class="p-2 hover:bg-gray-100 rounded-xl transition text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Percakapan dengan :name', ['name' => $student->nama_lengkap]) }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-[calc(100vh-64px)] flex flex-col">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex-grow flex flex-col">
            
            <div class="bg-white shadow-2xl rounded-[2.5rem] overflow-hidden border border-gray-100 flex flex-col flex-grow h-[600px] mb-10">
                
                <!-- Chat Header Info -->
                <div class="bg-gradient-primary p-6 flex items-center justify-between relative overflow-hidden shrink-0">
                    <div class="absolute inset-0 bg-black opacity-10 pointer-events-none"></div>
                    <div class="absolute -right-24 -top-24 w-64 h-64 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
                    
                    <div class="relative z-10 flex items-center gap-4">
                        <div class="w-12 h-12 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl flex items-center justify-center font-black text-white shadow-[0_0_15px_rgba(251,191,36,0.3)]">
                            {{ substr($student->nama_lengkap, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-extrabold text-white text-lg leading-tight">{{ $student->nama_lengkap }}</h3>
                            <p class="text-xs text-white/90 mt-0.5 font-medium">{{ $student->nomor_pendaftaran }}</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.students.show', $student->id) }}" class="bg-white/15 hover:bg-white/25 text-white border border-white/20 px-4 py-2.5 rounded-xl transition font-black text-xs uppercase tracking-widest relative z-10">
                        Profil Siswa
                    </a>
                </div>

                <!-- Message List -->
                <div class="flex-grow overflow-y-auto p-8 space-y-6 bg-gray-50/20" id="chat-box">
                    @foreach($messages as $message)
                        <div class="flex {{ $message->sender === 'admin' ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%]">
                                <div class="flex items-center gap-2 mb-1 px-2">
                                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">
                                        {{ $message->sender === 'admin' ? 'Anda' : 'Siswa' }}
                                    </span>
                                    <span class="text-[10px] text-gray-300">•</span>
                                    <span class="text-[10px] font-medium text-gray-400">
                                        {{ $message->created_at->format('d M, H:i') }}
                                    </span>
                                </div>
                                <div class="p-4 {{ $message->sender === 'admin' ? 'bg-blue-600 text-white rounded-l-3xl rounded-tr-3xl shadow-lg shadow-blue-500/10' : 'bg-white text-gray-800 rounded-r-3xl rounded-tl-3xl shadow-sm border border-gray-100' }}">
                                    <p class="text-sm leading-relaxed">{{ $message->message }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Reply Input -->
                <div class="p-6 bg-white border-t border-gray-50">
                    <form action="{{ route('admin.messages.store', $student->id) }}" method="POST" class="flex gap-4">
                        @csrf
                        <textarea name="message" required rows="1"
                               class="flex-grow border-gray-100 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-inner text-sm p-4 bg-gray-50/50 resize-none"
                               placeholder="Tulis balasan Anda..."></textarea>
                        <button type="submit" class="bg-highlight hover:bg-yellow-400 text-blue-900 px-8 rounded-2xl shadow-[0_5px_15px_rgba(251,191,36,0.3)] transition-all active:scale-95 flex items-center justify-center font-black text-xs uppercase tracking-widest shrink-0">
                            Kirim Balasan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const chatBox = document.getElementById('chat-box');
        chatBox.scrollTop = chatBox.scrollHeight;
    </script>
</x-app-layout>
