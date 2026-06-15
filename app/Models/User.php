<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\ProductViolation;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;

    protected $fillable = [
        'name',
        'nama_bisnis',
        'email',
        'no_hp',
        'tgl_lahir',
        'password',
        'role',
        'status',
        'is_banned_produk',
        'banned_produk_sampai',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'   => 'datetime',
            'tgl_lahir'           => 'date:Y-m-d',
            'password'            => 'hashed',
            'is_banned_produk'    => 'boolean',
            'banned_produk_sampai'=> 'datetime',
        ];
    }

    // Relasi ke Produk
    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    // Relasi ke Category
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    // Relasi ke Invoice
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Relasi ke ProductViolation
    public function violations()
    {
        return $this->hasMany(ProductViolation::class);
    }

    // Helper — cek apakah user sedang dibanned tambah produk
    public function isBannedProduk(): bool
    {
        if (!$this->is_banned_produk) return false;
        if ($this->banned_produk_sampai && now()->greaterThan($this->banned_produk_sampai)) {
            $this->update(['is_banned_produk' => false, 'banned_produk_sampai' => null]);
            return false;
        }
        return true;
    }

    // Helper — cek apakah user adalah owner
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    // Helper — cek apakah user diblokir
    public function isBlokir(): bool
    {
        return $this->status === 'blokir';
    }

    // Scope — filter by peran (role)
    public function scopePeran(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    // Scope — filter by status
    public function scopeStatus(Builder $query, string $status): Builder
    {
        return $query->where('status', $status);
    }
}