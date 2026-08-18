<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Penempatan_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/kesiswaan/M_penempatan_siswa', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Penempatan Siswa', 'periode' => $this->model->periode_list(), 'kelas' => $this->model->kelas_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/kesiswaan/penempatan_siswa', $data);
        $this->load->view('admin/template/footer');
    }
    public function result()
    {
        $this->json_response($this->model->result());
    }
    public function proses()
    {
        $this->json_response($this->model->proses());
    }
    public function keluarkan()
    {
        $this->json_response($this->model->keluarkan());
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
