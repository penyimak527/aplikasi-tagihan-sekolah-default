<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    private function in_clause($ids)
    {
        $ids = array_values(array_filter(array_map('intval', (array) $ids)));
        return empty($ids) ? '0' : implode(',', $ids);
    }

    private function tahun_awal_periode($id_periode)
    {
        $row = $this->db->where('id', (int) $id_periode)->get('master_tahun_ajaran')->row_array();
        if (!$row || empty($row['periode'])) {
            return 0;
        }
        $parts = explode('/', $row['periode']);
        return isset($parts[0]) ? (int) $parts[0] : 0;
    }

    public function ringkasan($ids, $id_periode)
    {
        $in = $this->in_clause($ids);
        if ($in === '0') {
            return array('tagihan_aktif' => 0, 'sudah_dibayar' => 0, 'sisa_tagihan' => 0, 'tunggakan_lama' => 0);
        }

        $tahunAwal = $this->tahun_awal_periode($id_periode);
        $row = $this->db->query(
            "SELECT
                COALESCE(SUM(CASE WHEN id_periode = ? AND status_tagihan='Aktif' AND status_pembayaran <> 'Dibatalkan' THEN nominal_tagihan ELSE 0 END),0) tagihan_aktif,
                COALESCE(SUM(CASE WHEN id_periode = ? AND status_tagihan='Aktif' AND status_pembayaran <> 'Dibatalkan' THEN nominal_dibayar ELSE 0 END),0) sudah_dibayar,
                COALESCE(SUM(CASE WHEN id_periode = ? AND status_tagihan='Aktif' AND status_pembayaran <> 'Dibatalkan' THEN sisa_tagihan ELSE 0 END),0) sisa_tagihan,
                COALESCE(SUM(CASE WHEN CAST(SUBSTRING_INDEX(periode,'/',1) AS UNSIGNED) < ?
                                      AND status_tagihan='Aktif'
                                      AND dianggap_tunggakan='Ya'
                                      AND sisa_tagihan > 0
                                      AND status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
                                  THEN sisa_tagihan ELSE 0 END),0) tunggakan_lama
             FROM tagihan_siswa
             WHERE id_siswa IN ($in)",
            array((int) $id_periode, (int) $id_periode, (int) $id_periode, (int) $tahunAwal)
        )->row_array();

        return array(
            'tagihan_aktif' => (float) ($row['tagihan_aktif'] ?? 0),
            'sudah_dibayar' => (float) ($row['sudah_dibayar'] ?? 0),
            'sisa_tagihan' => (float) ($row['sisa_tagihan'] ?? 0),
            'tunggakan_lama' => (float) ($row['tunggakan_lama'] ?? 0)
        );
    }

    public function perhatian($ids, $id_periode)
    {
        $in = $this->in_clause($ids);
        if ($in === '0') return array();

        return $this->db->query(
            "SELECT *
             FROM tagihan_siswa
             WHERE id_siswa IN ($in)
               AND id_periode = ?
               AND status_tagihan = 'Aktif'
               AND sisa_tagihan > 0
               AND status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
             ORDER BY
               CASE WHEN STR_TO_DATE(tanggal_jatuh_tempo, '%d-%m-%Y') IS NULL THEN 1 ELSE 0 END,
               STR_TO_DATE(tanggal_jatuh_tempo, '%d-%m-%Y') ASC,
               tahun ASC, bulan ASC, id ASC
             LIMIT 5",
            array((int) $id_periode)
        )->result_array();
    }

    public function pembayaran_terbaru($ids, $id_periode)
    {
        $in = $this->in_clause($ids);
        if ($in === '0') return array();

        return $this->db->query(
            "SELECT p.*,
                    GROUP_CONCAT(DISTINCT d.nama_tagihan ORDER BY d.id SEPARATOR ' + ') AS rincian_tagihan
             FROM tagihan_pembayaran p
             LEFT JOIN tagihan_pembayaran_detail d
               ON d.id_pembayaran = p.id AND d.status_detail = 'Aktif'
             WHERE p.id_siswa IN ($in)
               AND p.id_periode = ?
               AND p.status_transaksi = 'Aktif'
             GROUP BY p.id
             ORDER BY STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') DESC, p.waktu_transaksi DESC, p.id DESC
             LIMIT 5",
            array((int) $id_periode)
        )->result_array();
    }
}
