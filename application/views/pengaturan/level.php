<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Level</h4>
        <button type="button" class="btn btn-outline-primary" onclick="tambah()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-10">
                <input type="text" class="form-control" id="cari" placeholder="Cari level ...">
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn-cari">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="data_level" class="crud-list"></div>

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

<div class="modal fade" id="modal-level" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Level</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form-level">
                    <input type="hidden" name="id" id="id_level">
                    <label class="form-label">Level</label>
                    <input type="text" name="level" id="nama_level" class="form-control" required>
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
    level();

    $('#btn-cari').click(function () {
        level();
    });

    $('#cari').keyup(function (event) {
        if (event.key === 'Enter') level();
    });

    $('#btn-simpan').click(function () {
        var form = $('#form-level');
        var data = form.serialize();

        $.ajax({
            url: '<?= base_url('pengaturan/level/simpan'); ?>',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.result == 'true') {
                    $('#modal-level').modal('hide');
                    Swal.fire({icon: 'success', title: 'Berhasil', text: data.message});
                    level();
                } else if (data.result == 'false') {
                    Swal.fire({icon: 'error', title: 'Gagal', text: data.message});
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    });

    $('#dt-length-0').on('change', function () {
        const jumlah = parseInt($(this).val());
        paging($('#data_level .crud-list-item'), jumlah);
    });
});

function level() {
    var search = $('#cari').val();

    $.ajax({
        url: '<?= base_url('pengaturan/level/level_result'); ?>',
        type: 'POST',
        data: {
            search: search
        },
        dataType: 'JSON',
        success: function (data) {
            var no = 1;
            var table = '';

            if (data.length == 0) {
                table = `
                    <div class="crud-list-item">
                        <div class="crud-content">
                            <div class="crud-title">Tidak ada data</div>
                        </div>
                    </div>`;
            } else {
                data.forEach(function (item) {
                    let detail = btoa(JSON.stringify(item));

                    table += `
                        <div class="crud-list-item">
                            <div class="crud-content">
                                <div class="crud-title">${no++}. ${escapeHtml(item.level)}</div>
                            </div>
                            <div class="crud-actions">
                                <button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="edit('${detail}')">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus('${item.id}')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>`;
                });
            }

            $('#data_level').html(table);
            let jumlah_awal = parseInt($('#dt-length-0').val());
            paging($('#data_level .crud-list-item'), jumlah_awal);
        },
        error: function (xhr, status, error) {
            ajaxError(xhr);
        }
    });
}

function tambah() {
    $('#form-level')[0].reset();
    $('#id_level').val('');
    $('#modal-title').text('Tambah Level');
    $('#modal-level').modal('show');
}

function edit(detail) {
    var item = JSON.parse(atob(detail));
    $('#id_level').val(item.id);
    $('#nama_level').val(item.level);
    $('#modal-title').text('Edit Level');
    $('#modal-level').modal('show');
}

function hapus(id) {
    Swal.fire({
        title: 'Hapus Level',
        text: 'Anda yakin ingin menghapus level ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('pengaturan/level/hapus'); ?>',
                type: 'POST',
                data: {id: id},
                dataType: 'JSON',
                success: function (data) {
                    if (data.result == 'true') {
                        Swal.fire({icon: 'success', title: 'Berhasil', text: data.message});
                        level();
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
