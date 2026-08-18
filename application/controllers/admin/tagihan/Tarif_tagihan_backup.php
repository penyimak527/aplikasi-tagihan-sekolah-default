<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tarif_tagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
    }

    public function index()
    {
        $id = (int) $this->input->get('id_tagihan');
        redirect('admin/tagihan/tarif_per_kelas' . ($id > 0 ? '?id_tagihan=' . $id : ''));
    }
}
