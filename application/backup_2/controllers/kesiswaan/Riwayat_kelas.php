<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_kelas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kesiswaan/M_riwayat_kelas', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Riwayat Kelas Siswa',
            'id_siswa' => (int) $this->input->get('id_siswa'),
            'kelas' => $this->model->kelas_list()
        );
        $this->load->view('template/header', $data);
        $this->load->view('kesiswaan/riwayat_kelas', $data);
        $this->load->view('template/footer');
    }

    public function cari()
    {
        $this->json($this->model->cari());
    }

    public function result()
    {
        $this->json($this->model->result());
    }

    public function koreksi()
    {
        $this->json($this->model->koreksi());
    }
}
