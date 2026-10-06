<div class="row g-3">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h4 class="header-title mb-0">Import Data Wali Murid</h4>
                <a href="<?= base_url('admin/master_data/wali_murid') ?>" class="btn btn-sm btn-light">
                    <i class="ri-arrow-left-line me-1"></i>Kembali ke Wali Murid
                </a>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
                    <a href="<?= base_url('admin/master_data/import_wali_murid/template') ?>" class="btn btn-outline-primary">
                        <i class="ri-download-line me-1"></i>1. Unduh Template Excel
                    </a>
                    <span class="text-muted">→</span>
                    <span class="badge bg-light text-dark p-2">2. Isi Data</span>
                    <span class="text-muted">→</span>
                    <span class="badge bg-light text-dark p-2">3. Upload dan Preview</span>
                    <span class="text-muted">→</span>
                    <span class="badge bg-light text-dark p-2">4. Import</span>
                </div>

                <div class="alert alert-info mb-4">
                    <div class="fw-semibold mb-2">Tata Cara Import Wali Murid</div>
                    <ol class="mb-0 ps-3">
                        <li>Unduh template Excel dan jangan mengubah nama kolom.</li>
                        <li>Isi data wali, username, password, NIS, NISN, nama siswa, hubungan, nomor telepon, dan email.</li>
                        <li>Satu baris mewakili satu hubungan wali dengan satu siswa.</li>
                        <li>Jika satu wali mempunyai lebih dari satu anak, ulangi data wali pada baris berikutnya dengan <strong>username dan password yang sama</strong>, lalu isi NIS, NISN, dan nama siswa sesuai anak berikutnya.</li>
                        <li>NIS, NISN, dan nama siswa harus sesuai dengan data siswa yang sudah tersimpan di aplikasi.</li>
                        <li>Hubungan hanya boleh diisi: Ayah, Ibu, Wali, atau Lainnya.</li>
                        <li>Upload file, periksa hasil preview, lalu klik Import Data Valid.</li>
                    </ol>
                </div>

                <form id="form_preview" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label">File Excel (.xlsx)</label>
                            <input type="file" name="file_excel" class="form-control" accept=".xlsx" required>
                        </div>
                        <div class="col-md-4 d-grid">
                            <button class="btn btn-primary" id="btn_preview">
                                <i class="ri-eye-line me-1"></i>Upload dan Preview
                            </button>
                        </div>
                    </div>
                </form>

                <div id="preview_area" class="mt-4 d-none">
                    <div class="row g-2 mb-3">
                        <div class="col-md-3"><div class="alert alert-info mb-0">Total: <strong id="sum_total">0</strong></div></div>
                        <div class="col-md-3"><div class="alert alert-success mb-0">Valid: <strong id="sum_valid">0</strong></div></div>
                        <div class="col-md-3"><div class="alert alert-danger mb-0">Gagal: <strong id="sum_gagal">0</strong></div></div>
                        <div class="col-md-3"><div class="alert alert-warning mb-0">Duplikat: <strong id="sum_duplikat">0</strong></div></div>
                    </div>
                    <input type="hidden" id="token">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Baris</th>
                                    <th>Nama Wali</th>
                                    <th>Username</th>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama Siswa</th>
                                    <th>Hubungan</th>
                                    <th>Aksi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="preview_rows"></tbody>
                        </table>
                    </div>
                    <button class="btn btn-success" id="btn_import">
                        <i class="ri-upload-cloud-line me-1"></i>Import Data Valid
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card">
            <div class="card-header border-bottom border-dashed">
                <h4 class="header-title mb-0">Riwayat Import</h4>
            </div>
            <div class="card-body">
                <div id="riwayat"><div class="empty-state">Belum ada riwayat.</div></div>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-riwayat-import-wali"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-riwayat-import-wali" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-riwayat-import-wali">
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

<script>
    $(function() {
        loadRiwayat();
        $('#form_preview').submit(previewData);
        $('#btn_import').click(importData);
        $('#dt-length-riwayat-import-wali').on('change', refreshRiwayatPagination);
    });

    function previewData(e) {
        e.preventDefault();
        var fd = new FormData(this);
        $('#btn_preview').prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/master_data/import_wali_murid/preview') ?>',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function(r) {
                if (r.result !== 'true') {
                    Swal.fire('Gagal', r.message, 'error');
                    return;
                }

                $('#token').val(r.token);
                $('#sum_total').text(r.total);
                $('#sum_valid').text(r.valid);
                $('#sum_gagal').text(r.gagal);
                $('#sum_duplikat').text(r.duplikat || 0);

                var h = '';
                (r.rows || []).forEach(function(x) {
                    h += '<tr class="' + (x.status === 'Valid' ? 'table-success' : 'table-danger') + '">' +
                        '<td>' + Number(x.baris || 0) + '</td>' +
                        '<td>' + escapeHtml(x.nama_wali || '') + '</td>' +
                        '<td>' + escapeHtml(x.username || '') + '</td>' +
                        '<td>' + escapeHtml(x.nis || '') + '</td>' +
                        '<td>' + escapeHtml(x.nisn || '') + '</td>' +
                        '<td>' + escapeHtml(x.nama_siswa || '') + '</td>' +
                        '<td>' + escapeHtml(x.hubungan || '') + '</td>' +
                        '<td>' + escapeHtml(x.aksi || '') + '</td>' +
                        '<td><strong>' + escapeHtml(x.status || '') + '</strong><br><small>' + escapeHtml(x.pesan || '') + '</small></td>' +
                        '</tr>';
                });
                $('#preview_rows').html(h);
                $('#preview_area').removeClass('d-none');
            },
            error: function(xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function() {
                $('#btn_preview').prop('disabled', false);
            }
        });
    }

    function importData() {
        confirmAction('Import data valid?', 'Baris gagal tidak akan disimpan. Username yang sama akan digunakan untuk menghubungkan beberapa siswa.', function() {
            $('#btn_import').prop('disabled', true);

            $.ajax({
                url: '<?= base_url('admin/master_data/import_wali_murid/proses') ?>',
                type: 'POST',
                data: { token: $('#token').val() },
                dataType: 'JSON',
                success: function(r) {
                    Swal.fire(r.result === 'true' ? 'Berhasil' : 'Gagal', r.message, r.result === 'true' ? 'success' : 'error');
                    if (r.result === 'true') {
                        $('#preview_area').addClass('d-none');
                        $('#preview_rows').html('');
                        $('#form_preview')[0].reset();
                        loadRiwayat();
                    }
                },
                error: function(xhr, status, error) {
                    ajaxError(xhr);
                },
                complete: function() {
                    $('#btn_import').prop('disabled', false);
                }
            });
        });
    }

    function loadRiwayat() {
        $.ajax({
            url: '<?= base_url('admin/master_data/import_wali_murid/riwayat') ?>',
            type: 'POST',
            data: {},
            dataType: 'JSON',
            success: function(rows) {
                var h = '';
                if (!rows.length) {
                    h = '<div class="empty-state">Belum ada riwayat import.</div>';
                }

                (rows || []).forEach(function(r) {
                    var gagal = Number(r.jumlah_gagal || 0);
                    var duplikat = Number(r.jumlah_duplikat || 0);
                    var download = gagal > 0
                        ? '<div class="mt-2"><a class="btn btn-sm btn-outline-danger" href="<?= base_url('admin/master_data/import_wali_murid/download_gagal/') ?>' + Number(r.id) + '"><i class="ri-download-line me-1"></i>Unduh Data Gagal</a></div>'
                        : '';

                    h += '<div class="riwayat-import-wali-item border-bottom py-3">' +
                        '<div class="d-flex justify-content-between gap-2">' +
                            '<strong>' + escapeHtml(r.kode_import || '') + '</strong>' +
                            '<span class="badge bg-' + (r.status_import === 'Selesai' ? 'success' : 'warning') + '">' + escapeHtml(r.status_import || '') + '</span>' +
                        '</div>' +
                        '<small class="text-muted">' +
                            escapeHtml(r.nama_file || '') + '<br>' +
                            'Berhasil ' + Number(r.jumlah_berhasil || 0) +
                            ' | Gagal ' + gagal +
                            ' | Duplikat ' + duplikat +
                            ' | Total ' + Number(r.jumlah_data || 0) +
                        '</small>' + download +
                    '</div>';
                });

                $('#riwayat').html(h);
                refreshRiwayatPagination();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function refreshRiwayatPagination() {
        paging(
            $('#riwayat .riwayat-import-wali-item'),
            parseInt($('#dt-length-riwayat-import-wali').val(), 10) || 10,
            '#pagination-riwayat-import-wali'
        );
    }
</script>
