<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\KategoriBantuan;

class Faq extends Model
{
    use SoftDeletes;

    protected $table = 'faq';

    protected $fillable = [
        'kategori_bantuan_id',
        'pertanyaan',
        'jawaban',
        'is_aktif',
        'urutan',
    ];

    protected function casts(): array
    {
        return [
            'kategori_bantuan_id' => 'integer',
            'is_aktif'            => 'boolean',
            'urutan'              => 'integer',
        ];
    }

    // Relasi ke KategoriBantuan
    public function kategori()
    {
        return $this->belongsTo(KategoriBantuan::class, 'kategori_bantuan_id');
    }

    // Scope — hanya yang aktif
    public function scopeAktif(Builder $query): Builder
    {
        return $query->where('is_aktif', true)->orderBy('urutan');
    }
}
