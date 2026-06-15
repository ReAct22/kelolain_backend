<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PageSeo extends Model
{
    use SoftDeletes;

    protected $table = 'page_seo';

    protected $fillable = [
        'page_key',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'og_image',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'is_aktif' => 'boolean',
        ];
    }

    // Scope — hanya yang aktif
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true);
    }
}
