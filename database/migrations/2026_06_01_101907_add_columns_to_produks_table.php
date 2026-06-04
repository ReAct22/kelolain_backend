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
        Schema::table('produks', function (Blueprint $table) {
            $table->integer('jumlah_peringatan')->default(0)->after('status');
            $table->timestamp('peringatan_terakhir')->nullable()->after('jumlah_peringatan');
            $table->boolean('is_banned')->default(false)->after('peringatan_terakhir');
            $table->timestamp('banned_sampai')->nullable()->after('is_banned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn([
                'jumlah_peringatan',
                'peringatan_terakhir',
                'is_banned',
                'banned_sampai',
            ]);
        });
    }
};
