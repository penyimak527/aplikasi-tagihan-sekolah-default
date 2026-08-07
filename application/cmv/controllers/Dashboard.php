<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('dashboard/M_dashboard', 'model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard Tagihan Sekolah';
        $data['periode'] = $this->model->periode_list();
        $data['kelas'] = $this->model->kelas_list();
        $data['periode_aktif'] = $this->model->periode_aktif();
        $this->load->view('template/header', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('template/footer');
    }

    public function result()
    {
        json_response($this->model->dashboard_result());
    }
}
