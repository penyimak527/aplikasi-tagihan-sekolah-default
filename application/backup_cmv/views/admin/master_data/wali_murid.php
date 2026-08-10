<style>
    .wali-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .35rem 1.25rem;
        margin-top: .5rem;
    }

    .wali-meta-grid .meta-item {
        min-width: 0;
        color: var(--bs-secondary-color);
        font-size: .875rem;
    }

    .wali-meta-grid .meta-item strong {
        color: var(--bs-body-color);
        font-weight: 600;
    }

    .selected-student,
    .relation-item,
    .student-picker-item {
        border: 1px solid var(--bs-border-color);
        border-radius: .5rem;
        padding: .85rem 1rem;
        background: var(--bs-body-bg);
    }

    .selected-student+.selected-student,
    .relation-item+.relation-item,
    .student-picker-item+.student-picker-item {
        margin-top: .65rem;
    }

    .selected-student-main,
    .relation-main,
    .student-picker-main {
        min-width: 0;
    }

    .selected-student-title,
    .relation-title,
    .student-picker-title {
        font-weight: 600;
        color: var(--bs-heading-color);
    }

    .selected-student-meta,
    .relation-meta,
    .student-picker-meta {
        font-size: .85rem;
        color: var(--bs-secondary-color);
        margin-top: .15rem;
    }

    .credential-box {
        text-align: left;
        border: 1px dashed var(--bs-border-color);
        border-radius: .5rem;
        padding: .85rem 1rem;
        background: var(--bs-tertiary-bg);
    }

    .credential-box code {
        font-size: 1rem;
        color: inherit;
        word-break: break-all;
    }

    @media (max-width: 767.98px) {
        .wali-meta-grid {
            grid-template-columns: 1fr;
        }

        .crud-actions .btn {
            flex: 1 1 auto;
        }
    }
</style>

<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Wali Murid</h4>
        <button type="button" class="btn btn-outline-primary" id="btn_tambah_wali">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-7">
                <label for="search_wali" class="form-label">Pencarian</label>
                <input type="text" id="search_wali" class="form-control"
                    placeholder="Cari nama, username, telepon, nama/NIS/NISN siswa ...">
            </div>
            <div class="col-md-3">
                <label for="filter_status_wali" class="form-label">Status</label>
                <select id="filter_status_wali" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn_cari_wali">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>

        <div id="data_wali" class="crud-list">
            <div class="empty-state">Memuat data wali murid...</div>
        </div>

        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-center align-items-md-center flex-wrap gap-2 mt-3">
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

<!-- Tambah akun -->
<div class="modal fade" id="modalTambahWali" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Wali Murid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form_tambah_wali">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="tambah_nama_wali">Nama Wali <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tambah_nama_wali" name="nama_wali" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tambah_no_telepon">Nomor Telepon</label>
                            <input type="text" class="form-control" id="tambah_no_telepon" name="no_telepon"
                                placeholder="Contoh: 08123456789">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tambah_email">Email</label>
                            <input type="email" class="form-control" id="tambah_email" name="email"
                                placeholder="Contoh: wali@email.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tambah_status">Status</label>
                            <select class="form-select" id="tambah_status" name="status">
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tambah_username">Username <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="tambah_username" name="username"
                                    autocomplete="off" required>
                                <button type="button" class="btn btn-outline-primary"
                                    id="btn_generate_username">Generate Username</button>
                            </div>
                            <small class="text-muted">Huruf kecil; boleh menggunakan titik, underscore, atau tanda
                                minus.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tambah_password">Password Awal <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="tambah_password" name="password"
                                    autocomplete="new-password" required>
                                <button type="button" class="btn btn-outline-secondary btn-toggle-password"
                                    data-target="#tambah_password" title="Tampilkan/Sembunyikan"><i
                                        class="ri-eye-line"></i></button>
                                <button type="button" class="btn btn-outline-primary"
                                    id="btn_generate_password">Generate Password</button>
                            </div>
                            <small class="text-muted">Minimal 8 karakter serta mengandung huruf besar, huruf kecil, dan
                                angka.</small>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="mb-1">Siswa Terhubung</h5>
                            <div class="text-muted small">Satu akun wali dapat dihubungkan ke satu atau beberapa siswa. Disarankan minimal satu siswa dipilih sebelum akun diberikan kepada wali.
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary" id="btn_pilih_siswa_tambah">
                            <i class="ri-user-add-line me-1"></i>Pilih Siswa
                        </button>
                    </div>
                    <div id="siswa_terpilih_tambah">
                        <div class="empty-state">Belum ada siswa yang dipilih.</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_simpan_wali">Simpan Akun</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit akun tanpa password -->
<div class="modal fade" id="modalEditWali" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Wali Murid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form_edit_wali">
                    <input type="hidden" name="id" id="edit_id_wali">
                    <div class="mb-3">
                        <label class="form-label" for="edit_nama_wali">Nama Wali <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_wali" name="nama_wali" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_no_telepon">Nomor Telepon</label>
                        <input type="text" class="form-control" id="edit_no_telepon" name="no_telepon">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_username">Username <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_username" name="username" required>
                        <small class="text-muted">Username akan dicek unik terhadap akun wali murid lainnya.</small>
                    </div>
                    <div>
                        <label class="form-label" for="edit_status_wali">Status</label>
                        <select class="form-select" id="edit_status_wali" name="status">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                        <small class="text-muted d-block mt-2">Password tidak diubah melalui form ini.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_update_wali">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail akun dan relasi -->
<div class="modal fade" id="modalDetailWali" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Wali Murid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body" id="detail_wali_content">
                <div class="empty-state">Memuat detail wali murid...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Pilih siswa -->
<div class="modal fade" id="modalPilihSiswa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2 align-items-end mb-3">
                    <div class="col-md-3">
                        <label class="form-label" for="picker_periode">Tahun Ajaran</label>
                        <select class="form-select" id="picker_periode">
                            <option value="">Semua Tahun Ajaran</option>
                            <?php foreach ($periode as $p): ?>
                                <option value="<?= (int) $p['id'] ?>" <?= $p['status'] === 'Aktif' ? 'selected' : '' ?>>
                                    <?= html_escape($p['periode']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label" for="picker_kelas">Kelas</label>
                        <select class="form-select" id="picker_kelas">
                            <option value="">Semua Kelas</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="picker_search">Pencarian</label>
                        <input type="text" class="form-control" id="picker_search"
                            placeholder="Cari nama / NIS / NISN ...">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="button" class="btn btn-primary" id="btn_cari_siswa_picker"><i
                                class="ri-search-line me-1"></i>Cari</button>
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
                    <div>
                        <label for="picker_hubungan" class="form-label mb-1">Hubungan default</label>
                        <select id="picker_hubungan" class="form-select form-select-sm" style="min-width: 160px;">
                            <option value="Ayah" selected>Ayah</option>
                            <option value="Ibu">Ibu</option>
                            <option value="Wali">Wali</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="text-muted small">Centang satu atau beberapa siswa lalu klik Tambahkan.</div>
                </div>

                <div id="data_siswa_picker">
                    <div class="empty-state">Memuat data siswa...</div>
                </div>

                <div
                    class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3">
                    <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination_siswa"></ul>
                    <div class="d-flex align-items-center gap-2">
                        <label for="dt-length-siswa" class="mb-0">Tampilkan</label>
                        <select class="form-select form-select-sm" id="dt-length-siswa">
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
                <button type="button" class="btn btn-primary" id="btn_tambahkan_siswa">Tambahkan</button>
            </div>
        </div>
    </div>
</div>

<!-- Ubah hubungan relasi -->
<div class="modal fade" id="modalRelasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Hubungan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="relasi_id">
                <div class="mb-3">
                    <div class="text-muted small">Siswa</div>
                    <div class="fw-semibold" id="relasi_nama_siswa">-</div>
                </div>
                <div>
                    <label class="form-label" for="relasi_hubungan">Hubungan</label>
                    <select class="form-select" id="relasi_hubungan">
                        <option value="Ayah">Ayah</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Wali">Wali</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_simpan_relasi">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- Reset password -->
<div class="modal fade" id="modalResetPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reset_title">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="reset_id_wali">
                <div class="mb-3">
                    <div class="text-muted small">Username</div>
                    <div class="fw-semibold" id="reset_username">-</div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="reset_password">Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="reset_password" autocomplete="new-password">
                        <button type="button" class="btn btn-outline-secondary btn-toggle-password"
                            data-target="#reset_password" title="Tampilkan/Sembunyikan"><i
                                class="ri-eye-line"></i></button>
                        <button type="button" class="btn btn-outline-primary" id="btn_generate_reset_password">Generate
                            Password</button>
                    </div>
                    <small class="text-muted">Password lama tidak dapat dilihat kembali.</small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Ya" id="reset_wajib_ganti" checked>
                    <label class="form-check-label" for="reset_wajib_ganti">Wajibkan ganti password saat login
                        berikutnya</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-warning" id="btn_reset_password">Reset</button>
            </div>
        </div>
    </div>
</div>

<script>
    var modalTambahWali = null;
    var modalEditWali = null;
    var modalDetailWali = null;
    var modalPilihSiswa = null;
    var modalRelasi = null;
    var modalResetPassword = null;
    var waliRows = [];
    var pickerRows = [];
    var selectedCreate = [];
    var currentDetailId = 0;
    var currentDetailData = null;
    var pickerContext = 'create';
    var pickerReturnModal = '';
    var editReturnDetail = false;
    var resetReturnDetail = false;
    var relasiReturnDetail = false;

    $(document).ready(function () {
        modalTambahWali = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalTambahWali'));
        modalEditWali = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEditWali'));
        modalDetailWali = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalDetailWali'));
        modalPilihSiswa = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPilihSiswa'));
        modalRelasi = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalRelasi'));
        modalResetPassword = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalResetPassword'));

        loadWaliData();

        $('#btn_tambah_wali').on('click', openTambahWali);
        $('#btn_cari_wali').on('click', loadWaliData);
        $('#filter_status_wali').on('change', loadWaliData);
        $('#search_wali').on('keyup', function (event) {
            if (event.key === 'Enter') loadWaliData();
        });
        $('#dt-length-0').on('change', refreshWaliPagination);

        $('#btn_generate_username').on('click', generateUsername);
        $('#btn_generate_password').on('click', function () { generatePassword('#tambah_password'); });
        $('#btn_generate_reset_password').on('click', function () { generatePassword('#reset_password'); });
        $('#btn_simpan_wali').on('click', simpanWali);
        $('#btn_update_wali').on('click', updateWali);
        $('#btn_reset_password').on('click', resetPassword);
        $('#btn_simpan_relasi').on('click', simpanPerubahanRelasi);

        $('#btn_pilih_siswa_tambah').on('click', function () {
            openStudentPicker('create');
        });
        $('#picker_periode').on('change', function () {
            loadPickerClasses(true);
        });
        $('#picker_kelas').on('change', loadPickerStudents);
        $('#btn_cari_siswa_picker').on('click', loadPickerStudents);
        $('#picker_search').on('keyup', function (event) {
            if (event.key === 'Enter') loadPickerStudents();
        });
        $('#dt-length-siswa').on('change', refreshPickerPagination);
        $('#btn_tambahkan_siswa').on('click', addSelectedStudents);

        $(document).on('click', '.btn-toggle-password', function () {
            var target = $($(this).data('target'));
            var show = target.attr('type') === 'password';
            target.attr('type', show ? 'text' : 'password');
            $(this).find('i').attr('class', show ? 'ri-eye-off-line' : 'ri-eye-line');
        });

        $(document).on('change', '.selected-hubungan', function () {
            var id = Number($(this).data('id'));
            var row = selectedCreate.find(function (item) { return Number(item.id_siswa) === id; });
            if (row) row.hubungan = $(this).val();
        });

        $(document).on('click', '.btn-remove-selected-student', function () {
            var id = Number($(this).data('id'));
            selectedCreate = selectedCreate.filter(function (item) { return Number(item.id_siswa) !== id; });
            renderSelectedCreate();
        });

        $('#modalPilihSiswa').on('hidden.bs.modal', function () {
            if (pickerReturnModal === 'create') {
                pickerReturnModal = '';
                setTimeout(function () { modalTambahWali.show(); }, 120);
            } else if (pickerReturnModal === 'detail') {
                pickerReturnModal = '';
                setTimeout(function () { detailWali(currentDetailId); }, 120);
            }
        });

        $('#modalEditWali').on('hidden.bs.modal', function () {
            if (editReturnDetail) {
                editReturnDetail = false;
                setTimeout(function () { detailWali(currentDetailId); }, 120);
            }
        });

        $('#modalResetPassword').on('hidden.bs.modal', function () {
            if (resetReturnDetail) {
                resetReturnDetail = false;
                setTimeout(function () { detailWali(currentDetailId); }, 120);
            }
        });

        $('#modalRelasi').on('hidden.bs.modal', function () {
            if (relasiReturnDetail) {
                relasiReturnDetail = false;
                setTimeout(function () { detailWali(currentDetailId); }, 120);
            }
        });
    });

    function loadWaliData() {
        $('#data_wali').html('<div class="empty-state">Memuat data wali murid...</div>');

        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/result') ?>',
            type: 'POST',
            data: {
                search: $('#search_wali').val(),
                status: $('#filter_status_wali').val()
            },
            dataType: 'JSON',
            success: function (rows) {
                waliRows = rows || [];
                if (!waliRows.length) {
                    $('#data_wali').html('<div class="empty-state"><div class="empty-state-title">Data wali murid tidak ditemukan</div><div>Gunakan kata kunci atau filter status lain.</div></div>');
                    refreshWaliPagination();
                    return;
                }

                var html = waliRows.map(function (row, index) {
                    var aktif = row.status === 'Aktif';
                    var login = lastLoginText(row);
                    return '<div class="crud-list-item">' +
                        '<div class="crud-content">' +
                        '<div class="crud-status">Status: <span class="badge ' + (aktif ? 'bg-success' : 'bg-danger') + '">' + escapeHtml(row.status) + '</span></div>' +
                        '<div class="crud-title">' + (index + 1) + '. ' + escapeHtml(row.nama_wali || '-') + '</div>' +
                        '<div class="wali-meta-grid">' +
                        '<div class="meta-item"><strong>Username:</strong> ' + escapeHtml(row.username || '-') + '</div>' +
                        '<div class="meta-item"><strong>Telepon:</strong> ' + escapeHtml(row.no_telepon || '-') + '</div>' +
                        '<div class="meta-item"><strong>Anak:</strong> ' + Number(row.jumlah_siswa || 0).toLocaleString('id-ID') + ' siswa</div>' +
                        '<div class="meta-item"><strong>Login Terakhir:</strong> ' + escapeHtml(login) + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="crud-actions">' +
                        '<button type="button" class="btn btn-sm btn-outline-primary" onclick="detailWali(' + row.id + ')"><i class="ri-eye-line me-1"></i>Detail</button>' +
                        '<button type="button" class="btn btn-sm btn-outline-warning" onclick="openEditWali(' + row.id + ')"><i class="ri-edit-line me-1"></i>Edit</button>' +
                        (aktif ? '<button type="button" class="btn btn-sm btn-outline-secondary" onclick="openResetPassword(' + row.id + ')"><i class="ri-key-2-line me-1"></i>Reset Password</button>' : '') +
                        '<button type="button" class="btn btn-sm ' + (aktif ? 'btn-outline-danger' : 'btn-outline-primary') + '" onclick="ubahStatusWali(' + row.id + ', \'' + (aktif ? 'Tidak Aktif' : 'Aktif') + '\')">' +
                        '<i class="' + (aktif ? 'ri-close-circle-line' : 'ri-check-line') + ' me-1"></i>' + (aktif ? 'Nonaktifkan' : 'Aktifkan') +
                        '</button>' +
                        '</div>' +
                        '</div>';
                }).join('');

                $('#data_wali').html(html);
                refreshWaliPagination();
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function refreshWaliPagination() {
        paging($('#data_wali .crud-list-item'), parseInt($('#dt-length-0').val(), 10) || 10, '#pagination');
    }

    function openTambahWali() {
        $('#form_tambah_wali')[0].reset();
        $('#tambah_status').val('Aktif');
        $('#tambah_password').attr('type', 'password');
        selectedCreate = [];
        renderSelectedCreate();
        modalTambahWali.show();
    }

    function generateUsername() {
        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/generate_username') ?>',
            type: 'POST',
            data: { nama_wali: $('#tambah_nama_wali').val() },
            dataType: 'JSON',
            success: function (response) {
                if (response.result === 'true') {
                    $('#tambah_username').val(response.username);
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function generatePassword(target) {
        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/generate_password') ?>',
            type: 'POST',
            data: {},
            dataType: 'JSON',
            success: function (response) {
                if (response.result === 'true') {
                    $(target).val(response.password).attr('type', 'text');
                    return;
                }
                Swal.fire('Gagal', response.message, 'error');
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function simpanWali() {
        var button = $('#btn_simpan_wali');
        var formData = $('#form_tambah_wali').serializeArray();
        formData.push({
            name: 'siswa_json', value: JSON.stringify(selectedCreate.map(function (item) {
                return { id_siswa: item.id_siswa, hubungan: item.hubungan };
            }))
        });

        button.prop('disabled', true);
        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/simpan') ?>',
            type: 'POST',
            data: $.param(formData),
            dataType: 'JSON',
            success: function (response) {
                if (response.result !== 'true') {
                    Swal.fire('Gagal', response.message, 'error');
                    return;
                }

                modalTambahWali.hide();
                loadWaliData();
                if (response.credential) {
                    showCredential('Akun Wali Murid Berhasil Dibuat', response.credential.username, response.credential.password);
                } else {
                    Swal.fire('Berhasil', response.message, 'success');
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    }

    function openEditWali(id) {
        var fromDetail = $('#modalDetailWali').hasClass('show');
        editReturnDetail = fromDetail;
        if (fromDetail) modalDetailWali.hide();

        getWaliDetail(id, function (response) {
            var row = response.data;
            $('#form_edit_wali')[0].reset();
            $('#edit_id_wali').val(row.id);
            $('#edit_nama_wali').val(row.nama_wali || '');
            $('#edit_no_telepon').val(row.no_telepon || '');
            $('#edit_email').val(row.email || '');
            $('#edit_username').val(row.username || '');
            $('#edit_status_wali').val(row.status || 'Aktif');
            setTimeout(function () { modalEditWali.show(); }, fromDetail ? 120 : 0);
        });
    }

    function updateWali() {
        var button = $('#btn_update_wali');
        button.prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/update') ?>',
            type: 'POST',
            data: $('#form_edit_wali').serialize(),
            dataType: 'JSON',
            success: function (response) {
                var berhasil = response.result === 'true';
                Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                if (berhasil) {
                    modalEditWali.hide();
                    loadWaliData();
                    if (currentDetailId === Number($('#edit_id_wali').val())) currentDetailData = null;
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    }

    function detailWali(id) {
        currentDetailId = Number(id);
        $('#detail_wali_content').html('<div class="empty-state">Memuat detail wali murid...</div>');
        modalDetailWali.show();

        getWaliDetail(id, function (response) {
            currentDetailData = response;
            renderDetailWali(response);
        }, function () {
            $('#detail_wali_content').html('<div class="alert alert-danger">Detail wali murid gagal dimuat.</div>');
        });
    }

    function getWaliDetail(id, successCallback, failCallback) {
        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/detail') ?>',
            type: 'POST',
            data: { id: id },
            dataType: 'JSON',
            success: function (response) {
                if (response.result !== 'true') {
                    Swal.fire('Gagal', response.message, 'error');
                    if (typeof failCallback === 'function') failCallback(response);
                    return;
                }
                if (typeof successCallback === 'function') successCallback(response);
            },
            error: function (xhr, status, error) {
                if (typeof failCallback === 'function') failCallback();
                ajaxError(xhr);
            }
        });
    }

    function renderDetailWali(response) {
        var row = response.data;
        var relations = response.relasi || [];
        var aktif = row.status === 'Aktif';
        var relationHtml = relations.length ? relations.map(function (rel, index) {
            var relAktif = rel.status === 'Aktif';
            var classText = rel.nama_kelas || '-';
            if (rel.semester) classText += ' / ' + rel.semester;
            if (rel.periode) classText += ' / ' + rel.periode;
            return '<div class="relation-item">' +
                '<div class="d-flex flex-column flex-lg-row justify-content-between gap-3">' +
                '<div class="relation-main">' +
                '<div class="relation-title">' + (index + 1) + '. ' + escapeHtml(rel.nama_lengkap || '-') + ' <span class="badge ' + (relAktif ? 'bg-success' : 'bg-secondary') + ' ms-1">' + escapeHtml(rel.status) + '</span></div>' +
                '<div class="relation-meta">NIS: ' + escapeHtml(rel.nis || '-') + ' | NISN: ' + escapeHtml(rel.nisn || '-') + ' | Kelas: ' + escapeHtml(classText) + ' | Hubungan: ' + escapeHtml(rel.hubungan || '-') + '</div>' +
                '</div>' +
                '<div class="d-flex align-items-center flex-wrap gap-2">' +
                '<button type="button" class="btn btn-sm btn-outline-warning" onclick="openEditRelasi(' + rel.id + ', \'' + escapeHtml(jsEscape(rel.nama_lengkap || '-')) + '\', \'' + escapeHtml(jsEscape(rel.hubungan || 'Wali')) + '\')"><i class="ri-edit-line me-1"></i>Ubah</button>' +
                '<button type="button" class="btn btn-sm ' + (relAktif ? 'btn-outline-danger' : 'btn-outline-primary') + '" onclick="ubahStatusRelasi(' + rel.id + ', \'' + (relAktif ? 'Tidak Aktif' : 'Aktif') + '\', \'' + escapeHtml(jsEscape(rel.nama_lengkap || '-')) + '\')">' +
                '<i class="' + (relAktif ? 'ri-close-circle-line' : 'ri-check-line') + ' me-1"></i>' + (relAktif ? 'Nonaktifkan' : 'Aktifkan') +
                '</button>' +
                '</div>' +
                '</div>' +
                '</div>';
        }).join('') : '<div class="empty-state">Belum ada siswa yang terhubung dengan akun ini.</div>';

        var html = '<div class="row g-3 mb-4">' +
            infoCol('Nama', row.nama_wali || '-', 4) +
            infoCol('Username', row.username || '-', 4) +
            '<div class="col-md-4"><div class="text-muted small">Status</div><div><span class="badge ' + (aktif ? 'bg-success' : 'bg-danger') + '">' + escapeHtml(row.status) + '</span></div></div>' +
            infoCol('Telepon', row.no_telepon || '-', 4) +
            infoCol('Email', row.email || '-', 4) +
            infoCol('Login Terakhir', lastLoginText(row) + (row.last_login_ip ? ' | ' + row.last_login_ip : ''), 4) +
            '</div>' +
            '<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">' +
            '<div><h5 class="mb-1">Siswa Terhubung</h5><div class="text-muted small">Relasi tidak dihapus permanen; gunakan status Aktif/Tidak Aktif.</div></div>' +
            '<button type="button" class="btn btn-outline-primary" onclick="openStudentPicker(\'detail\')"><i class="ri-user-add-line me-1"></i>Tambah Siswa</button>' +
            '</div>' +
            relationHtml +
            '<hr class="my-4">' +
            '<div class="d-flex flex-wrap gap-2">' +
            '<button type="button" class="btn btn-warning" onclick="openEditWali(' + row.id + ')"><i class="ri-edit-line me-1"></i>Edit Akun</button>' +
            (aktif ? '<button type="button" class="btn btn-secondary" onclick="openResetPassword(' + row.id + ')"><i class="ri-key-2-line me-1"></i>Reset Password</button>' : '') +
            '<button type="button" class="btn ' + (aktif ? 'btn-danger' : 'btn-primary') + '" onclick="ubahStatusWali(' + row.id + ', \'' + (aktif ? 'Tidak Aktif' : 'Aktif') + '\')"><i class="' + (aktif ? 'ri-close-circle-line' : 'ri-check-line') + ' me-1"></i>' + (aktif ? 'Nonaktifkan Akun' : 'Aktifkan Akun') + '</button>' +
            '</div>';

        $('#detail_wali_content').html(html);
    }

    function infoCol(label, value, col) {
        return '<div class="col-md-' + col + '"><div class="text-muted small">' + escapeHtml(label) + '</div><div class="fw-semibold">' + escapeHtml(value) + '</div></div>';
    }

    function ubahStatusWali(id, target) {
        var row = waliRows.find(function (item) { return Number(item.id) === Number(id); });
        var nama = row ? row.nama_wali : (currentDetailData && Number(currentDetailData.data.id) === Number(id) ? currentDetailData.data.nama_wali : 'Akun wali murid');
        var username = row ? row.username : (currentDetailData && Number(currentDetailData.data.id) === Number(id) ? currentDetailData.data.username : '-');
        var jumlah = row ? Number(row.jumlah_siswa || 0) : (currentDetailData ? (currentDetailData.relasi || []).filter(function (item) { return item.status === 'Aktif'; }).length : 0);
        var nonaktif = target === 'Tidak Aktif';

        Swal.fire({
            title: nonaktif ? 'Nonaktifkan akun?' : 'Aktifkan akun?',
            html: '<div class="text-start">' +
                '<strong>' + escapeHtml(nama) + '</strong> - ' + escapeHtml(username) + '<br>' +
                'Anak terhubung: ' + jumlah + ' siswa<br><br>' +
                (nonaktif ? 'Setelah dinonaktifkan, akun tidak dapat login ke Portal Wali Murid. Relasi siswa dan riwayat akun tetap disimpan.' : 'Akun dapat kembali digunakan untuk login ke Portal Wali Murid.') +
                '</div>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: nonaktif ? 'Nonaktifkan' : 'Aktifkan',
            cancelButtonText: 'Batal'
        }).then(function (result) {
            if (!result.isConfirmed) return;

            $.ajax({
                url: '<?= base_url('admin/master_data/wali_murid/status') ?>',
                type: 'POST',
                data: { id: id, status: target },
                dataType: 'JSON',
                success: function (response) {
                    var berhasil = response.result === 'true';
                    Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                    if (berhasil) {
                        loadWaliData();
                        if (currentDetailId === Number(id) && $('#modalDetailWali').hasClass('show')) detailWali(id);
                    }
                },
                error: function (xhr, status, error) {
                    ajaxError(xhr);
                }
            });
        });
    }

    function openResetPassword(id) {
        var fromDetail = $('#modalDetailWali').hasClass('show');
        resetReturnDetail = fromDetail;
        if (fromDetail) modalDetailWali.hide();

        getWaliDetail(id, function (response) {
            var row = response.data;
            $('#reset_id_wali').val(row.id);
            $('#reset_username').text(row.username || '-');
            $('#reset_title').text('Reset Password - ' + (row.nama_wali || 'Wali Murid'));
            $('#reset_password').val('').attr('type', 'password');
            $('#reset_wajib_ganti').prop('checked', true);
            setTimeout(function () { modalResetPassword.show(); }, fromDetail ? 120 : 0);
        });
    }

    function resetPassword() {
        var button = $('#btn_reset_password');
        button.prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/reset_password') ?>',
            type: 'POST',
            data: {
                id: $('#reset_id_wali').val(),
                password: $('#reset_password').val(),
                wajib_ganti_password: $('#reset_wajib_ganti').is(':checked') ? 'Ya' : 'Tidak'
            },
            dataType: 'JSON',
            success: function (response) {
                if (response.result !== 'true') {
                    Swal.fire('Gagal', response.message, 'error');
                    return;
                }
                modalResetPassword.hide();
                $('#reset_password').val('');
                if (response.credential) {
                    showCredential('Password Berhasil Direset', response.credential.username, response.credential.password);
                } else {
                    Swal.fire('Berhasil', response.message, 'success');
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    }

    function showCredential(title, username, password) {
        var safeUser = escapeHtml(username || '');
        var safePass = escapeHtml(password || '');
        Swal.fire({
            title: title,
            html: '<div class="credential-box">' +
                '<div class="mb-2"><span class="text-muted">Username</span><br><code>' + safeUser + '</code></div>' +
                '<div><span class="text-muted">Password</span><br><code>' + safePass + '</code></div>' +
                '</div><div class="small text-warning mt-3">Password ini hanya ditampilkan sekarang. Jika hilang, lakukan reset password kembali.</div>',
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Salin Akun',
            cancelButtonText: 'Tutup'
        }).then(function (result) {
            if (result.isConfirmed) {
                copyAccount(username, password);
            }
        });
    }

    function copyAccount(username, password) {
        var text = 'Username: ' + username + '\nPassword: ' + password;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function () {
                Swal.fire('Tersalin', 'Username dan password berhasil disalin.', 'success');
            });
            return;
        }
        var temp = $('<textarea>').val(text).appendTo('body').select();
        document.execCommand('copy');
        temp.remove();
        Swal.fire('Tersalin', 'Username dan password berhasil disalin.', 'success');
    }

    function openStudentPicker(context) {
        pickerContext = context;
        pickerReturnModal = context === 'create' ? 'create' : 'detail';

        if (context === 'create') {
            modalTambahWali.hide();
        } else {
            modalDetailWali.hide();
        }

        setTimeout(function () {
            $('#picker_search').val('');
            $('#picker_kelas').html('<option value="">Semua Kelas</option>');
            $('#picker_hubungan').val('Ayah');
            loadPickerClasses(true);
            modalPilihSiswa.show();
        }, 160);
    }

    function loadPickerClasses(loadStudentsAfter) {
        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/kelas_result') ?>',
            type: 'POST',
            data: { id_periode: $('#picker_periode').val() },
            dataType: 'JSON',
            success: function (rows) {
                var html = '<option value="">Semua Kelas</option>';
                (rows || []).forEach(function (row) {
                    html += '<option value="' + row.id + '">' + escapeHtml(row.nama_kelas || '-') + '</option>';
                });
                $('#picker_kelas').html(html);
                if (loadStudentsAfter) loadPickerStudents();
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function loadPickerStudents() {
        $('#data_siswa_picker').html('<div class="empty-state">Memuat data siswa...</div>');
        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/siswa_result') ?>',
            type: 'POST',
            data: {
                search: $('#picker_search').val(),
                id_periode: $('#picker_periode').val(),
                id_kelas: $('#picker_kelas').val(),
                id_wali_murid: pickerContext === 'detail' ? currentDetailId : 0
            },
            dataType: 'JSON',
            success: function (rows) {
                pickerRows = rows || [];
                if (!pickerRows.length) {
                    $('#data_siswa_picker').html('<div class="empty-state">Tidak ada siswa pada filter yang dipilih.</div>');
                    refreshPickerPagination();
                    return;
                }

                var selectedIds = selectedCreate.map(function (item) { return Number(item.id_siswa); });
                var html = pickerRows.map(function (row) {
                    var checked = pickerContext === 'create' && selectedIds.indexOf(Number(row.id)) !== -1;
                    var kelas = row.nama_kelas || '-';
                    if (row.semester) kelas += ' / ' + row.semester;
                    if (row.periode) kelas += ' / ' + row.periode;
                    return '<label class="student-picker-item d-flex align-items-start gap-3 cursor-pointer">' +
                        '<div class="pt-1"><input type="checkbox" class="form-check-input picker-siswa-check" value="' + row.id + '" ' + (checked ? 'checked' : '') + '></div>' +
                        '<div class="student-picker-main flex-grow-1">' +
                        '<div class="student-picker-title">' + escapeHtml(row.nama_lengkap || '-') + '</div>' +
                        '<div class="student-picker-meta">NIS: ' + escapeHtml(row.nis || '-') + ' | NISN: ' + escapeHtml(row.nisn || '-') + ' | Kelas: ' + escapeHtml(kelas) + '</div>' +
                        '</div>' +
                        '</label>';
                }).join('');
                $('#data_siswa_picker').html(html);
                refreshPickerPagination();
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function refreshPickerPagination() {
        paging($('#data_siswa_picker .student-picker-item'), parseInt($('#dt-length-siswa').val(), 10) || 10, '#pagination_siswa');
    }

    function addSelectedStudents() {
        var ids = $('.picker-siswa-check:checked').map(function () { return Number(this.value); }).get();
        if (!ids.length) {
            Swal.fire('Pilih Siswa', 'Pilih minimal satu siswa yang akan dihubungkan.', 'warning');
            return;
        }

        var hubungan = $('#picker_hubungan').val() || 'Ayah';
        if (pickerContext === 'create') {
            ids.forEach(function (id) {
                var row = pickerRows.find(function (item) { return Number(item.id) === Number(id); });
                if (!row) return;
                var existing = selectedCreate.find(function (item) { return Number(item.id_siswa) === Number(id); });
                if (!existing) {
                    selectedCreate.push({
                        id_siswa: Number(row.id),
                        nama_lengkap: row.nama_lengkap || '-',
                        nis: row.nis || '-',
                        nisn: row.nisn || '-',
                        nama_kelas: row.nama_kelas || '-',
                        periode: row.periode || '',
                        semester: row.semester || '',
                        hubungan: hubungan
                    });
                }
            });
            renderSelectedCreate();
            modalPilihSiswa.hide();
            return;
        }

        var payload = ids.map(function (id) {
            return { id_siswa: id, hubungan: hubungan };
        });

        $('#btn_tambahkan_siswa').prop('disabled', true);
        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/tambah_relasi') ?>',
            type: 'POST',
            data: {
                id_wali_murid: currentDetailId,
                siswa_json: JSON.stringify(payload)
            },
            dataType: 'JSON',
            success: function (response) {
                var berhasil = response.result === 'true';
                if (!berhasil) {
                    Swal.fire('Gagal', response.message, 'error');
                    return;
                }
                loadWaliData();
                modalPilihSiswa.hide();
                Swal.fire('Berhasil', response.message, 'success');
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function () {
                $('#btn_tambahkan_siswa').prop('disabled', false);
            }
        });
    }

    function renderSelectedCreate() {
        if (!selectedCreate.length) {
            $('#siswa_terpilih_tambah').html('<div class="empty-state">Belum ada siswa yang dipilih.</div>');
            return;
        }

        var html = selectedCreate.map(function (row, index) {
            var kelas = row.nama_kelas || '-';
            if (row.semester) kelas += ' / ' + row.semester;
            if (row.periode) kelas += ' / ' + row.periode;
            return '<div class="selected-student">' +
                '<div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">' +
                '<div class="selected-student-main">' +
                '<div class="selected-student-title">' + (index + 1) + '. ' + escapeHtml(row.nama_lengkap) + '</div>' +
                '<div class="selected-student-meta">NISN: ' + escapeHtml(row.nisn || '-') + ' | Kelas: ' + escapeHtml(kelas) + '</div>' +
                '</div>' +
                '<div class="d-flex align-items-center gap-2">' +
                '<select class="form-select form-select-sm selected-hubungan" data-id="' + row.id_siswa + '">' + hubunganOptions(row.hubungan) + '</select>' +
                '<button type="button" class="btn btn-sm btn-outline-danger btn-remove-selected-student" data-id="' + row.id_siswa + '" title="Hapus pilihan"><i class="ri-close-line"></i></button>' +
                '</div>' +
                '</div>' +
                '</div>';
        }).join('');
        $('#siswa_terpilih_tambah').html(html);
    }

    function hubunganOptions(selected) {
        return ['Ayah', 'Ibu', 'Wali', 'Lainnya'].map(function (value) {
            return '<option value="' + value + '" ' + (value === selected ? 'selected' : '') + '>' + value + '</option>';
        }).join('');
    }

    function openEditRelasi(id, nama, hubungan) {
        relasiReturnDetail = $('#modalDetailWali').hasClass('show');
        if (relasiReturnDetail) modalDetailWali.hide();
        $('#relasi_id').val(id);
        $('#relasi_nama_siswa').text(nama || '-');
        $('#relasi_hubungan').val(hubungan || 'Wali');
        setTimeout(function () { modalRelasi.show(); }, relasiReturnDetail ? 120 : 0);
    }

    function simpanPerubahanRelasi() {
        var button = $('#btn_simpan_relasi');
        button.prop('disabled', true);
        $.ajax({
            url: '<?= base_url('admin/master_data/wali_murid/ubah_relasi') ?>',
            type: 'POST',
            data: {
                id: $('#relasi_id').val(),
                hubungan: $('#relasi_hubungan').val()
            },
            dataType: 'JSON',
            success: function (response) {
                var berhasil = response.result === 'true';
                Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                if (berhasil) {
                    modalRelasi.hide();
                    loadWaliData();
                }
            },
            error: function (xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function () {
                button.prop('disabled', false);
            }
        });
    }

    function ubahStatusRelasi(id, target, namaSiswa) {
        var nonaktif = target === 'Tidak Aktif';
        confirmAction(
            (nonaktif ? 'Nonaktifkan' : 'Aktifkan') + ' relasi siswa?',
            (namaSiswa || 'Siswa') + (nonaktif ? ' akan hilang dari akses portal wali, tetapi riwayat relasi tetap disimpan.' : ' akan kembali dapat diakses oleh akun wali.'),
            function () {
                $.ajax({
                    url: '<?= base_url('admin/master_data/wali_murid/status_relasi') ?>',
                    type: 'POST',
                    data: { id: id, status: target },
                    dataType: 'JSON',
                    success: function (response) {
                        var berhasil = response.result === 'true';
                        Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
                        if (berhasil) {
                            loadWaliData();
                            detailWali(currentDetailId);
                        }
                    },
                    error: function (xhr, status, error) {
                        ajaxError(xhr);
                    }
                });
            }
        );
    }

    function lastLoginText(row) {
        if (!row || !row.last_login_tanggal) return 'Belum pernah login';
        return (row.last_login_tanggal || '-') + (row.last_login_waktu ? ' ' + row.last_login_waktu : '');
    }

    function jsEscape(value) {
        return String(value == null ? '' : value)
            .replace(/\\/g, '\\\\')
            .replace(/'/g, "\\'")
            .replace(/\r/g, '')
            .replace(/\n/g, ' ');
    }
</script>