<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_per_kelas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tagihan/M_tarif_tagihan', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Tarif Per Kelas',
            'tagihan' => $this->model->tagihan_list(),
            'id_tagihan' => (int) $this->input->get('id_tagihan')
        );
        $this->load->view('template/header', $data);
        $this->load->view('tagihan/tarif_per_kelas', $data);
        $this->load->view('template/footer');
    }

    public function result()
    {
        $this->json($this->model->result());
    }

    public function simpan()
    {
        $this->json($this->model->simpan_kelas());
    }
}
