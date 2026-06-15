<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KataTerlarang extends Model
{
    use SoftDeletes;

    protected $table = 'kata_terlarang';

    protected $fillable = [
        'kata',
        'jenis',
        'keterangan',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'is_aktif' => 'boolean',
        ];
    }

    // Scope — ambil kata terlarang by jenis yang aktif
    public function scopeByJenis(Builder $query, string $jenis): Builder
    {
        return $query->where('is_aktif', true)
                     ->where(function (Builder $q) use ($jenis) {
                         $q->where('jenis', $jenis)
                           ->orWhere('jenis', 'keduanya');
                     });
    }

    // Static helper — cek apakah string mengandung kata terlarang
    public static function mengandungKataTerlarang(string $text, string $jenis): bool
    {
        $kataList = self::byJenis($jenis)->pluck('kata');

        foreach ($kataList as $kata) {
            if (str_contains(strtolower($text), strtolower($kata))) {
                return true;
            }
        }

        return false;
    }

    // Static helper — ambil kata terlarang yang ditemukan
    public static function temukanKataTerlarang(string $text, string $jenis): ?string
    {
        $kataList = self::byJenis($jenis)->pluck('kata');

        foreach ($kataList as $kata) {
            if (str_contains(strtolower($text), strtolower($kata))) {
                return $kata;
            }
        }

        return null;
    }
}
