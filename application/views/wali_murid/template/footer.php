            </div>

            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            2026 © Almahbaroh Lumajang - Portal Wali Murid
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="<?= base_url('wali_murid/dashboard') ?>">Dashboard</a>
                                <a href="<?= base_url('wali_murid/tagihan') ?>">Tagihan</a>
                                <a href="<?= base_url('wali_murid/profil') ?>">Profil</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="<?= base_url('assets/js/pagination.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <script>
    (function () {
        window.appBaseUrl = '<?= base_url() ?>';

        window.formatRupiah = function (value) {
            return 'Rp' + new Intl.NumberFormat('id-ID').format(Number(value || 0));
        };

        window.escapeHtml = function (text) {
            return $('<div>').text(text == null ? '' : text).html();
        };

        window.ajaxError = function (xhr) {
            var message = 'Terjadi kesalahan saat memproses data.';
            if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            Swal.fire('Gagal', message, 'error');
        };

        window.paging = function ($selector, jumlahTampil, targetPagination) {
            var $rows = $selector instanceof jQuery ? $selector : $($selector);
            var pageSize = parseInt(jumlahTampil, 10) || 10;
            var $target = $(targetPagination || '#pagination');

            if (!$target.length) {
                return null;
            }

            $rows.show();
            $target.empty();

            if (typeof Pagination !== 'function') {
                $target.html(
                    '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="ri-skip-left-line"></i></a></li>' +
                    '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="ri-arrow-left-s-line"></i></a></li>' +
                    '<li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>' +
                    '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="ri-arrow-right-s-line"></i></a></li>' +
                    '<li class="page-item disabled"><a class="page-link" href="javascript:void(0)"><i class="ri-skip-right-line"></i></a></li>'
                );
                return null;
            }

            var targetId = $target.attr('id') || '';
            var targetClass = $target.attr('class') || 'pagination pagination-sm pagination-boxed mb-0';
            var isList = $target.is('ul,ol');
            var $host = isList ? $('<div></div>') : $target;

            var pagination = new Pagination($host.get(0), {
                itemsCount: Math.max($rows.length, 1),
                pageSize: pageSize,
                labels: {
                    first: '<i class="ri-skip-left-line"></i>',
                    previous: '<i class="ri-arrow-left-s-line"></i>',
                    next: '<i class="ri-arrow-right-s-line"></i>',
                    last: '<i class="ri-skip-right-line"></i>'
                },
                onPageChange: function (page) {
                    var start = page.pageSize * (page.currentPage - 1);
                    var end = start + page.pageSize;
                    $rows.hide();
                    $rows.slice(start, end).show();
                }
            });

            if (isList) {
                var $generated = $host.find('ul.pagination').first();
                $generated.attr('id', targetId).attr('class', targetClass);
                $target.replaceWith($generated);
            }

            return pagination;
        };
    })();
    </script>
</body>
</html>
