<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_laporan extends CI_Model
{
    private $allowed=array('harian','bulanan','tahunan','per_kelas','per_jenis','tunggakan','pembatalan');
    public function periode_list(){return $this->db->order_by('id','DESC')->get('master_tahun_ajaran')->result_array();}
    public function kelas_list(){return $this->db->select('id,nama_kelas,id_periode')->order_by('id_periode','DESC')->order_by('nama_kelas')->get('kelas_setting')->result_array();}
    public function kelas_by_periode()
    {
        $periode = (int) $this->input->post('periode', true);
        if (!$periode) {
            return array();
        }

        return $this->db
            ->select('id,nama_kelas,id_periode')
            ->where('id_periode', $periode)
            ->order_by('nama_kelas', 'ASC')
            ->get('kelas_setting')
            ->result_array();
    }
    public function jenis_list(){return $this->db->where('status','Aktif')->order_by('nama_jenis')->get('tagihan_jenis')->result_array();}
    public function metode_list(){return $this->db->where('status','Aktif')->order_by('urutan')->get('tagihan_metode_pembayaran')->result_array();}
    private function input($key,$default=''){return $this->input->post_get($key,true)!==null?$this->input->post_get($key,true):$default;}
    public function report($type){if(!in_array($type,$this->allowed,true))return array('result'=>'false','message'=>'Jenis laporan tidak valid.');$method='report_'.$type;return $this->$method();}
    private function report_harian(){
        $tanggal=trim((string)$this->input('tanggal',date('d-m-Y')));$kelas=(int)$this->input('kelas');$metode=(int)$this->input('metode');$petugas=trim((string)$this->input('petugas'));$status=trim((string)$this->input('status','Aktif'));$this->db->from('tagihan_pembayaran p')->where('p.tanggal_transaksi',$tanggal);if($kelas)$this->db->where('p.id_kelas_setting',$kelas);if($metode)$this->db->where('p.id_metode_pembayaran',$metode);if($petugas!=='')$this->db->like('p.nama_user',$petugas);if($status!=='Semua')$this->db->where('p.status_transaksi',$status);$rows=$this->db->order_by('p.waktu_transaksi')->get()->result_array();$total=0;foreach($rows as $r)if($r['status_transaksi']==='Aktif')$total+=(float)$r['total_pembayaran'];return array('result'=>'true','columns'=>array('waktu_transaksi'=>'Waktu','no_transaksi'=>'No Transaksi','nama_siswa'=>'Siswa','nama_kelas'=>'Kelas','nama_metode_pembayaran'=>'Metode','nama_user'=>'Petugas','total_pembayaran'=>'Total','status_transaksi'=>'Status'),'money'=>array('total_pembayaran'),'rows'=>$rows,'summary'=>array('Jumlah Transaksi'=>count($rows),'Total Pembayaran'=>$total),'chart'=>array());
    }
    private function report_bulanan(){
        $periode=(int)$this->input('periode');$bulan=(int)$this->input('bulan',date('n'));$tahun=(int)$this->input('tahun',date('Y'));$kelas=(int)$this->input('kelas');$jenis=(int)$this->input('jenis');$metode=(int)$this->input('metode');
        $whereTs=array("ts.status_tagihan='Aktif'","ts.bulan=?","ts.tahun=?");$params=array($bulan,$tahun);if($periode){$whereTs[]='ts.id_periode=?';$params[]=$periode;}if($kelas){$whereTs[]='ts.id_kelas_setting=?';$params[]=$kelas;}if($jenis){$whereTs[]='ts.id_jenis_tagihan=?';$params[]=$jenis;}$summary=$this->db->query('SELECT COALESCE(SUM(ts.nominal_tagihan),0) target,COALESCE(SUM(ts.nominal_dibayar),0) pembayaran,COALESCE(SUM(ts.sisa_tagihan),0) sisa FROM tagihan_siswa ts WHERE '.implode(' AND ',$whereTs),$params)->row_array();$summary['realisasi']=$summary['target']>0?round($summary['pembayaran']/$summary['target']*100,2):0;
        $sql="SELECT p.tanggal_transaksi tanggal,ts.nama_jenis_tagihan jenis_tagihan,COUNT(DISTINCT p.id) jumlah_transaksi,SUM(d.nominal_bayar) total_pembayaran FROM tagihan_pembayaran p JOIN tagihan_pembayaran_detail d ON d.id_pembayaran=p.id AND d.status_detail='Aktif' JOIN tagihan_siswa ts ON ts.id=d.id_tagihan_siswa WHERE p.status_transaksi='Aktif' AND MONTH(STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'))=? AND YEAR(STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'))=?";$p=array($bulan,$tahun);if($periode){$sql.=' AND ts.id_periode=?';$p[]=$periode;}if($kelas){$sql.=' AND ts.id_kelas_setting=?';$p[]=$kelas;}if($jenis){$sql.=' AND ts.id_jenis_tagihan=?';$p[]=$jenis;}if($metode){$sql.=' AND p.id_metode_pembayaran=?';$p[]=$metode;}$sql.=" GROUP BY p.tanggal_transaksi,ts.nama_jenis_tagihan ORDER BY STR_TO_DATE(p.tanggal_transaksi,'%d-%m-%Y'),ts.nama_jenis_tagihan";$rows=$this->db->query($sql,$p)->result_array();return array('result'=>'true','columns'=>array('tanggal'=>'Tanggal','jenis_tagihan'=>'Jenis Tagihan','jumlah_transaksi'=>'Jumlah Transaksi','total_pembayaran'=>'Total Pembayaran'),'money'=>array('total_pembayaran'),'rows'=>$rows,'summary'=>array('Target Tagihan'=>(float)$summary['target'],'Pembayaran Masuk'=>(float)$summary['pembayaran'],'Sisa'=>(float)$summary['sisa'],'Realisasi (%)'=>$summary['realisasi']),'chart'=>array());
    }
    private function report_tahunan(){
        $periode=(int)$this->input('periode');$kelas=(int)$this->input('kelas');$jenis=(int)$this->input('jenis');$period=$this->db->where('id',$periode)->get('master_tahun_ajaran')->row_array();$start=$period?intval(substr($period['periode'],0,4)):date('Y');$months=bulan_tahun_ajaran($start);$rows=array();foreach($months as $m){$this->db->select('COALESCE(SUM(nominal_tagihan),0) target,COALESCE(SUM(nominal_dibayar),0) pembayaran,COALESCE(SUM(sisa_tagihan),0) sisa')->from('tagihan_siswa')->where('bulan',$m['bulan'])->where('tahun',$m['tahun'])->where('status_tagihan','Aktif');if($periode)$this->db->where('id_periode',$periode);if($kelas)$this->db->where('id_kelas_setting',$kelas);if($jenis)$this->db->where('id_jenis_tagihan',$jenis);$x=$this->db->get()->row_array();$rows[]=array('bulan'=>$m['nama'].' '.$m['tahun'],'target'=>(float)$x['target'],'pembayaran'=>(float)$x['pembayaran'],'sisa'=>(float)$x['sisa'],'realisasi'=>$x['target']>0?round($x['pembayaran']/$x['target']*100,2):0);}$tot=array('target'=>0,'pembayaran'=>0,'sisa'=>0);foreach($rows as $r){$tot['target']+=$r['target'];$tot['pembayaran']+=$r['pembayaran'];$tot['sisa']+=$r['sisa'];}$tot['realisasi']=$tot['target']>0?round($tot['pembayaran']/$tot['target']*100,2):0;return array('result'=>'true','columns'=>array('bulan'=>'Bulan','target'=>'Target','pembayaran'=>'Pembayaran','sisa'=>'Sisa','realisasi'=>'Realisasi (%)'),'money'=>array('target','pembayaran','sisa'),'rows'=>$rows,'summary'=>array('Total Target'=>$tot['target'],'Total Pembayaran'=>$tot['pembayaran'],'Total Sisa'=>$tot['sisa'],'Realisasi (%)'=>$tot['realisasi']),'chart'=>array('labels'=>array_column($rows,'bulan'),'series'=>array(array('name'=>'Target','data'=>array_column($rows,'target')),array('name'=>'Pembayaran','data'=>array_column($rows,'pembayaran')))));
    }
    private function report_per_kelas()
    {
        $periode = (int) $this->input('periode');
        $sampai = (int) $this->input('sampai_bulan');
        $jenis = (int) $this->input('jenis');
        $urutanSampai = $sampai ? ($sampai >= 7 ? $sampai - 6 : $sampai + 6) : 0;

        if ($periode) {
            $periodeSql = (int) $periode;
            $penempatanSql = "
                (
                    SELECT DISTINCT
                        CAST(ks.id_siswa AS UNSIGNED) AS id_siswa,
                        CAST(ks.id_kelas_setting AS UNSIGNED) AS id_kelas_setting
                    FROM kelas_siswa ks
                    INNER JOIN kelas_setting ka
                        ON ka.id = CAST(ks.id_kelas_setting AS UNSIGNED)
                    WHERE ks.status_aktif = '1'
                      AND CAST(ka.id_periode AS UNSIGNED) = {$periodeSql}

                    UNION

                    SELECT
                        r.id_siswa,
                        CASE
                            WHEN r.id_periode_tujuan = {$periodeSql}
                             AND COALESCE(r.id_kelas_setting_tujuan, 0) > 0
                            THEN r.id_kelas_setting_tujuan
                            WHEN r.id_periode_asal = {$periodeSql}
                             AND COALESCE(r.id_kelas_setting_asal, 0) > 0
                            THEN r.id_kelas_setting_asal
                            ELSE 0
                        END AS id_kelas_setting
                    FROM tagihan_riwayat_kelas_siswa r
                    WHERE r.status_riwayat = 'Aktif'
                      AND (
                            (r.id_periode_tujuan = {$periodeSql} AND COALESCE(r.id_kelas_setting_tujuan, 0) > 0)
                            OR
                            (r.id_periode_asal = {$periodeSql} AND COALESCE(r.id_kelas_setting_asal, 0) > 0)
                      )
                      AND r.id = (
                            SELECT MAX(r2.id)
                            FROM tagihan_riwayat_kelas_siswa r2
                            WHERE r2.id_siswa = r.id_siswa
                              AND r2.status_riwayat = 'Aktif'
                              AND (
                                    (r2.id_periode_tujuan = {$periodeSql} AND COALESCE(r2.id_kelas_setting_tujuan, 0) > 0)
                                    OR
                                    (r2.id_periode_asal = {$periodeSql} AND COALESCE(r2.id_kelas_setting_asal, 0) > 0)
                              )
                      )
                      AND NOT EXISTS (
                            SELECT 1
                            FROM kelas_siswa ks2
                            INNER JOIN kelas_setting k2
                                ON k2.id = CAST(ks2.id_kelas_setting AS UNSIGNED)
                            WHERE CAST(ks2.id_siswa AS UNSIGNED) = r.id_siswa
                              AND ks2.status_aktif = '1'
                              AND CAST(k2.id_periode AS UNSIGNED) = {$periodeSql}
                      )
                ) pk
            ";

            $joinTagihan = "ts.id_siswa = pk.id_siswa
                AND ts.id_periode = {$periodeSql}
                AND ts.status_tagihan = 'Aktif'";

            if ($urutanSampai) {
                $joinTagihan .= " AND (CASE WHEN ts.bulan >= 7 THEN ts.bulan - 6 ELSE ts.bulan + 6 END) <= " . (int) $urutanSampai;
            }
            if ($jenis) {
                $joinTagihan .= " AND ts.id_jenis_tagihan = " . (int) $jenis;
            }

            $sql = "SELECT
                        k.id AS id_kelas_setting,
                        k.nama_kelas,
                        COUNT(DISTINCT pk.id_siswa) AS jumlah_siswa,
                        COALESCE(SUM(ts.nominal_tagihan), 0) AS target,
                        COALESCE(SUM(ts.nominal_dibayar), 0) AS pembayaran,
                        COALESCE(SUM(
                            CASE
                                WHEN ts.dianggap_tunggakan = 'Ya'
                                 AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
                                THEN ts.sisa_tagihan
                                ELSE 0
                            END
                        ), 0) AS tunggakan
                    FROM kelas_setting k
                    LEFT JOIN {$penempatanSql} ON pk.id_kelas_setting = k.id
                    LEFT JOIN tagihan_siswa ts ON {$joinTagihan}
                    WHERE CAST(k.id_periode AS UNSIGNED) = ?
                    GROUP BY k.id, k.nama_kelas
                    ORDER BY k.nama_kelas";

            $rows = $this->db->query($sql, array($periode))->result_array();
        } else {
            $sql = "SELECT
                        ts.id_kelas_setting,
                        ts.nama_kelas,
                        COUNT(DISTINCT ts.id_siswa) AS jumlah_siswa,
                        SUM(ts.nominal_tagihan) AS target,
                        SUM(ts.nominal_dibayar) AS pembayaran,
                        SUM(CASE
                            WHEN ts.dianggap_tunggakan = 'Ya'
                             AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')
                            THEN ts.sisa_tagihan ELSE 0 END) AS tunggakan
                    FROM tagihan_siswa ts
                    WHERE ts.status_tagihan = 'Aktif'";
            $params = array();
            if ($urutanSampai) {
                $sql .= ' AND (CASE WHEN ts.bulan >= 7 THEN ts.bulan - 6 ELSE ts.bulan + 6 END) <= ?';
                $params[] = $urutanSampai;
            }
            if ($jenis) {
                $sql .= ' AND ts.id_jenis_tagihan = ?';
                $params[] = $jenis;
            }
            $sql .= ' GROUP BY ts.id_kelas_setting, ts.nama_kelas ORDER BY ts.nama_kelas';
            $rows = $this->db->query($sql, $params)->result_array();
        }

        $target = 0;
        $pay = 0;
        $arrears = 0;
        foreach ($rows as &$row) {
            $row['target'] = (float) $row['target'];
            $row['pembayaran'] = (float) $row['pembayaran'];
            $row['tunggakan'] = (float) $row['tunggakan'];
            $row['realisasi'] = $row['target'] > 0
                ? round($row['pembayaran'] / $row['target'] * 100, 2)
                : 0;
            $target += $row['target'];
            $pay += $row['pembayaran'];
            $arrears += $row['tunggakan'];
        }
        unset($row);

        return array(
            'result' => 'true',
            'columns' => array(
                'nama_kelas' => 'Kelas',
                'jumlah_siswa' => 'Jumlah Siswa',
                'target' => 'Target',
                'pembayaran' => 'Pembayaran',
                'tunggakan' => 'Tunggakan',
                'realisasi' => 'Realisasi (%)'
            ),
            'money' => array('target', 'pembayaran', 'tunggakan'),
            'rows' => $rows,
            'summary' => array(
                'Total Target' => $target,
                'Total Pembayaran' => $pay,
                'Total Tunggakan' => $arrears
            ),
            'chart' => array()
        );
    }
    private function report_per_jenis(){
        $periode=(int)$this->input('periode');$kelas=(int)$this->input('kelas');$bulan=(int)$this->input('bulan');$sql="SELECT ts.id_jenis_tagihan,ts.nama_jenis_tagihan jenis,ts.tipe_tagihan tipe,ts.dianggap_tunggakan wajib,COUNT(DISTINCT ts.id_siswa) jumlah_siswa,SUM(ts.nominal_tagihan) total_tagihan,SUM(ts.nominal_dibayar) dibayar,SUM(ts.sisa_tagihan) sisa FROM tagihan_siswa ts WHERE ts.status_tagihan='Aktif'";$p=array();if($periode){$sql.=' AND ts.id_periode=?';$p[]=$periode;}if($kelas){$sql.=' AND ts.id_kelas_setting=?';$p[]=$kelas;}if($bulan){$sql.=' AND ts.bulan=?';$p[]=$bulan;}$sql.=' GROUP BY ts.id_jenis_tagihan,ts.nama_jenis_tagihan,ts.tipe_tagihan,ts.dianggap_tunggakan ORDER BY ts.nama_jenis_tagihan';$rows=$this->db->query($sql,$p)->result_array();$target=$pay=$sisa=0;foreach($rows as &$r){$r['realisasi']=$r['total_tagihan']>0?round($r['dibayar']/$r['total_tagihan']*100,2):0;$target+=(float)$r['total_tagihan'];$pay+=(float)$r['dibayar'];$sisa+=(float)$r['sisa'];}return array('result'=>'true','columns'=>array('jenis'=>'Jenis','tipe'=>'Tipe','wajib'=>'Dihitung Tunggakan','jumlah_siswa'=>'Jumlah Siswa','total_tagihan'=>'Total Tagihan','dibayar'=>'Dibayar','sisa'=>'Sisa','realisasi'=>'Realisasi (%)'),'money'=>array('total_tagihan','dibayar','sisa'),'rows'=>$rows,'summary'=>array('Total Tagihan'=>$target,'Total Dibayar'=>$pay,'Total Sisa'=>$sisa),'chart'=>array());
    }
    private function report_tunggakan()
    {
        $periode = (int) $this->input('periode');
        $kelas = (int) $this->input('kelas');
        $jenis = (int) $this->input('jenis');
        $sampai = (int) $this->input('sampai_bulan');
        $statusSiswa = trim((string) $this->input('status_siswa', 'Aktif'));
        $urutanSampai = $sampai ? ($sampai >= 7 ? $sampai - 6 : $sampai + 6) : 0;

        $sql = "SELECT
                    ts.id_siswa,
                    ts.nis,
                    ts.nama_siswa,
                    COALESCE(cur.nama_kelas, '-') AS nama_kelas,
                    ts.periode AS tahun_asal,
                    COUNT(ts.id) AS jumlah_tagihan,
                    SUM(ts.sisa_tagihan) AS total_tunggakan,
                    MAX(COALESCE(NULLIF(s.telepon_ayah, ''), s.telepon_ibu, '')) AS no_wali
                FROM tagihan_siswa ts
                JOIN siswa s ON s.id = ts.id_siswa
                LEFT JOIN kelas_siswa ks_cur
                    ON ks_cur.id = (
                        SELECT MAX(ks2.id)
                        FROM kelas_siswa ks2
                        WHERE CAST(ks2.id_siswa AS UNSIGNED) = ts.id_siswa
                          AND ks2.status_aktif = '1'
                    )
                LEFT JOIN kelas_setting cur
                    ON cur.id = CAST(ks_cur.id_kelas_setting AS UNSIGNED)
                WHERE ts.dianggap_tunggakan = 'Ya'
                  AND ts.status_tagihan = 'Aktif'
                  AND ts.sisa_tagihan > 0
                  AND ts.status_pembayaran NOT IN ('Lunas','Dibebaskan','Dibatalkan')";

        $params = array();
        if ($periode) {
            $sql .= ' AND ts.id_periode = ?';
            $params[] = $periode;
        }
        if ($kelas) {
            $sql .= ' AND cur.id = ?';
            $params[] = $kelas;
        }
        if ($jenis) {
            $sql .= ' AND ts.id_jenis_tagihan = ?';
            $params[] = $jenis;
        }
        if ($urutanSampai) {
            $sql .= ' AND (CASE WHEN ts.bulan >= 7 THEN ts.bulan - 6 ELSE ts.bulan + 6 END) <= ?';
            $params[] = $urutanSampai;
        }
        if ($statusSiswa !== 'Semua') {
            $sql .= ' AND s.status_pendaftaran = ?';
            $params[] = $statusSiswa;
        }

        $sql .= ' GROUP BY ts.id_siswa, ts.nis, ts.nama_siswa, cur.nama_kelas, ts.periode
                  ORDER BY total_tunggakan DESC, ts.nama_siswa';

        $rows = $this->db->query($sql, $params)->result_array();
        $total = 0;
        foreach ($rows as $row) {
            $total += (float) $row['total_tunggakan'];
        }

        return array(
            'result' => 'true',
            'columns' => array(
                'nama_siswa' => 'Siswa',
                'nis' => 'NIS',
                'nama_kelas' => 'Kelas Saat Ini',
                'tahun_asal' => 'Tahun Asal',
                'jumlah_tagihan' => 'Jumlah Tagihan',
                'total_tunggakan' => 'Total Tunggakan',
                'no_wali' => 'No Wali'
            ),
            'money' => array('total_tunggakan'),
            'rows' => $rows,
            'summary' => array(
                'Jumlah Siswa' => count($rows),
                'Total Tunggakan' => $total
            ),
            'chart' => array()
        );
    }
    private function report_pembatalan()
    {
        $q = trim((string) $this->input('q'));
        $awal = trim((string) $this->input('awal'));
        $akhir = trim((string) $this->input('akhir'));
        $petugas = trim((string) $this->input('petugas'));

        $this->db
            ->select('c.no_transaksi no_asli,c.nama_siswa,c.total_pembayaran nominal,c.nama_user_transaksi pembuat,c.nama_user_pembatalan pembatal,CONCAT(c.tanggal_pembatalan," ",c.waktu_pembatalan) waktu,c.alasan_pembatalan alasan')
            ->from('tagihan_pembatalan_transaksi c');

        if ($q !== '') {
            $this->db
                ->group_start()
                ->like('c.no_transaksi', $q)
                ->or_like('c.nama_siswa', $q)
                ->group_end();
        }

        if ($awal !== '') {
            $tanggalAwal = DateTime::createFromFormat('d-m-Y', $awal);
            if ($tanggalAwal) {
                $this->db->where(
                    "STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y') >=",
                    $tanggalAwal->format('Y-m-d')
                );
            }
        }

        if ($akhir !== '') {
            $tanggalAkhir = DateTime::createFromFormat('d-m-Y', $akhir);
            if ($tanggalAkhir) {
                $this->db->where(
                    "STR_TO_DATE(c.tanggal_pembatalan,'%d-%m-%Y') <=",
                    $tanggalAkhir->format('Y-m-d')
                );
            }
        }

        if ($petugas !== '') {
            $this->db->like('c.nama_user_pembatalan', $petugas);
        }

        $rows = $this->db
            ->order_by('c.id', 'DESC')
            ->get()
            ->result_array();

        $total = 0;
        foreach ($rows as $row) {
            $total += (float) $row['nominal'];
        }

        return array(
            'result' => 'true',
            'columns' => array(
                'no_asli' => 'No Asli',
                'nama_siswa' => 'Siswa',
                'nominal' => 'Nominal',
                'pembuat' => 'Pembuat',
                'pembatal' => 'Pembatal',
                'waktu' => 'Waktu',
                'alasan' => 'Alasan'
            ),
            'money' => array('nominal'),
            'rows' => $rows,
            'summary' => array(
                'Jumlah Pembatalan' => count($rows),
                'Total Dibatalkan' => $total
            ),
            'chart' => array()
        );
    }

    public function print_filter($type)
    {
        $bulan = array(
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        );
        $result = array();
        $periode = (int) $this->input('periode');
        $kelas = (int) $this->input('kelas');
        $jenis = (int) $this->input('jenis');
        $metode = (int) $this->input('metode');

        if ($periode) {
            $row = $this->db->select('periode')->where('id', $periode)->get('master_tahun_ajaran')->row_array();
            if ($row) $result['Tahun Ajaran'] = $row['periode'];
        }
        if ($kelas) {
            $row = $this->db->select('nama_kelas')->where('id', $kelas)->get('kelas_setting')->row_array();
            if ($row) $result['Kelas'] = $row['nama_kelas'];
        }
        if ($jenis) {
            $row = $this->db->select('nama_jenis')->where('id', $jenis)->get('tagihan_jenis')->row_array();
            if ($row) $result['Jenis Tagihan'] = $row['nama_jenis'];
        }
        if ($metode) {
            $row = $this->db->select('nama_metode')->where('id', $metode)->get('tagihan_metode_pembayaran')->row_array();
            if ($row) $result['Metode'] = $row['nama_metode'];
        }

        if ($type === 'harian') {
            $result['Tanggal'] = trim((string) $this->input('tanggal', date('d-m-Y')));
            $petugas = trim((string) $this->input('petugas'));
            if ($petugas !== '') $result['Petugas'] = $petugas;
            $result['Status'] = trim((string) $this->input('status', 'Aktif'));
        } elseif ($type === 'bulanan') {
            $nomorBulan = (int) $this->input('bulan', date('n'));
            $tahun = (int) $this->input('tahun', date('Y'));
            $result['Bulan'] = (isset($bulan[$nomorBulan]) ? $bulan[$nomorBulan] : '-') . ' ' . $tahun;
        } elseif ($type === 'per_kelas') {
            $sampai = (int) $this->input('sampai_bulan');
            if ($sampai) $result['Sampai Bulan'] = isset($bulan[$sampai]) ? $bulan[$sampai] : '-';
        } elseif ($type === 'per_jenis') {
            $nomorBulan = (int) $this->input('bulan');
            if ($nomorBulan) $result['Periode Bulan'] = isset($bulan[$nomorBulan]) ? $bulan[$nomorBulan] : '-';
        } elseif ($type === 'tunggakan') {
            $sampai = (int) $this->input('sampai_bulan');
            if ($sampai) $result['Sampai Bulan'] = isset($bulan[$sampai]) ? $bulan[$sampai] : '-';
            $result['Status Siswa'] = trim((string) $this->input('status_siswa', 'Aktif'));
        } elseif ($type === 'pembatalan') {
            $q = trim((string) $this->input('q'));
            $awal = trim((string) $this->input('awal'));
            $akhir = trim((string) $this->input('akhir'));
            $petugas = trim((string) $this->input('petugas'));
            if ($q !== '') $result['Pencarian'] = $q;
            if ($awal !== '') $result['Tanggal Awal'] = $awal;
            if ($akhir !== '') $result['Tanggal Akhir'] = $akhir;
            if ($petugas !== '') $result['Petugas Pembatal'] = $petugas;
        }

        return $result;
    }

    public function export_csv($type){$result=$this->report($type);if(($result['result']??'false')!=='true')show_error($result['message']??'Laporan gagal.');$name='laporan_'.$type.'_'.date('Ymd_His').'.csv';$this->db->insert('tagihan_log_export',array('jenis_laporan'=>$type,'format_export'=>'Excel CSV','filter_json'=>json_encode($this->input->get()),'nama_file'=>$name,'jumlah_data'=>count($result['rows']),'tanggal'=>tanggal_sekarang(),'waktu'=>waktu_sekarang(),'id_user'=>app_user_id(),'nama_user'=>app_user_name()));header('Content-Type: text/csv; charset=UTF-8');header('Content-Disposition: attachment; filename="'.$name.'"');echo "\xEF\xBB\xBF";echo "sep=;\r\n";$o=fopen('php://output','w');fputcsv($o,array(strtoupper(str_replace('_',' ',$type))),';');fputcsv($o,array('Tanggal Ekspor',date('d-m-Y H:i:s'),'Petugas',app_user_name()),';');fputcsv($o,array_values($result['columns']),';');foreach($result['rows'] as $r){$line=array();foreach(array_keys($result['columns']) as $k)$line[]=in_array($k,$result['money'],true)?(float)($r[$k]??0):($r[$k]??'');fputcsv($o,$line,';');}fputcsv($o,array(),';');foreach($result['summary'] as $k=>$v)fputcsv($o,array($k,$v),';');fclose($o);exit;}
}
