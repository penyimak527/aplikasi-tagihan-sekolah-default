<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat_kelas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
        $this->load->model('admin/kesiswaan/M_riwayat_kelas', 'model');
    }

    public function index()
    {
        $data = array(
            'title' => 'Riwayat Kelas Siswa',
            'id_siswa' => (int) $this->input->get('id_siswa'),
            'kelas' => $this->model->kelas_list()
        );
        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/kesiswaan/riwayat_kelas', $data);
        $this->load->view('admin/template/footer');
    }

    public function cari()
    {
        $this->json_response($this->model->cari());
    }

    public function result()
    {
        $this->json_response($this->model->result());
    }

    public function koreksi()
    {
        $this->json_response($this->model->koreksi());
    }

    public function cetak($id_siswa = 0)
    {
        $id_siswa = (int) $id_siswa;
        $siswa = $this->db->where('id', $id_siswa)->get('siswa')->row_array();

        if (!$siswa) {
            show_404();
            return;
        }

        $placements = $this->db->query(
            "SELECT ks.id,ks.status_aktif,k.id id_kelas_setting,k.nama_kelas,ta.periode,
                    (SELECT h.jenis_proses FROM tagihan_riwayat_kelas_siswa h
                     WHERE h.id_siswa=? AND h.id_kelas_setting_tujuan=k.id
                     ORDER BY h.id DESC LIMIT 1) jenis_proses,
                    (SELECT h.tanggal_proses FROM tagihan_riwayat_kelas_siswa h
                     WHERE h.id_siswa=? AND h.id_kelas_setting_tujuan=k.id
                     ORDER BY h.id DESC LIMIT 1) tanggal_proses,
                    (SELECT h.nama_user FROM tagihan_riwayat_kelas_siswa h
                     WHERE h.id_siswa=? AND h.id_kelas_setting_tujuan=k.id
                     ORDER BY h.id DESC LIMIT 1) nama_user
             FROM kelas_siswa ks
             JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED)
             LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED)
             WHERE CAST(ks.id_siswa AS UNSIGNED)=?
             ORDER BY ta.id,ks.id",
            array($id_siswa, $id_siswa, $id_siswa, $id_siswa)
        )->result_array();

        $history = $this->db
            ->where('id_siswa', $id_siswa)
            ->order_by('id', 'ASC')
            ->get('tagihan_riwayat_kelas_siswa')
            ->result_array();

        $data = array(
            'title' => 'Cetak Riwayat Kelas Siswa',
            'siswa' => $siswa,
            'placements' => $placements,
            'history' => $history,
            'tanggal_cetak' => date('d-m-Y H:i:s')
        );

        $this->load->view('admin/kesiswaan/cetak/cetak_riwayat_kelas', $data);
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
