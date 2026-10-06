<?php
$wali_nama = isset($wali['nama_wali']) ? $wali['nama_wali'] : 'Wali Murid';
$current_uri = trim((string) $this->uri->uri_string(), '/');
$active = function ($path) use ($current_uri) {
    $path = trim((string) $path, '/');
    return $current_uri === $path || ($path !== '' && strpos($current_uri, $path . '/') === 0);
};
$show_global_filter = isset($show_global_filter) ? (bool) $show_global_filter : false;
$school = isset($sekolah) && is_array($sekolah) ? $sekolah : array();
$schoolName = !empty($school['nama_sekolah']) ? $school['nama_sekolah'] : 'Aplikasi Tagihan Sekolah';
$schoolLogo = !empty($school['logo_sekolah']) ? $school['logo_sekolah'] : 'assets/logo_almahbaro_edited.jpg';
$page_title = isset($title) && $title !== '' ? $title : 'Portal Wali Murid';
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light" data-layout="topnav" data-menu-color="brand" data-topbar-color="light">

<head>
    <meta charset="utf-8">
    <title><?= html_escape($page_title) ?> | SIPASTI</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Wali Murid Aplikasi Tagihan Sekolah">

    <link rel="shortcut icon" href="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>">

    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <link href="<?= base_url('assets/css/vendor.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" id="app-style">
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/vendor/flatpickr/flatpickr.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- Komponen visual yang sama dengan Admin. -->
    <link href="<?= base_url('assets/css/tagihan-custom.css') ?>" rel="stylesheet" type="text/css">
    <!-- Penyesuaian khusus layout Wali Murid: hanya top navigation dan komponen portal. -->
    <link href="<?= base_url('assets/css/wali-murid.css') ?>" rel="stylesheet" type="text/css">

    <script src="<?= base_url('assets/js/vendor.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.js') ?>"></script>
</head>

<body class="wali-layout">
    <div class="wrapper">
        <!-- Topbar menggunakan struktur Adminto yang sama dengan Admin. -->
        <header class="app-topbar" id="header">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2 min-w-0">
                    <a href="<?= base_url('wali_murid/dashboard') ?>" class="logo wali-logo">
                        <span class="logo-light">
                            <span class="logo-lg"><img src="<?= base_url($schoolLogo) ?>" alt="Logo sekolah"></span>
                            <span class="logo-sm"><img src="<?= base_url($schoolLogo) ?>" alt="Logo sekolah"></span>
                        </span>
                        <span class="logo-dark">
                            <span class="logo-lg"><img src="<?= base_url($schoolLogo) ?>" alt="Logo sekolah"></span>
                            <span class="logo-sm"><img src="<?= base_url($schoolLogo) ?>" alt="Logo sekolah"></span>
                        </span>
                    </a>

                    <button class="topnav-toggle-button px-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#waliTopnav" aria-controls="waliTopnav" aria-expanded="false"
                        aria-label="Buka atau tutup menu">
                        <i class="ri-menu-5-line fs-24"></i>
                    </button>

                    <div class="topbar-item d-flex px-2 min-w-0">
                        <div class="min-w-0">
                            <h4 class="page-title fs-20 fw-semibold mb-0 text-truncate"><?= html_escape($page_title) ?></h4>
                            <small class="text-muted d-none d-md-block text-truncate">Portal Wali Murid</small>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-1 ms-auto">
                    <div class="topbar-item d-flex">
                        <button class="topbar-link" id="light-dark-mode" type="button" aria-label="Ubah mode tampilan"
                            title="Mode terang/gelap">
                            <i class="ri-moon-line light-mode-icon fs-22"></i>
                            <i class="ri-sun-line dark-mode-icon fs-22"></i>
                        </button>
                    </div>

                    <div class="topbar-item nav-user">
                        <div class="dropdown">
                            <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                                data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?= base_url('assets/user.png') ?>" width="32"
                                    class="rounded-circle me-lg-2 d-flex" alt="Foto pengguna">
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    <h5 class="my-0"><?= html_escape($wali_nama) ?></h5>
                                </span>
                                <i class="ri-arrow-down-s-line d-none d-lg-block align-middle ms-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Wali Murid</h6>
                                </div>
                                <a class="dropdown-item" href="<?= base_url('wali_murid/profil') ?>">
                                    <i class="ri-user-line me-1 fs-16 align-middle"></i>
                                    <span class="align-middle">Profil</span>
                                </a>
                                <!-- <a class="dropdown-item" href="<= base_url('wali_murid/profil/ubah_password') ?>">
                                    <i class="ri-lock-password-line me-1 fs-16 align-middle"></i>
                                    <span class="align-middle">Ubah Password</span>
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item fw-semibold text-danger" href="<?= base_url('wali_murid/login/logout') ?>">
                                    <i class="ri-logout-box-line me-1 fs-16 align-middle"></i>
                                    <span class="align-middle">Keluar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Menu Wali Murid horizontal memakai topnav bawaan Adminto. -->
        <div class="topnav wali-topnav">
            <div class="page-container">
                <nav class="navbar navbar-expand-lg">
                    <div class="collapse navbar-collapse" id="waliTopnav">
                        <ul class="navbar-nav">
                            <li class="nav-item <?= $active('wali_murid/dashboard') ? 'active' : '' ?>">
                                <a class="nav-link <?= $active('wali_murid/dashboard') ? 'active' : '' ?>"
                                    href="<?= base_url('wali_murid/dashboard') ?>">
                                    <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item <?= $active('wali_murid/tagihan') ? 'active' : '' ?>">
                                <a class="nav-link <?= $active('wali_murid/tagihan') ? 'active' : '' ?>"
                                    href="<?= base_url('wali_murid/tagihan') ?>">
                                    <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                                    <span>Tagihan</span>
                                </a>
                            </li>
                            <li class="nav-item <?= ($active('wali_murid/riwayat_pembayaran') || $active('wali_murid/bukti_pembayaran')) ? 'active' : '' ?>">
                                <a class="nav-link <?= ($active('wali_murid/riwayat_pembayaran') || $active('wali_murid/bukti_pembayaran')) ? 'active' : '' ?>"
                                    href="<?= base_url('wali_murid/riwayat_pembayaran') ?>">
                                    <span class="menu-icon"><i class="ti ti-receipt"></i></span>
                                    <span>Riwayat Pembayaran</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="page-content">
            <div class="page-container">
                <?php if ($show_global_filter): ?>
                    <div class="card mb-3 wali-global-filter">
                        <div class="card-header">
                            <h4 class="header-title">Filter Data Wali Murid</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('wali_murid/dashboard/filter_global') ?>"
                                class="row g-2 align-items-end mb-0">
                                <input type="hidden" name="redirect" value="<?= html_escape($current_uri) ?>">
                                <div class="col-md-5">
                                    <label class="form-label" for="wali_filter_siswa">Anak</label>
                                    <select name="id_siswa" id="wali_filter_siswa" class="form-select">
                                        <option value="0">Semua Anak</option>
                                        <?php foreach ((isset($anak) ? $anak : array()) as $a): ?>
                                            <option value="<?= (int) $a['id_siswa'] ?>"
                                                <?= (int) (isset($id_siswa_filter) ? $id_siswa_filter : 0) === (int) $a['id_siswa'] ? 'selected' : '' ?>>
                                                <?= html_escape($a['nama_lengkap']) ?><?= !empty($a['nama_kelas']) ? ' - ' . html_escape($a['nama_kelas']) : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label" for="wali_filter_periode">Tahun Ajaran</label>
                                    <select name="id_periode" id="wali_filter_periode" class="form-select">
                                        <?php foreach ((isset($periode_list) ? $periode_list : array()) as $p): ?>
                                            <option value="<?= (int) $p['id'] ?>"
                                                <?= (int) (isset($id_periode_filter) ? $id_periode_filter : 0) === (int) $p['id'] ? 'selected' : '' ?>>
                                                <?= html_escape($p['periode']) ?><?= $p['status'] === 'Aktif' ? ' - Aktif' : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <i class="ri-filter-3-line me-1"></i>Tampilkan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($this->session->flashdata('portal_error')): ?>
                    <div class="alert alert-danger"><?= html_escape($this->session->flashdata('portal_error')) ?></div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('portal_success')): ?>
                    <div class="alert alert-success"><?= html_escape($this->session->flashdata('portal_success')) ?></div>
                <?php endif; ?>
                <?php if ($show_global_filter && empty($anak)): ?>
                    <div class="alert alert-warning">Belum ada relasi siswa aktif pada akun ini. Silakan hubungi admin sekolah.</div>
                <?php endif; ?>
