<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Tunggakan_lama extends CI_Controller{public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('tunggakan/M_monitoring_tagihan','model');}public function index(){$data = array('title'=>'Tunggakan Tahun Sebelumnya','periode'=>$this->model->periode_list(),'kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('tunggakan/tunggakan_lama', $data);
$this->load->view('template/footer');}public function result(){json_response($this->model->tunggakan_lama());}public function detail(){json_response($this->model->detail_tagihan());}}
