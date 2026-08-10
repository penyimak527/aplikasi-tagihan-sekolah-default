<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/transaksi/M_pembayaran', 'model');
    }

    public function index()
    {
        $token = bin2hex(random_bytes(16));
        $this->session->set_userdata('token_pembayaran_aktif', $token);

        $data = array(
            'title' => 'Pembayaran Tagihan',
            'metode' => $this->model->metode_list(),
            'token_pembayaran' => $token
        );

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/transaksi/pembayaran', $data);
        $this->load->view('admin/template/footer');
    }

    public function cari_siswa()
    {
        json_response($this->model->cari_siswa());
    }

    public function siswa($id = 0)
    {
        if ((int) $id <= 0) {
            $id = (int) $this->input->post('id');
        }

        json_response($this->model->siswa_by_id((int) $id));
    }

    public function tagihan_siswa()
    {
        json_response($this->model->tagihan_siswa());
    }

    public function simpan()
    {
        json_response($this->model->simpan());
    }

    public function detail()
    {
        json_response(
            $this->model->detail(
                (int) $this->input->post('id')
            )
        );
    }

    public function bukti($id = 0)
    {
        $data = $this->model->detail((int) $id);

        if (empty($data['result']) || $data['result'] !== 'true') {
            show_404();
        }

        $this->load->view('admin/transaksi/bukti_pembayaran', $data);
    }

    public function siapkan_whatsapp()
    {
        json_response($this->model->siapkan_whatsapp());
    }

    public function cetak_kartu($id = 0)
    {
        $data = $this->model->detail((int) $id);

        if (empty($data['result']) || $data['result'] !== 'true') {
            show_404();
        }

        $data['format'] = $this->model->format_kartu();
        $this->load->view('admin/transaksi/cetak_kartu', $data);
    }

    public function catat_cetak_kartu()
    {
        json_response($this->model->catat_cetak_kartu());
    }
}
