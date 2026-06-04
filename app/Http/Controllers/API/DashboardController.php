<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Models\Invoice;
use App\Models\Produk;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $user_id = $request->user()->id;
        $year    = $request->input('year', now()->year);

        // === Summary Cards ===
        $total_produk     = Produk::where('user_id', $user_id)->count();
        $total_category   = Category::where('user_id', $user_id)->count();
        $total_invoice    = Invoice::where('user_id', $user_id)->count();
        $total_pendapatan = (int) Invoice::where('user_id', $user_id)
            ->where('status', 'lunas')
            ->sum('total_harga');

        // Produk stok menipis (stok <= 5)
        $produk_stok_menipis = Produk::where('user_id', $user_id)
            ->where('status', 'aktif')
            ->where('stok', '<=', 5)
            ->orderBy('stok')
            ->take(5)
            ->get(['id', 'nama_produk', 'stok']);

        // === Invoice Terbaru ===
        $invoice_terbaru = Invoice::with('details')
            ->where('user_id', $user_id)
            ->latest()
            ->take(5)
            ->get();

        // === Pendapatan Per Bulan (chart) — PostgreSQL compatible ===
        $pendapatan_bulanan = Invoice::where('user_id', $user_id)
            ->where('status', 'lunas')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('EXTRACT(MONTH FROM created_at)::integer as bulan'),
                DB::raw('SUM(total_harga) as total'),
                DB::raw('COUNT(id) as jumlah_transaksi')
            )
            ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->orderBy(DB::raw('EXTRACT(MONTH FROM created_at)'))
            ->get();

        // Mapping ke 12 bulan (isi 0 jika tidak ada transaksi)
        $chart_pendapatan = collect(range(1, 12))->map(function ($bulan) use ($pendapatan_bulanan) {
            $data = $pendapatan_bulanan->firstWhere('bulan', $bulan);
            return [
                'bulan'            => $bulan,
                'nama_bulan'       => $this->namaBulan($bulan),
                'total'            => $data ? (int) $data->total : 0,
                'jumlah_transaksi' => $data ? (int) $data->jumlah_transaksi : 0,
            ];
        });

        // === Metode Bayar (pie chart) ===
        $metode_bayar = Invoice::where('user_id', $user_id)
            ->where('status', 'lunas')
            ->whereYear('created_at', $year)
            ->select('metode_bayar', DB::raw('COUNT(id)::integer as total'))
            ->groupBy('metode_bayar')
            ->get();

        // === Produk Terlaris ===
        $produk_terlaris = DB::table('invoice_details')
            ->join('invoices', 'invoice_details.invoice_id', '=', 'invoices.id')
            ->join('produks', 'invoice_details.produk_id', '=', 'produks.id')
            ->where('invoices.user_id', $user_id)
            ->where('invoices.status', 'lunas')
            ->whereYear('invoices.created_at', $year)
            ->select(
                'invoice_details.produk_id',
                'invoice_details.nama_produk',
                DB::raw('SUM(invoice_details.qty)::integer as total_terjual'),
                DB::raw('SUM(invoice_details.subtotal)::integer as total_pendapatan')
            )
            ->groupBy('invoice_details.produk_id', 'invoice_details.nama_produk')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        return $this->success([
            'summary' => [
                'total_produk'        => $total_produk,
                'total_category'      => $total_category,
                'total_invoice'       => $total_invoice,
                'total_pendapatan'    => $total_pendapatan,
                'produk_stok_menipis' => $produk_stok_menipis,
            ],
            'invoice_terbaru' => $invoice_terbaru,
            'chart'           => [
                'tahun'              => (int) $year,
                'pendapatan_bulanan' => $chart_pendapatan,
                'metode_bayar'       => $metode_bayar,
                'produk_terlaris'    => $produk_terlaris,
            ],
        ], 'Data dashboard');
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
