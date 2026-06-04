<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;
use App\Models\InvoiceDetail;
use App\Models\ProductViolation;

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
        'jumlah_peringatan',
        'peringatan_terakhir',
        'is_banned',
        'banned_sampai',
    ];

    protected function casts(): array
    {
        return [
            'user_id'             => 'integer',
            'category_id'         => 'integer',
            'harga'               => 'integer',
            'stok'                => 'integer',
            'jumlah_peringatan'   => 'integer',
            'peringatan_terakhir' => 'datetime',
            'is_banned'           => 'boolean',
            'banned_sampai'       => 'datetime',
        ];
    }

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

    // Relasi ke ProductViolation
    public function violations()
    {
        return $this->hasMany(ProductViolation::class);
    }

    // Helper — cek apakah produk sedang dibanned
    public function isBanned(): bool
    {
        if (!$this->is_banned) return false;
        if ($this->banned_sampai && now()->greaterThan($this->banned_sampai)) {
            $this->update(['is_banned' => false, 'banned_sampai' => null]);
            return false;
        }
        return true;
    }
}
