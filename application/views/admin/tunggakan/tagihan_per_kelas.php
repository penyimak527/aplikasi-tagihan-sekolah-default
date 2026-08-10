<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Filter Tagihan Per Kelas</h5>
    </div>

    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3">
                <select id="periode" class="form-select">
                    <option value="">Tahun Ajaran</option>

                    <?php foreach ($periode as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= html_escape($p['periode']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-3">
                <select id="kelas" class="form-select">
                    <option value="">Semua Kelas</option>

                    <?php foreach ($kelas as $k): ?>
                        <option
                            value="<?= $k['id'] ?>"
                            data-period="<?= $k['id_periode'] ?>">
                            <?= html_escape($k['nama_kelas'] . ' - ' . $k['semester']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-3">
                <select id="bulan" class="form-select">
                    <option value="">Sampai Semua Bulan</option>

                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>">
                            Sampai <?= nama_bulan($i) ?>
                        </option>
                    <?php endfor ?>
                </select>
            </div>

            <div class="col-md-3 d-grid">
                <button
                    type="button"
                    id="tampil"
                    class="btn btn-primary">
                    Tampilkan
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Ringkasan Siswa</h5>

        <div>
            <button
                type="button"
                onclick="window.print()"
                class="btn btn-secondary no-print">
                Cetak
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th class="text-end">Total Wajib</th>
                        <th class="text-end">Dibayar</th>
                        <th class="text-end">Tunggakan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="data">
                    <tr>
                        <td colspan="7" class="empty-state">
                            Pilih filter.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
            <ul
                class="pagination pagination-sm pagination-boxed mb-0"
                id="pagination"></ul>

            <div class="d-flex align-items-center gap-2">
                <label
                    for="dt-length-0"
                    class="mb-0">
                    Tampilkan
                </label>

                <select
                    class="form-select form-select-sm"
                    id="dt-length-0">
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

<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Detail Tagihan Siswa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="detail"></div>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
                    <ul class="pagination pagination-sm pagination-boxed mb-0"  id="pagination-detail"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-detail" class="mb-0"> Tampilkan </label>
                        <select
                            class="form-select form-select-sm"
                            id="dt-length-detail">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>entri</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-light"
                    data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /*
 * Pagination tetap memakai Pagination JS.
 * Fallback berikut hanya memastikan icon panah bawaan pagination.js
 * tetap terlihat bila Font Awesome tidak termuat pada template.
 */
    #pagination .fa-angle-double-left::before,
    #pagination-detail .fa-angle-double-left::before {
        content: "\00AB" !important;
        font-family: Arial, sans-serif !important;
    }

    #pagination .fa-angle-left::before,
    #pagination-detail .fa-angle-left::before {
        content: "\2039" !important;
        font-family: Arial, sans-serif !important;
    }

    #pagination .fa-angle-right::before,
    #pagination-detail .fa-angle-right::before {
        content: "\203A" !important;
        font-family: Arial, sans-serif !important;
    }

    #pagination .fa-angle-double-right::before,
    #pagination-detail .fa-angle-double-right::before {
        content: "\00BB" !important;
        font-family: Arial, sans-serif !important;
    }

    #pagination .page-link i,
    #pagination-detail .page-link i {
        font-style: normal;
    }
</style>

<script>
    const money = n =>
        'Rp' +
        Number(n || 0)
        .toLocaleString('id-ID');

    $(document).ready(function() {
        $('#tampil').on('click', function() {
            load();
        });

        $('#periode').on('change', function() {
            let periode = this.value;

            $('#kelas option').each(function() {
                $(this).toggle(
                    !this.value ||
                    !periode ||
                    String($(this).data('period')) ===
                    String(periode)
                );
            });

            $('#kelas').val('');
        });

        $('#dt-length-0').on('change', function() {
            const jumlah = parseInt(
                $(this).val()
            );

            paging(
                $('#data .data-tagihan-kelas'),
                jumlah,
                '#pagination'
            );
        });

        $('#dt-length-detail').on('change', function() {
            const jumlah = parseInt(
                $(this).val()
            );

            paging(
                $('#detail .data-detail-tagihan'),
                jumlah,
                '#pagination-detail'
            );
        });

        $(document).on(
            'click',
            '.detail',
            function() {
                detail(
                    $(this).data('id')
                );
            }
        );
    });

    function load() {
        var button = $('#tampil');

        $.ajax({
            url: '<?= base_url('admin/tunggakan/tagihan_per_kelas/result'); ?>',
            type: 'POST',

            data: {
                id_periode: $('#periode').val(),

                id_kelas_setting: $('#kelas').val(),

                sampai_bulan: $('#bulan').val()
            },

            dataType: 'JSON',

            beforeSend: function() {
                button
                    .prop('disabled', true)
                    .html(
                        '<span class="spinner-border spinner-border-sm me-1"></span>Memuat'
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

                $('#pagination').empty();
            },

            success: function(data) {
                var rows =
                    Array.isArray(data) ?
                    data :
                    [];

                var table = '';

                if (rows.length == 0) {
                    table += `
                        <tr class="data-tagihan-kelas">
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
                        function(item) {
                            var tunggakan =
                                Number(
                                    item.tunggakan || 0
                                );

                            var statusClass =
                                item.status === 'Lunas' ?
                                'success' :
                                'warning';

                            table += `
                                <tr class="data-tagihan-kelas">
                                    <td>
                                        <strong>
                                            ${escapeHtml(item.nama_siswa || '-')}
                                        </strong>

                                        <br>

                                        <small>
                                            ${escapeHtml(item.nis || '-')}
                                        </small>
                                    </td>

                                    <td>
                                        ${escapeHtml(item.nama_kelas || '-')}
                                    </td>

                                    <td class="text-end">
                                        ${money(item.total_wajib)}
                                    </td>

                                    <td class="text-end">
                                        ${money(item.dibayar)}
                                    </td>

                                    <td
                                        class="text-end fw-semibold text-${tunggakan > 0 ? 'danger' : 'success'}"
                                    >
                                        ${money(tunggakan)}
                                    </td>

                                    <td>
                                        <span
                                            class="badge bg-${statusClass}-subtle text-${statusClass}"
                                        >
                                            ${escapeHtml(item.status || '-')}
                                        </span>
                                    </td>

                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary detail"
                                            data-id="${Number(item.id_siswa)}"
                                        >
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                            `;
                        }
                    );
                }

                $('#data').html(
                    table
                );

                let jumlah_awal =
                    parseInt(
                        $('#dt-length-0')
                        .val()
                    );

                paging(
                    $('#data .data-tagihan-kelas'),
                    jumlah_awal,
                    '#pagination'
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
                            Data tagihan per kelas gagal dimuat.
                        </td>
                    </tr>
                `);

                $('#pagination')
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
                    .html('Tampilkan');
            }
        });
    }

    function detail(id_siswa) {
        var modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetail') );
        modal.show();
        $.ajax({
            url: '<?= base_url('admin/tunggakan/tagihan_per_kelas/detail'); ?>',
            type: 'POST',
            data: {
                id_siswa: id_siswa,
                id_periode: $('#periode').val()
            },

            dataType: 'JSON',
            beforeSend: function() {
                $('#detail').html(`
                    <div class="text-center py-4">
                        <span class="spinner-border spinner-border-sm me-1"></span>
                        Memuat detail tagihan...
                    </div>
                `);
                $('#pagination-detail').empty();
            },
            success: function(data) {
                var rows =
                    Array.isArray(data) ?
                    data :
                    [];

                var table = `
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Tagihan</th>
                                    <th>Periode</th>
                                    <th class="text-end">
                                        Nominal
                                    </th>
                                    <th class="text-end">
                                        Dibayar
                                    </th>
                                    <th class="text-end">
                                        Sisa
                                    </th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>
                `;

                if (rows.length == 0) {
                    table += `
                        <tr class="data-detail-tagihan">
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
                        function(item) {
                            table += `
                                <tr class="data-detail-tagihan">
                                    <td>
                                        <strong>
                                            ${escapeHtml(item.nama_tagihan || '-')}
                                        </strong>
                                    </td>

                                    <td>
                                        ${escapeHtml(
                                            (item.nama_bulan || '') +
                                            ' ' +
                                            (item.tahun || '')
                                        )}
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

                                    <td>
                                        ${escapeHtml(item.status_pembayaran || '-')}
                                    </td>
                                </tr>
                            `;
                        }
                    );
                }

                table += `
                            </tbody>
                        </table>
                    </div>
                `;

                $('#detail').html(
                    table
                );

                let jumlah_awal =
                    parseInt(
                        $('#dt-length-detail')
                        .val()
                    );

                paging(
                    $('#detail .data-detail-tagihan'),
                    jumlah_awal,
                    '#pagination-detail'
                );
            },

            error: function(
                xhr,
                status,
                error
            ) {
                $('#detail').html(`
                    <div class="empty-state text-danger py-4">
                        Detail tagihan gagal dimuat.
                    </div>
                `);

                $('#pagination-detail')
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
     * Parameter ketiga dipakai karena halaman ini
     * memiliki pagination utama dan pagination detail.
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