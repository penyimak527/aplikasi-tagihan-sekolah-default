<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Level extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/pengaturan/M_level', 'model');
    }

    public function index()
    {
        $data['title'] = 'Level';
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/pengaturan/level', $data);
        $this->load->view('admin/template/footer');
    }

    public function level_result()
    {
        json_response($this->model->level_result());
    }

    public function simpan()
    {
        json_response($this->model->simpan());
    }

    public function hapus()
    {
        json_response($this->model->hapus());
    }
}
