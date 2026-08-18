<?php
$app_admin = $this->session->userdata('admin');
$app_admin = is_array($app_admin) ? $app_admin : array();
$app_admin_name = isset($app_admin['nama']) && $app_admin['nama'] !== '' ? $app_admin['nama'] : 'Administrator';
?>
<div class="card">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title mb-1">1. Cari dan Pilih Siswa</h4>
            <p class="text-muted mb-0">Cari berdasarkan nama, NIS, NISN, atau kode siswa. Satu transaksi hanya untuk satu siswa.</p>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-md-10">
                <label class="form-label" for="cari_siswa">Nama / NIS / NISN / Scan Kode</label>
                <input type="text" id="cari_siswa"
                    class="form-control"
                    placeholder="Masukkan nama, NIS, NISN, atau scan kode siswa"
                    autocomplete="off"
                >
            </div>
            <div class="col-md-2 d-grid">
                <button id="btn_cari_siswa" type="button" class="btn btn-primary">
                    <i class="ri-search-line me-1"></i>Cari Siswa
                </button>
            </div>
        </div>

        <div id="hasil_siswa" class="crud-list mt-3"></div>
    </div>
</div>

<div id="card_identitas_siswa" class="card d-none">
    <div class="card-header app-card-header">
        <div>
            <h4 class="header-title mb-1">Identitas Siswa</h4>
            <p class="text-muted mb-0">Pastikan siswa yang dipilih sudah benar sebelum memilih tagihan.</p>
        </div>
        <button type="button" id="btn_ganti_siswa" class="btn btn-outline-primary">
            <i class="ri-user-search-line me-1"></i>Ganti Siswa
        </button>
    </div>
    <div class="card-body" id="siswa_dipilih"></div>
</div>

<div id="area_transaksi" class="d-none">
    <div class="row g-3 align-items-start">
        <div class="col-xl-7">
            <div class="card" id="card_tagihan">
                <div class="card-header app-card-header">
                    <div>
                        <h4 class="header-title mb-1">2. Tagihan Siswa</h4>
                        <p class="text-muted mb-0">Tagihan tahun berjalan dan tagihan tahun sebelumnya ditampilkan terpisah.</p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary" id="jumlah_tagihan">0 tagihan</span>
                </div>
                <div class="card-body">
                    <div class="row g-2 align-items-end">
                        <div class="col-xl-2 col-md-6">
                            <label class="form-label" for="filter_tahun">Tahun Ajaran</label>
                            <select id="filter_tahun" class="form-select">
                                <option value="">Semua Tahun</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <label class="form-label" for="filter_tipe">Tipe</label>
                            <select id="filter_tipe" class="form-select">
                                <option value="">Semua Tipe</option>
                                <option value="Bulanan">Bulanan</option>
                                <option value="Langsung">Langsung</option>
                                <option value="Tahunan">Tahunan</option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-md-6">
                            <label class="form-label" for="filter_status">Status</label>
                            <select id="filter_status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Dibayar Sebagian">Dibayar Sebagian</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <label class="form-label" for="filter_tagihan">Nama Tagihan</label>
                            <input
                                type="text"
                                id="filter_tagihan"
                                class="form-control"
                                placeholder="Cari nama atau nomor tagihan"
                            >
                        </div>
                        <div class="col-xl-2 col-md-12 d-grid">
                            <button id="btn_filter_tagihan" type="button" class="btn btn-primary">
                                <i class="ri-search-line me-1"></i>Cari
                            </button>
                        </div>
                    </div>

                    <div id="daftar_tagihan" class="mt-3"></div>

                    <div class="d-flex justify-content-end mt-3">
                        <button id="btn_tambah_keranjang" type="button" class="btn btn-primary" disabled>
                            <i class="ri-shopping-cart-2-line me-1"></i>Tambah Terpilih ke Keranjang
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card" id="keranjang-pembayaran">
                <div class="card-header app-card-header">
                    <div>
                        <h4 class="header-title mb-1">3. Keranjang Pembayaran</h4>
                        <p class="text-muted mb-0">Nominal setiap tagihan dapat diubah untuk pembayaran cicilan.</p>
                    </div>
                </div>
                <div class="card-body">
                    <div id="keranjang">
                        <div class="empty-state py-3">Keranjang masih kosong.</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
                        <strong>Total Pembayaran</strong>
                        <strong class="text-primary fs-18" id="total_keranjang">Rp0</strong>
                    </div>

                    <div class="row g-2 mt-2">
                        <div class="col-sm-6">
                            <button type="button" id="btn_kosongkan" class="btn btn-outline-danger w-100" disabled>
                                <i class="ri-delete-bin-line me-1"></i>Kosongkan Keranjang
                            </button>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" id="btn_selesaikan_pembayaran" class="btn btn-success w-100" disabled>
                                <i class="ri-checkbox-circle-line me-1"></i>Selesaikan Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<div class="modal fade" id="modal_checkout_pembayaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-1">
                        <i class="ri-secure-payment-line me-1 text-success"></i>Selesaikan Pembayaran
                    </h5>
                    <small class="text-muted" id="checkout_siswa">-</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-1">Tagihan Dipilih</h6>
                                <small class="text-muted">Periksa kembali daftar tagihan sebelum pembayaran.</small>
                            </div>
                            <span class="badge bg-primary-subtle text-primary" id="checkout_jumlah">0 tagihan</span>
                        </div>

                        <div id="checkout_daftar">
                            <div class="empty-state py-3">Belum ada tagihan dipilih.</div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="checkout-form-panel">
                            <h6 class="mb-3">Informasi Pembayaran</h6>

                            <form id="form_pembayaran">
                                <input type="hidden" id="id_siswa">
                                <input type="hidden" id="token_pembayaran" value="<?= html_escape($token_pembayaran) ?>">

                                <div class="mb-3">
                                    <label class="form-label" for="tanggal_pembayaran">Tanggal Pembayaran</label>
                                    <input type="text" id="tanggal_pembayaran" class="form-control tanggal-picker"
                                        value="<?= date('d-m-Y') ?>" placeholder="dd-mm-yyyy" autocomplete="off" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="id_metode">Metode Pembayaran</label>
                                    <select id="id_metode" class="form-select" required>
                                        <option value="">Pilih metode pembayaran</option>
                                        <?php foreach ($metode as $row): ?>
                                            <option value="<?= (int) $row['id'] ?>" data-cash="<?= html_escape($row['butuh_uang_diterima']) ?>">
                                                <?= html_escape($row['nama_metode']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div id="blok_tunai" class="d-none">
                                    <div class="row g-2 mb-3">
                                        <div class="col-xl-6">
                                            <label class="form-label" for="uang_diterima">Uang Diterima</label>
                                            <input type="text" inputmode="numeric" autocomplete="off"
                                                id="uang_diterima" class="form-control money-input" value="0">
                                        </div>
                                        <div class="col-xl-6">
                                            <label class="form-label" for="kembalian">Kembalian</label>
                                            <input id="kembalian" class="form-control" value="Rp0" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="referensi">Referensi Pembayaran</label>
                                    <input id="referensi" class="form-control" placeholder="Opsional untuk transfer atau QRIS">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Petugas</label>
                                    <div class="alert alert-light border mb-0 py-2">
                                        <small class="text-muted d-block">Transaksi diproses oleh</small>
                                        <strong><?= html_escape($app_admin_name) ?></strong>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label" for="catatan">Catatan</label>
                                    <textarea id="catatan" class="form-control" rows="3"
                                        placeholder="Catatan transaksi bila diperlukan"></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="me-auto">
                    <small class="text-muted d-block">Total Pembayaran</small>
                    <strong class="fs-18 text-success" id="checkout_total">Rp0</strong>
                </div>

                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="form_pembayaran" id="btn_simpan" class="btn btn-success" disabled>
                    <i class="ri-check-line me-1"></i>Bayar Sekarang
                </button>
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
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                        <label class="form-label mb-0" for="wa_pesan">Pesan</label>
                        <button type="button" id="btn_muat_template_wa" class="btn btn-sm btn-outline-secondary">
                            <i class="ri-refresh-line me-1"></i>Muat Template
                        </button>
                    </div>
                    <textarea id="wa_pesan" class="form-control" rows="7" placeholder="Template default Bukti Pembayaran akan dimuat otomatis"></textarea>
                    <small class="text-muted">Template default dari Pengaturan → Template WhatsApp dimuat otomatis dan tetap dapat diedit sebelum dikirim.</small>
                    <div id="wa_template_info" class="small text-primary mt-1"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tautan Bukti Pembayaran</label>
                    <div><a href="#" id="wa_bukti_link" target="_blank">Buka bukti pembayaran</a></div>
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
.bill-section + .bill-section {
    margin-top: 1.5rem;
}

.bill-section-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: .75rem;
}

.bill-item {
    border: 1px solid var(--ct-border-color);
    border-radius: var(--ct-border-radius-lg);
    padding: 1rem;
    margin-bottom: .75rem;
    background: var(--ct-tertiary-bg);
}

.bill-values {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(125px, 1fr));
    gap: .75rem;
    margin-top: .75rem;
}

.bill-values > div {
    min-width: 0;
}

.bill-values small {
    display: block;
    color: var(--ct-secondary-color);
    margin-bottom: .15rem;
}

.bill-values strong {
    display: block;
    overflow-wrap: anywhere;
}

#keranjang-pembayaran .cart-amount {
    min-width: 0;
}

.checkout-form-panel {
    border-left: 1px solid var(--ct-border-color);
    padding-left: 1.5rem;
    height: 100%;
}

.checkout-bill-item {
    border: 1px solid var(--ct-border-color);
    border-radius: var(--ct-border-radius-lg);
    padding: .9rem 1rem;
    margin-bottom: .75rem;
    background: var(--ct-tertiary-bg);
}

@media (max-width: 991.98px) {
    .checkout-form-panel {
        border-left: 0;
        border-top: 1px solid var(--ct-border-color);
        padding-left: 0;
        padding-top: 1.25rem;
    }
}

@media (min-width: 1200px) {
    #keranjang-pembayaran {
        position: sticky;
        top: 92px;
    }
}

@media (max-width: 575.98px) {
    .bill-section-title {
        align-items: flex-start;
        flex-direction: column;
    }

    .bill-values {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
</style>

<script>
var studentCache = {};
var selectedStudent = null;
var billRows = [];
var paymentCart = [];
var lastPaymentId = 0;
var lastPaymentNumber = '';
var currentAcademicPeriod = '';
var paymentSuccessModal;
var checkoutPaymentModal;
var transactionDetailModal;
var whatsappModal;
var waPesanEdited = false;

$(function () {
    flatpickr('#tanggal_pembayaran', {
        dateFormat: 'd-m-Y',
        allowInput: true,
        disableMobile: true
    });

    paymentSuccessModal = new bootstrap.Modal(
        document.getElementById('modal_berhasil')
    );

    checkoutPaymentModal = new bootstrap.Modal(
        document.getElementById('modal_checkout_pembayaran')
    );

    transactionDetailModal = new bootstrap.Modal(
        document.getElementById('modal_detail_transaksi')
    );

    whatsappModal = new bootstrap.Modal(
        document.getElementById('modal_whatsapp')
    );

    $('#btn_cari_siswa').click(function () {
        searchStudent();
    });

    $('#cari_siswa').keyup(function (event) {
        if (event.key === 'Enter') {
            searchStudent();
        }
    });

    $('#hasil_siswa').on('click', '[data-student-id]', function () {
        selectStudent($(this).data('student-id'));
    });

    $('#btn_ganti_siswa').click(function () {
        changeStudent();
    });

    $('#filter_tahun, #filter_tipe, #filter_status').change(function () {
        loadBills();
    });

    $('#btn_filter_tagihan').click(function () {
        loadBills();
    });

    $('#filter_tagihan').keyup(function (event) {
        if (event.key === 'Enter') {
            loadBills();
        }
    });

    $('#btn_tambah_keranjang').click(function () {
        addSelectedBills();
    });

    $('#daftar_tagihan').on('change', '.check-bill', function () {
        updateAddButton();
    });

    $('#keranjang').on('input', '.cart-amount', function () {
        updateCartAmount.call(this);
    });

    $('#keranjang').on('click', '[data-remove-cart]', function () {
        removeCartItem.call(this);
    });

    $('#btn_kosongkan').click(function () {
        emptyCart();
    });

    $('#btn_selesaikan_pembayaran').click(function () {
        openCheckoutPayment();
    });

    $('#id_metode').change(function () {
        toggleCashFields();
    });

    $('#uang_diterima').on('input', function () {
        calculateCart();
    });

    $('#form_pembayaran').submit(function (event) {
        savePayment(event);
    });

    $('#btn_lihat_detail').click(function () {
        showTransactionDetail();
    });

    $('#btn_whatsapp').click(function () {
        openWhatsapp();
    });

    $('#btn_kirim_wa').click(function () {
        sendWhatsapp();
    });

    $('#btn_muat_template_wa').click(function () {
        loadWhatsappTemplate(true);
    });

    $('#wa_pesan').on('input', function () {
        waPesanEdited = true;
    });

    $('#btn_transaksi_baru').click(function () {
        location.reload();
    });

    $('.tujuan-wa').change(function () {
        applyWhatsappRecipient();
        if (!waPesanEdited) {
            loadWhatsappTemplate(false);
        }
    });

    drawBills();

    var presetStudent = new URLSearchParams(window.location.search).get('siswa');

    if (presetStudent) {
        $.ajax({
            url: '<?= base_url('admin/transaksi/pembayaran/siswa'); ?>',
            type: 'POST',
            data: {
                id: presetStudent
            },
            dataType: 'JSON',
            success: function (data) {
                if (data.result == 'true') {
                    studentCache[data.siswa.id] = data.siswa;
                    selectStudent(data.siswa.id);
                } else if (data.result == 'false') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message
                    });
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }
});

function getStudentAdministrativeStatus(status) {
    var normalized = $.trim(String(status || ''));
    var inactiveStatuses = [
        'Lulus',
        'Pindah Sekolah',
        'Berhenti',
        'Nonaktif'
    ];

    return inactiveStatuses.indexOf(normalized) !== -1
        ? normalized
        : 'Aktif';
}

function searchStudent() {
    var keyword = $.trim($('#cari_siswa').val());

    if (keyword.length < 2) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Masukkan minimal 2 karakter pencarian.'
        });
        return;
    }

    var button = $('#btn_cari_siswa');

    button
        .prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm me-1"></span>Mencari');

    $.ajax({
        url: '<?= base_url('admin/transaksi/pembayaran/cari_siswa'); ?>',
        type: 'POST',
        data: {
            q: keyword
        },
        dataType: 'JSON',
        success: function (data) {
            studentCache = {};

            var table = '';

            if (data.length == 0) {
                table += `
                    <div class="empty-state">
                        <i class="ri-user-search-line empty-icon"></i>
                        Siswa tidak ditemukan.
                    </div>
                `;
            } else {
                data.forEach(function (item) {
                    studentCache[item.id] = item;

                    table += `
                        <div class="crud-list-item">
                            <div class="crud-content">
                                <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                                    <div class="crud-title mb-0">
                                        ${escapeHtml(item.nama_lengkap)}
                                    </div>
                                    <span class="badge bg-${getStudentAdministrativeStatus(item.status_pendaftaran) === 'Aktif' ? 'success' : 'secondary'}-subtle text-${getStudentAdministrativeStatus(item.status_pendaftaran) === 'Aktif' ? 'success' : 'secondary'}">
                                        ${escapeHtml(getStudentAdministrativeStatus(item.status_pendaftaran))}
                                    </span>
                                </div>
                                <div class="crud-meta">
                                    NIS ${escapeHtml(item.nis || '-')} |
                                    NISN ${escapeHtml(item.nisn || '-')} |
                                    Kelas Aktif ${escapeHtml(item.nama_kelas || 'Belum ditempatkan')}
                                </div>
                                <div class="crud-note">
                                    Ayah ${escapeHtml(item.telepon_ayah || '-')} |
                                    Ibu ${escapeHtml(item.telepon_ibu || '-')}
                                </div>
                            </div>
                            <div class="crud-actions">
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    data-student-id="${Number(item.id)}"
                                >
                                    <i class="ri-check-line me-1"></i>Pilih
                                </button>
                            </div>
                        </div>
                    `;
                });
            }

            $('#hasil_siswa').html(table);
        },
        error: function (xhr, status, error) {
            ajaxError(xhr);
        },
        complete: function () {
            button
                .prop('disabled', false)
                .html('<i class="ri-search-line me-1"></i>Cari Siswa');
        }
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
    currentAcademicPeriod = student.periode || '';

    var studentStatus = getStudentAdministrativeStatus(
        student.status_pendaftaran
    );
    var statusTone = studentStatus === 'Aktif' ? 'success' : 'secondary';

    $('#id_siswa').val(student.id);
    $('#hasil_siswa').empty();
    $('#filter_tahun').html('<option value="">Semua Tahun</option>');
    $('#filter_tipe').val('');
    $('#filter_status').val('');
    $('#filter_tagihan').val('');
    $('#id_metode').val('');
    $('#referensi').val('');
    $('#catatan').val('');
    setMoneyInputValue('#uang_diterima', 0);
    $('#blok_tunai').addClass('d-none');

    $('#siswa_dipilih').html(`
        <div class="row g-3">
            <div class="col-lg-4 col-md-6">
                <small class="text-muted d-block">Nama Siswa</small>
                <strong class="fs-16">${escapeHtml(student.nama_lengkap)}</strong>
            </div>
            <div class="col-lg-2 col-md-6">
                <small class="text-muted d-block">NIS</small>
                <strong>${escapeHtml(student.nis || '-')}</strong>
            </div>
            <div class="col-lg-2 col-md-6">
                <small class="text-muted d-block">NISN</small>
                <strong>${escapeHtml(student.nisn || '-')}</strong>
            </div>
            <div class="col-lg-2 col-md-6">
                <small class="text-muted d-block">Kelas Aktif</small>
                <strong>${escapeHtml(student.nama_kelas || 'Belum ditempatkan')}</strong>
            </div>
            <div class="col-lg-2 col-md-6">
                <small class="text-muted d-block">Status</small>
                <span class="badge bg-${statusTone}-subtle text-${statusTone}">${escapeHtml(studentStatus)}</span>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Telepon Ayah</small>
                <strong>${escapeHtml(student.telepon_ayah || '-')}</strong>
            </div>
            <div class="col-md-6">
                <small class="text-muted d-block">Telepon Ibu</small>
                <strong>${escapeHtml(student.telepon_ibu || '-')}</strong>
            </div>
        </div>
    `);

    $('#card_identitas_siswa').removeClass('d-none');
    $('#area_transaksi').removeClass('d-none');

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
    currentAcademicPeriod = '';

    $('#id_siswa').val('');
    $('#card_identitas_siswa').addClass('d-none');
    $('#siswa_dipilih').empty();
    $('#area_transaksi').addClass('d-none');
    $('#cari_siswa').val('').focus();

    $('#filter_tahun').html('<option value="">Semua Tahun</option>');
    $('#filter_tipe').val('');
    $('#filter_status').val('');
    $('#filter_tagihan').val('');
    $('#jumlah_tagihan').text('0 tagihan');

    drawBills();
    drawCart();
}

function loadBills() {
    if (!selectedStudent) {
        return;
    }

    var periode = $('#filter_tahun').val();
    var tipe = $('#filter_tipe').val();
    var status = $('#filter_status').val();
    var search = $('#filter_tagihan').val();

    $('#daftar_tagihan').html(`
        <div class="empty-state">
            <span class="spinner-border spinner-border-sm me-1"></span>
            Memuat tagihan...
        </div>
    `);

    $.ajax({
        url: '<?= base_url('admin/transaksi/pembayaran/tagihan_siswa'); ?>',
        type: 'POST',
        data: {
            id_siswa: selectedStudent.id,
            periode: periode,
            tipe: tipe,
            status: status,
            search: search
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.result == 'true') {
                billRows = data.tagihan || [];
                currentAcademicPeriod = data.periode_aktif || selectedStudent.periode || '';

                var selectedPeriod = $('#filter_tahun').val();
                var options = '<option value="">Semua Tahun</option>';

                (data.tahun_ajaran || []).forEach(function (year) {
                    options += `
                        <option value="${escapeHtml(year)}">
                            ${escapeHtml(year)}
                        </option>
                    `;
                });

                $('#filter_tahun').html(options).val(selectedPeriod);
                drawBills();
            } else if (data.result == 'false') {
                billRows = [];
                drawBills();

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message
                });
            }
        },
        error: function (xhr, status, error) {
            billRows = [];
            drawBills();
            ajaxError(xhr);
        }
    });
}

function drawBills() {
    var currentRows = [];
    var previousRows = [];

    billRows.forEach(function (item) {
        if (
            currentAcademicPeriod !== '' &&
            String(item.periode) === String(currentAcademicPeriod)
        ) {
            currentRows.push(item);
        } else {
            previousRows.push(item);
        }
    });

    $('#jumlah_tagihan').text(billRows.length + ' tagihan');

    var table = '';

    table += buildBillSection(
        'Tagihan Tahun Berjalan',
        currentRows,
        'primary',
        'current',
        'Tidak ada data tagihan tahun berjalan.'
    );

    table += buildBillSection(
        'Tunggakan / Tagihan Tahun Sebelumnya',
        previousRows,
        'warning',
        'previous',
        'Tidak ada data tagihan tahun sebelumnya.'
    );

    $('#daftar_tagihan').html(table);

    updateAddButton();
}

function buildBillSection(title, rows, tone, key, emptyMessage) {
    var table = `
        <div class="bill-section" id="bill-section-${key}">
            <div class="bill-section-title">
                <h5 class="mb-0">${escapeHtml(title)}</h5>
                <span class="badge bg-${tone}-subtle text-${tone}">
                    ${rows.length} tagihan
                </span>
            </div>
    `;

    if (rows.length == 0) {
        table += `
            <div class="empty-state">
                <i class="ri-file-search-line empty-icon"></i>
                ${escapeHtml(emptyMessage || 'Tidak ada data.')}
            </div>
        `;
    } else {
        rows.forEach(function (item) {
            var inCart = paymentCart.some(function (cartItem) {
                return cartItem.id === Number(item.id);
            });

            var reduction = Number(item.nilai_keringanan || 0);
            var statusTone = item.status_pembayaran === 'Dibayar Sebagian'
                ? 'warning'
                : 'secondary';

            table += `
                <div class="bill-item">
                    <div class="d-flex align-items-start gap-3">
                        <input
                            type="checkbox"
                            class="form-check-input check-bill mt-1"
                            value="${Number(item.id)}"
                            ${inCart ? 'disabled' : ''}
                        >

                        <div class="flex-grow-1 min-w-0">
                            <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                <div>
                                    <strong>${escapeHtml(item.nama_tagihan)}</strong>
                                    <br>
                                    <small class="text-muted">
                                        ${escapeHtml(item.no_tagihan || '-')} |
                                        ${escapeHtml(item.nama_bulan || '')}
                                        ${escapeHtml(item.tahun || '')} |
                                        ${escapeHtml(item.periode || '-')}
                                    </small>
                                </div>

                                <div class="d-flex gap-1 flex-wrap">
                                    <span class="badge bg-info-subtle text-info">
                                        ${escapeHtml(item.tipe_tagihan || '-')}
                                    </span>
                                    <span class="badge bg-${statusTone}-subtle text-${statusTone}">
                                        ${escapeHtml(item.status_pembayaran)}
                                    </span>
                                    ${item.dianggap_tunggakan === 'Tidak'
                                        ? '<span class="badge bg-purple-subtle text-purple">Tidak dianggap tunggakan</span>'
                                        : ''}
                                </div>
                            </div>

                            <div class="bill-values">
                                <div>
                                    <small>Nominal Awal</small>
                                    <strong>${formatRupiah(item.nominal_awal)}</strong>
                                </div>
                                <div>
                                    <small>Potongan/Pembebasan</small>
                                    <strong>${formatRupiah(reduction)}</strong>
                                </div>
                                <div>
                                    <small>Nominal Akhir</small>
                                    <strong>${formatRupiah(item.nominal_tagihan)}</strong>
                                </div>
                                <div>
                                    <small>Sudah Dibayar</small>
                                    <strong>${formatRupiah(item.nominal_dibayar)}</strong>
                                </div>
                                <div>
                                    <small>Sisa</small>
                                    <strong class="text-danger">${formatRupiah(item.sisa_tagihan)}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
    }

    table += '</div>';

    return table;
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

function openCheckoutPayment() {
    if (!selectedStudent || !paymentCart.length) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Keranjang pembayaran masih kosong.'
        });
        return;
    }

    var invalid = paymentCart.some(function (item) {
        return Number(item.pay) <= 0 || Number(item.pay) > Number(item.balance);
    });

    if (invalid) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Nominal pembayaran harus lebih dari nol dan tidak boleh melebihi sisa tagihan.'
        });
        return;
    }

    renderCheckoutPayment();
    calculateCart();
    checkoutPaymentModal.show();
}

function renderCheckoutPayment() {
    var html = '';

    $('#checkout_siswa').text(
        selectedStudent
            ? selectedStudent.nama_lengkap + ' | NIS ' + (selectedStudent.nis || '-') + ' | ' + (selectedStudent.nama_kelas || 'Belum ditempatkan')
            : '-'
    );

    $('#checkout_jumlah').text(paymentCart.length + ' tagihan');
    $('#checkout_total').text(formatRupiah(cartTotal()));

    paymentCart.forEach(function (item) {
        html += `
            <div class="checkout-bill-item">
                <div class="d-flex justify-content-between gap-3">
                    <div class="flex-grow-1 min-w-0">
                        <strong class="d-block">${escapeHtml(item.name)}</strong>
                        <small class="text-muted d-block mt-1">${escapeHtml(item.period)}</small>
                        <small class="text-muted d-block">Sisa: ${formatRupiah(item.balance)}</small>
                    </div>

                    <div class="text-end flex-shrink-0">
                        <small class="text-muted d-block">Dibayar</small>
                        <strong class="text-success">${formatRupiah(item.pay)}</strong>
                    </div>
                </div>
            </div>
        `;
    });

    $('#checkout_daftar').html(
        html || '<div class="empty-state py-3">Belum ada tagihan dipilih.</div>'
    );
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
    $('#btn_selesaikan_pembayaran').prop('disabled', !paymentCart.length || !selectedStudent);

    if ($('#modal_checkout_pembayaran').hasClass('show')) {
        renderCheckoutPayment();
    }
}

function toggleCashFields() {
    var needsCash = String($('#id_metode option:selected').data('cash')) === 'Ya';
    $('#blok_tunai').toggleClass('d-none', !needsCash);
    if (!needsCash) setMoneyInputValue('#uang_diterima', cartTotal());
    calculateCart();
}

function savePayment(event) {
    event.preventDefault();

    var invalid = paymentCart.some(function (item) {
        return item.pay <= 0 || item.pay > item.balance;
    });

    if (invalid) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Nominal setiap tagihan harus lebih dari nol dan tidak boleh melebihi sisa.'
        });
        return;
    }

    if (!$('#id_metode').val()) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Pilih metode pembayaran.'
        });
        return;
    }

    var total = cartTotal();
    var needsCash = String($('#id_metode option:selected').data('cash')) === 'Ya';
    var moneyReceived = parseMoneyInput($('#uang_diterima').val());

    if (needsCash && moneyReceived < total) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Uang diterima minimal sama dengan total pembayaran.'
        });
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
        if (!result.isConfirmed) {
            return;
        }

        var button = $('#btn_simpan');
        var paymentSaved = false;
        var data = {
            token: $('#token_pembayaran').val(),
            id_siswa: selectedStudent.id,
            id_metode: $('#id_metode').val(),
            tanggal: $('#tanggal_pembayaran').val(),
            uang_diterima: moneyReceived,
            referensi: $('#referensi').val(),
            catatan: $('#catatan').val(),
            items: JSON.stringify(
                paymentCart.map(function (item) {
                    return {
                        id_tagihan_siswa: item.id,
                        nominal_bayar: item.pay
                    };
                })
            )
        };

        button
            .prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan');

        $.ajax({
            url: '<?= base_url('admin/transaksi/pembayaran/simpan'); ?>',
            type: 'POST',
            data: data,
            dataType: 'JSON',
            success: function (data) {
                if (data.result == 'true') {
                    paymentSaved = true;
                    lastPaymentId = Number(data.id_pembayaran);
                    lastPaymentNumber = data.no_transaksi;

                    $('#isi_berhasil').html(`
                        <div class="text-center mb-4">
                            <div class="avatar-lg rounded-circle bg-success-subtle text-success mx-auto d-flex align-items-center justify-content-center">
                                <i class="ri-check-line fs-30"></i>
                            </div>
                            <h4 class="mt-2 mb-0">${escapeHtml(data.no_transaksi)}</h4>
                        </div>
                        <div class="row g-2">
                            <div class="col-6 text-muted">Siswa</div>
                            <div class="col-6 text-end fw-semibold">${escapeHtml(selectedStudent.nama_lengkap)}</div>
                            <div class="col-6 text-muted">Total</div>
                            <div class="col-6 text-end fw-semibold">${formatRupiah(data.total)}</div>
                            <div class="col-6 text-muted">Metode</div>
                            <div class="col-6 text-end">${escapeHtml($('#id_metode option:selected').text())}</div>
                            <div class="col-6 text-muted">Diterima</div>
                            <div class="col-6 text-end">${formatRupiah(data.uang_diterima)}</div>
                            <div class="col-6 text-muted">Kembalian</div>
                            <div class="col-6 text-end">${formatRupiah(data.kembalian)}</div>
                        </div>
                    `);

                    $('#link_bukti').attr(
                        'href',
                        '<?= base_url('admin/transaksi/pembayaran/bukti/'); ?>' + lastPaymentId
                    );

                    $('#link_kartu').attr(
                        'href',
                        '<?= base_url('admin/transaksi/pembayaran/cetak_kartu/'); ?>' + lastPaymentId
                    );

                    checkoutPaymentModal.hide();

                    setTimeout(function () {
                        paymentSuccessModal.show();
                    }, 200);
                } else if (data.result == 'false') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message
                    });
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function () {
                if (paymentSaved) {
                    button
                        .prop('disabled', true)
                        .html('<i class="ri-check-line me-1"></i>Pembayaran Tersimpan');
                } else {
                    button
                        .prop('disabled', false)
                        .html('<i class="ri-save-line me-1"></i>Simpan Pembayaran');
                }
            }
        });
    });
}

function showTransactionDetail() {
    if (!lastPaymentId) {
        return;
    }

    $.ajax({
        url: '<?= base_url('admin/transaksi/pembayaran/detail'); ?>',
        type: 'POST',
        data: {
            id: lastPaymentId
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.result == 'true') {
                var header = data.header;
                var table = `
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <small class="text-muted">Nomor</small>
                            <div class="fw-semibold">${escapeHtml(header.no_transaksi)}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Status</small>
                            <div>
                                <span class="badge bg-success-subtle text-success">
                                    ${escapeHtml(header.status_transaksi)}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Siswa</small>
                            <div>${escapeHtml(header.nama_siswa)}</div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Kelas</small>
                            <div>${escapeHtml(header.nama_kelas || '-')}</div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Tagihan</th>
                                    <th class="text-end">Dibayar</th>
                                    <th class="text-end">Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                data.detail.forEach(function (item) {
                    table += `
                        <tr>
                            <td>${escapeHtml(item.nama_tagihan)}</td>
                            <td class="text-end">${formatRupiah(item.nominal_bayar)}</td>
                            <td class="text-end">${formatRupiah(item.sisa_setelah)}</td>
                        </tr>
                    `;
                });

                table += `
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th class="text-end">${formatRupiah(header.total_pembayaran)}</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                `;

                $('#isi_detail_transaksi').html(table);
                transactionDetailModal.show();
            } else if (data.result == 'false') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message
                });
            }
        },
        error: function (xhr, status, error) {
            ajaxError(xhr);
        }
    });
}

function openWhatsapp() {
    if (!selectedStudent || !lastPaymentId) return;
    $('#label_wa_ayah').text('Ayah - ' + (selectedStudent.telepon_ayah || 'Tidak tersedia'));
    $('#label_wa_ibu').text('Ibu - ' + (selectedStudent.telepon_ibu || 'Tidak tersedia'));
    $('#wa_pesan').val('');
    $('#wa_template_info').text('Memuat template...');
    $('#wa_bukti_link').attr('href', '<?= base_url('admin/transaksi/pembayaran/bukti/'); ?>' + lastPaymentId);
    waPesanEdited = false;

    if (selectedStudent.telepon_ayah) $('#wa_ayah').prop('checked', true);
    else if (selectedStudent.telepon_ibu) $('#wa_ibu').prop('checked', true);
    else $('#wa_lain').prop('checked', true);

    applyWhatsappRecipient();
    whatsappModal.show();
    loadWhatsappTemplate(true);
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

function loadWhatsappTemplate(force) {
    if (!lastPaymentId) return;
    if (!force && waPesanEdited) return;

    var button = $('#btn_muat_template_wa');
    button.prop('disabled', true);
    $('#wa_template_info').text('Memuat template...');

    $.ajax({
        url: '<?= base_url('admin/transaksi/pembayaran/preview_whatsapp'); ?>',
        type: 'POST',
        data: {
            id: lastPaymentId,
            nama_penerima: $('#wa_nama').val()
        },
        dataType: 'JSON',
        success: function (data) {
            if (data.result == 'true') {
                $('#wa_pesan').val(data.pesan || '');
                $('#wa_template_info').text('Template: ' + (data.nama_template || 'Default'));
                waPesanEdited = false;
            } else {
                $('#wa_template_info').text(data.message || 'Template tidak dapat dimuat.');
            }
        },
        error: function (xhr, status, error) {
            $('#wa_template_info').text('Template tidak dapat dimuat.');
            ajaxError(xhr);
        },
        complete: function () {
            button.prop('disabled', false);
        }
    });
}

function sendWhatsapp() {
    var phone = $.trim($('#wa_nomor').val());

    if (!phone) {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian',
            text: 'Nomor WhatsApp wajib diisi.'
        });
        return;
    }

    var button = $('#btn_kirim_wa');
    var data = {
        id: lastPaymentId,
        hubungan: $('input[name="tujuan_wa"]:checked').val(),
        nama_penerima: $('#wa_nama').val(),
        nomor: phone,
        pesan: $('#wa_pesan').val()
    };

    button
        .prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm me-1"></span>Menyiapkan');

    $.ajax({
        url: '<?= base_url('admin/transaksi/pembayaran/siapkan_whatsapp'); ?>',
        type: 'POST',
        data: data,
        dataType: 'JSON',
        success: function (data) {
            if (data.result == 'true') {
                whatsappModal.hide();
                window.open(data.url, '_blank');
            } else if (data.result == 'false') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message
                });
            }
        },
        error: function (xhr, status, error) {
            ajaxError(xhr);
        },
        complete: function () {
            button
                .prop('disabled', false)
                .html('<i class="ri-whatsapp-line me-1"></i>Buka WhatsApp');
        }
    });
}
</script>