tarif per kelas 
<div class="card">
    <div class="card-header app-card-header">
        <h4 class="header-title">Tarif Per Kelas</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-0">
            <div class="col-md-8">
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
            <div class="col-md-2">
                <label for="filter_kelas" class="form-label">Kelas</label>
                <select id="filter_kelas" class="form-select" disabled>
                    <option value="">Pilih Kelas</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" id="btn_tampilkan" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </div>
</div>

<div class="card d-none" id="card_tarif">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title">Daftar Tarif Kelas</h4>
            <small class="text-muted">Tarif kelas hanya berlaku jika siswa tidak memiliki tarif khusus.</small>
        </div>
    </div>
    <div class="card-body">
        <form id="form_tarif">
            <input type="hidden" name="id_tagihan">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th class="text-end">Tarif Umum</th>
                            <th style="min-width:180px">Tarif Kelas</th>
                            <th class="text-center">Jumlah Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kelas_rows">
                        <tr><td colspan="5"><div class="empty-state">Pilih tagihan terlebih dahulu.</div></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-wrap justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-outline-primary" id="btn_terapkan_umum">
                    Terapkan Tarif Umum ke Semua
                </button>
                <button type="button" class="btn btn-primary" id="btn_simpan">
                    <i class="ri-save-line me-1"></i>Simpan Tarif Per Kelas
                </button>
            </div>
        </form>
    </div>
</div>

<script>
var tarifMaster = null;

$(document).ready(function () {
    $('#btn_tampilkan').on('click', loadTarifKelas);
    $('#btn_simpan').on('click', simpanTarifKelas);
    $('#filter_kelas').on('change', filterTarifKelas);
    $('#tagihan').on('change', function () {
        $('#filter_kelas')
            .prop('disabled', true)
            .html('<option value="">Pilih Kelas</option>');
        $('#card_tarif').addClass('d-none');
    });
    $('#btn_terapkan_umum').on('click', function () {
        if (!tarifMaster) return;
        $('.input-tarif-kelas').val(formatMoneyInput(tarifMaster.nominal_default || 0));
    });

    $(document).on('click', '.btn-salin-tarif', function () {
        var nominal = $(this).data('nominal');
        $(this).closest('tr').find('.input-tarif-kelas').val(formatMoneyInput(nominal));
    });

    if ($('#tagihan').val()) loadTarifKelas();
});

function loadTarifKelas() {
    var id = $('#tagihan').val();
    if (!id) {
        $('#filter_kelas')
            .prop('disabled', true)
            .html('<option value="">Pilih Kelas</option>');
        $('#card_tarif').addClass('d-none');
        return;
    }

    $('#kelas_rows').html('<tr><td colspan="5"><div class="empty-state">Memuat tarif kelas...</div></td></tr>');
    $.post('<?= base_url('admin/tagihan/tarif_per_kelas/result') ?>', {id_tagihan: id}, function (response) {
        if (response.result !== 'true') {
            $('#card_tarif').addClass('d-none');
            Swal.fire('Gagal', response.message, 'error');
            return;
        }

        tarifMaster = response.master || {};
        $('#card_tarif').removeClass('d-none');
        $('#form_tarif [name="id_tagihan"]').val(id);

        var rows = response.classes || [];
        if (!rows.length) {
            $('#filter_kelas')
                .prop('disabled', true)
                .html('<option value="">Tidak ada kelas</option>');
            $('#kelas_rows').html('<tr><td colspan="5"><div class="empty-state"><div class="empty-state-title">Belum ada target kelas</div><div>Tambahkan target kelas pada tagihan terlebih dahulu.</div></div></td></tr>');
            return;
        }

        var kelasOptions = '<option value="">Semua Kelas</option>';
        rows.forEach(function (row) {
            kelasOptions += '<option value="' + Number(row.id_kelas_setting || 0) + '">' +
                escapeHtml(row.nama_kelas || '-') +
            '</option>';
        });

        $('#filter_kelas')
            .html(kelasOptions)
            .prop('disabled', false);

        var html = rows.map(function (row) {
            var value = formatMoneyInput(row.nominal_kelas || tarifMaster.nominal_default || 0);
            return '<tr class="tarif-kelas-row" data-kelas-setting="' + Number(row.id_kelas_setting || 0) + '">' +
                '<td><strong>' + escapeHtml(row.nama_kelas || '-') + '</strong></td>' +
                '<td class="text-end">' + formatRupiah(tarifMaster.nominal_default || 0) + '</td>' +
                '<td><input type="text" inputmode="numeric" autocomplete="off" class="form-control money-input input-tarif-kelas" name="tarif[' + row.id + ']" value="' + value + '"></td>' +
                '<td class="text-center">' + Number(row.jumlah_siswa || 0).toLocaleString('id-ID') + '</td>' +
                '<td><button type="button" class="btn btn-sm btn-outline-primary btn-salin-tarif" data-nominal="' + Number(tarifMaster.nominal_default || 0) + '">Salin</button></td>' +
            '</tr>';
        }).join('');

        $('#kelas_rows').html(html);
        filterTarifKelas();
    }, 'json').fail(ajaxError);
}

function filterTarifKelas() {
    var idKelas = String($('#filter_kelas').val() || '');
    var $rows = $('#kelas_rows .tarif-kelas-row');

    if (!idKelas) {
        $rows.show();
        return;
    }

    $rows.each(function () {
        var rowKelas = String($(this).data('kelas-setting') || '');
        $(this).toggle(rowKelas === idKelas);
    });
}

function simpanTarifKelas() {
    if (!$('#form_tarif [name="id_tagihan"]').val()) {
        return Swal.fire('Perhatian', 'Pilih tagihan terlebih dahulu.', 'warning');
    }

    confirmAction('Simpan tarif per kelas?', 'Perubahan diterapkan pada tarif normal siswa. Tarif khusus siswa tetap memiliki prioritas tertinggi dan perubahan dicatat pada log aktivitas.', function () {
        var button = $('#btn_simpan').prop('disabled', true);
        $.post('<?= base_url('admin/tagihan/tarif_per_kelas/simpan') ?>', serializeMoneyForm('#form_tarif'), function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) loadTarifKelas();
        }, 'json').fail(ajaxError).always(function () {
            button.prop('disabled', false);
        });
    });
}
</script>