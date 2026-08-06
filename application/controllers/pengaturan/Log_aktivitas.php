<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Log_aktivitas extends MY_Controller{public function __construct(){parent::__construct();$this->load->model('pengaturan/M_pengaturan','model');}public function index(){$data = array('title'=>'Log Aktivitas');
$this->load->view('template/header', $data);
$this->load->view('pengaturan/log_aktivitas', $data);
$this->load->view('template/footer');}public function result(){$this->json($this->model->logs());}public function detail(){$this->json($this->model->log_detail((int)$this->input->post('id')));}public function export(){$this->model->export_logs();}}
