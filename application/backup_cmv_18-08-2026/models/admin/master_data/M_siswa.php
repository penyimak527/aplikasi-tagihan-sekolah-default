<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_siswa extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }

    public function kelas_list()
    {
        return $this->db->select('ks.*,ta.periode')
            ->from('kelas_setting ks')
            ->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')
            ->order_by('ta.id', 'DESC')
            ->order_by('ks.nama_kelas', 'ASC')
            ->get()
            ->result_array();
    }

    public function siswa_result()
    {
        $search = trim((string)$this->input->post('search', true));
        $id_periode = (int)$this->input->post('id_periode');
        $id_kelas_setting = (int)$this->input->post('id_kelas_setting');
        $status = trim((string)$this->input->post('status', true));

        $where_search = '';
        $where_periode = '';
        $where_kelas = '';
        $where_status = '';
        $params = array();

        if ($search != '') {
            $where_search = "AND (s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ?)";
            $cari = '%' . $search . '%';
            $params[] = $cari;
            $params[] = $cari;
            $params[] = $cari;
        }

        if ($id_periode > 0) {
            $where_periode = "AND CAST(kset.id_periode AS UNSIGNED) = ?";
            $params[] = $id_periode;
        }

        if ($id_kelas_setting > 0) {
            $where_kelas = "AND CAST(ks.id_kelas_setting AS UNSIGNED) = ?";
            $params[] = $id_kelas_setting;
        }

        if ($status != '') {
            $where_status = "AND s.status_pendaftaran = ?";
            $params[] = $status;
        }

        $sql = $this->db->query("SELECT
                                    s.*,
                                    ks.id_kelas_setting,
                                    kset.nama_kelas,
                                    kset.id_periode,
                                    ta.periode,
                                    CASE
                                        WHEN EXISTS(
                                            SELECT 1
                                            FROM kelas_siswa cek_ks
                                            WHERE CAST(cek_ks.id_siswa AS UNSIGNED) = s.id
                                        )
                                        OR EXISTS(
                                            SELECT 1
                                            FROM tagihan_riwayat_kelas_siswa cek_rk
                                            WHERE CAST(cek_rk.id_siswa AS UNSIGNED) = s.id
                                        )
                                        THEN 1 ELSE 0
                                    END AS ada_kesiswaan,
                                    CASE
                                        WHEN s.status_pendaftaran IN ('Aktif','Nonaktif')
                                        AND NOT EXISTS(
                                            SELECT 1
                                            FROM kelas_siswa cek_ks2
                                            WHERE CAST(cek_ks2.id_siswa AS UNSIGNED) = s.id
                                        )
                                        AND NOT EXISTS(
                                            SELECT 1
                                            FROM tagihan_riwayat_kelas_siswa cek_rk2
                                            WHERE CAST(cek_rk2.id_siswa AS UNSIGNED) = s.id
                                        )
                                        THEN 1 ELSE 0
                                    END AS status_boleh_diubah,
                                    CASE
                                        WHEN NOT EXISTS(
                                            SELECT 1
                                            FROM kelas_siswa cek_ks3
                                            WHERE CAST(cek_ks3.id_siswa AS UNSIGNED) = s.id
                                        )
                                        AND NOT EXISTS(
                                            SELECT 1
                                            FROM tagihan_riwayat_kelas_siswa cek_rk3
                                            WHERE CAST(cek_rk3.id_siswa AS UNSIGNED) = s.id
                                        )
                                        THEN 1 ELSE 0
                                    END AS boleh_hapus
                                  FROM siswa s
                                  LEFT JOIN kelas_siswa ks ON ks.id = (
                                      SELECT MAX(ks2.id)
                                      FROM kelas_siswa ks2
                                      WHERE CAST(ks2.id_siswa AS UNSIGNED) = s.id
                                      AND ks2.status_aktif = '1'
                                  )
                                  LEFT JOIN kelas_setting kset ON kset.id = CAST(ks.id_kelas_setting AS UNSIGNED)
                                  LEFT JOIN master_tahun_ajaran ta ON ta.id = CAST(kset.id_periode AS UNSIGNED)
                                  WHERE 1 = 1
                                  $where_search
                                  $where_periode
                                  $where_kelas
                                  $where_status
                                  ORDER BY s.nama_lengkap ASC
                                  LIMIT 500", $params)->result_array();

        return $sql;
    }

    public function cari()
    {
        $q = trim((string)$this->input->post('q', true));

        if (strlen($q) < 2) {
            return array();
        }

        $like = '%' . $q . '%';

        $sql = $this->db->query("SELECT
                                    s.id,
                                    s.nis,
                                    s.nisn,
                                    s.nama_lengkap,
                                    s.status_pendaftaran,
                                    s.telepon_ayah,
                                    s.telepon_ibu,
                                    kset.nama_kelas,
                                    kset.id AS id_kelas_setting,
                                    kset.id_kelas,
                                    kset.id_periode,
                                    ta.periode
                                  FROM siswa s
                                  LEFT JOIN kelas_siswa ks ON ks.id = (
                                      SELECT MAX(x.id)
                                      FROM kelas_siswa x
                                      WHERE CAST(x.id_siswa AS UNSIGNED) = s.id
                                      AND x.status_aktif = '1'
                                  )
                                  LEFT JOIN kelas_setting kset ON kset.id = CAST(ks.id_kelas_setting AS UNSIGNED)
                                  LEFT JOIN master_tahun_ajaran ta ON ta.id = CAST(kset.id_periode AS UNSIGNED)
                                  WHERE s.nama_lengkap LIKE ?
                                  OR s.nis LIKE ?
                                  OR s.nisn LIKE ?
                                  ORDER BY s.nama_lengkap ASC
                                  LIMIT 20", array($like, $like, $like))->result_array();

        return $sql;
    }

    public function tambah()
    {
        $nis = trim((string)$this->input->post('nis', true));
        $nisn = trim((string)$this->input->post('nisn', true));
        $nama_lengkap = trim((string)$this->input->post('nama_lengkap', true));
        $jk = trim((string)$this->input->post('jk', true));
        $tempat_lahir = trim((string)$this->input->post('tempat_lahir', true));
        $tanggal_lahir = trim((string)$this->input->post('tanggal_lahir', true));
        $tanggal_awal_masuk = trim((string)$this->input->post('tanggal_awal_masuk', true));
        $alamat_siswa = trim((string)$this->input->post('alamat_siswa', true));
        $nama_ayah = trim((string)$this->input->post('nama_ayah', true));
        $pekerjaan_ayah = trim((string)$this->input->post('pekerjaan_ayah', true));
        $telepon_ayah = trim((string)$this->input->post('telepon_ayah', true));
        $alamat_ayah = trim((string)$this->input->post('alamat_ayah', true));
        $nama_ibu = trim((string)$this->input->post('nama_ibu', true));
        $pekerjaan_ibu = trim((string)$this->input->post('pekerjaan_ibu', true));
        $telepon_ibu = trim((string)$this->input->post('telepon_ibu', true));
        $alamat_ibu = trim((string)$this->input->post('alamat_ibu', true));
        $status_pendaftaran = trim((string)$this->input->post('status_pendaftaran', true));

        if ($nis == '' || $nisn == '' || $nama_lengkap == '' || $jk == '') {
            return array(
                'result' => 'false',
                'message' => 'NIS, NISN, nama, dan jenis kelamin wajib diisi.'
            );
        }

        if (!in_array($status_pendaftaran, array('Aktif', 'Nonaktif'), true)) {
            $status_pendaftaran = 'Aktif';
        }

        $cek_nis = $this->db->where('nis', $nis)->count_all_results('siswa');
        if ($cek_nis > 0) {
            return array(
                'result' => 'false',
                'message' => 'NIS sudah digunakan.'
            );
        }

        $cek_nisn = $this->db->where('nisn', $nisn)->count_all_results('siswa');
        if ($cek_nisn > 0) {
            return array(
                'result' => 'false',
                'message' => 'NISN sudah digunakan.'
            );
        }

        $data = array(
            'id_daftar_siswa' => '0',
            'foto_siswa' => '',
            'id_periode' => '0',
            'nis' => $nis,
            'nisn' => $nisn,
            'nama_lengkap' => $nama_lengkap,
            'jk' => $jk,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'tanggal_awal_masuk' => $tanggal_awal_masuk,
            'alamat_siswa' => $alamat_siswa,
            'nama_ayah' => $nama_ayah,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'telepon_ayah' => $telepon_ayah,
            'alamat_ayah' => $alamat_ayah,
            'nama_ibu' => $nama_ibu,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'telepon_ibu' => $telepon_ibu,
            'alamat_ibu' => $alamat_ibu,
            'status_pendaftaran' => $status_pendaftaran
        );

        $this->db->trans_begin();
        $this->db->insert('siswa', $data);
        $id = $this->db->insert_id();

        $this->tagihan_log_activity(
            'Tambah Siswa',
            'Master Data',
            'Tambah',
            'siswa',
            $id,
            $nis,
            'Pengelolaan identitas siswa',
            null,
            $data
        );

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = array(
                'result' => 'false',
                'message' => 'Data siswa gagal disimpan.'
            );
        } else {
            $this->db->trans_commit();
            $response = array(
                'result' => 'true',
                'message' => 'Data siswa berhasil disimpan.'
            );
        }

        return $response;
    }

    public function edit()
    {
        $id = (int)$this->input->post('id');
        $nis = trim((string)$this->input->post('nis', true));
        $nisn = trim((string)$this->input->post('nisn', true));
        $nama_lengkap = trim((string)$this->input->post('nama_lengkap', true));
        $jk = trim((string)$this->input->post('jk', true));
        $tempat_lahir = trim((string)$this->input->post('tempat_lahir', true));
        $tanggal_lahir = trim((string)$this->input->post('tanggal_lahir', true));
        $tanggal_awal_masuk = trim((string)$this->input->post('tanggal_awal_masuk', true));
        $alamat_siswa = trim((string)$this->input->post('alamat_siswa', true));
        $nama_ayah = trim((string)$this->input->post('nama_ayah', true));
        $pekerjaan_ayah = trim((string)$this->input->post('pekerjaan_ayah', true));
        $telepon_ayah = trim((string)$this->input->post('telepon_ayah', true));
        $alamat_ayah = trim((string)$this->input->post('alamat_ayah', true));
        $nama_ibu = trim((string)$this->input->post('nama_ibu', true));
        $pekerjaan_ibu = trim((string)$this->input->post('pekerjaan_ibu', true));
        $telepon_ibu = trim((string)$this->input->post('telepon_ibu', true));
        $alamat_ibu = trim((string)$this->input->post('alamat_ibu', true));
        $status_pendaftaran = trim((string)$this->input->post('status_pendaftaran', true));

        $before = $this->db->where('id', $id)->get('siswa')->row_array();
        if (!$before) {
            return array(
                'result' => 'false',
                'message' => 'Data siswa tidak ditemukan.'
            );
        }

        if ($nis == '' || $nisn == '' || $nama_lengkap == '' || $jk == '') {
            return array(
                'result' => 'false',
                'message' => 'NIS, NISN, nama, dan jenis kelamin wajib diisi.'
            );
        }

        $cek_nis = $this->db->where('nis', $nis)->where('id !=', $id)->count_all_results('siswa');
        if ($cek_nis > 0) {
            return array(
                'result' => 'false',
                'message' => 'NIS sudah digunakan.'
            );
        }

        $cek_nisn = $this->db->where('nisn', $nisn)->where('id !=', $id)->count_all_results('siswa');
        if ($cek_nisn > 0) {
            return array(
                'result' => 'false',
                'message' => 'NISN sudah digunakan.'
            );
        }

        $cek_kelas = $this->db
            ->where('id_siswa', (string)$id)
            ->count_all_results('kelas_siswa');

        $cek_riwayat = $this->db
            ->where('id_siswa', $id)
            ->count_all_results('tagihan_riwayat_kelas_siswa');

        $status_boleh_diubah = ($cek_kelas == 0 && $cek_riwayat == 0);

        if (!$status_boleh_diubah) {
            $status_pendaftaran = $before['status_pendaftaran'];
        } else {
            if (!in_array($status_pendaftaran, array('Aktif', 'Nonaktif'), true)) {
                $status_pendaftaran = $before['status_pendaftaran'];
            }

            if (!in_array($before['status_pendaftaran'], array('Aktif', 'Nonaktif'), true)) {
                $status_pendaftaran = $before['status_pendaftaran'];
            }
        }

        $data = array(
            'nis' => $nis,
            'nisn' => $nisn,
            'nama_lengkap' => $nama_lengkap,
            'jk' => $jk,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'tanggal_awal_masuk' => $tanggal_awal_masuk,
            'alamat_siswa' => $alamat_siswa,
            'nama_ayah' => $nama_ayah,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'telepon_ayah' => $telepon_ayah,
            'alamat_ayah' => $alamat_ayah,
            'nama_ibu' => $nama_ibu,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'telepon_ibu' => $telepon_ibu,
            'alamat_ibu' => $alamat_ibu,
            'status_pendaftaran' => $status_pendaftaran
        );

        $this->db->trans_begin();
        $this->db->update('siswa', $data, array('id' => $id));

        $this->tagihan_log_activity(
            'Ubah Siswa',
            'Master Data',
            'Ubah',
            'siswa',
            $id,
            $nis,
            'Pengelolaan identitas siswa',
            $before,
            $data
        );

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = array(
                'result' => 'false',
                'message' => 'Data siswa gagal diubah.'
            );
        } else {
            $this->db->trans_commit();
            $response = array(
                'result' => 'true',
                'message' => 'Data siswa berhasil diubah.'
            );
        }

        return $response;
    }

    public function hapus()
    {
        $id = (int)$this->input->post('id');

        $row = $this->db->where('id', $id)->get('siswa')->row_array();
        if (!$row) {
            return array(
                'result' => 'false',
                'message' => 'Data siswa tidak ditemukan.'
            );
        }

        // Siswa hanya boleh dihapus jika belum pernah ditempatkan
        // dan belum mempunyai riwayat pada proses Kesiswaan.
        $cek_kelas = $this->db
            ->where('id_siswa', (string)$id)
            ->count_all_results('kelas_siswa');

        $cek_riwayat = $this->db
            ->where('id_siswa', $id)
            ->count_all_results('tagihan_riwayat_kelas_siswa');

        if ($cek_kelas > 0 || $cek_riwayat > 0) {
            return array(
                'result' => 'false',
                'message' => 'Siswa tidak dapat dihapus karena sudah ditempatkan atau sudah memiliki riwayat Kesiswaan.'
            );
        }

        $this->db->trans_begin();
        $this->db->delete('siswa', array('id' => $id));

        $this->tagihan_log_activity(
            'Hapus Siswa',
            'Master Data',
            'Hapus',
            'siswa',
            $id,
            $row['nis'],
            'Hapus siswa yang belum ditempatkan dan belum memiliki riwayat Kesiswaan',
            $row,
            null
        );

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = array(
                'result' => 'false',
                'message' => 'Data siswa gagal dihapus.'
            );
        } else {
            $this->db->trans_commit();
            $response = array(
                'result' => 'true',
                'message' => 'Data siswa berhasil dihapus.'
            );
        }

        return $response;
    }

    private function tagihan_log_activity($jenis, $modul, $aksi, $table, $id, $nomor, $keterangan, $before = null, $after = null)
    {
        $user = $this->session->userdata('admin');

        $this->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => $jenis,
            'modul' => $modul,
            'aksi' => $aksi,
            'nama_tabel' => $table,
            'id_referensi' => (string)$id,
            'nomor_referensi' => $nomor,
            'keterangan' => $keterangan,
            'data_sebelum' => $before === null ? null : json_encode($before, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => $after === null ? null : json_encode($after, JSON_UNESCAPED_UNICODE),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => is_array($user) && isset($user['id']) ? (int)$user['id'] : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator'
        ));
    }
}
?>
