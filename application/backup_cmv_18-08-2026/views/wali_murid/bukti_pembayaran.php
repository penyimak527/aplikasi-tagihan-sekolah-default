<div class="card portal-card">
    <div class="card-header">
        <h4 class="mb-0">Bukti Pembayaran</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">Daftar bukti transaksi yang telah dicatat secara resmi oleh sekolah.</p>
        <div id="data_bukti"></div>
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
    function loadBukti() {
        $.ajax({
            url: '<?= base_url('wali_murid/bukti_pembayaran/result') ?>',
            type: 'POST',
            data: {},
            dataType: 'JSON',
            success: function(res) {
                var rows = res.data || [],
                    html = '';
                if (!rows.length) html = '<div class="portal-list-item text-center text-muted portal-bukti-item">Belum ada bukti pembayaran.</div>';
                rows.forEach(function(r) {
                    var badge = r.status_transaksi === 'Aktif' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger';
                    html += '<div class="portal-list-item portal-bukti-item"><div class="d-flex justify-content-between gap-3 flex-wrap">' +
                        '<div class="flex-grow-1"><strong>' + escapeHtml(r.no_transaksi) + '</strong><div>' + escapeHtml(r.tanggal_transaksi) + ' • ' + escapeHtml(r.nama_siswa) + ' • ' + escapeHtml(r.nama_kelas) + '</div>' +
                        '<div class="portal-meta">' + escapeHtml(r.rincian_tagihan || '-') + '</div><div class="fw-semibold mt-1">' + formatRupiah(r.total_pembayaran) + ' <span class="badge ' + badge + ' ms-1">' + escapeHtml(r.status_transaksi) + '</span></div></div>' +
                        '<div class="d-flex gap-1 align-self-center"><a class="btn btn-sm btn-outline-primary" href="<?= base_url('wali_murid/riwayat_pembayaran/detail/') ?>' + r.id + '">Detail</a><a target="_blank" class="btn btn-sm btn-primary" href="<?= base_url('wali_murid/bukti_pembayaran/cetak/') ?>' + r.id + '"><i class="ri-printer-line me-1"></i>Cetak / Simpan PDF</a></div>' +
                        '</div></div>';
                });
                $('#data_bukti').html(html);
                paging($('#data_bukti .portal-bukti-item'), parseInt($('#dt-length-0').val(), 10) || 10);
            },
            error: function(xhr) {
                ajaxError(xhr);
            }
        });
    }
    $(function() {
        loadBukti();
        $('#dt-length-0').on('change', function() {
            paging($('#data_bukti .portal-bukti-item'), parseInt(this.value, 10) || 10);
        });
    });
</script>