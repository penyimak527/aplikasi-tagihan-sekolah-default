<?php
$format_rupiah = function ($nominal) { return 'Rp' . number_format((float) $nominal, 0, ',', '.'); };
?>
<?php
$f = is_array($format ?? null) ? $format : array();
$ukuran = $f['ukuran_kertas'] ?? '80mm';
$orientation = strtolower($f['orientasi'] ?? 'Portrait') === 'landscape' ? 'landscape' : 'portrait';
$marginTop = is_numeric($f['margin_atas'] ?? null) ? $f['margin_atas'] : 5;
$marginBottom = is_numeric($f['margin_bawah'] ?? null) ? $f['margin_bawah'] : 5;
$marginLeft = is_numeric($f['margin_kiri'] ?? null) ? $f['margin_kiri'] : 5;
$marginRight = is_numeric($f['margin_kanan'] ?? null) ? $f['margin_kanan'] : 5;
$pageSize = '80mm auto';
if ($ukuran === '58mm') $pageSize = '58mm auto';
elseif ($ukuran === 'A4') $pageSize = 'A4 ' . $orientation;
elseif ($ukuran === 'A5') $pageSize = 'A5 ' . $orientation;
elseif ($ukuran === 'Custom' && !empty($f['lebar_kertas']) && !empty($f['tinggi_kertas'])) $pageSize = $f['lebar_kertas'] . 'mm ' . $f['tinggi_kertas'] . 'mm';
elseif ($ukuran === '80mm') $pageSize = '80mm auto';
$namaSekolah = trim((string)($f['nama_sekolah'] ?? '')) ?: ($this->config->item('nama_sekolah') ?: 'SEKOLAH');
$judul = trim((string)($f['judul_bukti'] ?? '')) ?: 'BUKTI PEMBAYARAN';
$sisaTotal = 0;
foreach ($detail as $d) {
    if (($d['status_detail'] ?? '') === 'Aktif') $sisaTotal += (float)$d['sisa_setelah'];
}
function portal_terbilang($n)
{
    $n = abs((int)$n);
    $a = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    if ($n < 12) return $a[$n];
    if ($n < 20) return portal_terbilang($n - 10) . ' belas';
    if ($n < 100) return portal_terbilang(intdiv($n, 10)) . ' puluh ' . portal_terbilang($n % 10);
    if ($n < 200) return 'seratus ' . portal_terbilang($n - 100);
    if ($n < 1000) return portal_terbilang(intdiv($n, 100)) . ' ratus ' . portal_terbilang($n % 100);
    if ($n < 2000) return 'seribu ' . portal_terbilang($n - 1000);
    if ($n < 1000000) return portal_terbilang(intdiv($n, 1000)) . ' ribu ' . portal_terbilang($n % 1000);
    if ($n < 1000000000) return portal_terbilang(intdiv($n, 1000000)) . ' juta ' . portal_terbilang($n % 1000000);
    return (string)$n;
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= html_escape($header['no_transaksi']) ?></title>
    <style>
        @page {
            size: <?= html_escape($pageSize) ?>;
            margin: <?= $marginTop ?>mm <?= $marginRight ?>mm <?= $marginBottom ?>mm <?= $marginLeft ?>mm
        }

        * {
            box-sizing: border-box
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 0
        }

        .receipt {
            width: 100%;
            margin: auto
        }

        .center {
            text-align: center
        }

        .logo {
            max-width: 64px;
            max-height: 64px;
            margin-bottom: 5px
        }

        .school {
            font-size: 16px;
            font-weight: bold
        }

        .muted {
            color: #555;
            font-size: 11px
        }

        .line {
            border-top: 1px dashed #333;
            margin: 8px 0
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin: 3px 0
        }

        .row span:first-child {
            flex: 1
        }

        .row span:last-child {
            text-align: right
        }

        .total {
            font-size: 14px;
            font-weight: bold
        }

        .cancel {
            border: 2px solid #b00020;
            color: #b00020;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            padding: 6px;
            margin: 8px 0;
            transform: rotate(-3deg)
        }

        .footer {
            text-align: center;
            margin-top: 12px;
            white-space: pre-line
        }

        .sign {
            text-align: <?= strtolower($f['posisi_tanda_tangan'] ?? 'Kanan') === 'kiri' ? 'left' : (strtolower($f['posisi_tanda_tangan'] ?? '') === 'tengah' ? 'center' : 'right') ?>;
            margin-top: 22px
        }

        .no-print {
            margin: 15px;
            text-align: center
        }

        @media print {
            .no-print {
                display: none
            }
        }
    </style>
</head>

<body>
    <div class="no-print"><button onclick="window.print()">Cetak / Simpan PDF</button></div>
    <div class="receipt">
        <div class="center">
            <?php if (($f['tampilkan_logo'] ?? 'Ya') === 'Ya' && !empty($f['logo_sekolah'])): ?><img class="logo" src="<?= base_url($f['logo_sekolah']) ?>" alt="Logo"><?php endif; ?>
            <div class="school"><?= html_escape($namaSekolah) ?></div>
            <?php if (!empty($f['alamat_sekolah'])): ?><div class="muted"><?= nl2br(html_escape($f['alamat_sekolah'])) ?></div><?php endif; ?>
            <?php if (!empty($f['telepon_sekolah'])): ?><div class="muted"><?= html_escape($f['telepon_sekolah']) ?></div><?php endif; ?>
            <div class="line"></div><strong><?= html_escape($judul) ?></strong>
            <?php if (!empty($f['header_cetak'])): ?><div class="muted"><?= nl2br(html_escape($f['header_cetak'])) ?></div><?php endif; ?>
        </div>
        <?php if ($header['status_transaksi'] === 'Dibatalkan'): ?><div class="cancel">DIBATALKAN</div><?php endif; ?>
        <div class="line"></div>
        <div class="row"><span>No. Transaksi</span><span><?= html_escape($header['no_transaksi']) ?></span></div>
        <div class="row"><span>Tanggal</span><span><?= html_escape($header['tanggal_transaksi'] . ' ' . $header['waktu_transaksi']) ?></span></div>
        <div class="row"><span>Siswa</span><span><?= html_escape($header['nama_siswa']) ?></span></div>
        <div class="row"><span>Kelas</span><span><?= html_escape($header['nama_kelas']) ?></span></div>
        <div class="row"><span>Metode</span><span><?= html_escape($header['nama_metode_pembayaran']) ?></span></div>
        <div class="row"><span>Petugas</span><span><?= html_escape($header['nama_user']) ?></span></div>
        <div class="line"></div>
        <?php foreach ($detail as $d): ?><div class="row"><span><?= html_escape($d['nama_tagihan']) ?><?= $d['status_detail'] !== 'Aktif' ? ' (Dibatalkan)' : '' ?></span><span><?= $format_rupiah($d['nominal_bayar']) ?></span></div><?php endforeach; ?>
        <div class="line"></div>
        <div class="row total"><span>TOTAL</span><span><?= $format_rupiah($header['total_pembayaran']) ?></span></div>
        <?php if (($f['tampilkan_uang_diterima'] ?? 'Ya') === 'Ya'): ?><div class="row"><span>Uang Diterima</span><span><?= $format_rupiah($header['uang_diterima']) ?></span></div><?php endif; ?>
        <?php if (($f['tampilkan_kembalian'] ?? 'Ya') === 'Ya'): ?><div class="row"><span>Kembalian</span><span><?= $format_rupiah($header['kembalian']) ?></span></div><?php endif; ?>
        <?php if (($f['tampilkan_sisa_tagihan'] ?? 'Ya') === 'Ya'): ?><div class="row"><span>Sisa Tagihan</span><span><?= $format_rupiah($sisaTotal) ?></span></div><?php endif; ?>
        <?php if (($f['tampilkan_terbilang'] ?? 'Tidak') === 'Ya'): ?><div class="muted" style="margin-top:8px"><strong>Terbilang:</strong> <?= ucfirst(trim(portal_terbilang($header['total_pembayaran']))) ?> rupiah</div><?php endif; ?>
        <?php if (!empty($f['nama_penandatangan']) || !empty($f['jabatan_penandatangan'])): ?><div class="sign"><?= html_escape($f['jabatan_penandatangan'] ?? '') ?><br><br><br><strong><?= html_escape($f['nama_penandatangan'] ?? '') ?></strong></div><?php endif; ?>
        <?php if (!empty($f['footer_cetak'])): ?><div class="footer"><?= nl2br(html_escape($f['footer_cetak'])) ?></div><?php endif; ?>
    </div>
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>

</html>