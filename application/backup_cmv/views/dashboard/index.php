<?php
$periodeAktifId = isset($periode_aktif['id']) ? (int) $periode_aktif['id'] : 0;
$metricCards = array(
    array('key' => 'siswa_aktif', 'label' => 'Siswa Aktif', 'icon' => 'ti-users', 'tone' => 'primary', 'money' => false, 'hint' => 'Siswa aktif sesuai filter'),
    array('key' => 'total_tagihan', 'label' => 'Total Tagihan', 'icon' => 'ti-file-invoice', 'tone' => 'secondary', 'money' => true, 'hint' => 'Nominal tagihan sesuai periode'),
    array('key' => 'pembayaran_masuk', 'label' => 'Pembayaran Masuk', 'icon' => 'ti-cash', 'tone' => 'success', 'money' => true, 'hint' => 'Hanya transaksi berstatus Aktif'),
    array('key' => 'tunggakan', 'label' => 'Tunggakan', 'icon' => 'ti-alert-circle', 'tone' => 'danger', 'money' => true, 'hint' => 'Sisa tagihan yang dianggap tunggakan', 'url' => base_url('admin/tunggakan/tagihan_per_kelas')),
    array('key' => 'sudah_lunas', 'label' => 'Sudah Lunas', 'icon' => 'ti-circle-check', 'tone' => 'success', 'money' => false, 'hint' => 'Jumlah tagihan berstatus Lunas'),
    array('key' => 'belum_lunas', 'label' => 'Belum Lunas', 'icon' => 'ti-clock', 'tone' => 'warning', 'money' => false, 'hint' => 'Jumlah tagihan belum dibayar'),
    array('key' => 'cicilan_aktif', 'label' => 'Cicilan Aktif', 'icon' => 'ti-chart-pie', 'tone' => 'info', 'money' => false, 'hint' => 'Jumlah tagihan dibayar sebagian'),
    array('key' => 'transaksi_hari_ini', 'label' => 'Transaksi Hari Ini', 'icon' => 'ti-calendar-dollar', 'tone' => 'primary', 'money' => false, 'hint' => 'Transaksi aktif hari ini')
);
?>

<div class="card mb-3">
    <div class="card-header">
        <h4 class="header-title">Filter Dashboard</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-0">
            <div class="col-md-4">
                <label for="filter_periode" class="form-label">Tahun Ajaran</label>
                <select id="filter_periode" class="form-select">
                    <option value="">Pilih Tahun Ajaran</option>
                    <?php foreach ($periode as $row): ?>
                        <option value="<?= (int) $row['id'] ?>" <?= (int) $row['id'] === $periodeAktifId ? 'selected' : '' ?>>
                            <?= html_escape($row['periode']) ?>    <?= $row['status'] === 'Aktif' ? ' - Aktif' : '' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filter_kelas" class="form-label">Kelas</label>
                <select id="filter_kelas" class="form-select">
                    <option value="0">Semua Kelas</option>
                    <?php foreach ($kelas as $row): ?>
                        <option value="<?= (int) $row['id'] ?>" data-periode="<?= html_escape($row['id_periode']) ?>">
                            <?= html_escape($row['nama_kelas'] . ' - ' . $row['semester']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label for="filter_bulan" class="form-label">Bulan/Periode</label>
                <select id="filter_bulan" class="form-select">
                    <option value="0">Seluruh Tahun Ajaran</option>
                    <?php foreach (array(7, 8, 9, 10, 11, 12, 1, 2, 3, 4, 5, 6) as $nomorBulan): ?>
                        <option value="<?= $nomorBulan ?>"><?= nama_bulan($nomorBulan) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" id="btn_tampilkan">
                    <i class="ri-filter-3-line me-1"></i>Tampilkan
                </button>
            </div>
        </div>
    </div>
</div>

<div id="dashboard_error" class="alert alert-danger d-none" role="alert">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <strong>Data gagal dimuat.</strong>
            <div>Periksa koneksi dan coba kembali. Filter yang dipilih tetap dipertahankan.</div>
        </div>
        <button type="button" class="btn btn-sm btn-danger" id="btn_muat_ulang">Muat Ulang</button>
    </div>
</div>

<div class="row g-3 mb-3" id="dashboard_metrics">
    <?php foreach ($metricCards as $card): ?>
        <div class="col-12 col-md-6 col-xxl-3">
            <div class="card dashboard-metric-card <?= isset($card['url']) ? 'is-link' : '' ?>" <?= isset($card['url']) ? 'data-url="' . html_escape($card['url']) . '"' : '' ?>>
                <div class="card-body">
                    <div class="dashboard-metric-icon bg-<?= $card['tone'] ?>-subtle text-<?= $card['tone'] ?>">
                        <i class="ti <?= $card['icon'] ?> fs-24"></i>
                    </div>
                    <div class="text-end min-w-0">
                        <div class="text-muted mb-1"><?= html_escape($card['label']) ?></div>
                        <div class="summary-value" id="sum_<?= $card['key'] ?>"
                            data-money="<?= $card['money'] ? '1' : '0' ?>">-</div>
                        <small class="text-muted d-block"><?= html_escape($card['hint']) ?></small>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="card mb-3">
    <div class="card-header justify-content-between">
        <h4 class="header-title">Grafik Realisasi Pembayaran Juli–Juni</h4>
        <a href="<?= base_url('admin/laporan/laporan/tahunan') ?>" class="btn btn-sm btn-outline-primary">Buka Laporan
            Tahunan</a>
    </div>
    <div class="card-body">
        <div id="chart_realisasi" class="dashboard-chart-wrap"></div>
        <div id="chart_empty" class="dashboard-chart-empty d-none">
            <div class="empty-state py-3">
                <i class="ti ti-chart-bar-off empty-icon"></i>
                <div class="empty-state-title">Tidak ada tagihan pada periode ini</div>
                <div>Silakan pilih periode lain atau buat tagihan terlebih dahulu.</div>
                <a href="<?= base_url('admin/tagihan/tagihan_bulanan') ?>" class="btn btn-sm btn-primary mt-3">Buka Menu
                    Tagihan</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <h4 class="header-title">Ringkasan Jenis Tagihan</h4>
            </div>
            <div class="card-body" id="ringkasan_jenis">
                <div class="empty-state py-3">Belum ada data.</div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6">
        <div class="card h-100">
            <div class="card-header">
                <h4 class="header-title">Ringkasan Status Pembayaran</h4>
            </div>
            <div class="card-body" id="ringkasan_status">
                <div class="empty-state py-3">Belum ada data.</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-xl-7">
        <div class="card ">
            <div class="card-header justify-content-between">
                <h4 class="header-title">Transaksi Terbaru</h4>
                <a href="<?= base_url('admin/transaksi/riwayat_pembayaran') ?>" class="btn btn-sm btn-outline-primary">Lihat
                    Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>No Transaksi</th>
                                <th>Siswa</th>
                                <th>Metode</th>
                                <th>Petugas</th>
                                <th class="text-end">Nominal</th>
                                <th>Waktu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="transaksi_terbaru">
                            <tr class="data-transaksi-terbaru">
                                <td colspan="7">
                                    <div class="empty-state py-4">Memuat data...</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 p-3 border-top">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-transaksi"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-transaksi" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-transaksi">
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
    <div class="col-12 col-xl-5">
        <div class="card ">
            <div class="card-header justify-content-between">
                <h4 class="header-title">Tunggakan Prioritas</h4>
                <a href="<?= base_url('admin/tunggakan/tagihan_per_kelas') ?>" class="btn btn-sm btn-outline-primary">Tindak
                    Lanjut</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tunggakan_prioritas">
                            <tr class="data-tunggakan-prioritas">
                                <td colspan="5">
                                    <div class="empty-state py-4">Memuat data...</div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 p-3 border-top">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-tunggakan"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-tunggakan" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-tunggakan">
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


<style>
/*
 * Pagination tetap menggunakan Pagination JS seperti Beasiswa.
 * Pada template dashboard, elemen first/prev/next/last terbentuk
 * tetapi icon Font Awesome tidak ter-render sehingga terlihat kosong.
 * Fallback ini hanya menampilkan simbol arrow-nya.
 */
#pagination-transaksi .fa-angle-double-left::before,
#pagination-tunggakan .fa-angle-double-left::before {
    content: "\00AB" !important;
    font-family: Arial, sans-serif !important;
}

#pagination-transaksi .fa-angle-left::before,
#pagination-tunggakan .fa-angle-left::before {
    content: "\2039" !important;
    font-family: Arial, sans-serif !important;
}

#pagination-transaksi .fa-angle-right::before,
#pagination-tunggakan .fa-angle-right::before {
    content: "\203A" !important;
    font-family: Arial, sans-serif !important;
}

#pagination-transaksi .fa-angle-double-right::before,
#pagination-tunggakan .fa-angle-double-right::before {
    content: "\00BB" !important;
    font-family: Arial, sans-serif !important;
}

#pagination-transaksi .page-link i,
#pagination-tunggakan .page-link i {
    font-style: normal;
}
</style>

<script>
    var dashboardChart = null;

    $(document).ready(function () {
        filterDashboardKelas();
        loadDashboard();

        $('#filter_periode').on('change', filterDashboardKelas);
        $('#btn_tampilkan, #btn_muat_ulang').on('click', loadDashboard);

        $('#dt-length-transaksi').on('change', function () {
            pagingDashboard(
                $('#transaksi_terbaru .data-transaksi-terbaru'),
                parseInt($(this).val()),
                '#pagination-transaksi'
            );
        });

        $('#dt-length-tunggakan').on('change', function () {
            pagingDashboard(
                $('#tunggakan_prioritas .data-tunggakan-prioritas'),
                parseInt($(this).val()),
                '#pagination-tunggakan'
            );
        });

        $(document).on('click', '.dashboard-metric-card.is-link', function () {
            var url = $(this).data('url');
            if (url) window.location.href = url;
        });
    });

    function filterDashboardKelas() {
        var periode = String($('#filter_periode').val() || '');
        $('#filter_kelas option').each(function () {
            var optionPeriode = $(this).data('periode');
            var visible = !optionPeriode || String(optionPeriode) === periode;
            $(this).prop('hidden', !visible).prop('disabled', !visible);
        });
        $('#filter_kelas').val('0');
    }

    function loadDashboard() {
        $('#dashboard_error').addClass('d-none');
        $('#btn_tampilkan, #btn_muat_ulang').prop('disabled', true);

        $.ajax({
            url: '<?= base_url('dashboard/result') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id_periode: $('#filter_periode').val(),
                id_kelas_setting: $('#filter_kelas').val(),
                bulan: $('#filter_bulan').val()
            }
        }).done(function (response) {
            if (!response || response.result !== 'true') {
                showDashboardError();
                return;
            }

            renderDashboardSummary(response.summary || {});
            renderDashboardChart(response.chart || []);
            renderJenisTagihan(response.jenis || []);
            renderStatusPembayaran(response.status || []);
            renderTransaksiTerbaru(response.transaksi || []);
            renderTunggakanPrioritas(response.prioritas || []);
        }).fail(function () {
            showDashboardError();
        }).always(function () {
            $('#btn_tampilkan, #btn_muat_ulang').prop('disabled', false);
        });
    }

    function showDashboardError() {
        $('#dashboard_error').removeClass('d-none');
        $('#dashboard_metrics .summary-value').text('-');
        $('#ringkasan_jenis, #ringkasan_status').html('<div class="empty-state py-3">Data gagal dimuat.</div>');
        $('#transaksi_terbaru').html('<tr class="data-transaksi-terbaru"><td colspan="7"><div class="empty-state py-4">Data gagal dimuat.</div></td></tr>');
        $('#tunggakan_prioritas').html('<tr class="data-tunggakan-prioritas"><td colspan="5"><div class="empty-state py-4">Data gagal dimuat.</div></td></tr>');
        if (dashboardChart) {
            dashboardChart.destroy();
            dashboardChart = null;
        }
        $('#chart_realisasi').empty().addClass('d-none');
        $('#chart_empty').removeClass('d-none').find('.empty-state-title').text('Data gagal dimuat');
    }

    function renderDashboardSummary(summary) {
        $('#dashboard_metrics .summary-value').each(function () {
            var key = String(this.id).replace('sum_', '');
            var value = Number(summary[key] || 0);
            $(this).text($(this).data('money') === 1 ? formatRupiah(value) : new Intl.NumberFormat('id-ID').format(value));
        });
    }

    function renderDashboardChart(rows) {
        var totals = rows.map(function (row) { return Number(row.total || 0); });
        var hasData = totals.some(function (value) { return value > 0; });

        if (dashboardChart) {
            dashboardChart.destroy();
            dashboardChart = null;
        }

        if (!hasData) {
            $('#chart_realisasi').empty().addClass('d-none');
            $('#chart_empty').removeClass('d-none');
            return;
        }

        $('#chart_empty').addClass('d-none');
        $('#chart_realisasi').removeClass('d-none').empty();

        dashboardChart = new ApexCharts(document.querySelector('#chart_realisasi'), {
            chart: {
                type: 'bar',
                height: 320,
                toolbar: { show: false },
                animations: { enabled: true }
            },
            series: [{ name: 'Pembayaran', data: totals }],
            colors: ['#188ae2'],
            plotOptions: {
                bar: { borderRadius: 4, columnWidth: '48%' }
            },
            xaxis: {
                categories: rows.map(function (row) { return row.label; }),
                labels: { rotate: -35 }
            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return 'Rp' + new Intl.NumberFormat('id-ID', { notation: 'compact', maximumFractionDigits: 1 }).format(value);
                    }
                }
            },
            dataLabels: { enabled: false },
            grid: { borderColor: 'rgba(155, 166, 183, .22)' },
            tooltip: {
                y: { formatter: function (value) { return formatRupiah(value); } }
            }
        });
        dashboardChart.render();
    }

    function renderJenisTagihan(rows) {
        if (!rows.length) {
            $('#ringkasan_jenis').html('<div class="empty-state py-3">Belum ada tagihan pada filter ini.</div>');
            return;
        }

        var order = ['Bulanan', 'Langsung', 'Tahunan'];
        var indexed = {};
        rows.forEach(function (row) { indexed[row.tipe_tagihan] = row; });

        var html = order.map(function (tipe) {
            var row = indexed[tipe] || { jumlah: 0, nominal: 0 };
            return '<div class="dashboard-list-row">' +
                '<div><div class="fw-semibold">' + escapeHtml(tipe) + '</div>' +
                '<small class="text-muted">' + new Intl.NumberFormat('id-ID').format(Number(row.jumlah || 0)) + ' tagihan</small></div>' +
                '<div class="text-end fw-semibold">' + formatRupiah(row.nominal || 0) + '</div>' +
                '</div>';
        }).join('');

        $('#ringkasan_jenis').html(html);
    }

    function renderStatusPembayaran(rows) {
        if (!rows.length) {
            $('#ringkasan_status').html('<div class="empty-state py-3">Belum ada status pembayaran pada filter ini.</div>');
            return;
        }

        var tones = {
            'Lunas': 'success',
            'Dibayar Sebagian': 'info',
            'Belum Dibayar': 'warning'
        };
        var total = rows.reduce(function (sum, row) { return sum + Number(row.jumlah || 0); }, 0);

        var html = rows.map(function (row) {
            var count = Number(row.jumlah || 0);
            var percent = total > 0 ? Math.round((count / total) * 100) : 0;
            var tone = tones[row.status_pembayaran] || 'primary';
            return '<div class="mb-3">' +
                '<div class="d-flex justify-content-between gap-2 mb-2">' +
                '<span class="fw-semibold">' + escapeHtml(row.status_pembayaran) + '</span>' +
                '<span>' + new Intl.NumberFormat('id-ID').format(count) + ' (' + percent + '%)</span>' +
                '</div>' +
                '<div class="dashboard-status-bar"><span class="bg-' + tone + '" style="width:' + percent + '%"></span></div>' +
                '</div>';
        }).join('');

        $('#ringkasan_status').html(html);
    }

    function renderTransaksiTerbaru(rows) {
        if (!rows.length) {
            $('#transaksi_terbaru').html(
                '<tr class="data-transaksi-terbaru"><td colspan="7"><div class="empty-state py-4">' +
                '<div class="empty-state-title">Tidak ada transaksi terbaru</div>' +
                '<div>Transaksi pembayaran akan tampil setelah pembayaran pertama disimpan.</div>' +
                '</div></td></tr>'
            );

            pagingDashboard(
                $('#transaksi_terbaru .data-transaksi-terbaru'),
                parseInt($('#dt-length-transaksi').val()),
                '#pagination-transaksi'
            );
            return;
        }

        var html = rows.map(function (row) {
            var detailUrl = '<?= base_url('admin/transaksi/riwayat_pembayaran?detail=') ?>' + encodeURIComponent(row.id);
            return '<tr class="data-transaksi-terbaru">' +
                '<td><strong class="text-primary">' + escapeHtml(row.no_transaksi) + '</strong></td>' +
                '<td>' + escapeHtml(row.nama_siswa) + '<br><small class="text-muted">' + escapeHtml(row.nama_kelas || '-') + '</small></td>' +
                '<td>' + escapeHtml(row.nama_metode_pembayaran || '-') + '</td>' +
                '<td>' + escapeHtml(row.nama_user || '-') + '</td>' +
                '<td class="text-end fw-semibold">' + formatRupiah(row.total_pembayaran || 0) + '</td>' +
                '<td>' + escapeHtml(row.tanggal_transaksi) + '<br><small class="text-muted">' + escapeHtml(row.waktu_transaksi) + '</small></td>' +
                '<td><a href="' + detailUrl + '" class="btn btn-sm btn-outline-primary">Detail</a></td>' +
                '</tr>';
        }).join('');

        $('#transaksi_terbaru').html(html);

        pagingDashboard(
            $('#transaksi_terbaru .data-transaksi-terbaru'),
            parseInt($('#dt-length-transaksi').val()),
            '#pagination-transaksi'
        );
    }

    function renderTunggakanPrioritas(rows) {
        if (!rows.length) {
            $('#tunggakan_prioritas').html('<tr class="data-tunggakan-prioritas"><td colspan="5"><div class="empty-state py-4">Tidak ada tunggakan prioritas.</div></td></tr>');
            pagingDashboard(
                $('#tunggakan_prioritas .data-tunggakan-prioritas'),
                parseInt($('#dt-length-tunggakan').val()),
                '#pagination-tunggakan'
            );
            return;
        }

        var html = rows.map(function (row) {
            var detailUrl = '<?= base_url('admin/tunggakan/tagihan_per_siswa?id_siswa=') ?>' + encodeURIComponent(row.id_siswa);
            return '<tr class="data-tunggakan-prioritas">' +
                '<td class="fw-semibold">' + escapeHtml(row.nama_siswa) + '</td>' +
                '<td>' + escapeHtml(row.nama_kelas || '-') + '</td>' +
                '<td class="text-center">' + new Intl.NumberFormat('id-ID').format(Number(row.jumlah_tagihan || 0)) + '</td>' +
                '<td class="text-end text-danger fw-semibold">' + formatRupiah(row.total_tunggakan || 0) + '</td>' +
                '<td><a href="' + detailUrl + '" class="btn btn-sm btn-outline-primary">Detail</a></td>' +
                '</tr>';
        }).join('');

        $('#tunggakan_prioritas').html(html);

        pagingDashboard(
            $('#tunggakan_prioritas .data-tunggakan-prioritas'),
            parseInt($('#dt-length-tunggakan').val()),
            '#pagination-tunggakan'
        );
    }

    function pagingDashboard($selector, jumlah_tampil = 10, pagination_selector = '#pagination') {
        window.tpDashboard = new Pagination(pagination_selector, {
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