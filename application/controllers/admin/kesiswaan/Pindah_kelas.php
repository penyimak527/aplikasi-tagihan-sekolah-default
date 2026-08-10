<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pindah_kelas extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/kesiswaan/M_pindah_kelas','model');}
    public function index(){$data = array('title'=>'Pindah Kelas','kelas'=>$this->model->kelas_list());
$this->load->view('admin/template/header', $data);
$this->load->view('admin/kesiswaan/pindah_kelas', $data);
$this->load->view('admin/template/footer');}
    public function cari(){json_response($this->model->cari());}
    public function proses(){json_response($this->model->proses());}
}
