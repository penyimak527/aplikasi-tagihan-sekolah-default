<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/pengaturan/M_user', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'User',
            'level' => $this->model->level_list(),
            'pegawai' => $this->model->pegawai_list()
        );

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/pengaturan/user', $data);
        $this->load->view('admin/template/footer');
    }

    public function user_result()
    {
        $this->json_response($this->model->user_result());
    }

    public function tambah()
    {
        $this->json_response($this->model->tambah());
    }

    public function edit($id = 0)
    {
        $user = $this->model->detail((int) $id);
        if (!$user) {
            show_404();
            return;
        }

        $data = array(
            'title' => 'Edit User',
            'user' => $user,
            'level' => $this->model->level_list(),
            'pegawai' => $this->model->pegawai_list()
        );

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/pengaturan/view/edit_user', $data);
        $this->load->view('admin/template/footer');
    }

    public function update($id = 0)
    {
        $this->json_response($this->model->update((int) $id));
    }

    public function hapus()
    {
        $this->json_response($this->model->hapus());
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
