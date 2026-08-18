<div class="row g-3">
    <div class="col-xl-5">
        <div class="card">
            <div class="card-header app-card-header">
                <h4 class="header-title mb-0">Cari Siswa</h4>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12">
                        <label class="form-label" for="q">Nama/NIS/NISN</label>
                        <input id="q" class="form-control" placeholder="Masukkan nama, NIS, atau NISN">
                    </div>
                    <div class="col-12 d-grid">
                        <button type="button" class="btn btn-primary" id="btn_cari_siswa">
                            <i class="ri-search-line me-1"></i>Cari Siswa
                        </button>
                    </div>
                </div>
                <div id="hasil_siswa" class="mt-3"></div>

                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-2">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-cari-siswa"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-cari-siswa" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-cari-siswa">
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

        <div class="card">
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title mb-1">Riwayat Keringanan</h4>
                    <small class="text-muted">Menampilkan riwayat potongan dan pembebasan siswa terpilih.</small>
                </div>
            </div>
            <div class="card-body">
                <div id="riwayat">
                    <div class="empty-state">Pilih siswa terlebih dahulu.</div>
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination-riwayat-keringanan"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-riwayat-keringanan" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-riwayat-keringanan">
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
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title mb-1">Potongan atau Pembebasan</h4>
                    <small class="text-muted">Nominal akhir tidak boleh lebih kecil daripada nominal yang sudah dibayar.</small>
                </div>
            </div>
            <div class="card-body">
                <form id="form">
                    <input type="hidden" id="id_siswa">
                    <div class="alert alert-info" id="identitas">Pilih siswa terlebih dahulu.</div>

                    <div class="mb-3">
                        <label class="form-label" for="tagihan">Pilih Tagihan</label>
                        <select name="id_tagihan_siswa" id="tagihan" class="form-select">
                            <option value="">Pilih tagihan</option>
                        </select>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nominal Awal</label>
                            <input id="nominal_awal" class="form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sudah Dibayar</label>
                            <input id="sudah_dibayar" class="form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="jenis">Jenis Keringanan</label>
                            <select name="jenis_keringanan" id="jenis" class="form-select">
                                <option>Potongan Nominal</option>
                                <option>Potongan Persen</option>
                                <option>Pembebasan Penuh</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="nilai">Nilai Keringanan</label>
                            <input name="nilai_keringanan" id="nilai" type="text" inputmode="numeric" autocomplete="off" class="form-control money-input">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nominal Akhir</label>
                            <input id="nominal_akhir" class="form-control" disabled>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sisa Setelah Aturan</label>
                            <input id="sisa" class="form-control" disabled>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alasan</label>
                            <textarea name="alasan" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="col-12">
                            <button type="button" id="btn_simpan" class="btn btn-primary">Simpan Keringanan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
var tagihanMap = {};

$(document).ready(function () {
    $('#btn_cari_siswa').on('click', function () {
        cariSiswa();
    });

    $('#q').on('keyup', function (event) {
        if (event.key === 'Enter') {
            cariSiswa();
        }
    });

    $('#dt-length-cari-siswa').on('change', function () {
        refreshCariSiswaPagination();
    });

    $('#tagihan, #jenis, #nilai').on('change input', previewHitung);
    $('#nilai').on('input', batasiPersen);
    $('#jenis').on('change', aturInputKeringanan);
    $('#btn_simpan').on('click', saveData);
    $('#dt-length-riwayat-keringanan').on('change', refreshRiwayatKeringananPagination);

    aturInputKeringanan();
    refreshCariSiswaPagination();
    refreshRiwayatKeringananPagination();
});

function cariSiswa() {
    var search = $.trim($('#q').val());
    var button = $('#btn_cari_siswa');

    $.ajax({
        url: '<?= base_url('admin/tagihan/keringanan/cari_siswa'); ?>',
        type: 'POST',
        data: {
            q: search
        },
        dataType: 'JSON',
        beforeSend: function () {
            button.prop('disabled', true);
            button.html('<span class="spinner-border spinner-border-sm me-1"></span>Mencari');

            $('#hasil_siswa').html(
                '<div class="text-center py-3">' +
                    '<span class="spinner-border spinner-border-sm me-1"></span>Memuat data siswa...' +
                '</div>'
            );

            $('#pagination-cari-siswa').empty();
        },
        success: function (rows) {
            var html = '';

            if (!Array.isArray(rows) || rows.length === 0) {
                $('#hasil_siswa').html('<div class="empty-state">Siswa tidak ditemukan.</div>');
                $('#pagination-cari-siswa').empty();
                return;
            }

            rows.forEach(function (row) {
                html +=
                    '<button type="button" ' +
                        'class="list-group-item list-group-item-action border rounded mb-2 item-cari-siswa" ' +
                        'data-student="' + encodeURIComponent(JSON.stringify(row)) + '">' +
                        '<strong>' + escapeHtml(row.nama_siswa || '-') + '</strong><br>' +
                        '<small>' +
                            escapeHtml(row.nis || '-') + ' | ' +
                            escapeHtml(row.nama_kelas || 'Belum ditempatkan') +
                        '</small>' +
                    '</button>';
            });

            $('#hasil_siswa').html(html);
            refreshCariSiswaPagination();
        },
        error: function (xhr, status, error) {
            $('#hasil_siswa').html(
                '<div class="empty-state text-danger">Data siswa gagal dimuat.</div>'
            );
            $('#pagination-cari-siswa').empty();
            ajaxError(xhr, status, error);
        },
        complete: function () {
            button.prop('disabled', false);
            button.html('<i class="ri-search-line me-1"></i>Cari Siswa');
        }
    });
}

function refreshCariSiswaPagination() {
    paging(
        $('#hasil_siswa .item-cari-siswa'),
        parseInt($('#dt-length-cari-siswa').val(), 10) || 10,
        '#pagination-cari-siswa'
    );
}

$(document).on('click', '[data-student]', function () {
    pilihSiswa(JSON.parse(decodeURIComponent($(this).attr('data-student'))));
});

function pilihSiswa(row) {
    $('#id_siswa').val(row.id_siswa);
    $('#identitas').html(
        '<strong>' + escapeHtml(row.nama_siswa) + '</strong><br>' +
        escapeHtml(row.nis || '-') + ' / ' + escapeHtml(row.nisn || '-') +
        ' | ' + escapeHtml(row.nama_kelas || '-')
    );
    loadTagihan();
    loadRiwayat();
}

function loadTagihan() {
    $.ajax({
        url: '<?= base_url('admin/tagihan/keringanan/tagihan_siswa') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            id_siswa: $('#id_siswa').val()
        },
        success: function (rows) {
            tagihanMap = {};
            var html = '<option value="">Pilih tagihan</option>';

            rows.forEach(function (row) {
                tagihanMap[row.id] = row;
                html += '<option value="' + row.id + '">' +
                    escapeHtml(row.nama_tagihan) + ' - ' +
                    escapeHtml(row.nama_bulan || '') + ' ' + escapeHtml(row.tahun || '') +
                    ' | Sisa ' + formatRupiah(row.sisa_tagihan) +
                '</option>';
            });

            $('#tagihan').html(html);
            $('#nominal_awal, #sudah_dibayar, #nominal_akhir, #sisa').val('');
        },
        error: ajaxError
    });
}

function aturInputKeringanan() {
    var jenis = $('#jenis').val();
    var input = $('#nilai');
    var sebelumnya = input.data('jenis');

    if (sebelumnya && sebelumnya !== jenis) input.val('');
    input.data('jenis', jenis);

    if (jenis === 'Pembebasan Penuh') {
        input
            .prop('disabled', true)
            .removeClass('money-input')
            .removeAttr('max')
            .val('0');
    } else if (jenis === 'Potongan Persen') {
        input
            .prop('disabled', false)
            .removeClass('money-input')
            .attr('inputmode', 'decimal')
            .attr('max', '100')
            .attr('placeholder', '0 - 100');

        batasiPersen();
    } else {
        input
            .prop('disabled', false)
            .addClass('money-input')
            .removeAttr('max')
            .attr('inputmode', 'numeric')
            .attr('placeholder', 'Nominal potongan');

        if (input.val() !== '') input.val(formatMoneyInput(input.val()));
    }

    previewHitung();
}

function batasiPersen() {
    if ($('#jenis').val() !== 'Potongan Persen') {
        return;
    }

    var input = $('#nilai');
    var value = String(input.val() || '');

    // Hanya izinkan angka dan satu separator desimal.
    value = value.replace(',', '.').replace(/[^0-9.]/g, '');

    var parts = value.split('.');
    if (parts.length > 2) {
        value = parts.shift() + '.' + parts.join('');
    }

    if (value === '') {
        input.val('');
        return;
    }

    var persen = parseFloat(value);

    if (isNaN(persen)) {
        input.val('');
        return;
    }

    if (persen > 100) {
        persen = 100;
    }

    if (persen < 0) {
        persen = 0;
    }

    input.val(persen);
}

function previewHitung() {
    var row = tagihanMap[$('#tagihan').val()];
    if (!row) return;

    var awal = Number(row.nominal_awal);
    var dibayar = Number(row.nominal_dibayar);
    var jenis = $('#jenis').val();
    var nilai = jenis === 'Potongan Nominal'
        ? parseMoneyInput($('#nilai').val())
        : Number($('#nilai').val() || 0);
    var potongan = jenis === 'Potongan Nominal'
        ? nilai
        : (jenis === 'Potongan Persen' ? awal * Math.min(100, nilai) / 100 : awal);
    var akhir = Math.max(0, awal - potongan);
    var sisa = Math.max(0, akhir - dibayar);

    $('#nominal_awal').val(formatRupiah(awal));
    $('#sudah_dibayar').val(formatRupiah(dibayar));
    $('#nominal_akhir').val(formatRupiah(akhir));
    $('#sisa').val(formatRupiah(sisa));
}

function saveData() {
    confirmAction(
        'Simpan keringanan?',
        'Perubahan akan memengaruhi nominal dan sisa tagihan siswa.',
        function () {
            $.ajax({
                url: '<?= base_url('admin/tagihan/keringanan/simpan') ?>',
                type: 'POST',
                dataType: 'json',
                data: serializeMoneyForm('#form'),
                success: function (response) {
                    var berhasil = response.result === 'true';
                    Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                    if (berhasil) {
                        loadTagihan();
                        loadRiwayat();
                        $('#form [name="alasan"]').val('');
                    }
                },
                error: ajaxError
            });
        }
    );
}

function loadRiwayat() {
    $.ajax({
        url: '<?= base_url('admin/tagihan/keringanan/riwayat') ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            id_siswa: $('#id_siswa').val()
        },
        success: function (rows) {
            var html = '';

            if (!rows.length) {
                html = '<div class="empty-state">Belum ada keringanan.</div>';
            } else {
                rows.forEach(function (row) {
                    html +=
                        '<div class="keringanan-history-row border-bottom py-3">' +
                            '<div class="d-flex justify-content-between gap-2">' +
                                '<strong>' + escapeHtml(row.jenis_keringanan) + '</strong>' +
                                '<span class="badge bg-' + (row.status === 'Aktif' ? 'success' : 'secondary') + '">' + escapeHtml(row.status) + '</span>' +
                            '</div>' +
                            '<div>' + formatRupiah(row.nominal_awal) + ' → ' + formatRupiah(row.nominal_setelah_keringanan) + '</div>' +
                            '<small class="text-muted">' + escapeHtml(row.alasan || '-') + ' | ' + escapeHtml(row.tanggal || '-') + '</small>' +
                            (row.status === 'Aktif'
                                ? '<div class="mt-2"><button type="button" class="btn btn-sm btn-outline-danger" onclick="batalkan(' + Number(row.id) + ')">Batalkan</button></div>'
                                : '') +
                        '</div>';
                });
            }

            $('#riwayat').html(html);
            refreshRiwayatKeringananPagination();
        },
        error: ajaxError
    });
}

function refreshRiwayatKeringananPagination() {
    paging(
        $('#riwayat .keringanan-history-row'),
        parseInt($('#dt-length-riwayat-keringanan').val(), 10) || 10,
        '#pagination-riwayat-keringanan'
    );
}

function batalkan(id) {
    Swal.fire({
        title: 'Batalkan keringanan',
        input: 'textarea',
        inputLabel: 'Alasan pembatalan',
        showCancelButton: true,
        preConfirm: function (value) {
            if (!value) Swal.showValidationMessage('Alasan wajib diisi');
            return value;
        }
    }).then(function (result) {
        if (!result.isConfirmed) return;

        $.ajax({
            url: '<?= base_url('admin/tagihan/keringanan/batalkan') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
                id: id,
                alasan: result.value
            },
            success: function (response) {
                var berhasil = response.result === 'true';
                Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                if (berhasil) {
                    loadTagihan();
                    loadRiwayat();
                }
            },
            error: ajaxError
        });
    });
}
</script>