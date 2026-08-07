<div class="row g-3">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header app-card-header d-flex align-items-center justify-content-between gap-2">
                <div>
                    <h4 class="header-title mb-0">Daftar Format Kartu</h4>
                    <small class="text-muted">Format posisi cetak pada kartu pembayaran.</small>
                </div>
                <button type="button" id="baru" class="btn btn-primary btn-sm">
                    <i class="ri-add-line me-1"></i>Baru
                </button>
            </div>
            <div class="card-body" id="list">
                <div class="empty-state">Memuat format...</div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="card">
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title mb-0" id="form_title">Tambah Format Kartu Pembayaran</h4>
                    <small class="text-muted">Atur ukuran kartu, posisi awal, baris, kolom, dan lebar cetak.</small>
                </div>
            </div>
            <div class="card-body">
                <form id="form">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="ukuran_kertas" value="Custom">
                    <input type="hidden" name="orientasi" value="Portrait">
                    <input type="hidden" name="nama_sekolah" value="<?= html_escape(config_item('nama_sekolah') ?: 'Sekolah') ?>">
                    <input type="hidden" name="pengaturan_json" id="json">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Format</label>
                            <input type="text" name="nama_format" id="nama" class="form-control" placeholder="Contoh: Kartu Standar" required>
                        </div>
                        <div class="col-md-3">
                            <label for="default_format_kartu" class="form-label">Jadikan Default</label>
                            <select name="status_default" id="default_format_kartu" class="form-select">
                                <option value="Tidak">Tidak</option>
                                <option value="Ya">Ya</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status_format_kartu" class="form-label">Status</label>
                            <select name="status" id="status_format_kartu" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="lebar" class="form-label">Lebar Kartu (mm)</label>
                            <input type="number" step="0.1" min="1" name="lebar_kertas" id="lebar" class="form-control" value="210" required>
                        </div>
                        <div class="col-md-3">
                            <label for="tinggi" class="form-label">Tinggi Kartu (mm)</label>
                            <input type="number" step="0.1" min="1" name="tinggi_kertas" id="tinggi" class="form-control" value="148" required>
                        </div>
                        <div class="col-md-3">
                            <label for="jumlahBaris" class="form-label">Jumlah Baris</label>
                            <input type="number" min="1" id="jumlahBaris" class="form-control" value="12" required>
                        </div>
                        <div class="col-md-3">
                            <label for="jarak" class="form-label">Jarak Baris (mm)</label>
                            <input type="number" min="0" step="0.1" id="jarak" class="form-control" value="8" required>
                        </div>

                        <div class="col-md-3">
                            <label for="x" class="form-label">Posisi Awal X (mm)</label>
                            <input type="number" min="0" step="0.1" id="x" class="form-control" value="10" required>
                        </div>
                        <div class="col-md-3">
                            <label for="y" class="form-label">Posisi Awal Y (mm)</label>
                            <input type="number" min="0" step="0.1" id="y" class="form-control" value="10" required>
                        </div>
                        <div class="col-md-3">
                            <label for="wTanggal" class="form-label">Lebar Tanggal (mm)</label>
                            <input type="number" min="0" step="0.1" id="wTanggal" class="form-control" value="25">
                        </div>
                        <div class="col-md-3">
                            <label for="wJenis" class="form-label">Lebar Jenis/Bulan (mm)</label>
                            <input type="number" min="0" step="0.1" id="wJenis" class="form-control" value="70">
                        </div>
                        <div class="col-md-3">
                            <label for="wNominal" class="form-label">Lebar Nominal (mm)</label>
                            <input type="number" min="0" step="0.1" id="wNominal" class="form-control" value="35">
                        </div>
                        <div class="col-md-3">
                            <label for="wPetugas" class="form-label">Lebar Petugas (mm)</label>
                            <input type="number" min="0" step="0.1" id="wPetugas" class="form-control" value="20">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Kolom yang Dicetak</label>
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label class="border rounded p-2 w-100">
                                        <input type="checkbox" class="form-check-input me-1 kolom-cetak" value="Tanggal" checked> Tanggal
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="border rounded p-2 w-100">
                                        <input type="checkbox" class="form-check-input me-1 kolom-cetak" value="Jenis/Bulan" checked> Jenis/Bulan
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="border rounded p-2 w-100">
                                        <input type="checkbox" class="form-check-input me-1 kolom-cetak" value="Nominal" checked> Nominal
                                    </label>
                                </div>
                                <div class="col-md-3">
                                    <label class="border rounded p-2 w-100">
                                        <input type="checkbox" class="form-check-input me-1 kolom-cetak" value="Petugas" checked> Petugas
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                        <button type="button" id="preview" class="btn btn-outline-secondary">
                            <i class="ri-eye-line me-1"></i>Preview Baris
                        </button>
                        <button type="button" id="test_print" class="btn btn-outline-primary">
                            <i class="ri-printer-line me-1"></i>Tes Cetak
                        </button>
                        <button type="submit" id="btn_simpan" class="btn btn-primary">
                            <i class="ri-save-line me-1"></i>Simpan Format
                        </button>
                    </div>
                </form>

                <div id="previewBox" class="border rounded p-3 mt-3 d-none"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(function () {
    var rows = [];

    function selectedColumns() {
        return $('.kolom-cetak:checked').map(function () { return this.value; }).get();
    }

    function syncJson() {
        var columns = selectedColumns();
        $('#json').val(JSON.stringify({
            jumlah_baris: Number($('#jumlahBaris').val() || 0),
            jarak_baris: Number($('#jarak').val() || 0),
            posisi_x: Number($('#x').val() || 0),
            posisi_y: Number($('#y').val() || 0),
            lebar_tanggal: Number($('#wTanggal').val() || 0),
            lebar_jenis: Number($('#wJenis').val() || 0),
            lebar_nominal: Number($('#wNominal').val() || 0),
            lebar_petugas: Number($('#wPetugas').val() || 0),
            kolom: columns
        }));
        return columns;
    }

    function resetForm() {
        $('#form')[0].reset();
        $('#id').val('');
        $('#form_title').text('Tambah Format Kartu Pembayaran');
        $('#lebar').val('210');
        $('#tinggi').val('148');
        $('#jumlahBaris').val('12');
        $('#jarak').val('8');
        $('#x,#y').val('10');
        $('#wTanggal').val('25');
        $('#wJenis').val('70');
        $('#wNominal').val('35');
        $('#wPetugas').val('20');
        $('#default_format_kartu').val('Tidak');
        $('#status_format_kartu').val('Aktif');
        $('.kolom-cetak').prop('checked', true);
        $('#previewBox').addClass('d-none').empty();
        syncJson();
    }

    function load() {
        $.getJSON('<?= base_url('pengaturan/format_kartu/result') ?>', function (response) {
            rows = response || [];
            if (!rows.length) {
                $('#list').html('<div class="empty-state">Belum ada format kartu.</div>');
                return;
            }

            $('#list').html(rows.map(function (row) {
                return '<div class="border rounded p-3 mb-2">' +
                    '<div class="d-flex align-items-start justify-content-between gap-2">' +
                        '<div><strong>' + escapeHtml(row.nama_format || '-') + '</strong><br>' +
                        '<small class="text-muted">' + escapeHtml(row.lebar_kertas || '-') + ' × ' + escapeHtml(row.tinggi_kertas || '-') + ' mm</small></div>' +
                        (row.status_default === 'Ya' ? '<span class="badge bg-primary">Default</span>' : '') +
                    '</div>' +
                    '<div class="mt-2"><span class="badge bg-' + (row.status === 'Aktif' ? 'success' : 'secondary') + '">' + escapeHtml(row.status || '-') + '</span></div>' +
                    '<div class="d-flex gap-2 mt-3">' +
                        '<button type="button" class="btn btn-sm btn-outline-warning edit" data-id="' + row.id + '"><i class="ri-edit-line me-1"></i>Edit</button>' +
                        (row.status_default !== 'Ya' ? '<button type="button" class="btn btn-sm btn-outline-primary def" data-id="' + row.id + '"><i class="ri-star-line me-1"></i>Default</button>' : '') +
                    '</div>' +
                '</div>';
            }).join(''));
        }).fail(ajaxError);
    }

    function fill(row) {
        resetForm();
        var config = {};
        try { config = JSON.parse(row.pengaturan_json || '{}'); } catch (error) { config = {}; }

        $('#id').val(row.id || '');
        $('#form_title').text(row.id ? 'Edit Format Kartu Pembayaran' : 'Tambah Format Kartu Pembayaran');
        $('#nama').val(row.nama_format || '');
        $('#lebar').val(row.lebar_kertas || 210);
        $('#tinggi').val(row.tinggi_kertas || 148);
        $('#jumlahBaris').val(config.jumlah_baris || 12);
        $('#jarak').val(config.jarak_baris || 8);
        $('#x').val(config.posisi_x || 10);
        $('#y').val(config.posisi_y || 10);
        $('#wTanggal').val(config.lebar_tanggal || 25);
        $('#wJenis').val(config.lebar_jenis || 70);
        $('#wNominal').val(config.lebar_nominal || 35);
        $('#wPetugas').val(config.lebar_petugas || 20);
        $('#default_format_kartu').val(row.status_default || 'Tidak');
        $('#status_format_kartu').val(row.status || 'Aktif');

        var columns = Array.isArray(config.kolom) && config.kolom.length
            ? config.kolom
            : ['Tanggal', 'Jenis/Bulan', 'Nominal', 'Petugas'];
        $('.kolom-cetak').each(function () {
            this.checked = columns.indexOf(this.value) !== -1;
        });
        syncJson();
    }

    function previewHtml() {
        var columns = selectedColumns();
        var values = {
            'Tanggal': '04-08-2026',
            'Jenis/Bulan': 'SPP Juli',
            'Nominal': '250,000',
            'Petugas': 'MW'
        };
        var widths = {
            'Tanggal': Number($('#wTanggal').val() || 25),
            'Jenis/Bulan': Number($('#wJenis').val() || 70),
            'Nominal': Number($('#wNominal').val() || 35),
            'Petugas': Number($('#wPetugas').val() || 20)
        };

        return '<div style="margin-left:' + Number($('#x').val() || 0) + 'px;margin-top:' + Number($('#y').val() || 0) + 'px">' +
            '<div class="d-flex border rounded overflow-hidden">' +
            columns.map(function (column) {
                return '<div class="p-2 border-end" style="width:' + widths[column] + '%"><small class="text-muted d-block">' + escapeHtml(column) + '</small><strong>' + escapeHtml(values[column]) + '</strong></div>';
            }).join('') +
            '</div><small class="text-muted d-block mt-2">Jumlah baris: ' + escapeHtml($('#jumlahBaris').val()) + ' | Jarak: ' + escapeHtml($('#jarak').val()) + ' mm</small></div>';
    }

    function showPreview() {
        if (!selectedColumns().length) {
            Swal.fire('Perhatian', 'Pilih minimal satu kolom yang akan dicetak.', 'warning');
            return false;
        }
        syncJson();
        $('#previewBox').removeClass('d-none').html(previewHtml());
        return true;
    }

    $('#baru').on('click', resetForm);
    $('#preview').on('click', showPreview);
    $('.kolom-cetak').on('change', syncJson);

    $('#test_print').on('click', function () {
        if (!showPreview()) return;
        var win = window.open('', '_blank', 'width=900,height=500');
        if (!win) return;
        win.document.write('<!doctype html><html><head><title>Tes Cetak Kartu</title><style>body{font-family:Arial,sans-serif;padding:20px}.d-flex{display:flex}.border{border:1px solid #aaa}.border-end{border-right:1px solid #aaa}.rounded{border-radius:6px}.overflow-hidden{overflow:hidden}.p-2{padding:8px}.mt-2{margin-top:8px}.d-block{display:block}.text-muted{color:#666}small{font-size:11px}</style></head><body>' + previewHtml() + '<script>window.onload=function(){window.print();}<\/script></body></html>');
        win.document.close();
    });

    $(document).on('click', '.edit', function () {
        var id = Number($(this).data('id'));
        fill(rows.find(function (row) { return Number(row.id) === id; }) || {});
    });

    $(document).on('click', '.def', function () {
        var id = $(this).data('id');
        confirmAction('Jadikan format default?', 'Format default sebelumnya akan diganti.', function () {
            $.post('<?= base_url('pengaturan/format_kartu/set_default') ?>', {id: id}, function (response) {
                var ok = response.result === 'true';
                Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
                if (ok) load();
            }, 'json').fail(ajaxError);
        });
    });

    $('#form').on('submit', function (event) {
        event.preventDefault();
        var columns = syncJson();
        if (!columns.length) {
            Swal.fire('Perhatian', 'Pilih minimal satu kolom yang akan dicetak.', 'warning');
            return;
        }

        var button = $('#btn_simpan').prop('disabled', true);
        $.post('<?= base_url('pengaturan/format_kartu/simpan') ?>', $(this).serialize(), function (response) {
            var ok = response.result === 'true';
            Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
            if (ok) {
                resetForm();
                load();
            }
        }, 'json').fail(ajaxError).always(function () {
            button.prop('disabled', false);
        });
    });

    resetForm();
    load();
});
</script>
