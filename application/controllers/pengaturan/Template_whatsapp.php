<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Template_whatsapp extends MY_Controller{public function __construct(){parent::__construct();$this->load->model('pengaturan/M_pengaturan','model');}public function index(){$data = array('title'=>'Template WhatsApp');
$this->load->view('template/header', $data);
$this->load->view('pengaturan/template_whatsapp', $data);
$this->load->view('template/footer');}public function result(){$this->json($this->model->template_list());}public function simpan(){$this->json($this->model->template_save());}public function set_default(){$this->json($this->model->template_default());}}
