<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoBanner extends Model
{
    use SoftDeletes;

    protected $table = 'promo_banners';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'tombol_teks',
        'tombol_url',
        'mulai_tanggal',
        'selesai_tanggal',
        'is_aktif',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'mulai_tanggal'   => 'date',
            'selesai_tanggal' => 'date',
            'is_aktif'        => 'boolean',
            'urutan'          => 'integer',
        ];
    }

    // Scope — hanya yang aktif, urut berdasarkan kolom urutan
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true)->orderBy('urutan');
    }

    // Scope — hanya yang sedang berjalan (dalam rentang tanggal)
    public function scopeSedangBerjalan(Builder $query): Builder
    {
        $today = now()->toDateString();

        return $query->where(function (Builder $q) use ($today) {
            $q->whereNull('mulai_tanggal')->orWhere('mulai_tanggal', '<=', $today);
        })->where(function (Builder $q) use ($today) {
            $q->whereNull('selesai_tanggal')->orWhere('selesai_tanggal', '>=', $today);
        });
    }
}
