<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Import_wali_murid extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/master_data/M_import_wali_murid', 'model');
    }

    public function index()
    {
        $data = array('title' => 'Import Wali Murid');
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/master_data/import_wali_murid', $data);
        $this->load->view('admin/template/footer');
    }

    public function preview()
    {
        $this->json_response($this->model->preview());
    }

    public function proses()
    {
        $this->json_response($this->model->proses());
    }

    public function riwayat()
    {
        $this->json_response($this->model->riwayat());
    }

    public function template()
    {
        redirect(base_url('assets/template/template_import_wali_murid.xlsx'));
    }

    public function download_gagal($id = 0)
    {
        $id = (int) $id;
        $header = $this->model->import_by_id($id);
        if (!$header) {
            show_404();
        }

        $rows = $this->model->detail_gagal($id);
        $filename = 'laporan_gagal_import_wali_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $header['kode_import']) . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, array('Laporan Kegagalan Import Wali Murid'), ';');
        fputcsv($output, array('Kode Import', $header['kode_import']), ';');
        fputcsv($output, array('File', $header['nama_file']), ';');
        fputcsv($output, array(), ';');
        fputcsv($output, array('Baris', 'Nama Wali', 'Username', 'NIS', 'NISN', 'Nama Siswa', 'Hubungan', 'Aksi', 'Status', 'Pesan Validasi'), ';');

        foreach ($rows as $row) {
            fputcsv($output, array(
                $row['nomor_baris'],
                $row['nama_wali'],
                $row['username'],
                $row['nis'],
                $row['nisn'],
                $row['nama_siswa'],
                $row['hubungan'],
                $row['aksi'],
                $row['status_data'],
                $row['pesan_validasi']
            ), ';');
        }

        fclose($output);
        exit;
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
