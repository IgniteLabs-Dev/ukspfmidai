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
        Schema::create('izin', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tanggal_acc')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('izin_type_id')->nullable()->constrained('izin_type')->onDelete('set null');
            $table->date('tanggal')->nullable();
            $table->text('keperluan')->nullable();
            $table->time('mulai_pukul')->nullable();
            $table->time('sampai_pukul')->nullable();
            $table->enum('status', ['pending', 'success', 'failed', 'menunggu_ketua']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin');
    }
};
