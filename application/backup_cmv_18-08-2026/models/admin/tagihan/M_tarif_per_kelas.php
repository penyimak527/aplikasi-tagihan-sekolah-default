<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tarif_per_kelas extends CI_Model
{
    public function tagihan_list()
    {
        return $this->db
            ->where_in('status', array('Aktif', 'Draft'))
            ->order_by('id', 'DESC')
            ->get('tagihan_master')
            ->result_array();
    }

    public function result()
    {
        $id = (int) $this->input->post('id_tagihan');
        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();

        if (!$master) {
            return array('result' => 'false', 'message' => 'Tagihan tidak ditemukan.');
        }

        $classes = $this->db->query(
            "SELECT
                tk.*,
                COUNT(DISTINCT ts.id_siswa) jumlah_siswa
            FROM tagihan_target_kelas tk
            LEFT JOIN tagihan_siswa ts
                ON ts.id_tagihan_master=tk.id_tagihan_master
               AND ts.id_kelas_setting=tk.id_kelas_setting
               AND ts.status_tagihan='Aktif'
            WHERE tk.id_tagihan_master=?
              AND tk.status='Aktif'
            GROUP BY tk.id
            ORDER BY tk.nama_kelas",
            array($id)
        )->result_array();

        return array(
            'result' => 'true',
            'master' => $master,
            'classes' => $classes
        );
    }

    public function simpan()
    {
        $id = (int) $this->input->post('id_tagihan');
        $tarif = $this->input->post('tarif');
        if (!is_array($tarif)) {
            $tarif = array();
        }

        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$master || !$tarif) {
            return $this->model_response(false, 'Data tarif tidak lengkap.');
        }

        $this->db->trans_begin();

        foreach ($tarif as $idTarget => $nominalInput) {
            $idTarget = (int) $idTarget;
            $nominal = $this->nilai_nominal($nominalInput);

            if ($nominal < 0) {
                $this->db->trans_rollback();
                return $this->model_response(false, 'Tarif tidak boleh negatif.');
            }

            $target = $this->db
                ->where('id', $idTarget)
                ->where('id_tagihan_master', $id)
                ->where('status', 'Aktif')
                ->get('tagihan_target_kelas')
                ->row_array();

            if (!$target) {
                continue;
            }

            $maxPaidRow = $this->db
                ->select_max('nominal_dibayar', 'max')
                ->where('id_tagihan_master', $id)
                ->where('id_kelas_setting', $target['id_kelas_setting'])
                ->where('status_tagihan', 'Aktif')
                ->get('tagihan_siswa')
                ->row_array();
            $maxPaid = $maxPaidRow ? (float) $maxPaidRow['max'] : 0;

            if ($nominal < $maxPaid) {
                $this->db->trans_rollback();
                return $this->model_response(
                    false,
                    'Tarif kelas ' . $target['nama_kelas'] . ' tidak boleh lebih kecil dari pembayaran yang sudah masuk.'
                );
            }

            $before = $target;
            $this->db->where('id', $idTarget)->update('tagihan_target_kelas', array(
                'nominal_kelas' => $nominal,
                'tanggal' => $this->tanggal_sekarang(),
                'waktu' => $this->waktu_sekarang(),
                'id_user' => $this->app_user_id(),
                'nama_user' => $this->app_user_name()
            ));

            $rows = $this->db
                ->where('id_tagihan_master', $id)
                ->where('id_kelas_setting', $target['id_kelas_setting'])
                ->where('status_tagihan', 'Aktif')
                ->get('tagihan_siswa')
                ->result_array();

            foreach ($rows as $row) {
                $update = array(
                    'nominal_awal' => $nominal,
                    'tanggal_update' => $this->tanggal_sekarang(),
                    'waktu_update' => $this->waktu_sekarang()
                );

                $special = $this->tarif_khusus_aktif(
                    $id,
                    (int) $row['id_siswa'],
                    (int) $row['bulan'],
                    (int) $row['tahun']
                );

                if ($special) {
                    $tarifAkhir = (float) $special['nominal_setelah_keringanan'];
                    $dibayar = (float) $row['nominal_dibayar'];
                    $sisa = max(0, $tarifAkhir - $dibayar);
                    $status = $sisa <= 0
                        ? 'Lunas'
                        : ($dibayar > 0 ? 'Dibayar Sebagian' : 'Belum Dibayar');

                    $update['jenis_keringanan'] = 'Tarif Khusus';
                    $update['nilai_keringanan'] = max(0, $nominal - $tarifAkhir);
                    $update['nominal_tagihan'] = $tarifAkhir;
                    $update['sisa_tagihan'] = $sisa;
                    $update['status_pembayaran'] = $status;
                } elseif (empty($row['jenis_keringanan'])) {
                    $dibayar = (float) $row['nominal_dibayar'];
                    $sisa = max(0, $nominal - $dibayar);
                    $status = $sisa <= 0
                        ? 'Lunas'
                        : ($dibayar > 0 ? 'Dibayar Sebagian' : 'Belum Dibayar');

                    $update['nilai_keringanan'] = 0;
                    $update['nominal_tagihan'] = $nominal;
                    $update['sisa_tagihan'] = $sisa;
                    $update['status_pembayaran'] = $status;
                }

                $this->db->where('id', $row['id'])->update('tagihan_siswa', $update);
            }

            $this->tagihan_log_activity(
                'Ubah Tarif Kelas',
                'Tagihan',
                'Ubah',
                'tagihan_target_kelas',
                $idTarget,
                $master['kode_tagihan'],
                $target['nama_kelas'] . ' menjadi ' . $this->rupiah($nominal),
                $before,
                array('nominal_kelas' => $nominal)
            );
        }

        return $this->tagihan_transaction_result('Tarif per kelas berhasil disimpan.');
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


    private function rupiah($nominal)
    {
        return 'Rp' . number_format((float) $nominal, 0, ',', '.');
    }


    private function nilai_nominal($value)
    {
        if (is_int($value) || is_float($value)) {
            return (float) $value;
        }

        $text = trim(str_ireplace(array('Rp', ' '), '', (string) $value));
        if (preg_match('/^-?\\d+\\.\\d{1,2}$/', $text)) {
            return (float) $text;
        }

        $clean = preg_replace('/[^0-9-]/', '', $text);
        if ($clean === '' || $clean === '-') {
            return 0;
        }

        return (float) $clean;
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
