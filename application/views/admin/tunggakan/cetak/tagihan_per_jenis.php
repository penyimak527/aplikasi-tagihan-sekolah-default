<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title><?= html_escape($title) ?></title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 24px;
        }
        .toolbar {
            margin-bottom: 18px;
            display: flex;
            gap: 8px;
        }
        .toolbar button {
            border: 1px solid #999;
            background: #fff;
            padding: 7px 12px;
            cursor: pointer;
            border-radius: 4px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 18px;
        }
        .filter-table {
            border-collapse: collapse;
            margin-bottom: 18px;
            width: auto;
        }
        .filter-table td {
            padding: 2px 8px 2px 0;
            vertical-align: top;
        }
        .filter-table td:first-child {
            font-weight: bold;
            min-width: 120px;
        }
        .data-table {
            border-collapse: collapse;
            width: 100%;
        }
        .data-table th,
        .data-table td {
            border: 1px solid #333;
            padding: 6px 7px;
        }
        .data-table th {
            background: #f2f2f2;
            text-align: center;
        }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .summary {
            margin-top: 16px;
            width: 320px;
            border-collapse: collapse;
        }
        .summary td {
            padding: 4px 8px 4px 0;
        }
        .summary td:first-child {
            font-weight: bold;
            width: 120px;
        }
        .footer-info {
            margin-top: 12px;
            font-size: 10px;
        }
        @page {
            size: A4 landscape;
            margin: 10mm;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="toolbar no-print">
        <button type="button" onclick="window.print()">Cetak</button>
        <button type="button" onclick="window.close()">Tutup</button>
    </div>

    <div class="title">TAGIHAN PER JENIS</div>

    <table class="filter-table">
        <tr>
            <td>Tahun Ajaran</td>
            <td>: <?= html_escape($filter['tahun_ajaran']) ?></td>
        </tr>
        <tr>
            <td>Jenis Tagihan</td>
            <td>: <?= html_escape($filter['jenis_tagihan']) ?></td>
        </tr>
        <tr>
            <td>Batch/Periode</td>
            <td>: <?= html_escape($filter['batch_periode']) ?></td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: <?= html_escape($filter['kelas']) ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:38px;">No</th>
                <th>Siswa</th>
                <th>Kelas</th>
                <th>Tagihan</th>
                <th>Wajib</th>
                <th>Tarif Akhir</th>
                <th>Dibayar</th>
                <th>Sisa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $index => $row): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td>
                            <strong><?= html_escape($row['nama_siswa']) ?></strong><br>
                            <span style="font-size:10px;"><?= html_escape($row['nis']) ?></span>
                        </td>
                        <td><?= html_escape($row['nama_kelas']) ?></td>
                        <td>
                            <strong><?= html_escape($row['nama_tagihan']) ?></strong><br>
                            <span style="font-size:10px;">
                                <?= html_escape(trim((!empty($row['nama_bulan']) ? $row['nama_bulan'] . ' ' : '') . (!empty($row['tahun']) ? $row['tahun'] : ''))) ?>
                            </span>
                        </td>
                        <td><?= $row['dianggap_tunggakan'] === 'Ya' ? 'Ya' : 'Tidak' ?></td>
                        <td class="text-end">Rp<?= number_format((float) $row['nominal_tagihan'], 0, ',', '.') ?></td>
                        <td class="text-end">Rp<?= number_format((float) $row['nominal_dibayar'], 0, ',', '.') ?></td>
                        <td class="text-end">Rp<?= number_format((float) $row['sisa_tagihan'], 0, ',', '.') ?></td>
                        <td><?= html_escape($row['status_pembayaran']) ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td>Target</td>
            <td>: Rp<?= number_format((float) (isset($summary['target']) ? $summary['target'] : 0), 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Pembayaran</td>
            <td>: Rp<?= number_format((float) (isset($summary['bayar']) ? $summary['bayar'] : 0), 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Sisa</td>
            <td>: Rp<?= number_format((float) (isset($summary['sisa']) ? $summary['sisa'] : 0), 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Realisasi</td>
            <td>: <?= number_format((float) (isset($summary['realisasi']) ? $summary['realisasi'] : 0), 2, ',', '.') ?>%</td>
        </tr>
    </table>

    <div class="footer-info">
        Dicetak: <?= html_escape($tanggal_cetak) ?>
    </div>
</body>
</html>
