<?php
$periodeOptions = array();
foreach ($kelas as $row) {
    $periodeOptions[(string) $row['id_periode']] = $row['periode'];
}
?>
<div class="card">
    <div class="card-header">
        <h4 class="header-title">Kenaikan Kelas</h4>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-12 col-xl-6">
                <div class="wf-section h-100">
                    <h5 class="wf-section-title">Kelas Asal</h5>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="periode_asal" class="form-label">Tahun Ajaran</label>
                            <select id="periode_asal" class="form-select">
                                <option value="">Pilih Tahun Ajaran</option>
                                <?php foreach ($periodeOptions as $id => $label): ?>
                                    <option value="<?= html_escape($id) ?>"><?= html_escape($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="semester_asal" class="form-label">Semester</label>
                            <select id="semester_asal" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="kelas_asal" class="form-label">Kelas</label>
                            <select id="kelas_asal" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row): ?>
                                    <option value="<?= (int) $row['id'] ?>" data-periode="<?= html_escape($row['id_periode']) ?>" data-semester="<?= html_escape($row['semester']) ?>">
                                        <?= html_escape($row['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-6">
                <div class="wf-section h-100">
                    <h5 class="wf-section-title">Kelas Tujuan</h5>
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label for="periode_tujuan" class="form-label">Tahun Ajaran</label>
                            <select id="periode_tujuan" class="form-select">
                                <option value="">Pilih Tahun Ajaran</option>
                                <?php foreach ($periodeOptions as $id => $label): ?>
                                    <option value="<?= html_escape($id) ?>"><?= html_escape($label) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="semester_tujuan" class="form-label">Semester</label>
                            <select id="semester_tujuan" class="form-select">
                                <option value="">Pilih</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="kelas_tujuan" class="form-label">Kelas</label>
                            <select id="kelas_tujuan" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row): ?>
                                    <option value="<?= (int) $row['id'] ?>" data-periode="<?= html_escape($row['id_periode']) ?>" data-semester="<?= html_escape($row['semester']) ?>">
                                        <?= html_escape($row['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <label for="alasan" class="form-label">Keterangan</label>
                <textarea id="alasan" class="form-control" rows="2" placeholder="Keterangan proses kenaikan kelas ..."></textarea>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title">Daftar Siswa Kelas Asal</h4>
            <small class="text-muted">Siswa yang tidak dicentang dianggap dikecualikan dari proses.</small>
        </div>
        <button type="button" class="btn btn-sm btn-light" id="btn_pilih_semua">Pilih Semua</button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="42"></th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Status Tujuan</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr><td colspan="4"><div class="empty-state">Pilih kelas asal untuk menampilkan siswa.</div></td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-transparent d-flex flex-wrap justify-content-end gap-2">
        <button type="button" class="btn btn-outline-primary" id="btn_preview">Preview Hasil</button>
        <button type="button" class="btn btn-primary" id="btn_proses">Proses Kenaikan Kelas</button>
    </div>
</div>

<script>
$(document).ready(function () {
    filterKelasKenaikan('asal');
    filterKelasKenaikan('tujuan');

    $('#periode_asal, #semester_asal').on('change', function () { filterKelasKenaikan('asal'); });
    $('#periode_tujuan, #semester_tujuan').on('change', function () { filterKelasKenaikan('tujuan'); });
    $('#kelas_asal').on('change', loadSiswaKenaikan);
    $('#btn_pilih_semua').on('click', function () { $('.pilih-siswa').prop('checked', true); });
    $('#btn_preview').on('click', previewKenaikan);
    $('#btn_proses').on('click', prosesKenaikan);
});

function filterKelasKenaikan(side) {
    var periode = String($('#periode_' + side).val() || '');
    var semester = String($('#semester_' + side).val() || '');
    var select = $('#kelas_' + side);

    select.find('option').each(function () {
        var p = String($(this).data('periode') || '');
        var s = String($(this).data('semester') || '');
        var visible = !p || (p === periode && s === semester);
        $(this).prop('hidden', !visible).prop('disabled', !visible);
    });
    select.val('');

    if (side === 'asal') {
        $('#data').html('<tr><td colspan="4"><div class="empty-state">Pilih kelas asal untuk menampilkan siswa.</div></td></tr>');
    }
}

function loadSiswaKenaikan() {
    var id = $('#kelas_asal').val();
    if (!id) return;
    $('#data').html('<tr><td colspan="4"><div class="empty-state">Memuat siswa...</div></td></tr>');
    $.post('<?= base_url('kenaikan_kelas/siswa') ?>', {id_kelas_setting: id}, function (rows) {
        if (!rows.length) {
            $('#data').html('<tr><td colspan="4"><div class="empty-state">Tidak ada siswa aktif pada kelas asal.</div></td></tr>');
            return;
        }
        var html = rows.map(function (row) {
            return '<tr>' +
                '<td><input type="checkbox" class="form-check-input pilih-siswa" value="' + row.id + '"></td>' +
                '<td>' + escapeHtml(row.nis || '-') + '</td>' +
                '<td><strong>' + escapeHtml(row.nama_lengkap) + '</strong><br><small class="text-muted">NISN ' + escapeHtml(row.nisn || '-') + '</small></td>' +
                '<td><span class="badge bg-primary-subtle text-primary">Naik Kelas</span></td>' +
            '</tr>';
        }).join('');
        $('#data').html(html);
    }, 'json').fail(ajaxError);
}

function dataKenaikan() {
    return {
        id_kelas_asal: $('#kelas_asal').val(),
        id_kelas_tujuan: $('#kelas_tujuan').val(),
        id_siswa: $('.pilih-siswa:checked').map(function () { return this.value; }).get(),
        alasan: $('#alasan').val()
    };
}

function validasiKenaikan(data) {
    if (!data.id_kelas_asal || !data.id_kelas_tujuan || !data.id_siswa.length) {
        Swal.fire('Perhatian', 'Pilih kelas asal, kelas tujuan, dan minimal satu siswa.', 'warning');
        return false;
    }
    return true;
}

function previewKenaikan() {
    var data = dataKenaikan();
    if (!validasiKenaikan(data)) return;
    $.post('<?= base_url('kenaikan_kelas/preview') ?>', data, function (response) {
        if (response.result !== 'true') {
            Swal.fire('Gagal', response.message, 'error');
            return;
        }
        Swal.fire({
            title: 'Preview Kenaikan Kelas',
            html: '<div class="text-start">' +
                '<p><strong>Asal:</strong> ' + escapeHtml(response.asal.nama_kelas) + '</p>' +
                '<p><strong>Tujuan:</strong> ' + escapeHtml(response.tujuan.nama_kelas) + '</p>' +
                '<p><strong>Dipilih:</strong> ' + response.dipilih + ' siswa</p>' +
                '<p><strong>Dapat diproses:</strong> ' + response.valid + ' siswa</p>' +
                '<p><strong>Dilewati:</strong> ' + response.dilewati + ' siswa</p>' +
                '<p class="mb-0 text-muted">Data kelas lama tidak akan dihapus.</p>' +
            '</div>',
            icon: 'info',
            confirmButtonText: 'Tutup'
        });
    }, 'json').fail(ajaxError);
}

function prosesKenaikan() {
    var data = dataKenaikan();
    if (!validasiKenaikan(data)) return;
    confirmAction('Proses kenaikan kelas?', data.id_siswa.length + ' siswa akan dibuatkan penempatan baru. Data kelas lama tidak dihapus.', function () {
        $('#btn_proses').prop('disabled', true);
        $.post('<?= base_url('kenaikan_kelas/proses') ?>', data, function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) loadSiswaKenaikan();
        }, 'json').fail(ajaxError).always(function () { $('#btn_proses').prop('disabled', false); });
    });
}
</script>
