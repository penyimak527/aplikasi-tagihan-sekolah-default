<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Penempatan_siswa extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kesiswaan/M_penempatan_siswa', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Penempatan Siswa', 'periode' => $this->model->periode_list(), 'kelas' => $this->model->kelas_list());
        $this->load->view('template/header', $data);
        $this->load->view('kesiswaan/penempatan_siswa', $data);
        $this->load->view('template/footer');
    }
    public function result()
    {
        $this->json($this->model->result());
    }
    public function proses()
    {
        $this->json($this->model->proses());
    }
    public function keluarkan()
    {
        $this->json($this->model->keluarkan());
    }
}
