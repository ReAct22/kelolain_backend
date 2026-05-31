<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Produk;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->user()->id;

        $total_produk    = Produk::where('user_id', $user_id)->count();
        $total_category  = Category::where('user_id', $user_id)->count();
        $total_invoice   = Invoice::where('user_id', $user_id)->count();
        $total_pendapatan = Invoice::where('user_id', $user_id)
                            ->where('status', 'lunas')
                            ->sum('total_harga');

        $invoice_terbaru = Invoice::with('details')
                            ->where('user_id', $user_id)
                            ->latest()
                            ->take(5)
                            ->get();

        return response()->json([
            'message' => 'Data dashboard',
            'data'    => [
                'total_produk'     => $total_produk,
                'total_category'   => $total_category,
                'total_invoice'    => $total_invoice,
                'total_pendapatan' => $total_pendapatan,
                'invoice_terbaru'  => $invoice_terbaru,
            ],
        ]);
    }
}
