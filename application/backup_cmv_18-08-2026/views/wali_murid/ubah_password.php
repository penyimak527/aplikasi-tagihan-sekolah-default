<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card portal-card">
            <div class="card-header">
                <h4 class="mb-0">Ubah Password</h4>
            </div>
            <div class="card-body">
                <?php if (!empty($wajib_ganti)): ?>
                    <div class="alert alert-warning">Anda wajib mengganti password sebelum menggunakan Portal Wali Murid.
                    </div><?php endif; ?>
                <form method="post" action="<?= base_url('wali_murid/profil/proses_ubah_password') ?>">
                    <div class="mb-3"><label class="form-label">Password Saat Ini</label><input type="password"
                            class="form-control" name="password_lama" required></div>
                    <div class="mb-3"><label class="form-label">Password Baru</label><input type="password"
                            class="form-control" name="password_baru" minlength="8" required><small
                            class="text-muted">Minimal 8 karakter.</small></div>
                    <div class="mb-3"><label class="form-label">Ulangi Password Baru</label><input type="password"
                            class="form-control" name="konfirmasi_password" minlength="8" required></div>
                    <div class="d-flex justify-content-end gap-2"><?php if (empty($wajib_ganti)): ?><a
                                class="btn btn-light"
                                href="<?= base_url('wali_murid/profil') ?>">Batal</a><?php endif; ?><button
                            class="btn btn-primary" type="submit">Simpan Password</button></div>
                </form>
            </div>
        </div>
    </div>
</div>