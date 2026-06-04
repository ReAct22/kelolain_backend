<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peringatan Produk - Kelolain</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #1a7a4a;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .header p {
            color: #a8d5b5;
            font-size: 14px;
            margin-top: 5px;
        }

        .badge {
            display: inline-block;
            background-color: #ffffff;
            color: #1a7a4a;
            font-weight: bold;
            font-size: 13px;
            padding: 5px 15px;
            border-radius: 20px;
            margin-top: 10px;
        }

        .badge.final {
            background-color: #ff4444;
            color: #ffffff;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
        }

        .greeting span {
            font-weight: bold;
            color: #1a7a4a;
        }

        .alert-box {
            border-left: 4px solid #f0ad4e;
            background-color: #fff8e1;
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-box.final {
            border-left-color: #ff4444;
            background-color: #fff0f0;
        }

        .alert-box h3 {
            font-size: 15px;
            margin-bottom: 8px;
            color: #856404;
        }

        .alert-box.final h3 {
            color: #cc0000;
        }

        .alert-box p {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
        }

        .detail-box {
            background-color: #f9f9f9;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .detail-box h3 {
            font-size: 14px;
            font-weight: bold;
            color: #555;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row .label {
            color: #888;
        }

        .detail-row .value {
            font-weight: 600;
            color: #333;
        }

        .value.danger {
            color: #cc0000;
        }

        .warning-steps {
            margin-bottom: 20px;
        }

        .warning-steps h3 {
            font-size: 14px;
            font-weight: bold;
            color: #555;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .step {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .step-num {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 13px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .step-num.done {
            background-color: #ff4444;
            color: white;
        }

        .step-num.pending {
            background-color: #e0e0e0;
            color: #999;
        }

        .step-text {
            font-size: 14px;
            color: #555;
        }

        .step-text.done {
            color: #cc0000;
            font-weight: 600;
        }

        .banned-box {
            background-color: #fff0f0;
            border: 1px solid #ffcccc;
            border-radius: 6px;
            padding: 15px 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .banned-box h3 {
            color: #cc0000;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .banned-box p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-note {
            font-size: 13px;
            color: #888;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .footer {
            background-color: #f5f5f5;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #eee;
        }

        .footer p {
            font-size: 12px;
            color: #aaa;
            line-height: 1.8;
        }

        .footer strong {
            color: #1a7a4a;
        }
    </style>
</head>

<body>
    <div class="container">

        {{-- Header --}}
        <div class="header">
            <h1>Kelolain</h1>
            <p>Solusi manajemen bisnis profesional</p>
            @if ($is_final)
                <span class="badge final">⚠️ Peringatan Final</span>
            @else
                <span class="badge">Peringatan ke-{{ $peringatan_ke }} dari 3</span>
            @endif
        </div>

        {{-- Content --}}
        <div class="content">

            <p class="greeting">Halo, <span>{{ $user->name }}</span> ({{ $user->nama_bisnis }})</p>

            {{-- Alert Box --}}
            @if ($is_final)
                <div class="alert-box final">
                    <h3>⛔ Produk Anda Telah Dihapus oleh Sistem</h3>
                    <p>Produk Anda telah menerima 3 peringatan dan secara otomatis dihapus oleh sistem. Akun Anda juga
                        dibanned dari menambahkan produk selama <strong>30 hari</strong>.</p>
                </div>
            @else
                <div class="alert-box">
                    <h3>⚠️ Produk Anda Melanggar Kebijakan Kelolain</h3>
                    <p>Kami menemukan bahwa produk Anda tidak sesuai dengan kebijakan platform kami. Harap segera
                        perbaiki atau hapus produk tersebut.</p>
                </div>
            @endif

            {{-- Detail Produk --}}
            <div class="detail-box">
                <h3>Detail Pelanggaran</h3>
                <div class="detail-row">
                    <span class="label">Nama Produk</span>
                    <span class="value">{{ $produk->nama_produk }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Jenis Pelanggaran</span>
                    <span class="value danger">
                        @if ($tipe_pelanggaran === 'harga_nol')
                            Harga Produk Rp 0
                        @elseif($tipe_pelanggaran === 'nama_tidak_sesuai')
                            Nama Produk Tidak Sesuai
                        @elseif($tipe_pelanggaran === 'kategori_terlarang')
                            Kategori Terlarang
                        @endif
                    </span>
                </div>
                <div class="detail-row">
                    <span class="label">Keterangan</span>
                    <span class="value">{{ $keterangan }}</span>
                </div>
                <div class="detail-row">
                    <span class="label">Peringatan ke</span>
                    <span class="value danger">{{ $peringatan_ke }} dari 3</span>
                </div>
            </div>

            {{-- Progress Peringatan --}}
            <div class="warning-steps">
                <h3>Status Peringatan</h3>
                @for ($i = 1; $i <= 3; $i++)
                    <div class="step">
                        <div class="step-num {{ $i <= $peringatan_ke ? 'done' : 'pending' }}">{{ $i }}</div>
                        <div class="step-text {{ $i <= $peringatan_ke ? 'done' : '' }}">
                            @if ($i < 3)
                                Peringatan ke-{{ $i }} — Banned tambah produk 1 hari
                            @else
                                Peringatan ke-3 — Produk dihapus & Banned 30 hari
                            @endif
                            @if ($i <= $peringatan_ke)
                                ✓
                            @endif
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Banned Info --}}
            @if ($is_final)
                <div class="banned-box">
                    <h3>🚫 Akun Dibanned 30 Hari</h3>
                    <p>Anda tidak dapat menambahkan produk baru selama 30 hari ke depan. Jika Anda merasa ini adalah
                        kesalahan, silakan hubungi tim Kelolain.</p>
                </div>
            @endif

            <p class="footer-note">
                Jika Anda merasa email ini tidak sesuai atau ingin mengajukan keberatan, silakan hubungi tim support
                kami di
                <strong>kelolainId@gmail.com</strong>. Kami akan meninjau laporan Anda dalam 1x24 jam.
            </p>

        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem <strong>Kelolain</strong>.<br>
                Harap tidak membalas email ini langsung.<br>
                © {{ date('Y') }} Kelolain. All rights reserved.</p>
        </div>

    </div>
</body>

</html>
