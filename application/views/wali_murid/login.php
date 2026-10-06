<?php
$school = isset($sekolah) && is_array($sekolah) ? $sekolah : array();
$schoolName = !empty($school['nama_sekolah']) ? $school['nama_sekolah'] : 'Aplikasi Tagihan Sekolah';
$schoolLogo = !empty($school['logo_sekolah']) ? $school['logo_sekolah'] : 'assets/logo_almahbaro_edited.jpg';
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title>Login | Portal Wali Murid</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login Portal Wali Murid">
        <link rel="shortcut icon" href="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>">
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <link href="<?= base_url('assets/css/vendor.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/vendor.min.js') ?>"></script>
    <style>
        body {
            min-height: 100vh;
            background-image: linear-gradient(rgba(17, 24, 39, .30), rgba(17, 24, 39, .30)), url('<?= base_url('assets/almahbaro_login.webp') ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            display: flex;
            align-items: center;
        }

        .login-card {
            max-width: 410px;
            margin: auto;
            width: 100%;
            border: 1px solid rgba(255, 255, 255, .55);
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .16);
            background: rgba(255, 255, 255, .91);
            -webkit-backdrop-filter: blur(7px);
            backdrop-filter: blur(7px);
        }

        .login-card .card-body {
            padding: 28px 30px;
        }

        .login-logo {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            object-fit: cover;
        }

        @media (max-width: 575.98px) {
            body {
                align-items: center;
                background-attachment: scroll;
            }

            .login-card {
                max-width: 100%;
            }

            .login-card .card-body {
                padding: 24px 22px;
            }
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="card login-card">
            <div class="card-body">
                <div class="text-center mb-4">
                    <img class="login-logo mb-3" src="<?= base_url($schoolLogo) ?>" alt="Logo sekolah">
                    <div class="fw-semibold text-muted mb-1"><?= html_escape($schoolName) ?></div>
                    <h3 class="mb-0">Portal Wali Murid</h3>
                </div>

                <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger"><?= html_escape($this->session->flashdata('error')) ?></div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('wali_murid/login/proses') ?>" id="formLoginWali">
                    <div class="mb-3">
                        <label class="form-label" for="usernameWali">Username</label>
                        <input type="text" class="form-control" name="username" id="usernameWali"
                            autocomplete="username" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="passwordWali">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="passwordWali"
                                autocomplete="current-password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                aria-label="Tampilkan atau sembunyikan password"><i class="ri-eye-line"></i></button>
                        </div>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="ingatUsername">
                        <label class="form-check-label" for="ingatUsername">Ingat username</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">Masuk</button>
                </form>
                <p class="text-center text-muted mt-4 mb-0">Jika lupa password, silakan hubungi administrasi sekolah.</p>
            </div>
        </div>
    </div>
    <script>
        (function () {
            var saved = localStorage.getItem('wali_murid_username') || '';
            if (saved) {
                $('#usernameWali').val(saved);
                $('#ingatUsername').prop('checked', true);
            }
            $('#togglePassword').on('click', function () {
                var $password = $('#passwordWali');
                var show = $password.attr('type') === 'password';
                $password.attr('type', show ? 'text' : 'password');
                $(this).find('i').attr('class', show ? 'ri-eye-off-line' : 'ri-eye-line');
            });
            $('#formLoginWali').on('submit', function () {
                if ($('#ingatUsername').is(':checked')) {
                    localStorage.setItem('wali_murid_username', $('#usernameWali').val());
                } else {
                    localStorage.removeItem('wali_murid_username');
                }
            });
        })();
    </script>
</body>

</html>
