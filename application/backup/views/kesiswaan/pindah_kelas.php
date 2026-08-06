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
                        <button type="button" class="btn btn-primary" onclick="cari()"><i class="ri-search-line me-1"></i>Cari Siswa</button>
                    </div>
                </div>
                <div id="hasil" class="mt-3"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-7">
        <div class="card">
            <div class="card-header border-bottom border-dashed">
                <h4 class="header-title mb-0">Form Pindah Kelas</h4>
            </div>
            <div class="card-body">
                <form id="form"><input type="hidden" name="id_siswa"><input type="hidden" name="id_kelas_asal">
                    <div class="alert alert-info" id="identitas">Pilih siswa terlebih dahulu.</div>
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">Kelas Tujuan</label><select name="id_kelas_tujuan" id="kelas_tujuan" class="form-select">
                                <option value="">Pilih kelas tujuan</option><?php foreach ($kelas as $r): ?><option value="<?= $r['id'] ?>" data-periode="<?= $r['id_periode'] ?>" data-semester="<?= html_escape($r['semester']) ?>"><?= html_escape($r['periode'] . ' - ' . $r['semester'] . ' - ' . $r['nama_kelas']) ?></option><?php endforeach; ?>
                            </select></div>
                        <div class="col-md-6"><label class="form-label">Tanggal Pindah</label><input name="tanggal_pindah" class="form-control tanggal" value="<?= date('d-m-Y') ?>"></div>
                        <div class="col-12"><label class="form-label">Alasan</label><textarea name="alasan" class="form-control" required></textarea></div>
                        <div class="col-12"><button type="button" id="btn_proses" class="btn btn-primary">Proses Pindah Kelas</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        flatpickr('.tanggal', {
            dateFormat: 'd-m-Y'
        });
        $('#cari_siswa').keyup(function(e) {
            if (e.key === 'Enter') cari();
        });
        $('#btn_proses').click(proses);
    });

    function cari() {
        $.post('<?= base_url('pindah_kelas/cari') ?>', {
            q: $('#cari_siswa').val()
        }, function(rows) {
            var h = '';
            if (!rows.length) h = '<div class="empty-state">Siswa tidak ditemukan.</div>';
            rows.forEach(function(r) {
                h += '<button type="button" class="list-group-item list-group-item-action border rounded mb-2" onclick=\'pilih(' + JSON.stringify(r) + ')\'><strong>' + escapeHtml(r.nama_lengkap) + '</strong><br><small>' + escapeHtml(r.nis) + ' | ' + escapeHtml(r.nama_kelas) + ' - ' + escapeHtml(r.periode) + ' ' + escapeHtml(r.semester) + '</small></button>';
            });
            $('#hasil').html(h);
        }, 'json').fail(ajaxError);
    }

    function pilih(r) {
        $('#form [name=id_siswa]').val(r.id);
        $('#form [name=id_kelas_asal]').val(r.id_kelas_setting);
        $('#identitas').html('<strong>' + escapeHtml(r.nama_lengkap) + '</strong><br>NIS ' + escapeHtml(r.nis) + ' | Kelas saat ini: ' + escapeHtml(r.nama_kelas) + ' - ' + escapeHtml(r.periode) + ' ' + escapeHtml(r.semester));
        $('#kelas_tujuan option').each(function() {
            var p = $(this).data('periode'),
                s = $(this).data('semester');
            if (!p || (String(p) === String(r.id_periode) && String(s) === String(r.semester) && String(this.value) !== String(r.id_kelas_setting))) $(this).show();
            else $(this).hide();
        });
        $('#kelas_tujuan').val('');
    }

    function proses() {
        if (!$('#form [name=id_siswa]').val()) return Swal.fire('Perhatian', 'Pilih siswa terlebih dahulu.', 'warning');
        confirmAction('Proses pindah kelas?', 'Tagihan lama tidak akan diubah.', function() {
            $.post('<?= base_url('pindah_kelas/proses') ?>', $('#form').serialize(), function(r) {
                Swal.fire(r.result === 'true' ? 'Berhasil' : 'Gagal', r.message, r.result === 'true' ? 'success' : 'error');
                if (r.result === 'true') location.reload();
            }, 'json').fail(ajaxError);
        });
    }
</script>