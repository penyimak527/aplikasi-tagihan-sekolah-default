<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan_bulanan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }

        $this->load->model('admin/tagihan/M_buat_tagihan', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Buat Tagihan Bulanan',
            'tipe' => 'Bulanan',
            'periode' => $this->model->periode_list(),
            'jenis' => $this->model->jenis_list('Bulanan'),
            'kelas' => $this->model->kelas_list()
        );

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tagihan/tagihan_bulanan', $data);
        $this->load->view('admin/template/footer');
    }

    public function preview()
    {
        $data = $this->model->preview_bulanan();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function simpan()
    {
        $data = $this->model->simpan_bulanan();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function cari_siswa()
    {
        $data = $this->model->cari_siswa();

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
?>
