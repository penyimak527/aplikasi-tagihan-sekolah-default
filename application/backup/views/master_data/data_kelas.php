<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Kelas</h4>
        <button type="button" class="btn btn-outline-primary" onclick="openForm()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-7">
                <input type="text" id="search" class="form-control" placeholder="Cari kelas atau jurusan ...">
            </div>
            <div class="col-md-3">
                <select id="status_filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="REGULER">REGULER</option>
                    <option value="NONREGULER">NONREGULER</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" onclick="loadData()">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>
        <div id="data" class="crud-list"></div>
    </div>
</div>

<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Tambah Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control" placeholder="Nama Kelas ..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan/Kelompok</label>
                        <input type="text" name="jurusan" class="form-control" placeholder="Jurusan atau kelompok ...">
                    </div>
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
                <button type="button" id="btn_simpan" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kelas</h5>
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

$(document).ready(function () {
    modalForm = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalForm'));
    modalDetail = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetail'));
    loadData();

    $('#search').on('keyup', function (event) {
        if (event.key === 'Enter') loadData();
    });
    $('#status_filter').on('change', loadData);
    $('#btn_simpan').on('click', saveData);
});

function loadData() {
    $.post('<?= base_url('data_kelas/result') ?>', {
        search: $('#search').val(),
        status: $('#status_filter').val()
    }, function (rows) {
        dataRows = rows || [];
        if (!rows.length) {
            $('#data').html('<div class="empty-state">Belum ada data kelas.</div>');
            return;
        }

        const html = rows.map(function (row, index) {
            return `
                <div class="crud-list-item">
                    <div class="crud-content">
                        <div class="crud-status">Status: <span class="badge bg-primary">${escapeHtml(row.status || '-')}</span></div>
                        <div class="crud-title">${index + 1}. ${escapeHtml(row.nama_kelas)}</div>
                        <div class="crud-meta">Jurusan/Kelompok: ${escapeHtml(row.jurusan || '-')}</div>
                        <div class="crud-note">Pengaturan periode: ${Number(row.jumlah_setting || 0)} | Siswa aktif: ${Number(row.jumlah_siswa || 0)}</div>
                    </div>
                    <div class="crud-actions">
                        <button type="button" class="btn btn-outline-primary btn-icon" title="Detail" onclick="detailData(${row.id})">
                            <i class="ri-eye-line"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="openFormById(${row.id})">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus(${row.id})">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>`;
        }).join('');

        $('#data').html(html);
    }, 'json').fail(ajaxError);
}


function detailData(id) {
    $('#detail_content').html('<div class="empty-state">Memuat detail...</div>');
    modalDetail.show();
    $.post('<?= base_url('data_kelas/detail') ?>', {id: id}, function (response) {
        if (response.result !== 'true') {
            $('#detail_content').html('<div class="alert alert-danger">' + escapeHtml(response.message) + '</div>');
            return;
        }
        var row = response.data;
        var setting = response.setting || [];
        var table = setting.length ? setting.map(function (item, index) {
            return '<tr><td>' + (index + 1) + '</td><td>' + escapeHtml(item.periode || '-') + '</td><td>' + escapeHtml(item.semester || '-') + '</td><td>' + escapeHtml(item.wali_kelas || '-') + '</td><td class="text-center">' + Number(item.jumlah_siswa || 0).toLocaleString('id-ID') + '</td></tr>';
        }).join('') : '<tr><td colspan="5"><div class="empty-state">Kelas belum digunakan pada kelas_setting.</div></td></tr>';
        $('#detail_content').html(
            '<div class="row g-3 mb-3"><div class="col-md-4"><strong>Nama Kelas</strong><div>' + escapeHtml(row.nama_kelas || '-') + '</div></div><div class="col-md-4"><strong>Jurusan/Kelompok</strong><div>' + escapeHtml(row.jurusan || '-') + '</div></div><div class="col-md-4"><strong>Status</strong><div><span class="badge bg-primary">' + escapeHtml(row.status || '-') + '</span></div></div></div>' +
            '<h6 class="mb-3">Penggunaan Kelas</h6><div class="table-responsive"><table class="table table-hover align-middle"><thead><tr><th>No</th><th>Tahun Ajaran</th><th>Semester</th><th>Wali Kelas</th><th class="text-center">Siswa Aktif</th></tr></thead><tbody>' + table + '</tbody></table></div>'
        );
    }, 'json').fail(ajaxError);
}

function openFormById(id) {
    const row = dataRows.find(function (item) { return Number(item.id) === Number(id); });
    openForm(row);
}

function openForm(row) {
    $('#form')[0].reset();
    $('#form [name="id"]').val(row ? row.id : '');
    $('#modal_title').text(row ? 'Edit Kelas' : 'Tambah Kelas');

    if (row) {
        $('#form [name="nama_kelas"]').val(row.nama_kelas);
        $('#form [name="jurusan"]').val(row.jurusan);
        $('#form [name="status"]').val(row.status);
    }

    modalForm.show();
}

function saveData() {
    const button = $('#btn_simpan');
    button.prop('disabled', true);

    $.post('<?= base_url('data_kelas/simpan') ?>', $('#form').serialize(), function (response) {
        const berhasil = response.result === 'true';
        if (berhasil) {
            modalForm.hide();
            loadData();
        }
        Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
    }, 'json').fail(ajaxError).always(function () {
        button.prop('disabled', false);
    });
}

function hapus(id) {
    confirmAction('Hapus kelas?', 'Kelas yang sudah digunakan tidak dapat dihapus.', function () {
        $.post('<?= base_url('data_kelas/hapus') ?>', {id: id}, function (response) {
            const berhasil = response.result === 'true';
            Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
            if (berhasil) loadData();
        }, 'json').fail(ajaxError);
    });
}
</script>
