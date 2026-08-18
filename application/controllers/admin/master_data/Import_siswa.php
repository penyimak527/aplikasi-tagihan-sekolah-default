<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Import_siswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/master_data/M_import_siswa', 'model');
    }
    public function index()
    {
        $data = array('title' => 'Import Siswa', 'periode' => $this->model->periode_list(), 'kelas' => $this->model->kelas_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/master_data/import_siswa', $data);
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
        redirect(base_url('assets/template/template_import_siswa.xlsx'));
    }

    public function download_gagal($id = 0)
    {
        $id = (int) $id;
        $header = $this->model->import_by_id($id);
        if (!$header) {
            show_404();
        }

        $rows = $this->model->detail_gagal($id);
        $filename = 'laporan_gagal_import_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $header['kode_import']) . '.csv';

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, array('Laporan Kegagalan Import Siswa'), ';');
        fputcsv($output, array('Kode Import', $header['kode_import']), ';');
        fputcsv($output, array('File', $header['nama_file']), ';');
        fputcsv($output, array('Tahun Ajaran', $header['periode']), ';');
        fputcsv($output, array('Kelas', $header['nama_kelas']), ';');
        fputcsv($output, array(), ';');
        fputcsv($output, array('Baris', 'NIS', 'NISN', 'Nama Siswa', 'Jenis Kelamin', 'Kelas Excel', 'Status', 'Pesan Validasi'), ';');

        foreach ($rows as $row) {
            fputcsv($output, array(
                $row['nomor_baris'],
                $row['nis'],
                $row['nisn'],
                $row['nama_siswa'],
                $row['jenis_kelamin'],
                $row['nama_kelas_excel'],
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
