<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa_pembayar extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('tagihan/M_siswa_pembayar','model');}
    public function index(){$data = array('title'=>'Siswa Pembayar','tagihan'=>$this->model->tagihan_list(),'id_tagihan'=>(int)$this->input->get('id_tagihan'));
$this->load->view('template/header', $data);
$this->load->view('tagihan/siswa_pembayar', $data);
$this->load->view('template/footer');}
    public function result(){$this->json($this->model->result());}
    public function tambah(){$this->json($this->model->tambah());}
    public function keluarkan(){$this->json($this->model->keluarkan());}
}
