<?php
$format_rupiah = function ($nominal) { return 'Rp' . number_format((float) $nominal, 0, ',', '.'); };
?>
<div class="d-flex align-items-center justify-content-between mb-3">
    <div><a href="<?= base_url('wali_murid/tagihan') ?>" class="text-muted"><i class="ri-arrow-left-line"></i>
            Kembali</a>
        <h3 class="mb-0 mt-2">Detail Tagihan</h3>
    </div>
</div>
<div class="card portal-card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6"><small class="text-muted">Siswa</small>
                <div class="fw-semibold"><?= html_escape($tagihan['nama_siswa']) ?></div>
            </div>
            <div class="col-md-6"><small class="text-muted">Kelas</small>
                <div><?= html_escape($tagihan['nama_kelas']) ?></div>
            </div>
            <div class="col-md-4"><small class="text-muted">Tahun Ajaran</small>
                <div><?= html_escape($tagihan['periode']) ?></div>
            </div>
            <div class="col-md-4"><small class="text-muted">Jenis Tagihan</small>
                <div><?= html_escape($tagihan['nama_jenis_tagihan']) ?></div>
            </div>
            <div class="col-md-4"><small class="text-muted">Periode</small>
                <div>
                    <?= html_escape(($tagihan['nama_bulan'] ?: '-') . ($tagihan['tahun'] ? ' ' . $tagihan['tahun'] : '')) ?>
                </div>
            </div>
            <div class="col-md-4"><small class="text-muted">Jatuh Tempo</small>
                <div><?= html_escape($tagihan['tanggal_jatuh_tempo'] ?: '-') ?></div>
            </div>
            <div class="col-md-4"><small class="text-muted">Status</small>
                <div><span class="badge bg-light text-dark"><?= html_escape($tagihan['status_pembayaran']) ?></span>
                </div>
            </div>
        </div>
        <hr>
        <div class="row g-3">
            <div class="col-6 col-md-3"><small class="text-muted">Nominal Awal</small>
                <div><?= $format_rupiah($tagihan['nominal_awal']) ?></div>
            </div>
            <div class="col-6 col-md-3"><small class="text-muted">Potongan</small>
                <div><?= $format_rupiah($tagihan['nilai_keringanan']) ?></div>
            </div>
            <div class="col-6 col-md-3"><small class="text-muted">Nominal Tagihan</small>
                <div><?= $format_rupiah($tagihan['nominal_tagihan']) ?></div>
            </div>
            <div class="col-6 col-md-3"><small class="text-muted">Sudah Dibayar</small>
                <div><?= $format_rupiah($tagihan['nominal_dibayar']) ?></div>
            </div>
            <div class="col-12"><small class="text-muted">Sisa</small>
                <div class="fs-4 fw-bold text-primary"><?= $format_rupiah($tagihan['sisa_tagihan']) ?></div>
            </div>
        </div>
    </div>
</div>
<div class="card portal-card">
    <div class="card-header">
        <h5 class="mb-0">Riwayat Cicilan</h5>
    </div>
    <div class="card-body">
        <?php if (empty($cicilan)): ?>
            <div class="text-muted">Belum ada pembayaran untuk tagihan ini.</div>
        <?php else:
            foreach ($cicilan as $row): ?>
                <div class="border rounded p-3 mb-2 d-flex justify-content-between gap-3 flex-wrap">
                    <div>
                        <div class="fw-semibold"><?= html_escape($row['tanggal_transaksi']) ?> |
                            <?= html_escape($row['no_transaksi']) ?></div>
                        <div><?= $format_rupiah($row['nominal_bayar']) ?> | <?= html_escape($row['nama_metode_pembayaran']) ?> <span
                                class="badge bg-light text-dark"><?= html_escape($row['status_transaksi']) ?></span></div>
                    </div>
                    <a class="btn btn-sm btn-outline-primary align-self-center" target="_blank"
                        href="<?= base_url('wali_murid/bukti_pembayaran/cetak/' . $row['id_pembayaran']) ?>">Bukti</a>
                </div>
            <?php endforeach; endif; ?>
        <div class="alert alert-light border mt-3 mb-0">Pembayaran dilakukan melalui administrasi/bendahara sekolah.
        </div>
    </div>
</div>