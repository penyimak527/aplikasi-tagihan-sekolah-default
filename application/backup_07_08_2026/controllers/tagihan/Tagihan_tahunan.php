<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan_tahunan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tagihan/M_buat_tagihan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Buat Tagihan Tahunan', 'tipe' => 'Tahunan', 'periode' => $this->model->periode_list(), 'jenis' => $this->model->jenis_list('Tahunan'), 'kelas' => $this->model->kelas_list());
        $this->load->view('template/header', $data);
        $this->load->view('tagihan/tagihan_tahunan', $data);
        $this->load->view('template/footer');
    }
    public function preview()
    {
        $this->json($this->model->preview('Tahunan'));
    }
    public function simpan()
    {
        $this->json($this->model->simpan('Tahunan'));
    }
    public function cari_siswa()
    {
        $this->json($this->model->cari_siswa());
    }
}
