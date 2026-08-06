<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tagihan_bulanan extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('tagihan/M_buat_tagihan','model');}
    public function index(){$data = array('title'=>'Buat Tagihan Bulanan','tipe'=>'Bulanan','periode'=>$this->model->periode_list(),'jenis'=>$this->model->jenis_list('Bulanan'),'kelas'=>$this->model->kelas_list());
$this->load->view('template/header', $data);
$this->load->view('tagihan/tagihan_bulanan', $data);
$this->load->view('template/footer');}
    public function preview(){$this->json($this->model->preview('Bulanan'));}
    public function simpan(){$this->json($this->model->simpan('Bulanan'));}
    public function cari_siswa(){$this->json($this->model->cari_siswa());}
}
