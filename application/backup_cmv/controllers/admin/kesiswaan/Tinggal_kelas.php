<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tinggal_kelas extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/kesiswaan/M_kenaikan_kelas','model');}
    public function index(){$data = array('title'=>'Tinggal Kelas','kelas'=>$this->model->kelas_list());
$this->load->view('admin/template/header', $data);
$this->load->view('admin/kesiswaan/tinggal_kelas', $data);
$this->load->view('admin/template/footer');}
    public function siswa(){json_response($this->model->siswa());}
    public function preview(){json_response($this->model->preview('Tinggal Kelas'));}
    public function proses(){json_response($this->model->proses('Tinggal Kelas'));}
}
