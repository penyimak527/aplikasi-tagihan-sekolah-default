<div class="card no-print">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title">Cari Siswa</h4>
            <p class="text-muted mb-0">Cari berdasarkan nama, NIS, atau NISN untuk melihat seluruh riwayat penempatan kelas.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-0">
            <div class="col-md-10">
                <label class="form-label" for="q">Nama / NIS / NISN</label>
                <input type="text" id="q" class="form-control" placeholder="Masukkan minimal 2 karakter">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-primary w-100" id="btn_cari">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>
        <div id="hasil_cari" class="crud-list mt-3"></div>

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
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

<div id="detail" class="d-none">
    <div class="card">
        <div class="card-header app-card-header">
            <div>
                <h4 class="header-title" id="nama_siswa">-</h4>
                <p class="text-muted mb-0" id="identitas">-</p>
            </div>
            <div class="wf-toolbar-actions no-print">
                <button type="button" class="btn btn-outline-primary" id="btn_cetak">
                    <i class="ri-printer-line me-1"></i>Cetak Riwayat
                </button>
                <button type="button" class="btn btn-warning" id="btn_koreksi" disabled>
                    <i class="ri-edit-2-line me-1"></i>Koreksi Penempatan Terakhir
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-end no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="placements"></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header app-card-header">
            <div>
                <h4 class="header-title">Riwayat Perubahan</h4>
                <p class="text-muted mb-0">Penempatan, kenaikan, pindah kelas, tinggal kelas, kelulusan, dan koreksi yang pernah diproses.</p>
            </div>
        </div>
        <div class="card-body" id="history"></div>
    </div>
</div>

<div class="modal fade" id="modal_detail_penempatan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Penempatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <dl class="row mb-0" id="detail_penempatan_content"></dl>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_koreksi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Koreksi Penempatan Terakhir</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="ri-alert-line me-1"></i>
                    Koreksi hanya mengubah penempatan aktif. Tagihan yang sudah diterbitkan tetap menggunakan kelas yang tersimpan saat tagihan dibuat.
                </div>
                <div class="mb-3">
                    <label class="form-label">Penempatan Saat Ini</label>
                    <input type="text" class="form-control" id="kelas_asal_label" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="id_kelas_tujuan">Kelas Koreksi <span class="text-danger">*</span></label>
                    <select class="form-select" id="id_kelas_tujuan">
                        <option value="">Pilih tahun ajaran dan kelas</option>
                        <?php foreach ($kelas as $row): ?>
                            <option value="<?= (int) $row['id'] ?>">
                                <?= html_escape(($row['periode'] ?: '-') . ' | ' . $row['nama_kelas']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="form-label" for="alasan_koreksi">Alasan Koreksi <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="alasan_koreksi" rows="4" placeholder="Jelaskan alasan koreksi penempatan"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_simpan_koreksi">
                    <i class="ri-save-line me-1"></i>Simpan Koreksi
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {

        .no-print,
        .sidenav-menu,
        .app-topbar,
        .footer {
            display: none !important;
        }

        .page-content {
            margin: 0 !important;
            padding: 0 !important;
        }

        .page-content .page-container {
            max-width: none !important;
            padding: 0 !important;
        }

        .card {
            border: 0 !important;
            box-shadow: none !important;
        }

        .card-header,
        .card-body {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    }
</style>

<script>
    var initialId = <?= (int) $id_siswa ?>;
    var selectedStudentId = 0;
    var placementRows = [];
    var activePlacement = null;
    var modalDetailPenempatan;
    var modalKoreksi;

    $(function() {
        modalDetailPenempatan = new bootstrap.Modal(document.getElementById('modal_detail_penempatan'));
        modalKoreksi = new bootstrap.Modal(document.getElementById('modal_koreksi'));

        $('#btn_cari').on('click', cari);
        $('#q').on('keydown', function(event) {
            if (event.key === 'Enter') cari();
        });
        $('#btn_cetak').on('click', function() {
            window.print();
        });
        $('#btn_koreksi').on('click', bukaKoreksi);
        $('#btn_simpan_koreksi').on('click', simpanKoreksi);

        $('#hasil_cari').on('click', '[data-student-id]', function() {
            loadDetail($(this).data('student-id'));
        });
        $('#placements').on('click', '[data-placement-index]', function() {
            detailPenempatan(Number($(this).data('placement-index')));
        });

        $('#dt-length-0').on('change', function() {
            var jumlah = parseInt($(this).val(), 10) || 10;
            paging($('#hasil_cari .item-siswa'), jumlah);
        });

        if (initialId > 0) loadDetail(initialId);
    });

    function cari() {
        var keyword = $.trim($('#q').val());

        if (keyword.length < 2) {
            Swal.fire('Perhatian', 'Masukkan minimal 2 karakter pencarian.', 'warning');
            return;
        }

        $.ajax({
            url: '<?= base_url('admin/kesiswaan/riwayat_kelas/cari') ?>',
            type: 'POST',
            data: {
                q: keyword
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('#btn_cari')
                    .prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-1"></span>Mencari');

                $('#hasil_cari').html(
                    '<div class="text-center py-3">' +
                    '<span class="spinner-border spinner-border-sm text-primary me-1"></span>' +
                    'Memuat data siswa...' +
                    '</div>'
                );

                $('#pagination').empty();
            },
            success: function(rows) {
                var html = '';

                if (!Array.isArray(rows) || rows.length === 0) {
                    html = '<div class="empty-state">' +
                        '<i class="ri-user-search-line empty-icon"></i>' +
                        'Siswa tidak ditemukan.' +
                        '</div>';
                } else {
                    rows.forEach(function(row) {
                        html += '<div class="crud-list-item item-siswa">' +
                            '<div class="crud-content">' +
                            '<div class="crud-title">' + escapeHtml(row.nama_lengkap || '-') + '</div>' +
                            '<div class="crud-meta">NIS: ' + escapeHtml(row.nis || '-') +
                            ' | NISN: ' + escapeHtml(row.nisn || '-') + '</div>' +
                            '<div class="crud-status mt-1">' +
                            '<span class="badge bg-primary-subtle text-primary">' +
                            escapeHtml(row.status_pendaftaran || '-') +
                            '</span>' +
                            '</div>' +
                            '</div>' +
                            '<div class="crud-actions">' +
                            '<button type="button" class="btn btn-primary" data-student-id="' +
                            Number(row.id) + '">' +
                            '<i class="ri-check-line me-1"></i>Pilih' +
                            '</button>' +
                            '</div>' +
                            '</div>';
                    });
                }

                $('#hasil_cari').html(html);

                var jumlahAwal = parseInt($('#dt-length-0').val(), 10) || 10;
                paging($('#hasil_cari .item-siswa'), jumlahAwal);
            },
            error: function(xhr, status, error) {
                $('#hasil_cari').html(
                    '<div class="empty-state text-danger">' +
                    '<i class="ri-error-warning-line empty-icon"></i>' +
                    'Data siswa gagal dimuat.' +
                    '</div>'
                );
                $('#pagination').empty();
                ajaxError(xhr, status, error);
            },
            complete: function() {
                $('#btn_cari')
                    .prop('disabled', false)
                    .html('<i class="ri-search-line me-1"></i>Cari');
            }
        });
    }

    function loadDetail(id) {
        $.ajax({
            url: '<?= base_url('admin/kesiswaan/riwayat_kelas/result') ?>',
            type: 'POST',
            data: {
                id_siswa: id
            },
            dataType: 'JSON',
            beforeSend: function() {
                $('#detail').addClass('d-none');
            },
            success: function(response) {
                if (response.result !== 'true') {
                    Swal.fire('Gagal', response.message || 'Data riwayat tidak dapat dimuat.', 'error');
                    return;
                }

                selectedStudentId = Number(response.siswa.id);
                placementRows = response.placements || [];
                activePlacement = response.active || null;

                $('#detail').removeClass('d-none');
                $('#nama_siswa').text(response.siswa.nama_lengkap || '-');
                $('#identitas').text(
                    'NIS ' + (response.siswa.nis || '-') +
                    ' | NISN ' + (response.siswa.nisn || '-') +
                    ' | Status ' + (response.siswa.status_pendaftaran || '-')
                );

                $('#btn_koreksi').prop('disabled', !activePlacement);
                renderPlacements(placementRows);
                renderHistory(response.history || []);

                $('#hasil_cari').empty();
                $('#pagination').empty();

                document.getElementById('detail').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }

    function renderPlacements(rows) {
        var html = '';
        if (!rows.length) {
            html = '<tr><td colspan="6"><div class="empty-state"><i class="ri-school-line empty-icon"></i>Belum ada penempatan kelas.</div></td></tr>';
        }

        rows.forEach(function(row, index) {
            var isActive = String(row.status_aktif) === '1';
            var statusLabel = isActive ? 'Aktif' : (row.jenis_proses || 'Riwayat');
            var statusClass = isActive ? 'success' : 'secondary';
            html += '<tr>' +
                '<td>' + escapeHtml(row.periode || '-') + '</td>' +
                '<td><strong>' + escapeHtml(row.nama_kelas || '-') + '</strong></td>' +
                '<td><span class="badge bg-' + statusClass + '-subtle text-' + statusClass + '">' + escapeHtml(statusLabel) + '</span></td>' +
                '<td>' + escapeHtml(row.tanggal_proses || '-') + '</td>' +
                '<td class="text-end no-print"><button type="button" class="btn btn-sm btn-outline-primary" data-placement-index="' + index + '"><i class="ri-eye-line me-1"></i>Detail</button></td>' +
                '</tr>';
        });
        $('#placements').html(html);
    }

    function renderHistory(rows) {
        var html = '';
        if (!rows.length) {
            $('#history').html('<div class="empty-state"><i class="ri-history-line empty-icon"></i>Belum ada riwayat proses.</div>');
            return;
        }

        rows.forEach(function(row) {
            var origin = row.nama_kelas_asal || '-';
            var destination = row.nama_kelas_tujuan || '-';
            html += '<div class="border-start border-primary border-3 ps-3 pb-3 mb-3">' +
                '<div class="d-flex justify-content-between gap-3 flex-wrap">' +
                '<div class="fw-semibold">' + escapeHtml(row.jenis_proses || 'Perubahan Kelas') + '</div>' +
                '<span class="badge bg-primary-subtle text-primary">' + escapeHtml(row.status_riwayat || 'Aktif') + '</span>' +
                '</div>' +
                '<div class="mt-1">' + escapeHtml(origin) + ' <i class="ri-arrow-right-line mx-1"></i> ' + escapeHtml(destination) + '</div>' +
                '<small class="text-muted d-block mt-1">' +
                escapeHtml(row.tanggal_proses || '-') + ' ' + escapeHtml(row.waktu_proses || '') +
                ' | Petugas: ' + escapeHtml(row.nama_user || '-') +
                '</small>' +
                (row.alasan ? '<div class="mt-2"><strong>Alasan/Keterangan:</strong> ' + escapeHtml(row.alasan) + '</div>' : '') +
                '</div>';
        });
        $('#history').html(html);
    }


    function paging($selector, jumlah_tampil = 10) {
        $('#pagination').empty();

        var jumlahData = $selector.length;
        var jumlahTampil = parseInt(jumlah_tampil, 10) || 10;

        if (jumlahData === 0) {
            return;
        }

        if (typeof Pagination !== 'function') {
            console.error('Library Pagination belum dimuat pada template.');
            $selector.show();
            return;
        }

        window.tp = new Pagination('#pagination', {
            itemsCount: jumlahData,
            pageSize: jumlahTampil,
            onPageChange: function(paging) {
                var start = paging.pageSize * (paging.currentPage - 1);
                var end = start + paging.pageSize;
                var $rows = $selector;

                $rows.hide();

                for (var i = start; i < end; i++) {
                    $rows.eq(i).show();
                }
            }
        });
    }

    function detailPenempatan(index) {
        var row = placementRows[index];
        if (!row) return;
        var statusLabel = String(row.status_aktif) === '1' ? 'Aktif' : (row.jenis_proses || 'Riwayat');
        var content = '';
        content += detailItem('Tahun Ajaran', row.periode || '-');
        content += detailItem('Kelas', row.nama_kelas || '-');
        content += detailItem('Status', statusLabel);
        content += detailItem('Tanggal Proses', row.tanggal_proses || '-');
        content += detailItem('Petugas', row.nama_user || '-');
        $('#detail_penempatan_content').html(content);
        modalDetailPenempatan.show();
    }

    function detailItem(label, value) {
        return '<dt class="col-sm-5 text-muted">' + escapeHtml(label) + '</dt><dd class="col-sm-7">' + escapeHtml(value) + '</dd>';
    }

    function bukaKoreksi() {
        if (!activePlacement) {
            Swal.fire('Perhatian', 'Siswa belum memiliki penempatan aktif yang dapat dikoreksi.', 'warning');
            return;
        }
        $('#kelas_asal_label').val(
            (activePlacement.periode || '-') + ' | ' +
            (activePlacement.nama_kelas || '-')
        );
        $('#id_kelas_tujuan').val('');
        $('#alasan_koreksi').val('');
        modalKoreksi.show();
    }

    function simpanKoreksi() {
        var targetClassId = $('#id_kelas_tujuan').val();
        var reason = $.trim($('#alasan_koreksi').val());

        if (!targetClassId || !reason) {
            Swal.fire('Perhatian', 'Kelas koreksi dan alasan wajib diisi.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Simpan koreksi penempatan?',
            text: 'Riwayat lama tidak dihapus dan tagihan lama tidak diubah.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Simpan Koreksi',
            cancelButtonText: 'Batal'
        }).then(function(result) {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: '<?= base_url('admin/kesiswaan/riwayat_kelas/koreksi') ?>',
                type: 'POST',
                data: {
                    id_siswa: selectedStudentId,
                    id_kelas_tujuan: targetClassId,
                    alasan: reason
                },
                dataType: 'JSON',
                beforeSend: function() {
                    $('#btn_simpan_koreksi')
                        .prop('disabled', true)
                        .html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan');
                },
                success: function(response) {
                    if (response.result !== 'true') {
                        Swal.fire(
                            'Gagal',
                            response.message || 'Koreksi penempatan gagal.',
                            'error'
                        );
                        return;
                    }

                    modalKoreksi.hide();

                    Swal.fire({
                        icon: response.warning ? 'warning' : 'success',
                        title: response.warning ? 'Berhasil dengan Peringatan' : 'Berhasil',
                        text: response.message || 'Koreksi penempatan berhasil disimpan.'
                    });

                    loadDetail(selectedStudentId);
                },
                error: function(xhr, status, error) {
                    ajaxError(xhr, status, error);
                },
                complete: function() {
                    $('#btn_simpan_koreksi')
                        .prop('disabled', false)
                        .html('<i class="ri-save-line me-1"></i>Simpan Koreksi');
                }
            });
        });
    }
</script>