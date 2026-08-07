<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Format_bukti extends CI_Controller{public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('pengaturan/M_pengaturan','model');}public function index(){$data = array('title'=>'Format Bukti Pembayaran');
$this->load->view('template/header', $data);
$this->load->view('pengaturan/format_bukti', $data);
$this->load->view('template/footer');}public function result(){json_response($this->model->format_list('Bukti Pembayaran'));}public function detail(){json_response($this->model->format_detail((int)$this->input->post('id')));}public function simpan(){json_response($this->model->format_save('Bukti Pembayaran'));}public function set_default(){json_response($this->model->set_default());}}
