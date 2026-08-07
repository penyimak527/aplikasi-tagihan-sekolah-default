<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Daftar_tagihan extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tagihan/M_daftar_tagihan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Daftar Tagihan', 'periode' => $this->model->periode_list(), 'jenis' => $this->model->jenis_list());
        $this->load->view('template/header', $data);
        $this->load->view('tagihan/daftar_tagihan', $data);
        $this->load->view('template/footer');
    }
    public function result()
    {
        $this->json($this->model->result());
    }
    public function detail()
    {
        $this->json($this->model->detail());
    }
    public function terbitkan()
    {
        $this->json($this->model->terbitkan());
    }
    public function batalkan_sisa()
    {
        $this->json($this->model->batalkan_sisa());
    }
}
