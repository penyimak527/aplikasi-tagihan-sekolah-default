<div class="card">
    <div class="card-header app-card-header">
        <h4 class="header-title">Tarif Khusus Siswa</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-md-3">
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
            <div class="col-md-3">
                <label for="q_siswa" class="form-label">Nama/NIS/NISN</label>
                <input id="q_siswa" class="form-control" placeholder="Cari siswa penerima tagihan ...">
            </div>
            <div class="col-md-2">
                <label for="filter_kelas" class="form-label">Kelas</label>
                <select id="filter_kelas" class="form-select" disabled>
                    <option value="">Semua Kelas</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="filter_status_tarif" class="form-label">Status Tarif</label>
                <select id="filter_status_tarif" class="form-select">
                    <option value="Semua">Semua</option>
                    <option value="Normal">Normal</option>
                    <option value="Tarif Khusus">Tarif Khusus</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn_cari"><i class="ri-search-line me-1"></i>Cari</button>
            </div>
        </div>

        <div id="hasil_siswa" class="crud-list mt-4">
            <div class="empty-state">Pilih tagihan lalu cari siswa.</div>
        </div>

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
                    <input type="hidden" name="bulan" value="0">
                    <input type="hidden" name="tahun" value="0">

                    <div class="alert alert-info" id="identitas_siswa">Pilih siswa terlebih dahulu.</div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nominal Normal</label>
                            <input id="tarif_normal" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nominal Khusus</label>
                            <input name="nominal_khusus" type="text" inputmode="numeric" autocomplete="off" class="form-control money-input" required>
                        </div>
                        <div class="col-md-6">
                            <label for="berlaku_untuk" class="form-label">Berlaku Untuk</label>
                            <select id="berlaku_untuk" name="berlaku_untuk" class="form-select">
                                <option value="Tagihan">Tagihan ini</option>
                                <option value="Bulan">Bulan</option>
                            </select>
                        </div>
                        <div class="col-md-6 d-none" id="wrap_periode_berlaku">
                            <label for="periode_berlaku" class="form-label">Bulan Berlaku</label>
                            <select id="periode_berlaku" class="form-select">
                                <option value="">Pilih bulan</option>
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
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th class="text-end">Nominal Normal</th>
                                <th class="text-end">Nominal Khusus</th>
                                <th>Periode Berlaku</th>
                                <th>Alasan</th>
                                <th>Petugas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
var modalTarifKhusus = null;
var modalRiwayatTarif = null;
var infoTagihanTarif = null;
var siswaTarifAktif = null;

$(document).ready(function () {
    modalTarifKhusus = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTarifKhusus'));
    modalRiwayatTarif = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalRiwayatTarif'));

    $('#tagihan').on('change', function () {
        loadInfoTagihan();
        $('#hasil_siswa').html('<div class="empty-state">Gunakan filter lalu klik Cari.</div>');
        refreshCariTarifPagination();
    });
    $('#btn_cari').on('click', cariSiswa);
    $('#q_siswa').on('keyup', function (event) {
        if (event.key === 'Enter') cariSiswa();
    });
    $('#btn_simpan').on('click', simpanTarifKhusus);
    $('#berlaku_untuk').on('change', updateBerlakuUntuk);
    $('#periode_berlaku').on('change', updateNormalModal);
    $('#dt-length-cari-tarif').on('change', refreshCariTarifPagination);
    $('#dt-length-riwayat-tarif').on('change', refreshRiwayatTarifPagination);

    refreshCariTarifPagination();
    if ($('#tagihan').val()) loadInfoTagihan();
});

function loadInfoTagihan() {
    var id = $('#tagihan').val();
    infoTagihanTarif = null;
    $('#filter_kelas').prop('disabled', true).html('<option value="">Semua Kelas</option>');
    $('#periode_berlaku').html('<option value="">Pilih bulan</option>');

    if (!id) return;

    $.post('<?= base_url('admin/tagihan/tarif_khusus_siswa/result') ?>', {id_tagihan: id}, function (response) {
        if (response.result !== 'true') {
            Swal.fire('Gagal', response.message, 'error');
            return;
        }

        infoTagihanTarif = response;

        var kelasHtml = '<option value="">Semua Kelas</option>';
        (response.classes || []).forEach(function (row) {
            kelasHtml += '<option value="' + row.id_kelas_setting + '">' + escapeHtml(row.nama_kelas || '-') + '</option>';
        });
        $('#filter_kelas').html(kelasHtml).prop('disabled', false);

        var periodeHtml = '<option value="">Pilih bulan</option>';
        (response.periods || []).forEach(function (row) {
            periodeHtml += '<option value="' + row.bulan + '|' + row.tahun + '">' + escapeHtml(row.nama_bulan + ' ' + row.tahun) + '</option>';
        });
        $('#periode_berlaku').html(periodeHtml);
    }, 'json').fail(ajaxError);
}

function cariSiswa() {
    var id = $('#tagihan').val();
    if (!id) return Swal.fire('Perhatian', 'Pilih tagihan terlebih dahulu.', 'warning');

    $('#hasil_siswa').html('<div class="empty-state">Mencari siswa...</div>');

    $.post('<?= base_url('admin/tagihan/tarif_khusus_siswa/cari_siswa') ?>', {
        id_tagihan: id,
        q: $('#q_siswa').val(),
        id_kelas_setting: $('#filter_kelas').val(),
        status_tarif: $('#filter_status_tarif').val()
    }, function (rows) {
        if (!rows.length) {
            $('#hasil_siswa').html('<div class="empty-state tarif-cari-row">Siswa tidak ditemukan.</div>');
            refreshCariTarifPagination();
            return;
        }

        var html = rows.map(function (row) {
            var normalText = row.normal_bervariasi
                ? formatRupiah(row.nominal_normal_min || 0) + ' - ' + formatRupiah(row.nominal_normal_max || 0)
                : formatRupiah(row.nominal_normal || 0);

            var statusBadge = row.status_tarif === 'Tarif Khusus'
                ? '<span class="badge bg-success-subtle text-success">Tarif Khusus</span>'
                : '<span class="badge bg-secondary-subtle text-secondary">Normal</span>';

            var periode = row.status_tarif === 'Tarif Khusus'
                ? '<div class="crud-note">Periode berlaku: ' + escapeHtml(row.periode_berlaku || '-') + '</div>'
                : '';

            var actions = '<button type="button" class="btn btn-sm btn-outline-primary btn-atur" data-row="' + encodeURIComponent(JSON.stringify(row)) + '">Atur Tarif Khusus</button> ';
            if (row.status_tarif === 'Tarif Khusus') {
                actions += '<button type="button" class="btn btn-sm btn-outline-danger btn-normal" data-siswa="' + row.id_siswa + '">Kembalikan ke Tarif Normal</button> ';
            }
            actions += '<button type="button" class="btn btn-sm btn-outline-secondary btn-riwayat" data-siswa="' + row.id_siswa + '">Riwayat</button>';

            return '<div class="crud-list-item tarif-cari-row">' +
                '<div class="crud-content">' +
                    '<div class="crud-title">' + escapeHtml(row.nama_siswa || '-') + ' ' + statusBadge + '</div>' +
                    '<div class="crud-meta">NIS: ' + escapeHtml(row.nis || '-') + ' | NISN: ' + escapeHtml(row.nisn || '-') + ' | Kelas: ' + escapeHtml(row.nama_kelas || '-') + '</div>' +
                    '<div class="crud-note">Tarif Normal: ' + normalText + ' | Tarif Akhir: <strong>' + formatRupiah(row.nominal_akhir || 0) + '</strong></div>' +
                    periode +
                '</div>' +
                '<div class="crud-actions">' + actions + '</div>' +
            '</div>';
        }).join('');

        $('#hasil_siswa').html(html);
        refreshCariTarifPagination();
    }, 'json').fail(ajaxError);
}

$(document).on('click', '.btn-atur', function () {
    var row = JSON.parse(decodeURIComponent($(this).attr('data-row')));
    siswaTarifAktif = row;

    $('#form_siswa')[0].reset();
    $('#form_siswa [name="id_tagihan"]').val($('#tagihan').val());
    $('#form_siswa [name="id_siswa"]').val(row.id_siswa);
    $('#form_siswa [name="bulan"]').val(0);
    $('#form_siswa [name="tahun"]').val(0);
    $('#form_siswa [name="nominal_khusus"]').val(formatMoneyInput(row.nominal_khusus || row.nominal_normal || 0));
    $('#form_siswa [name="alasan"]').val(row.alasan_aktif || '');

    var tipe = infoTagihanTarif && infoTagihanTarif.master ? infoTagihanTarif.master.tipe_tagihan : '';
    var bolehBulan = tipe === 'Bulanan';
    $('#berlaku_untuk option[value="Bulan"]').prop('disabled', !bolehBulan);

    if (bolehBulan && row.status_tarif === 'Tarif Khusus' && row.berlaku_untuk_aktif === 'Bulan') {
        $('#berlaku_untuk').val('Bulan');
        $('#periode_berlaku').val(String(row.bulan_khusus) + '|' + String(row.tahun_khusus));
    } else {
        $('#berlaku_untuk').val('Tagihan');
        $('#periode_berlaku').val('');
    }

    $('#identitas_siswa').html(
        '<strong>' + escapeHtml(row.nama_siswa || '-') + '</strong><br>' +
        escapeHtml(row.nis || '-') + ' | ' + escapeHtml(row.nama_kelas || '-') +
        ' | Sudah dibayar ' + formatRupiah(row.nominal_dibayar || 0)
    );

    updateBerlakuUntuk();
    modalTarifKhusus.show();
});

function updateBerlakuUntuk() {
    var scope = $('#berlaku_untuk').val();
    if (scope === 'Bulan') {
        $('#wrap_periode_berlaku').removeClass('d-none');
    } else {
        $('#wrap_periode_berlaku').addClass('d-none');
        $('#periode_berlaku').val('');
        $('#form_siswa [name="bulan"]').val(0);
        $('#form_siswa [name="tahun"]').val(0);
    }
    updateNormalModal();
}

function updateNormalModal() {
    if (!siswaTarifAktif) return;

    var scope = $('#berlaku_untuk').val();
    if (scope !== 'Bulan') {
        var normalText = siswaTarifAktif.normal_bervariasi
            ? formatRupiah(siswaTarifAktif.nominal_normal_min || 0) + ' - ' + formatRupiah(siswaTarifAktif.nominal_normal_max || 0)
            : formatRupiah(siswaTarifAktif.nominal_normal || 0);
        $('#tarif_normal').val(normalText);
        return;
    }

    var value = $('#periode_berlaku').val();
    if (!value) {
        $('#tarif_normal').val('Pilih bulan berlaku');
        $('#form_siswa [name="bulan"]').val(0);
        $('#form_siswa [name="tahun"]').val(0);
        return;
    }

    var parts = value.split('|');
    var bulan = parseInt(parts[0], 10) || 0;
    var tahun = parseInt(parts[1], 10) || 0;
    $('#form_siswa [name="bulan"]').val(bulan);
    $('#form_siswa [name="tahun"]').val(tahun);

    var periode = (siswaTarifAktif.periode_rows || []).find(function (row) {
        return Number(row.bulan) === bulan && Number(row.tahun) === tahun;
    });
    $('#tarif_normal').val(periode ? formatRupiah(periode.nominal_normal || 0) : '-');

    if (periode && periode.tarif_khusus_aktif) {
        $('#form_siswa [name="nominal_khusus"]').val(formatMoneyInput(periode.nominal_khusus || 0));
    }
}

function simpanTarifKhusus() {
    if (!$('#form_siswa [name="id_siswa"]').val()) return;
    if ($('#berlaku_untuk').val() === 'Bulan' && !$('#periode_berlaku').val()) {
        return Swal.fire('Perhatian', 'Pilih bulan berlaku tarif khusus.', 'warning');
    }

    var button = $('#btn_simpan').prop('disabled', true);
    $.post('<?= base_url('admin/tagihan/tarif_khusus_siswa/simpan') ?>', serializeMoneyForm('#form_siswa'), function (response) {
        var ok = response.result === 'true';
        Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
        if (ok) {
            modalTarifKhusus.hide();
            cariSiswa();
        }
    }, 'json').fail(ajaxError).always(function () {
        button.prop('disabled', false);
    });
}

$(document).on('click', '.btn-normal', function () {
    var idSiswa = $(this).data('siswa');
    confirmAction('Kembalikan ke tarif normal?', 'Semua tarif khusus aktif siswa pada tagihan ini akan dibatalkan. Pembayaran yang sudah masuk tetap dipertahankan.', function () {
        $.post('<?= base_url('admin/tagihan/tarif_khusus_siswa/kembalikan_normal') ?>', {
            id_tagihan: $('#tagihan').val(),
            id_siswa: idSiswa,
            alasan: 'Dikembalikan ke tarif normal'
        }, function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) cariSiswa();
        }, 'json').fail(ajaxError);
    });
});

$(document).on('click', '.btn-riwayat', function () {
    $.post('<?= base_url('admin/tagihan/tarif_khusus_siswa/riwayat') ?>', {
        id_tagihan: $('#tagihan').val(),
        id_siswa: $(this).data('siswa')
    }, function (rows) {
        var html = rows.length ? rows.map(function (row) {
            var berlaku = Number(row.bulan || 0) > 0
                ? escapeHtml(namaBulanTarif(row.bulan) + ' ' + row.tahun)
                : 'Tagihan ini';

            return '<tr class="riwayat-tarif-row">' +
                '<td>' + escapeHtml((row.tanggal || '-') + ' ' + (row.waktu || '')) + '</td>' +
                '<td class="text-end">' + formatRupiah(row.nominal_awal || 0) + '</td>' +
                '<td class="text-end">' + formatRupiah(row.nominal_setelah_keringanan || 0) + '</td>' +
                '<td>' + berlaku + '</td>' +
                '<td>' + escapeHtml(row.alasan || '-') + '</td>' +
                '<td>' + escapeHtml(row.nama_user || '-') + '</td>' +
                '<td><span class="badge bg-' + (row.status === 'Aktif' ? 'success' : 'secondary') + '">' + escapeHtml(row.status || '-') + '</span></td>' +
            '</tr>';
        }).join('') : '<tr class="riwayat-tarif-row"><td colspan="7"><div class="empty-state">Belum ada riwayat.</div></td></tr>';

        $('#riwayat_rows').html(html);
        refreshRiwayatTarifPagination();
        modalRiwayatTarif.show();
    }, 'json').fail(ajaxError);
});

function namaBulanTarif(bulan) {
    var bulanList = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    return bulanList[parseInt(bulan, 10) || 0] || '-';
}

function refreshCariTarifPagination() {
    paging($('#hasil_siswa .tarif-cari-row'), parseInt($('#dt-length-cari-tarif').val(), 10) || 10, '#pagination-cari-tarif');
}

function refreshRiwayatTarifPagination() {
    paging($('#riwayat_rows .riwayat-tarif-row'), parseInt($('#dt-length-riwayat-tarif').val(), 10) || 10, '#pagination-riwayat-tarif');
}
</script>
