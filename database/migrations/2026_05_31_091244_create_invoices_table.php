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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('no_invoice')->unique();
            $table->string('nama_pelanggan');
            $table->string('no_hp_pelanggan')->nullable();
            $table->bigInteger('total_harga');
            $table->bigInteger('total_bayar');
            $table->bigInteger('kembalian')->default(0);
            $table->enum('status', ['lunas', 'belum_lunas'])->default('lunas');
            $table->enum('metode_bayar', ['cash', 'transfer', 'qris'])->default('cash');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
