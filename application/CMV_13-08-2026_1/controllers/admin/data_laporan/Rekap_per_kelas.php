<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_per_kelas extends CI_Controller
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
        $laporan = $this->model->report('per_kelas');
        if (!isset($laporan['result']) || $laporan['result'] !== 'true') {
            show_error(isset($laporan['message']) ? $laporan['message'] : 'Laporan gagal dimuat.');
        }

        $admin = $this->session->userdata('admin');
        $data = array(
            'title' => 'Rekap Pembayaran Per Kelas',
            'laporan' => $laporan,
            'filter_laporan' => $this->model->print_filter('per_kelas'),
            'petugas' => isset($admin['nama']) && $admin['nama'] !== '' ? $admin['nama'] : (isset($admin['username']) ? $admin['username'] : 'Administrator'),
            'orientation' => 'landscape'
        );

        $this->load->view('admin/data_laporan/rekap_per_kelas', $data);
    }
}
