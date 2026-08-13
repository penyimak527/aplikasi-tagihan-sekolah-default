<?php
$type = $jenis_laporan;
?>

<div class="card no-print">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title mb-1">Filter <?= html_escape($title) ?></h4>
            <p class="text-muted mb-0">Hasil laporan, cetak, dan ekspor mengikuti filter yang dipilih.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-end" id="filters">
            <?php if ($type === 'harian'): ?>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label" for="filter_tanggal">Tanggal</label>
                    <input
                        type="text"
                        id="filter_tanggal"
                        data-key="tanggal"
                        class="form-control filter tanggal-picker"
                        value="<?= date('d-m-Y') ?>"
                        placeholder="dd-mm-yyyy"
                        autocomplete="off"
                    >
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label" for="filter_kelas">Kelas</label>
                    <select id="filter_kelas" data-key="kelas" class="form-select filter filter-kelas">
                        <option value="">Semua Kelas</option>
                        <?php foreach ($kelas as $row): ?>
                            <option
                                value="<?= (int) $row['id'] ?>"
                                data-periode="<?= html_escape($row['id_periode']) ?>"
                            >
                                <?= html_escape($row['nama_kelas']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_metode">Metode</label>
                    <select id="filter_metode" data-key="metode" class="form-select filter">
                        <option value="">Semua Metode</option>
                        <?php foreach ($metode as $row): ?>
                            <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_metode']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_petugas">Petugas</label>
                    <input id="filter_petugas" data-key="petugas" class="form-control filter" placeholder="Nama petugas">
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_status_laporan">Status</label>
                    <select id="filter_status_laporan" data-key="status" class="form-select filter">
                        <option value="Aktif">Aktif</option>
                        <option value="Semua">Semua</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>

            <?php elseif ($type === 'bulanan'): ?>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_periode">Tahun Ajaran</label>
                    <select id="filter_periode" data-key="periode" class="form-select filter filter-periode">
                        <option value="">Semua Tahun</option>
                        <?php foreach ($periode as $row): ?>
                            <option value="<?= (int) $row['id'] ?>" <?= $row['status'] === 'Aktif' ? 'selected' : '' ?>>
                                <?= html_escape($row['periode']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_bulan">Bulan</label>
                    <select id="filter_bulan" data-key="bulan" class="form-select filter">
                        <?php for ($month = 1; $month <= 12; $month++): ?>
                            <option value="<?= $month ?>" <?= $month === (int) date('n') ? 'selected' : '' ?>>
                                <?= nama_bulan($month) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_tahun">Tahun Kalender</label>
                    <input id="filter_tahun" data-key="tahun" type="number" class="form-control filter" value="<?= date('Y') ?>">
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_kelas">Kelas</label>
                    <select id="filter_kelas" data-key="kelas" class="form-select filter">
                        <option value="">Semua Kelas Saat Ini</option>
                        <?php foreach ($kelas as $row): ?>
                            <option value="<?= (int) $row['id'] ?>">
                                <?= html_escape($row['nama_kelas']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_jenis">Jenis Tagihan</label>
                    <select id="filter_jenis" data-key="jenis" class="form-select filter">
                        <option value="">Semua Jenis</option>
                        <?php foreach ($jenis as $row): ?>
                            <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_jenis']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_metode">Metode</label>
                    <select id="filter_metode" data-key="metode" class="form-select filter">
                        <option value="">Semua Metode</option>
                        <?php foreach ($metode as $row): ?>
                            <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_metode']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php elseif ($type === 'tahunan'): ?>
                <div class="col-md-4">
                    <label class="form-label" for="filter_periode">Tahun Ajaran</label>
                    <select id="filter_periode" data-key="periode" class="form-select filter filter-periode">
                        <option value="">Pilih Tahun Ajaran</option>
                        <?php foreach ($periode as $row): ?>
                            <option value="<?= (int) $row['id'] ?>" <?= $row['status'] === 'Aktif' ? 'selected' : '' ?>>
                                <?= html_escape($row['periode']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="filter_kelas">Kelas</label>
                    <select id="filter_kelas" data-key="kelas" class="form-select filter filter-kelas">
                        <option value="">Semua Kelas</option>
                        <?php foreach ($kelas as $row): ?>
                            <option
                                value="<?= (int) $row['id'] ?>"
                                data-periode="<?= html_escape($row['id_periode']) ?>"
                            >
                                <?= html_escape($row['nama_kelas']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="filter_jenis">Jenis Tagihan</label>
                    <select id="filter_jenis" data-key="jenis" class="form-select filter">
                        <option value="">Semua Jenis</option>
                        <?php foreach ($jenis as $row): ?>
                            <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_jenis']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php elseif ($type === 'per_kelas'): ?>
                <div class="col-md-4">
                    <label class="form-label" for="filter_periode">Tahun Ajaran</label>
                    <select id="filter_periode" data-key="periode" class="form-select filter filter-periode">
                        <option value="">Semua Tahun</option>
                        <?php foreach ($periode as $row): ?>
                            <option value="<?= (int) $row['id'] ?>" <?= $row['status'] === 'Aktif' ? 'selected' : '' ?>>
                                <?= html_escape($row['periode']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="filter_sampai_bulan">Sampai Bulan</label>
                    <select id="filter_sampai_bulan" data-key="sampai_bulan" class="form-select filter">
                        <option value="">Semua Bulan</option>
                        <?php foreach (array(7,8,9,10,11,12,1,2,3,4,5,6) as $month): ?>
                            <option value="<?= $month ?>"><?= nama_bulan($month) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="filter_jenis">Jenis Tagihan</label>
                    <select id="filter_jenis" data-key="jenis" class="form-select filter">
                        <option value="">Semua Jenis</option>
                        <?php foreach ($jenis as $row): ?>
                            <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_jenis']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php elseif ($type === 'per_jenis'): ?>
                <div class="col-md-4">
                    <label class="form-label" for="filter_periode">Tahun Ajaran</label>
                    <select id="filter_periode" data-key="periode" class="form-select filter filter-periode">
                        <option value="">Semua Tahun</option>
                        <?php foreach ($periode as $row): ?>
                            <option value="<?= (int) $row['id'] ?>" <?= $row['status'] === 'Aktif' ? 'selected' : '' ?>>
                                <?= html_escape($row['periode']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="filter_kelas">Kelas</label>
                    <select id="filter_kelas" data-key="kelas" class="form-select filter filter-kelas">
                        <option value="">Semua Kelas</option>
                        <?php foreach ($kelas as $row): ?>
                            <option
                                value="<?= (int) $row['id'] ?>"
                                data-periode="<?= html_escape($row['id_periode']) ?>"
                            >
                                <?= html_escape($row['nama_kelas']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" for="filter_bulan">Periode Bulan</label>
                    <select id="filter_bulan" data-key="bulan" class="form-select filter">
                        <option value="">Semua Bulan</option>
                        <?php foreach (array(7,8,9,10,11,12,1,2,3,4,5,6) as $month): ?>
                            <option value="<?= $month ?>"><?= nama_bulan($month) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php elseif ($type === 'tunggakan'): ?>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label" for="filter_periode">Tahun Ajaran</label>
                    <select id="filter_periode" data-key="periode" class="form-select filter filter-periode">
                        <option value="">Semua Tahun</option>
                        <?php foreach ($periode as $row): ?>
                            <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['periode']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label" for="filter_kelas">Kelas</label>
                    <select id="filter_kelas" data-key="kelas" class="form-select filter">
                        <option value="">Semua Kelas Saat Ini</option>
                        <?php foreach ($kelas as $row): ?>
                            <option
                                value="<?= (int) $row['id'] ?>"
                            >
                                <?= html_escape($row['nama_kelas']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_jenis">Jenis Tagihan</label>
                    <select id="filter_jenis" data-key="jenis" class="form-select filter">
                        <option value="">Semua Jenis</option>
                        <?php foreach ($jenis as $row): ?>
                            <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_jenis']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_sampai_bulan">Sampai Bulan</label>
                    <select id="filter_sampai_bulan" data-key="sampai_bulan" class="form-select filter">
                        <option value="">Semua Bulan</option>
                        <?php foreach (array(7,8,9,10,11,12,1,2,3,4,5,6) as $month): ?>
                            <option value="<?= $month ?>"><?= nama_bulan($month) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 col-xl-2">
                    <label class="form-label" for="filter_status_siswa">Status Siswa</label>
                    <select id="filter_status_siswa" data-key="status_siswa" class="form-select filter">
                        <option value="Aktif">Aktif</option>
                        <option value="Semua">Semua</option>
                        <option value="Lulus">Lulus</option>
                        <option value="Berhenti">Berhenti</option>
                        <option value="Pindah Sekolah">Pindah Sekolah</option>
                    </select>
                </div>

            <?php else: ?>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label" for="filter_q">No Transaksi / Nama Siswa</label>
                    <input id="filter_q" data-key="q" class="form-control filter" placeholder="Cari nomor transaksi atau siswa">
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label" for="filter_awal">Tanggal Awal</label>
                    <input
                        type="text"
                        id="filter_awal"
                        data-key="awal"
                        class="form-control filter tanggal-picker"
                        placeholder="dd-mm-yyyy"
                        autocomplete="off"
                    >
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label" for="filter_akhir">Tanggal Akhir</label>
                    <input
                        type="text"
                        id="filter_akhir"
                        data-key="akhir"
                        class="form-control filter tanggal-picker"
                        placeholder="dd-mm-yyyy"
                        autocomplete="off"
                    >
                </div>
                <div class="col-md-6 col-xl-3">
                    <label class="form-label" for="filter_petugas">Petugas Pembatal</label>
                    <input id="filter_petugas" data-key="petugas" class="form-control filter" placeholder="Nama petugas pembatal">
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mt-3">
            <div class="d-flex flex-wrap gap-2">
                <button type="button" id="tampil" class="btn btn-primary">
                    <i class="ri-search-line me-1"></i>Tampilkan
                </button>
                <button type="button" id="reset" class="btn btn-light">
                    <i class="ri-refresh-line me-1"></i>Reset
                </button>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" id="cetak" class="btn btn-secondary">
                    <i class="ri-printer-line me-1"></i>Cetak / Simpan PDF
                </button>
                <a id="export" class="btn btn-success">
                    <i class="ri-file-excel-2-line me-1"></i>Ekspor Excel
                </a>
            </div>
        </div>
    </div>
</div>

<div id="summary" class="row g-3 mb-3"></div>

<div id="chartCard" class="card d-none">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title mb-1">Grafik <?= html_escape($title) ?></h4>
            <p class="text-muted mb-0">Ringkasan visual berdasarkan filter aktif.</p>
        </div>
    </div>
    <div class="card-body">
        <div id="chart"></div>
    </div>
</div>

<div class="card">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title mb-1"><?= html_escape($title) ?></h4>
            <p class="text-muted mb-0">
                Ditampilkan <?= date('d-m-Y H:i') ?> oleh <?= html_escape(app_user_name()) ?>
            </p>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead id="thead"></thead>
                <tbody id="tbody">
                    <tr>
                        <td class="empty-state">Klik Tampilkan untuk memuat laporan.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div
            id="pagination-wrapper"
            class="d-none flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3 no-print"
        >
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

<style>
@media print {
    #pagination-wrapper {
        display: none !important;
    }

    .report-row {
        display: table-row !important;
    }
}
</style>

<script>
$(function () {
    var chart = null;
    var type = '<?= $type ?>';

    function money(value) {
        return 'Rp' + Number(value || 0).toLocaleString('id-ID');
    }

    function filters() {
        var params = {};
        $('.filter').each(function () {
            params[$(this).data('key')] = $(this).val();
        });
        return params;
    }

    function isMoneySummary(label) {
        return /target|pembayaran|sisa|tunggakan|dibatalkan|nominal|total bayar/i.test(label);
    }

    function syncClassOptions() {
        var period = String($('.filter-periode').val() || '');
        $('.filter-kelas').each(function () {
            var $select = $(this);
            $select.find('option').each(function () {
                if (!this.value) {
                    this.hidden = false;
                    this.disabled = false;
                    return;
                }

                var matches = !period || String($(this).data('periode')) === period;
                this.hidden = !matches;
                this.disabled = !matches;
            });

            if ($select.find('option:selected').prop('disabled')) {
                $select.val('');
            }
        });
    }

    function renderSummary(summary) {
        var html = Object.entries(summary || {}).map(function (entry) {
            var label = entry[0];
            var value = entry[1];
            var displayValue = isMoneySummary(label) ? money(value) : escapeHtml(value);

            return '<div class="col-sm-6 col-xl-3">' +
                '<div class="card h-100 mb-0">' +
                    '<div class="card-body">' +
                        '<small class="text-muted d-block mb-1">' + escapeHtml(label) + '</small>' +
                        '<h4 class="mb-0">' + displayValue + '</h4>' +
                    '</div>' +
                '</div>' +
            '</div>';
        }).join('');

        $('#summary').html(html);
    }

    function renderTable(response) {
        var keys = Object.keys(response.columns || {});
        var moneyKeys = response.money || [];
        var rows = response.rows || [];

        $('#thead').html(
            '<tr><th style="width: 60px">No</th>' +
            keys.map(function (key) {
                var alignment = moneyKeys.includes(key) ? 'text-end' : '';
                return '<th class="' + alignment + '">' + escapeHtml(response.columns[key]) + '</th>';
            }).join('') +
            '</tr>'
        );

        if (!rows.length) {
            $('#tbody').html(
                '<tr><td colspan="' + (keys.length + 1) + '" class="empty-state">Tidak ada data sesuai filter.</td></tr>'
            );
            $('#pagination').empty();
            $('#pagination-wrapper').addClass('d-none').removeClass('d-flex');
            return;
        }

        var html = rows.map(function (row, index) {
            return '<tr class="report-row">' +
                '<td>' + (index + 1) + '</td>' +
                keys.map(function (key) {
                    var isMoney = moneyKeys.includes(key);
                    var alignment = isMoney ? 'text-end' : '';
                    var value = isMoney ? money(row[key]) : escapeHtml(row[key] == null ? '' : row[key]);
                    return '<td class="' + alignment + '">' + value + '</td>';
                }).join('') +
            '</tr>';
        }).join('');

        $('#tbody').html(html);
        $('#pagination-wrapper').removeClass('d-none').addClass('d-flex');

        var pageSize = parseInt($('#dt-length-0').val(), 10) || 10;
        paging($('#tbody .report-row'), pageSize, '#pagination');
    }

    function renderChart(chartData) {
        if (chartData && chartData.labels && chartData.labels.length) {
            $('#chartCard').removeClass('d-none');

            if (chart) {
                chart.destroy();
            }

            chart = new ApexCharts(document.querySelector('#chart'), {
                chart: {
                    type: 'bar',
                    height: 330,
                    toolbar: { show: false }
                },
                series: chartData.series,
                xaxis: { categories: chartData.labels },
                dataLabels: { enabled: false },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return Number(value).toLocaleString('id-ID');
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return money(value);
                        }
                    }
                }
            });
            chart.render();
            return;
        }

        $('#chartCard').addClass('d-none');
        if (chart) {
            chart.destroy();
            chart = null;
        }
    }

    function loadReport() {
        $('#tbody').html('<tr><td class="empty-state"><span class="spinner-border spinner-border-sm me-1"></span>Memuat laporan...</td></tr>');
        $('#pagination').empty();
        $('#pagination-wrapper').addClass('d-none').removeClass('d-flex');

        $.ajax({
            url: '<?= base_url('admin/laporan/laporan/result/') ?>' + type,
            type: 'POST',
            data: filters(),
            dataType: 'JSON',
            success: function (response) {
                if (response.result !== 'true') {
                    Swal.fire('Gagal', response.message, 'error');
                    return;
                }

                renderTable(response);
                renderSummary(response.summary);
                renderChart(response.chart);
            },
            error: function (xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }

    flatpickr('.tanggal-picker', {
        dateFormat: 'd-m-Y',
        allowInput: true,
        disableMobile: true
    });

    syncClassOptions();

    $('.filter-periode').on('change', function () {
        syncClassOptions();
    });

    $('#tampil').on('click', loadReport);
    $('#reset').on('click', function () {
        location.reload();
    });
    $('#cetak').on('click', function () {
        var printRoutes = {
            harian: 'pembayaran_harian',
            bulanan: 'pembayaran_bulanan',
            tahunan: 'pembayaran_tahunan',
            per_kelas: 'rekap_per_kelas',
            per_jenis: 'rekap_per_jenis',
            tunggakan: 'laporan_tunggakan',
            pembatalan: 'riwayat_pembatalan'
        };
        var route = printRoutes[type];
        if (!route) {
            return;
        }
        var url = '<?= base_url('admin/data_laporan/'); ?>' + route + '?' + new URLSearchParams(filters()).toString();
        window.open(url, '_blank');
    });
    $('#export').on('click', function () {
        this.href = '<?= base_url('admin/laporan/laporan/export/') ?>' + type + '?' + new URLSearchParams(filters()).toString();
    });
    $('#dt-length-0').on('change', function () {
        var pageSize = parseInt($(this).val(), 10) || 10;
        paging($('#tbody .report-row'), pageSize, '#pagination');
    });

    $('.filter').on('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            loadReport();
        }
    });

    loadReport();
});
</script>
