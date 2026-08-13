<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_riwayat_kelas extends CI_Model
{
    public function kelas_list()
    {
        return $this->db
            ->select('ks.*, ta.periode')
            ->from('kelas_setting ks')
            ->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')
            ->order_by('ta.id', 'DESC')
            ->order_by('ks.nama_kelas', 'ASC')
            ->get()
            ->result_array();
    }

    public function cari()
    {
        $q = trim((string) $this->input->post('q', true));
        if (strlen($q) < 2) {
            return array();
        }
        $like = '%' . $q . '%';
        return $this->db->query(
            "SELECT id,nis,nisn,nama_lengkap,status_pendaftaran
             FROM siswa
             WHERE nama_lengkap LIKE ? OR nis LIKE ? OR nisn LIKE ?
             ORDER BY nama_lengkap
             LIMIT 20",
            array($like, $like, $like)
        )->result_array();
    }

    public function result()
    {
        $id = (int) $this->input->post('id_siswa');
        $siswa = $this->db->where('id', $id)->get('siswa')->row_array();
        if (!$siswa) {
            return array('result' => 'false', 'message' => 'Siswa tidak ditemukan.');
        }

        $placements = $this->db->query(
            "SELECT ks.id,ks.status_aktif,k.id id_kelas_setting,k.nama_kelas,ta.periode,
                    (SELECT h.jenis_proses FROM tagihan_riwayat_kelas_siswa h
                     WHERE h.id_siswa=? AND h.id_kelas_setting_tujuan=k.id
                     ORDER BY h.id DESC LIMIT 1) jenis_proses,
                    (SELECT h.tanggal_proses FROM tagihan_riwayat_kelas_siswa h
                     WHERE h.id_siswa=? AND h.id_kelas_setting_tujuan=k.id
                     ORDER BY h.id DESC LIMIT 1) tanggal_proses,
                    (SELECT h.nama_user FROM tagihan_riwayat_kelas_siswa h
                     WHERE h.id_siswa=? AND h.id_kelas_setting_tujuan=k.id
                     ORDER BY h.id DESC LIMIT 1) nama_user
             FROM kelas_siswa ks
             JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED)
             LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED)
             WHERE CAST(ks.id_siswa AS UNSIGNED)=?
             ORDER BY ta.id,ks.id",
            array($id, $id, $id, $id)
        )->result_array();

        $history = $this->db
            ->where('id_siswa', $id)
            ->order_by('id', 'DESC')
            ->get('tagihan_riwayat_kelas_siswa')
            ->result_array();

        $active = null;
        foreach ($placements as $placement) {
            if ((string) $placement['status_aktif'] === '1') {
                $active = $placement;
            }
        }

        return array(
            'result' => 'true',
            'siswa' => $siswa,
            'placements' => $placements,
            'history' => $history,
            'active' => $active
        );
    }

    public function koreksi()
    {
        $idSiswa = (int) $this->input->post('id_siswa');
        $idTujuan = (int) $this->input->post('id_kelas_tujuan');
        $alasan = trim((string) $this->input->post('alasan', true));

        if (!$idSiswa || !$idTujuan || $alasan === '') {
            return model_response(false, 'Siswa, kelas koreksi, dan alasan wajib diisi.');
        }

        $siswa = $this->db->where('id', $idSiswa)->get('siswa')->row_array();
        $tujuan = $this->db->where('id', $idTujuan)->get('kelas_setting')->row_array();
        $asal = $this->db->query(
            "SELECT ks.id id_kelas_siswa,k.*,ta.periode
             FROM kelas_siswa ks
             JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED)
             LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED)
             WHERE CAST(ks.id_siswa AS UNSIGNED)=? AND ks.status_aktif='1'
             ORDER BY ks.id DESC LIMIT 1",
            array($idSiswa)
        )->row_array();

        if (!$siswa || !$tujuan || !$asal) {
            return model_response(false, 'Data siswa atau penempatan aktif tidak ditemukan.');
        }
        if ((int) $asal['id'] === $idTujuan) {
            return model_response(false, 'Kelas koreksi sama dengan kelas aktif saat ini.');
        }

        $periodeTujuan = $this->db->where('id', (int) $tujuan['id_periode'])->get('master_tahun_ajaran')->row_array();
        $tagihanTerkait = $this->db
            ->where('id_siswa', $idSiswa)
            ->where('id_kelas_setting', (int) $asal['id'])
            ->count_all_results('tagihan_siswa');

        $this->db->trans_begin();

        $this->db->where('id', (int) $asal['id_kelas_siswa'])->update('kelas_siswa', array('status_aktif' => '0'));
        $this->db->insert('kelas_siswa', array(
            'id_kelas_setting' => (string) $idTujuan,
            'id_siswa' => (string) $idSiswa,
            'nama_siswa' => $siswa['nama_lengkap'],
            'nisn' => $siswa['nisn'],
            'jenis_kelamin' => $siswa['jk'],
            'status_aktif' => '1'
        ));

        $history = array(
            'id_siswa' => $idSiswa,
            'nis' => $siswa['nis'],
            'nisn' => $siswa['nisn'],
            'nama_siswa' => $siswa['nama_lengkap'],
            'id_kelas_setting_asal' => (int) $asal['id'],
            'id_kelas_asal' => (int) $asal['id_kelas'],
            'nama_kelas_asal' => $asal['nama_kelas'],
            'id_periode_asal' => (int) $asal['id_periode'],
            'periode_asal' => $asal['periode'],
            'semester_asal' => null,
            'id_kelas_setting_tujuan' => $idTujuan,
            'id_kelas_tujuan' => (int) $tujuan['id_kelas'],
            'nama_kelas_tujuan' => $tujuan['nama_kelas'],
            'id_periode_tujuan' => (int) $tujuan['id_periode'],
            'periode_tujuan' => $periodeTujuan ? $periodeTujuan['periode'] : '',
            'semester_tujuan' => null,
            'jenis_proses' => 'Koreksi Penempatan',
            'status_sebelum' => 'Aktif',
            'status_setelah' => 'Aktif',
            'alasan' => $alasan,
            'tanggal_proses' => tanggal_sekarang(),
            'waktu_proses' => waktu_sekarang(),
            'id_user' => app_user_id(),
            'nama_user' => app_user_name(),
            'status_riwayat' => 'Aktif'
        );
        $this->db->insert('tagihan_riwayat_kelas_siswa', $history);

        tagihan_log_activity(
            'Koreksi Penempatan Siswa',
            'Kesiswaan',
            'Ubah',
            'kelas_siswa',
            $idSiswa,
            $siswa['nis'],
            $asal['nama_kelas'] . ' dikoreksi menjadi ' . $tujuan['nama_kelas'] . ' - ' . $alasan,
            array('kelas' => $asal),
            array('kelas' => $tujuan, 'alasan' => $alasan)
        );

        $result = tagihan_transaction_result('Penempatan terakhir berhasil dikoreksi.');
        if ($result['result'] === 'true' && $tagihanTerkait > 0) {
            $result['message'] .= ' Tagihan lama tetap menggunakan kelas saat tagihan diterbitkan.';
            $result['warning'] = true;
        }
        return $result;
    }
}
