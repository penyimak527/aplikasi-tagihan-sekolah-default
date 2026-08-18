<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_penempatan_siswa extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }

    public function kelas_list()
    {
        return $this->db
            ->select('ks.*,ta.periode')
            ->from('kelas_setting ks')
            ->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')
            ->order_by('ta.id', 'DESC')
            ->order_by('ks.nama_kelas')
            ->get()
            ->result_array();
    }

    public function result()
    {
        $id = (int) $this->input->post('id_kelas_setting');
        $kelas = $this->db->where('id', $id)->get('kelas_setting')->row_array();
        if (!$kelas) {
            return array('result' => 'false', 'message' => 'Pilih kelas tujuan.');
        }

        $search = trim((string) $this->input->post('search', true));
        $q = '%' . $search . '%';
        $idPeriode = (int) $kelas['id_periode'];

        /*
         * Penempatan Siswa hanya digunakan untuk PENEMPATAN AWAL.
         * Siswa tidak ditampilkan lagi di "Belum Ditempatkan" jika sudah pernah
         * mempunyai penempatan yang masih sah pada tahun ajaran mana pun.
         *
         * Penempatan dianggap masih sah jika:
         * 1. masih ada kelas_siswa aktif; atau
         * 2. masih ada riwayat kelas dengan status_riwayat = Aktif.
         *
         * Jika penempatan awal dikoreksi melalui Keluarkan, kelas_siswa dibuat
         * tidak aktif dan riwayat terkait menjadi Dibatalkan. Karena sudah tidak
         * ada penempatan/riwayat yang sah, siswa dapat muncul kembali di daftar
         * "Belum Ditempatkan" untuk ditempatkan ulang dengan benar.
         */
        $unplaced = $this->db->query(
            "SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.jk,s.status_pendaftaran
             FROM siswa s
             WHERE s.status_pendaftaran='Aktif'
               AND (s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ?)
               AND NOT EXISTS(
                    SELECT 1
                    FROM kelas_siswa x
                    WHERE CAST(x.id_siswa AS UNSIGNED)=s.id
                      AND x.status_aktif='1'
               )
               AND NOT EXISTS(
                    SELECT 1
                    FROM tagihan_riwayat_kelas_siswa r
                    WHERE r.id_siswa=s.id
                      AND r.status_riwayat='Aktif'
               )
             ORDER BY s.nama_lengkap
             LIMIT 500",
            array($q, $q, $q)
        )->result_array();

        $placed = $this->db->query(
            "SELECT ks.id AS id_kelas_siswa,s.id,s.nis,s.nisn,s.nama_lengkap,s.jk
             FROM kelas_siswa ks
             INNER JOIN siswa s ON s.id=CAST(ks.id_siswa AS UNSIGNED)
             WHERE CAST(ks.id_kelas_setting AS UNSIGNED)=?
               AND ks.status_aktif='1'
             ORDER BY s.nama_lengkap",
            array($id)
        )->result_array();

        return array(
            'result' => 'true',
            'unplaced' => $unplaced,
            'placed' => $placed,
            'kelas' => $kelas
        );
    }

    public function proses()
    {
        $idKelas = (int) $this->input->post('id_kelas_setting');
        $ids = $this->input->post('id_siswa');
        if (!is_array($ids)) {
            $ids = array();
        }

        $kelas = $this->db->where('id', $idKelas)->get('kelas_setting')->row_array();
        if (!$kelas || !$ids) {
            return $this->model_response(false, 'Pilih kelas dan minimal satu siswa.');
        }

        $idPeriode = (int) $kelas['id_periode'];
        $periode = $this->db->where('id', $idPeriode)->get('master_tahun_ajaran')->row_array();

        $this->db->trans_begin();
        $success = 0;
        $skip = 0;

        foreach ($ids as $sid) {
            $sid = (int) $sid;
            $s = $this->db->where('id', $sid)->get('siswa')->row_array();
            if (!$s) {
                $skip++;
                continue;
            }

            /*
             * Validasi backend harus sama dengan daftar "Belum Ditempatkan".
             * Jangan hanya mengecek tahun ajaran tujuan karena siswa yang sudah
             * pernah masuk Kesiswaan harus melanjutkan melalui Kenaikan/Pindah/
             * Tinggal Kelas, bukan ditempatkan ulang dari menu ini.
             */
            if ($s['status_pendaftaran'] !== 'Aktif') {
                $skip++;
                continue;
            }

            $activePlacement = (int) $this->db->query(
                "SELECT COUNT(*) total
                 FROM kelas_siswa x
                 WHERE CAST(x.id_siswa AS UNSIGNED)=?
                   AND x.status_aktif='1'",
                array($sid)
            )->row()->total;

            $validHistory = (int) $this->db->query(
                "SELECT COUNT(*) total
                 FROM tagihan_riwayat_kelas_siswa r
                 WHERE r.id_siswa=?
                   AND r.status_riwayat='Aktif'",
                array($sid)
            )->row()->total;

            if ($activePlacement || $validHistory) {
                $skip++;
                continue;
            }

            $this->db->insert('kelas_siswa', array(
                'id_kelas_setting' => (string) $idKelas,
                'id_siswa' => (string) $sid,
                'nama_siswa' => $s['nama_lengkap'],
                'nisn' => $s['nisn'],
                'jenis_kelamin' => $s['jk'],
                'status_aktif' => '1'
            ));

            $this->db->insert('tagihan_riwayat_kelas_siswa', array(
                'id_siswa' => $sid,
                'nis' => $s['nis'],
                'nisn' => $s['nisn'],
                'nama_siswa' => $s['nama_lengkap'],
                'id_kelas_setting_tujuan' => $idKelas,
                'id_kelas_tujuan' => (int) $kelas['id_kelas'],
                'nama_kelas_tujuan' => $kelas['nama_kelas'],
                'id_periode_tujuan' => $idPeriode,
                'periode_tujuan' => $periode ? $periode['periode'] : '',
                'semester_tujuan' => null,
                'jenis_proses' => 'Penempatan',
                'status_sebelum' => 'Belum Ditempatkan',
                'status_setelah' => 'Aktif',
                'tanggal_proses' => $this->tanggal_sekarang(),
                'waktu_proses' => $this->waktu_sekarang(),
                'id_user' => $this->app_user_id(),
                'nama_user' => $this->app_user_name(),
                'status_riwayat' => 'Aktif'
            ));

            $success++;
        }

        $this->tagihan_log_activity(
            'Penempatan Siswa',
            'Kesiswaan',
            'Tambah',
            'kelas_siswa',
            $idKelas,
            $kelas['nama_kelas'],
            'Menempatkan ' . $success . ' siswa; dilewati ' . $skip,
            null,
            array('id_siswa' => $ids)
        );

        return $this->tagihan_transaction_result(
            $success . ' siswa berhasil ditempatkan' . ($skip ? ' dan ' . $skip . ' dilewati.' : '.')
        );
    }

    public function keluarkan()
    {
        $id = (int) $this->input->post('id_kelas_siswa');
        $row = $this->db->query(
            "SELECT ks.*,s.nis,s.nisn,s.nama_lengkap,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode
             FROM kelas_siswa ks
             JOIN siswa s ON s.id=CAST(ks.id_siswa AS UNSIGNED)
             JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED)
             LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED)
             WHERE ks.id=?",
            array($id)
        )->row_array();

        if (!$row) {
            return $this->model_response(false, 'Penempatan tidak ditemukan.');
        }

        if ($row['status_aktif'] !== '1') {
            return $this->model_response(false, 'Penempatan siswa sudah tidak aktif.');
        }

        $sudahDipakaiTagihan = $this->db
            ->where('id_siswa', (int) $row['id_siswa'])
            ->where('id_kelas_setting', (int) $row['id_kelas_setting'])
            ->count_all_results('tagihan_siswa');

        if ($sudahDipakaiTagihan) {
            return $this->model_response(
                false,
                'Penempatan sudah digunakan pada tagihan dan tidak dapat dikeluarkan langsung.'
            );
        }

        /*
         * Cari riwayat aktif terakhir yang menghasilkan kelas aktif saat ini.
         * Tidak dibatasi hanya jenis_proses=Penempatan agar kelas yang berasal dari
         * Kenaikan/Pindah/Tinggal Kelas tetap mempunyai jejak pembatalan jika
         * dikoreksi melalui tombol Keluarkan.
         */
        $riwayat = $this->db
            ->where('id_siswa', (int) $row['id_siswa'])
            ->where('id_kelas_setting_tujuan', (int) $row['id_kelas_setting'])
            ->where('status_riwayat', 'Aktif')
            ->order_by('id', 'DESC')
            ->get('tagihan_riwayat_kelas_siswa')
            ->row_array();

        $this->db->trans_begin();

        $this->db
            ->where('id', $id)
            ->where('status_aktif', '1')
            ->update('kelas_siswa', array('status_aktif' => '0'));

        if ($riwayat) {
            $this->db
                ->where('id', (int) $riwayat['id'])
                ->update('tagihan_riwayat_kelas_siswa', array(
                    'status_riwayat' => 'Dibatalkan',
                    'tanggal_batal' => $this->tanggal_sekarang(),
                    'waktu_batal' => $this->waktu_sekarang(),
                    'id_user_batal' => $this->app_user_id(),
                    'nama_user_batal' => $this->app_user_name(),
                    'alasan_batal' => 'Dikeluarkan melalui koreksi Penempatan Siswa'
                ));
        }

        $this->tagihan_log_activity(
            'Koreksi Penempatan',
            'Kesiswaan',
            'Batal',
            'kelas_siswa',
            $id,
            $row['nis'],
            'Mengeluarkan penempatan yang belum digunakan',
            $row,
            array(
                'status_aktif' => '0',
                'id_riwayat_dibatalkan' => $riwayat ? (int) $riwayat['id'] : null
            )
        );

        return $this->tagihan_transaction_result('Penempatan siswa berhasil dikeluarkan.');
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
}
