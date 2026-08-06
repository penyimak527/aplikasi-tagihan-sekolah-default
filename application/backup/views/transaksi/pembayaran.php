<div class="row g-3">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title">1. Pencarian dan Pemilihan Siswa</h4>
                    <p class="text-muted mb-0">Satu transaksi hanya untuk satu siswa. Siswa nonaktif tetap dapat membayar tagihan lama.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-2 align-items-end">
                    <div class="col-md-10">
                        <input id="cari_siswa" class="form-control" placeholder="Nama / NIS / NISN / Scan Kode">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button id="btn_cari_siswa" type="button" class="btn btn-primary">
                            <i class="ri-search-line me-1"></i>Cari
                        </button>
                    </div>
                </div>
                <div id="hasil_siswa" class="crud-list mt-3"></div>
                <div id="siswa_dipilih" class="d-none mt-3"></div>
            </div>
        </div>

        <div class="card" id="card_tagihan">
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title">2. Tagihan Siswa</h4>
                    <p class="text-muted mb-0">Tagihan tahun berjalan dan tunggakan tahun sebelumnya ditampilkan terpisah.</p>
                </div>
                <span class="badge bg-primary-subtle text-primary" id="jumlah_tagihan">0 tagihan</span>
            </div>
            <div class="card-body">
                <div class="row g-2 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label" for="filter_tahun">Tahun Ajaran</label>
                        <select id="filter_tahun" class="form-select"><option value="">Semua Tahun</option></select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="filter_tipe">Tipe</label>
                        <select id="filter_tipe" class="form-select">
                            <option value="">Semua Tipe</option>
                            <option value="Bulanan">Bulanan</option>
                            <option value="Langsung">Langsung</option>
                            <option value="Tahunan">Tahunan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label" for="filter_status">Status</label>
                        <select id="filter_status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Belum Dibayar">Belum Dibayar</option>
                            <option value="Dibayar Sebagian">Dibayar Sebagian</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="filter_tagihan">Nama Tagihan</label>
                        <input id="filter_tagihan" class="form-control" placeholder="Cari tagihan">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button id="btn_filter_tagihan" type="button" class="btn btn-primary">
                            <i class="ri-search-line me-1"></i>Cari
                        </button>
                    </div>
                </div>

                <div id="daftar_tagihan">
                    <div class="empty-state"><i class="ri-user-search-line empty-icon"></i>Pilih siswa terlebih dahulu.</div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button id="btn_tambah_keranjang" type="button" class="btn btn-primary" disabled>
                        <i class="ri-shopping-cart-2-line me-1"></i>Tambah Terpilih ke Keranjang
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card sticky-summary" id="keranjang-pembayaran">
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title">3. Keranjang Pembayaran</h4>
                    <p class="text-muted mb-0">Nominal tiap tagihan dapat diubah untuk pembayaran cicilan.</p>
                </div>
            </div>
            <div class="card-body">
                <div id="keranjang"><div class="empty-state py-3">Keranjang masih kosong.</div></div>
                <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                    <strong>Total Pembayaran</strong>
                    <strong class="text-primary fs-18" id="total_keranjang">Rp0</strong>
                </div>
                <button type="button" id="btn_kosongkan" class="btn btn-sm btn-outline-danger mt-2 w-100" disabled>
                    <i class="ri-delete-bin-line me-1"></i>Kosongkan Keranjang
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-header app-card-header">
                <div>
                    <h4 class="header-title">4. Penyelesaian Pembayaran</h4>
                    <p class="text-muted mb-0" id="ringkasan_keranjang">0 tagihan | Total Rp0</p>
                </div>
            </div>
            <div class="card-body">
                <form id="form_pembayaran">
                    <input type="hidden" id="id_siswa">
                    <input type="hidden" id="token_pembayaran" value="<?= html_escape($token_pembayaran) ?>">

                    <div class="mb-3">
                        <label class="form-label" for="tanggal_pembayaran">Tanggal Pembayaran</label>
                        <input type="text" id="tanggal_pembayaran" class="form-control" value="<?= date('d-m-Y') ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="id_metode">Metode Pembayaran</label>
                        <select id="id_metode" class="form-select" required>
                            <option value="">Pilih metode</option>
                            <?php foreach ($metode as $row): ?>
                                <option value="<?= (int) $row['id'] ?>" data-cash="<?= html_escape($row['butuh_uang_diterima']) ?>">
                                    <?= html_escape($row['nama_metode']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="blok_tunai" class="d-none">
                        <div class="mb-3">
                            <label class="form-label" for="uang_diterima">Uang Diterima</label>
                            <input type="text" inputmode="numeric" autocomplete="off" id="uang_diterima" class="form-control money-input" value="0">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kembalian">Kembalian</label>
                            <input id="kembalian" class="form-control money-input" value="Rp0" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="referensi">Referensi Pembayaran</label>
                        <input id="referensi" class="form-control" placeholder="Opsional untuk transfer/QRIS">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="catatan">Catatan</label>
                        <textarea id="catatan" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="alert alert-light border py-2">
                        <small class="text-muted d-block">Petugas</small>
                        <strong><?= html_escape(app_user_name()) ?></strong>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" id="btn_simpan" class="btn btn-success" disabled>
                            <i class="ri-save-line me-1"></i>Simpan Pembayaran
                        </button>
                        <button type="button" id="btn_kembali_keranjang" class="btn btn-light">Kembali ke Keranjang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_berhasil" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success"><i class="ri-checkbox-circle-line me-1"></i>Pembayaran Berhasil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="isi_berhasil"></div>
            <div class="modal-footer flex-wrap">
                <button type="button" id="btn_lihat_detail" class="btn btn-outline-primary"><i class="ri-eye-line me-1"></i>Lihat Detail</button>
                <a id="link_bukti" target="_blank" class="btn btn-primary"><i class="ri-printer-line me-1"></i>Cetak / Simpan PDF</a>
                <button type="button" id="btn_whatsapp" class="btn btn-success"><i class="ri-whatsapp-line me-1"></i>Kirim WhatsApp</button>
                <a id="link_kartu" target="_blank" class="btn btn-info"><i class="ri-id-card-line me-1"></i>Cetak ke Kartu</a>
                <button type="button" id="btn_transaksi_baru" class="btn btn-dark">Transaksi Baru</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_detail_transaksi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="isi_detail_transaksi"></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_whatsapp" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kirim Bukti Pembayaran melalui WhatsApp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label d-block">Tujuan</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input tujuan-wa" type="radio" name="tujuan_wa" id="wa_ayah" value="Ayah">
                        <label class="form-check-label" for="wa_ayah" id="label_wa_ayah">Ayah</label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input tujuan-wa" type="radio" name="tujuan_wa" id="wa_ibu" value="Ibu">
                        <label class="form-check-label" for="wa_ibu" id="label_wa_ibu">Ibu</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input tujuan-wa" type="radio" name="tujuan_wa" id="wa_lain" value="Lainnya">
                        <label class="form-check-label" for="wa_lain">Nomor Lain</label>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-5">
                        <label class="form-label" for="wa_nama">Nama Penerima</label>
                        <input id="wa_nama" class="form-control">
                    </div>
                    <div class="col-md-7">
                        <label class="form-label" for="wa_nomor">Nomor WhatsApp</label>
                        <input id="wa_nomor" class="form-control" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="wa_pesan">Pesan</label>
                    <textarea id="wa_pesan" class="form-control" rows="7" placeholder="Kosongkan untuk menggunakan template default"></textarea>
                    <small class="text-muted">Pesan dapat diedit sebelum membuka WhatsApp.</small>
                </div>
                <div class="alert alert-info mb-0">Mode tautan WhatsApp menyiapkan pesan, tetapi tidak dapat memastikan pesan benar-benar terkirim.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btn_kirim_wa" class="btn btn-success"><i class="ri-whatsapp-line me-1"></i>Buka WhatsApp</button>
            </div>
        </div>
    </div>
</div>

<style>
.bill-section + .bill-section { margin-top: 1.5rem; }
.bill-section-title { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: .75rem; }
.bill-item { border: 1px solid var(--ct-border-color); border-radius: var(--ct-border-radius-lg); padding: 1rem; margin-bottom: .75rem; background: var(--ct-tertiary-bg); }
.bill-values { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: .75rem; margin-top: .75rem; }
.bill-values small { display: block; color: var(--ct-secondary-color); }
@media (max-width: 575.98px) {
    .bill-values { grid-template-columns: repeat(2, minmax(0, 1fr)); }
}
</style>

<script>
var studentCache = {};
var selectedStudent = null;
var billRows = [];
var paymentCart = [];
var lastPaymentId = 0;
var lastPaymentNumber = '';
var paymentSuccessModal;
var transactionDetailModal;
var whatsappModal;

$(function () {
    flatpickr('#tanggal_pembayaran', { dateFormat: 'd-m-Y' });
    paymentSuccessModal = new bootstrap.Modal(document.getElementById('modal_berhasil'));
    transactionDetailModal = new bootstrap.Modal(document.getElementById('modal_detail_transaksi'));
    whatsappModal = new bootstrap.Modal(document.getElementById('modal_whatsapp'));

    $('#btn_cari_siswa').on('click', searchStudent);
    $('#cari_siswa').on('keydown', function (event) { if (event.key === 'Enter') searchStudent(); });
    $('#hasil_siswa').on('click', '[data-student-id]', function () { selectStudent($(this).data('student-id')); });
    $('#siswa_dipilih').on('click', '#btn_ganti_siswa', changeStudent);

    $('#filter_tahun,#filter_tipe,#filter_status').on('change', drawBills);
    $('#btn_filter_tagihan').on('click', drawBills);
    $('#filter_tagihan').on('keydown', function (event) { if (event.key === 'Enter') drawBills(); });
    $('#btn_tambah_keranjang').on('click', addSelectedBills);
    $('#daftar_tagihan').on('change', '.check-bill', updateAddButton);

    $('#keranjang').on('input', '.cart-amount', updateCartAmount);
    $('#keranjang').on('click', '[data-remove-cart]', removeCartItem);
    $('#btn_kosongkan').on('click', emptyCart);
    $('#btn_kembali_keranjang').on('click', function () { document.getElementById('keranjang-pembayaran').scrollIntoView({ behavior: 'smooth' }); });

    $('#id_metode').on('change', toggleCashFields);
    $('#uang_diterima').on('input', calculateCart);
    $('#form_pembayaran').on('submit', savePayment);

    $('#btn_lihat_detail').on('click', showTransactionDetail);
    $('#btn_whatsapp').on('click', openWhatsapp);
    $('#btn_kirim_wa').on('click', sendWhatsapp);
    $('#btn_transaksi_baru').on('click', function () { location.reload(); });
    $('.tujuan-wa').on('change', applyWhatsappRecipient);

    var presetStudent = new URLSearchParams(window.location.search).get('siswa');
    if (presetStudent) {
        $.getJSON('<?= base_url('pembayaran/siswa/') ?>' + encodeURIComponent(presetStudent), function (response) {
            if (response.result === 'true') {
                studentCache[response.siswa.id] = response.siswa;
                selectStudent(response.siswa.id);
            }
        });
    }
});

function searchStudent() {
    var keyword = $.trim($('#cari_siswa').val());
    if (keyword.length < 2) {
        Swal.fire('Perhatian', 'Masukkan minimal 2 karakter pencarian.', 'warning');
        return;
    }

    var button = $('#btn_cari_siswa');
    button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Mencari');
    $.post('<?= base_url('pembayaran/cari_siswa') ?>', { q: keyword }, function (rows) {
        studentCache = {};
        var html = '';
        if (!rows.length) {
            html = '<div class="empty-state"><i class="ri-user-search-line empty-icon"></i>Siswa tidak ditemukan.</div>';
        }
        rows.forEach(function (row) {
            studentCache[row.id] = row;
            var statusClass = row.status_pendaftaran === 'Aktif' ? 'success' : 'secondary';
            html += '<div class="crud-list-item">' +
                '<div class="crud-content">' +
                    '<div class="d-flex align-items-center gap-2 flex-wrap"><div class="crud-title mb-0">' + escapeHtml(row.nama_lengkap) + '</div><span class="badge bg-' + statusClass + '-subtle text-' + statusClass + '">' + escapeHtml(row.status_pendaftaran || '-') + '</span></div>' +
                    '<div class="crud-meta">NIS ' + escapeHtml(row.nis || '-') + ' | NISN ' + escapeHtml(row.nisn || '-') + ' | Kelas Aktif ' + escapeHtml(row.nama_kelas || 'Belum ditempatkan') + '</div>' +
                    '<div class="crud-note">Wali: Ayah ' + escapeHtml(row.telepon_ayah || '-') + ' | Ibu ' + escapeHtml(row.telepon_ibu || '-') + '</div>' +
                '</div>' +
                '<div class="crud-actions"><button type="button" class="btn btn-primary" data-student-id="' + Number(row.id) + '"><i class="ri-check-line me-1"></i>Pilih</button></div>' +
            '</div>';
        });
        $('#hasil_siswa').html(html);
    }, 'json').fail(ajaxError).always(function () {
        button.prop('disabled', false).html('<i class="ri-search-line me-1"></i>Cari');
    });
}

function selectStudent(id) {
    var nextStudent = studentCache[id];
    if (!nextStudent) return;

    if (selectedStudent && Number(selectedStudent.id) !== Number(id) && paymentCart.length) {
        Swal.fire({
            title: 'Ganti siswa?',
            text: 'Keranjang pembayaran siswa sebelumnya akan dikosongkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ganti Siswa',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) applySelectedStudent(nextStudent);
        });
        return;
    }
    applySelectedStudent(nextStudent);
}

function applySelectedStudent(student) {
    selectedStudent = student;
    paymentCart = [];
    billRows = [];
    $('#id_siswa').val(student.id);
    $('#hasil_siswa').empty();
    $('#siswa_dipilih').removeClass('d-none').html(
        '<div class="alert alert-primary mb-0">' +
            '<div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">' +
                '<div><strong class="fs-16">' + escapeHtml(student.nama_lengkap) + '</strong>' +
                    '<div>NIS ' + escapeHtml(student.nis || '-') + ' | NISN ' + escapeHtml(student.nisn || '-') + '</div>' +
                    '<div>Kelas aktif: ' + escapeHtml(student.nama_kelas || 'Belum ditempatkan') + ' | Status: ' + escapeHtml(student.status_pendaftaran || '-') + '</div>' +
                    '<div>Ayah: ' + escapeHtml(student.telepon_ayah || '-') + ' | Ibu: ' + escapeHtml(student.telepon_ibu || '-') + '</div>' +
                '</div>' +
                '<button type="button" id="btn_ganti_siswa" class="btn btn-sm btn-outline-primary">Ganti Siswa</button>' +
            '</div>' +
        '</div>'
    );
    drawCart();
    loadBills();
}

function changeStudent() {
    if (paymentCart.length) {
        Swal.fire({
            title: 'Ganti siswa?',
            text: 'Keranjang pembayaran akan dikosongkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ganti',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (result.isConfirmed) resetStudentSelection();
        });
    } else {
        resetStudentSelection();
    }
}

function resetStudentSelection() {
    selectedStudent = null;
    paymentCart = [];
    billRows = [];
    $('#id_siswa').val('');
    $('#siswa_dipilih').addClass('d-none').empty();
    $('#cari_siswa').val('').focus();
    $('#daftar_tagihan').html('<div class="empty-state"><i class="ri-user-search-line empty-icon"></i>Pilih siswa terlebih dahulu.</div>');
    $('#jumlah_tagihan').text('0 tagihan');
    drawCart();
}

function loadBills() {
    $('#daftar_tagihan').html('<div class="empty-state"><span class="spinner-border spinner-border-sm me-1"></span>Memuat tagihan...</div>');
    $.post('<?= base_url('pembayaran/tagihan_siswa') ?>', { id_siswa: selectedStudent.id }, function (response) {
        if (response.result !== 'true') {
            Swal.fire('Gagal', response.message, 'error');
            return;
        }
        billRows = response.tagihan || [];
        var years = [];
        billRows.forEach(function (row) {
            if (years.indexOf(row.periode) === -1) years.push(row.periode);
        });
        $('#filter_tahun').html('<option value="">Semua Tahun</option>' + years.map(function (year) {
            return '<option value="' + escapeHtml(year) + '">' + escapeHtml(year) + '</option>';
        }).join(''));
        drawBills();
    }, 'json').fail(ajaxError);
}

function filteredBills() {
    var year = $('#filter_tahun').val();
    var type = $('#filter_tipe').val();
    var status = $('#filter_status').val();
    var keyword = $.trim($('#filter_tagihan').val()).toLowerCase();
    return billRows.filter(function (row) {
        return (!year || row.periode === year) &&
            (!type || row.tipe_tagihan === type) &&
            (!status || row.status_pembayaran === status) &&
            (!keyword || String(row.nama_tagihan || '').toLowerCase().indexOf(keyword) !== -1);
    });
}

function drawBills() {
    var rows = filteredBills();
    $('#jumlah_tagihan').text(rows.length + ' tagihan');
    if (!rows.length) {
        $('#daftar_tagihan').html('<div class="empty-state"><i class="ri-file-search-line empty-icon"></i>Tidak ada tagihan yang dapat dibayar sesuai filter.</div>');
        updateAddButton();
        return;
    }

    var currentPeriod = selectedStudent ? selectedStudent.periode : '';
    var currentRows = rows.filter(function (row) { return currentPeriod && row.periode === currentPeriod; });
    var previousRows = rows.filter(function (row) { return !currentPeriod || row.periode !== currentPeriod; });
    var html = '';
    if (currentRows.length) html += buildBillSection('Tagihan Tahun Berjalan', currentRows, 'primary');
    if (previousRows.length) html += buildBillSection('Tunggakan / Tagihan Tahun Sebelumnya', previousRows, 'warning');
    $('#daftar_tagihan').html(html);
    updateAddButton();
}

function buildBillSection(title, rows, tone) {
    var html = '<div class="bill-section"><div class="bill-section-title"><h5 class="mb-0">' + escapeHtml(title) + '</h5><span class="badge bg-' + tone + '-subtle text-' + tone + '">' + rows.length + ' tagihan</span></div>';
    rows.forEach(function (row) {
        var inCart = paymentCart.some(function (item) { return item.id === Number(row.id); });
        var reduction = Number(row.nilai_keringanan || 0);
        html += '<div class="bill-item">' +
            '<div class="d-flex align-items-start gap-3">' +
                '<input type="checkbox" class="form-check-input check-bill mt-1" value="' + Number(row.id) + '" ' + (inCart ? 'disabled' : '') + '>' +
                '<div class="flex-grow-1 min-w-0">' +
                    '<div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">' +
                        '<div><strong>' + escapeHtml(row.nama_tagihan) + '</strong><br><small class="text-muted">' + escapeHtml(row.no_tagihan || '-') + ' | ' + escapeHtml(row.nama_bulan || '') + ' ' + escapeHtml(row.tahun || '') + ' | ' + escapeHtml(row.periode || '-') + '</small></div>' +
                        '<div class="d-flex gap-1 flex-wrap"><span class="badge bg-info-subtle text-info">' + escapeHtml(row.tipe_tagihan || '-') + '</span>' +
                            '<span class="badge bg-' + (row.status_pembayaran === 'Dibayar Sebagian' ? 'warning' : 'secondary') + '-subtle text-' + (row.status_pembayaran === 'Dibayar Sebagian' ? 'warning' : 'secondary') + '">' + escapeHtml(row.status_pembayaran) + '</span>' +
                            (row.dianggap_tunggakan === 'Tidak' ? '<span class="badge bg-purple-subtle text-purple">Tidak dianggap tunggakan</span>' : '') +
                        '</div>' +
                    '</div>' +
                    '<div class="bill-values">' +
                        '<div><small>Nominal Awal</small><strong>' + formatRupiah(row.nominal_awal) + '</strong></div>' +
                        '<div><small>Potongan/Pembebasan</small><strong>' + formatRupiah(reduction) + '</strong></div>' +
                        '<div><small>Nominal Akhir</small><strong>' + formatRupiah(row.nominal_tagihan) + '</strong></div>' +
                        '<div><small>Sudah Dibayar</small><strong>' + formatRupiah(row.nominal_dibayar) + '</strong></div>' +
                        '<div><small>Sisa</small><strong class="text-danger">' + formatRupiah(row.sisa_tagihan) + '</strong></div>' +
                    '</div>' +
                '</div>' +
            '</div>' +
        '</div>';
    });
    return html + '</div>';
}

function updateAddButton() {
    $('#btn_tambah_keranjang').prop('disabled', $('.check-bill:checked').length === 0);
}

function addSelectedBills() {
    $('.check-bill:checked').each(function () {
        var id = Number(this.value);
        var row = billRows.find(function (item) { return Number(item.id) === id; });
        if (row && !paymentCart.some(function (item) { return item.id === id; })) {
            paymentCart.push({
                id: id,
                name: row.nama_tagihan,
                period: (row.nama_bulan || '') + ' ' + (row.tahun || '') + ' | ' + (row.periode || ''),
                balance: Number(row.sisa_tagihan),
                pay: Number(row.sisa_tagihan)
            });
        }
    });
    drawCart();
    drawBills();
    document.getElementById('keranjang-pembayaran').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function drawCart() {
    if (!paymentCart.length) {
        $('#keranjang').html('<div class="empty-state py-3">Keranjang masih kosong.</div>');
    } else {
        $('#keranjang').html(paymentCart.map(function (item, index) {
            return '<div class="border rounded p-2 mb-2">' +
                '<div class="d-flex justify-content-between gap-2">' +
                    '<div><strong>' + escapeHtml(item.name) + '</strong><br><small class="text-muted">' + escapeHtml(item.period) + '<br>Sisa ' + formatRupiah(item.balance) + '</small></div>' +
                    '<button type="button" class="btn btn-sm btn-outline-danger" data-remove-cart="' + index + '"><i class="ri-close-line"></i></button>' +
                '</div>' +
                '<label class="form-label mt-2 mb-1" for="cart_amount_' + index + '">Bayar sekarang</label>' +
                '<input type="text" inputmode="numeric" autocomplete="off" id="cart_amount_' + index + '" class="form-control money-input cart-amount" data-cart-index="' + index + '" value="' + formatMoneyInput(item.pay) + '">' +
            '</div>';
        }).join(''));
    }
    calculateCart();
}

function updateCartAmount() {
    var index = Number($(this).data('cart-index'));
    var value = parseMoneyInput($(this).val());
    paymentCart[index].pay = Math.min(paymentCart[index].balance, Math.max(0, value));
    $(this).val(formatMoneyInput(paymentCart[index].pay));
    calculateCart();
}

function removeCartItem() {
    paymentCart.splice(Number($(this).data('remove-cart')), 1);
    drawCart();
    drawBills();
}

function emptyCart() {
    if (!paymentCart.length) return;
    Swal.fire({
        title: 'Kosongkan keranjang?',
        text: 'Tagihan yang dipilih akan dikeluarkan dari keranjang.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Kosongkan',
        cancelButtonText: 'Batal'
    }).then(function (result) {
        if (result.isConfirmed) {
            paymentCart = [];
            drawCart();
            drawBills();
        }
    });
}

function cartTotal() {
    return paymentCart.reduce(function (total, item) { return total + Number(item.pay || 0); }, 0);
}

function calculateCart() {
    var total = cartTotal();
    var received = parseMoneyInput($('#uang_diterima').val());
    $('#total_keranjang').text(formatRupiah(total));
    $('#ringkasan_keranjang').text(paymentCart.length + ' tagihan | Total ' + formatRupiah(total));
    $('#kembalian').val(formatRupiah(Math.max(0, received - total)));
    $('#btn_simpan').prop('disabled', !paymentCart.length || !selectedStudent);
    $('#btn_kosongkan').prop('disabled', !paymentCart.length);
}

function toggleCashFields() {
    var needsCash = String($('#id_metode option:selected').data('cash')) === 'Ya';
    $('#blok_tunai').toggleClass('d-none', !needsCash);
    if (!needsCash) setMoneyInputValue('#uang_diterima', cartTotal());
    calculateCart();
}

function savePayment(event) {
    event.preventDefault();
    var invalid = paymentCart.some(function (item) { return item.pay <= 0 || item.pay > item.balance; });
    if (invalid) {
        Swal.fire('Perhatian', 'Nominal setiap tagihan harus lebih dari nol dan tidak boleh melebihi sisa.', 'warning');
        return;
    }
    if (!$('#id_metode').val()) {
        Swal.fire('Perhatian', 'Pilih metode pembayaran.', 'warning');
        return;
    }

    var total = cartTotal();
    var needsCash = String($('#id_metode option:selected').data('cash')) === 'Ya';
    if (needsCash && parseMoneyInput($('#uang_diterima').val()) < total) {
        Swal.fire('Perhatian', 'Uang diterima minimal sama dengan total pembayaran.', 'warning');
        return;
    }

    Swal.fire({
        title: 'Simpan transaksi pembayaran?',
        text: formatRupiah(total) + ' untuk ' + selectedStudent.nama_lengkap,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal'
    }).then(function (result) {
        if (!result.isConfirmed) return;

        var button = $('#btn_simpan');
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan');
        $.post('<?= base_url('pembayaran/simpan') ?>', {
            token: $('#token_pembayaran').val(),
            id_siswa: selectedStudent.id,
            id_metode: $('#id_metode').val(),
            tanggal: $('#tanggal_pembayaran').val(),
            uang_diterima: parseMoneyInput($('#uang_diterima').val()),
            referensi: $('#referensi').val(),
            catatan: $('#catatan').val(),
            items: JSON.stringify(paymentCart.map(function (item) {
                return { id_tagihan_siswa: item.id, nominal_bayar: item.pay };
            }))
        }, function (response) {
            if (response.result !== 'true') {
                Swal.fire('Gagal', response.message, 'error');
                return;
            }
            lastPaymentId = Number(response.id_pembayaran);
            lastPaymentNumber = response.no_transaksi;
            $('#isi_berhasil').html(
                '<div class="text-center mb-4"><div class="avatar-lg rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center"><i class="ri-check-line fs-30"></i></div><h4 class="mt-2 mb-0">' + escapeHtml(response.no_transaksi) + '</h4></div>' +
                '<div class="row g-2">' +
                    '<div class="col-6 text-muted">Siswa</div><div class="col-6 text-end fw-semibold">' + escapeHtml(selectedStudent.nama_lengkap) + '</div>' +
                    '<div class="col-6 text-muted">Total</div><div class="col-6 text-end fw-semibold">' + formatRupiah(response.total) + '</div>' +
                    '<div class="col-6 text-muted">Metode</div><div class="col-6 text-end">' + escapeHtml($('#id_metode option:selected').text()) + '</div>' +
                    '<div class="col-6 text-muted">Diterima</div><div class="col-6 text-end">' + formatRupiah(response.uang_diterima) + '</div>' +
                    '<div class="col-6 text-muted">Kembalian</div><div class="col-6 text-end">' + formatRupiah(response.kembalian) + '</div>' +
                '</div>'
            );
            $('#link_bukti').attr('href', '<?= base_url('pembayaran/bukti/') ?>' + lastPaymentId);
            $('#link_kartu').attr('href', '<?= base_url('pembayaran/cetak_kartu/') ?>' + lastPaymentId);
            paymentSuccessModal.show();
        }, 'json').fail(ajaxError).always(function () {
            button.prop('disabled', false).html('<i class="ri-save-line me-1"></i>Simpan Pembayaran');
        });
    });
}

function showTransactionDetail() {
    if (!lastPaymentId) return;
    $.getJSON('<?= base_url('pembayaran/detail/') ?>' + lastPaymentId, function (response) {
        if (response.result !== 'true') {
            Swal.fire('Gagal', response.message, 'error');
            return;
        }
        var header = response.header;
        var html = '<div class="row g-2 mb-3">' +
            '<div class="col-md-6"><small class="text-muted">Nomor</small><div class="fw-semibold">' + escapeHtml(header.no_transaksi) + '</div></div>' +
            '<div class="col-md-6"><small class="text-muted">Status</small><div><span class="badge bg-success-subtle text-success">' + escapeHtml(header.status_transaksi) + '</span></div></div>' +
            '<div class="col-md-6"><small class="text-muted">Siswa</small><div>' + escapeHtml(header.nama_siswa) + '</div></div>' +
            '<div class="col-md-6"><small class="text-muted">Kelas</small><div>' + escapeHtml(header.nama_kelas || '-') + '</div></div>' +
        '</div><div class="table-responsive"><table class="table table-bordered table-sm"><thead><tr><th>Tagihan</th><th class="text-end">Dibayar</th><th class="text-end">Sisa</th></tr></thead><tbody>';
        response.detail.forEach(function (row) {
            html += '<tr><td>' + escapeHtml(row.nama_tagihan) + '</td><td class="text-end">' + formatRupiah(row.nominal_bayar) + '</td><td class="text-end">' + formatRupiah(row.sisa_setelah) + '</td></tr>';
        });
        html += '</tbody><tfoot><tr><th>Total</th><th class="text-end">' + formatRupiah(header.total_pembayaran) + '</th><th></th></tr></tfoot></table></div>';
        $('#isi_detail_transaksi').html(html);
        transactionDetailModal.show();
    }).fail(ajaxError);
}

function openWhatsapp() {
    if (!selectedStudent || !lastPaymentId) return;
    $('#label_wa_ayah').text('Ayah - ' + (selectedStudent.telepon_ayah || 'Tidak tersedia'));
    $('#label_wa_ibu').text('Ibu - ' + (selectedStudent.telepon_ibu || 'Tidak tersedia'));
    $('#wa_pesan').val('');
    if (selectedStudent.telepon_ayah) $('#wa_ayah').prop('checked', true);
    else if (selectedStudent.telepon_ibu) $('#wa_ibu').prop('checked', true);
    else $('#wa_lain').prop('checked', true);
    applyWhatsappRecipient();
    whatsappModal.show();
}

function applyWhatsappRecipient() {
    var target = $('input[name="tujuan_wa"]:checked').val();
    if (target === 'Ayah') {
        $('#wa_nama').val(selectedStudent.nama_ayah || '');
        $('#wa_nomor').val(selectedStudent.telepon_ayah || '');
    } else if (target === 'Ibu') {
        $('#wa_nama').val(selectedStudent.nama_ibu || '');
        $('#wa_nomor').val(selectedStudent.telepon_ibu || '');
    } else {
        $('#wa_nama,#wa_nomor').val('');
    }
}

function sendWhatsapp() {
    var phone = $.trim($('#wa_nomor').val());
    if (!phone) {
        Swal.fire('Perhatian', 'Nomor WhatsApp wajib diisi.', 'warning');
        return;
    }
    var button = $('#btn_kirim_wa');
    button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyiapkan');
    $.post('<?= base_url('pembayaran/siapkan_whatsapp') ?>', {
        id: lastPaymentId,
        hubungan: $('input[name="tujuan_wa"]:checked').val(),
        nama_penerima: $('#wa_nama').val(),
        nomor: phone,
        pesan: $('#wa_pesan').val()
    }, function (response) {
        if (response.result !== 'true') {
            Swal.fire('Gagal', response.message, 'error');
            return;
        }
        whatsappModal.hide();
        window.open(response.url, '_blank');
    }, 'json').fail(ajaxError).always(function () {
        button.prop('disabled', false).html('<i class="ri-whatsapp-line me-1"></i>Buka WhatsApp');
    });
}
</script>
