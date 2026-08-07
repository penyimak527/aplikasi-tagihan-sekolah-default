<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');

        if (!$this->session->userdata('admin')) {
            if ($this->input->is_ajax_request()) {
                $this->json(array('result' => 'false', 'message' => 'Sesi berakhir. Silakan masuk kembali.'), 401);
            }
            redirect('login');
        }
    }

    protected function render($view, $data = array())
    {
        $data['title'] = isset($data['title']) ? $data['title'] : 'Aplikasi Tagihan Sekolah';
        $this->load->view('template/header', $data);
        $this->load->view($view, $data);
        $this->load->view('template/footer', $data);
    }

    protected function json($data, $status = 200)
    {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    protected function csv_download($filename, $headers, $rows)
    {
        $this->output->set_content_type('text/csv', 'utf-8');
        $this->output->set_header('Content-Disposition: attachment; filename="' . $filename . '"');
        $handle = fopen('php://output', 'w');
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, $headers, ';');
        foreach ($rows as $row) {
            fputcsv($handle, $row, ';');
        }
        fclose($handle);
        exit;
    }
}
