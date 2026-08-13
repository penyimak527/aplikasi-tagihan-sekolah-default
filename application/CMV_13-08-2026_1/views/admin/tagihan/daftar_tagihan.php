<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Daftar Tagihan</h4>
        <div class="dropdown">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="ri-add-line me-1"></i>Buat Tagihan
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="<?= base_url('admin/tagihan/tagihan_bulanan') ?>">Tagihan Bulanan</a>
                <a class="dropdown-item" href="<?= base_url('admin/tagihan/tagihan_langsung') ?>">Tagihan Langsung</a>
                <a class="dropdown-item" href="<?= base_url('admin/tagihan/tagihan_tahunan') ?>">Tagihan Tahunan</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-lg-2 col-md-4"><select id="periode" class="form-select">
                    <option value="0">Semua Tahun Ajaran</option><?php foreach ($periode as $r): ?><option value="<?= $r['id'] ?>"><?= html_escape($r['periode']) ?></option><?php endforeach; ?>
                </select></div>
            <div class="col-lg-2 col-md-4"><select id="tipe" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option>Bulanan</option>
                    <option>Langsung</option>
                    <option>Tahunan</option>
                </select></div>
            <div class="col-lg-2 col-md-4"><select id="jenis" class="form-select">
                    <option value="0">Semua Jenis</option><?php foreach ($jenis as $r): ?><option value="<?= $r['id'] ?>"><?= html_escape($r['nama_jenis']) ?></option><?php endforeach; ?>
                </select></div>
            <div class="col-lg-2 col-md-4"><select id="filter_status_tagihan" class="form-select">
                    <option value="">Semua Status</option>
                    <option>Draft</option>
                    <option>Aktif</option>
                    <option>Dibatalkan</option>
                </select></div>
            <div class="col-lg-2 col-md-4"><input id="search" class="form-control" placeholder="Cari nama atau kode ..."></div>
            <div class="col-lg-2 col-md-4 d-grid"><button class="btn btn-primary" type="button" onclick="loadData()"><i class="ri-search-line me-1"></i>Cari</button></div>
        </div>
        <div id="data" class="crud-list"></div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-daftar-tagihan"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-daftar-tagihan" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-daftar-tagihan">
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

<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Tagihan</h5><button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detail_content"></div>
            <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Tutup</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditDraft" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title">Edit Draft Tagihan</h5>
                    <small class="text-muted">Target, tahun ajaran, jenis, dan tipe tetap mengikuti draft yang sudah dibuat.</small>
                </div>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="form_edit_draft">
                    <input type="hidden" name="id" id="draft_id">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="draft_periode" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis / Tipe</label>
                            <input type="text" class="form-control" id="draft_jenis_tipe" disabled>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Nama Tagihan</label>
                            <input type="text" class="form-control" name="nama_tagihan" id="draft_nama_tagihan" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Dihitung sebagai Tunggakan</label>
                            <select class="form-select" name="dianggap_tunggakan" id="draft_tunggakan">
                                <option value="Ya">Ya</option>
                                <option value="Tidak">Tidak</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Periode dan Tarif</label>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Periode</th>
                                            <th style="width:220px">Nominal</th>
                                            <th style="width:190px">Jatuh Tempo</th>
                                        </tr>
                                    </thead>
                                    <tbody id="draft_period_rows"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="draft_keterangan" rows="3"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_simpan_draft">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

<script>
    var modalDetail;
    var modalEditDraft;
    $(function() {
        modalDetail = new bootstrap.Modal('#modalDetail');
        modalEditDraft = new bootstrap.Modal('#modalEditDraft');
        $('#btn_simpan_draft').on('click', simpanDraft);
        loadData();
        $('#dt-length-daftar-tagihan').on('change', refreshDaftarTagihanPagination);
    });

    function loadData() {
        $.ajax({
            url: '<?= base_url('admin/tagihan/daftar_tagihan/result') ?>',
            type: 'POST',
            data: {
                id_periode: $('#periode').val(),
                tipe: $('#tipe').val(),
                id_jenis: $('#jenis').val(),
                status: $('#filter_status_tagihan').val(),
                search: $('#search').val()
            },
            dataType: 'JSON',
            success: function(rows) {
            if (!rows.length) {
                $('#data').html('<div class="empty-state">Belum ada tagihan.</div>');
                refreshDaftarTagihanPagination();
                return;
            }
            var h = rows.map(function(r, index) {
                var badge = r.status === 'Aktif' ? 'bg-success' : (r.status === 'Draft' ? 'bg-warning' : 'bg-danger');
                var actions = '<button class="btn btn-outline-primary btn-icon" title="Detail" onclick="detail(' + r.id + ')"><i class="ri-eye-line"></i></button>' +
                    '<a class="btn btn-outline-primary btn-icon" title="Siswa Pembayar" href="<?= base_url('admin/tagihan/siswa_pembayar?id_tagihan=') ?>' + r.id + '"><i class="ri-user-follow-line"></i></a>' +
                    '<a class="btn btn-outline-warning btn-icon" title="Tarif" href="<?= base_url('admin/tagihan/tarif_per_kelas?id_tagihan=') ?>' + r.id + '"><i class="ri-money-dollar-circle-line"></i></a>' +
                    (r.status === 'Draft'
                        ? '<button class="btn btn-outline-warning btn-icon" title="Edit Draft" onclick="editDraft(' + r.id + ')"><i class="ri-edit-line"></i></button>' +
                          '<button class="btn btn-outline-success btn-icon" title="Terbitkan" onclick="terbitkan(' + r.id + ')"><i class="ri-send-plane-line"></i></button>' +
                          '<button class="btn btn-outline-danger btn-icon" title="Hapus Draft" onclick="hapusDraft(' + r.id + ')"><i class="ri-delete-bin-line"></i></button>'
                        : '') +
                    (r.status === 'Aktif' ? '<button class="btn btn-outline-danger btn-icon" title="Batalkan Sisa" onclick="batalkan(' + r.id + ')"><i class="ri-close-circle-line"></i></button>' : '');
                return '<div class="crud-list-item"><div class="crud-content">' +
                    '<div class="crud-status">Status: <span class="badge ' + badge + '">' + escapeHtml(r.status) + '</span> <span class="badge bg-light text-dark">' + escapeHtml(r.tipe_tagihan) + '</span></div>' +
                    '<div class="crud-title">' + (index + 1) + '. ' + escapeHtml(r.nama_tagihan) + '</div>' +
                    '<div class="crud-meta">Kode: ' + escapeHtml(r.kode_tagihan) + ' | Tahun: ' + escapeHtml(r.periode) + ' | Target: ' + escapeHtml(r.target_tagihan) + '</div>' +
                    '<div class="crud-note">Siswa: ' + Number(r.jumlah_siswa || 0) + ' | Total: ' + formatRupiah(r.total_nominal || 0) + ' | Belum: ' + Number(r.belum_bayar || 0) + ' | Sebagian: ' + Number(r.sebagian || 0) + ' | Lunas: ' + Number(r.lunas || 0) + '</div></div>' +
                    '<div class="crud-actions">' + actions + '</div></div>';
            }).join('');
            $('#data').html(h);
            refreshDaftarTagihanPagination();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }

    function detail(id) {
        $.ajax({
            url: '<?= base_url('admin/tagihan/daftar_tagihan/detail') ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(r) {
            if (r.result !== 'true') return Swal.fire('Gagal', r.message, 'error');
            var m = r.master,
                h = '<div class="row g-3"><div class="col-md-6"><div class="border rounded p-3"><h5>' + escapeHtml(m.nama_tagihan) + '</h5><div>Kode: ' + escapeHtml(m.kode_tagihan) + '</div><div>Tipe: ' + escapeHtml(m.tipe_tagihan) + '</div><div>Tahun Ajaran: ' + escapeHtml(m.periode) + '</div><div>Status: ' + escapeHtml(m.status) + '</div><div>Dihitung tunggakan: ' + escapeHtml(m.dianggap_tunggakan) + '</div></div></div><div class="col-md-6"><div class="border rounded p-3"><h6>Periode dan Tarif</h6><ul class="mb-0">';
            r.periods.forEach(function(x) {
                h += '<li>' + escapeHtml(x.nama_bulan) + ' ' + x.tahun + ' - ' + formatRupiah(x.nominal) + '</li>';
            });
            h += '</ul></div></div></div><h6 class="mt-4">Kelas Target</h6><div class="d-flex flex-wrap gap-2">';
            r.classes.forEach(function(x) {
                h += '<span class="badge bg-primary-subtle text-primary p-2">' + escapeHtml(x.nama_kelas) + ' - ' + formatRupiah(x.nominal_kelas) + '</span>';
            });
            h += '</div><h6 class="mt-4">Contoh Tagihan Siswa</h6><div class="table-responsive"><table class="table table-sm"><thead><tr><th>No Tagihan</th><th>Siswa</th><th>Periode</th><th>Nominal</th><th>Dibayar</th><th>Sisa</th><th>Status</th></tr></thead><tbody>';
            if (!r.students.length) h += '<tr><td colspan="7" class="text-center text-muted">Draft belum diterbitkan.</td></tr>';
            r.students.forEach(function(x) {
                h += '<tr><td>' + escapeHtml(x.no_tagihan) + '</td><td>' + escapeHtml(x.nama_siswa) + '<br><small>' + escapeHtml(x.nama_kelas) + '</small></td><td>' + escapeHtml(x.nama_bulan) + ' ' + x.tahun + '</td><td>' + formatRupiah(x.nominal_tagihan) + '</td><td>' + formatRupiah(x.nominal_dibayar) + '</td><td>' + formatRupiah(x.sisa_tagihan) + '</td><td>' + escapeHtml(x.status_pembayaran) + '</td></tr>';
            });
            h += '</tbody></table></div>';
            $('#detail_content').html(h);
            modalDetail.show();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }


    function editDraft(id) {
        $.ajax({
            url: '<?= base_url('admin/tagihan/daftar_tagihan/draft_detail') ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'JSON',
            success: function(response) {
                if (response.result !== 'true') {
                    Swal.fire('Gagal', response.message, 'error');
                    return;
                }

                var master = response.master;
                $('#form_edit_draft')[0].reset();
                $('#draft_id').val(master.id);
                $('#draft_periode').val(master.periode || '-');
                $('#draft_jenis_tipe').val((master.nama_jenis_tagihan || '-') + ' / ' + (master.tipe_tagihan || '-'));
                $('#draft_nama_tagihan').val(master.nama_tagihan || '');
                $('#draft_tunggakan').val(master.dianggap_tunggakan || 'Ya');
                $('#draft_keterangan').val(master.keterangan || '');

                var periodHtml = '';
                (response.periods || []).forEach(function(row) {
                    periodHtml += '<tr class="draft-period-item" data-id="' + Number(row.id) + '">' +
                        '<td><strong>' + escapeHtml(row.nama_bulan || '-') + ' ' + Number(row.tahun || 0) + '</strong></td>' +
                        '<td><input type="text" class="form-control form-control-sm nominal-draft text-end" value="' + Number(row.nominal || 0).toLocaleString('id-ID') + '"></td>' +
                        '<td><input type="text" class="form-control form-control-sm jatuh-draft" value="' + escapeHtml(row.tanggal_jatuh_tempo || '') + '" placeholder="dd-mm-yyyy"></td>' +
                    '</tr>';
                });
                $('#draft_period_rows').html(periodHtml);

                flatpickr('#draft_period_rows .jatuh-draft', {
                    dateFormat: 'd-m-Y',
                    allowInput: true,
                    disableMobile: true
                });

                modalEditDraft.show();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function simpanDraft() {
        var periods = [];

        $('#draft_period_rows .draft-period-item').each(function() {
            periods.push({
                id: Number($(this).data('id')),
                nominal: $(this).find('.nominal-draft').val(),
                tanggal_jatuh_tempo: $(this).find('.jatuh-draft').val()
            });
        });

        var button = $('#btn_simpan_draft');
        button.prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/tagihan/daftar_tagihan/update_draft') ?>',
            type: 'POST',
            data: {
                id: $('#draft_id').val(),
                nama_tagihan: $('#draft_nama_tagihan').val(),
                dianggap_tunggakan: $('#draft_tunggakan').val(),
                keterangan: $('#draft_keterangan').val(),
                period_json: JSON.stringify(periods)
            },
            dataType: 'JSON',
            success: function(response) {
                var berhasil = response.result === 'true';
                Swal.fire(
                    berhasil ? 'Berhasil' : 'Gagal',
                    response.message,
                    berhasil ? 'success' : 'error'
                );

                if (berhasil) {
                    modalEditDraft.hide();
                    loadData();
                }
            },
            error: function(xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    }

    function hapusDraft(id) {
        confirmAction(
            'Hapus draft tagihan?',
            'Draft yang belum diterbitkan akan dihapus bersama target dan tarif draft. Tindakan ini tidak berlaku untuk tagihan yang sudah diterbitkan.',
            function() {
                $.ajax({
                    url: '<?= base_url('admin/tagihan/daftar_tagihan/hapus_draft') ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        Swal.fire(
                            response.result === 'true' ? 'Berhasil' : 'Gagal',
                            response.message,
                            response.result === 'true' ? 'success' : 'error'
                        );

                        if (response.result === 'true') {
                            loadData();
                        }
                    },
                    error: function(xhr, status, error) {
                        ajaxError(xhr);
                    }
                });
            }
        );
    }

    function terbitkan(id) {
        confirmAction('Terbitkan draft tagihan?', 'Tagihan siswa akan dibuat berdasarkan target dan tarif tersimpan.', function() {
            $.ajax({
                url: '<?= base_url('admin/tagihan/daftar_tagihan/terbitkan') ?>',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function(r) {
                    Swal.fire(r.result === 'true' ? 'Berhasil' : 'Gagal', r.message, r.result === 'true' ? 'success' : 'error');
                    loadData();
                },
                error: function(xhr, status, error) {
                    ajaxError(xhr, status, error);
                }
            });
        });
    }

    function batalkan(id) {
        Swal.fire({
            title: 'Batalkan sisa tagihan',
            input: 'textarea',
            inputLabel: 'Alasan wajib',
            showCancelButton: true,
            confirmButtonText: 'Batalkan Tagihan',
            preConfirm: function(v) {
                if (!v) Swal.showValidationMessage('Alasan wajib diisi');
                return v;
            }
        }).then(function(res) {
            if (res.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/tagihan/daftar_tagihan/batalkan_sisa') ?>',
                    type: 'POST',
                    data: {
                        id: id,
                        alasan: res.value
                    },
                    dataType: 'JSON',
                    success: function(r) {
                        Swal.fire(r.result === 'true' ? 'Berhasil' : 'Gagal', r.message, r.result === 'true' ? 'success' : 'error');
                        loadData();
                    },
                    error: function(xhr, status, error) {
                        ajaxError(xhr, status, error);
                    }
                });
            }
        });
    }

    function refreshDaftarTagihanPagination() {
        paging($('#data .crud-list-item'), parseInt($('#dt-length-daftar-tagihan').val(), 10) || 10, '#pagination-daftar-tagihan');
    }
</script>