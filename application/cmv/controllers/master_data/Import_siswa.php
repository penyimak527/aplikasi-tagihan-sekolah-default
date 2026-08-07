<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Import_siswa extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('master_data/M_import_siswa','model');}
    public function index(){$data = array('title'=>'Import Siswa','periode'=>$this->model->periode_list(),'kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('master_data/import_siswa', $data);
$this->load->view('template/footer');}
    public function preview(){json_response($this->model->preview());}
    public function proses(){json_response($this->model->proses());}
    public function riwayat(){json_response($this->model->riwayat());}
    public function template(){redirect(base_url('assets/template/template_import_siswa.xlsx'));}
}
