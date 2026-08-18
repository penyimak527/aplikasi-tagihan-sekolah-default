<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_siswa_pembayar extends CI_Model
{
    public function tagihan_list()
    {
        return $this->db->where_in('status', array('Aktif', 'Draft'))->order_by('id', 'DESC')->get('tagihan_master')->result_array();
    }

    public function result()
    {
        $id = (int) $this->input->post('id_tagihan');
        $kelas = (int) $this->input->post('id_kelas_setting');
        $search = trim((string) $this->input->post('search', true));
        $status = trim((string) $this->input->post('status_tagihan', true));

        $m = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$m) {
            return array('result' => 'false', 'message' => 'Pilih tagihan.');
        }

        if (!in_array($status, array('', 'Aktif', 'Belum Ditambahkan'), true)) {
            $status = '';
        }

        $like = '%' . $search . '%';
        $current = array();
        $candidates = array();

        if ($status !== 'Belum Ditambahkan') {
            $sqlCurrent = "SELECT
                                ts.id_siswa,
                                ts.nis,
                                ts.nisn,
                                ts.nama_siswa,
                                ts.id_kelas_setting,
                                ts.nama_kelas,
                                COUNT(*) jumlah_baris,
                                MAX(ts.nominal_tagihan) tarif,
                                COALESCE(SUM(ts.nominal_dibayar),0) dibayar,
                                COALESCE(SUM(ts.sisa_tagihan),0) sisa,
                                CASE
                                    WHEN SUM(CASE WHEN ts.status_pembayaran='Dibebaskan' THEN 1 ELSE 0 END)=COUNT(*) THEN 'Dibebaskan'
                                    WHEN COALESCE(SUM(ts.sisa_tagihan),0)<=0 THEN 'Lunas'
                                    WHEN COALESCE(SUM(ts.nominal_dibayar),0)>0 THEN 'Dibayar Sebagian'
                                    ELSE 'Belum Dibayar'
                                END status_pembayaran,
                                'Aktif' status_penerima
                           FROM tagihan_siswa ts
                           WHERE ts.id_tagihan_master=?
                             AND (ts.nama_siswa LIKE ? OR ts.nis LIKE ? OR ts.nisn LIKE ?)";
            $paramsCurrent = array($id, $like, $like, $like);

            if ($kelas > 0) {
                $sqlCurrent .= " AND ts.id_kelas_setting=?";
                $paramsCurrent[] = $kelas;
            }

            $sqlCurrent .= " GROUP BY
                                ts.id_siswa,
                                ts.nis,
                                ts.nisn,
                                ts.nama_siswa,
                                ts.id_kelas_setting,
                                ts.nama_kelas
                             ORDER BY ts.nama_siswa";

            $current = $this->db->query($sqlCurrent, $paramsCurrent)->result_array();

            foreach ($current as &$row) {
                $row['bisa_dikeluarkan'] = (float) $row['dibayar'] <= 0 ? 1 : 0;
            }
            unset($row);
        }

        $periods = $this->db
            ->where('id_tagihan_master', $id)
            ->where('status', 'Aktif')
            ->order_by('tahun', 'ASC')
            ->order_by('bulan', 'ASC')
            ->get('tagihan_tarif_bulan')
            ->result_array();

        $classTargets = $this->db
            ->where('id_tagihan_master', $id)
            ->where('status', 'Aktif')
            ->get('tagihan_target_kelas')
            ->result_array();

        $classMap = array();
        foreach ($classTargets as $row) {
            $classMap[(int) $row['id_kelas_setting']] = $row;
        }

        if ($status !== 'Aktif') {
            $sql = "SELECT DISTINCT
                        s.id id_siswa,
                        s.nis,
                        s.nisn,
                        s.nama_lengkap nama_siswa,
                        k.id id_kelas_setting,
                        k.id_kelas,
                        k.nama_kelas
                    FROM siswa s
                    JOIN kelas_siswa ks
                        ON CAST(ks.id_siswa AS UNSIGNED)=s.id
                       AND ks.status_aktif='1'
                    JOIN kelas_setting k
                        ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED)
                    WHERE s.status_pendaftaran='Aktif'
                      AND CAST(k.id_periode AS UNSIGNED)=?
                      AND (s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ?)
                      AND NOT EXISTS(
                          SELECT 1
                          FROM tagihan_siswa t
                          WHERE t.id_tagihan_master=?
                            AND t.id_siswa=s.id
                      )";
            $params = array((int) $m['id_periode'], $like, $like, $like, $id);

            if ($kelas > 0) {
                $sql .= " AND k.id=?";
                $params[] = $kelas;
            }

            $sql .= " ORDER BY s.nama_lengkap LIMIT 500";
            $candidates = $this->db->query($sql, $params)->result_array();

            foreach ($candidates as &$row) {
                $row['tarif'] = $this->tarif_calon_siswa(
                    $id,
                    (int) $row['id_siswa'],
                    (int) $row['id_kelas_setting'],
                    $periods,
                    $classMap
                );
                $row['dibayar'] = 0;
                $row['sisa'] = (float) $row['tarif'];
                $row['status_pembayaran'] = '-';
                $row['status_penerima'] = 'Belum Ditambahkan';
            }
            unset($row);
        }

        $classes = $this->db->query(
            "SELECT id,id_kelas,nama_kelas,id_periode
             FROM kelas_setting
             WHERE CAST(id_periode AS UNSIGNED)=?
             ORDER BY nama_kelas",
            array((int) $m['id_periode'])
        )->result_array();

        return array(
            'result' => 'true',
            'master' => $m,
            'current' => $current,
            'candidates' => $candidates,
            'classes' => $classes
        );
    }

    public function export_rows($idTagihan, $idKelasSetting = 0, $search = '')
    {
        $idTagihan = (int) $idTagihan;
        $idKelasSetting = (int) $idKelasSetting;
        $search = trim((string) $search);
        $master = $this->db->where('id', $idTagihan)->get('tagihan_master')->row_array();

        if (!$master) {
            return array('master' => null, 'rows' => array(), 'kelas' => 'Semua Kelas');
        }

        $like = '%' . $search . '%';
        $sql = "SELECT
                    ts.id_siswa,
                    ts.nis,
                    ts.nisn,
                    ts.nama_siswa,
                    ts.id_kelas_setting,
                    ts.nama_kelas,
                    MAX(ts.nominal_tagihan) tarif,
                    COALESCE(SUM(ts.nominal_dibayar),0) dibayar,
                    COALESCE(SUM(ts.sisa_tagihan),0) sisa,
                    CASE
                        WHEN SUM(CASE WHEN ts.status_pembayaran='Dibebaskan' THEN 1 ELSE 0 END)=COUNT(*) THEN 'Dibebaskan'
                        WHEN COALESCE(SUM(ts.sisa_tagihan),0)<=0 THEN 'Lunas'
                        WHEN COALESCE(SUM(ts.nominal_dibayar),0)>0 THEN 'Dibayar Sebagian'
                        ELSE 'Belum Dibayar'
                    END status_pembayaran,
                    'Aktif' status_penerima
                FROM tagihan_siswa ts
                WHERE ts.id_tagihan_master=?
                  AND (ts.nama_siswa LIKE ? OR ts.nis LIKE ? OR ts.nisn LIKE ?)";
        $params = array($idTagihan, $like, $like, $like);

        if ($idKelasSetting > 0) {
            $sql .= " AND ts.id_kelas_setting=?";
            $params[] = $idKelasSetting;
        }

        $sql .= " GROUP BY
                    ts.id_siswa,
                    ts.nis,
                    ts.nisn,
                    ts.nama_siswa,
                    ts.id_kelas_setting,
                    ts.nama_kelas
                  ORDER BY ts.nama_siswa ASC";

        $rows = $this->db->query($sql, $params)->result_array();
        $kelasLabel = 'Semua Kelas';

        if ($idKelasSetting > 0) {
            $kelasRow = $this->db->where('id', $idKelasSetting)->get('kelas_setting')->row_array();
            if ($kelasRow) {
                $kelasLabel = $kelasRow['nama_kelas'];
            }
        }

        return array('master' => $master, 'rows' => $rows, 'kelas' => $kelasLabel);
    }

    public function tambah()
    {
        $id = (int) $this->input->post('id_tagihan');
        $ids = $this->input->post('id_siswa');
        if (!is_array($ids)) {
            $ids = array();
        }

        $m = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$m || !$ids) {
            return $this->model_response(false, 'Pilih tagihan dan siswa.');
        }
        if ($m['status'] === 'Draft') {
            return $this->model_response(false, 'Terbitkan draft terlebih dahulu sebelum menambah siswa.');
        }

        $periods = $this->db->where('id_tagihan_master', $id)->where('status', 'Aktif')->get('tagihan_tarif_bulan')->result_array();
        $classes = $this->db->where('id_tagihan_master', $id)->where('status', 'Aktif')->get('tagihan_target_kelas')->result_array();
        $classMap = array();
        foreach ($classes as $x) {
            $classMap[(int) $x['id_kelas_setting']] = $x;
        }

        $this->db->trans_begin();
        $success = 0;
        $skip = 0;

        foreach ($ids as $sid) {
            $sid = (int) $sid;
            $s = $this->db->query(
                "SELECT s.*,k.id id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode
                 FROM siswa s
                 JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1'
                 JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED)
                 LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED)
                 WHERE s.id=?
                   AND s.status_pendaftaran='Aktif'
                   AND CAST(k.id_periode AS UNSIGNED)=?
                 ORDER BY ks.id DESC
                 LIMIT 1",
                array($sid, (int) $m['id_periode'])
            )->row_array();

            if (!$s) {
                $skip++;
                continue;
            }

            foreach ($periods as $p) {
                if ($this->db->where('id_tagihan_master', $id)->where('id_siswa', $sid)->where('bulan', $p['bulan'])->where('tahun', $p['tahun'])->count_all_results('tagihan_siswa')) {
                    $skip++;
                    continue;
                }

                $nom = (float) $p['nominal'];
                if (isset($classMap[(int) $s['id_kelas_setting']]) && (float) $classMap[(int) $s['id_kelas_setting']]['nominal_kelas'] > 0) {
                    $nom = (float) $classMap[(int) $s['id_kelas_setting']]['nominal_kelas'];
                }

                $special = $this->tarif_khusus_aktif($id, $sid, (int) $p['bulan'], (int) $p['tahun']);
                $jenisKeringanan = null;
                $nilaiKeringanan = 0;
                if ($special) {
                    $tarifNormal = $nom;
                    $nom = (float) $special['nominal_setelah_keringanan'];
                    $jenisKeringanan = 'Tarif Khusus';
                    $nilaiKeringanan = max(0, $tarifNormal - $nom);
                }

                $this->db->insert('tagihan_siswa', array(
                    'no_tagihan' => $this->tagihan_next_code('TAG', 'tagihan_siswa', 'no_tagihan'),
                    'id_tagihan_master' => $id,
                    'kode_tagihan' => $m['kode_tagihan'],
                    'id_jenis_tagihan' => $m['id_jenis_tagihan'],
                    'nama_jenis_tagihan' => $m['nama_jenis_tagihan'],
                    'nama_tagihan' => $m['nama_tagihan'],
                    'tipe_tagihan' => $m['tipe_tagihan'],
                    'id_periode' => $m['id_periode'],
                    'periode' => $m['periode'],
                    'semester' => null,
                    'bulan' => $p['bulan'],
                    'nama_bulan' => $p['nama_bulan'],
                    'tahun' => $p['tahun'],
                    'tanggal_jatuh_tempo' => $p['tanggal_jatuh_tempo'],
                    'id_siswa' => $sid,
                    'nis' => $s['nis'],
                    'nisn' => $s['nisn'],
                    'nama_siswa' => $s['nama_lengkap'],
                    'id_kelas_setting' => $s['id_kelas_setting'],
                    'id_kelas' => $s['id_kelas'],
                    'nama_kelas' => $s['nama_kelas'],
                    'nominal_awal' => $special ? $tarifNormal : $nom,
                    'jenis_keringanan' => $jenisKeringanan,
                    'nilai_keringanan' => $nilaiKeringanan,
                    'nominal_tagihan' => $nom,
                    'nominal_dibayar' => 0,
                    'sisa_tagihan' => $nom,
                    'dianggap_tunggakan' => $m['dianggap_tunggakan'],
                    'status_pembayaran' => 'Belum Dibayar',
                    'status_tagihan' => 'Aktif',
                    'tanggal_generate' => $this->tanggal_sekarang(),
                    'waktu_generate' => $this->waktu_sekarang(),
                    'id_user_generate' => $this->app_user_id(),
                    'nama_user_generate' => $this->app_user_name()
                ));
                $success++;
            }
        }

        $this->tagihan_log_activity(
            'Tambah Siswa Pembayar',
            'Tagihan',
            'Tambah',
            'tagihan_siswa',
            $id,
            $m['kode_tagihan'],
            $success . ' baris tagihan ditambahkan',
            null,
            array('siswa' => $ids)
        );

        return $this->tagihan_transaction_result($success . ' baris tagihan berhasil ditambahkan' . ($skip ? ' dan ' . $skip . ' dilewati.' : '.'));
    }

    public function keluarkan()
    {
        $id = (int) $this->input->post('id_tagihan');
        $ids = $this->input->post('id_siswa');
        if (!is_array($ids)) {
            $ids = array((int) $ids);
        }
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));

        $m = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$m) {
            return $this->model_response(false, 'Tagihan tidak ditemukan.');
        }
        if (!$ids) {
            return $this->model_response(false, 'Pilih siswa yang akan dikeluarkan.');
        }

        $this->db->trans_begin();
        $berhasil = 0;
        $dilewati = 0;

        foreach ($ids as $sid) {
            if ($this->db->where('id_tagihan_master', $id)->where('id_siswa', $sid)->where('nominal_dibayar >', 0)->count_all_results('tagihan_siswa')) {
                $dilewati++;
                continue;
            }

            $rows = $this->db->where('id_tagihan_master', $id)->where('id_siswa', $sid)->get('tagihan_siswa')->result_array();
            if (!$rows) {
                $dilewati++;
                continue;
            }

            $this->db->where('id_tagihan_master', $id)->where('id_siswa', $sid)->delete('tagihan_siswa');
            $this->db->where('id_tagihan_master', $id)->where('id_siswa', $sid)->update('tagihan_target_siswa', array('status' => 'Nonaktif'));

            $this->tagihan_log_activity(
                'Keluarkan Siswa Pembayar',
                'Tagihan',
                'Batal',
                'tagihan_siswa',
                $sid,
                $m['kode_tagihan'],
                'Mengeluarkan siswa yang belum membayar',
                $rows,
                null
            );
            $berhasil++;
        }

        if ($berhasil <= 0 && $dilewati > 0) {
            $this->db->trans_rollback();
            return $this->model_response(false, 'Siswa yang dipilih sudah memiliki pembayaran atau tidak dapat dikeluarkan.');
        }

        return $this->tagihan_transaction_result(
            $berhasil . ' siswa berhasil dikeluarkan' . ($dilewati ? ' dan ' . $dilewati . ' dilewati karena sudah memiliki pembayaran.' : '.')
        );
    }

    private function tarif_calon_siswa($idTagihan, $idSiswa, $idKelasSetting, $periods, $classMap)
    {
        $tarif = 0;

        foreach ($periods as $p) {
            $nominal = (float) $p['nominal'];

            if (isset($classMap[$idKelasSetting]) && (float) $classMap[$idKelasSetting]['nominal_kelas'] > 0) {
                $nominal = (float) $classMap[$idKelasSetting]['nominal_kelas'];
            }

            $special = $this->tarif_khusus_aktif($idTagihan, $idSiswa, (int) $p['bulan'], (int) $p['tahun']);
            if ($special) {
                $nominal = (float) $special['nominal_setelah_keringanan'];
            }

            if ($nominal > $tarif) {
                $tarif = $nominal;
            }
        }

        return $tarif;
    }

    private function tarif_khusus_aktif($idTagihan, $idSiswa, $bulan, $tahun)
    {
        return $this->db->query(
            "SELECT *
             FROM tagihan_keringanan_siswa
             WHERE id_tagihan_master=?
               AND id_siswa=?
               AND jenis_keringanan='Tarif Khusus'
               AND status='Aktif'
               AND ((bulan=? AND tahun=?) OR (bulan=0 AND tahun=0))
             ORDER BY
                CASE WHEN bulan=? AND tahun=? THEN 0 ELSE 1 END,
                id DESC
             LIMIT 1",
            array($idTagihan, $idSiswa, $bulan, $tahun, $bulan, $tahun)
        )->row_array();
    }

    private function app_user_id()
    {
        $user = $this->session->userdata('admin');
        return is_array($user) && isset($user['id']) ? (int) $user['id'] : 0;
    }

    private function app_user_name()
    {
        $user = $this->session->userdata('admin');
        return is_array($user) && isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator';
    }

    private function tanggal_sekarang()
    {
        return date('d-m-Y');
    }

    private function waktu_sekarang()
    {
        return date('H:i:s');
    }

    private function model_response($success, $message = '', $extra = array())
    {
        return array_merge(array(
            'result' => $success ? 'true' : 'false',
            'message' => $message
        ), $extra);
    }

    private function tagihan_transaction_result($success_message = 'Data berhasil disimpan.')
    {
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return array(
                'result' => 'false',
                'message' => 'Proses database gagal. Tidak ada perubahan yang disimpan.'
            );
        }

        $this->db->trans_commit();
        return array(
            'result' => 'true',
            'message' => $success_message
        );
    }

    private function tagihan_log_activity($jenis, $modul, $aksi, $table, $id, $nomor, $keterangan, $before = null, $after = null)
    {
        $user = $this->session->userdata('admin');
        $this->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => $jenis,
            'modul' => $modul,
            'aksi' => $aksi,
            'nama_tabel' => $table,
            'id_referensi' => (string) $id,
            'nomor_referensi' => $nomor,
            'keterangan' => $keterangan,
            'data_sebelum' => $before === null ? null : json_encode($before, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => $after === null ? null : json_encode($after, JSON_UNESCAPED_UNICODE),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => is_array($user) && isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator'
        ));
    }

    private function tagihan_next_code($prefix, $table, $column)
    {
        $date = date('Ym');
        $like = $prefix . '/' . $date . '/';
        $row = $this->db->select($column)
            ->like($column, $like, 'after')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get($table)
            ->row_array();

        $next = 1;
        if ($row && !empty($row[$column])) {
            $parts = explode('/', $row[$column]);
            $next = ((int) end($parts)) + 1;
        }

        return $like . str_pad($next, 5, '0', STR_PAD_LEFT);
    }
}
