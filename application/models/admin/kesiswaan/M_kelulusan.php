<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_kelulusan extends CI_Model
{
    public function kelas_list()
    {
        return $this->db->select('ks.*,ta.periode')->from('kelas_setting ks')->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')->order_by('ta.id', 'DESC')->order_by('ks.nama_kelas')->get()->result_array();
    }
    public function siswa()
    {
        $id = (int)$this->input->post('id_kelas_setting');
        return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran,COALESCE(SUM(CASE WHEN t.dianggap_tunggakan='Ya' AND t.status_tagihan='Aktif' THEN t.sisa_tagihan ELSE 0 END),0) tunggakan FROM kelas_siswa ks JOIN siswa s ON s.id=CAST(ks.id_siswa AS UNSIGNED) LEFT JOIN tagihan_siswa t ON t.id_siswa=s.id WHERE CAST(ks.id_kelas_setting AS UNSIGNED)=? AND ks.status_aktif='1' GROUP BY s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran ORDER BY s.nama_lengkap", array($id))->result_array();
    }
    public function preview()
    {
        $idKelas = (int)$this->input->post('id_kelas_setting');
        $ids = $this->input->post('id_siswa');
        if (!is_array($ids)) $ids = array();
        $kelas = $this->db->where('id', $idKelas)->get('kelas_setting')->row_array();
        if (!$kelas || !$ids) return $this->model_response(false, 'Kelas dan siswa wajib dipilih.');
        $tunggakan = 0;
        $lunas = 0;
        foreach ($ids as $sid) {
            $total = (float)$this->db->select_sum('sisa_tagihan', 'total')->where('id_siswa', (int)$sid)->where('dianggap_tunggakan', 'Ya')->where('status_tagihan', 'Aktif')->where_not_in('status_pembayaran', array('Lunas', 'Dibebaskan', 'Dibatalkan'))->get('tagihan_siswa')->row()->total;
            if ($total > 0) $tunggakan++;
            else $lunas++;
        }
        return $this->model_response(true, 'Preview siap.', array('kelas' => $kelas, 'jumlah' => count($ids), 'masih_tunggakan' => $tunggakan, 'lunas' => $lunas));
    }
    public function proses()
    {
        $idKelas = (int)$this->input->post('id_kelas_setting');
        $ids = $this->input->post('id_siswa');
        $tanggal = trim((string)$this->input->post('tanggal_lulus', true));
        $tahun = trim((string)$this->input->post('tahun_kelulusan', true));
        if (!is_array($ids)) $ids = array();
        $kelas = $this->db->where('id', $idKelas)->get('kelas_setting')->row_array();
        if (!$kelas || !$ids || $tanggal === '' || $tahun === '') return $this->model_response(false, 'Kelas, siswa, tanggal lulus, dan tahun kelulusan wajib diisi.');
        $periode = $this->db->where('id', (int)$kelas['id_periode'])->get('master_tahun_ajaran')->row_array();
        $this->db->trans_begin();
        $success = 0;
        foreach ($ids as $sid) {
            $sid = (int)$sid;
            $s = $this->db->where('id', $sid)->get('siswa')->row_array();
            if (!$s) continue;
            $this->db->where('id', $sid)->update('siswa', array('status_pendaftaran' => 'Lulus'));
            $this->db->where('id_siswa', (string)$sid)->where('id_kelas_setting', (string)$idKelas)->where('status_aktif', '1')->update('kelas_siswa', array('status_aktif' => '0'));
            $this->db->insert('tagihan_riwayat_kelas_siswa', array('id_siswa' => $sid, 'nis' => $s['nis'], 'nisn' => $s['nisn'], 'nama_siswa' => $s['nama_lengkap'], 'id_kelas_setting_asal' => $idKelas, 'id_kelas_asal' => (int)$kelas['id_kelas'], 'nama_kelas_asal' => $kelas['nama_kelas'], 'id_periode_asal' => (int)$kelas['id_periode'], 'periode_asal' => $periode ? $periode['periode'] : '', 'semester_asal' => null, 'jenis_proses' => 'Lulus', 'status_sebelum' => $s['status_pendaftaran'], 'status_setelah' => 'Lulus', 'alasan' => 'Lulus tahun ' . $tahun, 'tanggal_proses' => $tanggal, 'waktu_proses' => $this->waktu_sekarang(), 'id_user' => $this->app_user_id(), 'nama_user' => $this->app_user_name(), 'status_riwayat' => 'Aktif'));
            $success++;
        }
        $this->tagihan_log_activity('Kelulusan Siswa', 'Kesiswaan', 'Ubah', 'siswa', $idKelas, $kelas['nama_kelas'], 'Meluluskan ' . $success . ' siswa tahun ' . $tahun, null, array('siswa' => $ids));
        return $this->tagihan_transaction_result($success . ' siswa berhasil diproses lulus.');
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
