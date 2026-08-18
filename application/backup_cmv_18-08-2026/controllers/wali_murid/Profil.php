<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{
    private $wali;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('wali_murid/M_portal', 'portal');
        $this->load->model('wali_murid/M_profil', 'model');

        $session = $this->session->userdata('wali_murid');
        if (!is_array($session) || empty($session['username'])) {
            redirect('wali_murid/login');
        }
        $akun = $this->portal->akun_aktif((int) $session['id']);
        if (!$akun) {
            $this->session->unset_userdata(array('wali_murid', 'wali_filter_siswa', 'wali_filter_periode'));
            redirect('wali_murid/login');
        }
        $this->wali = $akun;
    }

    public function index()
    {
        if ($this->wali['wajib_ganti_password'] === 'Ya') {
            redirect('wali_murid/profil/ubah_password');
        }

        $ctx = $this->portal->filter_context((int) $this->wali['id']);
        $data = array_merge($ctx, array(
            'title' => 'Profil Wali Murid',
            'wali' => $this->wali,
            'show_global_filter' => false
        ));
        $this->load->view('wali_murid/template/header', $data);
        $this->load->view('wali_murid/profil', $data);
        $this->load->view('wali_murid/template/footer');
    }

    public function ubah_password()
    {
        $ctx = $this->portal->filter_context((int) $this->wali['id']);
        $data = array_merge($ctx, array(
            'title' => 'Ubah Password',
            'wali' => $this->wali,
            'show_global_filter' => false,
            'wajib_ganti' => $this->wali['wajib_ganti_password'] === 'Ya'
        ));
        $this->load->view('wali_murid/template/header', $data);
        $this->load->view('wali_murid/ubah_password', $data);
        $this->load->view('wali_murid/template/footer');
    }

    public function proses_ubah_password()
    {
        $result = $this->model->ubah_password((int) $this->wali['id']);
        if ($result['result'] === 'true') {
            $session = $this->session->userdata('wali_murid');
            $session['wajib_ganti_password'] = 'Tidak';
            $this->session->set_userdata('wali_murid', $session);
            $this->session->set_flashdata('portal_success', $result['message']);
            redirect('wali_murid/dashboard');
        }

        $this->session->set_flashdata('portal_error', $result['message']);
        redirect('wali_murid/profil/ubah_password');
    }
}
