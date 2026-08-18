<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hak_akses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/pengaturan/M_hak_akses', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Hak Akses',
            'level' => $this->model->level_list()
        );

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/pengaturan/hak_akses', $data);
        $this->load->view('admin/template/footer');
    }

    public function hak_akses_result()
    {
        $this->json_response($this->model->hak_akses_result());
    }

    public function menu_result()
    {
        $this->json_response($this->model->menu_belum_dipilih());
    }

    public function tambah()
    {
        $result = $this->model->tambah();
        $this->json_response($result);
    }

    public function hapus()
    {
        $result = $this->model->hapus();
        $this->json_response($result);
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
