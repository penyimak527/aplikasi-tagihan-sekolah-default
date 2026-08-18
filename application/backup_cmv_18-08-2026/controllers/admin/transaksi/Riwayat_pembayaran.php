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
        $this->json_response($this->model->result());
    }
    public function detail()
    {
        $this->json_response($this->model->detail((int) $this->input->post('id')));
    }
    public function batalkan()
    {
        $this->json_response($this->model->batalkan());
    }
    public function catat_cetak($id = 0)
    {
        $this->json_response($this->model->catat_cetak((int) $id));
    }
    public function export()
    {
        $this->model->export_csv();
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
