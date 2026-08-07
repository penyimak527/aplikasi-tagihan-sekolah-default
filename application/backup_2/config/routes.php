<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Controller dikelompokkan per modul. Alias di bawah mempertahankan URL ringkas
| yang dipakai pada view/AJAX, sekaligus memetakan ke controller dalam folder.
*/
$route['default_controller'] = 'auth/login';
$route['404_override'] = 'errors/errors/page_missing';
$route['translate_uri_dashes'] = FALSE;

$module_routes = array(
    'login'                 => 'auth/login',
    'dashboard'             => 'dashboard/dashboard',

    'tahun_ajaran'          => 'master_data/tahun_ajaran',
    'data_kelas'            => 'master_data/data_kelas',
    'siswa'                 => 'master_data/siswa',
    'import_siswa'          => 'master_data/import_siswa',
    'jenis_tagihan'         => 'master_data/jenis_tagihan',
    'metode_pembayaran'     => 'master_data/metode_pembayaran',

    'penempatan_siswa'      => 'kesiswaan/penempatan_siswa',
    'kenaikan_kelas'        => 'kesiswaan/kenaikan_kelas',
    'pindah_kelas'          => 'kesiswaan/pindah_kelas',
    'tinggal_kelas'         => 'kesiswaan/tinggal_kelas',
    'kelulusan'             => 'kesiswaan/kelulusan',
    'status_siswa'          => 'kesiswaan/status_siswa',
    'riwayat_kelas'         => 'kesiswaan/riwayat_kelas',

    'tagihan_bulanan'       => 'tagihan/tagihan_bulanan',
    'tagihan_langsung'      => 'tagihan/tagihan_langsung',
    'tagihan_tahunan'       => 'tagihan/tagihan_tahunan',
    'daftar_tagihan'        => 'tagihan/daftar_tagihan',
    'siswa_pembayar'        => 'tagihan/siswa_pembayar',
    'tarif_tagihan'         => 'tagihan/tarif_tagihan',
    'tarif_per_kelas'       => 'tagihan/tarif_per_kelas',
    'tarif_khusus_siswa'    => 'tagihan/tarif_khusus_siswa',
    'keringanan'            => 'tagihan/keringanan',

    'pembayaran'            => 'transaksi/pembayaran',
    'riwayat_pembayaran'    => 'transaksi/riwayat_pembayaran',
    'pembatalan_transaksi'   => 'transaksi/pembatalan_transaksi',

    'tagihan_per_siswa'     => 'tunggakan/tagihan_per_siswa',
    'tagihan_per_kelas'     => 'tunggakan/tagihan_per_kelas',
    'tagihan_per_jenis'     => 'tunggakan/tagihan_per_jenis',
    'tunggakan_lama'        => 'tunggakan/tunggakan_lama',
    'surat_tunggakan'       => 'tunggakan/surat_tunggakan',

    'laporan'               => 'laporan/laporan',

    'format_bukti'          => 'pengaturan/format_bukti',
    'format_kartu'          => 'pengaturan/format_kartu',
    'template_whatsapp'     => 'pengaturan/template_whatsapp',
    'log_aktivitas'         => 'pengaturan/log_aktivitas'
);

foreach ($module_routes as $uri => $controller) {
    $route[$uri] = $controller;
    $route[$uri . '/(:any)'] = $controller . '/$1';
    $route[$uri . '/(:any)/(:any)'] = $controller . '/$1/$2';
    $route[$uri . '/(:any)/(:any)/(:any)'] = $controller . '/$1/$2/$3';
}
