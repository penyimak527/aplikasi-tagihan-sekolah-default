<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Surat_tunggakan extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/tunggakan/M_surat_tunggakan','model');}
    public function index(){$data = array('title'=>'Surat Pemberitahuan Tunggakan','periode'=>$this->model->periode_list());
$this->load->view('admin/template/header', $data);
$this->load->view('admin/tunggakan/surat_tunggakan', $data);
$this->load->view('admin/template/footer');}
    public function cari_siswa(){json_response($this->model->cari_siswa());}
    public function siswa($id=0){json_response($this->model->siswa_by_id((int)$id));}
    public function tagihan(){json_response($this->model->tagihan());}
    public function simpan(){json_response($this->model->simpan());}
    public function riwayat(){json_response($this->model->riwayat());}
    public function detail(){json_response($this->model->detail((int)$this->input->post('id')));}
    public function cetak($id=0){$d=$this->model->detail((int)$id);if($d['result']!=='true')show_404();$this->load->view('admin/tunggakan/cetak_surat_tunggakan',$d);}
    public function siapkan_whatsapp(){json_response($this->model->siapkan_whatsapp());}
}
