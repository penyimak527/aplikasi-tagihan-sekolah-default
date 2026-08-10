<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = app_user();
$user_name = isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator';
$user_role = isset($user['role']) && $user['role'] !== '' ? $user['role'] : 'Admin';
$page_title = isset($title) && $title !== '' ? $title : 'Aplikasi Tagihan Sekolah';

$id_level = (int) $this->session->userdata('admin')['id_level'];

// Menu sidebar mengikuti contoh CMV: diambil langsung dari list_menu sesuai level login.
$menuDashboard = $this->db->query(
    "SELECT a.* FROM list_menu a LEFT JOIN menu b ON a.id_menu = b.id WHERE a.id_level = ? AND a.`group` = 'Dashboard' ORDER BY b.urut ASC",
    array($id_level)
)->row_array();

$menuMaster = $this->db->query(
    "SELECT a.* FROM list_menu a LEFT JOIN menu b ON a.id_menu = b.id WHERE a.id_level = ? AND a.`group` = 'Master Data' ORDER BY b.urut ASC",
    array($id_level)
)->result_array();

$menuKesiswaan = $this->db->query(
    "SELECT a.* FROM list_menu a LEFT JOIN menu b ON a.id_menu = b.id WHERE a.id_level = ? AND a.`group` = 'Kesiswaan' ORDER BY b.urut ASC",
    array($id_level)
)->result_array();

$menuTagihan = $this->db->query(
    "SELECT a.* FROM list_menu a LEFT JOIN menu b ON a.id_menu = b.id WHERE a.id_level = ? AND a.`group` = 'Tagihan' ORDER BY b.urut ASC",
    array($id_level)
)->result_array();

$menuTransaksi = $this->db->query(
    "SELECT a.* FROM list_menu a LEFT JOIN menu b ON a.id_menu = b.id WHERE a.id_level = ? AND a.`group` = 'Transaksi' ORDER BY b.urut ASC",
    array($id_level)
)->result_array();

$menuTunggakan = $this->db->query(
    "SELECT a.* FROM list_menu a LEFT JOIN menu b ON a.id_menu = b.id WHERE a.id_level = ? AND a.`group` = 'Tagihan & Tunggakan' ORDER BY b.urut ASC",
    array($id_level)
)->result_array();

$menuLaporan = $this->db->query(
    "SELECT a.* FROM list_menu a LEFT JOIN menu b ON a.id_menu = b.id WHERE a.id_level = ? AND a.`group` = 'Laporan' ORDER BY b.urut ASC",
    array($id_level)
)->result_array();

$menuPengaturan = $this->db->query(
    "SELECT a.* FROM list_menu a LEFT JOIN menu b ON a.id_menu = b.id WHERE a.id_level = ? AND a.`group` = 'Pengaturan' ORDER BY b.urut ASC",
    array($id_level)
)->result_array();

$current_uri = trim((string) $this->uri->uri_string(), '/');
$menu_admin_path = function ($path) {
    $path = trim((string) $path, '/');
    if ($path === '' || $path === 'dashboard' || strpos($path, 'admin/') === 0) {
        return $path;
    }
    return 'admin/' . $path;
};

$is_menu_active = function ($path) use ($current_uri, $menu_admin_path) {
    $path = $menu_admin_path($path);
    return $current_uri === $path || ($path !== '' && strpos($current_uri, $path . '/') === 0);
};
$is_group_active = function ($menus) use ($is_menu_active) {
    foreach ($menus as $menu) {
        if (!empty($menu['path']) && $is_menu_active($menu['path'])) {
            return true;
        }
    }
    return false;
};

$master_open = $is_group_active($menuMaster);
$kesiswaan_open = $is_group_active($menuKesiswaan);
$tagihan_open = $is_group_active($menuTagihan);
$transaksi_open = $is_group_active($menuTransaksi);
$tunggakan_open = $is_group_active($menuTunggakan);
$laporan_open = $is_group_active($menuLaporan);
$pengaturan_open = $is_group_active($menuPengaturan);
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light" data-menu-color="light" data-topbar-color="light" data-sidenav-size="default">

<head>
    <meta charset="utf-8">
    <title><?= html_escape($page_title) ?> | Aplikasi Tagihan Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Tagihan Sekolah">

    <link rel="shortcut icon" href="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>">

    <!-- Konfigurasi dan asset resmi Adminto. -->
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
    <link href="<?= base_url('assets/css/vendor.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" id="app-style">
    <link href="<?= base_url('assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/vendor/flatpickr/flatpickr.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.css') ?>" rel="stylesheet" type="text/css">

    <!-- Penyesuaian hanya untuk komponen aplikasi, bukan mengganti layout Adminto. -->
    <link href="<?= base_url('assets/css/tagihan-custom.css') ?>" rel="stylesheet" type="text/css">

    <!-- vendor.min.js asli Adminto sudah memuat jQuery dan Bootstrap. -->
    <script src="<?= base_url('assets/js/vendor.min.js') ?>"></script>

    <script>
        if (typeof window.jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
        }
    </script>

    <script src="<?= base_url('assets/js/js-form.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/apexcharts/apexcharts.min.js') ?>"></script>
</head>

<body>
    <!-- Begin page -->
    <div class="wrapper">

        <!-- Sidenav Menu Start: struktur langsung dari template Adminto. -->
        <div class="sidenav-menu">
            <a href="<?= base_url('dashboard') ?>" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"><img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>"
                            alt="Adminto"></span>
                    <span class="logo-sm"><img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>"
                            alt="Adminto"></span>
                </span>
                <span class="logo-dark">
                    <span class="logo-lg"><img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>"
                            alt="Adminto"></span>
                    <span class="logo-sm"><img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>"
                            alt="Adminto"></span>
                </span>
            </a>

            <button class="button-sm-hover" type="button" aria-label="Mode sidebar ringkas">
                <i class="ri-circle-line align-middle"></i>
            </button>
            <button class="sidenav-toggle-button" type="button" aria-label="Buka atau tutup sidebar">
                <i class="ri-menu-5-line fs-20"></i>
            </button>
            <button class="button-close-fullsidebar" type="button" aria-label="Tutup sidebar">
                <i class="ti ti-x align-middle"></i>
            </button>

            <div data-simplebar>
                <div class="sidenav-user">
                    <div class="dropdown-center text-center">
                        <a class="topbar-link dropdown-toggle text-reset drop-arrow-none px-2" data-bs-toggle="dropdown"
                            type="button" aria-haspopup="false" aria-expanded="false">
                            <img src="<?= base_url('assets/user.png') ?>" width="46" class="rounded-circle"
                                alt="Foto pengguna">
                            <span class="d-flex gap-1 sidenav-user-name my-2">
                                <span>
                                    <span class="mb-0 fw-semibold lh-base fs-15"><?= html_escape($user_name) ?></span>
                                    <p class="my-0 fs-13 text-muted"><?= html_escape($user_role) ?></p>
                                </span>
                                <i class="ri-arrow-down-s-line d-block sidenav-user-arrow align-middle"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Aplikasi Tagihan Sekolah</h6>
                            </div>
                            <?php $log_menu = array_filter($menuPengaturan, function ($m) {
                                return isset($m['path']) && $m['path'] === 'admin/pengaturan/log_aktivitas'; }); ?>
                            <?php if (!empty($log_menu)): ?>
                                <a href="<?= base_url('admin/pengaturan/log_aktivitas') ?>" class="dropdown-item">
                                    <i class="ri-history-line me-1 fs-16 align-middle"></i>
                                    <span class="align-middle">Log Aktivitas</span>
                                </a>
                                <div class="dropdown-divider"></div>
                            <?php endif; ?>
                            <a href="<?= base_url('login/logout') ?>"
                                class="dropdown-item active fw-semibold text-danger">
                                <i class="ri-logout-box-line me-1 fs-16 align-middle"></i>
                                <span class="align-middle">Keluar</span>
                            </a>
                        </div>
                    </div>
                </div>

                <ul class="side-nav">
                    <?php if ($menuDashboard): ?>
                        <li class="side-nav-item">
                            <a href="<?= base_url($menu_admin_path($menuDashboard['path'])) ?>"
                                class="side-nav-link <?= $is_menu_active($menuDashboard['path']) ? 'active' : '' ?>">
                                <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                                <span class="menu-text"><?= html_escape($menuDashboard['name']) ?></span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($menuMaster || $menuKesiswaan): ?>
                        <li class="side-nav-title mt-2">Data dan Akademik</li>
                    <?php endif; ?>

                    <?php if ($menuMaster): ?>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#menuMaster"
                                aria-expanded="<?= $master_open ? 'true' : 'false' ?>" aria-controls="menuMaster"
                                class="side-nav-link <?= $master_open ? 'active' : '' ?>">
                                <span class="menu-icon"><i class="ti ti-database"></i></span>
                                <span class="menu-text">Master Data</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse <?= $master_open ? 'show' : '' ?>" id="menuMaster">
                                <ul class="sub-menu">
                                    <?php foreach ($menuMaster as $menu): ?>
                                        <li class="side-nav-item">
                                            <a href="<?= base_url($menu_admin_path($menu['path'])) ?>"
                                                class="side-nav-link <?= $is_menu_active($menu['path']) ? 'active' : '' ?>">
                                                <span class="menu-text"><?= html_escape($menu['name']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($menuKesiswaan): ?>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#menuKesiswaan"
                                aria-expanded="<?= $kesiswaan_open ? 'true' : 'false' ?>" aria-controls="menuKesiswaan"
                                class="side-nav-link <?= $kesiswaan_open ? 'active' : '' ?>">
                                <span class="menu-icon"><i class="ti ti-users-group"></i></span>
                                <span class="menu-text">Kesiswaan</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse <?= $kesiswaan_open ? 'show' : '' ?>" id="menuKesiswaan">
                                <ul class="sub-menu">
                                    <?php foreach ($menuKesiswaan as $menu): ?>
                                        <li class="side-nav-item">
                                            <a href="<?= base_url($menu_admin_path($menu['path'])) ?>"
                                                class="side-nav-link <?= $is_menu_active($menu['path']) ? 'active' : '' ?>">
                                                <span class="menu-text"><?= html_escape($menu['name']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($menuTagihan || $menuTransaksi || $menuTunggakan): ?>
                        <li class="side-nav-title mt-2">Tagihan dan Pembayaran</li>
                    <?php endif; ?>

                    <?php if ($menuTagihan): ?>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#menuTagihan"
                                aria-expanded="<?= $tagihan_open ? 'true' : 'false' ?>" aria-controls="menuTagihan"
                                class="side-nav-link <?= $tagihan_open ? 'active' : '' ?>">
                                <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                                <span class="menu-text">Tagihan</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse <?= $tagihan_open ? 'show' : '' ?>" id="menuTagihan">
                                <ul class="sub-menu">
                                    <?php foreach ($menuTagihan as $menu): ?>
                                        <li class="side-nav-item">
                                            <a href="<?= base_url($menu_admin_path($menu['path'])) ?>"
                                                class="side-nav-link <?= $is_menu_active($menu['path']) ? 'active' : '' ?>">
                                                <span class="menu-text"><?= html_escape($menu['name']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($menuTransaksi): ?>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#menuTransaksi"
                                aria-expanded="<?= $transaksi_open ? 'true' : 'false' ?>" aria-controls="menuTransaksi"
                                class="side-nav-link <?= $transaksi_open ? 'active' : '' ?>">
                                <span class="menu-icon"><i class="ti ti-cash"></i></span>
                                <span class="menu-text">Transaksi</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse <?= $transaksi_open ? 'show' : '' ?>" id="menuTransaksi">
                                <ul class="sub-menu">
                                    <?php foreach ($menuTransaksi as $menu): ?>
                                        <li class="side-nav-item">
                                            <a href="<?= base_url($menu_admin_path($menu['path'])) ?>"
                                                class="side-nav-link <?= $is_menu_active($menu['path']) ? 'active' : '' ?>">
                                                <span class="menu-text"><?= html_escape($menu['name']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($menuTunggakan): ?>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#menuTunggakan"
                                aria-expanded="<?= $tunggakan_open ? 'true' : 'false' ?>" aria-controls="menuTunggakan"
                                class="side-nav-link <?= $tunggakan_open ? 'active' : '' ?>">
                                <span class="menu-icon"><i class="ti ti-alert-circle"></i></span>
                                <span class="menu-text">Tagihan &amp; Tunggakan</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse <?= $tunggakan_open ? 'show' : '' ?>" id="menuTunggakan">
                                <ul class="sub-menu">
                                    <?php foreach ($menuTunggakan as $menu): ?>
                                        <li class="side-nav-item">
                                            <a href="<?= base_url($menu_admin_path($menu['path'])) ?>"
                                                class="side-nav-link <?= $is_menu_active($menu['path']) ? 'active' : '' ?>">
                                                <span class="menu-text"><?= html_escape($menu['name']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($menuLaporan || $menuPengaturan): ?>
                        <li class="side-nav-title mt-2">Monitoring</li>
                    <?php endif; ?>

                    <?php if ($menuLaporan): ?>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#menuLaporan"
                                aria-expanded="<?= $laporan_open ? 'true' : 'false' ?>" aria-controls="menuLaporan"
                                class="side-nav-link <?= $laporan_open ? 'active' : '' ?>">
                                <span class="menu-icon"><i class="ti ti-report-analytics"></i></span>
                                <span class="menu-text">Laporan</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse <?= $laporan_open ? 'show' : '' ?>" id="menuLaporan">
                                <ul class="sub-menu">
                                    <?php foreach ($menuLaporan as $menu): ?>
                                        <li class="side-nav-item">
                                            <a href="<?= base_url($menu_admin_path($menu['path'])) ?>"
                                                class="side-nav-link <?= $is_menu_active($menu['path']) ? 'active' : '' ?>">
                                                <span class="menu-text"><?= html_escape($menu['name']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>

                    <?php if ($menuPengaturan): ?>
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#menuPengaturan"
                                aria-expanded="<?= $pengaturan_open ? 'true' : 'false' ?>" aria-controls="menuPengaturan"
                                class="side-nav-link <?= $pengaturan_open ? 'active' : '' ?>">
                                <span class="menu-icon"><i class="ti ti-settings"></i></span>
                                <span class="menu-text">Pengaturan</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse <?= $pengaturan_open ? 'show' : '' ?>" id="menuPengaturan">
                                <ul class="sub-menu">
                                    <?php foreach ($menuPengaturan as $menu): ?>
                                        <li class="side-nav-item">
                                            <a href="<?= base_url($menu_admin_path($menu['path'])) ?>"
                                                class="side-nav-link <?= $is_menu_active($menu['path']) ? 'active' : '' ?>">
                                                <span class="menu-text"><?= html_escape($menu['name']) ?></span>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- Sidenav Menu End -->

        <!-- Topbar Start -->
        <header class="app-topbar" id="header">
            <div class="page-container topbar-menu">
                <div class="d-flex align-items-center gap-2 min-w-0">
                    <!-- Logo ini hanya tampil pada mode mobile sesuai perilaku bawaan Adminto. -->
                    <a href="<?= base_url('dashboard') ?>" class="logo">
                        <span class="logo-light">
                            <span class="logo-lg"><img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>"
                                    alt="Adminto"></span>
                            <span class="logo-sm"><img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>"
                                    alt="Adminto"></span>
                        </span>
                        <span class="logo-dark">
                            <span class="logo-lg"><img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>"
                                    alt="Adminto"></span>
                            <span class="logo-sm"><img src="<?= base_url('assets/logo_almahbaro_edited.jpg') ?>"
                                    alt="Adminto"></span>
                        </span>
                    </a>

                    <button class="sidenav-toggle-button px-2" type="button" aria-label="Buka atau tutup sidebar">
                        <i class="ri-menu-5-line fs-24"></i>
                    </button>

                    <div class="topbar-item d-flex px-2 min-w-0">
                        <h4 class="page-title fs-20 fw-semibold mb-0 text-truncate"><?= html_escape($page_title) ?></h4>
                    </div>
                </div>

                <!-- Sesuai wireframe: mode tampilan dan identitas pengguna saja. -->
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
                                    <h5 class="my-0"><?= html_escape($user_name) ?></h5>
                                </span>
                                <i class="ri-arrow-down-s-line d-none d-lg-block align-middle ms-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0"><?= html_escape($user_role) ?></h6>
                                </div>
                                <?php $log_menu = array_filter($menuPengaturan, function ($m) {
                                    return isset($m['path']) && $m['path'] === 'admin/pengaturan/log_aktivitas'; }); ?>
                                <?php if (!empty($log_menu)): ?>
                                    <a href="<?= base_url('admin/pengaturan/log_aktivitas') ?>" class="dropdown-item">
                                        <i class="ri-history-line me-1 fs-16 align-middle"></i>
                                        <span class="align-middle">Log Aktivitas</span>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                <?php endif; ?>
                                <a href="<?= base_url('login/logout') ?>" class="dropdown-item fw-semibold text-danger">
                                    <i class="ri-logout-box-line me-1 fs-16 align-middle"></i>
                                    <span class="align-middle">Keluar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Topbar End -->

        <!-- Start Page Content here -->
        <div class="page-content">
            <div class="page-container">