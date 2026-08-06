<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Status_siswa extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('kesiswaan/M_status_siswa','model');}
    public function index(){$data = array('title'=>'Siswa Berhenti atau Pindah Sekolah');
$this->load->view('template/header', $data);
$this->load->view('kesiswaan/status_siswa', $data);
$this->load->view('template/footer');}
    public function cari(){$this->json($this->model->cari());}
    public function proses(){$this->json($this->model->proses());}
}
