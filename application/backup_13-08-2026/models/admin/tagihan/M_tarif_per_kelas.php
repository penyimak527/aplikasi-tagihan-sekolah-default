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
            return model_response(false, 'Data tarif tidak lengkap.');
        }

        $this->db->trans_begin();

        foreach ($tarif as $idTarget => $nominalInput) {
            $idTarget = (int) $idTarget;
            $nominal = nilai_nominal($nominalInput);

            if ($nominal < 0) {
                $this->db->trans_rollback();
                return model_response(false, 'Tarif tidak boleh negatif.');
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
                return model_response(
                    false,
                    'Tarif kelas ' . $target['nama_kelas'] . ' tidak boleh lebih kecil dari pembayaran yang sudah masuk.'
                );
            }

            $before = $target;
            $this->db->where('id', $idTarget)->update('tagihan_target_kelas', array(
                'nominal_kelas' => $nominal,
                'tanggal' => tanggal_sekarang(),
                'waktu' => waktu_sekarang(),
                'id_user' => app_user_id(),
                'nama_user' => app_user_name()
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
                    'tanggal_update' => tanggal_sekarang(),
                    'waktu_update' => waktu_sekarang()
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

            tagihan_log_activity(
                'Ubah Tarif Kelas',
                'Tagihan',
                'Ubah',
                'tagihan_target_kelas',
                $idTarget,
                $master['kode_tagihan'],
                $target['nama_kelas'] . ' menjadi ' . rupiah($nominal),
                $before,
                array('nominal_kelas' => $nominal)
            );
        }

        return tagihan_transaction_result('Tarif per kelas berhasil disimpan.');
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
}
