@extends('layouts.public')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-blue-900 mb-6 text-center">{{ $header->title ?? 'Prestasi Siswa' }}</h1>
        <div class="w-24 h-1 bg-highlight mx-auto rounded mb-6"></div>
        <div class="text-center text-lg text-gray-600 max-w-3xl mx-auto mb-16">
            {!! $header->body ?? 'Bangga atas pencapaian siswa-siswi kami dalam berbagai ajang kompetisi.' !!}
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse ($prestasis as $p)
            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden group hover:shadow-2xl transition duration-500">
                <div class="h-64 bg-gray-100 relative overflow-hidden flex items-center justify-center cursor-pointer" 
                     @click="lightboxSrc = @js($p->image ? asset('storage/' . $p->image) : 'https://placehold.co/600x400/003366/FFFFFF?text=' . urlencode($p->title)); lightboxOpen = true">
                    <img src="{{ $p->image ? asset('storage/' . $p->image) : 'https://placehold.co/600x400/003366/FFFFFF?text=' . urlencode($p->title) }}" alt="{{ $p->title }}" class="w-full h-full object-contain bg-gray-50 transition duration-500 group-hover:scale-105">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition flex items-center justify-center">
                        <svg class="w-10 h-10 text-blue-600 opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>
                </div>
                <div class="p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-3 leading-tight">{{ $p->title }}</h3>
                    <div class="text-gray-600 text-sm leading-relaxed">
                        {!! $p->body !!}
                    </div>
                </div>
            </div>
            @empty
                <div class="col-span-full text-center py-20 text-gray-400 italic">Belum ada data prestasi yang ditambahkan.</div>
            @endforelse
        </div>

        <div class="mt-20 bg-blue-50 rounded-3xl p-10 border border-blue-100 text-center">
            <h2 class="text-2xl font-bold text-blue-900 mb-4">Ingin Menjadi Bagian dari Generasi Berprestasi?</h2>
            <p class="text-blue-700 mb-8 max-w-2xl mx-auto text-lg">Daftarkan diri Anda sekarang dan kembangkan potensi terbaik Anda bersama kami di SMP Muhammadiyah Kaliwiro.</p>
            <a href="{{ url('/pendaftaran') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-full font-bold shadow-lg transition transform hover:-translate-y-1 inline-block">Daftar Sekarang</a>
        </div>
    </div>
</div>
@endsection
