<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tahun_ajaran extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/master_data/M_tahun_ajaran','model');}
    public function index(){$data = array('title'=>'Tahun Ajaran');
$this->load->view('admin/template/header', $data);
$this->load->view('admin/master_data/tahun_ajaran', $data);
$this->load->view('admin/template/footer');}
    public function result(){json_response($this->model->result());}
    public function detail(){json_response($this->model->detail());}
    public function simpan(){json_response($this->model->simpan());}
    public function aktifkan(){json_response($this->model->aktifkan());}
    public function hapus(){json_response($this->model->hapus());}
}
