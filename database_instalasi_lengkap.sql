/*
 Navicat Premium Data Transfer

 Source Server         : localku
 Source Server Type    : MySQL
 Source Server Version : 100432
 Source Host           : localhost:3306
 Source Schema         : aplikasi_tagihan_sekolah_default

 Target Server Type    : MySQL
 Target Server Version : 100432
 File Encoding         : 65001

 Date: 05/08/2026 21:32:26
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for jabatan
-- ----------------------------
DROP TABLE IF EXISTS `jabatan`;
CREATE TABLE `jabatan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kelas
-- ----------------------------
DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_jurusan` int NULL DEFAULT 0,
  `jurusan` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kelas_setting
-- ----------------------------
DROP TABLE IF EXISTS `kelas_setting`;
CREATE TABLE `kelas_setting`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_guru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wali_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_periode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `semester` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for kelas_siswa
-- ----------------------------
DROP TABLE IF EXISTS `kelas_siswa`;
CREATE TABLE `kelas_siswa`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_kelas_setting` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nisn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jenis_kelamin` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_aktif` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for master_tahun_ajaran
-- ----------------------------
DROP TABLE IF EXISTS `master_tahun_ajaran`;
CREATE TABLE `master_tahun_ajaran`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `periode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 92 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pegawai
-- ----------------------------
DROP TABLE IF EXISTS `pegawai`;
CREATE TABLE `pegawai`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_daftar_guru` int NOT NULL,
  `nama_pegawai` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jk` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_tlp` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_pendaftaran` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pegawai_jabatan
-- ----------------------------
DROP TABLE IF EXISTS `pegawai_jabatan`;
CREATE TABLE `pegawai_jabatan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_jabatan` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_pegawai` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_jabatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pegawai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 122 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for siswa
-- ----------------------------
DROP TABLE IF EXISTS `siswa`;
CREATE TABLE `siswa`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_daftar_siswa` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `nisn` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jk` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tempat_lahir` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_lahir` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_awal_masuk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `foto_siswa` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status_pendaftaran` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `id_periode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_ayah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pekerjaan_ayah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telepon_ayah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_ayah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `usia_ayah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_ibu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `pekerjaan_ibu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `telepon_ibu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_ibu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `usia_ibu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `kode_absen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password_pkl` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 47 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_cetak_kartu
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_cetak_kartu`;
CREATE TABLE `tagihan_cetak_kartu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pembayaran` int NULL DEFAULT 0,
  `no_transaksi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_siswa` int NULL DEFAULT 0,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_format_cetak` int NULL DEFAULT 0,
  `nama_format` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor_baris` int NULL DEFAULT 0,
  `posisi_x` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `posisi_y` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_cetak` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Berhasil',
  `jumlah_cetak` int NULL DEFAULT 1,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_cetak_kartu_pembayaran`(`id_pembayaran`) USING BTREE,
  INDEX `idx_tagihan_cetak_kartu_siswa`(`id_siswa`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_import_siswa
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_import_siswa`;
CREATE TABLE `tagihan_import_siswa`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_import` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `lokasi_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_periode` int NULL DEFAULT 0,
  `periode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_kelas_setting` int NULL DEFAULT 0,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah_data` int NULL DEFAULT 0,
  `jumlah_berhasil` int NULL DEFAULT 0,
  `jumlah_gagal` int NULL DEFAULT 0,
  `status_import` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Diproses' COMMENT 'Diproses/Selesai/Gagal',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_import_kode`(`kode_import`) USING BTREE,
  INDEX `idx_tagihan_import_periode`(`id_periode`) USING BTREE,
  INDEX `idx_tagihan_import_kelas`(`id_kelas_setting`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_import_siswa_detail
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_import_siswa_detail`;
CREATE TABLE `tagihan_import_siswa_detail`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_import` int NULL DEFAULT 0,
  `nomor_baris` int NULL DEFAULT 0,
  `nis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nisn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jenis_kelamin` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_kelas_excel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_siswa_hasil` int NULL DEFAULT 0,
  `status_data` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Berhasil/Gagal/Dilewati',
  `pesan_validasi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `data_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_import_detail_header`(`id_import`) USING BTREE,
  INDEX `idx_tagihan_import_detail_status`(`status_data`) USING BTREE,
  INDEX `idx_tagihan_import_detail_nis`(`nis`) USING BTREE,
  INDEX `idx_tagihan_import_detail_nisn`(`nisn`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_jenis
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_jenis`;
CREATE TABLE `tagihan_jenis`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_jenis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_jenis` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipe_default` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Bulanan/Langsung/Tahunan',
  `dianggap_tunggakan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_jenis_kode`(`kode_jenis`) USING BTREE,
  INDEX `idx_tagihan_jenis_status`(`status`) USING BTREE,
  INDEX `idx_tagihan_jenis_tipe`(`tipe_default`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_keringanan_siswa
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_keringanan_siswa`;
CREATE TABLE `tagihan_keringanan_siswa`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tagihan_master` int NULL DEFAULT 0,
  `id_siswa` int NULL DEFAULT 0,
  `nis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nisn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bulan` int NULL DEFAULT 0 COMMENT '0 berarti berlaku umum',
  `tahun` int NULL DEFAULT 0 COMMENT '0 berarti berlaku umum',
  `jenis_keringanan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Tarif Khusus/Potongan Nominal/Potongan Persen/Pembebasan Penuh',
  `nominal_awal` decimal(15, 2) NULL DEFAULT 0.00,
  `nilai_keringanan` decimal(15, 2) NULL DEFAULT 0.00,
  `nominal_setelah_keringanan` decimal(15, 2) NULL DEFAULT 0.00,
  `alasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal_mulai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_selesai` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_batal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_batal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user_batal` int NULL DEFAULT 0,
  `nama_user_batal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alasan_batal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_keringanan_master`(`id_tagihan_master`) USING BTREE,
  INDEX `idx_tagihan_keringanan_siswa`(`id_siswa`) USING BTREE,
  INDEX `idx_tagihan_keringanan_periode`(`bulan`, `tahun`) USING BTREE,
  INDEX `idx_tagihan_keringanan_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_log_aktivitas
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_log_aktivitas`;
CREATE TABLE `tagihan_log_aktivitas`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `jenis_aktivitas` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `modul` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `aksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Tambah/Ubah/Batal/Cetak/Kirim/Import/Export',
  `nama_tabel` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_referensi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nomor_referensi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `data_sebelum` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `data_sesudah` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `ip_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_log_modul`(`modul`) USING BTREE,
  INDEX `idx_tagihan_log_aksi`(`aksi`) USING BTREE,
  INDEX `idx_tagihan_log_referensi`(`id_referensi`) USING BTREE,
  INDEX `idx_tagihan_log_tanggal`(`tanggal`) USING BTREE,
  INDEX `idx_tagihan_log_user`(`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_log_export
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_log_export`;
CREATE TABLE `tagihan_log_export`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis_laporan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `format_export` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Excel',
  `filter_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `nama_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jumlah_data` int NULL DEFAULT 0,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_log_export_jenis`(`jenis_laporan`) USING BTREE,
  INDEX `idx_tagihan_log_export_user`(`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_master
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_master`;
CREATE TABLE `tagihan_master`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_tagihan` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_jenis_tagihan` int NULL DEFAULT 0,
  `nama_jenis_tagihan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_tagihan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipe_tagihan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Bulanan/Langsung/Tahunan',
  `id_periode` int NULL DEFAULT 0,
  `periode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `semester` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nominal_default` decimal(15, 2) NULL DEFAULT 0.00,
  `model_tarif_bulanan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Sama' COMMENT 'Sama/Berbeda',
  `bulan_mulai` int NULL DEFAULT 0,
  `tahun_mulai` int NULL DEFAULT 0,
  `bulan_selesai` int NULL DEFAULT 0,
  `tahun_selesai` int NULL DEFAULT 0,
  `bulan_penagihan` int NULL DEFAULT 0,
  `tahun_penagihan` int NULL DEFAULT 0,
  `tanggal_jatuh_tempo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `target_tagihan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Kelas' COMMENT 'Semua/Kelas/Siswa',
  `dianggap_tunggakan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya',
  `status_generate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Belum' COMMENT 'Belum/Sebagian/Selesai',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user_update` int NULL DEFAULT 0,
  `nama_user_update` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_master_kode`(`kode_tagihan`) USING BTREE,
  INDEX `idx_tagihan_master_periode`(`id_periode`) USING BTREE,
  INDEX `idx_tagihan_master_jenis`(`id_jenis_tagihan`) USING BTREE,
  INDEX `idx_tagihan_master_tipe`(`tipe_tagihan`) USING BTREE,
  INDEX `idx_tagihan_master_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_metode_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_metode_pembayaran`;
CREATE TABLE `tagihan_metode_pembayaran`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_metode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_metode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jenis_metode` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Tunai/Transfer/QRIS/Lainnya',
  `butuh_uang_diterima` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Tidak',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `urutan` int NULL DEFAULT 0,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_metode_kode`(`kode_metode`) USING BTREE,
  INDEX `idx_tagihan_metode_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_pembatalan_transaksi
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_pembatalan_transaksi`;
CREATE TABLE `tagihan_pembatalan_transaksi`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pembayaran` int NULL DEFAULT 0,
  `no_transaksi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_siswa` int NULL DEFAULT 0,
  `nis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_pembayaran` decimal(15, 2) NULL DEFAULT 0.00,
  `alasan_pembatalan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal_transaksi_asli` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_transaksi_asli` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user_transaksi` int NULL DEFAULT 0,
  `nama_user_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_pembatalan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_pembatalan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user_pembatalan` int NULL DEFAULT 0,
  `nama_user_pembatalan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `ip_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_pembatalan_pembayaran`(`id_pembayaran`) USING BTREE,
  INDEX `idx_tagihan_pembatalan_no`(`no_transaksi`) USING BTREE,
  INDEX `idx_tagihan_pembatalan_siswa`(`id_siswa`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_pembayaran`;
CREATE TABLE `tagihan_pembayaran`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_transaksi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_siswa` int NULL DEFAULT 0,
  `nis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nisn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_kelas_setting` int NULL DEFAULT 0,
  `id_kelas` int NULL DEFAULT 0,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_periode` int NULL DEFAULT 0,
  `periode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `total_tagihan_dipilih` decimal(15, 2) NULL DEFAULT 0.00,
  `total_potongan` decimal(15, 2) NULL DEFAULT 0.00,
  `total_pembayaran` decimal(15, 2) NULL DEFAULT 0.00,
  `id_metode_pembayaran` int NULL DEFAULT 0,
  `nama_metode_pembayaran` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `uang_diterima` decimal(15, 2) NULL DEFAULT 0.00,
  `kembalian` decimal(15, 2) NULL DEFAULT 0.00,
  `referensi_pembayaran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_transaksi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif' COMMENT 'Aktif/Dibatalkan',
  `status_cetak` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Belum',
  `jumlah_cetak` int NULL DEFAULT 0,
  `status_kirim_whatsapp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Belum',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_pembayaran_no`(`no_transaksi`) USING BTREE,
  INDEX `idx_tagihan_pembayaran_siswa`(`id_siswa`) USING BTREE,
  INDEX `idx_tagihan_pembayaran_tanggal`(`tanggal_transaksi`) USING BTREE,
  INDEX `idx_tagihan_pembayaran_status`(`status_transaksi`) USING BTREE,
  INDEX `idx_tagihan_pembayaran_metode`(`id_metode_pembayaran`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_pembayaran_detail
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_pembayaran_detail`;
CREATE TABLE `tagihan_pembayaran_detail`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_pembayaran` int NULL DEFAULT 0,
  `no_transaksi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_tagihan_siswa` int NULL DEFAULT 0,
  `no_tagihan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_tagihan_master` int NULL DEFAULT 0,
  `nama_tagihan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipe_tagihan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bulan` int NULL DEFAULT 0,
  `nama_bulan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT 0,
  `nominal_tagihan` decimal(15, 2) NULL DEFAULT 0.00,
  `nominal_sudah_dibayar_sebelum` decimal(15, 2) NULL DEFAULT 0.00,
  `sisa_sebelum` decimal(15, 2) NULL DEFAULT 0.00,
  `nominal_bayar` decimal(15, 2) NULL DEFAULT 0.00,
  `sisa_setelah` decimal(15, 2) NULL DEFAULT 0.00,
  `status_setelah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_detail` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_bayar_detail_header`(`id_pembayaran`) USING BTREE,
  INDEX `idx_tagihan_bayar_detail_tagihan`(`id_tagihan_siswa`) USING BTREE,
  INDEX `idx_tagihan_bayar_detail_no`(`no_transaksi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_pengaturan_cetak
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_pengaturan_cetak`;
CREATE TABLE `tagihan_pengaturan_cetak`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis_format` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Bukti Pembayaran/Kartu Pembayaran/Surat Tunggakan',
  `nama_format` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_default` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Tidak',
  `ukuran_kertas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '58mm/80mm/A4/A5/Custom',
  `orientasi` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Portrait',
  `lebar_kertas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tinggi_kertas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `margin_atas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `margin_bawah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `margin_kiri` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `margin_kanan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tampilkan_logo` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya',
  `logo_sekolah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_sekolah` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alamat_sekolah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `telepon_sekolah` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `judul_bukti` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `header_cetak` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `footer_cetak` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tampilkan_terbilang` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya',
  `tampilkan_uang_diterima` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya',
  `tampilkan_kembalian` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya',
  `tampilkan_sisa_tagihan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya',
  `nama_penandatangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jabatan_penandatangan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `posisi_tanda_tangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Kanan',
  `pengaturan_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT 'Pengaturan posisi khusus kartu/format custom',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_pengaturan_cetak_jenis`(`jenis_format`) USING BTREE,
  INDEX `idx_tagihan_pengaturan_cetak_default`(`status_default`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_pengaturan_umum
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_pengaturan_umum`;
CREATE TABLE `tagihan_pengaturan_umum`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_pengaturan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_pengaturan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nilai_pengaturan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_pengaturan_kode`(`kode_pengaturan`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_riwayat_kelas_siswa
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_riwayat_kelas_siswa`;
CREATE TABLE `tagihan_riwayat_kelas_siswa`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_siswa` int NULL DEFAULT 0,
  `nis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nisn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_kelas_setting_asal` int NULL DEFAULT 0,
  `id_kelas_asal` int NULL DEFAULT 0,
  `nama_kelas_asal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_periode_asal` int NULL DEFAULT 0,
  `periode_asal` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `semester_asal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_kelas_setting_tujuan` int NULL DEFAULT 0,
  `id_kelas_tujuan` int NULL DEFAULT 0,
  `nama_kelas_tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_periode_tujuan` int NULL DEFAULT 0,
  `periode_tujuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `semester_tujuan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jenis_proses` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Penempatan/Naik Kelas/Pindah Kelas/Tinggal Kelas/Lulus/Berhenti',
  `status_sebelum` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_setelah` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alasan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal_proses` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_proses` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_riwayat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal_batal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_batal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user_batal` int NULL DEFAULT 0,
  `nama_user_batal` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `alasan_batal` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_riwayat_kelas_siswa`(`id_siswa`) USING BTREE,
  INDEX `idx_tagihan_riwayat_kelas_asal`(`id_kelas_setting_asal`) USING BTREE,
  INDEX `idx_tagihan_riwayat_kelas_tujuan`(`id_kelas_setting_tujuan`) USING BTREE,
  INDEX `idx_tagihan_riwayat_kelas_jenis`(`jenis_proses`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_riwayat_whatsapp
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_riwayat_whatsapp`;
CREATE TABLE `tagihan_riwayat_whatsapp`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis_kirim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Bukti Pembayaran/Surat Tunggakan',
  `id_referensi` int NULL DEFAULT 0,
  `nomor_referensi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_siswa` int NULL DEFAULT 0,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_penerima` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `hubungan_penerima` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Ayah/Ibu/Wali/Lainnya',
  `nomor_whatsapp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `isi_pesan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `file_lampiran` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `metode_kirim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Tautan' COMMENT 'Tautan/API',
  `status_kirim` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Disiapkan' COMMENT 'Disiapkan/Berhasil/Gagal',
  `respon_gateway` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_wa_jenis`(`jenis_kirim`) USING BTREE,
  INDEX `idx_tagihan_wa_referensi`(`id_referensi`) USING BTREE,
  INDEX `idx_tagihan_wa_siswa`(`id_siswa`) USING BTREE,
  INDEX `idx_tagihan_wa_status`(`status_kirim`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_siswa
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_siswa`;
CREATE TABLE `tagihan_siswa`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_tagihan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_tagihan_master` int NULL DEFAULT 0,
  `kode_tagihan` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_jenis_tagihan` int NULL DEFAULT 0,
  `nama_jenis_tagihan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_tagihan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipe_tagihan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_periode` int NULL DEFAULT 0,
  `periode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `semester` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bulan` int NULL DEFAULT 0,
  `nama_bulan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT 0,
  `tanggal_jatuh_tempo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_siswa` int NULL DEFAULT 0,
  `nis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nisn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_kelas_setting` int NULL DEFAULT 0,
  `id_kelas` int NULL DEFAULT 0,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nominal_awal` decimal(15, 2) NULL DEFAULT 0.00,
  `jenis_keringanan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nilai_keringanan` decimal(15, 2) NULL DEFAULT 0.00,
  `nominal_tagihan` decimal(15, 2) NULL DEFAULT 0.00,
  `nominal_dibayar` decimal(15, 2) NULL DEFAULT 0.00,
  `sisa_tagihan` decimal(15, 2) NULL DEFAULT 0.00,
  `dianggap_tunggakan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya',
  `status_pembayaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Belum Dibayar' COMMENT 'Belum Dibayar/Dibayar Sebagian/Lunas/Dibebaskan/Dibatalkan',
  `status_tagihan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `tanggal_generate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_generate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user_generate` int NULL DEFAULT 0,
  `nama_user_generate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_siswa_no`(`no_tagihan`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_siswa_periode`(`id_tagihan_master`, `id_siswa`, `bulan`, `tahun`) USING BTREE,
  INDEX `idx_tagihan_siswa_siswa`(`id_siswa`) USING BTREE,
  INDEX `idx_tagihan_siswa_kelas`(`id_kelas_setting`) USING BTREE,
  INDEX `idx_tagihan_siswa_periode`(`id_periode`) USING BTREE,
  INDEX `idx_tagihan_siswa_status_bayar`(`status_pembayaran`) USING BTREE,
  INDEX `idx_tagihan_siswa_status_tagihan`(`status_tagihan`) USING BTREE,
  INDEX `idx_tagihan_siswa_tunggakan`(`dianggap_tunggakan`) USING BTREE,
  INDEX `idx_tagihan_siswa_bulan_tahun`(`bulan`, `tahun`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_surat_tunggakan
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_surat_tunggakan`;
CREATE TABLE `tagihan_surat_tunggakan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_surat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_siswa` int NULL DEFAULT 0,
  `nis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nisn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_kelas_setting` int NULL DEFAULT 0,
  `id_kelas` int NULL DEFAULT 0,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_periode` int NULL DEFAULT 0,
  `periode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `batas_bulan` int NULL DEFAULT 0,
  `batas_tahun` int NULL DEFAULT 0,
  `total_tunggakan` decimal(15, 2) NULL DEFAULT 0.00,
  `jumlah_tagihan` int NULL DEFAULT 0,
  `nama_penandatangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `jabatan_penandatangan` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `catatan_surat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `file_surat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_cetak` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Belum',
  `status_kirim_whatsapp` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Belum',
  `status_surat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_surat_no`(`no_surat`) USING BTREE,
  INDEX `idx_tagihan_surat_siswa`(`id_siswa`) USING BTREE,
  INDEX `idx_tagihan_surat_periode`(`id_periode`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_surat_tunggakan_detail
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_surat_tunggakan_detail`;
CREATE TABLE `tagihan_surat_tunggakan_detail`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_surat_tunggakan` int NULL DEFAULT 0,
  `no_surat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_tagihan_siswa` int NULL DEFAULT 0,
  `no_tagihan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_tagihan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `bulan` int NULL DEFAULT 0,
  `nama_bulan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT 0,
  `nominal_tagihan` decimal(15, 2) NULL DEFAULT 0.00,
  `nominal_dibayar` decimal(15, 2) NULL DEFAULT 0.00,
  `sisa_tagihan` decimal(15, 2) NULL DEFAULT 0.00,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_surat_detail_header`(`id_surat_tunggakan`) USING BTREE,
  INDEX `idx_tagihan_surat_detail_tagihan`(`id_tagihan_siswa`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_target_kelas
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_target_kelas`;
CREATE TABLE `tagihan_target_kelas`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tagihan_master` int NULL DEFAULT 0,
  `id_kelas_setting` int NULL DEFAULT 0,
  `id_kelas` int NULL DEFAULT 0,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_periode` int NULL DEFAULT 0,
  `periode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `semester` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nominal_kelas` decimal(15, 2) NULL DEFAULT 0.00,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_target_kelas`(`id_tagihan_master`, `id_kelas_setting`) USING BTREE,
  INDEX `idx_tagihan_target_kelas_master`(`id_tagihan_master`) USING BTREE,
  INDEX `idx_tagihan_target_kelas_setting`(`id_kelas_setting`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_target_siswa
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_target_siswa`;
CREATE TABLE `tagihan_target_siswa`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tagihan_master` int NULL DEFAULT 0,
  `id_siswa` int NULL DEFAULT 0,
  `nis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nisn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_siswa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_kelas_setting` int NULL DEFAULT 0,
  `id_kelas` int NULL DEFAULT 0,
  `nama_kelas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nominal_target` decimal(15, 2) NULL DEFAULT 0.00,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_target_siswa`(`id_tagihan_master`, `id_siswa`) USING BTREE,
  INDEX `idx_tagihan_target_siswa_master`(`id_tagihan_master`) USING BTREE,
  INDEX `idx_tagihan_target_siswa_siswa`(`id_siswa`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_tarif_bulan
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_tarif_bulan`;
CREATE TABLE `tagihan_tarif_bulan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_tagihan_master` int NULL DEFAULT 0,
  `bulan` int NULL DEFAULT 0,
  `nama_bulan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tahun` int NULL DEFAULT 0,
  `nominal` decimal(15, 2) NULL DEFAULT 0.00,
  `tanggal_jatuh_tempo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_tagihan_tarif_bulan`(`id_tagihan_master`, `bulan`, `tahun`) USING BTREE,
  INDEX `idx_tagihan_tarif_bulan_master`(`id_tagihan_master`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for tagihan_template_whatsapp
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_template_whatsapp`;
CREATE TABLE `tagihan_template_whatsapp`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `jenis_template` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Bukti Pembayaran/Surat Tunggakan',
  `nama_template` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `isi_template` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status_default` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Tidak',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif',
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_tagihan_template_wa_jenis`(`jenis_template`) USING BTREE,
  INDEX `idx_tagihan_template_wa_default`(`status_default`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
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
