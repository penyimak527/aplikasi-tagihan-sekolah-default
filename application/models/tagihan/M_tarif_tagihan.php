<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_tarif_tagihan extends MY_Model
{
    public function tagihan_list(){return $this->db->where_in('status',array('Aktif','Draft'))->order_by('id','DESC')->get('tagihan_master')->result_array();}
    public function result(){
        $id=(int)$this->input->post('id_tagihan');$m=$this->db->where('id',$id)->get('tagihan_master')->row_array();if(!$m)return array('result'=>'false','message'=>'Tagihan tidak ditemukan.');$classes=$this->db->query("SELECT tk.*,COUNT(DISTINCT ts.id_siswa) jumlah_siswa,COALESCE(SUM(ts.nominal_dibayar),0) total_dibayar FROM tagihan_target_kelas tk LEFT JOIN tagihan_siswa ts ON ts.id_tagihan_master=tk.id_tagihan_master AND ts.id_kelas_setting=tk.id_kelas_setting WHERE tk.id_tagihan_master=? GROUP BY tk.id",array($id))->result_array();$special=$this->db->query("SELECT k.*,MAX(ts.nominal_dibayar) nominal_dibayar,MAX(ts.nama_kelas) nama_kelas FROM tagihan_keringanan_siswa k LEFT JOIN tagihan_siswa ts ON ts.id_tagihan_master=k.id_tagihan_master AND ts.id_siswa=k.id_siswa WHERE k.id_tagihan_master=? AND k.jenis_keringanan='Tarif Khusus' AND k.status='Aktif' GROUP BY k.id ORDER BY k.nama_siswa",array($id))->result_array();return array('result'=>'true','master'=>$m,'classes'=>$classes,'special'=>$special);
    }
    public function simpan_kelas(){
        $id=(int)$this->input->post('id_tagihan');$tarif=$this->input->post('tarif');if(!is_array($tarif))$tarif=array();$m=$this->db->where('id',$id)->get('tagihan_master')->row_array();if(!$m||!$tarif)return $this->response(false,'Data tarif tidak lengkap.');$this->db->trans_begin();foreach($tarif as $idTarget=>$nominal){$idTarget=(int)$idTarget;$nominal=nilai_nominal($nominal);if($nominal<0){$this->db->trans_rollback();return $this->response(false,'Tarif tidak boleh negatif.');}$target=$this->db->where('id',$idTarget)->where('id_tagihan_master',$id)->get('tagihan_target_kelas')->row_array();if(!$target)continue;$maxPaid=(float)$this->db->select_max('nominal_dibayar','max')->where('id_tagihan_master',$id)->where('id_kelas_setting',$target['id_kelas_setting'])->get('tagihan_siswa')->row()->max;if($nominal<$maxPaid){$this->db->trans_rollback();return $this->response(false,'Tarif kelas '.$target['nama_kelas'].' tidak boleh lebih kecil dari pembayaran yang sudah masuk.');}$before=$target;$this->db->where('id',$idTarget)->update('tagihan_target_kelas',array('nominal_kelas'=>$nominal,'tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang(),'id_user'=>app_user_id(),'nama_user'=>app_user_name()));$rows=$this->db->where('id_tagihan_master',$id)->where('id_kelas_setting',$target['id_kelas_setting'])->get('tagihan_siswa')->result_array();foreach($rows as $row){$special=$this->db->where('id_tagihan_master',$id)->where('id_siswa',$row['id_siswa'])->where('jenis_keringanan','Tarif Khusus')->where('status','Aktif')->order_by('id','DESC')->get('tagihan_keringanan_siswa')->row_array();if($special)continue;$newSisa=max(0,$nominal-(float)$row['nominal_dibayar']);$status=$newSisa<=0?'Lunas':((float)$row['nominal_dibayar']>0?'Dibayar Sebagian':'Belum Dibayar');$this->db->where('id',$row['id'])->update('tagihan_siswa',array('nominal_awal'=>$nominal,'nominal_tagihan'=>$nominal,'sisa_tagihan'=>$newSisa,'status_pembayaran'=>$status,'tanggal_update'=>tanggal_sekarang(),'waktu_update'=>waktu_sekarang()));}$this->log_activity('Ubah Tarif Kelas','Tagihan','Ubah','tagihan_target_kelas',$idTarget,$m['kode_tagihan'],$target['nama_kelas'].' menjadi '.rupiah($nominal),$before,array('nominal_kelas'=>$nominal));}
        return $this->transaction_result('Tarif per kelas berhasil disimpan.');
    }
    public function cari_siswa(){
        $id=(int)$this->input->post('id_tagihan');$q=trim((string)$this->input->post('q',true));$like='%'.$q.'%';return $this->db->query("SELECT DISTINCT id_siswa,nis,nisn,nama_siswa,id_kelas_setting,nama_kelas,MAX(nominal_awal) nominal_normal,MAX(nominal_dibayar) nominal_dibayar FROM tagihan_siswa WHERE id_tagihan_master=? AND (nama_siswa LIKE ? OR nis LIKE ? OR nisn LIKE ?) GROUP BY id_siswa,nis,nisn,nama_siswa,id_kelas_setting,nama_kelas ORDER BY nama_siswa LIMIT 30",array($id,$like,$like,$like))->result_array();
    }
    public function simpan_siswa(){
        $id=(int)$this->input->post('id_tagihan');$sid=(int)$this->input->post('id_siswa');$nominal=nilai_nominal($this->input->post('nominal_khusus'));$alasan=trim((string)$this->input->post('alasan',true));$m=$this->db->where('id',$id)->get('tagihan_master')->row_array();$s=$this->db->where('id_tagihan_master',$id)->where('id_siswa',$sid)->get('tagihan_siswa')->row_array();if(!$m||!$s||$alasan===''||$nominal<0)return $this->response(false,'Siswa, nominal khusus, dan alasan wajib diisi.');$maxPaid=(float)$this->db->select_max('nominal_dibayar','max')->where('id_tagihan_master',$id)->where('id_siswa',$sid)->get('tagihan_siswa')->row()->max;if($nominal<$maxPaid)return $this->response(false,'Tarif khusus tidak boleh lebih kecil dari pembayaran yang sudah masuk.');
        $this->db->trans_begin();$this->db->where('id_tagihan_master',$id)->where('id_siswa',$sid)->where('jenis_keringanan','Tarif Khusus')->where('status','Aktif')->update('tagihan_keringanan_siswa',array('status'=>'Dibatalkan','tanggal_batal'=>tanggal_sekarang(),'waktu_batal'=>waktu_sekarang(),'id_user_batal'=>app_user_id(),'nama_user_batal'=>app_user_name(),'alasan_batal'=>'Diganti tarif khusus baru'));
        $this->db->insert('tagihan_keringanan_siswa',array('id_tagihan_master'=>$id,'id_siswa'=>$sid,'nis'=>$s['nis'],'nisn'=>$s['nisn'],'nama_siswa'=>$s['nama_siswa'],'bulan'=>0,'tahun'=>0,'jenis_keringanan'=>'Tarif Khusus','nominal_awal'=>$s['nominal_awal'],'nilai_keringanan'=>max(0,(float)$s['nominal_awal']-$nominal),'nominal_setelah_keringanan'=>$nominal,'alasan'=>$alasan,'status'=>'Aktif','tanggal_mulai'=>tanggal_sekarang(),'tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang(),'id_user'=>app_user_id(),'nama_user'=>app_user_name()));
        $target=$this->db->where('id_tagihan_master',$id)->where('id_siswa',$sid)->get('tagihan_target_siswa')->row_array();$targetData=array('id_tagihan_master'=>$id,'id_siswa'=>$sid,'nis'=>$s['nis'],'nisn'=>$s['nisn'],'nama_siswa'=>$s['nama_siswa'],'id_kelas_setting'=>$s['id_kelas_setting'],'id_kelas'=>$s['id_kelas'],'nama_kelas'=>$s['nama_kelas'],'nominal_target'=>$nominal,'status'=>'Aktif','tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang(),'id_user'=>app_user_id(),'nama_user'=>app_user_name());if($target)$this->db->where('id',$target['id'])->update('tagihan_target_siswa',$targetData);else$this->db->insert('tagihan_target_siswa',$targetData);
        $rows=$this->db->where('id_tagihan_master',$id)->where('id_siswa',$sid)->get('tagihan_siswa')->result_array();foreach($rows as $row){$sisa=max(0,$nominal-(float)$row['nominal_dibayar']);$status=$sisa<=0?'Lunas':((float)$row['nominal_dibayar']>0?'Dibayar Sebagian':'Belum Dibayar');$this->db->where('id',$row['id'])->update('tagihan_siswa',array('jenis_keringanan'=>'Tarif Khusus','nilai_keringanan'=>max(0,(float)$row['nominal_awal']-$nominal),'nominal_tagihan'=>$nominal,'sisa_tagihan'=>$sisa,'status_pembayaran'=>$status,'tanggal_update'=>tanggal_sekarang(),'waktu_update'=>waktu_sekarang()));}
        $this->log_activity('Tarif Khusus Siswa','Tagihan','Ubah','tagihan_siswa',$sid,$m['kode_tagihan'],$s['nama_siswa'].' menjadi '.rupiah($nominal).' - '.$alasan,$s,array('nominal_khusus'=>$nominal));return $this->transaction_result('Tarif khusus siswa berhasil disimpan.');
    }

    public function kembalikan_normal()
    {
        $id = (int) $this->input->post('id_tagihan');
        $idSiswa = (int) $this->input->post('id_siswa');
        $alasan = trim((string) $this->input->post('alasan', true));

        $master = $this->db->where('id', $id)->get('tagihan_master')->row_array();
        $rows = $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $idSiswa)
            ->get('tagihan_siswa')
            ->result_array();

        if (!$master || !$rows) {
            return $this->response(false, 'Tagihan atau siswa tidak ditemukan.');
        }
        if ($alasan === '') {
            $alasan = 'Dikembalikan ke tarif normal';
        }

        $this->db->trans_begin();

        $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $idSiswa)
            ->where('jenis_keringanan', 'Tarif Khusus')
            ->where('status', 'Aktif')
            ->update('tagihan_keringanan_siswa', array(
                'status' => 'Dibatalkan',
                'tanggal_batal' => tanggal_sekarang(),
                'waktu_batal' => waktu_sekarang(),
                'id_user_batal' => app_user_id(),
                'nama_user_batal' => app_user_name(),
                'alasan_batal' => $alasan
            ));

        foreach ($rows as $row) {
            $normal = (float) $row['nominal_awal'];
            $dibayar = (float) $row['nominal_dibayar'];
            if ($normal < $dibayar) {
                $this->db->trans_rollback();
                return $this->response(false, 'Tarif normal tidak boleh lebih kecil dari pembayaran yang sudah masuk.');
            }

            $sisa = max(0, $normal - $dibayar);
            $status = $sisa <= 0 ? 'Lunas' : ($dibayar > 0 ? 'Dibayar Sebagian' : 'Belum Dibayar');

            $this->db->where('id', $row['id'])->update('tagihan_siswa', array(
                'jenis_keringanan' => NULL,
                'nilai_keringanan' => 0,
                'nominal_tagihan' => $normal,
                'sisa_tagihan' => $sisa,
                'status_pembayaran' => $status,
                'tanggal_update' => tanggal_sekarang(),
                'waktu_update' => waktu_sekarang()
            ));
        }

        $first = $rows[0];
        $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $idSiswa)
            ->update('tagihan_target_siswa', array(
                'nominal_target' => (float) $first['nominal_awal'],
                'tanggal' => tanggal_sekarang(),
                'waktu' => waktu_sekarang(),
                'id_user' => app_user_id(),
                'nama_user' => app_user_name()
            ));

        $this->log_activity(
            'Kembalikan Tarif Normal',
            'Tagihan',
            'Ubah',
            'tagihan_siswa',
            $idSiswa,
            $master['kode_tagihan'],
            $first['nama_siswa'] . ' dikembalikan ke tarif normal - ' . $alasan,
            array('jenis_keringanan' => 'Tarif Khusus'),
            array('jenis_keringanan' => NULL, 'nominal_tagihan' => (float) $first['nominal_awal'])
        );

        return $this->transaction_result('Tarif siswa berhasil dikembalikan ke tarif normal.');
    }

    public function riwayat_siswa()
    {
        $id = (int) $this->input->post('id_tagihan');
        $idSiswa = (int) $this->input->post('id_siswa');

        return $this->db
            ->where('id_tagihan_master', $id)
            ->where('id_siswa', $idSiswa)
            ->where('jenis_keringanan', 'Tarif Khusus')
            ->order_by('id', 'DESC')
            ->get('tagihan_keringanan_siswa')
            ->result_array();
    }

}
