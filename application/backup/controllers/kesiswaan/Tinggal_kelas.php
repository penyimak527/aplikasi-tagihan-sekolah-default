<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tinggal_kelas extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('kesiswaan/M_kenaikan_kelas','model');}
    public function index(){$data = array('title'=>'Tinggal Kelas','kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('kesiswaan/tinggal_kelas', $data);
$this->load->view('template/footer');}
    public function siswa(){$this->json($this->model->siswa());}
    public function preview(){$this->json($this->model->preview('Tinggal Kelas'));}
    public function proses(){$this->json($this->model->proses('Tinggal Kelas'));}
}
