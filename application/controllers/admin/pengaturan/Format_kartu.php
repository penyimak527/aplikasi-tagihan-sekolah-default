<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Format_kartu extends CI_Controller{public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/pengaturan/M_pengaturan','model');}public function index(){$data = array('title'=>'Format Kartu Pembayaran');
$this->load->view('admin/template/header', $data);
$this->load->view('admin/pengaturan/format_kartu', $data);
$this->load->view('admin/template/footer');}public function result(){json_response($this->model->format_list('Kartu Pembayaran'));}public function detail(){json_response($this->model->format_detail((int)$this->input->post('id')));}public function simpan(){json_response($this->model->format_save('Kartu Pembayaran'));}public function set_default(){json_response($this->model->set_default());}}
