<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        $this->json($this->model->dashboard_result());
    }
}
