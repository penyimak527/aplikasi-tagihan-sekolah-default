<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_per_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tagihan/M_tarif_per_kelas', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Tarif Per Kelas',
            'tagihan' => $this->model->tagihan_list(),
            'id_tagihan' => (int) $this->input->get('id_tagihan')
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tagihan/tarif_per_kelas', $data);
        $this->load->view('admin/template/footer');
    }

    public function result()
    {
        json_response($this->model->result());
    }

    public function simpan()
    {
        json_response($this->model->simpan());
    }
}
