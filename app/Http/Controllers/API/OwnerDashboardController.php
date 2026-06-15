<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Invoice;
use App\Models\Produk;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerDashboardController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $year = $request->input('year', now()->year);

        // === Summary Cards ===
        $total_organisasi = User::where('role', 'user')->count();
        $total_user_aktif = User::where('role', 'user')
            ->whereHas('tokens')
            ->count();
        $total_transaksi  = (int) Invoice::where('status', 'lunas')->sum('total_harga');
        $total_invoice    = Invoice::count();
        $total_produk     = Produk::count();
        $total_category   = Category::count();

        // === Health Status ===
        $health_status = [
            'status'     => 'Online',
            'percentage' => 99.9,
        ];

        // === Pertumbuhan User Per Bulan (chart) ===
        $pertumbuhan_user_raw = User::where('role', 'user')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('EXTRACT(MONTH FROM created_at)::integer as bulan'),
                DB::raw('COUNT(id)::integer as total_user')
            )
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->get();

        $pertumbuhan_user = collect(range(1, 12))->map(function ($bulan) use ($pertumbuhan_user_raw) {
            $data = $pertumbuhan_user_raw->firstWhere('bulan', $bulan);
            return [
                'bulan'      => $bulan,
                'nama_bulan' => $this->namaBulan($bulan),
                'total_user' => $data ? (int) $data->total_user : 0,
            ];
        });

        // === Distribusi Produk Per Kategori ===
        $distribusi_produk = DB::table('produks')
            ->join('categories', 'produks.category_id', '=', 'categories.id')
            ->select(
                'categories.nama_category',
                DB::raw('COUNT(produks.id)::integer as total_produk')
            )
            ->groupBy('categories.nama_category')
            ->orderByDesc('total_produk')
            ->get();

        // === Transaksi Per Bulan (chart) ===
        $transaksi_bulanan_raw = Invoice::where('status', 'lunas')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('EXTRACT(MONTH FROM created_at)::integer as bulan'),
                DB::raw('SUM(total_harga)::integer as total'),
                DB::raw('COUNT(id)::integer as jumlah_transaksi')
            )
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->get();

        $transaksi_bulanan = collect(range(1, 12))->map(function ($bulan) use ($transaksi_bulanan_raw) {
            $data = $transaksi_bulanan_raw->firstWhere('bulan', $bulan);
            return [
                'bulan'            => $bulan,
                'nama_bulan'       => $this->namaBulan($bulan),
                'total'            => $data ? (int) $data->total : 0,
                'jumlah_transaksi' => $data ? (int) $data->jumlah_transaksi : 0,
            ];
        });

        // === Aktivitas Admin Terakhir ===
        $aktivitas_admin = DB::table('product_violations')
            ->join('users', 'product_violations.user_id', '=', 'users.id')
            ->join('produks', 'product_violations.produk_id', '=', 'produks.id')
            ->select(
                'product_violations.id',
                'users.name as admin_name',
                'product_violations.jenis_pelanggaran as action',
                'produks.nama_produk',
                'product_violations.peringatan_ke',
                'product_violations.dikirim_at as timestamp',
                DB::raw("'SUCCESS' as status")
            )
            ->orderByDesc('product_violations.dikirim_at')
            ->take(10)
            ->get();

        // === User Terbaru ===
        $user_terbaru = User::where('role', 'user')
            ->latest()
            ->take(5)
            ->get(['id', 'name', 'nama_bisnis', 'email', 'created_at']);

        return $this->success([
            'summary' => [
                'total_organisasi' => $total_organisasi,
                'total_user_aktif' => $total_user_aktif,
                'total_transaksi'  => $total_transaksi,
                'total_invoice'    => $total_invoice,
                'total_produk'     => $total_produk,
                'total_category'   => $total_category,
                'health_status'    => $health_status,
            ],
            'chart' => [
                'tahun'             => (int) $year,
                'pertumbuhan_user'  => $pertumbuhan_user,
                'transaksi_bulanan' => $transaksi_bulanan,
                'distribusi_produk' => $distribusi_produk,
            ],
            'aktivitas_admin' => $aktivitas_admin,
            'user_terbaru'    => $user_terbaru,
        ], 'Data dashboard owner');
    }

    private function namaBulan(int $bulan): string
    {
        $bulanMap = [
            1  => 'Jan', 2  => 'Feb', 3  => 'Mar',
            4  => 'Apr', 5  => 'Mei', 6  => 'Jun',
            7  => 'Jul', 8  => 'Agu', 9  => 'Sep',
            10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];
        return $bulanMap[$bulan] ?? '';
    }
}
