<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('master_data/M_siswa','model');}
    public function index(){$data = array('title'=>'Data Siswa','periode'=>$this->model->periode_list(),'kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('master_data/siswa', $data);
$this->load->view('template/footer');}
    public function result(){$this->json($this->model->result());}
    public function detail(){$this->json($this->model->detail());}
    public function simpan(){$this->json($this->model->simpan());}
    public function nonaktifkan(){$this->json($this->model->nonaktifkan());}
    public function cari(){$this->json($this->model->cari());}
}
