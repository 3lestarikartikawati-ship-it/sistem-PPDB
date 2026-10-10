<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class KegiatanRestorationSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing 'kegiatan' records to avoid duplicates during restoration
        Content::where('type', 'kegiatan')->delete();

        $kegiatans = [
            [
                'title' => 'Tapak Suci',
                'body' => 'Seni bela diri khas Muhammadiyah untuk melatih kekuatan fisik, mental, dan spiritual siswa.',
                'image' => 'images/tapak suci.jpeg'
            ],
            [
                'title' => 'Videografi & Multimedia',
                'body' => 'Mengasah kreativitas siswa dalam bidang perfilman, editing video, dan konten kreatif digital.',
                'image' => 'images/video grafi.jpeg'
            ],
            [
                'title' => 'Seni Tilawah',
                'body' => 'Memperdalam seni baca Al-Quran dengan irama yang merdu untuk mengikuti berbagai ajang MTQ.',
                'image' => 'images/tilawah.jpeg'
            ],
            [
                'title' => 'Upacara Bendera',
                'body' => 'Kegiatan rutin setiap Senin pagi untuk memupuk rasa nasionalisme dan patriotisme.',
                'image' => 'images/kegiatan upacara rutin.jpeg'
            ],
            [
                'title' => 'Senam Bersama',
                'body' => 'Menjaga kebugaran jasmani seluruh warga sekolah melalui kegiatan senam rutin.',
                'image' => 'images/senam indonesia sehat.jpeg'
            ],
            [
                'title' => 'Piket Siswa',
                'body' => 'Melatih tanggung jawab dan kerjasama dalam menjaga kebersihan lingkungan sekolah.',
                'image' => 'images/kegiatan piket siswa.jpeg'
            ],
            [
                'title' => 'Sholat Berjamaah',
                'body' => 'Pembiasaan sholat fardhu berjamaah untuk meningkatkan kedisiplinan dan ketaqwaan.',
                'image' => 'images/sholat berjamaah.jpeg'
            ],
            [
                'title' => 'Ngaji Bersama',
                'body' => 'Kegiatan tadarus Al-Quran bersama untuk memperlancar bacaan dan pemahaman ayat suci.',
                'image' => 'images/ngaji bersama.jpeg'
            ]
        ];

        foreach ($kegiatans as $k) {
            Content::create([
                'type' => 'kegiatan',
                'title' => $k['title'],
                'body' => $k['body'],
                'image' => $k['image'],
                'is_active' => true
            ]);
        }
    }
}
