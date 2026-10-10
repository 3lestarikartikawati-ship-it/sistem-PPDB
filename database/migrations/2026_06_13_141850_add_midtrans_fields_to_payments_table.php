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
        Schema::table('payments', function (Blueprint $table) {
            $table->string('bukti_transfer')->nullable()->change();
            $table->string('snap_token')->nullable()->after('status');
            $table->string('midtrans_order_id')->nullable()->unique()->after('snap_token');
        });

        // Use raw statement to modify enum column to include 'midtrans'
        DB::statement("ALTER TABLE payments MODIFY COLUMN metode_pembayaran ENUM('transfer', 'qris', 'tunai', 'midtrans') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['snap_token', 'midtrans_order_id']);
        });
        
        DB::statement("ALTER TABLE payments MODIFY COLUMN metode_pembayaran ENUM('transfer', 'qris', 'tunai') NOT NULL");
    }
};
