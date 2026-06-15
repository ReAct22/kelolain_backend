<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\InvoiceDetail;

class Invoice extends Model
{
    use SoftDeletes;

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

    protected function casts(): array
    {
        return [
            'user_id'     => 'integer',
            'total_harga' => 'integer',
            'total_bayar' => 'integer',
            'kembalian'   => 'integer',
        ];
    }

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
