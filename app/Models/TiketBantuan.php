<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\KategoriBantuan;

class TiketBantuan extends Model
{
    use SoftDeletes;

    protected $table = 'tiket_bantuan';

    protected $fillable = [
        'user_id',
        'kategori_bantuan_id',
        'no_tiket',
        'subjek',
        'pesan',
        'status',
        'prioritas',
        'balasan',
        'dibalas_at',
    ];

    protected function casts(): array
    {
        return [
            'user_id'             => 'integer',
            'kategori_bantuan_id' => 'integer',
            'dibalas_at'          => 'datetime',
        ];
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke KategoriBantuan
    public function kategori()
    {
        return $this->belongsTo(KategoriBantuan::class, 'kategori_bantuan_id');
    }

    // Scope — filter by status
    public function scopeMenunggu(Builder $query): Builder
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDalamProses(Builder $query): Builder
    {
        return $query->where('status', 'dalam_proses');
    }

    public function scopeSelesai(Builder $query): Builder
    {
        return $query->where('status', 'selesai');
    }

    // Generate nomor tiket unik
    public static function generateNoTiket(): string
    {
        $random = strtoupper(substr(uniqid(), -5));
        return "TK-{$random}";
    }
}
