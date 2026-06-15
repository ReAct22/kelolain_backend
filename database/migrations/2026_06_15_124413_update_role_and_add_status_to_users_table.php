<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Drop CHECK constraint lama untuk kolom role (enum lama: user, owner)
        //    Nama constraint default Laravel: {table}_{column}_check
        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");

        // 2. Tambah CHECK constraint baru dengan daftar role lengkap
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'owner', 'admin', 'manager', 'staff'))");

        // 3. Tambah kolom status: aktif, nonaktif, blokir
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['aktif', 'nonaktif', 'blokir'])->default('aktif')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
        DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role IN ('user', 'owner'))");
    }
};