<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'ppdb_quota',
                'name' => 'Total Kuota (Seluruh Gelombang)',
                'value' => '200',
                'type' => 'number',
            ],
            [
                'key' => 'quota_gel1',
                'name' => 'Kuota Gelombang 1',
                'value' => '100',
                'type' => 'number',
            ],
            [
                'key' => 'quota_gel2',
                'name' => 'Kuota Gelombang 2',
                'value' => '100',
                'type' => 'number',
            ],
            [
                'key' => 'tgl_mulai_gel1',
                'name' => 'Mulai Gelombang 1',
                'value' => '2026-05-01',
                'type' => 'date',
            ],
            [
                'key' => 'tgl_selesai_gel1',
                'name' => 'Selesai Gelombang 1',
                'value' => '2026-05-31',
                'type' => 'date',
            ],
            [
                'key' => 'tgl_mulai_gel2',
                'name' => 'Mulai Gelombang 2',
                'value' => '2026-06-01',
                'type' => 'date',
            ],
            [
                'key' => 'tgl_selesai_gel2',
                'name' => 'Selesai Gelombang 2',
                'value' => '2026-06-30',
                'type' => 'date',
            ],
            [
                'key' => 'tgl_pengumuman',
                'name' => 'Tanggal Pengumuman Akhir',
                'value' => '2026-07-05',
                'type' => 'date',
            ],
            [
                'key' => 'tgl_mulai_daftar_ulang',
                'name' => 'Mulai Daftar Ulang',
                'value' => '2026-07-10',
                'type' => 'date',
            ],
            [
                'key' => 'tgl_selesai_daftar_ulang',
                'name' => 'Selesai Daftar Ulang',
                'value' => '2026-07-31',
                'type' => 'date',
            ],
            [
                'key' => 'payment_amount',
                'name' => 'Biaya Daftar Ulang (Rupiah)',
                'value' => '750000',
                'type' => 'number',
            ],
            [
                'key' => 'payment_bank',
                'name' => 'Nama Bank Penerima',
                'value' => 'Bank Syariah Indonesia (BSI)',
                'type' => 'text',
            ],
            [
                'key' => 'payment_rekening',
                'name' => 'Nomor Rekening Penerima',
                'value' => '7149028882',
                'type' => 'text',
            ],
            [
                'key' => 'payment_penerima',
                'name' => 'Nama Pemilik Rekening',
                'value' => 'Panitia PPDB SMP Muhammadiyah Kaliwiro',
                'type' => 'text',
            ],
            [
                'key' => 'payment_qris_image',
                'name' => 'Kode QRIS Sekolah (Unggah Gambar)',
                'value' => null,
                'type' => 'file',
            ],
            [
                'key' => 'jalur_reguler_aktif',
                'name' => 'Jalur Reguler Aktif',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'jalur_reguler_req_rapor',
                'name' => 'Reguler: Wajib Upload Rapor',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'jalur_prestasi_aktif',
                'name' => 'Jalur Prestasi Aktif',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'jalur_prestasi_req_rapor',
                'name' => 'Prestasi: Wajib Upload Rapor',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'jalur_prestasi_req_prestasi',
                'name' => 'Prestasi: Wajib Upload Prestasi',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'jalur_afirmasi_aktif',
                'name' => 'Jalur Afirmasi Aktif',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'jalur_afirmasi_req_rapor',
                'name' => 'Afirmasi: Wajib Upload Rapor',
                'value' => '1',
                'type' => 'boolean',
            ],
            [
                'key' => 'jalur_afirmasi_req_beasiswa',
                'name' => 'Afirmasi: Wajib Upload KIP/SKTM',
                'value' => '1',
                'type' => 'boolean',
            ],
            // Rincian Biaya (dikelola Bendahara)
            [
                'key' => 'biaya_infak',
                'name' => 'Biaya Infak (6 bulan)',
                'value' => '180000',
                'type' => 'number',
            ],
            [
                'key' => 'biaya_lk_7',
                'name' => 'Biaya LKS Kelas 7',
                'value' => '157000',
                'type' => 'number',
            ],
            [
                'key' => 'biaya_lk_8',
                'name' => 'Biaya LKS Kelas 8',
                'value' => '154000',
                'type' => 'number',
            ],
            [
                'key' => 'biaya_lk_9',
                'name' => 'Biaya LKS Kelas 9',
                'value' => '275000',
                'type' => 'number',
            ],
            [
                'key' => 'biaya_seragam',
                'name' => 'Biaya Seragam',
                'value' => '336000',
                'type' => 'number',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
