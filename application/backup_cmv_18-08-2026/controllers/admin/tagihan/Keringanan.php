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
        $this->load->model('admin/tagihan/M_keringanan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Potongan atau Pembebasan');
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tagihan/keringanan', $data);
        $this->load->view('admin/template/footer');
    }
    public function cari_siswa()
    {
        $this->json_response($this->model->cari_siswa());
    }
    public function tagihan_siswa()
    {
        $this->json_response($this->model->tagihan_siswa());
    }
    public function simpan()
    {
        $this->json_response($this->model->simpan());
    }
    public function riwayat()
    {
        $this->json_response($this->model->riwayat());
    }
    public function batalkan()
    {
        $this->json_response($this->model->batalkan());
    }

    private function json_response($data, $status = 200)
    {
        $this->output
            ->set_status_header((int) $status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
