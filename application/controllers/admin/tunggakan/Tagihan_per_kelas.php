<?php defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan_per_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tunggakan/M_monitoring_tagihan', 'model');
    }
    public function index()
    {
        $data = array(
            'title' => 'Tagihan Per Kelas', 
            'periode' => $this->model->periode_list(), 
            'kelas' => $this->model->kelas_list()
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tunggakan/tagihan_per_kelas', $data);
        $this->load->view('admin/template/footer');
    }
    public function result()
    {
        json_response($this->model->per_kelas());
    }
    public function detail()
    {
        json_response($this->model->detail_tagihan());
    }

    public function export()
    {
        $filter = array(
            'id_periode' => (int) $this->input->get('id_periode'),
            'id_kelas_setting' => (int) $this->input->get('id_kelas_setting'),
            'sampai_bulan' => (int) $this->input->get('sampai_bulan')
        );
        $rows = $this->model->per_kelas($filter);

        $filename = 'tagihan_per_kelas_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");
         fwrite($output, "sep=;\r\n");
        fputcsv($output, array('Tagihan Per Kelas'), ';');
        fputcsv($output, array('Tanggal Ekspor', date('d-m-Y H:i:s')), ';');
        fputcsv($output, array(), ';');
        fputcsv($output, array('No', 'NIS', 'NISN', 'Nama Siswa', 'Kelas', 'Total Wajib', 'Dibayar', 'Tunggakan', 'Status'), ';');

        foreach ($rows as $index => $row) {
            fputcsv($output, array(
                $index + 1,
                $row['nis'],
                $row['nisn'],
                $row['nama_siswa'],
                $row['nama_kelas'],
                (float) $row['total_wajib'],
                (float) $row['dibayar'],
                (float) $row['tunggakan'],
                $row['status']
            ), ';');
        }

        fclose($output);
        exit;
    }
}

