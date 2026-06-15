<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Daftar tabel yang akan ditambahkan kolom soft delete (deleted_at).
     */
    protected array $tables = [
        'users',
        'categories',
        'produks',
        'invoices',
        'invoice_details',
        'product_violations',
        'kata_terlarang',
        'kategori_bantuan',
        'faq',
        'tiket_bantuan',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
