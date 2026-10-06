<div class="card">
    <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
        <h4 class="header-title mb-0">Data <?= $title; ?></h4>
    </div>
    <div class="card-body">
        <div class="row g-2 mb-3">
            <div class="col-lg-2 col-md-4">
                <label class="form-label">Tahun Ajaran</label>
                <select id="periode" class="form-select">
                    <?php foreach ($periode as $row): ?>
                        <option value="<?= (int) $row['id'] ?>"
                            <?= isset($periode_aktif['id']) && (int) $periode_aktif['id'] === (int) $row['id'] ? 'selected' : '' ?>>
                            <?= html_escape($row['periode']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <label class="form-label">Kelas</label>
                <select id="kelas" class="form-select">
                    <option value="0">Semua Kelas</option>
                    <?php foreach ($kelas as $row): ?>
                        <option value="<?= (int) $row['id'] ?>">
                            <?= html_escape($row['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-2 col-md-4">
                <label class="form-label">Dari Tanggal</label>
                <input type="text" id="dari_tanggal" class="form-control tanggal" placeholder="dd-mm-yyyy">
            </div>
            <div class="col-lg-2 col-md-4">
                <label class="form-label">Sampai Tanggal</label>
                <input type="text" id="sampai_tanggal" class="form-control tanggal" placeholder="dd-mm-yyyy">
            </div>
            <div class="col-lg-3 col-md-6">
                <label class="form-label">Cari</label>
                <div class="input-group">
                    <input type="text" id="search" class="form-control" placeholder="Nama / NIS / tagihan ...">
                    <span class="input-group-text bg-primary text-white"><i class="ri-search-line"></i></span>
                </div>
            </div>
            <div class="col-lg-1 col-md-2 d-grid align-self-end">
                <button type="button" class="btn btn-primary" id="btn-cari">Cari</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th style="width:60px;">No</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Tagihan</th>
                        <th class="text-center">Jumlah Cicilan</th>
                        <th class="text-end">Total Dibayar</th>
                        <th class="text-end">Sisa</th>
                        <th>Pembayaran Terakhir</th>
                        <th>Status</th>
                        <th style="width:90px;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="data_cicilan"></tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
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

<div class="modal fade" id="modal-detail-cicilan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Cicilan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="ringkasan_cicilan" class="mb-3"></div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:90px;">Cicilan</th>
                                <th>Tanggal</th>
                                <th>No. Transaksi</th>
                                <th class="text-end">Nominal Bayar</th>
                                <th class="text-end">Sisa Setelah</th>
                                <th>Metode</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody id="data_detail_cicilan"></tbody>
                    </table>
                </div>
                <div class="mt-2 mb-2 text-muted">
                    Total <span class="fw-semibold" id="total_detail_cicilan">0 cicilan</span>
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-detail-cicilan"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-detail-0" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-detail-0">
                            <option value="5" selected>5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span>entri</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        flatpickr('.tanggal', {
            dateFormat: 'd-m-Y',
            allowInput: true
        });

        $('#periode').on('change', function () {
            kelas_result();
        });

        $('#kelas, #dari_tanggal, #sampai_tanggal').on('change', function () {
            cicilan();
        });

        $('#btn-cari').on('click', function () {
            cicilan();
        });

        $('#search').on('keyup', function (event) {
            if (event.key === 'Enter') {
                cicilan();
            }
        });

        $('#dt-length-0').on('change', function () {
            const jumlah = parseInt($(this).val());
            paging($('#data_cicilan .data-cicilan'), jumlah);
        });

        $('#dt-length-detail-0').on('change', function () {
            const jumlah = parseInt($(this).val());
            paging_detail($('#data_detail_cicilan .data-detail-cicilan'), jumlah);
        });

        cicilan();
    });

    function kelas_result() {
        $.ajax({
            url: '<?= base_url('admin/transaksi/cicilan/kelas_result') ?>',
            type: 'POST',
            data: {
                id_periode: $('#periode').val()
            },
            dataType: 'JSON',
            success: function (data) {
                var option = '<option value="0">Semua Kelas</option>';

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(function (item) {
                        option += '<option value="' + Number(item.id || 0) + '">' +
                            escapeHtml(item.nama_kelas || '-') +
                            '</option>';
                    });
                }

                $('#kelas').html(option);
                cicilan();
            },
            error: function (xhr) {
                ajaxError(xhr);
            }
        });
    }

    function cicilan() {
        $.ajax({
            url: '<?= base_url('admin/transaksi/cicilan/result') ?>',
            type: 'POST',
            data: {
                id_periode: $('#periode').val(),
                id_kelas_setting: $('#kelas').val(),
                dari_tanggal: $('#dari_tanggal').val(),
                sampai_tanggal: $('#sampai_tanggal').val(),
                search: $('#search').val()
            },
            dataType: 'JSON',
            success: function (data) {
                var table = '';

                if (!Array.isArray(data) || data.length === 0) {
                    table = '<tr class="data-cicilan"><td colspan="10" class="text-center text-muted">Tidak ada data</td></tr>';
                } else {
                    data.forEach(function (item, index) {
                        var periodeTagihan = Number(item.tahun || 0) > 0
                            ? ' - ' + escapeHtml(item.nama_bulan || '') + ' ' + Number(item.tahun || 0)
                            : '';

                        var status = escapeHtml(item.status_pembayaran || '-');
                        var statusClass = 'secondary';
                        if (item.status_pembayaran === 'Lunas') {
                            statusClass = 'success';
                        } else if (item.status_pembayaran === 'Dibayar Sebagian') {
                            statusClass = 'warning';
                        } else if (item.status_pembayaran === 'Dibatalkan') {
                            statusClass = 'danger';
                        }

                        table += '<tr class="data-cicilan">' +
                            '<td>' + (index + 1) + '</td>' +
                            '<td><strong>' + escapeHtml(item.nama_siswa || '-') + '</strong><br><small class="text-muted">' + escapeHtml(item.nis || '-') + '</small></td>' +
                            '<td>' + escapeHtml(item.nama_kelas || '-') + '</td>' +
                            '<td>' + escapeHtml(item.nama_tagihan || '-') + periodeTagihan + '<br><small class="text-muted">' + escapeHtml(item.no_tagihan || '-') + '</small></td>' +
                            '<td class="text-center"><span class="badge bg-info-subtle text-info">' + Number(item.jumlah_cicilan || 0) + 'x pembayaran</span></td>' +
                            '<td class="text-end">' + formatRupiah(item.total_dibayar_cicilan || 0) + '</td>' +
                            '<td class="text-end">' + formatRupiah(item.sisa_tagihan || 0) + '</td>' +
                            '<td>' + escapeHtml(item.tanggal_terakhir || '-') + '<br><small class="text-muted">' + escapeHtml(item.waktu_terakhir || '') + '</small></td>' +
                            '<td><span class="badge bg-' + statusClass + '-subtle text-' + statusClass + '">' + status + '</span></td>' +
                            '<td><button type="button" class="btn btn-sm btn-outline-primary" onclick="detailCicilan(' + Number(item.id_tagihan_siswa || 0) + ')"><i class="ri-eye-line me-1"></i>Detail</button></td>' +
                            '</tr>';
                    });
                }

                $('#data_cicilan').html(table);
                let jumlah_awal = parseInt($('#dt-length-0').val());
                paging($('#data_cicilan .data-cicilan'), jumlah_awal);
            },
            error: function (xhr) {
                ajaxError(xhr);
            }
        });
    }

    function detailCicilan(id) {
        $.ajax({
            url: '<?= base_url('admin/transaksi/cicilan/detail') ?>',
            type: 'POST',
            data: {
                id_tagihan_siswa: id
            },
            dataType: 'JSON',
            success: function (data) {
                if (data.result !== 'true') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message || 'Detail cicilan gagal dimuat.'
                    });
                    return;
                }

                var tagihan = data.tagihan || {};
                var detail = Array.isArray(data.detail) ? data.detail : [];
                var periodeTagihan = Number(tagihan.tahun || 0) > 0
                    ? ' - ' + escapeHtml(tagihan.nama_bulan || '') + ' ' + Number(tagihan.tahun || 0)
                    : '';

                $('#ringkasan_cicilan').html(
                    '<div class="row g-2">' +
                        '<div class="col-md-4"><div class="border rounded p-2 h-100"><small class="text-muted">Siswa</small><div class="fw-semibold">' + escapeHtml(tagihan.nama_siswa || '-') + '</div><small>' + escapeHtml(tagihan.nis || '-') + ' - ' + escapeHtml(tagihan.nama_kelas || '-') + '</small></div></div>' +
                        '<div class="col-md-4"><div class="border rounded p-2 h-100"><small class="text-muted">Tagihan</small><div class="fw-semibold">' + escapeHtml(tagihan.nama_tagihan || '-') + periodeTagihan + '</div><small>' + escapeHtml(tagihan.no_tagihan || '-') + '</small></div></div>' +
                        '<div class="col-md-4"><div class="border rounded p-2 h-100"><small class="text-muted">Ringkasan</small><div><strong>Dibayar:</strong> ' + formatRupiah(tagihan.nominal_dibayar || 0) + '</div><div><strong>Sisa:</strong> ' + formatRupiah(tagihan.sisa_tagihan || 0) + '</div></div></div>' +
                    '</div>'
                );

                var rows = '';
                if (detail.length === 0) {
                    rows = '<tr class="data-detail-cicilan"><td colspan="7" class="text-center text-muted">Tidak ada detail cicilan</td></tr>';
                } else {
                    detail.forEach(function (item, index) {
                        rows += '<tr class="data-detail-cicilan">' +
                            '<td><span class="badge bg-primary-subtle text-primary">Cicilan ' + (index + 1) + '</span></td>' +
                            '<td>' + escapeHtml(item.tanggal_transaksi || '-') + '<br><small class="text-muted">' + escapeHtml(item.waktu_transaksi || '') + '</small></td>' +
                            '<td>' + escapeHtml(item.no_transaksi || '-') + '</td>' +
                            '<td class="text-end">' + formatRupiah(item.nominal_bayar || 0) + '</td>' +
                            '<td class="text-end">' + formatRupiah(item.sisa_setelah || 0) + '</td>' +
                            '<td>' + escapeHtml(item.nama_metode_pembayaran || '-') + '</td>' +
                            '<td>' + escapeHtml(item.nama_user || '-') + '</td>' +
                            '</tr>';
                    });
                }

                $('#data_detail_cicilan').html(rows);
                $('#total_detail_cicilan').text(detail.length + ' cicilan');

                let jumlah_detail = parseInt($('#dt-length-detail-0').val());
                paging_detail($('#data_detail_cicilan .data-detail-cicilan'), jumlah_detail);

                $('#modal-detail-cicilan').modal('show');
            },
            error: function (xhr) {
                ajaxError(xhr);
            }
        });
    }

    function paging($selector, jumlah_tampil = 10) {
        window.tp = new Pagination('#pagination', {
            itemsCount: $selector.length,
            pageSize: parseInt(jumlah_tampil),
            onPageChange: function (paging) {
                let start = paging.pageSize * (paging.currentPage - 1);
                let end = start + paging.pageSize;
                let $rows = $selector;

                $rows.hide();
                for (let i = start; i < end; i++) {
                    $rows.eq(i).show();
                }
            }
        });
    }

    function paging_detail($selector, jumlah_tampil = 5) {
        window.tp_detail = new Pagination('#pagination-detail-cicilan', {
            itemsCount: $selector.length,
            pageSize: parseInt(jumlah_tampil),
            labels: {
                first: '<i class="ri-skip-left-line"></i>',
                previous: '<i class="ri-arrow-left-s-line"></i>',
                next: '<i class="ri-arrow-right-s-line"></i>',
                last: '<i class="ri-skip-right-line"></i>'
            },
            onPageChange: function (paging) {
                let start = paging.pageSize * (paging.currentPage - 1);
                let end = start + paging.pageSize;
                let $rows = $selector;

                $rows.hide();
                for (let i = start; i < end; i++) {
                    $rows.eq(i).show();
                }
            }
        });
    }
</script>
