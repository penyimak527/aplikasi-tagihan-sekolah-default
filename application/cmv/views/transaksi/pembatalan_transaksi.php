<div class="card">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title">Pembatalan Transaksi</h4>
            <p class="text-muted mb-0">Cari transaksi aktif yang akan dibatalkan. Transaksi tidak dihapus dan saldo tagihan dikembalikan.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label" for="filter_q">Nomor Transaksi / Nama Siswa</label>
                <input type="text" id="filter_q" class="form-control" placeholder="Cari nomor transaksi atau siswa">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="filter_awal">Tanggal Awal</label>
                <input type="text" id="filter_awal" class="form-control tanggal" placeholder="dd-mm-yyyy">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="filter_akhir">Tanggal Akhir</label>
                <input type="text" id="filter_akhir" class="form-control tanggal" placeholder="dd-mm-yyyy">
            </div>
            <div class="col-md-2">
                <label class="form-label" for="filter_metode">Metode</label>
                <select id="filter_metode" class="form-select">
                    <option value="">Semua Metode</option>
                    <?php foreach ($metode as $row): ?>
                        <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_metode']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" id="btn_tampil">
                    <i class="ri-search-line me-1"></i>Tampilkan
                </button>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nomor / Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Metode</th>
                        <th class="text-end">Total</th>
                        <th>Petugas</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody id="data_transaksi"></tbody>
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

<div class="modal fade" id="modal_detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="isi_detail"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_batal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Batalkan Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_pembayaran_batal">
                <div class="alert alert-warning">
                    Pembayaran akan dikembalikan ke sisa setiap tagihan. Proses ini tidak menghapus transaksi asli.
                </div>
                <label class="form-label" for="alasan_batal">Alasan Pembatalan <span class="text-danger">*</span></label>
                <textarea id="alasan_batal" class="form-control" rows="4" placeholder="Masukkan alasan pembatalan"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-danger" id="btn_konfirmasi_batal">
                    <i class="ri-close-circle-line me-1"></i>Konfirmasi Batalkan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
var modalDetailPembatalan;
var modalBatalkanTransaksi;
var transactionCache = {};

$(document).ready(function () {
    flatpickr('.tanggal', {
        dateFormat: 'd-m-Y'
    });

    modalDetailPembatalan = new bootstrap.Modal(
        document.getElementById('modal_detail')
    );

    modalBatalkanTransaksi = new bootstrap.Modal(
        document.getElementById('modal_batal')
    );

    $('#btn_tampil').on('click', function () {
        loadTransactions();
    });

    $('#filter_q').on('keydown', function (event) {
        if (event.key === 'Enter') {
            loadTransactions();
        }
    });

    $('#data_transaksi').on('click', '[data-detail-id]', function () {
        showDetail($(this).data('detail-id'));
    });

    $('#data_transaksi').on('click', '[data-cancel-id]', function () {
        openCancel($(this).data('cancel-id'));
    });

    $('#btn_konfirmasi_batal').on('click', function () {
        cancelTransaction();
    });

    $('#dt-length-0').on('change', function () {
        const jumlah = parseInt($(this).val());

        paging(
            $('#data_transaksi .data-pembatalan-transaksi'),
            jumlah
        );
    });

    loadTransactions();
});

function loadTransactions() {
    var button = $('#btn_tampil');

    $.ajax({
        url: '<?= base_url('transaksi/pembatalan_transaksi/result'); ?>',
        type: 'POST',
        data: {
            q: $('#filter_q').val(),
            awal: $('#filter_awal').val(),
            akhir: $('#filter_akhir').val(),
            metode: $('#filter_metode').val()
        },
        dataType: 'JSON',

        beforeSend: function () {
            button
                .prop('disabled', true)
                .html(
                    '<span class="spinner-border spinner-border-sm me-1"></span>Memuat'
                );

            $('#data_transaksi').html(`
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Memuat transaksi...
                        </div>
                    </td>
                </tr>
            `);

            $('#pagination').empty();
        },

        success: function (data) {
            transactionCache = {};

            var rows = Array.isArray(data) ? data : [];
            var html = '';

            if (rows.length == 0) {
                html += `
                    <tr class="data-pembatalan-transaksi">
                        <td colspan="7">
                            <div class="empty-state">
                                Tidak ada data
                            </div>
                        </td>
                    </tr>
                `;
            } else {
                rows.forEach(function (row) {
                    transactionCache[row.id] = row;

                    html += `
                        <tr class="data-pembatalan-transaksi">
                            <td>
                                <strong>
                                    ${escapeHtml(row.no_transaksi || '-')}
                                </strong>
                                <br>
                                <small class="text-muted">
                                    ${escapeHtml(row.tanggal_transaksi || '-')}
                                    ${escapeHtml(row.waktu_transaksi || '')}
                                </small>
                            </td>

                            <td>
                                <strong>
                                    ${escapeHtml(row.nama_siswa || '-')}
                                </strong>
                                <br>
                                <small>
                                    NIS ${escapeHtml(row.nis || '-')}
                                </small>
                            </td>

                            <td>
                                ${escapeHtml(row.nama_kelas || '-')}
                            </td>

                            <td>
                                ${escapeHtml(row.nama_metode_pembayaran || '-')}
                            </td>

                            <td class="text-end fw-semibold">
                                ${formatRupiah(row.total_pembayaran || 0)}
                            </td>

                            <td>
                                ${escapeHtml(row.nama_user || '-')}
                            </td>

                            <td class="text-end table-actions">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary me-1"
                                    data-detail-id="${Number(row.id)}">
                                    <i class="ri-eye-line"></i>
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-danger"
                                    data-cancel-id="${Number(row.id)}">
                                    <i class="ri-close-circle-line me-1"></i>
                                    Batalkan
                                </button>
                            </td>
                        </tr>
                    `;
                });
            }

            $('#data_transaksi').html(html);

            let jumlah_awal = parseInt($('#dt-length-0').val());

            paging(
                $('#data_transaksi .data-pembatalan-transaksi'),
                jumlah_awal
            );
        },

        error: function (xhr, status, error) {
            $('#data_transaksi').html(`
                <tr>
                    <td colspan="7">
                        <div class="empty-state text-danger">
                            Data transaksi gagal dimuat.
                        </div>
                    </td>
                </tr>
            `);

            $('#pagination').empty();

            ajaxError(xhr, status, error);
        },

        complete: function () {
            button
                .prop('disabled', false)
                .html(
                    '<i class="ri-search-line me-1"></i>Tampilkan'
                );
        }
    });
}

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

function showDetail(id) {
    $.ajax({
        url: '<?= base_url('transaksi/pembatalan_transaksi/detail'); ?>',
        type: 'POST',
        data: {
            id: id
        },
        dataType: 'JSON',

        beforeSend: function () {
            $('#isi_detail').html(`
                <div class="text-center py-4">
                    <span class="spinner-border spinner-border-sm me-1"></span>
                    Memuat detail transaksi...
                </div>
            `);
        },

        success: function (response) {
            if (response.result !== 'true') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.message || 'Detail transaksi gagal dimuat.'
                });
                return;
            }

            var header = response.header;
            var detailRows = Array.isArray(response.detail)
                ? response.detail
                : [];

            var html = `
                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <small class="text-muted">Nomor Transaksi</small>
                        <div class="fw-semibold">
                            ${escapeHtml(header.no_transaksi || '-')}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Tanggal</small>
                        <div>
                            ${escapeHtml(header.tanggal_transaksi || '-')}
                            ${escapeHtml(header.waktu_transaksi || '')}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Siswa</small>
                        <div>
                            ${escapeHtml(header.nama_siswa || '-')}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Kelas</small>
                        <div>
                            ${escapeHtml(header.nama_kelas || '-')}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Metode</small>
                        <div>
                            ${escapeHtml(header.nama_metode_pembayaran || '-')}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Petugas</small>
                        <div>
                            ${escapeHtml(header.nama_user || '-')}
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Tagihan</th>
                                <th class="text-end">Dibayar Transaksi Ini</th>
                                <th class="text-end">Sisa Setelah</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            if (detailRows.length == 0) {
                html += `
                    <tr>
                        <td colspan="3" class="text-center">
                            Tidak ada data
                        </td>
                    </tr>
                `;
            } else {
                detailRows.forEach(function (row) {
                    html += `
                        <tr>
                            <td>
                                ${escapeHtml(row.nama_tagihan || '-')}
                            </td>

                            <td class="text-end">
                                ${formatRupiah(row.nominal_bayar || 0)}
                            </td>

                            <td class="text-end">
                                ${formatRupiah(row.sisa_setelah || 0)}
                            </td>
                        </tr>
                    `;
                });
            }

            html += `
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-end">
                                    ${formatRupiah(header.total_pembayaran || 0)}
                                </th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            `;

            $('#isi_detail').html(html);

            modalDetailPembatalan.show();
        },

        error: function (xhr, status, error) {
            ajaxError(xhr, status, error);
        }
    });
}

function openCancel(id) {
    var row = transactionCache[id];

    if (!row) {
        return;
    }

    $('#id_pembayaran_batal').val(id);
    $('#alasan_batal').val('');

    modalBatalkanTransaksi.show();
}

function cancelTransaction() {
    var id = $('#id_pembayaran_batal').val();
    var reason = $.trim($('#alasan_batal').val());

    if (!reason) {
        Swal.fire(
            'Perhatian',
            'Alasan pembatalan wajib diisi.',
            'warning'
        );
        return;
    }

    var button = $('#btn_konfirmasi_batal');

    $.ajax({
        url: '<?= base_url('transaksi/pembatalan_transaksi/batalkan'); ?>',
        type: 'POST',
        data: {
            id: id,
            alasan: reason
        },
        dataType: 'JSON',

        beforeSend: function () {
            button
                .prop('disabled', true)
                .html(
                    '<span class="spinner-border spinner-border-sm me-1"></span>Membatalkan'
                );
        },

        success: function (response) {
            if (response.result === 'true') {
                modalBatalkanTransaksi.hide();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message || 'Transaksi berhasil dibatalkan.'
                });

                loadTransactions();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.message || 'Transaksi gagal dibatalkan.'
                });
            }
        },

        error: function (xhr, status, error) {
            ajaxError(xhr, status, error);
        },

        complete: function () {
            button
                .prop('disabled', false)
                .html(
                    '<i class="ri-close-circle-line me-1"></i>Konfirmasi Batalkan'
                );
        }
    });
}
</script>