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
        Schema::table('cuti_approval_level_ref', function (Blueprint $table) {
            $table->enum('is_sign', ['true', 'false'])->default('false')->after('jabatan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuti_approval_level_ref', function (Blueprint $table) {
            $table->dropColumn('is_sign');
        });
    }
};
