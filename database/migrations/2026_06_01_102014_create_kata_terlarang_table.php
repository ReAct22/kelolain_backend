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
        Schema::create('kata_terlarang', function (Blueprint $table) {
            $table->id();
            $table->string('kata')->unique();
            $table->enum('jenis', ['nama_produk', 'kategori', 'keduanya'])->default('keduanya');
            $table->text('keterangan')->nullable();
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kata_terlarang');
    }
};
