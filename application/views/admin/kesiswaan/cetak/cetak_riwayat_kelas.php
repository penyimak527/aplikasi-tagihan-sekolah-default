<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= html_escape($title) ?></title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 20px;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
            background: #fff;
        }
        .toolbar {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
        }
        .toolbar button {
            padding: 7px 12px;
            border: 1px solid #999;
            border-radius: 4px;
            background: #fff;
            cursor: pointer;
        }
        .title {
            text-align: center;
            margin-bottom: 18px;
        }
        .title h1 {
            margin: 0;
            font-size: 18px;
        }
        .title p {
            margin: 4px 0 0;
            font-size: 11px;
        }
        .identity {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .identity td {
            padding: 3px 5px;
            vertical-align: top;
        }
        .identity td:first-child {
            width: 130px;
            font-weight: bold;
        }
        .section-title {
            margin: 18px 0 8px;
            font-size: 13px;
            font-weight: bold;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th,
        .data-table td {
            border: 1px solid #333;
            padding: 6px 7px;
            vertical-align: top;
        }
        .data-table th {
            text-align: center;
            background: #f2f2f2;
        }
        .text-center { text-align: center; }
        .muted { color: #555; }
        .footer-info {
            margin-top: 14px;
            font-size: 10px;
        }
        @page {
            size: A4 portrait;
            margin: 12mm;
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

    <div class="title">
        <h1>RIWAYAT KELAS SISWA</h1>
        <p>Riwayat penempatan dan perubahan kelas siswa</p>
    </div>

    <table class="identity">
        <tr>
            <td>Nama Siswa</td>
            <td>: <?= html_escape(isset($siswa['nama_lengkap']) ? $siswa['nama_lengkap'] : '-') ?></td>
        </tr>
        <tr>
            <td>NIS</td>
            <td>: <?= html_escape(!empty($siswa['nis']) ? $siswa['nis'] : '-') ?></td>
        </tr>
        <tr>
            <td>NISN</td>
            <td>: <?= html_escape(!empty($siswa['nisn']) ? $siswa['nisn'] : '-') ?></td>
        </tr>
        <tr>
            <td>Status Siswa</td>
            <td>: <?= html_escape(!empty($siswa['status_pendaftaran']) ? $siswa['status_pendaftaran'] : '-') ?></td>
        </tr>
    </table>

    <div class="section-title">Riwayat Penempatan Kelas</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:40px;">No</th>
                <th>Tahun Ajaran</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Tanggal Proses</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($placements)): ?>
                <tr>
                    <td colspan="6" class="text-center">Belum ada penempatan kelas.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($placements as $index => $row): ?>
                    <?php
                    $aktif = (string) $row['status_aktif'] === '1';
                    $status = $aktif ? 'Aktif' : (!empty($row['jenis_proses']) ? $row['jenis_proses'] : 'Riwayat');
                    ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td><?= html_escape(!empty($row['periode']) ? $row['periode'] : '-') ?></td>
                        <td><?= html_escape(!empty($row['nama_kelas']) ? $row['nama_kelas'] : '-') ?></td>
                        <td><?= html_escape($status) ?></td>
                        <td><?= html_escape(!empty($row['tanggal_proses']) ? $row['tanggal_proses'] : '-') ?></td>
                        <td><?= html_escape(!empty($row['nama_user']) ? $row['nama_user'] : '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="section-title">Riwayat Perubahan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:40px;">No</th>
                <th>Proses</th>
                <th>Kelas Asal</th>
                <th>Kelas Tujuan</th>
                <th>Tanggal</th>
                <th>Petugas</th>
                <th>Alasan / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($history)): ?>
                <tr>
                    <td colspan="7" class="text-center">Belum ada riwayat perubahan.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($history as $index => $row): ?>
                    <tr>
                        <td class="text-center"><?= $index + 1 ?></td>
                        <td><?= html_escape(!empty($row['jenis_proses']) ? $row['jenis_proses'] : 'Perubahan Kelas') ?></td>
                        <td>
                            <?= html_escape(!empty($row['nama_kelas_asal']) ? $row['nama_kelas_asal'] : '-') ?><br>
                            <span class="muted"><?= html_escape(!empty($row['periode_asal']) ? $row['periode_asal'] : '-') ?></span>
                        </td>
                        <td>
                            <?= html_escape(!empty($row['nama_kelas_tujuan']) ? $row['nama_kelas_tujuan'] : '-') ?><br>
                            <span class="muted"><?= html_escape(!empty($row['periode_tujuan']) ? $row['periode_tujuan'] : '-') ?></span>
                        </td>
                        <td>
                            <?= html_escape(!empty($row['tanggal_proses']) ? $row['tanggal_proses'] : '-') ?>
                            <?= html_escape(!empty($row['waktu_proses']) ? $row['waktu_proses'] : '') ?>
                        </td>
                        <td><?= html_escape(!empty($row['nama_user']) ? $row['nama_user'] : '-') ?></td>
                        <td><?= html_escape(!empty($row['alasan']) ? $row['alasan'] : '-') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer-info">Dicetak: <?= html_escape($tanggal_cetak) ?></div>
</body>
</html>
