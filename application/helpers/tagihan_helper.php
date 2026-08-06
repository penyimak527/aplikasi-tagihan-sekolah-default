<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('app_user')) {
    function app_user()
    {
        $CI =& get_instance();
        $user = $CI->session->userdata('admin');
        return is_array($user) ? $user : array();
    }
}

if (!function_exists('app_user_id')) {
    function app_user_id()
    {
        $user = app_user();
        return isset($user['id']) ? (int) $user['id'] : 0;
    }
}

if (!function_exists('app_user_name')) {
    function app_user_name()
    {
        $user = app_user();
        return isset($user['nama']) ? $user['nama'] : 'Administrator';
    }
}

if (!function_exists('rupiah')) {
    function rupiah($nominal)
    {
        return 'Rp' . number_format((float) $nominal, 0, ',', '.');
    }
}

if (!function_exists('angka_rupiah')) {
    function angka_rupiah($nominal)
    {
        return number_format((float) $nominal, 0, ',', '.');
    }
}


if (!function_exists('nilai_nominal')) {
    function nilai_nominal($value)
    {
        if (is_int($value) || is_float($value)) {
            return (float) $value;
        }

        $text = trim(str_ireplace(array('Rp', ' '), '', (string) $value));
        if (preg_match('/^-?\d+\.\d{1,2}$/', $text)) {
            return (float) $text;
        }

        $clean = preg_replace('/[^0-9-]/', '', $text);
        if ($clean === '' || $clean === '-') {
            return 0;
        }

        return (float) $clean;
    }
}

if (!function_exists('nama_bulan')) {
    function nama_bulan($bulan)
    {
        $bulan_list = array(
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        );
        return isset($bulan_list[(int) $bulan]) ? $bulan_list[(int) $bulan] : '-';
    }
}

if (!function_exists('bulan_tahun_ajaran')) {
    function bulan_tahun_ajaran($periode)
    {
        $parts = explode('/', (string) $periode);
        $awal = isset($parts[0]) ? (int) $parts[0] : (int) date('Y');
        $akhir = isset($parts[1]) ? (int) $parts[1] : $awal + 1;
        return array(
            array('bulan' => 7, 'tahun' => $awal, 'nama' => 'Juli'),
            array('bulan' => 8, 'tahun' => $awal, 'nama' => 'Agustus'),
            array('bulan' => 9, 'tahun' => $awal, 'nama' => 'September'),
            array('bulan' => 10, 'tahun' => $awal, 'nama' => 'Oktober'),
            array('bulan' => 11, 'tahun' => $awal, 'nama' => 'November'),
            array('bulan' => 12, 'tahun' => $awal, 'nama' => 'Desember'),
            array('bulan' => 1, 'tahun' => $akhir, 'nama' => 'Januari'),
            array('bulan' => 2, 'tahun' => $akhir, 'nama' => 'Februari'),
            array('bulan' => 3, 'tahun' => $akhir, 'nama' => 'Maret'),
            array('bulan' => 4, 'tahun' => $akhir, 'nama' => 'April'),
            array('bulan' => 5, 'tahun' => $akhir, 'nama' => 'Mei'),
            array('bulan' => 6, 'tahun' => $akhir, 'nama' => 'Juni')
        );
    }
}

if (!function_exists('tanggal_sekarang')) {
    function tanggal_sekarang()
    {
        return date('d-m-Y');
    }
}

if (!function_exists('waktu_sekarang')) {
    function waktu_sekarang()
    {
        return date('H:i:s');
    }
}

if (!function_exists('status_badge')) {
    function status_badge($status)
    {
        $status_l = strtolower((string) $status);
        if (strpos($status_l, 'batal') !== false || strpos($status_l, 'nonaktif') !== false || strpos($status_l, 'tidak aktif') !== false || strpos($status_l, 'gagal') !== false || strpos($status_l, 'berhenti') !== false) {
            return 'danger';
        }
        if (strpos($status_l, 'sebagian') !== false || strpos($status_l, 'draft') !== false || strpos($status_l, 'belum') !== false || strpos($status_l, 'kurang') !== false) {
            return 'warning';
        }
        if (strpos($status_l, 'lunas') !== false || strpos($status_l, 'aktif') !== false || strpos($status_l, 'selesai') !== false || strpos($status_l, 'berhasil') !== false) {
            return 'success';
        }
        return 'secondary';
    }
}

if (!function_exists('menu_is_active')) {
    function menu_is_active($controllers)
    {
        $CI =& get_instance();
        $current = strtolower($CI->router->fetch_class());
        $controllers = is_array($controllers) ? $controllers : array($controllers);
        return in_array($current, array_map('strtolower', $controllers), true);
    }
}

if (!function_exists('clean_phone')) {
    function clean_phone($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', (string) $phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }
}

if (!function_exists('bersihkan_nomor_wa')) {
    function bersihkan_nomor_wa($phone)
    {
        return clean_phone($phone);
    }
}
