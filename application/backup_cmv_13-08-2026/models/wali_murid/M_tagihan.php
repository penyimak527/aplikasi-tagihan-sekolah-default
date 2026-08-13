<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tagihan extends CI_Model
{
    private function in_clause($ids)
    {
        $ids = array_values(array_filter(array_map('intval', (array) $ids)));
        return empty($ids) ? '0' : implode(',', $ids);
    }

    private function tahun_awal_aktif()
    {
        $row = $this->db->where('status', 'Aktif')->order_by('id', 'DESC')->get('master_tahun_ajaran')->row_array();
        if (!$row || empty($row['periode'])) return 0;
        $parts = explode('/', $row['periode']);
        return isset($parts[0]) ? (int) $parts[0] : 0;
    }

    public function jenis_list()
    {
        return $this->db->where('status', 'Aktif')->order_by('nama_jenis', 'ASC')->get('tagihan_jenis')->result_array();
    }

    public function result($ids, $id_periode)
    {
        $in = $this->in_clause($ids);
        if ($in === '0') return array();

        $status = trim((string) $this->input->post('status', true));
        $id_jenis = (int) $this->input->post('id_jenis_tagihan');
        $search = trim((string) $this->input->post('search', true));
        $tahunAktif = $this->tahun_awal_aktif();

        $sql = "SELECT ts.*,
                       CASE WHEN CAST(SUBSTRING_INDEX(ts.periode,'/',1) AS UNSIGNED) < ? THEN 'Ya' ELSE 'Tidak' END AS tahun_sebelumnya
                FROM tagihan_siswa ts
                WHERE ts.id_siswa IN ($in)
                  AND ts.id_periode = ?
                  AND ts.status_tagihan = 'Aktif'
                  AND ts.status_pembayaran <> 'Dibatalkan'";
        $params = array($tahunAktif, (int) $id_periode);

        if (in_array($status, array('Belum Dibayar', 'Dibayar Sebagian', 'Lunas', 'Dibebaskan'), true)) {
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

        $sql .= " ORDER BY ts.nama_siswa ASC, ts.tahun ASC, ts.bulan ASC, ts.id ASC";
        return $this->db->query($sql, $params)->result_array();
    }

    public function detail($id_wali, $id_tagihan)
    {
        $tagihan = $this->db->where('id', (int) $id_tagihan)->get('tagihan_siswa')->row_array();
        if (!$tagihan) return model_response(false, 'Tagihan tidak ditemukan.');

        $valid = $this->db
            ->where('id_wali_murid', (int) $id_wali)
            ->where('id_siswa', (int) $tagihan['id_siswa'])
            ->where('status', 'Aktif')
            ->count_all_results('wali_murid_siswa') > 0;
        if (!$valid) return model_response(false, 'Tagihan tidak dapat diakses oleh akun ini.');

        $cicilan = $this->db->query(
            "SELECT d.*, p.tanggal_transaksi, p.waktu_transaksi,
                    p.nama_metode_pembayaran, p.status_transaksi
             FROM tagihan_pembayaran_detail d
             INNER JOIN tagihan_pembayaran p ON p.id = d.id_pembayaran
             WHERE d.id_tagihan_siswa = ?
             ORDER BY STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') ASC, p.waktu_transaksi ASC, d.id ASC",
            array((int) $id_tagihan)
        )->result_array();

        return model_response(true, 'Detail tagihan berhasil dimuat.', array('tagihan' => $tagihan, 'cicilan' => $cicilan));
    }
}
