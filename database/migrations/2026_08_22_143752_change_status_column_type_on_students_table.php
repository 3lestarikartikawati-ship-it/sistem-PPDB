<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE students MODIFY COLUMN status VARCHAR(255) DEFAULT 'menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverting to ENUM might truncate data if there are non-enum statuses, 
        // so we just leave it as VARCHAR in down() or specify the original ENUM.
        // For safety, we keep it simple.
    }
};
