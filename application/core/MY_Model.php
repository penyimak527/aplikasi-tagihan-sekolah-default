<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    protected function user()
    {
        $user = $this->session->userdata('admin');
        return is_array($user) ? $user : array('id' => 0, 'nama' => 'Administrator', 'username' => 'admin', 'role' => 'Admin');
    }

    protected function audit_fields()
    {
        $user = $this->user();
        return array(
            'tanggal' => tanggal_sekarang(),
            'waktu' => waktu_sekarang(),
            'id_user' => isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => isset($user['nama']) ? $user['nama'] : 'Administrator'
        );
    }

    protected function response($success, $message = '', $extra = array())
    {
        return array_merge(array(
            'result' => $success ? 'true' : 'false',
            'message' => $message
        ), $extra);
    }

    protected function transaction_result($success_message = 'Data berhasil disimpan.')
    {
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->response(false, 'Proses database gagal. Tidak ada perubahan yang disimpan.');
        }
        $this->db->trans_commit();
        return $this->response(true, $success_message);
    }

    protected function log_activity($jenis, $modul, $aksi, $table, $id, $nomor, $keterangan, $before = null, $after = null)
    {
        $user = $this->user();
        $this->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => $jenis,
            'modul' => $modul,
            'aksi' => $aksi,
            'nama_tabel' => $table,
            'id_referensi' => (string) $id,
            'nomor_referensi' => $nomor,
            'keterangan' => $keterangan,
            'data_sebelum' => $before === null ? null : json_encode($before, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => $after === null ? null : json_encode($after, JSON_UNESCAPED_UNICODE),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => tanggal_sekarang(),
            'waktu' => waktu_sekarang(),
            'id_user' => isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => isset($user['nama']) ? $user['nama'] : 'Administrator'
        ));
    }

    protected function next_code($prefix, $table, $column)
    {
        $date = date('Ym');
        $like = $prefix . '/' . $date . '/';
        $row = $this->db->select($column)
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

    protected function active_period()
    {
        $row = $this->db->where('status', 'Aktif')->order_by('id', 'DESC')->get('master_tahun_ajaran')->row_array();
        if (!$row) {
            $row = $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->row_array();
        }
        return $row ?: array('id' => 0, 'periode' => date('Y') . '/' . (date('Y') + 1), 'status' => 'Tidak Aktif');
    }

    protected function kelas_aktif_siswa_query()
    {
        return "SELECT ks.id AS id_kelas_siswa, s.*, ks.id_kelas_setting, kset.id_kelas, kset.nama_kelas, kset.id_periode, kset.semester, ta.periode
                FROM siswa s
                LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED) = s.id AND ks.status_aktif = '1'
                LEFT JOIN kelas_setting kset ON kset.id = CAST(ks.id_kelas_setting AS UNSIGNED)
                LEFT JOIN master_tahun_ajaran ta ON ta.id = CAST(kset.id_periode AS UNSIGNED)";
    }
}
