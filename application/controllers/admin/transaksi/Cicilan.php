<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cicilan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }

        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('admin/transaksi/M_cicilan', 'model');
    }

    public function index()
    {
        $data['title'] = 'Cicilan';
        $data['periode'] = $this->model->periode_list();
        $data['periode_aktif'] = $this->model->periode_aktif();

        $idPeriodeAktif = isset($data['periode_aktif']['id']) ? (int) $data['periode_aktif']['id'] : 0;
        $data['kelas'] = $this->model->kelas_list($idPeriodeAktif);

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/transaksi/cicilan', $data);
        $this->load->view('admin/template/footer');
    }

    public function kelas_result()
    {
        $data = $this->model->kelas_list();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function result()
    {
        $data = $this->model->result();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function detail()
    {
        $data = $this->model->detail();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
