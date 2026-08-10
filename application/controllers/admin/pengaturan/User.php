<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
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
        json_response($this->model->user_result());
    }

    public function tambah()
    {
        json_response($this->model->tambah());
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
        json_response($this->model->update((int) $id));
    }

    public function hapus()
    {
        json_response($this->model->hapus());
    }
}
