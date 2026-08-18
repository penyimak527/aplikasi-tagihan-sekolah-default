<?php
$nama_bulan_lokal = function ($bulan) {
    $list = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
    return isset($list[(int) $bulan]) ? $list[(int) $bulan] : '-';
};
?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Cari dan Tinjau Tagihan Siswa</h5>
    </div>

    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-md-10">
                <input
                    id="q"
                    class="form-control"
                    placeholder="Nama / NIS / NISN">
            </div>

            <div class="col-md-2 d-grid">
                <button
                    type="button"
                    id="cari"
                    class="btn btn-primary">
                    <i class="ti ti-search me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="hasil" class="mt-3"></div>

        <div
            id="pagination_siswa_area"
            class="d-none flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
            <ul
                class="pagination pagination-sm pagination-boxed mb-0"
                id="pagination-siswa"></ul>

            <div class="d-flex align-items-center gap-2">
                <label
                    for="dt-length-siswa"
                    class="mb-0">
                    Tampilkan
                </label>

                <select
                    class="form-select form-select-sm"
                    id="dt-length-siswa">
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
            class="alert alert-primary mt-3 d-none"></div>

        <div
            id="filter"
            class="row g-2 mt-1 d-none">
            <div class="col-md-3">
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
                <select id="tipe" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option>Bulanan</option>
                    <option>Langsung</option>
                    <option>Tahunan</option>
                </select>
            </div>

            <div class="col-md-3">
                <select
                    id="filter_status_tagihan_siswa"
                    class="form-select">
                    <option value="">Semua Status</option>
                    <option>Belum Dibayar</option>
                    <option>Dibayar Sebagian</option>
                    <option>Lunas</option>
                    <option>Dibebaskan</option>
                    <option>Dibatalkan</option>
                </select>
            </div>

            <div class="col-md-2">
                <select id="bulan" class="form-select">
                    <option value="">Semua Bulan</option>

                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>">
                            <?= $nama_bulan_lokal($i) ?>
                        </option>
                    <?php endfor ?>
                </select>
            </div>

            <div class="col-md-1 d-grid">
                <button
                    type="button"
                    id="tampil"
                    class="btn btn-primary">
                    <i class="ti ti-filter"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div
    id="summary"
    class="row g-3 d-none mb-3">
    <div class="col-md-4">
        <div class="card summary-card">
            <div class="card-body">
                <small>Total Tagihan Wajib</small>
                <div
                    id="swajib"
                    class="summary-value"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card summary-card">
            <div class="card-body">
                <small>Total Dibayar</small>
                <div
                    id="sdibayar"
                    class="summary-value text-success"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card summary-card">
            <div class="card-body">
                <small>Total Tunggakan</small>
                <div
                    id="stunggakan"
                    class="summary-value text-danger"></div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5 class="mb-0">Daftar Tagihan</h5>

        <div class="action-buttons">
            <a
                id="bayar"
                class="btn btn-success disabled">
                <i class="ti ti-cash"></i>
                Bayar Tagihan
            </a>

            <button
                type="button"
                id="btnCetak"
                class="btn btn-secondary no-print"
                disabled>
                <i class="ti ti-printer"></i>
                Cetak Rekap
            </button>

            <a
                id="surat"
                class="btn btn-warning disabled">
                <i class="ti ti-mail"></i>
                Buat Surat
            </a>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Tagihan</th>
                        <th>Periode</th>
                        <th>Wajib</th>
                        <th class="text-end">Nominal</th>
                        <th class="text-end">Dibayar</th>
                        <th class="text-end">Sisa</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="data">
                    <tr>
                        <td colspan="7" class="empty-state">
                            Pilih siswa.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            id="pagination_tagihan_area"
            class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
            <ul
                class="pagination pagination-sm pagination-boxed mb-0"
                id="pagination-tagihan"></ul>

            <div class="d-flex align-items-center gap-2">
                <label
                    for="dt-length-tagihan"
                    class="mb-0">
                    Tampilkan
                </label>

                <select
                    class="form-select form-select-sm"
                    id="dt-length-tagihan">
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
 * Tetap menggunakan Pagination JS.
 * Fallback hanya untuk memastikan arrow bawaan terlihat
 * apabila Font Awesome tidak termuat.
 */
    #pagination-siswa .fa-angle-double-left::before,
    #pagination-tagihan .fa-angle-double-left::before {
        content: "\00AB" !important;
        font-family: Arial, sans-serif !important;
    }

    #pagination-siswa .fa-angle-left::before,
    #pagination-tagihan .fa-angle-left::before {
        content: "\2039" !important;
        font-family: Arial, sans-serif !important;
    }

    #pagination-siswa .fa-angle-right::before,
    #pagination-tagihan .fa-angle-right::before {
        content: "\203A" !important;
        font-family: Arial, sans-serif !important;
    }

    #pagination-siswa .fa-angle-double-right::before,
    #pagination-tagihan .fa-angle-double-right::before {
        content: "\00BB" !important;
        font-family: Arial, sans-serif !important;
    }

    #pagination-siswa .page-link i,
    #pagination-tagihan .page-link i {
        font-style: normal;
    }
</style>

<script>
    let id = 0;

    const money = n =>
        'Rp' +
        Number(n || 0)
        .toLocaleString('id-ID');

    $(document).ready(function() {
        $('#cari').on('click', function() {
            search();
        });

        $('#q').on('keypress', function(event) {
            if (event.which === 13) {
                search();
            }
        });

        $('#tampil').on('click', function() {
            load();
        });

        $('#btnCetak').on('click', function() {
            cetakData();
        });

        $('#dt-length-siswa').on('change', function() {
            const jumlah = parseInt(
                $(this).val()
            );

            paging(
                $('#hasil .data-siswa-tagihan'),
                jumlah,
                '#pagination-siswa'
            );
        });

        $('#dt-length-tagihan').on('change', function() {
            const jumlah = parseInt(
                $(this).val()
            );

            paging(
                $('#data .data-tagihan-siswa'),
                jumlah,
                '#pagination-tagihan'
            );
        });

        $(document).on(
            'click',
            '.pilih',
            function() {
                id = $(this).data('id');

                /*
                 * Setelah siswa dipilih:
                 * hasil pencarian dan pagination siswa dihilangkan.
                 */
                $('#hasil').empty();

                $('#pagination-siswa')
                    .empty();

                $('#pagination_siswa_area')
                    .addClass('d-none')
                    .removeClass('d-flex');

                $('#identitas')
                    .removeClass('d-none')
                    .html(`
                        <strong>
                            ${escapeHtml($(this).data('name'))}
                        </strong>
                        <br>
                        ${escapeHtml($(this).data('info'))}
                    `);

                $('#filter, #summary')
                    .removeClass('d-none');

                $('#bayar')
                    .removeClass('disabled')
                    .attr(
                        'href',
                        '<?= base_url('admin/transaksi/pembayaran'); ?>?siswa=' +
                        id
                    );

                $('#surat')
                    .removeClass('disabled')
                    .attr(
                        'href',
                        '<?= base_url('admin/tunggakan/surat_tunggakan'); ?>?siswa=' +
                        id
                    );

                $('#btnCetak')
                    .prop('disabled', false);

                load();
            }
        );
    });

    function search() {
        const q =
            $.trim(
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

        var button =
            $('#cari');

        $.ajax({
            url: '<?= base_url('admin/tunggakan/tagihan_per_siswa/cari_siswa'); ?>',
            type: 'POST',

            data: {
                q: q
            },

            dataType: 'JSON',

            beforeSend: function() {
                button
                    .prop('disabled', true)
                    .html(
                        '<span class="spinner-border spinner-border-sm me-1"></span>Mencari'
                    );

                $('#hasil').html(`
                    <div class="data-siswa-tagihan">
                        <div class="empty-state">
                            Memuat data...
                        </div>
                    </div>
                `);

                $('#pagination-siswa')
                    .empty();

                $('#pagination_siswa_area')
                    .removeClass('d-none')
                    .addClass('d-flex');
            },

            success: function(data) {
                var rows =
                    Array.isArray(data) ?
                    data :
                    [];

                var html = '';

                if (rows.length == 0) {
                    html += `
                        <div class="data-siswa-tagihan">
                            <div class="alert alert-warning mb-0">
                                Tidak ada data
                            </div>
                        </div>
                    `;
                } else {
                    html +=
                        '<div class="list-group">';

                    rows.forEach(
                        function(row) {
                            const info =
                                (row.nis || '-') +
                                ' | ' +
                                (row.nama_kelas || '-') +
                                ' | ' +
                                (row.status_pendaftaran || '-');

                            const subInfo =
                                (row.nis || '-') +
                                ' | ' +
                                (row.nisn || '-') +
                                ' | ' +
                                (row.nama_kelas || '-');

                            html += `
                                <button
                                    type="button"
                                    class="list-group-item list-group-item-action pilih data-siswa-tagihan"
                                    data-id="${Number(row.id)}"
                                    data-name="${escapeHtml(row.nama_lengkap || '-')}"
                                    data-info="${escapeHtml(info)}"
                                >
                                    <strong>
                                        ${escapeHtml(row.nama_lengkap || '-')}
                                    </strong>

                                    <br>

                                    <small>
                                        ${escapeHtml(subInfo)}
                                    </small>
                                </button>
                            `;
                        }
                    );

                    html +=
                        '</div>';
                }

                $('#hasil')
                    .html(html);

                /*
                 * Selama siswa belum dipilih,
                 * pagination hasil pencarian tetap tampil.
                 */
                $('#pagination_siswa_area')
                    .removeClass('d-none')
                    .addClass('d-flex');

                let jumlah_awal =
                    parseInt(
                        $('#dt-length-siswa')
                        .val()
                    );

                paging(
                    $('#hasil .data-siswa-tagihan'),
                    jumlah_awal,
                    '#pagination-siswa'
                );
            },

            error: function(
                xhr,
                status,
                error
            ) {
                $('#hasil').html(`
                    <div class="alert alert-danger mb-0">
                        Data siswa gagal dimuat.
                    </div>
                `);

                $('#pagination-siswa')
                    .empty();

                ajaxError(
                    xhr,
                    status,
                    error
                );
            },

            complete: function() {
                button
                    .prop('disabled', false)
                    .html(
                        '<i class="ti ti-search me-1"></i>Cari'
                    );
            }
        });
    }

    function load() {
        if (!id) {
            return;
        }

        var button =
            $('#tampil');

        $.ajax({
            url: '<?= base_url('admin/tunggakan/tagihan_per_siswa/result'); ?>',
            type: 'POST',

            data: {
                id_siswa: id,

                id_periode: $('#periode').val(),

                tipe: $('#tipe').val(),

                status: $('#filter_status_tagihan_siswa')
                    .val(),

                sampai_bulan: $('#bulan').val()
            },

            dataType: 'JSON',

            beforeSend: function() {
                button
                    .prop('disabled', true)
                    .html(
                        '<span class="spinner-border spinner-border-sm"></span>'
                    );

                $('#data').html(`
                    <tr>
                        <td
                            colspan="7"
                            class="empty-state"
                        >
                            Memuat data...
                        </td>
                    </tr>
                `);

                $('#pagination-tagihan')
                    .empty();
            },

            success: function(response) {
                if (
                    response.result !==
                    'true'
                ) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message ||
                            'Data gagal dimuat.'
                    });

                    $('#data').html(`
                        <tr class="data-tagihan-siswa">
                            <td
                                colspan="7"
                                class="empty-state"
                            >
                                Tidak ada data
                            </td>
                        </tr>
                    `);

                    paging(
                        $('#data .data-tagihan-siswa'),
                        parseInt(
                            $('#dt-length-tagihan')
                            .val()
                        ),
                        '#pagination-tagihan'
                    );

                    return;
                }

                var summary =
                    response.summary || {};

                $('#swajib').text(
                    money(
                        summary.wajib || 0
                    )
                );

                $('#sdibayar').text(
                    money(
                        summary.dibayar || 0
                    )
                );

                $('#stunggakan').text(
                    money(
                        summary.tunggakan || 0
                    )
                );

                var rows =
                    Array.isArray(
                        response.rows
                    ) ?
                    response.rows :
                    [];

                var html = '';

                if (rows.length == 0) {
                    html += `
                        <tr class="data-tagihan-siswa">
                            <td
                                colspan="7"
                                class="empty-state"
                            >
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                } else {
                    rows.forEach(
                        function(row) {
                            const wajib =
                                row.dianggap_tunggakan === 'Ya' ?
                                '<span class="badge bg-warning-subtle text-warning">Ya</span>' :
                                '<span class="badge bg-info-subtle text-info">Tidak</span>';

                            var status =
                                row.status_pembayaran || '-';

                            var statusClass =
                                'secondary';

                            if (
                                status === 'Lunas'
                            ) {
                                statusClass =
                                    'success';
                            } else if (
                                status ===
                                'Dibayar Sebagian'
                            ) {
                                statusClass =
                                    'warning';
                            } else if (
                                status ===
                                'Belum Dibayar'
                            ) {
                                statusClass =
                                    'danger';
                            } else if (
                                status ===
                                'Dibebaskan'
                            ) {
                                statusClass =
                                    'info';
                            }

                            html += `
                                <tr class="data-tagihan-siswa">
                                    <td>
                                        <strong>
                                            ${escapeHtml(row.nama_tagihan || '-')}
                                        </strong>

                                        <br>

                                        <small>
                                            ${escapeHtml(row.no_tagihan || '-')}
                                        </small>
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            (row.nama_bulan || '') +
                                            ' ' +
                                            (row.tahun || '')
                                        )}

                                        <br>

                                        <small>
                                            ${escapeHtml(row.periode || '-')}
                                        </small>
                                    </td>

                                    <td>
                                        ${wajib}
                                    </td>

                                    <td class="text-end">
                                        ${money(row.nominal_tagihan)}
                                    </td>

                                    <td class="text-end">
                                        ${money(row.nominal_dibayar)}
                                    </td>

                                    <td class="text-end fw-semibold">
                                        ${money(row.sisa_tagihan)}
                                    </td>

                                    <td>
                                        <span
                                            class="badge bg-${statusClass}-subtle text-${statusClass}"
                                        >
                                            ${escapeHtml(status)}
                                        </span>
                                    </td>
                                </tr>
                            `;
                        }
                    );
                }

                $('#data')
                    .html(html);

                let jumlah_awal =
                    parseInt(
                        $('#dt-length-tagihan')
                        .val()
                    );

                paging(
                    $('#data .data-tagihan-siswa'),
                    jumlah_awal,
                    '#pagination-tagihan'
                );
            },

            error: function(
                xhr,
                status,
                error
            ) {
                $('#data').html(`
                    <tr>
                        <td
                            colspan="7"
                            class="empty-state text-danger"
                        >
                            Data tagihan siswa gagal dimuat.
                        </td>
                    </tr>
                `);

                $('#pagination-tagihan')
                    .empty();

                ajaxError(
                    xhr,
                    status,
                    error
                );
            },

            complete: function() {
                button
                    .prop('disabled', false)
                    .html(
                        '<i class="ti ti-filter"></i>'
                    );
            }
        });
    }

    function cetakData() {
        if (!id) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih siswa terlebih dahulu.'
            });
            return;
        }

        var params = new URLSearchParams({
            id_siswa: id,
            id_periode: $('#periode').val() || '',
            tipe: $('#tipe').val() || '',
            status: $('#filter_status_tagihan_siswa').val() || '',
            sampai_bulan: $('#bulan').val() || ''
        });

        window.open(
            '<?= base_url('admin/tunggakan/tagihan_per_siswa/cetak'); ?>?' + params.toString(),
            '_blank'
        );
    }

    /*
     * Pola paging mengikuti Beasiswa.
     * Parameter ketiga digunakan karena halaman ini
     * memiliki pagination pencarian siswa dan daftar tagihan.
     */
    function paging(
        $selector,
        jumlah_tampil = 10,
        pagination_selector = '#pagination'
    ) {
        window.tp =
            new Pagination(
                pagination_selector, {
                    itemsCount: $selector.length,

                    pageSize: parseInt(
                        jumlah_tampil
                    ),

                    onPageChange: function(paging) {
                        let start =
                            paging.pageSize *
                            (
                                paging.currentPage -
                                1
                            );

                        let end =
                            start +
                            paging.pageSize;

                        let $rows =
                            $selector;

                        $rows.hide();

                        for (
                            let i = start; i < end; i++
                        ) {
                            $rows
                                .eq(i)
                                .show();
                        }
                    }
                }
            );
    }
</script>