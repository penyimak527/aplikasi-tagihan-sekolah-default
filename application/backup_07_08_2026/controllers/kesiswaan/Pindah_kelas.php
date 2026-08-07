<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pindah_kelas extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('kesiswaan/M_pindah_kelas','model');}
    public function index(){$data = array('title'=>'Pindah Kelas','kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('kesiswaan/pindah_kelas', $data);
$this->load->view('template/footer');}
    public function cari(){$this->json($this->model->cari());}
    public function proses(){$this->json($this->model->proses());}
}
