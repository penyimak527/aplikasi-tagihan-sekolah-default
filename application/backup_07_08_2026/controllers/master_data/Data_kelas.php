<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_kelas extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('master_data/M_data_kelas','model');}
    public function index(){$data = array('title'=>'Data Kelas');
$this->load->view('template/header', $data);
$this->load->view('master_data/data_kelas', $data);
$this->load->view('template/footer');}
    public function result(){$this->json($this->model->result());}
    public function detail(){$this->json($this->model->detail());}
    public function simpan(){$this->json($this->model->simpan());}
    public function hapus(){$this->json($this->model->hapus());}
}
