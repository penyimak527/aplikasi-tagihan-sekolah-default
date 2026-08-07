<?php
$periodeOptions = array();
foreach ($kelas as $row) {
    $periodeOptions[(string) $row['id_periode']] = $row['periode'];
}
?>
<div class="card">
    <div class="card-header">
        <h4 class="header-title">Kelulusan</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-0">
            <div class="col-md-3">
                <label class="form-label" for="periode">Tahun Ajaran</label>
                <select id="periode" class="form-select">
                    <option value="">Pilih Tahun Ajaran</option>
                    <?php foreach ($periodeOptions as $id => $label): ?>
                        <option value="<?= html_escape($id) ?>"><?= html_escape($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="kelas">Kelas Akhir</label>
                <select id="kelas" class="form-select">
                    <option value="">Pilih Kelas Akhir</option>
                    <?php foreach ($kelas as $row): ?>
                        <option value="<?= (int) $row['id'] ?>" data-periode="<?= html_escape($row['id_periode']) ?>">
                            <?= html_escape($row['nama_kelas'] . ' - ' . $row['semester']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label" for="tanggal">Tanggal Lulus</label>
                <input id="tanggal" class="form-control tanggal" value="<?= date('d-m-Y') ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="tahun">Tahun Kelulusan</label>
                <input id="tahun" class="form-control" value="<?= date('Y') ?>">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" id="btn_tampilkan">Tampilkan</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title">Daftar Siswa Kelas Akhir</h4>
            <small class="text-muted">Tunggakan ditampilkan sebagai informasi dan tidak otomatis menghalangi kelulusan.</small>
        </div>
        <button type="button" class="btn btn-sm btn-light" id="btn_pilih_semua">Pilih Semua</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th width="42"></th><th>Siswa</th><th>Status Tagihan</th><th>Status Siswa</th></tr></thead>
                <tbody id="data"><tr><td colspan="4"><div class="empty-state">Pilih tahun ajaran dan kelas akhir.</div></td></tr></tbody>
            </table>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 p-3 pt-2">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-kelulusan"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-kelulusan" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-kelulusan">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>entri</span>
            </div>
        </div>
    </div>
    <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-outline-primary" id="btn_preview">Preview</button>
        <button type="button" class="btn btn-primary" id="btn_proses">Proses Kelulusan</button>
    </div>
</div>

<script>
$(document).ready(function () {
    flatpickr('.tanggal', {dateFormat: 'd-m-Y'});
    filterKelasKelulusan();
    $('#periode').on('change', filterKelasKelulusan);
    $('#btn_tampilkan').on('click', loadSiswaKelulusan);
    $('#btn_pilih_semua').on('click', function () { $('.pilih-siswa').prop('checked', true); });
    $('#btn_preview').on('click', previewKelulusan);
    $('#btn_proses').on('click', prosesKelulusan);
    $('#dt-length-kelulusan').on('change', refreshKelulusanPagination);
});

function filterKelasKelulusan() {
    var periode = String($('#periode').val() || '');
    $('#kelas option').each(function () {
        var p = String($(this).data('periode') || '');
        var visible = !p || p === periode;
        $(this).prop('hidden', !visible).prop('disabled', !visible);
    });
    $('#kelas').val('');
    $('#data').html('<tr><td colspan="4"><div class="empty-state">Pilih tahun ajaran dan kelas akhir.</div></td></tr>');
    refreshKelulusanPagination();
}

function loadSiswaKelulusan() {
    if (!$('#kelas').val()) {
        Swal.fire('Perhatian', 'Pilih kelas akhir terlebih dahulu.', 'warning');
        return;
    }
    $('#data').html('<tr><td colspan="4"><div class="empty-state">Memuat siswa...</div></td></tr>');
    $.post('<?= base_url('kelulusan/siswa') ?>', {id_kelas_setting: $('#kelas').val()}, function (rows) {
        if (!rows.length) {
            $('#data').html('<tr><td colspan="4"><div class="empty-state">Tidak ada siswa aktif pada kelas ini.</div></td></tr>');
            refreshKelulusanPagination();
            return;
        }
        $('#data').html(rows.map(function (row) {
            var tagihan = Number(row.tunggakan || 0) > 0
                ? '<span class="badge bg-danger-subtle text-danger">Masih ada tunggakan ' + formatRupiah(row.tunggakan) + '</span>'
                : '<span class="badge bg-success-subtle text-success">Lunas/Tidak Ada Tunggakan</span>';
            return '<tr class="siswa-kelulusan-row"><td><input type="checkbox" class="form-check-input pilih-siswa" value="' + row.id + '"></td><td><strong>' + escapeHtml(row.nama_lengkap) + '</strong><br><small class="text-muted">NIS ' + escapeHtml(row.nis || '-') + ' | NISN ' + escapeHtml(row.nisn || '-') + '</small></td><td>' + tagihan + '</td><td>' + escapeHtml(row.status_pendaftaran || '-') + '</td></tr>';
        }).join(''));
        refreshKelulusanPagination();
    }, 'json').fail(ajaxError);
}

function dataKelulusan() {
    return {
        id_kelas_setting: $('#kelas').val(),
        id_siswa: $('.pilih-siswa:checked').map(function () { return this.value; }).get(),
        tanggal_lulus: $('#tanggal').val(),
        tahun_kelulusan: $('#tahun').val()
    };
}

function validasiKelulusan(data) {
    if (!data.id_kelas_setting || !data.id_siswa.length || !data.tanggal_lulus || !data.tahun_kelulusan) {
        Swal.fire('Perhatian', 'Pilih siswa dan lengkapi tanggal serta tahun kelulusan.', 'warning');
        return false;
    }
    return true;
}

function previewKelulusan() {
    var data = dataKelulusan();
    if (!validasiKelulusan(data)) return;
    $.post('<?= base_url('kelulusan/preview') ?>', data, function (response) {
        if (response.result !== 'true') return Swal.fire('Gagal', response.message, 'error');
        Swal.fire({
            title: 'Preview Kelulusan',
            html: '<div class="text-start"><p><strong>Kelas akhir:</strong> ' + escapeHtml(response.kelas.nama_kelas) + '</p><p><strong>Jumlah siswa:</strong> ' + response.jumlah + '</p><p><strong>Masih memiliki tunggakan:</strong> ' + response.masih_tunggakan + '</p><p><strong>Lunas/tidak ada tunggakan:</strong> ' + response.lunas + '</p><p class="text-muted mb-0">Tunggakan tidak dihapus dan riwayat pembayaran tetap dapat dicari.</p></div>',
            icon: 'info',
            confirmButtonText: 'Tutup'
        });
    }, 'json').fail(ajaxError);
}

function prosesKelulusan() {
    var data = dataKelulusan();
    if (!validasiKelulusan(data)) return;
    confirmAction('Proses kelulusan ' + data.id_siswa.length + ' siswa?', 'Siswa tidak ikut tagihan baru. Tagihan dan pembayaran lama tetap tersimpan.', function () {
        $('#btn_proses').prop('disabled', true);
        $.post('<?= base_url('kelulusan/proses') ?>', data, function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) loadSiswaKelulusan();
        }, 'json').fail(ajaxError).always(function () { $('#btn_proses').prop('disabled', false); });
    });
}

function refreshKelulusanPagination() {
    paging($('#data .siswa-kelulusan-row'), parseInt($('#dt-length-kelulusan').val(), 10) || 10, '#pagination-kelulusan');
}

</script>
