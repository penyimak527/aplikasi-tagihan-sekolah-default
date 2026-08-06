<div class="card">
    <div class="card-header app-card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h4 class="header-title mb-0">Daftar Tagihan</h4>
        <div class="dropdown">
            <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                <i class="ri-add-line me-1"></i>Buat Tagihan
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="<?= base_url('tagihan_bulanan') ?>">Tagihan Bulanan</a>
                <a class="dropdown-item" href="<?= base_url('tagihan_langsung') ?>">Tagihan Langsung</a>
                <a class="dropdown-item" href="<?= base_url('tagihan_tahunan') ?>">Tagihan Tahunan</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-lg-2 col-md-4"><select id="periode" class="form-select"><option value="0">Semua Tahun Ajaran</option><?php foreach($periode as $r): ?><option value="<?= $r['id'] ?>"><?= html_escape($r['periode']) ?></option><?php endforeach; ?></select></div>
            <div class="col-lg-2 col-md-4"><select id="tipe" class="form-select"><option value="">Semua Tipe</option><option>Bulanan</option><option>Langsung</option><option>Tahunan</option></select></div>
            <div class="col-lg-2 col-md-4"><select id="jenis" class="form-select"><option value="0">Semua Jenis</option><?php foreach($jenis as $r): ?><option value="<?= $r['id'] ?>"><?= html_escape($r['nama_jenis']) ?></option><?php endforeach; ?></select></div>
            <div class="col-lg-2 col-md-4"><select id="filter_status_tagihan" class="form-select"><option value="">Semua Status</option><option>Draft</option><option>Aktif</option><option>Dibatalkan</option></select></div>
            <div class="col-lg-2 col-md-4"><input id="search" class="form-control" placeholder="Cari nama atau kode ..."></div>
            <div class="col-lg-2 col-md-4 d-grid"><button class="btn btn-primary" type="button" onclick="loadData()"><i class="ri-search-line me-1"></i>Cari</button></div>
        </div>
        <div id="data" class="crud-list"></div>
    </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">Detail Tagihan</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body" id="detail_content"></div>
            <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Tutup</button></div>
        </div>
    </div>
</div>
<script>
var modalDetail;$(function(){modalDetail=new bootstrap.Modal('#modalDetail');loadData();});
function loadData(){
    $.post('<?= base_url('daftar_tagihan/result') ?>',{
        id_periode:$('#periode').val(),tipe:$('#tipe').val(),id_jenis:$('#jenis').val(),status:$('#filter_status_tagihan').val(),search:$('#search').val()
    },function(rows){
        if(!rows.length){$('#data').html('<div class="empty-state">Belum ada tagihan.</div>');return;}
        var h=rows.map(function(r,index){
            var badge=r.status==='Aktif'?'bg-success':(r.status==='Draft'?'bg-warning':'bg-danger');
            var actions='<button class="btn btn-outline-primary btn-icon" title="Detail" onclick="detail('+r.id+')"><i class="ri-eye-line"></i></button>'+
                '<a class="btn btn-outline-primary btn-icon" title="Siswa Pembayar" href="<?= base_url('siswa_pembayar?id_tagihan=') ?>'+r.id+'"><i class="ri-user-follow-line"></i></a>'+
                '<a class="btn btn-outline-warning btn-icon" title="Tarif" href="<?= base_url('tarif_per_kelas?id_tagihan=') ?>'+r.id+'"><i class="ri-money-dollar-circle-line"></i></a>'+
                (r.status==='Draft'?'<button class="btn btn-outline-success btn-icon" title="Terbitkan" onclick="terbitkan('+r.id+')"><i class="ri-send-plane-line"></i></button>':'')+
                (r.status==='Aktif'?'<button class="btn btn-outline-danger btn-icon" title="Batalkan Sisa" onclick="batalkan('+r.id+')"><i class="ri-close-circle-line"></i></button>':'');
            return '<div class="crud-list-item"><div class="crud-content">'+
                '<div class="crud-status">Status: <span class="badge '+badge+'">'+escapeHtml(r.status)+'</span> <span class="badge bg-light text-dark">'+escapeHtml(r.tipe_tagihan)+'</span></div>'+
                '<div class="crud-title">'+(index+1)+'. '+escapeHtml(r.nama_tagihan)+'</div>'+
                '<div class="crud-meta">Kode: '+escapeHtml(r.kode_tagihan)+' | Tahun: '+escapeHtml(r.periode)+' '+escapeHtml(r.semester||'')+' | Target: '+escapeHtml(r.target_tagihan)+'</div>'+
                '<div class="crud-note">Siswa: '+Number(r.jumlah_siswa||0)+' | Total: '+formatRupiah(r.total_nominal||0)+' | Belum: '+Number(r.belum_bayar||0)+' | Sebagian: '+Number(r.sebagian||0)+' | Lunas: '+Number(r.lunas||0)+'</div></div>'+
                '<div class="crud-actions">'+actions+'</div></div>';
        }).join('');
        $('#data').html(h);
    },'json').fail(ajaxError);
}
function detail(id){$.post('<?= base_url('daftar_tagihan/detail') ?>',{id:id},function(r){if(r.result!=='true')return Swal.fire('Gagal',r.message,'error');var m=r.master,h='<div class="row g-3"><div class="col-md-6"><div class="border rounded p-3"><h5>'+escapeHtml(m.nama_tagihan)+'</h5><div>Kode: '+escapeHtml(m.kode_tagihan)+'</div><div>Tipe: '+escapeHtml(m.tipe_tagihan)+'</div><div>Tahun Ajaran: '+escapeHtml(m.periode)+'</div><div>Status: '+escapeHtml(m.status)+'</div><div>Dihitung tunggakan: '+escapeHtml(m.dianggap_tunggakan)+'</div></div></div><div class="col-md-6"><div class="border rounded p-3"><h6>Periode dan Tarif</h6><ul class="mb-0">';r.periods.forEach(function(x){h+='<li>'+escapeHtml(x.nama_bulan)+' '+x.tahun+' - '+formatRupiah(x.nominal)+'</li>';});h+='</ul></div></div></div><h6 class="mt-4">Kelas Target</h6><div class="d-flex flex-wrap gap-2">';r.classes.forEach(function(x){h+='<span class="badge bg-primary-subtle text-primary p-2">'+escapeHtml(x.nama_kelas)+' - '+formatRupiah(x.nominal_kelas)+'</span>';});h+='</div><h6 class="mt-4">Contoh Tagihan Siswa</h6><div class="table-responsive"><table class="table table-sm"><thead><tr><th>No Tagihan</th><th>Siswa</th><th>Periode</th><th>Nominal</th><th>Dibayar</th><th>Sisa</th><th>Status</th></tr></thead><tbody>';if(!r.students.length)h+='<tr><td colspan="7" class="text-center text-muted">Draft belum diterbitkan.</td></tr>';r.students.forEach(function(x){h+='<tr><td>'+escapeHtml(x.no_tagihan)+'</td><td>'+escapeHtml(x.nama_siswa)+'<br><small>'+escapeHtml(x.nama_kelas)+'</small></td><td>'+escapeHtml(x.nama_bulan)+' '+x.tahun+'</td><td>'+formatRupiah(x.nominal_tagihan)+'</td><td>'+formatRupiah(x.nominal_dibayar)+'</td><td>'+formatRupiah(x.sisa_tagihan)+'</td><td>'+escapeHtml(x.status_pembayaran)+'</td></tr>';});h+='</tbody></table></div>';$('#detail_content').html(h);modalDetail.show();},'json').fail(ajaxError);}
function terbitkan(id){confirmAction('Terbitkan draft tagihan?','Tagihan siswa akan dibuat berdasarkan target dan tarif tersimpan.',function(){$.post('<?= base_url('daftar_tagihan/terbitkan') ?>',{id:id},function(r){Swal.fire(r.result==='true'?'Berhasil':'Gagal',r.message,r.result==='true'?'success':'error');loadData();},'json').fail(ajaxError);});}
function batalkan(id){Swal.fire({title:'Batalkan sisa tagihan',input:'textarea',inputLabel:'Alasan wajib',showCancelButton:true,confirmButtonText:'Batalkan Tagihan',preConfirm:function(v){if(!v)Swal.showValidationMessage('Alasan wajib diisi');return v;}}).then(function(res){if(res.isConfirmed)$.post('<?= base_url('daftar_tagihan/batalkan_sisa') ?>',{id:id,alasan:res.value},function(r){Swal.fire(r.result==='true'?'Berhasil':'Gagal',r.message,r.result==='true'?'success':'error');loadData();},'json').fail(ajaxError);});}
</script>
