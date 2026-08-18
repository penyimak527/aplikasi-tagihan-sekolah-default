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
        $this->json_response($this->model->result());
    }
    public function detail()
    {
        $this->json_response($this->model->detail());
    }
    public function draft_detail()
    {
        $this->json_response($this->model->draft_detail());
    }

    public function update_draft()
    {
        $this->json_response($this->model->update_draft());
    }

    public function hapus_draft()
    {
        $this->json_response($this->model->hapus_draft());
    }

    public function terbitkan()
    {
        $this->json_response($this->model->terbitkan());
    }
    public function batalkan_sisa()
    {
        $this->json_response($this->model->batalkan_sisa());
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
