<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Riwayat Pembayaran</h5>
        <a id="btnExport" class="btn btn-success">
            <i class="ti ti-file-spreadsheet"></i> Ekspor Excel
        </a>
    </div>

    <div class="card-body">
        <div class="row g-2 mb-3">
            <div class="col-lg-3">
                <input id="q" class="form-control" placeholder="No transaksi / nama / NIS">
            </div>

            <div class="col-lg-2">
                <input id="awal" class="form-control tanggal-picker"
                    placeholder="Tanggal awal" autocomplete="off">
            </div>

            <div class="col-lg-2">
                <input id="akhir" class="form-control tanggal-picker"
                    placeholder="Tanggal akhir" autocomplete="off">
            </div>

            <div class="col-lg-2">
                <select id="metode" class="form-select">
                    <option value="">Semua metode</option>
                    <?php foreach ($metode as $m): ?>
                        <option value="<?= $m['id'] ?>">
                            <?= html_escape($m['nama_metode']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-lg-2">
                <select id="filter_status_transaksi" class="form-select">
                    <option value="">Semua status</option>
                    <option>Aktif</option>
                    <option>Dibatalkan</option>
                </select>
            </div>

            <div class="col-lg-1 d-grid">
                <button type="button" id="cari" class="btn btn-primary">
                    <i class="ti ti-search"></i>
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No Transaksi</th>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Metode</th>
                        <th class="text-end">Total</th>
                        <th>Petugas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="data"></tbody>
            </table>
        </div>

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

<div class="modal fade" id="modalDetail">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="detailBody"></div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalWhatsappRiwayat" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Ulang Bukti melalui WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tujuan</label>
                    <div class="d-flex flex-wrap gap-3">
                        <div class="form-check">
                            <input class="form-check-input wa-riwayat-target" type="radio" name="wa_riwayat_target" id="wa_riwayat_ayah" value="Ayah">
                            <label class="form-check-label" id="wa_riwayat_label_ayah" for="wa_riwayat_ayah">Ayah</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input wa-riwayat-target" type="radio" name="wa_riwayat_target" id="wa_riwayat_ibu" value="Ibu">
                            <label class="form-check-label" id="wa_riwayat_label_ibu" for="wa_riwayat_ibu">Ibu</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input wa-riwayat-target" type="radio" name="wa_riwayat_target" id="wa_riwayat_lain" value="Lainnya">
                            <label class="form-check-label" for="wa_riwayat_lain">Nomor Lain</label>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" class="form-control" id="wa_riwayat_nama">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="text" class="form-control" id="wa_riwayat_nomor">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Pesan</label>
                        <textarea class="form-control" id="wa_riwayat_pesan" rows="6"></textarea>
                        <small class="text-muted" id="wa_riwayat_template_info"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-success" id="btn_kirim_wa_riwayat">
                    <i class="ri-whatsapp-line me-1"></i>Buka WhatsApp
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let rows = [];
    let waRiwayatPaymentId = 0;
    let waRiwayatStudent = null;
    let modalWhatsappRiwayat = null;

    $(document).ready(function () {
        flatpickr('.tanggal-picker', {
            dateFormat: 'd-m-Y',
            allowInput: true,
            disableMobile: true
        });

        modalWhatsappRiwayat = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalWhatsappRiwayat'));
        load();

        $('#cari').on('click', function () {
            load();
        });

        $('#q').on('keypress', function (e) {
            if (e.which === 13) {
                load();
            }
        });

        $('#dt-length-0').on('change', function () {
            const jumlah = parseInt($(this).val());

            paging(
                $('#data .data-riwayat-pembayaran'),
                jumlah
            );
        });

        $('#btnExport').on('click', function () {
            let p = new URLSearchParams(params());

            this.href =
                '<?= base_url('admin/transaksi/riwayat_pembayaran/export'); ?>?' +
                p.toString();
        });

        $(document).on('click', '.detail', function () {
            detail($(this).data('id'));
        });

        $(document).on('click', '.batal', function () {
            batalkan($(this).data('id'));
        });

        $(document).on('click', '.cetak-ulang', function () {
            cetakUlang($(this).data('id'));
        });

        $(document).on('click', '.kirim-wa-ulang', function () {
            openWhatsappRiwayat($(this).data('id'));
        });

        $(document).on('change', '.wa-riwayat-target', applyWhatsappRiwayatRecipient);
        $('#btn_kirim_wa_riwayat').on('click', kirimWhatsappRiwayat);
    });

    function params() {
        return {
            q: $('#q').val(),
            awal: $('#awal').val(),
            akhir: $('#akhir').val(),
            metode: $('#metode').val(),
            status: $('#filter_status_transaksi').val()
        };
    }

    function load() {
        var button = $('#cari');

        $.ajax({
            url: '<?= base_url('admin/transaksi/riwayat_pembayaran/result'); ?>',
            type: 'POST',
            data: params(),
            dataType: 'JSON',

            beforeSend: function () {
                button.prop('disabled', true);
                button.html(
                    '<span class="spinner-border spinner-border-sm"></span>'
                );

                $('#data').html(`
                    <tr>
                        <td colspan="9" class="empty-state">
                            Memuat data...
                        </td>
                    </tr>
                `);

                $('#pagination').empty();
            },

            success: function (data) {
                rows = Array.isArray(data) ? data : [];

                var table = '';

                if (rows.length == 0) {
                    table += `
                        <tr class="data-riwayat-pembayaran">
                            <td colspan="9" class="empty-state">
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                } else {
                    rows.forEach(function (item) {
                        var statusClass =
                            item.status_transaksi === 'Aktif'
                                ? 'success'
                                : 'danger';

                        table += `
                            <tr class="data-riwayat-pembayaran">
                                <td>
                                    <strong>
                                        ${escapeHtml(item.no_transaksi || '-')}
                                    </strong>
                                    <br>
                                    <small>
                                        ${escapeHtml(item.waktu_transaksi || '-')}
                                    </small>
                                </td>

                                <td>
                                    ${escapeHtml(item.tanggal_transaksi || '-')}
                                </td>

                                <td>
                                    ${escapeHtml(item.nama_siswa || '-')}
                                    <br>
                                    <small>
                                        ${escapeHtml(item.nis || '-')}
                                    </small>
                                </td>

                                <td>
                                    ${escapeHtml(item.nama_kelas || '-')}
                                </td>

                                <td>
                                    ${escapeHtml(item.nama_metode_pembayaran || '-')}
                                </td>

                                <td class="text-end fw-semibold">
                                    ${formatRupiah(item.total_pembayaran)}
                                </td>

                                <td>
                                    ${escapeHtml(item.nama_user || '-')}
                                </td>

                                <td>
                                    <span
                                        class="badge bg-${statusClass}-subtle text-${statusClass}">
                                        ${escapeHtml(item.status_transaksi || '-')}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary detail"
                                            data-id="${Number(item.id)}">
                                            Detail
                                        </button>

                                        ${
                                            item.status_transaksi === 'Aktif'
                                                ? `
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-secondary cetak-ulang"
                                                        data-id="${Number(item.id)}">
                                                        Cetak Ulang
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-success kirim-wa-ulang"
                                                        data-id="${Number(item.id)}">
                                                        Kirim Ulang WA
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-danger batal"
                                                        data-id="${Number(item.id)}">
                                                        Batalkan
                                                    </button>
                                                `
                                                : `
                                                    <a
                                                        target="_blank"
                                                        href="<?= base_url('admin/transaksi/pembayaran/bukti/'); ?>${Number(item.id)}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        Lihat Bukti
                                                    </a>
                                                `
                                        }
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                }

                $('#data').html(table);

                let jumlah_awal = parseInt($('#dt-length-0').val());

                paging(
                    $('#data .data-riwayat-pembayaran'),
                    jumlah_awal
                );
            },

            error: function (xhr, status, error) {
                $('#data').html(`
                    <tr>
                        <td colspan="9" class="empty-state text-danger">
                            Data riwayat pembayaran gagal dimuat.
                        </td>
                    </tr>
                `);

                $('#pagination').empty();

                ajaxError(xhr, status, error);
            },

            complete: function () {
                button.prop('disabled', false);
                button.html('<i class="ti ti-search"></i>');
            }
        });
    }

    /*
     * Pagination mengikuti pola view Beasiswa:
     * tetap menggunakan Pagination JS yang sudah dipakai aplikasi.
     */
    function paging($selector, jumlah_tampil = 10) {

        window.tp = new Pagination('#pagination', {
            itemsCount: $selector.length,
            pageSize: parseInt(jumlah_tampil),

            onPageChange: function (paging) {
                let start =
                    paging.pageSize *
                    (paging.currentPage - 1);

                let end =
                    start +
                    paging.pageSize;

                let $rows = $selector;

                $rows.hide();

                for (let i = start; i < end; i++) {
                    $rows.eq(i).show();
                }
            }
        });
    }

    function detail(id) {
        $.ajax({
            url: '<?= base_url('admin/transaksi/riwayat_pembayaran/detail'); ?>',
            type: 'POST',

            data: {
                id: id
            },

            dataType: 'JSON',

            beforeSend: function () {
                $('#detailBody').html(`
                    <div class="text-center py-4">
                        <span class="spinner-border spinner-border-sm me-1"></span>
                        Memuat detail transaksi...
                    </div>
                `);
            },

            success: function (data) {
                if (data.result !== 'true') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text:
                            data.message ||
                            'Detail transaksi gagal dimuat.'
                    });

                    return;
                }

                var header = data.header;
                var detailRows =
                    Array.isArray(data.detail)
                        ? data.detail
                        : [];

                var html = `
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>
                                ${escapeHtml(header.no_transaksi || '-')}
                            </strong>
                            <br>

                            ${escapeHtml(
                                (header.tanggal_transaksi || '-') +
                                ' ' +
                                (header.waktu_transaksi || '')
                            )}

                            <br>

                            ${escapeHtml(header.nama_siswa || '-')}
                            (${escapeHtml(header.nis || '-')})
                        </div>

                        <div class="col-md-6 text-md-end">
                            ${escapeHtml(header.nama_kelas || '-')}
                            <br>

                            ${escapeHtml(
                                header.nama_metode_pembayaran || '-'
                            )}

                            <br>

                            <strong>
                                ${formatRupiah(header.total_pembayaran)}
                            </strong>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tagihan</th>
                                    <th>Periode</th>
                                    <th class="text-end">Sisa Sebelum</th>
                                    <th class="text-end">Bayar</th>
                                    <th class="text-end">Sisa Setelah</th>
                                </tr>
                            </thead>

                            <tbody>
                `;

                if (detailRows.length == 0) {
                    html += `
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data
                            </td>
                        </tr>
                    `;
                } else {
                    detailRows.forEach(function (item) {
                        html += `
                            <tr>
                                <td>
                                    ${escapeHtml(item.nama_tagihan || '-')}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        (item.nama_bulan || '') +
                                        ' ' +
                                        (item.tahun || '')
                                    )}
                                </td>

                                <td class="text-end">
                                    ${formatRupiah(item.sisa_sebelum)}
                                </td>

                                <td class="text-end">
                                    ${formatRupiah(item.nominal_bayar)}
                                </td>

                                <td class="text-end">
                                    ${formatRupiah(item.sisa_setelah)}
                                </td>
                            </tr>
                        `;
                    });
                }

                html += `
                            </tbody>
                        </table>
                    </div>
                `;

                if (data.pembatalan) {
                    html += `
                        <div class="alert alert-danger">
                            <strong>
                                Dibatalkan oleh
                                ${escapeHtml(
                                    data.pembatalan.nama_user_pembatalan || '-'
                                )}
                            </strong>

                            <br>

                            ${escapeHtml(
                                (data.pembatalan.tanggal_pembatalan || '-') +
                                ' ' +
                                (data.pembatalan.waktu_pembatalan || '')
                            )}

                            <br>

                            Alasan:
                            ${escapeHtml(
                                data.pembatalan.alasan_pembatalan || '-'
                            )}
                        </div>
                    `;
                }

                $('#detailBody').html(html);

                bootstrap.Modal
                    .getOrCreateInstance(
                        document.getElementById('modalDetail')
                    )
                    .show();
            },

            error: function (xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }


    function cetakUlang(id) {
        $.ajax({
            url: '<?= base_url('admin/transaksi/riwayat_pembayaran/catat_cetak/'); ?>' + Number(id),
            type: 'POST',
            data: {},
            dataType: 'JSON',
            success: function(data) {
                if (data.result !== 'true') {
                    Swal.fire('Gagal', data.message || 'Cetak ulang tidak dapat diproses.', 'error');
                    return;
                }

                window.open(
                    '<?= base_url('admin/transaksi/pembayaran/bukti/'); ?>' + Number(id),
                    '_blank'
                );
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }

    function openWhatsappRiwayat(id) {
        waRiwayatPaymentId = Number(id);
        waRiwayatStudent = null;

        $.ajax({
            url: '<?= base_url('admin/transaksi/riwayat_pembayaran/detail'); ?>',
            type: 'POST',
            data: {
                id: waRiwayatPaymentId
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.result !== 'true') {
                    Swal.fire('Gagal', data.message || 'Transaksi tidak ditemukan.', 'error');
                    return;
                }
                if (!data.header || data.header.status_transaksi !== 'Aktif') {
                    Swal.fire('Perhatian', 'Hanya transaksi aktif yang dapat dikirim ulang.', 'warning');
                    return;
                }

                waRiwayatStudent = data.siswa || {};
                $('#wa_riwayat_label_ayah').text('Ayah - ' + (waRiwayatStudent.telepon_ayah || 'Tidak tersedia'));
                $('#wa_riwayat_label_ibu').text('Ibu - ' + (waRiwayatStudent.telepon_ibu || 'Tidak tersedia'));
                $('#wa_riwayat_pesan').val('');
                $('#wa_riwayat_template_info').text('Memuat template...');

                if (waRiwayatStudent.telepon_ayah) {
                    $('#wa_riwayat_ayah').prop('checked', true);
                } else if (waRiwayatStudent.telepon_ibu) {
                    $('#wa_riwayat_ibu').prop('checked', true);
                } else {
                    $('#wa_riwayat_lain').prop('checked', true);
                }

                applyWhatsappRiwayatRecipient();
                modalWhatsappRiwayat.show();
                loadWhatsappRiwayatTemplate();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error);
            }
        });
    }

    function applyWhatsappRiwayatRecipient() {
        if (!waRiwayatStudent) return;

        var target = $('input[name="wa_riwayat_target"]:checked').val();

        if (target === 'Ayah') {
            $('#wa_riwayat_nama').val(waRiwayatStudent.nama_ayah || '');
            $('#wa_riwayat_nomor').val(waRiwayatStudent.telepon_ayah || '');
        } else if (target === 'Ibu') {
            $('#wa_riwayat_nama').val(waRiwayatStudent.nama_ibu || '');
            $('#wa_riwayat_nomor').val(waRiwayatStudent.telepon_ibu || '');
        } else {
            $('#wa_riwayat_nama').val('');
            $('#wa_riwayat_nomor').val('');
        }

        loadWhatsappRiwayatTemplate();
    }

    function loadWhatsappRiwayatTemplate() {
        if (!waRiwayatPaymentId) return;

        $.ajax({
            url: '<?= base_url('admin/transaksi/pembayaran/preview_whatsapp'); ?>',
            type: 'POST',
            data: {
                id: waRiwayatPaymentId,
                nama_penerima: $('#wa_riwayat_nama').val()
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.result === 'true') {
                    $('#wa_riwayat_pesan').val(data.pesan || '');
                    $('#wa_riwayat_template_info').text('Template: ' + (data.nama_template || 'Default'));
                } else {
                    $('#wa_riwayat_template_info').text(data.message || 'Template tidak dapat dimuat.');
                }
            },
            error: function(xhr, status, error) {
                $('#wa_riwayat_template_info').text('Template tidak dapat dimuat.');
                ajaxError(xhr, status, error);
            }
        });
    }

    function kirimWhatsappRiwayat() {
        var nomor = $.trim($('#wa_riwayat_nomor').val());
        if (!nomor) {
            Swal.fire('Perhatian', 'Nomor WhatsApp wajib diisi.', 'warning');
            return;
        }

        var button = $('#btn_kirim_wa_riwayat');
        button.prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/transaksi/pembayaran/siapkan_whatsapp'); ?>',
            type: 'POST',
            data: {
                id: waRiwayatPaymentId,
                hubungan: $('input[name="wa_riwayat_target"]:checked').val(),
                nama_penerima: $('#wa_riwayat_nama').val(),
                nomor: nomor,
                pesan: $('#wa_riwayat_pesan').val()
            },
            dataType: 'JSON',
            success: function(data) {
                if (data.result === 'true') {
                    modalWhatsappRiwayat.hide();
                    window.open(data.url, '_blank');
                    load();
                } else {
                    Swal.fire('Gagal', data.message || 'WhatsApp gagal disiapkan.', 'error');
                }
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error);
            },
            complete: function() {
                button.prop('disabled', false);
            }
        });
    }

    function batalkan(id) {
        Swal.fire({
            title: 'Batalkan transaksi?',
            text:
                'Saldo setiap tagihan akan dikembalikan. ' +
                'Data transaksi tidak dihapus.',
            input: 'textarea',
            inputLabel: 'Alasan wajib',
            showCancelButton: true,
            confirmButtonText: 'Konfirmasi Batalkan',
            confirmButtonColor: '#dc3545',

            preConfirm: function (value) {
                if (!$.trim(value)) {
                    Swal.showValidationMessage(
                        'Alasan wajib diisi'
                    );
                }

                return value;
            }
        }).then(function (result) {
            if (!result.isConfirmed) {
                return;
            }

            $.ajax({
                url: '<?= base_url('admin/transaksi/riwayat_pembayaran/batalkan'); ?>',
                type: 'POST',

                data: {
                    id: id,
                    alasan: result.value
                },

                dataType: 'JSON',

                success: function (data) {
                    if (data.result === 'true') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text:
                                data.message ||
                                'Transaksi berhasil dibatalkan.'
                        });

                        load();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text:
                                data.message ||
                                'Transaksi gagal dibatalkan.'
                        });
                    }
                },

                error: function (xhr, status, error) {
                    ajaxError(xhr, status, error);
                }
            });
        });
    }
</script>