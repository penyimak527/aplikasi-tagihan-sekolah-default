<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Status_siswa extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/kesiswaan/M_status_siswa','model');}
    public function index(){$data = array('title'=>'Siswa Berhenti atau Pindah Sekolah');
$this->load->view('admin/template/header', $data);
$this->load->view('admin/kesiswaan/status_siswa', $data);
$this->load->view('admin/template/footer');}
    public function cari(){$this->json_response($this->model->cari());}
    public function proses(){$this->json_response($this->model->proses());}

    private function json_response($data, $status = 200)
    {
        $this->output
            ->set_status_header((int) $status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
