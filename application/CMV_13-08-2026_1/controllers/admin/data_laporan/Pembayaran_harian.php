<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran_harian extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/laporan/M_laporan', 'model');
    }

    public function index()
    {
        $laporan = $this->model->report('harian');
        if (!isset($laporan['result']) || $laporan['result'] !== 'true') {
            show_error(isset($laporan['message']) ? $laporan['message'] : 'Laporan gagal dimuat.');
        }

        $admin = $this->session->userdata('admin');
        $data = array(
            'title' => 'Laporan Pembayaran Harian',
            'laporan' => $laporan,
            'filter_laporan' => $this->model->print_filter('harian'),
            'petugas' => isset($admin['nama']) && $admin['nama'] !== '' ? $admin['nama'] : (isset($admin['username']) ? $admin['username'] : 'Administrator'),
            'orientation' => 'landscape'
        );

        $this->load->view('admin/data_laporan/pembayaran_harian', $data);
    }
}
