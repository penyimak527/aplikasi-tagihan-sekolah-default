<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/kesiswaan/M_riwayat_kelas', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Riwayat Kelas Siswa',
            'id_siswa' => (int) $this->input->get('id_siswa'),
            'kelas' => $this->model->kelas_list()
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/kesiswaan/riwayat_kelas', $data);
        $this->load->view('admin/template/footer');
    }

    public function cari()
    {
        $this->json_response($this->model->cari());
    }

    public function result()
    {
        $this->json_response($this->model->result());
    }

    public function koreksi()
    {
        $this->json_response($this->model->koreksi());
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
