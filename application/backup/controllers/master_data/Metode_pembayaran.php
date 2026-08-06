<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Metode_pembayaran extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('master_data/M_metode_pembayaran','model');}
    public function index(){$data = array('title'=>'Metode Pembayaran');
$this->load->view('template/header', $data);
$this->load->view('master_data/metode_pembayaran', $data);
$this->load->view('template/footer');}
    public function result(){$this->json($this->model->result());}
    public function simpan(){$this->json($this->model->simpan());}
    public function status(){$this->json($this->model->ubah_status());}
}
