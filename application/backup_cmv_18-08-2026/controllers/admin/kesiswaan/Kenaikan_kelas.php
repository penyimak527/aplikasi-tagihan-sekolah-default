<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Kenaikan_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/kesiswaan/M_kenaikan_kelas', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Kenaikan Kelas', 'kelas' => $this->model->kelas_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/kesiswaan/kenaikan_kelas', $data);
        $this->load->view('admin/template/footer');
    }
    public function siswa()
    {
        $this->json_response($this->model->siswa());
    }
    public function preview()
    {
        $this->json_response($this->model->preview());
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
