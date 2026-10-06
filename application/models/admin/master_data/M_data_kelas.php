<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_data_kelas extends CI_Model
{
    public function result()
    {
        $search = trim((string) $this->input->post('search', true));
        $status = trim((string) $this->input->post('status', true));

        $this->db->select("
            k.*,
            (
                SELECT COUNT(*)
                FROM kelas_setting ks
                WHERE CAST(ks.id_kelas AS UNSIGNED) = k.id
            ) AS jumlah_setting,
            (
                SELECT COUNT(*)
                FROM kelas_siswa x
                INNER JOIN kelas_setting y
                    ON y.id = CAST(x.id_kelas_setting AS UNSIGNED)
                WHERE CAST(y.id_kelas AS UNSIGNED) = k.id
                    AND x.status_aktif = '1'
            ) AS jumlah_siswa
        ");
        $this->db->from('kelas k');

        if ($search !== '') {
            $this->db->group_start()
                ->like('k.nama_kelas', $search)
                ->or_like('k.jurusan', $search)
                ->group_end();
        }

        if ($status !== '') {
            $this->db->where('k.status', $status);
        }

        return $this->db
            ->order_by('k.nama_kelas', 'ASC')
            ->get()
            ->result_array();
    }

    public function detail()
    {
        $id = (int) $this->input->post('id');

        $row = $this->db
            ->where('id', $id)
            ->get('kelas')
            ->row_array();

        if (!$row) {
            return array(
                'result' => 'false',
                'message' => 'Kelas tidak ditemukan.'
            );
        }

        $setting = $this->db->query("
            SELECT
                ks.*,
                ta.periode,
                COUNT(kss.id) AS jumlah_siswa
            FROM kelas_setting ks
            LEFT JOIN master_tahun_ajaran ta
                ON ta.id = CAST(ks.id_periode AS UNSIGNED)
            LEFT JOIN kelas_siswa kss
                ON CAST(kss.id_kelas_setting AS UNSIGNED) = ks.id
                AND kss.status_aktif = '1'
            WHERE CAST(ks.id_kelas AS UNSIGNED) = ?
            GROUP BY ks.id
            ORDER BY ta.id DESC, ks.nama_kelas
        ", array($id))->result_array();

        return array(
            'result' => 'true',
            'data' => $row,
            'setting' => $setting
        );
    }

    public function tambah()
    {
        $nama = trim((string) $this->input->post('nama_kelas', true));
        $jurusan = trim((string) $this->input->post('jurusan', true));
        $status = trim((string) $this->input->post('status', true));

        if ($nama === '') {
            return array(
                'result' => 'false',
                'message' => 'Nama kelas wajib diisi.'
            );
        }

        if ($status === '') {
            $status = 'REGULER';
        }

        $data = array(
            'nama_kelas' => $nama,
            'jurusan' => $jurusan,
            'status' => $status,
            'id_jurusan' => 0
        );

        $user = $this->session->userdata('admin');

        $this->db->trans_begin();
        $this->db->insert('kelas', $data);
        $id = $this->db->insert_id();

        $this->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => 'Tambah Kelas',
            'modul' => 'Master Data',
            'aksi' => 'Tambah',
            'nama_tabel' => 'kelas',
            'id_referensi' => (string) $id,
            'nomor_referensi' => $nama,
            'keterangan' => 'Pengelolaan master kelas',
            'data_sebelum' => null,
            'data_sesudah' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => is_array($user) && isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== ''
                ? $user['nama']
                : 'Administrator'
        ));

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
            'message' => 'Data kelas berhasil disimpan.'
        );
    }

    public function edit()
    {
        $id = (int) $this->input->post('id');
        $nama = trim((string) $this->input->post('nama_kelas', true));
        $status = trim((string) $this->input->post('status', true));

        $before = $this->db
            ->where('id', $id)
            ->get('kelas')
            ->row_array();

        if (!$before) {
            return array(
                'result' => 'false',
                'message' => 'Data kelas tidak ditemukan.'
            );
        }

        if ($nama === '') {
            return array(
                'result' => 'false',
                'message' => 'Nama kelas wajib diisi.'
            );
        }

        if ($status === '') {
            $status = 'REGULER';
        }

        $jurusan_post = $this->input->post('jurusan', true);
        $jurusan = $jurusan_post === null
            ? (isset($before['jurusan']) ? $before['jurusan'] : '')
            : trim((string) $jurusan_post);

        $data = array(
            'nama_kelas' => $nama,
            'jurusan' => $jurusan,
            'status' => $status
        );

        $user = $this->session->userdata('admin');

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('kelas', $data);

        $this->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => 'Ubah Kelas',
            'modul' => 'Master Data',
            'aksi' => 'Ubah',
            'nama_tabel' => 'kelas',
            'id_referensi' => (string) $id,
            'nomor_referensi' => $nama,
            'keterangan' => 'Pengelolaan master kelas',
            'data_sebelum' => json_encode($before, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => json_encode(array_merge($before, $data), JSON_UNESCAPED_UNICODE),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => is_array($user) && isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== ''
                ? $user['nama']
                : 'Administrator'
        ));

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
            'message' => 'Data kelas berhasil diperbarui.'
        );
    }

    public function hapus()
    {
        $id = (int) $this->input->post('id');

        $row = $this->db
            ->where('id', $id)
            ->get('kelas')
            ->row_array();

        if (!$row) {
            return array(
                'result' => 'false',
                'message' => 'Data tidak ditemukan.'
            );
        }

        $digunakan = $this->db
            ->where('id_kelas', (string) $id)
            ->count_all_results('kelas_setting');

        if ($digunakan > 0) {
            return array(
                'result' => 'false',
                'message' => 'Kelas sudah digunakan pada pengaturan kelas dan tidak dapat dihapus.'
            );
        }

        $user = $this->session->userdata('admin');

        $this->db->trans_begin();
        $this->db->where('id', $id)->delete('kelas');

        $this->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => 'Hapus Kelas',
            'modul' => 'Master Data',
            'aksi' => 'Batal',
            'nama_tabel' => 'kelas',
            'id_referensi' => (string) $id,
            'nomor_referensi' => $row['nama_kelas'],
            'keterangan' => 'Menghapus kelas yang belum digunakan',
            'data_sebelum' => json_encode($row, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => null,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => is_array($user) && isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== ''
                ? $user['nama']
                : 'Administrator'
        ));

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
            'message' => 'Kelas berhasil dihapus.'
        );
    }
}
?>