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
        $this->load->model('admin/tagihan/M_buat_tagihan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Buat Tagihan Langsung', 'tipe' => 'Langsung', 'periode' => $this->model->periode_list(), 'jenis' => $this->model->jenis_list('Langsung'), 'kelas' => $this->model->kelas_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tagihan/tagihan_langsung', $data);
        $this->load->view('admin/template/footer');
    }
    public function preview()
    {
        $this->json_response($this->model->preview('Langsung'));
    }
    public function simpan()
    {
        $this->json_response($this->model->simpan('Langsung'));
    }
    public function cari_siswa()
    {
        $this->json_response($this->model->cari_siswa());
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
