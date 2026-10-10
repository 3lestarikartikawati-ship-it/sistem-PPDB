@extends('layouts.public')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-6 text-center">{{ $header->title ?? 'Kegiatan & Ekstrakurikuler' }}</h1>
        <div class="w-24 h-1 bg-highlight mx-auto rounded mb-6"></div>
        <div class="text-center text-lg text-gray-600 max-w-3xl mx-auto mb-16">
            {!! $header->body ?? 'Kami memiliki berbagai program unggulan untuk mengembangkan potensi siswa.' !!}
        </div>

        <!-- Section Ekstrakurikuler -->
        <div class="mb-20">
            <div class="flex items-center gap-4 mb-10">
                <div class="bg-blue-600 text-white p-3 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2H3a2 2 0 01-2-2V5a2 2 0 012-2h8V4zM17.5 17.5l4.5 4.5m-4.5-4.5a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Ekstrakurikuler Unggulan</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($extras as $k)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition transform hover:-translate-y-1 group cursor-pointer"
                     @click="lightboxSrc = @js($k->image ? asset('storage/' . $k->image) : 'https://placehold.co/600x400/003366/FFFFFF?text=' . urlencode($k->title)); lightboxOpen = true">
                    <div class="h-64 bg-gray-100 relative overflow-hidden flex items-center justify-center">
                        <img src="{{ $k->image ? asset('storage/' . $k->image) : 'https://placehold.co/600x400/003366/FFFFFF?text=' . urlencode($k->title) }}" alt="{{ $k->title }}" class="w-full h-full object-contain bg-gray-50 transition duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition flex items-center justify-center">
                            <svg class="w-10 h-10 text-blue-600 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $k->title }}</h3>
                        <div class="text-gray-600 text-sm leading-relaxed">
                            {!! $k->body !!}
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-400 italic">Belum ada data ekstrakurikuler.</div>
                @endforelse
            </div>
        </div>

        <hr class="border-gray-100 mb-20">

        <!-- Section Kegiatan Sekolah -->
        <div>
            <div class="flex items-center gap-4 mb-10">
                <div class="bg-amber-500 text-white p-3 rounded-2xl shadow-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Kegiatan Rutin Sekolah</h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($kegiatans as $k)
                <div class="bg-gray-50 rounded-2xl overflow-hidden border border-gray-100 hover:bg-white hover:shadow-lg transition group cursor-pointer"
                     @click="lightboxSrc = @js($k->image ? asset('storage/' . $k->image) : 'https://placehold.co/600x400/003366/FFFFFF?text=' . urlencode($k->title)); lightboxOpen = true">
                    <div class="h-48 bg-gray-100 relative overflow-hidden flex items-center justify-center">
                        <img src="{{ $k->image ? asset('storage/' . $k->image) : 'https://placehold.co/600x400/003366/FFFFFF?text=' . urlencode($k->title) }}" alt="{{ $k->title }}" class="w-full h-full object-contain bg-gray-50 transition duration-500 group-hover:scale-110">
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-gray-800 mb-2">{{ $k->title }}</h3>
                        <div class="text-gray-500 text-xs leading-relaxed line-clamp-3">
                            {{ strip_tags($k->body) }}
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-span-full text-center py-10 text-gray-400 italic">Belum ada data kegiatan rutin.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
