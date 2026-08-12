<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_tarif_khusus_siswa extends CI_Model
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
            "SELECT DISTINCT id_kelas_setting, nama_kelas
            FROM tagihan_siswa
            WHERE id_tagihan_master=?
              AND status_tagihan='Aktif'
            ORDER BY nama_kelas",
            array($id)
        )->result_array();

        $periods = $this->db
            ->where('id_tagihan_master', $id)
            ->where('status', 'Aktif')
            ->order_by('tahun', 'ASC')
            ->order_by('bulan', 'ASC')
            ->get('tagihan_tarif_bulan')
            ->result_array();

        return array(
            'result' => 'true',
            'master' => $master,
            'classes' => $classes,
            'periods' => $periods
        );
    }

    public function cari_siswa()
    {
        $id = (int) $this->input->post('id_tagihan');
        $q = trim((string) $this->input->post('q', true));
        $idKelasSetting = (int) $this->input->post('id_kelas_setting');
        $statusTarif = trim((string) $this->input->post('status_tarif', true));

        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$master) {
            return array();
        }

        $like = '%' . $q . '%';
        $sql = "SELECT
                    id_siswa,
                    nis,
                    nisn,
                    nama_siswa,
                    id_kelas_setting,
                    nama_kelas,
                    MIN(nominal_awal) nominal_normal_min,
                    MAX(nominal_awal) nominal_normal_max,
                    SUM(nominal_dibayar) nominal_dibayar
                FROM tagihan_siswa
                WHERE id_tagihan_master=?
                  AND status_tagihan='Aktif'
                  AND (nama_siswa LIKE ? OR nis LIKE ? OR nisn LIKE ?)";
        $params = array($id, $like, $like, $like);

        if ($idKelasSetting > 0) {
            $sql .= " AND id_kelas_setting=?";
            $params[] = $idKelasSetting;
        }

        $sql .= " GROUP BY id_siswa,nis,nisn,nama_siswa,id_kelas_setting,nama_kelas
                  ORDER BY nama_siswa
                  LIMIT 500";

        $rows = $this->db->query($sql, $params)->result_array();
        $hasil = array();

        foreach ($rows as $row) {
            $sid = (int) $row['id_siswa'];
            $specials = $this->db
                ->where('id_tagihan_master', $id)
                ->where('id_siswa', $sid)
                ->where('jenis_keringanan', 'Tarif Khusus')
                ->where('status', 'Aktif')
                ->order_by('id', 'DESC')
                ->get('tagihan_keringanan_siswa')
                ->result_array();

            $status = $specials ? 'Tarif Khusus' : 'Normal';
            if ($statusTarif !== '' && $statusTarif !== 'Semua' && $statusTarif !== $status) {
                continue;
            }

            $detail = $this->db
                ->where('id_tagihan_master', $id)
                ->where('id_siswa', $sid)
                ->where('status_tagihan', 'Aktif')
                ->order_by('tahun', 'ASC')
                ->order_by('bulan', 'ASC')
                ->get('tagihan_siswa')
                ->result_array();

            $periodeRows = array();
            foreach ($detail as $item) {
                $special = $this->tarif_khusus_aktif(
                    $id,
                    $sid,
                    (int) $item['bulan'],
                    (int) $item['tahun']
                );

                $periodeRows[] = array(
                    'bulan' => (int) $item['bulan'],
                    'tahun' => (int) $item['tahun'],
                    'nama_bulan' => $item['nama_bulan'],
                    'nominal_normal' => (float) $item['nominal_awal'],
                    'nominal_akhir' => (float) $item['nominal_tagihan'],
                    'nominal_dibayar' => (float) $item['nominal_dibayar'],
                    'tarif_khusus_aktif' => $special ? 1 : 0,
                    'nominal_khusus' => $special ? (float) $special['nominal_setelah_keringanan'] : 0
                );
            }

            $latest = $specials ? $specials[0] : null;
            $normalMin = (float) $row['nominal_normal_min'];
            $normalMax = (float) $row['nominal_normal_max'];
            $nominalAkhir = $latest
                ? (float) $latest['nominal_setelah_keringanan']
                : $normalMax;

            $row['nominal_normal'] = $normalMax;
            $row['normal_bervariasi'] = abs($normalMax - $normalMin) > 0.00001 ? 1 : 0;
            $row['status_tarif'] = $status;
            $row['nominal_akhir'] = $nominalAkhir;
            $row['nominal_khusus'] = $latest ? (float) $latest['nominal_setelah_keringanan'] : $normalMax;
            $row['berlaku_untuk_aktif'] = $latest && (int) $latest['bulan'] > 0 ? 'Bulan' : 'Tagihan';
            $row['bulan_khusus'] = $latest ? (int) $latest['bulan'] : 0;
            $row['tahun_khusus'] = $latest ? (int) $latest['tahun'] : 0;
            $row['alasan_aktif'] = $latest ? $latest['alasan'] : '';
            $row['jumlah_tarif_khusus_aktif'] = count($specials);
            $row['periode_berlaku'] = $this->label_periode_tarif($latest, count($specials));
            $row['periode_rows'] = $periodeRows;

            $hasil[] = $row;
        }

        return $hasil;
    }

    public function simpan()
    {
        $id = (int) $this->input->post('id_tagihan');
        $sid = (int) $this->input->post('id_siswa');
        $nominal = nilai_nominal($this->input->post('nominal_khusus'));
        $berlakuUntuk = trim((string) $this->input->post('berlaku_untuk', true));
        $bulan = (int) $this->input->post('bulan');
        $tahun = (int) $this->input->post('tahun');
        $alasan = trim((string) $this->input->post('alasan', true));

        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$master || !$sid || $alasan === '' || $nominal < 0) {
            return model_response(false, 'Siswa, nominal khusus, dan alasan wajib diisi.');
        }

        if ($master['tipe_tagihan'] !== 'Bulanan') {
            $berlakuUntuk = 'Tagihan';
        }
        if (!in_array($berlakuUntuk, array('Bulan', 'Tagihan'), true)) {
            $berlakuUntuk = 'Tagihan';
        }

        $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $sid)
            ->where('status_tagihan', 'Aktif');
        if ($berlakuUntuk === 'Bulan') {
            if ($bulan < 1 || $bulan > 12 || $tahun <= 0) {
                return model_response(false, 'Bulan berlaku tarif khusus wajib dipilih.');
            }
            $this->db->where('bulan', $bulan)->where('tahun', $tahun);
        }
        $rows = $this->db->get('tagihan_siswa')->result_array();

        if (!$rows) {
            return model_response(false, 'Tagihan siswa pada periode yang dipilih tidak ditemukan.');
        }

        $maxPaid = 0;
        foreach ($rows as $row) {
            $maxPaid = max($maxPaid, (float) $row['nominal_dibayar']);
        }
        if ($nominal < $maxPaid) {
            return model_response(false, 'Tarif khusus tidak boleh lebih kecil dari pembayaran yang sudah masuk.');
        }

        $first = $rows[0];
        $normalValues = array_map(function ($row) {
            return (float) $row['nominal_awal'];
        }, $rows);
        $normalRiwayat = max($normalValues);

        $this->db->trans_begin();

        $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $sid)
            ->where('jenis_keringanan', 'Tarif Khusus')
            ->where('status', 'Aktif');

        if ($berlakuUntuk === 'Bulan') {
            $this->db->where('bulan', $bulan)->where('tahun', $tahun);
        }

        $this->db->update('tagihan_keringanan_siswa', array(
            'status' => 'Dibatalkan',
            'tanggal_batal' => tanggal_sekarang(),
            'waktu_batal' => waktu_sekarang(),
            'id_user_batal' => app_user_id(),
            'nama_user_batal' => app_user_name(),
            'alasan_batal' => 'Diganti tarif khusus baru'
        ));

        $this->db->insert('tagihan_keringanan_siswa', array(
            'id_tagihan_master' => $id,
            'id_siswa' => $sid,
            'nis' => $first['nis'],
            'nisn' => $first['nisn'],
            'nama_siswa' => $first['nama_siswa'],
            'bulan' => $berlakuUntuk === 'Bulan' ? $bulan : 0,
            'tahun' => $berlakuUntuk === 'Bulan' ? $tahun : 0,
            'jenis_keringanan' => 'Tarif Khusus',
            'nominal_awal' => $normalRiwayat,
            'nilai_keringanan' => max(0, $normalRiwayat - $nominal),
            'nominal_setelah_keringanan' => $nominal,
            'alasan' => $alasan,
            'status' => 'Aktif',
            'tanggal_mulai' => tanggal_sekarang(),
            'tanggal' => tanggal_sekarang(),
            'waktu' => waktu_sekarang(),
            'id_user' => app_user_id(),
            'nama_user' => app_user_name()
        ));

        foreach ($rows as $row) {
            $dibayar = (float) $row['nominal_dibayar'];
            $sisa = max(0, $nominal - $dibayar);
            $status = $sisa <= 0
                ? 'Lunas'
                : ($dibayar > 0 ? 'Dibayar Sebagian' : 'Belum Dibayar');

            $this->db->where('id', $row['id'])->update('tagihan_siswa', array(
                'jenis_keringanan' => 'Tarif Khusus',
                'nilai_keringanan' => max(0, (float) $row['nominal_awal'] - $nominal),
                'nominal_tagihan' => $nominal,
                'sisa_tagihan' => $sisa,
                'status_pembayaran' => $status,
                'tanggal_update' => tanggal_sekarang(),
                'waktu_update' => waktu_sekarang()
            ));
        }

        $periodeLabel = $berlakuUntuk === 'Bulan'
            ? nama_bulan($bulan) . ' ' . $tahun
            : 'Tagihan ini';

        tagihan_log_activity(
            'Tarif Khusus Siswa',
            'Tagihan',
            'Ubah',
            'tagihan_siswa',
            $sid,
            $master['kode_tagihan'],
            $first['nama_siswa'] . ' menjadi ' . rupiah($nominal) . ' (' . $periodeLabel . ') - ' . $alasan,
            $first,
            array(
                'nominal_khusus' => $nominal,
                'berlaku_untuk' => $berlakuUntuk,
                'bulan' => $berlakuUntuk === 'Bulan' ? $bulan : 0,
                'tahun' => $berlakuUntuk === 'Bulan' ? $tahun : 0
            )
        );

        return tagihan_transaction_result('Tarif khusus siswa berhasil disimpan.');
    }

    public function kembalikan_normal()
    {
        $id = (int) $this->input->post('id_tagihan');
        $sid = (int) $this->input->post('id_siswa');
        $alasan = trim((string) $this->input->post('alasan', true));

        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$master || !$sid) {
            return model_response(false, 'Tagihan atau siswa tidak ditemukan.');
        }
        if ($alasan === '') {
            $alasan = 'Dikembalikan ke tarif normal';
        }

        $specials = $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $sid)
            ->where('jenis_keringanan', 'Tarif Khusus')
            ->where('status', 'Aktif')
            ->get('tagihan_keringanan_siswa')
            ->result_array();

        if (!$specials) {
            return model_response(false, 'Siswa tidak memiliki tarif khusus aktif.');
        }

        $rows = $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $sid)
            ->where('status_tagihan', 'Aktif')
            ->get('tagihan_siswa')
            ->result_array();

        if (!$rows) {
            return model_response(false, 'Tagihan siswa tidak ditemukan.');
        }

        $this->db->trans_begin();

        $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $sid)
            ->where('jenis_keringanan', 'Tarif Khusus')
            ->where('status', 'Aktif')
            ->update('tagihan_keringanan_siswa', array(
                'status' => 'Dibatalkan',
                'tanggal_batal' => tanggal_sekarang(),
                'waktu_batal' => waktu_sekarang(),
                'id_user_batal' => app_user_id(),
                'nama_user_batal' => app_user_name(),
                'alasan_batal' => $alasan
            ));

        foreach ($rows as $row) {
            if (!$this->row_terkena_special($row, $specials)) {
                continue;
            }
            if ($row['jenis_keringanan'] !== 'Tarif Khusus') {
                continue;
            }

            $normal = (float) $row['nominal_awal'];
            $dibayar = (float) $row['nominal_dibayar'];
            if ($normal < $dibayar) {
                $this->db->trans_rollback();
                return model_response(false, 'Tarif normal tidak boleh lebih kecil dari pembayaran yang sudah masuk.');
            }

            $sisa = max(0, $normal - $dibayar);
            $status = $sisa <= 0
                ? 'Lunas'
                : ($dibayar > 0 ? 'Dibayar Sebagian' : 'Belum Dibayar');

            $this->db->where('id', $row['id'])->update('tagihan_siswa', array(
                'jenis_keringanan' => null,
                'nilai_keringanan' => 0,
                'nominal_tagihan' => $normal,
                'sisa_tagihan' => $sisa,
                'status_pembayaran' => $status,
                'tanggal_update' => tanggal_sekarang(),
                'waktu_update' => waktu_sekarang()
            ));
        }

        $first = $rows[0];
        tagihan_log_activity(
            'Kembalikan Tarif Normal',
            'Tagihan',
            'Ubah',
            'tagihan_siswa',
            $sid,
            $master['kode_tagihan'],
            $first['nama_siswa'] . ' dikembalikan ke tarif normal - ' . $alasan,
            array('jenis_keringanan' => 'Tarif Khusus'),
            array('jenis_keringanan' => null)
        );

        return tagihan_transaction_result('Tarif siswa berhasil dikembalikan ke tarif normal.');
    }

    public function riwayat()
    {
        $id = (int) $this->input->post('id_tagihan');
        $sid = (int) $this->input->post('id_siswa');

        return $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $sid)
            ->where('jenis_keringanan', 'Tarif Khusus')
            ->order_by('id', 'DESC')
            ->get('tagihan_keringanan_siswa')
            ->result_array();
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

    private function row_terkena_special($row, $specials)
    {
        foreach ($specials as $special) {
            if ((int) $special['bulan'] === 0 && (int) $special['tahun'] === 0) {
                return true;
            }
            if ((int) $special['bulan'] === (int) $row['bulan'] && (int) $special['tahun'] === (int) $row['tahun']) {
                return true;
            }
        }
        return false;
    }

    private function label_periode_tarif($latest, $jumlahAktif)
    {
        if (!$latest) {
            return 'Normal';
        }
        if ((int) $latest['bulan'] === 0 && (int) $latest['tahun'] === 0) {
            return 'Tagihan ini';
        }

        $label = nama_bulan((int) $latest['bulan']) . ' ' . (int) $latest['tahun'];
        if ($jumlahAktif > 1) {
            $label .= ' +' . ($jumlahAktif - 1) . ' periode';
        }
        return $label;
    }
}
