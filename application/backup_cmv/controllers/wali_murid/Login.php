<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('wali_murid/M_login', 'model');
        $this->load->model('wali_murid/M_portal', 'portal');
    }

    public function index()
    {
        $session = $this->session->userdata('wali_murid');
        if (is_array($session) && !empty($session['username'])) {
            $akun = $this->portal->akun_aktif((int) $session['id']);
            if ($akun) {
                if ($akun['wajib_ganti_password'] === 'Ya') {
                    redirect('wali_murid/profil/ubah_password');
                }
                redirect('wali_murid/dashboard');
            }
            $this->session->unset_userdata(array('wali_murid', 'wali_filter_siswa', 'wali_filter_periode'));
        }

        $this->load->view('wali_murid/login', array('sekolah' => $this->portal->profil_sekolah()));
    }

    public function proses()
    {
        $username = trim((string) $this->input->post('username', true));
        $password = (string) $this->input->post('password');

        if ($username === '' || $password === '') {
            $this->model->catat_login(null, $username, 'Gagal', 'Username atau password wajib diisi.');
            $this->session->set_flashdata('error', 'Username dan password wajib diisi.');
            redirect('wali_murid/login');
        }

        $wali = $this->model->get_by_username($username);
        if (!$wali) {
            $this->model->catat_login(null, $username, 'Gagal', 'Username atau password tidak sesuai.');
            $this->session->set_flashdata('error', 'Username atau password tidak sesuai.');
            redirect('wali_murid/login');
        }

        if ($wali['status'] !== 'Aktif') {
            $this->model->catat_login($wali, $username, 'Ditolak', 'Akun wali murid tidak aktif.');
            $this->session->set_flashdata('error', 'Username atau password tidak sesuai.');
            redirect('wali_murid/login');
        }

        if (!password_verify($password, (string) $wali['password_hash'])) {
            $this->model->catat_login($wali, $username, 'Gagal', 'Username atau password tidak sesuai.');
            $this->session->set_flashdata('error', 'Username atau password tidak sesuai.');
            redirect('wali_murid/login');
        }

        $this->model->login_berhasil($wali);
        $this->session->set_userdata('wali_murid', array(
            'id' => (int) $wali['id'],
            'username' => $wali['username'],
            'nama_wali' => $wali['nama_wali'],
            'wajib_ganti_password' => $wali['wajib_ganti_password'],
            'status' => $wali['status']
        ));
        $this->session->set_userdata('wali_filter_siswa', 0);
        $aktif = $this->portal->periode_aktif();
        $this->session->set_userdata('wali_filter_periode', (int) $aktif['id']);

        if ($wali['wajib_ganti_password'] === 'Ya') {
            redirect('wali_murid/profil/ubah_password');
        }
        redirect('wali_murid/dashboard');
    }

    public function logout()
    {
        $this->session->unset_userdata(array('wali_murid', 'wali_filter_siswa', 'wali_filter_periode'));
        redirect('wali_murid/login');
    }
}
