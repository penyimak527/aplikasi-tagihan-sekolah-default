<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_wali_murid extends CI_Model
{
    private $hubungan = array('Ayah', 'Ibu', 'Wali', 'Lainnya');

    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }

    public function result()
    {
        $search = trim((string) $this->input->post('search', true));
        $status = trim((string) $this->input->post('status', true));
        $params = array();

        $sql = "SELECT wm.*,
                    (SELECT COUNT(*)
                     FROM wali_murid_siswa wms
                     WHERE wms.id_wali_murid = wm.id
                       AND wms.status = 'Aktif') AS jumlah_siswa
                FROM wali_murid wm
                WHERE 1=1";

        if ($search !== '') {
            $like = '%' . $search . '%';
            $sql .= " AND (
                        wm.nama_wali LIKE ?
                        OR wm.username LIKE ?
                        OR wm.no_telepon LIKE ?
                        OR EXISTS (
                            SELECT 1
                            FROM wali_murid_siswa wms2
                            INNER JOIN siswa s2 ON s2.id = wms2.id_siswa
                            WHERE wms2.id_wali_murid = wm.id
                              AND wms2.status = 'Aktif'
                              AND (
                                  s2.nama_lengkap LIKE ?
                                  OR s2.nis LIKE ?
                                  OR s2.nisn LIKE ?
                              )
                        )
                    )";
            $params = array($like, $like, $like, $like, $like, $like);
        }

        if (in_array($status, array('Aktif', 'Tidak Aktif'), true)) {
            $sql .= " AND wm.status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY CASE WHEN wm.status='Aktif' THEN 0 ELSE 1 END, wm.nama_wali ASC, wm.id DESC";
        return $this->db->query($sql, $params)->result_array();
    }

    public function detail()
    {
        $id = (int) $this->input->post('id');
        $wali = $this->db->where('id', $id)->get('wali_murid')->row_array();
        if (!$wali) {
            return model_response(false, 'Data wali murid tidak ditemukan.');
        }

        $relasi = $this->db->query(
            "SELECT wms.*, s.nis, s.nisn, s.nama_lengkap, s.status_pendaftaran,
                    kset.nama_kelas, kset.semester, ta.periode
             FROM wali_murid_siswa wms
             INNER JOIN siswa s ON s.id = wms.id_siswa
             LEFT JOIN kelas_siswa kss ON kss.id = (
                 SELECT MAX(x.id)
                 FROM kelas_siswa x
                 WHERE CAST(x.id_siswa AS UNSIGNED) = s.id
                   AND x.status_aktif = '1'
             )
             LEFT JOIN kelas_setting kset ON kset.id = CAST(kss.id_kelas_setting AS UNSIGNED)
             LEFT JOIN master_tahun_ajaran ta ON ta.id = CAST(kset.id_periode AS UNSIGNED)
             WHERE wms.id_wali_murid = ?
             ORDER BY CASE WHEN wms.status='Aktif' THEN 0 ELSE 1 END, s.nama_lengkap ASC",
            array($id)
        )->result_array();

        return model_response(true, 'Detail wali murid berhasil dimuat.', array(
            'data' => $wali,
            'relasi' => $relasi
        ));
    }

    public function kelas_result()
    {
        $id_periode = (int) $this->input->post('id_periode');

        $this->db->select('DISTINCT k.id, k.nama_kelas', false)
            ->from('kelas_setting ks')
            ->join('kelas k', 'k.id = CAST(ks.id_kelas AS UNSIGNED)', 'left');

        if ($id_periode > 0) {
            $this->db->where('CAST(ks.id_periode AS UNSIGNED) = ' . $id_periode, null, false);
        }

        return $this->db->where('k.id IS NOT NULL', null, false)
            ->order_by('k.nama_kelas', 'ASC')
            ->get()
            ->result_array();
    }

    public function siswa_result()
    {
        $search = trim((string) $this->input->post('search', true));
        $id_periode = (int) $this->input->post('id_periode');
        $id_kelas = (int) $this->input->post('id_kelas');
        $id_wali_murid = (int) $this->input->post('id_wali_murid');

        $params = array();
        $subPeriode = '';
        if ($id_periode > 0) {
            $subPeriode = " AND CAST(kx.id_periode AS UNSIGNED) = ?";
            $params[] = $id_periode;
        }

        $sql = "SELECT s.id, s.nis, s.nisn, s.nama_lengkap, s.status_pendaftaran,
                       kset.nama_kelas, kset.semester, ta.periode, k.id AS id_kelas
                FROM siswa s
                LEFT JOIN kelas_siswa kss ON kss.id = (
                    SELECT MAX(x.id)
                    FROM kelas_siswa x
                    INNER JOIN kelas_setting kx ON kx.id = CAST(x.id_kelas_setting AS UNSIGNED)
                    WHERE CAST(x.id_siswa AS UNSIGNED) = s.id
                      AND x.status_aktif = '1'" . $subPeriode . "
                )
                LEFT JOIN kelas_setting kset ON kset.id = CAST(kss.id_kelas_setting AS UNSIGNED)
                LEFT JOIN kelas k ON k.id = CAST(kset.id_kelas AS UNSIGNED)
                LEFT JOIN master_tahun_ajaran ta ON ta.id = CAST(kset.id_periode AS UNSIGNED)
                WHERE s.status_pendaftaran = 'Aktif'";

        if ($id_periode > 0) {
            $sql .= " AND CAST(kset.id_periode AS UNSIGNED) = ?";
            $params[] = $id_periode;
        }

        if ($id_kelas > 0) {
            $sql .= " AND k.id = ?";
            $params[] = $id_kelas;
        }

        if ($search !== '') {
            $like = '%' . $search . '%';
            $sql .= " AND (s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ?)";
            $params[] = $like;
            $params[] = $like;
            $params[] = $like;
        }

        if ($id_wali_murid > 0) {
            $sql .= " AND NOT EXISTS (
                        SELECT 1
                        FROM wali_murid_siswa wms
                        WHERE wms.id_wali_murid = ?
                          AND wms.id_siswa = s.id
                          AND wms.status = 'Aktif'
                    )";
            $params[] = $id_wali_murid;
        }

        $sql .= " ORDER BY s.nama_lengkap ASC LIMIT 500";
        return $this->db->query($sql, $params)->result_array();
    }

    public function generate_username()
    {
        $nama = trim((string) $this->input->post('nama_wali', true));
        if ($nama === '') {
            return model_response(false, 'Nama wali harus diisi terlebih dahulu.');
        }

        $base = $this->normalisasi_username($nama);
        for ($i = 0; $i < 100; $i++) {
            $username = substr($base, 0, 90) . random_int(100, 999);
            if ($this->db->where('username', $username)->count_all_results('wali_murid') === 0) {
                return model_response(true, 'Username berhasil dibuat.', array('username' => $username));
            }
        }

        return model_response(false, 'Username unik gagal dibuat. Silakan coba lagi.');
    }

    public function generate_password()
    {
        return model_response(true, 'Password berhasil dibuat.', array(
            'password' => $this->password_acak(8)
        ));
    }

    public function simpan()
    {
        $nama = trim((string) $this->input->post('nama_wali', true));
        $telepon = trim((string) $this->input->post('no_telepon', true));
        $email = trim((string) $this->input->post('email', true));
        $username = strtolower(trim((string) $this->input->post('username', true)));
        $password = (string) $this->input->post('password');
        $status = trim((string) $this->input->post('status', true));
        $status = in_array($status, array('Aktif', 'Tidak Aktif'), true) ? $status : 'Aktif';

        $validasi = $this->validasi_akun($nama, $email, $username, 0);
        if ($validasi !== true) {
            return model_response(false, $validasi);
        }
        $validasiPassword = $this->validasi_password($password);
        if ($validasiPassword !== true) {
            return model_response(false, $validasiPassword);
        }

        $siswa = $this->parse_siswa_json($this->input->post('siswa_json'));
        $kode = tagihan_next_code('WALI', 'wali_murid', 'kode_wali');
        $data = array(
            'kode_wali' => $kode,
            'nama_wali' => $nama,
            'no_telepon' => $telepon,
            'email' => $email,
            'username' => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'wajib_ganti_password' => 'Ya',
            'status' => $status,
            'tanggal_password_update' => tanggal_sekarang(),
            'waktu_password_update' => waktu_sekarang(),
            'tanggal' => tanggal_sekarang(),
            'waktu' => waktu_sekarang(),
            'id_user' => app_user_id(),
            'nama_user' => app_user_name()
        );

        $this->db->trans_begin();
        $this->db->insert('wali_murid', $data);
        $id = (int) $this->db->insert_id();

        tagihan_log_activity(
            'Tambah Wali Murid',
            'Master Data',
            'Tambah',
            'wali_murid',
            $id,
            $kode,
            'Membuat akun portal wali murid',
            null,
            $this->log_akun_data($data)
        );

        foreach ($siswa as $item) {
            $this->simpan_relasi_internal($id, (int) $item['id_siswa'], $item['hubungan']);
        }

        $result = tagihan_transaction_result('Akun wali murid berhasil dibuat.');
        if ($result['result'] === 'true') {
            $result['credential'] = array(
                'username' => $username,
                'password' => $password
            );
        }
        return $result;
    }

    public function update()
    {
        $id = (int) $this->input->post('id');
        $before = $this->db->where('id', $id)->get('wali_murid')->row_array();
        if (!$before) {
            return model_response(false, 'Data wali murid tidak ditemukan.');
        }

        $nama = trim((string) $this->input->post('nama_wali', true));
        $telepon = trim((string) $this->input->post('no_telepon', true));
        $email = trim((string) $this->input->post('email', true));
        $username = strtolower(trim((string) $this->input->post('username', true)));
        $status = trim((string) $this->input->post('status', true));
        $status = in_array($status, array('Aktif', 'Tidak Aktif'), true) ? $status : $before['status'];

        $validasi = $this->validasi_akun($nama, $email, $username, $id);
        if ($validasi !== true) {
            return model_response(false, $validasi);
        }

        $data = array(
            'nama_wali' => $nama,
            'no_telepon' => $telepon,
            'email' => $email,
            'username' => $username,
            'status' => $status,
            'tanggal_update' => tanggal_sekarang(),
            'waktu_update' => waktu_sekarang(),
            'id_user_update' => app_user_id(),
            'nama_user_update' => app_user_name()
        );

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('wali_murid', $data);
        tagihan_log_activity(
            'Ubah Wali Murid',
            'Master Data',
            'Ubah',
            'wali_murid',
            $id,
            $before['kode_wali'],
            'Mengubah data akun wali murid',
            $this->log_akun_data($before),
            $this->log_akun_data(array_merge($before, $data))
        );

        return tagihan_transaction_result('Data wali murid berhasil diperbarui.');
    }

    public function status()
    {
        $id = (int) $this->input->post('id');
        $target = trim((string) $this->input->post('status', true));
        if (!in_array($target, array('Aktif', 'Tidak Aktif'), true)) {
            return model_response(false, 'Status akun tidak valid.');
        }

        $before = $this->db->where('id', $id)->get('wali_murid')->row_array();
        if (!$before) {
            return model_response(false, 'Data wali murid tidak ditemukan.');
        }

        if ($before['status'] === $target) {
            return model_response(true, 'Status akun sudah ' . $target . '.');
        }

        $data = array(
            'status' => $target,
            'tanggal_update' => tanggal_sekarang(),
            'waktu_update' => waktu_sekarang(),
            'id_user_update' => app_user_id(),
            'nama_user_update' => app_user_name()
        );

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('wali_murid', $data);
        tagihan_log_activity(
            $target === 'Aktif' ? 'Aktifkan Akun Wali Murid' : 'Nonaktifkan Akun Wali Murid',
            'Master Data',
            'Ubah',
            'wali_murid',
            $id,
            $before['kode_wali'],
            'Status akun wali murid menjadi ' . $target,
            array('status' => $before['status']),
            array('status' => $target)
        );

        return tagihan_transaction_result('Akun wali murid berhasil ' . ($target === 'Aktif' ? 'diaktifkan.' : 'dinonaktifkan.'));
    }

    public function tambah_relasi()
    {
        $id_wali = (int) $this->input->post('id_wali_murid');
        $wali = $this->db->where('id', $id_wali)->get('wali_murid')->row_array();
        if (!$wali) {
            return model_response(false, 'Akun wali murid tidak ditemukan.');
        }

        $siswa = $this->parse_siswa_json($this->input->post('siswa_json'));
        if (!$siswa) {
            return model_response(false, 'Pilih minimal satu siswa.');
        }

        $this->db->trans_begin();
        $jumlah = 0;
        foreach ($siswa as $item) {
            if ($this->simpan_relasi_internal($id_wali, (int) $item['id_siswa'], $item['hubungan'])) {
                $jumlah++;
            }
        }

        $result = tagihan_transaction_result($jumlah . ' relasi siswa berhasil disimpan.');
        $result['jumlah'] = $jumlah;
        return $result;
    }

    public function ubah_relasi()
    {
        $id = (int) $this->input->post('id');
        $hubungan = $this->normalisasi_hubungan($this->input->post('hubungan', true));
        $before = $this->db->where('id', $id)->get('wali_murid_siswa')->row_array();
        if (!$before) {
            return model_response(false, 'Relasi wali dan siswa tidak ditemukan.');
        }

        $data = array(
            'hubungan' => $hubungan,
            'tanggal_update' => tanggal_sekarang(),
            'waktu_update' => waktu_sekarang(),
            'id_user_update' => app_user_id(),
            'nama_user_update' => app_user_name()
        );

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('wali_murid_siswa', $data);
        tagihan_log_activity(
            'Ubah Relasi Wali Murid',
            'Master Data',
            'Ubah',
            'wali_murid_siswa',
            $id,
            (string) $before['id_wali_murid'] . '/' . (string) $before['id_siswa'],
            'Mengubah hubungan wali dengan siswa',
            array('hubungan' => $before['hubungan']),
            array('hubungan' => $hubungan)
        );

        return tagihan_transaction_result('Hubungan wali dengan siswa berhasil diperbarui.');
    }

    public function status_relasi()
    {
        $id = (int) $this->input->post('id');
        $target = trim((string) $this->input->post('status', true));
        if (!in_array($target, array('Aktif', 'Tidak Aktif'), true)) {
            return model_response(false, 'Status relasi tidak valid.');
        }

        $before = $this->db->where('id', $id)->get('wali_murid_siswa')->row_array();
        if (!$before) {
            return model_response(false, 'Relasi wali dan siswa tidak ditemukan.');
        }

        $data = array(
            'status' => $target,
            'tanggal_update' => tanggal_sekarang(),
            'waktu_update' => waktu_sekarang(),
            'id_user_update' => app_user_id(),
            'nama_user_update' => app_user_name()
        );

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('wali_murid_siswa', $data);
        tagihan_log_activity(
            $target === 'Aktif' ? 'Aktifkan Relasi Wali Murid' : 'Nonaktifkan Relasi Wali Murid',
            'Master Data',
            'Ubah',
            'wali_murid_siswa',
            $id,
            (string) $before['id_wali_murid'] . '/' . (string) $before['id_siswa'],
            'Status relasi wali dengan siswa menjadi ' . $target,
            array('status' => $before['status']),
            array('status' => $target)
        );

        return tagihan_transaction_result('Relasi siswa berhasil ' . ($target === 'Aktif' ? 'diaktifkan.' : 'dinonaktifkan.'));
    }

    public function reset_password()
    {
        $id = (int) $this->input->post('id');
        $password = (string) $this->input->post('password');
        $wajib = $this->input->post('wajib_ganti_password', true) === 'Ya' ? 'Ya' : 'Tidak';

        $wali = $this->db->where('id', $id)->get('wali_murid')->row_array();
        if (!$wali) {
            return model_response(false, 'Akun wali murid tidak ditemukan.');
        }

        $validasiPassword = $this->validasi_password($password);
        if ($validasiPassword !== true) {
            return model_response(false, $validasiPassword);
        }

        $data = array(
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'wajib_ganti_password' => $wajib,
            'tanggal_password_update' => tanggal_sekarang(),
            'waktu_password_update' => waktu_sekarang(),
            'tanggal_update' => tanggal_sekarang(),
            'waktu_update' => waktu_sekarang(),
            'id_user_update' => app_user_id(),
            'nama_user_update' => app_user_name()
        );

        $this->db->trans_begin();
        $this->db->where('id', $id)->update('wali_murid', $data);
        tagihan_log_activity(
            'Reset Password Wali Murid',
            'Master Data',
            'Ubah',
            'wali_murid',
            $id,
            $wali['kode_wali'],
            'Reset password akun portal wali murid',
            array('wajib_ganti_password' => $wali['wajib_ganti_password']),
            array(
                'wajib_ganti_password' => $wajib,
                'tanggal_password_update' => $data['tanggal_password_update'],
                'waktu_password_update' => $data['waktu_password_update']
            )
        );

        $result = tagihan_transaction_result('Password wali murid berhasil direset.');
        if ($result['result'] === 'true') {
            $result['credential'] = array(
                'username' => $wali['username'],
                'password' => $password
            );
        }
        return $result;
    }

    private function simpan_relasi_internal($id_wali, $id_siswa, $hubungan)
    {
        if ($id_wali <= 0 || $id_siswa <= 0) {
            return false;
        }

        $siswa = $this->db->where('id', $id_siswa)->get('siswa')->row_array();
        if (!$siswa) {
            return false;
        }

        $hubungan = $this->normalisasi_hubungan($hubungan);
        $before = $this->db
            ->where('id_wali_murid', $id_wali)
            ->where('id_siswa', $id_siswa)
            ->get('wali_murid_siswa')
            ->row_array();

        if ($before) {
            if ($before['status'] === 'Aktif' && $before['hubungan'] === $hubungan) {
                return false;
            }

            $data = array(
                'hubungan' => $hubungan,
                'status' => 'Aktif',
                'tanggal_update' => tanggal_sekarang(),
                'waktu_update' => waktu_sekarang(),
                'id_user_update' => app_user_id(),
                'nama_user_update' => app_user_name()
            );
            $this->db->where('id', $before['id'])->update('wali_murid_siswa', $data);
            $id_relasi = (int) $before['id'];
            $jenis = $before['status'] === 'Aktif' ? 'Ubah Relasi Wali Murid' : 'Aktifkan Relasi Wali Murid';
            $aksi = 'Ubah';
        } else {
            $data = array(
                'id_wali_murid' => $id_wali,
                'id_siswa' => $id_siswa,
                'hubungan' => $hubungan,
                'status' => 'Aktif',
                'keterangan' => '',
                'tanggal' => tanggal_sekarang(),
                'waktu' => waktu_sekarang(),
                'id_user' => app_user_id(),
                'nama_user' => app_user_name()
            );
            $this->db->insert('wali_murid_siswa', $data);
            $id_relasi = (int) $this->db->insert_id();
            $jenis = 'Tambah Relasi Wali Murid';
            $aksi = 'Tambah';
        }

        tagihan_log_activity(
            $jenis,
            'Master Data',
            $aksi,
            'wali_murid_siswa',
            $id_relasi,
            (string) $id_wali . '/' . (string) $id_siswa,
            'Menghubungkan akun wali dengan siswa ' . $siswa['nama_lengkap'],
            $before,
            $data
        );
        return true;
    }

    private function validasi_akun($nama, $email, $username, $id)
    {
        if ($nama === '') {
            return 'Nama wali wajib diisi.';
        }
        if ($username === '') {
            return 'Username wajib diisi.';
        }
        if (!preg_match('/^[a-z0-9._-]+$/', $username)) {
            return 'Username hanya boleh berisi huruf kecil, angka, titik, underscore, atau tanda minus.';
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Format email tidak valid.';
        }

        $this->db->where('username', $username);
        if ($id > 0) {
            $this->db->where('id !=', $id);
        }
        if ($this->db->count_all_results('wali_murid') > 0) {
            return 'Username sudah digunakan akun wali murid lain.';
        }
        return true;
    }

    private function validasi_password($password)
    {
        if (strlen($password) < 8) {
            return 'Password minimal 8 karakter.';
        }
        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            return 'Password harus mengandung huruf besar, huruf kecil, dan angka.';
        }
        return true;
    }

    private function normalisasi_username($nama)
    {
        $text = trim((string) $nama);
        $ascii = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        if ($ascii !== false) {
            $text = $ascii;
        }
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/', '.', $text);
        $text = trim($text, '.');
        return $text !== '' ? $text : 'wali';
    }

    private function password_acak($length)
    {
        $upper = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        $lower = 'abcdefghijkmnopqrstuvwxyz';
        $digit = '23456789';
        $all = $upper . $lower . $digit;

        $chars = array(
            $upper[random_int(0, strlen($upper) - 1)],
            $lower[random_int(0, strlen($lower) - 1)],
            $digit[random_int(0, strlen($digit) - 1)]
        );

        while (count($chars) < $length) {
            $chars[] = $all[random_int(0, strlen($all) - 1)];
        }

        for ($i = count($chars) - 1; $i > 0; $i--) {
            $j = random_int(0, $i);
            $tmp = $chars[$i];
            $chars[$i] = $chars[$j];
            $chars[$j] = $tmp;
        }
        return implode('', $chars);
    }

    private function parse_siswa_json($json)
    {
        $decoded = json_decode((string) $json, true);
        if (!is_array($decoded)) {
            return array();
        }

        $result = array();
        $seen = array();
        foreach ($decoded as $item) {
            $id = isset($item['id_siswa']) ? (int) $item['id_siswa'] : 0;
            if ($id <= 0 || isset($seen[$id])) {
                continue;
            }
            $seen[$id] = true;
            $result[] = array(
                'id_siswa' => $id,
                'hubungan' => $this->normalisasi_hubungan(isset($item['hubungan']) ? $item['hubungan'] : 'Ayah')
            );
        }
        return $result;
    }

    private function normalisasi_hubungan($hubungan)
    {
        $hubungan = trim((string) $hubungan);
        return in_array($hubungan, $this->hubungan, true) ? $hubungan : 'Ayah';
    }

    private function log_akun_data($data)
    {
        $copy = is_array($data) ? $data : array();
        unset($copy['password_hash']);
        return $copy;
    }
}
