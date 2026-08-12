<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Riwayat_pembayaran extends CI_Controller
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
        $data = array('title' => 'Riwayat Pembayaran', 'metode' => $this->model->metode_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/transaksi/riwayat_pembayaran', $data);
        $this->load->view('admin/template/footer');
    }
    public function result()
    {
        json_response($this->model->result());
    }
    public function detail()
    {
        json_response($this->model->detail((int) $this->input->post('id')));
    }
    public function batalkan()
    {
        json_response($this->model->batalkan());
    }
    public function catat_cetak($id = 0)
    {
        json_response($this->model->catat_cetak((int) $id));
    }
    public function export()
    {
        $this->model->export_csv();
    }
}
