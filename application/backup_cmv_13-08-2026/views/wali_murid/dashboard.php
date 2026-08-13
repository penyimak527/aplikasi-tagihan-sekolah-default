<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h3 class="mb-1">Beranda Portal Wali Murid</h3>
        <p class="text-muted mb-0">Ringkasan kondisi tagihan dan pembayaran anak.</p>
    </div>
</div>

<?php if (!empty($anak)): ?>
    <div class="row g-3 mb-3">
        <?php
        $utama = array(
            array('Tagihan Aktif', $ringkasan['tagihan_aktif'], 'ri-file-list-3-line'),
            array('Sudah Dibayar', $ringkasan['sudah_dibayar'], 'ri-checkbox-circle-line'),
            array('Sisa Tagihan', $ringkasan['sisa_tagihan'], 'ri-wallet-3-line')
        );
        foreach ($utama as $card): ?>
            <div class="col-md-6 col-xl-4">
                <div class="card portal-card h-100">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted mb-2"><?= html_escape($card[0]) ?></div>
                            <div class="portal-stat-value"><?= rupiah($card[1]) ?></div>
                        </div>
                        <i class="<?= $card[2] ?> fs-3 text-primary"></i>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card portal-card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-2">Tunggakan Lama</div>
                        <div class="portal-stat-value"><?= rupiah($ringkasan['tunggakan_lama']) ?></div>
                    </div>
                    <i class="ri-error-warning-line fs-3 text-primary"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card portal-card h-100">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted mb-2">Jumlah Anak</div>
                        <div class="portal-stat-value"><?= (int) $jumlah_anak ?> siswa</div>
                    </div>
                    <i class="ri-group-line fs-3 text-primary"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="card portal-card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Tagihan yang Perlu Diperhatikan</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($perhatian)): ?>
                        <div class="text-muted">Tidak ada tagihan yang perlu diperhatikan pada filter yang dipilih.</div>
                    <?php else:
                        foreach ($perhatian as $row): ?>
                            <div class="portal-list-item">
                                <div class="d-flex justify-content-between gap-3 flex-wrap">
                                    <div>
                                        <strong><?= html_escape($row['nama_siswa']) ?></strong> <span class="text-muted">-
                                            <?= html_escape($row['nama_kelas']) ?></span><br>
                                        <span><?= html_escape($row['nama_tagihan']) ?><?= !empty($row['nama_bulan']) ? ' ' . html_escape($row['nama_bulan']) . ' ' . (int) $row['tahun'] : '' ?></span><br>
                                        <small class="text-muted">Sisa
                                            <?= rupiah($row['sisa_tagihan']) ?>            <?= $row['tanggal_jatuh_tempo'] ? ' • Jatuh tempo ' . html_escape($row['tanggal_jatuh_tempo']) : '' ?></small>
                                    </div>
                                    <a class="btn btn-sm btn-outline-primary align-self-center"
                                        href="<?= base_url('wali_murid/tagihan/detail/' . $row['id']) ?>">Detail</a>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card portal-card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Pembayaran Terbaru</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($pembayaran_terbaru)): ?>
                        <div class="text-muted">Belum ada transaksi pembayaran.</div>
                    <?php else:
                        foreach ($pembayaran_terbaru as $row): ?>
                            <div class="border-bottom pb-3 mb-3">
                                <div class="fw-semibold"><?= html_escape($row['tanggal_transaksi']) ?> •
                                    <?= html_escape($row['nama_siswa']) ?></div>
                                <div class="text-muted small mb-1">
                                    <?= html_escape($row['rincian_tagihan'] ?: $row['no_transaksi']) ?></div>
                                <div class="d-flex justify-content-between align-items-center gap-2">
                                    <strong><?= rupiah($row['total_pembayaran']) ?></strong><a target="_blank"
                                        href="<?= base_url('wali_murid/bukti_pembayaran/cetak/' . $row['id']) ?>">Lihat Bukti</a>
                                </div>
                            </div>
                        <?php endforeach; endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>