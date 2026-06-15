<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Faq;
use App\Models\TiketBantuan;

class KategoriBantuan extends Model
{
    use SoftDeletes;

    protected $table = 'kategori_bantuan';

    protected $fillable = [
        'nama',
        'ikon',
        'deskripsi',
        'is_aktif',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'is_aktif' => 'boolean',
            'urutan'   => 'integer',
        ];
    }

    // Relasi ke FAQ
    public function faqs()
    {
        return $this->hasMany(Faq::class, 'kategori_bantuan_id');
    }

    // Relasi ke Tiket Bantuan
    public function tiketBantuan()
    {
        return $this->hasMany(TiketBantuan::class, 'kategori_bantuan_id');
    }

    // Scope — hanya yang aktif
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true)->orderBy('urutan');
    }
}
