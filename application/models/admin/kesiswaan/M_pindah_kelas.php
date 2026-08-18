<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_pindah_kelas extends CI_Model
{
    public function kelas_list()
    {
        return $this->db->select('ks.*,ta.periode')->from('kelas_setting ks')->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')->order_by('ta.id', 'DESC')->order_by('ks.nama_kelas')->get()->result_array();
    }
    public function cari()
    {
        $q = trim((string)$this->input->post('q', true));
        $like = '%' . $q . '%';
        return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran,ks.id id_kelas_siswa,k.id id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s JOIN kelas_siswa ks ON ks.id=(SELECT MAX(x.id) FROM kelas_siswa x WHERE CAST(x.id_siswa AS UNSIGNED)=s.id AND x.status_aktif='1') JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ? ORDER BY s.nama_lengkap LIMIT 20", array($like, $like, $like))->result_array();
    }
    public function proses()
    {
        $sid = (int)$this->input->post('id_siswa');
        $asalId = (int)$this->input->post('id_kelas_asal');
        $tujuanId = (int)$this->input->post('id_kelas_tujuan');
        $tanggal = trim((string)$this->input->post('tanggal_pindah', true));
        $alasan = trim((string)$this->input->post('alasan', true));
        if (!$sid || !$asalId || !$tujuanId || $asalId === $tujuanId || $alasan === '') return $this->model_response(false, 'Data siswa, kelas tujuan, tanggal, dan alasan wajib diisi.');
        $s = $this->db->where('id', $sid)->get('siswa')->row_array();
        $asal = $this->db->where('id', $asalId)->get('kelas_setting')->row_array();
        $tujuan = $this->db->where('id', $tujuanId)->get('kelas_setting')->row_array();
        if (!$s || !$asal || !$tujuan) return $this->model_response(false, 'Data referensi tidak ditemukan.');
        if ((int)$asal['id_periode'] !== (int)$tujuan['id_periode']) return $this->model_response(false, 'Kelas tujuan harus pada tahun ajaran yang sama.');
        $periode = $this->db->where('id', (int)$asal['id_periode'])->get('master_tahun_ajaran')->row_array();
        $this->db->trans_begin();
        $this->db->where('id_siswa', (string)$sid)->where('id_kelas_setting', (string)$asalId)->where('status_aktif', '1')->update('kelas_siswa', array('status_aktif' => '0'));
        $this->db->insert('kelas_siswa', array('id_kelas_setting' => (string)$tujuanId, 'id_siswa' => (string)$sid, 'nama_siswa' => $s['nama_lengkap'], 'nisn' => $s['nisn'], 'jenis_kelamin' => $s['jk'], 'status_aktif' => '1'));
        $history = array('id_siswa' => $sid, 'nis' => $s['nis'], 'nisn' => $s['nisn'], 'nama_siswa' => $s['nama_lengkap'], 'id_kelas_setting_asal' => $asalId, 'id_kelas_asal' => (int)$asal['id_kelas'], 'nama_kelas_asal' => $asal['nama_kelas'], 'id_periode_asal' => (int)$asal['id_periode'], 'periode_asal' => $periode ? $periode['periode'] : '', 'semester_asal' => null, 'id_kelas_setting_tujuan' => $tujuanId, 'id_kelas_tujuan' => (int)$tujuan['id_kelas'], 'nama_kelas_tujuan' => $tujuan['nama_kelas'], 'id_periode_tujuan' => (int)$tujuan['id_periode'], 'periode_tujuan' => $periode ? $periode['periode'] : '', 'semester_tujuan' => null, 'jenis_proses' => 'Pindah Kelas', 'status_sebelum' => 'Aktif', 'status_setelah' => 'Aktif', 'alasan' => $alasan, 'tanggal_proses' => $tanggal ?: $this->tanggal_sekarang(), 'waktu_proses' => $this->waktu_sekarang(), 'id_user' => $this->app_user_id(), 'nama_user' => $this->app_user_name(), 'status_riwayat' => 'Aktif');
        $this->db->insert('tagihan_riwayat_kelas_siswa', $history);
        $this->tagihan_log_activity('Pindah Kelas', 'Kesiswaan', 'Ubah', 'kelas_siswa', $sid, $s['nis'], $asal['nama_kelas'] . ' ke ' . $tujuan['nama_kelas'], array('kelas' => $asal), array('kelas' => $tujuan, 'alasan' => $alasan));
        return $this->tagihan_transaction_result('Siswa berhasil dipindahkan ke kelas tujuan.');
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


    private function tanggal_sekarang()
    {
        return date('d-m-Y');
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
