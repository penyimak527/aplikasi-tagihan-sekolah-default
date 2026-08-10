<?php
$periodeOptions = array();
foreach ($kelas as $row) {
    $periodeOptions[(string) $row['id_periode']] = $row['periode'];
}
?>
<div class="card">
    <div class="card-header">
        <h4 class="header-title">Tinggal Kelas</h4>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-xl-6">
                <div class="wf-section h-100">
                    <h5 class="wf-section-title">Kelas Asal</h5>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Tahun Ajaran</label>
                            <select id="periode_asal" class="form-select">
                                <option value="">Pilih Tahun Ajaran</option>
                                <?php foreach ($periodeOptions as $id => $label): ?>
                                    <option value="<?= html_escape($id) ?>"><?= html_escape($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Semester</label>
                            <select id="semester_asal" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kelas</label>
                            <select id="kelas_asal" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row): ?>
                                    <option value="<?= (int) $row['id'] ?>" data-periode="<?= html_escape($row['id_periode']) ?>" data-semester="<?= html_escape($row['semester']) ?>"><?= html_escape($row['nama_kelas']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="wf-section h-100">
                    <h5 class="wf-section-title">Penempatan Tujuan</h5>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label">Tahun Ajaran Tujuan</label>
                            <select id="periode_tujuan" class="form-select">
                                <option value="">Pilih Tahun Ajaran</option>
                                <?php foreach ($periodeOptions as $id => $label): ?>
                                    <option value="<?= html_escape($id) ?>"><?= html_escape($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Semester</label>
                            <select id="semester_tujuan" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kelas Penempatan</label>
                            <select id="kelas_tujuan" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row): ?>
                                    <option value="<?= (int) $row['id'] ?>" data-periode="<?= html_escape($row['id_periode']) ?>" data-semester="<?= html_escape($row['semester']) ?>"><?= html_escape($row['nama_kelas']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <label for="alasan" class="form-label">Keterangan</label>
                <textarea id="alasan" class="form-control" rows="2" placeholder="Keterangan siswa tinggal kelas ..."></textarea>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title">Pilih Siswa yang Tinggal Kelas</h4>
            <small class="text-muted">Siswa akan dibuatkan penempatan baru pada kelas tujuan.</small>
        </div>
        <button type="button" class="btn btn-sm btn-light" id="btn_pilih_semua">Pilih Semua</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th width="42"></th><th>NIS</th><th>Siswa</th><th>Kelas Asal</th></tr></thead>
                <tbody id="data"><tr><td colspan="4"><div class="empty-state">Pilih kelas asal.</div></td></tr></tbody>
            </table>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 p-3 pt-2">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-tinggal-kelas"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-tinggal-kelas" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-tinggal-kelas">
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
        <button type="button" class="btn btn-outline-primary" id="btn_preview">Preview Hasil</button>
        <button type="button" class="btn btn-primary" id="btn_proses">Proses Tinggal Kelas</button>
    </div>
</div>

<script>
$(document).ready(function () {
    filterKelasTinggal('asal');
    filterKelasTinggal('tujuan');
    $('#periode_asal,#semester_asal').on('change', function () { filterKelasTinggal('asal'); });
    $('#periode_tujuan,#semester_tujuan').on('change', function () { filterKelasTinggal('tujuan'); });
    $('#kelas_asal').on('change', loadSiswaTinggal);
    $('#btn_pilih_semua').on('click', function () { $('.pilih-siswa').prop('checked', true); });
    $('#btn_preview').on('click', previewTinggal);
    $('#btn_proses').on('click', prosesTinggal);
    $('#dt-length-tinggal-kelas').on('change', refreshTinggalPagination);
});

function filterKelasTinggal(side) {
    var periode = String($('#periode_' + side).val() || '');
    var semester = String($('#semester_' + side).val() || '');
    $('#kelas_' + side + ' option').each(function () {
        var p = String($(this).data('periode') || '');
        var s = String($(this).data('semester') || '');
        var visible = !p || (p === periode && s === semester);
        $(this).prop('hidden', !visible).prop('disabled', !visible);
    });
    $('#kelas_' + side).val('');
    if (side === 'asal') {
        $('#data').html('<tr><td colspan="4"><div class="empty-state">Pilih kelas asal.</div></td></tr>');
        refreshTinggalPagination();
    }
}

function loadSiswaTinggal() {
    var id = $('#kelas_asal').val();
    if (!id) return;
    $('#data').html('<tr><td colspan="4"><div class="empty-state">Memuat siswa...</div></td></tr>');
    $.post('<?= base_url('admin/kesiswaan/tinggal_kelas/siswa') ?>', {id_kelas_setting: id}, function (rows) {
        if (!rows.length) {
            $('#data').html('<tr><td colspan="4"><div class="empty-state">Tidak ada siswa aktif.</div></td></tr>');
            refreshTinggalPagination();
            return;
        }
        var kelasAsal = $('#kelas_asal option:selected').text().trim();
        $('#data').html(rows.map(function (row) {
            return '<tr class="siswa-tinggal-row"><td><input type="checkbox" class="form-check-input pilih-siswa" value="' + row.id + '"></td><td>' + escapeHtml(row.nis || '-') + '</td><td><strong>' + escapeHtml(row.nama_lengkap) + '</strong><br><small class="text-muted">NISN ' + escapeHtml(row.nisn || '-') + '</small></td><td>' + escapeHtml(kelasAsal) + '</td></tr>';
        }).join(''));
        refreshTinggalPagination();
    }, 'json').fail(ajaxError);
}

function dataTinggal() {
    return {
        id_kelas_asal: $('#kelas_asal').val(),
        id_kelas_tujuan: $('#kelas_tujuan').val(),
        id_siswa: $('.pilih-siswa:checked').map(function () { return this.value; }).get(),
        alasan: $('#alasan').val()
    };
}

function validasiTinggal(data) {
    if (!data.id_kelas_asal || !data.id_kelas_tujuan || !data.id_siswa.length) {
        Swal.fire('Perhatian', 'Pilih kelas asal, kelas tujuan, dan siswa.', 'warning');
        return false;
    }
    return true;
}

function previewTinggal() {
    var data = dataTinggal();
    if (!validasiTinggal(data)) return;
    $.post('<?= base_url('admin/kesiswaan/tinggal_kelas/preview') ?>', data, function (response) {
        if (response.result !== 'true') return Swal.fire('Gagal', response.message, 'error');
        Swal.fire({
            title: 'Preview Tinggal Kelas',
            html: '<div class="text-start"><p><strong>Kelas asal:</strong> ' + escapeHtml(response.asal.nama_kelas) + '</p><p><strong>Kelas tujuan:</strong> ' + escapeHtml(response.tujuan.nama_kelas) + '</p><p><strong>Dipilih:</strong> ' + response.dipilih + ' siswa</p><p><strong>Dapat diproses:</strong> ' + response.valid + ' siswa</p><p><strong>Dilewati:</strong> ' + response.dilewati + ' siswa</p><p class="text-muted mb-0">Data kelas lama tidak dihapus.</p></div>',
            icon: 'info',
            confirmButtonText: 'Tutup'
        });
    }, 'json').fail(ajaxError);
}

function prosesTinggal() {
    var data = dataTinggal();
    if (!validasiTinggal(data)) return;
    confirmAction('Proses tinggal kelas?', data.id_siswa.length + ' siswa akan dibuatkan penempatan baru. Data kelas lama tidak dihapus.', function () {
        $('#btn_proses').prop('disabled', true);
        $.post('<?= base_url('admin/kesiswaan/tinggal_kelas/proses') ?>', data, function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) loadSiswaTinggal();
        }, 'json').fail(ajaxError).always(function () { $('#btn_proses').prop('disabled', false); });
    });
}

function refreshTinggalPagination() {
    paging($('#data .siswa-tinggal-row'), parseInt($('#dt-length-tinggal-kelas').val(), 10) || 10, '#pagination-tinggal-kelas');
}

</script>
