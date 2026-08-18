<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_status_siswa extends CI_Model
{
    public function cari()
    {
        $q = trim((string)$this->input->post('q', true));
        $like = '%' . $q . '%';

        $rows = $this->db->query(
            "SELECT
                s.id,
                s.nis,
                s.nisn,
                s.nama_lengkap,
                s.status_pendaftaran,
                ks.id id_kelas_siswa,
                k.id id_kelas_setting,
                k.id_kelas,
                k.nama_kelas,
                k.id_periode,
                ta.periode
             FROM siswa s
             LEFT JOIN kelas_siswa ks
                ON ks.id=(
                    SELECT MAX(x.id)
                    FROM kelas_siswa x
                    WHERE CAST(x.id_siswa AS UNSIGNED)=s.id
                      AND x.status_aktif='1'
                )
             LEFT JOIN kelas_setting k
                ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED)
             LEFT JOIN master_tahun_ajaran ta
                ON ta.id=CAST(k.id_periode AS UNSIGNED)
             WHERE s.nama_lengkap LIKE ?
                OR s.nis LIKE ?
                OR s.nisn LIKE ?
             ORDER BY s.nama_lengkap
             LIMIT 20",
            array($like, $like, $like)
        )->result_array();


        foreach ($rows as &$row) {
            if (!empty($row['id_kelas_setting'])) {
                continue;
            }

            $kelasTerakhir = $this->kelas_terakhir((int)$row['id']);
            if (!$kelasTerakhir) {
                continue;
            }

            $row['id_kelas_siswa'] = null;
            $row['id_kelas_setting'] = $kelasTerakhir['id_kelas_setting'];
            $row['id_kelas'] = $kelasTerakhir['id_kelas'];
            $row['nama_kelas'] = $kelasTerakhir['nama_kelas'];
            $row['id_periode'] = $kelasTerakhir['id_periode'];
            $row['periode'] = $kelasTerakhir['periode'];
        }
        unset($row);

        return $rows;
    }
    public function proses()
    {
        $sid = (int)$this->input->post('id_siswa');
        $status = trim((string)$this->input->post('status_baru', true));
        $tanggal = trim((string)$this->input->post('tanggal', true));
        $alasan = trim((string)$this->input->post('alasan', true));
        if (!$sid || !in_array($status, array('Pindah Sekolah', 'Berhenti'), true) || $tanggal === '' || $alasan === '') return $this->model_response(false, 'Siswa, status baru, tanggal, dan alasan wajib diisi.');
        $s = $this->db->where('id', $sid)->get('siswa')->row_array();
        if (!$s) return $this->model_response(false, 'Siswa tidak ditemukan.');

        if (in_array($s['status_pendaftaran'], array('Pindah Sekolah', 'Berhenti'), true)) {
            return $this->model_response(false, 'Siswa sudah berstatus ' . $s['status_pendaftaran'] . ' dan tidak dapat diproses ulang.');
        }

        $kelas = $this->db->query(
            "SELECT ks.id id_kelas_siswa,k.*,ta.periode
             FROM kelas_siswa ks
             JOIN kelas_setting k
                ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED)
             LEFT JOIN master_tahun_ajaran ta
                ON ta.id=CAST(k.id_periode AS UNSIGNED)
             WHERE CAST(ks.id_siswa AS UNSIGNED)=?
               AND ks.status_aktif='1'
             ORDER BY ks.id DESC
             LIMIT 1",
            array($sid)
        )->row_array();

        if (!$kelas) {
            $kelasTerakhir = $this->kelas_terakhir($sid);
            if ($kelasTerakhir) {
                $kelas = array(
                    'id_kelas_siswa' => null,
                    'id' => $kelasTerakhir['id_kelas_setting'],
                    'id_kelas' => $kelasTerakhir['id_kelas'],
                    'nama_kelas' => $kelasTerakhir['nama_kelas'],
                    'id_periode' => $kelasTerakhir['id_periode'],
                    'periode' => $kelasTerakhir['periode']
                );
            }
        }
        $this->db->trans_begin();
        $this->db->where('id', $sid)->update('siswa', array('status_pendaftaran' => $status));
        if ($kelas && !empty($kelas['id_kelas_siswa'])) {
            $this->db
                ->where('id', (int)$kelas['id_kelas_siswa'])
                ->update('kelas_siswa', array('status_aktif' => '0'));
        }
        $this->db->insert('tagihan_riwayat_kelas_siswa', array('id_siswa' => $sid, 'nis' => $s['nis'], 'nisn' => $s['nisn'], 'nama_siswa' => $s['nama_lengkap'], 'id_kelas_setting_asal' => $kelas ? (int)$kelas['id'] : 0, 'id_kelas_asal' => $kelas ? (int)$kelas['id_kelas'] : 0, 'nama_kelas_asal' => $kelas ? $kelas['nama_kelas'] : '', 'id_periode_asal' => $kelas ? (int)$kelas['id_periode'] : 0, 'periode_asal' => $kelas ? $kelas['periode'] : '', 'semester_asal' => null, 'jenis_proses' => $status === 'Berhenti' ? 'Berhenti' : 'Pindah Sekolah', 'status_sebelum' => $s['status_pendaftaran'], 'status_setelah' => $status, 'alasan' => $alasan, 'tanggal_proses' => $tanggal, 'waktu_proses' => $this->waktu_sekarang(), 'id_user' => $this->app_user_id(), 'nama_user' => $this->app_user_name(), 'status_riwayat' => 'Aktif'));
        $this->tagihan_log_activity('Perubahan Status Siswa', 'Kesiswaan', 'Ubah', 'siswa', $sid, $s['nis'], 'Status menjadi ' . $status . ' - ' . $alasan, $s, array('status_pendaftaran' => $status));
        return $this->tagihan_transaction_result('Status siswa berhasil diubah. Tagihan lama tetap tersimpan.');
    }

    private function kelas_terakhir($idSiswa)
    {
        $riwayat = $this->db
            ->where('id_siswa', (int)$idSiswa)
            ->where('status_riwayat', 'Aktif')
            ->order_by('id', 'DESC')
            ->get('tagihan_riwayat_kelas_siswa')
            ->row_array();

        if (!$riwayat) {
            return null;
        }

        $gunakanTujuan = !empty($riwayat['id_kelas_setting_tujuan']);

        return array(
            'id_kelas_setting' => $gunakanTujuan
                ? (int)$riwayat['id_kelas_setting_tujuan']
                : (int)$riwayat['id_kelas_setting_asal'],
            'id_kelas' => $gunakanTujuan
                ? (int)$riwayat['id_kelas_tujuan']
                : (int)$riwayat['id_kelas_asal'],
            'nama_kelas' => $gunakanTujuan
                ? $riwayat['nama_kelas_tujuan']
                : $riwayat['nama_kelas_asal'],
            'id_periode' => $gunakanTujuan
                ? (int)$riwayat['id_periode_tujuan']
                : (int)$riwayat['id_periode_asal'],
            'periode' => $gunakanTujuan
                ? $riwayat['periode_tujuan']
                : $riwayat['periode_asal']
        );
    }

    private function app_user_id()
    {
        $user = $this->session->userdata('admin');
        return is_array($user) && isset($user['id']) ? (int) $user['id'] : 0;
    }


    private function app_user_name()
    {
        $user = $this->session->userdata('admin');
        return is_array($user) && isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator';
    }


    private function waktu_sekarang()
    {
        return date('H:i:s');
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