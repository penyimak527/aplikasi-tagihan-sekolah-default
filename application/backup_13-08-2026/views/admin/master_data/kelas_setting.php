<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Data Kelas Setting</h4>
        <button type="button" class="btn btn-outline-primary" id="btn_tambah">
            <i class="ri-add-line me-1"></i>Tambah
        </button>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-3">
                <label class="form-label">Tahun Ajaran</label>
                <select id="filter_periode" class="form-select">
                    <option value="">Semua Tahun Ajaran</option>
                    <?php foreach ($periode as $row): ?>
                        <option value="<?= (int)$row['id'] ?>"><?= html_escape($row['periode']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Kelas</label>
                <select id="filter_kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $row): ?>
                        <option value="<?= (int)$row['id'] ?>"><?= html_escape($row['nama_kelas']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cari Kelas</label>
                <input type="text" id="search" class="form-control" placeholder="Cari kelas ...">
            </div>
            <div class="col-md-2 d-grid">
                <button type="button" class="btn btn-primary" id="btn_cari"><i class="ri-search-line me-1"></i>Cari</button>
            </div>
        </div>

        <div id="data" class="crud-list"></div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center flex-wrap gap-2 mt-3">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination"></ul>
            <div class="d-flex align-items-center gap-2">
                <label for="dt-length-0" class="mb-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-0">
                    <option value="10" selected>10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option>
                </select>
                <span>entri</span>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_title">Tambah Kelas Setting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <form id="form">
                    <input type="hidden" name="id">
                    <input type="hidden" name="konfirmasi" value="Tidak">
                    <div class="mb-3">
                        <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
                        <select name="id_periode" class="form-select" required>
                            <option value="">Pilih Tahun Ajaran</option>
                            <?php foreach ($periode as $row): ?>
                                <option value="<?= (int)$row['id'] ?>"><?= html_escape($row['periode']) ?><?= $row['status']==='Aktif'?' - Aktif':'' ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kelas <span class="text-danger">*</span></label>
                        <select name="id_kelas" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <?php foreach ($kelas as $row): ?>
                                <option value="<?= (int)$row['id'] ?>"><?= html_escape($row['nama_kelas']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btn_simpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
var modalForm;
var dataRows = [];

$(document).ready(function () {
    modalForm = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalForm'));
    loadData();
    $('#btn_tambah').on('click', function(){ openForm(); });
    $('#btn_cari').on('click', loadData);
    $('#search').on('keyup', function(e){ if(e.key === 'Enter') loadData(); });
    $('#dt-length-0').on('change', refreshPagination);
    $('#btn_simpan').on('click', function(){ saveData(false); });
});

function loadData() {
    $.ajax({
        url: '<?= base_url('admin/master_data/kelas_setting/result') ?>',
        type: 'POST',
        dataType: 'JSON',
        data: {id_periode: $('#filter_periode').val(), id_kelas: $('#filter_kelas').val(), search: $('#search').val()},
        success: function(rows){
            dataRows = Array.isArray(rows) ? rows : [];
            if (!dataRows.length) {
                $('#data').html('<div class="empty-state">Belum ada data Kelas Setting.</div>');
                refreshPagination();
                return;
            }
            $('#data').html(dataRows.map(function(row,index){
                return '<div class="crud-list-item">' +
                    '<div class="crud-content">' +
                    '<div class="crud-title">' + (index+1) + '. ' + escapeHtml(row.nama_kelas || '-') + '</div>' +
                    '<div class="crud-meta">Tahun Ajaran: ' + escapeHtml(row.periode || '-') + '</div>' +
                    '<div class="crud-note">Siswa aktif: ' + Number(row.jumlah_siswa || 0).toLocaleString('id-ID') + '</div>' +
                    '</div>' +
                    '<div class="crud-actions">' +
                    '<button type="button" class="btn btn-outline-warning btn-icon" title="Edit" onclick="openFormById(' + Number(row.id) + ')"><i class="ri-edit-line"></i></button>' +
                    '<button type="button" class="btn btn-outline-danger btn-icon" title="Hapus" onclick="hapus(' + Number(row.id) + ')"><i class="ri-delete-bin-line"></i></button>' +
                    '</div></div>';
            }).join(''));
            refreshPagination();
        },
        error: function(xhr,status,error){ ajaxError(xhr,status,error); }
    });
}

function openFormById(id){
    var row = dataRows.find(function(item){ return Number(item.id) === Number(id); });
    openForm(row || null);
}

function openForm(row){
    $('#form')[0].reset();
    $('#form [name="id"]').val(row ? row.id : '');
    $('#form [name="konfirmasi"]').val('Tidak');
    $('#modal_title').text(row ? 'Edit Kelas Setting' : 'Tambah Kelas Setting');
    if(row){
        $('#form [name="id_periode"]').val(row.id_periode);
        $('#form [name="id_kelas"]').val(row.id_kelas);
    }
    modalForm.show();
}

function saveData(force){
    $('#form [name="konfirmasi"]').val(force ? 'Ya' : 'Tidak');
    var button=$('#btn_simpan').prop('disabled',true);
    $.ajax({
        url: '<?= base_url('admin/master_data/kelas_setting/simpan') ?>',
        type: 'POST', dataType: 'JSON', data: $('#form').serialize(),
        success: function(response){
            if(response.result === 'confirm'){
                Swal.fire({icon:'warning',title:'Konfirmasi Perubahan',text:response.message,showCancelButton:true,confirmButtonText:'Ya, Lanjutkan',cancelButtonText:'Batal'}).then(function(r){ if(r.isConfirmed) saveData(true); });
                return;
            }
            var ok=response.result === 'true';
            Swal.fire(ok?'Berhasil':'Gagal',response.message,ok?'success':'error');
            if(ok){ modalForm.hide(); loadData(); }
        },
        error: function(xhr,status,error){ ajaxError(xhr,status,error); },
        complete: function(){ button.prop('disabled',false); }
    });
}

function hapus(id){
    confirmAction('Hapus Kelas Setting?','Data yang sudah digunakan untuk penempatan siswa tidak boleh dihapus.',function(){
        $.ajax({
            url:'<?= base_url('admin/master_data/kelas_setting/hapus') ?>', type:'POST', dataType:'JSON', data:{id:id},
            success:function(response){ var ok=response.result==='true'; Swal.fire(ok?'Berhasil':'Gagal',response.message,ok?'success':'error'); if(ok) loadData(); },
            error:function(xhr,status,error){ ajaxError(xhr,status,error); }
        });
    });
}

function refreshPagination(){ paging($('#data .crud-list-item'), parseInt($('#dt-length-0').val(),10)||10, '#pagination'); }
</script>
