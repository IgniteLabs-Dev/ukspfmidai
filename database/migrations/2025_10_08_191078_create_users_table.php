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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->nullable();
            $table->enum('status', ['active', 'nonactive'])->default('active');
            $table->string('password');
            $table->foreignId('role_id')->nullable()->constrained('role')->onDelete('set null');
            $table->foreignId('jabatan')->nullable()->constrained('jabatan')->onDelete('set null');
            $table->string('nomor_wa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
