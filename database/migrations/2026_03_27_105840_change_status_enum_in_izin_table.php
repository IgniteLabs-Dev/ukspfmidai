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
        DB::statement("ALTER TABLE izin MODIFY COLUMN status ENUM('pending', 'success', 'failed', 'process')");
        DB::statement("UPDATE izin SET status = 'process' WHERE status = 'menunggu_ketua'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("UPDATE izin SET status = 'pending' WHERE status = 'process'");
        DB::statement("ALTER TABLE izin MODIFY COLUMN status ENUM('pending', 'success', 'failed', 'menunggu_ketua')");
    }
};
