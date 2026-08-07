<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Keringanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
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
        json_response($this->model->cari_siswa());
    }
    public function tagihan_siswa()
    {
        json_response($this->model->tagihan_siswa());
    }
    public function simpan()
    {
        json_response($this->model->simpan());
    }
    public function riwayat()
    {
        json_response($this->model->riwayat());
    }
    public function batalkan()
    {
        json_response($this->model->batalkan());
    }
}
