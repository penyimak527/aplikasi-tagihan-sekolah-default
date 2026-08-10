<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Tahun Ajaran</h4>
        <button type="button" class="btn btn-outline-primary" onclick="openForm()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-10">
                <input type="text" id="search" class="form-control" placeholder="Cari tahun ajaran ...">
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn_cari">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>
        <div id="data" class="crud-list"></div>
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

<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Tambah Tahun Ajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran</label>
                        <input type="text" class="form-control" name="periode" placeholder="Contoh: 2026/2027" required>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status">
                            <option value="Tidak Aktif">Tidak Aktif</option>
                            <option value="Aktif">Aktif</option>
                        </select>
                        <small class="text-muted d-block mt-2">Mengaktifkan periode ini akan menonaktifkan periode aktif sebelumnya.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Tahun Ajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="detail_content"></div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button></div>
        </div>
    </div>
</div>

<script>
    let modalForm;
    let modalDetail;
    let dataRows = [];

    $(document).ready(function() {
        modalForm = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalForm'));
        modalDetail = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetail'));
        loadData();

        $('#btn_cari').on('click', loadData);
        $('#search').on('keyup', function(event) {
            if (event.key === 'Enter') loadData();
        });
        $('#btn_simpan').on('click', saveData);
    $('#dt-length-0').on('change', refreshPagination);
    });

    function loadData() {
        $.post('<?= base_url('admin/master_data/tahun_ajaran/result') ?>', {
            search: $('#search').val()
        }, function(rows) {
            dataRows = rows || [];
            if (!rows.length) {
                $('#data').html('<div class="empty-state">Belum ada tahun ajaran.</div>');
                refreshPagination();
                return;
            }

            const html = rows.map(function(row, index) {
                const aktif = row.status === 'Aktif';
                return `
                <div class="crud-list-item">
                    <div class="crud-content">
                        <div class="crud-status">Status: <span class="badge ${aktif ? 'bg-success' : 'bg-secondary'}">${escapeHtml(row.status)}</span></div>
                        <div class="crud-title">${index + 1}. ${escapeHtml(row.periode)}</div>
                        <div class="crud-meta">Pengaturan kelas terkait: ${Number(row.jumlah_kelas || 0)}</div>
                    </div>
                    <div class="crud-actions">
                        <button type="button" class="btn btn-outline-primary btn-icon" title="Detail" onclick="detailData(${row.id})">
                            <i class="ri-eye-line"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="openFormById(${row.id})">
                            <i class="ri-edit-line"></i>
                        </button>
                        ${aktif ? `
                            <button type="button" class="btn btn-outline-secondary btn-icon" title="Periode aktif" disabled>
                                <i class="ri-check-double-line"></i>
                            </button>
                        ` : `
                            <button type="button" class="btn btn-outline-primary btn-icon" title="Aktifkan" onclick="aktifkan(${row.id})">
                                <i class="ri-check-line"></i>
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus(${row.id})">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        `}
                    </div>
                </div>`;
            }).join('');

            $('#data').html(html);
        refreshPagination();
        }, 'json').fail(ajaxError);
    }


    function detailData(id) {
        $('#detail_content').html('<div class="empty-state">Memuat detail...</div>');
        modalDetail.show();
        $.post('<?= base_url('admin/master_data/tahun_ajaran/detail') ?>', {
            id: id
        }, function(response) {
            if (response.result !== 'true') {
                $('#detail_content').html('<div class="alert alert-danger">' + escapeHtml(response.message) + '</div>');
                return;
            }
            var row = response.data;
            var kelas = response.kelas || [];
            var table = kelas.length ? kelas.map(function(item, index) {
                return '<tr><td>' + (index + 1) + '</td><td>' + escapeHtml(item.nama_kelas || '-') + '</td><td>' + escapeHtml(item.semester || '-') + '</td><td>' + escapeHtml(item.wali_kelas || '-') + '</td><td class="text-center">' + Number(item.jumlah_siswa || 0).toLocaleString('id-ID') + '</td></tr>';
            }).join('') : '<tr><td colspan="5"><div class="empty-state">Belum ada kelas_setting pada tahun ajaran ini.</div></td></tr>';
            $('#detail_content').html(
                '<div class="row g-3 mb-3"><div class="col-md-4"><strong>Periode</strong><div>' + escapeHtml(row.periode) + '</div></div><div class="col-md-4"><strong>Status</strong><div><span class="badge bg-' + (row.status === 'Aktif' ? 'success' : 'secondary') + '">' + escapeHtml(row.status) + '</span></div></div><div class="col-md-4"><strong>Dibuat/Diubah</strong><div>' + escapeHtml((row.tanggal || '-') + ' ' + (row.waktu || '')) + '</div></div></div>' +
                '<h6 class="mb-3">Kelas Terkait</h6><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>No</th><th>Kelas</th><th>Semester</th><th>Wali Kelas</th><th class="text-center">Siswa Aktif</th></tr></thead><tbody>' + table + '</tbody></table></div>'
            );
        }, 'json').fail(ajaxError);
    }

    function openFormById(id) {
        const row = dataRows.find(function(item) {
            return Number(item.id) === Number(id);
        });
        openForm(row);
    }

    function openForm(row) {
        $('#form')[0].reset();
        $('#form [name="id"]').val(row ? row.id : '');
        $('#modal_title').text(row ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran');

        if (row) {
            $('#form [name="periode"]').val(row.periode);
            $('#form [name="status"]').val(row.status);
        }

        modalForm.show();
    }

    function saveData() {
        const button = $('#btn_simpan');
        button.prop('disabled', true);

        $.post('<?= base_url('admin/master_data/tahun_ajaran/simpan') ?>', $('#form').serialize(), function(response) {
            const berhasil = response.result === 'true';
            if (berhasil) {
                modalForm.hide();
                loadData();
            }
            Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
        }, 'json').fail(ajaxError).always(function() {
            button.prop('disabled', false);
        });
    }

    function aktifkan(id) {
        confirmAction('Aktifkan tahun ajaran?', 'Periode aktif sebelumnya akan dinonaktifkan.', function() {
            $.post('<?= base_url('admin/master_data/tahun_ajaran/aktifkan') ?>', {
                id: id
            }, function(response) {
                const berhasil = response.result === 'true';
                Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                if (berhasil) loadData();
            }, 'json').fail(ajaxError);
        });
    }

    function hapus(id) {
        confirmAction('Hapus tahun ajaran?', 'Hanya data yang belum digunakan yang dapat dihapus.', function() {
            $.post('<?= base_url('admin/master_data/tahun_ajaran/hapus') ?>', {
                id: id
            }, function(response) {
                const berhasil = response.result === 'true';
                Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                if (berhasil) loadData();
            }, 'json').fail(ajaxError);
        });
    }

function refreshPagination() {
    paging($('#data .crud-list-item'), parseInt($('#dt-length-0').val(), 10) || 10, '#pagination');
}

</script>