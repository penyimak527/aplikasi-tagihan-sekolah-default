<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Jenis Tagihan</h4>
        <button type="button" class="btn btn-outline-primary" onclick="openForm()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-4">
                <input type="text" id="search" class="form-control" placeholder="Cari jenis tagihan ...">
            </div>
            <div class="col-md-2">
                <select id="tipe" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option value="Bulanan">Bulanan</option>
                    <option value="Langsung">Langsung</option>
                    <option value="Tahunan">Tahunan</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="filter_status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2 ">
                <button type="button" class="btn btn-primary" onclick="loadData()">
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Tambah Jenis Tagihan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" name="id">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kode</label>
                            <input type="text" name="kode_jenis" class="form-control" placeholder="Otomatis jika kosong">
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Nama Jenis Tagihan</label>
                            <input type="text" name="nama_jenis" class="form-control" placeholder="Nama jenis tagihan ..." required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipe</label>
                            <select name="tipe_default" class="form-select">
                                <option value="Bulanan">Bulanan</option>
                                <option value="Langsung">Langsung</option>
                                <option value="Tahunan">Tahunan</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Dihitung sebagai Tunggakan</label>
                            <select name="dianggap_tunggakan" class="form-select">
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" placeholder="Keterangan ..."></textarea>
                        </div>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jenis Tagihan</h5>
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
    $('#btn_simpan').on('click', saveData);
    $('#dt-length-0').on('change', refreshPagination);
});

function loadData() {
    $.post('<?= base_url('admin/master_data/jenis_tagihan/result') ?>', {
        search: $('#search').val(),
        tipe: $('#tipe').val(),
        status: $('#filter_status').val()
    }, function (rows) {
        dataRows = rows || [];
        if (!rows.length) {
            $('#data').html('<div class="empty-state">Belum ada jenis tagihan.</div>');
            refreshPagination();
            return;
        }

        const html = rows.map(function (row, index) {
            const aktif = row.status === 'Aktif';
            return `
                <div class="crud-list-item">
                    <div class="crud-content">
                        <div class="crud-status">Status: <span class="badge ${aktif ? 'bg-success' : 'bg-secondary'}">${escapeHtml(row.status)}</span></div>
                        <div class="crud-title">${index + 1}. ${escapeHtml(row.nama_jenis)}</div>
                        <div class="crud-meta">Tipe: ${escapeHtml(row.tipe_default)} | Dihitung tunggakan: ${escapeHtml(row.dianggap_tunggakan)}</div>
                        <div class="crud-note">Kode: ${escapeHtml(row.kode_jenis || '-')} | Keterangan: ${escapeHtml(row.keterangan || '-')}</div>
                    </div>
                    <div class="crud-actions">
                        <button type="button" class="btn btn-outline-primary btn-icon" title="Detail" onclick="detailData(${row.id})">
                            <i class="ri-eye-line"></i>
                        </button>
                        <button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="openFormById(${row.id})">
                            <i class="ri-edit-line"></i>
                        </button>
                        <button type="button" class="btn ${aktif ? 'btn-outline-danger' : 'btn-outline-primary'} btn-icon" title="${aktif ? 'Nonaktifkan' : 'Aktifkan'}" onclick="toggleStatus(${row.id})">
                            <i class="${aktif ? 'ri-close-circle-line' : 'ri-check-line'}"></i>
                        </button>
                    </div>
                </div>`;
        }).join('');

        $('#data').html(html);
        refreshPagination();
    }, 'json').fail(ajaxError);
}


function detailData(id) {
    const row = dataRows.find(function (item) { return Number(item.id) === Number(id); });
    if (!row) return;
    $('#detail_content').html(
        '<div class="row g-3">' +
            '<div class="col-md-6"><strong>Nama Jenis</strong><div>' + escapeHtml(row.nama_jenis || '-') + '</div></div>' +
            '<div class="col-md-3"><strong>Tipe</strong><div>' + escapeHtml(row.tipe_default || '-') + '</div></div>' +
            '<div class="col-md-3"><strong>Status</strong><div><span class="badge bg-' + (row.status === 'Aktif' ? 'success' : 'secondary') + '">' + escapeHtml(row.status || '-') + '</span></div></div>' +
            '<div class="col-md-6"><strong>Dihitung sebagai tunggakan</strong><div>' + escapeHtml(row.dianggap_tunggakan || '-') + '</div></div>' +
            '<div class="col-12"><strong>Keterangan</strong><div>' + escapeHtml(row.keterangan || '-') + '</div></div>' +
        '</div>'
    );
    modalDetail.show();
}

function openFormById(id) {
    const row = dataRows.find(function (item) { return Number(item.id) === Number(id); });
    openForm(row);
}

function openForm(row) {
    $('#form')[0].reset();
    $('#form [name="id"]').val(row ? row.id : '');
    $('#modal_title').text(row ? 'Edit Jenis Tagihan' : 'Tambah Jenis Tagihan');

    if (row) {
        Object.keys(row).forEach(function (key) {
            $('#form [name="' + key + '"]').val(row[key]);
        });
    }

    modalForm.show();
}

function saveData() {
    const button = $('#btn_simpan');
    button.prop('disabled', true);

    $.post('<?= base_url('admin/master_data/jenis_tagihan/simpan') ?>', $('#form').serialize(), function (response) {
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

function toggleStatus(id) {
    confirmAction('Ubah status?', 'Jenis yang sudah digunakan tidak dihapus, hanya statusnya yang diubah.', function () {
        $.post('<?= base_url('admin/master_data/jenis_tagihan/status') ?>', {id: id}, function (response) {
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
