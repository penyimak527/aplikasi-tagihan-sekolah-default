<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembatalan_transaksi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/transaksi/M_riwayat_pembayaran', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Pembatalan Transaksi',
            'metode' => $this->model->metode_list()
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/transaksi/pembatalan_transaksi', $data);
        $this->load->view('admin/template/footer');
    }

    public function result()
    {
        $this->json_response($this->model->result_aktif());
    }

    public function detail()
    {
        $this->json_response($this->model->detail((int) $this->input->post('id')));
    }

    public function batalkan()
    {
        $this->json_response($this->model->batalkan());
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
