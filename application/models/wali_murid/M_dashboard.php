<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    public function ringkasan($ids, $id_periode)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $ids))));
        if (count($ids) == 0) {
            return array('tagihan_aktif' => 0, 'sudah_dibayar' => 0, 'sisa_tagihan' => 0, 'tunggakan_lama' => 0);
        }

        $bulanHariIni = (int) date('n');
        $tahunHariIni = (int) date('Y');
        $periodeHariIni = ($tahunHariIni * 100) + $bulanHariIni;
        $tanggalHariIni = date('Y-m-d');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $paramsTagihan = array_merge(
            array(
                $bulanHariIni, $tahunHariIni, $periodeHariIni, $tanggalHariIni,
                $bulanHariIni, $tahunHariIni, $periodeHariIni, $tanggalHariIni,
                $periodeHariIni, $tanggalHariIni,
                (int) $id_periode
            ),
            $ids
        );

        $rowTagihan = $this->db->query(
            "SELECT
                COALESCE(SUM(CASE
                    WHEN status_tagihan = 'Aktif'
                         AND status_pembayaran <> 'Dibatalkan'
                         AND (
                            (bulan = ? AND tahun = ?)
                            OR (
                                ((tahun * 100) + bulan) < ?
                                AND dianggap_tunggakan = 'Ya'
                                AND STR_TO_DATE(tanggal_jatuh_tempo,'%d-%m-%Y') <= ?
                            )
                         )
                    THEN nominal_tagihan ELSE 0 END),0) tagihan_aktif,
                COALESCE(SUM(CASE
                    WHEN status_tagihan = 'Aktif'
                         AND status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
                         AND sisa_tagihan > 0
                         AND (
                            (bulan = ? AND tahun = ?)
                            OR (
                                ((tahun * 100) + bulan) < ?
                                AND dianggap_tunggakan = 'Ya'
                                AND STR_TO_DATE(tanggal_jatuh_tempo,'%d-%m-%Y') <= ?
                            )
                         )
                    THEN sisa_tagihan ELSE 0 END),0) sisa_tagihan,
                COALESCE(SUM(CASE
                    WHEN status_tagihan = 'Aktif'
                         AND dianggap_tunggakan = 'Ya'
                         AND sisa_tagihan > 0
                         AND status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
                         AND ((tahun * 100) + bulan) <= ?
                         AND STR_TO_DATE(tanggal_jatuh_tempo,'%d-%m-%Y') <= ?
                    THEN sisa_tagihan ELSE 0 END),0) tunggakan_lama
             FROM tagihan_siswa
             WHERE id_periode = ?
               AND id_siswa IN ($placeholders)",
            $paramsTagihan
        )->row_array();

        $paramsBayar = array_merge($ids, array((int) $id_periode));
        $rowBayar = $this->db->query(
            "SELECT COALESCE(SUM(d.nominal_bayar),0) AS sudah_dibayar
             FROM tagihan_pembayaran p
             INNER JOIN tagihan_pembayaran_detail d
                ON d.id_pembayaran=p.id AND d.status_detail='Aktif'
             INNER JOIN tagihan_siswa ts ON ts.id=d.id_tagihan_siswa
             WHERE p.id_siswa IN ($placeholders)
               AND ts.id_periode=?
               AND p.status_transaksi='Aktif'",
            $paramsBayar
        )->row_array();

        return array(
            'tagihan_aktif' => (float) ($rowTagihan['tagihan_aktif'] ?? 0),
            'sudah_dibayar' => (float) ($rowBayar['sudah_dibayar'] ?? 0),
            'sisa_tagihan' => (float) ($rowTagihan['sisa_tagihan'] ?? 0),
            'tunggakan_lama' => (float) ($rowTagihan['tunggakan_lama'] ?? 0)
        );
    }

    public function perhatian($ids, $id_periode)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $ids))));
        if (count($ids) == 0) {
            return array();
        }

        $bulanHariIni = (int) date('n');
        $tahunHariIni = (int) date('Y');
        $periodeHariIni = ($tahunHariIni * 100) + $bulanHariIni;
        $tanggalHariIni = date('Y-m-d');
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $params = array_merge(
            $ids,
            array(
                (int) $id_periode,
                $bulanHariIni,
                $tahunHariIni,
                $periodeHariIni,
                $tanggalHariIni
            )
        );

        return $this->db->query(
            "SELECT *
             FROM tagihan_siswa
             WHERE id_siswa IN ($placeholders)
               AND id_periode = ?
               AND status_tagihan = 'Aktif'
               AND sisa_tagihan > 0
               AND status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
               AND (
                    (bulan = ? AND tahun = ?)
                    OR (
                        ((tahun * 100) + bulan) < ?
                        AND dianggap_tunggakan = 'Ya'
                        AND STR_TO_DATE(tanggal_jatuh_tempo,'%d-%m-%Y') <= ?
                    )
               )
             ORDER BY
                CASE
                    WHEN dianggap_tunggakan = 'Ya'
                         AND STR_TO_DATE(tanggal_jatuh_tempo,'%d-%m-%Y') <= CURDATE()
                    THEN 0 ELSE 1
                END,
                tahun ASC, bulan ASC,
                STR_TO_DATE(tanggal_jatuh_tempo, '%d-%m-%Y') ASC, id ASC
             LIMIT 5",
            $params
        )->result_array();
    }

    public function pembayaran_terbaru($ids, $id_periode)
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $ids))));
        if (count($ids) == 0) {
            return array();
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $params = array_merge($ids, array((int) $id_periode));

        return $this->db->query(
            "SELECT p.*,
                    GROUP_CONCAT(DISTINCT d.nama_tagihan ORDER BY d.id SEPARATOR ' + ') AS rincian_tagihan
             FROM tagihan_pembayaran p
             LEFT JOIN tagihan_pembayaran_detail d
               ON d.id_pembayaran = p.id AND d.status_detail = 'Aktif'
             WHERE p.id_siswa IN ($placeholders)
               AND p.id_periode = ?
               AND p.status_transaksi = 'Aktif'
             GROUP BY p.id
             ORDER BY STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') DESC, p.waktu_transaksi DESC, p.id DESC
             LIMIT 5",
            $params
        )->result_array();
    }
}
