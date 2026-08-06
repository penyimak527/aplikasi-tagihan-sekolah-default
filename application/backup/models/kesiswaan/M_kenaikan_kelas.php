<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_kenaikan_kelas extends MY_Model
{
    public function kelas_list(){return $this->db->select('ks.*,ta.periode')->from('kelas_setting ks')->join('master_tahun_ajaran ta','ta.id=CAST(ks.id_periode AS UNSIGNED)','left')->order_by('ta.id','DESC')->order_by('ks.nama_kelas')->get()->result_array();}
    public function siswa(){
        $id=(int)$this->input->post('id_kelas_setting');return $this->db->query("SELECT s.id,s.nis,s.nisn,s.nama_lengkap,s.jk,s.status_pendaftaran FROM kelas_siswa ks JOIN siswa s ON s.id=CAST(ks.id_siswa AS UNSIGNED) WHERE CAST(ks.id_kelas_setting AS UNSIGNED)=? AND ks.status_aktif='1' AND s.status_pendaftaran='Aktif' ORDER BY s.nama_lengkap",array($id))->result_array();
    }
    public function preview($jenis){
        $asalId=(int)$this->input->post('id_kelas_asal');
        $tujuanId=(int)$this->input->post('id_kelas_tujuan');
        $ids=$this->input->post('id_siswa');
        if(!is_array($ids))$ids=array();
        $asal=$this->db->where('id',$asalId)->get('kelas_setting')->row_array();
        $tujuan=$this->db->where('id',$tujuanId)->get('kelas_setting')->row_array();
        if(!$asal||!$tujuan||!$ids)return $this->response(false,'Kelas asal, kelas tujuan, dan siswa wajib dipilih.');
        if((int)$asal['id_periode']===(int)$tujuan['id_periode'])return $this->response(false,'Tahun ajaran tujuan harus berbeda dari tahun ajaran asal.');
        $valid=0;$skip=0;
        foreach($ids as $sid){
            $sid=(int)$sid;
            $exists=$this->db->query("SELECT COUNT(*) total FROM kelas_siswa x JOIN kelas_setting k ON k.id=CAST(x.id_kelas_setting AS UNSIGNED) WHERE CAST(x.id_siswa AS UNSIGNED)=? AND x.status_aktif='1' AND CAST(k.id_periode AS UNSIGNED)=? AND k.semester=?",array($sid,(int)$tujuan['id_periode'],$tujuan['semester']))->row()->total;
            if($exists)$skip++;else$valid++;
        }
        return $this->response(true,'Preview siap.',array('jenis'=>$jenis,'asal'=>$asal,'tujuan'=>$tujuan,'dipilih'=>count($ids),'valid'=>$valid,'dilewati'=>$skip));
    }
    public function proses($jenis){
        $asalId=(int)$this->input->post('id_kelas_asal');$tujuanId=(int)$this->input->post('id_kelas_tujuan');$ids=$this->input->post('id_siswa');$alasan=trim((string)$this->input->post('alasan',true));if(!is_array($ids))$ids=array();$asal=$this->db->where('id',$asalId)->get('kelas_setting')->row_array();$tujuan=$this->db->where('id',$tujuanId)->get('kelas_setting')->row_array();if(!$asal||!$tujuan||!$ids)return $this->response(false,'Kelas asal, kelas tujuan, dan siswa wajib dipilih.');if((int)$asal['id_periode']===(int)$tujuan['id_periode'])return $this->response(false,'Tahun ajaran tujuan harus berbeda dari tahun ajaran asal.');
        $pa=$this->db->where('id',(int)$asal['id_periode'])->get('master_tahun_ajaran')->row_array();$pt=$this->db->where('id',(int)$tujuan['id_periode'])->get('master_tahun_ajaran')->row_array();$this->db->trans_begin();$success=0;$skip=0;
        foreach($ids as $sid){$sid=(int)$sid;$s=$this->db->where('id',$sid)->get('siswa')->row_array();if(!$s){$skip++;continue;}$exists=$this->db->query("SELECT COUNT(*) total FROM kelas_siswa x JOIN kelas_setting k ON k.id=CAST(x.id_kelas_setting AS UNSIGNED) WHERE CAST(x.id_siswa AS UNSIGNED)=? AND x.status_aktif='1' AND CAST(k.id_periode AS UNSIGNED)=? AND k.semester=?",array($sid,(int)$tujuan['id_periode'],$tujuan['semester']))->row()->total;if($exists){$skip++;continue;}
            $this->db->insert('kelas_siswa',array('id_kelas_setting'=>(string)$tujuanId,'id_siswa'=>(string)$sid,'nama_siswa'=>$s['nama_lengkap'],'nisn'=>$s['nisn'],'jenis_kelamin'=>$s['jk'],'status_aktif'=>'1'));
            $this->db->insert('tagihan_riwayat_kelas_siswa',array('id_siswa'=>$sid,'nis'=>$s['nis'],'nisn'=>$s['nisn'],'nama_siswa'=>$s['nama_lengkap'],'id_kelas_setting_asal'=>$asalId,'id_kelas_asal'=>(int)$asal['id_kelas'],'nama_kelas_asal'=>$asal['nama_kelas'],'id_periode_asal'=>(int)$asal['id_periode'],'periode_asal'=>$pa?$pa['periode']:'','semester_asal'=>$asal['semester'],'id_kelas_setting_tujuan'=>$tujuanId,'id_kelas_tujuan'=>(int)$tujuan['id_kelas'],'nama_kelas_tujuan'=>$tujuan['nama_kelas'],'id_periode_tujuan'=>(int)$tujuan['id_periode'],'periode_tujuan'=>$pt?$pt['periode']:'','semester_tujuan'=>$tujuan['semester'],'jenis_proses'=>$jenis,'status_sebelum'=>'Aktif','status_setelah'=>$jenis,'alasan'=>$alasan,'tanggal_proses'=>tanggal_sekarang(),'waktu_proses'=>waktu_sekarang(),'id_user'=>app_user_id(),'nama_user'=>app_user_name(),'status_riwayat'=>'Aktif'));$success++;}
        $this->log_activity($jenis,'Kesiswaan','Tambah','kelas_siswa',$tujuanId,$tujuan['nama_kelas'],$jenis.' '.$success.' siswa; dilewati '.$skip,null,array('asal'=>$asalId,'tujuan'=>$tujuanId,'siswa'=>$ids));return $this->transaction_result($success.' siswa berhasil diproses'.($skip?' dan '.$skip.' dilewati.':'.'));
    }
}
