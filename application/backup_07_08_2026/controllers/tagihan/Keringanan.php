<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Keringanan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tagihan/M_keringanan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Potongan atau Pembebasan');
        $this->load->view('template/header', $data);
        $this->load->view('tagihan/keringanan', $data);
        $this->load->view('template/footer');
    }
    public function cari_siswa()
    {
        $this->json($this->model->cari_siswa());
    }
    public function tagihan_siswa()
    {
        $this->json($this->model->tagihan_siswa());
    }
    public function simpan()
    {
        $this->json($this->model->simpan());
    }
    public function riwayat()
    {
        $this->json($this->model->riwayat());
    }
    public function batalkan()
    {
        $this->json($this->model->batalkan());
    }
}
