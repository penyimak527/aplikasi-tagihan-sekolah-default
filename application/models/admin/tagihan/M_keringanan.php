<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_keringanan extends CI_Model
{
    public function cari_siswa()
    {
        $q = trim((string) $this->input->post('q', true));
        $like = '%' . $q . '%';
        return $this->db->query("SELECT DISTINCT id_siswa,nis,nisn,nama_siswa,nama_kelas FROM tagihan_siswa WHERE status_tagihan='Aktif' AND (nama_siswa LIKE ? OR nis LIKE ? OR nisn LIKE ?) ORDER BY nama_siswa LIMIT 30", array($like, $like, $like))->result_array();
    }
    public function tagihan_siswa()
    {
        $sid = (int) $this->input->post('id_siswa');
        return $this->db->where('id_siswa', $sid)->where('status_tagihan', 'Aktif')->order_by('tahun')->order_by('bulan')->get('tagihan_siswa')->result_array();
    }
    public function riwayat()
    {
        $sid = (int) $this->input->post('id_siswa');
        return $this->db->where('id_siswa', $sid)->where_in('jenis_keringanan', array('Potongan Nominal', 'Potongan Persen', 'Pembebasan Penuh'))->order_by('id', 'DESC')->get('tagihan_keringanan_siswa')->result_array();
    }
    public function simpan()
    {
        $idTagihan = (int) $this->input->post('id_tagihan_siswa');
        $jenis = trim((string) $this->input->post('jenis_keringanan', true));
        $nilai = nilai_nominal($this->input->post('nilai_keringanan'));
        $alasan = trim((string) $this->input->post('alasan', true));
        $row = $this->db->where('id', $idTagihan)->where('status_tagihan', 'Aktif')->get('tagihan_siswa')->row_array();
        if (!$row || !in_array($jenis, array('Potongan Nominal', 'Potongan Persen', 'Pembebasan Penuh'), true) || $alasan === '')
            return model_response(false, 'Tagihan, jenis keringanan, dan alasan wajib diisi.');
        $awal = (float) $row['nominal_awal'];
        $dibayar = (float) $row['nominal_dibayar'];
        if ($jenis === 'Potongan Nominal')
            $potongan = $nilai;
        elseif ($jenis === 'Potongan Persen') {
            $nilai = max(0, min(100, $nilai));
            $potongan = $awal * $nilai / 100;
        } else {
            $potongan = $awal;
        }
        $akhir = max(0, $awal - $potongan);
        if ($akhir < $dibayar)
            return model_response(false, 'Nominal akhir tidak boleh lebih kecil dari pembayaran yang sudah masuk.');
        $sisa = max(0, $akhir - $dibayar);
        $status = $jenis === 'Pembebasan Penuh' && $dibayar <= 0 ? 'Dibebaskan' : ($sisa <= 0 ? 'Lunas' : ($dibayar > 0 ? 'Dibayar Sebagian' : 'Belum Dibayar'));
        $this->db->trans_begin();
        $this->db->where('id_tagihan_master', $row['id_tagihan_master'])->where('id_siswa', $row['id_siswa'])->where('bulan', $row['bulan'])->where('tahun', $row['tahun'])->where_in('jenis_keringanan', array('Potongan Nominal', 'Potongan Persen', 'Pembebasan Penuh'))->where('status', 'Aktif')->update('tagihan_keringanan_siswa', array('status' => 'Dibatalkan', 'tanggal_batal' => tanggal_sekarang(), 'waktu_batal' => waktu_sekarang(), 'id_user_batal' => app_user_id(), 'nama_user_batal' => app_user_name(), 'alasan_batal' => 'Diganti keringanan baru'));
        $data = array('id_tagihan_master' => $row['id_tagihan_master'], 'id_siswa' => $row['id_siswa'], 'nis' => $row['nis'], 'nisn' => $row['nisn'], 'nama_siswa' => $row['nama_siswa'], 'bulan' => $row['bulan'], 'tahun' => $row['tahun'], 'jenis_keringanan' => $jenis, 'nominal_awal' => $awal, 'nilai_keringanan' => $jenis === 'Potongan Persen' ? $nilai : $potongan, 'nominal_setelah_keringanan' => $akhir, 'alasan' => $alasan, 'status' => 'Aktif', 'tanggal_mulai' => tanggal_sekarang(), 'tanggal' => tanggal_sekarang(), 'waktu' => waktu_sekarang(), 'id_user' => app_user_id(), 'nama_user' => app_user_name());
        $this->db->insert('tagihan_keringanan_siswa', $data);
        $id = $this->db->insert_id();
        $this->db->where('id', $idTagihan)->update('tagihan_siswa', array('jenis_keringanan' => $jenis, 'nilai_keringanan' => $potongan, 'nominal_tagihan' => $akhir, 'sisa_tagihan' => $sisa, 'status_pembayaran' => $status, 'tanggal_update' => tanggal_sekarang(), 'waktu_update' => waktu_sekarang()));
        tagihan_log_activity('Keringanan Tagihan', 'Tagihan', 'Ubah', 'tagihan_siswa', $idTagihan, $row['no_tagihan'], $jenis . ' ' . rupiah($potongan) . ' - ' . $alasan, $row, array('nominal_tagihan' => $akhir, 'sisa_tagihan' => $sisa, 'status' => $status));
        return tagihan_transaction_result('Keringanan berhasil disimpan.');
    }
    public function batalkan()
    {
        $id = (int) $this->input->post('id');
        $alasan = trim((string) $this->input->post('alasan', true));
        $k = $this->db->where('id', $id)->where('status', 'Aktif')->get('tagihan_keringanan_siswa')->row_array();
        if (!$k || $alasan === '')
            return model_response(false, 'Keringanan aktif dan alasan pembatalan wajib tersedia.');
        $row = $this->db->where('id_tagihan_master', $k['id_tagihan_master'])->where('id_siswa', $k['id_siswa'])->where('bulan', $k['bulan'])->where('tahun', $k['tahun'])->get('tagihan_siswa')->row_array();
        if (!$row)
            return model_response(false, 'Tagihan siswa tidak ditemukan.');
        $normal = (float) $row['nominal_awal'];
        $sisa = max(0, $normal - (float) $row['nominal_dibayar']);
        $status = $sisa <= 0 ? 'Lunas' : ((float) $row['nominal_dibayar'] > 0 ? 'Dibayar Sebagian' : 'Belum Dibayar');
        $this->db->trans_begin();
        $this->db->where('id', $id)->update('tagihan_keringanan_siswa', array('status' => 'Dibatalkan', 'tanggal_batal' => tanggal_sekarang(), 'waktu_batal' => waktu_sekarang(), 'id_user_batal' => app_user_id(), 'nama_user_batal' => app_user_name(), 'alasan_batal' => $alasan));
        $this->db->where('id', $row['id'])->update('tagihan_siswa', array('jenis_keringanan' => null, 'nilai_keringanan' => 0, 'nominal_tagihan' => $normal, 'sisa_tagihan' => $sisa, 'status_pembayaran' => $status, 'tanggal_update' => tanggal_sekarang(), 'waktu_update' => waktu_sekarang()));
        tagihan_log_activity('Batalkan Keringanan', 'Tagihan', 'Batal', 'tagihan_keringanan_siswa', $id, $row['no_tagihan'], $alasan, $k, array('status' => 'Dibatalkan'));
        return tagihan_transaction_result('Keringanan berhasil dibatalkan dan tarif normal dipulihkan.');
    }
}
