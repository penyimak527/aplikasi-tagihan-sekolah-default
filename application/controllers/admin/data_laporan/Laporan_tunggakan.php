<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_tunggakan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
    }

    public function print_laporan()
    {
        $json = file_get_contents('php://input');
        $ambil = json_decode($json, true);
        $ambil = is_array($ambil) ? $ambil : array();

        $periode = isset($ambil['periode']) ? (int) $ambil['periode'] : 0;
        $kelas = isset($ambil['kelas']) ? (int) $ambil['kelas'] : 0;
        $jenis = isset($ambil['jenis']) ? (int) $ambil['jenis'] : 0;
        $sampai_bulan = isset($ambil['sampai_bulan']) ? (int) $ambil['sampai_bulan'] : 0;
        $status_siswa = isset($ambil['status_siswa']) && $ambil['status_siswa'] !== '' ? $ambil['status_siswa'] : 'Aktif';

        $sql = "SELECT ts.id_siswa,ts.nis,ts.nama_siswa,
                       COALESCE(cur.nama_kelas,ts.nama_kelas,'-') AS nama_kelas,
                       ts.periode AS tahun_asal,COUNT(ts.id) AS jumlah_tagihan,
                       COALESCE(SUM(ts.sisa_tagihan),0) AS total_tunggakan,
                       MAX(COALESCE(NULLIF(s.telepon_ayah,''),s.telepon_ibu,'')) AS no_wali
                FROM tagihan_siswa ts
                JOIN siswa s ON s.id=ts.id_siswa
                LEFT JOIN kelas_siswa ks_cur ON ks_cur.id=(
                    SELECT MAX(ks2.id) FROM kelas_siswa ks2
                    WHERE CAST(ks2.id_siswa AS UNSIGNED)=ts.id_siswa AND ks2.status_aktif='1'
                )
                LEFT JOIN kelas_setting cur ON cur.id=CAST(ks_cur.id_kelas_setting AS UNSIGNED)
                WHERE ts.dianggap_tunggakan='Ya'
                  AND ts.status_tagihan='Aktif'
                  AND ts.sisa_tagihan>0
                  AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')";
        $params = array();

        // Sampai Bulan mengikuti urutan Tahun Ajaran Juli-Juni.
        if ($sampai_bulan) {
            $urutan_sampai = $sampai_bulan >= 7 ? $sampai_bulan - 6 : $sampai_bulan + 6;
            $sql .= ' AND (CASE WHEN ts.bulan>=7 THEN ts.bulan-6 ELSE ts.bulan+6 END)<=?';
            $params[] = $urutan_sampai;
        }

        if ($periode) {
            $sql .= ' AND ts.id_periode=?';
            $params[] = $periode;
        }
        if ($kelas) {
            $sql .= ' AND COALESCE(cur.id,ts.id_kelas_setting)=?';
            $params[] = $kelas;
        }
        if ($jenis) {
            $sql .= ' AND ts.id_jenis_tagihan=?';
            $params[] = $jenis;
        }
        if ($status_siswa !== 'Semua') {
            $sql .= ' AND s.status_pendaftaran=?';
            $params[] = $status_siswa;
        }
        $sql .= ' GROUP BY ts.id_siswa,ts.nis,ts.nama_siswa,cur.nama_kelas,ts.nama_kelas,ts.periode ORDER BY total_tunggakan DESC,ts.nama_siswa ASC';

        $rows = $this->db->query($sql, $params)->result_array();
        $total = 0;
        foreach ($rows as $row) $total += (float) $row['total_tunggakan'];

        $laporan = array(
            'columns' => array('nama_siswa' => 'Siswa', 'nis' => 'NIS', 'nama_kelas' => 'Kelas Saat Ini', 'tahun_asal' => 'Tahun Asal', 'jumlah_tagihan' => 'Jumlah Tagihan', 'total_tunggakan' => 'Total Tunggakan', 'no_wali' => 'No Wali'),
            'money' => array('total_tunggakan'),
            'rows' => $rows,
            'summary' => array('Jumlah Siswa' => count($rows), 'Total Tunggakan' => $total)
        );
        $filters = array(
            'Tahun Ajaran' => $this->nama_tahun_ajaran($periode),
            'Kelas' => $this->nama_kelas($kelas),
            'Jenis Tagihan' => $this->nama_jenis($jenis),
            'Sampai Bulan' => $sampai_bulan ? $this->nama_bulan($sampai_bulan) : 'Semua Bulan',
            'Status Siswa' => $status_siswa
        );
        $admin = $this->session->userdata('admin');
        $data = array(
            'title' => 'Laporan Tunggakan',
            'laporan' => $laporan,
            'filter_laporan' => $filters,
            'petugas' => isset($admin['nama']) && $admin['nama'] !== '' ? $admin['nama'] : (isset($admin['username']) ? $admin['username'] : 'Administrator'),
            'orientation' => 'landscape'
        );
        $this->load->view('admin/data_laporan/laporan_tunggakan', $data);
    }

    private function nama_bulan($bulan)
    {
        $l = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
        return isset($l[(int)$bulan]) ? $l[(int)$bulan] : '-';
    }
    private function nama_tahun_ajaran($id)
    {
        if (!$id) return 'Semua Tahun Ajaran';
        $r = $this->db->select('periode')->where('id', $id)->get('master_tahun_ajaran')->row_array();
        return $r ? $r['periode'] : '-';
    }
    private function nama_kelas($id)
    {
        if (!$id) return 'Semua Kelas';
        $r = $this->db->select('nama_kelas')->where('id', $id)->get('kelas_setting')->row_array();
        return $r ? $r['nama_kelas'] : '-';
    }
    private function nama_jenis($id)
    {
        if (!$id) return 'Semua Jenis';
        $r = $this->db->select('nama_jenis')->where('id', $id)->get('tagihan_jenis')->row_array();
        return $r ? $r['nama_jenis'] : '-';
    }
}
