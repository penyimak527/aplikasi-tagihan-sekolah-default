<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kelas_setting extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }

    public function kelas_list()
    {
        return $this->db->order_by('nama_kelas', 'ASC')->get('kelas')->result_array();
    }

    public function result()
    {
        $idPeriode = (int) $this->input->post('id_periode');
        $idKelas = (int) $this->input->post('id_kelas');
        $search = trim((string) $this->input->post('search', true));

        $this->db->select("ks.id,ks.id_periode,ks.id_kelas,COALESCE(NULLIF(ks.nama_kelas,''),k.nama_kelas) nama_kelas,ta.periode,k.jurusan,k.status,COUNT(kss.id) jumlah_siswa")
            ->from('kelas_setting ks')
            ->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')
            ->join('kelas k', 'k.id=CAST(ks.id_kelas AS UNSIGNED)', 'left')
            ->join('kelas_siswa kss', "CAST(kss.id_kelas_setting AS UNSIGNED)=ks.id AND kss.status_aktif='1'", 'left');

        if ($idPeriode > 0) $this->db->where('CAST(ks.id_periode AS UNSIGNED)=' . $idPeriode, null, false);
        if ($idKelas > 0) $this->db->where('CAST(ks.id_kelas AS UNSIGNED)=' . $idKelas, null, false);
        if ($search !== '') {
            $this->db->group_start()
                ->like('ks.nama_kelas', $search)
                ->or_like('k.nama_kelas', $search)
                ->group_end();
        }

        return $this->db->group_by('ks.id')
            ->order_by('ta.id', 'DESC')
            ->order_by('nama_kelas', 'ASC')
            ->get()->result_array();
    }

    public function simpan()
    {
        $id = (int) $this->input->post('id');
        $idPeriode = (int) $this->input->post('id_periode');
        $konfirmasi = $this->input->post('konfirmasi', true) === 'Ya';

        if (!$idPeriode) {
            return $this->model_response(false, 'Tahun ajaran wajib dipilih.');
        }

        $periode = $this->db->where('id', $idPeriode)->get('master_tahun_ajaran')->row_array();
        if (!$periode) {
            return $this->model_response(false, 'Tahun ajaran tidak ditemukan pada master.');
        }

        // Tambah: satu Tahun Ajaran dapat langsung dipasangkan ke beberapa kelas.
        // Setiap kelas tetap disimpan sebagai satu row kelas_setting tersendiri.
        if (!$id) {
            $postKelas = $this->input->post('id_kelas');
            $postKelas = is_array($postKelas) ? $postKelas : array($postKelas);

            $idKelasList = array();
            foreach ($postKelas as $kelasId) {
                $kelasId = (int) $kelasId;
                if ($kelasId > 0 && !in_array($kelasId, $idKelasList, true)) {
                    $idKelasList[] = $kelasId;
                }
            }

            if (empty($idKelasList)) {
                return $this->model_response(false, 'Pilih minimal satu kelas.');
            }

            $this->db->trans_begin();
            $berhasil = 0;
            $duplikat = 0;
            $tidakDitemukan = 0;

            foreach ($idKelasList as $idKelas) {
                $kelas = $this->db->where('id', $idKelas)->get('kelas')->row_array();
                if (!$kelas) {
                    $tidakDitemukan++;
                    continue;
                }

                $duplicate = $this->db
                    ->where('CAST(id_periode AS UNSIGNED)=' . $idPeriode, null, false)
                    ->where('CAST(id_kelas AS UNSIGNED)=' . $idKelas, null, false)
                    ->count_all_results('kelas_setting');

                if ($duplicate > 0) {
                    $duplikat++;
                    continue;
                }

                $data = array(
                    'id_periode' => (string) $idPeriode,
                    'id_kelas' => (string) $idKelas,
                    'nama_kelas' => $kelas['nama_kelas'],
                    'semester' => null,
                    'id_guru' => null,
                    'wali_kelas' => null
                );

                $this->db->insert('kelas_setting', $data);
                $newId = (int) $this->db->insert_id();

                $this->tagihan_log_activity(
                    'Tambah Kelas Setting',
                    'Master Data',
                    'Tambah',
                    'kelas_setting',
                    $newId,
                    $periode['periode'] . ' - ' . $kelas['nama_kelas'],
                    'Pengaturan kelas per tahun ajaran',
                    null,
                    $data
                );

                $berhasil++;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return $this->model_response(false, 'Proses database gagal. Tidak ada perubahan yang disimpan.');
            }

            if ($berhasil === 0) {
                $this->db->trans_rollback();
                if ($duplikat > 0 && $tidakDitemukan === 0) {
                    return $this->model_response(false, 'Semua kombinasi Tahun Ajaran dan Kelas yang dipilih sudah tersedia.');
                }
                return $this->model_response(false, 'Tidak ada Kelas Setting yang dapat ditambahkan.');
            }

            $this->db->trans_commit();

            $message = $berhasil . ' Kelas Setting berhasil ditambahkan.';
            if ($duplikat > 0) {
                $message .= ' ' . $duplikat . ' kelas dilewati karena sudah tersedia.';
            }
            if ($tidakDitemukan > 0) {
                $message .= ' ' . $tidakDitemukan . ' kelas dilewati karena tidak ditemukan pada master.';
            }

            return $this->model_response(true, $message);
        }

        // Edit tetap satu kelas per record agar histori kelas_setting yang sudah ada
        // tidak berubah menjadi satu record dengan banyak kelas.
        $idKelas = (int) $this->input->post('id_kelas');
        if (!$idKelas) {
            return $this->model_response(false, 'Kelas wajib dipilih.');
        }

        $kelas = $this->db->where('id', $idKelas)->get('kelas')->row_array();
        if (!$kelas) {
            return $this->model_response(false, 'Kelas tidak ditemukan pada master.');
        }

        $duplicate = $this->db
            ->where('CAST(id_periode AS UNSIGNED)=' . $idPeriode, null, false)
            ->where('CAST(id_kelas AS UNSIGNED)=' . $idKelas, null, false)
            ->where('id !=', $id)
            ->count_all_results('kelas_setting');
        if ($duplicate > 0) {
            return $this->model_response(false, 'Kombinasi tahun ajaran dan kelas sudah tersedia.');
        }

        $before = $this->db->where('id', $id)->get('kelas_setting')->row_array();
        if (!$before) return $this->model_response(false, 'Kelas Setting tidak ditemukan.');

        $used = 0;
        $structuralChange = ((int)$before['id_periode'] !== $idPeriode || (int)$before['id_kelas'] !== $idKelas);
        if ($structuralChange) {
            $used = $this->db->where('id_kelas_setting', (string)$id)->count_all_results('kelas_siswa');
            if ($used > 0 && !$konfirmasi) {
                return array(
                    'result' => 'confirm',
                    'message' => 'Kelas Setting sudah digunakan pada penempatan siswa. Agar riwayat kelas_siswa tidak berubah, pengaturan lama akan dipertahankan dan perubahan disimpan sebagai Kelas Setting baru. Tetap lanjutkan?'
                );
            }
        }

        $data = array(
            'id_periode' => (string) $idPeriode,
            'id_kelas' => (string) $idKelas,
            'nama_kelas' => $kelas['nama_kelas'],
            'semester' => null,
            'id_guru' => null,
            'wali_kelas' => null
        );

        $this->db->trans_begin();
        $preserveHistory = ($structuralChange && $used > 0 && $konfirmasi);
        if ($preserveHistory) {
            // Jangan ubah kelas_setting yang sudah dirujuk kelas_siswa karena akan
            // mengubah arti riwayat penempatan. Simpan pilihan baru sebagai mapping baru.
            $this->db->insert('kelas_setting', $data);
            $id = (int) $this->db->insert_id();
        } else {
            $this->db->where('id', $id)->update('kelas_setting', $data);
        }

        $this->tagihan_log_activity(
            $preserveHistory ? 'Tambah Kelas Setting dari Perubahan' : 'Ubah Kelas Setting',
            'Master Data',
            $preserveHistory ? 'Tambah' : 'Ubah',
            'kelas_setting',
            $id,
            $periode['periode'] . ' - ' . $kelas['nama_kelas'],
            'Pengaturan kelas per tahun ajaran',
            $before,
            $data
        );

        return $this->tagihan_transaction_result($preserveHistory
            ? 'Kelas Setting baru berhasil dibuat. Pengaturan lama tetap dipertahankan karena sudah digunakan pada riwayat siswa.'
            : 'Kelas Setting berhasil disimpan.');
    }

    public function hapus()
    {
        $id = (int) $this->input->post('id');
        $row = $this->db->query("SELECT ks.*,ta.periode,COALESCE(NULLIF(ks.nama_kelas,''),k.nama_kelas) nama_kelas FROM kelas_setting ks LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(ks.id_periode AS UNSIGNED) LEFT JOIN kelas k ON k.id=CAST(ks.id_kelas AS UNSIGNED) WHERE ks.id=?", array($id))->row_array();
        if (!$row) return $this->model_response(false, 'Kelas Setting tidak ditemukan.');

        if ($this->db->where('id_kelas_setting', (string)$id)->count_all_results('kelas_siswa') > 0) {
            return $this->model_response(false, 'Kelas Setting sudah digunakan pada penempatan siswa dan tidak dapat dihapus.');
        }

        $this->db->trans_begin();
        $this->db->where('id', $id)->delete('kelas_setting');
        $this->tagihan_log_activity('Hapus Kelas Setting', 'Master Data', 'Batal', 'kelas_setting', $id, $row['periode'] . ' - ' . $row['nama_kelas'], 'Menghapus Kelas Setting yang belum digunakan', $row, null);
        return $this->tagihan_transaction_result('Kelas Setting berhasil dihapus.');
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
