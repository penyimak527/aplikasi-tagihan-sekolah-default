<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tagihan_per_kelas extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }

    public function kelas_list()
    {
        return $this->db->select('k.id,k.nama_kelas,k.id_periode')->from('kelas_setting k')->order_by('k.id_periode', 'DESC')->order_by('k.nama_kelas')->get()->result_array();
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

    public function detail_tagihan()
    {
        $id = (int)$this->input->post('id_siswa');
        $periode = (int)$this->input->post('id_periode');
        $this->db->where('id_siswa', $id);
        if ($periode) $this->db->where('id_periode', $periode);
        return $this->db->order_by('tahun')->order_by('bulan')->get('tagihan_siswa')->result_array();
    }

    public function filter_info($filter = array())
    {
        $idPeriode = isset($filter['id_periode']) ? (int) $filter['id_periode'] : 0;
        $idKelas = isset($filter['id_kelas_setting']) ? (int) $filter['id_kelas_setting'] : 0;

        $tahunAjaran = 'Semua Tahun Ajaran';
        $namaKelas = 'Semua Kelas';

        if ($idPeriode > 0) {
            $row = $this->db->select('periode')->where('id', $idPeriode)->get('master_tahun_ajaran')->row_array();
            if ($row) {
                $tahunAjaran = $row['periode'];
            }
        }

        if ($idKelas > 0) {
            $row = $this->db->select('nama_kelas')->where('id', $idKelas)->get('kelas_setting')->row_array();
            if ($row) {
                $namaKelas = $row['nama_kelas'];
            }
        }

        return array(
            'tahun_ajaran' => $tahunAjaran,
            'kelas' => $namaKelas
        );
    }
}
