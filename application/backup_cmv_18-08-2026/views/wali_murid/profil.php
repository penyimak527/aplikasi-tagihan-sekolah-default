<div class="card portal-card mb-3">
    <div class="card-header">
        <h4 class="mb-0">Profil Wali Murid</h4>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6"><small class="text-muted">Nama</small>
                <div class="fw-semibold"><?= html_escape($wali['nama_wali']) ?></div>
            </div>
            <div class="col-md-6"><small class="text-muted">Username</small>
                <div><?= html_escape($wali['username']) ?></div>
            </div>
            <div class="col-md-6"><small class="text-muted">Telepon</small>
                <div><?= html_escape($wali['no_telepon'] ?: '-') ?></div>
            </div>
            <div class="col-md-6"><small class="text-muted">Email</small>
                <div><?= html_escape($wali['email'] ?: '-') ?></div>
            </div>
            <div class="col-md-6"><small class="text-muted">Status</small>
                <div><span class="badge bg-success-subtle text-success"><?= html_escape($wali['status']) ?></span></div>
            </div>
        </div>
        <a class="btn btn-outline-primary mt-3" href="<?= base_url('wali_murid/profil/ubah_password') ?>">Ubah
            Password</a>
    </div>
</div>
<div class="card portal-card">
    <div class="card-header">
        <h5 class="mb-0">Anak Terhubung</h5>
    </div>
    <div class="card-body">
        <?php if (empty($anak)): ?>
            <div class="text-muted">Belum ada siswa aktif yang terhubung.</div><?php else:
            foreach ($anak as $i => $a): ?>
                <div class="border rounded p-3 mb-2"><strong><?= ($i + 1) . '. ' . html_escape($a['nama_lengkap']) ?></strong>
                    <div class="text-muted">NISN <?= html_escape($a['nisn']) ?> | <?= html_escape($a['nama_kelas'] ?: '-') ?> |
                        Hubungan: <?= html_escape($a['hubungan']) ?></div>
                </div>
            <?php endforeach; endif; ?>
    </div>
</div>