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
        $this->load->model('pengaturan/M_hak_akses', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Hak Akses',
            'level' => $this->model->level_list()
        );

        $this->load->view('template/header', $data);
        $this->load->view('pengaturan/hak_akses', $data);
        $this->load->view('template/footer');
    }

    public function hak_akses_result()
    {
        json_response($this->model->hak_akses_result());
    }

    public function menu_result()
    {
        json_response($this->model->menu_belum_dipilih());
    }

    public function tambah()
    {
        $result = $this->model->tambah();
        json_response($result);
    }

    public function hapus()
    {
        $result = $this->model->hapus();
        json_response($result);
    }

}
