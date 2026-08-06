<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        if ($this->session->userdata('admin')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function proses()
    {
        $username = trim((string) $this->input->post('username', true));
        $password = (string) $this->input->post('password');

        $valid_username = (string) $this->config->item('tagihan_login_username');
        $valid_password = (string) $this->config->item('tagihan_login_password');

        if (hash_equals($valid_username, $username) && hash_equals($valid_password, $password)) {
            $this->session->set_userdata('admin', array(
                'id' => 0,
                'username' => $username,
                'nama' => $this->config->item('tagihan_login_name'),
                'role' => $this->config->item('tagihan_login_role')
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
