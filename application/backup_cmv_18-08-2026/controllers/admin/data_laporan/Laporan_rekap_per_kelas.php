<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_rekap_per_kelas extends CI_Controller
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
        $periode = isset($ambil['periode']) ? (int) $ambil['periode'] : 0;
        $jenis = isset($ambil['jenis']) ? (int) $ambil['jenis'] : 0;

        $sql = "SELECT ts.id_kelas_setting,ts.nama_kelas,
                       COUNT(DISTINCT ts.id_siswa) AS jumlah_siswa,
                       COALESCE(SUM(ts.nominal_tagihan),0) AS target,
                       COALESCE(SUM(ts.nominal_dibayar),0) AS pembayaran,
                       COALESCE(SUM(CASE WHEN ts.dianggap_tunggakan='Ya'
                                         AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
                                    THEN ts.sisa_tagihan ELSE 0 END),0) AS tunggakan
                FROM tagihan_siswa ts
                WHERE ts.status_tagihan='Aktif'";
        $params = array();

        if ($filter == 'bulan') {
            $bulan = isset($ambil['bulan']) ? (int) $ambil['bulan'] : (int) date('n');
            $tahun = isset($ambil['tahun']) ? (int) $ambil['tahun'] : (int) date('Y');
            $sql .= ' AND ts.bulan=? AND ts.tahun=?';
            $params[] = $bulan;
            $params[] = $tahun;
            $periode_label = $this->nama_bulan($bulan) . ' ' . $tahun;
        } else if ($filter == 'tahun') {
            $tahun = isset($ambil['tahun']) ? (int) $ambil['tahun'] : (int) date('Y');
            $sql .= ' AND ts.tahun=?';
            $params[] = $tahun;
            $periode_label = (string) $tahun;
        } else {
            $awal = isset($ambil['dari_tanggal']) && $ambil['dari_tanggal'] !== '' ? $ambil['dari_tanggal'] : date('Y-m-d');
            $akhir = isset($ambil['sampai_tanggal']) && $ambil['sampai_tanggal'] !== '' ? $ambil['sampai_tanggal'] : $awal;
            $sql .= " AND STR_TO_DATE(ts.tanggal_generate,'%d-%m-%Y') BETWEEN ? AND ?";
            $params[] = $awal;
            $params[] = $akhir;
            $a = date('d-m-Y', strtotime($awal));
            $b = date('d-m-Y', strtotime($akhir));
            $periode_label = $a === $b ? $a : $a . ' s/d ' . $b;
        }

        if ($periode) { $sql .= ' AND ts.id_periode=?'; $params[] = $periode; }
        if ($jenis) { $sql .= ' AND ts.id_jenis_tagihan=?'; $params[] = $jenis; }
        $sql .= ' GROUP BY ts.id_kelas_setting,ts.nama_kelas ORDER BY ts.nama_kelas ASC';

        $rows = $this->db->query($sql, $params)->result_array();
        $total_target = 0; $total_bayar = 0; $total_tunggakan = 0;
        foreach ($rows as &$row) {
            $row['target'] = (float) $row['target'];
            $row['pembayaran'] = (float) $row['pembayaran'];
            $row['tunggakan'] = (float) $row['tunggakan'];
            $row['realisasi'] = $row['target'] > 0 ? round(($row['pembayaran'] / $row['target']) * 100, 2) : 0;
            $total_target += $row['target'];
            $total_bayar += $row['pembayaran'];
            $total_tunggakan += $row['tunggakan'];
        }
        unset($row);

        $laporan = array(
            'columns'=>array('nama_kelas'=>'Kelas','jumlah_siswa'=>'Jumlah Siswa','target'=>'Target','pembayaran'=>'Pembayaran','tunggakan'=>'Tunggakan','realisasi'=>'Realisasi (%)'),
            'money'=>array('target','pembayaran','tunggakan'),'rows'=>$rows,
            'summary'=>array('Total Target'=>$total_target,'Total Pembayaran'=>$total_bayar,'Total Tunggakan'=>$total_tunggakan)
        );
        $filters = array('Periode'=>$periode_label,'Tahun Ajaran'=>$this->nama_tahun_ajaran($periode),'Jenis Tagihan'=>$this->nama_jenis($jenis));
        $admin = $this->session->userdata('admin');
        $data = array('title'=>'Rekap Pembayaran Per Kelas','laporan'=>$laporan,'filter_laporan'=>$filters,
            'petugas'=>isset($admin['nama']) && $admin['nama'] !== '' ? $admin['nama'] : (isset($admin['username']) ? $admin['username'] : 'Administrator'),
            'orientation'=>'landscape');
        $this->load->view('admin/data_laporan/laporan_rekap_per_kelas', $data);
    }

    private function nama_bulan($bulan){ $l=array(1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'); return isset($l[(int)$bulan])?$l[(int)$bulan]:'-'; }
    private function nama_tahun_ajaran($id){ if(!$id)return 'Semua Tahun Ajaran'; $r=$this->db->select('periode')->where('id',$id)->get('master_tahun_ajaran')->row_array(); return $r?$r['periode']:'-'; }
    private function nama_jenis($id){ if(!$id)return 'Semua Jenis'; $r=$this->db->select('nama_jenis')->where('id',$id)->get('tagihan_jenis')->row_array(); return $r?$r['nama_jenis']:'-'; }
}
