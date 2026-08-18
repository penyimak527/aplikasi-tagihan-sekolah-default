<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_riwayat_pembatalan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
    }

    public function print_laporan()
    {
        $json = file_get_contents('php://input');
        $ambil = json_decode($json, true);
        $ambil = is_array($ambil) ? $ambil : array();

        $filter = isset($ambil['filter']) ? $ambil['filter'] : 'tanggal';
        $q = isset($ambil['q']) ? trim((string) $ambil['q']) : '';
        $petugas_filter = isset($ambil['petugas']) ? trim((string) $ambil['petugas']) : '';

        $sql = "SELECT c.no_transaksi AS no_asli,c.nama_siswa,c.total_pembayaran AS nominal,
                       c.nama_user_transaksi AS pembuat,c.nama_user_pembatalan AS pembatal,
                       CONCAT(c.tanggal_pembatalan,' ',c.waktu_pembatalan) AS waktu,
                       c.alasan_pembatalan AS alasan
                FROM tagihan_pembatalan_transaksi c
                WHERE 1=1";
        $params = array();

        if ($filter == 'bulan') {
            $bulan = isset($ambil['bulan']) ? (int) $ambil['bulan'] : (int) date('n');
            $tahun = isset($ambil['tahun']) ? (int) $ambil['tahun'] : (int) date('Y');
            $sql .= " AND MONTH(STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y'))=? AND YEAR(STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y'))=?";
            $params[] = $bulan;
            $params[] = $tahun;
            $periode_label = $this->nama_bulan($bulan) . ' ' . $tahun;
        } else if ($filter == 'tahun') {
            $tahun = isset($ambil['tahun']) ? (int) $ambil['tahun'] : (int) date('Y');
            $sql .= " AND YEAR(STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y'))=?";
            $params[] = $tahun;
            $periode_label = (string) $tahun;
        } else {
            $awal = isset($ambil['dari_tanggal']) && $ambil['dari_tanggal'] !== '' ? $ambil['dari_tanggal'] : date('Y-m-d');
            $akhir = isset($ambil['sampai_tanggal']) && $ambil['sampai_tanggal'] !== '' ? $ambil['sampai_tanggal'] : $awal;
            $sql .= " AND STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y') BETWEEN ? AND ?";
            $params[] = $awal;
            $params[] = $akhir;
            $a = date('d-m-Y', strtotime($awal));
            $b = date('d-m-Y', strtotime($akhir));
            $periode_label = $a === $b ? $a : $a . ' s/d ' . $b;
        }
        if ($q !== '') {
            $sql .= ' AND (c.no_transaksi LIKE ? OR c.nama_siswa LIKE ?)';
            $params[] = '%' . $q . '%';
            $params[] = '%' . $q . '%';
        }
        if ($petugas_filter !== '') {
            $sql .= ' AND c.nama_user_pembatalan LIKE ?';
            $params[] = '%' . $petugas_filter . '%';
        }
        $sql .= " ORDER BY STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y') DESC,c.waktu_pembatalan DESC";

        $rows = $this->db->query($sql, $params)->result_array();
        $total = 0;
        foreach ($rows as $row) $total += (float) $row['nominal'];

        $laporan = array(
            'columns' => array('no_asli' => 'No Asli', 'nama_siswa' => 'Siswa', 'nominal' => 'Nominal', 'pembuat' => 'Pembuat', 'pembatal' => 'Pembatal', 'waktu' => 'Waktu', 'alasan' => 'Alasan'),
            'money' => array('nominal'),
            'rows' => $rows,
            'summary' => array('Jumlah Pembatalan' => count($rows), 'Total Dibatalkan' => $total)
        );
        $filters = array('Periode' => $periode_label, 'Pencarian' => $q !== '' ? $q : '-', 'Petugas Pembatal' => $petugas_filter !== '' ? $petugas_filter : 'Semua Petugas');
        $admin = $this->session->userdata('admin');
        $data = array(
            'title' => 'Riwayat Pembatalan',
            'laporan' => $laporan,
            'filter_laporan' => $filters,
            'petugas' => isset($admin['nama']) && $admin['nama'] !== '' ? $admin['nama'] : (isset($admin['username']) ? $admin['username'] : 'Administrator'),
            'orientation' => 'landscape'
        );
        $this->load->view('admin/data_laporan/laporan_riwayat_pembatalan', $data);
    }

    private function nama_bulan($bulan)
    {
        $l = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
        return isset($l[(int)$bulan]) ? $l[(int)$bulan] : '-';
    }
}
