</main>
<footer class="border-top bg-white py-3">
    <div class="container-fluid text-center text-muted portal-shell">
        2026 © Aplikasi Tagihan Sekolah - Portal Wali Murid
    </div>
</footer>
<script src="<?= base_url('assets/js/pagination.js') ?>"></script>
<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script>
    window.formatRupiah = function(value) {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(Number(value || 0));
    };
    window.escapeHtml = function(text) {
        return $('<div>').text(text == null ? '' : text).html();
    };
    window.ajaxError = function(xhr) {
        var message = 'Terjadi kesalahan saat memproses data.';
        if (xhr && xhr.responseJSON && xhr.responseJSON.message) message = xhr.responseJSON.message;
        Swal.fire('Gagal', message, 'error');
    };
    window.paging = function($selector, jumlahTampil, targetPagination) {
        var $rows = $selector instanceof jQuery ? $selector : $($selector);
        var pageSize = parseInt(jumlahTampil, 10) || 10;
        var $target = $(targetPagination || '#pagination');
        if (!$target.length) return null;
        $rows.show();
        $target.empty();
        if (typeof Pagination !== 'function') {
            $target.html('<li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="ri-arrow-left-s-line"></i></a></li><li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li><li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="ri-arrow-right-s-line"></i></a></li>');
            return null;
        }
        var targetId = $target.attr('id') || '';
        var targetClass = $target.attr('class') || 'pagination pagination-sm pagination-boxed mb-0';
        var isList = $target.is('ul,ol');
        var $host = isList ? $('<div></div>') : $target;
        new Pagination($host.get(0), {
            itemsCount: Math.max($rows.length, 1),
            pageSize: pageSize,
            labels: {
                first: '<i class="ri-skip-left-line"></i>',
                previous: '<i class="ri-arrow-left-s-line"></i>',
                next: '<i class="ri-arrow-right-s-line"></i>',
                last: '<i class="ri-skip-right-line"></i>'
            },
            onPageChange: function(page) {
                var start = page.pageSize * (page.currentPage - 1);
                $rows.hide().slice(start, start + page.pageSize).show();
            }
        });
        if (isList) {
            var $generated = $host.find('ul.pagination').first();
            $generated.attr('id', targetId).attr('class', targetClass);
            $target.replaceWith($generated);
        }
    };
</script>
</body>

</html>