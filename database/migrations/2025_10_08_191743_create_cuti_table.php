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
        Schema::create('cuti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cuti_type_id')->nullable()->constrained('cuti_type')->onDelete('set null');
            $table->dateTime('tanggal_acc')->nullable();
            $table->text('alasan')->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->string('tanggal_start')->nullable();
            $table->string('tanggal_end')->nullable();
            $table->string('doc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuti');
    }
};
