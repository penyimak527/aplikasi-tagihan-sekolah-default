<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bukti_pembayaran extends CI_Controller
{
    private $wali;

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('wali_murid/M_portal', 'portal');
        $this->load->model('wali_murid/M_riwayat_pembayaran', 'model');

        $session = $this->session->userdata('wali_murid');
        if (!is_array($session) || empty($session['username'])) redirect('wali_murid/login');
        $akun = $this->portal->akun_aktif((int) $session['id']);
        if (!$akun) {
            $this->session->unset_userdata(array('wali_murid', 'wali_filter_siswa', 'wali_filter_periode'));
            redirect('wali_murid/login');
        }
        if ($akun['wajib_ganti_password'] === 'Ya') redirect('wali_murid/profil/ubah_password');
        $this->wali = $akun;
    }

    public function index()
    {
        $ctx = $this->portal->filter_context((int) $this->wali['id']);
        $data = array_merge($ctx, array('title' => 'Bukti Pembayaran', 'wali' => $this->wali, 'show_global_filter' => true));
        $this->load->view('wali_murid/template/header', $data);
        $this->load->view('wali_murid/bukti_pembayaran', $data);
        $this->load->view('wali_murid/template/footer');
    }

    public function result()
    {
        $ctx = $this->portal->filter_context((int) $this->wali['id']);
        $ids = $this->portal->ids_dari_context((int) $this->wali['id'], $ctx);
        $this->json_response(array('result' => 'true', 'data' => $this->model->result($ids, $ctx['id_periode_filter'])));
    }

    public function detail($id = 0)
    {
        redirect('wali_murid/riwayat_pembayaran/detail/' . (int) $id);
    }

    public function cetak($id = 0)
    {
        $detail = $this->model->detail((int) $this->wali['id'], (int) $id);
        if ($detail['result'] !== 'true') show_404();
        $detail['format'] = $this->model->format_bukti();
        $this->load->view('wali_murid/bukti_pembayaran_cetak', $detail);
    }

    private function json_response($data, $status = 200)
    {
        $this->output
            ->set_status_header((int) $status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
