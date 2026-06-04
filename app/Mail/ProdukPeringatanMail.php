<?php

namespace App\Mail;

use App\Models\Produk;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProdukPeringatanMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public Produk $produk;
    public int $peringatan_ke;
    public string $tipe_pelanggaran;
    public string $keterangan;
    public bool $is_final;

    public function __construct(
        User   $user,
        Produk $produk,
        int    $peringatan_ke,
        string $tipe_pelanggaran,
        string $keterangan
    ) {
        $this->user             = $user;
        $this->produk           = $produk;
        $this->peringatan_ke    = $peringatan_ke;
        $this->tipe_pelanggaran = $tipe_pelanggaran;
        $this->keterangan       = $keterangan;
        $this->is_final         = $peringatan_ke >= 3;
    }

    public function envelope(): Envelope
    {
        $subject = $this->is_final
            ? '[Kelolain] Produk Anda Telah Dihapus & Akun Dibanned 30 Hari'
            : '[Kelolain] Peringatan ke-' . $this->peringatan_ke . ' - Produk Melanggar Kebijakan';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.produk-peringatan',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
