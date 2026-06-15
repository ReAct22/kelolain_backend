<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $table = 'testimonials';

    protected $fillable = [
        'nama',
        'jabatan',
        'nama_bisnis',
        'foto',
        'isi_testimoni',
        'rating',
        'is_aktif',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'rating'   => 'integer',
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