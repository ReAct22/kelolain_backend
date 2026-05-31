<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('details')
            ->where('user_id', $request->user()->id)
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data invoice',
            'data'    => $invoices,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'no_hp_pelanggan'   => 'nullable|string|max:20',
            'total_bayar'       => 'required|integer',
            'metode_bayar'      => 'required|in:cash,transfer,qris',
            'catatan'           => 'nullable|string',
            'items'             => 'required|array|min:1',
            'items.*.produk_id' => 'required|exists:produks,id',
            'items.*.qty'       => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total_harga = 0;
            $details = [];

            foreach ($request->items as $item) {
                $produk = Produk::findOrFail($item['produk_id']);
                $subtotal = $produk->harga * $item['qty'];
                $total_harga += $subtotal;

                $details[] = [
                    'produk_id'   => $produk->id,
                    'nama_produk' => $produk->nama_produk,
                    'harga'       => $produk->harga,
                    'qty'         => $item['qty'],
                    'subtotal'    => $subtotal,
                ];

                // Kurangi stok
                $produk->decrement('stok', $item['qty']);
            }

            $invoice = Invoice::create([
                'user_id'         => $request->user()->id,
                'no_invoice'      => 'INV-' . strtoupper(uniqid()),
                'nama_pelanggan'  => $request->nama_pelanggan,
                'no_hp_pelanggan' => $request->no_hp_pelanggan,
                'total_harga'     => $total_harga,
                'total_bayar'     => $request->total_bayar,
                'kembalian'       => $request->total_bayar - $total_harga,
                'status'          => 'lunas',
                'metode_bayar'    => $request->metode_bayar,
                'catatan'         => $request->catatan,
            ]);

            foreach ($details as $detail) {
                $invoice->details()->create($detail);
            }

            DB::commit();

            return response()->json([
                'message' => 'Invoice berhasil dibuat',
                'data'    => $invoice->load('details'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal membuat invoice',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        $invoice = Invoice::with('details')
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        return response()->json([
            'message' => 'Detail invoice',
            'data'    => $invoice,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $invoice = Invoice::where('user_id', $request->user()->id)->findOrFail($id);
        $invoice->details()->delete();
        $invoice->delete();

        return response()->json([
            'message' => 'Invoice berhasil dihapus',
        ]);
    }
}
