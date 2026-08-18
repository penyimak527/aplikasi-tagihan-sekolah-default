<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_daftar_tagihan extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }
    public function jenis_list()
    {
        return $this->db->order_by('nama_jenis')->get('tagihan_jenis')->result_array();
    }
    public function result()
    {
        $idPeriode = (int)$this->input->post('id_periode');
        $tipe = trim((string)$this->input->post('tipe', true));
        $jenis = (int)$this->input->post('id_jenis');
        $status = trim((string)$this->input->post('status', true));
        $search = trim((string)$this->input->post('search', true));
        $this->db->select("m.*, COUNT(DISTINCT ts.id_siswa) jumlah_siswa, COALESCE(SUM(ts.nominal_tagihan),0) total_nominal, SUM(CASE WHEN ts.status_pembayaran='Belum Dibayar' THEN 1 ELSE 0 END) belum_bayar, SUM(CASE WHEN ts.status_pembayaran='Dibayar Sebagian' THEN 1 ELSE 0 END) sebagian, SUM(CASE WHEN ts.status_pembayaran='Lunas' THEN 1 ELSE 0 END) lunas, SUM(CASE WHEN ts.status_pembayaran='Dibebaskan' THEN 1 ELSE 0 END) dibebaskan")->from('tagihan_master m')->join('tagihan_siswa ts', 'ts.id_tagihan_master=m.id', 'left')->group_by('m.id');
        if ($idPeriode) $this->db->where('m.id_periode', $idPeriode);
        if ($tipe !== '') $this->db->where('m.tipe_tagihan', $tipe);
        if ($jenis) $this->db->where('m.id_jenis_tagihan', $jenis);
        if ($status !== '') $this->db->where('m.status', $status);
        if ($search !== '') $this->db->group_start()->like('m.nama_tagihan', $search)->or_like('m.kode_tagihan', $search)->group_end();
        return $this->db->order_by('m.id', 'DESC')->get()->result_array();
    }
    public function detail()
    {
        $id = (int)$this->input->post('id');
        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$master) return array('result' => 'false', 'message' => 'Tagihan tidak ditemukan.');
        return array('result' => 'true', 'master' => $master, 'periods' => $this->db->where('id_tagihan_master', $id)->order_by('tahun')->order_by('bulan')->get('tagihan_tarif_bulan')->result_array(), 'classes' => $this->db->where('id_tagihan_master', $id)->get('tagihan_target_kelas')->result_array(), 'students' => $this->db->where('id_tagihan_master', $id)->limit(100)->get('tagihan_siswa')->result_array());
    }

    public function draft_detail()
    {
        $id = (int) $this->input->post('id');
        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();

        if (!$master) {
            return $this->model_response(false, 'Draft tagihan tidak ditemukan.');
        }
        if ($master['status'] !== 'Draft') {
            return $this->model_response(false, 'Hanya tagihan berstatus Draft yang dapat diedit.');
        }
        if ($this->db->where('id_tagihan_master', $id)->count_all_results('tagihan_siswa') > 0) {
            return $this->model_response(false, 'Draft sudah memiliki tagihan siswa dan tidak dapat diedit dari halaman ini.');
        }

        return $this->model_response(true, 'Draft berhasil dimuat.', array(
            'master' => $master,
            'periods' => $this->db
                ->where('id_tagihan_master', $id)
                ->where('status', 'Aktif')
                ->order_by('tahun', 'ASC')
                ->order_by('bulan', 'ASC')
                ->get('tagihan_tarif_bulan')
                ->result_array(),
            'classes' => $this->db
                ->where('id_tagihan_master', $id)
                ->where('status', 'Aktif')
                ->get('tagihan_target_kelas')
                ->result_array(),
            'students' => $this->db
                ->where('id_tagihan_master', $id)
                ->where('status', 'Aktif')
                ->get('tagihan_target_siswa')
                ->result_array()
        ));
    }

    public function update_draft()
    {
        $id = (int) $this->input->post('id');
        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();

        if (!$master) {
            return $this->model_response(false, 'Draft tagihan tidak ditemukan.');
        }
        if ($master['status'] !== 'Draft') {
            return $this->model_response(false, 'Hanya tagihan berstatus Draft yang dapat diubah.');
        }
        if ($this->db->where('id_tagihan_master', $id)->count_all_results('tagihan_siswa') > 0) {
            return $this->model_response(false, 'Draft sudah memiliki tagihan siswa dan tidak dapat diubah.');
        }

        $nama = trim((string) $this->input->post('nama_tagihan', true));
        $tunggakan = $this->input->post('dianggap_tunggakan', true) === 'Tidak' ? 'Tidak' : 'Ya';
        $keterangan = trim((string) $this->input->post('keterangan', true));
        $periodJson = (string) $this->input->post('period_json');
        $periods = json_decode($periodJson, true);

        if ($nama === '') {
            return $this->model_response(false, 'Nama tagihan wajib diisi.');
        }
        if (!is_array($periods) || !count($periods)) {
            return $this->model_response(false, 'Minimal satu periode tarif harus tersedia.');
        }

        $storedPeriods = $this->db
            ->where('id_tagihan_master', $id)
            ->where('status', 'Aktif')
            ->get('tagihan_tarif_bulan')
            ->result_array();
        $storedMap = array();
        foreach ($storedPeriods as $row) {
            $storedMap[(int) $row['id']] = $row;
        }

        $nominalDefault = 0;
        $first = null;
        $last = null;
        $this->db->trans_begin();

        foreach ($periods as $row) {
            $periodId = isset($row['id']) ? (int) $row['id'] : 0;
            if ($periodId <= 0 || !isset($storedMap[$periodId])) {
                $this->db->trans_rollback();
                return $this->model_response(false, 'Periode draft tidak valid.');
            }

            $nominalText = isset($row['nominal']) ? (string) $row['nominal'] : '0';
            $nominal = (float) preg_replace('/[^0-9]/', '', $nominalText);
            $jatuhTempo = isset($row['tanggal_jatuh_tempo']) ? trim((string) $row['tanggal_jatuh_tempo']) : '';

            if ($nominal <= 0) {
                $this->db->trans_rollback();
                return $this->model_response(false, 'Nominal setiap periode harus lebih dari nol.');
            }

            $this->db->where('id', $periodId)->update('tagihan_tarif_bulan', array(
                'nominal' => $nominal,
                'tanggal_jatuh_tempo' => $jatuhTempo
            ));

            if ($first === null) {
                $first = $storedMap[$periodId];
                $nominalDefault = $nominal;
            }
            $last = $storedMap[$periodId];
        }

        $update = array(
            'nama_tagihan' => $nama,
            'dianggap_tunggakan' => $tunggakan,
            'nominal_default' => $nominalDefault,
            'tanggal_jatuh_tempo' => isset($periods[0]['tanggal_jatuh_tempo']) ? trim((string) $periods[0]['tanggal_jatuh_tempo']) : '',
            'keterangan' => $keterangan,
            'tanggal_update' => date('d-m-Y'),
            'waktu_update' => date('H:i:s'),
            'id_user_update' => isset($this->session->userdata('admin')['id']) ? (int) $this->session->userdata('admin')['id'] : 0,
            'nama_user_update' => isset($this->session->userdata('admin')['nama']) ? $this->session->userdata('admin')['nama'] : 'Administrator'
        );

        $this->db->where('id', $id)->update('tagihan_master', $update);

        $this->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => 'Edit Draft Tagihan',
            'modul' => 'Tagihan',
            'aksi' => 'Ubah',
            'nama_tabel' => 'tagihan_master',
            'id_referensi' => (string) $id,
            'nomor_referensi' => $master['kode_tagihan'],
            'keterangan' => 'Mengubah draft tagihan sebelum diterbitkan.',
            'data_sebelum' => json_encode($master, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => json_encode(array_merge($master, $update), JSON_UNESCAPED_UNICODE),
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => $update['id_user_update'],
            'nama_user' => $update['nama_user_update']
        ));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return $this->model_response(false, 'Draft tagihan gagal diperbarui.');
        }

        $this->db->trans_commit();
        return $this->model_response(true, 'Draft tagihan berhasil diperbarui.');
    }

    public function hapus_draft()
    {
        $id = (int) $this->input->post('id');
        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();

        if (!$master) {
            return $this->model_response(false, 'Draft tagihan tidak ditemukan.');
        }
        if ($master['status'] !== 'Draft') {
            return $this->model_response(false, 'Hanya tagihan berstatus Draft yang dapat dihapus.');
        }
        if ($this->db->where('id_tagihan_master', $id)->count_all_results('tagihan_siswa') > 0) {
            return $this->model_response(false, 'Draft sudah memiliki tagihan siswa sehingga tidak dapat dihapus.');
        }

        $user = $this->session->userdata('admin');
        $idUser = is_array($user) && isset($user['id']) ? (int) $user['id'] : 0;
        $namaUser = is_array($user) && isset($user['nama']) ? $user['nama'] : 'Administrator';

        $this->db->trans_begin();

        $this->db->insert('tagihan_log_aktivitas', array(
            'jenis_aktivitas' => 'Hapus Draft Tagihan',
            'modul' => 'Tagihan',
            'aksi' => 'Batal',
            'nama_tabel' => 'tagihan_master',
            'id_referensi' => (string) $id,
            'nomor_referensi' => $master['kode_tagihan'],
            'keterangan' => 'Menghapus draft tagihan yang belum diterbitkan.',
            'data_sebelum' => json_encode($master, JSON_UNESCAPED_UNICODE),
            'data_sesudah' => null,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'tanggal' => date('d-m-Y'),
            'waktu' => date('H:i:s'),
            'id_user' => $idUser,
            'nama_user' => $namaUser
        ));

        $this->db->where('id_tagihan_master', $id)->delete('tagihan_tarif_bulan');
        $this->db->where('id_tagihan_master', $id)->delete('tagihan_target_kelas');
        $this->db->where('id_tagihan_master', $id)->delete('tagihan_target_siswa');
        $this->db->where('id', $id)->delete('tagihan_master');

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return $this->model_response(false, 'Draft tagihan gagal dihapus.');
        }

        $this->db->trans_commit();
        return $this->model_response(true, 'Draft tagihan berhasil dihapus.');
    }

    private function generate($master)
    {
        $id = (int)$master['id'];
        $periods = $this->db->where('id_tagihan_master', $id)->where('status', 'Aktif')->get('tagihan_tarif_bulan')->result_array();
        $classTargets = $this->db->where('id_tagihan_master', $id)->where('status', 'Aktif')->get('tagihan_target_kelas')->result_array();
        $studentTargets = $this->db->where('id_tagihan_master', $id)->where('status', 'Aktif')->get('tagihan_target_siswa')->result_array();
        $classIds = array_column($classTargets, 'id_kelas_setting');
        if ($master['target_tagihan'] === 'Siswa' && $studentTargets) {
            $ids = array_column($studentTargets, 'id_siswa');
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $students = $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,k.id id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.id IN ($placeholders) AND CAST(k.id_periode AS UNSIGNED)=?", array_merge($ids, array((int)$master['id_periode'])))->result_array();
        } else {
            if (!$classIds) return array(0, 0);
            $placeholders = implode(',', array_fill(0, count($classIds), '?'));
            $students = $this->db->query("SELECT DISTINCT s.id,s.nis,s.nisn,s.nama_lengkap,k.id id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE k.id IN ($placeholders) AND s.status_pendaftaran='Aktif'", $classIds)->result_array();
        }
        $classMap = array();
        foreach ($classTargets as $x) $classMap[(int)$x['id_kelas_setting']] = $x;
        $studentMap = array();
        foreach ($studentTargets as $x) $studentMap[(int)$x['id_siswa']] = $x;
        $generated = 0;
        $skipped = 0;
        foreach ($students as $s) {
            foreach ($periods as $p) {
                $this->db->from('tagihan_siswa')
                    ->where('id_siswa', (int) $s['id'])
                    ->where('id_jenis_tagihan', (int) $master['id_jenis_tagihan'])
                    ->where('id_periode', (int) $master['id_periode'])
                    ->where('status_tagihan', 'Aktif');

                if ($master['tipe_tagihan'] === 'Tahunan') {
                    $this->db->where('tipe_tagihan', 'Tahunan');
                } elseif ($master['tipe_tagihan'] === 'Bulanan') {
                    $this->db->where('tipe_tagihan', 'Bulanan')
                        ->where('bulan', (int) $p['bulan'])
                        ->where('tahun', (int) $p['tahun']);
                } else {
                    $this->db->where('id_tagihan_master', $id)
                        ->where('bulan', (int) $p['bulan'])
                        ->where('tahun', (int) $p['tahun']);
                }

                if ($this->db->count_all_results() > 0) {
                    $skipped++;
                    continue;
                }
                $nom = (float)$p['nominal'];
                if (isset($classMap[(int)$s['id_kelas_setting']]) && (float)$classMap[(int)$s['id_kelas_setting']]['nominal_kelas'] > 0) $nom = (float)$classMap[(int)$s['id_kelas_setting']]['nominal_kelas'];
                if (isset($studentMap[(int)$s['id']]) && (float)$studentMap[(int)$s['id']]['nominal_target'] > 0) $nom = (float)$studentMap[(int)$s['id']]['nominal_target'];
                $this->db->insert('tagihan_siswa', array('no_tagihan' => $this->tagihan_next_code('TAG', 'tagihan_siswa', 'no_tagihan'), 'id_tagihan_master' => $id, 'kode_tagihan' => $master['kode_tagihan'], 'id_jenis_tagihan' => $master['id_jenis_tagihan'], 'nama_jenis_tagihan' => $master['nama_jenis_tagihan'], 'nama_tagihan' => $master['nama_tagihan'], 'tipe_tagihan' => $master['tipe_tagihan'], 'id_periode' => $master['id_periode'], 'periode' => $master['periode'], 'semester' => null, 'bulan' => $p['bulan'], 'nama_bulan' => $p['nama_bulan'], 'tahun' => $p['tahun'], 'tanggal_jatuh_tempo' => $p['tanggal_jatuh_tempo'], 'id_siswa' => $s['id'], 'nis' => $s['nis'], 'nisn' => $s['nisn'], 'nama_siswa' => $s['nama_lengkap'], 'id_kelas_setting' => $s['id_kelas_setting'], 'id_kelas' => $s['id_kelas'], 'nama_kelas' => $s['nama_kelas'], 'nominal_awal' => $nom, 'nilai_keringanan' => 0, 'nominal_tagihan' => $nom, 'nominal_dibayar' => 0, 'sisa_tagihan' => $nom, 'dianggap_tunggakan' => $master['dianggap_tunggakan'], 'status_pembayaran' => 'Belum Dibayar', 'status_tagihan' => 'Aktif', 'keterangan' => $master['keterangan'], 'tanggal_generate' => $this->tanggal_sekarang(), 'waktu_generate' => $this->waktu_sekarang(), 'id_user_generate' => $this->app_user_id(), 'nama_user_generate' => $this->app_user_name()));
                $generated++;
            }
        }
        return array($generated, $skipped);
    }
    public function terbitkan()
    {
        $id = (int)$this->input->post('id');
        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$master) return $this->model_response(false, 'Tagihan tidak ditemukan.');
        if ($master['status'] !== 'Draft') return $this->model_response(false, 'Hanya draft yang dapat diterbitkan.');
        $this->db->trans_begin();
        list($generated, $skipped) = $this->generate($master);
        if (!$generated && $skipped === 0) {
            $this->db->trans_rollback();
            return $this->model_response(false, 'Tidak ada target siswa yang dapat dibuatkan tagihan.');
        }
        $this->db->where('id', $id)->update('tagihan_master', array('status' => 'Aktif', 'status_generate' => 'Selesai', 'tanggal_update' => $this->tanggal_sekarang(), 'waktu_update' => $this->waktu_sekarang(), 'id_user_update' => $this->app_user_id(), 'nama_user_update' => $this->app_user_name()));
        $this->tagihan_log_activity('Terbitkan Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', $id, $master['kode_tagihan'], $generated . ' tagihan diterbitkan', $master, array('status' => 'Aktif'));
        return $this->tagihan_transaction_result($generated . ' tagihan berhasil diterbitkan' . ($skipped ? ' dan ' . $skipped . ' duplikat dilewati.' : '.'));
    }
    public function batalkan_sisa()
    {
        $id = (int)$this->input->post('id');
        $alasan = trim((string)$this->input->post('alasan', true));
        if ($alasan === '') return $this->model_response(false, 'Alasan pembatalan wajib diisi.');
        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        if (!$master) return $this->model_response(false, 'Tagihan tidak ditemukan.');
        $rows = $this->db->where('id_tagihan_master', $id)->where('status_tagihan', 'Aktif')->where('sisa_tagihan >', 0)->get('tagihan_siswa')->result_array();
        $this->db->trans_begin();
        foreach ($rows as $r) {
            $this->db->where('id', $r['id'])->update('tagihan_siswa', array('sisa_tagihan' => 0, 'status_tagihan' => 'Dibatalkan', 'status_pembayaran' => 'Dibatalkan', 'keterangan' => trim($r['keterangan'] . ' | Dibatalkan: ' . $alasan), 'tanggal_update' => $this->tanggal_sekarang(), 'waktu_update' => $this->waktu_sekarang()));
        }
        $this->db->where('id', $id)->update('tagihan_master', array('status' => 'Dibatalkan', 'tanggal_update' => $this->tanggal_sekarang(), 'waktu_update' => $this->waktu_sekarang(), 'id_user_update' => $this->app_user_id(), 'nama_user_update' => $this->app_user_name()));
        $this->tagihan_log_activity('Batalkan Sisa Tagihan', 'Tagihan', 'Batal', 'tagihan_master', $id, $master['kode_tagihan'], $alasan, $master, array('status' => 'Dibatalkan', 'jumlah' => count($rows)));
        return $this->tagihan_transaction_result(count($rows) . ' sisa tagihan berhasil dibatalkan. Pembayaran yang sudah masuk tetap tersimpan.');
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
