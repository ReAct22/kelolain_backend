<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Produk;

class ProdukSeo extends Model
{
    use SoftDeletes;

    protected $table = 'produk_seo';

    protected $fillable = [
        'produk_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'slug',
        'og_image',
    ];

    protected function casts(): array
    {
        return [
            'produk_id' => 'integer',
        ];
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
