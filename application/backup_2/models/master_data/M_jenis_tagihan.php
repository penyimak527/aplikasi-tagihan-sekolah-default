<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_jenis_tagihan extends MY_Model
{
    public function result(){
        $search=trim((string)$this->input->post('search',true));$tipe=trim((string)$this->input->post('tipe',true));$status=trim((string)$this->input->post('status',true));$this->db->from('tagihan_jenis');
        if($search!=='')$this->db->group_start()->like('nama_jenis',$search)->or_like('kode_jenis',$search)->group_end();if($tipe!=='')$this->db->where('tipe_default',$tipe);if($status!=='')$this->db->where('status',$status);
        return $this->db->order_by('id','DESC')->get()->result_array();
    }
    public function simpan(){
        $id=(int)$this->input->post('id');$nama=trim((string)$this->input->post('nama_jenis',true));$kode=strtoupper(trim((string)$this->input->post('kode_jenis',true)));$tipe=$this->input->post('tipe_default',true);$tunggakan=$this->input->post('dianggap_tunggakan',true)==='Tidak'?'Tidak':'Ya';$status=$this->input->post('status',true)==='Nonaktif'?'Nonaktif':'Aktif';$ket=trim((string)$this->input->post('keterangan',true));
        if($nama===''||!in_array($tipe,array('Bulanan','Langsung','Tahunan'),true))return $this->response(false,'Nama dan tipe tagihan wajib diisi.');if($kode==='')$kode='JNS-'.strtoupper(substr(preg_replace('/[^A-Za-z0-9]/','',$nama),0,12));
        $exists=$this->db->where('nama_jenis',$nama)->where('status','Aktif')->where('id !=',$id)->count_all_results('tagihan_jenis');if($exists)return $this->response(false,'Nama jenis tagihan aktif sudah digunakan.');
        $before=$id?$this->db->where('id',$id)->get('tagihan_jenis')->row_array():null;$data=array_merge(array('kode_jenis'=>$kode,'nama_jenis'=>$nama,'tipe_default'=>$tipe,'dianggap_tunggakan'=>$tunggakan,'status'=>$status,'keterangan'=>$ket),$this->audit_fields());
        $this->db->trans_begin();if($id){$this->db->where('id',$id)->update('tagihan_jenis',$data);}else{$this->db->insert('tagihan_jenis',$data);$id=$this->db->insert_id();}$this->log_activity($before?'Ubah Jenis Tagihan':'Tambah Jenis Tagihan','Master Data',$before?'Ubah':'Tambah','tagihan_jenis',$id,$kode,'Pengelolaan jenis tagihan',$before,$data);return $this->transaction_result('Jenis tagihan berhasil disimpan.');
    }
    public function ubah_status(){
        $id=(int)$this->input->post('id');$row=$this->db->where('id',$id)->get('tagihan_jenis')->row_array();if(!$row)return $this->response(false,'Data tidak ditemukan.');$status=$row['status']==='Aktif'?'Nonaktif':'Aktif';
        $this->db->trans_begin();$this->db->where('id',$id)->update('tagihan_jenis',array('status'=>$status,'tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang()));$this->log_activity('Ubah Status Jenis Tagihan','Master Data','Ubah','tagihan_jenis',$id,$row['kode_jenis'],'Status menjadi '.$status,$row,array('status'=>$status));return $this->transaction_result('Status jenis tagihan berhasil diubah.');
    }
}
