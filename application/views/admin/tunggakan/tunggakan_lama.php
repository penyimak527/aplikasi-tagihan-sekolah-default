<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Tunggakan Tahun Sebelumnya</h5>
    </div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-5">
                <select id="periode" class="form-select">
                    <option value="">Pilih Tahun Berjalan</option>
                    <?php foreach ($periode as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['status'] === 'Aktif' ? 'selected' : '' ?>>
                            <?= html_escape($p['periode']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-5">
                <select id="kelas" class="form-select">
                    <option value="">Semua Kelas Saat Ini</option>
                    <?php foreach ($kelas as $k): ?>
                        <option
                            value="<?= $k['id'] ?>"
                            data-period="<?= $k['id_periode'] ?>">
                            <?= html_escape($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-2 d-grid">
                <button id="tampil" class="btn btn-primary">Tampilkan</button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h5 class="mb-0">Daftar Tunggakan Lama</h5>
        <div class="d-flex gap-2 no-print">
            <button type="button" id="btnCetak" class="btn btn-secondary">Cetak Daftar</button>
            <button type="button" id="btnExport" class="btn btn-success">Ekspor Excel</button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kelas Saat Ini</th>
                        <th>Tahun Asal</th>
                        <th>Rincian</th>
                        <th class="text-end">Total Tunggakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr class="tunggakan-row">
                        <td colspan="6" class="empty-state">Pilih tahun berjalan.</td>
                    </tr>
                </tbody>
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

<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rincian Tunggakan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detail"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    function formatNominalDecimal(value) {
        var nominal = parseFloat(value || 0);

        if (isNaN(nominal)) {
            nominal = 0;
        }

        return 'Rp ' + nominal.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 2
        });
    }

    $(function() {
        filterKelasByPeriode();

        $('#periode').on('change', function() {
            filterKelasByPeriode();
        });

        $('#tampil').on('click', function() {
            loadData();
        });

        $('#btnCetak').on('click', function() {
            cetakData();
        });

        $('#btnExport').on('click', function() {
            exportData();
        });

        $('#dt-length-0').on('change', function() {
            refreshPagination();
        });

        $(document).on('click', '.detail', function() {
            loadDetail(
                $(this).data('id'),
                $(this).data('period')
            );
        });

        loadData();
    });

    function filterKelasByPeriode() {
        let periode = String($('#periode').val() || '');

        $('#kelas option').each(function() {
            let optionPeriode = String($(this).data('period') || '');
            let visible = !this.value || (periode !== '' && optionPeriode === periode);

            $(this)
                .prop('hidden', !visible)
                .prop('disabled', !visible);
        });

        $('#kelas').val('');
    }

    function loadData() {
        var idPeriode = $('#periode').val();
        var idKelasSetting = $('#kelas').val();

        if (!idPeriode) {
            $('#data').html(
                '<tr class="tunggakan-row">' +
                '<td colspan="6" class="empty-state">Pilih tahun berjalan.</td>' +
                '</tr>'
            );

            refreshPagination();
            return;
        }

        $.ajax({
            url: '<?= base_url('admin/tunggakan/tunggakan_lama/result') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id_periode_berjalan: idPeriode,
                id_kelas_setting: idKelasSetting
            },
            beforeSend: function() {
                $('#data').html(
                    '<tr class="tunggakan-row">' +
                    '<td colspan="6" class="text-center py-3">' +
                    '<span class="spinner-border spinner-border-sm me-1"></span>' +
                    'Memuat data...' +
                    '</td>' +
                    '</tr>'
                );

                $('#pagination').empty();
            },
            success: function(response) {
                var rows = Array.isArray(response) ? response : [];
                var html = '';

                if (!rows.length) {
                    html =
                        '<tr class="tunggakan-row">' +
                        '<td colspan="6" class="empty-state">' +
                        'Tidak ada tunggakan tahun sebelumnya.' +
                        '</td>' +
                        '</tr>';
                } else {
                    rows.forEach(function(row) {
                        html +=
                            '<tr class="tunggakan-row">' +
                            '<td>' +
                            '<strong>' + escapeHtml(row.nama_siswa || '-') + '</strong><br>' +
                            '<small>' + escapeHtml(row.nis || '-') + '</small>' +
                            '</td>' +
                            '<td>' + escapeHtml(row.kelas_saat_ini || '-') + '</td>' +
                            '<td>' + escapeHtml(row.tahun_asal || '-') + '</td>' +
                            '<td>' + Number(row.jumlah_tagihan || 0) + ' tagihan</td>' +
                            '<td class="text-end fw-semibold text-danger">' +
                            formatNominalDecimal(row.total_tunggakan) +
                            '</td>' +
                            '<td>' +
                            '<div class="action-buttons">' +
                            '<button type="button" ' +
                            'class="btn btn-sm btn-primary detail" ' +
                            'data-id="' + Number(row.id_siswa || 0) + '" ' +
                            'data-period="' + Number(row.id_periode || 0) + '">' +
                            'Detail' +
                            '</button>' +
                            '<a class="btn btn-sm btn-warning" ' +
                            'href="<?= base_url('admin/tunggakan/surat_tunggakan') ?>?siswa=' + Number(row.id_siswa || 0) + '">' +
                            'Buat Surat' +
                            '</a>' +
                            '</div>' +
                            '</td>' +
                            '</tr>';
                    });
                }

                $('#data').html(html);
                refreshPagination();
            },
            error: function(xhr, status, error) {
                $('#data').html(
                    '<tr class="tunggakan-row">' +
                    '<td colspan="6" class="empty-state text-danger">' +
                    'Data tunggakan gagal dimuat.' +
                    '</td>' +
                    '</tr>'
                );

                refreshPagination();
                ajaxError(xhr, status, error);
            }
        });
    }

    function cetakData() {
        if (!$('#periode').val()) {
            Swal.fire('Pilih tahun berjalan', 'Pilih Tahun Berjalan terlebih dahulu.', 'warning');
            return;
        }

        var params = new URLSearchParams({
            id_periode_berjalan: $('#periode').val() || '',
            id_kelas_setting: $('#kelas').val() || ''
        });

        window.open(
            '<?= base_url('admin/tunggakan/tunggakan_lama/cetak') ?>?' + params.toString(),
            '_blank'
        );
    }

    function exportData() {
        if (!$('#periode').val()) {
            Swal.fire('Pilih tahun berjalan', 'Pilih Tahun Berjalan terlebih dahulu.', 'warning');
            return;
        }

        var params = new URLSearchParams({
            id_periode_berjalan: $('#periode').val() || '',
            id_kelas_setting: $('#kelas').val() || ''
        });

        window.location.href = '<?= base_url('admin/tunggakan/tunggakan_lama/export') ?>?' + params.toString();
    }

    function loadDetail(idSiswa, idPeriode) {
        $.ajax({
            url: '<?= base_url('admin/tunggakan/tunggakan_lama/detail') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id_siswa: idSiswa,
                id_periode: idPeriode
            },
            beforeSend: function() {
                $('#detail').html(
                    '<div class="text-center py-4">' +
                    '<span class="spinner-border spinner-border-sm me-1"></span>' +
                    'Memuat rincian tunggakan...' +
                    '</div>'
                );

                bootstrap.Modal
                    .getOrCreateInstance(document.getElementById('modalDetail'))
                    .show();
            },
            success: function(response) {
                var rows = Array.isArray(response) ? response : [];

                var html =
                    '<table class="table">' +
                    '<thead>' +
                    '<tr>' +
                    '<th>Tagihan</th>' +
                    '<th>Periode</th>' +
                    '<th class="text-end">Nominal</th>' +
                    '<th class="text-end">Dibayar</th>' +
                    '<th class="text-end">Sisa</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>';

                if (!rows.length) {
                    html +=
                        '<tr>' +
                        '<td colspan="5" class="empty-state">' +
                        'Tidak ada rincian tunggakan.' +
                        '</td>' +
                        '</tr>';
                } else {
                    rows.forEach(function(row) {
                        html +=
                            '<tr>' +
                            '<td>' + escapeHtml(row.nama_tagihan || '-') + '</td>' +
                            '<td>' +
                            escapeHtml(
                                ((row.nama_bulan || '') + ' ' + (row.tahun || '')).trim()
                            ) +
                            '</td>' +
                            '<td class="text-end">' +
                            formatNominalDecimal(row.nominal_tagihan) +
                            '</td>' +
                            '<td class="text-end">' +
                            formatNominalDecimal(row.nominal_dibayar) +
                            '</td>' +
                            '<td class="text-end">' +
                            formatNominalDecimal(row.sisa_tagihan) +
                            '</td>' +
                            '</tr>';
                    });
                }

                html += '</tbody></table>';
                $('#detail').html(html);
            },
            error: function(xhr, status, error) {
                $('#detail').html(
                    '<div class="empty-state text-danger">' +
                    'Rincian tunggakan gagal dimuat.' +
                    '</div>'
                );

                ajaxError(xhr, status, error);
            }
        });
    }

    function refreshPagination() {
        paging(
            $('#data .tunggakan-row'),
            parseInt($('#dt-length-0').val(), 10) || 10
        );
    }

    function paging($selector, jumlah_tampil = 10) {
        window.tp = new Pagination('#pagination', {
            itemsCount: $selector.length,
            pageSize: parseInt(jumlah_tampil),
            onPageChange: function(paging) {
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
