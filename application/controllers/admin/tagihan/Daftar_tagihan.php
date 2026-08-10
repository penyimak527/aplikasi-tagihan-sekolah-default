<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Daftar_tagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tagihan/M_daftar_tagihan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Daftar Tagihan', 'periode' => $this->model->periode_list(), 'jenis' => $this->model->jenis_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tagihan/daftar_tagihan', $data);
        $this->load->view('admin/template/footer');
    }
    public function result()
    {
        json_response($this->model->result());
    }
    public function detail()
    {
        json_response($this->model->detail());
    }
    public function terbitkan()
    {
        json_response($this->model->terbitkan());
    }
    public function batalkan_sisa()
    {
        json_response($this->model->batalkan_sisa());
    }
}
