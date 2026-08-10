<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Audit Aktivitas Penting</h5>
        <a id="export" class="btn btn-success">Ekspor</a>
    </div>

    <div class="card-body">
        <div class="row g-2 align-items-end mb-2">
            <div class="col-md-2">
                <input
                    id="awal"
                    class="form-control tanggal-picker"
                    placeholder="Tanggal awal"
                    autocomplete="off">
            </div>

            <div class="col-md-2">
                <input
                    id="akhir"
                    class="form-control tanggal-picker"
                    placeholder="Tanggal akhir"
                    autocomplete="off">
            </div>

            <div class="col-md-2">
                <input
                    id="user"
                    class="form-control"
                    placeholder="Pengguna">
            </div>

            <div class="col-md-3">
                <select id="aksi" class="form-select">
                    <option value="">Semua Aktivitas</option>
                    <option>Tambah</option>
                    <option>Ubah</option>
                    <option>Batal</option>
                    <option>Cetak</option>
                    <option>Kirim</option>
                    <option>Import</option>
                    <option>Export</option>
                </select>
            </div>

            <div class="col-md-3">
                <select id="modul" class="form-select">
                    <option value="">Semua Menu</option>
                    <option>Master Data</option>
                    <option>Kesiswaan</option>
                    <option>Tagihan</option>
                    <option>Transaksi</option>
                    <option>Tunggakan</option>
                    <option>Laporan</option>
                    <option>Pengaturan</option>
                </select>
            </div>
        </div>

        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-10">
                <input
                    id="q"
                    class="form-control"
                    placeholder="Kata kunci / referensi">
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

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Pengguna</th>
                        <th>Aktivitas</th>
                        <th>Menu</th>
                        <th>Referensi</th>
                        <th>Ringkasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="data">
                    <tr class="data-log">
                        <td colspan="7">
                            <div class="empty-state">Memuat...</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3">
            <ul
                class="pagination pagination-sm pagination-boxed mb-0"
                id="pagination"></ul>

            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-0" class="mb-0">
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

<div class="modal fade" id="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Log</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="detail"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        flatpickr('.tanggal-picker', {
            dateFormat: 'd-m-Y',
            allowInput: true,
            disableMobile: true
        });

        log_aktivitas();

        $('#cari').click(function() {
            log_aktivitas();
        });

        $('#q, #user').keyup(function(event) {
            if (event.key === 'Enter') {
                log_aktivitas();
            }
        });

        $('#aksi, #modul').change(function() {
            log_aktivitas();
        });

        $('#dt-length-0').on('change', function() {
            const jumlah = parseInt($(this).val());

            paging(
                $('#data .data-log'),
                jumlah
            );
        });

        $('#export').click(function() {
            var params = filter();

            this.href =
                '<?= base_url('admin/pengaturan/log_aktivitas/export'); ?>?' +
                new URLSearchParams(params).toString();
        });

        $(document).on('click', '.detail', function() {
            var id = $(this).data('id');

            detail_log(id);
        });
    });

    function filter() {
        return {
            awal: $('#awal').val(),
            akhir: $('#akhir').val(),
            user: $('#user').val(),
            aksi: $('#aksi').val(),
            modul: $('#modul').val(),
            q: $('#q').val()
        };
    }

    function log_aktivitas() {
        var data_filter = filter();

        $('#data').html(`
        <tr class="data-log">
            <td colspan="7">
                <div class="empty-state">
                    Memuat...
                </div>
            </td>
        </tr>
    `);

        $.ajax({
            url: '<?= base_url('admin/pengaturan/log_aktivitas/result'); ?>',
            type: 'POST',
            data: {
                awal: data_filter.awal,
                akhir: data_filter.akhir,
                user: data_filter.user,
                aksi: data_filter.aksi,
                modul: data_filter.modul,
                q: data_filter.q
            },
            dataType: 'JSON',
            success: function(data) {
                var table = '';

                if (!Array.isArray(data) || data.length == 0) {
                    table += `
                    <tr class="data-log">
                        <td colspan="7">
                            <div class="empty-state">
                                Tidak ada log.
                            </div>
                        </td>
                    </tr>
                `;
                } else {
                    data.forEach(function(item) {
                        table += `
                        <tr class="data-log">
                            <td>
                                ${escapeHtml(item.tanggal || '-')}
                                <br>
                                <small>
                                    ${escapeHtml(item.waktu || '-')}
                                </small>
                            </td>

                            <td>
                                ${escapeHtml(item.nama_user || '-')}
                            </td>

                            <td>
                                <strong>
                                    ${escapeHtml(item.jenis_aktivitas || '-')}
                                </strong>
                                <br>
                                <small>
                                    ${escapeHtml(item.aksi || '-')}
                                </small>
                            </td>

                            <td>
                                ${escapeHtml(item.modul || '-')}
                            </td>

                            <td>
                                ${escapeHtml(item.nomor_referensi || '-')}
                            </td>

                            <td>
                                ${escapeHtml(item.keterangan || '-')}
                            </td>

                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary detail"
                                    data-id="${item.id}"
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>
                    `;
                    });
                }

                $('#data').html(table);

                let jumlah_awal = parseInt(
                    $('#dt-length-0').val()
                );

                paging(
                    $('#data .data-log'),
                    jumlah_awal
                );
            },
            error: function(xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function detail_log(id) {
        $('#detail').html(`
        <div class="empty-state">
            Memuat detail...
        </div>
    `);

        $.ajax({
            url: '<?= base_url('admin/pengaturan/log_aktivitas/detail'); ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(data) {
                function pretty(value) {
                    try {
                        return `
                        <pre class="bg-light p-3 rounded">${escapeHtml(
                            JSON.stringify(
                                JSON.parse(value),
                                null,
                                2
                            )
                        )}</pre>
                    `;
                    } catch (e) {
                        return `
                        <pre>${escapeHtml(value || '-')}</pre>
                    `;
                    }
                }

                $('#detail').html(`
                <div class="row g-3">
                    <div class="col-md-6">
                        <strong>
                            ${escapeHtml(data.jenis_aktivitas || '-')}
                        </strong>
                        <br>

                        ${escapeHtml(
                            (data.tanggal || '-') +
                            ' ' +
                            (data.waktu || '-')
                        )}
                        <br>

                        Pengguna:
                        ${escapeHtml(data.nama_user || '-')}
                        <br>

                        IP:
                        ${escapeHtml(data.ip_address || '-')}
                    </div>

                    <div class="col-md-6">
                        Menu:
                        ${escapeHtml(data.modul || '-')}
                        <br>

                        Aksi:
                        ${escapeHtml(data.aksi || '-')}
                        <br>

                        Referensi:
                        ${escapeHtml(data.nomor_referensi || '-')}
                    </div>
                </div>

                <hr>

                <p>
                    ${escapeHtml(data.keterangan || '-')}
                </p>

                <h6>Data Sebelum</h6>
                ${pretty(data.data_sebelum)}

                <h6>Data Sesudah</h6>
                ${pretty(data.data_sesudah)}

                <h6>Perangkat</h6>
                <small>
                    ${escapeHtml(data.user_agent || '-')}
                </small>
            `);

                bootstrap.Modal
                    .getOrCreateInstance(
                        document.getElementById('modal')
                    )
                    .show();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }
</script>