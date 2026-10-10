<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight tracking-tight">
                {{ __('Edit Konten: ') }} <span class="capitalize">{{ $content->type }}</span>
            </h2>
            <a href="{{ route('admin.contents.index') }}" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-medium text-sm px-4 py-2 rounded-lg transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white shadow-md rounded-2xl overflow-hidden border border-gray-100">
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    <h3 class="text-lg font-bold text-gray-800">Formulir Edit Konten</h3>
                </div>

                <div class="p-6">
                    <form action="{{ route('admin.contents.update', $content->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Tipe / Halaman</label>
                                <input type="text" value="{{ str_replace('_', ' ', $content->type) }}" disabled class="w-full bg-gray-100 border-gray-200 rounded-xl shadow-sm text-gray-500 px-4 py-3 capitalize">
                                <p class="text-[10px] text-gray-400 mt-1">*Tipe konten tidak dapat diubah.</p>
                            </div>
                            <div>
                                <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Judul Konten</label>
                                <input type="text" id="title" name="title" value="{{ old('title', $content->title) }}" required class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900 px-4 py-3 @error('title') border-red-500 @enderror">
                                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="body" class="block text-sm font-bold text-gray-700 mb-2">Isi Konten / Deskripsi</label>
                            <textarea id="body" name="body" rows="8" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm text-gray-900 px-4 py-3 @error('body') border-red-500 @enderror">{{ old('body', $content->body) }}</textarea>
                            @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Konten</label>
                            @if($content->image)
                                <div class="mb-4">
                                    <p class="text-xs text-gray-500 mb-2">Gambar Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $content->image) }}" alt="Current Image" class="w-48 h-32 object-cover rounded-xl shadow-sm border border-gray-200">
                                </div>
                            @endif
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 @error('image') border-red-500 @else border-gray-300 @enderror border-dashed rounded-xl hover:border-blue-400 transition">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 @error('image') text-red-400 @else text-gray-400 @enderror" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                            <span>{{ $content->image ? 'Ganti Gambar' : 'Upload Gambar' }}</span>
                                            <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                        </label>
                                        <p class="pl-1">atau tarik file ke sini</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 5MB</p>
                                </div>
                            </div>
                            @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center gap-2 mb-8">
                            <input type="checkbox" id="is_active" name="is_active" {{ $content->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                            <label for="is_active" class="text-sm font-medium text-gray-700">Tampilkan Konten (Aktif)</label>
                        </div>

                        <div class="flex justify-end pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl transition shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
