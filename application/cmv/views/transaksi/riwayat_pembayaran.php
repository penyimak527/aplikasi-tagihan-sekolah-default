<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Riwayat Pembayaran</h5>
        <a id="btnExport" class="btn btn-success">
            <i class="ti ti-file-spreadsheet"></i> Ekspor Excel
        </a>
    </div>

    <div class="card-body">
        <div class="row g-2 mb-3">
            <div class="col-lg-3">
                <input id="q" class="form-control" placeholder="No transaksi / nama / NIS">
            </div>

            <div class="col-lg-2">
                <input id="awal" class="form-control tanggal-picker"
                    placeholder="Tanggal awal dd-mm-yyyy" autocomplete="off">
            </div>

            <div class="col-lg-2">
                <input id="akhir" class="form-control tanggal-picker"
                    placeholder="Tanggal akhir dd-mm-yyyy" autocomplete="off">
            </div>

            <div class="col-lg-2">
                <select id="metode" class="form-select">
                    <option value="">Semua metode</option>
                    <?php foreach ($metode as $m): ?>
                        <option value="<?= $m['id'] ?>">
                            <?= html_escape($m['nama_metode']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-lg-2">
                <select id="filter_status_transaksi" class="form-select">
                    <option value="">Semua status</option>
                    <option>Aktif</option>
                    <option>Dibatalkan</option>
                </select>
            </div>

            <div class="col-lg-1 d-grid">
                <button type="button" id="cari" class="btn btn-primary">
                    <i class="ti ti-search"></i>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Metode</th>
                        <th class="text-end">Total</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="data"></tbody>
            </table>
        </div>

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination"></ul>

            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-0" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-0">
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
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="detailBody"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let rows = [];

    $(document).ready(function () {
        flatpickr('.tanggal-picker', {
            dateFormat: 'd-m-Y',
            allowInput: true,
            disableMobile: true
        });

        load();

        $('#cari').on('click', function () {
            load();
        });

        $('#q').on('keypress', function (e) {
            if (e.which === 13) {
                load();
            }
        });

        $('#dt-length-0').on('change', function () {
            const jumlah = parseInt($(this).val());

            paging(
                $('#data .data-riwayat-pembayaran'),
                jumlah
            );
        });

        $('#btnExport').on('click', function () {
            let p = new URLSearchParams(params());

            this.href =
                '<?= base_url('transaksi/riwayat_pembayaran/export'); ?>?' +
                p.toString();
        });

        $(document).on('click', '.detail', function () {
            detail($(this).data('id'));
        });

        $(document).on('click', '.batal', function () {
            batalkan($(this).data('id'));
        });
    });

    function params() {
        return {
            q: $('#q').val(),
            awal: $('#awal').val(),
            akhir: $('#akhir').val(),
            metode: $('#metode').val(),
            status: $('#filter_status_transaksi').val()
        };
    }

    function load() {
        var button = $('#cari');

        $.ajax({
            url: '<?= base_url('transaksi/riwayat_pembayaran/result'); ?>',
            type: 'POST',
            data: params(),
            dataType: 'JSON',

            beforeSend: function () {
                button.prop('disabled', true);
                button.html(
                    '<span class="spinner-border spinner-border-sm"></span>'
                );

                $('#data').html(`
                    <tr>
                        <td colspan="9" class="empty-state">
                            Memuat data...
                        </td>
                    </tr>
                `);

                $('#pagination').empty();
            },

            success: function (data) {
                rows = Array.isArray(data) ? data : [];

                var table = '';

                if (rows.length == 0) {
                    table += `
                        <tr class="data-riwayat-pembayaran">
                            <td colspan="9" class="empty-state">
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                } else {
                    rows.forEach(function (item) {
                        var statusClass =
                            item.status_transaksi === 'Aktif'
                                ? 'success'
                                : 'danger';

                        table += `
                            <tr class="data-riwayat-pembayaran">
                                <td>
                                    <strong>
                                        ${escapeHtml(item.no_transaksi || '-')}
                                    </strong>
                                    <br>
                                    <small>
                                        ${escapeHtml(item.waktu_transaksi || '-')}
                                    </small>
                                </td>

                                <td>
                                    ${escapeHtml(item.tanggal_transaksi || '-')}
                                </td>

                                <td>
                                    ${escapeHtml(item.nama_siswa || '-')}
                                    <br>
                                    <small>
                                        ${escapeHtml(item.nis || '-')}
                                    </small>
                                </td>

                                <td>
                                    ${escapeHtml(item.nama_kelas || '-')}
                                </td>

                                <td>
                                    ${escapeHtml(item.nama_metode_pembayaran || '-')}
                                </td>

                                <td class="text-end fw-semibold">
                                    ${formatRupiah(item.total_pembayaran)}
                                </td>

                                <td>
                                    ${escapeHtml(item.nama_user || '-')}
                                </td>

                                <td>
                                    <span
                                        class="badge bg-${statusClass}-subtle text-${statusClass}">
                                        ${escapeHtml(item.status_transaksi || '-')}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary detail"
                                            data-id="${Number(item.id)}">
                                            Detail
                                        </button>

                                        <a
                                            target="_blank"
                                            href="<?= base_url('transaksi/pembayaran/bukti/'); ?>${Number(item.id)}"
                                            class="btn btn-sm btn-secondary">
                                            Cetak
                                        </a>

                                        ${
                                            item.status_transaksi === 'Aktif'
                                                ? `
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-danger batal"
                                                        data-id="${Number(item.id)}">
                                                        Batalkan
                                                    </button>
                                                `
                                                : ''
                                        }
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }

                $('#data').html(table);

                let jumlah_awal = parseInt($('#dt-length-0').val());

                paging(
                    $('#data .data-riwayat-pembayaran'),
                    jumlah_awal
                );
            },

            error: function (xhr, status, error) {
                $('#data').html(`
                    <tr>
                        <td colspan="9" class="empty-state text-danger">
                            Data riwayat pembayaran gagal dimuat.
                        </td>
                    </tr>
                `);

                $('#pagination').empty();

                ajaxError(xhr, status, error);
            },

            complete: function () {
                button.prop('disabled', false);
                button.html('<i class="ti ti-search"></i>');
            }
        });
    }

    /*
     * Pagination mengikuti pola view Beasiswa:
     * tetap menggunakan Pagination JS yang sudah dipakai aplikasi.
     */
    function paging($selector, jumlah_tampil = 10) {

        window.tp = new Pagination('#pagination', {
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
        });
    }

    function detail(id) {
        $.ajax({
            url: '<?= base_url('transaksi/riwayat_pembayaran/detail'); ?>',
            type: 'POST',

            data: {
                id: id
            },

            dataType: 'JSON',

            beforeSend: function () {
                $('#detailBody').html(`
                    <div class="text-center py-4">
                        <span class="spinner-border spinner-border-sm me-1"></span>
                        Memuat detail transaksi...
                    </div>
                `);
            },

            success: function (data) {
                if (data.result !== 'true') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text:
                            data.message ||
                            'Detail transaksi gagal dimuat.'
                    });

                    return;
                }

                var header = data.header;
                var detailRows =
                    Array.isArray(data.detail)
                        ? data.detail
                        : [];

                var html = `
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>
                                ${escapeHtml(header.no_transaksi || '-')}
                            </strong>
                            <br>

                            ${escapeHtml(
                                (header.tanggal_transaksi || '-') +
                                ' ' +
                                (header.waktu_transaksi || '')
                            )}

                            <br>

                            ${escapeHtml(header.nama_siswa || '-')}
                            (${escapeHtml(header.nis || '-')})
                        </div>

                        <div class="col-md-6 text-md-end">
                            ${escapeHtml(header.nama_kelas || '-')}
                            <br>

                            ${escapeHtml(
                                header.nama_metode_pembayaran || '-'
                            )}

                            <br>

                            <strong>
                                ${formatRupiah(header.total_pembayaran)}
                            </strong>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tagihan</th>
                                    <th>Periode</th>
                                    <th class="text-end">Sisa Sebelum</th>
                                    <th class="text-end">Bayar</th>
                                    <th class="text-end">Sisa Setelah</th>
                                </tr>
                            </thead>

                            <tbody>
                `;

                if (detailRows.length == 0) {
                    html += `
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                } else {
                    detailRows.forEach(function (item) {
                        html += `
                            <tr>
                                <td>
                                    ${escapeHtml(item.nama_tagihan || '-')}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        (item.nama_bulan || '') +
                                        ' ' +
                                        (item.tahun || '')
                                    )}
                                </td>

                                <td class="text-end">
                                    ${formatRupiah(item.sisa_sebelum)}
                                </td>

                                <td class="text-end">
                                    ${formatRupiah(item.nominal_bayar)}
                                </td>

                                <td class="text-end">
                                    ${formatRupiah(item.sisa_setelah)}
                                </td>
                            </tr>
                        `;
                    });
                }

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                if (data.pembatalan) {
                    html += `
                        <div class="alert alert-danger">
                            <strong>
                                Dibatalkan oleh
                                ${escapeHtml(
                                    data.pembatalan.nama_user_pembatalan || '-'
                                )}
                            </strong>

                            <br>

                            ${escapeHtml(
                                (data.pembatalan.tanggal_pembatalan || '-') +
                                ' ' +
                                (data.pembatalan.waktu_pembatalan || '')
                            )}

                            <br>

                            Alasan:
                            ${escapeHtml(
                                data.pembatalan.alasan_pembatalan || '-'
                            )}
                        </div>
                    `;
                }

                $('#detailBody').html(html);

                bootstrap.Modal
                    .getOrCreateInstance(
                        document.getElementById('modalDetail')
                    )
                    .show();
            },

            error: function (xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }

    function batalkan(id) {
        Swal.fire({
            title: 'Batalkan transaksi?',
            text:
                'Saldo setiap tagihan akan dikembalikan. ' +
                'Data transaksi tidak dihapus.',
            input: 'textarea',
            inputLabel: 'Alasan wajib',
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi Batalkan',
            confirmButtonColor: '#dc3545',

            preConfirm: function (value) {
                if (!$.trim(value)) {
                    Swal.showValidationMessage(
                        'Alasan wajib diisi'
                    );
                }

                return value;
            }
        }).then(function (result) {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: '<?= base_url('transaksi/riwayat_pembayaran/batalkan'); ?>',
                type: 'POST',

                data: {
                    id: id,
                    alasan: result.value
                },

                dataType: 'JSON',

                success: function (data) {
                    if (data.result === 'true') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text:
                                data.message ||
                                'Transaksi berhasil dibatalkan.'
                        });

                        load();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text:
                                data.message ||
                                'Transaksi gagal dibatalkan.'
                        });
                    }
                },

                error: function (xhr, status, error) {
                    ajaxError(xhr, status, error);
                }
            });
        });
    }
</script>