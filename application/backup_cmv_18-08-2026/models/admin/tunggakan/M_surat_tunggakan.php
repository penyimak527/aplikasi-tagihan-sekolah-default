<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_surat_tunggakan extends CI_Model
{
    public function periode_list()
    {
        return $this->db->order_by('id', 'DESC')->get('master_tahun_ajaran')->result_array();
    }
    public function cari_siswa()
    {
        $q = trim((string)$this->input->post('q', true));
        if (strlen($q) < 2) return array();
        return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.nama_ayah,s.telepon_ayah,s.nama_ibu,s.telepon_ibu,k.id id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ? ORDER BY s.nama_lengkap LIMIT 20", array('%' . $q . '%', '%' . $q . '%', '%' . $q . '%'))->result_array();
    }
    public function siswa_by_id($id)
    {
        $row = $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.nama_ayah,s.telepon_ayah,s.nama_ibu,s.telepon_ibu,k.id id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.id=? LIMIT 1", array((int)$id))->row_array();
        return $row ? array('result' => 'true', 'siswa' => $row) : $this->model_response(false, 'Siswa tidak ditemukan.');
    }
    public function tagihan()
    {
        $id = (int)$this->input->post('id_siswa');
        $periode = (int)$this->input->post('id_periode');
        $bulan = (int)$this->input->post('batas_bulan');
        $tahun = (int)$this->input->post('batas_tahun');
        $this->db->where('id_siswa', $id)->where('status_tagihan', 'Aktif')->where('dianggap_tunggakan', 'Ya')->where('sisa_tagihan >', 0)->where_not_in('status_pembayaran', array('Lunas', 'Dibebaskan', 'Dibatalkan'));
        if ($periode) $this->db->where('id_periode', $periode);
        if ($bulan && $tahun) $this->db->group_start()->where('tahun <', $tahun)->or_group_start()->where('tahun', $tahun)->where('bulan <=', $bulan)->group_end()->group_end();
        return $this->db->order_by('tahun')->order_by('bulan')->get('tagihan_siswa')->result_array();
    }
    public function simpan()
    {
        $idSiswa = (int)$this->input->post('id_siswa');
        $ids = json_decode((string)$this->input->post('tagihan'), true);
        $tanggal = trim((string)$this->input->post('tanggal_surat', true));
        $nama = trim((string)$this->input->post('nama_penandatangan', true));
        $jabatan = trim((string)$this->input->post('jabatan_penandatangan', true));
        $catatan = trim((string)$this->input->post('catatan', true));
        $bulan = (int)$this->input->post('batas_bulan');
        $tahun = (int)$this->input->post('batas_tahun');
        if (!$idSiswa || !is_array($ids) || !count($ids)) return $this->model_response(false, 'Siswa dan minimal satu tagihan wajib dipilih.');
        if ($tanggal === '' || $nama === '' || $jabatan === '') return $this->model_response(false, 'Tanggal dan penandatangan wajib diisi.');
        $s = $this->db->query("SELECT s.*,k.id id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.id=? LIMIT 1", array($idSiswa))->row_array();
        if (!$s) return $this->model_response(false, 'Siswa tidak ditemukan.');
        $rows = array();
        $total = 0;
        foreach (array_unique(array_map('intval', $ids)) as $id) {
            $r = $this->db->where('id', $id)->where('id_siswa', $idSiswa)->where('status_tagihan', 'Aktif')->where('dianggap_tunggakan', 'Ya')->where('sisa_tagihan >', 0)->get('tagihan_siswa')->row_array();
            if (!$r) return $this->model_response(false, 'Salah satu tagihan tidak dapat dimasukkan ke surat.');
            $rows[] = $r;
            $total += (float)$r['sisa_tagihan'];
        }
        $this->db->trans_begin();
        $no = $this->tagihan_next_code('STG', 'tagihan_surat_tunggakan', 'no_surat');
        $head = array('no_surat' => $no, 'tanggal_surat' => $tanggal, 'id_siswa' => $idSiswa, 'nis' => $s['nis'], 'nisn' => $s['nisn'], 'nama_siswa' => $s['nama_lengkap'], 'id_kelas_setting' => (int)($s['id_kelas_setting'] ?? 0), 'id_kelas' => (int)($s['id_kelas'] ?? 0), 'nama_kelas' => $s['nama_kelas'] ?? '-', 'id_periode' => (int)($s['id_periode'] ?? 0), 'periode' => $s['periode'] ?? '-', 'batas_bulan' => $bulan, 'batas_tahun' => $tahun, 'total_tunggakan' => $total, 'jumlah_tagihan' => count($rows), 'nama_penandatangan' => $nama, 'jabatan_penandatangan' => $jabatan, 'catatan_surat' => $catatan, 'status_cetak' => 'Belum', 'status_kirim_whatsapp' => 'Belum', 'status_surat' => 'Aktif', 'tanggal' => $this->tanggal_sekarang(), 'waktu' => $this->waktu_sekarang(), 'id_user' => $this->app_user_id(), 'nama_user' => $this->app_user_name());
        $this->db->insert('tagihan_surat_tunggakan', $head);
        $idSurat = (int)$this->db->insert_id();
        foreach ($rows as $r) $this->db->insert('tagihan_surat_tunggakan_detail', array('id_surat_tunggakan' => $idSurat, 'no_surat' => $no, 'id_tagihan_siswa' => $r['id'], 'no_tagihan' => $r['no_tagihan'], 'nama_tagihan' => $r['nama_tagihan'], 'bulan' => $r['bulan'], 'nama_bulan' => $r['nama_bulan'], 'tahun' => $r['tahun'], 'nominal_tagihan' => $r['nominal_tagihan'], 'nominal_dibayar' => $r['nominal_dibayar'], 'sisa_tagihan' => $r['sisa_tagihan']));
        $this->tagihan_log_activity('Buat Surat Tunggakan', 'Tunggakan', 'Tambah', 'tagihan_surat_tunggakan', $idSurat, $no, 'Surat ' . $s['nama_lengkap'] . ' sebesar ' . $this->rupiah($total), null, $head);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->model_response(false, 'Surat gagal disimpan.');
        }
        $this->db->trans_commit();
        return $this->model_response(true, 'Surat tunggakan berhasil disimpan.', array('id' => $idSurat, 'no_surat' => $no));
    }
    public function riwayat()
    {
        return $this->db
            ->select('st.*,s.nama_ayah,s.telepon_ayah,s.nama_ibu,s.telepon_ibu')
            ->from('tagihan_surat_tunggakan st')
            ->join('siswa s', 's.id=st.id_siswa', 'left')
            ->order_by('st.id', 'DESC')
            ->limit(200)
            ->get()
            ->result_array();
    }
    public function detail($id)
    {
        $h = $this->db->where('id', $id)->get('tagihan_surat_tunggakan')->row_array();
        if (!$h) return $this->model_response(false, 'Surat tidak ditemukan.');
        return array('result' => 'true', 'header' => $h, 'detail' => $this->db->where('id_surat_tunggakan', $id)->order_by('tahun')->order_by('bulan')->get('tagihan_surat_tunggakan_detail')->result_array(), 'siswa' => $this->db->where('id', $h['id_siswa'])->get('siswa')->row_array());
    }
    private function template($tpl, $h, $s, $namaPenerima = '')
    {
        $namaWali = trim((string)$namaPenerima);

        if ($namaWali === '') {
            $namaWali =
                trim($s['nama_ayah'] ?? '')
                ?: trim($s['nama_ibu'] ?? '');
        }

        if ($namaWali === '') {
            $namaWali = 'Bapak/Ibu Wali';
        }

        $map = array(
            '{nama_wali}' => $namaWali,
            '{nama_siswa}' => $h['nama_siswa'],
            '{kelas}' => $h['nama_kelas'],
            '{tanggal}' => $h['tanggal_surat'],
            '{no_transaksi}' => $h['no_surat'],
            '{total_bayar}' => '',
            '{total_tunggakan}' => $this->rupiah($h['total_tunggakan']),
            '{nama_sekolah}' => $this->config->item('nama_sekolah') ?: 'Sekolah',
            '{nama_petugas}' => $h['nama_user']
        );

        return strtr($tpl, $map);
    }
    public function siapkan_whatsapp()
    {
        $id = (int)$this->input->post('id');
        $no = $this->bersihkan_nomor_wa((string)$this->input->post('nomor', true));
        $hub = trim((string)$this->input->post('hubungan', true));
        $nama = trim((string)$this->input->post('nama_penerima', true));
        $pesan = trim((string)$this->input->post('pesan', false));
        $d = $this->detail($id);
        if ($d['result'] !== 'true') return $d;
        if ($no === '') return $this->model_response(false, 'Nomor WhatsApp wajib diisi.');

        $siswa = $d['siswa'] ?: array();

        /*
         * Nama penerima Surat Tunggakan mengikuti pilihan pada modal.
         * Jika kosong, backend tetap melakukan fallback berdasarkan hubungan.
         */
        if ($nama === '') {
            if ($hub === 'Ayah') {
                $nama = trim($siswa['nama_ayah'] ?? '');
            } elseif ($hub === 'Ibu') {
                $nama = trim($siswa['nama_ibu'] ?? '');
            }
        }

        if ($nama === '') {
            return $this->model_response(false, 'Nama penerima WhatsApp wajib diisi.');
        }

        if ($pesan === '') {
            $tpl = $this->db
                ->where('jenis_template', 'Surat Tunggakan')
                ->where('status', 'Aktif')
                ->order_by("status_default='Ya'", 'DESC', false)
                ->get('tagihan_template_whatsapp')
                ->row_array();

            $pesan = $this->template(
                $tpl
                    ? $tpl['isi_template']
                    : 'Yth. Bapak/Ibu {nama_wali}, berikut kami sampaikan surat pemberitahuan tunggakan {nama_siswa} sebesar {total_tunggakan}. Terima kasih.',
                $d['header'],
                $siswa,
                $nama
            );
        }

        $this->db->trans_begin();
        $this->db->insert('tagihan_riwayat_whatsapp', array('jenis_kirim' => 'Surat Tunggakan', 'id_referensi' => $id, 'nomor_referensi' => $d['header']['no_surat'], 'id_siswa' => $d['header']['id_siswa'], 'nama_siswa' => $d['header']['nama_siswa'], 'nama_penerima' => $nama, 'hubungan_penerima' => $hub, 'nomor_whatsapp' => $no, 'isi_pesan' => $pesan, 'metode_kirim' => 'Tautan', 'status_kirim' => 'Disiapkan', 'tanggal' => $this->tanggal_sekarang(), 'waktu' => $this->waktu_sekarang(), 'id_user' => $this->app_user_id(), 'nama_user' => $this->app_user_name()));
        $this->db->where('id', $id)->update('tagihan_surat_tunggakan', array('status_kirim_whatsapp' => 'Disiapkan'));
        $this->tagihan_log_activity('Kirim Surat Tunggakan WhatsApp', 'Tunggakan', 'Kirim', 'tagihan_surat_tunggakan', $id, $d['header']['no_surat'], 'Surat disiapkan ke ' . $no);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $this->model_response(false, 'Gagal menyiapkan WhatsApp.');
        }
        $this->db->trans_commit();
        return $this->model_response(true, 'WhatsApp berhasil disiapkan.', array('url' => 'https://wa.me/' . $no . '?text=' . rawurlencode($pesan), 'pesan' => $pesan));
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


    private function tanggal_sekarang()
    {
        return date('d-m-Y');
    }


    private function waktu_sekarang()
    {
        return date('H:i:s');
    }


    private function bersihkan_nomor_wa($phone)
    {
        $phone = preg_replace('/[^0-9]/', '', (string) $phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }


    private function model_response($success, $message = '', $extra = array())
    {
        return array_merge(array(
            'result' => $success ? 'true' : 'false',
            'message' => $message
        ), $extra);
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
