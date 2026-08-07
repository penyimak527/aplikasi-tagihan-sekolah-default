<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembatalan_transaksi extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/M_riwayat_pembayaran', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Pembatalan Transaksi',
            'metode' => $this->model->metode_list()
        );
        $this->load->view('template/header', $data);
        $this->load->view('transaksi/pembatalan_transaksi', $data);
        $this->load->view('template/footer');
    }

    public function result()
    {
        $this->json($this->model->result_aktif());
    }

    public function detail()
    {
        $this->json($this->model->detail((int) $this->input->post('id')));
    }

    public function batalkan()
    {
        $this->json($this->model->batalkan());
    }
}
