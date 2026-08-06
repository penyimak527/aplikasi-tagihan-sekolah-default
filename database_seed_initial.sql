-- Data awal aplikasi tagihan sekolah.
-- Jalankan setelah aplikasi_tagihan_sekolah_default.sql.
SET NAMES utf8mb4;

INSERT IGNORE INTO tagihan_jenis
(kode_jenis,nama_jenis,tipe_default,dianggap_tunggakan,status,keterangan,tanggal,waktu,id_user,nama_user) VALUES
('SPP','SPP','Bulanan','Ya','Aktif','Tagihan rutin bulanan',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'),
('BUKU','Buku Paket','Langsung','Ya','Aktif','Tagihan buku paket',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'),
('DAFTAR_ULANG','Daftar Ulang','Tahunan','Ya','Aktif','Tagihan tahunan daftar ulang',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'),
('KEGIATAN_PILIHAN','Kegiatan Pilihan','Langsung','Tidak','Aktif','Tidak dihitung sebagai tunggakan',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem');

INSERT IGNORE INTO tagihan_metode_pembayaran
(kode_metode,nama_metode,jenis_metode,butuh_uang_diterima,status,urutan,keterangan,tanggal,waktu,id_user,nama_user) VALUES
('TUNAI','Tunai','Tunai','Ya','Aktif',1,'Menampilkan uang diterima dan kembalian',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'),
('TRANSFER','Transfer Bank','Transfer','Tidak','Aktif',2,'Gunakan kolom referensi pembayaran',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'),
('QRIS','QRIS','QRIS','Tidak','Aktif',3,'Pembayaran non-tunai',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem');

INSERT INTO tagihan_template_whatsapp
(jenis_template,nama_template,isi_template,status_default,status,tanggal,waktu,id_user,nama_user)
SELECT 'Bukti Pembayaran','Template Utama Bukti','Yth. Bapak/Ibu {nama_wali}, pembayaran {nama_siswa} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.','Ya','Aktif',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'
WHERE NOT EXISTS (SELECT 1 FROM tagihan_template_whatsapp WHERE jenis_template='Bukti Pembayaran' AND nama_template='Template Utama Bukti');

INSERT INTO tagihan_template_whatsapp
(jenis_template,nama_template,isi_template,status_default,status,tanggal,waktu,id_user,nama_user)
SELECT 'Surat Tunggakan','Template Utama Tunggakan','Yth. Bapak/Ibu {nama_wali}, berikut kami sampaikan pemberitahuan tunggakan {nama_siswa} sebesar {total_tunggakan}. Mohon dapat ditindaklanjuti. Terima kasih.','Ya','Aktif',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'
WHERE NOT EXISTS (SELECT 1 FROM tagihan_template_whatsapp WHERE jenis_template='Surat Tunggakan' AND nama_template='Template Utama Tunggakan');

INSERT INTO tagihan_pengaturan_cetak
(jenis_format,nama_format,status_default,ukuran_kertas,orientasi,margin_atas,margin_bawah,margin_kiri,margin_kanan,tampilkan_logo,nama_sekolah,judul_bukti,tampilkan_terbilang,tampilkan_uang_diterima,tampilkan_kembalian,tampilkan_sisa_tagihan,status,tanggal,waktu,id_user,nama_user)
SELECT 'Bukti Pembayaran','Thermal 80 mm','Ya','80mm','Portrait','5','5','5','5','Ya','Sekolah','BUKTI PEMBAYARAN','Ya','Ya','Ya','Ya','Aktif',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'
WHERE NOT EXISTS (SELECT 1 FROM tagihan_pengaturan_cetak WHERE jenis_format='Bukti Pembayaran' AND nama_format='Thermal 80 mm');

INSERT INTO tagihan_pengaturan_cetak
(jenis_format,nama_format,status_default,ukuran_kertas,orientasi,lebar_kertas,tinggi_kertas,nama_sekolah,pengaturan_json,status,tanggal,waktu,id_user,nama_user)
SELECT 'Kartu Pembayaran','Kartu Pembayaran Sekolah','Ya','Custom','Portrait','210','148','Sekolah','{"jumlah_baris":12,"jarak_baris":8,"posisi_x":10,"posisi_y":10,"lebar_tanggal":25,"lebar_jenis":70,"lebar_nominal":35,"lebar_petugas":20,"kolom":["Tanggal","Jenis/Bulan","Nominal","Petugas"]}','Aktif',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'
WHERE NOT EXISTS (SELECT 1 FROM tagihan_pengaturan_cetak WHERE jenis_format='Kartu Pembayaran' AND nama_format='Kartu Pembayaran Sekolah');

INSERT IGNORE INTO tagihan_pengaturan_umum
(kode_pengaturan,nama_pengaturan,nilai_pengaturan,keterangan,status,tanggal,waktu,id_user,nama_user) VALUES
('MODE_WHATSAPP','Mode Pengiriman WhatsApp','Tautan','Pilihan awal menggunakan tautan wa.me','Aktif',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem'),
('FORMAT_TANGGAL','Format Tanggal','d-m-Y','Tanggal database disimpan dd-mm-YYYY','Aktif',DATE_FORMAT(NOW(),'%d-%m-%Y'),TIME_FORMAT(NOW(),'%H:%i:%s'),0,'Sistem');
