<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tunggakan_lama extends CI_Controller
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
            'title' => 'Tunggakan Tahun Sebelumnya',
            'periode' => $this->model->periode_list(),
            'kelas' => $this->model->kelas_list()
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tunggakan/tunggakan_lama', $data);
        $this->load->view('admin/template/footer');
    }

    public function result()
    {
        $this->json_response($this->model->tunggakan_lama());
    }

    public function detail()
    {
        $this->json_response($this->model->detail_tagihan());
    }

    public function export()
    {
        $filter = array(
            'id_periode_berjalan' => (int) $this->input->get('id_periode_berjalan'),
            'id_kelas_setting' => (int) $this->input->get('id_kelas_setting')
        );
        $rows = $this->model->tunggakan_lama($filter);

        $filename = 'tunggakan_tahun_sebelumnya_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");
         fwrite($output, "sep=;\r\n");
        fputcsv($output, array('Tunggakan Tahun Sebelumnya'), ';');
        fputcsv($output, array('Tanggal Ekspor', date('d-m-Y H:i:s')), ';');
        fputcsv($output, array(), ';');
        fputcsv($output, array('No', 'NIS', 'NISN', 'Nama Siswa', 'Kelas Saat Ini', 'Tahun Asal', 'Jumlah Tagihan', 'Total Tunggakan'), ';');

        foreach ($rows as $index => $row) {
            fputcsv($output, array(
                $index + 1,
                $row['nis'],
                $row['nisn'],
                $row['nama_siswa'],
                $row['kelas_saat_ini'],
                $row['tahun_asal'],
                (int) $row['jumlah_tagihan'],
                (float) $row['total_tunggakan']
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
