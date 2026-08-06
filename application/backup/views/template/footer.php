            </div>

            <footer class="footer">
                <div class="page-container">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start">
                            <?= date('Y') ?> © Aplikasi Tagihan Sekolah
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="<?= base_url('dashboard') ?>">Dashboard</a>
                                <a href="<?= base_url('log_aktivitas') ?>">Log Aktivitas</a>
                                <a href="<?= base_url('format_bukti') ?>">Pengaturan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Plugin yang dipakai oleh view. -->
    <script src="<?= base_url('assets/vendor/flatpickr/flatpickr.min.js') ?>"></script>

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
