<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Riwayat_pembayaran extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('transaksi/M_riwayat_pembayaran','model');}
    public function index(){$data = array('title'=>'Riwayat Pembayaran','metode'=>$this->model->metode_list());
$this->load->view('template/header', $data);
$this->load->view('transaksi/riwayat_pembayaran', $data);
$this->load->view('template/footer');}
    public function result(){$this->json($this->model->result());}
    public function detail(){$this->json($this->model->detail((int)$this->input->post('id')));}
    public function batalkan(){$this->json($this->model->batalkan());}
    public function catat_cetak($id=0){$this->json($this->model->catat_cetak((int)$id));}
    public function export(){ $this->model->export_csv(); }
}
