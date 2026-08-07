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
        $this->load->model('kesiswaan/M_kenaikan_kelas', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Kenaikan Kelas', 'kelas' => $this->model->kelas_list());
        $this->load->view('template/header', $data);
        $this->load->view('kesiswaan/kenaikan_kelas', $data);
        $this->load->view('template/footer');
    }
    public function siswa()
    {
        json_response($this->model->siswa());
    }
    public function preview()
    {
        json_response($this->model->preview('Naik Kelas'));
    }
    public function proses()
    {
        json_response($this->model->proses('Naik Kelas'));
    }
}
