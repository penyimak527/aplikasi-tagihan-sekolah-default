<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_import_siswa extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }
    public function kelas_list()
    {
        return $this->db->select('ks.*,ta.periode')->from('kelas_setting ks')->join('master_tahun_ajaran ta', 'ta.id=CAST(ks.id_periode AS UNSIGNED)', 'left')->order_by('ta.id', 'DESC')->order_by('ks.nama_kelas')->get()->result_array();
    }
    public function riwayat()
    {
        return $this->db->order_by('id', 'DESC')->limit(20)->get('tagihan_import_siswa')->result_array();
    }

    public function preview()
    {
        $id_periode = (int) $this->input->post('id_periode');
        $id_kelas_setting = (int) $this->input->post('id_kelas_setting');
        $periode = $this->db->where('id', $id_periode)->get('master_tahun_ajaran')->row_array();
        $kelas = $this->db->where('id', $id_kelas_setting)->get('kelas_setting')->row_array();
        if (!$periode || !$kelas || ((int) $kelas['id_periode'] !== $id_periode))
            return $this->model_response(false, 'Tahun ajaran dan kelas penempatan tidak sesuai.');
        if (empty($_FILES['file_excel']['name']))
            return $this->model_response(false, 'Pilih file XLSX terlebih dahulu.');
        $ext = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'xlsx')
            return $this->model_response(false, 'File yang diterima hanya format .xlsx.');
        $dir = FCPATH . 'uploads/import_siswa/';
        if (!is_dir($dir))
            mkdir($dir, 0755, true);
        $filename = 'preview_' . date('YmdHis') . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $_FILES['file_excel']['name']);
        $path = $dir . $filename;
        if (!move_uploaded_file($_FILES['file_excel']['tmp_name'], $path))
            return $this->model_response(false, 'File gagal diunggah.');
        try {
            $this->load->library('Simple_xlsx_reader');
            $rows = $this->simple_xlsx_reader->read($path);
        } catch (Exception $e) {
            @unlink($path);
            return $this->model_response(false, $e->getMessage());
        }
        if (count($rows) < 2) {
            @unlink($path);
            return $this->model_response(false, 'File tidak memiliki data siswa.');
        }
        $headers = array_map(function ($v) {
            return strtoupper(trim(preg_replace('/\s+/', '_', str_replace(array('/', '-'), '_', $v)))); }, $rows[0]);
        $required = array('NIS', 'NISN', 'NAMA_LENGKAP', 'JENIS_KELAMIN');
        foreach ($required as $h)
            if (!in_array($h, $headers, true)) {
                @unlink($path);
                return $this->model_response(false, 'Kolom wajib ' . $h . ' tidak ditemukan.');
            }
        $seenNis = array();
        $seenNisn = array();
        $preview = array();
        $valid = 0;
        $invalid = 0;
        $duplicate = 0;
        for ($i = 1; $i < count($rows); $i++) {
            if (!array_filter($rows[$i], function ($v) {
                return trim((string) $v) !== ''; }))
                continue;
            $item = array();
            foreach ($headers as $idx => $h)
                $item[$h] = isset($rows[$i][$idx]) ? trim((string) $rows[$i][$idx]) : '';
            $errors = array();
            $nis = $item['NIS'];
            $nisn = $item['NISN'];
            $nama = $item['NAMA_LENGKAP'];
            $jk = $item['JENIS_KELAMIN'];
            if ($nis === '' || $nisn === '' || $nama === '' || $jk === '')
                $errors[] = 'Kolom wajib belum lengkap';
            if (isset($seenNis[$nis]))
                $errors[] = 'NIS duplikat dalam file';
            if (isset($seenNisn[$nisn]))
                $errors[] = 'NISN duplikat dalam file';
            $seenNis[$nis] = true;
            $seenNisn[$nisn] = true;
            if ($nis !== '' && $this->db->where('nis', $nis)->count_all_results('siswa'))
                $errors[] = 'NIS sudah ada di database';
            if ($nisn !== '' && $this->db->where('nisn', $nisn)->count_all_results('siswa'))
                $errors[] = 'NISN sudah ada di database';
            if (!empty($item['NAMA_KELAS']) && strcasecmp($item['NAMA_KELAS'], $kelas['nama_kelas']) !== 0)
                $errors[] = 'Nama kelas tidak sama dengan kelas penempatan';
            $status = $errors ? 'Gagal' : 'Valid';
            if ($errors) {
                $invalid++;
                $isDuplicate = false;
                foreach ($errors as $errorText) {
                    $errorLower = strtolower($errorText);
                    if (strpos($errorLower, 'duplikat') !== false || strpos($errorLower, 'sudah ada') !== false) {
                        $isDuplicate = true;
                        break;
                    }
                }
                if ($isDuplicate) {
                    $duplicate++;
                }
            } else {
                $valid++;
            }
            $preview[] = array('baris' => $i + 1, 'nis' => $nis, 'nisn' => $nisn, 'nama' => $nama, 'jk' => $jk, 'kelas' => $item['NAMA_KELAS'] ?: $kelas['nama_kelas'], 'status' => $status, 'pesan' => implode('; ', $errors), 'data' => $item);
        }
        $token = bin2hex(random_bytes(16));
        $this->session->set_userdata('import_preview_' . $token, array('path' => $path, 'filename' => $filename, 'id_periode' => $id_periode, 'periode' => $periode['periode'], 'id_kelas_setting' => $id_kelas_setting, 'kelas' => $kelas, 'rows' => $preview));
        return $this->model_response(true, 'Preview berhasil dibuat.', array(
            'token' => $token,
            'rows' => $preview,
            'total' => count($preview),
            'valid' => $valid,
            'gagal' => $invalid,
            'duplikat' => $duplicate
        ));
    }

    public function proses()
    {
        $token = trim((string) $this->input->post('token', true));
        $session = $this->session->userdata('import_preview_' . $token);
        if (!$session)
            return $this->model_response(false, 'Data preview tidak ditemukan atau sudah kedaluwarsa.');
        $validRows = array_values(array_filter($session['rows'], function ($r) {
            return $r['status'] === 'Valid'; }));
        if (!$validRows)
            return $this->model_response(false, 'Tidak ada data valid yang dapat diimport.');
        $kode = 'IMP/' . date('Ym') . '/' . str_pad(((int) $this->db->count_all('tagihan_import_siswa')) + 1, 5, '0', STR_PAD_LEFT);
        $audit = $this->tagihan_audit_fields();
        $header = array_merge(array('kode_import' => $kode, 'nama_file' => $session['filename'], 'lokasi_file' => str_replace(FCPATH, '', $session['path']), 'id_periode' => $session['id_periode'], 'periode' => $session['periode'], 'id_kelas_setting' => $session['id_kelas_setting'], 'nama_kelas' => $session['kelas']['nama_kelas'], 'jumlah_data' => count($session['rows']), 'jumlah_berhasil' => 0, 'jumlah_gagal' => count($session['rows']) - count($validRows), 'status_import' => 'Diproses', 'keterangan' => 'Import siswa dari template XLSX'), $audit);
        $this->db->trans_begin();
        $this->db->insert('tagihan_import_siswa', $header);
        $idImport = $this->db->insert_id();
        $success = 0;
        foreach ($session['rows'] as $row) {
            $idSiswa = 0;
            $status = $row['status'] === 'Valid' ? 'Berhasil' : 'Gagal';
            $message = $row['pesan'];
            if ($row['status'] === 'Valid') {
                $d = $row['data'];
                $jk = strtolower($d['JENIS_KELAMIN']);
                $jk = in_array($jk, array('l', 'laki-laki', 'laki laki'), true) ? 'Laki-laki' : (in_array($jk, array('p', 'perempuan'), true) ? 'Perempuan' : $d['JENIS_KELAMIN']);
                $siswa = array('id_daftar_siswa' => '0', 'nisn' => $d['NISN'], 'nis' => $d['NIS'], 'nama_lengkap' => $d['NAMA_LENGKAP'], 'jk' => $jk, 'tempat_lahir' => isset($d['TEMPAT_LAHIR']) ? $d['TEMPAT_LAHIR'] : '', 'tanggal_lahir' => isset($d['TANGGAL_LAHIR']) ? $d['TANGGAL_LAHIR'] : '', 'tanggal_awal_masuk' => isset($d['TANGGAL_AWAL_MASUK']) ? $d['TANGGAL_AWAL_MASUK'] : $this->tanggal_sekarang(), 'foto_siswa' => '', 'status_pendaftaran' => 'Aktif', 'id_periode' => (string) $session['id_periode'], 'alamat_siswa' => isset($d['ALAMAT']) ? $d['ALAMAT'] : '', 'nama_ayah' => isset($d['NAMA_AYAH']) ? $d['NAMA_AYAH'] : '', 'pekerjaan_ayah' => isset($d['PEKERJAAN_AYAH']) ? $d['PEKERJAAN_AYAH'] : '', 'telepon_ayah' => isset($d['TELEPON_AYAH']) ? $d['TELEPON_AYAH'] : '', 'nama_ibu' => isset($d['NAMA_IBU']) ? $d['NAMA_IBU'] : '', 'pekerjaan_ibu' => isset($d['PEKERJAAN_IBU']) ? $d['PEKERJAAN_IBU'] : '', 'telepon_ibu' => isset($d['TELEPON_IBU']) ? $d['TELEPON_IBU'] : '');
                $this->db->insert('siswa', $siswa);
                $idSiswa = $this->db->insert_id();
                $this->db->insert('kelas_siswa', array('id_kelas_setting' => (string) $session['id_kelas_setting'], 'id_siswa' => (string) $idSiswa, 'nama_siswa' => $d['NAMA_LENGKAP'], 'nisn' => $d['NISN'], 'jenis_kelamin' => $jk, 'status_aktif' => '1'));
                $success++;
            }
            $this->db->insert('tagihan_import_siswa_detail', array('id_import' => $idImport, 'nomor_baris' => $row['baris'], 'nis' => $row['nis'], 'nisn' => $row['nisn'], 'nama_siswa' => $row['nama'], 'jenis_kelamin' => $row['jk'], 'nama_kelas_excel' => $row['kelas'], 'id_siswa_hasil' => $idSiswa, 'status_data' => $status, 'pesan_validasi' => $message, 'data_json' => json_encode($row['data'], JSON_UNESCAPED_UNICODE)));
        }
        $this->db->where('id', $idImport)->update('tagihan_import_siswa', array('jumlah_berhasil' => $success, 'status_import' => 'Selesai'));
        $this->tagihan_log_activity('Import Siswa', 'Master Data', 'Import', 'tagihan_import_siswa', $idImport, $kode, 'Import ' . $success . ' siswa ke kelas ' . $session['kelas']['nama_kelas'], null, $header);
        $result = $this->tagihan_transaction_result('Import selesai. ' . $success . ' siswa berhasil disimpan.');
        if ($result['result'] === 'true') {
            $result['id_import'] = (int) $idImport;
            $result['jumlah_gagal'] = count($session['rows']) - $success;
            $this->session->unset_userdata('import_preview_' . $token);
        }
        return $result;
    }

    public function detail_gagal($idImport)
    {
        $idImport = (int) $idImport;
        if ($idImport <= 0) {
            return array();
        }

        return $this->db
            ->where('id_import', $idImport)
            ->where('status_data !=', 'Berhasil')
            ->order_by('nomor_baris', 'ASC')
            ->get('tagihan_import_siswa_detail')
            ->result_array();
    }

    public function import_by_id($idImport)
    {
        return $this->db->where('id', (int) $idImport)->get('tagihan_import_siswa')->row_array();
    }

    private function tanggal_sekarang()
    {
        return date('d-m-Y');
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
