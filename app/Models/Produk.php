<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\InvoiceDetail;

class Produk extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'status',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke InvoiceDetail
    public function invoiceDetails()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
