<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_khusus_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tagihan/M_tarif_khusus_siswa', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Tarif Khusus Siswa',
            'tagihan' => $this->model->tagihan_list(),
            'id_tagihan' => (int) $this->input->get('id_tagihan')
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tagihan/tarif_khusus_siswa', $data);
        $this->load->view('admin/template/footer');
    }

    public function result()
    {
        $this->json_response($this->model->result());
    }

    public function cari_siswa()
    {
        $this->json_response($this->model->cari_siswa());
    }

    public function simpan()
    {
        $this->json_response($this->model->simpan());
    }

    public function kembalikan_normal()
    {
        $this->json_response($this->model->kembalikan_normal());
    }

    public function riwayat()
    {
        $this->json_response($this->model->riwayat());
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
