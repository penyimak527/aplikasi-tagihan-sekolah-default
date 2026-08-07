<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Tunggakan_lama extends MY_Controller{public function __construct(){parent::__construct();$this->load->model('tunggakan/M_monitoring_tagihan','model');}public function index(){$data = array('title'=>'Tunggakan Tahun Sebelumnya','periode'=>$this->model->periode_list(),'kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('tunggakan/tunggakan_lama', $data);
$this->load->view('template/footer');}public function result(){$this->json($this->model->tunggakan_lama());}public function detail(){$this->json($this->model->detail_tagihan());}}
