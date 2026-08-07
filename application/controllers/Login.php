<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('M_login', 'model');
    }

    public function index()
    {
        if ($this->session->userdata('admin')) {
            redirect('dashboard');
        }

        $this->load->view('login');
    }

    public function proses()
    {
        $username = trim((string) $this->input->post('username', true));
        $password = (string) $this->input->post('password');

        if ($username === '' || $password === '') {
            $this->session->set_flashdata('error', 'Username dan password wajib diisi.');
            redirect('login');
        }

        $user = $this->model->get_by_username($username);

        if ($user && password_verify($password, (string) $user['password'])) {
            $this->session->set_userdata('admin', array(
                'id'         => (int) $user['id'],
                'id_pegawai' => (int) $user['id_pegawai'],
                'id_level'   => (int) $user['id_level'],
                'username'   => $user['username'],
                'nama'       => $user['nama_user'],
                'level'      => $user['level'],
                'role'       => $user['level']
            ));

            redirect('dashboard');
        }

        $this->session->set_flashdata('error', 'Username atau password tidak sesuai.');
        redirect('login');
    }

    public function logout()
    {
        $this->session->unset_userdata('admin');
        $this->session->sess_destroy();
        redirect('login');
    }
}
