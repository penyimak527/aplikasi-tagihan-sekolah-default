<?php
$default_periode = '';
foreach ($periode as $row_periode) {
    if (isset($row_periode['status']) && $row_periode['status'] === 'Aktif') {
        $default_periode = (int) $row_periode['id'];
        break;
    }
}
$admin_laporan = $this->session->userdata('admin');
$admin_laporan = is_array($admin_laporan) ? $admin_laporan : array();
$admin_laporan_nama = isset($admin_laporan['nama']) && $admin_laporan['nama'] !== '' ? $admin_laporan['nama'] : (isset($admin_laporan['username']) ? $admin_laporan['username'] : 'Administrator');
$nama_bulan = array(1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember');
?>

<div class="card">
    <div class="card-header border-bottom border-dashed">
        <h4 class="header-title mb-0">Data Laporan</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="cari-data-laporan" placeholder="Cari Laporan" autocomplete="off">
                    <button type="button" class="btn btn-primary" id="btn-cari-laporan"><i class="ri-search-line"></i></button>
                </div>
            </div>
        </div>
        <div id="data-laporan" style="height:500px;overflow-y:auto;padding-right:8px;">
            <div class="text-center text-muted py-4"><span class="spinner-border spinner-border-sm me-1"></span>Memuat laporan...</div>
        </div>
    </div>
</div>

<div class="modal fade" id="printLaporan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Laporan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_laporan" onsubmit="return false;">
                    <input type="hidden" name="path" id="path">
                    <input type="hidden" name="key_laporan" id="key_laporan">

                    <!-- Filter waktu universal. Disembunyikan hanya untuk Rekap Per Jenis. -->
                    <div id="filter-data">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="form-check ps-0">
                                    <input type="radio" name="filter" id="filter_hari" value="tanggal" checked>
                                    <label for="filter_hari" class="ms-1">Hari</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check ps-0">
                                    <input type="radio" name="filter" id="filter_bulan_radio" value="bulan">
                                    <label for="filter_bulan_radio" class="ms-1">Bulan</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check ps-0">
                                    <input type="radio" name="filter" id="filter_tahun_radio" value="tahun">
                                    <label for="filter_tahun_radio" class="ms-1">Tahun</label>
                                </div>
                            </div>
                        </div>

                        <div id="form-hari" class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1">Start</label>
                                    <input type="date" class="form-control" name="dari_tanggal" id="dari_tanggal" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1">End</label>
                                    <input type="date" class="form-control" name="sampai_tanggal" id="sampai_tanggal" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>

                        <div id="form-bulan" class="row mb-3" style="display:none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1">Bulan</label>
                                    <select class="form-control" name="bulan" id="filter_bulan">
                                        <?php foreach ($nama_bulan as $no => $nama): ?>
                                            <option value="<?= $no ?>" <?= $no == (int) date('n') ? 'selected' : '' ?>><?= html_escape($nama) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mb-1">Tahun</label>
                                    <select class="form-control" name="tahun_bulan" id="filter_tahun_bulan">
                                        <?php foreach ($tahun_kalender as $tahun): ?>
                                            <option value="<?= (int) $tahun ?>" <?= (int) $tahun === (int) date('Y') ? 'selected' : '' ?>><?= (int) $tahun ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="form-tahun" class="row mb-3" style="display:none;">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="mb-1">Tahun</label>
                                    <select class="form-control" name="single_filter_tahun" id="single_filter_tahun">
                                        <?php foreach ($tahun_kalender as $tahun): ?>
                                            <option value="<?= (int) $tahun ?>" <?= (int) $tahun === (int) date('Y') ? 'selected' : '' ?>><?= (int) $tahun ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Filter Tahun Ajaran -->
                    <div id="field-periode" class="report-field row g-2" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Tahun Ajaran</label>
                                <select name="periode" id="filter_periode" class="form-control" data-default="<?= $default_periode ?>">
                                    <option value="">Semua Tahun Ajaran</option>
                                    <?php foreach ($periode as $row): ?>
                                        <option value="<?= (int) $row['id'] ?>" <?= isset($row['status']) && $row['status'] === 'Aktif' ? 'selected' : '' ?>><?= html_escape($row['periode']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="field-kelas" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Kelas</label>
                                <select name="kelas" id="filter_kelas" class="form-control">
                                    <option value="">Semua Kelas</option>
                                    <?php foreach ($kelas as $row): ?>
                                        <option value="<?= (int) $row['id'] ?>" data-periode="<?= (int) $row['id_periode'] ?>"><?= html_escape($row['nama_kelas']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="field-jenis" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Jenis Tagihan</label>
                                <select name="jenis" id="filter_jenis" class="form-control">
                                    <option value="">Semua Jenis</option>
                                    <?php foreach ($jenis as $row): ?>
                                        <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_jenis']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="field-sampai-bulan" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Sampai Bulan</label>
                                <select name="sampai_bulan" id="filter_sampai_bulan" class="form-control">
                                    <option value="">Semua Bulan</option>
                                    <?php foreach (array(7,8,9,10,11,12,1,2,3,4,5,6) as $no): ?>
                                        <option value="<?= $no ?>"><?= html_escape($nama_bulan[$no]) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="field-metode" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Metode</label>
                                <select name="metode" id="filter_metode" class="form-control">
                                    <option value="">Semua Metode</option>
                                    <?php foreach ($metode as $row): ?>
                                        <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_metode']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="field-petugas" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Petugas</label>
                                <input type="text" name="petugas" id="filter_petugas" class="form-control" placeholder="Nama petugas">
                            </div>
                        </div>
                    </div> -->

                    <div id="field-status" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Status</label>
                                <select name="status" id="filter_status" class="form-control">
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                    <option value="Semua">Semua Status</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="field-status-siswa" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Status Siswa</label>
                                <select name="status_siswa" id="filter_status_siswa" class="form-control">
                                    <option value="Aktif" selected>Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Semua">Semua Status</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="field-periode-jenis" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">Periode</label>
                                <select name="periode_jenis" id="filter_periode_jenis" class="form-control">
                                    <option value="">Semua Periode</option>
                                    <?php foreach (array(7,8,9,10,11,12,1,2,3,4,5,6) as $no): ?>
                                        <option value="<?= $no ?>"><?= html_escape($nama_bulan[$no]) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="field-q" class="report-field row g-2 mt-1" style="display:none;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="mb-1">No Transaksi / Nama Siswa</label>
                                <input type="text" name="q" id="filter_q" class="form-control" placeholder="Cari nomor transaksi atau nama siswa">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="btn_print_laporan_excel"><i class="ri-file-excel-2-line me-1"></i>Excel</button>
                <button type="button" class="btn btn-info text-white" id="btn_print_laporan"><i class="ri-printer-line me-1"></i>Print</button>
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- HTML table hasil AJAX. Table inilah yang dibaca button Excel seperti pola CMV acuan. -->
<div style="display:none;">
    <table id="data_laporan_pembayaran" border="1"></table>
    <table id="data_laporan_rekap_per_kelas" border="1"></table>
    <table id="data_laporan_rekap_per_jenis" border="1"></table>
    <table id="data_laporan_tunggakan" border="1"></table>
    <table id="data_laporan_riwayat_pembatalan" border="1"></table>
</div>

<style>
.report-panel{border:1px solid #e4e7ec;border-radius:5px;background:#fff;margin-bottom:24px;box-shadow:0 1px 4px rgba(0,0,0,.08)}
.report-panel-header{padding:17px 22px;border-bottom:1px solid #e9ecef}.report-panel-header h4{margin:0;font-weight:500}
.report-panel-body{padding:22px}.report-field{margin-top:8px}
</style>

<script>
$(document).ready(function () {
    var laporanAktif = '';
    var pathAktif = '';
    var namaAktif = '';

    function esc(text) {
        return $('<div>').text(text == null ? '' : text).html();
    }

    function data_laporan() {
        $.ajax({
            url: '<?= base_url('admin/laporan/laporan_result') ?>',
            type: 'POST',
            data: { search: $('#cari-data-laporan').val() },
            dataType: 'JSON',
            success: function (data) {
                var html = '';
                if (!Array.isArray(data) || data.length === 0) {
                    html = '<div class="text-center text-muted py-4">Tidak ada data</div>';
                } else {
                    data.forEach(function (item) {
                        html += '<div class="report-panel">' +
                            '<div class="report-panel-header"><h4>' + esc(item.name) + '</h4></div>' +
                            '<div class="report-panel-body">' +
                                '<button type="button" class="btn btn-primary" onclick="klik_laporan(\'' + esc(item.name).replace(/'/g,"\\'") + '\',\'' + esc(item.path).replace(/'/g,"\\'") + '\',\'' + esc(item.key) + '\')">' +
                                    '<i class="ri-bookmark-fill me-1"></i>Buka Laporan' +
                                '</button>' +
                            '</div>' +
                        '</div>';
                    });
                }
                $('#data-laporan').html(html);
            },
            error: function () {
                $('#data-laporan').html('<div class="text-center text-danger py-4">Daftar laporan gagal dimuat.</div>');
            }
        });
    }

    window.klik_laporan = function (nama, path, key) {
        laporanAktif = key;
        pathAktif = path;
        namaAktif = nama;
        $('#myLargeModalLabel').html(nama);
        $('#path').val(path);
        $('#key_laporan').val(key);
        reset_filter();
        atur_form_laporan();
        bootstrap.Modal.getOrCreateInstance(document.getElementById('printLaporan')).show();
    };

    function reset_filter() {
        $('#filter_hari').prop('checked', true);
        $('#dari_tanggal,#sampai_tanggal').val('<?= date('Y-m-d') ?>');
        $('#filter_bulan').val('<?= date('n') ?>');
        $('#filter_tahun_bulan,#single_filter_tahun').val('<?= date('Y') ?>');
        $('#filter_periode').val(String($('#filter_periode').data('default') || ''));
        $('#filter_kelas,#filter_jenis,#filter_metode,#filter_periode_jenis,#filter_sampai_bulan').val('');
        $('#filter_petugas,#filter_q').val('');
        $('#filter_status').val('Aktif');
        $('#filter_status_siswa').val('Aktif');
        form_waktu();
        filter_kelas_periode();
    }

    function form_waktu() {
        var filter = $('input[name="filter"]:checked').val();
        $('#form-hari,#form-bulan,#form-tahun').hide();
        if (filter === 'tanggal') $('#form-hari').show();
        if (filter === 'bulan') $('#form-bulan').show();
        if (filter === 'tahun') $('#form-tahun').show();
    }

    function tampil_field(ids) {
        $('.report-field').hide();
        ids.forEach(function (id) { $('#' + id).show(); });
    }

    function atur_form_laporan() {
        $('#filter-data').show();
        form_waktu();

        if (laporanAktif === 'pembayaran') {
            // Ketiga laporan pembayaran digabung, sehingga filter tambahannya dibuat sama untuk Hari/Bulan/Tahun.
            tampil_field(['field-periode','field-kelas','field-jenis','field-metode','field-status']);
            return;
        }
        if (laporanAktif === 'per_kelas') {
            // Sampai Bulan pada wireframe digantikan radio Hari/Bulan/Tahun, sehingga tidak ada field Sampai Bulan lagi.
            tampil_field(['field-periode','field-jenis']);
            return;
        }
        if (laporanAktif === 'per_jenis') {
            // Sesuai wireframe: Tahun Ajaran + Kelas + Periode saja.
            $('#filter-data').hide();
            tampil_field(['field-periode','field-kelas','field-periode-jenis']);
            return;
        }
        if (laporanAktif === 'tunggakan') {
            // Laporan Tunggakan menggunakan Tahun Ajaran + Sampai Bulan, tanpa filter Hari/Bulan/Tahun.
            $('#filter-data').hide();
            tampil_field(['field-periode','field-kelas','field-jenis','field-sampai-bulan','field-status-siswa']);
            return;
        }
        if (laporanAktif === 'pembatalan') {
            tampil_field(['field-q']);
            return;
        }
        tampil_field([]);
    }

    function filter_kelas_periode() {
        var periode = $('#filter_periode').val();
        $('#filter_kelas option').each(function () {
            if ($(this).val() === '') {
                $(this).prop('hidden', false);
            } else {
                $(this).prop('hidden', periode !== '' && String($(this).data('periode')) !== String(periode));
            }
        });
        $('#filter_kelas').val('');
    }

    function data_post() {
        var filter = $('input[name="filter"]:checked').val() || 'tanggal';
        return {
            filter: filter,
            dari_tanggal: $('#dari_tanggal').val(),
            sampai_tanggal: $('#sampai_tanggal').val(),
            bulan: $('#filter_bulan').val(),
            tahun: filter === 'bulan' ? $('#filter_tahun_bulan').val() : $('#single_filter_tahun').val(),
            periode: $('#filter_periode').val(),
            kelas: $('#filter_kelas').val(),
            jenis: $('#filter_jenis').val(),
            metode: $('#filter_metode').val(),
            petugas: $('#filter_petugas').val(),
            status: $('#filter_status').val(),
            status_siswa: $('#filter_status_siswa').val(),
            periode_jenis: $('#filter_periode_jenis').val(),
            sampai_bulan: $('#filter_sampai_bulan').val(),
            q: $('#filter_q').val()
        };
    }

    function isi_table_excel(idTable, response) {
        var columns = response.columns || {};
        var keys = Object.keys(columns);
        var colspan = Math.max(2, keys.length + 1);
        var html = '<tbody>';
        html += '<tr><th colspan="' + colspan + '">' + esc(response.title || namaAktif) + '</th></tr>';
        html += '<tr><td colspan="' + colspan + '"></td></tr>';
        Object.keys(response.filters || {}).forEach(function (label) {
            html += '<tr><td>' + esc(label) + '</td><td>' + esc(response.filters[label]) + '</td>';
            if (colspan > 2) html += '<td colspan="' + (colspan - 2) + '"></td>';
            html += '</tr>';
        });
        html += '<tr><td>Tanggal Ekspor</td><td><?= date('d-m-Y') ?></td>' + (colspan > 2 ? '<td colspan="' + (colspan - 2) + '"></td>' : '') + '</tr>';
        html += '<tr><td>Petugas</td><td><?= html_escape($admin_laporan_nama) ?></td>' + (colspan > 2 ? '<td colspan="' + (colspan - 2) + '"></td>' : '') + '</tr>';
        html += '<tr><td colspan="' + colspan + '"></td></tr>';
        html += '<tr><th>No</th>';
        keys.forEach(function (key) { html += '<th>' + esc(columns[key]) + '</th>'; });
        html += '</tr>';
        (response.rows || []).forEach(function (row, index) {
            html += '<tr><td>' + (index + 1) + '</td>';
            keys.forEach(function (key) {
                var value = row[key] == null ? '' : row[key];
                if ((response.money || []).indexOf(key) !== -1 || /realisasi|\(%\)/i.test(columns[key] || '')) {
                    html += '<td>' + Number(value || 0) + '</td>';
                } else {
                    html += '<td>' + esc(value) + '</td>';
                }
            });
            html += '</tr>';
        });
        if (Object.keys(response.summary || {}).length) {
            html += '<tr><td colspan="' + colspan + '"></td></tr>';
            Object.keys(response.summary).forEach(function (label) {
                var value = response.summary[label];
                html += '<tr><td>' + esc(label) + '</td><td>' + (!isNaN(value) && value !== '' ? Number(value) : esc(value)) + '</td>';
                if (colspan > 2) html += '<td colspan="' + (colspan - 2) + '"></td>';
                html += '</tr>';
            });
        }
        html += '</tbody>';
        $('#' + idTable).html(html);
    }

    function download_excel(idTable) {
        if (typeof XLSX === 'undefined') {
            Swal.fire('Gagal', 'Library XLSX belum tersedia.', 'error');
            return;
        }
        var table = document.getElementById(idTable);
        var workbook = XLSX.utils.table_to_book(table, { sheet: 'Laporan', raw: true });
        var sheet = workbook.Sheets['Laporan'];
        if (sheet) sheet['!cols'] = Array(12).fill({ wch: 20 });
        var filename = (namaAktif || 'laporan').toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_|_$/g, '') + '_' + '<?= date('Ymd') ?>' + '.xlsx';
        XLSX.writeFile(workbook, filename);
    }

    function data_laporan_pembayaran(callback) {
        $.ajax({
            url: '<?= base_url('admin/laporan/laporan_pembayaran') ?>', type: 'POST', data: data_post(), dataType: 'JSON',
            success: function (data) { if (data.result !== 'true') { $('#btn_print_laporan_excel').prop('disabled', false); return Swal.fire('Gagal', data.message || 'Gagal membuat laporan.', 'error'); } isi_table_excel('data_laporan_pembayaran', data); callback(); },
            error: function(xhr){ $('#btn_print_laporan_excel').prop('disabled', false); ajaxError(xhr); }
        });
    }
    function data_laporan_rekap_per_kelas(callback) {
        $.ajax({
            url: '<?= base_url('admin/laporan/laporan_rekap_per_kelas') ?>', type: 'POST', data: data_post(), dataType: 'JSON',
            success: function (data) { if (data.result !== 'true') { $('#btn_print_laporan_excel').prop('disabled', false); return Swal.fire('Gagal', data.message || 'Gagal membuat laporan.', 'error'); } isi_table_excel('data_laporan_rekap_per_kelas', data); callback(); },
            error: function(xhr){ $('#btn_print_laporan_excel').prop('disabled', false); ajaxError(xhr); }
        });
    }
    function data_laporan_rekap_per_jenis(callback) {
        $.ajax({
            url: '<?= base_url('admin/laporan/laporan_rekap_per_jenis') ?>', type: 'POST', data: data_post(), dataType: 'JSON',
            success: function (data) { if (data.result !== 'true') { $('#btn_print_laporan_excel').prop('disabled', false); return Swal.fire('Gagal', data.message || 'Gagal membuat laporan.', 'error'); } isi_table_excel('data_laporan_rekap_per_jenis', data); callback(); },
            error: function(xhr){ $('#btn_print_laporan_excel').prop('disabled', false); ajaxError(xhr); }
        });
    }
    function data_laporan_tunggakan(callback) {
        $.ajax({
            url: '<?= base_url('admin/laporan/laporan_tunggakan') ?>', type: 'POST', data: data_post(), dataType: 'JSON',
            success: function (data) { if (data.result !== 'true') { $('#btn_print_laporan_excel').prop('disabled', false); return Swal.fire('Gagal', data.message || 'Gagal membuat laporan.', 'error'); } isi_table_excel('data_laporan_tunggakan', data); callback(); },
            error: function(xhr){ $('#btn_print_laporan_excel').prop('disabled', false); ajaxError(xhr); }
        });
    }
    function data_laporan_riwayat_pembatalan(callback) {
        $.ajax({
            url: '<?= base_url('admin/laporan/laporan_riwayat_pembatalan') ?>', type: 'POST', data: data_post(), dataType: 'JSON',
            success: function (data) { if (data.result !== 'true') { $('#btn_print_laporan_excel').prop('disabled', false); return Swal.fire('Gagal', data.message || 'Gagal membuat laporan.', 'error'); } isi_table_excel('data_laporan_riwayat_pembatalan', data); callback(); },
            error: function(xhr){ $('#btn_print_laporan_excel').prop('disabled', false); ajaxError(xhr); }
        });
    }

    $('#btn_print_laporan_excel').click(function () {
        var btn = $(this);
        btn.prop('disabled', true);
        function selesai() { btn.prop('disabled', false); }
        if (laporanAktif === 'pembayaran') return data_laporan_pembayaran(function(){ download_excel('data_laporan_pembayaran'); selesai(); });
        if (laporanAktif === 'per_kelas') return data_laporan_rekap_per_kelas(function(){ download_excel('data_laporan_rekap_per_kelas'); selesai(); });
        if (laporanAktif === 'per_jenis') return data_laporan_rekap_per_jenis(function(){ download_excel('data_laporan_rekap_per_jenis'); selesai(); });
        if (laporanAktif === 'tunggakan') return data_laporan_tunggakan(function(){ download_excel('data_laporan_tunggakan'); selesai(); });
        if (laporanAktif === 'pembatalan') return data_laporan_riwayat_pembatalan(function(){ download_excel('data_laporan_riwayat_pembatalan'); selesai(); });
        selesai();
    });

    $('#btn_print_laporan').click(function () {
        if (!pathAktif) {
            Swal.fire('Gagal', 'Path laporan belum tersedia di database.', 'error');
            return;
        }
        var indexed_array = data_post();
        indexed_array['print'] = 'pdf';
        var myWindow = window.open('', '_blank');
        if (!myWindow) {
            Swal.fire('Gagal', 'Popup diblokir browser.', 'warning');
            return;
        }
        myWindow.document.write('<div style="font-family:Arial;padding:20px">Memuat laporan...</div>');
        $.ajax({
            url: '<?= base_url() ?>' + pathAktif + '/print_laporan',
            data: JSON.stringify(indexed_array),
            contentType: 'application/json',
            type: 'POST',
            success: function (result) {
                myWindow.document.open();
                myWindow.document.write(result);
                myWindow.document.close();
            },
            error: function (xhr) {
                myWindow.document.open();
                myWindow.document.write('<pre>' + esc(xhr.responseText || 'Laporan gagal dimuat.') + '</pre>');
                myWindow.document.close();
            }
        });
    });

    $('input[name="filter"]').click(form_waktu);
    $('#filter_periode').change(filter_kelas_periode);
    $('#btn-cari-laporan').click(data_laporan);
    $('#cari-data-laporan').on('keyup', data_laporan);
    data_laporan();
});
</script>
