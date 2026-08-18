<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('admin')['username'] == null) {
            redirect('/');
        }
    }

    public function index()
    {
        $data['title'] = 'Laporan';
        $data['periode'] = $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
        $data['kelas'] = $this->db->order_by('nama_kelas')->get('kelas_setting')->result_array();
        $data['jenis'] = $this->db->where('status', 'Aktif')->order_by('nama_jenis')->get('tagihan_jenis')->result_array();
        $data['metode'] = $this->db->where('status', 'Aktif')->order_by('nama_metode')->get('tagihan_metode_pembayaran')->result_array();

        $tahun = array();
        $tahun_sekarang = (int) date('Y');
        for ($i = $tahun_sekarang - 5; $i <= $tahun_sekarang + 2; $i++) {
            $tahun[$i] = $i;
        }
        foreach ($data['periode'] as $row) {
            if (preg_match_all('/\d{4}/', isset($row['periode']) ? $row['periode'] : '', $m)) {
                foreach ($m[0] as $th) {
                    $tahun[(int) $th] = (int) $th;
                }
            }
        }
        ksort($tahun);
        $data['tahun_kalender'] = array_values($tahun);

        $this->load->view('admin/template/header', $data);
        $this->load->view('admin/laporan', $data);
        $this->load->view('admin/template/footer');
    }

    public function laporan_result()
    {
        $id_level = (int) $this->session->userdata('admin')['id_level'];
        $search = trim((string) $this->input->post('search', true));

        $sql = "SELECT a.*
                FROM list_menu a
                LEFT JOIN menu b ON a.id_menu=b.id
                WHERE a.id_level=? AND a.`group`='Laporan'";
        $params = array($id_level);
        if ($search !== '') {
            $sql .= " AND a.name LIKE ?";
            $params[] = '%' . $search . '%';
        }
        $sql .= " ORDER BY b.urut ASC,a.id_menu ASC";
        $menu = $this->db->query($sql, $params)->result_array();

        // Tiga menu pembayaran pada database lama digabung menjadi satu laporan.
        $data = array();
        $pembayaran = null;
        foreach ($menu as $row) {
            $id_menu = (int) $row['id_menu'];
            if (in_array($id_menu, array(31, 32, 33), true)) {
                if ($pembayaran === null || $id_menu === 31) {
                    $pembayaran = array(
                        'key' => 'pembayaran',
                        'name' => 'Laporan Pembayaran',
                        'path' => $row['path'],
                        'id_menu' => 31,
                        'urut' => 1
                    );
                }
                continue;
            }

            $map = array(
                34 => array('key' => 'per_kelas', 'name' => 'Rekap Pembayaran Per Kelas', 'urut' => 2),
                35 => array('key' => 'per_jenis', 'name' => 'Rekap Pembayaran Per Jenis', 'urut' => 3),
                36 => array('key' => 'tunggakan', 'name' => 'Laporan Tunggakan', 'urut' => 4),
                37 => array('key' => 'pembatalan', 'name' => 'Riwayat Pembatalan', 'urut' => 5)
            );
            if (!isset($map[$id_menu])) {
                continue;
            }
            $data[] = array(
                'key' => $map[$id_menu]['key'],
                'name' => $map[$id_menu]['name'],
                'path' => $row['path'],
                'id_menu' => $id_menu,
                'urut' => $map[$id_menu]['urut']
            );
        }
        if ($pembayaran !== null) {
            $data[] = $pembayaran;
        }

        usort($data, function ($a, $b) {
            return (int) $a['urut'] <=> (int) $b['urut'];
        });

        // Search "Laporan Pembayaran" tetap menemukan laporan gabungan walaupun nama DB masih Harian/Bulanan/Tahunan.
        if ($search !== '' && stripos('Laporan Pembayaran', $search) !== false) {
            $ada = false;
            foreach ($data as $row) {
                if ($row['key'] === 'pembayaran') {
                    $ada = true;
                    break;
                }
            }
            if (!$ada) {
                $row = $this->db->query(
                    "SELECT a.* FROM list_menu a WHERE a.id_level=? AND a.`group`='Laporan' AND a.id_menu IN (31,32,33) ORDER BY FIELD(a.id_menu,31,32,33) LIMIT 1",
                    array($id_level)
                )->row_array();
                if ($row) {
                    array_unshift($data, array(
                        'key' => 'pembayaran',
                        'name' => 'Laporan Pembayaran',
                        'path' => $row['path'],
                        'id_menu' => 31,
                        'urut' => 1
                    ));
                }
            }
        }

        echo json_encode($data);
    }

    public function kelas_result()
    {
        $periode = (int) $this->input->post('periode');
        $sql = "SELECT id,nama_kelas,id_periode FROM kelas_setting WHERE 1=1";
        $params = array();
        if ($periode) {
            $sql .= " AND id_periode=?";
            $params[] = $periode;
        }
        $sql .= " ORDER BY nama_kelas ASC";
        echo json_encode(array('result' => 'true', 'data' => $this->db->query($sql, $params)->result_array()));
    }

    public function laporan_pembayaran()
    {
        $filter = (string) $this->input->post('filter');
        $periode = (int) $this->input->post('periode');
        $kelas = (int) $this->input->post('kelas');
        $jenis = (int) $this->input->post('jenis');
        $metode = (int) $this->input->post('metode');
        $petugas = trim((string) $this->input->post('petugas', true));
        $status = trim((string) $this->input->post('status', true));
        if ($status === '') $status = 'Aktif';

        if ($filter === 'bulan') {
            $bulan = (int) $this->input->post('bulan');
            $tahun = (int) $this->input->post('tahun');

            $where_target = array("ts.status_tagihan='Aktif'", 'ts.bulan=?', 'ts.tahun=?');
            $param_target = array($bulan, $tahun);
            if ($periode) {
                $where_target[] = 'ts.id_periode=?';
                $param_target[] = $periode;
            }
            if ($kelas) {
                $where_target[] = 'ts.id_kelas_setting=?';
                $param_target[] = $kelas;
            }
            if ($jenis) {
                $where_target[] = 'ts.id_jenis_tagihan=?';
                $param_target[] = $jenis;
            }

            $target = (float) $this->db->query(
                "SELECT COALESCE(SUM(ts.nominal_tagihan),0) total FROM tagihan_siswa ts WHERE " . implode(' AND ', $where_target),
                $param_target
            )->row()->total;

            $sql = "SELECT p.tanggal_transaksi AS tanggal,
                           ts.nama_jenis_tagihan AS jenis_tagihan,
                           COUNT(DISTINCT p.id) AS jumlah_transaksi,
                           COALESCE(SUM(d.nominal_bayar),0) AS total_pembayaran
                    FROM tagihan_pembayaran p
                    JOIN tagihan_pembayaran_detail d ON d.id_pembayaran=p.id AND d.status_detail='Aktif'
                    JOIN tagihan_siswa ts ON ts.id=d.id_tagihan_siswa
                    WHERE MONTH(STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'))=?
                      AND YEAR(STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'))=?";
            $params = array($bulan, $tahun);
            if ($periode) {
                $sql .= ' AND ts.id_periode=?';
                $params[] = $periode;
            }
            if ($kelas) {
                $sql .= ' AND ts.id_kelas_setting=?';
                $params[] = $kelas;
            }
            if ($jenis) {
                $sql .= ' AND ts.id_jenis_tagihan=?';
                $params[] = $jenis;
            }
            if ($metode) {
                $sql .= ' AND p.id_metode_pembayaran=?';
                $params[] = $metode;
            }
            if ($petugas !== '') {
                $sql .= ' AND p.nama_user LIKE ?';
                $params[] = '%' . $petugas . '%';
            }
            if ($status !== 'Semua') {
                $sql .= ' AND p.status_transaksi=?';
                $params[] = $status;
            }
            $sql .= " GROUP BY p.tanggal_transaksi,ts.nama_jenis_tagihan
                      ORDER BY STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y') ASC,ts.nama_jenis_tagihan ASC";

            $rows = $this->db->query($sql, $params)->result_array();
            $total_bayar = 0;
            foreach ($rows as $row) $total_bayar += (float) $row['total_pembayaran'];
            $sisa = max(0, $target - $total_bayar);

            echo json_encode(array(
                'result' => 'true',
                'title' => 'Laporan Pembayaran',
                'columns' => array('tanggal' => 'Tanggal', 'jenis_tagihan' => 'Jenis Tagihan', 'jumlah_transaksi' => 'Jumlah Transaksi', 'total_pembayaran' => 'Total Pembayaran'),
                'money' => array('total_pembayaran'),
                'rows' => $rows,
                'summary' => array('Target Tagihan' => $target, 'Pembayaran Masuk' => $total_bayar, 'Sisa' => $sisa, 'Realisasi (%)' => $target > 0 ? round(($total_bayar / $target) * 100, 2) : 0),
                'filters' => array(
                    'Periode' => $this->periode_label('bulan'),
                    'Tahun Ajaran' => $this->nama_tahun_ajaran($periode),
                    'Kelas' => $this->nama_kelas($kelas),
                    'Jenis Tagihan' => $this->nama_jenis($jenis),
                    'Metode' => $this->nama_metode($metode),
                    'Petugas' => $petugas !== '' ? $petugas : 'Semua Petugas',
                    'Status' => $status
                )
            ));
            return;
        }

        if ($filter === 'tahun') {
            $tahun = (int) $this->input->post('tahun');
            $nama_bulan = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
            $rows = array();
            $total_target = 0;
            $total_bayar = 0;
            $total_sisa = 0;

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $where_target = array("ts.status_tagihan='Aktif'", 'ts.bulan=?', 'ts.tahun=?');
                $param_target = array($bulan, $tahun);
                if ($periode) {
                    $where_target[] = 'ts.id_periode=?';
                    $param_target[] = $periode;
                }
                if ($kelas) {
                    $where_target[] = 'ts.id_kelas_setting=?';
                    $param_target[] = $kelas;
                }
                if ($jenis) {
                    $where_target[] = 'ts.id_jenis_tagihan=?';
                    $param_target[] = $jenis;
                }
                $target = (float) $this->db->query(
                    "SELECT COALESCE(SUM(ts.nominal_tagihan),0) total FROM tagihan_siswa ts WHERE " . implode(' AND ', $where_target),
                    $param_target
                )->row()->total;

                $sql_bayar = "SELECT COALESCE(SUM(d.nominal_bayar),0) total
                              FROM tagihan_pembayaran p
                              JOIN tagihan_pembayaran_detail d ON d.id_pembayaran=p.id AND d.status_detail='Aktif'
                              JOIN tagihan_siswa ts ON ts.id=d.id_tagihan_siswa
                              WHERE ts.bulan=? AND ts.tahun=?";
                $param_bayar = array($bulan, $tahun);
                if ($periode) {
                    $sql_bayar .= ' AND ts.id_periode=?';
                    $param_bayar[] = $periode;
                }
                if ($kelas) {
                    $sql_bayar .= ' AND ts.id_kelas_setting=?';
                    $param_bayar[] = $kelas;
                }
                if ($jenis) {
                    $sql_bayar .= ' AND ts.id_jenis_tagihan=?';
                    $param_bayar[] = $jenis;
                }
                if ($metode) {
                    $sql_bayar .= ' AND p.id_metode_pembayaran=?';
                    $param_bayar[] = $metode;
                }
                if ($petugas !== '') {
                    $sql_bayar .= ' AND p.nama_user LIKE ?';
                    $param_bayar[] = '%' . $petugas . '%';
                }
                if ($status !== 'Semua') {
                    $sql_bayar .= ' AND p.status_transaksi=?';
                    $param_bayar[] = $status;
                }
                $bayar = (float) $this->db->query($sql_bayar, $param_bayar)->row()->total;
                $sisa = max(0, $target - $bayar);

                $rows[] = array(
                    'bulan' => $nama_bulan[$bulan],
                    'target' => $target,
                    'pembayaran' => $bayar,
                    'sisa' => $sisa,
                    'realisasi' => $target > 0 ? round(($bayar / $target) * 100, 2) : 0
                );
                $total_target += $target;
                $total_bayar += $bayar;
                $total_sisa += $sisa;
            }

            echo json_encode(array(
                'result' => 'true',
                'title' => 'Laporan Pembayaran',
                'columns' => array('bulan' => 'Bulan', 'target' => 'Target', 'pembayaran' => 'Pembayaran', 'sisa' => 'Sisa', 'realisasi' => 'Realisasi (%)'),
                'money' => array('target', 'pembayaran', 'sisa'),
                'rows' => $rows,
                'summary' => array('Total Target' => $total_target, 'Total Pembayaran' => $total_bayar, 'Total Sisa' => $total_sisa, 'Realisasi (%)' => $total_target > 0 ? round(($total_bayar / $total_target) * 100, 2) : 0),
                'filters' => array(
                    'Periode' => $this->periode_label('tahun'),
                    'Tahun Ajaran' => $this->nama_tahun_ajaran($periode),
                    'Kelas' => $this->nama_kelas($kelas),
                    'Jenis Tagihan' => $this->nama_jenis($jenis),
                    'Metode' => $this->nama_metode($metode),
                    'Petugas' => $petugas !== '' ? $petugas : 'Semua Petugas',
                    'Status' => $status
                )
            ));
            return;
        }

        // Hari
        $awal = (string) $this->input->post('dari_tanggal');
        $akhir = (string) $this->input->post('sampai_tanggal');
        if ($awal === '') $awal = date('Y-m-d');
        if ($akhir === '') $akhir = $awal;

        $sql = "SELECT p.tanggal_transaksi,p.waktu_transaksi,p.no_transaksi,p.nama_siswa,p.nama_kelas,
                       p.nama_metode_pembayaran,p.nama_user,p.total_pembayaran,p.status_transaksi
                FROM tagihan_pembayaran p
                WHERE STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y') BETWEEN ? AND ?";
        $params = array($awal, $akhir);
        if ($periode) {
            $sql .= ' AND p.id_periode=?';
            $params[] = $periode;
        }
        if ($kelas) {
            $sql .= ' AND p.id_kelas_setting=?';
            $params[] = $kelas;
        }
        if ($metode) {
            $sql .= ' AND p.id_metode_pembayaran=?';
            $params[] = $metode;
        }
        if ($petugas !== '') {
            $sql .= ' AND p.nama_user LIKE ?';
            $params[] = '%' . $petugas . '%';
        }
        if ($status !== 'Semua') {
            $sql .= ' AND p.status_transaksi=?';
            $params[] = $status;
        }
        if ($jenis) {
            $sql .= " AND EXISTS (
                        SELECT 1 FROM tagihan_pembayaran_detail d
                        JOIN tagihan_siswa ts ON ts.id=d.id_tagihan_siswa
                        WHERE d.id_pembayaran=p.id AND d.status_detail='Aktif' AND ts.id_jenis_tagihan=?
                      )";
            $params[] = $jenis;
        }
        $sql .= " ORDER BY STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y') ASC,p.waktu_transaksi ASC";
        $rows = $this->db->query($sql, $params)->result_array();
        $total = 0;
        foreach ($rows as $row) {
            if ($row['status_transaksi'] === 'Aktif') $total += (float) $row['total_pembayaran'];
        }

        echo json_encode(array(
            'result' => 'true',
            'title' => 'Laporan Pembayaran',
            'columns' => array(
                'tanggal_transaksi' => 'Tanggal',
                'waktu_transaksi' => 'Waktu',
                'no_transaksi' => 'No Transaksi',
                'nama_siswa' => 'Siswa',
                'nama_kelas' => 'Kelas',
                'nama_metode_pembayaran' => 'Metode',
                'nama_user' => 'Petugas',
                'total_pembayaran' => 'Total',
                'status_transaksi' => 'Status'
            ),
            'money' => array('total_pembayaran'),
            'rows' => $rows,
            'summary' => array('Jumlah Transaksi' => count($rows), 'Total Pembayaran' => $total),
            // Sesuai keputusan sebelumnya: bagian kiri cetak/Excel harian cukup tanggal/periode dan status.
            'filters' => array('Periode' => $this->periode_label('tanggal'), 'Status' => $status)
        ));
    }

    public function laporan_rekap_per_kelas()
    {
        $filter = (string) $this->input->post('filter');
        $periode = (int) $this->input->post('periode');
        $jenis = (int) $this->input->post('jenis');

        $sql = "SELECT ts.id_kelas_setting,ts.nama_kelas,
                       COUNT(DISTINCT ts.id_siswa) AS jumlah_siswa,
                       COALESCE(SUM(ts.nominal_tagihan),0) AS target,
                       COALESCE(SUM(ts.nominal_dibayar),0) AS pembayaran,
                       COALESCE(SUM(CASE WHEN ts.dianggap_tunggakan='Ya'
                                         AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
                                    THEN ts.sisa_tagihan ELSE 0 END),0) AS tunggakan
                FROM tagihan_siswa ts
                WHERE ts.status_tagihan='Aktif'";
        $params = array();

        if ($filter === 'bulan') {
            $sql .= ' AND ts.bulan=? AND ts.tahun=?';
            $params[] = (int) $this->input->post('bulan');
            $params[] = (int) $this->input->post('tahun');
        } elseif ($filter === 'tahun') {
            $sql .= ' AND ts.tahun=?';
            $params[] = (int) $this->input->post('tahun');
        } else {
            $awal = (string) $this->input->post('dari_tanggal');
            $akhir = (string) $this->input->post('sampai_tanggal');
            if ($awal === '') $awal = date('Y-m-d');
            if ($akhir === '') $akhir = $awal;
            $sql .= " AND STR_TO_DATE(ts.tanggal_generate,'%d-%m-%Y') BETWEEN ? AND ?";
            $params[] = $awal;
            $params[] = $akhir;
        }

        if ($periode) {
            $sql .= ' AND ts.id_periode=?';
            $params[] = $periode;
        }
        if ($jenis) {
            $sql .= ' AND ts.id_jenis_tagihan=?';
            $params[] = $jenis;
        }
        $sql .= ' GROUP BY ts.id_kelas_setting,ts.nama_kelas ORDER BY ts.nama_kelas ASC';

        $rows = $this->db->query($sql, $params)->result_array();
        $total_target = 0;
        $total_bayar = 0;
        $total_tunggakan = 0;
        foreach ($rows as &$row) {
            $row['target'] = (float) $row['target'];
            $row['pembayaran'] = (float) $row['pembayaran'];
            $row['tunggakan'] = (float) $row['tunggakan'];
            $row['realisasi'] = $row['target'] > 0 ? round(($row['pembayaran'] / $row['target']) * 100, 2) : 0;
            $total_target += $row['target'];
            $total_bayar += $row['pembayaran'];
            $total_tunggakan += $row['tunggakan'];
        }
        unset($row);

        echo json_encode(array(
            'result' => 'true',
            'title' => 'Rekap Pembayaran Per Kelas',
            'columns' => array('nama_kelas' => 'Kelas', 'jumlah_siswa' => 'Jumlah Siswa', 'target' => 'Target', 'pembayaran' => 'Pembayaran', 'tunggakan' => 'Tunggakan', 'realisasi' => 'Realisasi (%)'),
            'money' => array('target', 'pembayaran', 'tunggakan'),
            'rows' => $rows,
            'summary' => array('Total Target' => $total_target, 'Total Pembayaran' => $total_bayar, 'Total Tunggakan' => $total_tunggakan),
            'filters' => array('Periode' => $this->periode_label($filter), 'Tahun Ajaran' => $this->nama_tahun_ajaran($periode), 'Jenis Tagihan' => $this->nama_jenis($jenis))
        ));
    }

    public function laporan_rekap_per_jenis()
    {
        // Sesuai wireframe: Tahun Ajaran + Kelas + Periode. Tidak memakai radio Hari/Bulan/Tahun.
        $periode = (int) $this->input->post('periode');
        $kelas = (int) $this->input->post('kelas');
        $periode_jenis = (int) $this->input->post('periode_jenis');

        $sql = "SELECT ts.id_jenis_tagihan,ts.nama_jenis_tagihan AS jenis,ts.tipe_tagihan AS tipe,
                       ts.dianggap_tunggakan AS wajib,COUNT(DISTINCT ts.id_siswa) AS jumlah_siswa,
                       COALESCE(SUM(ts.nominal_tagihan),0) AS total_tagihan,
                       COALESCE(SUM(ts.nominal_dibayar),0) AS dibayar,
                       COALESCE(SUM(ts.sisa_tagihan),0) AS sisa
                FROM tagihan_siswa ts
                WHERE ts.status_tagihan='Aktif'";
        $params = array();
        if ($periode) {
            $sql .= ' AND ts.id_periode=?';
            $params[] = $periode;
        }
        if ($kelas) {
            $sql .= ' AND ts.id_kelas_setting=?';
            $params[] = $kelas;
        }
        if ($periode_jenis) {
            $sql .= ' AND ts.bulan=?';
            $params[] = $periode_jenis;
        }
        $sql .= ' GROUP BY ts.id_jenis_tagihan,ts.nama_jenis_tagihan,ts.tipe_tagihan,ts.dianggap_tunggakan ORDER BY ts.nama_jenis_tagihan ASC';

        $rows = $this->db->query($sql, $params)->result_array();
        $total_tagihan = 0;
        $total_bayar = 0;
        $total_sisa = 0;
        foreach ($rows as &$row) {
            $row['total_tagihan'] = (float) $row['total_tagihan'];
            $row['dibayar'] = (float) $row['dibayar'];
            $row['sisa'] = (float) $row['sisa'];
            $row['realisasi'] = $row['total_tagihan'] > 0 ? round(($row['dibayar'] / $row['total_tagihan']) * 100, 2) : 0;
            $total_tagihan += $row['total_tagihan'];
            $total_bayar += $row['dibayar'];
            $total_sisa += $row['sisa'];
        }
        unset($row);

        echo json_encode(array(
            'result' => 'true',
            'title' => 'Rekap Pembayaran Per Jenis',
            'columns' => array('jenis' => 'Jenis', 'tipe' => 'Tipe', 'wajib' => 'Dihitung Tunggakan', 'jumlah_siswa' => 'Jumlah Siswa', 'total_tagihan' => 'Total Tagihan', 'dibayar' => 'Dibayar', 'sisa' => 'Sisa', 'realisasi' => 'Realisasi (%)'),
            'money' => array('total_tagihan', 'dibayar', 'sisa'),
            'rows' => $rows,
            'summary' => array('Total Tagihan' => $total_tagihan, 'Total Dibayar' => $total_bayar, 'Total Sisa' => $total_sisa),
            'filters' => array('Tahun Ajaran' => $this->nama_tahun_ajaran($periode), 'Kelas' => $this->nama_kelas($kelas), 'Periode' => $this->nama_bulan($periode_jenis, 'Semua Periode'))
        ));
    }

    public function laporan_tunggakan()
    {
        $filter = (string) $this->input->post('filter');
        $periode = (int) $this->input->post('periode');
        $kelas = (int) $this->input->post('kelas');
        $jenis = (int) $this->input->post('jenis');
        $status_siswa = trim((string) $this->input->post('status_siswa', true));
        if ($status_siswa === '') $status_siswa = 'Aktif';

        $sql = "SELECT ts.id_siswa,ts.nis,ts.nama_siswa,
                       COALESCE(cur.nama_kelas,ts.nama_kelas,'-') AS nama_kelas,
                       ts.periode AS tahun_asal,COUNT(ts.id) AS jumlah_tagihan,
                       COALESCE(SUM(ts.sisa_tagihan),0) AS total_tunggakan,
                       MAX(COALESCE(NULLIF(s.telepon_ayah,''),s.telepon_ibu,'')) AS no_wali
                FROM tagihan_siswa ts
                JOIN siswa s ON s.id=ts.id_siswa
                LEFT JOIN kelas_siswa ks_cur ON ks_cur.id=(
                    SELECT MAX(ks2.id) FROM kelas_siswa ks2
                    WHERE CAST(ks2.id_siswa AS UNSIGNED)=ts.id_siswa AND ks2.status_aktif='1'
                )
                LEFT JOIN kelas_setting cur ON cur.id=CAST(ks_cur.id_kelas_setting AS UNSIGNED)
                WHERE ts.dianggap_tunggakan='Ya'
                  AND ts.status_tagihan='Aktif'
                  AND ts.sisa_tagihan>0
                  AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')";
        $params = array();
        if ($filter === 'bulan') {
            $sql .= ' AND ts.bulan=? AND ts.tahun=?';
            $params[] = (int) $this->input->post('bulan');
            $params[] = (int) $this->input->post('tahun');
        } elseif ($filter === 'tahun') {
            $sql .= ' AND ts.tahun=?';
            $params[] = (int) $this->input->post('tahun');
        } else {
            $awal = (string) $this->input->post('dari_tanggal');
            $akhir = (string) $this->input->post('sampai_tanggal');
            if ($awal === '') $awal = date('Y-m-d');
            if ($akhir === '') $akhir = $awal;
            $sql .= " AND STR_TO_DATE(ts.tanggal_generate,'%d-%m-%Y') BETWEEN ? AND ?";
            $params[] = $awal;
            $params[] = $akhir;
        }
        if ($periode) {
            $sql .= ' AND ts.id_periode=?';
            $params[] = $periode;
        }
        if ($kelas) {
            $sql .= ' AND COALESCE(cur.id,ts.id_kelas_setting)=?';
            $params[] = $kelas;
        }
        if ($jenis) {
            $sql .= ' AND ts.id_jenis_tagihan=?';
            $params[] = $jenis;
        }
        if ($status_siswa !== 'Semua') {
            $sql .= ' AND s.status_pendaftaran=?';
            $params[] = $status_siswa;
        }
        $sql .= ' GROUP BY ts.id_siswa,ts.nis,ts.nama_siswa,cur.nama_kelas,ts.nama_kelas,ts.periode ORDER BY total_tunggakan DESC,ts.nama_siswa ASC';

        $rows = $this->db->query($sql, $params)->result_array();
        $total = 0;
        foreach ($rows as $row) $total += (float) $row['total_tunggakan'];

        echo json_encode(array(
            'result' => 'true',
            'title' => 'Laporan Tunggakan',
            'columns' => array('nama_siswa' => 'Siswa', 'nis' => 'NIS', 'nama_kelas' => 'Kelas Saat Ini', 'tahun_asal' => 'Tahun Asal', 'jumlah_tagihan' => 'Jumlah Tagihan', 'total_tunggakan' => 'Total Tunggakan', 'no_wali' => 'No Wali'),
            'money' => array('total_tunggakan'),
            'rows' => $rows,
            'summary' => array('Jumlah Siswa' => count($rows), 'Total Tunggakan' => $total),
            'filters' => array('Periode' => $this->periode_label($filter), 'Tahun Ajaran' => $this->nama_tahun_ajaran($periode), 'Kelas' => $this->nama_kelas($kelas), 'Jenis Tagihan' => $this->nama_jenis($jenis), 'Status Siswa' => $status_siswa)
        ));
    }

    public function laporan_riwayat_pembatalan()
    {
        $filter = (string) $this->input->post('filter');
        $q = trim((string) $this->input->post('q', true));
        $petugas = trim((string) $this->input->post('petugas', true));

        $sql = "SELECT c.no_transaksi AS no_asli,c.nama_siswa,c.total_pembayaran AS nominal,
                       c.nama_user_transaksi AS pembuat,c.nama_user_pembatalan AS pembatal,
                       CONCAT(c.tanggal_pembatalan,' ',c.waktu_pembatalan) AS waktu,
                       c.alasan_pembatalan AS alasan
                FROM tagihan_pembatalan_transaksi c
                WHERE 1=1";
        $params = array();
        if ($filter === 'bulan') {
            $sql .= " AND MONTH(STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y'))=? AND YEAR(STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y'))=?";
            $params[] = (int) $this->input->post('bulan');
            $params[] = (int) $this->input->post('tahun');
        } elseif ($filter === 'tahun') {
            $sql .= " AND YEAR(STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y'))=?";
            $params[] = (int) $this->input->post('tahun');
        } else {
            $awal = (string) $this->input->post('dari_tanggal');
            $akhir = (string) $this->input->post('sampai_tanggal');
            if ($awal === '') $awal = date('Y-m-d');
            if ($akhir === '') $akhir = $awal;
            $sql .= " AND STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y') BETWEEN ? AND ?";
            $params[] = $awal;
            $params[] = $akhir;
        }
        if ($q !== '') {
            $sql .= ' AND (c.no_transaksi LIKE ? OR c.nama_siswa LIKE ?)';
            $params[] = '%' . $q . '%';
            $params[] = '%' . $q . '%';
        }
        if ($petugas !== '') {
            $sql .= ' AND c.nama_user_pembatalan LIKE ?';
            $params[] = '%' . $petugas . '%';
        }
        $sql .= " ORDER BY STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y') DESC,c.waktu_pembatalan DESC";

        $rows = $this->db->query($sql, $params)->result_array();
        $total = 0;
        foreach ($rows as $row) $total += (float) $row['nominal'];

        echo json_encode(array(
            'result' => 'true',
            'title' => 'Riwayat Pembatalan',
            'columns' => array('no_asli' => 'No Asli', 'nama_siswa' => 'Siswa', 'nominal' => 'Nominal', 'pembuat' => 'Pembuat', 'pembatal' => 'Pembatal', 'waktu' => 'Waktu', 'alasan' => 'Alasan'),
            'money' => array('nominal'),
            'rows' => $rows,
            'summary' => array('Jumlah Pembatalan' => count($rows), 'Total Dibatalkan' => $total),
            'filters' => array('Periode' => $this->periode_label($filter), 'Pencarian' => $q !== '' ? $q : '-', 'Petugas Pembatal' => $petugas !== '' ? $petugas : 'Semua Petugas')
        ));
    }

    private function periode_label($filter)
    {
        if ($filter === 'bulan') {
            return $this->nama_bulan((int) $this->input->post('bulan'), '-') . ' ' . (int) $this->input->post('tahun');
        }
        if ($filter === 'tahun') {
            return (string) (int) $this->input->post('tahun');
        }
        $awal = (string) $this->input->post('dari_tanggal');
        $akhir = (string) $this->input->post('sampai_tanggal');
        if ($awal === '') $awal = date('Y-m-d');
        if ($akhir === '') $akhir = $awal;
        $awal_tampil = date('d-m-Y', strtotime($awal));
        $akhir_tampil = date('d-m-Y', strtotime($akhir));
        return $awal_tampil === $akhir_tampil ? $awal_tampil : $awal_tampil . ' s/d ' . $akhir_tampil;
    }

    private function nama_bulan($bulan, $default = '-')
    {
        $list = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
        return isset($list[(int) $bulan]) ? $list[(int) $bulan] : $default;
    }

    private function nama_tahun_ajaran($id)
    {
        if (!$id) return 'Semua Tahun Ajaran';
        $row = $this->db->select('periode')->where('id', (int) $id)->get('master_tahun_ajaran')->row_array();
        return $row ? $row['periode'] : '-';
    }

    private function nama_kelas($id)
    {
        if (!$id) return 'Semua Kelas';
        $row = $this->db->select('nama_kelas')->where('id', (int) $id)->get('kelas_setting')->row_array();
        return $row ? $row['nama_kelas'] : '-';
    }

    private function nama_jenis($id)
    {
        if (!$id) return 'Semua Jenis';
        $row = $this->db->select('nama_jenis')->where('id', (int) $id)->get('tagihan_jenis')->row_array();
        return $row ? $row['nama_jenis'] : '-';
    }

    private function nama_metode($id)
    {
        if (!$id) return 'Semua Metode';
        $row = $this->db->select('nama_metode')->where('id', (int) $id)->get('tagihan_metode_pembayaran')->row_array();
        return $row ? $row['nama_metode'] : '-';
    }
}
