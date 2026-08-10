<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_portal extends CI_Model
{
    public function akun($id_wali)
    {
        return $this->db->where('id', (int) $id_wali)->get('wali_murid')->row_array();
    }

    public function akun_aktif($id_wali)
    {
        $row = $this->akun($id_wali);
        return $row && $row['status'] === 'Aktif' ? $row : false;
    }

    public function profil_sekolah()
    {
        $row = $this->db
            ->where('jenis_format', 'Bukti Pembayaran')
            ->where('status', 'Aktif')
            ->where('status_default', 'Ya')
            ->order_by('id', 'DESC')
            ->get('tagihan_pengaturan_cetak')
            ->row_array();

        if (!$row) {
            $row = $this->db
                ->where('jenis_format', 'Bukti Pembayaran')
                ->where('status', 'Aktif')
                ->order_by('id', 'ASC')
                ->get('tagihan_pengaturan_cetak')
                ->row_array();
        }

        return array(
            'nama_sekolah' => !empty($row['nama_sekolah']) ? $row['nama_sekolah'] : 'Aplikasi Tagihan Sekolah',
            'logo_sekolah' => !empty($row['logo_sekolah']) ? $row['logo_sekolah'] : 'assets/logo_almahbaro_edited.jpg',
            'alamat_sekolah' => isset($row['alamat_sekolah']) ? $row['alamat_sekolah'] : '',
            'telepon_sekolah' => isset($row['telepon_sekolah']) ? $row['telepon_sekolah'] : ''
        );
    }

    public function periode_list()
    {
        $rows = $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
        $aktif = null;
        foreach ($rows as $row) {
            if ($row['status'] === 'Aktif') {
                $aktif = $row;
                break;
            }
        }

        if (!$aktif || empty($aktif['periode'])) {
            return $rows;
        }

        $partsAktif = explode('/', $aktif['periode']);
        $tahunAktif = isset($partsAktif[0]) ? (int) $partsAktif[0] : 0;
        if ($tahunAktif <= 0) {
            return $rows;
        }

        return array_values(array_filter($rows, function ($row) use ($tahunAktif) {
            $parts = explode('/', (string) $row['periode']);
            $tahun = isset($parts[0]) ? (int) $parts[0] : 0;
            return $tahun > 0 && $tahun <= $tahunAktif;
        }));
    }

    public function periode_aktif()
    {
        $row = $this->db->where('status', 'Aktif')->order_by('id', 'DESC')->get('master_tahun_ajaran')->row_array();
        if (!$row) {
            $row = $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->row_array();
        }
        return $row ?: array('id' => 0, 'periode' => '-', 'status' => 'Tidak Aktif');
    }

    public function anak($id_wali)
    {
        return $this->db->query(
            "SELECT wms.id AS id_relasi, wms.id_siswa, wms.hubungan,
                    s.nis, s.nisn, s.nama_lengkap, s.status_pendaftaran,
                    ks.id_kelas_setting, kset.id_kelas, kset.nama_kelas,
                    kset.id_periode, kset.semester, ta.periode
             FROM wali_murid_siswa wms
             INNER JOIN siswa s ON s.id = wms.id_siswa
             LEFT JOIN kelas_siswa ks ON ks.id = (
                 SELECT MAX(x.id)
                 FROM kelas_siswa x
                 WHERE CAST(x.id_siswa AS UNSIGNED) = s.id
                   AND x.status_aktif = '1'
             )
             LEFT JOIN kelas_setting kset ON kset.id = CAST(ks.id_kelas_setting AS UNSIGNED)
             LEFT JOIN master_tahun_ajaran ta ON ta.id = CAST(kset.id_periode AS UNSIGNED)
             WHERE wms.id_wali_murid = ?
               AND wms.status = 'Aktif'
             ORDER BY s.nama_lengkap ASC",
            array((int) $id_wali)
        )->result_array();
    }

    public function validasi_siswa($id_wali, $id_siswa)
    {
        if ((int) $id_siswa <= 0) {
            return false;
        }

        return $this->db
            ->where('id_wali_murid', (int) $id_wali)
            ->where('id_siswa', (int) $id_siswa)
            ->where('status', 'Aktif')
            ->count_all_results('wali_murid_siswa') > 0;
    }

    public function id_siswa_aktif($id_wali)
    {
        $rows = $this->db
            ->select('id_siswa')
            ->where('id_wali_murid', (int) $id_wali)
            ->where('status', 'Aktif')
            ->get('wali_murid_siswa')
            ->result_array();

        return array_values(array_unique(array_map('intval', array_column($rows, 'id_siswa'))));
    }

    public function filter_context($id_wali)
    {
        $anak = $this->anak($id_wali);
        $periode = $this->periode_list();

        $id_siswa = (int) $this->session->userdata('wali_filter_siswa');
        if ($id_siswa > 0 && !$this->validasi_siswa($id_wali, $id_siswa)) {
            $id_siswa = 0;
            $this->session->set_userdata('wali_filter_siswa', 0);
        }

        $id_periode = (int) $this->session->userdata('wali_filter_periode');
        $periode_terpilih = null;
        foreach ($periode as $row) {
            if ((int) $row['id'] === $id_periode) {
                $periode_terpilih = $row;
                break;
            }
        }

        if (!$periode_terpilih) {
            foreach ($periode as $row) {
                if ($row['status'] === 'Aktif') {
                    $periode_terpilih = $row;
                    break;
                }
            }
        }
        if (!$periode_terpilih && !empty($periode)) {
            $periode_terpilih = $periode[0];
        }

        $id_periode = $periode_terpilih ? (int) $periode_terpilih['id'] : 0;
        $this->session->set_userdata('wali_filter_periode', $id_periode);

        return array(
            'anak' => $anak,
            'periode_list' => $periode,
            'id_siswa_filter' => $id_siswa,
            'id_periode_filter' => $id_periode,
            'periode_filter' => $periode_terpilih ? $periode_terpilih['periode'] : '-',
            'periode_aktif' => $this->periode_aktif(),
            'sekolah' => $this->profil_sekolah()
        );
    }

    public function set_filter($id_wali, $id_siswa, $id_periode)
    {
        $id_siswa = (int) $id_siswa;
        $id_periode = (int) $id_periode;

        if ($id_siswa > 0 && !$this->validasi_siswa($id_wali, $id_siswa)) {
            return model_response(false, 'Siswa tidak terhubung dengan akun wali murid ini.');
        }

        if ($id_periode > 0 && $this->db->where('id', $id_periode)->count_all_results('master_tahun_ajaran') === 0) {
            return model_response(false, 'Tahun ajaran tidak ditemukan.');
        }

        $this->session->set_userdata('wali_filter_siswa', $id_siswa);
        if ($id_periode > 0) {
            $this->session->set_userdata('wali_filter_periode', $id_periode);
        }

        return model_response(true, 'Filter portal berhasil diterapkan.');
    }

    public function ids_dari_context($id_wali, $context)
    {
        $selected = isset($context['id_siswa_filter']) ? (int) $context['id_siswa_filter'] : 0;
        if ($selected > 0) {
            return $this->validasi_siswa($id_wali, $selected) ? array($selected) : array();
        }
        return $this->id_siswa_aktif($id_wali);
    }
}
