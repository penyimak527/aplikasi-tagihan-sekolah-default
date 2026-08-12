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
        return $this->db->select('ks.*,ta.periode')->from('kelas_setting ks')->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')->order_by('ta.id', 'DESC')->order_by('ks.nama_kelas', 'ASC')->get()->result_array();
    }
    public function result()
    {
        $search = trim((string)$this->input->post('search', true));
        $periode = (int)$this->input->post('id_periode');
        $kelas = (int)$this->input->post('id_kelas_setting');
        $status = trim((string)$this->input->post('status', true));
        $sql = "SELECT s.*, ks.id_kelas_setting, kset.nama_kelas, kset.id_periode, ta.periode
              FROM siswa s
              LEFT JOIN kelas_siswa ks ON ks.id=(SELECT MAX(ks2.id) FROM kelas_siswa ks2 WHERE CAST(ks2.id_siswa AS UNSIGNED)=s.id AND ks2.status_aktif='1')
              LEFT JOIN kelas_setting kset ON kset.id=CAST(ks.id_kelas_setting AS UNSIGNED)
              LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(kset.id_periode AS UNSIGNED) WHERE 1=1";
        $params = array();
        if ($search !== '') {
            $sql .= " AND (s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ?)";
            $q = '%' . $search . '%';
            $params = array($q, $q, $q);
        }
        if ($periode > 0) {
            $sql .= " AND CAST(kset.id_periode AS UNSIGNED)=?";
            $params[] = $periode;
        }
        if ($kelas > 0) {
            $sql .= " AND CAST(ks.id_kelas_setting AS UNSIGNED)=?";
            $params[] = $kelas;
        }
        if ($status !== '') {
            $sql .= " AND s.status_pendaftaran=?";
            $params[] = $status;
        }
        $sql .= " ORDER BY s.nama_lengkap ASC LIMIT 500";
        return $this->db->query($sql, $params)->result_array();
    }
    public function detail()
    {
        return $this->db->where('id', (int)$this->input->post('id'))->get('siswa')->row_array();
    }
    public function cari()
    {
        $q = trim((string)$this->input->post('q', true));
        if (strlen($q) < 2) return array();
        $like = '%' . $q . '%';
        return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran,s.telepon_ayah,s.telepon_ibu,kset.nama_kelas,kset.id AS id_kelas_setting,kset.id_kelas,kset.id_periode,ta.periode
        FROM siswa s LEFT JOIN kelas_siswa ks ON ks.id=(SELECT MAX(x.id) FROM kelas_siswa x WHERE CAST(x.id_siswa AS UNSIGNED)=s.id AND x.status_aktif='1') LEFT JOIN kelas_setting kset ON kset.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(kset.id_periode AS UNSIGNED)
        WHERE s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ? ORDER BY s.nama_lengkap LIMIT 20", array($like, $like, $like))->result_array();
    }
    public function simpan()
    {
        $id = (int)$this->input->post('id');
        $nis = trim((string)$this->input->post('nis', true));
        $nisn = trim((string)$this->input->post('nisn', true));
        $nama = trim((string)$this->input->post('nama_lengkap', true));
        $jk = trim((string)$this->input->post('jk', true));
        if ($nis === '' || $nisn === '' || $nama === '' || $jk === '') return model_response(false, 'NIS, NISN, nama, dan jenis kelamin wajib diisi.');
        if ($this->db->where('nis', $nis)->where('id !=', $id)->count_all_results('siswa')) return model_response(false, 'NIS sudah digunakan.');
        if ($this->db->where('nisn', $nisn)->where('id !=', $id)->count_all_results('siswa')) return model_response(false, 'NISN sudah digunakan.');
        $fields = array('nis', 'nisn', 'nama_lengkap', 'jk', 'tempat_lahir', 'tanggal_lahir', 'tanggal_awal_masuk', 'alamat_siswa', 'nama_ayah', 'pekerjaan_ayah', 'telepon_ayah', 'alamat_ayah', 'nama_ibu', 'pekerjaan_ibu', 'telepon_ibu', 'alamat_ibu', 'status_pendaftaran');
        $data = array();
        foreach ($fields as $f) $data[$f] = trim((string)$this->input->post($f, true));
        $data['status_pendaftaran'] = $data['status_pendaftaran'] !== '' ? $data['status_pendaftaran'] : 'Aktif';
        $before = $id ? $this->db->where('id', $id)->get('siswa')->row_array() : null;
        if (!$id) {
            $data = array_merge(array('id_daftar_siswa' => '0', 'foto_siswa' => '', 'id_periode' => '0'), $data);
        }
        $this->db->trans_begin();
        if ($id) {
            $this->db->where('id', $id)->update('siswa', $data);
        } else {
            $this->db->insert('siswa', $data);
            $id = $this->db->insert_id();
        }
        tagihan_log_activity($before ? 'Ubah Siswa' : 'Tambah Siswa', 'Master Data', $before ? 'Ubah' : 'Tambah', 'siswa', $id, $nis, 'Pengelolaan identitas siswa', $before, $data);
        return tagihan_transaction_result('Data siswa berhasil disimpan.');
    }
    public function nonaktifkan()
    {
        $id = (int)$this->input->post('id');
        $status = trim((string)$this->input->post('status', true));
        if (!in_array($status, array('Aktif', 'Lulus', 'Pindah Sekolah', 'Berhenti', 'Nonaktif'), true)) $status = 'Nonaktif';
        $row = $this->db->where('id', $id)->get('siswa')->row_array();
        if (!$row) return model_response(false, 'Siswa tidak ditemukan.');
        $this->db->trans_begin();
        $this->db->where('id', $id)->update('siswa', array('status_pendaftaran' => $status));
        tagihan_log_activity('Ubah Status Siswa', 'Kesiswaan', 'Ubah', 'siswa', $id, $row['nis'], 'Status siswa menjadi ' . $status, $row, array('status_pendaftaran' => $status));
        return tagihan_transaction_result('Status siswa berhasil diubah.');
    }
}
