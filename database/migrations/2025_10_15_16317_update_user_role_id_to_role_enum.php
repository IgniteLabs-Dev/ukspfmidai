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
            if (Schema::hasColumn('users', 'role_id')) {

                $foreignKeys = DB::select(
                    "SELECT CONSTRAINT_NAME 
                     FROM information_schema.KEY_COLUMN_USAGE 
                     WHERE TABLE_SCHEMA = DATABASE() 
                     AND TABLE_NAME = 'users' 
                     AND COLUMN_NAME = 'role_id' 
                     AND REFERENCED_TABLE_NAME IS NOT NULL"
                );

                foreach ($foreignKeys as $fk) {
                    $table->dropForeign($fk->CONSTRAINT_NAME);
                }

                $table->dropColumn('role_id');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['ADMIN', 'SUPERADMIN', 'USER'])->default('USER');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (!Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->nullable()->constrained('role')->onDelete('set null');
            }
        });
    }
};
