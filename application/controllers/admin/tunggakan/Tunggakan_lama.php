<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tunggakan_lama extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tunggakan/M_tunggakan_lama', 'model');
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

    public function cetak()
    {
        $filter = $this->filter_get();
        $data = array(
            'title' => 'Tunggakan Tahun Sebelumnya',
            'rows' => $this->model->tunggakan_lama($filter),
            'filter' => $this->model->filter_info($filter),
            'tanggal_cetak' => date('d-m-Y H:i:s')
        );

        $this->load->view('admin/tunggakan/cetak/tunggakan_lama', $data);
    }

    public function export()
    {
        $this->load_phpspreadsheet();

        $filter = $this->filter_get();
        $rows = $this->model->tunggakan_lama($filter);
        $info = $this->model->filter_info($filter);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tunggakan Tahun Sebelumnya');

        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'TUNGGAKAN TAHUN SEBELUMNYA');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Tahun Berjalan');
        $sheet->setCellValue('B3', $info['tahun_berjalan']);
        $sheet->setCellValue('A4', 'Kelas Saat Ini');
        $sheet->setCellValue('B4', $info['kelas_saat_ini']);
        $sheet->setCellValue('A5', 'Tanggal Ekspor');
        $sheet->setCellValue('B5', date('d-m-Y H:i:s'));
        $sheet->getStyle('A3:A5')->getFont()->setBold(true);

        $headerRow = 7;
        $headers = array(
            'A' => 'No',
            'B' => 'NIS',
            'C' => 'NISN',
            'D' => 'Nama Siswa',
            'E' => 'Kelas Saat Ini',
            'F' => 'Tahun Asal',
            'G' => 'Rincian',
            'H' => 'Total Tunggakan'
        );

        foreach ($headers as $column => $label) {
            $sheet->setCellValue($column . $headerRow, $label);
        }
        $sheet->getStyle('A' . $headerRow . ':H' . $headerRow)->getFont()->setBold(true);

        $rowNumber = $headerRow + 1;
        foreach ($rows as $index => $row) {
            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValueExplicit('B' . $rowNumber, (string) $row['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $rowNumber, (string) $row['nisn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNumber, $row['nama_siswa']);
            $sheet->setCellValue('E' . $rowNumber, $row['kelas_saat_ini'] ?: '-');
            $sheet->setCellValue('F' . $rowNumber, $row['tahun_asal']);
            $sheet->setCellValue('G' . $rowNumber, (int) $row['jumlah_tagihan'] . ' tagihan');
            $sheet->setCellValue('H' . $rowNumber, (float) $row['total_tunggakan']);
            $rowNumber++;
        }

        if ($rowNumber > $headerRow + 1) {
            $sheet->getStyle('H' . ($headerRow + 1) . ':H' . ($rowNumber - 1))
                ->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        foreach (array(
            'A' => 6,
            'B' => 16,
            'C' => 18,
            'D' => 30,
            'E' => 20,
            'F' => 18,
            'G' => 16,
            'H' => 20
        ) as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->freezePane('A8');

        $filename = 'tunggakan_tahun_sebelumnya_' . date('Ymd_His') . '.xlsx';
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        $spreadsheet->disconnectWorksheets();
        exit;
    }

    private function filter_get()
    {
        return array(
            'id_periode_berjalan' => (int) $this->input->get('id_periode_berjalan'),
            'id_kelas_setting' => (int) $this->input->get('id_kelas_setting')
        );
    }

    private function load_phpspreadsheet()
    {
        if (class_exists('\\PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
            return;
        }

        $autoload = dirname(APPPATH) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
        if (is_file($autoload)) {
            require_once $autoload;
        }

        if (!class_exists('\\PhpOffice\\PhpSpreadsheet\\Spreadsheet')) {
            show_error('Library PhpSpreadsheet belum tersedia.', 500);
        }
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
