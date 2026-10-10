@extends('layouts.public')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-black text-blue-900 mb-4 tracking-tight">{{ $header->title ?? 'Berita Terkini' }}</h1>
            <div class="w-20 h-1.5 bg-highlight mx-auto rounded-full mb-6"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto font-medium">
                {{ $header->body ?? 'Ikuti perkembangan terbaru, informasi penting, dan artikel menarik seputar SMP Muhammadiyah Kaliwiro.' }}
            </p>
        </div>

        <!-- News Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($beritas as $b)
            <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-xl transition duration-500 group">
                <!-- Image Wrapper -->
                <div class="h-56 overflow-hidden relative">
                    <img src="{{ $b->image ? asset('storage/' . $b->image) : 'https://placehold.co/600x400/0f172a/FFFFFF?text=Berita' }}" 
                         alt="{{ $b->title }}" 
                         class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                    <div class="absolute top-4 left-4">
                        <span class="bg-blue-600 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest shadow-lg">
                            {{ $b->created_at->format('d M Y') }}
                        </span>
                    </div>
                </div>

                <!-- Content Wrapper -->
                <div class="p-6 flex-grow flex flex-col">
                    <h2 class="text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-600 transition duration-300 line-clamp-2">
                        {{ $b->title }}
                    </h2>
                    <div class="text-gray-500 text-sm leading-relaxed mb-6 line-clamp-3">
                        {!! strip_tags($b->body) !!}
                    </div>
                    <div class="mt-auto pt-4 border-t border-gray-50">
                        <button @click="lightboxSrc = @js($b->image ? asset('storage/' . $b->image) : 'https://placehold.co/600x400/0f172a/FFFFFF?text=Berita'); lightboxOpen = true" 
                                class="text-blue-600 font-bold text-sm flex items-center gap-2 group/btn">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 transition-transform group-hover/btn:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </button>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full py-20 text-center">
                <div class="bg-white rounded-3xl p-12 shadow-sm border border-dashed border-gray-300 inline-block mx-auto">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2zM14 2v4h4"></path></svg>
                    <p class="text-gray-400 font-medium italic">Belum ada berita yang dipublikasikan saat ini.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
