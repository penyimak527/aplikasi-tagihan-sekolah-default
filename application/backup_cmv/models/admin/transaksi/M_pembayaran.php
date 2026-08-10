<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_pembayaran extends CI_Model
{
    public function metode_list(){return $this->db->where('status','Aktif')->order_by('urutan')->order_by('nama_metode')->get('tagihan_metode_pembayaran')->result_array();}
    public function cari_siswa(){
        $q=trim((string)$this->input->post('q',true));if(strlen($q)<2)return array();
        return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran,s.nama_ayah,s.telepon_ayah,s.nama_ibu,s.telepon_ibu,ks.id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.nama_lengkap LIKE ? OR s.nis LIKE ? OR s.nisn LIKE ? ORDER BY s.nama_lengkap LIMIT 20",array('%'.$q.'%','%'.$q.'%','%'.$q.'%'))->result_array();
    }
    public function siswa_by_id($id){
        $row=$this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.status_pendaftaran,s.nama_ayah,s.telepon_ayah,s.nama_ibu,s.telepon_ibu,ks.id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.id=? LIMIT 1",array((int)$id))->row_array();
        return $row?array('result'=>'true','siswa'=>$row):model_response(false,'Siswa tidak ditemukan.');
    }
    public function tagihan_siswa()
    {
        $idSiswa = (int) $this->input->post('id_siswa');
        $periode = trim((string) $this->input->post('periode', true));
        $tipe = trim((string) $this->input->post('tipe', true));
        $status = trim((string) $this->input->post('status', true));
        $search = trim((string) $this->input->post('search', true));

        $siswa = $this->db->query(
            "SELECT
                s.*,
                ks.id_kelas_setting,
                k.id_kelas,
                k.nama_kelas,
                k.id_periode,
                ta.periode
            FROM siswa s
            LEFT JOIN kelas_siswa ks
                ON CAST(ks.id_siswa AS UNSIGNED) = s.id
                AND ks.status_aktif = '1'
            LEFT JOIN kelas_setting k
                ON k.id = CAST(ks.id_kelas_setting AS UNSIGNED)
            LEFT JOIN master_tahun_ajaran ta
                ON ta.id = CAST(k.id_periode AS UNSIGNED)
            WHERE s.id = ?
            LIMIT 1",
            array($idSiswa)
        )->row_array();

        if (!$siswa) {
            return model_response(false, 'Siswa tidak ditemukan.');
        }

        $periodeAktif = $this->db
            ->select('periode')
            ->where('status', 'Aktif')
            ->limit(1)
            ->get('master_tahun_ajaran')
            ->row_array();

        $periodeList = $this->db
            ->select('periode')
            ->where('id_siswa', $idSiswa)
            ->where('status_tagihan', 'Aktif')
            ->where('sisa_tagihan >', 0)
            ->where_not_in(
                'status_pembayaran',
                array('Lunas', 'Dibebaskan', 'Dibatalkan')
            )
            ->group_by('periode')
            ->order_by('periode', 'DESC')
            ->get('tagihan_siswa')
            ->result_array();

        $this->db
            ->from('tagihan_siswa')
            ->where('id_siswa', $idSiswa)
            ->where('status_tagihan', 'Aktif')
            ->where('sisa_tagihan >', 0)
            ->where_not_in(
                'status_pembayaran',
                array('Lunas', 'Dibebaskan', 'Dibatalkan')
            );

        if ($periode !== '') {
            $this->db->where('periode', $periode);
        }

        if ($tipe !== '') {
            $this->db->where('tipe_tagihan', $tipe);
        }

        if ($status !== '') {
            $this->db->where('status_pembayaran', $status);
        }

        if ($search !== '') {
            $this->db->group_start()
                ->like('nama_tagihan', $search)
                ->or_like('no_tagihan', $search)
                ->group_end();
        }

        $rows = $this->db
            ->order_by('tahun', 'ASC')
            ->order_by('bulan', 'ASC')
            ->order_by('id', 'ASC')
            ->get()
            ->result_array();

        return array(
            'result' => 'true',
            'siswa' => $siswa,
            'periode_aktif' => $periodeAktif['periode'] ?? ($siswa['periode'] ?? ''),
            'tahun_ajaran' => array_values(
                array_filter(
                    array_map(
                        static function ($row) {
                            return $row['periode'] ?? '';
                        },
                        $periodeList
                    )
                )
            ),
            'tagihan' => $rows
        );
    }

    private function payment_status($paid,$total){if($paid<=0)return 'Belum Dibayar';if($paid+0.001>=$total)return 'Lunas';return 'Dibayar Sebagian';}
    public function simpan(){
        $token=trim((string)$this->input->post('token',true));$active=(string)$this->session->userdata('token_pembayaran_aktif');if($token===''||!hash_equals($active,$token))return model_response(false,'Token transaksi tidak valid atau transaksi sudah diproses. Muat ulang halaman.');
        $idSiswa=(int)$this->input->post('id_siswa');$idMetode=(int)$this->input->post('id_metode');$tanggal=trim((string)$this->input->post('tanggal',true));$uang=nilai_nominal($this->input->post('uang_diterima'));$referensi=trim((string)$this->input->post('referensi',true));$catatan=trim((string)$this->input->post('catatan',true));$items=json_decode((string)$this->input->post('items'),true);
        if(!$idSiswa||!$idMetode||!is_array($items)||!count($items))return model_response(false,'Siswa, metode, dan minimal satu tagihan wajib dipilih.');
        if(!preg_match('/^\d{2}-\d{2}-\d{4}$/',$tanggal))return model_response(false,'Format tanggal pembayaran harus dd-mm-yyyy.');
        $siswa=$this->db->query("SELECT s.*,ks.id_kelas_setting,k.id_kelas,k.nama_kelas,k.id_periode,ta.periode FROM siswa s LEFT JOIN kelas_siswa ks ON CAST(ks.id_siswa AS UNSIGNED)=s.id AND ks.status_aktif='1' LEFT JOIN kelas_setting k ON k.id=CAST(ks.id_kelas_setting AS UNSIGNED) LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(k.id_periode AS UNSIGNED) WHERE s.id=? LIMIT 1",array($idSiswa))->row_array();$metode=$this->db->where('id',$idMetode)->where('status','Aktif')->get('tagihan_metode_pembayaran')->row_array();if(!$siswa||!$metode)return model_response(false,'Data siswa atau metode pembayaran tidak ditemukan.');
        $normalized=array();$total=0;$seen=array();foreach($items as $item){$id=(int)($item['id_tagihan_siswa']??0);$bayar=nilai_nominal($item['nominal_bayar']??0);if(!$id||$bayar<=0||isset($seen[$id]))return model_response(false,'Keranjang mengandung data tidak valid atau tagihan ganda.');$seen[$id]=1;$row=$this->db->where('id',$id)->where('id_siswa',$idSiswa)->where('status_tagihan','Aktif')->get('tagihan_siswa')->row_array();if(!$row||in_array($row['status_pembayaran'],array('Lunas','Dibebaskan','Dibatalkan'),true))return model_response(false,'Salah satu tagihan tidak lagi dapat dibayar. Silakan muat ulang daftar.');if($bayar-(float)$row['sisa_tagihan']>0.001)return model_response(false,'Nominal bayar '.$row['nama_tagihan'].' melebihi sisa tagihan.');$normalized[]=array('row'=>$row,'bayar'=>$bayar);$total+=$bayar;}
        if($total<=0)return model_response(false,'Total pembayaran harus lebih dari nol.');if($metode['butuh_uang_diterima']==='Ya'&&$uang+0.001<$total)return model_response(false,'Uang diterima kurang dari total pembayaran.');if($metode['butuh_uang_diterima']!=='Ya')$uang=$total;$kembali=max(0,$uang-$total);
        $this->db->trans_begin();$no=tagihan_next_code('BYR','tagihan_pembayaran','no_transaksi');$header=array('no_transaksi'=>$no,'tanggal_transaksi'=>$tanggal,'waktu_transaksi'=>waktu_sekarang(),'id_siswa'=>$idSiswa,'nis'=>$siswa['nis'],'nisn'=>$siswa['nisn'],'nama_siswa'=>$siswa['nama_lengkap'],'id_kelas_setting'=>(int)($siswa['id_kelas_setting']??0),'id_kelas'=>(int)($siswa['id_kelas']??0),'nama_kelas'=>$siswa['nama_kelas']??'-','id_periode'=>(int)($siswa['id_periode']??0),'periode'=>$siswa['periode']??'-','total_tagihan_dipilih'=>$total,'total_potongan'=>0,'total_pembayaran'=>$total,'id_metode_pembayaran'=>$idMetode,'nama_metode_pembayaran'=>$metode['nama_metode'],'uang_diterima'=>$uang,'kembalian'=>$kembali,'referensi_pembayaran'=>$referensi,'status_transaksi'=>'Aktif','status_cetak'=>'Belum','jumlah_cetak'=>0,'status_kirim_whatsapp'=>'Belum','keterangan'=>$catatan,'id_user'=>app_user_id(),'nama_user'=>app_user_name());$this->db->insert('tagihan_pembayaran',$header);$idBayar=(int)$this->db->insert_id();
        foreach($normalized as $x){$r=$x['row'];$bayar=$x['bayar'];$paidBefore=(float)$r['nominal_dibayar'];$sisaBefore=(float)$r['sisa_tagihan'];$paidAfter=$paidBefore+$bayar;$sisaAfter=max(0,$sisaBefore-$bayar);$status=$this->payment_status($paidAfter,(float)$r['nominal_tagihan']);$this->db->insert('tagihan_pembayaran_detail',array('id_pembayaran'=>$idBayar,'no_transaksi'=>$no,'id_tagihan_siswa'=>$r['id'],'no_tagihan'=>$r['no_tagihan'],'id_tagihan_master'=>$r['id_tagihan_master'],'nama_tagihan'=>$r['nama_tagihan'],'tipe_tagihan'=>$r['tipe_tagihan'],'bulan'=>$r['bulan'],'nama_bulan'=>$r['nama_bulan'],'tahun'=>$r['tahun'],'nominal_tagihan'=>$r['nominal_tagihan'],'nominal_sudah_dibayar_sebelum'=>$paidBefore,'sisa_sebelum'=>$sisaBefore,'nominal_bayar'=>$bayar,'sisa_setelah'=>$sisaAfter,'status_setelah'=>$status,'status_detail'=>'Aktif','tanggal'=>$tanggal,'waktu'=>waktu_sekarang()));$this->db->where('id',$r['id'])->update('tagihan_siswa',array('nominal_dibayar'=>$paidAfter,'sisa_tagihan'=>$sisaAfter,'status_pembayaran'=>$status,'tanggal_update'=>tanggal_sekarang(),'waktu_update'=>waktu_sekarang()));}
        tagihan_log_activity('Terima Pembayaran','Transaksi','Tambah','tagihan_pembayaran',$idBayar,$no,'Pembayaran '.$siswa['nama_lengkap'].' sebesar '.rupiah($total),null,$header);
        if($this->db->trans_status()===FALSE){$this->db->trans_rollback();return model_response(false,'Penyimpanan pembayaran gagal. Seluruh perubahan dibatalkan.');}$this->db->trans_commit();$this->session->unset_userdata('token_pembayaran_aktif');return model_response(true,'Pembayaran berhasil disimpan.',array('id_pembayaran'=>$idBayar,'no_transaksi'=>$no,'total'=>$total,'uang_diterima'=>$uang,'kembalian'=>$kembali));
    }
    public function detail($id){
        $header=$this->db->where('id',$id)->get('tagihan_pembayaran')->row_array();if(!$header)return model_response(false,'Transaksi tidak ditemukan.');$detail=$this->db->where('id_pembayaran',$id)->order_by('id')->get('tagihan_pembayaran_detail')->result_array();$siswa=$this->db->where('id',$header['id_siswa'])->get('siswa')->row_array();$cancel=$this->db->where('id_pembayaran',$id)->get('tagihan_pembatalan_transaksi')->row_array();return array('result'=>'true','header'=>$header,'detail'=>$detail,'siswa'=>$siswa,'pembatalan'=>$cancel);
    }
    private function replace_template($tpl,$header,$siswa){$map=array('{nama_wali}'=>trim($siswa['nama_ayah']??'')?:trim($siswa['nama_ibu']??''),'{nama_siswa}'=>$header['nama_siswa'],'{kelas}'=>$header['nama_kelas'],'{tanggal}'=>$header['tanggal_transaksi'],'{no_transaksi}'=>$header['no_transaksi'],'{total_bayar}'=>rupiah($header['total_pembayaran']),'{total_tunggakan}'=>'','{nama_sekolah}'=>$this->config->item('nama_sekolah')?:'Sekolah','{nama_petugas}'=>$header['nama_user']);return strtr($tpl,$map);}
    public function siapkan_whatsapp(){
        $id=(int)$this->input->post('id');$hub=trim((string)$this->input->post('hubungan',true));$nomor=bersihkan_nomor_wa((string)$this->input->post('nomor',true));$nama=trim((string)$this->input->post('nama_penerima',true));$pesan=trim((string)$this->input->post('pesan',false));$data=$this->detail($id);if($data['result']!=='true')return $data;if($data['header']['status_transaksi']!=='Aktif')return model_response(false,'Bukti transaksi dibatalkan tidak dapat dikirim.');if($nomor==='')return model_response(false,'Nomor WhatsApp wajib diisi.');if($pesan===''){$tpl=$this->db->where('jenis_template','Bukti Pembayaran')->where('status','Aktif')->order_by("status_default='Ya'",'DESC',false)->get('tagihan_template_whatsapp')->row_array();$pesan=$this->replace_template($tpl?$tpl['isi_template']:'Yth. Bapak/Ibu wali {nama_siswa}, pembayaran sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.',$data['header'],$data['siswa']?:array());}
        $this->db->trans_begin();$this->db->insert('tagihan_riwayat_whatsapp',array('jenis_kirim'=>'Bukti Pembayaran','id_referensi'=>$id,'nomor_referensi'=>$data['header']['no_transaksi'],'id_siswa'=>$data['header']['id_siswa'],'nama_siswa'=>$data['header']['nama_siswa'],'nama_penerima'=>$nama,'hubungan_penerima'=>$hub,'nomor_whatsapp'=>$nomor,'isi_pesan'=>$pesan,'metode_kirim'=>'Tautan','status_kirim'=>'Disiapkan','tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang(),'id_user'=>app_user_id(),'nama_user'=>app_user_name()));$this->db->where('id',$id)->update('tagihan_pembayaran',array('status_kirim_whatsapp'=>'Disiapkan'));tagihan_log_activity('Kirim Ulang Bukti WhatsApp','Transaksi','Kirim','tagihan_pembayaran',$id,$data['header']['no_transaksi'],'Bukti disiapkan ke '.$nomor);if($this->db->trans_status()===FALSE){$this->db->trans_rollback();return model_response(false,'Gagal menyiapkan WhatsApp.');}$this->db->trans_commit();return model_response(true,'Tautan WhatsApp berhasil disiapkan.',array('url'=>'https://wa.me/'.$nomor.'?text='.rawurlencode($pesan),'pesan'=>$pesan));
    }
    public function format_kartu(){return $this->db->where('jenis_format','Kartu Pembayaran')->where('status','Aktif')->order_by("status_default='Ya'",'DESC',false)->get('tagihan_pengaturan_cetak')->row_array();}
    public function catat_cetak_kartu(){
        $id=(int)$this->input->post('id');$baris=(int)$this->input->post('nomor_baris');$x=trim((string)$this->input->post('posisi_x',true));$y=trim((string)$this->input->post('posisi_y',true));$data=$this->detail($id);if($data['result']!=='true')return $data;if($data['header']['status_transaksi']!=='Aktif')return model_response(false,'Transaksi dibatalkan tidak dapat dicetak ke kartu.');$format=$this->format_kartu();$existing=$this->db->where('id_pembayaran',$id)->where('nomor_baris',$baris)->count_all_results('tagihan_cetak_kartu');$this->db->trans_begin();$this->db->insert('tagihan_cetak_kartu',array('id_pembayaran'=>$id,'no_transaksi'=>$data['header']['no_transaksi'],'id_siswa'=>$data['header']['id_siswa'],'nama_siswa'=>$data['header']['nama_siswa'],'id_format_cetak'=>$format['id']??0,'nama_format'=>$format['nama_format']??'Kartu Pembayaran','nomor_baris'=>$baris,'posisi_x'=>$x,'posisi_y'=>$y,'status_cetak'=>'Berhasil','jumlah_cetak'=>1,'keterangan'=>$existing?'Cetak ulang pada baris yang pernah digunakan.':'Cetak kartu pembayaran.','tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang(),'id_user'=>app_user_id(),'nama_user'=>app_user_name()));tagihan_log_activity('Cetak Kartu Pembayaran','Transaksi','Cetak','tagihan_pembayaran',$id,$data['header']['no_transaksi'],'Baris '.$baris.($existing?' (cetak ulang)':''));return tagihan_transaction_result('Cetak kartu berhasil dicatat.'.($existing?' Peringatan: baris ini pernah digunakan.':''));
    }
}
