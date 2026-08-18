<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tagihan_per_siswa extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }

    public function cari_siswa()
    {
        $q = trim((string)$this->input->post('q', true));
        if (strlen($q) < 2) return array();
        return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran,s.telepon_ayah,s.telepon_ibu,k.nama_kelas,k.id id_kelas_setting,k.id_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ? ORDER BY s.nama_lengkap LIMIT 25", array('%' . $q . '%', '%' . $q . '%', '%' . $q . '%'))->result_array();
    }

    public function per_siswa($filter = array())
    {
        $id = isset($filter['id_siswa']) ? (int) $filter['id_siswa'] : (int)$this->input->post('id_siswa');
        $periode = isset($filter['id_periode']) ? (int) $filter['id_periode'] : (int)$this->input->post('id_periode');
        $tipe = isset($filter['tipe']) ? trim((string) $filter['tipe']) : trim((string)$this->input->post('tipe', true));
        $status = isset($filter['status']) ? trim((string) $filter['status']) : trim((string)$this->input->post('status', true));
        $sampai = isset($filter['sampai_bulan']) ? (int) $filter['sampai_bulan'] : (int)$this->input->post('sampai_bulan');

        $siswa = $this->db->query("SELECT s.*,k.nama_kelas,k.id id_kelas_setting,k.id_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.id=? LIMIT 1", array($id))->row_array();
        if (!$siswa) return $this->model_response(false, 'Siswa tidak ditemukan.');

        $this->db->from('tagihan_siswa')->where('id_siswa', $id);
        if ($periode) $this->db->where('id_periode', $periode);
        if ($tipe !== '') $this->db->where('tipe_tagihan', $tipe);
        if ($status !== '') $this->db->where('status_pembayaran', $status);
        if ($sampai) {
            $urutanSampai = $sampai >= 7 ? $sampai - 6 : $sampai + 6;
            $this->db->where(
                "(CASE WHEN bulan >= 7 THEN bulan - 6 ELSE bulan + 6 END) <= " . (int) $urutanSampai,
                null,
                false
            );
        }

        $rows = $this->db->order_by('tahun')->order_by('bulan')->get()->result_array();
        $summary = array('wajib' => 0, 'dibayar' => 0, 'tunggakan' => 0, 'semua' => 0);

        foreach ($rows as $r) {
            $summary['semua'] += (float)$r['nominal_tagihan'];
            $summary['dibayar'] += (float)$r['nominal_dibayar'];
            if ($r['dianggap_tunggakan'] === 'Ya' && $r['status_tagihan'] === 'Aktif') {
                $summary['wajib'] += (float)$r['nominal_tagihan'];
                if (!in_array($r['status_pembayaran'], array('Lunas', 'Dibebaskan', 'Dibatalkan'), true)) {
                    $summary['tunggakan'] += (float)$r['sisa_tagihan'];
                }
            }
        }

        return array('result' => 'true', 'siswa' => $siswa, 'rows' => $rows, 'summary' => $summary);
    }

    public function filter_info($filter = array())
    {
        $periode = isset($filter['id_periode']) ? (int) $filter['id_periode'] : 0;
        $tipe = isset($filter['tipe']) ? trim((string) $filter['tipe']) : '';
        $status = isset($filter['status']) ? trim((string) $filter['status']) : '';
        $sampai = isset($filter['sampai_bulan']) ? (int) $filter['sampai_bulan'] : 0;

        $tahunAjaran = 'Semua Tahun Ajaran';
        if ($periode > 0) {
            $row = $this->db->select('periode')->where('id', $periode)->get('master_tahun_ajaran')->row_array();
            if ($row && isset($row['periode'])) {
                $tahunAjaran = $row['periode'];
            }
        }

        $bulan = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );

        return array(
            'tahun_ajaran' => $tahunAjaran,
            'tipe' => $tipe !== '' ? $tipe : 'Semua Tipe',
            'status' => $status !== '' ? $status : 'Semua Status',
            'sampai_bulan' => $sampai > 0 && isset($bulan[$sampai]) ? $bulan[$sampai] : 'Semua Bulan'
        );
    }

    private function model_response($success, $message = '', $extra = array())
    {
        return array_merge(array(
            'result' => $success ? 'true' : 'false',
            'message' => $message
        ), $extra);
    }
}
