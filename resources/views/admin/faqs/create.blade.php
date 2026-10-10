<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
            {{ __('Tambah FAQ') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-3xl overflow-hidden border border-gray-100">
                <div class="p-8 border-b border-gray-50 bg-gray-50/30">
                    <h3 class="text-xl font-black text-gray-800 flex items-center gap-3">
                        <span class="w-2 h-8 bg-blue-600 rounded-full"></span>
                        Informasi FAQ Baru
                    </h3>
                </div>

                <form action="{{ route('admin.faqs.store') }}" method="POST" class="p-8">
                    @csrf
                    <div class="space-y-6">
                        <div>
                            <label for="question" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-2">Pertanyaan</label>
                            <input type="text" name="question" id="question" required 
                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50"
                                   placeholder="Contoh: Bagaimana cara daftar ulang?">
                        </div>

                        <div>
                            <label for="answer" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-2">Jawaban</label>
                            <textarea name="answer" id="answer" rows="5" required 
                                      class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-medium p-4 bg-gray-50/50"
                                      placeholder="Masukkan jawaban lengkap di sini..."></textarea>
                        </div>

                        <div class="w-1/3">
                            <label for="order" class="block text-sm font-black text-gray-700 uppercase tracking-wider mb-2">Urutan Tampil</label>
                            <input type="number" name="order" id="order" value="0"
                                   class="w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-2xl shadow-sm text-gray-800 font-bold p-4 bg-gray-50/50">
                        </div>
                    </div>

                    <div class="mt-12 flex items-center justify-end gap-4">
                        <a href="{{ route('admin.faqs.index') }}" class="px-6 py-3 rounded-2xl font-bold text-gray-500 hover:bg-gray-100 transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black shadow-lg shadow-blue-500/20 transition-all active:scale-95 flex items-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            SIMPAN FAQ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
