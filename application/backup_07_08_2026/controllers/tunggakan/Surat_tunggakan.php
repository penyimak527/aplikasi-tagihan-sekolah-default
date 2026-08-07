<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Surat_tunggakan extends MY_Controller
{
    public function __construct(){parent::__construct();$this->load->model('tunggakan/M_surat_tunggakan','model');}
    public function index(){$data = array('title'=>'Surat Pemberitahuan Tunggakan','periode'=>$this->model->periode_list());
$this->load->view('template/header', $data);
$this->load->view('tunggakan/surat_tunggakan', $data);
$this->load->view('template/footer');}
    public function cari_siswa(){$this->json($this->model->cari_siswa());}
    public function siswa($id=0){$this->json($this->model->siswa_by_id((int)$id));}
    public function tagihan(){$this->json($this->model->tagihan());}
    public function simpan(){$this->json($this->model->simpan());}
    public function riwayat(){$this->json($this->model->riwayat());}
    public function detail(){$this->json($this->model->detail((int)$this->input->post('id')));}
    public function cetak($id=0){$d=$this->model->detail((int)$id);if($d['result']!=='true')show_404();$this->load->view('tunggakan/cetak_surat_tunggakan',$d);}
    public function siapkan_whatsapp(){$this->json($this->model->siapkan_whatsapp());}
}
