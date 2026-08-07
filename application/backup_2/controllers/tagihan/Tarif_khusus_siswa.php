<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_khusus_siswa extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tagihan/M_tarif_tagihan', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Tarif Khusus Siswa',
            'tagihan' => $this->model->tagihan_list(),
            'id_tagihan' => (int) $this->input->get('id_tagihan')
        );
        $this->load->view('template/header', $data);
        $this->load->view('tagihan/tarif_khusus_siswa', $data);
        $this->load->view('template/footer');
    }

    public function result()
    {
        $this->json($this->model->result());
    }

    public function cari_siswa()
    {
        $this->json($this->model->cari_siswa());
    }

    public function simpan()
    {
        $this->json($this->model->simpan_siswa());
    }

    public function kembalikan_normal()
    {
        $this->json($this->model->kembalikan_normal());
    }

    public function riwayat()
    {
        $this->json($this->model->riwayat_siswa());
    }
}
