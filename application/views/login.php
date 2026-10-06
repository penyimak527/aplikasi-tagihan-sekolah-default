<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Login | SIPASTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Sistem Informasi & Pengelolaan Administrasi Sekolah Terpadu.">

    <link rel="shortcut icon" href="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>">
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <link href="<?= base_url('assets/css/vendor.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" id="app-style">
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css">
</head>
<body>
    <div class="auth-bg d-flex min-vh-100">
        <div class="row g-0 justify-content-center align-items-center w-100 m-0 p-2 auth-login-layout">
            <div class="col-xxl-4 col-xl-4 col-lg-5 col-md-7 col-sm-9 auth-login-column">
                <div class="text-center auth-login-branding">
                    <a href="<?= base_url('login') ?>" class="auth-brand d-inline-flex justify-content-center">
                        <img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>" alt="Al Mahbaroh" class="auth-login-logo">
                    </a>
                    <h2 class="auth-login-name">SIPASTI</h2>
                    <p class="auth-login-description fw-bold">Sistem Informasi & Pengelolaan Administrasi Sekolah Terpadu.</p>
                </div>

                <div class="card overflow-hidden text-center p-3 mb-0 auth-login-card">
                    <h4 class="fw-semibold mb-1 fs-18">Masuk ke akun Anda</h4>

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
                </div>

                <p class="mt-3 text-center mb-0 auth-login-footer fw-bold">2026 © Almahbaroh Lumajang - Di kembangkan oleh <a href="https://pyramidsoft.co.id" target="_blank" class="text-white ">pyramidsoft.co.id</a></p>
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
