<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Metode_pembayaran extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('master_data/M_metode_pembayaran','model');}
    public function index(){$data = array('title'=>'Metode Pembayaran');
$this->load->view('template/header', $data);
$this->load->view('master_data/metode_pembayaran', $data);
$this->load->view('template/footer');}
    public function result(){json_response($this->model->result());}
    public function simpan(){json_response($this->model->simpan());}
    public function status(){json_response($this->model->ubah_status());}
}
