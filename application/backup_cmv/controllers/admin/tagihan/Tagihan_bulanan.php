<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan_bulanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tagihan/M_buat_tagihan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Buat Tagihan Bulanan', 'tipe' => 'Bulanan', 'periode' => $this->model->periode_list(), 'jenis' => $this->model->jenis_list('Bulanan'), 'kelas' => $this->model->kelas_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tagihan/tagihan_bulanan', $data);
        $this->load->view('admin/template/footer');
    }
    public function preview()
    {
        json_response($this->model->preview('Bulanan'));
    }
    public function simpan()
    {
        json_response($this->model->simpan('Bulanan'));
    }
    public function cari_siswa()
    {
        json_response($this->model->cari_siswa());
    }
}
