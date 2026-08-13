<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_level extends CI_Model
{
    public function level_result()
    {
        $search = trim((string) $this->input->post('search', true));
        $this->db->from('level');
        if ($search !== '') {
            $this->db->like('level', $search);
        }
        return $this->db->order_by('id', 'ASC')->get()->result_array();
    }

    public function simpan()
    {
        $id = (int) $this->input->post('id');
        $nama = trim((string) $this->input->post('level', true));

        if ($nama === '') {
            return array('result' => 'false', 'message' => 'Nama level wajib diisi.');
        }

        $this->db->from('level')->where('LOWER(TRIM(level)) = ' . $this->db->escape(strtolower($nama)), null, false);
        if ($id > 0) {
            $this->db->where('id !=', $id);
        }
        if ($this->db->count_all_results() > 0) {
            return array('result' => 'false', 'message' => 'Nama level sudah digunakan.');
        }

        if ($id > 0) {
            $this->db->where('id', $id)->update('level', array('level' => $nama));
            $this->db->where('id_level', $id)->update('users', array('level' => $nama));
        } else {
            $this->db->insert('level', array('level' => $nama));
        }

        return array('result' => 'true', 'message' => $id > 0 ? 'Data level berhasil diupdate.' : 'Data level berhasil disimpan.');
    }

    public function hapus()
    {
        $id = (int) $this->input->post('id');
        if ($id <= 0) {
            return array('result' => 'false', 'message' => 'Data level tidak valid.');
        }

        $dipakai_user = $this->db->where('id_level', $id)->count_all_results('users');
        $dipakai_menu = $this->db->where('id_level', $id)->count_all_results('list_menu');
        if ($dipakai_user > 0 || $dipakai_menu > 0) {
            return array('result' => 'false', 'message' => 'Level masih digunakan oleh user atau hak akses.');
        }

        $this->db->where('id', $id)->delete('level');
        return $this->db->affected_rows() > 0
            ? array('result' => 'true', 'message' => 'Data level berhasil dihapus.')
            : array('result' => 'false', 'message' => 'Data level gagal dihapus.');
    }
}
