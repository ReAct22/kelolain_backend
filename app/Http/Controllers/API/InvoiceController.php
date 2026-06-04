<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Http\Traits\ApiResponse;
use App\Models\Invoice;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $query = Invoice::with('details')
            ->where('user_id', $request->user()->id);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by metode_bayar
        if ($request->filled('metode_bayar')) {
            $query->where('metode_bayar', $request->metode_bayar);
        }

        // Filter by tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }
        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        // Search by nama pelanggan atau no invoice
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'like', '%' . $search . '%')
                  ->orWhere('no_invoice', 'like', '%' . $search . '%');
            });
        }

        $perPage  = $request->input('per_page', 15);
        $invoices = $query->latest()->paginate($perPage);

        return $this->success($invoices, 'Data invoice');
    }

    public function store(InvoiceRequest $request)
    {
        DB::beginTransaction();
        try {
            $total_harga = 0;
            $details     = [];

            // Validasi stok & kalkulasi total
            foreach ($request->items as $item) {
                $produk = Produk::where('user_id', $request->user()->id)
                    ->find($item['produk_id']);

                if (!$produk) {
                    DB::rollBack();
                    return $this->error("Produk ID {$item['produk_id']} tidak ditemukan.", 404);
                }

                if ($produk->status === 'nonaktif') {
                    DB::rollBack();
                    return $this->error("Produk '{$produk->nama_produk}' sedang nonaktif.", 422);
                }

                if ($produk->stok < $item['qty']) {
                    DB::rollBack();
                    return $this->error(
                        "Stok produk '{$produk->nama_produk}' tidak mencukupi. Stok tersedia: {$produk->stok}.",
                        422
                    );
                }

                $subtotal     = $produk->harga * $item['qty'];
                $total_harga += $subtotal;

                $details[] = [
                    'produk'      => $produk,
                    'nama_produk' => $produk->nama_produk,
                    'harga'       => $produk->harga,
                    'qty'         => $item['qty'],
                    'subtotal'    => $subtotal,
                ];
            }

            // Validasi total bayar tidak kurang dari total harga (khusus cash)
            if ($request->metode_bayar === 'cash' && $request->total_bayar < $total_harga) {
                DB::rollBack();
                return $this->error('Total bayar kurang dari total harga.', 422);
            }

            // Buat invoice
            $invoice = Invoice::create([
                'user_id'         => $request->user()->id,
                'no_invoice'      => $this->generateNoInvoice(),
                'nama_pelanggan'  => $request->nama_pelanggan,
                'no_hp_pelanggan' => $request->no_hp_pelanggan,
                'total_harga'     => $total_harga,
                'total_bayar'     => $request->total_bayar,
                'kembalian'       => max(0, $request->total_bayar - $total_harga),
                'status'          => 'lunas',
                'metode_bayar'    => $request->metode_bayar,
                'catatan'         => $request->catatan,
            ]);

            // Buat detail & kurangi stok
            foreach ($details as $detail) {
                $invoice->details()->create([
                    'produk_id'   => $detail['produk']->id,
                    'nama_produk' => $detail['nama_produk'],
                    'harga'       => $detail['harga'],
                    'qty'         => $detail['qty'],
                    'subtotal'    => $detail['subtotal'],
                ]);

                $detail['produk']->decrement('stok', $detail['qty']);
            }

            DB::commit();

            return $this->created($invoice->load('details'), 'Invoice berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->serverError('Gagal membuat invoice', $e->getMessage());
        }
    }

    public function show(Request $request, string $id)
    {
        $invoice = Invoice::with(['details.produk'])
            ->where('user_id', $request->user()->id)
            ->find($id);

        if (!$invoice) {
            return $this->notFound('Invoice tidak ditemukan');
        }

        return $this->success($invoice, 'Detail invoice');
    }

    public function update(Request $request, string $id)
    {
        $invoice = Invoice::where('user_id', $request->user()->id)->find($id);

        if (!$invoice) {
            return $this->notFound('Invoice tidak ditemukan');
        }

        $request->validate([
            'status'  => 'sometimes|in:lunas,belum_lunas',
            'catatan' => 'nullable|string',
        ]);

        $data = [];
        if ($request->filled('status')) $data['status']  = $request->status;
        if ($request->has('catatan'))   $data['catatan']  = $request->catatan;

        $invoice->update($data);

        return $this->success($invoice->load('details'), 'Invoice berhasil diupdate');
    }

    public function destroy(Request $request, string $id)
    {
        $invoice = Invoice::where('user_id', $request->user()->id)->find($id);

        if (!$invoice) {
            return $this->notFound('Invoice tidak ditemukan');
        }

        $invoice->details()->delete();
        $invoice->delete();

        return $this->success(null, 'Invoice berhasil dihapus');
    }

    /**
     * Generate nomor invoice unik format: INV-YYYYMMDD-XXXXX
     */
    private function generateNoInvoice(): string
    {
        $date   = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        return "INV-{$date}-{$random}";
    }
}
