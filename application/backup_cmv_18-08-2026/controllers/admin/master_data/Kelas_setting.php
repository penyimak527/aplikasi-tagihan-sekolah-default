<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelas_setting extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/master_data/M_kelas_setting', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Kelas Setting',
            'periode' => $this->model->periode_list(),
            'kelas' => $this->model->kelas_list()
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/master_data/kelas_setting', $data);
        $this->load->view('admin/template/footer');
    }

    public function result(){ $this->json_response($this->model->result()); }
    public function simpan(){ $this->json_response($this->model->simpan()); }
    public function hapus(){ $this->json_response($this->model->hapus()); }

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
