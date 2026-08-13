<?php defined('BASEPATH') OR exit('No direct script access allowed'); class Template_whatsapp extends CI_Controller{public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/pengaturan/M_pengaturan','model');}public function index(){$data = array('title'=>'Template WhatsApp');
$this->load->view('admin/template/header', $data);
$this->load->view('admin/pengaturan/template_whatsapp', $data);
$this->load->view('admin/template/footer');}public function result(){json_response($this->model->template_list());}public function simpan(){json_response($this->model->template_save());}public function set_default(){json_response($this->model->template_default());}}
