<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    private $wali;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('wali_murid/M_portal', 'portal');
        $this->load->model('wali_murid/M_dashboard', 'model');

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

        if ($akun['wajib_ganti_password'] === 'Ya') {
            redirect('wali_murid/profil/ubah_password');
        }
    }

    public function index()
    {
        $ctx = $this->portal->filter_context((int) $this->wali['id']);
        $ids = $this->portal->ids_dari_context((int) $this->wali['id'], $ctx);
        $ringkasan = $this->model->ringkasan($ids, $ctx['id_periode_filter']);

        $data = array_merge($ctx, array(
            'title' => 'Beranda Portal Wali Murid',
            'wali' => $this->wali,
            'show_global_filter' => true,
            'ringkasan' => $ringkasan,
            'jumlah_anak' => count($ids),
            'perhatian' => $this->model->perhatian($ids, $ctx['id_periode_filter']),
            'pembayaran_terbaru' => $this->model->pembayaran_terbaru($ids, $ctx['id_periode_filter'])
        ));

        $this->load->view('wali_murid/template/header', $data);
        $this->load->view('wali_murid/dashboard', $data);
        $this->load->view('wali_murid/template/footer');
    }

    public function filter_global()
    {
        $id_siswa = (int) $this->input->post('id_siswa');
        $id_periode = (int) $this->input->post('id_periode');
        $redirect = trim((string) $this->input->post('redirect', true), '/');

        $result = $this->portal->set_filter((int) $this->wali['id'], $id_siswa, $id_periode);
        if ($result['result'] !== 'true') {
            $this->session->set_flashdata('portal_error', $result['message']);
        }

        if ($redirect === '' || strpos($redirect, 'wali_murid/') !== 0) {
            $redirect = 'wali_murid/dashboard';
        }
        redirect($redirect);
    }
}
