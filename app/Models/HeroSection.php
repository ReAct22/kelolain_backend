<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeroSection extends Model
{
    use SoftDeletes;

    protected $table = 'hero_sections';

    protected $fillable = [
        'judul',
        'subjudul',
        'gambar',
        'tombol_teks',
        'tombol_url',
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

    // Scope — hanya yang aktif, urut berdasarkan kolom urutan
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true)->orderBy('urutan');
    }
}
