<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_metode_pembayaran extends CI_Model
{
    public function result()
    {
        $search = trim((string) $this->input->post('search', true));
        $status = trim((string) $this->input->post('status', true));

        $this->db->from('tagihan_metode_pembayaran');
        if ($search !== '') {
            $this->db->group_start()
                ->like('nama_metode', $search)
                ->or_like('keterangan', $search)
                ->group_end();
        }
        if ($status !== '') {
            $this->db->where('status', $status);
        }

        return $this->db
            ->order_by('urutan', 'ASC')
            ->order_by('id', 'ASC')
            ->get()
            ->result_array();
    }

    private function jenis_otomatis($nama, $butuhUang)
    {
        $namaLower = strtolower($nama);
        if ($butuhUang === 'Ya' || strpos($namaLower, 'tunai') !== false) {
            return 'Tunai';
        }
        if (strpos($namaLower, 'transfer') !== false || strpos($namaLower, 'bank') !== false) {
            return 'Transfer';
        }
        if (strpos($namaLower, 'qris') !== false || strpos($namaLower, 'qr') !== false) {
            return 'QRIS';
        }
        return 'Lainnya';
    }

    private function nama_aktif_sudah_digunakan($nama, $idKecuali = 0)
    {
        $nama = strtolower(trim((string) $nama));

        $this->db->from('tagihan_metode_pembayaran');

        $this->db->where(
            'LOWER(TRIM(nama_metode)) = ' . $this->db->escape($nama),
            null,
            false
        );

        $this->db->where('status', 'Aktif');

        if ((int) $idKecuali > 0) {
            $this->db->where('id !=', (int) $idKecuali);
        }

        return $this->db->count_all_results() > 0;
    }

    public function simpan()
    {
        $id = (int) $this->input->post('id');
        $nama = trim((string) $this->input->post('nama_metode', true));
        $butuhUang = $this->input->post('butuh_uang_diterima', true) === 'Ya' ? 'Ya' : 'Tidak';
        $status = $this->input->post('status', true) === 'Nonaktif' ? 'Nonaktif' : 'Aktif';
        $keterangan = trim((string) $this->input->post('keterangan', true));

        if ($nama === '') {
            return $this->model_response(false, 'Nama metode pembayaran wajib diisi.');
        }

        if (
            $status === 'Aktif'
            && $this->nama_aktif_sudah_digunakan($nama, $id)
        ) {
            return $this->model_response(
                false,
                'Nama metode pembayaran aktif sudah digunakan.'
            );
        }

        $before = $id
            ? $this->db->where('id', $id)->get('tagihan_metode_pembayaran')->row_array()
            : null;

        $kode = $before && !empty($before['kode_metode'])
            ? $before['kode_metode']
            : 'MET-' . strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $nama), 0, 10));

        $urutan = $before
            ? (int) $before['urutan']
            : ((int) $this->db->select_max('urutan', 'maks')->get('tagihan_metode_pembayaran')->row()->maks + 1);

        $data = array_merge(array(
            'kode_metode' => $kode,
            'nama_metode' => $nama,
            'jenis_metode' => $this->jenis_otomatis($nama, $butuhUang),
            'butuh_uang_diterima' => $butuhUang,
            'status' => $status,
            'urutan' => $urutan,
            'keterangan' => $keterangan
        ), $this->tagihan_audit_fields());

        $this->db->trans_begin();
        if ($id > 0) {
            $this->db->where('id', $id)->update('tagihan_metode_pembayaran', $data);
        } else {
            $this->db->insert('tagihan_metode_pembayaran', $data);
            $id = $this->db->insert_id();
        }

        $this->tagihan_log_activity(
            $before ? 'Ubah Metode Pembayaran' : 'Tambah Metode Pembayaran',
            'Master Data',
            $before ? 'Ubah' : 'Tambah',
            'tagihan_metode_pembayaran',
            $id,
            $kode,
            'Pengelolaan metode pembayaran',
            $before,
            $data
        );

        return $this->tagihan_transaction_result('Metode pembayaran berhasil disimpan.');
    }

    public function ubah_status()
    {
        $id = (int) $this->input->post('id');
        $row = $this->db->where('id', $id)->get('tagihan_metode_pembayaran')->row_array();
        if (!$row) {
            return $this->model_response(false, 'Data metode pembayaran tidak ditemukan.');
        }

        $status = $row['status'] === 'Aktif' ? 'Nonaktif' : 'Aktif';
        if (
            $status === 'Aktif'
            && $this->nama_aktif_sudah_digunakan($row['nama_metode'], $id)
        ) {
            return $this->model_response(
                false,
                'Tidak dapat diaktifkan karena nama metode aktif sudah tersedia.'
            );
        }

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('tagihan_metode_pembayaran', array(
            'status' => $status,
            'tanggal' => $this->tanggal_sekarang(),
            'waktu' => $this->waktu_sekarang(),
            'id_user' => $this->app_user_id(),
            'nama_user' => $this->app_user_name()
        ));

        $this->tagihan_log_activity(
            'Ubah Status Metode',
            'Master Data',
            'Ubah',
            'tagihan_metode_pembayaran',
            $id,
            $row['kode_metode'],
            'Status menjadi ' . $status,
            $row,
            array('status' => $status)
        );

        return $this->tagihan_transaction_result('Status metode pembayaran berhasil diubah.');
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


    private function tagihan_audit_fields()
    {
        $user = $this->session->userdata('admin');
        return array(
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => is_array($user) && isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator'
        );
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
