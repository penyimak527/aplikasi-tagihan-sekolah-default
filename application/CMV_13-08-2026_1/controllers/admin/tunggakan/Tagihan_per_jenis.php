<?php defined('BASEPATH') or exit('No direct script access allowed');
class Tagihan_per_jenis extends CI_Controller
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
        $data = array('title' => 'Tagihan Per Jenis', 'periode' => $this->model->periode_list(), 'jenis' => $this->model->jenis_list(), 'kelas' => $this->model->kelas_list());
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tunggakan/tagihan_per_jenis', $data);
        $this->load->view('admin/template/footer');
    }
    public function master()
    {
        json_response($this->model->master_by_jenis());
    }
    public function result()
    {
        json_response($this->model->per_jenis());
    }
    public function detail()
    {
        json_response($this->model->detail_tagihan());
    }

    public function export()
    {
        $filter = array(
            'id_periode' => (int) $this->input->get('id_periode'),
            'id_jenis' => (int) $this->input->get('id_jenis'),
            'id_master' => (int) $this->input->get('id_master'),
            'id_kelas_setting' => (int) $this->input->get('id_kelas_setting')
        );

        $data = $this->model->per_jenis($filter);
        $rows = isset($data['rows']) ? $data['rows'] : array();

        $filename = 'tagihan_per_jenis_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");
        fputcsv($output, array('Tagihan Per Jenis'), ';');
        fputcsv($output, array('Tanggal Ekspor', date('d-m-Y H:i:s')), ';');
        fputcsv($output, array(), ';');
        fputcsv($output, array('No', 'NIS', 'NISN', 'Nama Siswa', 'Kelas', 'Tagihan', 'Periode', 'Wajib', 'Tarif Akhir', 'Dibayar', 'Sisa', 'Status'), ';');

        foreach ($rows as $index => $row) {
            fputcsv($output, array(
                $index + 1,
                $row['nis'],
                $row['nisn'],
                $row['nama_siswa'],
                $row['nama_kelas'],
                $row['nama_tagihan'],
                trim(($row['nama_bulan'] ? $row['nama_bulan'] . ' ' : '') . $row['tahun']),
                $row['dianggap_tunggakan'],
                (float) $row['nominal_tagihan'],
                (float) $row['nominal_dibayar'],
                (float) $row['sisa_tagihan'],
                $row['status_pembayaran']
            ), ';');
        }

        fclose($output);
        exit;
    }
}
