<div class="card">
    <div class="card-header border-bottom border-dashed d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h4 class="header-title mb-0">Edit Data User</h4>
        </div>
        <a href="<?= base_url('pengaturan/user') ?>" class="btn btn-outline-danger">
            <i class="ri-arrow-left-line me-1"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <form id="form-edit">
            <div class="mb-3">
                <label class="form-label">Nama Pegawai</label>
                <select name="id_pegawai" id="id_pegawai_edit" class="form-select" required>
                    <option value=""></option>
                    <?php foreach ($pegawai as $row): ?>
                        <option
                            value="<?= (int) $row['id'] ?>"
                            <?= (int) $user['id_pegawai'] === (int) $row['id'] ? 'selected' : '' ?>>
                            <?= html_escape($row['nama_pegawai']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Level</label>
                <select name="id_level" id="id_level_edit" class="form-select" required>
                    <option value="">Pilih Level</option>
                    <?php foreach ($level as $row): ?>
                        <option
                            value="<?= (int) $row['id'] ?>"
                            <?= (int) $user['id_level'] === (int) $row['id'] ? 'selected' : '' ?>>
                            <?= html_escape($row['level']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" value="<?= html_escape($user['username']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="new-password">
                <small class="text-muted">Kosongkan jika password tidak diubah.</small>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" class="form-control" placeholder="Konfirmasi Password" autocomplete="new-password">
            </div>

            <button type="button" class="btn btn-primary" id="btn-update">Simpan</button>
        </form>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#id_pegawai_edit').select2({
        width: '100%',
        placeholder: 'Pilih Pegawai',
        allowClear: true
    });

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