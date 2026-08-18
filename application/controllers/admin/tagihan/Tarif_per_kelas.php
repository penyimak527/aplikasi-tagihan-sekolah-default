<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_per_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
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
        $this->json_response($this->model->result());
    }

    public function simpan()
    {
        $this->json_response($this->model->simpan());
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
