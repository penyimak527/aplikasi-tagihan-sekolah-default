<?php defined('BASEPATH') or exit('No direct script access allowed');
class Log_aktivitas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/pengaturan/M_pengaturan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Log Aktivitas');
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/pengaturan/log_aktivitas', $data);
        $this->load->view('admin/template/footer');
    }
    public function result()
    {
        json_response($this->model->logs());
    }
    public function detail()
    {
        json_response($this->model->log_detail((int)$this->input->post('id')));
    }
    public function export()
    {
        $this->model->export_logs();
    }
}
