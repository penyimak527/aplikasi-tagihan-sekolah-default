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

/* ============================================================
 * Helper umum aplikasi tagihan.
 * Fungsi-fungsi ini menampung kebutuhan umum agar perubahan tetap berada pada CMV/helper.
 * ============================================================ */

if (!function_exists('json_response')) {
    function json_response($data, $status = 200)
    {
        $CI =& get_instance();
        $CI->output
            ->set_status_header((int) $status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}

if (!function_exists('csv_download_file')) {
    function csv_download_file($filename, $headers, $rows)
    {
        $CI =& get_instance();
        $CI->output->set_content_type('text/csv', 'utf-8');
        $CI->output->set_header('Content-Disposition: attachment; filename="' . $filename . '"');

        $handle = fopen('php://output', 'w');
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, $headers, ';');
        foreach ($rows as $row) {
            fputcsv($handle, $row, ';');
        }
        fclose($handle);
        exit;
    }
}

if (!function_exists('model_response')) {
    function model_response($success, $message = '', $extra = array())
    {
        return array_merge(array(
            'result' => $success ? 'true' : 'false',
            'message' => $message
        ), $extra);
    }
}

if (!function_exists('tagihan_audit_fields')) {
    function tagihan_audit_fields()
    {
        return array(
            'tanggal' => tanggal_sekarang(),
            'waktu' => waktu_sekarang(),
            'id_user' => app_user_id(),
            'nama_user' => app_user_name()
        );
    }
}

if (!function_exists('tagihan_transaction_result')) {
    function tagihan_transaction_result($success_message = 'Data berhasil disimpan.')
    {
        $CI =& get_instance();
        if ($CI->db->trans_status() === FALSE) {
            $CI->db->trans_rollback();
            return model_response(false, 'Proses database gagal. Tidak ada perubahan yang disimpan.');
        }

        $CI->db->trans_commit();
        return model_response(true, $success_message);
    }
}

if (!function_exists('tagihan_log_activity')) {
    function tagihan_log_activity($jenis, $modul, $aksi, $table, $id, $nomor, $keterangan, $before = null, $after = null)
    {
        $CI =& get_instance();
        $CI->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => $jenis,
            'modul' => $modul,
            'aksi' => $aksi,
            'nama_tabel' => $table,
            'id_referensi' => (string) $id,
            'nomor_referensi' => $nomor,
            'keterangan' => $keterangan,
            'data_sebelum' => $before === null ? null : json_encode($before, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => $after === null ? null : json_encode($after, JSON_UNESCAPED_UNICODE),
            'ip_address' => $CI->input->ip_address(),
            'user_agent' => $CI->input->user_agent(),
            'tanggal' => tanggal_sekarang(),
            'waktu' => waktu_sekarang(),
            'id_user' => app_user_id(),
            'nama_user' => app_user_name()
        ));
    }
}

if (!function_exists('tagihan_next_code')) {
    function tagihan_next_code($prefix, $table, $column)
    {
        $CI =& get_instance();
        $date = date('Ym');
        $like = $prefix . '/' . $date . '/';
        $row = $CI->db->select($column)
            ->like($column, $like, 'after')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get($table)
            ->row_array();

        $next = 1;
        if ($row && !empty($row[$column])) {
            $parts = explode('/', $row[$column]);
            $next = ((int) end($parts)) + 1;
        }

        return $like . str_pad($next, 5, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('tagihan_active_period')) {
    function tagihan_active_period()
    {
        $CI =& get_instance();
        $row = $CI->db
            ->where('status', 'Aktif')
            ->order_by('id', 'DESC')
            ->get('master_tahun_ajaran')
            ->row_array();

        if (!$row) {
            $row = $CI->db
                ->order_by('id', 'DESC')
                ->get('master_tahun_ajaran')
                ->row_array();
        }

        return $row ?: array(
            'id' => 0,
            'periode' => date('Y') . '/' . (date('Y') + 1),
            'status' => 'Tidak Aktif'
        );
    }
}

if (!function_exists('kelas_aktif_siswa_query')) {
    function kelas_aktif_siswa_query()
    {
        return "SELECT ks.id AS id_kelas_siswa, s.*, ks.id_kelas_setting, kset.id_kelas, kset.nama_kelas, kset.id_periode, kset.semester, ta.periode
                FROM siswa s
                LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED) = s.id AND ks.status_aktif = '1'
                LEFT JOIN kelas_setting kset ON kset.id = CAST(ks.id_kelas_setting AS UNSIGNED)
                LEFT JOIN master_tahun_ajaran ta ON ta.id = CAST(kset.id_periode AS UNSIGNED)";
    }
}
