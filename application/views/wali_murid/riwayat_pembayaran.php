<div class="card portal-card">
    <div class="card-header">
        <h4 class="mb-0">Riwayat Pembayaran</h4>
    </div>
    <div class="card-body">
        <div class="row g-2 align-items-end mb-3">
            <div class="col-md-5"><label class="form-label" for="dari_tanggal">Dari Tanggal</label><input type="text"
                    id="dari_tanggal" class="form-control" placeholder="dd-mm-yyyy"></div>
            <div class="col-md-5"><label class="form-label" for="sampai_tanggal">Sampai Tanggal</label><input
                    type="text" id="sampai_tanggal" class="form-control" placeholder="dd-mm-yyyy"></div>
            <div class="col-md-2"><button class="btn btn-primary w-100" id="btnCari"><i
                        class="ri-search-line me-1"></i>Cari</button></div>
        </div>
        <div id="data_riwayat"></div>
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-3">
            <ul class="pagination pagination-sm pagination-boxed mb-0" id="pagination"></ul>
            <div class="d-flex align-items-center gap-2"><label class="mb-0" for="dt-length-0">Tampilkan</label><select
                    class="form-select form-select-sm" id="dt-length-0">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select><span>entri</span></div>
        </div>
    </div>
</div>
<script>
    function loadRiwayat() {
        $.ajax({
            url: '<?= base_url('wali_murid/riwayat_pembayaran/result') ?>',
            type: 'POST',
            data: { dari_tanggal: $('#dari_tanggal').val(), sampai_tanggal: $('#sampai_tanggal').val() },
            dataType: 'JSON',
            success: function (res) {
                var rows = res.data || [], html = '';
                if (!rows.length) html = '<div class="portal-list-item text-center text-muted portal-riwayat-item">Belum ada transaksi pembayaran.</div>';
                rows.forEach(function (r) {
                    var badge = r.status_transaksi === 'Aktif' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                    html += '<div class="portal-list-item portal-riwayat-item"><div class="d-flex justify-content-between gap-3 flex-wrap">' +
                        '<div class="flex-grow-1"><div class="fw-semibold">' + escapeHtml(r.tanggal_transaksi) + ' | ' + escapeHtml(r.nama_siswa) + '</div>' +
                        '<div class="portal-meta">No. ' + escapeHtml(r.no_transaksi) + '</div><div class="mt-1">' + escapeHtml(r.rincian_tagihan || '-') + '</div>' +
                        '<div class="mt-1"><strong>' + formatRupiah(r.total_pembayaran) + '</strong> | ' + escapeHtml(r.nama_metode_pembayaran) + ' | <span class="badge ' + badge + '">' + escapeHtml(r.status_transaksi) + '</span></div></div>' +
                        '<div class="d-flex gap-1 align-self-center"><a class="btn btn-sm btn-outline-primary" href="<?= base_url('wali_murid/riwayat_pembayaran/detail/') ?>' + r.id + '">Detail</a><a target="_blank" class="btn btn-sm btn-primary" href="<?= base_url('wali_murid/bukti_pembayaran/cetak/') ?>' + r.id + '">Bukti</a></div>' +
                        '</div></div>';
                });
                $('#data_riwayat').html(html);
                paging($('#data_riwayat .portal-riwayat-item'), parseInt($('#dt-length-0').val(), 10) || 10);
            },
            error: function (xhr) { ajaxError(xhr); }
        });
    }
    $(function () {
        if (typeof flatpickr === 'function') flatpickr('#dari_tanggal,#sampai_tanggal', { dateFormat: 'd-m-Y' });
        loadRiwayat();
        $('#btnCari').on('click', loadRiwayat);
        $('#dt-length-0').on('change', function () { paging($('#data_riwayat .portal-riwayat-item'), parseInt(this.value, 10) || 10); });
    });
</script>