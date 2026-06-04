<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\InvoiceDetail;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'no_invoice',
        'nama_pelanggan',
        'no_hp_pelanggan',
        'total_harga',
        'total_bayar',
        'kembalian',
        'status',
        'metode_bayar',
        'catatan',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke InvoiceDetail
    public function details()
    {
        return $this->hasMany(InvoiceDetail::class);
    }
}
