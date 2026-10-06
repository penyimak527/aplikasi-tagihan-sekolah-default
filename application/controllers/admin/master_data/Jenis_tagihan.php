<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_tagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }

        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('admin/master_data/M_jenis_tagihan', 'model');
    }

    public function index()
    {
        $data['title'] = 'Jenis Tagihan';
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/master_data/jenis_tagihan', $data);
        $this->load->view('admin/template/footer');
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

    public function tambah()
    {
        $data = $this->model->tambah();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function edit()
    {
        $data = $this->model->edit();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function status()
    {
        $data = $this->model->ubah_status();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
