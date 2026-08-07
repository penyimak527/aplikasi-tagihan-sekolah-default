<div class="card">
    <div class="card-header border-bottom border-dashed d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="header-title mb-0">Edit User</h4>
            <small class="text-muted">Ubah data user dan level akses.</small>
        </div>
        <a href="<?= base_url('pengaturan/user') ?>" class="btn btn-light">
            <i class="ri-arrow-left-line me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form id="form-edit">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Pegawai</label>
                    <select name="id_pegawai" class="form-select">
                        <option value="">Pilih Pegawai</option>
                        <?php foreach ($pegawai as $row): ?>
                            <option value="<?= (int) $row['id'] ?>" <?= (int) $user['id_pegawai'] === (int) $row['id'] ? 'selected' : '' ?>>
                                <?= html_escape($row['nama_pegawai']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Level</label>
                    <select name="id_level" class="form-select" required>
                        <option value="">Pilih Level</option>
                        <?php foreach ($level as $row): ?>
                            <option value="<?= (int) $row['id'] ?>" <?= (int) $user['id_level'] === (int) $row['id'] ? 'selected' : '' ?>>
                                <?= html_escape($row['level']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama User</label>
                    <input type="text" name="nama_user" class="form-control" value="<?= html_escape($user['nama_user']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= html_escape($user['username']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                    <small class="text-muted">Kosongkan jika password tidak diubah.</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="konfirmasi_password" class="form-control" autocomplete="new-password">
                </div>
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="<?= base_url('pengaturan/user') ?>" class="btn btn-light">Batal</a>
                    <button type="button" class="btn btn-primary" id="btn-update">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#btn-update').click(function () {
        var form = $('#form-edit');
        var data = form.serialize();

        $.ajax({
            url: '<?= base_url('pengaturan/user/update/' . (int) $user['id']); ?>',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.result == 'true') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message
                    }).then(function () {
                        window.location.href = '<?= base_url('pengaturan/user'); ?>';
                    });
                } else if (data.result == 'false') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message
                    });
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    });
});
</script>
