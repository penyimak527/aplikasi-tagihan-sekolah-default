<div class="row g-3">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header border-bottom border-dashed">
                <h4 class="header-title mb-0">Import Data Siswa</h4>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2 align-items-center mb-4"><a
                        href="<?= base_url('admin/master_data/import_siswa/template') ?>" class="btn btn-outline-primary"><i
                            class="ri-download-line me-1"></i>1. Unduh Template Excel</a><span
                        class="text-muted">→</span><span class="badge bg-light text-dark p-2">2. Pilih File</span><span
                        class="text-muted">→</span><span class="badge bg-light text-dark p-2">3. Preview</span><span
                        class="text-muted">→</span><span class="badge bg-light text-dark p-2">4. Import</span></div>
                <form id="form_preview" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-3"><label class="form-label">Tahun Ajaran Penempatan</label><select
                                name="id_periode" id="id_periode" class="form-select" required>
                                <option value="">Pilih Tahun Ajaran</option><?php foreach ($periode as $r): ?>
                                    <option value="<?= $r['id'] ?>"><?= html_escape($r['periode']) ?></option>
                                <?php endforeach; ?>
                            </select></div>
                        <div class="col-md-3"><label class="form-label">Kelas Penempatan</label><select
                                name="id_kelas_setting" id="id_kelas_setting" class="form-select" required>
                                <option value="">Pilih Kelas</option><?php foreach ($kelas as $r): ?>
                                    <option value="<?= $r['id'] ?>" data-periode="<?= $r['id_periode'] ?>">
                                        <?= html_escape($r['nama_kelas']) ?></option><?php endforeach; ?>
                            </select></div>
                        <div class="col-md-3"><label class="form-label">File Excel (.xlsx)</label><input type="file"
                                name="file_excel" class="form-control" accept=".xlsx" required></div>
                        <div class="col-12"><button class="btn btn-primary" id="btn_preview"><i
                                    class="ri-eye-line me-1"></i>Upload dan Preview</button></div>
                    </div>
                </form>
                <div id="preview_area" class="mt-4 d-none">
                    <div class="row g-2 mb-3">
                        <div class="col-md-4">
                            <div class="alert alert-info mb-0">Total: <strong id="sum_total">0</strong></div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-success mb-0">Valid: <strong id="sum_valid">0</strong></div>
                        </div>
                        <div class="col-md-4">
                            <div class="alert alert-danger mb-0">Gagal: <strong id="sum_gagal">0</strong></div>
                        </div>
                    </div><input type="hidden" id="token">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Baris</th>
                                    <th>NIS</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>JK</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="preview_rows"></tbody>
                        </table>
                    </div><button class="btn btn-success" id="btn_import"><i
                            class="ri-upload-cloud-line me-1"></i>Import Data Valid</button>
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
                <div id="riwayat">
                    <div class="empty-state">Belum ada riwayat.</div>
                </div>
                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-riwayat-import"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-riwayat-import" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-riwayat-import">
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
    $(function () { loadRiwayat(); $('#id_periode').change(filterKelas); $('#form_preview').submit(previewData); $('#btn_import').click(importData); $('#dt-length-riwayat-import').on('change', refreshRiwayatImportPagination); });
    function filterKelas() { var p = $('#id_periode').val(); $('#id_kelas_setting option').each(function () { var v = $(this).data('periode'); var visible = !v || String(v) === String(p); $(this).prop('hidden', !visible).prop('disabled', !visible); }); $('#id_kelas_setting').val(''); }
    function previewData(e) { e.preventDefault(); var fd = new FormData(this); $('#btn_preview').prop('disabled', true); $.ajax({ url: '<?= base_url('admin/master_data/import_siswa/preview') ?>', type: 'POST', data: fd, processData: false, contentType: false, dataType: 'json', success: function (r) { if (r.result !== 'true') return Swal.fire('Gagal', r.message, 'error'); $('#token').val(r.token); $('#sum_total').text(r.total); $('#sum_valid').text(r.valid); $('#sum_gagal').text(r.gagal); var h = ''; r.rows.forEach(function (x) { h += '<tr class="' + (x.status === 'Valid' ? 'table-success' : 'table-danger') + '"><td>' + x.baris + '</td><td>' + escapeHtml(x.nis) + '</td><td>' + escapeHtml(x.nisn) + '</td><td>' + escapeHtml(x.nama) + '</td><td>' + escapeHtml(x.jk) + '</td><td>' + escapeHtml(x.kelas) + '</td><td><strong>' + x.status + '</strong><br><small>' + escapeHtml(x.pesan) + '</small></td></tr>'; }); $('#preview_rows').html(h); $('#preview_area').removeClass('d-none'); }, error: ajaxError, complete: function () { $('#btn_preview').prop('disabled', false); } }); }
    function importData() { confirmAction('Import data valid?', 'Baris gagal tidak akan disimpan.', function () { $('#btn_import').prop('disabled', true); $.post('<?= base_url('admin/master_data/import_siswa/proses') ?>', { token: $('#token').val() }, function (r) { Swal.fire(r.result === 'true' ? 'Berhasil' : 'Gagal', r.message, r.result === 'true' ? 'success' : 'error'); if (r.result === 'true') { $('#preview_area').addClass('d-none'); $('#form_preview')[0].reset(); loadRiwayat(); } }, 'json').fail(ajaxError).always(function () { $('#btn_import').prop('disabled', false); }); }); }
    function loadRiwayat() { $.post('<?= base_url('admin/master_data/import_siswa/riwayat') ?>', {}, function (rows) { var h = ''; if (!rows.length) h = '<div class="empty-state">Belum ada riwayat import.</div>'; rows.forEach(function (r) { h += '<div class="riwayat-import-item border-bottom py-3"><div class="d-flex justify-content-between"><strong>' + escapeHtml(r.kode_import) + '</strong><span class="badge bg-' + (r.status_import === 'Selesai' ? 'success' : 'warning') + '">' + escapeHtml(r.status_import) + '</span></div><small class="text-muted">' + escapeHtml(r.nama_file) + '<br>' + escapeHtml(r.nama_kelas) + ' | Berhasil ' + Number(r.jumlah_berhasil || 0) + ' / ' + Number(r.jumlah_data || 0) + '</small></div>'; }); $('#riwayat').html(h); refreshRiwayatImportPagination(); }, 'json'); }
    function refreshRiwayatImportPagination() { paging($('#riwayat .riwayat-import-item'), parseInt($('#dt-length-riwayat-import').val(), 10) || 10, '#pagination-riwayat-import'); }
</script>