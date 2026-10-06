<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Hak Akses</h4>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary" id="btn-tambah">
                <i class="ri-add-line me-1"></i>Tambah
            </button>
            <button type="button" class="btn btn-outline-danger" id="btn-hapus">
                <i class="ri-delete-bin-line me-1"></i>Hapus
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label for="id_level_filter" class="form-label">Level</label>
                <select id="id_level_filter" class="form-select">
                    <option value="">Pilih Level</option>
                    <?php foreach ($level as $row): ?>
                        <option value="<?= (int) $row['id'] ?>"><?= html_escape($row['level']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="cari" class="form-label">Cari Hak Akses</label>
                <input type="text" class="form-control" id="cari" placeholder="Cari nama menu atau group ...">
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn-cari">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="pilih-semua-hak-akses-wrap" class="mt-3 d-none">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="pilih-semua-hak-akses">
                <label class="form-check-label fw-semibold" for="pilih-semua-hak-akses">
                    Pilih Semua
                </label>
            </div>
        </div>

        <div id="data_hak_akses" class="crud-list mt-2"></div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-2">
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

<div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Hak Akses</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info py-2">
                    Level: <strong id="nama_level_modal">-</strong>
                </div>
                <div class="row g-2 align-items-end">
                    <div class="col-md-10">
                        <label for="cari_menu" class="form-label">Cari Menu</label>
                        <input type="text" class="form-control" id="cari_menu" placeholder="Cari nama menu atau group ...">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="button" class="btn btn-primary" id="btn-cari-menu">
                            <i class="ri-search-line me-1"></i>Cari
                        </button>
                    </div>
                </div>

                <form id="form-tambah">
                    <input type="hidden" name="id_level" id="id_level_tambah">

                    <div id="pilih-semua-menu-wrap" class="mt-3 d-none">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pilih-semua-menu">
                            <label class="form-check-label fw-semibold" for="pilih-semua-menu">
                                Pilih Semua
                            </label>
                        </div>
                    </div>

                    <div id="data_menu" class="crud-list mt-2"></div>
                </form>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-2">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-menu"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-menu" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-menu">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>entri</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn-simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    hak_akses();

    $('#id_level_filter').change(function () {
        hak_akses();
    });

    $('#btn-cari').click(function () {
        hak_akses();
    });

    $('#cari').keyup(function (event) {
        if (event.key === 'Enter') hak_akses();
    });

    $('#btn-tambah').click(function () {
        tambah();
    });

    $('#btn-hapus').click(function () {
        hapus();
    });

    $('#pilih-semua-hak-akses').on('change', function () {
        $('.pilih-hak-akses').prop('checked', this.checked);
        sinkron_pilih_semua_hak_akses();
    });

    $(document).on('change', '.pilih-hak-akses', function () {
        sinkron_pilih_semua_hak_akses();
    });

    $('#pilih-semua-menu').on('change', function () {
        $('.pilih-menu').prop('checked', this.checked);
        sinkron_pilih_semua_menu();
    });

    $(document).on('change', '.pilih-menu', function () {
        sinkron_pilih_semua_menu();
    });

    $('#btn-cari-menu').click(function () {
        menu_result();
    });

    $('#cari_menu').keyup(function (event) {
        if (event.key === 'Enter') menu_result();
    });

    $('#btn-simpan').click(function () {
        var form = $('#form-tambah');
        var data = form.serialize();

        $.ajax({
            url: '<?= base_url('admin/pengaturan/hak_akses/tambah'); ?>',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.result == 'true') {
                    $('#tambah').modal('hide');
                    Swal.fire({icon: 'success', title: 'Berhasil', text: data.message});
                    hak_akses();
                } else if (data.result == 'false') {
                    Swal.fire({icon: 'error', title: 'Gagal', text: data.message});
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    });

    $('#dt-length-0').on('change', function () {
        const jumlah = parseInt($(this).val());
        paging($('#data_hak_akses .crud-list-item'), jumlah);
    });

    $('#dt-length-menu').on('change', function () {
        const jumlah = parseInt($(this).val());
        paging($('#data_menu .crud-list-item'), jumlah, '#pagination-menu');
    });
});

function hak_akses() {
    var id_level = $('#id_level_filter').val();
    var search = $('#cari').val();

    if (id_level == '') {
        $('#pilih-semua-hak-akses').prop('checked', false).prop('indeterminate', false);
        $('#pilih-semua-hak-akses-wrap').addClass('d-none');

        $('#data_hak_akses').html(`
            <div class="crud-list-item">
                <div class="crud-content">
                    <div class="crud-title">Pilih level terlebih dahulu.</div>
                </div>
            </div>`);

        paging(
            $('#data_hak_akses .crud-list-item'),
            parseInt($('#dt-length-0').val())
        );
        return;
    }

    $.ajax({
        url: '<?= base_url('admin/pengaturan/hak_akses/hak_akses_result'); ?>',
        type: 'POST',
        data: {
            id_level: id_level,
            search: search
        },
        dataType: 'JSON',
        success: function (data) {
            var no = 1;
            var table = '';

            $('#pilih-semua-hak-akses').prop('checked', false).prop('indeterminate', false);

            if (data.length == 0) {
                $('#pilih-semua-hak-akses-wrap').addClass('d-none');
                table += `
                    <div class="crud-list-item">
                        <div class="crud-content">
                            <div class="crud-title">Tidak ada data</div>
                        </div>
                    </div>`;
            } else {
                $('#pilih-semua-hak-akses-wrap').removeClass('d-none');
                data.forEach(function (item) {
                    table += `
                        <div class="crud-list-item">
                            <div class="crud-content">
                                <div class="crud-status">Group: ${escapeHtml(item.group || '-')}</div>
                                <div class="crud-title">${no++}. ${escapeHtml(item.name)}</div>
                            </div>
                            <div class="crud-actions">
                                <input
                                    class="form-check-input pilih-hak-akses"
                                    type="checkbox"
                                    value="${item.id}"
                                    title="Pilih hak akses"
                                >
                            </div>
                        </div>`;
                });
            }

            $('#data_hak_akses').html(table);
            sinkron_pilih_semua_hak_akses();
            let jumlah_awal = parseInt($('#dt-length-0').val());
            paging($('#data_hak_akses .crud-list-item'), jumlah_awal);
        },
        error: function (xhr, status, error) {
            ajaxError(xhr);
        }
    });
}

function tambah() {
    var id_level = $('#id_level_filter').val();
    if (id_level == '') {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan',
            text: 'Level belum dipilih.'
        });
        return;
    }

    $('#id_level_tambah').val(id_level);
    $('#nama_level_modal').text($('#id_level_filter option:selected').text());
    $('#cari_menu').val('');
    menu_result();
    $('#tambah').modal('show');
}

function menu_result() {
    var id_level = $('#id_level_filter').val();
    var search = $('#cari_menu').val();

    $.ajax({
        url: '<?= base_url('admin/pengaturan/hak_akses/menu_result'); ?>',
        type: 'POST',
        data: {
            id_level: id_level,
            search: search
        },
        dataType: 'JSON',
        success: function (data) {
            var no = 1;
            var table = '';

            $('#pilih-semua-menu').prop('checked', false).prop('indeterminate', false);

            if (data.length == 0) {
                $('#pilih-semua-menu-wrap').addClass('d-none');
                table += `
                    <div class="crud-list-item">
                        <div class="crud-content">
                            <div class="crud-title">Tidak ada menu yang dapat ditambahkan.</div>
                        </div>
                    </div>`;
            } else {
                $('#pilih-semua-menu-wrap').removeClass('d-none');
                data.forEach(function (item) {
                    table += `
                        <div class="crud-list-item">
                            <div class="crud-content">
                                <div class="crud-status">Group: ${escapeHtml(item.group || '-')}</div>
                                <div class="crud-title">${no++}. ${escapeHtml(item.name)}</div>
                            </div>
                            <div class="crud-actions">
                                <input
                                    class="form-check-input pilih-menu"
                                    type="checkbox"
                                    name="id_menu[]"
                                    value="${item.id}"
                                    title="Pilih menu"
                                >
                            </div>
                        </div>`;
                });
            }

            $('#data_menu').html(table);
            sinkron_pilih_semua_menu();
            let jumlah_awal = parseInt($('#dt-length-menu').val());
            paging($('#data_menu .crud-list-item'), jumlah_awal, '#pagination-menu');
        },
        error: function (xhr, status, error) {
            ajaxError(xhr);
        }
    });
}

function sinkron_pilih_semua_hak_akses() {
    var total = $('.pilih-hak-akses').length;
    var terpilih = $('.pilih-hak-akses:checked').length;
    var pilih_semua = $('#pilih-semua-hak-akses').get(0);

    if (!pilih_semua) return;

    pilih_semua.checked = total > 0 && terpilih === total;
    pilih_semua.indeterminate = terpilih > 0 && terpilih < total;
}

function sinkron_pilih_semua_menu() {
    var total = $('.pilih-menu').length;
    var terpilih = $('.pilih-menu:checked').length;
    var pilih_semua = $('#pilih-semua-menu').get(0);

    if (!pilih_semua) return;

    pilih_semua.checked = total > 0 && terpilih === total;
    pilih_semua.indeterminate = terpilih > 0 && terpilih < total;
}

function hapus() {
    var id_level = $('#id_level_filter').val();
    var ids = $('.pilih-hak-akses:checked').map(function () {
        return this.value;
    }).get();

    if (id_level == '') {
        Swal.fire({icon: 'warning', title: 'Peringatan', text: 'Level belum dipilih.'});
        return;
    }

    if (ids.length == 0) {
        Swal.fire({icon: 'warning', title: 'Peringatan', text: 'Pilih hak akses yang akan dihapus.'});
        return;
    }

    Swal.fire({
        title: 'Hapus Hak Akses',
        text: 'Hak akses yang dipilih akan dihapus dari level ini.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('admin/pengaturan/hak_akses/hapus'); ?>',
                type: 'POST',
                data: {
                    id_level: id_level,
                    id: ids
                },
                dataType: 'JSON',
                success: function (data) {
                    if (data.result == 'true') {
                        Swal.fire({icon: 'success', title: 'Berhasil', text: data.message});
                        hak_akses();
                    } else if (data.result == 'false') {
                        Swal.fire({icon: 'error', title: 'Gagal', text: data.message});
                    }
                },
                error: function (xhr, status, error) {
                    ajaxError(xhr);
                }
            });
        }
    });
}
</script>
