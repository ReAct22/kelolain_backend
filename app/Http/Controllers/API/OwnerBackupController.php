<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class OwnerBackupController extends Controller
{
    use ApiResponse;

    /**
     * Helper — ambil daftar folder tanggal (format YYYY-MM-DD) di dalam storage/backups/daily/
     */
    protected function daftarFolderBackup(string $folderDaily): array
    {
        $semuaPath = glob($folderDaily . '/*');

        if ($semuaPath === false) {
            return [];
        }

        return array_filter($semuaPath, function ($path) {
            return is_dir($path) && preg_match('/\d{4}-\d{2}-\d{2}$/', basename($path));
        });
    }

    /**
     * Trigger backup manual (menjalankan command backup:harian langsung).
     */
    public function jalankan()
    {
        try {
            $exitCode = Artisan::call('backup:harian');
            $output   = Artisan::output();

            if ($exitCode === 0) {
                return $this->success([
                    'output' => trim($output),
                ], 'Backup berhasil dijalankan');
            }

            return $this->error('Backup selesai dengan sebagian error. Cek detail output.', 422, [
                'output' => trim($output),
            ]);

        } catch (\Exception $e) {
            Log::error('[BACKUP] Gagal trigger backup manual', ['error' => $e->getMessage()]);
            return $this->serverError('Gagal menjalankan backup', $e->getMessage());
        }
    }

    /**
     * List semua backup yang tersedia di storage/backups/daily/
     */
    public function index()
    {
        $folderDaily = storage_path('backups/daily');

        if (!is_dir($folderDaily)) {
            return $this->success([], 'Belum ada data backup');
        }

        $folders = $this->daftarFolderBackup($folderDaily);
        $data    = [];

        foreach ($folders as $folder) {
            $tanggal = basename($folder);
            $files   = glob($folder . '/*');

            $items = [];
            foreach ($files as $file) {
                $items[] = [
                    'nama_file'  => basename($file),
                    'jenis'      => str_starts_with(basename($file), 'database_') ? 'database' : 'foto_produk',
                    'ukuran_kb'  => round(filesize($file) / 1024, 2),
                    'dibuat_at'  => date('Y-m-d H:i:s', filemtime($file)),
                ];
            }

            $data[] = [
                'tanggal' => $tanggal,
                'jumlah_file' => count($items),
                'files'   => $items,
            ];
        }

        // Urutkan dari tanggal terbaru
        usort($data, fn($a, $b) => strcmp($b['tanggal'], $a['tanggal']));

        return $this->success($data, 'Data backup');
    }

    /**
     * Status backup terakhir — diambil dari folder backup terbaru.
     */
    public function status()
    {
        $folderDaily = storage_path('backups/daily');

        if (!is_dir($folderDaily)) {
            return $this->success([
                'status'           => 'belum_pernah',
                'tanggal_terakhir' => null,
                'jumlah_file'      => 0,
            ], 'Status backup');
        }

        $folders = $this->daftarFolderBackup($folderDaily);

        if (empty($folders)) {
            return $this->success([
                'status'           => 'belum_pernah',
                'tanggal_terakhir' => null,
                'jumlah_file'      => 0,
            ], 'Status backup');
        }

        // Ambil folder dengan tanggal terbaru
        usort($folders, fn($a, $b) => strcmp(basename($b), basename($a)));
        $folderTerakhir  = array_values($folders)[0];
        $tanggalTerakhir = basename($folderTerakhir);
        $files           = glob($folderTerakhir . '/*');

        $adaDatabase = false;
        $adaFoto     = false;

        foreach ($files as $file) {
            if (str_starts_with(basename($file), 'database_')) {
                $adaDatabase = true;
            }
            if (str_starts_with(basename($file), 'foto_produk_')) {
                $adaFoto = true;
            }
        }

        return $this->success([
            'status'           => $adaDatabase ? 'sukses' : 'gagal',
            'tanggal_terakhir' => $tanggalTerakhir,
            'jumlah_file'      => count($files),
            'database_backup'  => $adaDatabase,
            'foto_backup'      => $adaFoto,
        ], 'Status backup');
    }

    /**
     * Download file backup tertentu berdasarkan tanggal dan jenis (database/foto_produk).
     */
    public function download(string $tanggal, string $jenis)
    {
        // Validasi format tanggal untuk mencegah path traversal
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $tanggal)) {
            return $this->error('Format tanggal tidak valid', 422);
        }

        if (!in_array($jenis, ['database', 'foto_produk'])) {
            return $this->error('Jenis backup tidak valid. Gunakan: database atau foto_produk', 422);
        }

        $folder = storage_path("backups/daily/{$tanggal}");

        if (!is_dir($folder)) {
            return $this->notFound('Backup untuk tanggal tersebut tidak ditemukan');
        }

        $pattern = $jenis === 'database'
            ? "{$folder}/database_{$tanggal}_*.sql"
            : "{$folder}/foto_produk_{$tanggal}.zip";

        $matches = glob($pattern);

        if (empty($matches)) {
            return $this->notFound("File backup {$jenis} untuk tanggal tersebut tidak ditemukan");
        }

        $filePath = $matches[0];

        return response()->download($filePath);
    }
}
