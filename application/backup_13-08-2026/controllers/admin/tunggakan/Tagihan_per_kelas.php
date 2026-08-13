<?php defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan_per_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tunggakan/M_monitoring_tagihan', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Tagihan Per Kelas', 'periode' => $this->model->periode_list(), 'kelas' => $this->model->kelas_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tunggakan/tagihan_per_kelas', $data);
        $this->load->view('admin/template/footer');
    }
    public function result()
    {
        json_response($this->model->per_kelas());
    }
    public function detail()
    {
        json_response($this->model->detail_tagihan());
    }
}
