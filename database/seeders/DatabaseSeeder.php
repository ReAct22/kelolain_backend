<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Owner — Project Manager & UI/UX Designer
        User::create([
            'name'                 => 'Michelle Agnesia',
            'nama_bisnis'          => 'Kelolain',
            'email'                => 'kelolainId@gmail.com',
            'no_hp'                => '08100000001',
            'tgl_lahir'            => '1990-01-01',
            'password'             => Hash::make('kelolain123'),
            'role'                 => 'owner',
            'is_banned_produk'     => false,
            'banned_produk_sampai' => null,
        ]);

        // Akun Developer — Andrean Ahmad Fauzi
        User::create([
            'name'                 => 'Andrean Ahmad Fauzi',
            'nama_bisnis'          => 'Toko Andrean',
            'email'                => 'andrean@kelolain.com',
            'no_hp'                => '08100000002',
            'tgl_lahir'            => '1999-05-10',
            'password'             => Hash::make('andrean123'),
            'role'                 => 'user',
            'is_banned_produk'     => false,
            'banned_produk_sampai' => null,
        ]);

        // Akun Developer — Naufal Febriansyah
        User::create([
            'name'                 => 'Naufal Febriansyah',
            'nama_bisnis'          => 'Toko Naufal',
            'email'                => 'naufal@kelolain.com',
            'no_hp'                => '08100000003',
            'tgl_lahir'            => '2000-01-15',
            'password'             => Hash::make('naufal123'),
            'role'                 => 'user',
            'is_banned_produk'     => false,
            'banned_produk_sampai' => null,
        ]);

        // Akun UI/UX Designer — Ghibran Aryasena Aviyanto
        User::create([
            'name'                 => 'Ghibran Aryasena Aviyanto',
            'nama_bisnis'          => 'Toko Ghibran',
            'email'                => 'ghibran@kelolain.com',
            'no_hp'                => '08100000004',
            'tgl_lahir'            => '2001-03-20',
            'password'             => Hash::make('ghibran123'),
            'role'                 => 'user',
            'is_banned_produk'     => false,
            'banned_produk_sampai' => null,
        ]);

        // Akun Digital Marketing — Marfuah Zahra
        User::create([
            'name'                 => 'Marfuah Zahra',
            'nama_bisnis'          => 'Toko Marfuah',
            'email'                => 'marfuah@kelolain.com',
            'no_hp'                => '08100000005',
            'tgl_lahir'            => '2001-07-25',
            'password'             => Hash::make('marfuah123'),
            'role'                 => 'user',
            'is_banned_produk'     => false,
            'banned_produk_sampai' => null,
        ]);
    }
}
