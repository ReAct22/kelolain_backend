<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use App\Models\Produk;

class InvoiceDetail extends Model
{
    protected $fillable = [
        'invoice_id',
        'produk_id',
        'nama_produk',
        'harga',
        'qty',
        'subtotal',
    ];

    // Relasi ke Invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
