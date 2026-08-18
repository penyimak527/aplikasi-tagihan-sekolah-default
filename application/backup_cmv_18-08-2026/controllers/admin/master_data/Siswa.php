<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }

        $this->load->model('admin/master_data/M_siswa', 'model');
    }

    public function index()
    {
        $data['title'] = 'Data Siswa';
        $data['periode'] = $this->model->periode_list();
        $data['kelas'] = $this->model->kelas_list();

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/master_data/siswa', $data);
        $this->load->view('admin/template/footer');
    }

    public function siswa_result()
    {
        $data = $this->model->siswa_result();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function tambah()
    {
        $data = $this->model->tambah();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function edit()
    {
        $data = $this->model->edit();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function hapus()
    {
        $data = $this->model->hapus();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function cari()
    {
        $data = $this->model->cari();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
?>
