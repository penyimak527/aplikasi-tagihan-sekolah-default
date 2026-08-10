<div class="card">
    <div class="card-header app-card-header">
        <h4 class="header-title">Data Metode Pembayaran</h4>
        <button type="button" class="btn btn-outline-primary" id="btn_tambah_metode">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-7">
                <input type="text" id="search_metode" class="form-control" placeholder="Cari metode pembayaran ...">
            </div>
            <div class="col-md-3">
                <select id="status_metode" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn_cari_metode">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="data_metode" class="crud-list">
            <div class="empty-state">Memuat data metode pembayaran...</div>
        </div>
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

<div class="modal fade" id="modalMetode" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_metode_title">Tambah Metode Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form_metode">
                    <input type="hidden" name="id">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label for="nama_metode" class="form-label">Nama Metode</label>
                            <input type="text" id="nama_metode" name="nama_metode" class="form-control" placeholder="Contoh: Tunai, Transfer Bank, QRIS" required>
                        </div>
                        <div class="col-md-5">
                            <label for="butuh_uang_diterima" class="form-label">Memerlukan Uang Diterima/Kembalian</label>
                            <select id="butuh_uang_diterima" name="butuh_uang_diterima" class="form-select">
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                            <small class="text-muted">Pilih Ya untuk metode Tunai.</small>
                        </div>
                        <div class="col-md-4">
                            <label for="status_form_metode" class="form-label">Status</label>
                            <select id="status_form_metode" name="status" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label for="keterangan_metode" class="form-label">Keterangan</label>
                            <textarea id="keterangan_metode" name="keterangan" class="form-control" rows="3" placeholder="Keterangan metode pembayaran ..."></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_simpan_metode">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
var modalMetode = null;
var metodeRows = [];

$(document).ready(function () {
    modalMetode = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalMetode'));

    $('#btn_tambah_metode').on('click', function () { openMetodeForm(); });
    $('#btn_cari_metode').on('click', loadMetodeData);
    $('#status_metode').on('change', loadMetodeData);
    $('#search_metode').on('keyup', function (event) {
        if (event.key === 'Enter') loadMetodeData();
    });
    $('#btn_simpan_metode').on('click', saveMetodeData);
    $('#dt-length-0').on('change', refreshMetodePagination);

    loadMetodeData();
});

function loadMetodeData() {
    $('#data_metode').html('<div class="empty-state">Memuat data metode pembayaran...</div>');

    $.post('<?= base_url('admin/master_data/metode_pembayaran/result') ?>', {
        search: $('#search_metode').val(),
        status: $('#status_metode').val()
    }, function (rows) {
        metodeRows = rows || [];

        if (!metodeRows.length) {
            $('#data_metode').html('<div class="empty-state"><div class="empty-state-title">Data metode pembayaran tidak ditemukan</div><div>Gunakan kata kunci atau status lain.</div></div>');
            refreshMetodePagination();
            return;
        }

        var html = metodeRows.map(function (row, index) {
            var aktif = row.status === 'Aktif';
            var uangLabel = row.butuh_uang_diterima === 'Ya' ? 'Ditampilkan' : 'Disembunyikan';
            return '<div class="crud-list-item">' +
                '<div class="crud-content">' +
                    '<div class="crud-status">Status: <span class="badge bg-' + (aktif ? 'success' : 'secondary') + '">' + escapeHtml(row.status) + '</span></div>' +
                    '<div class="crud-title">' + (index + 1) + '. ' + escapeHtml(row.nama_metode) + '</div>' +
                    '<div class="crud-meta">Uang diterima/kembalian: ' + escapeHtml(uangLabel) + '</div>' +
                    '<div class="crud-note">Keterangan: ' + escapeHtml(row.keterangan || '-') + '</div>' +
                '</div>' +
                '<div class="crud-actions">' +
                    '<button type="button" class="btn btn-outline-warning btn-icon btn-edit-metode" data-id="' + row.id + '" title="Edit"><i class="ri-edit-line"></i></button>' +
                    '<button type="button" class="btn ' + (aktif ? 'btn-outline-danger' : 'btn-outline-primary') + ' btn-icon btn-status-metode" data-id="' + row.id + '" title="' + (aktif ? 'Nonaktifkan' : 'Aktifkan') + '">' +
                        '<i class="' + (aktif ? 'ri-close-circle-line' : 'ri-check-line') + '"></i>' +
                    '</button>' +
                '</div>' +
            '</div>';
        }).join('');

        $('#data_metode').html(html);
        refreshMetodePagination();
    }, 'json').fail(ajaxError);
}

$(document).on('click', '.btn-edit-metode', function () {
    var id = Number($(this).data('id'));
    var row = metodeRows.find(function (item) { return Number(item.id) === id; });
    openMetodeForm(row || null);
});

$(document).on('click', '.btn-status-metode', function () {
    var id = Number($(this).data('id'));
    var row = metodeRows.find(function (item) { return Number(item.id) === id; });
    if (!row) return;

    var action = row.status === 'Aktif' ? 'nonaktifkan' : 'aktifkan';
    confirmAction(
        (action === 'nonaktifkan' ? 'Nonaktifkan' : 'Aktifkan') + ' metode pembayaran?',
        'Riwayat transaksi lama tidak akan berubah.',
        function () {
            $.post('<?= base_url('admin/master_data/metode_pembayaran/status') ?>', {id: id}, function (response) {
                var berhasil = response.result === 'true';
                Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                if (berhasil) loadMetodeData();
            }, 'json').fail(ajaxError);
        }
    );
});

function openMetodeForm(row) {
    $('#form_metode')[0].reset();
    $('#form_metode [name="id"]').val(row ? row.id : '');
    $('#butuh_uang_diterima').val(row ? row.butuh_uang_diterima : 'Ya');
    $('#status_form_metode').val(row ? row.status : 'Aktif');
    $('#modal_metode_title').text(row ? 'Edit Metode Pembayaran' : 'Tambah Metode Pembayaran');

    if (row) {
        $('#nama_metode').val(row.nama_metode || '');
        $('#keterangan_metode').val(row.keterangan || '');
    }

    modalMetode.show();
}

function saveMetodeData() {
    var button = $('#btn_simpan_metode');
    button.prop('disabled', true);

    $.post('<?= base_url('admin/master_data/metode_pembayaran/simpan') ?>', $('#form_metode').serialize(), function (response) {
        var berhasil = response.result === 'true';
        if (berhasil) {
            modalMetode.hide();
            loadMetodeData();
        }
        Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
    }, 'json').fail(ajaxError).always(function () {
        button.prop('disabled', false);
    });
}

function refreshMetodePagination() {
    paging($('#data_metode .crud-list-item'), parseInt($('#dt-length-0').val(), 10) || 10, '#pagination');
}

</script>
