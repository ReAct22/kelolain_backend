<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Backup Harian Otomatis
|--------------------------------------------------------------------------
| Dijalankan setiap hari pukul 02:00 WIB (Asia/Jakarta)
| Timezone diset di config/app.php: 'timezone' => 'Asia/Jakarta'
|
| Hasil backup tersimpan di:
|   - storage/backups/daily/    → backup harian otomatis
|   - storage/backups/archive/  → arsip lama (dipindah manual oleh admin)
|
| Cek log di: storage/logs/backup.log & storage/logs/laravel.log
|--------------------------------------------------------------------------
*/

Schedule::command('backup:harian')
    ->dailyAt('02:00')
    ->withoutOverlapping()
    ->runInBackground()
    ->appendOutputTo(storage_path('logs/backup.log'));
