<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Siswa_pembayar extends CI_Controller
{
    public function __construct(){parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }$this->load->model('admin/tagihan/M_siswa_pembayar','model');}
    public function index(){$data = array('title'=>'Siswa Pembayar','tagihan'=>$this->model->tagihan_list(),'id_tagihan'=>(int)$this->input->get('id_tagihan'));
$this->load->view('admin/template/header', $data);
$this->load->view('admin/tagihan/siswa_pembayar', $data);
$this->load->view('admin/template/footer');}
    public function result(){json_response($this->model->result());}
    public function tambah(){json_response($this->model->tambah());}
    public function keluarkan(){json_response($this->model->keluarkan());}

    public function export()
    {
        $id = (int) $this->input->get('id_tagihan');
        $search = trim((string) $this->input->get('search', true));
        $data = $this->model->export_rows($id, $search);

        if (!$data['master']) {
            show_404();
        }

        $filename = 'siswa_pembayar_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $data['master']['kode_tagihan']) . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, array('Daftar Siswa Pembayar'), ';');
        fputcsv($output, array('Tagihan', $data['master']['nama_tagihan']), ';');
        fputcsv($output, array('Tahun Ajaran', $data['master']['periode']), ';');
        fputcsv($output, array(), ';');
        fputcsv($output, array('No', 'NIS', 'NISN', 'Nama Siswa', 'Kelas', 'Tarif', 'Dibayar', 'Sisa', 'Status'), ';');

        foreach ($data['rows'] as $index => $row) {
            fputcsv($output, array(
                $index + 1,
                $row['nis'],
                $row['nisn'],
                $row['nama_siswa'],
                $row['nama_kelas'],
                (float) $row['tarif'],
                (float) $row['dibayar'],
                (float) $row['sisa'],
                $row['status_tagihan']
            ), ';');
        }

        fclose($output);
        exit;
    }
}

