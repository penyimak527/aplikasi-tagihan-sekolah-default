<div class="row g-3">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header app-card-header d-flex align-items-center justify-content-between gap-2">
                <div>
                    <h4 class="header-title mb-0">Daftar Format Bukti</h4>
                    <small class="text-muted">Pilih format untuk diedit atau dijadikan default.</small>
                </div>
                <button type="button" id="baru" class="btn btn-primary btn-sm">
                    <i class="ri-add-line me-1"></i>Format Baru
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
                    <h4 class="header-title mb-0" id="form_title">Tambah Format Bukti Pembayaran</h4>
                    <small class="text-muted">Atur ukuran, identitas sekolah, elemen cetak, dan tanda tangan.</small>
                </div>
            </div>
            <div class="card-body">
                <form id="form" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama Format</label>
                            <input type="text" name="nama_format" id="nama" class="form-control" placeholder="Contoh: Bukti 80mm" required>
                        </div>
                        <div class="col-md-3">
                            <label for="default_format_bukti" class="form-label">Jadikan Default</label>
                            <select name="status_default" id="default_format_bukti" class="form-select">
                                <option value="Tidak">Tidak</option>
                                <option value="Ya">Ya</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status_format_bukti" class="form-label">Status</label>
                            <select name="status" id="status_format_bukti" class="form-select">
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="ukuran" class="form-label">Ukuran Kertas</label>
                            <select name="ukuran_kertas" id="ukuran" class="form-select">
                                <option value="58mm">58mm</option>
                                <option value="80mm" selected>80mm</option>
                                <option value="A5">A5</option>
                                <option value="A4">A4</option>
                                <option value="Custom">Custom</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="orientasi" class="form-label">Orientasi</label>
                            <select name="orientasi" id="orientasi" class="form-select">
                                <option value="Portrait">Portrait</option>
                                <option value="Landscape">Landscape</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="judul" class="form-label">Judul Bukti</label>
                            <input type="text" name="judul_bukti" id="judul" class="form-control" value="BUKTI PEMBAYARAN">
                        </div>

                        <div class="col-12 d-none" id="custom_size_area">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="lebar_kertas" class="form-label">Lebar Kertas Custom (mm)</label>
                                    <input type="number" step="0.1" min="1" name="lebar_kertas" id="lebar_kertas" class="form-control" placeholder="Contoh: 80">
                                </div>
                                <div class="col-md-6">
                                    <label for="tinggi_kertas" class="form-label">Tinggi Kertas Custom (mm)</label>
                                    <input type="number" step="0.1" min="1" name="tinggi_kertas" id="tinggi_kertas" class="form-control" placeholder="Contoh: 200">
                                </div>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-1"></div>
                        <div class="col-12">
                            <h5 class="fs-15 mb-0">Identitas Sekolah</h5>
                        </div>
                        <div class="col-md-6">
                            <label for="sekolah" class="form-label">Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" id="sekolah" class="form-control" value="<?= html_escape(config_item('nama_sekolah') ?: 'Sekolah') ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="telepon" class="form-label">Telepon Sekolah</label>
                            <input type="text" name="telepon_sekolah" id="telepon" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat Sekolah</label>
                            <textarea name="alamat_sekolah" id="alamat" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Logo Sekolah</label>
                            <input type="file" name="logo" class="form-control" accept="image/png,image/jpeg,image/webp">
                            <small class="text-muted">Kosongkan saat edit untuk mempertahankan logo lama.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="showLogo" class="form-label">Tampilkan Logo</label>
                            <select name="tampilkan_logo" id="showLogo" class="form-select">
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="header_cetak" class="form-label">Teks Header Tambahan</label>
                            <textarea name="header_cetak" id="header_cetak" class="form-control" rows="2" placeholder="Teks tambahan di bawah identitas sekolah"></textarea>
                        </div>

                        <div class="col-12"><hr class="my-1"></div>
                        <div class="col-12">
                            <h5 class="fs-15 mb-0">Margin Cetak (mm)</h5>
                        </div>
                        <div class="col-md-3">
                            <label for="ma" class="form-label">Atas</label>
                            <input type="number" step="0.1" min="0" name="margin_atas" id="ma" class="form-control" value="5">
                        </div>
                        <div class="col-md-3">
                            <label for="mb" class="form-label">Bawah</label>
                            <input type="number" step="0.1" min="0" name="margin_bawah" id="mb" class="form-control" value="5">
                        </div>
                        <div class="col-md-3">
                            <label for="mk" class="form-label">Kiri</label>
                            <input type="number" step="0.1" min="0" name="margin_kiri" id="mk" class="form-control" value="5">
                        </div>
                        <div class="col-md-3">
                            <label for="mka" class="form-label">Kanan</label>
                            <input type="number" step="0.1" min="0" name="margin_kanan" id="mka" class="form-control" value="5">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Elemen yang Ditampilkan</label>
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <label for="showTerbilang" class="form-label small mb-1">Terbilang</label>
                                    <select name="tampilkan_terbilang" id="showTerbilang" class="form-select">
                                        <option value="Ya">Ya</option><option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="showUang" class="form-label small mb-1">Uang Diterima</label>
                                    <select name="tampilkan_uang_diterima" id="showUang" class="form-select">
                                        <option value="Ya">Ya</option><option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="showKembali" class="form-label small mb-1">Kembalian</label>
                                    <select name="tampilkan_kembalian" id="showKembali" class="form-select">
                                        <option value="Ya">Ya</option><option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="showSisa" class="form-label small mb-1">Sisa Tagihan</label>
                                    <select name="tampilkan_sisa_tagihan" id="showSisa" class="form-select">
                                        <option value="Ya">Ya</option><option value="Tidak">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12"><hr class="my-1"></div>
                        <div class="col-12">
                            <h5 class="fs-15 mb-0">Tanda Tangan dan Footer</h5>
                        </div>
                        <div class="col-md-5">
                            <label for="ttd" class="form-label">Nama Penandatangan</label>
                            <input type="text" name="nama_penandatangan" id="ttd" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan_penandatangan" id="jabatan" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="posisi_tanda_tangan" class="form-label">Posisi</label>
                            <select name="posisi_tanda_tangan" id="posisi_tanda_tangan" class="form-select">
                                <option value="Kiri">Kiri</option>
                                <option value="Tengah">Tengah</option>
                                <option value="Kanan" selected>Kanan</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="footer_cetak" class="form-label">Teks Footer</label>
                            <textarea name="footer_cetak" id="footer_cetak" class="form-control" rows="2" placeholder="Contoh: Simpan bukti ini sebagai tanda pembayaran yang sah"></textarea>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap justify-content-end gap-2 mt-4">
                        <button type="button" id="preview" class="btn btn-outline-secondary">
                            <i class="ri-eye-line me-1"></i>Preview
                        </button>
                        <button type="button" id="test_print" class="btn btn-outline-primary">
                            <i class="ri-printer-line me-1"></i>Tes Cetak
                        </button>
                        <button type="submit" id="btn_simpan" class="btn btn-primary">
                            <i class="ri-save-line me-1"></i>Simpan Pengaturan
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

    function resetForm() {
        $('#form')[0].reset();
        $('#id').val('');
        $('#form_title').text('Tambah Format Bukti Pembayaran');
        $('#ukuran').val('80mm');
        $('#orientasi').val('Portrait');
        $('#judul').val('BUKTI PEMBAYARAN');
        $('#sekolah').val('<?= html_escape(config_item('nama_sekolah') ?: 'Sekolah') ?>');
        $('#ma,#mb,#mk,#mka').val('5');
        $('#default_format_bukti').val('Tidak');
        $('#status_format_bukti').val('Aktif');
        $('#showLogo,#showTerbilang,#showUang,#showKembali,#showSisa').val('Ya');
        $('#posisi_tanda_tangan').val('Kanan');
        $('#previewBox').addClass('d-none').empty();
        toggleCustomSize();
    }

    function load() {
        $.getJSON('<?= base_url('pengaturan/format_bukti/result') ?>', function (response) {
            rows = response || [];
            if (!rows.length) {
                $('#list').html('<div class="empty-state">Belum ada format bukti pembayaran.</div>');
                return;
            }

            $('#list').html(rows.map(function (row) {
                return '<div class="border rounded p-3 mb-2">' +
                    '<div class="d-flex align-items-start justify-content-between gap-2">' +
                        '<div><strong>' + escapeHtml(row.nama_format || '-') + '</strong><br>' +
                        '<small class="text-muted">' + escapeHtml(row.ukuran_kertas || '-') + ' | ' + escapeHtml(row.orientasi || '-') + '</small></div>' +
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
        $('#id').val(row.id || '');
        $('#form_title').text(row.id ? 'Edit Format Bukti Pembayaran' : 'Tambah Format Bukti Pembayaran');
        $('#nama').val(row.nama_format || '');
        $('#default_format_bukti').val(row.status_default || 'Tidak');
        $('#status_format_bukti').val(row.status || 'Aktif');
        $('#ukuran').val(row.ukuran_kertas || '80mm');
        $('#orientasi').val(row.orientasi || 'Portrait');
        $('#lebar_kertas').val(row.lebar_kertas || '');
        $('#tinggi_kertas').val(row.tinggi_kertas || '');
        $('#sekolah').val(row.nama_sekolah || '<?= html_escape(config_item('nama_sekolah') ?: 'Sekolah') ?>');
        $('#telepon').val(row.telepon_sekolah || '');
        $('#alamat').val(row.alamat_sekolah || '');
        $('#judul').val(row.judul_bukti || 'BUKTI PEMBAYARAN');
        $('#header_cetak').val(row.header_cetak || '');
        $('#footer_cetak').val(row.footer_cetak || '');
        $('#ma').val(row.margin_atas || 5);
        $('#mb').val(row.margin_bawah || 5);
        $('#mk').val(row.margin_kiri || 5);
        $('#mka').val(row.margin_kanan || 5);
        $('#showLogo').val(row.tampilkan_logo || 'Ya');
        $('#showTerbilang').val(row.tampilkan_terbilang || 'Ya');
        $('#showUang').val(row.tampilkan_uang_diterima || 'Ya');
        $('#showKembali').val(row.tampilkan_kembalian || 'Ya');
        $('#showSisa').val(row.tampilkan_sisa_tagihan || 'Ya');
        $('#ttd').val(row.nama_penandatangan || '');
        $('#jabatan').val(row.jabatan_penandatangan || '');
        $('#posisi_tanda_tangan').val(row.posisi_tanda_tangan || 'Kanan');
        toggleCustomSize();
    }

    function toggleCustomSize() {
        $('#custom_size_area').toggleClass('d-none', $('#ukuran').val() !== 'Custom');
    }

    function previewHtml() {
        var signatureAlign = $('#posisi_tanda_tangan').val() === 'Kiri' ? 'start' : ($('#posisi_tanda_tangan').val() === 'Tengah' ? 'center' : 'end');
        var html = '<div class="text-center">' +
            ($('#showLogo').val() === 'Ya' ? '<div class="mb-1"><span class="badge bg-light text-dark border">LOGO</span></div>' : '') +
            '<h5 class="mb-0">' + escapeHtml($('#sekolah').val() || 'Sekolah') + '</h5>' +
            '<small>' + escapeHtml($('#alamat').val() || '') + '</small><br>' +
            '<small>' + escapeHtml($('#telepon').val() || '') + '</small>' +
            ($('#header_cetak').val() ? '<div class="mt-1">' + escapeHtml($('#header_cetak').val()) + '</div>' : '') +
            '<hr><strong>' + escapeHtml($('#judul').val() || 'BUKTI PEMBAYARAN') + '</strong></div>' +
            '<div class="d-flex justify-content-between mt-3"><span>No Transaksi</span><b>BYR/CONTOH/00001</b></div>' +
            '<div class="d-flex justify-content-between"><span>Siswa</span><span>CONTOH SISWA</span></div>' +
            '<table class="table table-sm mt-2 mb-2"><tr><td>SPP Juli</td><td class="text-end">Rp150.000</td></tr></table>' +
            '<div class="d-flex justify-content-between"><strong>Total</strong><strong>Rp150.000</strong></div>' +
            ($('#showTerbilang').val() === 'Ya' ? '<div class="small mt-1">Terbilang: Seratus lima puluh ribu rupiah</div>' : '') +
            ($('#showUang').val() === 'Ya' ? '<div class="d-flex justify-content-between mt-1"><span>Uang diterima</span><span>Rp200.000</span></div>' : '') +
            ($('#showKembali').val() === 'Ya' ? '<div class="d-flex justify-content-between"><span>Kembalian</span><span>Rp50.000</span></div>' : '') +
            ($('#showSisa').val() === 'Ya' ? '<div class="d-flex justify-content-between"><span>Sisa tagihan</span><span>Rp0</span></div>' : '') +
            '<div class="text-' + signatureAlign + ' mt-4"><small>' + escapeHtml($('#jabatan').val() || 'Petugas') + '</small><div style="height:45px"></div><strong>' + escapeHtml($('#ttd').val() || '(........................)') + '</strong></div>' +
            ($('#footer_cetak').val() ? '<div class="text-center border-top pt-2 mt-3 small">' + escapeHtml($('#footer_cetak').val()) + '</div>' : '');
        return html;
    }

    function showPreview() {
        $('#previewBox').removeClass('d-none').html(previewHtml());
    }

    $('#baru').on('click', resetForm);
    $('#ukuran').on('change', toggleCustomSize);
    $('#preview').on('click', showPreview);
    $('#test_print').on('click', function () {
        showPreview();
        var win = window.open('', '_blank', 'width=700,height=800');
        if (!win) return;
        win.document.write('<!doctype html><html><head><title>Tes Cetak Bukti</title><style>body{font-family:Arial,sans-serif;padding:20px;color:#111}.paper{max-width:520px;margin:auto}.text-center{text-align:center}.text-start{text-align:left}.text-end{text-align:right}.d-flex{display:flex}.justify-content-between{justify-content:space-between}.table{width:100%;border-collapse:collapse}.table td{padding:6px;border-bottom:1px solid #ddd}.mt-1{margin-top:4px}.mt-2{margin-top:8px}.mt-3{margin-top:16px}.mt-4{margin-top:24px}.mb-0{margin-bottom:0}.mb-1{margin-bottom:4px}.mb-2{margin-bottom:8px}.pt-2{padding-top:8px}.border-top{border-top:1px solid #ccc}.small,small{font-size:12px}</style></head><body><div class="paper">' + previewHtml() + '</div><script>window.onload=function(){window.print();}<\/script></body></html>');
        win.document.close();
    });

    $(document).on('click', '.edit', function () {
        var id = Number($(this).data('id'));
        fill(rows.find(function (row) { return Number(row.id) === id; }) || {});
    });

    $(document).on('click', '.def', function () {
        var id = $(this).data('id');
        confirmAction('Jadikan format default?', 'Format default sebelumnya akan diganti.', function () {
            $.post('<?= base_url('pengaturan/format_bukti/set_default') ?>', {id: id}, function (response) {
                var ok = response.result === 'true';
                Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
                if (ok) load();
            }, 'json').fail(ajaxError);
        });
    });

    $('#form').on('submit', function (event) {
        event.preventDefault();
        if ($('#ukuran').val() === 'Custom' && (!$('#lebar_kertas').val() || !$('#tinggi_kertas').val())) {
            Swal.fire('Perhatian', 'Lebar dan tinggi kertas custom wajib diisi.', 'warning');
            return;
        }

        var button = $('#btn_simpan').prop('disabled', true);
        $.ajax({
            url: '<?= base_url('pengaturan/format_bukti/simpan') ?>',
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                var ok = response.result === 'true';
                Swal.fire(ok ? 'Berhasil' : 'Gagal', response.message, ok ? 'success' : 'error');
                if (ok) {
                    resetForm();
                    load();
                }
            },
            error: ajaxError,
            complete: function () { button.prop('disabled', false); }
        });
    });

    resetForm();
    load();
});
</script>
