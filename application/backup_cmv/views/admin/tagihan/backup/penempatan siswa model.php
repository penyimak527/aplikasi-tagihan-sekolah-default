penempatan siswa model 
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_penempatan_siswa extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }
    public function kelas_list()
    {
        return $this->db->select('ks.*,ta.periode')->from('kelas_setting ks')->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')->order_by('ta.id', 'DESC')->order_by('ks.nama_kelas')->get()->result_array();
    }
    public function result()
    {
        $id = (int)$this->input->post('id_kelas_setting');
        $kelas = $this->db->where('id', $id)->get('kelas_setting')->row_array();
        if (!$kelas) return array('result' => 'false', 'message' => 'Pilih kelas tujuan.');
        $search = trim((string)$this->input->post('search', true));
        $q = '%' . $search . '%';
        $unplaced = $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.jk,s.status_pendaftaran FROM siswa s
            WHERE s.status_pendaftaran='Aktif' AND (s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ?)
            AND NOT EXISTS(SELECT 1 FROM kelas_siswa x INNER JOIN kelas_setting k ON k.id=CAST(x.id_kelas_setting AS UNSIGNED)
                WHERE CAST(x.id_siswa AS UNSIGNED)=s.id AND x.status_aktif='1' AND CAST(k.id_periode AS UNSIGNED)=?)
            ORDER BY s.nama_lengkap LIMIT 500", array($q, $q, $q, (int)$kelas['id_periode']))->result_array();
        $placed = $this->db->query("SELECT ks.id AS id_kelas_siswa,s.id,s.nis,s.nisn,s.nama_lengkap,s.jk FROM kelas_siswa ks INNER JOIN siswa s ON s.id=CAST(ks.id_siswa AS UNSIGNED) WHERE CAST(ks.id_kelas_setting AS UNSIGNED)=? AND ks.status_aktif='1' ORDER BY s.nama_lengkap", array($id))->result_array();
        return array('result' => 'true', 'unplaced' => $unplaced, 'placed' => $placed, 'kelas' => $kelas);
    }
    public function proses()
    {
        $idKelas = (int)$this->input->post('id_kelas_setting');
        $ids = $this->input->post('id_siswa');
        if (!is_array($ids)) $ids = array();
        $kelas = $this->db->where('id', $idKelas)->get('kelas_setting')->row_array();
        if (!$kelas || !$ids) return model_response(false, 'Pilih kelas dan minimal satu siswa.');
        $periode = $this->db->where('id', (int)$kelas['id_periode'])->get('master_tahun_ajaran')->row_array();
        $this->db->trans_begin();
        $success = 0;
        $skip = 0;
        foreach ($ids as $sid) {
            $sid = (int)$sid;
            $s = $this->db->where('id', $sid)->get('siswa')->row_array();
            if (!$s) {
                $skip++;
                continue;
            }
            $exists = $this->db->query("SELECT COUNT(*) total FROM kelas_siswa x INNER JOIN kelas_setting k ON k.id=CAST(x.id_kelas_setting AS UNSIGNED) WHERE CAST(x.id_siswa AS UNSIGNED)=? AND x.status_aktif='1' AND CAST(k.id_periode AS UNSIGNED)=?", array($sid, (int)$kelas['id_periode']))->row()->total;
            if ($exists) {
                $skip++;
                continue;
            }
            $this->db->insert('kelas_siswa', array('id_kelas_setting' => (string)$idKelas, 'id_siswa' => (string)$sid, 'nama_siswa' => $s['nama_lengkap'], 'nisn' => $s['nisn'], 'jenis_kelamin' => $s['jk'], 'status_aktif' => '1'));
            $this->db->insert('tagihan_riwayat_kelas_siswa', array('id_siswa' => $sid, 'nis' => $s['nis'], 'nisn' => $s['nisn'], 'nama_siswa' => $s['nama_lengkap'], 'id_kelas_setting_tujuan' => $idKelas, 'id_kelas_tujuan' => (int)$kelas['id_kelas'], 'nama_kelas_tujuan' => $kelas['nama_kelas'], 'id_periode_tujuan' => (int)$kelas['id_periode'], 'periode_tujuan' => $periode ? $periode['periode'] : '', 'semester_tujuan' => null, 'jenis_proses' => 'Penempatan', 'status_sebelum' => 'Belum Ditempatkan', 'status_setelah' => 'Aktif', 'tanggal_proses' => tanggal_sekarang(), 'waktu_proses' => waktu_sekarang(), 'id_user' => app_user_id(), 'nama_user' => app_user_name(), 'status_riwayat' => 'Aktif'));
            $success++;
        }
        tagihan_log_activity('Penempatan Siswa', 'Kesiswaan', 'Tambah', 'kelas_siswa', $idKelas, $kelas['nama_kelas'], 'Menempatkan ' . $success . ' siswa; dilewati ' . $skip, null, array('id_siswa' => $ids));
        return tagihan_transaction_result($success . ' siswa berhasil ditempatkan' . ($skip ? ' dan ' . $skip . ' dilewati.' : '.'));
    }
    public function keluarkan()
    {
        $id = (int)$this->input->post('id_kelas_siswa');
        $row = $this->db->query("SELECT ks.*,s.nis,s.nama_lengkap,k.nama_kelas FROM kelas_siswa ks JOIN siswa s ON s.id=CAST(ks.id_siswa AS UNSIGNED) JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) WHERE ks.id=?", array($id))->row_array();
        if (!$row) return model_response(false, 'Penempatan tidak ditemukan.');
        if ($this->db->where('id_siswa', (int)$row['id_siswa'])->where('id_kelas_setting', (int)$row['id_kelas_setting'])->count_all_results('tagihan_siswa')) return model_response(false, 'Penempatan sudah digunakan pada tagihan dan tidak dapat dikeluarkan langsung.');
        $this->db->trans_begin();
        $this->db->where('id', $id)->update('kelas_siswa', array('status_aktif' => '0'));
        tagihan_log_activity('Koreksi Penempatan', 'Kesiswaan', 'Batal', 'kelas_siswa', $id, $row['nis'], 'Mengeluarkan penempatan yang belum digunakan', $row, array('status_aktif' => '0'));
        return tagihan_transaction_result('Penempatan siswa berhasil dikeluarkan.');
    }
}
