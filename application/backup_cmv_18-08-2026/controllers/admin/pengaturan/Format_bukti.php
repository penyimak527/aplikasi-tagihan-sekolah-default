<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Format_bukti extends CI_Controller{public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/pengaturan/M_pengaturan','model');}public function index(){$data = array('title'=>'Format Bukti Pembayaran');
$this->load->view('admin/template/header', $data);
$this->load->view('admin/pengaturan/format_bukti', $data);
$this->load->view('admin/template/footer');}public function result(){$this->json_response($this->model->format_list('Bukti Pembayaran'));}public function detail(){$this->json_response($this->model->format_detail((int)$this->input->post('id')));}public function simpan(){$this->json_response($this->model->format_save('Bukti Pembayaran'));}public function set_default(){$this->json_response($this->model->set_default());}
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
