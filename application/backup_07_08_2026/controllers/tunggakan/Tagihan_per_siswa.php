<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Tagihan_per_siswa extends MY_Controller{public function __construct(){parent::__construct();$this->load->model('tunggakan/M_monitoring_tagihan','model');}public function index(){$data = array('title'=>'Tagihan Per Siswa','periode'=>$this->model->periode_list());
$this->load->view('template/header', $data);
$this->load->view('tunggakan/tagihan_per_siswa', $data);
$this->load->view('template/footer');}public function cari_siswa(){$this->json($this->model->cari_siswa());}public function result(){$this->json($this->model->per_siswa());}}
