<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_data_kelas extends CI_Model
{
    public function result(){
        $search=trim((string)$this->input->post('search',true));$status=trim((string)$this->input->post('status',true));
        $this->db->select("k.*, (SELECT COUNT(*) FROM kelas_setting ks WHERE CAST(ks.id_kelas AS UNSIGNED)=k.id) jumlah_setting, (SELECT COUNT(*) FROM kelas_siswa x INNER JOIN kelas_setting y ON y.id=CAST(x.id_kelas_setting AS UNSIGNED) WHERE CAST(y.id_kelas AS UNSIGNED)=k.id AND x.status_aktif='1') jumlah_siswa")->from('kelas k');
        if($search!=='')$this->db->group_start()->like('k.nama_kelas',$search)->or_like('k.jurusan',$search)->group_end();if($status!=='')$this->db->where('k.status',$status);
        return $this->db->order_by('k.nama_kelas','ASC')->get()->result_array();
    }
    public function detail(){
        $id=(int)$this->input->post('id');
        $row=$this->db->where('id',$id)->get('kelas')->row_array();
        if(!$row)return model_response(false,'Kelas tidak ditemukan.');
        $setting=$this->db->query("SELECT ks.*,ta.periode,COUNT(kss.id) jumlah_siswa FROM kelas_setting ks LEFT JOIN master_tahun_ajaran ta ON ta.id=CAST(ks.id_periode AS UNSIGNED) LEFT JOIN kelas_siswa kss ON CAST(kss.id_kelas_setting AS UNSIGNED)=ks.id AND kss.status_aktif='1' WHERE CAST(ks.id_kelas AS UNSIGNED)=? GROUP BY ks.id ORDER BY ta.id DESC,ks.nama_kelas",array($id))->result_array();
        return array('result'=>'true','data'=>$row,'setting'=>$setting);
    }
    public function simpan(){
        $id=(int)$this->input->post('id');$nama=trim((string)$this->input->post('nama_kelas',true));$jurusan=trim((string)$this->input->post('jurusan',true));$status=trim((string)$this->input->post('status',true));
        if($nama==='')return model_response(false,'Nama kelas wajib diisi.');if($status==='')$status='REGULER';
        $before=$id?$this->db->where('id',$id)->get('kelas')->row_array():null;$data=array('nama_kelas'=>$nama,'jurusan'=>$jurusan,'status'=>$status);
        $this->db->trans_begin();if($id){$this->db->where('id',$id)->update('kelas',$data);}else{$data['id_jurusan']=0;$this->db->insert('kelas',$data);$id=$this->db->insert_id();}
        tagihan_log_activity($before?'Ubah Kelas':'Tambah Kelas','Master Data',$before?'Ubah':'Tambah','kelas',$id,$nama,'Pengelolaan master kelas',$before,$data);
        return tagihan_transaction_result('Data kelas berhasil disimpan.');
    }
    public function hapus(){
        $id=(int)$this->input->post('id');$row=$this->db->where('id',$id)->get('kelas')->row_array();if(!$row)return model_response(false,'Data tidak ditemukan.');
        if($this->db->where('id_kelas',(string)$id)->count_all_results('kelas_setting'))return model_response(false,'Kelas sudah digunakan pada pengaturan kelas dan tidak dapat dihapus.');
        $this->db->trans_begin();$this->db->where('id',$id)->delete('kelas');tagihan_log_activity('Hapus Kelas','Master Data','Batal','kelas',$id,$row['nama_kelas'],'Menghapus kelas yang belum digunakan',$row,null);return tagihan_transaction_result('Kelas berhasil dihapus.');
    }
}
