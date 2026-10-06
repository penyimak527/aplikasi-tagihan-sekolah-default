<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }

        $this->load->model('admin/kepegawaian/M_jabatan', 'model');
    }

    public function index()
    {
        $data['title'] = 'Jabatan';

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/kepegawaian/jabatan', $data);
        $this->load->view('admin/template/footer');
    }

    public function jabatan_result()
    {
        $data = $this->model->jabatan_result();
        $this->json_response($data);
    }

    public function tambah()
    {
        $data = $this->model->tambah();
        $this->json_response($data);
    }

    public function edit()
    {
        $data = $this->model->edit();
        $this->json_response($data);
    }

    public function hapus()
    {
        $data = $this->model->hapus();
        $this->json_response($data);
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
