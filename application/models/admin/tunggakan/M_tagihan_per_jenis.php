<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tagihan_per_jenis extends CI_Model
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
        $idJenis = isset($filter['id_jenis']) ? (int) $filter['id_jenis'] : 0;
        $idMaster = isset($filter['id_master']) ? (int) $filter['id_master'] : 0;
        $idKelas = isset($filter['id_kelas_setting']) ? (int) $filter['id_kelas_setting'] : 0;

        $tahunAjaran = 'Semua Tahun Ajaran';
        $namaJenis = 'Semua Jenis';
        $namaBatch = 'Semua Batch/Periode';
        $namaKelas = 'Semua Kelas';

        if ($idPeriode > 0) {
            $row = $this->db->select('periode')->where('id', $idPeriode)->get('master_tahun_ajaran')->row_array();
            if ($row) {
                $tahunAjaran = $row['periode'];
            }
        }

        if ($idJenis > 0) {
            $row = $this->db->select('nama_jenis')->where('id', $idJenis)->get('tagihan_jenis')->row_array();
            if ($row) {
                $namaJenis = $row['nama_jenis'];
            }
        }

        if ($idMaster > 0) {
            $row = $this->db->select('nama_tagihan,tipe_tagihan')->where('id', $idMaster)->get('tagihan_master')->row_array();
            if ($row) {
                $namaBatch = $row['nama_tagihan'];
                if (!empty($row['tipe_tagihan'])) {
                    $namaBatch .= ' (' . $row['tipe_tagihan'] . ')';
                }
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
            'jenis_tagihan' => $namaJenis,
            'batch_periode' => $namaBatch,
            'kelas' => $namaKelas
        );
    }
}
