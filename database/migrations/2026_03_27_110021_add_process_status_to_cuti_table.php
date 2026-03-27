<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE cuti MODIFY COLUMN status ENUM('pending', 'success', 'failed', 'process') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("UPDATE cuti SET status = 'pending' WHERE status = 'process'");
        DB::statement("ALTER TABLE cuti MODIFY COLUMN status ENUM('pending', 'success', 'failed') DEFAULT 'pending'");
    }
};
