<div class="card">
    <div class="card-header app-card-header">
        <h4 class="header-title">Tarif Khusus Siswa</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-md-6">
                <label for="tagihan" class="form-label">Tagihan</label>
                <select id="tagihan" class="form-select">
                    <option value="">Pilih tagihan</option>
                    <?php foreach ($tagihan as $row): ?>
                        <option value="<?= (int) $row['id'] ?>" <?= (int) $id_tagihan === (int) $row['id'] ? 'selected' : '' ?>>
                            <?= html_escape($row['periode'] . ' - ' . $row['nama_tagihan'] . ' [' . $row['status'] . ']') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label for="q_siswa" class="form-label">Nama/NIS/NISN</label>
                <input id="q_siswa" class="form-control" placeholder="Cari siswa penerima tagihan ...">
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn_cari"><i class="ri-search-line me-1"></i>Cari</button>
            </div>
        </div>
        <div id="hasil_siswa" class="crud-list mt-4"></div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-cari-tarif"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-cari-tarif" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-cari-tarif">
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

<div class="card d-none" id="card_aktif">
    <div class="card-header">
        <h4 class="header-title">Tarif Khusus Aktif</h4>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th class="text-end">Tarif Normal</th>
                        <th class="text-end">Tarif Akhir</th>
                        <th>Alasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="special_rows"></tbody>
            </table>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 px-3 pb-3 pt-2">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-tarif-aktif"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-tarif-aktif" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-tarif-aktif">
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

<div class="modal fade" id="modalTarifKhusus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atur Tarif Khusus Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form_siswa">
                    <input type="hidden" name="id_tagihan">
                    <input type="hidden" name="id_siswa">
                    <div class="alert alert-info" id="identitas_siswa">Pilih siswa terlebih dahulu.</div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nominal Normal</label>
                            <input id="tarif_normal" class="form-control money-input" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nominal Khusus</label>
                            <input name="nominal_khusus" type="text" inputmode="numeric" autocomplete="off" class="form-control money-input" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Berlaku Untuk</label>
                            <select class="form-select" disabled>
                                <option>Tagihan ini</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alasan</label>
                            <textarea name="alasan" class="form-control" rows="3" required></textarea>
                        </div>
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

<div class="modal fade" id="modalRiwayatTarif" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Riwayat Tarif Khusus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead><tr><th>Tanggal</th><th>Nominal Awal</th><th>Nominal Khusus</th><th>Alasan</th><th>Petugas</th><th>Status</th></tr></thead>
                        <tbody id="riwayat_rows"></tbody>
                    </table>
                </div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-riwayat-tarif"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-riwayat-tarif" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-riwayat-tarif">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>entri</span>
            </div>
        </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button></div>
        </div>
    </div>
</div>

<script>
var modalTarifKhusus = null;
var modalRiwayatTarif = null;
var tarifRows = [];

$(document).ready(function () {
    modalTarifKhusus = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTarifKhusus'));
    modalRiwayatTarif = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalRiwayatTarif'));
    // $('#tagihan').on('change', loadTarifAktif);
    $('#btn_cari').on('click', cariSiswa);
    $('#q_siswa').on('keyup', function (event) { if (event.key === 'Enter') cariSiswa(); });
    $('#btn_simpan').on('click', simpanTarifKhusus);
    $('#dt-length-cari-tarif').on('change', refreshCariTarifPagination);
    $('#dt-length-tarif-aktif').on('change', refreshTarifAktifPagination);
    $('#dt-length-riwayat-tarif').on('change', refreshRiwayatTarifPagination);
    refreshCariTarifPagination();
    if ($('#tagihan').val()) loadTarifAktif();
});

function cariSiswa() {
    var id = $('#tagihan').val();
    if (!id) return Swal.fire('Perhatian', 'Pilih tagihan terlebih dahulu.', 'warning');
    $('#hasil_siswa').html('<div class="empty-state">Mencari siswa...</div>');
    $.post('<?= base_url('tagihan/tarif_khusus_siswa/cari_siswa') ?>', {id_tagihan: id, q: $('#q_siswa').val()}, function (rows) {
        if (!rows.length) {
            $('#hasil_siswa').html('<div class="empty-state">Siswa tidak ditemukan.</div>');
            refreshCariTarifPagination();
            return;
        }
        var html = rows.map(function (row) {
            return '<div class="crud-list-item tarif-cari-row">' +
                '<div class="crud-content"><div class="crud-title">' + escapeHtml(row.nama_siswa) + '</div>' +
                '<div class="crud-meta">NIS: ' + escapeHtml(row.nis || '-') + ' | NISN: ' + escapeHtml(row.nisn || '-') + ' | Kelas: ' + escapeHtml(row.nama_kelas || '-') + '</div>' +
                '<div class="crud-note">Tarif normal: ' + formatRupiah(row.nominal_normal || 0) + ' | Sudah dibayar: ' + formatRupiah(row.nominal_dibayar || 0) + '</div></div>' +
                '<div class="crud-actions"><button type="button" class="btn btn-outline-primary btn-atur" data-row="' + encodeURIComponent(JSON.stringify(row)) + '">Atur Tarif Khusus</button></div>' +
            '</div>';
        }).join('');
        $('#hasil_siswa').html(html);
        refreshCariTarifPagination();
    }, 'json').fail(ajaxError);
}

$(document).on('click', '.btn-atur', function () {
    var row = JSON.parse(decodeURIComponent($(this).attr('data-row')));
    $('#form_siswa')[0].reset();
    $('#form_siswa [name="id_tagihan"]').val($('#tagihan').val());
    $('#form_siswa [name="id_siswa"]').val(row.id_siswa);
    $('#form_siswa [name="nominal_khusus"]').val(formatMoneyInput(row.nominal_normal || 0));
    $('#tarif_normal').val(formatRupiah(row.nominal_normal || 0));
    $('#identitas_siswa').html('<strong>' + escapeHtml(row.nama_siswa) + '</strong><br>' + escapeHtml(row.nis || '-') + ' | ' + escapeHtml(row.nama_kelas || '-') + ' | Dibayar ' + formatRupiah(row.nominal_dibayar || 0));
    modalTarifKhusus.show();
});

function simpanTarifKhusus() {
    if (!$('#form_siswa [name="id_siswa"]').val()) return;
    var button = $('#btn_simpan').prop('disabled', true);
    $.post('<?= base_url('tagihan/tarif_khusus_siswa/simpan') ?>', serializeMoneyForm('#form_siswa'), function (response) {
        var ok = response.result === 'true';
        Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
        if (ok) {
            modalTarifKhusus.hide();
            loadTarifAktif();
            cariSiswa();
        }
    }, 'json').fail(ajaxError).always(function () { button.prop('disabled', false); });
}

function loadTarifAktif() {
    var id = $('#tagihan').val();
    $('#hasil_siswa').empty();
    if (!id) {
        $('#card_aktif').addClass('d-none');
        return;
    }
    $.post('<?= base_url('tagihan/tarif_khusus_siswa/result') ?>', {id_tagihan: id}, function (response) {
        if (response.result !== 'true') return;
        tarifRows = response.special || [];
        $('#card_aktif').removeClass('d-none');
        if (!tarifRows.length) {
            $('#special_rows').html('<tr><td colspan="6"><div class="empty-state">Belum ada tarif khusus siswa.</div></td></tr>');
            refreshTarifAktifPagination();
            return;
        }
        var html = tarifRows.map(function (row) {
            return '<tr class="tarif-aktif-row">' +
                '<td><strong>' + escapeHtml(row.nama_siswa || '-') + '</strong><br><small class="text-muted">' + escapeHtml(row.nis || '-') + '</small></td>' +
                '<td>' + escapeHtml(row.nama_kelas || '-') + '</td>' +
                '<td class="text-end">' + formatRupiah(row.nominal_awal || 0) + '</td>' +
                '<td class="text-end fw-semibold">' + formatRupiah(row.nominal_setelah_keringanan || 0) + '</td>' +
                '<td>' + escapeHtml(row.alasan || '-') + '</td>' +
                '<td class="table-actions"><button class="btn btn-sm btn-outline-primary btn-riwayat" data-siswa="' + row.id_siswa + '">Riwayat</button> <button class="btn btn-sm btn-outline-danger btn-normal" data-siswa="' + row.id_siswa + '">Kembalikan Normal</button></td>' +
            '</tr>';
        }).join('');
        $('#special_rows').html(html);
        refreshTarifAktifPagination();
    }, 'json').fail(ajaxError);
}

$(document).on('click', '.btn-normal', function () {
    var idSiswa = $(this).data('siswa');
    confirmAction('Kembalikan ke tarif normal?', 'Tarif khusus aktif akan dibatalkan. Pembayaran yang sudah masuk tetap dipertahankan.', function () {
        $.post('<?= base_url('tagihan/tarif_khusus_siswa/kembalikan_normal') ?>', {id_tagihan: $('#tagihan').val(), id_siswa: idSiswa, alasan: 'Dikembalikan ke tarif normal'}, function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) loadTarifAktif();
        }, 'json').fail(ajaxError);
    });
});

$(document).on('click', '.btn-riwayat', function () {
    $.post('<?= base_url('tagihan/tarif_khusus_siswa/riwayat') ?>', {id_tagihan: $('#tagihan').val(), id_siswa: $(this).data('siswa')}, function (rows) {
        var html = rows.length ? rows.map(function (row) {
            return '<tr class="riwayat-tarif-row"><td>' + escapeHtml((row.tanggal || '-') + ' ' + (row.waktu || '')) + '</td><td class="text-end">' + formatRupiah(row.nominal_awal || 0) + '</td><td class="text-end">' + formatRupiah(row.nominal_setelah_keringanan || 0) + '</td><td>' + escapeHtml(row.alasan || '-') + '</td><td>' + escapeHtml(row.nama_user || '-') + '</td><td><span class="badge bg-' + (row.status === 'Aktif' ? 'success' : 'secondary') + '">' + escapeHtml(row.status) + '</span></td></tr>';
        }).join('') : '<tr><td colspan="6"><div class="empty-state">Belum ada riwayat.</div></td></tr>';
        $('#riwayat_rows').html(html);
        refreshRiwayatTarifPagination();
        modalRiwayatTarif.show();
    }, 'json').fail(ajaxError);
});

function refreshCariTarifPagination() {
    paging($('#hasil_siswa .tarif-cari-row'), parseInt($('#dt-length-cari-tarif').val(), 10) || 10, '#pagination-cari-tarif');
}

function refreshTarifAktifPagination() {
    paging($('#special_rows .tarif-aktif-row'), parseInt($('#dt-length-tarif-aktif').val(), 10) || 10, '#pagination-tarif-aktif');
}

function refreshRiwayatTarifPagination() {
    paging($('#riwayat_rows .riwayat-tarif-row'), parseInt($('#dt-length-riwayat-tarif').val(), 10) || 10, '#pagination-riwayat-tarif');
}

</script>
