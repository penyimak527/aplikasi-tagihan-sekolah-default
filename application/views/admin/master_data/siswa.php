<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Siswa</h4>
        <button type="button" class="btn btn-outline-primary" onclick="tambah()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-lg-4 col-md-12">
                <input type="text" id="search" class="form-control" placeholder="Nama / NIS / NISN ...">
            </div>
            <div class="col-lg-2 col-md-6">
                <select id="periode_filter" class="form-select">
                    <option value="0">Semua Tahun Ajaran</option>
                    <?php foreach ($periode as $row): ?>
                        <option value="<?= $row['id'] ?>"><?= html_escape($row['periode']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <select id="kelas_filter" class="form-select">
                    <option value="0">Semua Kelas</option>
                    <?php foreach ($kelas as $row): ?>
                        <option value="<?= $row['id'] ?>" data-periode="<?= $row['id_periode'] ?>"><?= html_escape($row['nama_kelas']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <select id="status_filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Lulus">Lulus</option>
                    <option value="Pindah Sekolah">Pindah Sekolah</option>
                    <option value="Berhenti">Berhenti</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="col-lg-2 col-md-6 d-grid">
                <button type="button" class="btn btn-primary" onclick="siswa()">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="data_siswa" class="crud-list"></div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3">
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

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah">
                    <ul class="nav nav-tabs nav-bordered mb-4" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tabTambahIdentitas">Identitas</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabTambahAlamat">Alamat</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabTambahAyah">Data Ayah</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabTambahIbu">Data Ibu</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="tabTambahIdentitas">
                            <div class="row">
                                <div class="col-md-4 mb-3"><label class="form-label">NIS</label><input name="nis" class="form-control" placeholder="NIS ..." required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">NISN</label><input name="nisn" class="form-control" placeholder="NISN ..." required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Status</label><select name="status_pendaftaran" class="form-select"><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select></div>
                                <div class="col-md-8 mb-3"><label class="form-label">Nama Lengkap</label><input name="nama_lengkap" class="form-control" placeholder="Nama lengkap ..." required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Jenis Kelamin</label><select name="jk" class="form-select"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tempat Lahir</label><input name="tempat_lahir" class="form-control" placeholder="Tempat lahir ..."></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tanggal Lahir</label><input name="tanggal_lahir" class="form-control tanggal" placeholder="dd-mm-yyyy"></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tanggal Awal Masuk</label><input name="tanggal_awal_masuk" class="form-control tanggal" placeholder="dd-mm-yyyy"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabTambahAlamat"><label class="form-label">Alamat Siswa</label><textarea name="alamat_siswa" class="form-control" rows="5" placeholder="Alamat siswa ..."></textarea></div>
                        <div class="tab-pane" id="tabTambahAyah"><div class="row"><div class="col-md-6 mb-3"><label class="form-label">Nama Ayah</label><input name="nama_ayah" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Pekerjaan Ayah</label><input name="pekerjaan_ayah" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Telepon Ayah</label><input name="telepon_ayah" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Alamat Ayah</label><textarea name="alamat_ayah" class="form-control"></textarea></div></div></div>
                        <div class="tab-pane" id="tabTambahIbu"><div class="row"><div class="col-md-6 mb-3"><label class="form-label">Nama Ibu</label><input name="nama_ibu" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Pekerjaan Ibu</label><input name="pekerjaan_ibu" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Telepon Ibu</label><input name="telepon_ibu" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Alamat Ibu</label><textarea name="alamat_ibu" class="form-control"></textarea></div></div></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit / Detail -->
<div class="modal fade" id="edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judul-edit">Edit Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit">
                    <input type="hidden" name="id">
                    <ul class="nav nav-tabs nav-bordered mb-4" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tabEditIdentitas">Identitas</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabEditAlamat">Alamat</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabEditAyah">Data Ayah</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabEditIbu">Data Ibu</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="tabEditIdentitas">
                            <div class="row">
                                <div class="col-md-4 mb-3"><label class="form-label">NIS</label><input name="nis" class="form-control" required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">NISN</label><input name="nisn" class="form-control" required></div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status_pendaftaran" class="form-select"><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select>
                                    <input type="text" id="status-readonly" class="form-control" readonly style="display:none;">
                                    <small id="status-keterangan" class="text-muted" style="display:none;">Status tidak dapat diubah dari Master Data karena siswa sudah memiliki data Kesiswaan.</small>
                                </div>
                                <div class="col-md-8 mb-3"><label class="form-label">Nama Lengkap</label><input name="nama_lengkap" class="form-control" required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Jenis Kelamin</label><select name="jk" class="form-select"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tempat Lahir</label><input name="tempat_lahir" class="form-control"></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tanggal Lahir</label><input name="tanggal_lahir" class="form-control tanggal"></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tanggal Awal Masuk</label><input name="tanggal_awal_masuk" class="form-control tanggal"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabEditAlamat"><label class="form-label">Alamat Siswa</label><textarea name="alamat_siswa" class="form-control" rows="5"></textarea></div>
                        <div class="tab-pane" id="tabEditAyah"><div class="row"><div class="col-md-6 mb-3"><label class="form-label">Nama Ayah</label><input name="nama_ayah" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Pekerjaan Ayah</label><input name="pekerjaan_ayah" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Telepon Ayah</label><input name="telepon_ayah" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Alamat Ayah</label><textarea name="alamat_ayah" class="form-control"></textarea></div></div></div>
                        <div class="tab-pane" id="tabEditIbu"><div class="row"><div class="col-md-6 mb-3"><label class="form-label">Nama Ibu</label><input name="nama_ibu" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Pekerjaan Ibu</label><input name="pekerjaan_ibu" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Telepon Ibu</label><input name="telepon_ibu" class="form-control"></div><div class="col-md-6 mb-3"><label class="form-label">Alamat Ibu</label><textarea name="alamat_ibu" class="form-control"></textarea></div></div></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-update">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        siswa();
        filterKelas();

        flatpickr('.tanggal', {
            dateFormat: 'd-m-Y'
        });

        $('#periode_filter').on('change', function() {
            filterKelas();
        });

        $('#search').on('keyup', function(event) {
            if (event.key === 'Enter') siswa();
        });

        $('#btn-simpan').click(function() {
            var form = $('#form-tambah');
            var data = form.serialize();
            $('#btn-simpan').prop('disabled', true);
			$('#btn-simpan').html('Sedang Diproses');
            $.ajax({
                url: '<?= base_url('admin/master_data/siswa/tambah'); ?>',
                type: 'POST',
                data: data,
                dataType: 'JSON',
                success: function(data) {
                    if (data.result == 'true') {
                        $('#tambah').modal('hide');
                        Swal.fire({icon: 'success', title: 'Berhasil', text: data.message || 'Data berhasil disimpan'});
                        $('#form-tambah')[0].reset();
                        $('#btn-simpan').prop('disabled', false);
						$('#btn-simpan').html('Simpan');
                        siswa();
                    } else {
                        Swal.fire({icon: 'error', title: 'Gagal', text: data.message || 'Data gagal disimpan'});
                    }
                    
                },
                error: function(xhr) {
                    ajaxError(xhr);
                }
            });
        });

        $('#btn-update').click(function() {
            var form = $('#form-edit');
            var data = form.serialize();
$('#btn-update').prop('disabled', true);
			$('#btn-update').html('Sedang Diproses');
            $.ajax({
                url: '<?= base_url('admin/master_data/siswa/edit'); ?>',
                type: 'POST',
                data: data,
                dataType: 'JSON',
                success: function(data) {
                    if (data.result == 'true') {
                        $('#edit').modal('hide');
                        Swal.fire({icon: 'success', title: 'Berhasil', text: data.message || 'Data berhasil diubah'});
                        $('#btn-update').prop('disabled', false);
						$('#btn-update').html('Simpan');
                        siswa();
                    } else {
                        Swal.fire({icon: 'error', title: 'Gagal', text: data.message || 'Data gagal diubah'});
                    }
                },
                error: function(xhr) {
                    ajaxError(xhr);
                }
            });
        });

        $('#dt-length-0').on('change', function() {
            var jumlah = parseInt($(this).val(), 10) || 10;
            paging($('#data_siswa .crud-list-item'), jumlah);
        });
    });

    function filterKelas() {
        var periode = $('#periode_filter').val();
        $('#kelas_filter option').each(function() {
            var optionPeriode = $(this).data('periode');
            $(this).toggle(!optionPeriode || periode === '0' || String(optionPeriode) === String(periode));
        });
        $('#kelas_filter').val('0');
    }

    function siswa() {
        var search = $('#search').val();
        var id_periode = $('#periode_filter').val();
        var id_kelas_setting = $('#kelas_filter').val();
        var status = $('#status_filter').val();

        $.ajax({
            url: '<?= base_url('admin/master_data/siswa/siswa_result'); ?>',
            type: 'POST',
            data: {
                search: search,
                id_periode: id_periode,
                id_kelas_setting: id_kelas_setting,
                status: status
            },
            dataType: 'JSON',
            success: function(data) {
                var no = 1;
                var table = '';

                if (data.length == 0) {
                    table = '<div class="empty-state">Data siswa tidak ditemukan.</div>';
                } else {
                    data.forEach(function(item) {
                        var detailData = btoa(unescape(encodeURIComponent(JSON.stringify(item))));
                        var aktif = item.status_pendaftaran === 'Aktif';
                        var tombolHapus = '';

                        if (String(item.boleh_hapus) === '1') {
                            tombolHapus = `<button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus('${item.id}')"><i class="ri-delete-bin-line"></i></button>`;
                        }

                        table += `
                            <div class="crud-list-item">
                                <div class="crud-content">
                                    <div class="crud-status">Status: <span class="badge ${aktif ? 'bg-success' : 'bg-secondary'}">${escapeHtml(item.status_pendaftaran || '-')}</span></div>
                                    <div class="crud-title">${no++}. ${escapeHtml(item.nama_lengkap || '-')}</div>
                                    <div class="crud-meta">NIS: ${escapeHtml(item.nis || '-')} | NISN: ${escapeHtml(item.nisn || '-')} | ${escapeHtml(item.jk || '-')}</div>
                                    <div class="crud-note">Kelas aktif: ${escapeHtml(item.nama_kelas || 'Belum ditempatkan')} | ${escapeHtml(item.periode || '-')}</div>
                                </div>
                                <div class="crud-actions">
                                    <button type="button" class="btn btn-outline-primary btn-icon" title="Detail" onclick="detail('${detailData}')"><i class="ri-eye-line"></i></button>
                                    <button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="edit('${detailData}')"><i class="ri-edit-line"></i></button>
                                    <a class="btn btn-outline-info btn-icon" title="Riwayat Kelas" href="<?= base_url('admin/kesiswaan/riwayat_kelas?id_siswa=') ?>${item.id}"><i class="ri-history-line"></i></a>
                                    <a class="btn btn-outline-primary btn-icon" title="Riwayat Tagihan" href="<?= base_url('admin/tunggakan/tagihan_per_siswa?id_siswa=') ?>${item.id}"><i class="ri-file-list-3-line"></i></a>
                                    ${tombolHapus}
                                </div>
                            </div>`;
                    });
                }

                $('#data_siswa').html(table);
                var jumlah = parseInt($('#dt-length-0').val(), 10) || 10;
                paging($('#data_siswa .crud-list-item'), jumlah);
            },
            error: function(xhr) {
                ajaxError(xhr);
            }
        });
    }

    function tambah() {
        $('#form-tambah')[0].reset();
        $('#form-tambah select[name="status_pendaftaran"]').val('Aktif');
        bootstrap.Tab.getOrCreateInstance(document.querySelector('a[href="#tabTambahIdentitas"]')).show();
        $('#tambah').modal('show');
    }

    function isiFormEdit(item, detailMode) {
        var form = $('#form-edit');
        form[0].reset();
        form.find(':input').prop('disabled', false);
        $('#btn-update').show();
        $('#status-readonly').hide();
        $('#status-keterangan').hide();
        form.find('select[name="status_pendaftaran"]').show().prop('disabled', false);

        Object.keys(item).forEach(function(key) {
            form.find('[name="' + key + '"]').val(item[key]);
        });

        if (String(item.status_boleh_diubah) !== '1') {
            form.find('select[name="status_pendaftaran"]').hide().prop('disabled', true);
            $('#status-readonly').val(item.status_pendaftaran || '-').show();
            $('#status-keterangan').show();
        }

        if (detailMode) {
            form.find(':input').prop('disabled', true);
            $('#btn-update').hide();
            $('#status-keterangan').hide();
        }

        bootstrap.Tab.getOrCreateInstance(document.querySelector('a[href="#tabEditIdentitas"]')).show();
    }

    function edit(detailData) {
        var item = JSON.parse(decodeURIComponent(escape(atob(detailData))));
        $('#judul-edit').text('Edit Siswa');
        isiFormEdit(item, false);
        $('#edit').modal('show');
    }

    function detail(detailData) {
        var item = JSON.parse(decodeURIComponent(escape(atob(detailData))));
        $('#judul-edit').text('Detail Siswa');
        isiFormEdit(item, true);
        $('#edit').modal('show');
    }

    function hapus(id) {
        Swal.fire({
            title: 'Hapus Data',
            text: 'Siswa hanya dapat dihapus jika belum pernah ditempatkan dan belum memiliki riwayat Kesiswaan. Lanjutkan?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function(result) {
            if (result.isConfirmed || result.value) {
                $.ajax({
                    url: '<?= base_url('admin/master_data/siswa/hapus'); ?>',
                    type: 'POST',
                    data: {id: id},
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.result == 'true') {
                            Swal.fire({icon: 'success', title: 'Berhasil', text: data.message || 'Data berhasil dihapus'});
                            siswa();
                        } else {
                            Swal.fire({icon: 'error', title: 'Gagal', text: data.message || 'Data gagal dihapus'});
                        }
                    },
                    error: function(xhr) {
                        ajaxError(xhr);
                    }
                });
            }
        });
    }

    function paging($selector, jumlah_tampil = 10) {
        window.tp = new Pagination('#pagination', {
            itemsCount: $selector.length,
            pageSize: parseInt(jumlah_tampil),
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
</script>
