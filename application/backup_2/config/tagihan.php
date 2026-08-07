<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Kredensial awal karena database sumber belum memiliki tabel akun aplikasi.
| Ganti nilai ini atau hubungkan Login.php dengan autentikasi sekolah yang digunakan.
*/
$config['tagihan_login_username'] = 'admin';
$config['tagihan_login_password'] = 'admin123';
$config['tagihan_login_name']     = 'Administrator';
$config['tagihan_login_role']     = 'Admin';
$config['tagihan_school_name']    = 'Sekolah';

/* Alias singkat untuk view cetak dan template pesan. */
$config['nama_sekolah'] = $config['tagihan_school_name'];
$config['alamat_sekolah'] = '';
$config['telepon_sekolah'] = '';
