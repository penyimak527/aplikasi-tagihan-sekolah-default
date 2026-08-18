<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_riwayat_pembayaran extends CI_Model
{
    private function in_clause($ids)
    {
        $ids = array_values(array_filter(array_map('intval', (array) $ids)));
        return empty($ids) ? '0' : implode(',', $ids);
    }

    public function result($ids, $id_periode)
    {
        $in = $this->in_clause($ids);
        if ($in === '0') {
            return array();
        }

        $dari = trim((string) $this->input->post('dari_tanggal', true));
        $sampai = trim((string) $this->input->post('sampai_tanggal', true));
        $params = array((int) $id_periode);

        $sql = "SELECT p.*,
                       GROUP_CONCAT(DISTINCT d.nama_tagihan ORDER BY d.id SEPARATOR ' + ') AS rincian_tagihan
                FROM tagihan_pembayaran p
                LEFT JOIN tagihan_pembayaran_detail d ON d.id_pembayaran = p.id
                WHERE p.id_siswa IN ($in)
                  AND p.id_periode = ?";

        if ($dari !== '') {
            $sql .= " AND STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') >= STR_TO_DATE(?, '%d-%m-%Y')";
            $params[] = $dari;
        }
        if ($sampai !== '') {
            $sql .= " AND STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') <= STR_TO_DATE(?, '%d-%m-%Y')";
            $params[] = $sampai;
        }

        $sql .= " GROUP BY p.id
                  ORDER BY STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') DESC,
                           p.waktu_transaksi DESC, p.id DESC";
        return $this->db->query($sql, $params)->result_array();
    }

    public function detail($id_wali, $id_pembayaran)
    {
        $header = $this->db->where('id', (int) $id_pembayaran)->get('tagihan_pembayaran')->row_array();
        if (!$header) {
            return $this->model_response(false, 'Transaksi pembayaran tidak ditemukan.');
        }

        $valid = $this->db
            ->where('id_wali_murid', (int) $id_wali)
            ->where('id_siswa', (int) $header['id_siswa'])
            ->where('status', 'Aktif')
            ->count_all_results('wali_murid_siswa') > 0;
        if (!$valid) {
            return $this->model_response(false, 'Transaksi tidak dapat diakses oleh akun ini.');
        }

        $detail = $this->db->where('id_pembayaran', (int) $id_pembayaran)->order_by('id', 'ASC')->get('tagihan_pembayaran_detail')->result_array();
        $pembatalan = $this->db->where('id_pembayaran', (int) $id_pembayaran)->get('tagihan_pembatalan_transaksi')->row_array();

        return $this->model_response(true, 'Detail pembayaran berhasil dimuat.', array(
            'header' => $header,
            'detail' => $detail,
            'pembatalan' => $pembatalan
        ));
    }

    public function format_bukti()
    {
        $row = $this->db
            ->where('jenis_format', 'Bukti Pembayaran')
            ->where('status', 'Aktif')
            ->where('status_default', 'Ya')
            ->order_by('id', 'DESC')
            ->get('tagihan_pengaturan_cetak')
            ->row_array();

        if (!$row) {
            $row = $this->db
                ->where('jenis_format', 'Bukti Pembayaran')
                ->where('status', 'Aktif')
                ->order_by('id', 'ASC')
                ->get('tagihan_pengaturan_cetak')
                ->row_array();
        }
        return $row ?: array();
    }

    private function model_response($success, $message = '', $extra = array())
    {
        return array_merge(array(
            'result' => $success ? 'true' : 'false',
            'message' => $message
        ), $extra);
    }
}
