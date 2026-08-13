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
                        <option value="<?= (int) $row['id'] ?>">
                            <?= html_escape($row['periode']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select id="kelas" class="form-select">
                    <option value="">Pilih Kelas</option>
                    <?php foreach ($kelas as $row): ?>
                        <option
                            value="<?= (int) $row['id'] ?>"
                            data-periode="<?= html_escape($row['id_periode']) ?>"
                        >
                            <?= html_escape($row['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label for="search" class="form-label">Cari Siswa</label>
                <input
                    type="text"
                    id="search"
                    class="form-control"
                    placeholder="Nama/NIS/NISN ..."
                >
            </div>

            <div class="col-md-1 d-grid">
                <button
                    type="button"
                    class="btn btn-primary"
                    id="btn_tampilkan"
                    title="Tampilkan"
                >
                    <i class="ri-search-line"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-xl-6">
        <div class="card">
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title">Siswa Belum Ditempatkan</h4>
                    <small class="text-muted">
                        Siswa yang belum memiliki penempatan pada tahun ajaran terpilih.
                    </small>
                </div>

                <button
                    type="button"
                    class="btn btn-sm btn-light"
                    id="btn_pilih_semua"
                >
                    Pilih Semua
                </button>
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
                            <tr class="data-belum">
                                <td colspan="3">
                                    <div class="empty-state">
                                        Pilih tahun ajaran dan kelas.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-transparent">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2"
                >
                    <ul
                        class="pagination pagination-sm pagination-boxed mb-0"
                        id="pagination-belum"
                    ></ul>

                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-belum" class="mb-0">
                            Tampilkan
                        </label>

                        <select
                            class="form-select form-select-sm"
                            id="dt-length-belum"
                        >
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>

                        <span>entri</span>
                    </div>
                </div>

                <div class="text-end mt-3">
                    <button
                        type="button"
                        class="btn btn-primary"
                        id="btn_tempatkan"
                    >
                        Tempatkan Siswa
                        <i class="ri-arrow-right-line ms-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-6">
        <div class="card ">
            <div class="card-header">
                <div>
                    <h4 class="header-title">Siswa dalam Kelas Tujuan</h4>
                    <small class="text-muted" id="kelas_tujuan_label">
                        Belum ada kelas dipilih.
                    </small>
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
                            <tr class="data-sudah">
                                <td colspan="3">
                                    <div class="empty-state">
                                        Pilih kelas tujuan.
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer bg-transparent">
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2"
                >
                    <ul
                        class="pagination pagination-sm pagination-boxed mb-0"
                        id="pagination-sudah"
                    ></ul>

                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-sudah" class="mb-0">
                            Tampilkan
                        </label>

                        <select
                            class="form-select form-select-sm"
                            id="dt-length-sudah"
                        >
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

<script>
$(document).ready(function () {
    filterKelasPenempatan();

    $('#periode').on('change', function () {
        filterKelasPenempatan();
    });

    $('#btn_tampilkan').on('click', function () {
        loadPenempatan();
    });

    $('#btn_pilih_semua').on('click', function () {
        $('.pilih-siswa').prop('checked', true);
    });

    $('#btn_tempatkan').on('click', function () {
        prosesPenempatan();
    });

    $('#search').on('keyup', function (event) {
        if (event.key === 'Enter') {
            loadPenempatan();
        }
    });

    $('#dt-length-belum').on('change', function () {
        const jumlah = parseInt($(this).val());

        paging(
            $('#belum .data-belum'),
            jumlah,
            '#pagination-belum'
        );
    });

    $('#dt-length-sudah').on('change', function () {
        const jumlah = parseInt($(this).val());

        paging(
            $('#sudah .data-sudah'),
            jumlah,
            '#pagination-sudah'
        );
    });

    $(document).on('click', '.btn-keluarkan-penempatan', function () {
        var id = $(this).data('id');
        keluarkanPenempatan(id);
    });
});

function filterKelasPenempatan() {
    var periode = String($('#periode').val() || '');

    $('#kelas option').each(function () {
        var optionPeriode = String($(this).data('periode') || '');

        var visible = !optionPeriode || optionPeriode === periode;

        $(this)
            .prop('hidden', !visible)
            .prop('disabled', !visible);
    });

    $('#kelas').val('');

    $('#belum').html(`
        <tr class="data-belum">
            <td colspan="3">
                <div class="empty-state">
                    Pilih kelas tujuan.
                </div>
            </td>
        </tr>
    `);

    $('#sudah').html(`
        <tr class="data-sudah">
            <td colspan="3">
                <div class="empty-state">
                    Pilih kelas tujuan.
                </div>
            </td>
        </tr>
    `);

    $('#kelas_tujuan_label').text('Belum ada kelas dipilih.');

    refreshPaginationBelum();
    refreshPaginationSudah();
}

function loadPenempatan() {
    var idKelas = $('#kelas').val();
    var search = $('#search').val();

    if (
        $('#periode').val() == '' ||
        idKelas == ''
    ) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Pilih tahun ajaran dan kelas terlebih dahulu.'
        });

        return;
    }

    $('#belum').html(`
        <tr class="data-belum">
            <td colspan="3">
                <div class="empty-state">
                    Memuat data...
                </div>
            </td>
        </tr>
    `);

    $('#sudah').html(`
        <tr class="data-sudah">
            <td colspan="3">
                <div class="empty-state">
                    Memuat data...
                </div>
            </td>
        </tr>
    `);

    refreshPaginationBelum();
    refreshPaginationSudah();

    $.ajax({
        url: '<?= base_url('admin/kesiswaan/penempatan_siswa/result'); ?>',
        type: 'POST',
        data: {
            id_kelas_setting: idKelas,
            search: search
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.result == 'false') {
                $('#belum').html(`
                    <tr class="data-belum">
                        <td colspan="3">
                            <div class="empty-state">
                                Data siswa gagal dimuat.
                            </div>
                        </td>
                    </tr>
                `);

                $('#sudah').html(`
                    <tr class="data-sudah">
                        <td colspan="3">
                            <div class="empty-state">
                                Data siswa gagal dimuat.
                            </div>
                        </td>
                    </tr>
                `);

                refreshPaginationBelum();
                refreshPaginationSudah();

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message
                });

                return;
            }

            var unplaced = data.unplaced || [];
            var placed = data.placed || [];
            var belumHtml = '';
            var sudahHtml = '';

            if (unplaced.length == 0) {
                belumHtml += `
                    <tr class="data-belum">
                        <td colspan="3">
                            <div class="empty-state">
                                Tidak ada siswa yang belum ditempatkan.
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                unplaced.forEach(function (item) {
                    belumHtml += `
                        <tr class="data-belum">
                            <td>
                                <input
                                    class="form-check-input pilih-siswa"
                                    type="checkbox"
                                    value="${item.id}"
                                >
                            </td>

                            <td>
                                <strong>
                                    ${escapeHtml(item.nama_lengkap)}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    NIS ${escapeHtml(item.nis || '-')}
                                    |
                                    NISN ${escapeHtml(item.nisn || '-')}
                                </small>
                            </td>

                            <td>
                                ${escapeHtml(item.jk || '-')}
                            </td>
                        </tr>
                    `;
                });
            }

            if (placed.length == 0) {
                sudahHtml += `
                    <tr class="data-sudah">
                        <td colspan="3">
                            <div class="empty-state">
                                Belum ada siswa dalam kelas ini.
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                placed.forEach(function (item) {
                    sudahHtml += `
                        <tr class="data-sudah">
                            <td>
                                <strong>
                                    ${escapeHtml(item.nama_lengkap)}
                                </strong>

                                <br>

                                <small class="text-muted">
                                    NIS ${escapeHtml(item.nis || '-')}
                                    |
                                    NISN ${escapeHtml(item.nisn || '-')}
                                </small>
                            </td>

                            <td>
                                ${escapeHtml(item.jk || '-')}
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger btn-keluarkan-penempatan"
                                    data-id="${item.id_kelas_siswa}"
                                >
                                    Keluarkan
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#belum').html(belumHtml);
            $('#sudah').html(sudahHtml);

            $('#kelas_tujuan_label').text(
                $('#kelas option:selected').text().trim() +
                ' - ' +
                placed.length +
                ' siswa'
            );

            refreshPaginationBelum();
            refreshPaginationSudah();
        },
        error: function (xhr, status, error) {
            $('#belum').html(`
                <tr class="data-belum">
                    <td colspan="3">
                        <div class="empty-state">
                            Data siswa gagal dimuat.
                        </div>
                    </td>
                </tr>
            `);

            $('#sudah').html(`
                <tr class="data-sudah">
                    <td colspan="3">
                        <div class="empty-state">
                            Data siswa gagal dimuat.
                        </div>
                    </td>
                </tr>
            `);

            refreshPaginationBelum();
            refreshPaginationSudah();
            ajaxError(xhr);
        }
    });
}

function prosesPenempatan() {
    var ids = $('.pilih-siswa:checked').map(function () {
        return this.value;
    }).get();

    if (ids.length == 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Pilih minimal satu siswa.'
        });

        return;
    }

    var kelas = $('#kelas option:selected').text().trim();
    var periode = $('#periode option:selected').text().trim();

    confirmAction(
        'Tempatkan ' + ids.length + ' siswa?',
        ids.length +
        ' siswa akan ditempatkan ke ' +
        kelas +
        ' tahun ajaran ' +
        periode +
        '.',
        function () {
            $('#btn_tempatkan').prop('disabled', true);

            $.ajax({
                url: '<?= base_url('admin/kesiswaan/penempatan_siswa/proses'); ?>',
                type: 'POST',
                data: {
                    id_kelas_setting: $('#kelas').val(),
                    id_siswa: ids
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.result == 'true') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message
                        });

                        loadPenempatan();
                    } else if (data.result == 'false') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    ajaxError(xhr);
                },
                complete: function () {
                    $('#btn_tempatkan').prop('disabled', false);
                }
            });
        }
    );
}

function keluarkanPenempatan(id) {
    confirmAction(
        'Keluarkan penempatan?',
        'Penempatan yang sudah digunakan untuk tagihan tidak dapat dikeluarkan langsung.',
        function () {
            $.ajax({
                url: '<?= base_url('admin/kesiswaan/penempatan_siswa/keluarkan'); ?>',
                type: 'POST',
                data: {
                    id_kelas_siswa: id
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.result == 'true') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message
                        });

                        loadPenempatan();
                    } else if (data.result == 'false') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    ajaxError(xhr);
                }
            });
        }
    );
}

function refreshPaginationBelum() {
    var jumlah = parseInt($('#dt-length-belum').val());

    paging(
        $('#belum .data-belum'),
        jumlah,
        '#pagination-belum'
    );
}

function refreshPaginationSudah() {
    var jumlah = parseInt($('#dt-length-sudah').val());

    paging(
        $('#sudah .data-sudah'),
        jumlah,
        '#pagination-sudah'
    );
}
</script>