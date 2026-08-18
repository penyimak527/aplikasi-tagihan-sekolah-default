<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Kelulusan extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/kesiswaan/M_kelulusan','model');}
    public function index(){$data = array('title'=>'Kelulusan','kelas'=>$this->model->kelas_list());
$this->load->view('admin/template/header', $data);
$this->load->view('admin/kesiswaan/kelulusan', $data);
$this->load->view('admin/template/footer');}
    public function siswa(){$this->json_response($this->model->siswa());}
    public function preview(){$this->json_response($this->model->preview());}
    public function proses(){$this->json_response($this->model->proses());}

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
