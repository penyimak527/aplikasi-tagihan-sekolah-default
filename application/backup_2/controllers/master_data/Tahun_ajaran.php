<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tahun_ajaran extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('master_data/M_tahun_ajaran','model');}
    public function index(){$data = array('title'=>'Tahun Ajaran');
$this->load->view('template/header', $data);
$this->load->view('master_data/tahun_ajaran', $data);
$this->load->view('template/footer');}
    public function result(){$this->json($this->model->result());}
    public function detail(){$this->json($this->model->detail());}
    public function simpan(){$this->json($this->model->simpan());}
    public function aktifkan(){$this->json($this->model->aktifkan());}
    public function hapus(){$this->json($this->model->hapus());}
}
