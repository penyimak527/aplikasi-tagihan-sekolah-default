<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Status_siswa extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('kesiswaan/M_status_siswa','model');}
    public function index(){$data = array('title'=>'Siswa Berhenti atau Pindah Sekolah');
$this->load->view('template/header', $data);
$this->load->view('kesiswaan/status_siswa', $data);
$this->load->view('template/footer');}
    public function cari(){json_response($this->model->cari());}
    public function proses(){json_response($this->model->proses());}
}
