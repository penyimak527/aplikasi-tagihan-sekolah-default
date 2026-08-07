<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan_langsung extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('tagihan/M_buat_tagihan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Buat Tagihan Langsung', 'tipe' => 'Langsung', 'periode' => $this->model->periode_list(), 'jenis' => $this->model->jenis_list('Langsung'), 'kelas' => $this->model->kelas_list());
        $this->load->view('template/header', $data);
        $this->load->view('tagihan/tagihan_langsung', $data);
        $this->load->view('template/footer');
    }
    public function preview()
    {
        json_response($this->model->preview('Langsung'));
    }
    public function simpan()
    {
        json_response($this->model->simpan('Langsung'));
    }
    public function cari_siswa()
    {
        json_response($this->model->cari_siswa());
    }
}
