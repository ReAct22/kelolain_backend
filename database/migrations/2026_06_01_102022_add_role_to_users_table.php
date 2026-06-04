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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['owner', 'user'])->default('user')->after('password');
            $table->integer('sisa_peringatan_produk')->default(3)->after('role');
            $table->boolean('is_banned_produk')->default(false)->after('sisa_peringatan_produk');
            $table->timestamp('banned_produk_sampai')->nullable()->after('is_banned_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'sisa_peringatan_produk',
                'is_banned_produk',
                'banned_produk_sampai',
            ]);
        });
    }
};
