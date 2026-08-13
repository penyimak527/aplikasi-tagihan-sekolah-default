<div class="card portal-card">
    <div class="card-header border-bottom">
        <h4 class="mb-0">Tagihan</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-3">
                <label class="form-label" for="filter_status">Status</label>
                <select id="filter_status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Belum Dibayar">Belum Dibayar</option>
                    <option value="Dibayar Sebagian">Dibayar Sebagian</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Dibebaskan">Dibebaskan</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label" for="filter_jenis">Jenis Tagihan</label>
                <select id="filter_jenis" class="form-select">
                    <option value="0">Semua Jenis</option>
                    <?php foreach ($jenis as $j): ?>
                        <option value="<?= (int) $j['id'] ?>"><?= html_escape($j['nama_jenis']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label" for="filter_search">Cari Tagihan</label>
                <input id="filter_search" class="form-control" placeholder="Cari nama tagihan ...">
            </div>
            <div class="col-md-2"><button id="btnCari" class="btn btn-primary w-100"><i
                        class="ri-search-line me-1"></i>Cari</button></div>
        </div>

        <div id="data_tagihan"></div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination"></ul>
            <div class="d-flex align-items-center gap-2">
                <label class="mb-0" for="dt-length-0">Tampilkan</label>
                <select class="form-select form-select-sm" id="dt-length-0">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select><span>entri</span>
            </div>
        </div>
    </div>
</div>
<script>
    function statusBadge(status) {
        if (status === 'Lunas') return 'bg-success-subtle text-success';
        if (status === 'Dibayar Sebagian') return 'bg-warning-subtle text-warning';
        if (status === 'Dibebaskan') return 'bg-info-subtle text-info';
        return 'bg-secondary-subtle text-secondary';
    }
    function loadTagihan() {
        $.ajax({
            url: '<?= base_url('wali_murid/tagihan/result') ?>',
            type: 'POST',
            data: { status: $('#filter_status').val(), id_jenis_tagihan: $('#filter_jenis').val(), search: $('#filter_search').val() },
            dataType: 'JSON',
            success: function (res) {
                var rows = res.data || [], html = '';
                if (!rows.length) {
                    html = '<div class="portal-list-item text-center text-muted portal-tagihan-item">Tidak ada tagihan pada filter yang dipilih.</div>';
                }
                rows.forEach(function (r) {
                    var old = '';
                    if (r.tahun_sebelumnya === 'Ya') {
                        old = r.dianggap_tunggakan === 'Ya'
                            ? '<span class="badge bg-danger-subtle text-danger ms-1">Tunggakan Tahun Sebelumnya</span>'
                            : '<span class="badge bg-light text-dark ms-1">Tagihan Tahun Sebelumnya</span>';
                    }
                    html += '<div class="portal-list-item portal-tagihan-item">' +
                        '<div class="d-flex justify-content-between gap-3 flex-wrap">' +
                        '<div class="flex-grow-1">' +
                        '<div><span class="badge ' + statusBadge(r.status_pembayaran) + '">' + escapeHtml(r.status_pembayaran) + '</span>' + old + '</div>' +
                        '<h5 class="mt-2 mb-1">' + escapeHtml(r.nama_tagihan) + '</h5>' +
                        '<div class="portal-meta">' + escapeHtml(r.nama_siswa) + ' | ' + escapeHtml(r.nama_kelas) + ' | ' + escapeHtml(r.periode) + '</div>' +
                        '</div>' +
                        '<a class="btn btn-sm btn-outline-primary align-self-center" href="<?= base_url('wali_murid/tagihan/detail/') ?>' + r.id + '">Detail</a>' +
                        '</div>' +
                        '<div class="row g-2 mt-2">' +
                        '<div class="col-md-4"><small class="text-muted">Tagihan</small><div>' + formatRupiah(r.nominal_tagihan) + '</div></div>' +
                        '<div class="col-md-4"><small class="text-muted">Dibayar</small><div>' + formatRupiah(r.nominal_dibayar) + '</div></div>' +
                        '<div class="col-md-4"><small class="text-muted">Sisa</small><div class="fw-semibold">' + formatRupiah(r.sisa_tagihan) + '</div></div>' +
                        '</div>' +
                        (r.tanggal_jatuh_tempo ? '<small class="text-muted d-block mt-2">Jatuh Tempo: ' + escapeHtml(r.tanggal_jatuh_tempo) + '</small>' : '') +
                        '</div>';
                });
                $('#data_tagihan').html(html);
                paging($('#data_tagihan .portal-tagihan-item'), parseInt($('#dt-length-0').val(), 10) || 10);
            },
            error: function (xhr) { ajaxError(xhr); }
        });
    }
    $(function () {
        loadTagihan();
        $('#btnCari').on('click', loadTagihan);
        $('#filter_status,#filter_jenis').on('change', loadTagihan);
        $('#filter_search').on('keyup', function (e) { if (e.key === 'Enter') loadTagihan(); });
        $('#dt-length-0').on('change', function () { paging($('#data_tagihan .portal-tagihan-item'), parseInt(this.value, 10) || 10); });
    });
</script>