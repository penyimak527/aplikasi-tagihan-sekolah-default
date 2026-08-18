<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }

    public function periode_aktif()
    {
        return $this->tagihan_active_period();
    }

    public function kelas_list()
    {
        return $this->db
            ->select('ks.id, ks.id_kelas, ks.nama_kelas, ks.id_periode, ta.periode')
            ->from('kelas_setting ks')
            ->join('master_tahun_ajaran ta', 'ta.id = CAST(ks.id_periode AS UNSIGNED)', 'left')
            ->order_by('ta.id', 'DESC')
            ->order_by('ks.nama_kelas', 'ASC')
            ->get()
            ->result_array();
    }

    public function dashboard_result()
    {
        $periodeAktif = $this->tagihan_active_period();
        $idPeriode = (int) $this->input->post('id_periode');
        if ($idPeriode <= 0) {
            $idPeriode = (int) $periodeAktif['id'];
        }

        $idKelasSetting = (int) $this->input->post('id_kelas_setting');
        $bulan = (int) $this->input->post('bulan');

        $periodeRow = $this->db->where('id', $idPeriode)->get('master_tahun_ajaran')->row_array();
        if (!$periodeRow) {
            $periodeRow = $periodeAktif;
        }

        $studentSql = "SELECT COUNT(DISTINCT ks.id_siswa) AS total
                       FROM kelas_siswa ks
                       INNER JOIN kelas_setting kset ON kset.id = CAST(ks.id_kelas_setting AS UNSIGNED)
                       INNER JOIN siswa s ON s.id = CAST(ks.id_siswa AS UNSIGNED)
                       WHERE ks.status_aktif = '1'
                         AND s.status_pendaftaran = 'Aktif'
                         AND CAST(kset.id_periode AS UNSIGNED) = ?";
        $studentParams = array($idPeriode);
        if ($idKelasSetting > 0) {
            $studentSql .= ' AND kset.id = ?';
            $studentParams[] = $idKelasSetting;
        }
        $studentRow = $this->db->query($studentSql, $studentParams)->row_array();
        $siswaAktif = $studentRow ? (int) $studentRow['total'] : 0;

        $tagihanWhere = "id_periode = ? AND status_tagihan = 'Aktif'";
        $tagihanParams = array($idPeriode);
        if ($idKelasSetting > 0) {
            $tagihanWhere .= ' AND id_kelas_setting = ?';
            $tagihanParams[] = $idKelasSetting;
        }
        if ($bulan > 0) {
            $tagihanWhere .= ' AND bulan = ?';
            $tagihanParams[] = $bulan;
        }

        $summary = $this->db->query(
            "SELECT
                COALESCE(SUM(nominal_tagihan), 0) AS total_tagihan,
                COALESCE(SUM(CASE
                    WHEN dianggap_tunggakan = 'Ya'
                     AND sisa_tagihan > 0
                     AND status_pembayaran NOT IN ('Lunas', 'Dibebaskan', 'Dibatalkan')
                    THEN sisa_tagihan ELSE 0 END), 0) AS tunggakan,
                COALESCE(SUM(CASE WHEN status_pembayaran = 'Lunas' THEN 1 ELSE 0 END), 0) AS sudah_lunas,
                COALESCE(SUM(CASE WHEN status_pembayaran = 'Belum Dibayar' THEN 1 ELSE 0 END), 0) AS belum_lunas,
                COALESCE(SUM(CASE WHEN status_pembayaran = 'Dibayar Sebagian' THEN 1 ELSE 0 END), 0) AS cicilan_aktif
             FROM tagihan_siswa
             WHERE {$tagihanWhere}",
            $tagihanParams
        )->row_array();

        $paymentWhere = "id_periode = ? AND status_transaksi = 'Aktif'";
        $paymentParams = array($idPeriode);
        if ($idKelasSetting > 0) {
            $paymentWhere .= ' AND id_kelas_setting = ?';
            $paymentParams[] = $idKelasSetting;
        }
        if ($bulan > 0) {
            $paymentWhere .= " AND MONTH(STR_TO_DATE(tanggal_transaksi, '%d-%m-%Y')) = ?";
            $paymentParams[] = $bulan;
        }

        $paymentSummary = $this->db->query(
            "SELECT
                COALESCE(SUM(total_pembayaran), 0) AS pembayaran_masuk,
                COALESCE(SUM(CASE WHEN tanggal_transaksi = ? THEN 1 ELSE 0 END), 0) AS transaksi_hari_ini
             FROM tagihan_pembayaran
             WHERE {$paymentWhere}",
            array_merge(array($this->tanggal_sekarang()), $paymentParams)
        )->row_array();

        $chart = array();
        foreach ($this->bulan_tahun_ajaran($periodeRow['periode']) as $item) {
            $params = array($idPeriode, $item['bulan'], $item['tahun']);
            $extra = '';
            if ($idKelasSetting > 0) {
                $extra .= ' AND id_kelas_setting = ?';
                $params[] = $idKelasSetting;
            }

            $row = $this->db->query(
                "SELECT COALESCE(SUM(total_pembayaran), 0) AS total
                 FROM tagihan_pembayaran
                 WHERE id_periode = ?
                   AND status_transaksi = 'Aktif'
                   AND MONTH(STR_TO_DATE(tanggal_transaksi, '%d-%m-%Y')) = ?
                   AND YEAR(STR_TO_DATE(tanggal_transaksi, '%d-%m-%Y')) = ?
                   {$extra}",
                $params
            )->row_array();

            $chart[] = array(
                'label' => $item['nama'],
                'total' => (float) ($row ? $row['total'] : 0)
            );
        }

        $jenis = $this->db->query(
            "SELECT tipe_tagihan, COUNT(*) AS jumlah, COALESCE(SUM(nominal_tagihan), 0) AS nominal
             FROM tagihan_siswa
             WHERE {$tagihanWhere}
             GROUP BY tipe_tagihan
             ORDER BY FIELD(tipe_tagihan, 'Bulanan', 'Langsung', 'Tahunan'), tipe_tagihan",
            $tagihanParams
        )->result_array();

        $status = $this->db->query(
            "SELECT status_pembayaran, COUNT(*) AS jumlah, COALESCE(SUM(nominal_tagihan), 0) AS nominal
             FROM tagihan_siswa
             WHERE {$tagihanWhere}
               AND status_pembayaran IN ('Lunas', 'Dibayar Sebagian', 'Belum Dibayar')
             GROUP BY status_pembayaran
             ORDER BY FIELD(status_pembayaran, 'Lunas', 'Dibayar Sebagian', 'Belum Dibayar')",
            $tagihanParams
        )->result_array();

        $transaksi = $this->db->query(
            "SELECT id, no_transaksi, tanggal_transaksi, waktu_transaksi, nama_siswa, nama_kelas,
                    nama_metode_pembayaran, total_pembayaran, nama_user
             FROM tagihan_pembayaran
             WHERE {$paymentWhere}
             ORDER BY STR_TO_DATE(CONCAT(tanggal_transaksi, ' ', waktu_transaksi), '%d-%m-%Y %H:%i:%s') DESC
             LIMIT 8",
            $paymentParams
        )->result_array();

        $priorityWhere = $tagihanWhere . "
            AND dianggap_tunggakan = 'Ya'
            AND sisa_tagihan > 0
            AND status_pembayaran NOT IN ('Lunas', 'Dibebaskan', 'Dibatalkan')";

        $prioritas = $this->db->query(
            "SELECT id_siswa, nama_siswa, nama_kelas, COUNT(*) AS jumlah_tagihan,
                    COALESCE(SUM(sisa_tagihan), 0) AS total_tunggakan
             FROM tagihan_siswa
             WHERE {$priorityWhere}
             GROUP BY id_siswa, nama_siswa, nama_kelas
             ORDER BY total_tunggakan DESC, jumlah_tagihan DESC
             LIMIT 8",
            $tagihanParams
        )->result_array();

        return array(
            'result' => 'true',
            'summary' => array(
                'siswa_aktif' => $siswaAktif,
                'total_tagihan' => (float) $summary['total_tagihan'],
                'pembayaran_masuk' => (float) $paymentSummary['pembayaran_masuk'],
                'tunggakan' => (float) $summary['tunggakan'],
                'sudah_lunas' => (int) $summary['sudah_lunas'],
                'belum_lunas' => (int) $summary['belum_lunas'],
                'cicilan_aktif' => (int) $summary['cicilan_aktif'],
                'transaksi_hari_ini' => (int) $paymentSummary['transaksi_hari_ini']
            ),
            'chart' => $chart,
            'jenis' => $jenis,
            'status' => $status,
            'transaksi' => $transaksi,
            'prioritas' => $prioritas
        );
    }

    private function bulan_tahun_ajaran($periode)
    {
        $parts = explode('/', (string) $periode);
        $awal = isset($parts[0]) ? (int) $parts[0] : (int) date('Y');
        $akhir = isset($parts[1]) ? (int) $parts[1] : $awal + 1;
        return array(
            array('bulan' => 7, 'tahun' => $awal, 'nama' => 'Juli'),
            array('bulan' => 8, 'tahun' => $awal, 'nama' => 'Agustus'),
            array('bulan' => 9, 'tahun' => $awal, 'nama' => 'September'),
            array('bulan' => 10, 'tahun' => $awal, 'nama' => 'Oktober'),
            array('bulan' => 11, 'tahun' => $awal, 'nama' => 'November'),
            array('bulan' => 12, 'tahun' => $awal, 'nama' => 'Desember'),
            array('bulan' => 1, 'tahun' => $akhir, 'nama' => 'Januari'),
            array('bulan' => 2, 'tahun' => $akhir, 'nama' => 'Februari'),
            array('bulan' => 3, 'tahun' => $akhir, 'nama' => 'Maret'),
            array('bulan' => 4, 'tahun' => $akhir, 'nama' => 'April'),
            array('bulan' => 5, 'tahun' => $akhir, 'nama' => 'Mei'),
            array('bulan' => 6, 'tahun' => $akhir, 'nama' => 'Juni')
        );
    }


    private function tanggal_sekarang()
    {
        return date('d-m-Y');
    }


    private function tagihan_active_period()
    {
        $row = $this->db
            ->where('status', 'Aktif')
            ->order_by('id', 'DESC')
            ->get('master_tahun_ajaran')
            ->row_array();

        if (!$row) {
            $row = $this->db
                ->order_by('id', 'DESC')
                ->get('master_tahun_ajaran')
                ->row_array();
        }

        return $row ? $row : array(
            'id' => 0,
            'periode' => date('Y') . '/' . (date('Y') + 1),
            'status' => 'Tidak Aktif'
        );
    }
}
