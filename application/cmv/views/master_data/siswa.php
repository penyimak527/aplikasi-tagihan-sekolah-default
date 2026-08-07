<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Siswa</h4>
        <button type="button" class="btn btn-outline-primary" onclick="openForm()">
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
                        <option value="<?= $row['id'] ?>" data-periode="<?= $row['id_periode'] ?>"><?= html_escape($row['nama_kelas'] . ' - ' . $row['semester']) ?></option>
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
                <button type="button" class="btn btn-primary" onclick="loadData()">
                    <i class="ri-search-line me-1"></i>Cari
                </button>
            </div>
        </div>
        <div id="data" class="crud-list"></div>
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

<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Tambah Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" name="id">
                    <ul class="nav nav-tabs nav-bordered mb-4" role="tablist">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tabIdentitas">Identitas</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabAlamat">Alamat</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabAyah">Data Ayah</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tabIbu">Data Ibu</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="tabIdentitas">
                            <div class="row">
                                <div class="col-md-4 mb-3"><label class="form-label">NIS</label><input name="nis" class="form-control" placeholder="NIS ..." required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">NISN</label><input name="nisn" class="form-control" placeholder="NISN ..." required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Status</label><select name="status_pendaftaran" class="form-select"><option>Aktif</option><option>Lulus</option><option>Pindah Sekolah</option><option>Berhenti</option><option>Nonaktif</option></select></div>
                                <div class="col-md-8 mb-3"><label class="form-label">Nama Lengkap</label><input name="nama_lengkap" class="form-control" placeholder="Nama lengkap ..." required></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Jenis Kelamin</label><select name="jk" class="form-select"><option value="Laki-laki">Laki-laki</option><option value="Perempuan">Perempuan</option></select></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tempat Lahir</label><input name="tempat_lahir" class="form-control" placeholder="Tempat lahir ..."></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tanggal Lahir</label><input name="tanggal_lahir" class="form-control tanggal" placeholder="dd-mm-yyyy"></div>
                                <div class="col-md-4 mb-3"><label class="form-label">Tanggal Awal Masuk</label><input name="tanggal_awal_masuk" class="form-control tanggal" placeholder="dd-mm-yyyy"></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabAlamat">
                            <label class="form-label">Alamat Siswa</label>
                            <textarea name="alamat_siswa" class="form-control" rows="5" placeholder="Alamat siswa ..."></textarea>
                        </div>
                        <div class="tab-pane" id="tabAyah">
                            <div class="row">
                                <div class="col-md-6 mb-3"><label class="form-label">Nama Ayah</label><input name="nama_ayah" class="form-control" placeholder="Nama ayah ..."></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Pekerjaan Ayah</label><input name="pekerjaan_ayah" class="form-control" placeholder="Pekerjaan ayah ..."></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Telepon Ayah</label><input name="telepon_ayah" class="form-control" placeholder="Nomor telepon ayah ..."></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Alamat Ayah</label><textarea name="alamat_ayah" class="form-control" placeholder="Alamat ayah ..."></textarea></div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tabIbu">
                            <div class="row">
                                <div class="col-md-6 mb-3"><label class="form-label">Nama Ibu</label><input name="nama_ibu" class="form-control" placeholder="Nama ibu ..."></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Pekerjaan Ibu</label><input name="pekerjaan_ibu" class="form-control" placeholder="Pekerjaan ibu ..."></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Telepon Ibu</label><input name="telepon_ibu" class="form-control" placeholder="Nomor telepon ibu ..."></div>
                                <div class="col-md-6 mb-3"><label class="form-label">Alamat Ibu</label><textarea name="alamat_ibu" class="form-control" placeholder="Alamat ibu ..."></textarea></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btn_simpan" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
let modalForm;

$(document).ready(function () {
    modalForm = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalForm'));
    flatpickr('.tanggal', {dateFormat: 'd-m-Y'});
    loadData();

    $('#periode_filter').on('change', function () {
        filterKelas();
        loadData();
    });
    $('#kelas_filter, #status_filter').on('change', loadData);
    $('#search').on('keyup', function (event) {
        if (event.key === 'Enter') loadData();
    });
    $('#btn_simpan').on('click', saveData);
    $('#dt-length-0').on('change', refreshPagination);
});

function filterKelas() {
    const periode = $('#periode_filter').val();
    $('#kelas_filter option').each(function () {
        const optionPeriode = $(this).data('periode');
        $(this).toggle(!optionPeriode || periode === '0' || String(optionPeriode) === String(periode));
    });
    $('#kelas_filter').val('0');
}

function loadData() {
    $.post('<?= base_url('master_data/siswa/result') ?>', {
        search: $('#search').val(),
        id_periode: $('#periode_filter').val(),
        id_kelas_setting: $('#kelas_filter').val(),
        status: $('#status_filter').val()
    }, function (rows) {
        if (!rows.length) {
            $('#data').html('<div class="empty-state">Data siswa tidak ditemukan.</div>');
            refreshPagination();
            return;
        }

        const html = rows.map(function (row, index) {
            const aktif = row.status_pendaftaran === 'Aktif';
            return `
                <div class="crud-list-item">
                    <div class="crud-content">
                        <div class="crud-status">Status: <span class="badge ${aktif ? 'bg-success' : 'bg-secondary'}">${escapeHtml(row.status_pendaftaran)}</span></div>
                        <div class="crud-title">${index + 1}. ${escapeHtml(row.nama_lengkap)}</div>
                        <div class="crud-meta">NIS: ${escapeHtml(row.nis)} | NISN: ${escapeHtml(row.nisn)} | ${escapeHtml(row.jk || '-')}</div>
                        <div class="crud-note">Kelas aktif: ${escapeHtml(row.nama_kelas || 'Belum ditempatkan')} | ${escapeHtml(row.periode || '-')} ${escapeHtml(row.semester || '')}</div>
                    </div>
                    <div class="crud-actions">
                        <button type="button" class="btn btn-outline-primary btn-icon" title="Detail" onclick="detail(${row.id}, false)"><i class="ri-eye-line"></i></button>
                        <button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="detail(${row.id}, true)"><i class="ri-edit-line"></i></button>
                        <a class="btn btn-outline-info btn-icon" title="Riwayat Kelas" href="<?= base_url('kesiswaan/riwayat_kelas?id_siswa=') ?>${row.id}"><i class="ri-history-line"></i></a>
                        <a class="btn btn-outline-primary btn-icon" title="Riwayat Tagihan" href="<?= base_url('tunggakan/tagihan_per_siswa?id_siswa=') ?>${row.id}"><i class="ri-file-list-3-line"></i></a>
                    </div>
                </div>`;
        }).join('');

        $('#data').html(html);
        refreshPagination();
    }, 'json').fail(ajaxError);
}

function resetFormState() {
    $('#form')[0].reset();
    $('#form :input').prop('disabled', false);
    $('#btn_simpan').show().prop('disabled', false);
    $('#form [name="id"]').val('');
    bootstrap.Tab.getOrCreateInstance(document.querySelector('a[href="#tabIdentitas"]')).show();
}

function openForm() {
    resetFormState();
    $('#modal_title').text('Tambah Siswa');
    modalForm.show();
}

function detail(id, editMode) {
    $.post('<?= base_url('master_data/siswa/detail') ?>', {id: id}, function (row) {
        if (!row || !row.id) {
            Swal.fire('Gagal', 'Data siswa tidak ditemukan.', 'error');
            return;
        }

        resetFormState();
        Object.keys(row).forEach(function (key) {
            $('#form [name="' + key + '"]').val(row[key]);
        });

        $('#modal_title').text(editMode ? 'Edit Siswa' : 'Detail Siswa');
        if (!editMode) {
            $('#form :input').prop('disabled', true);
            $('#btn_simpan').hide();
        }
        modalForm.show();
    }, 'json').fail(ajaxError);
}

$('#modalForm').on('hidden.bs.modal', resetFormState);

function saveData() {
    const button = $('#btn_simpan');
    button.prop('disabled', true);

    $.post('<?= base_url('master_data/siswa/simpan') ?>', $('#form').serialize(), function (response) {
        const berhasil = response.result === 'true';
        if (berhasil) {
            modalForm.hide();
            loadData();
        }
        Swal.fire(berhasil ? 'Berhasil' : 'Gagal', response.message, berhasil ? 'success' : 'error');
    }, 'json').fail(ajaxError).always(function () {
        button.prop('disabled', false);
    });
}

function refreshPagination() {
    paging($('#data .crud-list-item'), parseInt($('#dt-length-0').val(), 10) || 10, '#pagination');
}

</script>
