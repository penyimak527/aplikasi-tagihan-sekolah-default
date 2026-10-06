<?php
$bulan = array(
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember'
);

$presetNama = '';
if (!empty($preset_siswa)) {
    $presetNama = $preset_siswa['nama_lengkap'];
    if (!empty($preset_siswa['nis'])) {
        $presetNama .= ' - ' . $preset_siswa['nis'];
    }
}
?>
<div class="card">
    <div class="card-header app-card-header">
        <h4 class="header-title mb-0">Monitoring Tagihan</h4>
    </div>

    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Cari Siswa</label>
                <div class="position-relative">
                    <div class="input-group">
                        <input type="text" class="form-control" id="cari_siswa" 
                        value="<?= html_escape($presetNama) ?>" placeholder="Nama / NIS / NISN ..." autocomplete="off">
                        <button type="button" class="btn btn-outline-primary" id="btn-cari-siswa"><i class="ri-search-line"></i>
                        </button>
                    </div>
                    <div id="hasil_siswa" class="monitoring-siswa-result"></div>
                </div>
                <input type="hidden" id="id_siswa" value="<?= (int) $id_siswa ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label">Tahun Ajaran</label>
                <select id="periode" class="form-select">
                    <option value="">Semua Tahun Ajaran</option>
                    <?php foreach ($periode as $p): ?>
                        <option value="<?= (int) $p['id'] ?>">
                            <?= html_escape($p['periode']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Kelas</label>
                <select id="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?>
                        <option
                            value="<?= (int) $k['id'] ?>"
                            data-period="<?= (int) $k['id_periode'] ?>">
                            <?= html_escape($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Jenis Tagihan</label>
                <select id="jenis" class="form-select">
                    <option value="">Semua Jenis</option>
                    <?php foreach ($jenis as $j): ?>
                        <option value="<?= (int) $j['id'] ?>">
                            <?= html_escape($j['nama_jenis']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Batch/Periode</label>
                <select id="master" class="form-select">
                    <option value="">Semua Batch/Periode</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Tipe Tagihan</label>
                <select id="tipe" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option value="Bulanan">Bulanan</option>
                    <option value="Langsung">Langsung</option>
                    <option value="Tahunan">Tahunan</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Status Pembayaran</label>
                <select id="status_pembayaran" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Belum Dibayar">Belum Dibayar</option>
                    <option value="Dibayar Sebagian">Dibayar Sebagian</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Dibebaskan">Dibebaskan</option>
                    <option value="Dibatalkan">Dibatalkan</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Sampai Bulan</label>
                <select id="sampai_bulan" class="form-select">
                    <option value="">Semua Bulan</option>
                    <?php foreach ($bulan as $nomor => $nama): ?>
                        <option value="<?= (int) $nomor ?>"><?= html_escape($nama) ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button type="button" class="btn btn-primary flex-fill" id="btn-tampil">
                    <i class="ri-search-line me-1"></i>Tampilkan
                </button>
                <button type="button" class="btn btn-light" id="btn-reset" title="Reset Filter">
                    <i class="ri-refresh-line"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card summary-card h-100">
            <div class="card-body">
                <small>Total Tagihan</small>
                <div class="summary-value" id="total_tagihan">Rp0</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card summary-card h-100">
            <div class="card-body">
                <small>Total Dibayar</small>
                <div class="summary-value text-success" id="total_dibayar">Rp0</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card summary-card h-100">
            <div class="card-body">
                <small>Total Sisa</small>
                <div class="summary-value text-danger" id="total_sisa">Rp0</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card summary-card h-100">
            <div class="card-body">
                <small>Realisasi</small>
                <div class="summary-value" id="realisasi">0%</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h4 class="header-title mb-0">Daftar Monitoring Tagihan</h4>
            <small class="text-muted" id="jumlah_data">0 data</small>
        </div>
        <div class="d-flex gap-2 no-print">
            <button type="button" class="btn btn-secondary" id="btn-cetak">
                <i class="ri-printer-line me-1"></i>Cetak
            </button>
            <button type="button" class="btn btn-success" id="btn-export">
                <i class="ri-file-excel-2-line me-1"></i>Ekspor Excel
            </button>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Jenis Tagihan</th>
                        <th>Tagihan</th>
                        <th>Periode</th>
                        <th>Wajib</th>
                        <th class="text-end">Tarif Akhir</th>
                        <th class="text-end">Dibayar</th>
                        <th class="text-end">Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <tr>
                        <td colspan="11" class="empty-state">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3">
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
    .monitoring-siswa-result {
        position: absolute;
        top: calc(100% + 4px);
        left: 0;
        right: 0;
        z-index: 1055;
    }

    .monitoring-siswa-result .list-group {
        max-height: 280px;
        overflow-y: auto;
    }

    #hasil_siswa .monitoring-siswa-item {
        cursor: pointer;
    }

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

    $(document).ready(function() {
        filterKelasByPeriode();
        masters();
        load();

        $('#btn-cari-siswa').on('click', function() {
            cariSiswa();
        });

        $('#cari_siswa').on('keypress', function(e) {
            if (e.which === 13) {
                cariSiswa();
            }
        });

        $('#cari_siswa').on('input', function() {
            $('#id_siswa').val('');
        });

        $(document).on('click', '.monitoring-siswa-item', function() {
            $('#id_siswa').val($(this).data('id'));
            $('#cari_siswa').val($(this).data('label'));
            $('#hasil_siswa').empty();
            load();
        });

        $('#periode').on('change', function() {
            filterKelasByPeriode();
            masters();
        });

        $('#jenis').on('change', function() {
            masters();
        });

        $('#btn-tampil').on('click', function() {
            load();
        });

        $('#btn-reset').on('click', function() {
            resetFilter();
        });

        $('#btn-cetak').on('click', function() {
            cetakData();
        });

        $('#btn-export').on('click', function() {
            exportData();
        });

        $('#dt-length-0').on('change', function() {
            refreshPagination();
        });
    });

    function cariSiswa() {
        var q = $.trim($('#cari_siswa').val());

        if (q.length < 2) {
            Swal.fire('Perhatian', 'Masukkan minimal 2 karakter untuk mencari siswa.', 'warning');
            return;
        }

        $.ajax({
            url: '<?= base_url('admin/tunggakan/monitoring_tagihan/siswa'); ?>',
            type: 'POST',
            data: {
                q: q
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('#hasil_siswa').html('<div class="text-muted small">Mencari siswa...</div>');
            },
            success: function(data) {
                var rows = Array.isArray(data) ? data : [];
                var html = '';

                if (!rows.length) {
                    $('#hasil_siswa').html('<div class="empty-state py-2">Siswa tidak ditemukan.</div>');
                    return;
                }

                html += '<div class="list-group">';
                rows.forEach(function(item) {
                    var label = (item.nama_lengkap || '-') + ' - ' + (item.nis || '-');
                    var info = (item.nisn || '-') + ' | ' + (item.nama_kelas || 'Belum Ditempatkan');

                    html += '<button type="button" class="list-group-item list-group-item-action monitoring-siswa-item" ' +
                        'data-id="' + Number(item.id) + '" ' +
                        'data-label="' + escapeHtml(label) + '">' +
                        '<strong>' + escapeHtml(item.nama_lengkap || '-') + '</strong><br>' +
                        '<small class="text-muted">' + escapeHtml(info) + '</small>' +
                        '</button>';
                });
                html += '</div>';

                $('#hasil_siswa').html(html);
            },
            error: function(xhr, status, error) {
                $('#hasil_siswa').empty();
                ajaxError(xhr, status, error);
            }
        });
    }

    function filterKelasByPeriode() {
        var periode = String($('#periode').val() || '');

        $('#kelas option').each(function() {
            if (!this.value) {
                $(this).prop('hidden', false).prop('disabled', false);
                return;
            }

            var optionPeriode = String($(this).data('period') || '');
            var visible = periode !== '' && optionPeriode === periode;

            $(this)
                .prop('hidden', !visible)
                .prop('disabled', !visible);
        });

        $('#kelas').val('');
    }

    function masters() {
        $.ajax({
            url: '<?= base_url('admin/tunggakan/monitoring_tagihan/master'); ?>',
            type: 'POST',
            data: {
                id_periode: $('#periode').val(),
                id_jenis: $('#jenis').val()
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('#master')
                    .prop('disabled', true)
                    .html('<option value="">Memuat Batch/Periode...</option>');
            },
            success: function(data) {
                var rows = Array.isArray(data) ? data : [];
                var option = '<option value="">Semua Batch/Periode</option>';

                rows.forEach(function(item) {
                    var label = item.nama_tagihan || '-';
                    if (item.tipe_tagihan) {
                        label += ' (' + item.tipe_tagihan + ')';
                    }

                    option += '<option value="' + Number(item.id) + '">' + escapeHtml(label) + '</option>';
                });

                $('#master').html(option);
            },
            error: function(xhr, status, error) {
                $('#master').html('<option value="">Semua Batch/Periode</option>');
                ajaxError(xhr, status, error);
            },
            complete: function() {
                $('#master').prop('disabled', false);
            }
        });
    }

    function filterData() {
        return {
            id_siswa: $('#id_siswa').val(),
            id_periode: $('#periode').val(),
            id_kelas_setting: $('#kelas').val(),
            id_jenis: $('#jenis').val(),
            id_master: $('#master').val(),
            tipe: $('#tipe').val(),
            status: $('#status_pembayaran').val(),
            sampai_bulan: $('#sampai_bulan').val()
        };
    }

    function load() {
        var button = $('#btn-tampil');

        $.ajax({
            url: '<?= base_url('admin/tunggakan/monitoring_tagihan/result'); ?>',
            type: 'POST',
            data: filterData(),
            dataType: 'JSON',
            beforeSend: function() {
                button.prop('disabled', true);
                $('#data').html('<tr><td colspan="11" class="empty-state">Memuat data...</td></tr>');
                $('#pagination').empty();
            },
            success: function(response) {
                var rows = response && Array.isArray(response.rows) ? response.rows : [];
                var summary = response && response.summary ? response.summary : {};

                $('#total_tagihan').text(money(summary.tagihan || 0));
                $('#total_dibayar').text(money(summary.dibayar || 0));
                $('#total_sisa').text(money(summary.sisa || 0));
                $('#realisasi').text(Number(summary.realisasi || 0).toLocaleString('id-ID', {
                    maximumFractionDigits: 2
                }) + '%');
                $('#jumlah_data').text(Number(summary.jumlah_data || rows.length) + ' data');

                var html = '';

                if (!rows.length) {
                    html = '<tr><td colspan="11" class="empty-state">Tidak ada data.</td></tr>';
                } else {
                    rows.forEach(function(item) {
                        var status = item.status_pembayaran || '-';
                        var statusClass = statusClassName(status);
                        var wajib = item.dianggap_tunggakan === 'Ya' ? 'Ya' : 'Tidak';
                        var periodeTagihan = $.trim((item.nama_bulan || '') + ' ' + (item.tahun || ''));

                        if (periodeTagihan === '') {
                            periodeTagihan = item.periode || '-';
                        }

                        var bisaSurat = item.dianggap_tunggakan === 'Ya' &&
                            item.status_tagihan === 'Aktif' &&
                            Number(item.sisa_tagihan || 0) > 0 && ['Lunas', 'Dibebaskan', 'Dibatalkan'].indexOf(status) === -1;

                        var aksi = '-';
                        if (bisaSurat) {
                            aksi = '<a class="btn btn-sm btn-warning" href="<?= base_url('admin/tunggakan/surat_tunggakan'); ?>?siswa=' + Number(item.id_siswa) + '">' +
                                '<i class="ri-mail-line me-1"></i>Buat Surat</a>';
                        }

                        html += '<tr class="data-monitoring-tagihan">' +
                            '<td><strong>' + escapeHtml(item.nama_siswa || '-') + '</strong><br><small>' + escapeHtml(item.nis || '-') + '</small></td>' +
                            '<td>' + escapeHtml(item.nama_kelas || '-') + '</td>' +
                            '<td>' + escapeHtml(item.nama_jenis_tagihan || '-') + '</td>' +
                            '<td><strong>' + escapeHtml(item.nama_tagihan || '-') + '</strong><br><small>' + escapeHtml(item.kode_tagihan || '') + '</small></td>' +
                            '<td>' + escapeHtml(periodeTagihan) + '</td>' +
                            '<td><span class="badge bg-' + (wajib === 'Ya' ? 'success' : 'secondary') + '-subtle text-' + (wajib === 'Ya' ? 'success' : 'secondary') + '">' + wajib + '</span></td>' +
                            '<td class="text-end">' + money(item.nominal_tagihan) + '</td>' +
                            '<td class="text-end">' + money(item.nominal_dibayar) + '</td>' +
                            '<td class="text-end fw-semibold text-' + (Number(item.sisa_tagihan || 0) > 0 ? 'danger' : 'success') + '">' + money(item.sisa_tagihan) + '</td>' +
                            '<td><span class="badge bg-' + statusClass + '-subtle text-' + statusClass + '">' + escapeHtml(status) + '</span></td>' +
                            '<td>' + aksi + '</td>' +
                            '</tr>';
                    });
                }

                $('#data').html(html);
                refreshPagination();
            },
            error: function(xhr, status, error) {
                $('#total_tagihan').text('Rp0');
                $('#total_dibayar').text('Rp0');
                $('#total_sisa').text('Rp0');
                $('#realisasi').text('0%');
                $('#jumlah_data').text('0 data');
                $('#data').html('<tr><td colspan="11" class="empty-state text-danger">Data monitoring tagihan gagal dimuat.</td></tr>');
                $('#pagination').empty();
                ajaxError(xhr, status, error);
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    }

    function statusClassName(status) {
        if (status === 'Lunas') return 'success';
        if (status === 'Dibayar Sebagian') return 'warning';
        if (status === 'Belum Dibayar') return 'danger';
        if (status === 'Dibebaskan') return 'info';
        return 'secondary';
    }

    function resetFilter() {
        $('#cari_siswa').val('');
        $('#id_siswa').val('');
        $('#hasil_siswa').empty();
        $('#periode').val('');
        $('#kelas').val('');
        $('#jenis').val('');
        $('#master').html('<option value="">Semua Batch/Periode</option>');
        $('#tipe').val('');
        $('#status_pembayaran').val('');
        $('#sampai_bulan').val('');
        filterKelasByPeriode();
        masters();
        load();
    }

    function queryParams() {
        return new URLSearchParams(filterData()).toString();
    }

    function cetakData() {
        window.open(
            '<?= base_url('admin/tunggakan/monitoring_tagihan/cetak'); ?>?' + queryParams(),
            '_blank'
        );
    }

    function exportData() {
        window.location.href = '<?= base_url('admin/tunggakan/monitoring_tagihan/export'); ?>?' + queryParams();
    }

    function refreshPagination() {
        paging(
            $('#data .data-monitoring-tagihan'),
            parseInt($('#dt-length-0').val(), 10) || 10,
            '#pagination'
        );
    }
</script>