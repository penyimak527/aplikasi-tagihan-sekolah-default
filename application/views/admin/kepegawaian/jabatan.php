<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data <?= $title; ?></h4>
        <button type="button" class="btn btn-outline-primary" onclick="tambah()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="cari" placeholder="Cari jabatan ..." onkeyup="jabatan()">
                        <span class="input-group-text bg-primary text-white">
                            <i class="ri-search-line"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="data_jabatan" class="crud-list"></div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3">
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

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah">
                    <div class="mb-2">
                        <label class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jabatan" class="form-control" placeholder="Nama jabatan ..." required>
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

<!-- Modal Edit -->
<div class="modal fade" id="edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit">
                    <input type="hidden" name="id" id="id_jabatan">
                    <div class="mb-2">
                        <label class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jabatan" id="nama_jabatan_edit" class="form-control" placeholder="Nama jabatan ..." required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-update">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    jabatan();

    $('#btn-simpan').click(function () {
        var form = $('#form-tambah');
        var nama = $.trim(form.find('[name="nama_jabatan"]').val());

        if (nama === '') {
            Swal.fire('Perhatian', 'Nama jabatan wajib diisi.', 'warning');
            return;
        }

        var button = $('#btn-simpan').prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/kepegawaian/jabatan/tambah'); ?>',
            type: 'POST',
            data: form.serialize(),
            dataType: 'JSON',
            success: function (data) {
                if (data.result === 'true') {
                    $('#tambah').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message || 'Data berhasil disimpan'
                    });
                    $('#form-tambah')[0].reset();
                    jabatan();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Data gagal disimpan'
                    });
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr, status, error);
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    });

    $('#btn-update').click(function () {
        var form = $('#form-edit');
        var nama = $.trim(form.find('[name="nama_jabatan"]').val());

        if (nama === '') {
            Swal.fire('Perhatian', 'Nama jabatan wajib diisi.', 'warning');
            return;
        }

        var button = $('#btn-update').prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/kepegawaian/jabatan/edit'); ?>',
            type: 'POST',
            data: form.serialize(),
            dataType: 'JSON',
            success: function (data) {
                if (data.result === 'true') {
                    $('#edit').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message || 'Data berhasil diupdate'
                    });
                    jabatan();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Data gagal diupdate'
                    });
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr, status, error);
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    });

    $('#dt-length-0').on('change', function () {
        refreshPagination();
    });
});

function jabatan() {
    var search = $('#cari').val();

    $.ajax({
        url: '<?= base_url('admin/kepegawaian/jabatan/jabatan_result'); ?>',
        type: 'POST',
        data: {
            search: search
        },
        dataType: 'JSON',
        success: function (data) {
            var no = 1;
            var html = '';

            if (!Array.isArray(data) || data.length === 0) {
                html = '<div class="empty-state">Belum ada data jabatan.</div>';
            } else {
                data.forEach(function (item) {
                    var detail = btoa(unescape(encodeURIComponent(JSON.stringify(item))));

                    html += '<div class="crud-list-item">' +
                        '<div class="crud-content">' +
                            '<div class="crud-title">' + (no++) + '. ' + escapeHtml(item.nama_jabatan || '-') + '</div>' +
                        '</div>' +
                        '<div class="crud-actions">' +
                            '<button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="edit(\'' + detail + '\')"><i class="ri-edit-line"></i></button>' +
                            '<button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus(\'' + Number(item.id) + '\')"><i class="ri-delete-bin-line"></i></button>' +
                        '</div>' +
                    '</div>';
                });
            }

            $('#data_jabatan').html(html);
            refreshPagination();
        },
        error: function (xhr, status, error) {
            ajaxError(xhr, status, error);
        }
    });
}

function tambah() {
    $('#form-tambah')[0].reset();
    $('#tambah').modal('show');
}

function edit(detail) {
    var item = JSON.parse(decodeURIComponent(escape(atob(detail))));

    $('#id_jabatan').val(item.id);
    $('#nama_jabatan_edit').val(item.nama_jabatan || '');
    $('#edit').modal('show');
}

function hapus(id) {
    Swal.fire({
        title: 'Hapus Data',
        text: 'Anda yakin ingin menghapus data jabatan ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('admin/kepegawaian/jabatan/hapus'); ?>',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.result === 'true') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message || 'Data berhasil dihapus'
                        });
                        jabatan();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Data gagal dihapus'
                        });
                    }
                },
                error: function (xhr, status, error) {
                    ajaxError(xhr, status, error);
                }
            });
        }
    });
}

function refreshPagination() {
    paging(
        $('#data_jabatan .crud-list-item'),
        parseInt($('#dt-length-0').val(), 10) || 10,
        '#pagination'
    );
}
</script>
