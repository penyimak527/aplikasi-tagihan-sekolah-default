<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelulusan extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('kesiswaan/M_kelulusan','model');}
    public function index(){$data = array('title'=>'Kelulusan','kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('kesiswaan/kelulusan', $data);
$this->load->view('template/footer');}
    public function siswa(){json_response($this->model->siswa());}
    public function preview(){json_response($this->model->preview());}
    public function proses(){json_response($this->model->proses());}
}
