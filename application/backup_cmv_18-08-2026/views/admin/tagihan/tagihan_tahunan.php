<?php
$nama_bulan_lokal = function ($bulan) {
    $list = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
    return isset($list[(int) $bulan]) ? $list[(int) $bulan] : '-';
};
?>
<div class="card">
      <div class="card-header border-bottom border-dashed d-flex align-items-center justify-content-between">
        <h4 class="header-title mb-0">Langkah 1 - Informasi Tagihan</h4>

        <a href="<?= base_url('admin/tagihan/daftar_tagihan'); ?>"
            class="btn btn-outline-danger">
            <i class="ri-arrow-left-line me-1"></i>
            Kembali
        </a>
    </div>

    <div class="card-body">
        <form id="form_tagihan">
            <div class="row g-3">
                <div class="col-md-3"><label class="form-label">Tahun Ajaran</label><select name="id_periode" id="id_periode" class="form-select" required>
                        <option value="">Pilih tahun ajaran</option><?php foreach ($periode as $r): ?><option value="<?= $r['id'] ?>" data-periode="<?= html_escape($r['periode']) ?>"><?= html_escape($r['periode']) ?><?= $r['status'] === 'Aktif' ? ' - Aktif' : '' ?></option><?php endforeach; ?>
                    </select></div>
                <div class="col-md-3"><label class="form-label">Jenis Tagihan</label><select name="id_jenis_tagihan" id="id_jenis" class="form-select" required>
                        <option value="">Pilih jenis</option><?php foreach ($jenis as $r): ?><option value="<?= $r['id'] ?>" data-tunggakan="<?= $r['dianggap_tunggakan'] ?>"><?= html_escape($r['nama_jenis']) ?></option><?php endforeach; ?>
                    </select></div>
                <div class="col-md-3"><label class="form-label">Dihitung sebagai Tunggakan</label><select name="dianggap_tunggakan" id="dianggap_tunggakan" class="form-select">
                        <option>Ya</option>
                        <option>Tidak</option>
                    </select></div>
                <div class="col-md-8"><label class="form-label">Nama Tagihan</label><input name="nama_tagihan" class="form-control" placeholder="Nama tagihan" required></div>
                <div class="col-md-4"><label class="form-label">Nominal Umum</label><input name="nominal_default" id="nominal_default" type="text" inputmode="numeric" autocomplete="off" class="form-control money-input" required></div>
                <div class="col-12"><label class="form-label">Keterangan</label><textarea name="keterangan" class="form-control" rows="2"></textarea></div>
            </div>

            <div class="card border mt-4 mb-0">
                <div class="card-header border-bottom border-dashed">
                    <h4 class="header-title mb-0">Langkah 2 - Periode Penagihan</h4>
                </div>
                <div class="card-body">

                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Bulan Mulai Tampil</label><select name="bulan_penagihan" id="bulan_penagihan" class="form-select"><?php foreach (range(1, 12) as $m): ?><option value="<?= $m ?>"><?= $nama_bulan_lokal($m) ?></option><?php endforeach; ?></select></div>
                        <div class="col-md-4"><label class="form-label">Tahun</label><select name="tahun_penagihan" id="tahun_penagihan" class="form-select"></select></div>
                        <div class="col-md-4"><label class="form-label">Jatuh Tempo</label><input name="tanggal_jatuh_tempo" class="form-control tanggal"></div>
                    </div>

                </div>
            </div>

            <div class="card border mt-4 mb-0">
                <div class="card-header border-bottom border-dashed">
                    <h4 class="header-title mb-0">Langkah 3 - Target Tagihan</h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">Target</label><select name="target_tagihan" id="target_tagihan" class="form-select">
                                <option value="Semua">Semua Siswa Aktif</option>
                                <option value="Kelas">Kelas Tertentu</option>
                                <option value="Siswa">Siswa Tertentu</option>
                            </select></div>
                    </div>
                    <div id="target_kelas_area" class="mt-3 d-none"><label class="form-label">Pilih Kelas</label>
                        <div class="row g-2" id="kelas_options"><?php foreach ($kelas as $r): ?><div class="col-md-4 kelas-item" data-periode="<?= $r['id_periode'] ?>"><label class="border rounded p-2 w-100"><input type="checkbox" class="form-check-input me-1" name="target_kelas[]" value="<?= $r['id'] ?>"> <?= html_escape($r['nama_kelas']) ?></label></div><?php endforeach; ?></div>
                    </div>
                    <div id="target_siswa_area" class="mt-3 d-none"><label class="form-label">Cari dan Tambahkan Siswa</label>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-10"><input id="cari_siswa" class="form-control" placeholder="Nama/NIS/NISN"></div>
                            <div class="col-md-2 d-grid"><button type="button" class="btn btn-primary" id="btn_cari_siswa"><i class="ri-search-line me-1"></i>Cari</button></div>
                        </div>
                        <div id="hasil_siswa" class="mt-2"></div>
                        <div id="siswa_terpilih" class="mt-3 d-flex flex-wrap gap-2"></div>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-end gap-2 mt-4"><button type="button" class="btn btn-light" onclick="document.getElementById('form_tagihan').reset();location.reload();">Reset</button><button type="button" class="btn btn-outline-secondary" onclick="simpan('Draft')">Simpan Draft</button><button type="button" class="btn btn-outline-primary" id="btn_preview">Preview Tagihan</button><button type="button" class="btn btn-primary" onclick="simpan('Terbitkan')">Buat Tagihan</button></div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalPreview">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Tagihan</h5><button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="preview_content"></div>
            <div class="modal-footer"><button class="btn btn-light" data-bs-dismiss="modal">Tutup</button><button class="btn btn-primary" onclick="simpan('Terbitkan')">Terbitkan Tagihan</button></div>
        </div>
    </div>
</div>
<script>
    var previewModal;
    var selectedStudents = {};

    $(document).ready(function() {
        previewModal = new bootstrap.Modal('#modalPreview');

        flatpickr('.tanggal,.jatuh_tempo', {
            dateFormat: 'd-m-Y'
        });

        $('#id_periode').change(function() {
            updatePeriodTarget();
        });

        $('#id_jenis').change(function() {
            $('#dianggap_tunggakan').val($(this).find(':selected').data('tunggakan') || 'Ya');
        });

        $('#target_tagihan').change(function() {
            toggleTarget();
        });

        $('.cek_bulan').change(toggleMonth);

        $('#terapkan_nominal').click(function() {
            applyNominal();
        });

        $('#nominal_default').on('input', function() {
            if ($('#mode_tarif').val() === 'Sama') {
                applyNominal();
            }
        });

        $('#btn_cari_siswa').click(function() {
            cariSiswa();
        });

        $('#cari_siswa').keyup(function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                cariSiswa();
            }
        });

        $('#btn_preview').click(function() {
            preview();
        });

        toggleTarget();
        updatePeriodTarget();
    });

    function updatePeriodTarget() {
        var periode = $('#id_periode').val();
        var periodeText = $('#id_periode :selected').data('periode') || '';
        var years = String(periodeText).split('/');

        $('#tahun_penagihan').html(
            years.map(function(tahun) {
                return '<option>' + escapeHtml(tahun) + '</option>';
            }).join('')
        );

        $('.kelas-item').each(function() {
            var sesuai = String($(this).data('periode')) === String(periode);

            $(this).toggle(sesuai);
            if (!sesuai) {
                $(this).find('input').prop('checked', false);
            }
        });

        $('#bulan_rows tr').each(function() {
            var bulan = Number($(this).data('bulan'));
            $(this).find('.tahun_label').text(bulan >= 7 ? (years[0] || '-') : (years[1] || '-'));
        });

        selectedStudents = {};
        renderSelected();
    }

    function toggleTarget() {
        var target = $('#target_tagihan').val();
        $('#target_kelas_area').toggleClass('d-none', target !== 'Kelas');
        $('#target_siswa_area').toggleClass('d-none', target !== 'Siswa');
    }

    function toggleMonth() {
        var row = $(this).closest('tr');
        var aktif = this.checked;

        row.find('input:not(.cek_bulan)').prop('disabled', !aktif);

        if (aktif && $('#mode_tarif').val() === 'Sama') {
            row.find('.nominal_bulan').val($('#nominal_default').val());
        }
    }

    function applyNominal() {
        $('.cek_bulan:checked').each(function() {
            $(this).closest('tr').find('.nominal_bulan').val($('#nominal_default').val());
        });
    }

    function cariSiswa() {
        if (!$('#id_periode').val()) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Pilih tahun ajaran terlebih dahulu.'
            });
            return;
        }

        $.ajax({
            url: '<?= base_url('admin/tagihan/tagihan_tahunan/cari_siswa'); ?>',
            type: 'POST',
            data: {
                q: $('#cari_siswa').val(),
                id_periode: $('#id_periode').val()
            },
            dataType: 'JSON',
            success: function(data) {
                var html = '';

                if (data.length == 0) {
                    html = '<div class="text-muted">Siswa tidak ditemukan.</div>';
                } else {
                    data.forEach(function(item) {
                        html += '<button type="button" class="btn btn-sm btn-outline-primary me-1 mb-1" onclick=\'addStudent(' + JSON.stringify(item) + ')\'>' +
                            escapeHtml(item.nama_lengkap) + ' - ' + escapeHtml(item.nama_kelas) +
                            '</button>';
                    });
                }

                $('#hasil_siswa').html(html);
            },
            error: function(xhr, status, error) {
                ajaxError(xhr);
            }
        });
    }

    function addStudent(item) {
        selectedStudents[item.id] = item;
        renderSelected();
    }

    function removeStudent(id) {
        delete selectedStudents[id];
        renderSelected();
    }

    function renderSelected() {
        var html = '';

        Object.keys(selectedStudents).forEach(function(id) {
            var item = selectedStudents[id];
            html += '<span class="badge bg-primary-subtle text-primary p-2">' +
                escapeHtml(item.nama_lengkap) +
                ' <button type="button" class="btn-close btn-close-sm ms-1" onclick="removeStudent(' + id + ')"></button>' +
                '<input type="hidden" name="target_siswa[]" value="' + id + '">' +
                '</span>';
        });

        $('#siswa_terpilih').html(html);
    }

    function formData(mode) {
        var data = serializeMoneyForm('#form_tagihan');
        return data + '&' + $.param({
            mode_simpan: mode
        });
    }

    function preview() {
        $('#btn_preview').prop('disabled', true);

        $.ajax({
            url: '<?= base_url('admin/tagihan/tagihan_tahunan/preview'); ?>',
            type: 'POST',
            data: formData('Preview'),
            dataType: 'JSON',
            success: function(data) {
                if (data.result != 'true') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: data.message
                    });
                    return;
                }

                var html = '<div class="row g-3">' +
                    '<div class="col-md-4"><div class="alert alert-info"><small>Jumlah Siswa</small><h4>' + data.jumlah_siswa + '</h4></div></div>' +
                    '<div class="col-md-4"><div class="alert alert-primary"><small>Jumlah Baris Tagihan</small><h4>' + data.jumlah_baris + '</h4></div></div>' +
                    '<div class="col-md-4"><div class="alert alert-success"><small>Total Nominal</small><h4>' + formatRupiah(data.total_nominal) + '</h4></div></div>' +
                    '</div><h6>Periode Tagihan</h6><ul>';

                data.periods.forEach(function(item) {
                    html += '<li>' + escapeHtml(item.nama_bulan) + ' ' + item.tahun + ' - ' + formatRupiah(item.nominal) + '</li>';
                });

                html += '</ul><h6>Contoh Target</h6><div class="table-responsive"><table class="table table-sm">' +
                    '<thead><tr><th>Siswa</th><th>Kelas</th></tr></thead><tbody>';

                data.students.forEach(function(item) {
                    html += '<tr><td>' + escapeHtml(item.nama_lengkap) + '</td><td>' + escapeHtml(item.nama_kelas) + '</td></tr>';
                });

                html += '</tbody></table></div>';

                $('#preview_content').html(html);
                previewModal.show();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr);
            },
            complete: function() {
                $('#btn_preview').prop('disabled', false);
            }
        });
    }

    function simpan(mode) {
        confirmAction(
            mode === 'Draft' ? 'Simpan draft tagihan?' : 'Terbitkan tagihan?',
            'Pastikan target dan tarif sudah benar.',
            function() {
                $('button').prop('disabled', true);

                $.ajax({
                    url: '<?= base_url('admin/tagihan/tagihan_tahunan/simpan'); ?>',
                    type: 'POST',
                    data: formData(mode),
                    dataType: 'JSON',
                    success: function(data) {
                        Swal.fire({
                            icon: data.result == 'true' ? 'success' : 'error',
                            title: data.result == 'true' ? 'Berhasil' : 'Gagal',
                            text: data.message
                        }).then(function() {
                            if (data.result == 'true') {
                                window.location.href = '<?= base_url('admin/tagihan/daftar_tagihan'); ?>';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        ajaxError(xhr);
                    },
                    complete: function() {
                        $('button').prop('disabled', false);
                    }
                });
            }
        );
    }
</script>