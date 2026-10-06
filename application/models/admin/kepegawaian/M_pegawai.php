<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pegawai extends CI_Model
{
    public function jabatan_list()
    {
        return $this->db
            ->select('id, nama_jabatan')
            ->order_by('nama_jabatan', 'ASC')
            ->get('jabatan')
            ->result_array();
    }

    public function pegawai_result()
    {
        $search = trim((string) $this->input->post('search', true));
        $idJabatan = (int) $this->input->post('id_jabatan');

        $this->db
            ->select("p.*,
                COALESCE((
                    SELECT GROUP_CONCAT(
                        DISTINCT COALESCE(NULLIF(j.nama_jabatan, ''), pj.nama_jabatan)
                        ORDER BY COALESCE(NULLIF(j.nama_jabatan, ''), pj.nama_jabatan)
                        SEPARATOR ', '
                    )
                    FROM pegawai_jabatan pj
                    LEFT JOIN jabatan j
                        ON j.id = CAST(pj.id_jabatan AS UNSIGNED)
                    WHERE CAST(pj.id_pegawai AS UNSIGNED) = p.id
                ), '') AS jabatan,
                COALESCE((
                    SELECT GROUP_CONCAT(
                        DISTINCT pj.id_jabatan
                        ORDER BY CAST(pj.id_jabatan AS UNSIGNED)
                        SEPARATOR ','
                    )
                    FROM pegawai_jabatan pj
                    WHERE CAST(pj.id_pegawai AS UNSIGNED) = p.id
                ), '') AS jabatan_ids", false)
            ->from('pegawai p');

        if ($search !== '') {
            $this->db
                ->group_start()
                ->like('p.nama_pegawai', $search)
                ->or_like('p.no_tlp', $search)
                ->group_end();
        }

        if ($idJabatan > 0) {
            $this->db->where("EXISTS (
                SELECT 1
                FROM pegawai_jabatan pjf
                WHERE CAST(pjf.id_pegawai AS UNSIGNED) = p.id
                  AND CAST(pjf.id_jabatan AS UNSIGNED) = " . $idJabatan . "
            )", null, false);
        }

        $rows = $this->db
            ->order_by('p.nama_pegawai', 'ASC')
            ->get()
            ->result_array();

        foreach ($rows as &$row) {
            $row['tanggal_lahir_form'] = $this->tanggal_form($row['tanggal_lahir']);
        }
        unset($row);

        return $rows;
    }

    public function tambah()
    {
        $nama = trim((string) $this->input->post('nama_pegawai', true));
        $jk = trim((string) $this->input->post('jk', true));
        $tempatLahir = trim((string) $this->input->post('tempat_lahir', true));
        $tanggalLahir = trim((string) $this->input->post('tanggal_lahir', true));
        $noTlp = trim((string) $this->input->post('no_tlp', true));
        $jabatanIds = $this->post_ids('id_jabatan');

        $validasi = $this->validasi_input(
            $nama,
            $jk,
            $tempatLahir,
            $tanggalLahir,
            $jabatanIds
        );

        if ($validasi['result'] !== 'true') {
            return $validasi;
        }

        $jabatanRows = $validasi['jabatan_rows'];
        $tanggalLahir = $validasi['tanggal_lahir'];

        $dataPegawai = array(
            'id_daftar_guru' => 0,
            'nama_pegawai' => $nama,
            'jk' => $jk,
            'tempat_lahir' => $tempatLahir,
            'tanggal_lahir' => $tanggalLahir,
            'no_tlp' => $noTlp,
            'status_pendaftaran' => 'Offline',
            'status' => null
        );

        $this->db->trans_begin();

        $this->db->insert('pegawai', $dataPegawai);
        $idPegawai = (int) $this->db->insert_id();

        $jabatanSimpan = $this->simpan_jabatan($idPegawai, $nama, $jabatanRows);

        $after = array(
            'pegawai' => array_merge(array('id' => $idPegawai), $dataPegawai),
            'jabatan' => $jabatanSimpan
        );

        $this->tagihan_log_activity(
            'Tambah Pegawai',
            'Kepegawaian',
            'Tambah',
            'pegawai',
            $idPegawai,
            $nama,
            'Menambah data pegawai beserta jabatan',
            null,
            $after
        );

        return $this->tagihan_transaction_result('Data pegawai berhasil disimpan.');
    }

    public function edit()
    {
        $id = (int) $this->input->post('id');
        $nama = trim((string) $this->input->post('nama_pegawai', true));
        $jk = trim((string) $this->input->post('jk', true));
        $tempatLahir = trim((string) $this->input->post('tempat_lahir', true));
        $tanggalLahir = trim((string) $this->input->post('tanggal_lahir', true));
        $noTlp = trim((string) $this->input->post('no_tlp', true));
        $jabatanIds = $this->post_ids('id_jabatan');

        if ($id <= 0) {
            return $this->model_response(false, 'Data pegawai tidak ditemukan.');
        }

        $before = $this->pegawai_snapshot($id);
        if (!$before) {
            return $this->model_response(false, 'Data pegawai tidak ditemukan.');
        }

        $validasi = $this->validasi_input(
            $nama,
            $jk,
            $tempatLahir,
            $tanggalLahir,
            $jabatanIds
        );

        if ($validasi['result'] !== 'true') {
            return $validasi;
        }

        $jabatanRows = $validasi['jabatan_rows'];
        $tanggalLahir = $validasi['tanggal_lahir'];

        $dataPegawai = array(
            'nama_pegawai' => $nama,
            'jk' => $jk,
            'tempat_lahir' => $tempatLahir,
            'tanggal_lahir' => $tanggalLahir,
            'no_tlp' => $noTlp
        );

        $this->db->trans_begin();

        $this->db
            ->where('id', $id)
            ->update('pegawai', $dataPegawai);

        $this->db
            ->where('CAST(id_pegawai AS UNSIGNED)=' . $id, null, false)
            ->delete('pegawai_jabatan');

        $jabatanSimpan = $this->simpan_jabatan($id, $nama, $jabatanRows);

        $after = array(
            'pegawai' => array_merge(
                isset($before['pegawai']) ? $before['pegawai'] : array(),
                $dataPegawai
            ),
            'jabatan' => $jabatanSimpan
        );

        $this->tagihan_log_activity(
            'Ubah Pegawai',
            'Kepegawaian',
            'Ubah',
            'pegawai',
            $id,
            $nama,
            'Mengubah data pegawai beserta jabatan',
            $before,
            $after
        );

        return $this->tagihan_transaction_result('Data pegawai berhasil diupdate.');
    }

    public function hapus()
    {
        $id = (int) $this->input->post('id');
        $before = $this->pegawai_snapshot($id);

        if (!$before) {
            return $this->model_response(false, 'Data pegawai tidak ditemukan.');
        }

        $dipakaiUser = $this->db
            ->where('CAST(id_pegawai AS UNSIGNED)=' . $id, null, false)
            ->count_all_results('users');

        if ($dipakaiUser > 0) {
            return $this->model_response(
                false,
                'Pegawai sudah terhubung dengan akun User dan tidak dapat dihapus.'
            );
        }

        $nama = isset($before['pegawai']['nama_pegawai'])
            ? $before['pegawai']['nama_pegawai']
            : '-';

        $this->db->trans_begin();

        $this->db
            ->where('CAST(id_pegawai AS UNSIGNED)=' . $id, null, false)
            ->delete('pegawai_jabatan');

        $this->db
            ->where('id', $id)
            ->delete('pegawai');

        $this->tagihan_log_activity(
            'Hapus Pegawai',
            'Kepegawaian',
            'Batal',
            'pegawai',
            $id,
            $nama,
            'Menghapus data pegawai yang belum terhubung ke akun User',
            $before,
            null
        );

        return $this->tagihan_transaction_result('Pegawai berhasil dihapus.');
    }

    private function validasi_input($nama, $jk, $tempatLahir, $tanggalLahir, $jabatanIds)
    {
        if ($nama === '') {
            return $this->model_response(false, 'Nama pegawai wajib diisi.');
        }

        if ($jk === '') {
            return $this->model_response(false, 'Jenis kelamin wajib dipilih.');
        }

        if ($tempatLahir === '') {
            return $this->model_response(false, 'Tempat lahir wajib diisi.');
        }

        if ($tanggalLahir === '') {
            return $this->model_response(false, 'Tanggal lahir wajib diisi.');
        }

        if (empty($jabatanIds)) {
            return $this->model_response(false, 'Minimal satu jabatan wajib dipilih.');
        }

        $tanggalLahir = $this->tanggal_db($tanggalLahir);
        if ($tanggalLahir === '') {
            return $this->model_response(false, 'Format tanggal lahir tidak valid.');
        }

        $jabatanRows = $this->db
            ->where_in('id', $jabatanIds)
            ->get('jabatan')
            ->result_array();

        if (count($jabatanRows) !== count($jabatanIds)) {
            return $this->model_response(
                false,
                'Terdapat jabatan yang tidak ditemukan pada master.'
            );
        }

        return array(
            'result' => 'true',
            'jabatan_rows' => $jabatanRows,
            'tanggal_lahir' => $tanggalLahir
        );
    }

    private function simpan_jabatan($idPegawai, $namaPegawai, $jabatanRows)
    {
        $dataSimpan = array();

        foreach ($jabatanRows as $jabatan) {
            $row = array(
                'id_jabatan' => (string) $jabatan['id'],
                'id_pegawai' => (string) $idPegawai,
                'nama_jabatan' => $jabatan['nama_jabatan'],
                'nama_pegawai' => $namaPegawai
            );

            $this->db->insert('pegawai_jabatan', $row);
            $dataSimpan[] = $row;
        }

        return $dataSimpan;
    }

    private function pegawai_snapshot($idPegawai)
    {
        if ((int) $idPegawai <= 0) {
            return null;
        }

        $pegawai = $this->db
            ->where('id', (int) $idPegawai)
            ->get('pegawai')
            ->row_array();

        if (!$pegawai) {
            return null;
        }

        $jabatan = $this->db
            ->where('CAST(id_pegawai AS UNSIGNED)=' . (int) $idPegawai, null, false)
            ->order_by('id', 'ASC')
            ->get('pegawai_jabatan')
            ->result_array();

        return array(
            'pegawai' => $pegawai,
            'jabatan' => $jabatan
        );
    }

    private function post_ids($field)
    {
        $values = $this->input->post($field);

        if (!is_array($values)) {
            $values = $values === null || $values === ''
                ? array()
                : array($values);
        }

        $ids = array();
        foreach ($values as $value) {
            $id = (int) $value;
            if ($id > 0) {
                $ids[$id] = $id;
            }
        }

        return array_values($ids);
    }

    private function tanggal_db($tanggal)
    {
        $tanggal = trim((string) $tanggal);

        foreach (array('d-m-Y', 'Y-m-d') as $format) {
            $date = DateTime::createFromFormat($format, $tanggal);
            if ($date && $date->format($format) === $tanggal) {
                return $date->format('d-m-Y');
            }
        }

        return '';
    }

    private function tanggal_form($tanggal)
    {
        $tanggal = trim((string) $tanggal);

        foreach (array('d-m-Y', 'Y-m-d') as $format) {
            $date = DateTime::createFromFormat($format, $tanggal);
            if ($date && $date->format($format) === $tanggal) {
                return $date->format('d-m-Y');
            }
        }

        return $tanggal;
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
            'data_sebelum' => $before === null
                ? null
                : json_encode($before, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => $after === null
                ? null
                : json_encode($after, JSON_UNESCAPED_UNICODE),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => is_array($user) && isset($user['id'])
                ? (int) $user['id']
                : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== ''
                ? $user['nama']
                : 'Administrator'
        ));
    }
}