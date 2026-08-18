<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tagihan_per_jenis extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
           date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/tunggakan/M_tagihan_per_jenis', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Tagihan Per Jenis',
            'periode' => $this->model->periode_list(),
            'jenis' => $this->model->jenis_list(),
            'kelas' => $this->model->kelas_list()
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tunggakan/tagihan_per_jenis', $data);
        $this->load->view('admin/template/footer');
    }

    public function master()
    {
        $this->json_response($this->model->master_by_jenis());
    }

    public function result()
    {
        $this->json_response($this->model->per_jenis());
    }

    public function detail()
    {
        $this->json_response($this->model->detail_tagihan());
    }

    public function cetak()
    {
        $filter = $this->filter_get();
        $result = $this->model->per_jenis($filter);

        $data = array(
            'title' => 'Tagihan Per Jenis',
            'rows' => isset($result['rows']) ? $result['rows'] : array(),
            'summary' => isset($result['summary']) ? $result['summary'] : array(),
            'filter' => $this->model->filter_info($filter),
            'tanggal_cetak' => date('d-m-Y H:i:s')
        );

        $this->load->view('admin/tunggakan/cetak/tagihan_per_jenis', $data);
    }

    public function export()
    {
        $this->load_phpspreadsheet();

        $filter = $this->filter_get();
        $result = $this->model->per_jenis($filter);
        $rows = isset($result['rows']) ? $result['rows'] : array();
        $summary = isset($result['summary']) ? $result['summary'] : array();
        $info = $this->model->filter_info($filter);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Tagihan Per Jenis');

        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', 'TAGIHAN PER JENIS');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A3', 'Tahun Ajaran');
        $sheet->setCellValue('B3', $info['tahun_ajaran']);
        $sheet->setCellValue('A4', 'Jenis Tagihan');
        $sheet->setCellValue('B4', $info['jenis_tagihan']);
        $sheet->setCellValue('A5', 'Batch/Periode');
        $sheet->setCellValue('B5', $info['batch_periode']);
        $sheet->setCellValue('A6', 'Kelas');
        $sheet->setCellValue('B6', $info['kelas']);
        $sheet->setCellValue('A7', 'Tanggal Ekspor');
        $sheet->setCellValue('B7', date('d-m-Y H:i:s'));
        $sheet->getStyle('A3:A7')->getFont()->setBold(true);

        $headerRow = 9;
        $headers = array(
            'A' => 'No',
            'B' => 'NIS',
            'C' => 'NISN',
            'D' => 'Nama Siswa',
            'E' => 'Kelas',
            'F' => 'Tagihan',
            'G' => 'Periode',
            'H' => 'Wajib',
            'I' => 'Tarif Akhir',
            'J' => 'Dibayar',
            'K' => 'Sisa',
            'L' => 'Status'
        );
        foreach ($headers as $column => $label) {
            $sheet->setCellValue($column . $headerRow, $label);
        }
        $sheet->getStyle('A' . $headerRow . ':L' . $headerRow)->getFont()->setBold(true);

        $rowNumber = $headerRow + 1;
        foreach ($rows as $index => $row) {
            $periodeTagihan = trim((!empty($row['nama_bulan']) ? $row['nama_bulan'] . ' ' : '') . (!empty($row['tahun']) ? $row['tahun'] : ''));

            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValueExplicit('B' . $rowNumber, (string) $row['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $rowNumber, (string) $row['nisn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNumber, $row['nama_siswa']);
            $sheet->setCellValue('E' . $rowNumber, $row['nama_kelas']);
            $sheet->setCellValue('F' . $rowNumber, $row['nama_tagihan']);
            $sheet->setCellValue('G' . $rowNumber, $periodeTagihan);
            $sheet->setCellValue('H' . $rowNumber, $row['dianggap_tunggakan'] === 'Ya' ? 'Ya' : 'Tidak');
            $sheet->setCellValue('I' . $rowNumber, (float) $row['nominal_tagihan']);
            $sheet->setCellValue('J' . $rowNumber, (float) $row['nominal_dibayar']);
            $sheet->setCellValue('K' . $rowNumber, (float) $row['sisa_tagihan']);
            $sheet->setCellValue('L' . $rowNumber, $row['status_pembayaran']);
            $rowNumber++;
        }

        if ($rowNumber > $headerRow + 1) {
            $sheet->getStyle('I' . ($headerRow + 1) . ':K' . ($rowNumber - 1))
                ->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        $summaryRow = $rowNumber + 1;
        $sheet->setCellValue('A' . $summaryRow, 'Target');
        $sheet->setCellValue('B' . $summaryRow, (float) (isset($summary['target']) ? $summary['target'] : 0));
        $sheet->setCellValue('A' . ($summaryRow + 1), 'Pembayaran');
        $sheet->setCellValue('B' . ($summaryRow + 1), (float) (isset($summary['bayar']) ? $summary['bayar'] : 0));
        $sheet->setCellValue('A' . ($summaryRow + 2), 'Sisa');
        $sheet->setCellValue('B' . ($summaryRow + 2), (float) (isset($summary['sisa']) ? $summary['sisa'] : 0));
        $sheet->setCellValue('A' . ($summaryRow + 3), 'Realisasi');
        $sheet->setCellValue('B' . ($summaryRow + 3), (float) (isset($summary['realisasi']) ? $summary['realisasi'] : 0) / 100);
        $sheet->getStyle('A' . $summaryRow . ':A' . ($summaryRow + 3))->getFont()->setBold(true);
        $sheet->getStyle('B' . $summaryRow . ':B' . ($summaryRow + 2))->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('B' . ($summaryRow + 3))->getNumberFormat()->setFormatCode('0.00%');

        foreach (array('A' => 6, 'B' => 16, 'C' => 18, 'D' => 28, 'E' => 18, 'F' => 28, 'G' => 18, 'H' => 12, 'I' => 16, 'J' => 16, 'K' => 16, 'L' => 20) as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->freezePane('A10');

        $filename = 'tagihan_per_jenis_' . date('Ymd_His') . '.xlsx';
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
            'id_jenis' => (int) $this->input->get('id_jenis'),
            'id_master' => (int) $this->input->get('id_master'),
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
