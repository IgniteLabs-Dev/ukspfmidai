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
        Schema::create('cuti_approval_workflow', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuti_id')->constrained('cuti')->onDelete('cascade');
            $table->foreignId('approval_level_id')->constrained('cuti_approval_level_ref')->onDelete('cascade');
            $table->enum('status', ['pending', 'success', 'failed', 'waiting'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti_approval_workflow');
    }
};
