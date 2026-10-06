<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring_tagihan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }

        $this->load->model('admin/tunggakan/M_monitoring_tagihan', 'model');
    }

    public function index()
    {
        $idSiswa = (int) $this->input->get('id_siswa');
        if ($idSiswa <= 0) {
            $idSiswa = (int) $this->input->get('siswa');
        }

        $data = array(
            'title' => 'Monitoring Tagihan',
            'periode' => $this->model->periode_list(),
            'kelas' => $this->model->kelas_list(),
            'jenis' => $this->model->jenis_list(),
            'id_siswa' => $idSiswa,
            'preset_siswa' => $idSiswa > 0 ? $this->model->siswa_by_id($idSiswa) : null
        );

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/tunggakan/monitoring_tagihan', $data);
        $this->load->view('admin/template/footer');
    }

    public function siswa()
    {
        $this->json_response($this->model->cari_siswa());
    }

    public function master()
    {
        $this->json_response($this->model->master_list());
    }

    public function result()
    {
        $this->json_response($this->model->monitoring_result());
    }

    public function cetak()
    {
        $filter = $this->filter_get();
        $result = $this->model->monitoring_result($filter);

        $data = array(
            'title' => 'Monitoring Tagihan',
            'rows' => isset($result['rows']) ? $result['rows'] : array(),
            'summary' => isset($result['summary']) ? $result['summary'] : array(),
            'filter' => $this->model->filter_info($filter),
            'tanggal_cetak' => date('d-m-Y H:i:s')
        );

        $this->load->view('admin/tunggakan/cetak/monitoring_tagihan', $data);
    }

    public function export()
    {
        $this->load_phpspreadsheet();

        $filter = $this->filter_get();
        $result = $this->model->monitoring_result($filter);
        $rows = isset($result['rows']) ? $result['rows'] : array();
        $summary = isset($result['summary']) ? $result['summary'] : array();
        $info = $this->model->filter_info($filter);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Monitoring Tagihan');

        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'MONITORING TAGIHAN');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $filterRows = array(
            'A3' => array('Siswa', $info['siswa']),
            'A4' => array('Tahun Ajaran', $info['tahun_ajaran']),
            'A5' => array('Kelas', $info['kelas']),
            'A6' => array('Jenis Tagihan', $info['jenis_tagihan']),
            'A7' => array('Batch/Periode', $info['batch_periode']),
            'A8' => array('Tipe Tagihan', $info['tipe']),
            'A9' => array('Status Pembayaran', $info['status']),
            'A10' => array('Sampai Bulan', $info['sampai_bulan']),
            'A11' => array('Tanggal Ekspor', date('d-m-Y H:i:s'))
        );

        foreach ($filterRows as $cell => $values) {
            $row = (int) preg_replace('/\D/', '', $cell);
            $sheet->setCellValue('A' . $row, $values[0]);
            $sheet->setCellValue('B' . $row, $values[1]);
        }
        $sheet->getStyle('A3:A11')->getFont()->setBold(true);

        $headerRow = 13;
        $headers = array(
            'A' => 'No',
            'B' => 'NIS',
            'C' => 'NISN',
            'D' => 'Siswa',
            'E' => 'Kelas',
            'F' => 'Jenis Tagihan',
            'G' => 'Tagihan',
            'H' => 'Periode',
            'I' => 'Wajib',
            'J' => 'Tarif Akhir',
            'K' => 'Dibayar',
            'L' => 'Sisa',
            'M' => 'Status'
        );

        foreach ($headers as $column => $label) {
            $sheet->setCellValue($column . $headerRow, $label);
        }
        $sheet->getStyle('A' . $headerRow . ':M' . $headerRow)->getFont()->setBold(true);

        $rowNumber = $headerRow + 1;
        foreach ($rows as $index => $row) {
            $periodeTagihan = $this->periode_tagihan($row);

            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValueExplicit('B' . $rowNumber, (string) $row['nis'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('C' . $rowNumber, (string) $row['nisn'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $rowNumber, $row['nama_siswa']);
            $sheet->setCellValue('E' . $rowNumber, $row['nama_kelas']);
            $sheet->setCellValue('F' . $rowNumber, $row['nama_jenis_tagihan']);
            $sheet->setCellValue('G' . $rowNumber, $row['nama_tagihan']);
            $sheet->setCellValue('H' . $rowNumber, $periodeTagihan);
            $sheet->setCellValue('I' . $rowNumber, $row['dianggap_tunggakan'] === 'Ya' ? 'Ya' : 'Tidak');
            $sheet->setCellValue('J' . $rowNumber, (float) $row['nominal_tagihan']);
            $sheet->setCellValue('K' . $rowNumber, (float) $row['nominal_dibayar']);
            $sheet->setCellValue('L' . $rowNumber, (float) $row['sisa_tagihan']);
            $sheet->setCellValue('M' . $rowNumber, $row['status_pembayaran']);
            $rowNumber++;
        }

        if ($rowNumber > $headerRow + 1) {
            $sheet->getStyle('J' . ($headerRow + 1) . ':L' . ($rowNumber - 1))
                ->getNumberFormat()
                ->setFormatCode('#,##0');
        }

        $summaryRow = $rowNumber + 1;
        $sheet->setCellValue('A' . $summaryRow, 'Total Tagihan');
        $sheet->setCellValue('B' . $summaryRow, (float) (isset($summary['tagihan']) ? $summary['tagihan'] : 0));
        $sheet->setCellValue('A' . ($summaryRow + 1), 'Total Dibayar');
        $sheet->setCellValue('B' . ($summaryRow + 1), (float) (isset($summary['dibayar']) ? $summary['dibayar'] : 0));
        $sheet->setCellValue('A' . ($summaryRow + 2), 'Total Sisa');
        $sheet->setCellValue('B' . ($summaryRow + 2), (float) (isset($summary['sisa']) ? $summary['sisa'] : 0));
        $sheet->setCellValue('A' . ($summaryRow + 3), 'Realisasi');
        $sheet->setCellValue('B' . ($summaryRow + 3), (float) (isset($summary['realisasi']) ? $summary['realisasi'] : 0) / 100);
        $sheet->getStyle('A' . $summaryRow . ':A' . ($summaryRow + 3))->getFont()->setBold(true);
        $sheet->getStyle('B' . $summaryRow . ':B' . ($summaryRow + 2))->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('B' . ($summaryRow + 3))->getNumberFormat()->setFormatCode('0.00%');

        foreach (
            array(
                'A' => 6,
                'B' => 16,
                'C' => 18,
                'D' => 28,
                'E' => 18,
                'F' => 22,
                'G' => 30,
                'H' => 18,
                'I' => 10,
                'J' => 16,
                'K' => 16,
                'L' => 16,
                'M' => 20
            ) as $column => $width
        ) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $sheet->freezePane('A14');

        $filename = 'monitoring_tagihan_' . date('Ymd_His') . '.xlsx';
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
            'id_siswa' => (int) $this->input->get('id_siswa'),
            'id_periode' => (int) $this->input->get('id_periode'),
            'id_kelas_setting' => (int) $this->input->get('id_kelas_setting'),
            'id_jenis' => (int) $this->input->get('id_jenis'),
            'id_master' => (int) $this->input->get('id_master'),
            'tipe' => trim((string) $this->input->get('tipe', true)),
            'status' => trim((string) $this->input->get('status', true)),
            'sampai_bulan' => (int) $this->input->get('sampai_bulan')
        );
    }

    private function periode_tagihan($row)
    {
        $namaBulan = isset($row['nama_bulan']) ? trim((string) $row['nama_bulan']) : '';
        $tahun = isset($row['tahun']) ? trim((string) $row['tahun']) : '';

        if ($namaBulan !== '' || $tahun !== '') {
            return trim($namaBulan . ' ' . $tahun);
        }

        return isset($row['periode']) ? (string) $row['periode'] : '-';
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
