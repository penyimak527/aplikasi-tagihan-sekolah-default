<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pindah_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/kesiswaan/M_pindah_kelas', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Pindah Kelas', 'kelas' => $this->model->kelas_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/kesiswaan/pindah_kelas', $data);
        $this->load->view('admin/template/footer');
    }
    public function cari()
    {
        $this->json_response($this->model->cari());
    }
    public function proses()
    {
        $this->json_response($this->model->proses());
    }

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
