<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model
{
    public function user_result()
    {
        $search = trim((string) $this->input->post('search', true));

        $this->db
            ->select('u.*, COALESCE(l.level, u.level) AS nama_level, p.nama_pegawai')
            ->from('users u')
            ->join('level l', 'l.id = u.id_level', 'left')
            ->join('pegawai p', 'p.id = u.id_pegawai', 'left');

        if ($search !== '') {
            $this->db->group_start()
                ->like('u.nama_user', $search)
                ->or_like('u.username', $search)
                ->or_like('l.level', $search)
                ->or_like('p.nama_pegawai', $search)
                ->group_end();
        }

        return $this->db
            ->order_by('u.id', 'DESC')
            ->get()
            ->result_array();
    }

    public function level_list()
    {
        return $this->db
            ->order_by('level', 'ASC')
            ->get('level')
            ->result_array();
    }

    public function pegawai_list()
    {
        return $this->db
            ->select('id, nama_pegawai')
            ->from('pegawai')
            ->order_by('nama_pegawai', 'ASC')
            ->get()
            ->result_array();
    }

    public function detail($id)
    {
        return $this->db
            ->select('u.*, COALESCE(l.level, u.level) AS nama_level, p.nama_pegawai')
            ->from('users u')
            ->join('level l', 'l.id = u.id_level', 'left')
            ->join('pegawai p', 'p.id = u.id_pegawai', 'left')
            ->where('u.id', (int) $id)
            ->get()
            ->row_array();
    }

    private function username_exists($username, $except_id = 0)
    {
        $this->db->from('users')->where('username', $username);
        if ((int) $except_id > 0) {
            $this->db->where('id !=', (int) $except_id);
        }
        return $this->db->count_all_results() > 0;
    }

    private function get_level($id_level)
    {
        return $this->db
            ->where('id', (int) $id_level)
            ->get('level')
            ->row_array();
    }

    public function tambah()
    {
        $nama_user = trim((string) $this->input->post('nama_user', true));
        $username = trim((string) $this->input->post('username', true));
        $password = (string) $this->input->post('password');
        $konfirmasi = (string) $this->input->post('konfirmasi_password');
        $id_level = (int) $this->input->post('id_level');
        $id_pegawai = (int) $this->input->post('id_pegawai');

        if ($nama_user === '' || $username === '' || $password === '' || $id_level <= 0) {
            return array('result' => 'false', 'message' => 'Nama user, username, password, dan level wajib diisi.');
        }

        if ($password !== $konfirmasi) {
            return array('result' => 'false', 'message' => 'Konfirmasi password tidak sama.');
        }

        if ($this->username_exists($username)) {
            return array('result' => 'false', 'message' => 'Username sudah digunakan.');
        }

        $level = $this->get_level($id_level);
        if (!$level) {
            return array('result' => 'false', 'message' => 'Level tidak ditemukan.');
        }

        $data = array(
            'nama_user' => $nama_user,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'password_text' => null,
            'id_level' => $id_level,
            'level' => $level['level'],
            'id_pegawai' => $id_pegawai > 0 ? $id_pegawai : null
        );

        $this->db->insert('users', $data);

        return $this->db->affected_rows() > 0
            ? array('result' => 'true', 'message' => 'Data user berhasil disimpan.')
            : array('result' => 'false', 'message' => 'Data user gagal disimpan.');
    }

    public function update($id)
    {
        $id = (int) $id;
        $row = $this->detail($id);
        if (!$row) {
            return array('result' => 'false', 'message' => 'Data user tidak ditemukan.');
        }

        $nama_user = trim((string) $this->input->post('nama_user', true));
        $username = trim((string) $this->input->post('username', true));
        $password = (string) $this->input->post('password');
        $konfirmasi = (string) $this->input->post('konfirmasi_password');
        $id_level = (int) $this->input->post('id_level');
        $id_pegawai = (int) $this->input->post('id_pegawai');

        if ($nama_user === '' || $username === '' || $id_level <= 0) {
            return array('result' => 'false', 'message' => 'Nama user, username, dan level wajib diisi.');
        }

        if ($this->username_exists($username, $id)) {
            return array('result' => 'false', 'message' => 'Username sudah digunakan.');
        }

        $level = $this->get_level($id_level);
        if (!$level) {
            return array('result' => 'false', 'message' => 'Level tidak ditemukan.');
        }

        $data = array(
            'nama_user' => $nama_user,
            'username' => $username,
            'id_level' => $id_level,
            'level' => $level['level'],
            'id_pegawai' => $id_pegawai > 0 ? $id_pegawai : null
        );

        if ($password !== '') {
            if ($password !== $konfirmasi) {
                return array('result' => 'false', 'message' => 'Konfirmasi password baru tidak sama.');
            }
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            $data['password_text'] = null;
        }

        $this->db->where('id', $id)->update('users', $data);

        return array('result' => 'true', 'message' => 'Data user berhasil diupdate.');
    }

    public function hapus()
    {
        $id = (int) $this->input->post('id');
        if ($id <= 0) {
            return array('result' => 'false', 'message' => 'Data user tidak valid.');
        }

        $current = $this->session->userdata('admin');
        if (!empty($current['id']) && (int) $current['id'] === $id) {
            return array('result' => 'false', 'message' => 'User yang sedang login tidak dapat dihapus.');
        }

        $this->db->where('id', $id)->delete('users');

        return $this->db->affected_rows() > 0
            ? array('result' => 'true', 'message' => 'Data user berhasil dihapus.')
            : array('result' => 'false', 'message' => 'Data user gagal dihapus.');
    }
}
