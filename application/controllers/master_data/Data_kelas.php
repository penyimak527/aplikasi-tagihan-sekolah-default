<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Data_kelas extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('master_data/M_data_kelas','model');}
    public function index(){$data = array('title'=>'Data Kelas');
$this->load->view('template/header', $data);
$this->load->view('master_data/data_kelas', $data);
$this->load->view('template/footer');}
    public function result(){json_response($this->model->result());}
    public function detail(){json_response($this->model->detail());}
    public function simpan(){json_response($this->model->simpan());}
    public function hapus(){json_response($this->model->hapus());}
}
