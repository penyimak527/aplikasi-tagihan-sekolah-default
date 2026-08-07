<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Laporan extends MY_Controller
{
    private $titles=array('harian'=>'Laporan Pembayaran Harian','bulanan'=>'Laporan Pembayaran Bulanan','tahunan'=>'Laporan Pembayaran Tahunan','per_kelas'=>'Rekap Pembayaran Per Kelas','per_jenis'=>'Rekap Per Jenis Tagihan','tunggakan'=>'Laporan Tunggakan','pembatalan'=>'Riwayat Pembatalan Transaksi');
    public function __construct(){parent::__construct();$this->load->model('laporan/M_laporan','model');}
    private function page($type){if(!isset($this->titles[$type]))show_404();$data = array('title'=>$this->titles[$type],'jenis_laporan'=>$type,'periode'=>$this->model->periode_list(),'kelas'=>$this->model->kelas_list(),'jenis'=>$this->model->jenis_list(),'metode'=>$this->model->metode_list());
$this->load->view('template/header', $data);
$this->load->view('laporan/index', $data);
$this->load->view('template/footer');}
    public function index(){redirect('laporan/harian');}
    public function harian(){$this->page('harian');} public function bulanan(){$this->page('bulanan');} public function tahunan(){$this->page('tahunan');} public function per_kelas(){$this->page('per_kelas');} public function per_jenis(){$this->page('per_jenis');} public function tunggakan(){$this->page('tunggakan');} public function pembatalan(){$this->page('pembatalan');}
    public function result($type=''){$this->json($this->model->report($type));}
    public function export($type=''){$this->model->export_csv($type);}
}
