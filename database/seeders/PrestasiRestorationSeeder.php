<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Content;

class PrestasiRestorationSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing 'prestasi' records (except header if needed, but seeder will handle it)
        Content::where('type', 'prestasi')->delete();

        $prestasis = [
            [
                'title' => 'Bulu Tangkis U-15 Putri',
                'body' => '<b>PORDES Selomanik 2025</b><br>Prestasi membanggakan diraih dalam ajang PORDES Selomanik 2025 pada cabang olahraga Bulu Tangkis kategori Putri.',
                'image' => 'images/bulutangkis.jpeg'
            ],
            [
                'title' => 'Kejuaraan Futsal Santri',
                'body' => '<b>Festival Santri Muhammadiyah Kabupaten</b><br>Tim futsal sekolah menunjukkan performa luar biasa hingga berhasil meraih posisi Runner Up di tingkat kabupaten.',
                'image' => 'images/prestasi futsal.jpeg'
            ],
            [
                'title' => 'Lulusan Terbaik SBM PTN',
                'body' => '<b>Alumni SMP Muhammadiyah</b><br>Banyak alumni kami yang berhasil menembus perguruan tinggi negeri favorit melalui jalur prestasi.',
                'image' => 'images/prestasi sbmptn.jpeg'
            ]
        ];

        foreach ($prestasis as $p) {
            Content::create([
                'type' => 'prestasi',
                'title' => $p['title'],
                'body' => $p['body'],
                'image' => $p['image'],
                'is_active' => true
            ]);
        }
    }
}
