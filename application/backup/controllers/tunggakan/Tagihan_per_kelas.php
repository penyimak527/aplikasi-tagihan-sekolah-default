<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Tagihan_per_kelas extends MY_Controller{public function __construct(){parent::__construct();$this->load->model('tunggakan/M_monitoring_tagihan','model');}public function index(){$data = array('title'=>'Tagihan Per Kelas','periode'=>$this->model->periode_list(),'kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('tunggakan/tagihan_per_kelas', $data);
$this->load->view('template/footer');}public function result(){$this->json($this->model->per_kelas());}public function detail(){$this->json($this->model->detail_tagihan());}}
