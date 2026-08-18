<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_rekap_per_jenis extends CI_Controller
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
        $periode_jenis = isset($ambil['periode_jenis']) ? (int) $ambil['periode_jenis'] : 0;

        $sql = "SELECT ts.id_jenis_tagihan,ts.nama_jenis_tagihan AS jenis,ts.tipe_tagihan AS tipe,
                       ts.dianggap_tunggakan AS wajib,COUNT(DISTINCT ts.id_siswa) AS jumlah_siswa,
                       COALESCE(SUM(ts.nominal_tagihan),0) AS total_tagihan,
                       COALESCE(SUM(ts.nominal_dibayar),0) AS dibayar,
                       COALESCE(SUM(ts.sisa_tagihan),0) AS sisa
                FROM tagihan_siswa ts
                WHERE ts.status_tagihan='Aktif'";
        $params = array();
        if ($periode) { $sql .= ' AND ts.id_periode=?'; $params[] = $periode; }
        if ($kelas) { $sql .= ' AND ts.id_kelas_setting=?'; $params[] = $kelas; }
        if ($periode_jenis) { $sql .= ' AND ts.bulan=?'; $params[] = $periode_jenis; }
        $sql .= ' GROUP BY ts.id_jenis_tagihan,ts.nama_jenis_tagihan,ts.tipe_tagihan,ts.dianggap_tunggakan ORDER BY ts.nama_jenis_tagihan ASC';

        $rows = $this->db->query($sql, $params)->result_array();
        $total_tagihan = 0; $total_bayar = 0; $total_sisa = 0;
        foreach ($rows as &$row) {
            $row['total_tagihan'] = (float) $row['total_tagihan'];
            $row['dibayar'] = (float) $row['dibayar'];
            $row['sisa'] = (float) $row['sisa'];
            $row['realisasi'] = $row['total_tagihan'] > 0 ? round(($row['dibayar'] / $row['total_tagihan']) * 100, 2) : 0;
            $total_tagihan += $row['total_tagihan'];
            $total_bayar += $row['dibayar'];
            $total_sisa += $row['sisa'];
        }
        unset($row);

        $laporan = array(
            'columns'=>array('jenis'=>'Jenis','tipe'=>'Tipe','wajib'=>'Dihitung Tunggakan','jumlah_siswa'=>'Jumlah Siswa','total_tagihan'=>'Total Tagihan','dibayar'=>'Dibayar','sisa'=>'Sisa','realisasi'=>'Realisasi (%)'),
            'money'=>array('total_tagihan','dibayar','sisa'),'rows'=>$rows,
            'summary'=>array('Total Tagihan'=>$total_tagihan,'Total Dibayar'=>$total_bayar,'Total Sisa'=>$total_sisa)
        );
        $filters = array('Tahun Ajaran'=>$this->nama_tahun_ajaran($periode),'Kelas'=>$this->nama_kelas($kelas),'Periode'=>$periode_jenis ? $this->nama_bulan($periode_jenis) : 'Semua Periode');
        $admin = $this->session->userdata('admin');
        $data = array('title'=>'Rekap Pembayaran Per Jenis','laporan'=>$laporan,'filter_laporan'=>$filters,
            'petugas'=>isset($admin['nama']) && $admin['nama'] !== '' ? $admin['nama'] : (isset($admin['username']) ? $admin['username'] : 'Administrator'),
            'orientation'=>'landscape');
        $this->load->view('admin/data_laporan/laporan_rekap_per_jenis', $data);
    }

    private function nama_bulan($bulan){ $l=array(1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'); return isset($l[(int)$bulan])?$l[(int)$bulan]:'-'; }
    private function nama_tahun_ajaran($id){ if(!$id)return 'Semua Tahun Ajaran'; $r=$this->db->select('periode')->where('id',$id)->get('master_tahun_ajaran')->row_array(); return $r?$r['periode']:'-'; }
    private function nama_kelas($id){ if(!$id)return 'Semua Kelas'; $r=$this->db->select('nama_kelas')->where('id',$id)->get('kelas_setting')->row_array(); return $r?$r['nama_kelas']:'-'; }
}
