<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_import_wali_murid extends CI_Model
{
    private $hubungan = array('Ayah', 'Ibu', 'Wali', 'Lainnya');

    public function riwayat()
    {
        if (!$this->db->table_exists('tagihan_import_wali_murid')) {
            return array();
        }
        return $this->db->order_by('id', 'DESC')->limit(20)->get('tagihan_import_wali_murid')->result_array();
    }

    public function preview()
    {
        if (empty($_FILES['file_excel']['name'])) {
            return $this->model_response(false, 'Pilih file XLSX terlebih dahulu.');
        }

        $ext = strtolower(pathinfo($_FILES['file_excel']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'xlsx') {
            return $this->model_response(false, 'File yang diterima hanya format .xlsx.');
        }

        $dir = FCPATH . 'uploads/import_wali_murid/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = 'preview_' . date('YmdHis') . '_' . preg_replace('/[^A-Za-z0-9._-]/', '_', $_FILES['file_excel']['name']);
        $path = $dir . $filename;
        if (!move_uploaded_file($_FILES['file_excel']['tmp_name'], $path)) {
            return $this->model_response(false, 'File gagal diunggah.');
        }

        try {
            $this->load->library('Simple_xlsx_reader');
            $rows = $this->simple_xlsx_reader->read($path);
        } catch (Exception $e) {
            @unlink($path);
            return $this->model_response(false, $e->getMessage());
        }

        if (count($rows) < 2) {
            @unlink($path);
            return $this->model_response(false, 'File tidak memiliki data wali murid.');
        }

        $headers = array_map(function ($v) {
            return strtoupper(trim(preg_replace('/\s+/', '_', str_replace(array('/', '-'), '_', $v))));
        }, $rows[0]);

        $required = array('NAMA_WALI', 'USERNAME', 'PASSWORD', 'NIS', 'NISN', 'NAMA_SISWA', 'HUBUNGAN', 'NO_TELEPON', 'EMAIL');
        foreach ($required as $h) {
            if (!in_array($h, $headers, true)) {
                @unlink($path);
                return $this->model_response(false, 'Kolom wajib ' . $h . ' tidak ditemukan.');
            }
        }

        $rawRows = array();
        for ($i = 1; $i < count($rows); $i++) {
            if (!array_filter($rows[$i], function ($v) {
                return trim((string) $v) !== '';
            })) {
                continue;
            }

            $item = array();
            foreach ($headers as $idx => $h) {
                $item[$h] = isset($rows[$i][$idx]) ? trim((string) $rows[$i][$idx]) : '';
            }
            $item['USERNAME'] = strtolower($item['USERNAME']);
            $rawRows[] = array('baris' => $i + 1, 'data' => $item);
        }

        if (!$rawRows) {
            @unlink($path);
            return $this->model_response(false, 'File tidak memiliki data wali murid.');
        }

        $accountReference = array();
        foreach ($rawRows as $row) {
            $d = $row['data'];
            $username = $d['USERNAME'];
            if ($username === '' || isset($accountReference[$username])) {
                continue;
            }
            $accountReference[$username] = array(
                'nama_wali' => $this->normalisasi_text($d['NAMA_WALI']),
                'password' => $d['PASSWORD'],
                'no_telepon' => $d['NO_TELEPON'],
                'email' => strtolower($d['EMAIL'])
            );
        }

        $waliCache = array();
        $siswaCache = array();
        $seenRelation = array();
        $newAccountValidSeen = array();
        $preview = array();
        $valid = 0;
        $invalid = 0;
        $duplicate = 0;

        foreach ($rawRows as $raw) {
            $item = $raw['data'];
            $errors = array();
            $isDuplicate = false;

            $namaWali = $item['NAMA_WALI'];
            $username = $item['USERNAME'];
            $password = $item['PASSWORD'];
            $nis = $item['NIS'];
            $nisn = $item['NISN'];
            $namaSiswa = $item['NAMA_SISWA'];
            $hubungan = $this->normalisasi_hubungan_excel($item['HUBUNGAN']);
            $telepon = $item['NO_TELEPON'];
            $email = $item['EMAIL'];

            if ($namaWali === '' || $username === '' || $password === '' || $nis === '' || $nisn === '' || $namaSiswa === '' || $item['HUBUNGAN'] === '') {
                $errors[] = 'Kolom wajib belum lengkap';
            }
            if ($username !== '' && !preg_match('/^[a-z0-9._-]+$/', $username)) {
                $errors[] = 'Format username tidak valid';
            }
            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Format email tidak valid';
            }
            if ($item['HUBUNGAN'] !== '' && $hubungan === '') {
                $errors[] = 'Hubungan harus Ayah, Ibu, Wali, atau Lainnya';
            }

            if ($username !== '' && isset($accountReference[$username])) {
                $ref = $accountReference[$username];
                if ($this->normalisasi_text($namaWali) !== $ref['nama_wali']) {
                    $errors[] = 'Nama wali berbeda untuk username yang sama dalam file';
                }
                if ($password !== $ref['password']) {
                    $errors[] = 'Password berbeda untuk username yang sama dalam file';
                }
                if ($telepon !== $ref['no_telepon']) {
                    $errors[] = 'Nomor telepon berbeda untuk username yang sama dalam file';
                }
                if (strtolower($email) !== $ref['email']) {
                    $errors[] = 'Email berbeda untuk username yang sama dalam file';
                }
            }

            $wali = null;
            if ($username !== '') {
                if (!array_key_exists($username, $waliCache)) {
                    $waliCache[$username] = $this->db->where('username', $username)->get('wali_murid')->row_array();
                }
                $wali = $waliCache[$username];
                if ($wali && $this->normalisasi_text($wali['nama_wali']) !== $this->normalisasi_text($namaWali)) {
                    $errors[] = 'Username sudah digunakan akun wali murid dengan nama berbeda';
                }
            }

            $siswa = null;
            if ($nis !== '') {
                if (!array_key_exists($nis, $siswaCache)) {
                    $siswaCache[$nis] = $this->db->where('nis', $nis)->get('siswa')->row_array();
                }
                $siswa = $siswaCache[$nis];
                if (!$siswa) {
                    $errors[] = 'NIS tidak ditemukan pada data siswa';
                } else {
                    if ((string) $siswa['nisn'] !== (string) $nisn) {
                        $errors[] = 'NISN tidak sesuai dengan data siswa';
                    }
                    if ($this->normalisasi_text($siswa['nama_lengkap']) !== $this->normalisasi_text($namaSiswa)) {
                        $errors[] = 'Nama siswa tidak sesuai dengan data siswa';
                    }
                    if (isset($siswa['status_pendaftaran']) && $siswa['status_pendaftaran'] !== 'Aktif') {
                        $errors[] = 'Siswa tidak berstatus Aktif';
                    }
                }
            }

            $aksi = $wali ? 'Tambah Relasi' : (isset($newAccountValidSeen[$username]) ? 'Tambah Relasi' : 'Akun Baru + Relasi');
            if ($siswa && $username !== '') {
                $relationKey = $username . '|' . (int) $siswa['id'];
                if (isset($seenRelation[$relationKey])) {
                    $errors[] = 'Relasi wali dan siswa duplikat dalam file';
                    $isDuplicate = true;
                } else {
                    $seenRelation[$relationKey] = true;
                }

                if ($wali) {
                    $relasi = $this->db
                        ->where('id_wali_murid', (int) $wali['id'])
                        ->where('id_siswa', (int) $siswa['id'])
                        ->get('wali_murid_siswa')
                        ->row_array();
                    if ($relasi) {
                        if ($relasi['status'] === 'Aktif') {
                            $errors[] = 'Siswa sudah terhubung aktif dengan akun wali ini';
                            $isDuplicate = true;
                        } else {
                            $aksi = 'Aktifkan Relasi';
                        }
                    }
                }
            }

            foreach ($errors as $errorText) {
                $lower = strtolower($errorText);
                if (strpos($lower, 'duplikat') !== false || strpos($lower, 'sudah terhubung aktif') !== false) {
                    $isDuplicate = true;
                    break;
                }
            }

            $status = $errors ? 'Gagal' : 'Valid';
            if ($status === 'Valid') {
                if (!$wali && $username !== '') {
                    $newAccountValidSeen[$username] = true;
                }
                $valid++;
            } else {
                $invalid++;
                if ($isDuplicate) {
                    $duplicate++;
                }
            }

            $preview[] = array(
                'baris' => $raw['baris'],
                'nama_wali' => $namaWali,
                'username' => $username,
                'nis' => $nis,
                'nisn' => $nisn,
                'nama_siswa' => $namaSiswa,
                'hubungan' => $hubungan !== '' ? $hubungan : $item['HUBUNGAN'],
                'aksi' => $aksi,
                'status' => $status,
                'pesan' => implode('; ', $errors),
                'duplikat' => $isDuplicate,
                'id_siswa' => $siswa ? (int) $siswa['id'] : 0,
                'data' => $item
            );
        }

        $token = bin2hex(random_bytes(16));
        $this->session->set_userdata('import_wali_preview_' . $token, array(
            'path' => $path,
            'filename' => $filename,
            'rows' => $preview
        ));

        $publicRows = array_map(function ($row) {
            $copy = $row;
            unset($copy['data']);
            return $copy;
        }, $preview);

        return $this->model_response(true, 'Preview berhasil dibuat.', array(
            'token' => $token,
            'rows' => $publicRows,
            'total' => count($preview),
            'valid' => $valid,
            'gagal' => $invalid,
            'duplikat' => $duplicate
        ));
    }

    public function proses()
    {
        if (!$this->tabel_import_siap()) {
            return $this->model_response(false, 'Tabel import wali murid belum tersedia. Jalankan file database_import_wali_murid.sql terlebih dahulu.');
        }

        $token = trim((string) $this->input->post('token', true));
        $session = $this->session->userdata('import_wali_preview_' . $token);
        if (!$session) {
            return $this->model_response(false, 'Data preview tidak ditemukan atau sudah kedaluwarsa.');
        }

        $validRows = array_values(array_filter($session['rows'], function ($r) {
            return $r['status'] === 'Valid';
        }));
        if (!$validRows) {
            return $this->model_response(false, 'Tidak ada data valid yang dapat diimport.');
        }

        $kode = 'IMPWALI/' . date('Ym') . '/' . str_pad(((int) $this->db->count_all('tagihan_import_wali_murid')) + 1, 5, '0', STR_PAD_LEFT);
        $audit = $this->tagihan_audit_fields();
        $header = array_merge(array(
            'kode_import' => $kode,
            'nama_file' => $session['filename'],
            'lokasi_file' => str_replace(FCPATH, '', $session['path']),
            'jumlah_data' => count($session['rows']),
            'jumlah_berhasil' => 0,
            'jumlah_gagal' => 0,
            'jumlah_duplikat' => 0,
            'status_import' => 'Diproses',
            'keterangan' => 'Import wali murid dan relasi siswa dari template XLSX'
        ), $audit);

        $this->db->trans_begin();
        $this->db->insert('tagihan_import_wali_murid', $header);
        $idImport = (int) $this->db->insert_id();

        $waliMap = array();
        $success = 0;
        $failed = 0;
        $duplicate = 0;

        foreach ($session['rows'] as $row) {
            $idWali = 0;
            $idSiswa = (int) $row['id_siswa'];
            $idRelasi = 0;
            $status = $row['status'] === 'Valid' ? 'Berhasil' : 'Gagal';
            $message = $row['pesan'];
            $aksiHasil = $row['aksi'];

            if ($row['status'] === 'Valid') {
                $d = $row['data'];
                $username = strtolower(trim($d['USERNAME']));

                if (isset($waliMap[$username])) {
                    $wali = $waliMap[$username];
                } else {
                    $wali = $this->db->where('username', $username)->get('wali_murid')->row_array();
                    if (!$wali) {
                        $kodeWali = $this->tagihan_next_code('WALI', 'wali_murid', 'kode_wali');
                        $waliData = array(
                            'kode_wali' => $kodeWali,
                            'nama_wali' => trim($d['NAMA_WALI']),
                            'no_telepon' => trim($d['NO_TELEPON']),
                            'email' => trim($d['EMAIL']),
                            'username' => $username,
                            'password_hash' => password_hash((string) $d['PASSWORD'], PASSWORD_DEFAULT),
                            'password_text' => (string) $d['PASSWORD'],
                            'wajib_ganti_password' => 'Ya',
                            'status' => 'Aktif',
                            'tanggal_password_update' => $this->tanggal_sekarang(),
                            'waktu_password_update' => $this->waktu_sekarang(),
                            'tanggal' => $this->tanggal_sekarang(),
                            'waktu' => $this->waktu_sekarang(),
                            'id_user' => $this->app_user_id(),
                            'nama_user' => $this->app_user_name()
                        );
                        $this->db->insert('wali_murid', $waliData);
                        $idWali = (int) $this->db->insert_id();
                        $wali = array_merge($waliData, array('id' => $idWali));
                        $this->tagihan_log_activity(
                            'Tambah Wali Murid',
                            'Master Data',
                            'Tambah',
                            'wali_murid',
                            $idWali,
                            $kodeWali,
                            'Membuat akun portal wali murid melalui import',
                            null,
                            $this->log_akun_data($waliData)
                        );
                    }
                    $waliMap[$username] = $wali;
                }

                $idWali = (int) $wali['id'];
                $relationResult = $this->simpan_relasi_import($idWali, $idSiswa, $row['hubungan']);
                if ($relationResult['result'] === true) {
                    $idRelasi = (int) $relationResult['id_relasi'];
                    $aksiHasil = $relationResult['aksi'];
                    $success++;
                } else {
                    $status = 'Gagal';
                    $message = $relationResult['message'];
                    $failed++;
                    if (!empty($relationResult['duplikat'])) {
                        $duplicate++;
                    }
                }
            } else {
                $failed++;
                if (!empty($row['duplikat'])) {
                    $duplicate++;
                }
            }

            $dataJson = $row['data'];
            unset($dataJson['PASSWORD']);
            $this->db->insert('tagihan_import_wali_murid_detail', array(
                'id_import' => $idImport,
                'nomor_baris' => $row['baris'],
                'nama_wali' => $row['nama_wali'],
                'no_telepon' => isset($row['data']['NO_TELEPON']) ? $row['data']['NO_TELEPON'] : '',
                'email' => isset($row['data']['EMAIL']) ? $row['data']['EMAIL'] : '',
                'username' => $row['username'],
                'nis' => $row['nis'],
                'nisn' => $row['nisn'],
                'nama_siswa' => $row['nama_siswa'],
                'hubungan' => $row['hubungan'],
                'aksi' => $aksiHasil,
                'id_wali_murid_hasil' => $idWali,
                'id_siswa_hasil' => $idSiswa,
                'id_relasi_hasil' => $idRelasi,
                'status_data' => $status,
                'pesan_validasi' => $message,
                'data_json' => json_encode($dataJson, JSON_UNESCAPED_UNICODE)
            ));
        }

        $this->db->where('id', $idImport)->update('tagihan_import_wali_murid', array(
            'jumlah_berhasil' => $success,
            'jumlah_gagal' => $failed,
            'jumlah_duplikat' => $duplicate,
            'status_import' => 'Selesai'
        ));

        $this->tagihan_log_activity(
            'Import Wali Murid',
            'Master Data',
            'Import',
            'tagihan_import_wali_murid',
            $idImport,
            $kode,
            'Import ' . $success . ' relasi wali murid berhasil diproses',
            null,
            array(
                'jumlah_data' => count($session['rows']),
                'jumlah_berhasil' => $success,
                'jumlah_gagal' => $failed,
                'jumlah_duplikat' => $duplicate
            )
        );

        $result = $this->tagihan_transaction_result('Import selesai. ' . $success . ' data wali/siswa berhasil disimpan.');
        if ($result['result'] === 'true') {
            $result['id_import'] = $idImport;
            $result['jumlah_gagal'] = $failed;
            $result['jumlah_duplikat'] = $duplicate;
            $this->session->unset_userdata('import_wali_preview_' . $token);
        }
        return $result;
    }

    public function detail_gagal($idImport)
    {
        if (!$this->tabel_import_siap()) {
            return array();
        }
        return $this->db
            ->where('id_import', (int) $idImport)
            ->where('status_data !=', 'Berhasil')
            ->order_by('nomor_baris', 'ASC')
            ->get('tagihan_import_wali_murid_detail')
            ->result_array();
    }

    public function import_by_id($idImport)
    {
        if (!$this->tabel_import_siap()) {
            return null;
        }
        return $this->db->where('id', (int) $idImport)->get('tagihan_import_wali_murid')->row_array();
    }

    private function simpan_relasi_import($idWali, $idSiswa, $hubungan)
    {
        if ($idWali <= 0 || $idSiswa <= 0) {
            return array('result' => false, 'message' => 'Data wali atau siswa tidak valid.', 'duplikat' => false);
        }

        $siswa = $this->db->where('id', $idSiswa)->get('siswa')->row_array();
        if (!$siswa) {
            return array('result' => false, 'message' => 'Data siswa tidak ditemukan.', 'duplikat' => false);
        }

        $hubungan = $this->normalisasi_hubungan($hubungan);
        $before = $this->db
            ->where('id_wali_murid', $idWali)
            ->where('id_siswa', $idSiswa)
            ->get('wali_murid_siswa')
            ->row_array();

        if ($before && $before['status'] === 'Aktif') {
            return array('result' => false, 'message' => 'Siswa sudah terhubung aktif dengan akun wali ini.', 'duplikat' => true);
        }

        if ($before) {
            $data = array(
                'hubungan' => $hubungan,
                'status' => 'Aktif',
                'tanggal_update' => $this->tanggal_sekarang(),
                'waktu_update' => $this->waktu_sekarang(),
                'id_user_update' => $this->app_user_id(),
                'nama_user_update' => $this->app_user_name()
            );
            $this->db->where('id', $before['id'])->update('wali_murid_siswa', $data);
            $idRelasi = (int) $before['id'];
            $jenis = 'Aktifkan Relasi Wali Murid';
            $aksi = 'Aktifkan Relasi';
        } else {
            $data = array(
                'id_wali_murid' => $idWali,
                'id_siswa' => $idSiswa,
                'hubungan' => $hubungan,
                'status' => 'Aktif',
                'keterangan' => '',
                'tanggal' => $this->tanggal_sekarang(),
                'waktu' => $this->waktu_sekarang(),
                'id_user' => $this->app_user_id(),
                'nama_user' => $this->app_user_name()
            );
            $this->db->insert('wali_murid_siswa', $data);
            $idRelasi = (int) $this->db->insert_id();
            $jenis = 'Tambah Relasi Wali Murid';
            $aksi = 'Tambah Relasi';
        }

        $this->tagihan_log_activity(
            $jenis,
            'Master Data',
            $before ? 'Ubah' : 'Tambah',
            'wali_murid_siswa',
            $idRelasi,
            (string) $idWali . '/' . (string) $idSiswa,
            'Menghubungkan akun wali dengan siswa ' . $siswa['nama_lengkap'] . ' melalui import',
            $before,
            $data
        );

        return array('result' => true, 'id_relasi' => $idRelasi, 'aksi' => $aksi);
    }

    private function normalisasi_hubungan_excel($value)
    {
        $value = trim((string) $value);
        foreach ($this->hubungan as $allowed) {
            if (strcasecmp($value, $allowed) === 0) {
                return $allowed;
            }
        }
        return '';
    }

    private function normalisasi_hubungan($value)
    {
        $normal = $this->normalisasi_hubungan_excel($value);
        return $normal !== '' ? $normal : 'Ayah';
    }

    private function normalisasi_text($value)
    {
        $value = preg_replace('/\s+/u', ' ', trim((string) $value));
        if (function_exists('mb_strtolower')) {
            return mb_strtolower($value, 'UTF-8');
        }
        return strtolower($value);
    }

    private function tabel_import_siap()
    {
        return $this->db->table_exists('tagihan_import_wali_murid') && $this->db->table_exists('tagihan_import_wali_murid_detail');
    }

    private function log_akun_data($data)
    {
        $copy = is_array($data) ? $data : array();
        unset($copy['password_hash'], $copy['password_text']);
        return $copy;
    }

    private function tagihan_audit_fields()
    {
        return array(
            'tanggal' => $this->tanggal_sekarang(),
            'waktu' => $this->waktu_sekarang(),
            'id_user' => $this->app_user_id(),
            'nama_user' => $this->app_user_name()
        );
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
            'tanggal' => $this->tanggal_sekarang(),
            'waktu' => $this->waktu_sekarang(),
            'id_user' => is_array($user) && isset($user['id']) ? (int) $user['id'] : 0,
            'nama_user' => is_array($user) && isset($user['nama']) && $user['nama'] !== '' ? $user['nama'] : 'Administrator'
        ));
    }

    private function tagihan_next_code($prefix, $table, $column)
    {
        $date = date('Ym');
        $like = $prefix . '/' . $date . '/';
        $row = $this->db->select($column)
            ->like($column, $like, 'after')
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get($table)
            ->row_array();

        $next = 1;
        if ($row && !empty($row[$column])) {
            $parts = explode('/', $row[$column]);
            $next = ((int) end($parts)) + 1;
        }

        return $like . str_pad($next, 5, '0', STR_PAD_LEFT);
    }
}
