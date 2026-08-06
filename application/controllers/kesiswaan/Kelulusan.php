<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelulusan extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('kesiswaan/M_kelulusan','model');}
    public function index(){$data = array('title'=>'Kelulusan','kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('kesiswaan/kelulusan', $data);
$this->load->view('template/footer');}
    public function siswa(){$this->json($this->model->siswa());}
    public function preview(){$this->json($this->model->preview());}
    public function proses(){$this->json($this->model->proses());}
}
