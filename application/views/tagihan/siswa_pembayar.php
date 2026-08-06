<div class="card">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title mb-1">Siswa Pembayar</h4>
            <p class="text-muted mb-0">Pilih tagihan, lalu kelola siswa yang menjadi penerima tagihan.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-lg-6">
                <label class="form-label" for="tagihan">Tagihan</label>
                <select id="tagihan" class="form-select">
                    <option value="">Pilih tagihan</option>
                    <?php foreach ($tagihan as $row): ?>
                        <option value="<?= (int) $row['id'] ?>" <?= (int) $id_tagihan === (int) $row['id'] ? 'selected' : '' ?>>
                            <?= html_escape($row['periode'] . ' - ' . $row['nama_tagihan'] . ' [' . $row['status'] . ']') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-4">
                <label class="form-label" for="search">Nama/NIS/NISN</label>
                <input id="search" class="form-control" placeholder="Cari siswa ...">
            </div>
            <div class="col-lg-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn_tampilkan">
                    <i class="ri-search-line me-1"></i>Tampilkan
                </button>
            </div>
        </div>
    </div>
</div>

<div id="content" class="d-none">
    <div class="row g-3">
        <div class="col-xl-6">
            <div class="card ">
                <div class="card-header app-card-header">
                    <div>
                        <h4 class="header-title mb-1">Siswa Pembayar</h4>
                        <small class="text-muted">Siswa yang sudah menjadi penerima tagihan.</small>
                    </div>
                    <span class="badge bg-primary" id="count_current">0</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Siswa</th>
                                    <th class="text-end">Tarif</th>
                                    <th class="text-end">Dibayar</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="current"></tbody>
                        </table>
                    </div>
                    <div class="px-3 pb-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3">
                            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-current"></ul>
                            <div class="d-flex align-items-center gap-2">
                                <label for="dt-length-current" class="mb-0">Tampilkan</label>
                                <select class="form-select form-select-sm" id="dt-length-current">
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
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card ">
                <div class="card-header app-card-header">
                    <div>
                        <h4 class="header-title mb-1">Calon Siswa</h4>
                        <small class="text-muted">Siswa aktif pada tahun ajaran tagihan yang belum menjadi penerima.</small>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-sm btn-light" id="btn_pilih_semua">Pilih Semua</button>
                        <button type="button" class="btn btn-sm btn-primary" id="btn_tambah">Tambah Terpilih</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="42"></th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody id="candidates"></tbody>
                        </table>
                    </div>
                    <div class="px-3 pb-3">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3">
                            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-candidates"></ul>
                            <div class="d-flex align-items-center gap-2">
                                <label for="dt-length-candidates" class="mb-0">Tampilkan</label>
                                <select class="form-select form-select-sm" id="dt-length-candidates">
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
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#tagihan').on('change', loadData);
    $('#btn_tampilkan').on('click', loadData);
    $('#btn_tambah').on('click', tambah);
    $('#btn_pilih_semua').on('click', function () {
        $('#candidates .candidate:visible').prop('checked', true);
    });
    $('#search').on('keyup', function (event) {
        if (event.key === 'Enter') loadData();
    });
    $('#dt-length-current').on('change', refreshCurrentPagination);
    $('#dt-length-candidates').on('change', refreshCandidatePagination);

    if ($('#tagihan').val()) {
        loadData();
    } else {
        refreshCurrentPagination();
        refreshCandidatePagination();
    }
});

function loadData() {
    var id = $('#tagihan').val();

    if (!id) {
        $('#content').addClass('d-none');
        return Swal.fire('Perhatian', 'Pilih tagihan terlebih dahulu.', 'warning');
    }

    $.post('<?= base_url('siswa_pembayar/result') ?>', {
        id_tagihan: id,
        search: $('#search').val()
    }, function (response) {
        if (response.result !== 'true') {
            return Swal.fire('Gagal', response.message, 'error');
        }

        $('#content').removeClass('d-none');

        var current = response.current || [];
        var candidates = response.candidates || [];
        var currentHtml = '';
        var candidateHtml = '';

        $('#count_current').text(current.length);

        if (!current.length) {
            currentHtml = '<tr><td colspan="4"><div class="empty-state">Belum ada siswa pembayar.</div></td></tr>';
        } else {
            current.forEach(function (row) {
                currentHtml +=
                    '<tr class="current-student-row">' +
                        '<td><strong>' + escapeHtml(row.nama_siswa) + '</strong><br><small class="text-muted">' +
                            escapeHtml(row.nis || '-') + ' | ' + escapeHtml(row.nama_kelas || '-') +
                        '</small></td>' +
                        '<td class="text-end">' + formatRupiah(row.tarif || 0) + '</td>' +
                        '<td class="text-end">' + formatRupiah(row.dibayar || 0) + '</td>' +
                        '<td class="text-center"><button type="button" class="btn btn-sm btn-outline-danger" onclick="keluarkan(' + Number(row.id_siswa) + ')">Keluarkan</button></td>' +
                    '</tr>';
            });
        }

        if (!candidates.length) {
            candidateHtml = '<tr><td colspan="3"><div class="empty-state">Tidak ada calon siswa.</div></td></tr>';
        } else {
            candidates.forEach(function (row) {
                candidateHtml +=
                    '<tr class="candidate-student-row">' +
                        '<td><input type="checkbox" class="form-check-input candidate" value="' + Number(row.id_siswa) + '"></td>' +
                        '<td><strong>' + escapeHtml(row.nama_siswa) + '</strong><br><small class="text-muted">' +
                            escapeHtml(row.nis || '-') + ' / ' + escapeHtml(row.nisn || '-') +
                        '</small></td>' +
                        '<td>' + escapeHtml(row.nama_kelas || '-') + '</td>' +
                    '</tr>';
            });
        }

        $('#current').html(currentHtml);
        $('#candidates').html(candidateHtml);
        refreshCurrentPagination();
        refreshCandidatePagination();
    }, 'json').fail(ajaxError);
}

function refreshCurrentPagination() {
    paging(
        $('#current .current-student-row'),
        parseInt($('#dt-length-current').val(), 10) || 10,
        '#pagination-current'
    );
}

function refreshCandidatePagination() {
    paging(
        $('#candidates .candidate-student-row'),
        parseInt($('#dt-length-candidates').val(), 10) || 10,
        '#pagination-candidates'
    );
}

function tambah() {
    var ids = $('.candidate:checked').map(function () {
        return this.value;
    }).get();

    if (!ids.length) {
        return Swal.fire('Perhatian', 'Pilih siswa yang akan ditambahkan.', 'warning');
    }

    confirmAction(
        'Tambahkan siswa?',
        'Tarif mengikuti tarif khusus, tarif kelas, lalu tarif umum.',
        function () {
            $.post('<?= base_url('siswa_pembayar/tambah') ?>', {
                id_tagihan: $('#tagihan').val(),
                id_siswa: ids
            }, function (response) {
                var berhasil = response.result === 'true';
                Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                if (berhasil) loadData();
            }, 'json').fail(ajaxError);
        }
    );
}

function keluarkan(id) {
    confirmAction(
        'Keluarkan siswa?',
        'Siswa yang sudah membayar tidak dapat dikeluarkan.',
        function () {
            $.post('<?= base_url('siswa_pembayar/keluarkan') ?>', {
                id_tagihan: $('#tagihan').val(),
                id_siswa: id
            }, function (response) {
                var berhasil = response.result === 'true';
                Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                if (berhasil) loadData();
            }, 'json').fail(ajaxError);
        }
    );
}
</script>
