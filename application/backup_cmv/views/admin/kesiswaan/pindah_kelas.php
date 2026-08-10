<div class="row g-3">
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header border-bottom border-dashed">
                <h4 class="header-title mb-0">Cari Siswa</h4>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12">
                        <label for="cari_siswa" class="form-label">Nama/NIS/NISN</label>
                        <input type="text" id="cari_siswa" class="form-control" placeholder="Masukkan nama, NIS, atau NISN">
                    </div>
                    <div class="col-12 d-grid">
                        <button type="button" class="btn btn-primary" id="btn_cari_siswa">
                            <i class="ri-search-line me-1"></i>Cari Siswa
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
                <h4 class="header-title mb-0">Form Pindah Kelas</h4>
            </div>
            <div class="card-body">
                <form id="form">
                    <input type="hidden" name="id_siswa">
                    <input type="hidden" name="id_kelas_asal">

                    <div class="alert alert-info" id="identitas">Pilih siswa terlebih dahulu.</div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kelas Tujuan</label>
                            <select name="id_kelas_tujuan" id="kelas_tujuan" class="form-select">
                                <option value="">Pilih kelas tujuan</option>
                                <?php foreach ($kelas as $r): ?>
                                    <option
                                        value="<?= $r['id'] ?>"
                                        data-periode="<?= $r['id_periode'] ?>"
                                        data-semester="<?= html_escape($r['semester']) ?>">
                                        <?= html_escape($r['periode'] . ' - ' . $r['semester'] . ' - ' . $r['nama_kelas']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Pindah</label>
                            <input name="tanggal_pindah" class="form-control tanggal" value="<?= date('d-m-Y') ?>">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alasan</label>
                            <textarea name="alasan" class="form-control" required></textarea>
                        </div>

                        <div class="col-12">
                            <button type="button" id="btn_proses" class="btn btn-primary">Proses Pindah Kelas</button>
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

        $('#btn_cari_siswa').on('click', function() {
            cari();
        });

        $('#cari_siswa').on('keyup', function(e) {
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
        var keyword = $.trim($('#cari_siswa').val());
        var button = $('#btn_cari_siswa');

        button.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1"></span>Mencari'
        );

        $.ajax({
            url: '<?= base_url('admin/kesiswaan/pindah_kelas/cari') ?>',
            type: 'POST',
            data: {
                q: keyword
            },
            dataType: 'JSON',
            success: function(rows) {
                var html = '';

                if (!Array.isArray(rows) || rows.length === 0) {
                    html = '<div class="empty-state">Siswa tidak ditemukan.</div>';
                } else {
                    rows.forEach(function(row) {
                        var detail = btoa(unescape(encodeURIComponent(JSON.stringify(row))));

                        html += '<button type="button" ' +
                            'class="list-group-item list-group-item-action border rounded mb-2 item-siswa" ' +
                            'onclick="pilih(\'' + detail + '\')">' +
                                '<strong>' + escapeHtml(row.nama_lengkap || '-') + '</strong><br>' +
                                '<small>' +
                                    escapeHtml(row.nis || '-') + ' | ' +
                                    escapeHtml(row.nama_kelas || '-') + ' - ' +
                                    escapeHtml(row.periode || '-') + ' ' +
                                    escapeHtml(row.semester || '-') +
                                '</small>' +
                            '</button>';
                    });
                }

                $('#hasil').html(html);

                var jumlahAwal = parseInt($('#dt-length-0').val(), 10) || 10;
                paging($('#hasil .item-siswa'), jumlahAwal);
            },
            error: function(xhr, status, error) {
                if (typeof ajaxError === 'function') {
                    ajaxError(xhr, status, error);
                } else {
                    Swal.fire('Gagal', 'Data siswa tidak dapat dimuat.', 'error');
                }
            },
            complete: function() {
                button.prop('disabled', false).html(
                    '<i class="ri-search-line me-1"></i>Cari Siswa'
                );
            }
        });
    }

    function paging($selector, jumlah_tampil = 10) {
        $('#pagination').empty();

        if ($selector.length === 0) {
            return;
        }

        if (typeof Pagination !== 'function') {
            console.error('Library Pagination belum dimuat pada template.');
            $selector.show();
            return;
        }

        window.tp = new Pagination('#pagination', {
            itemsCount: $selector.length,
            pageSize: parseInt(jumlah_tampil, 10) || 10,
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

    function pilih(detail) {
        var row = JSON.parse(decodeURIComponent(escape(atob(detail))));

        $('#form [name="id_siswa"]').val(row.id);
        $('#form [name="id_kelas_asal"]').val(row.id_kelas_setting);

        $('#identitas').html(
            '<strong>' + escapeHtml(row.nama_lengkap || '-') + '</strong><br>' +
            'NIS ' + escapeHtml(row.nis || '-') +
            ' | Kelas saat ini: ' + escapeHtml(row.nama_kelas || '-') +
            ' - ' + escapeHtml(row.periode || '-') + ' ' + escapeHtml(row.semester || '-')
        );

        $('#kelas_tujuan option').each(function() {
            var periode = $(this).data('periode');
            var semester = $(this).data('semester');

            if (
                !periode ||
                (
                    String(periode) === String(row.id_periode) &&
                    String(semester) === String(row.semester) &&
                    String(this.value) !== String(row.id_kelas_setting)
                )
            ) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

        $('#kelas_tujuan').val('');
    }

    function proses() {
        if (!$('#form [name="id_siswa"]').val()) {
            Swal.fire('Perhatian', 'Pilih siswa terlebih dahulu.', 'warning');
            return;
        }

        confirmAction('Proses pindah kelas?', 'Tagihan lama tidak akan diubah.', function() {
            var button = $('#btn_proses');
            var form = $('#form');
            var data = form.serialize();

            button.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-1"></span>Memproses'
            );

            $.ajax({
                url: '<?= base_url('admin/kesiswaan/pindah_kelas/proses') ?>',
                type: 'POST',
                data: data,
                dataType: 'JSON',
                success: function(response) {
                    Swal.fire({
                        icon: response.result === 'true' ? 'success' : 'error',
                        title: response.result === 'true' ? 'Berhasil' : 'Gagal',
                        text: response.message || (
                            response.result === 'true'
                                ? 'Pindah kelas berhasil diproses.'
                                : 'Pindah kelas gagal diproses.'
                        )
                    }).then(function() {
                        if (response.result === 'true') {
                            location.reload();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    if (typeof ajaxError === 'function') {
                        ajaxError(xhr, status, error);
                    } else {
                        Swal.fire('Gagal', 'Proses pindah kelas gagal dijalankan.', 'error');
                    }
                },
                complete: function() {
                    button.prop('disabled', false).html('Proses Pindah Kelas');
                }
            });
        });
    }
</script>