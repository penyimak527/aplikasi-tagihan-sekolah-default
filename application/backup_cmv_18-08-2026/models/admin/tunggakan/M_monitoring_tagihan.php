<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_monitoring_tagihan extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }
    public function kelas_list()
    {
        return $this->db->select('k.id,k.nama_kelas,k.id_periode')->from('kelas_setting k')->order_by('k.id_periode', 'DESC')->order_by('k.nama_kelas')->get()->result_array();
    }
    public function jenis_list()
    {
        return $this->db->where('status', 'Aktif')->order_by('nama_jenis')->get('tagihan_jenis')->result_array();
    }
    public function cari_siswa()
    {
        $q = trim((string)$this->input->post('q', true));
        if (strlen($q) < 2) return array();
        return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran,s.telepon_ayah,s.telepon_ibu,k.nama_kelas,k.id id_kelas_setting,k.id_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ? ORDER BY s.nama_lengkap LIMIT 25", array('%' . $q . '%', '%' . $q . '%', '%' . $q . '%'))->result_array();
    }
    public function per_siswa()
    {
        $id = (int)$this->input->post('id_siswa');
        $periode = (int)$this->input->post('id_periode');
        $tipe = trim((string)$this->input->post('tipe', true));
        $status = trim((string)$this->input->post('status', true));
        $sampai = (int)$this->input->post('sampai_bulan');
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
                if (!in_array($r['status_pembayaran'], array('Lunas', 'Dibebaskan', 'Dibatalkan'), true)) $summary['tunggakan'] += (float)$r['sisa_tagihan'];
            }
        }
        return array('result' => 'true', 'siswa' => $siswa, 'rows' => $rows, 'summary' => $summary);
    }
    public function per_kelas($filter = array())
    {
        $periode = isset($filter['id_periode']) ? (int) $filter['id_periode'] : (int)$this->input->post('id_periode');
        $kelas = isset($filter['id_kelas_setting']) ? (int) $filter['id_kelas_setting'] : (int)$this->input->post('id_kelas_setting');
        $sampai = isset($filter['sampai_bulan']) ? (int) $filter['sampai_bulan'] : (int)$this->input->post('sampai_bulan');

        $params = array();

        /*
         * Penentuan kelas siswa:
         *
         * 1. Jika siswa masih mempunyai kelas_siswa aktif pada tahun ajaran
         *    yang dipilih, gunakan kelas aktif tersebut.
         *
         * 2. Jika sudah tidak aktif pada tahun itu karena Naik Kelas,
         *    Pindah Kelas, Lulus, Berhenti, atau Pindah Sekolah,
         *    gunakan SATU riwayat kelas terakhir yang masih sah
         *    (status_riwayat = Aktif).
         *
         * Untuk Pindah Kelas dalam tahun yang sama, kelas tujuan pada riwayat
         * terakhir yang digunakan. Dengan begitu siswa tidak muncul sekaligus
         * di kelas-kelas yang pernah dilewati.
         */
        if ($periode) {
            $periodeSql = (int)$periode;

            $penempatanSql = "
                (
                    SELECT DISTINCT
                        CAST(ks.id_siswa AS UNSIGNED) AS id_siswa,
                        CAST(ks.id_kelas_setting AS UNSIGNED) AS id_kelas_setting
                    FROM kelas_siswa ks
                    INNER JOIN kelas_setting ka
                        ON ka.id=CAST(ks.id_kelas_setting AS UNSIGNED)
                    WHERE ks.status_aktif='1'
                      AND CAST(ka.id_periode AS UNSIGNED)={$periodeSql}

                    UNION

                    SELECT
                        r.id_siswa,
                        CASE
                            WHEN r.id_periode_tujuan={$periodeSql}
                             AND COALESCE(r.id_kelas_setting_tujuan,0)>0
                            THEN r.id_kelas_setting_tujuan

                            WHEN r.id_periode_asal={$periodeSql}
                             AND COALESCE(r.id_kelas_setting_asal,0)>0
                            THEN r.id_kelas_setting_asal

                            ELSE 0
                        END AS id_kelas_setting
                    FROM tagihan_riwayat_kelas_siswa r
                    WHERE r.status_riwayat='Aktif'

                      AND (
                            (
                                r.id_periode_tujuan={$periodeSql}
                                AND COALESCE(r.id_kelas_setting_tujuan,0)>0
                            )
                            OR
                            (
                                r.id_periode_asal={$periodeSql}
                                AND COALESCE(r.id_kelas_setting_asal,0)>0
                            )
                      )

                      /*
                       * Ambil hanya kejadian kelas TERAKHIR siswa
                       * yang berhubungan dengan tahun ajaran ini.
                       */
                      AND r.id=(
                            SELECT MAX(r2.id)
                            FROM tagihan_riwayat_kelas_siswa r2
                            WHERE r2.id_siswa=r.id_siswa
                              AND r2.status_riwayat='Aktif'
                              AND (
                                    (
                                        r2.id_periode_tujuan={$periodeSql}
                                        AND COALESCE(r2.id_kelas_setting_tujuan,0)>0
                                    )
                                    OR
                                    (
                                        r2.id_periode_asal={$periodeSql}
                                        AND COALESCE(r2.id_kelas_setting_asal,0)>0
                                    )
                              )
                      )

                      /*
                       * Jika pada periode yang dipilih masih ada kelas_siswa
                       * aktif, kelas aktif menjadi sumber utama dan riwayat
                       * tidak perlu ditambahkan lagi.
                       */
                      AND NOT EXISTS (
                            SELECT 1
                            FROM kelas_siswa ks2
                            INNER JOIN kelas_setting k2
                                ON k2.id=CAST(ks2.id_kelas_setting AS UNSIGNED)
                            WHERE CAST(ks2.id_siswa AS UNSIGNED)=r.id_siswa
                              AND ks2.status_aktif='1'
                              AND CAST(k2.id_periode AS UNSIGNED)={$periodeSql}
                      )
                ) pk
            ";
        } else {
            /*
             * Jika Tahun Ajaran tidak dipilih, pertahankan perilaku lama:
             * tampilkan kelas siswa yang aktif saat ini.
             */
            $penempatanSql = "
                (
                    SELECT DISTINCT
                        CAST(ks.id_siswa AS UNSIGNED) AS id_siswa,
                        CAST(ks.id_kelas_setting AS UNSIGNED) AS id_kelas_setting
                    FROM kelas_siswa ks
                    WHERE ks.status_aktif='1'
                ) pk
            ";
        }

        $sql = "
            SELECT
                s.id AS id_siswa,
                s.nis,
                s.nisn,
                s.nama_lengkap AS nama_siswa,
                k.id AS id_kelas_setting,
                k.nama_kelas,

                COALESCE(
                    SUM(
                        CASE
                            WHEN ts.dianggap_tunggakan='Ya'
                             AND ts.status_tagihan='Aktif'
                            THEN ts.nominal_tagihan
                            ELSE 0
                        END
                    ),
                    0
                ) AS total_wajib,

                COALESCE(
                    SUM(
                        CASE
                            WHEN ts.dianggap_tunggakan='Ya'
                             AND ts.status_tagihan='Aktif'
                            THEN ts.nominal_dibayar
                            ELSE 0
                        END
                    ),
                    0
                ) AS dibayar,

                COALESCE(
                    SUM(
                        CASE
                            WHEN ts.dianggap_tunggakan='Ya'
                             AND ts.status_tagihan='Aktif'
                             AND ts.status_pembayaran NOT IN (
                                'Lunas',
                                'Dibebaskan',
                                'Dibatalkan'
                             )
                            THEN ts.sisa_tagihan
                            ELSE 0
                        END
                    ),
                    0
                ) AS tunggakan,

                COUNT(
                    DISTINCT CASE
                        WHEN ts.dianggap_tunggakan='Ya'
                         AND ts.status_tagihan='Aktif'
                        THEN ts.id
                        ELSE NULL
                    END
                ) AS jumlah_tagihan_wajib

            FROM {$penempatanSql}

            INNER JOIN siswa s
                ON s.id=pk.id_siswa

            INNER JOIN kelas_setting k
                ON k.id=pk.id_kelas_setting

            /*
             * Tagihan sengaja dicocokkan dengan siswa + tahun ajaran,
             * BUKAN id_kelas_setting.
             *
             * Contoh:
             * siswa menerima tagihan ketika masih Kelas 10 B,
             * lalu pindah ke Kelas 10 C pada tahun ajaran yang sama.
             * Tagihan lama tetap menjadi tagihan siswa pada tahun tersebut
             * dan harus tetap terbaca ketika siswa sekarang ditampilkan
             * pada Kelas 10 C.
             */
            LEFT JOIN tagihan_siswa ts
                ON ts.id_siswa=s.id
               AND ts.id_periode=CAST(k.id_periode AS UNSIGNED)
        ";

        /*
         * Sampai Bulan diletakkan pada JOIN agar siswa yang belum memiliki
         * tagihan tetap muncul dengan nilai 0 / Belum Ada Tagihan.
         */
        if ($sampai) {
            $urutanSampai = $sampai >= 7 ? $sampai - 6 : $sampai + 6;
            $sql .= " AND (ts.bulan IS NULL OR (CASE WHEN ts.bulan>=7 THEN ts.bulan-6 ELSE ts.bulan+6 END)<=?)";
            $params[] = $urutanSampai;
        }

        $where = array();

        if ($periode) {
            $where[] = 'CAST(k.id_periode AS UNSIGNED)=?';
            $params[] = $periode;
        }

        if ($kelas) {
            $where[] = 'k.id=?';
            $params[] = $kelas;
        }

        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= "
            GROUP BY
                s.id,
                s.nis,
                s.nisn,
                s.nama_lengkap,
                k.id,
                k.nama_kelas

            ORDER BY
                k.nama_kelas,
                s.nama_lengkap
        ";

        $rows = $this->db->query($sql, $params)->result_array();

        foreach ($rows as &$r) {
            $jumlahTagihanWajib = (int)$r['jumlah_tagihan_wajib'];
            $tunggakan = (float)$r['tunggakan'];

            /*
             * Status Tagihan Per Kelas hanya berdasarkan tagihan wajib.
             * Tagihan tidak wajib tidak boleh membuat siswa dianggap
             * mempunyai kewajiban ataupun dianggap Lunas.
             */
            if ($jumlahTagihanWajib <= 0) {
                $r['status'] = 'Belum Ada Tagihan';
            } elseif ($tunggakan > 0) {
                $r['status'] = 'Kurang';
            } else {
                $r['status'] = 'Lunas';
            }
        }
        unset($r);

        return $rows;
    }

    public function per_jenis($filter = array())
    {
        $periode = isset($filter['id_periode']) ? (int) $filter['id_periode'] : (int)$this->input->post('id_periode');
        $jenis = isset($filter['id_jenis']) ? (int) $filter['id_jenis'] : (int)$this->input->post('id_jenis');
        $master = isset($filter['id_master']) ? (int) $filter['id_master'] : (int)$this->input->post('id_master');
        $kelas = isset($filter['id_kelas_setting']) ? (int) $filter['id_kelas_setting'] : (int)$this->input->post('id_kelas_setting');
        $this->db->select('ts.*,m.kode_tagihan')->from('tagihan_siswa ts')->join('tagihan_master m', 'm.id=ts.id_tagihan_master', 'left');
        if ($periode) $this->db->where('ts.id_periode', $periode);
        if ($jenis) $this->db->where('ts.id_jenis_tagihan', $jenis);
        if ($master) $this->db->where('ts.id_tagihan_master', $master);
        if ($kelas) $this->db->where('ts.id_kelas_setting', $kelas);
        $rows = $this->db->order_by('ts.nama_siswa')->get()->result_array();
        $summary = array('target' => 0, 'bayar' => 0, 'sisa' => 0);
        foreach ($rows as $r) {
            $summary['target'] += (float)$r['nominal_tagihan'];
            $summary['bayar'] += (float)$r['nominal_dibayar'];
            $summary['sisa'] += (float)$r['sisa_tagihan'];
        }
        $summary['realisasi'] = $summary['target'] > 0 ? round($summary['bayar'] / $summary['target'] * 100, 2) : 0;
        return array('rows' => $rows, 'summary' => $summary);
    }
    public function master_by_jenis()
    {
        $periode = (int)$this->input->post('id_periode');
        $jenis = (int)$this->input->post('id_jenis');
        $this->db->select('id,kode_tagihan,nama_tagihan,tipe_tagihan')->from('tagihan_master')->where_in('status', array('Aktif', 'Dibatalkan'));
        if ($periode) $this->db->where('id_periode', $periode);
        if ($jenis) $this->db->where('id_jenis_tagihan', $jenis);
        return $this->db->order_by('id', 'DESC')->get()->result_array();
    }
    public function tunggakan_lama($filter = array())
    {
        $tahunBerjalan = isset($filter['id_periode_berjalan']) ? (int) $filter['id_periode_berjalan'] : (int)$this->input->post('id_periode_berjalan');
        $kelas = isset($filter['id_kelas_setting']) ? (int) $filter['id_kelas_setting'] : (int)$this->input->post('id_kelas_setting');
        if (!$tahunBerjalan) return array();
        $periodeAktif = $this->db->where('id', $tahunBerjalan)->get('master_tahun_ajaran')->row_array();
        if (!$periodeAktif) return array();
        $tahunAwal = (int)substr($periodeAktif['periode'], 0, 4);
        $sql = "SELECT s.id id_siswa,s.nis,s.nisn,s.nama_lengkap nama_siswa,cur.nama_kelas kelas_saat_ini,ts.id_periode,ts.periode tahun_asal,COUNT(ts.id) jumlah_tagihan,SUM(ts.sisa_tagihan) total_tunggakan FROM tagihan_siswa ts JOIN siswa s ON s.id=ts.id_siswa LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting cur ON cur.id=CAST(ks.id_kelas_setting AS UNSIGNED) WHERE CAST(SUBSTRING_INDEX(ts.periode,'/',1) AS UNSIGNED)<? AND ts.dianggap_tunggakan='Ya' AND ts.status_tagihan='Aktif' AND ts.sisa_tagihan>0 AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')";
        $params = array($tahunAwal);
        if ($kelas) {
            $sql .= ' AND cur.id=?';
            $params[] = $kelas;
        }
        $sql .= ' GROUP BY s.id,ts.id_periode,ts.periode,cur.nama_kelas ORDER BY total_tunggakan DESC,s.nama_lengkap';
        return $this->db->query($sql, $params)->result_array();
    }
    public function detail_tagihan()
    {
        $id = (int)$this->input->post('id_siswa');
        $periode = (int)$this->input->post('id_periode');
        $this->db->where('id_siswa', $id);
        if ($periode) $this->db->where('id_periode', $periode);
        return $this->db->order_by('tahun')->order_by('bulan')->get('tagihan_siswa')->result_array();
    }

    private function model_response($success, $message = '', $extra = array())
    {
        return array_merge(array(
            'result' => $success ? 'true' : 'false',
            'message' => $message
        ), $extra);
    }
}