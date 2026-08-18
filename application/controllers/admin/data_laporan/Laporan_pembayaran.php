<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_pembayaran extends CI_Controller
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

        $filter = isset($ambil['filter']) ? $ambil['filter'] : 'tanggal';
        $periode = isset($ambil['periode']) ? (int) $ambil['periode'] : 0;
        $kelas = isset($ambil['kelas']) ? (int) $ambil['kelas'] : 0;
        $jenis = isset($ambil['jenis']) ? (int) $ambil['jenis'] : 0;
        $metode = isset($ambil['metode']) ? (int) $ambil['metode'] : 0;
        $petugas_filter = isset($ambil['petugas']) ? trim((string) $ambil['petugas']) : '';
        $status = isset($ambil['status']) && $ambil['status'] !== '' ? $ambil['status'] : 'Aktif';

        if ($filter == 'bulan') {
            $bulan = isset($ambil['bulan']) ? (int) $ambil['bulan'] : (int) date('n');
            $tahun = isset($ambil['tahun']) ? (int) $ambil['tahun'] : (int) date('Y');

            $where_target = array("ts.status_tagihan='Aktif'", 'ts.bulan=?', 'ts.tahun=?');
            $param_target = array($bulan, $tahun);
            if ($periode) {
                $where_target[] = 'ts.id_periode=?';
                $param_target[] = $periode;
            }
            if ($kelas) {
                $where_target[] = 'ts.id_kelas_setting=?';
                $param_target[] = $kelas;
            }
            if ($jenis) {
                $where_target[] = 'ts.id_jenis_tagihan=?';
                $param_target[] = $jenis;
            }
            $target = (float) $this->db->query(
                "SELECT COALESCE(SUM(ts.nominal_tagihan),0) total FROM tagihan_siswa ts WHERE " . implode(' AND ', $where_target),
                $param_target
            )->row()->total;

            $sql = "SELECT p.tanggal_transaksi AS tanggal,ts.nama_jenis_tagihan AS jenis_tagihan,
                           COUNT(DISTINCT p.id) AS jumlah_transaksi,COALESCE(SUM(d.nominal_bayar),0) AS total_pembayaran
                    FROM tagihan_pembayaran p
                    JOIN tagihan_pembayaran_detail d ON d.id_pembayaran=p.id AND d.status_detail='Aktif'
                    JOIN tagihan_siswa ts ON ts.id=d.id_tagihan_siswa
                    WHERE MONTH(STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'))=?
                      AND YEAR(STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'))=?";
            $params = array($bulan, $tahun);
            if ($periode) {
                $sql .= ' AND ts.id_periode=?';
                $params[] = $periode;
            }
            if ($kelas) {
                $sql .= ' AND ts.id_kelas_setting=?';
                $params[] = $kelas;
            }
            if ($jenis) {
                $sql .= ' AND ts.id_jenis_tagihan=?';
                $params[] = $jenis;
            }
            if ($metode) {
                $sql .= ' AND p.id_metode_pembayaran=?';
                $params[] = $metode;
            }
            if ($petugas_filter !== '') {
                $sql .= ' AND p.nama_user LIKE ?';
                $params[] = '%' . $petugas_filter . '%';
            }
            if ($status !== 'Semua') {
                $sql .= ' AND p.status_transaksi=?';
                $params[] = $status;
            }
            $sql .= " GROUP BY p.tanggal_transaksi,ts.nama_jenis_tagihan ORDER BY STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'),ts.nama_jenis_tagihan";
            $rows = $this->db->query($sql, $params)->result_array();

            $total_bayar = 0;
            foreach ($rows as $row) $total_bayar += (float) $row['total_pembayaran'];
            $laporan = array(
                'columns' => array('tanggal' => 'Tanggal', 'jenis_tagihan' => 'Jenis Tagihan', 'jumlah_transaksi' => 'Jumlah Transaksi', 'total_pembayaran' => 'Total Pembayaran'),
                'money' => array('total_pembayaran'),
                'rows' => $rows,
                'summary' => array('Target Tagihan' => $target, 'Pembayaran Masuk' => $total_bayar, 'Sisa' => max(0, $target - $total_bayar), 'Realisasi (%)' => $target > 0 ? round(($total_bayar / $target) * 100, 2) : 0)
            );
            $filters = array(
                'Periode' => $this->nama_bulan($bulan) . ' ' . $tahun,
                'Tahun Ajaran' => $this->nama_tahun_ajaran($periode),
                'Kelas' => $this->nama_kelas($kelas),
                'Jenis Tagihan' => $this->nama_jenis($jenis),
                'Metode' => $this->nama_metode($metode),
                'Petugas' => $petugas_filter !== '' ? $petugas_filter : 'Semua Petugas',
                'Status' => $status
            );
        } else if ($filter == 'tahun') {
            $tahun = isset($ambil['tahun']) ? (int) $ambil['tahun'] : (int) date('Y');
            $rows = array();
            $total_target = 0;
            $total_bayar = 0;
            $total_sisa = 0;
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $where_target = array("ts.status_tagihan='Aktif'", 'ts.bulan=?', 'ts.tahun=?');
                $param_target = array($bulan, $tahun);
                if ($periode) {
                    $where_target[] = 'ts.id_periode=?';
                    $param_target[] = $periode;
                }
                if ($kelas) {
                    $where_target[] = 'ts.id_kelas_setting=?';
                    $param_target[] = $kelas;
                }
                if ($jenis) {
                    $where_target[] = 'ts.id_jenis_tagihan=?';
                    $param_target[] = $jenis;
                }
                $target = (float) $this->db->query(
                    "SELECT COALESCE(SUM(ts.nominal_tagihan),0) total FROM tagihan_siswa ts WHERE " . implode(' AND ', $where_target),
                    $param_target
                )->row()->total;

                $sql_bayar = "SELECT COALESCE(SUM(d.nominal_bayar),0) total
                              FROM tagihan_pembayaran p
                              JOIN tagihan_pembayaran_detail d ON d.id_pembayaran=p.id AND d.status_detail='Aktif'
                              JOIN tagihan_siswa ts ON ts.id=d.id_tagihan_siswa
                              WHERE ts.bulan=? AND ts.tahun=?";
                $param_bayar = array($bulan, $tahun);
                if ($periode) {
                    $sql_bayar .= ' AND ts.id_periode=?';
                    $param_bayar[] = $periode;
                }
                if ($kelas) {
                    $sql_bayar .= ' AND ts.id_kelas_setting=?';
                    $param_bayar[] = $kelas;
                }
                if ($jenis) {
                    $sql_bayar .= ' AND ts.id_jenis_tagihan=?';
                    $param_bayar[] = $jenis;
                }
                if ($metode) {
                    $sql_bayar .= ' AND p.id_metode_pembayaran=?';
                    $param_bayar[] = $metode;
                }
                if ($petugas_filter !== '') {
                    $sql_bayar .= ' AND p.nama_user LIKE ?';
                    $param_bayar[] = '%' . $petugas_filter . '%';
                }
                if ($status !== 'Semua') {
                    $sql_bayar .= ' AND p.status_transaksi=?';
                    $param_bayar[] = $status;
                }
                $bayar = (float) $this->db->query($sql_bayar, $param_bayar)->row()->total;
                $sisa = max(0, $target - $bayar);
                $rows[] = array('bulan' => $this->nama_bulan($bulan), 'target' => $target, 'pembayaran' => $bayar, 'sisa' => $sisa, 'realisasi' => $target > 0 ? round(($bayar / $target) * 100, 2) : 0);
                $total_target += $target;
                $total_bayar += $bayar;
                $total_sisa += $sisa;
            }
            $laporan = array(
                'columns' => array('bulan' => 'Bulan', 'target' => 'Target', 'pembayaran' => 'Pembayaran', 'sisa' => 'Sisa', 'realisasi' => 'Realisasi (%)'),
                'money' => array('target', 'pembayaran', 'sisa'),
                'rows' => $rows,
                'summary' => array('Total Target' => $total_target, 'Total Pembayaran' => $total_bayar, 'Total Sisa' => $total_sisa, 'Realisasi (%)' => $total_target > 0 ? round(($total_bayar / $total_target) * 100, 2) : 0)
            );
            $filters = array(
                'Periode' => (string)$tahun,
                'Tahun Ajaran' => $this->nama_tahun_ajaran($periode),
                'Kelas' => $this->nama_kelas($kelas),
                'Jenis Tagihan' => $this->nama_jenis($jenis),
                'Metode' => $this->nama_metode($metode),
                'Petugas' => $petugas_filter !== '' ? $petugas_filter : 'Semua Petugas',
                'Status' => $status
            );
        } else {
            $awal = isset($ambil['dari_tanggal']) && $ambil['dari_tanggal'] !== '' ? $ambil['dari_tanggal'] : date('Y-m-d');
            $akhir = isset($ambil['sampai_tanggal']) && $ambil['sampai_tanggal'] !== '' ? $ambil['sampai_tanggal'] : $awal;
            $sql = "SELECT p.tanggal_transaksi,p.waktu_transaksi,p.no_transaksi,p.nama_siswa,p.nama_kelas,
                           p.nama_metode_pembayaran,p.nama_user,p.total_pembayaran,p.status_transaksi
                    FROM tagihan_pembayaran p
                    WHERE STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y') BETWEEN ? AND ?";
            $params = array($awal, $akhir);
            if ($periode) {
                $sql .= ' AND p.id_periode=?';
                $params[] = $periode;
            }
            if ($kelas) {
                $sql .= ' AND p.id_kelas_setting=?';
                $params[] = $kelas;
            }
            if ($metode) {
                $sql .= ' AND p.id_metode_pembayaran=?';
                $params[] = $metode;
            }
            if ($petugas_filter !== '') {
                $sql .= ' AND p.nama_user LIKE ?';
                $params[] = '%' . $petugas_filter . '%';
            }
            if ($status !== 'Semua') {
                $sql .= ' AND p.status_transaksi=?';
                $params[] = $status;
            }
            if ($jenis) {
                $sql .= " AND EXISTS (SELECT 1 FROM tagihan_pembayaran_detail d JOIN tagihan_siswa ts ON ts.id=d.id_tagihan_siswa WHERE d.id_pembayaran=p.id AND d.status_detail='Aktif' AND ts.id_jenis_tagihan=?)";
                $params[] = $jenis;
            }
            $sql .= " ORDER BY STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'),p.waktu_transaksi";
            $rows = $this->db->query($sql, $params)->result_array();
            $total = 0;
            foreach ($rows as $row) if ($row['status_transaksi'] === 'Aktif') $total += (float) $row['total_pembayaran'];
            $laporan = array(
                'columns' => array('tanggal_transaksi' => 'Tanggal', 'waktu_transaksi' => 'Waktu', 'no_transaksi' => 'No Transaksi', 'nama_siswa' => 'Siswa', 'nama_kelas' => 'Kelas', 'nama_metode_pembayaran' => 'Metode', 'nama_user' => 'Petugas', 'total_pembayaran' => 'Total', 'status_transaksi' => 'Status'),
                'money' => array('total_pembayaran'),
                'rows' => $rows,
                'summary' => array('Jumlah Transaksi' => count($rows), 'Total Pembayaran' => $total)
            );
            $awal_tampil = date('d-m-Y', strtotime($awal));
            $akhir_tampil = date('d-m-Y', strtotime($akhir));
            $filters = array('Periode' => $awal_tampil === $akhir_tampil ? $awal_tampil : $awal_tampil . ' s/d ' . $akhir_tampil, 'Status' => $status);
        }

        $admin = $this->session->userdata('admin');
        $data = array(
            'title' => 'Laporan Pembayaran',
            'laporan' => $laporan,
            'filter_laporan' => $filters,
            'petugas' => isset($admin['nama']) && $admin['nama'] !== '' ? $admin['nama'] : (isset($admin['username']) ? $admin['username'] : 'Administrator'),
            'orientation' => 'landscape'
        );
        $this->load->view('admin/data_laporan/laporan_pembayaran', $data);
    }

    private function nama_bulan($bulan)
    {
        $list = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
        return isset($list[(int)$bulan]) ? $list[(int)$bulan] : '-';
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
    private function nama_metode($id)
    {
        if (!$id) return 'Semua Metode';
        $r = $this->db->select('nama_metode')->where('id', $id)->get('tagihan_metode_pembayaran')->row_array();
        return $r ? $r['nama_metode'] : '-';
    }
}
