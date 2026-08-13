            </div>

            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            2026 © Aplikasi Tagihan Sekolah
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                                <a href="<?= base_url('admin/pengaturan/log_aktivitas') ?>">Log Aktivitas</a>
                                <a href="<?= base_url('admin/pengaturan/format_bukti') ?>">Pengaturan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Plugin yang dipakai oleh view. Flatpickr sudah tersedia di vendor.min.js Adminto. -->
    <script src="<?= base_url('assets/js/pagination.js') ?>"></script>

    <!-- App Js resmi Adminto. -->
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
            var target = targetPagination || '#pagination';
            var $target = $(target);

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
            var isListTarget = $target.is('ul,ol');
            var $host = isListTarget ? $('<div></div>') : $target;

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

            if (isListTarget) {
                var $generated = $host.find('ul.pagination').first();
                $generated.attr('id', targetId).attr('class', targetClass);
                $target.replaceWith($generated);
            }

            return pagination;
        };

        window.confirmAction = function (title, text, callback) {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then(function (result) {
                if (result.isConfirmed) callback();
            });
        };

        window.parseMoneyInput = function (value) {
            if (typeof value === 'number') return Number.isFinite(value) ? value : 0;

            var text = String(value == null ? '' : value)
                .replace(/Rp/gi, '')
                .replace(/\s/g, '')
                .trim();

            if (/^-?\d+\.\d{1,2}$/.test(text)) {
                return Number(text);
            }

            var raw = typeof MoneyToNumber === 'function'
                ? MoneyToNumber(text)
                : text.replace(/,/g, '');
            raw = String(raw).replace(/[^0-9-]/g, '');
            return raw === '' || raw === '-' ? 0 : Number(raw);
        };

        window.formatMoneyInput = function (value) {
            var raw = String(parseMoneyInput(value));
            return typeof AddCommas === 'function' ? AddCommas(raw) : raw;
        };

        window.setMoneyInputValue = function (target, value) {
            $(target).val(formatMoneyInput(value));
        };

        window.serializeMoneyForm = function (form) {
            var $form = $(form);
            var original = [];

            $form.find('.money-input').each(function () {
                original.push({element: this, value: this.value});
                this.value = String(parseMoneyInput(this.value));
            });

            var data = $form.serialize();

            original.forEach(function (item) {
                item.element.value = item.value;
            });

            return data;
        };

        $(document).on('input', '.money-input:not([readonly]):not([disabled])', function () {
            var value = String(this.value || '').replace(/[^0-9]/g, '');
            this.value = value === '' ? '' : (typeof AddCommas === 'function' ? AddCommas(value) : value);
        });

    })();
    </script>
</body>
</html>
