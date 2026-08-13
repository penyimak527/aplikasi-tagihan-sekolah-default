<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_riwayat_pembayaran extends CI_Model
{
    public function metode_list()
    {
        return $this->db->where('status', 'Aktif')->order_by('nama_metode')->get('tagihan_metode_pembayaran')->result_array();
    }
    private function apply_filters($forceStatus = null)
    {
        $q = trim((string) $this->input->post_get('q', true));
        $awal = trim((string) $this->input->post_get('awal', true));
        $akhir = trim((string) $this->input->post_get('akhir', true));
        $metode = (int) $this->input->post_get('metode');
        $status = trim((string) $this->input->post_get('status', true));
        $petugas = trim((string) $this->input->post_get('petugas', true));
        if ($q !== '')
            $this->db->group_start()->like('p.no_transaksi', $q)->or_like('p.nama_siswa', $q)->or_like('p.nis', $q)->group_end();
        if ($awal !== '')
            $this->db->where("STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y') >=", date('Y-m-d', strtotime(str_replace('/', '-', $awal))));
        if ($akhir !== '')
            $this->db->where("STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y') <=", date('Y-m-d', strtotime(str_replace('/', '-', $akhir))));
        if ($metode)
            $this->db->where('p.id_metode_pembayaran', $metode);
        if ($forceStatus !== null)
            $this->db->where('p.status_transaksi', $forceStatus);
        elseif ($status !== '')
            $this->db->where('p.status_transaksi', $status);
        if ($petugas !== '')
            $this->db->like('p.nama_user', $petugas);
    }
    public function result()
    {
        $this->db->select('p.*,c.alasan_pembatalan,c.nama_user_pembatalan,c.tanggal_pembatalan,c.waktu_pembatalan')->from('tagihan_pembayaran p')->join('tagihan_pembatalan_transaksi c', 'c.id_pembayaran=p.id', 'left');
        $this->apply_filters();
        return $this->db->order_by("STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y')", 'DESC', false)->order_by('p.waktu_transaksi', 'DESC')->order_by('p.id', 'DESC')->limit(1000)->get()->result_array();
    }
    public function result_aktif()
    {
        $this->db->select('p.*')->from('tagihan_pembayaran p');
        $this->apply_filters('Aktif');
        return $this->db->order_by("STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y')", 'DESC', false)->order_by('p.waktu_transaksi', 'DESC')->order_by('p.id', 'DESC')->limit(1000)->get()->result_array();
    }
    public function detail($id)
    {
        $p = $this->db->where('id', $id)->get('tagihan_pembayaran')->row_array();
        if (!$p)
            return model_response(false, 'Transaksi tidak ditemukan.');
        return array('result' => 'true', 'header' => $p, 'detail' => $this->db->where('id_pembayaran', $id)->order_by('id')->get('tagihan_pembayaran_detail')->result_array(), 'pembatalan' => $this->db->where('id_pembayaran', $id)->get('tagihan_pembatalan_transaksi')->row_array(), 'siswa' => $this->db->where('id', $p['id_siswa'])->get('siswa')->row_array());
    }
    private function status($paid, $total)
    {
        if ($paid <= 0)
            return 'Belum Dibayar';
        if ($paid + 0.001 >= $total)
            return 'Lunas';
        return 'Dibayar Sebagian';
    }
    public function batalkan()
    {
        $id = (int) $this->input->post('id');
        $alasan = trim((string) $this->input->post('alasan', true));
        if ($alasan === '')
            return model_response(false, 'Alasan pembatalan wajib diisi.');
        $p = $this->db->where('id', $id)->get('tagihan_pembayaran')->row_array();
        if (!$p)
            return model_response(false, 'Transaksi tidak ditemukan.');
        if ($p['status_transaksi'] !== 'Aktif')
            return model_response(false, 'Transaksi ini sudah dibatalkan.');
        if ($this->db->where('id_pembayaran', $id)->count_all_results('tagihan_pembatalan_transaksi'))
            return model_response(false, 'Riwayat pembatalan sudah tersedia.');
        $details = $this->db->where('id_pembayaran', $id)->where('status_detail', 'Aktif')->get('tagihan_pembayaran_detail')->result_array();
        if (!$details)
            return model_response(false, 'Detail transaksi tidak ditemukan.');
        $this->db->trans_begin();
        foreach ($details as $d) {
            $bill = $this->db->where('id', $d['id_tagihan_siswa'])->get('tagihan_siswa')->row_array();
            if (!$bill) {
                $this->db->trans_rollback();
                return model_response(false, 'Tagihan ' . $d['no_tagihan'] . ' tidak ditemukan. Tidak ada perubahan disimpan.');
            }
            $newPaid = max(0, (float) $bill['nominal_dibayar'] - (float) $d['nominal_bayar']);
            $newSisa = max(0, (float) $bill['nominal_tagihan'] - $newPaid);
            $newStatus = $this->status($newPaid, (float) $bill['nominal_tagihan']);
            $this->db->where('id', $bill['id'])->update('tagihan_siswa', array('nominal_dibayar' => $newPaid, 'sisa_tagihan' => $newSisa, 'status_pembayaran' => $newStatus, 'tanggal_update' => tanggal_sekarang(), 'waktu_update' => waktu_sekarang()));
            $this->db->where('id', $d['id'])->update('tagihan_pembayaran_detail', array('status_detail' => 'Dibatalkan'));
        }
        $this->db->where('id', $id)->update('tagihan_pembayaran', array('status_transaksi' => 'Dibatalkan', 'keterangan' => trim($p['keterangan'] . ' | Pembatalan: ' . $alasan)));
        $this->db->insert('tagihan_pembatalan_transaksi', array('id_pembayaran' => $id, 'no_transaksi' => $p['no_transaksi'], 'id_siswa' => $p['id_siswa'], 'nis' => $p['nis'], 'nama_siswa' => $p['nama_siswa'], 'total_pembayaran' => $p['total_pembayaran'], 'alasan_pembatalan' => $alasan, 'tanggal_transaksi_asli' => $p['tanggal_transaksi'], 'waktu_transaksi_asli' => $p['waktu_transaksi'], 'id_user_transaksi' => $p['id_user'], 'nama_user_transaksi' => $p['nama_user'], 'tanggal_pembatalan' => tanggal_sekarang(), 'waktu_pembatalan' => waktu_sekarang(), 'id_user_pembatalan' => app_user_id(), 'nama_user_pembatalan' => app_user_name(), 'ip_address' => $this->input->ip_address()));
        tagihan_log_activity('Batalkan Pembayaran', 'Transaksi', 'Batal', 'tagihan_pembayaran', $id, $p['no_transaksi'], $alasan, $p, array('status_transaksi' => 'Dibatalkan'));
        return tagihan_transaction_result('Transaksi berhasil dibatalkan dan saldo seluruh tagihan telah dikembalikan.');
    }
    public function catat_cetak($id)
    {
        $p = $this->db->where('id', $id)->get('tagihan_pembayaran')->row_array();
        if (!$p)
            return model_response(false, 'Transaksi tidak ditemukan.');
        $this->db->set('jumlah_cetak', 'jumlah_cetak+1', false)->set('status_cetak', 'Sudah')->where('id', $id)->update('tagihan_pembayaran');
        tagihan_log_activity('Cetak Ulang Bukti', 'Transaksi', 'Cetak', 'tagihan_pembayaran', $id, $p['no_transaksi'], 'Bukti pembayaran dicetak/disimpan PDF.');
        return model_response(true, 'Cetak dicatat.');
    }
   public function export_csv()
{
    $rows = $this->result();
    $name = 'riwayat_pembayaran_' . date('Ymd_His') . '.csv';

    $this->db->insert('tagihan_log_export', array(
        'jenis_laporan' => 'Riwayat Pembayaran',
        'format_export' => 'Excel CSV',
        'filter_json' => json_encode($this->input->get()),
        'nama_file' => $name,
        'jumlah_data' => count($rows),
        'tanggal' => tanggal_sekarang(),
        'waktu' => waktu_sekarang(),
        'id_user' => app_user_id(),
        'nama_user' => app_user_name()
    ));

    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="' . $name . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $o = fopen('php://output', 'w');

    fwrite($o, "\xEF\xBB\xBF");
    fwrite($o, "sep=;\r\n");
    fputcsv($o, array(
        'No Transaksi',
        'Tanggal',
        'Waktu',
        'NIS',
        'Siswa',
        'Kelas',
        'Metode',
        'Total',
        'Petugas',
        'Status'
    ), ';');

    foreach ($rows as $r) {
        fputcsv($o, array(
            $r['no_transaksi'],
            $r['tanggal_transaksi'],
            $r['waktu_transaksi'],
            $r['nis'],
            $r['nama_siswa'],
            $r['nama_kelas'],
            $r['nama_metode_pembayaran'],
            (float) $r['total_pembayaran'],
            $r['nama_user'],
            $r['status_transaksi']
        ), ';');
    }

    fclose($o);
    exit;
}
}
