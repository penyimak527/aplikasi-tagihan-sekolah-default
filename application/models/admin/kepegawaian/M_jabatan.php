<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jabatan extends CI_Model
{
    public function jabatan_result()
    {
        $search = trim((string) $this->input->post('search', true));

        $this->db
            ->select('id, nama_jabatan')
            ->from('jabatan');

        if ($search !== '') {
            $this->db->like('nama_jabatan', $search);
        }

        return $this->db
            ->order_by('nama_jabatan', 'ASC')
            ->get()
            ->result_array();
    }

    public function tambah()
    {
        $nama = trim((string) $this->input->post('nama_jabatan', true));

        if ($nama === '') {
            return $this->model_response(false, 'Nama jabatan wajib diisi.');
        }

        if ($this->jabatan_duplikat($nama)) {
            return $this->model_response(false, 'Nama jabatan sudah tersedia.');
        }

        $data = array(
            'nama_jabatan' => $nama
        );

        $this->db->trans_begin();
        $this->db->insert('jabatan', $data);
        $id = (int) $this->db->insert_id();

        $this->tagihan_log_activity(
            'Tambah Jabatan',
            'Kepegawaian',
            'Tambah',
            'jabatan',
            $id,
            $nama,
            'Menambah master jabatan',
            null,
            $data
        );

        return $this->tagihan_transaction_result('Data jabatan berhasil disimpan.');
    }

    public function edit()
    {
        $id = (int) $this->input->post('id');
        $nama = trim((string) $this->input->post('nama_jabatan', true));

        if ($id <= 0) {
            return $this->model_response(false, 'Data jabatan tidak ditemukan.');
        }

        if ($nama === '') {
            return $this->model_response(false, 'Nama jabatan wajib diisi.');
        }

        $before = $this->db->where('id', $id)->get('jabatan')->row_array();
        if (!$before) {
            return $this->model_response(false, 'Data jabatan tidak ditemukan.');
        }

        if ($this->jabatan_duplikat($nama, $id)) {
            return $this->model_response(false, 'Nama jabatan sudah tersedia.');
        }

        $data = array(
            'nama_jabatan' => $nama
        );

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('jabatan', $data);

        $this->tagihan_log_activity(
            'Ubah Jabatan',
            'Kepegawaian',
            'Ubah',
            'jabatan',
            $id,
            $nama,
            'Mengubah master jabatan',
            $before,
            $data
        );

        return $this->tagihan_transaction_result('Data jabatan berhasil diupdate.');
    }

    public function hapus()
    {
        $id = (int) $this->input->post('id');
        $row = $this->db->where('id', $id)->get('jabatan')->row_array();

        if (!$row) {
            return $this->model_response(false, 'Data jabatan tidak ditemukan.');
        }

        $this->db->trans_begin();
        $this->db->where('id', $id)->delete('jabatan');

        $this->tagihan_log_activity(
            'Hapus Jabatan',
            'Kepegawaian',
            'Batal',
            'jabatan',
            $id,
            $row['nama_jabatan'],
            'Menghapus master jabatan',
            $row,
            null
        );

        return $this->tagihan_transaction_result('Jabatan berhasil dihapus.');
    }

    private function jabatan_duplikat($nama, $excludeId = 0)
    {
        $this->db->from('jabatan');
        $this->db->where(
            'LOWER(TRIM(nama_jabatan)) = ' . $this->db->escape(strtolower($nama)),
            null,
            false
        );

        if ((int) $excludeId > 0) {
            $this->db->where('id !=', (int) $excludeId);
        }

        return $this->db->count_all_results() > 0;
    }

    private function model_response($success, $message = '', $extra = array())
    {
        return array_merge(array(
            'result' => $success ? 'true' : 'false',
            'message' => $message
        ), $extra);
    }

    private function tagihan_transaction_result($success_message = 'Data berhasil disimpan.')
    {
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'result' => 'false',
                'message' => 'Proses database gagal. Tidak ada perubahan yang disimpan.'
            );
        }

        $this->db->trans_commit();
        return array(
            'result' => 'true',
            'message' => $success_message
        );
    }

    private function tagihan_log_activity($jenis, $modul, $aksi, $table, $id, $nomor, $keterangan, $before = null, $after = null)
    {
        $user = $this->session->userdata('admin');

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
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => is_array($user) && isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator'
        ));
    }
}
