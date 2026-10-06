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
        $row = $this->db->where('status', 'Aktif')->order_by('id', 'DESC')->get('master_tahun_ajaran')->row_array();
        if (!$row) {
            $row = $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->row_array();
        }
        return $row ?: array('id' => 0, 'periode' => date('Y') . '/' . (date('Y') + 1), 'status' => 'Tidak Aktif');
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
        $periodeAktif = $this->periode_aktif();
        $idPeriode = (int) $this->input->post('id_periode');
        $idKelasSetting = (int) $this->input->post('id_kelas_setting');
        $bulan = (int) $this->input->post('bulan');
        $tahun = (int) $this->input->post('tahun');

        if ($idPeriode <= 0) {
            $idPeriode = (int) $periodeAktif['id'];
        }

        $periodeRow = $this->db->where('id', $idPeriode)->get('master_tahun_ajaran')->row_array();
        if (!$periodeRow) {
            return array('result' => 'false', 'message' => 'Tahun ajaran tidak ditemukan.');
        }

        $parts = explode('/', (string) $periodeRow['periode']);
        $tahunAwal = isset($parts[0]) ? (int) $parts[0] : (int) date('Y');
        $tahunAkhir = isset($parts[1]) ? (int) $parts[1] : $tahunAwal + 1;
        $bulanTahunAjaran = array(
            array('bulan' => 7, 'tahun' => $tahunAwal, 'nama' => 'Juli'),
            array('bulan' => 8, 'tahun' => $tahunAwal, 'nama' => 'Agustus'),
            array('bulan' => 9, 'tahun' => $tahunAwal, 'nama' => 'September'),
            array('bulan' => 10, 'tahun' => $tahunAwal, 'nama' => 'Oktober'),
            array('bulan' => 11, 'tahun' => $tahunAwal, 'nama' => 'November'),
            array('bulan' => 12, 'tahun' => $tahunAwal, 'nama' => 'Desember'),
            array('bulan' => 1, 'tahun' => $tahunAkhir, 'nama' => 'Januari'),
            array('bulan' => 2, 'tahun' => $tahunAkhir, 'nama' => 'Februari'),
            array('bulan' => 3, 'tahun' => $tahunAkhir, 'nama' => 'Maret'),
            array('bulan' => 4, 'tahun' => $tahunAkhir, 'nama' => 'April'),
            array('bulan' => 5, 'tahun' => $tahunAkhir, 'nama' => 'Mei'),
            array('bulan' => 6, 'tahun' => $tahunAkhir, 'nama' => 'Juni')
        );

        if ($bulan > 0 && $tahun <= 0) {
            $tahun = $bulan >= 7 ? $tahunAwal : $tahunAkhir;
        }

        // Filter Bulan/Periode bersifat kumulatif dari awal Tahun Ajaran (Juli)
        // sampai bulan/tahun yang dipilih. Jika tidak memilih bulan, gunakan Juli-Juni penuh.
        $periodeAwalKey = ($tahunAwal * 100) + 7;
        $periodeAkhirKey = ($tahunAkhir * 100) + 6;
        $bulanTahunFilter = $bulanTahunAjaran;

        if ($bulan > 0 && $tahun > 0) {
            $periodePilihanKey = ($tahun * 100) + $bulan;
            $periodeDitemukan = false;
            $bulanTahunFilter = array();

            foreach ($bulanTahunAjaran as $item) {
                $bulanTahunFilter[] = $item;
                if ((int) $item['bulan'] === $bulan && (int) $item['tahun'] === $tahun) {
                    $periodeDitemukan = true;
                    $periodeAkhirKey = $periodePilihanKey;
                    break;
                }
            }

            if (!$periodeDitemukan) {
                return array('result' => 'false', 'message' => 'Bulan/periode tidak sesuai dengan Tahun Ajaran yang dipilih.');
            }
        }

        $periodeAkhirItem = !empty($bulanTahunFilter) ? $bulanTahunFilter[count($bulanTahunFilter) - 1] : array('nama' => 'Juni', 'tahun' => $tahunAkhir);
        $labelPeriodeFilter = 'Juli ' . $tahunAwal . ' s.d. ' . $periodeAkhirItem['nama'] . ' ' . $periodeAkhirItem['tahun'];

        $tanggalMulaiFilter = '01-07-' . $tahunAwal;
        $akhirFilter = DateTime::createFromFormat('!Y-n-j', (int) ($periodeAkhirKey / 100) . '-' . ($periodeAkhirKey % 100) . '-1');
        $tanggalSampaiFilter = '30-06-' . $tahunAkhir;
        if ($akhirFilter) {
            $akhirFilter->modify('last day of this month');
            $tanggalSampaiFilter = $akhirFilter->format('d-m-Y');
        }

        // Untuk tunggakan, tanggal acuan tidak boleh melewati hari ini agar tagihan masa depan
        // tidak dianggap menunggak hanya karena pengguna memilih periode yang lebih jauh.
        $tanggalAcuan = $tanggalSampaiFilter;
        $hariIni = new DateTime('today');
        $tanggalAcuanObj = DateTime::createFromFormat('!d-m-Y', $tanggalAcuan);
        if ($tanggalAcuanObj && $tanggalAcuanObj > $hariIni) {
            $tanggalAcuan = $hariIni->format('d-m-Y');
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

        // Total Tagihan tetap memakai nominal tagihan yang diterbitkan kepada siswa,
        // tetapi hanya tagihan siswa yang masih aktif yang dihitung pada ringkasan Dashboard.
        // Pembayaran historis tetap dihitung terpisah dari tabel transaksi.
        $tagihanWhere = "ts.id_periode = ?
            AND ((CAST(ts.tahun AS UNSIGNED) * 100) + CAST(ts.bulan AS UNSIGNED)) BETWEEN ? AND ?";
        $tagihanParams = array($idPeriode, $periodeAwalKey, $periodeAkhirKey);
        if ($idKelasSetting > 0) {
            $tagihanWhere .= ' AND ts.id_kelas_setting = ?';
            $tagihanParams[] = $idKelasSetting;
        }

        $summary = $this->db->query(
            "SELECT
                COALESCE(SUM(CASE
                    WHEN ts.status_tagihan = 'Aktif' THEN ts.nominal_tagihan
                    ELSE 0
                END), 0) AS total_tagihan,
                COALESCE(SUM(CASE WHEN ts.status_tagihan = 'Aktif' AND ts.status_pembayaran = 'Lunas' THEN 1 ELSE 0 END), 0) AS sudah_lunas,
                COALESCE(SUM(CASE WHEN ts.status_tagihan = 'Aktif' AND ts.status_pembayaran = 'Belum Dibayar' THEN 1 ELSE 0 END), 0) AS belum_lunas,
                COALESCE(SUM(CASE WHEN ts.status_tagihan = 'Aktif' AND ts.status_pembayaran = 'Dibayar Sebagian' THEN 1 ELSE 0 END), 0) AS cicilan_aktif
             FROM tagihan_siswa ts
             WHERE {$tagihanWhere}",
            $tagihanParams
        )->row_array();

        // Tunggakan adalah sisa kewajiban yang masih aktif, wajib menjadi tunggakan,
        // dan jatuh temponya sudah tercapai pada tanggal acuan. Pembayaran sebagian hanya
        // menyumbang sisa_tagihan, bukan nominal awal.
        $tunggakanWhere = "ts.id_periode = ?
            AND ((CAST(ts.tahun AS UNSIGNED) * 100) + CAST(ts.bulan AS UNSIGNED)) BETWEEN ? AND ?
            AND ts.status_tagihan = 'Aktif'
            AND ts.dianggap_tunggakan = 'Ya'
            AND ts.sisa_tagihan > 0
            AND ts.status_pembayaran NOT IN ('Lunas', 'Dibebaskan', 'Dibatalkan')
            AND STR_TO_DATE(ts.tanggal_jatuh_tempo, '%d-%m-%Y') IS NOT NULL
            AND STR_TO_DATE(ts.tanggal_jatuh_tempo, '%d-%m-%Y') <= STR_TO_DATE(?, '%d-%m-%Y')";
        $tunggakanParams = array($idPeriode, $periodeAwalKey, $periodeAkhirKey, $tanggalAcuan);
        if ($idKelasSetting > 0) {
            $tunggakanWhere .= ' AND ts.id_kelas_setting = ?';
            $tunggakanParams[] = $idKelasSetting;
        }
        $tunggakanRow = $this->db->query(
            "SELECT COALESCE(SUM(ts.sisa_tagihan), 0) AS tunggakan
             FROM tagihan_siswa ts
             WHERE {$tunggakanWhere}",
            $tunggakanParams
        )->row_array();

        // Pembayaran Masuk murni berdasarkan transaksi uang yang masih aktif.
        // Tidak bergantung pada status tagihan setelah pembayaran (mis. Batalkan Sisa).
        $paymentWhere = "p.status_transaksi = 'Aktif'
            AND pd.status_detail = 'Aktif'
            AND ts.id_periode = ?
            AND STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y')";
        $paymentParams = array($idPeriode, $tanggalMulaiFilter, $tanggalSampaiFilter);
        if ($idKelasSetting > 0) {
            $paymentWhere .= ' AND ts.id_kelas_setting = ?';
            $paymentParams[] = $idKelasSetting;
        }

        $paymentSummary = $this->db->query(
            "SELECT COALESCE(SUM(pd.nominal_bayar), 0) AS pembayaran_masuk
             FROM tagihan_pembayaran p
             INNER JOIN tagihan_pembayaran_detail pd ON pd.id_pembayaran = p.id
             INNER JOIN tagihan_siswa ts ON ts.id = pd.id_tagihan_siswa
             WHERE {$paymentWhere}",
            $paymentParams
        )->row_array();

        $todayWhere = "p.status_transaksi = 'Aktif'
            AND pd.status_detail = 'Aktif'
            AND p.tanggal_transaksi = ?
            AND ts.id_periode = ?
            AND STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y') BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y')";
        $todayParams = array(date('d-m-Y'), $idPeriode, $tanggalMulaiFilter, $tanggalSampaiFilter);
        if ($idKelasSetting > 0) {
            $todayWhere .= ' AND ts.id_kelas_setting = ?';
            $todayParams[] = $idKelasSetting;
        }
        $todayRow = $this->db->query(
            "SELECT COUNT(DISTINCT p.id) AS transaksi_hari_ini
             FROM tagihan_pembayaran p
             INNER JOIN tagihan_pembayaran_detail pd ON pd.id_pembayaran = p.id
             INNER JOIN tagihan_siswa ts ON ts.id = pd.id_tagihan_siswa
             WHERE {$todayWhere}",
            $todayParams
        )->row_array();

        $chart = array();
        foreach ($bulanTahunFilter as $item) {
            $params = array($idPeriode, $item['bulan'], $item['tahun']);
            $extra = '';
            if ($idKelasSetting > 0) {
                $extra = ' AND ts.id_kelas_setting = ?';
                $params[] = $idKelasSetting;
            }

            $row = $this->db->query(
                "SELECT COALESCE(SUM(pd.nominal_bayar), 0) AS total
                 FROM tagihan_pembayaran p
                 INNER JOIN tagihan_pembayaran_detail pd ON pd.id_pembayaran = p.id
                 INNER JOIN tagihan_siswa ts ON ts.id = pd.id_tagihan_siswa
                 WHERE ts.id_periode = ?
                   AND p.status_transaksi = 'Aktif'
                   AND pd.status_detail = 'Aktif'
                   AND MONTH(STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y')) = ?
                   AND YEAR(STR_TO_DATE(p.tanggal_transaksi, '%d-%m-%Y')) = ?
                   {$extra}",
                $params
            )->row_array();

            $chart[] = array('label' => $item['nama'] . ' ' . $item['tahun'], 'total' => (float) ($row['total'] ?? 0));
        }

        $jenis = $this->db->query(
            "SELECT ts.tipe_tagihan, COUNT(*) AS jumlah, COALESCE(SUM(ts.nominal_tagihan), 0) AS nominal
             FROM tagihan_siswa ts
             WHERE {$tagihanWhere}
               AND ts.status_tagihan = 'Aktif'
             GROUP BY ts.tipe_tagihan
             ORDER BY FIELD(ts.tipe_tagihan, 'Bulanan', 'Langsung', 'Tahunan'), ts.tipe_tagihan",
            $tagihanParams
        )->result_array();

        $statusWhere = $tagihanWhere . " AND ts.status_tagihan = 'Aktif' AND ts.status_pembayaran IN ('Lunas', 'Dibayar Sebagian', 'Belum Dibayar')";
        $statusRows = $this->db->query(
            "SELECT ts.status_pembayaran, COUNT(*) AS jumlah, COALESCE(SUM(ts.nominal_tagihan), 0) AS nominal
             FROM tagihan_siswa ts
             WHERE {$statusWhere}
             GROUP BY ts.status_pembayaran
             ORDER BY FIELD(ts.status_pembayaran, 'Lunas', 'Dibayar Sebagian', 'Belum Dibayar')",
            $tagihanParams
        )->result_array();

        $transaksi = $this->db->query(
            "SELECT p.id, p.no_transaksi, p.tanggal_transaksi, p.waktu_transaksi, p.nama_siswa,
                    COALESCE(NULLIF(GROUP_CONCAT(DISTINCT NULLIF(ts.nama_kelas, '') ORDER BY ts.nama_kelas SEPARATOR ', '), ''), '-') AS nama_kelas,
                    p.nama_metode_pembayaran, COALESCE(SUM(pd.nominal_bayar), 0) AS total_pembayaran, p.nama_user
             FROM tagihan_pembayaran p
             INNER JOIN tagihan_pembayaran_detail pd ON pd.id_pembayaran = p.id
             INNER JOIN tagihan_siswa ts ON ts.id = pd.id_tagihan_siswa
             WHERE {$paymentWhere}
             GROUP BY p.id, p.no_transaksi, p.tanggal_transaksi, p.waktu_transaksi, p.nama_siswa, p.nama_metode_pembayaran, p.nama_user
             ORDER BY STR_TO_DATE(CONCAT(p.tanggal_transaksi, ' ', p.waktu_transaksi), '%d-%m-%Y %H:%i:%s') DESC
             LIMIT 8",
            $paymentParams
        )->result_array();

        $prioritas = $this->db->query(
            "SELECT ts.id_siswa, ts.nama_siswa, ts.nama_kelas, COUNT(*) AS jumlah_tagihan,
                    COALESCE(SUM(ts.sisa_tagihan), 0) AS total_tunggakan
             FROM tagihan_siswa ts
             WHERE {$tunggakanWhere}
             GROUP BY ts.id_siswa, ts.nama_siswa, ts.nama_kelas
             ORDER BY total_tunggakan DESC, jumlah_tagihan DESC
             LIMIT 8",
            $tunggakanParams
        )->result_array();

        return array(
            'result' => 'true',
            'summary' => array(
                'siswa_aktif' => $siswaAktif,
                'total_tagihan' => (float) ($summary['total_tagihan'] ?? 0),
                'pembayaran_masuk' => (float) ($paymentSummary['pembayaran_masuk'] ?? 0),
                'tunggakan' => (float) ($tunggakanRow['tunggakan'] ?? 0),
                'sudah_lunas' => (int) ($summary['sudah_lunas'] ?? 0),
                'belum_lunas' => (int) ($summary['belum_lunas'] ?? 0),
                'cicilan_aktif' => (int) ($summary['cicilan_aktif'] ?? 0),
                'transaksi_hari_ini' => (int) ($todayRow['transaksi_hari_ini'] ?? 0)
            ),
            'chart' => $chart,
            'jenis' => $jenis,
            'status' => $statusRows,
            'transaksi' => $transaksi,
            'prioritas' => $prioritas,
            'tanggal_acuan_tunggakan' => $tanggalAcuan,
            'periode_filter' => array(
                'mulai' => $tanggalMulaiFilter,
                'sampai' => $tanggalSampaiFilter,
                'label' => $labelPeriodeFilter
            )
        );
    }
}
