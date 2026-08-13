<div class="d-flex justify-content-between align-items-center mb-3 gap-2 flex-wrap">
    <div><a href="<?= base_url('wali_murid/riwayat_pembayaran') ?>" class="text-muted"><i
                class="ri-arrow-left-line"></i> Kembali</a>
        <h3 class="mt-2 mb-0">Detail Pembayaran</h3>
    </div>
    <a target="_blank" class="btn btn-primary"
        href="<?= base_url('wali_murid/bukti_pembayaran/cetak/' . $header['id']) ?>"><i
            class="ri-printer-line me-1"></i>Cetak / Simpan PDF</a>
</div>
<div class="card portal-card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4"><small class="text-muted">No. Transaksi</small>
                <div class="fw-semibold"><?= html_escape($header['no_transaksi']) ?></div>
            </div>
            <div class="col-md-4"><small class="text-muted">Tanggal</small>
                <div><?= html_escape($header['tanggal_transaksi'] . ' ' . $header['waktu_transaksi']) ?></div>
            </div>
            <div class="col-md-4"><small class="text-muted">Status</small>
                <div><span
                        class="badge <?= $header['status_transaksi'] === 'Aktif' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' ?>"><?= html_escape($header['status_transaksi']) ?></span>
                </div>
            </div>
            <div class="col-md-6"><small class="text-muted">Siswa</small>
                <div><?= html_escape($header['nama_siswa'] . ' - ' . $header['nama_kelas']) ?></div>
            </div>
            <div class="col-md-3"><small class="text-muted">Metode</small>
                <div><?= html_escape($header['nama_metode_pembayaran']) ?></div>
            </div>
            <div class="col-md-3"><small class="text-muted">Petugas</small>
                <div><?= html_escape($header['nama_user']) ?></div>
            </div>
        </div>
        <?php if ($header['status_transaksi'] === 'Dibatalkan' && $pembatalan): ?>
            <div class="alert alert-danger mt-3 mb-0">Transaksi dibatalkan.
                <?= html_escape($pembatalan['alasan_pembatalan'] ?? '') ?></div>
        <?php endif; ?>
    </div>
</div>
<div class="card portal-card">
    <div class="card-header">
        <h5 class="mb-0">Rincian</h5>
    </div>
    <div class="card-body">
        <?php foreach ($detail as $row): ?>
            <div class="d-flex justify-content-between border-bottom py-2 gap-3">
                <div>
                    <?= html_escape($row['nama_tagihan']) ?>    <?= $row['status_detail'] !== 'Aktif' ? ' <span class="text-danger">(Dibatalkan)</span>' : '' ?>
                </div><strong><?= rupiah($row['nominal_bayar']) ?></strong>
            </div>
        <?php endforeach; ?>
        <div class="d-flex justify-content-between pt-3"><strong>TOTAL</strong><strong
                class="fs-5"><?= rupiah($header['total_pembayaran']) ?></strong></div>
        <div class="d-flex justify-content-between mt-2"><span>Uang
                Diterima</span><span><?= rupiah($header['uang_diterima']) ?></span></div>
        <div class="d-flex justify-content-between">
            <span>Kembalian</span><span><?= rupiah($header['kembalian']) ?></span></div>
    </div>
</div>