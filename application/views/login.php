<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login | Aplikasi Tagihan Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Aplikasi Tagihan Sekolah">

    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <link href="<?= base_url('assets/css/vendor.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" id="app-style">
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="auth-bg d-flex min-vh-100">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xxl-3 col-lg-5 col-md-6">
                <a href="<?= base_url('login') ?>" class="auth-brand d-flex justify-content-center mb-2">
                    <img src="<?= base_url('assets/images/logo-dark.png') ?>" alt="Adminto" height="26" class="logo-dark">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Adminto" height="26" class="logo-light">
                </a>

                <p class="fw-semibold mb-4 text-center text-muted fs-15">Aplikasi Tagihan Sekolah</p>

                <div class="card overflow-hidden text-center p-xxl-4 p-3 mb-0">
                    <h4 class="fw-semibold mb-3 fs-18">Masuk ke akun Anda</h4>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger text-start"><?= html_escape($this->session->flashdata('error')) ?></div>
                    <?php endif; ?>

                    <form action="<?= base_url('login/proses') ?>" method="post" class="text-start mb-3">
                        <div class="mb-3">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan username" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="show-password">
                                <label class="form-check-label" for="show-password">Tampilkan password</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary fw-semibold" type="submit">Masuk</button>
                        </div>
                    </form>

                    <p class="text-muted fs-14 mb-0">Akun awal: <strong>admin</strong> / <strong>admin123</strong></p>
                </div>

                <p class="mt-4 text-center mb-0"><?= date('Y') ?> © Aplikasi Tagihan Sekolah</p>
            </div>
        </div>
    </div>

    <script src="<?= base_url('assets/js/vendor.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <script>
        document.getElementById('show-password').addEventListener('change', function () {
            document.getElementById('password').type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>
