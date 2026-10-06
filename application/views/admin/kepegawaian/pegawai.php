<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data <?= $title; ?></h4>
        <button type="button" class="btn btn-outline-primary" onclick="tambah()">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>

    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-5">
                <label class="form-label">Cari Pegawai</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="cari" placeholder="Cari nama atau telepon ...">
                    <span class="input-group-text bg-primary text-white"><i class="ri-search-line"></i></span>
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label">Jabatan</label>
                <select id="filter_jabatan" class="form-select">
                    <option value="">Semua Jabatan</option>
                    <?php foreach ($jabatan as $row): ?>
                        <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['nama_jabatan']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <button type="button" class="btn btn-primary" id="btn-cari">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="data_pegawai" class="crud-list"></div>

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

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pegawai" class="form-control" placeholder="Nama pegawai ..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jk" class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki - Laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir ..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal_lahir" class="form-control" placeholder="Tanggal lahir ..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_tlp" class="form-control" placeholder="No. telepon ...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <select name="id_jabatan[]"
                                id="jabatan_tambah"
                                class="select2 form-control select2-multiple"
                                multiple="multiple">
                                <?php foreach ($jabatan as $row): ?>
                                    <option value="<?= (int) $row['id'] ?>">
                                        <?= html_escape($row['nama_jabatan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
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

<!-- Modal Edit -->
<div class="modal fade" id="edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit">
                    <input type="hidden" name="id" id="id_pegawai">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pegawai <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pegawai" class="form-control" placeholder="Nama pegawai ..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jk" class="form-select" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki - Laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat lahir ..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tanggal_lahir" class="form-control" placeholder="Tanggal lahir ..." required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Telepon</label>
                            <input type="text" name="no_tlp" class="form-control" placeholder="No. telepon ...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <select name="id_jabatan[]"
                                id="jabatan_edit"
                                class="select2 form-control select2-multiple"
                                multiple="multiple">
                                <?php foreach ($jabatan as $row): ?>
                                    <option value="<?= (int) $row['id'] ?>">
                                        <?= html_escape($row['nama_jabatan']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
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
    var fpTanggalLahirTambah;
    var fpTanggalLahirEdit;

    $(document).ready(function() {
        pegawai();

        $('#jabatan_tambah').select2({
            width: '100%',
            placeholder: 'Pilih Jabatan',
            dropdownParent: $('#tambah')
        });

        $('#jabatan_edit').select2({
            width: '100%',
            placeholder: 'Pilih Jabatan',
            dropdownParent: $('#edit')
        });

        fpTanggalLahirTambah = flatpickr('#form-tambah [name="tanggal_lahir"]', {
            dateFormat: 'd-m-Y',
            altInput: true,
            altFormat: 'd F Y',
            locale: 'id',
            disableMobile: true
        });

        fpTanggalLahirEdit = flatpickr('#form-edit [name="tanggal_lahir"]', {
            dateFormat: 'd-m-Y',
            altInput: true,
            altFormat: 'd F Y',
            locale: 'id',
            disableMobile: true
        });

        $('#btn-cari').click(function() {
            pegawai();
        });

        $('#cari').on('keyup', function(e) {
            if (e.key === 'Enter') pegawai();
        });
        // $('#filter_jabatan').on('change', function () {
        //     pegawai();
        // });

        $('#btn-simpan').click(function() {
            if (!validasiFormPegawai('#form-tambah')) return;

            var form = $('#form-tambah');
            var button = $('#btn-simpan').prop('disabled', true);

            $.ajax({
                url: '<?= base_url('admin/kepegawaian/pegawai/tambah'); ?>',
                type: 'POST',
                data: form.serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.result === 'true') {
                        $('#tambah').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message || 'Data berhasil disimpan'
                        });
                        resetFormPegawai('#form-tambah');
                        pegawai();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Data gagal disimpan'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    ajaxError(xhr, status, error);
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });

        $('#btn-update').click(function() {
            if (!validasiFormPegawai('#form-edit')) return;

            var form = $('#form-edit');
            var button = $('#btn-update').prop('disabled', true);

            $.ajax({
                url: '<?= base_url('admin/kepegawaian/pegawai/edit'); ?>',
                type: 'POST',
                data: form.serialize(),
                dataType: 'JSON',
                success: function(data) {
                    if (data.result === 'true') {
                        $('#edit').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message || 'Data berhasil diupdate'
                        });
                        pegawai();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: data.message || 'Data gagal diupdate'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    ajaxError(xhr, status, error);
                },
                complete: function() {
                    button.prop('disabled', false);
                }
            });
        });

        $('#dt-length-0').on('change', function() {
            refreshPagination();
        });
    });

    function pegawai() {
        $.ajax({
            url: '<?= base_url('admin/kepegawaian/pegawai/pegawai_result'); ?>',
            type: 'POST',
            data: {
                search: $('#cari').val(),
                id_jabatan: $('#filter_jabatan').val()
            },
            dataType: 'JSON',
            success: function(data) {
                var no = 1;
                var html = '';

                if (!Array.isArray(data) || data.length === 0) {
                    html = '<div class="empty-state">Belum ada data pegawai.</div>';
                } else {
                    data.forEach(function(item) {
                        var detail = btoa(unescape(encodeURIComponent(JSON.stringify(item))));

                        html += '<div class="crud-list-item">' +
                            '<div class="crud-content">' +
                            '<div class="crud-title">' + (no++) + '. ' + escapeHtml(item.nama_pegawai || '-') + '</div>' +
                            '<div class="crud-meta">Jenis Kelamin: ' + escapeHtml(item.jk || '-') + ' | Telepon: ' + escapeHtml(item.no_tlp || '-') + '</div>' +
                            '<div class="crud-note">Tempat/Tanggal Lahir: ' + escapeHtml(item.tempat_lahir || '-') + ', ' + escapeHtml(item.tanggal_lahir_form || item.tanggal_lahir || '-') + '</div>' +
                            '<div class="crud-note">Jabatan: ' + escapeHtml(item.jabatan || '-') + '</div>' +
                            '</div>' +
                            '<div class="crud-actions">' +
                            '<button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="edit(\'' + detail + '\')"><i class="ri-edit-line"></i></button>' +
                            '<button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus(\'' + Number(item.id) + '\')"><i class="ri-delete-bin-line"></i></button>' +
                            '</div>' +
                            '</div>';
                    });
                }

                $('#data_pegawai').html(html);
                refreshPagination();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }

    function tambah() {
        resetFormPegawai('#form-tambah');
        $('#tambah').modal('show');
    }

    function edit(detail) {
        var item = JSON.parse(decodeURIComponent(escape(atob(detail))));
        var form = '#form-edit';

        resetFormPegawai(form);
        $(form + ' [name="id"]').val(item.id || '');
        $(form + ' [name="nama_pegawai"]').val(item.nama_pegawai || '');
        $(form + ' [name="jk"]').val(item.jk || '');
        $(form + ' [name="tempat_lahir"]').val(item.tempat_lahir || '');
        $(form + ' [name="no_tlp"]').val(item.no_tlp || '');

        if (fpTanggalLahirEdit) {
            fpTanggalLahirEdit.setDate(item.tanggal_lahir_form || null, false, 'd-m-Y');
        }

        $(form + ' [name="id_jabatan[]"]').val(csvToArray(item.jabatan_ids)).trigger('change');

        $('#edit').modal('show');
    }

    function hapus(id) {
        Swal.fire({
            title: 'Hapus Data',
            text: 'Anda yakin ingin menghapus data pegawai ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/kepegawaian/pegawai/hapus'); ?>',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.result === 'true') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: data.message || 'Data berhasil dihapus'
                            });
                            pegawai();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message || 'Data gagal dihapus'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        ajaxError(xhr, status, error);
                    }
                });
            }
        });
    }

    function validasiFormPegawai(form) {
        if ($.trim($(form + ' [name="nama_pegawai"]').val()) === '') {
            Swal.fire('Perhatian', 'Nama pegawai wajib diisi.', 'warning');
            return false;
        }
        if ($(form + ' [name="jk"]').val() === '') {
            Swal.fire('Perhatian', 'Jenis kelamin wajib dipilih.', 'warning');
            return false;
        }
        if ($.trim($(form + ' [name="tempat_lahir"]').val()) === '') {
            Swal.fire('Perhatian', 'Tempat lahir wajib diisi.', 'warning');
            return false;
        }
        if ($.trim($(form + ' [name="tanggal_lahir"]').val()) === '') {
            Swal.fire('Perhatian', 'Tanggal lahir wajib diisi.', 'warning');
            return false;
        }
        if (($(form + ' [name="id_jabatan[]"]').val() || []).length === 0) {
            Swal.fire('Perhatian', 'Minimal satu jabatan wajib dipilih.', 'warning');
            return false;
        }

        return true;
    }


    function resetFormPegawai(form) {
        $(form)[0].reset();
        $(form + ' [name="id_jabatan[]"]').val(null).trigger('change');
        if (form === '#form-tambah' && fpTanggalLahirTambah) fpTanggalLahirTambah.clear();
        if (form === '#form-edit' && fpTanggalLahirEdit) fpTanggalLahirEdit.clear();
    }

    function csvToArray(csv) {
        return String(csv || '')
            .split(',')
            .map(function(value) {
                return $.trim(value);
            })
            .filter(function(value) {
                return value !== '';
            });
    }

    function refreshPagination() {
        paging(
            $('#data_pegawai .crud-list-item'),
            parseInt($('#dt-length-0').val(), 10) || 10,
            '#pagination'
        );
    }
</script>