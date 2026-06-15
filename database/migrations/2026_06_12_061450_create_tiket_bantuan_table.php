<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tiket_bantuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_bantuan_id')->nullable()->constrained('kategori_bantuan')->onDelete('set null');
            $table->string('no_tiket')->unique();
            $table->string('subjek');
            $table->text('pesan');
            $table->enum('status', ['menunggu', 'dalam_proses', 'selesai', 'ditutup'])->default('menunggu');
            $table->enum('prioritas', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->text('balasan')->nullable();
            $table->timestamp('dibalas_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tiket_bantuan');
    }
};