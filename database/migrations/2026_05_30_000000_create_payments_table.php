<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->unique()->constrained()->onDelete('cascade');
            $table->enum('metode_pembayaran', ['transfer', 'qris', 'tunai']);
            $table->decimal('jumlah_bayar', 12, 2);
            $table->string('bukti_transfer');
            $table->date('tanggal_bayar');
            $table->string('bank_asal')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->enum('status', ['menunggu', 'lunas', 'ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Insert payment-related configurations into settings table
        DB::table('settings')->insert([
            [
                'key' => 'payment_amount',
                'name' => 'Biaya Daftar Ulang (Rupiah)',
                'value' => '750000',
                'type' => 'number',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'payment_bank',
                'name' => 'Nama Bank Penerima',
                'value' => 'Bank Syariah Indonesia (BSI)',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'payment_rekening',
                'name' => 'Nomor Rekening Penerima',
                'value' => '7149028882',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'payment_penerima',
                'name' => 'Nama Pemilik Rekening',
                'value' => 'Panitia PPDB SMP Muhammadiyah Kaliwiro',
                'type' => 'text',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'payment_qris_image',
                'name' => 'Kode QRIS Sekolah (Unggah Gambar)',
                'value' => null,
                'type' => 'file',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');

        // Delete settings
        DB::table('settings')->whereIn('key', [
            'payment_amount',
            'payment_bank',
            'payment_rekening',
            'payment_penerima',
            'payment_qris_image'
        ])->delete();
    }
};
