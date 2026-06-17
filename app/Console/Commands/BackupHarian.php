<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BackupHarian extends Command
{
    /**
     * Nama command artisan.
     */
    protected $signature = 'backup:harian';

    /**
     * Deskripsi command.
     */
    protected $description = 'Backup harian otomatis — database PostgreSQL dan foto produk ke storage/backups/daily/';

    public function handle(): int
    {
        $tanggal      = now()->format('Y-m-d');
        $jam          = now()->format('H-i-s');
        $folderBackup = storage_path("backups/daily/{$tanggal}");

        $this->info("Memulai backup harian: {$tanggal} {$jam}");
        Log::info("[BACKUP] Memulai backup harian", ['tanggal' => $tanggal, 'jam' => $jam]);

        // Buat folder backup hari ini jika belum ada
        if (!is_dir($folderBackup)) {
            mkdir($folderBackup, 0755, true);
        }

        $sukses = true;

        // === 1. BACKUP DATABASE ===
        $sukses = $this->backupDatabase($folderBackup, $tanggal, $jam) && $sukses;

        // === 2. BACKUP FOTO PRODUK ===
        $sukses = $this->backupFoto($folderBackup, $tanggal) && $sukses;

        // Catatan:
        // - Backup di storage/backups/daily/ TIDAK dihapus otomatis.
        // - Untuk mengarsipkan, admin memindahkan folder secara manual
        //   dari storage/backups/daily/ ke storage/backups/archive/

        if ($sukses) {
            $this->info("Backup harian selesai: {$folderBackup}");
            Log::info("[BACKUP] Backup harian selesai", ['folder' => $folderBackup]);
            return self::SUCCESS;
        }

        $this->error("Backup selesai dengan sebagian error. Cek log untuk detail.");
        Log::warning("[BACKUP] Backup selesai dengan sebagian error", ['folder' => $folderBackup]);
        return self::FAILURE;
    }

    /**
     * Backup database PostgreSQL menggunakan pg_dump.
     * Kompatibel dengan Windows dan Linux/Mac.
     */
    protected function backupDatabase(string $folder, string $tanggal, string $jam): bool
    {
        $namaFile = "{$folder}/database_{$tanggal}_{$jam}.sql";

        $host     = config('database.connections.pgsql.host', '127.0.0.1');
        $port     = config('database.connections.pgsql.port', '5432');
        $database = config('database.connections.pgsql.database');
        $username = config('database.connections.pgsql.username');
        $password = config('database.connections.pgsql.password');

        // Deteksi OS — Windows vs Linux/Mac
            $isWindows = strncasecmp(php_uname('s'), 'WIN', 3) === 0;

        if ($isWindows) {
            // Windows: gunakan SET PGPASSWORD dalam satu perintah cmd /C
            $command = "cmd /C \"SET PGPASSWORD={$password} && pg_dump -h {$host} -p {$port} -U {$username} -d {$database} -F p -f \"{$namaFile}\"\" 2>&1";
        } else {
            // Linux/Mac: gunakan prefix PGPASSWORD=
            $command = "PGPASSWORD=\"{$password}\" pg_dump -h {$host} -p {$port} -U {$username} -d {$database} -F p -f \"{$namaFile}\" 2>&1";
        }

        exec($command, $output, $exitCode);

        if ($exitCode === 0 && file_exists($namaFile)) {
            $ukuran = round(filesize($namaFile) / 1024, 2);
            $this->line("  Backup database sukses: database_{$tanggal}_{$jam}.sql ({$ukuran} KB)");
            Log::info("[BACKUP] Database backup sukses", ['file' => $namaFile, 'ukuran_kb' => $ukuran]);
            return true;
        }

        $errorMsg = implode("\n", $output);
        $this->error("  Database backup gagal: {$errorMsg}");
        Log::error("[BACKUP] Database backup gagal", ['command_output' => $output, 'exit_code' => $exitCode]);
        return false;
    }

    /**
     * Backup foto produk dari storage/app/public/produks/
     */
    protected function backupFoto(string $folder, string $tanggal): bool
    {
        $sumberFoto = storage_path('app/public/produks');
        $namaZip    = "{$folder}/foto_produk_{$tanggal}.zip";

        if (!is_dir($sumberFoto)) {
            $this->line("  Folder foto produk tidak ditemukan, backup foto dilewati.");
            Log::info("[BACKUP] Folder foto produk tidak ditemukan, dilewati", ['path' => $sumberFoto]);
            return true;
        }

        $files = glob($sumberFoto . '/*');
        if (empty($files)) {
            $this->line("  Folder foto produk kosong, backup foto dilewati.");
            Log::info("[BACKUP] Folder foto produk kosong, dilewati");
            return true;
        }

        if (!class_exists('ZipArchive')) {
            $this->error("  ZipArchive tidak tersedia. Install php-zip extension.");
            Log::error("[BACKUP] ZipArchive tidak tersedia");
            return false;
        }

        $zip = new \ZipArchive();

        if ($zip->open($namaZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            $this->error("  Gagal membuat file zip: {$namaZip}");
            Log::error("[BACKUP] Gagal membuat file zip", ['path' => $namaZip]);
            return false;
        }

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($sumberFoto),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        $jumlahFile = 0;
        foreach ($iterator as $file) {
            if (!$file->isDir()) {
                $filePath     = $file->getRealPath();
                $relativePath = substr($filePath, strlen($sumberFoto) + 1);
                $zip->addFile($filePath, $relativePath);
                $jumlahFile++;
            }
        }

        $zip->close();

        if (file_exists($namaZip)) {
            $ukuran = round(filesize($namaZip) / 1024, 2);
            $this->line("  Backup foto sukses: foto_produk_{$tanggal}.zip ({$jumlahFile} file, {$ukuran} KB)");
            Log::info("[BACKUP] Foto backup sukses", [
                'file'        => $namaZip,
                'jumlah_file' => $jumlahFile,
                'ukuran_kb'   => $ukuran,
            ]);
            return true;
        }

        $this->error("  Foto backup gagal: file zip tidak terbuat.");
        Log::error("[BACKUP] Foto backup gagal, zip tidak terbuat", ['path' => $namaZip]);
        return false;
    }
}
