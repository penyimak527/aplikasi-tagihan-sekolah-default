<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= html_escape($title) ?></title>
    <style>
        @page {{ size: A4 <?= $orientation === 'landscape' ? 'landscape' : 'portrait' ?>; margin: 12mm; }}
        * {{ box-sizing: border-box; }}
        body {{ font-family: Arial, sans-serif; margin: 0; color: #222; font-size: 12px; }}
        .toolbar {{ margin-bottom: 16px; }}
        .toolbar button {{ padding: 8px 14px; cursor: pointer; }}
        .report-header {{ text-align: center; margin-bottom: 14px; }}
        .report-header h2 {{ margin: 0 0 5px; font-size: 18px; }}
        .report-header p {{ margin: 2px 0; }}
        .meta {{ display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 5px 18px; margin-bottom: 12px; }}
        .meta-item {{ display: flex; gap: 6px; }}
        .meta-label {{ font-weight: bold; min-width: 110px; }}
        table {{ width: 100%; border-collapse: collapse; margin-top: 8px; }}
        th, td {{ border: 1px solid #444; padding: 6px 7px; vertical-align: top; }}
        th {{ background: #f1f1f1; text-align: left; }}
        .text-end {{ text-align: right; }}
        .summary {{ width: 55%; margin-left: auto; margin-top: 14px; }}
        .summary td:first-child {{ font-weight: bold; }}
        .empty {{ text-align: center; padding: 16px; }}
        .footer {{ margin-top: 16px; font-size: 11px; }}
        @media print {{ .no-print {{ display: none !important; }} body {{ font-size: 10.5px; }} }}
    </style>
</head>
<body>
    <div class="toolbar no-print">
        <button type="button" onclick="window.print()">Cetak / Simpan PDF</button>
    </div>

    <div class="report-header">
        <h2><?= html_escape($title) ?></h2>
        <p>Aplikasi Tagihan Sekolah</p>
    </div>

    <div class="meta">
        <?php foreach ($filter_laporan as $label => $value): ?>
            <div class="meta-item">
                <span class="meta-label"><?= html_escape($label) ?></span>
                <span>: <?= html_escape($value === '' ? '-' : $value) ?></span>
            </div>
        <?php endforeach; ?>
        <div class="meta-item">
            <span class="meta-label">Tanggal Cetak</span>
            <span>: <?= date('d-m-Y H:i:s') ?></span>
        </div>
        <div class="meta-item">
            <span class="meta-label">Petugas</span>
            <span>: <?= html_escape($petugas) ?></span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:45px;">No</th>
                <?php foreach ($laporan['columns'] as $key => $label): ?>
                    <th class="<?= in_array($key, $laporan['money'], true) ? 'text-end' : '' ?>">
                        <?= html_escape($label) ?>
                    </th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($laporan['rows'])): ?>
                <tr>
                    <td colspan="<?= count($laporan['columns']) + 1 ?>" class="empty">Tidak ada data sesuai filter.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($laporan['rows'] as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <?php foreach ($laporan['columns'] as $key => $label): ?>
                            <?php $isMoney = in_array($key, $laporan['money'], true); ?>
                            <td class="<?= $isMoney ? 'text-end' : '' ?>">
                                <?php if ($isMoney): ?>
                                    Rp<?= number_format((float) (isset($row[$key]) ? $row[$key] : 0), 0, ',', '.') ?>
                                <?php else: ?>
                                    <?= html_escape(isset($row[$key]) ? $row[$key] : '') ?>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if (!empty($laporan['summary'])): ?>
        <table class="summary">
            <tbody>
                <?php foreach ($laporan['summary'] as $label => $value): ?>
                    <?php $isMoney = preg_match('/target|pembayaran|sisa|tunggakan|dibatalkan|nominal|total bayar/i', $label); ?>
                    <tr>
                        <td><?= html_escape($label) ?></td>
                        <td class="text-end">
                            <?= $isMoney ? 'Rp' . number_format((float) $value, 0, ',', '.') : html_escape($value) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="footer">
        Laporan dibuat berdasarkan filter aktif dan data yang tersimpan pada aplikasi.
    </div>
</body>
</html>
