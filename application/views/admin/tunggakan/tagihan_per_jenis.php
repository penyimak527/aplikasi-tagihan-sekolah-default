<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Filter Jenis Tagihan</h5>
    </div>
    <div class="card-body">
        <div class="row g-2">
            <div class="col-md-3">
                <select id="periode" class="form-select">
                    <option value="">Semua Tahun Ajaran</option>
                    <?php foreach ($periode as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= html_escape($p['periode']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-3">
                <select id="jenis" class="form-select">
                    <option value="">Semua Jenis</option>
                    <?php foreach ($jenis as $j): ?>
                        <option value="<?= $j['id'] ?>"><?= html_escape($j['nama_jenis']) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-3">
                <select id="master" class="form-select">
                    <option value="">Semua Batch/Periode</option>
                </select>
            </div>

            <div class="col-md-2">
                <select id="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?>
                        <option
                            value="<?= $k['id'] ?>"
                            data-period="<?= $k['id_periode'] ?>">
                            <?= html_escape($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-1 d-grid">
                <button type="button" id="tampil" class="btn btn-primary">
                    <i class="ti ti-search"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card"><div class="card-body"><small>Target</small><h4 id="target">Rp0</h4></div></div>
    </div>
    <div class="col-md-3">
        <div class="card"><div class="card-body"><small>Pembayaran</small><h4 id="bayar" class="text-success">Rp0</h4></div></div>
    </div>
    <div class="col-md-3">
        <div class="card"><div class="card-body"><small>Sisa</small><h4 id="sisa" class="text-danger">Rp0</h4></div></div>
    </div>
    <div class="col-md-3">
        <div class="card"><div class="card-body"><small>Realisasi</small><h4 id="realisasi">0%</h4></div></div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Realisasi Per Siswa</h5>
        <div class="d-flex gap-2 no-print">
            <button type="button" class="btn btn-secondary" id="btnCetak">Cetak</button>
            <button type="button" class="btn btn-success" id="btnExport">Ekspor Excel</button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Tagihan</th>
                        <th>Wajib</th>
                        <th class="text-end">Tarif Akhir</th>
                        <th class="text-end">Dibayar</th>
                        <th class="text-end">Sisa</th>
                        <th>Status</th>
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody id="data">
                    <tr>
                        <td colspan="8" class="empty-state">Pilih filter.</td>
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


<div class="modal fade" id="modalDetailJenis" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Tagihan Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailJenis"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
#pagination .fa-angle-double-left::before {
    content: "\00AB" !important;
    font-family: Arial, sans-serif !important;
}
#pagination .fa-angle-left::before {
    content: "\2039" !important;
    font-family: Arial, sans-serif !important;
}
#pagination .fa-angle-right::before {
    content: "\203A" !important;
    font-family: Arial, sans-serif !important;
}
#pagination .fa-angle-double-right::before {
    content: "\00BB" !important;
    font-family: Arial, sans-serif !important;
}
#pagination .page-link i {
    font-style: normal;
}
</style>

<script>
    const money = n => 'Rp' + Number(n || 0).toLocaleString('id-ID');

    $(document).ready(function () {
        filterKelasByPeriode();

        $('#periode').on('change', function () {
            filterKelasByPeriode();
            masters();
        });

        $('#jenis').on('change', function () {
            masters();
        });

        $('#tampil').on('click', function () {
            load();
        });

        $('#dt-length-0').on('change', function () {
            const jumlah = parseInt($(this).val());

            paging(
                $('#data .data-tagihan-jenis'),
                jumlah
            );
        });

        $('#btnCetak').on('click', function () {
            cetakData();
        });

        $('#btnExport').on('click', function () {
            exportData();
        });

        $(document).on('click', '.detail-jenis', function () {
            detailJenis($(this).data('id'));
        });
    });

    function filterKelasByPeriode() {
        let periode = String($('#periode').val() || '');

        $('#kelas option').each(function () {
            let optionPeriode = String($(this).data('period') || '');
            let visible = !this.value || (periode !== '' && optionPeriode === periode);

            $(this)
                .prop('hidden', !visible)
                .prop('disabled', !visible);
        });

        $('#kelas').val('');
    }

    function masters() {
        $.ajax({
            url: '<?= base_url('admin/tunggakan/tagihan_per_jenis/master'); ?>',
            type: 'POST',
            data: {
                id_periode: $('#periode').val(),
                id_jenis: $('#jenis').val()
            },
            dataType: 'JSON',

            beforeSend: function () {
                $('#master')
                    .prop('disabled', true)
                    .html('<option value="">Memuat Batch/Periode...</option>');
            },

            success: function (data) {
                var rows = Array.isArray(data) ? data : [];
                var option = '<option value="">Semua Batch/Periode</option>';

                if (rows.length > 0) {
                    rows.forEach(function (item) {
                        option += `
                            <option value="${Number(item.id)}">
                                ${escapeHtml(item.nama_tagihan)}
                                (${escapeHtml(item.tipe_tagihan)})
                            </option>
                        `;
                    });
                }

                $('#master').html(option);
            },

            error: function (xhr, status, error) {
                $('#master').html('<option value="">Semua Batch/Periode</option>');
                ajaxError(xhr, status, error);
            },

            complete: function () {
                $('#master').prop('disabled', false);
            }
        });
    }

    function load() {
        var button = $('#tampil');

        $.ajax({
            url: '<?= base_url('admin/tunggakan/tagihan_per_jenis/result'); ?>',
            type: 'POST',
            data: {
                id_periode: $('#periode').val(),
                id_jenis: $('#jenis').val(),
                id_master: $('#master').val(),
                id_kelas_setting: $('#kelas').val()
            },
            dataType: 'JSON',

            beforeSend: function () {
                button
                    .prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm"></span>');

                $('#data').html(`
                    <tr>
                        <td colspan="8" class="empty-state">Memuat data...</td>
                    </tr>
                `);

                $('#pagination').empty();
            },

            success: function (data) {
                var summary = data && data.summary ? data.summary : {};
                var rows = data && Array.isArray(data.rows) ? data.rows : [];

                $('#target').text(money(summary.target || 0));
                $('#bayar').text(money(summary.bayar || 0));
                $('#sisa').text(money(summary.sisa || 0));
                $('#realisasi').text(Number(summary.realisasi || 0) + '%');

                var table = '';

                if (rows.length == 0) {
                    table += `
                        <tr class="data-tagihan-jenis">
                            <td colspan="8" class="empty-state">Tidak ada data</td>
                        </tr>
                    `;
                } else {
                    rows.forEach(function (item) {
                        var wajib = item.dianggap_tunggakan === 'Ya' ? 'Ya' : 'Tidak';
                        var status = item.status_pembayaran || '-';
                        var statusClass = 'secondary';

                        if (status === 'Lunas') {
                            statusClass = 'success';
                        } else if (status === 'Dibayar Sebagian') {
                            statusClass = 'warning';
                        } else if (status === 'Belum Dibayar') {
                            statusClass = 'danger';
                        } else if (status === 'Dibebaskan') {
                            statusClass = 'info';
                        }

                        table += `
                            <tr class="data-tagihan-jenis">
                                <td>
                                    <strong>${escapeHtml(item.nama_siswa || '-')}</strong>
                                    <br>
                                    <small>${escapeHtml(item.nis || '-')}</small>
                                </td>

                                <td>${escapeHtml(item.nama_kelas || '-')}</td>

                                <td>
                                    <strong>${escapeHtml(item.nama_tagihan || '-')}</strong>
                                    <br>
                                    <small>
                                        ${escapeHtml(
                                            (item.nama_bulan || '') +
                                            ' ' +
                                            (item.tahun || '')
                                        )}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge bg-${wajib === 'Ya' ? 'success' : 'secondary'}-subtle text-${wajib === 'Ya' ? 'success' : 'secondary'}">
                                        ${wajib}
                                    </span>
                                </td>

                                <td class="text-end">${money(item.nominal_tagihan)}</td>
                                <td class="text-end">${money(item.nominal_dibayar)}</td>

                                <td class="text-end fw-semibold text-${Number(item.sisa_tagihan || 0) > 0 ? 'danger' : 'success'}">
                                    ${money(item.sisa_tagihan)}
                                </td>

                                <td>
                                    <span class="badge bg-${statusClass}-subtle text-${statusClass}">
                                        ${escapeHtml(status)}
                                    </span>
                                </td>
                                
                            </tr>
                        `;
                    });
                }
// <td>
//                                     <button type="button" class="btn btn-sm btn-primary detail-jenis" data-id="${Number(item.id_siswa)}">
//                                         Detail
//                                     </button>
//                                 </td>
                $('#data').html(table);

                let jumlah_awal = parseInt($('#dt-length-0').val());

                paging(
                    $('#data .data-tagihan-jenis'),
                    jumlah_awal
                );
            },

            error: function (xhr, status, error) {
                $('#target').text('Rp0');
                $('#bayar').text('Rp0');
                $('#sisa').text('Rp0');
                $('#realisasi').text('0%');

                $('#data').html(`
                    <tr>
                        <td colspan="8" class="empty-state text-danger">
                            Data tagihan per jenis gagal dimuat.
                        </td>
                    </tr>
                `);

                $('#pagination').empty();

                ajaxError(xhr, status, error);
            },

            complete: function () {
                button
                    .prop('disabled', false)
                    .html('<i class="ti ti-search"></i>');
            }
        });
    }


    function cetakData() {
        var params = new URLSearchParams({
            id_periode: $('#periode').val() || '',
            id_jenis: $('#jenis').val() || '',
            id_master: $('#master').val() || '',
            id_kelas_setting: $('#kelas').val() || ''
        });

        window.open(
            '<?= base_url('admin/tunggakan/tagihan_per_jenis/cetak'); ?>?' + params.toString(),
            '_blank'
        );
    }

    function exportData() {
        var params = new URLSearchParams({
            id_periode: $('#periode').val() || '',
            id_jenis: $('#jenis').val() || '',
            id_master: $('#master').val() || '',
            id_kelas_setting: $('#kelas').val() || ''
        });

        window.location.href = '<?= base_url('admin/tunggakan/tagihan_per_jenis/export'); ?>?' + params.toString();
    }

    function detailJenis(idSiswa) {
        $.ajax({
            url: '<?= base_url('admin/tunggakan/tagihan_per_jenis/detail'); ?>',
            type: 'POST',
            data: {
                id_siswa: idSiswa,
                id_periode: $('#periode').val()
            },
            dataType: 'JSON',
            beforeSend: function () {
                $('#detailJenis').html('<div class="text-center py-4"><span class="spinner-border spinner-border-sm me-1"></span>Memuat detail...</div>');
                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetailJenis')).show();
            },
            success: function (data) {
                var rows = Array.isArray(data) ? data : [];
                var html = '<div class="table-responsive"><table class="table align-middle"><thead><tr><th>Tagihan</th><th>Periode</th><th class="text-end">Nominal</th><th class="text-end">Dibayar</th><th class="text-end">Sisa</th><th>Status</th></tr></thead><tbody>';

                if (!rows.length) {
                    html += '<tr><td colspan="6" class="empty-state">Tidak ada data.</td></tr>';
                } else {
                    rows.forEach(function (row) {
                        html += '<tr>' +
                            '<td>' + escapeHtml(row.nama_tagihan || '-') + '</td>' +
                            '<td>' + escapeHtml(((row.nama_bulan || '') + ' ' + (row.tahun || '')).trim()) + '</td>' +
                            '<td class="text-end">' + money(row.nominal_tagihan) + '</td>' +
                            '<td class="text-end">' + money(row.nominal_dibayar) + '</td>' +
                            '<td class="text-end">' + money(row.sisa_tagihan) + '</td>' +
                            '<td>' + escapeHtml(row.status_pembayaran || '-') + '</td>' +
                            '</tr>';
                    });
                }

                html += '</tbody></table></div>';
                $('#detailJenis').html(html);
            },
            error: function (xhr, status, error) {
                $('#detailJenis').html('<div class="empty-state text-danger">Detail tagihan gagal dimuat.</div>');
                ajaxError(xhr, status, error);
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
</script>