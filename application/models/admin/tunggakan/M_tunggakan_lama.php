<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tunggakan_lama extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }

    public function kelas_list()
    {
        return $this->db
            ->select('k.id,k.nama_kelas,k.id_periode')
            ->from('kelas_setting k')
            ->order_by('k.id_periode', 'DESC')
            ->order_by('k.nama_kelas')
            ->get()
            ->result_array();
    }

    public function tunggakan_lama($filter = array())
    {
        $tahunBerjalan = isset($filter['id_periode_berjalan'])
            ? (int) $filter['id_periode_berjalan']
            : (int) $this->input->post('id_periode_berjalan');

        $kelas = isset($filter['id_kelas_setting'])
            ? (int) $filter['id_kelas_setting']
            : (int) $this->input->post('id_kelas_setting');

        if (!$tahunBerjalan) {
            return array();
        }

        $periodeAktif = $this->db
            ->where('id', $tahunBerjalan)
            ->get('master_tahun_ajaran')
            ->row_array();

        if (!$periodeAktif) {
            return array();
        }

        $tahunAwal = (int) substr($periodeAktif['periode'], 0, 4);

        $sql = "SELECT
                    s.id AS id_siswa,
                    s.nis,
                    s.nisn,
                    s.nama_lengkap AS nama_siswa,
                    cur.nama_kelas AS kelas_saat_ini,
                    ts.id_periode,
                    ts.periode AS tahun_asal,
                    COUNT(ts.id) AS jumlah_tagihan,
                    SUM(ts.sisa_tagihan) AS total_tunggakan
                FROM tagihan_siswa ts
                INNER JOIN siswa s
                    ON s.id=ts.id_siswa
                LEFT JOIN kelas_siswa ks
                    ON CAST(ks.id_siswa AS UNSIGNED)=s.id
                   AND ks.status_aktif='1'
                LEFT JOIN kelas_setting cur
                    ON cur.id=CAST(ks.id_kelas_setting AS UNSIGNED)
                WHERE CAST(SUBSTRING_INDEX(ts.periode,'/',1) AS UNSIGNED)<?
                  AND ts.dianggap_tunggakan='Ya'
                  AND ts.status_tagihan='Aktif'
                  AND ts.sisa_tagihan>0
                  AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')";

        $params = array($tahunAwal);

        if ($kelas) {
            $sql .= ' AND cur.id=?';
            $params[] = $kelas;
        }

        $sql .= " GROUP BY
                    s.id,
                    s.nis,
                    s.nisn,
                    s.nama_lengkap,
                    cur.nama_kelas,
                    ts.id_periode,
                    ts.periode
                  ORDER BY
                    total_tunggakan DESC,
                    s.nama_lengkap";

        return $this->db->query($sql, $params)->result_array();
    }

    public function detail_tagihan()
    {
        $id = (int) $this->input->post('id_siswa');
        $periode = (int) $this->input->post('id_periode');

        $this->db
            ->where('id_siswa', $id)
            ->where('status_tagihan', 'Aktif')
            ->where('dianggap_tunggakan', 'Ya')
            ->where('sisa_tagihan >', 0)
            ->where_not_in('status_pembayaran', array('Lunas', 'Dibebaskan', 'Dibatalkan'));

        if ($periode) {
            $this->db->where('id_periode', $periode);
        }

        return $this->db
            ->order_by('tahun')
            ->order_by('bulan')
            ->get('tagihan_siswa')
            ->result_array();
    }

    public function filter_info($filter = array())
    {
        $idPeriode = isset($filter['id_periode_berjalan'])
            ? (int) $filter['id_periode_berjalan']
            : 0;

        $idKelas = isset($filter['id_kelas_setting'])
            ? (int) $filter['id_kelas_setting']
            : 0;

        $tahunBerjalan = 'Semua Tahun Ajaran';
        $kelasSaatIni = 'Semua Kelas Saat Ini';

        if ($idPeriode > 0) {
            $row = $this->db
                ->select('periode')
                ->where('id', $idPeriode)
                ->get('master_tahun_ajaran')
                ->row_array();

            if ($row) {
                $tahunBerjalan = $row['periode'];
            }
        }

        if ($idKelas > 0) {
            $row = $this->db
                ->select('nama_kelas')
                ->where('id', $idKelas)
                ->get('kelas_setting')
                ->row_array();

            if ($row) {
                $kelasSaatIni = $row['nama_kelas'];
            }
        }

        return array(
            'tahun_berjalan' => $tahunBerjalan,
            'kelas_saat_ini' => $kelasSaatIni
        );
    }
}
