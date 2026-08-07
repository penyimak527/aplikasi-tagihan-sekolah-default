<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data User</h4>
        <button type="button" class="btn btn-outline-primary" onclick="tambah()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-10">
                <input type="text" class="form-control" id="cari" placeholder="Cari nama user, username, level, atau pegawai ...">
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn-cari">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="data_user" class="crud-list"></div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-2">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-0" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-0">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>entri</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah">
                    <div class="mb-3">
                        <label class="form-label">Nama Pegawai</label>
                        <select name="id_pegawai" id="id_pegawai_tambah" class="form-select" required>
                            <option value=""></option>
                            <?php foreach ($pegawai as $row): ?>
                                <option value="<?= (int) $row['id'] ?>">
                                    <?= html_escape($row['nama_pegawai']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="id_level" id="id_level_tambah" class="form-select" required>
                            <option value="">Pilih Level</option>
                            <?php foreach ($level as $row): ?>
                                <option value="<?= (int) $row['id'] ?>">
                                    <?= html_escape($row['level']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="new-password" required>
                    </div>

                    <div>
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" class="form-control" placeholder="Konfirmasi Password" autocomplete="new-password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    user();

    $('#id_pegawai_tambah').select2({
        width: '100%',
        placeholder: 'Pilih Pegawai',
        allowClear: true,
        dropdownParent: $('#tambah')
    });

    $('#btn-cari').click(function () {
        user();
    });

    $('#cari').keyup(function (event) {
        if (event.key === 'Enter') {
            user();
        }
    });

    $('#btn-simpan').click(function () {
        var form = $('#form-tambah');
        var data = form.serialize();

        $.ajax({
            url: '<?= base_url('pengaturan/user/tambah'); ?>',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.result == 'true') {
                    $('#tambah').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message
                    });
                    $('#form-tambah')[0].reset();
                    $('#id_pegawai_tambah').val('').trigger('change');
                    user();
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

    $('#dt-length-0').on('change', function () {
        const jumlah = parseInt($(this).val());
        paging($('#data_user .crud-list-item'), jumlah);
    });
});

function user() {
    var search = $('#cari').val();

    $.ajax({
        url: '<?= base_url('pengaturan/user/user_result'); ?>',
        type: 'POST',
        data: {
            search: search
        },
        dataType: 'JSON',
        success: function (data) {
            var no = 1;
            var table = '';

            if (data.length == 0) {
                table += `
                    <div class="crud-list-item">
                        <div class="crud-content">
                            <div class="crud-title">Tidak ada data</div>
                        </div>
                    </div>`;
            } else {
                data.forEach(function (item) {
                    table += `
                        <div class="crud-list-item">
                            <div class="crud-content">
                                <div class="">
                                    <span>Level: ${escapeHtml(item.nama_level || '-')}</span>
                                </div>
                                <div class="crud-title">${no++}. ${escapeHtml(item.nama_user || '-')}</div>
                                <div class="crud-meta">Username: <b>${escapeHtml(item.username || '-')}</b></div>
                            </div>
                            <div class="crud-actions">
                                <a class="btn btn-outline-warning btn-icon" title="Edit" href="<?= base_url('pengaturan/user/edit/'); ?>${item.id}">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus('${item.id}')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>`;
                });
            }

            $('#data_user').html(table);
            let jumlah_awal = parseInt($('#dt-length-0').val());
            paging($('#data_user .crud-list-item'), jumlah_awal);
        },
        error: function (xhr, status, error) {
            ajaxError(xhr);
        }
    });
}

function tambah() {
    $('#form-tambah')[0].reset();
    $('#id_pegawai_tambah').val('').trigger('change');
    $('#tambah').modal('show');
}

function hapus(id) {
    Swal.fire({
        title: 'Hapus Data',
        text: 'Anda yakin ingin menghapus user ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('pengaturan/user/hapus'); ?>',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.result == 'true') {
                        Swal.fire({icon: 'success', title: 'Berhasil', text: data.message});
                        user();
                    } else if (data.result == 'false') {
                        Swal.fire({icon: 'error', title: 'Gagal', text: data.message});
                    }
                },
                error: function (xhr, status, error) {
                    ajaxError(xhr);
                }
            });
        }
    });
}
</script>
