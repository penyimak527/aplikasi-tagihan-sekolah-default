<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tagihan extends CI_Controller
{
    private $wali;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('wali_murid/M_portal', 'portal');
        $this->load->model('wali_murid/M_tagihan', 'model');

        $session = $this->session->userdata('wali_murid');
        if (!is_array($session) || empty($session['username'])) {
            redirect('wali_murid/login');
        }
        $akun = $this->portal->akun_aktif((int) $session['id']);
        if (!$akun) {
            $this->session->unset_userdata(array('wali_murid', 'wali_filter_siswa', 'wali_filter_periode'));
            redirect('wali_murid/login');
        }
        if ($akun['wajib_ganti_password'] === 'Ya') {
            redirect('wali_murid/profil/ubah_password');
        }
        $this->wali = $akun;
    }

    public function index()
    {
        $ctx = $this->portal->filter_context((int) $this->wali['id']);
        $data = array_merge($ctx, array(
            'title' => 'Tagihan',
            'wali' => $this->wali,
            'show_global_filter' => true,
            'jenis' => $this->model->jenis_list()
        ));
        $this->load->view('wali_murid/template/header', $data);
        $this->load->view('wali_murid/tagihan', $data);
        $this->load->view('wali_murid/template/footer');
    }

    public function result()
    {
        $ctx = $this->portal->filter_context((int) $this->wali['id']);
        $ids = $this->portal->ids_dari_context((int) $this->wali['id'], $ctx);
        json_response(array(
            'result' => 'true',
            'data' => $this->model->result($ids, $ctx['id_periode_filter'])
        ));
    }

    public function detail($id = 0)
    {
        $detail = $this->model->detail((int) $this->wali['id'], (int) $id);
        if ($detail['result'] !== 'true') {
            show_404();
        }

        $ctx = $this->portal->filter_context((int) $this->wali['id']);
        $data = array_merge($ctx, $detail, array(
            'title' => 'Detail Tagihan',
            'wali' => $this->wali,
            'show_global_filter' => false
        ));
        $this->load->view('wali_murid/template/header', $data);
        $this->load->view('wali_murid/detail_tagihan', $data);
        $this->load->view('wali_murid/template/footer');
    }
}
