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
        .info-table {
            border-collapse: collapse;
            margin-bottom: 18px;
            width: auto;
        }
        .info-table td {
            padding: 2px 8px 2px 0;
            vertical-align: top;
        }
        .info-table td:first-child {
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
            width: 340px;
            border-collapse: collapse;
        }
        .summary td {
            padding: 4px 8px 4px 0;
        }
        .summary td:first-child {
            font-weight: bold;
            width: 150px;
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

    <div class="title">TAGIHAN PER SISWA</div>

    <table class="info-table">
        <tr>
            <td>Nama Siswa</td>
            <td>: <?= html_escape(isset($siswa['nama_lengkap']) ? $siswa['nama_lengkap'] : '-') ?></td>
        </tr>
        <tr>
            <td>NIS / NISN</td>
            <td>: <?= html_escape(isset($siswa['nis']) ? $siswa['nis'] : '-') ?> / <?= html_escape(isset($siswa['nisn']) ? $siswa['nisn'] : '-') ?></td>
        </tr>
        <tr>
            <td>Kelas Aktif</td>
            <td>: <?= html_escape(!empty($siswa['nama_kelas']) ? $siswa['nama_kelas'] : 'Belum ditempatkan') ?></td>
        </tr>
        <tr>
            <td>Tahun Ajaran</td>
            <td>: <?= html_escape($filter['tahun_ajaran']) ?></td>
        </tr>
        <tr>
            <td>Tipe Tagihan</td>
            <td>: <?= html_escape($filter['tipe']) ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: <?= html_escape($filter['status']) ?></td>
        </tr>
        <tr>
            <td>Sampai Bulan</td>
            <td>: <?= html_escape($filter['sampai_bulan']) ?></td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>Tagihan</th>
                <th>Periode</th>
                <th>Wajib</th>
                <th>Nominal</th>
                <th>Dibayar</th>
                <th>Sisa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)): ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td>
                            <strong><?= html_escape(isset($row['nama_tagihan']) ? $row['nama_tagihan'] : '-') ?></strong><br>
                            <span style="font-size:10px;"><?= html_escape(isset($row['no_tagihan']) ? $row['no_tagihan'] : '-') ?></span>
                        </td>
                        <td>
                            <?= html_escape(trim((!empty($row['nama_bulan']) ? $row['nama_bulan'] . ' ' : '') . (!empty($row['tahun']) ? $row['tahun'] : ''))) ?><br>
                            <span style="font-size:10px;"><?= html_escape(isset($row['periode']) ? $row['periode'] : '-') ?></span>
                        </td>
                        <td class="text-center"><?= isset($row['dianggap_tunggakan']) && $row['dianggap_tunggakan'] === 'Ya' ? 'Ya' : 'Tidak' ?></td>
                        <td class="text-end">Rp<?= number_format((float) (isset($row['nominal_tagihan']) ? $row['nominal_tagihan'] : 0), 0, ',', '.') ?></td>
                        <td class="text-end">Rp<?= number_format((float) (isset($row['nominal_dibayar']) ? $row['nominal_dibayar'] : 0), 0, ',', '.') ?></td>
                        <td class="text-end">Rp<?= number_format((float) (isset($row['sisa_tagihan']) ? $row['sisa_tagihan'] : 0), 0, ',', '.') ?></td>
                        <td><?= html_escape(isset($row['status_pembayaran']) ? $row['status_pembayaran'] : '-') ?></td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <td>Total Tagihan Wajib</td>
            <td>: Rp<?= number_format((float) (isset($summary['wajib']) ? $summary['wajib'] : 0), 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Total Dibayar</td>
            <td>: Rp<?= number_format((float) (isset($summary['dibayar']) ? $summary['dibayar'] : 0), 0, ',', '.') ?></td>
        </tr>
        <tr>
            <td>Total Tunggakan</td>
            <td>: Rp<?= number_format((float) (isset($summary['tunggakan']) ? $summary['tunggakan'] : 0), 0, ',', '.') ?></td>
        </tr>
    </table>

    <div class="footer-info">
        Dicetak: <?= html_escape($tanggal_cetak) ?>
    </div>
</body>
</html>
