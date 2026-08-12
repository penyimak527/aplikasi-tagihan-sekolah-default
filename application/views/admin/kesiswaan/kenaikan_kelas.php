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
                        <div class="col-md-4">
                            <label for="kelas_asal" class="form-label">Kelas</label>
                            <select id="kelas_asal" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row): ?>
                                    <option value="<?= (int) $row['id'] ?>" data-periode="<?= html_escape($row['id_periode']) ?>" >
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
                        <div class="col-md-4">
                            <label for="kelas_tujuan" class="form-label">Kelas</label>
                            <select id="kelas_tujuan" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <?php foreach ($kelas as $row): ?>
                                    <option value="<?= (int) $row['id'] ?>" data-periode="<?= html_escape($row['id_periode']) ?>" >
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
    <div class="card-footer bg-transparent d-flex justify-content-end">
        <button type="button" class="btn btn-primary" id="btn_terapkan">Terapkan</button>
    </div>
</div>

<div class="card" id="card_siswa_asal" style="display: none;">
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
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 p-3 pt-2">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-kelas-asal"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-kelas-asal" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-kelas-asal">
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>entri</span>
            </div>
        </div>
    </div>
    <div class="card-footer bg-transparent d-flex flex-wrap justify-content-end gap-2">
        <button type="button" class="btn btn-outline-primary" id="btn_preview">Preview Hasil</button>
        <button type="button" class="btn btn-primary" id="btn_proses">Proses Kenaikan Kelas</button>
    </div>
</div>

<script>
var kenaikanDiterapkan = false;
var filterKenaikanAktif = null;

$(document).ready(function () {
    filterKelasKenaikan('asal');
    filterKelasKenaikan('tujuan');

    $('#periode_asal').on('change', function () {
        filterKelasKenaikan('asal');
        resetTerapkanKenaikan();
    });
    $('#periode_tujuan').on('change', function () {
        filterKelasKenaikan('tujuan');
        resetTerapkanKenaikan();
    });
    $('#kelas_asal, #kelas_tujuan').on('change', resetTerapkanKenaikan);
    $('#btn_terapkan').on('click', terapkanKenaikan);
    $('#btn_pilih_semua').on('click', function () {
        $('.pilih-siswa:not(:disabled)').prop('checked', true);
    });
    $('#btn_preview').on('click', previewKenaikan);
    $('#btn_proses').on('click', prosesKenaikan);
    $('#dt-length-kelas-asal').on('change', refreshKelasAsalPagination);
});

function filterKelasKenaikan(side) {
    var periode = String($('#periode_' + side).val() || '');
    var select = $('#kelas_' + side);

    select.find('option').each(function () {
        var p = String($(this).data('periode') || '');
        var visible = !p || p === periode;
        $(this).prop('hidden', !visible).prop('disabled', !visible);
    });
    select.val('');

    if (side === 'asal') {
        $('#data').html('<tr><td colspan="4"><div class="empty-state">Pilih kelas asal dan kelas tujuan, lalu klik Terapkan.</div></td></tr>');
        refreshKelasAsalPagination();
    }
}

function resetTerapkanKenaikan() {
    kenaikanDiterapkan = false;
    filterKenaikanAktif = null;
    $('#card_siswa_asal').hide();
    $('#data').html('<tr><td colspan="4"><div class="empty-state">Pilih kelas asal dan kelas tujuan, lalu klik Terapkan.</div></td></tr>');
    refreshKelasAsalPagination();
}

function terapkanKenaikan() {
    var periodeAsal = $('#periode_asal').val();
    var kelasAsal = $('#kelas_asal').val();
    var periodeTujuan = $('#periode_tujuan').val();
    var kelasTujuan = $('#kelas_tujuan').val();

    if (!periodeAsal || !kelasAsal || !periodeTujuan || !kelasTujuan) {
        Swal.fire('Perhatian', 'Pilih tahun ajaran dan kelas asal serta tujuan terlebih dahulu.', 'warning');
        return;
    }

    if (String(periodeAsal) === String(periodeTujuan)) {
        Swal.fire('Perhatian', 'Tahun ajaran tujuan harus berbeda dari tahun ajaran asal.', 'warning');
        return;
    }

    kenaikanDiterapkan = true;
    filterKenaikanAktif = {
        periode_asal: String(periodeAsal),
        kelas_asal: String(kelasAsal),
        periode_tujuan: String(periodeTujuan),
        kelas_tujuan: String(kelasTujuan)
    };

    $('#card_siswa_asal').show();
    loadSiswaKenaikan();
}

function loadSiswaKenaikan() {
    var id = $('#kelas_asal').val();
    var idTujuan = $('#kelas_tujuan').val();

    if (!id || !idTujuan || !kenaikanDiterapkan) {
        resetTerapkanKenaikan();
        return;
    }

    $('#data').html('<tr><td colspan="4"><div class="empty-state">Memuat siswa...</div></td></tr>');

    $.ajax({
        url: '<?= base_url('admin/kesiswaan/kenaikan_kelas/siswa'); ?>',
        type: 'POST',
        data: {
            id_kelas_setting: id,
            id_kelas_tujuan: idTujuan
        },
        dataType: 'JSON',
        success: function (rows) {
            if (!rows.length) {
                $('#data').html('<tr><td colspan="4"><div class="empty-state">Tidak ada siswa aktif pada kelas asal.</div></td></tr>');
                refreshKelasAsalPagination();
                return;
            }

            var html = rows.map(function (row) {
                var sudahTujuan = Number(row.sudah_tujuan || 0) === 1;
                var checkbox = '<input type="checkbox" class="form-check-input pilih-siswa" value="' + row.id + '"' +
                    (sudahTujuan ? ' disabled' : '') + '>';

                var status = '<span class="badge bg-primary-subtle text-primary">Naik Kelas</span>';

                if (sudahTujuan) {
                    status =
                        '<span class="badge bg-secondary-subtle text-secondary">Sudah ditempatkan</span>' +
                        '<small class="text-muted d-block mt-1">' +
                            escapeHtml(row.kelas_tujuan_existing || '-') +
                            ' | ' +
                            escapeHtml(row.periode_tujuan_existing || '-') +
                        '</small>';
                }

                return '<tr class="siswa-kelas-asal-row' + (sudahTujuan ? ' table-light' : '') + '">' +
                    '<td>' + checkbox + '</td>' +
                    '<td>' + escapeHtml(row.nis || '-') + '</td>' +
                    '<td><strong>' + escapeHtml(row.nama_lengkap) + '</strong><br><small class="text-muted">NISN ' + escapeHtml(row.nisn || '-') + '</small></td>' +
                    '<td>' + status + '</td>' +
                '</tr>';
            }).join('');

            $('#data').html(html);
            refreshKelasAsalPagination();
        },
        error: function (xhr) {
            ajaxError(xhr);
        }
    });
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
    var filterMasihSama = filterKenaikanAktif &&
        filterKenaikanAktif.periode_asal === String($('#periode_asal').val() || '') &&
        filterKenaikanAktif.kelas_asal === String($('#kelas_asal').val() || '') &&
        filterKenaikanAktif.periode_tujuan === String($('#periode_tujuan').val() || '') &&
        filterKenaikanAktif.kelas_tujuan === String($('#kelas_tujuan').val() || '');

    if (!kenaikanDiterapkan || !filterMasihSama) {
        Swal.fire('Perhatian', 'Klik Terapkan terlebih dahulu setelah memilih kelas asal dan kelas tujuan.', 'warning');
        return false;
    }

    if (!data.id_kelas_asal || !data.id_kelas_tujuan || !data.id_siswa.length) {
        Swal.fire('Perhatian', 'Pilih kelas asal, kelas tujuan, dan minimal satu siswa.', 'warning');
        return false;
    }
    return true;
}

function previewKenaikan() {
    var data = dataKenaikan();
    if (!validasiKenaikan(data)) return;
    $.ajax({
        url: '<?= base_url('admin/kesiswaan/kenaikan_kelas/preview'); ?>',
        type: 'POST',
        data: data,
        dataType: 'JSON',
        success: function (response) {
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
        },
        error: function (xhr) {
            ajaxError(xhr);
        }
    });
}

function prosesKenaikan() {
    var data = dataKenaikan();
    if (!validasiKenaikan(data)) return;
    confirmAction('Proses kenaikan kelas?', data.id_siswa.length + ' siswa akan dibuatkan penempatan baru. Data kelas lama tidak dihapus.', function () {
        $('#btn_proses').prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/kesiswaan/kenaikan_kelas/proses'); ?>',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            success: function (response) {
                var ok = response.result === 'true';
                Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');

                if (ok) {
                    loadSiswaKenaikan();
                }
            },
            error: function (xhr) {
                ajaxError(xhr);
            },
            complete: function () {
                $('#btn_proses').prop('disabled', false);
            }
        });
    });
}

function refreshKelasAsalPagination() {
    paging($('#data .siswa-kelas-asal-row'), parseInt($('#dt-length-kelas-asal').val(), 10) || 10, '#pagination-kelas-asal');
}

</script>