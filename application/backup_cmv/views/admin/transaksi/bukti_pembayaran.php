<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title><?= html_escape($header['no_transaksi']) ?></title>
    <style>
        body {
            font: 13px Arial;
            margin: 20px;
            color: #111
        }

        .receipt {
            max-width: 760px;
            margin: auto
        }

        .center {
            text-align: center
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0
        }

        .line {
            border-top: 1px dashed #555;
            margin: 12px 0
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            text-align: left
        }

        .right {
            text-align: right
        }

        .btn {
            padding: 9px 14px;
            background: #1677ff;
            color: white;
            border: 0;
            border-radius: 4px;
            cursor: pointer
        }

        @media print {
            .no-print {
                display: none
            }

            body {
                margin: 0
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="center">
            <h2 style="margin-bottom:2px"><?= html_escape(config_item('nama_sekolah') ?: 'SEKOLAH') ?></h2><strong>BUKTI
                PEMBAYARAN</strong>
        </div>
        <div class="line"></div>
        <div class="row"><span>No. Transaksi</span><strong><?= html_escape($header['no_transaksi']) ?></strong></div>
        <div class="row">
            <span>Tanggal</span><span><?= html_escape($header['tanggal_transaksi'] . ' ' . $header['waktu_transaksi']) ?></span>
        </div>
        <div class="row"><span>Siswa</span><span><?= html_escape($header['nama_siswa']) ?></span></div>
        <div class="row"><span>NIS/NISN</span><span><?= html_escape($header['nis'] . ' / ' . $header['nisn']) ?></span>
        </div>
        <div class="row"><span>Kelas</span><span><?= html_escape($header['nama_kelas']) ?></span></div>
        <div class="line"></div>
        <table>
            <thead>
                <tr>
                    <th>Tagihan</th>
                    <th>Periode</th>
                    <th class="right">Dibayar</th>
                    <th class="right">Sisa</th>
                </tr>
            </thead>
            <tbody><?php foreach ($detail as $d): ?>
                    <tr>
                        <td><?= html_escape($d['nama_tagihan']) ?></td>
                        <td><?= html_escape(($d['nama_bulan'] ?: '') . ' ' . $d['tahun']) ?></td>
                        <td class="right"><?= rupiah($d['nominal_bayar']) ?></td>
                        <td class="right"><?= rupiah($d['sisa_setelah']) ?></td>
                    </tr><?php endforeach ?>
            </tbody>
        </table>
        <div class="line"></div>
        <div class="row"><strong>Total Pembayaran</strong><strong><?= rupiah($header['total_pembayaran']) ?></strong>
        </div>
        <div class="row"><span>Metode</span><span><?= html_escape($header['nama_metode_pembayaran']) ?></span></div>
        <div class="row"><span>Uang diterima</span><span><?= rupiah($header['uang_diterima']) ?></span></div>
        <div class="row"><span>Kembalian</span><span><?= rupiah($header['kembalian']) ?></span></div>
        <div class="row"><span>Petugas</span><span><?= html_escape($header['nama_user']) ?></span></div>
        <?php if ($header['status_transaksi'] === 'Dibatalkan'): ?>
            <h3 class="center" style="color:#c00">TRANSAKSI DIBATALKAN</h3><?php endif ?>
        <div class="center no-print" style="margin-top:20px"><button class="btn" onclick="window.print()">Cetak / Simpan
                PDF</button></div>
    </div>
    <script>window.addEventListener('afterprint', () => fetch('<?= base_url('admin/transaksi/riwayat_pembayaran/catat_cetak/' . $header['id']) ?>'));</script>
</body>

</html>