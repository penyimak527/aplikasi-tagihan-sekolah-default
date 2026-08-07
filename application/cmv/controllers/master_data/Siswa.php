<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('master_data/M_siswa','model');}
    public function index(){$data = array('title'=>'Data Siswa','periode'=>$this->model->periode_list(),'kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('master_data/siswa', $data);
$this->load->view('template/footer');}
    public function result(){json_response($this->model->result());}
    public function detail(){json_response($this->model->detail());}
    public function simpan(){json_response($this->model->simpan());}
    public function nonaktifkan(){json_response($this->model->nonaktifkan());}
    public function cari(){json_response($this->model->cari());}
}
