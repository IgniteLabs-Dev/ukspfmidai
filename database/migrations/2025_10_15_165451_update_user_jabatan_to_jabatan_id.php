<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME 
                 FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_SCHEMA = DATABASE() 
                 AND TABLE_NAME = 'users' 
                 AND COLUMN_NAME = 'jabatan' 
                 AND REFERENCED_TABLE_NAME IS NOT NULL"
            );

            foreach ($foreignKeys as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }

            $table->renameColumn('jabatan', 'jabatan_id');

            $table->foreign('jabatan_id')->references('id')->on('jabatan')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $foreignKeys = DB::select(
                "SELECT CONSTRAINT_NAME 
                 FROM information_schema.KEY_COLUMN_USAGE 
                 WHERE TABLE_SCHEMA = DATABASE() 
                 AND TABLE_NAME = 'users' 
                 AND COLUMN_NAME = 'jabatan_id' 
                 AND REFERENCED_TABLE_NAME IS NOT NULL"
            );

            foreach ($foreignKeys as $fk) {
                $table->dropForeign($fk->CONSTRAINT_NAME);
            }

            $table->renameColumn('jabatan_id', 'jabatan');

            $table->foreign('jabatan')->references('id')->on('jabatan')->onDelete('set null');
        });
    }
};
