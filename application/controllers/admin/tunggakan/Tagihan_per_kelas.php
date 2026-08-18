<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tagihan_per_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tunggakan/M_tagihan_per_kelas', 'model');
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
        $this->json_response($this->model->per_kelas());
    }

    public function detail()
    {
        $this->json_response($this->model->detail_tagihan());
    }

    public function cetak()
    {
        $filter = $this->filter_get();
        $data = array(
            'title' => 'Tagihan Per Kelas',
            'rows' => $this->model->per_kelas($filter),
            'filter' => $this->model->filter_info($filter),
            'tanggal_cetak' => date('d-m-Y H:i:s')
        );

        $this->load->view('admin/tunggakan/cetak/tagihan_per_kelas', $data);
    }

    public function export()
    {
        $this->load_phpspreadsheet();

        $filter = $this->filter_get();
        $rows = $this->model->per_kelas($filter);
        $info = $this->model->filter_info($filter);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tagihan Per Kelas');

        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'TAGIHAN PER KELAS');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Tahun Ajaran');
        $sheet->setCellValue('B3', $info['tahun_ajaran']);
        $sheet->setCellValue('A4', 'Kelas');
        $sheet->setCellValue('B4', $info['kelas']);
        $sheet->setCellValue('A5', 'Tanggal Ekspor');
        $sheet->setCellValue('B5', date('d-m-Y H:i:s'));
        $sheet->getStyle('A3:A5')->getFont()->setBold(true);

        $headerRow = 7;
        $headers = array(
            'A' => 'No',
            'B' => 'NIS',
            'C' => 'NISN',
            'D' => 'Nama Siswa',
            'E' => 'Kelas',
            'F' => 'Total Wajib',
            'G' => 'Dibayar',
            'H' => 'Tunggakan',
            'I' => 'Status'
        );
        foreach ($headers as $column => $label) {
            $sheet->setCellValue($column . $headerRow, $label);
        }
        $sheet->getStyle('A' . $headerRow . ':I' . $headerRow)->getFont()->setBold(true);

        $rowNumber = $headerRow + 1;
        foreach ($rows as $index => $row) {
            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValueExplicit('B' . $rowNumber, (string) $row['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $rowNumber, (string) $row['nisn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNumber, $row['nama_siswa']);
            $sheet->setCellValue('E' . $rowNumber, $row['nama_kelas']);
            $sheet->setCellValue('F' . $rowNumber, (float) $row['total_wajib']);
            $sheet->setCellValue('G' . $rowNumber, (float) $row['dibayar']);
            $sheet->setCellValue('H' . $rowNumber, (float) $row['tunggakan']);
            $sheet->setCellValue('I' . $rowNumber, $row['status']);
            $rowNumber++;
        }

        if ($rowNumber > $headerRow + 1) {
            $sheet->getStyle('F' . ($headerRow + 1) . ':H' . ($rowNumber - 1))
                ->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        foreach (array('A' => 6, 'B' => 16, 'C' => 18, 'D' => 28, 'E' => 18, 'F' => 16, 'G' => 16, 'H' => 16, 'I' => 18) as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->freezePane('A8');

        $filename = 'tagihan_per_kelas_' . date('Ymd_His') . '.xlsx';
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
            'id_periode' => (int) $this->input->get('id_periode'),
            'id_kelas_setting' => (int) $this->input->get('id_kelas_setting'),
            'sampai_bulan' => (int) $this->input->get('sampai_bulan')
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
