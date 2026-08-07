<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_tahun_ajaran extends MY_Model
{
    public function result(){
        $search=trim((string)$this->input->post('search',true));
        $this->db->select("ta.*, (SELECT COUNT(*) FROM kelas_setting ks WHERE CAST(ks.id_periode AS UNSIGNED)=ta.id) jumlah_kelas")->from('master_tahun_ajaran ta');
        if($search!=='')$this->db->like('ta.periode',$search);
        return $this->db->order_by('ta.id','DESC')->get()->result_array();
    }
    public function detail(){
        $id=(int)$this->input->post('id');
        $row=$this->db->where('id',$id)->get('master_tahun_ajaran')->row_array();
        if(!$row)return $this->response(false,'Tahun ajaran tidak ditemukan.');
        $kelas=$this->db->query("SELECT ks.*,COUNT(kss.id) jumlah_siswa FROM kelas_setting ks LEFT JOIN kelas_siswa kss ON CAST(kss.id_kelas_setting AS UNSIGNED)=ks.id AND kss.status_aktif='1' WHERE CAST(ks.id_periode AS UNSIGNED)=? GROUP BY ks.id ORDER BY ks.semester,ks.nama_kelas",array($id))->result_array();
        return array('result'=>'true','data'=>$row,'kelas'=>$kelas);
    }
    public function simpan(){
        $id=(int)$this->input->post('id');$periode=trim((string)$this->input->post('periode',true));$status=$this->input->post('status',true)==='Aktif'?'Aktif':'Tidak Aktif';
        if(!preg_match('/^(\d{4})\/(\d{4})$/',$periode,$m)||((int)$m[2]!==((int)$m[1]+1)))return $this->response(false,'Format tahun ajaran harus YYYY/YYYY dan tahun kedua satu tahun setelah tahun pertama.');
        $exists=$this->db->where('periode',$periode)->where('id !=',$id)->count_all_results('master_tahun_ajaran');
        if($exists)return $this->response(false,'Tahun ajaran tersebut sudah tersedia.');
        $before=$id?$this->db->where('id',$id)->get('master_tahun_ajaran')->row_array():null;
        $data=array('periode'=>$periode,'status'=>$status,'tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang(),'id_user'=>app_user_id());
        $this->db->trans_begin();
        if($status==='Aktif')$this->db->where('id !=',$id)->update('master_tahun_ajaran',array('status'=>'Tidak Aktif'));
        if($id){$this->db->where('id',$id)->update('master_tahun_ajaran',$data);}else{$this->db->insert('master_tahun_ajaran',$data);$id=$this->db->insert_id();}
        $this->log_activity($before?'Ubah Tahun Ajaran':'Tambah Tahun Ajaran','Master Data',$before?'Ubah':'Tambah','master_tahun_ajaran',$id,$periode,'Pengelolaan tahun ajaran',$before,$data);
        return $this->transaction_result('Tahun ajaran berhasil disimpan.');
    }
    public function aktifkan(){
        $id=(int)$this->input->post('id');$row=$this->db->where('id',$id)->get('master_tahun_ajaran')->row_array();if(!$row)return $this->response(false,'Tahun ajaran tidak ditemukan.');
        $this->db->trans_begin();$this->db->update('master_tahun_ajaran',array('status'=>'Tidak Aktif'));$this->db->where('id',$id)->update('master_tahun_ajaran',array('status'=>'Aktif','tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang(),'id_user'=>app_user_id()));
        $this->log_activity('Aktifkan Tahun Ajaran','Master Data','Ubah','master_tahun_ajaran',$id,$row['periode'],'Menetapkan tahun ajaran aktif',$row,array('status'=>'Aktif'));
        return $this->transaction_result('Tahun ajaran berhasil diaktifkan.');
    }
    public function hapus(){
        $id=(int)$this->input->post('id');$row=$this->db->where('id',$id)->get('master_tahun_ajaran')->row_array();if(!$row)return $this->response(false,'Data tidak ditemukan.');
        if($row['status']==='Aktif')return $this->response(false,'Tahun ajaran aktif tidak dapat dihapus.');
        if($this->db->where('id_periode',(string)$id)->count_all_results('kelas_setting')||$this->db->where('id_periode',$id)->count_all_results('tagihan_master'))return $this->response(false,'Tahun ajaran sudah digunakan dan tidak dapat dihapus.');
        $this->db->trans_begin();$this->db->where('id',$id)->delete('master_tahun_ajaran');$this->log_activity('Hapus Tahun Ajaran','Master Data','Batal','master_tahun_ajaran',$id,$row['periode'],'Menghapus tahun ajaran yang belum digunakan',$row,null);
        return $this->transaction_result('Tahun ajaran berhasil dihapus.');
    }
}
