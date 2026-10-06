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

        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('admin/tagihan/M_daftar_tagihan', 'model');
    }

    public function index()
    {
        $data['title'] = 'Daftar Tagihan';
        $data['periode'] = $this->model->periode_list();
        $data['jenis'] = $this->model->jenis_list();

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tagihan/daftar_tagihan', $data);
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

    public function draft_detail()
    {
        $data = $this->model->draft_detail();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function cari_siswa()
    {
        $data = $this->model->cari_siswa();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function kelas_periode()
    {
        $data = $this->model->kelas_periode();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function update_draft()
    {
        $data = $this->model->update_draft();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function terbit_detail()
    {
        $data = $this->model->terbit_detail();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function update_terbit()
    {
        $data = $this->model->update_terbit();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function hapus_draft()
    {
        $data = $this->model->hapus_draft();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function terbitkan()
    {
        $data = $this->model->terbitkan();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function batalkan_sisa()
    {
        $data = $this->model->batalkan_sisa();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
