<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_login extends CI_Model
{
    public function get_by_username($username)
    {
        return $this->db->where('username', trim((string) $username))->get('wali_murid')->row_array();
    }

    public function catat_login($wali, $username, $status, $keterangan)
    {
        $this->db->insert('wali_murid_login_log', array(
            'id_wali_murid' => $wali ? (int) $wali['id'] : 0,
            'username' => (string) $username,
            'status_login' => $status,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'keterangan' => $keterangan,
            'tanggal' => $this->tanggal_sekarang(),
            'waktu' => $this->waktu_sekarang()
        ));
    }

    public function login_berhasil($wali)
    {
        $this->db->where('id', (int) $wali['id'])->update('wali_murid', array(
            'last_login_tanggal' => $this->tanggal_sekarang(),
            'last_login_waktu' => $this->waktu_sekarang(),
            'last_login_ip' => $this->input->ip_address()
        ));
        $this->catat_login($wali, $wali['username'], 'Berhasil', 'Login Portal Wali Murid berhasil.');
    }

    private function tanggal_sekarang()
    {
        return date('d-m-Y');
    }


    private function waktu_sekarang()
    {
        return date('H:i:s');
    }
}
