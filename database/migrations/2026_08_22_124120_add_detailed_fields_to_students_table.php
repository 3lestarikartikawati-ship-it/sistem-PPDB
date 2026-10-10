<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Data Pribadi Tambahan
            $table->string('nik', 20)->nullable();
            $table->string('no_ujian', 50)->nullable();
            $table->string('no_skhu', 50)->nullable();
            $table->string('no_ijazah', 50)->nullable();
            $table->string('suku', 50)->nullable();
            $table->string('status_anak', 50)->nullable(); // Pelajar, Person, CKM
            $table->string('kondisi_anak', 50)->nullable(); // Berkecukupan, Kurang Mampu
            $table->string('keadaan_orang_tua', 50)->nullable(); // Lengkap, Yatim, Piatu
            $table->string('status_dalam_keluarga', 50)->nullable(); // Anak Kandung, dll
            $table->string('tinggal_bersama', 50)->nullable(); // Orang Tua, Kakek/Nenek, dll
            $table->string('kewarganegaraan', 50)->nullable();
            $table->integer('anak_ke')->nullable();
            $table->integer('dari_bersaudara')->nullable();
            $table->string('bahasa_sehari_hari', 50)->nullable();
            $table->string('jalan')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('email_siswa')->nullable();

            // Data Orang Tua Tambahan
            $table->string('pendidikan_ayah', 50)->nullable();
            $table->string('pendidikan_ibu', 50)->nullable();
            $table->string('penghasilan_ayah', 50)->nullable();
            $table->string('penghasilan_ibu', 50)->nullable();
            $table->string('email_orang_tua')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('alamat_wali')->nullable();
            $table->string('alamat_penghubung_orang_tua')->nullable();
            $table->string('alamat_penghubung_wali')->nullable();

            // Riwayat Kesehatan
            $table->string('golongan_darah', 5)->nullable(); // A, B, AB, O
            $table->string('berat_badan', 10)->nullable();
            $table->string('tinggi_badan', 10)->nullable();
            $table->string('riwayat_penyakit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 'no_ujian', 'no_skhu', 'no_ijazah', 'suku',
                'status_anak', 'kondisi_anak', 'keadaan_orang_tua',
                'status_dalam_keluarga', 'tinggal_bersama', 'kewarganegaraan',
                'anak_ke', 'dari_bersaudara', 'bahasa_sehari_hari',
                'jalan', 'rt', 'rw', 'desa_kelurahan', 'kecamatan',
                'kabupaten', 'provinsi', 'kode_pos', 'email_siswa',
                'pendidikan_ayah', 'pendidikan_ibu', 'penghasilan_ayah',
                'penghasilan_ibu', 'email_orang_tua', 'nama_wali', 'alamat_wali',
                'alamat_penghubung_orang_tua', 'alamat_penghubung_wali',
                'golongan_darah', 'berat_badan', 'tinggi_badan', 'riwayat_penyakit'
            ]);
        });
    }
};
