<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa_pembayar extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/tagihan/M_siswa_pembayar','model');}
    public function index(){$data = array('title'=>'Siswa Pembayar','tagihan'=>$this->model->tagihan_list(),'id_tagihan'=>(int)$this->input->get('id_tagihan'));
$this->load->view('admin/template/header', $data);
$this->load->view('admin/tagihan/siswa_pembayar', $data);
$this->load->view('admin/template/footer');}
    public function result(){json_response($this->model->result());}
    public function tambah(){json_response($this->model->tambah());}
    public function keluarkan(){json_response($this->model->keluarkan());}
}
