<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h4 class="header-title mb-0">Template WhatsApp</h4>
            <small class="text-muted">Template untuk bukti pembayaran dan surat tunggakan.</small>
        </div>
        <button type="button" class="btn btn-outline-primary" onclick="openForm()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-5">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" id="search" class="form-control" placeholder="Cari nama atau isi template ...">
            </div>
            <div class="col-md-3">
                <label for="filter_jenis" class="form-label">Jenis Template</label>
                <select id="filter_jenis" class="form-select">
                    <option value="">Semua Jenis</option>
                    <option value="Bukti Pembayaran">Bukti Pembayaran</option>
                    <option value="Surat Tunggakan">Surat Tunggakan</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="filter_status_template" class="form-label">Status</label>
                <select id="filter_status_template" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn_cari">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>
        <div id="list" class="crud-list"></div>
    </div>
</div>

<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Tambah Template WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" name="id" id="id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="jenis" class="form-label">Jenis Template</label>
                            <select name="jenis_template" id="jenis" class="form-select">
                                <option value="Bukti Pembayaran">Bukti Pembayaran</option>
                                <option value="Surat Tunggakan">Surat Tunggakan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Template</label>
                            <input type="text" name="nama_template" id="nama" class="form-control" placeholder="Nama template ..." required>
                        </div>
                        <div class="col-12">
                            <label for="isi" class="form-label">Pesan</label>
                            <textarea name="isi_template" id="isi" class="form-control" rows="8" required></textarea>
                        </div>
                        <div class="col-12">
                            <div class="alert alert-info mb-0 py-2">
                                <small>
                                    Variabel: {nama_wali}, {nama_siswa}, {kelas}, {tanggal}, {no_transaksi},
                                    {total_bayar}, {total_tunggakan}, {nama_sekolah}, {nama_petugas}
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="default_template" class="form-label">Jadikan Default</label>
                            <select name="status_default" id="default_template" class="form-select">
                                <option value="Tidak">Tidak</option>
                                <option value="Ya">Ya</option>
                            </select>
                            <small class="text-muted">Hanya satu template default untuk setiap jenis.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="status_template" class="form-label">Status</label>
                            <select name="status" id="status_template" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <small class="text-muted">Template tidak aktif tidak dipakai saat pengiriman.</small>
                        </div>
                    </div>
                    <div id="previewBox" class="alert alert-light border d-none mt-3 mb-0"></div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" id="preview" class="btn btn-outline-secondary">
                    <i class="ri-eye-line me-1"></i>Preview
                </button>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" id="btn_simpan" class="btn btn-primary">
                        <i class="ri-save-line me-1"></i>Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var templateRows = [];
var modalTemplate;

$(function () {
    modalTemplate = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalForm'));
    loadData();

    $('#btn_cari').on('click', renderList);
    $('#search').on('keyup', function (event) {
        if (event.key === 'Enter') renderList();
    });
    $('#filter_jenis,#filter_status_template').on('change', renderList);
    $('#btn_simpan').on('click', saveData);
    $('#preview').on('click', previewMessage);
    $('#default_template').on('change', function () {
        if ($(this).val() === 'Ya') $('#status_template').val('Aktif');
    });
});

function defaultMessage() {
    return 'Yth. Bapak/Ibu {nama_wali}, pembayaran {nama_siswa} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.';
}

function resetForm() {
    $('#form')[0].reset();
    $('#id').val('');
    $('#jenis').val('Bukti Pembayaran');
    $('#isi').val(defaultMessage());
    $('#default_template').val('Tidak');
    $('#status_template').val('Aktif');
    $('#previewBox').addClass('d-none').empty();
}

function loadData() {
    $.getJSON('<?= base_url('template_whatsapp/result') ?>', function (response) {
        templateRows = response || [];
        renderList();
    }).fail(ajaxError);
}

function renderList() {
    var search = String($('#search').val() || '').toLowerCase();
    var jenis = $('#filter_jenis').val();
    var status = $('#filter_status_template').val();
    var filtered = templateRows.filter(function (row) {
        var matchSearch = !search ||
            String(row.nama_template || '').toLowerCase().includes(search) ||
            String(row.isi_template || '').toLowerCase().includes(search);
        var matchType = !jenis || row.jenis_template === jenis;
        var matchStatus = !status || row.status === status;
        return matchSearch && matchType && matchStatus;
    });

    if (!filtered.length) {
        $('#list').html('<div class="empty-state">Belum ada template WhatsApp sesuai filter.</div>');
        return;
    }

    $('#list').html(filtered.map(function (row, index) {
        return '<div class="crud-list-item">' +
            '<div class="crud-content">' +
                '<div class="crud-status">Status: <span class="badge ' + (row.status === 'Aktif' ? 'bg-success' : 'bg-secondary') + '">' + escapeHtml(row.status) + '</span> ' +
                    (row.status_default === 'Ya' ? '<span class="badge bg-primary">Default</span>' : '') +
                '</div>' +
                '<div class="crud-title">' + (index + 1) + '. ' + escapeHtml(row.nama_template) + '</div>' +
                '<div class="crud-meta">Jenis: ' + escapeHtml(row.jenis_template) + '</div>' +
                '<div class="crud-note">' + escapeHtml(row.isi_template || '').substring(0, 180) + '</div>' +
            '</div>' +
            '<div class="crud-actions">' +
                '<button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="editTemplate(' + row.id + ')"><i class="ri-edit-line"></i></button>' +
                (row.status_default !== 'Ya' ? '<button type="button" class="btn btn-outline-primary btn-icon" title="Jadikan Default" onclick="setDefault(' + row.id + ')"><i class="ri-star-line"></i></button>' : '') +
            '</div>' +
        '</div>';
    }).join(''));
}

function openForm() {
    resetForm();
    $('#modal_title').text('Tambah Template WhatsApp');
    modalTemplate.show();
}

function editTemplate(id) {
    var row = templateRows.find(function (item) { return Number(item.id) === Number(id); });
    if (!row) return;

    resetForm();
    $('#modal_title').text('Edit Template WhatsApp');
    $('#id').val(row.id);
    $('#jenis').val(row.jenis_template);
    $('#nama').val(row.nama_template);
    $('#isi').val(row.isi_template);
    $('#default_template').val(row.status_default);
    $('#status_template').val(row.status);
    modalTemplate.show();
}

function saveData() {
    if (!$.trim($('#nama').val()) || !$.trim($('#isi').val())) {
        Swal.fire('Perhatian', 'Nama dan isi template wajib diisi.', 'warning');
        return;
    }

    if ($('#default_template').val() === 'Ya') $('#status_template').val('Aktif');
    var button = $('#btn_simpan').prop('disabled', true);

    $.post('<?= base_url('template_whatsapp/simpan') ?>', $('#form').serialize(), function (response) {
        var ok = response.result === 'true';
        if (ok) {
            modalTemplate.hide();
            loadData();
        }
        Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
    }, 'json').fail(ajaxError).always(function () {
        button.prop('disabled', false);
    });
}

function setDefault(id) {
    confirmAction('Jadikan template default?', 'Template default pada jenis yang sama akan diganti.', function () {
        $.post('<?= base_url('template_whatsapp/set_default') ?>', {id: id}, function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) loadData();
        }, 'json').fail(ajaxError);
    });
}

function previewMessage() {
    var text = $('#isi').val();
    var sample = {
        '{nama_wali}': 'Bapak/Ibu Contoh',
        '{nama_siswa}': 'ADISKA REYFANO',
        '{kelas}': 'KELAS 10',
        '{tanggal}': '04-08-2026',
        '{no_transaksi}': 'BYR/202608/00001',
        '{total_bayar}': 'Rp250.000',
        '{total_tunggakan}': 'Rp300.000',
        '{nama_sekolah}': 'Sekolah Contoh',
        '{nama_petugas}': 'Mariya'
    };
    Object.keys(sample).forEach(function (key) {
        text = String(text || '').split(key).join(sample[key]);
    });
    $('#previewBox').removeClass('d-none').text(text);
}
</script>
