<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$user = app_user();
$current_controller = strtolower($this->router->fetch_class());
$current_method = strtolower($this->router->fetch_method());
$user_name = isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator';
$user_role = isset($user['role']) && $user['role'] !== '' ? $user['role'] : 'Admin';
$page_title = isset($title) && $title !== '' ? $title : 'Aplikasi Tagihan Sekolah';

$master_open = menu_is_active(array('tahun_ajaran', 'data_kelas', 'siswa', 'import_siswa', 'jenis_tagihan', 'metode_pembayaran'));
$kesiswaan_open = menu_is_active(array('penempatan_siswa', 'kenaikan_kelas', 'pindah_kelas', 'tinggal_kelas', 'kelulusan', 'status_siswa', 'riwayat_kelas'));
$tagihan_open = menu_is_active(array('tagihan_bulanan', 'tagihan_langsung', 'tagihan_tahunan', 'daftar_tagihan', 'siswa_pembayar', 'tarif_tagihan', 'tarif_per_kelas', 'tarif_khusus_siswa', 'keringanan'));
$transaksi_open = menu_is_active(array('pembayaran', 'riwayat_pembayaran', 'pembatalan_transaksi'));
$tunggakan_open = menu_is_active(array('tagihan_per_siswa', 'tagihan_per_kelas', 'tagihan_per_jenis', 'tunggakan_lama', 'surat_tunggakan'));
$laporan_open = menu_is_active('laporan');
$pengaturan_open = menu_is_active(array('format_bukti', 'format_kartu', 'template_whatsapp', 'log_aktivitas'));
?>
<!DOCTYPE html>
<html lang="id" data-bs-theme="light" data-menu-color="light" data-topbar-color="light" data-sidenav-size="default">
<head>
    <meta charset="utf-8">
    <title><?= html_escape($page_title) ?> | Aplikasi Tagihan Sekolah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Tagihan Sekolah">

    <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>">

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
    <!-- CDN hanya menjadi cadangan bila jQuery dari bundle vendor gagal dimuat. -->
    <script>
        if (typeof window.jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
        }
    </script>

    <!-- Utilitas format angka bawaan project. -->
    <script src="<?= base_url('assets/js/js-form.js') ?>"></script>

    <!-- Dibaca sebelum script view agar SweetAlert dan ApexCharts siap digunakan. -->
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
                    <span class="logo-lg"><img src="<?= base_url('assets/images/logo.png') ?>" alt="Adminto"></span>
                    <span class="logo-sm"><img src="<?= base_url('assets/images/logo-sm.png') ?>" alt="Adminto"></span>
                </span>
                <span class="logo-dark">
                    <span class="logo-lg"><img src="<?= base_url('assets/images/logo-dark.png') ?>" alt="Adminto"></span>
                    <span class="logo-sm"><img src="<?= base_url('assets/images/logo-sm.png') ?>" alt="Adminto"></span>
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
                        <a class="topbar-link dropdown-toggle text-reset drop-arrow-none px-2" data-bs-toggle="dropdown" type="button" aria-haspopup="false" aria-expanded="false">
                            <img src="<?= base_url('assets/user.png') ?>" width="46" class="rounded-circle" alt="Foto pengguna">
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
                            <a href="<?= base_url('pengaturan/log_aktivitas') ?>" class="dropdown-item">
                                <i class="ri-history-line me-1 fs-16 align-middle"></i>
                                <span class="align-middle">Log Aktivitas</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('login/logout') ?>" class="dropdown-item active fw-semibold text-danger">
                                <i class="ri-logout-box-line me-1 fs-16 align-middle"></i>
                                <span class="align-middle">Keluar</span>
                            </a>
                        </div>
                    </div>
                </div>

                <ul class="side-nav">
                    <li class="side-nav-item">
                        <a href="<?= base_url('dashboard') ?>" class="side-nav-link <?= menu_is_active('dashboard') ? 'active' : '' ?>">
                            <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="side-nav-title mt-2">Data dan Akademik</li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#menuMaster" aria-expanded="<?= $master_open ? 'true' : 'false' ?>" aria-controls="menuMaster" class="side-nav-link <?= $master_open ? 'active' : '' ?>">
                            <span class="menu-icon"><i class="ti ti-database"></i></span>
                            <span class="menu-text">Master Data</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?= $master_open ? 'show' : '' ?>" id="menuMaster">
                            <ul class="sub-menu">
                                <li class="side-nav-item"><a href="<?= base_url('master_data/tahun_ajaran') ?>" class="side-nav-link <?= menu_is_active('tahun_ajaran') ? 'active' : '' ?>"><span class="menu-text">Tahun Ajaran</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('master_data/data_kelas') ?>" class="side-nav-link <?= menu_is_active('data_kelas') ? 'active' : '' ?>"><span class="menu-text">Kelas</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('master_data/siswa') ?>" class="side-nav-link <?= menu_is_active('siswa') ? 'active' : '' ?>"><span class="menu-text">Siswa</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('master_data/import_siswa') ?>" class="side-nav-link <?= menu_is_active('import_siswa') ? 'active' : '' ?>"><span class="menu-text">Import Siswa</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('master_data/jenis_tagihan') ?>" class="side-nav-link <?= menu_is_active('jenis_tagihan') ? 'active' : '' ?>"><span class="menu-text">Jenis Tagihan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('master_data/metode_pembayaran') ?>" class="side-nav-link <?= menu_is_active('metode_pembayaran') ? 'active' : '' ?>"><span class="menu-text">Metode Pembayaran</span></a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#menuKesiswaan" aria-expanded="<?= $kesiswaan_open ? 'true' : 'false' ?>" aria-controls="menuKesiswaan" class="side-nav-link <?= $kesiswaan_open ? 'active' : '' ?>">
                            <span class="menu-icon"><i class="ti ti-users-group"></i></span>
                            <span class="menu-text">Kesiswaan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?= $kesiswaan_open ? 'show' : '' ?>" id="menuKesiswaan">
                            <ul class="sub-menu">
                                <li class="side-nav-item"><a href="<?= base_url('kesiswaan/penempatan_siswa') ?>" class="side-nav-link <?= menu_is_active('penempatan_siswa') ? 'active' : '' ?>"><span class="menu-text">Penempatan Siswa</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('kesiswaan/kenaikan_kelas') ?>" class="side-nav-link <?= menu_is_active('kenaikan_kelas') ? 'active' : '' ?>"><span class="menu-text">Kenaikan Kelas</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('kesiswaan/pindah_kelas') ?>" class="side-nav-link <?= menu_is_active('pindah_kelas') ? 'active' : '' ?>"><span class="menu-text">Pindah Kelas</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('kesiswaan/tinggal_kelas') ?>" class="side-nav-link <?= menu_is_active('tinggal_kelas') ? 'active' : '' ?>"><span class="menu-text">Tinggal Kelas</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('kesiswaan/kelulusan') ?>" class="side-nav-link <?= menu_is_active('kelulusan') ? 'active' : '' ?>"><span class="menu-text">Kelulusan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('kesiswaan/status_siswa') ?>" class="side-nav-link <?= menu_is_active('status_siswa') ? 'active' : '' ?>"><span class="menu-text">Berhenti/Pindah Sekolah</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('kesiswaan/riwayat_kelas') ?>" class="side-nav-link <?= menu_is_active('riwayat_kelas') ? 'active' : '' ?>"><span class="menu-text">Riwayat Kelas</span></a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-title mt-2">Tagihan dan Pembayaran</li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#menuTagihan" aria-expanded="<?= $tagihan_open ? 'true' : 'false' ?>" aria-controls="menuTagihan" class="side-nav-link <?= $tagihan_open ? 'active' : '' ?>">
                            <span class="menu-icon"><i class="ti ti-file-invoice"></i></span>
                            <span class="menu-text">Tagihan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?= $tagihan_open ? 'show' : '' ?>" id="menuTagihan">
                            <ul class="sub-menu">
                                <li class="side-nav-item"><a href="<?= base_url('tagihan/tagihan_bulanan') ?>" class="side-nav-link <?= menu_is_active('tagihan_bulanan') ? 'active' : '' ?>"><span class="menu-text">Buat Tagihan Bulanan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tagihan/tagihan_langsung') ?>" class="side-nav-link <?= menu_is_active('tagihan_langsung') ? 'active' : '' ?>"><span class="menu-text">Buat Tagihan Langsung</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tagihan/tagihan_tahunan') ?>" class="side-nav-link <?= menu_is_active('tagihan_tahunan') ? 'active' : '' ?>"><span class="menu-text">Buat Tagihan Tahunan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tagihan/daftar_tagihan') ?>" class="side-nav-link <?= menu_is_active('daftar_tagihan') ? 'active' : '' ?>"><span class="menu-text">Daftar Tagihan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tagihan/siswa_pembayar') ?>" class="side-nav-link <?= menu_is_active('siswa_pembayar') ? 'active' : '' ?>"><span class="menu-text">Siswa Pembayar</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tagihan/tarif_per_kelas') ?>" class="side-nav-link <?= menu_is_active('tarif_per_kelas') ? 'active' : '' ?>"><span class="menu-text">Tarif Per Kelas</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tagihan/tarif_khusus_siswa') ?>" class="side-nav-link <?= menu_is_active('tarif_khusus_siswa') ? 'active' : '' ?>"><span class="menu-text">Tarif Khusus Siswa</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tagihan/keringanan') ?>" class="side-nav-link <?= menu_is_active('keringanan') ? 'active' : '' ?>"><span class="menu-text">Potongan/Pembebasan</span></a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#menuTransaksi" aria-expanded="<?= $transaksi_open ? 'true' : 'false' ?>" aria-controls="menuTransaksi" class="side-nav-link <?= $transaksi_open ? 'active' : '' ?>">
                            <span class="menu-icon"><i class="ti ti-cash"></i></span>
                            <span class="menu-text">Transaksi</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?= $transaksi_open ? 'show' : '' ?>" id="menuTransaksi">
                            <ul class="sub-menu">
                                <li class="side-nav-item"><a href="<?= base_url('transaksi/pembayaran') ?>" class="side-nav-link <?= menu_is_active('pembayaran') ? 'active' : '' ?>"><span class="menu-text">Pembayaran Tagihan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('transaksi/riwayat_pembayaran') ?>" class="side-nav-link <?= menu_is_active('riwayat_pembayaran') ? 'active' : '' ?>"><span class="menu-text">Riwayat Pembayaran</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('transaksi/pembatalan_transaksi') ?>" class="side-nav-link <?= menu_is_active('pembatalan_transaksi') ? 'active' : '' ?>"><span class="menu-text">Pembatalan Transaksi</span></a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#menuTunggakan" aria-expanded="<?= $tunggakan_open ? 'true' : 'false' ?>" aria-controls="menuTunggakan" class="side-nav-link <?= $tunggakan_open ? 'active' : '' ?>">
                            <span class="menu-icon"><i class="ti ti-alert-circle"></i></span>
                            <span class="menu-text">Tagihan &amp; Tunggakan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?= $tunggakan_open ? 'show' : '' ?>" id="menuTunggakan">
                            <ul class="sub-menu">
                                <li class="side-nav-item"><a href="<?= base_url('tunggakan/tagihan_per_siswa') ?>" class="side-nav-link <?= menu_is_active('tagihan_per_siswa') ? 'active' : '' ?>"><span class="menu-text">Tagihan Per Siswa</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tunggakan/tagihan_per_kelas') ?>" class="side-nav-link <?= menu_is_active('tagihan_per_kelas') ? 'active' : '' ?>"><span class="menu-text">Tagihan Per Kelas</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tunggakan/tagihan_per_jenis') ?>" class="side-nav-link <?= menu_is_active('tagihan_per_jenis') ? 'active' : '' ?>"><span class="menu-text">Tagihan Per Jenis</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tunggakan/tunggakan_lama') ?>" class="side-nav-link <?= menu_is_active('tunggakan_lama') ? 'active' : '' ?>"><span class="menu-text">Tunggakan Tahun Sebelumnya</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('tunggakan/surat_tunggakan') ?>" class="side-nav-link <?= menu_is_active('surat_tunggakan') ? 'active' : '' ?>"><span class="menu-text">Surat Tunggakan</span></a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-title mt-2">Monitoring</li>
                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#menuLaporan" aria-expanded="<?= $laporan_open ? 'true' : 'false' ?>" aria-controls="menuLaporan" class="side-nav-link <?= $laporan_open ? 'active' : '' ?>">
                            <span class="menu-icon"><i class="ti ti-report-analytics"></i></span>
                            <span class="menu-text">Laporan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?= $laporan_open ? 'show' : '' ?>" id="menuLaporan">
                            <ul class="sub-menu">
                                <li class="side-nav-item"><a href="<?= base_url('laporan/laporan/harian') ?>" class="side-nav-link <?= $laporan_open && $current_method === 'harian' ? 'active' : '' ?>"><span class="menu-text">Pembayaran Harian</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('laporan/laporan/bulanan') ?>" class="side-nav-link <?= $laporan_open && $current_method === 'bulanan' ? 'active' : '' ?>"><span class="menu-text">Pembayaran Bulanan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('laporan/laporan/tahunan') ?>" class="side-nav-link <?= $laporan_open && $current_method === 'tahunan' ? 'active' : '' ?>"><span class="menu-text">Pembayaran Tahunan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('laporan/laporan/per_kelas') ?>" class="side-nav-link <?= $laporan_open && $current_method === 'per_kelas' ? 'active' : '' ?>"><span class="menu-text">Rekap Per Kelas</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('laporan/laporan/per_jenis') ?>" class="side-nav-link <?= $laporan_open && $current_method === 'per_jenis' ? 'active' : '' ?>"><span class="menu-text">Rekap Per Jenis</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('laporan/laporan/tunggakan') ?>" class="side-nav-link <?= $laporan_open && $current_method === 'tunggakan' ? 'active' : '' ?>"><span class="menu-text">Laporan Tunggakan</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('laporan/laporan/pembatalan') ?>" class="side-nav-link <?= $laporan_open && $current_method === 'pembatalan' ? 'active' : '' ?>"><span class="menu-text">Riwayat Pembatalan</span></a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#menuPengaturan" aria-expanded="<?= $pengaturan_open ? 'true' : 'false' ?>" aria-controls="menuPengaturan" class="side-nav-link <?= $pengaturan_open ? 'active' : '' ?>">
                            <span class="menu-icon"><i class="ti ti-settings"></i></span>
                            <span class="menu-text">Pengaturan</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse <?= $pengaturan_open ? 'show' : '' ?>" id="menuPengaturan">
                            <ul class="sub-menu">
                                <li class="side-nav-item"><a href="<?= base_url('pengaturan/format_bukti') ?>" class="side-nav-link <?= menu_is_active('format_bukti') ? 'active' : '' ?>"><span class="menu-text">Format Bukti</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('pengaturan/format_kartu') ?>" class="side-nav-link <?= menu_is_active('format_kartu') ? 'active' : '' ?>"><span class="menu-text">Format Kartu</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('pengaturan/template_whatsapp') ?>" class="side-nav-link <?= menu_is_active('template_whatsapp') ? 'active' : '' ?>"><span class="menu-text">Template WhatsApp</span></a></li>
                                <li class="side-nav-item"><a href="<?= base_url('pengaturan/log_aktivitas') ?>" class="side-nav-link <?= menu_is_active('log_aktivitas') ? 'active' : '' ?>"><span class="menu-text">Log Aktivitas</span></a></li>
                            </ul>
                        </div>
                    </li>
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
                            <span class="logo-lg"><img src="<?= base_url('assets/images/logo.png') ?>" alt="Adminto"></span>
                            <span class="logo-sm"><img src="<?= base_url('assets/images/logo-sm.png') ?>" alt="Adminto"></span>
                        </span>
                        <span class="logo-dark">
                            <span class="logo-lg"><img src="<?= base_url('assets/images/logo-dark.png') ?>" alt="Adminto"></span>
                            <span class="logo-sm"><img src="<?= base_url('assets/images/logo-sm.png') ?>" alt="Adminto"></span>
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
                        <button class="topbar-link" id="light-dark-mode" type="button" aria-label="Ubah mode tampilan" title="Mode terang/gelap">
                            <i class="ri-moon-line light-mode-icon fs-22"></i>
                            <i class="ri-sun-line dark-mode-icon fs-22"></i>
                        </button>
                    </div>

                    <div class="topbar-item nav-user">
                        <div class="dropdown">
                            <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button" aria-haspopup="false" aria-expanded="false">
                                <img src="<?= base_url('assets/user.png') ?>" width="32" class="rounded-circle me-lg-2 d-flex" alt="Foto pengguna">
                                <span class="d-lg-flex flex-column gap-1 d-none">
                                    <h5 class="my-0"><?= html_escape($user_name) ?></h5>
                                </span>
                                <i class="ri-arrow-down-s-line d-none d-lg-block align-middle ms-1"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0"><?= html_escape($user_role) ?></h6>
                                </div>
                                <a href="<?= base_url('pengaturan/log_aktivitas') ?>" class="dropdown-item">
                                    <i class="ri-history-line me-1 fs-16 align-middle"></i>
                                    <span class="align-middle">Log Aktivitas</span>
                                </a>
                                <div class="dropdown-divider"></div>
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
