<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Penempatan_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        json_response($this->model->result());
    }
    public function proses()
    {
        json_response($this->model->proses());
    }
    public function keluarkan()
    {
        json_response($this->model->keluarkan());
    }
}
