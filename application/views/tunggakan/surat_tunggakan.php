<div class="row g-3">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Buat Surat Tunggakan</h5>
            </div>

            <div class="card-body">
                <div class="row g-2 align-items-end">
                    <div class="col-md-10">
                        <input
                            id="q"
                            class="form-control"
                            placeholder="Cari siswa nama / NIS / NISN"
                        >
                    </div>

                    <div class="col-md-2 d-grid">
                        <button type="button" id="cari" class="btn btn-primary">
                            <i class="ri-search-line me-1"></i>Cari
                        </button>
                    </div>
                </div>

                <div id="hasil" class="mt-3"></div>

                <div
                    id="pagination_siswa_area"
                    class="d-none flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2"
                >
                    <ul
                        class="pagination pagination-sm pagination-boxed mb-0"
                        id="pagination-siswa"
                    ></ul>

                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-siswa" class="mb-0">
                            Tampilkan
                        </label>

                        <select
                            class="form-select form-select-sm"
                            id="dt-length-siswa"
                        >
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>

                        <span>entri</span>
                    </div>
                </div>

                <div
                    id="identitas"
                    class="alert alert-primary mt-3 d-none"
                ></div>

                <div id="formArea" class="d-none">
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <select id="periode" class="form-select">
                                <option value="">Semua Tahun Ajaran</option>

                                <?php foreach ($periode as $p): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= html_escape($p['periode']) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select id="batasBulan" class="form-select">
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option
                                        value="<?= $i ?>"
                                        <?= $i == date('n') ? 'selected' : '' ?>
                                    >
                                        Sampai <?= nama_bulan($i) ?>
                                    </option>
                                <?php endfor ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select
                                id="batasTahun"
                                class="form-select"
                            >
                                <option value="">Pilih Tahun</option>

                                <?php
                                $now = date('Y');

                                for ($a = 2025; $a <= $now; $a++):
                                ?>
                                    <option
                                        value="<?= $a ?>"
                                        <?= $a == $now ? 'selected' : '' ?>
                                    >
                                        <?= $a ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-2 d-grid">
                            <button
                                type="button"
                                id="muat"
                                class="btn btn-secondary"
                            >
                                Muat
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>
                                        <input
                                            type="checkbox"
                                            id="all"
                                        >
                                    </th>
                                    <th>Tagihan</th>
                                    <th>Periode</th>
                                    <th class="text-end">Nominal</th>
                                    <th class="text-end">Dibayar</th>
                                    <th class="text-end">Sisa</th>
                                </tr>
                            </thead>

                            <tbody id="tagihan">
                                <tr>
                                    <td
                                        colspan="6"
                                        class="empty-state"
                                    >
                                        Muat tagihan.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card sticky-summary">
            <div class="card-header">
                <h5 class="mb-0">Informasi Surat</h5>
            </div>

            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <strong>Total dalam Surat</strong>
                    <strong
                        class="text-danger fs-18"
                        id="total"
                    >
                        Rp0
                    </strong>
                </div>

                <div class="mb-2">
                    <label class="form-label">Tanggal Surat</label>
                    <input
                        id="tanggal"
                        class="form-control tanggal-picker"
                        value="<?= date('d-m-Y') ?>"
                        autocomplete="off"
                    >
                </div>

                <div class="mb-2">
                    <label class="form-label">
                        Nama Penandatangan
                    </label>
                    <input
                        id="namaTtd"
                        class="form-control"
                        value="Bendahara Sekolah"
                    >
                </div>

                <div class="mb-2">
                    <label class="form-label">Jabatan</label>
                    <input
                        id="jabatanTtd"
                        class="form-control"
                        value="Bendahara"
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea
                        id="catatan"
                        class="form-control"
                        rows="3"
                    ></textarea>
                </div>

                <div class="d-grid">
                    <button
                        type="button"
                        id="simpan"
                        class="btn btn-success"
                        disabled
                    >
                        Simpan & Preview Surat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Riwayat Surat</h5>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No Surat</th>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th class="text-end">Total</th>
                        <th>Status WA</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="riwayat"></tbody>
            </table>
        </div>

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2"
        >
            <ul
                class="pagination pagination-sm pagination-boxed mb-0"
                id="pagination-riwayat"
            ></ul>

            <div class="d-flex align-items-center gap-2">
                <label
                    for="dt-length-riwayat"
                    class="mb-0"
                >
                    Tampilkan
                </label>

                <select
                    class="form-select form-select-sm"
                    id="dt-length-riwayat"
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


<style>
/*
 * Pagination JS bawaan menggunakan icon Font Awesome:
 * fa-angle-double-left, fa-angle-left, fa-angle-right, fa-angle-double-right.
 *
 * Pada template ini kotak pagination tampil tetapi icon FA tidak terbaca.
 * Pagination tetap memakai Pagination JS; CSS berikut hanya memberikan
 * fallback karakter pada icon bawaan agar arrow terlihat.
 */
#pagination-siswa .fa-angle-double-left::before,
#pagination-riwayat .fa-angle-double-left::before {
    content: "\00AB" !important;
    font-family: Arial, sans-serif !important;
}

#pagination-siswa .fa-angle-left::before,
#pagination-riwayat .fa-angle-left::before {
    content: "\2039" !important;
    font-family: Arial, sans-serif !important;
}

#pagination-siswa .fa-angle-right::before,
#pagination-riwayat .fa-angle-right::before {
    content: "\203A" !important;
    font-family: Arial, sans-serif !important;
}

#pagination-siswa .fa-angle-double-right::before,
#pagination-riwayat .fa-angle-double-right::before {
    content: "\00BB" !important;
    font-family: Arial, sans-serif !important;
}

#pagination-siswa .page-link i,
#pagination-riwayat .page-link i {
    font-style: normal;
}
</style>

<script>
    let siswa = null;
    let rows = [];

    $(document).ready(function () {
        flatpickr('.tanggal-picker', {
            dateFormat: 'd-m-Y',
            allowInput: true,
            disableMobile: true
        });

        history();

        $('#cari').on('click', function () {
            search();
        });

        $('#q').on('keypress', function (e) {
            if (e.which === 13) {
                search();
            }
        });

        $('#dt-length-siswa').on('change', function () {
            const jumlah = parseInt($(this).val());

            paging(
                $('#hasil .data-siswa-surat'),
                jumlah,
                '#pagination-siswa'
            );
        });

        $('#dt-length-riwayat').on('change', function () {
            const jumlah = parseInt($(this).val());

            paging(
                $('#riwayat .data-riwayat-surat'),
                jumlah,
                '#pagination-riwayat'
            );
        });

        $(document).on('click', '.pilih', function () {
            siswa = JSON.parse(
                $(this).attr('data-json')
            );

            /*
             * Setelah nama siswa diklik:
             * hasil pencarian dan pagination siswa dihilangkan.
             */
            $('#hasil').empty();

            $('#pagination-siswa').empty();

            $('#pagination_siswa_area')
                .addClass('d-none')
                .removeClass('d-flex');

            $('#identitas')
                .removeClass('d-none')
                .html(`
                    <strong>
                        ${escapeHtml(siswa.nama_lengkap)}
                    </strong>
                    <br>
                    ${escapeHtml(
                        siswa.nis +
                        ' | ' +
                        (siswa.nama_kelas || '-')
                    )}
                    <br>
                    Ayah:
                    ${escapeHtml(siswa.telepon_ayah || '-')}
                    |
                    Ibu:
                    ${escapeHtml(siswa.telepon_ibu || '-')}
                `);

            $('#formArea').removeClass('d-none');

            loadBills();
        });

        $('#muat').on('click', function () {
            loadBills();
        });

        $('#all').on('change', function () {
            $('.cek').prop(
                'checked',
                this.checked
            );

            calc();
        });

        $(document).on(
            'change',
            '.cek',
            function () {
                calc();
            }
        );

        $('#simpan').on('click', function () {
            saveLetter();
        });

        $(document).on(
            'click',
            '.wa',
            function () {
                openWhatsapp($(this));
            }
        );

        let preset =
            new URLSearchParams(
                location.search
            ).get('siswa');

        if (preset) {
            loadPresetStudent(preset);
        }
    });

    function money(n) {
        return 'Rp' +
            Number(n || 0)
                .toLocaleString('id-ID');
    }

    function search() {
        let q = $.trim(
            $('#q').val()
        );

        if (q.length < 2) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Masukkan minimal 2 karakter.'
            });

            return;
        }

        var button = $('#cari');

        $.ajax({
            url: '<?= base_url('tunggakan/surat_tunggakan/cari_siswa'); ?>',
            type: 'POST',

            data: {
                q: q
            },

            dataType: 'JSON',

            beforeSend: function () {
                button
                    .prop('disabled', true)
                    .html(
                        '<span class="spinner-border spinner-border-sm me-1"></span>Mencari'
                    );

                $('#hasil').html(`
                    <div class="data-siswa-surat">
                        <div class="empty-state">
                            Memuat data...
                        </div>
                    </div>
                `);

                $('#pagination-siswa').empty();

                $('#pagination_siswa_area')
                    .removeClass('d-none')
                    .addClass('d-flex');
            },

            success: function (data) {
                var dataSiswa =
                    Array.isArray(data)
                        ? data
                        : [];

                var html = '';

                if (dataSiswa.length == 0) {
                    html += `
                        <div class="data-siswa-surat">
                            <div class="alert alert-warning mb-0">
                                Tidak ada data
                            </div>
                        </div>
                    `;
                } else {
                    html +=
                        '<div class="list-group">';

                    dataSiswa.forEach(
                        function (item) {
                            html += `
                                <button
                                    type="button"
                                    class="list-group-item list-group-item-action pilih data-siswa-surat"
                                    data-json='${escapeHtml(JSON.stringify(item))}'
                                >
                                    <strong>
                                        ${escapeHtml(item.nama_lengkap)}
                                    </strong>

                                    <br>

                                    <small>
                                        ${escapeHtml(
                                            item.nis +
                                            ' | ' +
                                            (item.nama_kelas || '-')
                                        )}
                                    </small>
                                </button>
                            `;
                        }
                    );

                    html += '</div>';
                }

                $('#hasil').html(html);

                /*
                 * Hasil siswa sudah tampil dan belum dipilih:
                 * pagination siswa ikut ditampilkan.
                 */
                $('#pagination_siswa_area')
                    .removeClass('d-none')
                    .addClass('d-flex');

                let jumlah_awal =
                    parseInt(
                        $('#dt-length-siswa').val()
                    );

                paging(
                    $('#hasil .data-siswa-surat'),
                    jumlah_awal,
                    '#pagination-siswa'
                );
            },

            error: function (
                xhr,
                status,
                error
            ) {
                $('#hasil').html(`
                    <div class="alert alert-danger mb-0">
                        Data siswa gagal dimuat.
                    </div>
                `);

                $('#pagination-siswa').empty();

                ajaxError(
                    xhr,
                    status,
                    error
                );
            },

            complete: function () {
                button
                    .prop('disabled', false)
                    .html(
                        '<i class="ri-search-line me-1"></i>Cari'
                    );
            }
        });
    }

    function loadBills() {
        if (!siswa) {
            return;
        }

        if (!$('#batasTahun').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih tahun terlebih dahulu.'
            });

            return;
        }

        $.ajax({
            url: '<?= base_url('tunggakan/surat_tunggakan/tagihan'); ?>',
            type: 'POST',

            data: {
                id_siswa: siswa.id,
                id_periode:
                    $('#periode').val(),
                batas_bulan:
                    $('#batasBulan').val(),
                batas_tahun:
                    $('#batasTahun').val()
            },

            dataType: 'JSON',

            beforeSend: function () {
                $('#tagihan').html(`
                    <tr>
                        <td
                            colspan="6"
                            class="empty-state"
                        >
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memuat tagihan...
                        </td>
                    </tr>
                `);
            },

            success: function (data) {
                rows =
                    Array.isArray(data)
                        ? data
                        : [];

                var html = '';

                if (rows.length == 0) {
                    html += `
                        <tr>
                            <td
                                colspan="6"
                                class="empty-state"
                            >
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                } else {
                    rows.forEach(
                        function (item) {
                            html += `
                                <tr>
                                    <td>
                                        <input
                                            type="checkbox"
                                            class="form-check-input cek"
                                            value="${Number(item.id)}"
                                        >
                                    </td>

                                    <td>
                                        <strong>
                                            ${escapeHtml(item.nama_tagihan)}
                                        </strong>

                                        <br>

                                        <small>
                                            ${escapeHtml(item.no_tagihan)}
                                        </small>
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            (item.nama_bulan || '') +
                                            ' ' +
                                            item.tahun
                                        )}

                                        <br>

                                        <small>
                                            ${escapeHtml(item.periode)}
                                        </small>
                                    </td>

                                    <td class="text-end">
                                        ${money(item.nominal_tagihan)}
                                    </td>

                                    <td class="text-end">
                                        ${money(item.nominal_dibayar)}
                                    </td>

                                    <td class="text-end fw-semibold">
                                        ${money(item.sisa_tagihan)}
                                    </td>
                                </tr>
                            `;
                        }
                    );
                }

                $('#tagihan').html(html);

                $('#all').prop(
                    'checked',
                    false
                );

                calc();
            },

            error: function (
                xhr,
                status,
                error
            ) {
                rows = [];

                $('#tagihan').html(`
                    <tr>
                        <td
                            colspan="6"
                            class="empty-state text-danger"
                        >
                            Data tagihan gagal dimuat.
                        </td>
                    </tr>
                `);

                calc();

                ajaxError(
                    xhr,
                    status,
                    error
                );
            }
        });
    }

    function calc() {
        let ids =
            $('.cek:checked')
                .map(
                    (_, item) =>
                        Number(
                            item.value
                        )
                )
                .get();

        let total =
            rows
                .filter(
                    item =>
                        ids.includes(
                            Number(item.id)
                        )
                )
                .reduce(
                    (total, item) =>
                        total +
                        Number(
                            item.sisa_tagihan
                        ),
                    0
                );

        $('#total').text(
            money(total)
        );

        $('#simpan').prop(
            'disabled',
            !ids.length ||
            !siswa
        );
    }

    function saveLetter() {
        if (!siswa) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih siswa terlebih dahulu.'
            });

            return;
        }

        let ids =
            $('.cek:checked')
                .map(
                    (_, item) =>
                        Number(
                            item.value
                        )
                )
                .get();

        if (!ids.length) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih minimal satu tagihan.'
            });

            return;
        }

        if (!$('#batasTahun').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih tahun terlebih dahulu.'
            });

            return;
        }

        var button = $('#simpan');

        $.ajax({
            url: '<?= base_url('tunggakan/surat_tunggakan/simpan'); ?>',
            type: 'POST',

            data: {
                id_siswa:
                    siswa.id,

                tagihan:
                    JSON.stringify(ids),

                tanggal_surat:
                    $('#tanggal').val(),

                batas_bulan:
                    $('#batasBulan').val(),

                batas_tahun:
                    $('#batasTahun').val(),

                nama_penandatangan:
                    $('#namaTtd').val(),

                jabatan_penandatangan:
                    $('#jabatanTtd').val(),

                catatan:
                    $('#catatan').val()
            },

            dataType: 'JSON',

            beforeSend: function () {
                button
                    .prop('disabled', true)
                    .html(
                        '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan'
                    );
            },

            success: function (data) {
                if (
                    data.result !==
                    'true'
                ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message
                    });

                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.message
                }).then(
                    function () {
                        window.open(
                            '<?= base_url('tunggakan/surat_tunggakan/cetak/'); ?>' +
                            data.id,
                            '_blank'
                        );
                    }
                );

                history();
            },

            error: function (
                xhr,
                status,
                error
            ) {
                ajaxError(
                    xhr,
                    status,
                    error
                );
            },

            complete: function () {
                button.html(
                    'Simpan & Preview Surat'
                );

                calc();
            }
        });
    }

    function history() {
        $.ajax({
            url: '<?= base_url('tunggakan/surat_tunggakan/riwayat'); ?>',
            type: 'POST',

            data: {},

            dataType: 'JSON',

            beforeSend: function () {
                $('#riwayat').html(`
                    <tr>
                        <td
                            colspan="7"
                            class="empty-state"
                        >
                            Memuat data...
                        </td>
                    </tr>
                `);

                $('#pagination-riwayat')
                    .empty();
            },

            success: function (data) {
                var dataRiwayat =
                    Array.isArray(data)
                        ? data
                        : [];

                var html = '';

                if (
                    dataRiwayat.length ==
                    0
                ) {
                    html += `
                        <tr class="data-riwayat-surat">
                            <td
                                colspan="7"
                                class="empty-state"
                            >
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                } else {
                    dataRiwayat.forEach(
                        function (item) {
                            html += `
                                <tr class="data-riwayat-surat">
                                    <td>
                                        <strong>
                                            ${escapeHtml(item.no_surat)}
                                        </strong>
                                    </td>

                                    <td>
                                        ${escapeHtml(item.tanggal_surat)}
                                    </td>

                                    <td>
                                        ${escapeHtml(item.nama_siswa)}

                                        <br>

                                        <small>
                                            ${escapeHtml(item.nis)}
                                        </small>
                                    </td>

                                    <td>
                                        ${escapeHtml(item.nama_kelas || '-')}
                                    </td>

                                    <td class="text-end fw-semibold">
                                        ${money(item.total_tunggakan)}
                                    </td>

                                    <td>
                                        ${escapeHtml(item.status_kirim_whatsapp)}
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <a
                                                target="_blank"
                                                href="<?= base_url('tunggakan/surat_tunggakan/cetak/'); ?>${Number(item.id)}"
                                                class="btn btn-sm btn-primary"
                                            >
                                                Preview/Cetak
                                            </a>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-success wa"
                                                data-json='${escapeHtml(JSON.stringify(item))}'
                                            >
                                                WhatsApp
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            `;
                        }
                    );
                }

                $('#riwayat').html(
                    html
                );

                let jumlah_awal =
                    parseInt(
                        $('#dt-length-riwayat')
                            .val()
                    );

                paging(
                    $('#riwayat .data-riwayat-surat'),
                    jumlah_awal,
                    '#pagination-riwayat'
                );
            },

            error: function (
                xhr,
                status,
                error
            ) {
                $('#riwayat').html(`
                    <tr>
                        <td
                            colspan="7"
                            class="empty-state text-danger"
                        >
                            Data riwayat surat gagal dimuat.
                        </td>
                    </tr>
                `);

                $('#pagination-riwayat')
                    .empty();

                ajaxError(
                    xhr,
                    status,
                    error
                );
            }
        });
    }

    /*
     * Pola paging mengikuti Beasiswa.
     * Parameter ketiga hanya untuk menentukan container pagination,
     * karena halaman Surat Tunggakan memiliki dua pagination.
     */
    function paging(
        $selector,
        jumlah_tampil = 10,
        pagination_selector = '#pagination'
    ) {
        window.tp = new Pagination(
            pagination_selector,
            {
                itemsCount: $selector.length,
                pageSize: parseInt(jumlah_tampil),

                onPageChange: function (paging) {
                    let start =
                        paging.pageSize *
                        (paging.currentPage - 1);

                    let end =
                        start +
                        paging.pageSize;

                    let $rows = $selector;

                    $rows.hide();

                    for (let i = start; i < end; i++) {
                        $rows.eq(i).show();
                    }
                }
            }
        );
    }

    function openWhatsapp(
        $button
    ) {
        let item =
            JSON.parse(
                $button.attr(
                    'data-json'
                )
            );

        let no =
            item.telepon_ayah ||
            item.telepon_ibu ||
            '';

        Swal.fire({
            title:
                'Kirim Surat WhatsApp',

            html: `
                <select
                    id="hub"
                    class="form-select mb-2"
                >
                    <option>Ayah</option>
                    <option>Ibu</option>
                    <option>Lainnya</option>
                </select>

                <input
                    id="nama"
                    class="form-control mb-2"
                    placeholder="Nama penerima"
                >

                <input
                    id="no"
                    class="form-control"
                    value="${escapeHtml(no)}"
                    placeholder="Nomor WhatsApp"
                >
            `,

            showCancelButton: true,

            confirmButtonText:
                'Buka WhatsApp',

            preConfirm: function () {
                return {
                    hubungan:
                        $('#hub').val(),

                    nama_penerima:
                        $('#nama').val(),

                    nomor:
                        $('#no').val()
                };
            }
        }).then(
            function (result) {
                if (
                    !result.isConfirmed
                ) {
                    return;
                }

                $.ajax({
                    url: '<?= base_url('tunggakan/surat_tunggakan/siapkan_whatsapp'); ?>',
                    type: 'POST',

                    data: {
                        id:
                            item.id,

                        hubungan:
                            result.value.hubungan,

                        nama_penerima:
                            result.value.nama_penerima,

                        nomor:
                            result.value.nomor
                    },

                    dataType:
                        'JSON',

                    success:
                        function (
                            data
                        ) {
                            if (
                                data.result ===
                                'true'
                            ) {
                                window.open(
                                    data.url,
                                    '_blank'
                                );

                                history();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: data.message
                                });
                            }
                        },

                    error:
                        function (
                            xhr,
                            status,
                            error
                        ) {
                            ajaxError(
                                xhr,
                                status,
                                error
                            );
                        }
                });
            }
        );
    }

    function loadPresetStudent(
        preset
    ) {
        $.ajax({
            url:
                '<?= base_url('tunggakan/surat_tunggakan/siswa/'); ?>' +
                encodeURIComponent(preset),

            type: 'GET',

            dataType: 'JSON',

            success:
                function (data) {
                    if (
                        data.result !==
                        'true'
                    ) {
                        return;
                    }

                    let button =
                        $(
                            '<button type="button" class="pilih d-none"></button>'
                        ).attr(
                            'data-json',
                            JSON.stringify(
                                data.siswa
                            )
                        );

                    $('#hasil').append(
                        button
                    );

                    button.trigger(
                        'click'
                    );
                },

            error:
                function (
                    xhr,
                    status,
                    error
                ) {
                    ajaxError(
                        xhr,
                        status,
                        error
                    );
                }
        });
    }
</script>