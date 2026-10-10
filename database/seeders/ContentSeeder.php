<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // Home
        Content::updateOrCreate(['type' => 'home_hero'], [
            'title' => 'Selamat Datang di PPDB SMP Muhammadiyah Kaliwiro',
            'body' => 'Wujudkan impian putra-putri Anda menjadi generasi Islami yang cerdas, berprestasi, dan berakhlak mulia.'
        ]);

        Content::updateOrCreate(['type' => 'home_about'], [
            'title' => 'Membangun Masa Depan Bersama SMP Muhammadiyah Kaliwiro',
            'body' => 'Kami berkomitmen untuk menyelenggarakan pendidikan yang memadukan nilai-nilai keislaman dengan keunggulan akademik dan pengembangan karakter. Dengan fasilitas modern dan tenaga pendidik profesional, kami siap membimbing siswa menjadi pribadi yang unggul.'
        ]);

        // Prestasi
        Content::updateOrCreate(['type' => 'prestasi_header'], [
            'title' => 'Prestasi Siswa',
            'body' => 'Bangga atas pencapaian siswa-siswi kami dalam berbagai ajang kompetisi.'
        ]);

        $prestasis = [
            [
                'title' => 'Bulu Tangkis U-15 Putri',
                'body' => '<b>PORDES Selomanik 2025</b><br>Prestasi membanggakan diraih dalam ajang PORDES Selomanik 2025 pada cabang olahraga Bulu Tangkis kategori Putri.'
            ],
            [
                'title' => 'Kejuaraan Futsal Santri',
                'body' => '<b>Festival Santri Muhammadiyah Kabupaten</b><br>Tim futsal sekolah menunjukkan performa luar biasa hingga berhasil meraih posisi Runner Up di tingkat kabupaten.'
            ]
        ];

        foreach ($prestasis as $p) {
            Content::create([
                'type' => 'prestasi',
                'title' => $p['title'],
                'body' => $p['body'],
                'is_active' => true
            ]);
        }

        // Kegiatan
        Content::updateOrCreate(['type' => 'kegiatan_header'], [
            'title' => 'Kegiatan & Ekstrakurikuler',
            'body' => 'Kami memiliki berbagai program unggulan untuk mengembangkan potensi siswa.'
        ]);

        $kegiatans = [
            [
                'title' => 'Tapak Suci',
                'body' => 'Seni bela diri khas Muhammadiyah untuk melatih kekuatan fisik, mental, dan spiritual siswa.'
            ],
            [
                'title' => 'Videografi & Multimedia',
                'body' => 'Mengasah kreativitas siswa dalam bidang perfilman, editing video, dan konten kreatif digital.'
            ]
        ];

        foreach ($kegiatans as $k) {
            Content::create([
                'type' => 'kegiatan',
                'title' => $k['title'],
                'body' => $k['body'],
                'is_active' => true
            ]);
        }

        // Profil
        Content::updateOrCreate(['type' => 'profil'], [
            'title' => 'Profil SMP Muhammadiyah Kaliwiro',
            'body' => '<p>SMP Muhammadiyah Kaliwiro merupakan salah satu lembaga pendidikan menengah pertama di bawah naungan Persyarikatan Muhammadiyah. Berlokasi di wilayah yang strategis, sekolah ini telah menjadi pilihan utama bagi masyarakat sekitar dalam menitipkan putra-putrinya untuk menimba ilmu.</p><h3>Visi & Misi</h3><p>Terwujudnya generasi yang bertaqwa, cerdas, terampil, dan berwawasan lingkungan.</p>'
        ]);

        // Informasi
        Content::updateOrCreate(['type' => 'informasi'], [
            'title' => 'Informasi Pendaftaran 2026/2027',
            'body' => '<p>Pendaftaran Peserta Didik Baru (PPDB) SMP Muhammadiyah Kaliwiro tahun ajaran 2026/2027 telah dibuka. Silakan lengkapi berkas dan ikuti alur pendaftaran yang tersedia.</p>'
        ]);
    }
}
