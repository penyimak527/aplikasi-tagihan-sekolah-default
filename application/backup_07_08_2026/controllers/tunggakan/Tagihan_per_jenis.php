<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Tagihan_per_jenis extends MY_Controller{public function __construct(){parent::__construct();$this->load->model('tunggakan/M_monitoring_tagihan','model');}public function index(){$data = array('title'=>'Tagihan Per Jenis','periode'=>$this->model->periode_list(),'jenis'=>$this->model->jenis_list(),'kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('tunggakan/tagihan_per_jenis', $data);
$this->load->view('template/footer');}public function master(){$this->json($this->model->master_by_jenis());}public function result(){$this->json($this->model->per_jenis());}public function detail(){$this->json($this->model->detail_tagihan());}}
