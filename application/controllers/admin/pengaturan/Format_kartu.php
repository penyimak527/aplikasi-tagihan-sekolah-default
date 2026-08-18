<?php defined('BASEPATH') or exit('No direct script access allowed');
class Format_kartu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/pengaturan/M_pengaturan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Format Kartu Pembayaran');
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/pengaturan/format_kartu', $data);
        $this->load->view('admin/template/footer');
    }
    public function result()
    {
        $this->json_response($this->model->format_list('Kartu Pembayaran'));
    }
    public function detail()
    {
        $this->json_response($this->model->format_detail((int)$this->input->post('id')));
    }
    public function simpan()
    {
        $this->json_response($this->model->format_save('Kartu Pembayaran'));
    }
    public function set_default()
    {
        $this->json_response($this->model->set_default());
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
