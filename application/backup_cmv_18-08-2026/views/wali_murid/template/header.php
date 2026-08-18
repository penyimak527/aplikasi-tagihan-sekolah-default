<?php
$wali_nama = isset($wali['nama_wali']) ? $wali['nama_wali'] : 'Wali Murid';
$current_uri = trim((string) $this->uri->uri_string(), '/');
$active = function ($path) use ($current_uri) {
    $path = trim($path, '/');
    return $current_uri === $path || strpos($current_uri, $path . '/') === 0;
};
$show_global_filter = isset($show_global_filter) ? (bool) $show_global_filter : false;
$school = isset($sekolah) && is_array($sekolah) ? $sekolah : array();
$schoolName = !empty($school['nama_sekolah']) ? $school['nama_sekolah'] : 'Aplikasi Tagihan Sekolah';
$schoolLogo = !empty($school['logo_sekolah']) ? $school['logo_sekolah'] : 'assets/logo_almahbaro_edited.jpg';
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <title><?= html_escape(isset($title) ? $title : 'Portal Wali Murid') ?> | Portal Wali Murid</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Wali Murid Aplikasi Tagihan Sekolah">
    <link rel="shortcut icon" href="<?= base_url($schoolLogo) ?>">
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <link href="<?= base_url('assets/css/vendor.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" id="app-style">
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/vendor/flatpickr/flatpickr.min.css') ?>" rel="stylesheet">
    <script src="<?= base_url('assets/js/vendor.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.js') ?>"></script>
    <style>
        body {
            background: #f5f7fb;
        }

        a {
            text-decoration: none;
        }

        .portal-topbar {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
        }

        .portal-shell {
            max-width: 1180px;
            margin: 0 auto;
        }

        .portal-brand img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 50%;
        }

        .portal-nav {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
            overflow-x: auto;
            white-space: nowrap;
        }

        .portal-nav a {
            display: inline-block;
            padding: 14px 16px;
            color: #495057;
            font-weight: 600;
            border-bottom: 2px solid transparent;
        }

        .portal-nav a.active {
            color: var(--ct-primary, #3b82f6);
            border-bottom-color: var(--ct-primary, #3b82f6);
        }

        .portal-filter {
            background: #fff;
            border-bottom: 1px solid #e9ecef;
        }

        .portal-main {
            max-width: 1180px;
            margin: 0 auto;
            padding: 24px 16px 40px;
        }

        .portal-card {
            border: 1px solid #e9ecef;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .04);
        }

        .portal-list-item {
            border: 1px solid var(--bs-border-color);
            border-radius: .55rem;
            padding: 1rem;
            background: var(--bs-body-bg);
        }

        .portal-list-item+.portal-list-item {
            margin-top: .65rem;
        }

        .portal-stat-value {
            font-size: 1.35rem;
            font-weight: 700;
        }

        .portal-meta {
            color: var(--bs-secondary-color);
            font-size: .875rem;
        }

        @media (max-width:767.98px) {
            .portal-user-name {
                display: none;
            }

            .portal-main {
                padding: 16px 12px 30px;
            }

            .portal-filter .btn {
                width: 100%;
            }

            .portal-nav a {
                padding: 12px 13px;
            }
        }
    </style>
</head>

<body>
    <header class="portal-topbar">
        <div class="container-fluid portal-shell">
            <div class="d-flex align-items-center justify-content-between py-3 gap-3">
                <a href="<?= base_url('wali_murid/dashboard') ?>" class="portal-brand d-flex align-items-center gap-2 text-reset">
                    <img src="<?= base_url($schoolLogo) ?>" alt="Logo sekolah">
                    <div>
                        <div class="fw-bold"><?= html_escape($schoolName) ?></div>
                        <small class="text-muted">Portal Wali Murid</small>
                    </div>
                </a>
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" type="button">
                        <span class="portal-user-name">Halo, <?= html_escape($wali_nama) ?></span>
                        <i class="ri-user-3-line ms-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="<?= base_url('wali_murid/profil') ?>"><i class="ri-user-line me-1"></i> Profil</a>
                        <a class="dropdown-item" href="<?= base_url('wali_murid/profil/ubah_password') ?>"><i class="ri-lock-password-line me-1"></i> Ubah Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= base_url('wali_murid/login/logout') ?>"><i class="ri-logout-box-line me-1"></i> Keluar</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <nav class="portal-nav">
        <div class="container-fluid portal-shell">
            <a class="<?= $active('wali_murid/dashboard') ? 'active' : '' ?>" href="<?= base_url('wali_murid/dashboard') ?>">Beranda</a>
            <a class="<?= $active('wali_murid/tagihan') ? 'active' : '' ?>" href="<?= base_url('wali_murid/tagihan') ?>">Tagihan</a>
            <a class="<?= $active('wali_murid/riwayat_pembayaran') ? 'active' : '' ?>" href="<?= base_url('wali_murid/riwayat_pembayaran') ?>">Riwayat Pembayaran</a>
            <a class="<?= $active('wali_murid/bukti_pembayaran') ? 'active' : '' ?>" href="<?= base_url('wali_murid/bukti_pembayaran') ?>">Bukti Pembayaran</a>
        </div>
    </nav>
    <?php if ($show_global_filter): ?>
        <section class="portal-filter">
            <div class="container-fluid portal-shell py-3">
                <form method="post" action="<?= base_url('wali_murid/dashboard/filter_global') ?>" class="row g-2 align-items-end">
                    <input type="hidden" name="redirect" value="<?= html_escape($current_uri) ?>">
                    <div class="col-md-5">
                        <label class="form-label mb-1">Anak</label>
                        <select name="id_siswa" class="form-select">
                            <option value="0">Semua Anak</option>
                            <?php foreach ((isset($anak) ? $anak : array()) as $a): ?>
                                <option value="<?= (int) $a['id_siswa'] ?>" <?= (int)(isset($id_siswa_filter) ? $id_siswa_filter : 0) === (int)$a['id_siswa'] ? 'selected' : '' ?>>
                                    <?= html_escape($a['nama_lengkap']) ?><?= !empty($a['nama_kelas']) ? ' - ' . html_escape($a['nama_kelas']) : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label mb-1">Tahun Ajaran</label>
                        <select name="id_periode" class="form-select">
                            <?php foreach ((isset($periode_list) ? $periode_list : array()) as $p): ?>
                                <option value="<?= (int) $p['id'] ?>" <?= (int)(isset($id_periode_filter) ? $id_periode_filter : 0) === (int)$p['id'] ? 'selected' : '' ?>>
                                    <?= html_escape($p['periode']) ?><?= $p['status'] === 'Aktif' ? ' (Aktif)' : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2"><button class="btn btn-primary w-100" type="submit"><i class="ri-filter-3-line me-1"></i>Terapkan</button></div>
                </form>
            </div>
        </section>
    <?php endif; ?>
    <main class="portal-main">
        <?php if ($this->session->flashdata('portal_error')): ?>
            <div class="alert alert-danger"><?= html_escape($this->session->flashdata('portal_error')) ?></div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('portal_success')): ?>
            <div class="alert alert-success"><?= html_escape($this->session->flashdata('portal_success')) ?></div>
        <?php endif; ?>
        <?php if ($show_global_filter && empty($anak)): ?>
            <div class="alert alert-warning">Belum ada relasi siswa aktif pada akun ini. Silakan hubungi admin sekolah.</div>
        <?php endif; ?>