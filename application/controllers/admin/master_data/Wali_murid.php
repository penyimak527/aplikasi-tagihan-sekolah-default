<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wali_murid extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/master_data/M_wali_murid', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Wali Murid',
            'periode' => $this->model->periode_list()
        );

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/master_data/wali_murid', $data);
        $this->load->view('admin/template/footer');
    }

    public function result()
    {
        json_response($this->model->result());
    }

    public function detail()
    {
        json_response($this->model->detail());
    }

    public function kelas_result()
    {
        json_response($this->model->kelas_result());
    }

    public function siswa_result()
    {
        json_response($this->model->siswa_result());
    }

    public function generate_username()
    {
        json_response($this->model->generate_username());
    }

    public function generate_password()
    {
        json_response($this->model->generate_password());
    }

    public function simpan()
    {
        json_response($this->model->simpan());
    }

    public function update()
    {
        json_response($this->model->update());
    }

    public function status()
    {
        json_response($this->model->status());
    }

    public function tambah_relasi()
    {
        json_response($this->model->tambah_relasi());
    }

    public function ubah_relasi()
    {
        json_response($this->model->ubah_relasi());
    }

    public function status_relasi()
    {
        json_response($this->model->status_relasi());
    }

    public function reset_password()
    {
        json_response($this->model->reset_password());
    }
}
