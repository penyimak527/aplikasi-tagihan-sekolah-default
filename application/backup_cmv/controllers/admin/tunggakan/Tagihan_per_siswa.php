<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Tagihan_per_siswa extends CI_Controller{public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/tunggakan/M_monitoring_tagihan','model');}public function index(){$data = array('title'=>'Tagihan Per Siswa','periode'=>$this->model->periode_list());
$this->load->view('admin/template/header', $data);
$this->load->view('admin/tunggakan/tagihan_per_siswa', $data);
$this->load->view('admin/template/footer');}public function cari_siswa(){json_response($this->model->cari_siswa());}public function result(){json_response($this->model->per_siswa());}}
