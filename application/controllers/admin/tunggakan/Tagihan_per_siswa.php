<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan_per_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tunggakan/M_tagihan_per_siswa', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Tagihan Per Siswa',
            'periode' => $this->model->periode_list()
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tunggakan/tagihan_per_siswa', $data);
        $this->load->view('admin/template/footer');
    }

    public function cari_siswa()
    {
        $this->json_response($this->model->cari_siswa());
    }

    public function result()
    {
        $this->json_response($this->model->per_siswa());
    }

    public function cetak()
    {
        $filter = array(
            'id_siswa' => (int) $this->input->get('id_siswa'),
            'id_periode' => (int) $this->input->get('id_periode'),
            'tipe' => trim((string) $this->input->get('tipe', true)),
            'status' => trim((string) $this->input->get('status', true)),
            'sampai_bulan' => (int) $this->input->get('sampai_bulan')
        );

        if ($filter['id_siswa'] <= 0) {
            show_error('Siswa belum dipilih.', 400);
        }

        $result = $this->model->per_siswa($filter);
        if (!isset($result['result']) || $result['result'] !== 'true') {
            show_error(isset($result['message']) ? $result['message'] : 'Data tagihan siswa tidak ditemukan.', 404);
        }

        $data = array(
            'title' => 'Tagihan Per Siswa',
            'siswa' => isset($result['siswa']) ? $result['siswa'] : array(),
            'rows' => isset($result['rows']) ? $result['rows'] : array(),
            'summary' => isset($result['summary']) ? $result['summary'] : array(),
            'filter' => $this->model->filter_info($filter),
            'tanggal_cetak' => date('d-m-Y H:i:s')
        );

        $this->load->view('admin/tunggakan/cetak/tagihan_per_siswa', $data);
    }

    private function json_response($data, $status = 200)
    {
        $this->output
            ->set_status_header((int) $status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
