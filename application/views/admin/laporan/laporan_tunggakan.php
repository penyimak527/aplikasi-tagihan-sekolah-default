
<div class="card no-print">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title mb-1">Filter <?= html_escape($title) ?></h4>
            <p class="text-muted mb-0">Hasil laporan, cetak, dan ekspor mengikuti filter yang dipilih.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-end" id="filters">

            <div class="col-md-6 col-xl-3">
                <label class="form-label" for="filter_periode">Tahun Ajaran</label>
                <select id="filter_periode" class="form-select">
                    <option value="">Semua Tahun</option>
                    <?php foreach ($periode as $row): ?>
                        <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['periode']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 col-xl-3">
                <label class="form-label" for="filter_kelas">Kelas</label>
                <select id="filter_kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                </select>
            </div>
            <div class="col-md-6 col-xl-2">
                <label class="form-label" for="filter_jenis">Jenis Tagihan</label>
                <select id="filter_jenis" class="form-select">
                    <option value="">Semua Jenis</option>
                    <?php foreach ($jenis as $row): ?>
                        <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_jenis']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 col-xl-2">
                <label class="form-label" for="filter_sampai_bulan">Sampai Bulan</label>
                <select id="filter_sampai_bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    <?php foreach (array(7,8,9,10,11,12,1,2,3,4,5,6) as $month): ?>
                        <option value="<?= $month ?>"><?= nama_bulan($month) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6 col-xl-2">
                <label class="form-label" for="filter_status_siswa">Status Siswa</label>
                <select id="filter_status_siswa" class="form-select">
                    <option value="Aktif">Aktif</option>
                    <option value="Semua">Semua</option>
                    <option value="Lulus">Lulus</option>
                    <option value="Berhenti">Berhenti</option>
                    <option value="Pindah Sekolah">Pindah Sekolah</option>
                </select>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-between gap-2 mt-3">
            <div class="d-flex flex-wrap gap-2">
                <button type="button" id="tampil" class="btn btn-primary"><i class="ri-search-line me-1"></i>Tampilkan</button>
                <button type="button" id="reset" class="btn btn-light"><i class="ri-refresh-line me-1"></i>Reset</button>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <button type="button" id="cetak" class="btn btn-secondary"><i class="ri-printer-line me-1"></i>Cetak / Simpan PDF</button>
                <a id="export" class="btn btn-success"><i class="ri-file-excel-2-line me-1"></i>Ekspor Excel</a>
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
    <div class="card-body"><div id="chart"></div></div>
</div>

<div class="card">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title mb-1"><?= html_escape($title) ?></h4>
            <p class="text-muted mb-0">Ditampilkan <?= date('d-m-Y H:i') ?> oleh <?= html_escape(app_user_name()) ?></p>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle mb-0">
                <thead id="thead"></thead>
                <tbody id="tbody"><tr><td class="empty-state">Klik Tampilkan untuk memuat laporan.</td></tr></tbody>
            </table>
        </div>
        <div id="pagination-wrapper" class="d-none flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3 no-print">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-0" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-0">
                    <option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                </select>
                <span>entri</span>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    #pagination-wrapper { display: none !important; }
    .report-row { display: table-row !important; }
}
</style>

<script>
$(document).ready(function () {
    var chart = null;

    function numberFormat(value) {
        return Number(value || 0).toLocaleString('id-ID', { maximumFractionDigits: 2 });
    }

    function money(value) {
        return 'Rp' + Number(value || 0).toLocaleString('id-ID', { maximumFractionDigits: 0 });
    }

    function reportData() {
        return {
            periode: $('#filter_periode').val(),
            kelas: $('#filter_kelas').val(),
            jenis: $('#filter_jenis').val(),
            sampai_bulan: $('#filter_sampai_bulan').val(),
            status_siswa: $('#filter_status_siswa').val()
        };
    }

    function isMoneySummary(label) {
        return /target|pembayaran|sisa|tunggakan|dibatalkan|nominal|tagihan|dibayar|total bayar/i.test(label);
    }

    function renderSummary(summary) {
        var html = Object.entries(summary || {}).map(function (entry) {
            var label = entry[0];
            var value = entry[1];
            var displayValue;

            if (isMoneySummary(label)) {
                displayValue = money(value);
            } else if (/realisasi|\(%\)/i.test(label)) {
                displayValue = numberFormat(value) + '%';
            } else if (/jumlah/i.test(label) && !isNaN(value)) {
                displayValue = numberFormat(value);
            } else {
                displayValue = escapeHtml(value);
            }

            return '<div class="col-sm-6 col-xl-3">' +
                '<div class="card h-100 mb-0"><div class="card-body">' +
                '<small class="text-muted d-block mb-1">' + escapeHtml(label) + '</small>' +
                '<h4 class="mb-0">' + displayValue + '</h4>' +
                '</div></div></div>';
        }).join('');

        $('#summary').html(html);
    }

    function renderTable(response) {
        var keys = Object.keys(response.columns || {});
        var moneyKeys = response.money || [];
        var rows = response.rows || [];

        $('#thead').html('<tr><th style="width:60px">No</th>' + keys.map(function (key) {
            return '<th class="' + (moneyKeys.includes(key) ? 'text-end' : '') + '">' + escapeHtml(response.columns[key]) + '</th>';
        }).join('') + '</tr>');

        if (!rows.length) {
            $('#tbody').html('<tr><td colspan="' + (keys.length + 1) + '" class="empty-state">Tidak ada data sesuai filter.</td></tr>');
            $('#pagination').empty();
            $('#pagination-wrapper').addClass('d-none').removeClass('d-flex');
            return;
        }

        $('#tbody').html(rows.map(function (row, index) {
            return '<tr class="report-row"><td>' + (index + 1) + '</td>' + keys.map(function (key) {
                var label = response.columns[key] || '';
                var value = row[key] == null ? '' : row[key];
                var display = escapeHtml(value);
                var align = '';

                if (moneyKeys.includes(key)) {
                    display = money(value);
                    align = 'text-end';
                } else if (/realisasi|\(%\)/i.test(label)) {
                    display = numberFormat(value) + '%';
                    align = 'text-end';
                } else if (/^Jumlah/i.test(label) && value !== '' && !isNaN(value)) {
                    display = numberFormat(value);
                    align = 'text-end';
                }

                return '<td class="' + align + '">' + display + '</td>';
            }).join('') + '</tr>';
        }).join(''));

        $('#pagination-wrapper').removeClass('d-none').addClass('d-flex');
        paging($('#tbody .report-row'), parseInt($('#dt-length-0').val(), 10) || 10, '#pagination');
    }

    function renderChart(chartData) {
        if (chartData && chartData.labels && chartData.labels.length) {
            $('#chartCard').removeClass('d-none');
            if (chart) chart.destroy();
            chart = new ApexCharts(document.querySelector('#chart'), {
                chart: { type: 'bar', height: 330, toolbar: { show: false } },
                series: chartData.series,
                xaxis: { categories: chartData.labels },
                dataLabels: { enabled: false },
                yaxis: { labels: { formatter: function (value) { return numberFormat(value); } } },
                tooltip: { y: { formatter: function (value) { return money(value); } } }
            });
            chart.render();
        } else {
            $('#chartCard').addClass('d-none');
            if (chart) { chart.destroy(); chart = null; }
        }
    }

    function loadReport() {
        $('#tbody').html('<tr><td class="empty-state"><span class="spinner-border spinner-border-sm me-1"></span>Memuat laporan...</td></tr>');
        $('#pagination').empty();
        $('#pagination-wrapper').addClass('d-none').removeClass('d-flex');

        $.ajax({
            url: '<?= base_url('admin/laporan/laporan/result/tunggakan') ?>',
            type: 'POST',
            data: reportData(),
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


    function kelasResult() {
        var periode = $('#filter_periode').val();
        var $kelas = $('#filter_kelas');

        $kelas.html('<option value="">Semua Kelas</option>');
        if (!periode) {
            return;
        }

        $.ajax({
            url: '<?= base_url('admin/laporan/laporan/kelas_result') ?>',
            type: 'POST',
            data: {
                periode: periode
            },
            dataType: 'JSON',
            success: function (response) {
                if (response.result !== 'true') {
                    return;
                }

                var option = '<option value="">Semua Kelas</option>';
                $.each(response.data || [], function (index, row) {
                    option += '<option value="' + row.id + '">' + escapeHtml(row.nama_kelas) + '</option>';
                });
                $kelas.html(option);
            },
            error: function (xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }

    $('#filter_periode').on('change', function () {
        kelasResult();
    });

    flatpickr('.tanggal-picker', {
        dateFormat: 'd-m-Y',
        allowInput: true,
        disableMobile: true
    });

    $('#tampil').on('click', function () { loadReport(); });
    $('#reset').on('click', function () { location.reload(); });
    $('#cetak').on('click', function () {
        var url = '<?= base_url('admin/data_laporan/laporan_tunggakan') ?>?' + new URLSearchParams(reportData()).toString();
        window.open(url, '_blank');
    });
    $('#export').on('click', function () {
        this.href = '<?= base_url('admin/laporan/laporan/export/tunggakan') ?>?' + new URLSearchParams(reportData()).toString();
    });
    $('#dt-length-0').on('change', function () {
        paging($('#tbody .report-row'), parseInt($(this).val(), 10) || 10, '#pagination');
    });
    $('#filters input, #filters select').on('keydown', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            loadReport();
        }
    });

    kelasResult();
    loadReport();
});
</script>
