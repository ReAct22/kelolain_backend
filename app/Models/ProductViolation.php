<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Produk;
use App\Models\User;

class ProductViolation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'produk_id',
        'user_id',
        'jenis_pelanggaran',
        'keterangan',
        'peringatan_ke',
        'dikirim_at',
    ];

    protected function casts(): array
    {
        return [
            'peringatan_ke' => 'integer',
            'dikirim_at'    => 'datetime',
        ];
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Relasi ke User (pemilik produk)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
