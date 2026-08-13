<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Laporan extends CI_Controller
{
    private $titles = array('harian' => 'Laporan Pembayaran Harian', 'bulanan' => 'Laporan Pembayaran Bulanan', 'tahunan' => 'Laporan Pembayaran Tahunan', 'per_kelas' => 'Rekap Pembayaran Per Kelas', 'per_jenis' => 'Rekap Per Jenis Tagihan', 'tunggakan' => 'Laporan Tunggakan', 'pembatalan' => 'Riwayat Pembatalan Transaksi');
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/laporan/M_laporan', 'model');
    }
    private function page($type)
    {
        if (!isset($this->titles[$type])) show_404();
        $data = array('title' => $this->titles[$type], 'jenis_laporan' => $type, 'periode' => $this->model->periode_list(), 'kelas' => $this->model->kelas_list(), 'jenis' => $this->model->jenis_list(), 'metode' => $this->model->metode_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/laporan/index', $data);
        $this->load->view('admin/template/footer');
    }
    public function index()
    {
        redirect('admin/laporan/laporan/harian');
    }
    public function harian()
    {
        $this->page('harian');
    }
    public function bulanan()
    {
        $this->page('bulanan');
    }
    public function tahunan()
    {
        $this->page('tahunan');
    }
    public function per_kelas()
    {
        $this->page('per_kelas');
    }
    public function per_jenis()
    {
        $this->page('per_jenis');
    }
    public function tunggakan()
    {
        $this->page('tunggakan');
    }
    public function pembatalan()
    {
        $this->page('pembatalan');
    }
    public function result($type = '')
    {
        json_response($this->model->report($type));
    }
    public function export($type = '')
    {
        $this->model->export_csv($type);
    }
}
