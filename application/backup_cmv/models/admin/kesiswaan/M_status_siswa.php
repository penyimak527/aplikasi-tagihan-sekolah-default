<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_status_siswa extends CI_Model
{
    public function cari()
    {
        $q = trim((string)$this->input->post('q', true));
        $like = '%' . $q . '%';
        return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran,ks.id id_kelas_siswa,k.id id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON ks.id=(SELECT MAX(x.id) FROM kelas_siswa x WHERE CAST(x.id_siswa AS UNSIGNED)=s.id AND x.status_aktif='1') LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ? ORDER BY s.nama_lengkap LIMIT 20", array($like, $like, $like))->result_array();
    }
    public function proses()
    {
        $sid = (int)$this->input->post('id_siswa');
        $status = trim((string)$this->input->post('status_baru', true));
        $tanggal = trim((string)$this->input->post('tanggal', true));
        $alasan = trim((string)$this->input->post('alasan', true));
        if (!$sid || !in_array($status, array('Pindah Sekolah', 'Berhenti'), true) || $tanggal === '' || $alasan === '') return model_response(false, 'Siswa, status baru, tanggal, dan alasan wajib diisi.');
        $s = $this->db->where('id', $sid)->get('siswa')->row_array();
        if (!$s) return model_response(false, 'Siswa tidak ditemukan.');
        $kelas = $this->db->query("SELECT ks.id id_kelas_siswa,k.*,ta.periode FROM kelas_siswa ks JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE CAST(ks.id_siswa AS UNSIGNED)=? AND ks.status_aktif='1' ORDER BY ks.id DESC LIMIT 1", array($sid))->row_array();
        $this->db->trans_begin();
        $this->db->where('id', $sid)->update('siswa', array('status_pendaftaran' => $status));
        if ($kelas) $this->db->where('id', (int)$kelas['id_kelas_siswa'])->update('kelas_siswa', array('status_aktif' => '0'));
        $this->db->insert('tagihan_riwayat_kelas_siswa', array('id_siswa' => $sid, 'nis' => $s['nis'], 'nisn' => $s['nisn'], 'nama_siswa' => $s['nama_lengkap'], 'id_kelas_setting_asal' => $kelas ? (int)$kelas['id'] : 0, 'id_kelas_asal' => $kelas ? (int)$kelas['id_kelas'] : 0, 'nama_kelas_asal' => $kelas ? $kelas['nama_kelas'] : '', 'id_periode_asal' => $kelas ? (int)$kelas['id_periode'] : 0, 'periode_asal' => $kelas ? $kelas['periode'] : '', 'semester_asal' => null, 'jenis_proses' => $status === 'Berhenti' ? 'Berhenti' : 'Pindah Sekolah', 'status_sebelum' => $s['status_pendaftaran'], 'status_setelah' => $status, 'alasan' => $alasan, 'tanggal_proses' => $tanggal, 'waktu_proses' => waktu_sekarang(), 'id_user' => app_user_id(), 'nama_user' => app_user_name(), 'status_riwayat' => 'Aktif'));
        tagihan_log_activity('Perubahan Status Siswa', 'Kesiswaan', 'Ubah', 'siswa', $sid, $s['nis'], 'Status menjadi ' . $status . ' - ' . $alasan, $s, array('status_pendaftaran' => $status));
        return tagihan_transaction_result('Status siswa berhasil diubah. Tagihan lama tetap tersimpan.');
    }
}
