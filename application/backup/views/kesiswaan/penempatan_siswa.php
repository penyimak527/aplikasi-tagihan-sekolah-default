<div class="card">
    <div class="card-header">
        <h4 class="header-title">Penempatan Siswa</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-0">
            <div class="col-md-3">
                <label for="periode" class="form-label">Tahun Ajaran</label>
                <select id="periode" class="form-select">
                    <option value="">Pilih Tahun Ajaran</option>
                    <?php foreach ($periode as $row): ?>
                        <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['periode']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <label for="semester" class="form-label">Semester</label>
                <select id="semester" class="form-select">
                    <option value="">Pilih Semester</option>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select id="kelas" class="form-select">
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($kelas as $row): ?>
                        <option value="<?= (int) $row['id'] ?>"
                                data-periode="<?= html_escape($row['id_periode']) ?>"
                                data-semester="<?= html_escape($row['semester']) ?>">
                            <?= html_escape($row['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label">Cari Siswa</label>
                <input id="search" class="form-control" placeholder="Nama/NIS/NISN ...">
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-primary w-100" id="btn_tampilkan" title="Tampilkan">
                    <i class="ri-search-line"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title">Siswa Belum Ditempatkan</h4>
                    <small class="text-muted">Siswa yang belum memiliki penempatan pada periode dan semester terpilih.</small>
                </div>
                <button type="button" class="btn btn-sm btn-light" id="btn_pilih_semua">Pilih Semua</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="42"></th>
                                <th>Siswa</th>
                                <th>Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody id="belum">
                            <tr><td colspan="3"><div class="empty-state">Pilih tahun ajaran, semester, dan kelas.</div></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-transparent text-end">
                <button type="button" class="btn btn-primary" id="btn_tempatkan">
                    Tempatkan Siswa <i class="ri-arrow-right-line ms-1"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <div>
                    <h4 class="header-title">Siswa dalam Kelas Tujuan</h4>
                    <small class="text-muted" id="kelas_tujuan_label">Belum ada kelas dipilih.</small>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Jenis Kelamin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="sudah">
                            <tr><td colspan="3"><div class="empty-state">Pilih kelas tujuan.</div></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    filterKelasPenempatan();
    $('#periode, #semester').on('change', filterKelasPenempatan);
    $('#btn_tampilkan').on('click', loadPenempatan);
    $('#btn_pilih_semua').on('click', function () {
        $('.pilih-siswa').prop('checked', true);
    });
    $('#btn_tempatkan').on('click', prosesPenempatan);
    $('#search').on('keyup', function (event) {
        if (event.key === 'Enter') loadPenempatan();
    });
    $(document).on('click', '.btn-keluarkan-penempatan', function () {
        keluarkanPenempatan($(this).data('id'));
    });
});

function filterKelasPenempatan() {
    var periode = String($('#periode').val() || '');
    var semester = String($('#semester').val() || '');

    $('#kelas option').each(function () {
        var optionPeriode = String($(this).data('periode') || '');
        var optionSemester = String($(this).data('semester') || '');
        var visible = !optionPeriode || (optionPeriode === periode && optionSemester === semester);
        $(this).prop('hidden', !visible).prop('disabled', !visible);
    });

    $('#kelas').val('');
    $('#belum').html('<tr><td colspan="3"><div class="empty-state">Pilih kelas tujuan.</div></td></tr>');
    $('#sudah').html('<tr><td colspan="3"><div class="empty-state">Pilih kelas tujuan.</div></td></tr>');
    $('#kelas_tujuan_label').text('Belum ada kelas dipilih.');
}

function loadPenempatan() {
    var idKelas = $('#kelas').val();
    if (!$('#periode').val() || !$('#semester').val() || !idKelas) {
        Swal.fire('Perhatian', 'Pilih tahun ajaran, semester, dan kelas terlebih dahulu.', 'warning');
        return;
    }

    $('#belum, #sudah').html('<tr><td colspan="3"><div class="empty-state">Memuat data...</div></td></tr>');

    $.post('<?= base_url('penempatan_siswa/result') ?>', {
        id_kelas_setting: idKelas,
        search: $('#search').val()
    }, function (response) {
        if (response.result !== 'true') {
            Swal.fire('Gagal', response.message, 'error');
            return;
        }

        var unplaced = response.unplaced || [];
        var placed = response.placed || [];
        var belumHtml = unplaced.length ? unplaced.map(function (row) {
            return '<tr>' +
                '<td><input class="form-check-input pilih-siswa" type="checkbox" value="' + row.id + '"></td>' +
                '<td><strong>' + escapeHtml(row.nama_lengkap) + '</strong><br><small class="text-muted">NIS ' + escapeHtml(row.nis || '-') + ' | NISN ' + escapeHtml(row.nisn || '-') + '</small></td>' +
                '<td>' + escapeHtml(row.jk || '-') + '</td>' +
            '</tr>';
        }).join('') : '<tr><td colspan="3"><div class="empty-state">Tidak ada siswa yang belum ditempatkan.</div></td></tr>';

        var sudahHtml = placed.length ? placed.map(function (row) {
            return '<tr>' +
                '<td><strong>' + escapeHtml(row.nama_lengkap) + '</strong><br><small class="text-muted">NIS ' + escapeHtml(row.nis || '-') + ' | NISN ' + escapeHtml(row.nisn || '-') + '</small></td>' +
                '<td>' + escapeHtml(row.jk || '-') + '</td>' +
                '<td><button type="button" class="btn btn-sm btn-outline-danger btn-keluarkan-penempatan" data-id="' + row.id_kelas_siswa + '">Keluarkan</button></td>' +
            '</tr>';
        }).join('') : '<tr><td colspan="3"><div class="empty-state">Belum ada siswa dalam kelas ini.</div></td></tr>';

        $('#belum').html(belumHtml);
        $('#sudah').html(sudahHtml);
        $('#kelas_tujuan_label').text($('#kelas option:selected').text().trim() + ' - ' + placed.length + ' siswa');
    }, 'json').fail(ajaxError);
}

function prosesPenempatan() {
    var ids = $('.pilih-siswa:checked').map(function () { return this.value; }).get();
    if (!ids.length) {
        Swal.fire('Perhatian', 'Pilih minimal satu siswa.', 'warning');
        return;
    }

    var kelas = $('#kelas option:selected').text().trim();
    var periode = $('#periode option:selected').text().trim();
    confirmAction(
        'Tempatkan ' + ids.length + ' siswa?',
        ids.length + ' siswa akan ditempatkan ke ' + kelas + ' tahun ajaran ' + periode + '.',
        function () {
            $('#btn_tempatkan').prop('disabled', true);
            $.post('<?= base_url('penempatan_siswa/proses') ?>', {
                id_kelas_setting: $('#kelas').val(),
                id_siswa: ids
            }, function (response) {
                var ok = response.result === 'true';
                Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
                if (ok) loadPenempatan();
            }, 'json').fail(ajaxError).always(function () {
                $('#btn_tempatkan').prop('disabled', false);
            });
        }
    );
}

function keluarkanPenempatan(id) {
    confirmAction('Keluarkan penempatan?', 'Penempatan yang sudah digunakan untuk tagihan tidak dapat dikeluarkan langsung.', function () {
        $.post('<?= base_url('penempatan_siswa/keluarkan') ?>', {id_kelas_siswa: id}, function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) loadPenempatan();
        }, 'json').fail(ajaxError);
    });
}
</script>
