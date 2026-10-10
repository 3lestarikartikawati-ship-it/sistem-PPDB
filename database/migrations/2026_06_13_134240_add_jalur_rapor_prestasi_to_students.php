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
        Schema::table('students', function (Blueprint $table) {
            $table->string('jalur_pendaftaran')->nullable();
            $table->decimal('nilai_rapor', 5, 2)->nullable();
            $table->string('prestasi')->nullable();
        });

        // Modify enum
        DB::statement("ALTER TABLE students MODIFY status ENUM('menunggu', 'diterima', 'ditolak', 'cadangan') DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['jalur_pendaftaran', 'nilai_rapor', 'prestasi']);
        });
        
        DB::statement("ALTER TABLE students MODIFY status ENUM('menunggu', 'diterima', 'ditolak') DEFAULT 'menunggu'");
    }
};
