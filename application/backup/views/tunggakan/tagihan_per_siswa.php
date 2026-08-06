<div class="card"><div class="card-header"><h5 class="mb-0">Cari dan Tinjau Tagihan Siswa</h5></div><div class="card-body"><div class="row g-2 align-items-end"><div class="col-md-10"><input id="q" class="form-control" placeholder="Nama / NIS / NISN"></div><div class="col-md-2 d-grid"><button id="cari" class="btn btn-primary"><i class="ti ti-search me-1"></i>Cari</button></div></div><div id="hasil" class="mt-3"></div><div id="identitas" class="alert alert-primary mt-3 d-none"></div><div id="filter" class="row g-2 mt-1 d-none"><div class="col-md-3"><select id="periode" class="form-select"><option value="">Semua Tahun Ajaran</option><?php foreach($periode as $p): ?><option value="<?= $p['id'] ?>"><?= html_escape($p['periode']) ?></option><?php endforeach ?></select></div><div class="col-md-3"><select id="tipe" class="form-select"><option value="">Semua Tipe</option><option>Bulanan</option><option>Langsung</option><option>Tahunan</option></select></div><div class="col-md-3"><select id="filter_status_tagihan_siswa" class="form-select"><option value="">Semua Status</option><option>Belum Dibayar</option><option>Dibayar Sebagian</option><option>Lunas</option><option>Dibebaskan</option><option>Dibatalkan</option></select></div><div class="col-md-2"><select id="bulan" class="form-select"><option value="">Semua Bulan</option><?php for($i=1;$i<=12;$i++): ?><option value="<?= $i ?>"><?= nama_bulan($i) ?></option><?php endfor ?></select></div><div class="col-md-1 d-grid"><button id="tampil" class="btn btn-primary"><i class="ti ti-filter"></i></button></div></div></div></div>
<div id="summary" class="row g-3 d-none mb-3"><div class="col-md-4"><div class="card summary-card"><div class="card-body"><small>Total Tagihan Wajib</small><div id="swajib" class="summary-value"></div></div></div></div><div class="col-md-4"><div class="card summary-card"><div class="card-body"><small>Total Dibayar</small><div id="sdibayar" class="summary-value text-success"></div></div></div></div><div class="col-md-4"><div class="card summary-card"><div class="card-body"><small>Total Tunggakan</small><div id="stunggakan" class="summary-value text-danger"></div></div></div></div></div>
<div class="card"><div class="card-header d-flex justify-content-between"><h5 class="mb-0">Daftar Tagihan</h5><div class="action-buttons"><a id="bayar" class="btn btn-success disabled"><i class="ti ti-cash"></i> Bayar Tagihan</a><button onclick="window.print()" class="btn btn-secondary no-print"><i class="ti ti-printer"></i> Cetak Rekap</button><a id="surat" class="btn btn-warning disabled"><i class="ti ti-mail"></i> Buat Surat</a></div></div><div class="card-body"><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Tagihan</th><th>Periode</th><th>Wajib</th><th class="text-end">Nominal</th><th class="text-end">Dibayar</th><th class="text-end">Sisa</th><th>Status</th></tr></thead><tbody id="data"><tr><td colspan="7" class="empty-state">Pilih siswa.</td></tr></tbody></table></div></div></div>
<script>
$(function () {
    let id = 0;
    const money = n => 'Rp' + Number(n || 0).toLocaleString('id-ID');

    function search() {
        const q = $('#q').val();
        if (q.trim().length < 2) {
            Swal.fire('Perhatian', 'Masukkan minimal 2 karakter.', 'warning');
            return;
        }

        $.post('<?= base_url('tagihan_per_siswa/cari_siswa') ?>', { q }, function (rows) {
            if (!rows.length) {
                $('#hasil').html('<div class="alert alert-warning">Siswa tidak ditemukan.</div>');
                return;
            }

            const html = rows.map(function (row) {
                const info = row.nis + ' | ' + (row.nama_kelas || '-') + ' | ' + row.status_pendaftaran;
                const subInfo = row.nis + ' | ' + row.nisn + ' | ' + (row.nama_kelas || '-');

                return `
                    <button class="list-group-item list-group-item-action pilih"
                        data-id="${row.id}"
                        data-name="${escapeHtml(row.nama_lengkap)}"
                        data-info="${escapeHtml(info)}">
                        <strong>${escapeHtml(row.nama_lengkap)}</strong><br>
                        <small>${escapeHtml(subInfo)}</small>
                    </button>`;
            }).join('');

            $('#hasil').html('<div class="list-group">' + html + '</div>');
        }, 'json').fail(ajaxError);
    }

    function load() {
        if (!id) {
            return;
        }

        $.post('<?= base_url('tagihan_per_siswa/result') ?>', {
            id_siswa: id,
            id_periode: $('#periode').val(),
            tipe: $('#tipe').val(),
            status: $('#filter_status_tagihan_siswa').val(),
            sampai_bulan: $('#bulan').val()
        }, function (response) {
            if (response.result !== 'true') {
                Swal.fire('Gagal', response.message, 'error');
                return;
            }

            $('#swajib').text(money(response.summary.wajib));
            $('#sdibayar').text(money(response.summary.dibayar));
            $('#stunggakan').text(money(response.summary.tunggakan));

            if (!response.rows.length) {
                $('#data').html('<tr><td colspan="7" class="empty-state">Tidak ada tagihan sesuai filter.</td></tr>');
                return;
            }

            const html = response.rows.map(function (row) {
                const wajib = row.dianggap_tunggakan === 'Ya'
                    ? '<span class="badge bg-warning-subtle text-warning">Ya</span>'
                    : '<span class="badge bg-info-subtle text-info">Tidak</span>';

                return `
                    <tr>
                        <td>
                            <strong>${escapeHtml(row.nama_tagihan)}</strong><br>
                            <small>${escapeHtml(row.no_tagihan)}</small>
                        </td>
                        <td>
                            ${escapeHtml((row.nama_bulan || '') + ' ' + row.tahun)}<br>
                            <small>${escapeHtml(row.periode)}</small>
                        </td>
                        <td>${wajib}</td>
                        <td class="text-end">${money(row.nominal_tagihan)}</td>
                        <td class="text-end">${money(row.nominal_dibayar)}</td>
                        <td class="text-end fw-semibold">${money(row.sisa_tagihan)}</td>
                        <td><span class="badge bg-secondary-subtle text-secondary">${escapeHtml(row.status_pembayaran)}</span></td>
                    </tr>`;
            }).join('');

            $('#data').html(html);
        }, 'json').fail(ajaxError);
    }

    $('#cari').on('click', search);
    $('#q').on('keypress', function (event) {
        if (event.which === 13) {
            search();
        }
    });
    $('#tampil').on('click', load);

    $(document).on('click', '.pilih', function () {
        id = $(this).data('id');
        $('#hasil').empty();
        $('#identitas')
            .removeClass('d-none')
            .html(`<strong>${escapeHtml($(this).data('name'))}</strong><br>${escapeHtml($(this).data('info'))}`);
        $('#filter, #summary').removeClass('d-none');
        $('#bayar').removeClass('disabled').attr('href', '<?= base_url('pembayaran') ?>?siswa=' + id);
        $('#surat').removeClass('disabled').attr('href', '<?= base_url('surat_tunggakan') ?>?siswa=' + id);
        load();
    });
});
</script>
