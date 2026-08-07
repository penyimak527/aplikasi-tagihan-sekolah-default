<div class="row g-3">
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header border-bottom border-dashed">
                <h4 class="header-title mb-0">Cari Siswa</h4>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12">
                        <label for="filter_siswa" class="form-label">Nama/NIS/NISN</label>
                        <input type="text" id="filter_siswa" class="form-control" placeholder="Nama/NIS/NISN">
                    </div>
                    <div class="col-12 d-grid">
                        <button type="button" class="btn btn-primary" id="btn_cari">
                            <i class="ri-search-line me-1"></i>Cari
                        </button>
                    </div>
                </div>

                <div id="hasil" class="mt-3"></div>

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
    </div>

    <div class="col-xl-7">
        <div class="card">
            <div class="card-header border-bottom border-dashed">
                <h4 class="header-title mb-0">Perubahan Status Siswa</h4>
            </div>
            <div class="card-body">
                <form id="form">
                    <input type="hidden" name="id_siswa">

                    <div class="alert alert-info" id="identitas">Pilih siswa terlebih dahulu.</div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Status Baru</label>
                            <select name="status_baru" class="form-select">
                                <option>Pindah Sekolah</option>
                                <option>Berhenti</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="text" name="tanggal" class="form-control tanggal" value="<?= date('d-m-Y') ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alasan</label>
                            <textarea name="alasan" class="form-control" required></textarea>
                        </div>

                        <div class="col-12">
                            <button type="button" id="btn_proses" class="btn btn-primary">
                                Simpan Perubahan Status
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        flatpickr('.tanggal', {
            dateFormat: 'd-m-Y'
        });

        $('#btn_cari').on('click', function() {
            cari();
        });

        $('#filter_siswa').on('keyup', function(e) {
            if (e.key === 'Enter') {
                cari();
            }
        });

        $('#btn_proses').on('click', function() {
            proses();
        });

        $('#dt-length-0').on('change', function() {
            const jumlah = parseInt($(this).val(), 10) || 10;
            paging($('#hasil .item-siswa'), jumlah);
        });
    });

    function cari() {
        var search = $.trim($('#filter_siswa').val());
        var button = $('#btn_cari');

        $.ajax({
            url: '<?= base_url('status_siswa/cari'); ?>',
            type: 'POST',
            data: {
                q: search
            },
            dataType: 'JSON',
            beforeSend: function() {
                button.prop('disabled', true);
                button.html('<span class="spinner-border spinner-border-sm me-1"></span>Mencari');

                $('#hasil').html(
                    '<div class="text-center py-3">' +
                        '<span class="spinner-border spinner-border-sm me-1"></span>Memuat data siswa...' +
                    '</div>'
                );

                $('#pagination').empty();
            },
            success: function(rows) {
                var html = '';

                if (!Array.isArray(rows) || rows.length === 0) {
                    html = '<div class="empty-state">Siswa tidak ditemukan.</div>';
                    $('#hasil').html(html);
                    $('#pagination').empty();
                    return;
                }

                rows.forEach(function(row) {
                    var detail = encodeURIComponent(JSON.stringify(row));

                    html += '<button type="button" ' +
                        'class="list-group-item list-group-item-action border rounded mb-2 item-siswa" ' +
                        'data-siswa="' + detail + '">' +
                            '<strong>' + escapeHtml(row.nama_lengkap || '-') + '</strong><br>' +
                            '<small>' +
                                escapeHtml(row.nis || '-') + ' | ' +
                                escapeHtml(row.nama_kelas || 'Belum ditempatkan') + ' | ' +
                                escapeHtml(row.status_pendaftaran || '-') +
                            '</small>' +
                        '</button>';
                });

                $('#hasil').html(html);

                $('#hasil .item-siswa').off('click').on('click', function() {
                    var row = JSON.parse(decodeURIComponent($(this).attr('data-siswa')));
                    pilih(row);
                });

                var jumlahAwal = parseInt($('#dt-length-0').val(), 10) || 10;
                paging($('#hasil .item-siswa'), jumlahAwal);
            },
            error: function(xhr, status, error) {
                $('#hasil').html(
                    '<div class="empty-state text-danger">Data siswa gagal dimuat.</div>'
                );
                $('#pagination').empty();
                ajaxError(xhr, status, error);
            },
            complete: function() {
                button.prop('disabled', false);
                button.html('<i class="ri-search-line me-1"></i>Cari');
            }
        });
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

    function pilih(row) {
        $('#form [name="id_siswa"]').val(row.id);

        $('#identitas').html(
            '<strong>' + escapeHtml(row.nama_lengkap || '-') + '</strong><br>' +
            'NIS ' + escapeHtml(row.nis || '-') +
            ' | Kelas: ' + escapeHtml(row.nama_kelas || '-') +
            ' | Status: ' + escapeHtml(row.status_pendaftaran || '-')
        );
    }

    function proses() {
        var idSiswa = $('#form [name="id_siswa"]').val();

        if (!idSiswa) {
            Swal.fire('Perhatian', 'Pilih siswa terlebih dahulu.', 'warning');
            return;
        }

        confirmAction(
            'Simpan perubahan status?',
            'Siswa tidak ikut tagihan baru, tetapi tagihan lama tetap tersimpan.',
            function() {
                var form = $('#form');
                var data = form.serialize();
                var button = $('#btn_proses');

                $.ajax({
                    url: '<?= base_url('status_siswa/proses'); ?>',
                    type: 'POST',
                    data: data,
                    dataType: 'JSON',
                    beforeSend: function() {
                        button.prop('disabled', true);
                        button.html(
                            '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan'
                        );
                    },
                    success: function(response) {
                        if (response.result === 'true') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || 'Perubahan status siswa berhasil disimpan.'
                            }).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Perubahan status siswa gagal disimpan.'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        ajaxError(xhr, status, error);
                    },
                    complete: function() {
                        button.prop('disabled', false);
                        button.html('Simpan Perubahan Status');
                    }
                });
            }
        );
    }
</script>