<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_kelas extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }

        $this->load->model('admin/master_data/M_data_kelas', 'model');
    }

    public function index()
    {
        $data['title'] = 'Data Kelas';

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/master_data/data_kelas', $data);
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

    public function hapus()
    {
        $data = $this->model->hapus();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
?>