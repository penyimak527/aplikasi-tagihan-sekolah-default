<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Kelas</h4>
        <button type="button" class="btn btn-outline-primary" onclick="tambah()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-7">
                <input type="text" id="search" class="form-control" placeholder="Cari kelas ...">
            </div>
            <div class="col-md-3">
                <select id="status_filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="REGULER">REGULER</option>
                    <option value="NONREGULER">NONREGULER</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" onclick="data_kelas()">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="data"></div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3">
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" placeholder="Nama Kelas ..." required>
                    </div>

                    <input type="hidden" name="jurusan" value="">

                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="REGULER">REGULER</option>
                            <option value="NONREGULER">NONREGULER</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btn-simpan" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit">
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" placeholder="Nama Kelas ..." required>
                    </div>

                    <input type="hidden" name="jurusan">

                    <div>
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="REGULER">REGULER</option>
                            <option value="NONREGULER">NONREGULER</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btn-update" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="detail_content"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
let dataRows = [];

$(document).ready(function () {
    data_kelas();

    $('#search').on('keyup', function (event) {
        if (event.key === 'Enter') {
            data_kelas();
        }
    });

    $('#status_filter').on('change', function () {
        data_kelas();
    });

    $('#btn-simpan').on('click', function () {
        var form = $('#form-tambah');
        var data = form.serialize();

        $.ajax({
            url: '<?= base_url('admin/master_data/data_kelas/tambah'); ?>',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.result == 'true') {
                    $('#tambah').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message || 'Data kelas berhasil disimpan.'
                    });

                    $('#form-tambah')[0].reset();
                    data_kelas();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Data kelas gagal disimpan.'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat menyimpan data.'
                });
            }
        });
    });

    $('#btn-update').on('click', function () {
        var form = $('#form-edit');
        var data = form.serialize();

        $.ajax({
            url: '<?= base_url('admin/master_data/data_kelas/edit'); ?>',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.result == 'true') {
                    $('#edit').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: data.message || 'Data kelas berhasil diperbarui.'
                    });

                    data_kelas();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Data kelas gagal diperbarui.'
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat memperbarui data.'
                });
            }
        });
    });

    $('#dt-length-0').on('change', function () {
        var jumlah = parseInt($(this).val(), 10) || 10;
        paging($('#data .crud-list-item'), jumlah);
    });
});

function data_kelas() {
    var search = $('#search').val();
    var status = $('#status_filter').val();

    $.ajax({
        url: '<?= base_url('admin/master_data/data_kelas/result'); ?>',
        type: 'POST',
        data: {
            search: search,
            status: status
        },
        dataType: 'JSON',
        success: function (data) {
            dataRows = Array.isArray(data) ? data : [];

            var no = 1;
            var html = '';

            if (dataRows.length == 0) {
                html += `
                    <div class="crud-list-item">
                        <div class="crud-content">
                            <div class="crud-title">Tidak ada data</div>
                        </div>
                    </div>
                `;
            } else {
                //  <div class="crud-meta">
                //                     Jurusan/Kelompok: ${escapeHtml(row.jurusan || '-')}
                //                 </div>
                dataRows.forEach(function (row) {
                    html += `
                        <div class="crud-list-item">
                            <div class="crud-content">
                                <div class="crud-status">
                                    Status:
                                    <span class="badge bg-primary">${escapeHtml(row.status || '-')}</span>
                                </div>
                                <div class="crud-title">${no++}. ${escapeHtml(row.nama_kelas || '-')}</div>
                                <div class="crud-note">
                                    Pengaturan periode: ${Number(row.jumlah_setting || 0)}
                                    |
                                    Siswa aktif: ${Number(row.jumlah_siswa || 0)}
                                </div>
                            </div>
                            <div class="crud-actions">
                                <button type="button" class="btn btn-outline-primary btn-icon" title="Detail" onclick="detailData(${row.id})">
                                    <i class="ri-eye-line"></i>
                                </button>
                                <button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="editData(${row.id})">
                                    <i class="ri-edit-line"></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus(${row.id})">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
            }

            $('#data').html(html);

            var jumlah_awal = parseInt($('#dt-length-0').val(), 10) || 10;
            paging($('#data .crud-list-item'), jumlah_awal);
        },
        error: function () {
            $('#data').html(`
                <div class="crud-list-item">
                    <div class="crud-content">
                        <div class="crud-title">Data gagal dimuat</div>
                    </div>
                </div>
            `);
        }
    });
}

function tambah() {
    $('#form-tambah')[0].reset();
    $('#tambah').modal('show');
}

function editData(id) {
    var row = dataRows.find(function (item) {
        return Number(item.id) === Number(id);
    });

    if (!row) {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: 'Data kelas tidak ditemukan.'
        });
        return;
    }

    $('#form-edit [name="id"]').val(row.id);
    $('#form-edit [name="nama_kelas"]').val(row.nama_kelas || '');
    $('#form-edit [name="jurusan"]').val(row.jurusan || '');
    $('#form-edit [name="status"]').val(row.status || 'REGULER');

    $('#edit').modal('show');
}

function detailData(id) {
    $('#detail_content').html('<div class="empty-state">Memuat detail...</div>');
    $('#detail').modal('show');

    $.ajax({
        url: '<?= base_url('admin/master_data/data_kelas/detail'); ?>',
        type: 'POST',
        data: {
            id: id
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.result != 'true') {
                $('#detail_content').html(
                    '<div class="alert alert-danger">' +
                    escapeHtml(data.message || 'Detail kelas gagal dimuat.') +
                    '</div>'
                );
                return;
            }

            var row = data.data || {};
            var setting = Array.isArray(data.setting) ? data.setting : [];
            var table = '';

            if (setting.length == 0) {
                table = `
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                Kelas belum digunakan pada kelas_setting.
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                setting.forEach(function (item, index) {
                    table += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${escapeHtml(item.periode || '-')}</td>
                            <td class="text-center">${Number(item.jumlah_siswa || 0).toLocaleString('id-ID')}</td>
                        </tr>
                    `;
                });
            }
//  <div class="col-md-4">
//                         <strong>Jurusan/Kelompok</strong>
//                         <div>${escapeHtml(row.jurusan || '-')}</div>
//                     </div>
            $('#detail_content').html(`
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <strong>Nama Kelas</strong>
                        <div>${escapeHtml(row.nama_kelas || '-')}</div>
                    </div>
                    <div class="col-md-4">
                        <strong>Status</strong>
                        <div>
                            <span class="badge bg-primary">${escapeHtml(row.status || '-')}</span>
                        </div>
                    </div>
                </div>

                <h6 class="mb-3">Penggunaan Kelas</h6>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Ajaran</th>
                                <th class="text-center">Siswa Aktif</th>
                            </tr>
                        </thead>
                        <tbody>${table}</tbody>
                    </table>
                </div>
            `);
        },
        error: function () {
            $('#detail_content').html(
                '<div class="alert alert-danger">Detail kelas gagal dimuat.</div>'
            );
        }
    });
}

function hapus(id) {
    Swal.fire({
        title: 'Hapus Data',
        text: 'Kelas yang sudah digunakan pada pengaturan kelas tidak dapat dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value || result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('admin/master_data/data_kelas/hapus'); ?>',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.result == 'true') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message || 'Kelas berhasil dihapus.'
                        });

                        data_kelas();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Kelas gagal dihapus.'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan saat menghapus data.'
                    });
                }
            });
        }
    });
}

function paging($selector, jumlah_tampil = 10) {
    window.tp = new Pagination('#pagination', {
        itemsCount: $selector.length,
        pageSize: parseInt(jumlah_tampil, 10),
        onPageChange: function (paging) {
            var start = paging.pageSize * (paging.currentPage - 1);
            var end = start + paging.pageSize;
            var $rows = $selector;

            $rows.hide();

            for (var i = start; i < end; i++) {
                $rows.eq(i).show();
            }
        }
    });
}
</script>