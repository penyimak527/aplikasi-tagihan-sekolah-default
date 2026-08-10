<div class="card">
    <div class="card-header app-card-header">
        <h4 class="header-title">Tarif Per Kelas</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-0">
            <div class="col-md-10">
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
                <button type="button" id="btn_tampilkan" class="btn btn-primary w-100">Tampilkan</button>
            </div>
        </div>
    </div>
</div>

<div class="card d-none" id="card_tarif">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title">Daftar Tarif Kelas</h4>
            <small class="text-muted">Tarif kelas hanya dipakai jika siswa tidak memiliki tarif khusus.</small>
        </div>
        <button type="button" class="btn btn-primary" id="btn_simpan">
            <i class="ri-save-line me-1"></i>Simpan Tarif Per Kelas
        </button>
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
                            <th class="text-end">Pembayaran Masuk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="kelas_rows">
                        <tr><td colspan="6"><div class="empty-state">Pilih tagihan terlebih dahulu.</div></td></tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <button type="button" class="btn btn-outline-primary" id="btn_terapkan_umum">
                    Terapkan Tarif Umum ke Semua
                </button>
            </div>
        </form>
    </div>
</div>

<script>
var tarifMaster = null;

$(document).ready(function () {
    $('#btn_tampilkan').on('click', loadTarifKelas);
    // $('#tagihan').on('change', loadTarifKelas);
    $('#btn_simpan').on('click', simpanTarifKelas);
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
        $('#card_tarif').addClass('d-none');
        return;
    }

    $('#kelas_rows').html('<tr><td colspan="6"><div class="empty-state">Memuat tarif kelas...</div></td></tr>');
    $.post('<?= base_url('admin/tagihan/tarif_per_kelas/result') ?>', {id_tagihan: id}, function (response) {
        if (response.result !== 'true') {
            Swal.fire('Gagal', response.message, 'error');
            return;
        }

        tarifMaster = response.master || {};
        $('#card_tarif').removeClass('d-none');
        $('#form_tarif [name="id_tagihan"]').val(id);

        var rows = response.classes || [];
        if (!rows.length) {
            $('#kelas_rows').html('<tr><td colspan="6"><div class="empty-state"><div class="empty-state-title">Belum ada target kelas</div><div>Tambahkan target kelas pada tagihan terlebih dahulu.</div></div></td></tr>');
            return;
        }

        var html = rows.map(function (row) {
            var value = formatMoneyInput(row.nominal_kelas || tarifMaster.nominal_default || 0);
            return '<tr>' +
                '<td><strong>' + escapeHtml(row.nama_kelas || '-') + '</strong><br><small class="text-muted">' + escapeHtml(row.semester || '-') + '</small></td>' +
                '<td class="text-end">' + formatRupiah(tarifMaster.nominal_default || 0) + '</td>' +
                '<td><input type="text" inputmode="numeric" autocomplete="off" class="form-control money-input input-tarif-kelas" name="tarif[' + row.id + ']" value="' + value + '"></td>' +
                '<td class="text-center">' + Number(row.jumlah_siswa || 0).toLocaleString('id-ID') + '</td>' +
                '<td class="text-end">' + formatRupiah(row.total_dibayar || 0) + '</td>' +
                '<td><button type="button" class="btn btn-sm btn-outline-primary btn-salin-tarif" data-nominal="' + Number(tarifMaster.nominal_default || 0) + '">Salin Umum</button></td>' +
            '</tr>';
        }).join('');
        $('#kelas_rows').html(html);
    }, 'json').fail(ajaxError);
}

function simpanTarifKelas() {
    confirmAction('Simpan tarif per kelas?', 'Perubahan akan diterapkan pada siswa tanpa tarif khusus dan dicatat pada log aktivitas.', function () {
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
