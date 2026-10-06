<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tagihan extends CI_Model
{
    public function jenis_list()
    {
        return $this->db
            ->where('status', 'Aktif')
            ->order_by('nama_jenis', 'ASC')
            ->get('tagihan_jenis')
            ->result_array();
    }

    public function result($ids, $id_periode)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $ids))));
        if (count($ids) == 0) {
            return array();
        }

        $status = trim((string) $this->input->post('status', true));
        $id_jenis = (int) $this->input->post('id_jenis_tagihan');
        $search = trim((string) $this->input->post('search', true));
        $tanggal_hari_ini = date('Y-m-d');
        $bulan_hari_ini = (int) date('n');
        $tahun_hari_ini = (int) date('Y');
        $periode_hari_ini = ($tahun_hari_ini * 100) + $bulan_hari_ini;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT ts.*,
                       CASE
                           WHEN STR_TO_DATE(ts.tanggal_jatuh_tempo, '%d-%m-%Y') <= ?
                                AND ts.dianggap_tunggakan = 'Ya'
                           THEN 'Ya'
                           ELSE 'Tidak'
                       END AS is_tunggakan,
                       CASE
                           WHEN ts.bulan = ? AND ts.tahun = ? THEN 'Ya'
                           ELSE 'Tidak'
                       END AS is_bulan_ini
                FROM tagihan_siswa ts
                WHERE ts.id_siswa IN ($placeholders)
                  AND ts.id_periode = ?
                  AND ts.status_tagihan = 'Aktif'
                  AND ts.sisa_tagihan > 0
                  AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
                  AND (
                        (ts.bulan = ? AND ts.tahun = ?)
                        OR (
                            ((ts.tahun * 100) + ts.bulan) < ?
                            AND ts.dianggap_tunggakan = 'Ya'
                            AND STR_TO_DATE(ts.tanggal_jatuh_tempo, '%d-%m-%Y') <= ?
                        )
                  )";

        $params = array_merge(
            array($tanggal_hari_ini, $bulan_hari_ini, $tahun_hari_ini),
            $ids,
            array(
                (int) $id_periode,
                $bulan_hari_ini,
                $tahun_hari_ini,
                $periode_hari_ini,
                $tanggal_hari_ini
            )
        );

        if (in_array($status, array('Belum Dibayar', 'Dibayar Sebagian'), true)) {
            $sql .= " AND ts.status_pembayaran = ?";
            $params[] = $status;
        }
        if ($id_jenis > 0) {
            $sql .= " AND ts.id_jenis_tagihan = ?";
            $params[] = $id_jenis;
        }
        if ($search !== '') {
            $like = '%' . $search . '%';
            $sql .= " AND (ts.nama_tagihan LIKE ? OR ts.nama_jenis_tagihan LIKE ? OR ts.no_tagihan LIKE ?)";
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        $sql .= " ORDER BY
                    CASE
                        WHEN STR_TO_DATE(ts.tanggal_jatuh_tempo, '%d-%m-%Y') <= ?
                             AND ts.dianggap_tunggakan = 'Ya'
                        THEN 0 ELSE 1
                    END,
                    ts.tahun ASC,
                    ts.bulan ASC,
                    STR_TO_DATE(ts.tanggal_jatuh_tempo, '%d-%m-%Y') ASC,
                    ts.nama_siswa ASC,
                    ts.id ASC";
        $params[] = $tanggal_hari_ini;

        return $this->db->query($sql, $params)->result_array();
    }

    public function detail($id_wali, $id_tagihan)
    {
        $tagihan = $this->db->where('id', (int) $id_tagihan)->get('tagihan_siswa')->row_array();
        if (!$tagihan) {
            return array('result' => 'false', 'message' => 'Tagihan tidak ditemukan.');
        }

        $valid = $this->db
            ->where('id_wali_murid', (int) $id_wali)
            ->where('id_siswa', (int) $tagihan['id_siswa'])
            ->where('status', 'Aktif')
            ->count_all_results('wali_murid_siswa') > 0;

        if (!$valid) {
            return array('result' => 'false', 'message' => 'Tagihan tidak dapat diakses oleh akun ini.');
        }

        $cicilan = $this->db->query(
            "SELECT d.*, p.tanggal_transaksi, p.waktu_transaksi,
                    p.nama_metode_pembayaran, p.status_transaksi
             FROM tagihan_pembayaran_detail d
             INNER JOIN tagihan_pembayaran p ON p.id = d.id_pembayaran
             WHERE d.id_tagihan_siswa = ?
             ORDER BY STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') ASC, p.waktu_transaksi ASC, d.id ASC",
            array((int) $id_tagihan)
        )->result_array();

        return array(
            'result' => 'true',
            'message' => 'Detail tagihan berhasil dimuat.',
            'tagihan' => $tagihan,
            'cicilan' => $cicilan
        );
    }
}
