/*
 Navicat Premium Data Transfer

 Source Server         : lokalku
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : aplikasi_program_tagihan_sekolah

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 07/08/2026 09:04:36
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
-- Records of jabatan
-- ----------------------------
INSERT INTO `jabatan` VALUES (1, 'Kepala Sekolah');
INSERT INTO `jabatan` VALUES (2, 'Guru');
INSERT INTO `jabatan` VALUES (3, 'KA. TU');
INSERT INTO `jabatan` VALUES (4, 'Bendahara');
INSERT INTO `jabatan` VALUES (5, 'WK. Humas');
INSERT INTO `jabatan` VALUES (6, 'Pembina Ekskul');
INSERT INTO `jabatan` VALUES (7, 'Operator Sekolah');
INSERT INTO `jabatan` VALUES (8, 'Wali Kelas');
INSERT INTO `jabatan` VALUES (9, 'Staf Humas');
INSERT INTO `jabatan` VALUES (10, 'Staf Kurikulum');
INSERT INTO `jabatan` VALUES (11, 'KA. Prog DKV');
INSERT INTO `jabatan` VALUES (12, 'WK. Kesiswaan');
INSERT INTO `jabatan` VALUES (13, 'WK. Kurikulum');
INSERT INTO `jabatan` VALUES (14, 'Staf Kesiswaan');
INSERT INTO `jabatan` VALUES (15, 'OB');
INSERT INTO `jabatan` VALUES (16, 'Admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kelas
-- ----------------------------
INSERT INTO `kelas` VALUES (1, 'KELAS 10', 1, 'Desain Komunikasi Visual', 'REGULER');
INSERT INTO `kelas` VALUES (2, 'KELAS 11', 1, 'Desain Komunikasi Visual', 'REGULER');
INSERT INTO `kelas` VALUES (3, 'KELAS 12', 1, 'Desain Komunikasi Visual', 'REGULER');
INSERT INTO `kelas` VALUES (4, 'KELAS 10', 0, 'Rekayasa Perangkat Lunak', 'REGULER');
INSERT INTO `kelas` VALUES (5, 'KELAS 10', 0, 'Rekayasa Perangkat Lunak', 'NONREGULER');

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
-- Records of kelas_setting
-- ----------------------------
INSERT INTO `kelas_setting` VALUES (14, '1', 'KELAS 10', '8', 'Putri Wulida Sani, S.Pd', '91', 'Genap');
INSERT INTO `kelas_setting` VALUES (15, '2', 'KELAS 11', '10', 'Mohammad Rizky, S. Kom', '91', 'Genap');
INSERT INTO `kelas_setting` VALUES (16, '3', 'KELAS 12', '6', 'Navida Dwi Ana Rahmawati, S.Pd', '91', 'Genap');

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
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kelas_siswa
-- ----------------------------
INSERT INTO `kelas_siswa` VALUES (1, '14', '13', 'ACHMAD DAFFA  ZULKARNAIN', '3084750785', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (2, '14', '1', 'ADISKA REYFANO', '0098826829', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (3, '14', '47', 'Zaks Prian', '24202607', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (4, '14', '48', 'Abdillah Chatam', '0099999999', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (5, '14', '49', 'Abdurrahman Al Hafiz', '0199999999', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (6, '14', '50', 'Ahmad Zhafir', '0100000000', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (7, '14', '51', 'Amirah Izdihar Faiz', '0100000001', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (8, '14', '52', 'Asma\' Albani', '0100000002', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (9, '14', '53', 'Aysha Salma Salsabila', '0100000003', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (10, '14', '54', 'Azkia Ramadhani Setiawan', '0100000004', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (11, '14', '55', 'Khaulah chatam', '0100000005', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (12, '14', '56', 'Maryam', '0100000006', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (13, '14', '57', 'Muhammad Ibrahim Al Fatih', '0100000007', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (14, '14', '58', 'Muhammad Yusuf', '0100000008', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (15, '14', '59', 'Nafisha Jihan Arsyila', '0100000009', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (16, '14', '60', 'Nusaibah Maryam', '0100000010', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (17, '14', '61', 'RUMAYSHA ABIDAH', '0100000011', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (18, '14', '62', 'Sabiqul Haqqi Abadan', '0100000012', 'Laki-laki', '1');

-- ----------------------------
-- Table structure for level
-- ----------------------------
DROP TABLE IF EXISTS `level`;
CREATE TABLE `level`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of level
-- ----------------------------

-- ----------------------------
-- Table structure for list_menu
-- ----------------------------
DROP TABLE IF EXISTS `list_menu`;
CREATE TABLE `list_menu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_menu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of list_menu
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 93 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_tahun_ajaran
-- ----------------------------
INSERT INTO `master_tahun_ajaran` VALUES (1, '2023/2024', 'Tidak Aktif', NULL, NULL, NULL);
INSERT INTO `master_tahun_ajaran` VALUES (3, '2024/2025', 'Tidak Aktif', NULL, NULL, NULL);
INSERT INTO `master_tahun_ajaran` VALUES (90, '2025/2026', 'Tidak Aktif', '25-10-2024', '15:47:41', 16);
INSERT INTO `master_tahun_ajaran` VALUES (91, '2026/2027', 'Aktif', '06-08-2026', '10:21:20', 0);
INSERT INTO `master_tahun_ajaran` VALUES (92, '2027/2028', 'Tidak Aktif', '06-08-2026', '10:21:12', 0);

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `group` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `urut` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of menu
-- ----------------------------

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
-- Records of pegawai
-- ----------------------------
INSERT INTO `pegawai` VALUES (2, 0, 'Mariya Wijayanti, S.E', 'Perempuan', 'Bandung', '1992-08-03', '082330216507', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (3, 0, 'Andini Oktarani Tria Rahma, S.Ds', 'Perempuan', 'Lumajang', '1994-10-15', '085939286060', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (4, 0, 'Ridhotullah Mahfud Yahya, A.Md', 'Laki - Laki', 'Jember', '1990-11-24', '085756383176', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (6, 0, 'Navida Dwi Ana Rahmawati, S.Pd', 'Perempuan', 'Lumajang', '1990-11-24', '085335181883', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (7, 0, 'Masduki, S.Si', 'Laki - Laki', 'Lumajang', '1999-07-15', '085730354381', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (8, 0, 'Putri Wulida Sani, S.Pd', 'Perempuan', 'Lumajang', '2000-02-02', '081930753127', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (10, 0, 'Mohammad Rizky, S. Kom', 'Laki - Laki', 'Lumajang', '2001-10-15', '085234547923', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (11, 0, 'Nanis Su\'udah, S. Pd., Gr.', 'Perempuan', 'Lumajang', '1992-05-26', '089689028526', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (12, 0, 'Muhammad Mughni Labib, S.A.P., M.A.P', 'Laki - Laki', 'Lumajang', '01-03-1998', '082337993160', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (13, 0, 'Ahmad Nur Wicaksono, S.Pd', 'Laki - Laki', 'Lumajang', '06-05-1998', '085536928389', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (19, 0, 'Muhammad Fazar Ramadhan', 'Laki - Laki', 'Lumajang', '2008-09-16', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (21, 0, 'Khaidar Zulkarnaen Firdaus, S.Pd', 'Laki - Laki', 'Lumajang', '2000-04-01', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (22, 0, 'M. Zam Zam Putra Romadhon', 'Laki - Laki', 'Lumajang', '16-04-2025', '-', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (23, 0, 'Nabil Miftahudin, S. Pd', 'Laki - Laki', 'LUMAJANG', '0001-01-01', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (24, 0, 'Wahyu Novianto, S. Sos. I', 'Laki - Laki', 'LUMAJANG', '0001-01-01', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (25, 0, 'Munib Agil Cahyono, S. Pd', 'Laki - Laki', 'LUMAJANG', '0001-01-01', '', 'Offline', NULL);

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
-- Records of pegawai_jabatan
-- ----------------------------
INSERT INTO `pegawai_jabatan` VALUES (23, '2', '12', 'Guru', 'Muhammad Mughni Labib, S.A.P., M.A.P');
INSERT INTO `pegawai_jabatan` VALUES (24, '2', '13', 'Guru', 'Ahmad Nur Wicaksono, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (33, '15', '22', 'OB', 'M. Zam Zam Putra Romadhon');
INSERT INTO `pegawai_jabatan` VALUES (55, '2', '7', 'Guru', 'Masduki, S.Si');
INSERT INTO `pegawai_jabatan` VALUES (56, '1', '7', 'Kepala Sekolah', 'Masduki, S.Si');
INSERT INTO `pegawai_jabatan` VALUES (60, '2', '8', 'Guru', 'Putri Wulida Sani, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (61, '8', '8', 'Wali Kelas', 'Putri Wulida Sani, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (62, '12', '8', 'WK. Kesiswaan', 'Putri Wulida Sani, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (87, '2', '11', 'Guru', 'Nanis Su\'udah, S. Pd., Gr.');
INSERT INTO `pegawai_jabatan` VALUES (88, '2', '6', 'Guru', 'Navida Dwi Ana Rahmawati, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (89, '5', '6', 'WK. Humas', 'Navida Dwi Ana Rahmawati, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (90, '8', '6', 'Wali Kelas', 'Navida Dwi Ana Rahmawati, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (92, '2', '3', 'Guru', 'Andini Oktarani Tria Rahma, S.Ds');
INSERT INTO `pegawai_jabatan` VALUES (102, '2', '24', 'Guru', 'Wahyu Novianto, S. Sos. I');
INSERT INTO `pegawai_jabatan` VALUES (103, '11', '24', 'KA. Prog DKV', 'Wahyu Novianto, S. Sos. I');
INSERT INTO `pegawai_jabatan` VALUES (105, '2', '21', 'Guru', 'Khaidar Zulkarnaen Firdaus, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (106, '7', '4', 'Operator Sekolah', 'Ridhotullah Mahfud Yahya, A.Md');
INSERT INTO `pegawai_jabatan` VALUES (112, '15', '19', 'OB', 'Muhammad Fazar Ramadhan');
INSERT INTO `pegawai_jabatan` VALUES (113, '4', '2', 'Bendahara', 'Mariya Wijayanti, S.E');
INSERT INTO `pegawai_jabatan` VALUES (114, '2', '2', 'Guru', 'Mariya Wijayanti, S.E');
INSERT INTO `pegawai_jabatan` VALUES (115, '2', '10', 'Guru', 'Mohammad Rizky, S. Kom');
INSERT INTO `pegawai_jabatan` VALUES (116, '3', '10', 'KA. TU', 'Mohammad Rizky, S. Kom');
INSERT INTO `pegawai_jabatan` VALUES (117, '2', '23', 'Guru', 'Nabil Miftahudin, S. Pd');
INSERT INTO `pegawai_jabatan` VALUES (118, '13', '23', 'WK. Kurikulum', 'Nabil Miftahudin, S. Pd');
INSERT INTO `pegawai_jabatan` VALUES (120, '2', '25', 'Guru', 'Munib Agil Cahyono, S. Pd');
INSERT INTO `pegawai_jabatan` VALUES (121, '8', '25', 'Wali Kelas', 'Munib Agil Cahyono, S. Pd');

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
) ENGINE = InnoDB AUTO_INCREMENT = 63 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siswa
-- ----------------------------
INSERT INTO `siswa` VALUES (1, '0', '0098826829', '0001/017.126', 'ADISKA REYFANO', 'Laki-laki', 'Lumajang', '13-05-2009', '06-07-2024', '', 'Aktif', '3', 'ryoyuwaraja', 'Dusun Kembangan, RT. 9 RW. 5, Desa/Kel. Kaliwungu, Kec. Tempeh, 67371', 'Sukarto', 'Karyawan Swasta', '', 'djjd', '56', 'Iswati', 'Karyawan Swasta', '78', 'wwd', '56', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (2, '0', '0087264530', '0002/018.126', 'AGIS DANIAL SYAIFURRIDJAL', 'Laki-laki', 'Lumajang', '07-10-2008', '06-07-2024', '', 'Aktif', '3', 'ryoyuwaraja', 'Jln. Raya Randuagung, RT. 1 RW. 15, Dusun Elosan, Kec. Randuagung, 67354', 'Minhatul Aidy', 'Wiraswasta', '', 'gg', '53', 'Afifah', 'Tidak bekerja', '11', 'zz', '66', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (3, '0', '3075253528', '0003/019.126', 'AMRISH YAHYA', 'Laki - Laki', 'Lumajang', '31-05-2007', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Dusun Karanglo, RT. 3 RW. 12, Desa/Kel. Gedangmas, Kec. Randuagung, 67354', 'Jamaluddin', 'Lainnya', '55', 'bb', '55', 'Jumaiyeh', 'Tidak bekerja', '44', 'bbn', '45', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (4, '0', '0088827870', '0004/020.126', 'AURELLIA KESHENA ARSIFA', 'Perempuan', 'Lumajang', '25-09-2008', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Jl. MT. Hariyono No.94, RT. 1 RW. 5, Jogoyudan, Kec. Lumajang, 67315', 'Doddy Suryadiawan', 'PNS/TNI/Polri', '009', 'kk', '44', 'Dea Argyadi Hapsari', 'Tidak bekerja', '88', 'bbnn', '77', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (5, '0', '0098611799', '0005/021.126', 'DINA NURAINI', 'Perempuan', 'Lumajang', '29-10-2009', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Dusun Tawangsongo, RT. 3 RW. 10, Desa/Kel. Pasrujambe, Kec. Pasrujambe, 67361', 'Samsul Hadi', 'Wiraswasta', '009', 'dd', '55', 'Sri Nurhayati', 'Tidak bekerja', '44', 'bbff', '45', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (6, '0', '0095294864', '0006/022.126', 'FARAH AULIA JASMINE', 'Perempuan', 'Situbondo', '12-09-2009', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Perum Panorama Blok Ll-17, RT. 1 RW. 5, Sumberkolak, Desa/Kel. Sumber Kolak, Kec. Panarukan, 68351', 'Apriyanto', 'Karyawan Swasta', '009', 'cc', '56', 'Windhi Ika Wulandari', 'Karyawan Swasta', '88', 'zz', '66', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (7, '0', '0096694213', '0007/023.126', 'RAISYA HAIDAR AKMAL', 'Laki - Laki', 'Lumajang', '08-01-2009', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Jl. Selokambang Gg. Masjid No.4, RT. 2 RW. 1, Srebet, Purwosono, Kec. Sumbersuko, 67316', 'Musyafi\'In', 'PNS/TNI/Polri', '55', 'mmm', '53', 'Ambarita Rachmawati', 'Tidak bekerja', '88', 'ooo', '45', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (8, '0', '0084458450', '0008/024.126', 'SEPTIAN WISNU RAJENDRA', 'Laki - Laki', 'Lumajang', '24-09-2008', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Jalan Kaliwungu, RT. 8 RW. 5, Kembangan, Desa/Kel. Kaliwungu, Kec. Tempeh, 67371', 'Sulaiman', 'Karyawan Swasta', '55', 'nnn', '53', 'Arik Oktavia', 'Wiraswasta', '44', 'kkk', '45', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (9, '0', '0086535821', '0009/025.126', 'SYAFRIL MAULIDAN ZIDQI', 'Laki - Laki', 'Lumajang', '19-04-2008', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Jl. Raya Klakah, RT. 1 RW. 9, Mlawang, Kec. Klakah, 67356', 'Achmad Subhan Fadlillah', 'Sudah Meninggal', '009', 'hh', '56', 'Suhaeni Angraeni', 'Pedagang Kecil', '11', 'hgg', '45', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (10, '0', '0087122726', '0010/026.126', 'ZAIM NUR FADILLAH', 'Laki - Laki', 'Lumajang', '17-06-2008', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Jl Citandui, RT. 2 RW. 7, Jogoyudan, Kec. Lumajang, 67315', 'Nurbarid Hakim', 'Wiraswasta', '', 'G', '56', 'Yuliani', 'Tidak bekerja', '09', 'Hh', '56', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (11, '0', '0086172473', '0011/027.126', 'ZAKI ASYAKIB', 'Laki - Laki', 'Lumajang', '16-02-2008', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Dusun Biting, RT. 26 RW. 7, Desa/Kel. Kutorenon, Kec. Sukodono, 67352', 'Agus Salim', 'Buruh', '009', 'vvv', '53', 'Sri Handayani', 'Tidak bekerja', '88', 'fff', '45', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (12, '0', '0074955596', '0012/028.126', 'ZULFATUL MAGFIROH', 'Perempuan', 'Lumajang', '28-04-2007', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Dsn Wonomerto Lor, RT. 6 RW. 5, Wonomerto Lor, Tempeh Kidul, Kec. Tempeh, 67371', 'Hadir Alim', 'Tidak bekerja', '009', 'sss', '56', 'Siti Aminah', 'Lainnya', '44', 'dffd', '45', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (13, '0', '3084750785', '0001/001.126', 'ACHMAD DAFFA  ZULKARNAIN', 'Laki-laki', 'Lumajang', '10-10-2008', '17-07-2023', '', 'Aktif', '1', NULL, 'Dsn Suco, RT. 3 RW. 22, Pasrujambe, Desa/Kel. Pasrujambe, Kec. Pasrujambe', 'Muhammad Wempi Zulkarnain', 'Wiraswasta', '', '', '', 'Nafiah', 'Wiraswasta', '', '', '', NULL, '3bd57');
INSERT INTO `siswa` VALUES (14, '0', '0085810665', '0002/002.126', 'ARINA AIZA ANANTA', 'Perempuan', 'Jember', '06-07-2007', '17-07-2023', '', 'Offline', '1', NULL, 'Dusun Sumber Nangka, RT. 5 RW. 2, Desa/Kel. Sukogidri, Kec. Ledok Ombo', 'Mulyadi', 'Tidak bekerja', '', '', '', 'Novi Dina Yati', 'Petani', '', '', '', NULL, '8b993');
INSERT INTO `siswa` VALUES (15, '0', '0088409930', '0003/003.126', 'BIMBAS HAKIKI', 'Laki - Laki', 'Lumajang', '28-01-2008', '17-07-2023', '', 'Offline', '1', NULL, 'Jln.Raya Randuagung, RT. 2 RW. 15, Elosan, Desa/Kel. Randuagung, Kec. Randuagung, 67354', 'Mauludin', 'Wiraswasta', '', '', '', 'Endang Susilowati', 'Wiraswasta', '', '', '', NULL, 'd7e92');
INSERT INTO `siswa` VALUES (16, '0', '0062429308', '0004/004.126', 'CINDY META KLAODIYA', 'Perempuan', 'Dekai', '06-07-2006', '17-07-2023', '', 'Offline', '1', NULL, 'Perumahan Pesona Alam, RT. 1 RW. 3, -, Selokbesuki, Kec. Sukodono, 67354', 'Joni Mulyono', 'Karyawan Swasta', '', '', '', 'Mimin Mutmainah', 'Tidak bekerja', '', '', '', NULL, '044f6');
INSERT INTO `siswa` VALUES (17, '0', '0087294078', '0005/005/126', 'DINDA BERLIANA ROSYID', 'Perempuan', 'Lumajang', '12-08-2008', '17-07-2023', '', 'Offline', '1', NULL, 'Jl. Raya Grobogan, RT. 4 RW. 1, Krajan, Desa/Kel. Grobogan, Kec. Kedungjajang, 67358', 'Fathor Rosyid', 'Wiraswasta', '', '', '', 'Arifah Setyawati', 'Tidak bekerja', '', '', '', NULL, 'bd4b6');
INSERT INTO `siswa` VALUES (18, '0', '0079675878', '0006/006.126', 'GIOK D\'YAN PRAMANA', 'Laki - Laki', 'Lumajang', '21-04-2007', '17-07-2023', '', 'Offline', '1', NULL, 'Jalan Raya Ranuyoso, RT. 1 RW. 1, Krajan, Desa/Kel. Ranuyoso, Kec. Ranuyoso, 67357', 'Dwi Riyanto', 'Petani', '', '', '', 'Suyani', 'PNS/TNI/Polri', '', '', '', NULL, 'b77f7');
INSERT INTO `siswa` VALUES (19, '0', '0088626636', '0008/008.126', 'MOHAMMAD KHOIRUL ANAM', 'Laki - Laki', 'Lumajang', '19-03-2008', '17-07-2023', '', 'Offline', '1', NULL, 'Sememu, RT. 1 RW. 3, Umbul, Kec. Pasirian, 67372', 'Subandi', 'Wiraswasta', '', '', '', 'Suntik', 'Petani', '', '', '', NULL, 'f325f');
INSERT INTO `siswa` VALUES (20, '0', '0072727723', '0009/009.126', 'MUHAMMAD ADITIYA', 'Laki - Laki', 'Lumajang', '25-05-2007', '17-07-2023', '', 'Offline', '1', NULL, 'Jl. Tambakrejo Kulon, RT. 6 RW. 3, Karanganom, Kec. Pasrujambe, 67361', 'Sundoyo', 'Wiraswasta', '', '', '', 'Ida Ulaika', 'Tidak bekerja', '', '', '', NULL, '2d8ed');
INSERT INTO `siswa` VALUES (21, '0', '0078988239', '0016/016.126', 'MUHAMMAD BEMBI MAULANA', 'Laki - Laki', 'Lumajang', '23-07-2007', '17-07-2023', '', 'Offline', '1', NULL, 'Jl. Kyai Ilyas Gg Gaza No. 9, RT. 2 RW. 6, Citrodiwangsan, Kec. Lumajang, 67312', 'Muhammad Yatim', 'Wiraswasta', '', '', '', 'Tri Rupiani', 'Karyawan Swasta', '', '', '', NULL, 'e6c1f');
INSERT INTO `siswa` VALUES (22, '0', '0071307566', '0010/010.126', 'MUHAMMAD HABIBI LAM DHARMAWAN', 'Laki - Laki', 'Lumajang', '22-10-2007', '17-07-2023', '', 'Offline', '1', NULL, 'Krajan, RT. 2 RW. 1, Mlawang, Kec. Klakah, 67356', 'Kurniawan Budi Santoso', 'Wiraswasta', '', '', '', 'Darti Darmawanti', 'Pedagang Kecil', '', '', '', NULL, 'f7008');
INSERT INTO `siswa` VALUES (23, '0', '0073352713', '0011/011.126', 'MUHAMMAD HEAGEL PUTRA WIBISONO', 'Laki - Laki', 'Lumajang', '03-04-2007', '17-07-2023', '', 'Offline', '1', NULL, 'Jl. Mayor Kamari Sampurno 74, RT. 4 RW. 2, Ditotrunan, Kec. Lumajang, 67313', 'Wiwit Setyo Wibisono', 'Wiraswasta', '', '', '', 'Erna Risdiyanti', 'Tidak bekerja', '', '', '', NULL, 'cf845');
INSERT INTO `siswa` VALUES (24, '0', '3071237025', '0012/012.126', 'NADILA HALIF RAHMALA', 'Perempuan', 'Surabaya', '26-08-2007', '17-07-2023', '', 'Offline', '1', NULL, 'Dusun Krajan Timur, RT. 20 RW. 3, Krajan Timur, Sumberjati, Kec. Tempeh', 'Ainur Rokhim', 'Wiraswasta', '', '', '', 'Mujilah', 'Karyawan Swasta', '', '', '', NULL, 'c30e3');
INSERT INTO `siswa` VALUES (25, '0', '0050716083', '0013/013.126', 'ROBBY MAULANA YUSUF', 'Laki - Laki', 'Lumajang', '02-01-2005', '17-07-2023', '', 'Offline', '1', NULL, 'Jl. Jendral Hariyono No. 26B, RT. 2 RW. 8, Jogotrunan, Desa/Kel. Jogoyudan, Kec. Lumajang, 67314', 'Lutfi Hakim', 'PNS/TNI/Polri', '', '', '', 'Citra Sentia Rahayu', 'Wiraswasta', '', '', '', NULL, 'dfaab');
INSERT INTO `siswa` VALUES (26, '0', '0082415722', '0014/014.126', 'SITI NUR A\'ISYAH', 'Perempuan', 'Lumajang', '11-09-2008', '17-07-2023', '', 'Offline', '1', NULL, 'Dusun Tanjungsari, RT. 5 RW. 8, Tanjungsari, Mangunsari, Kec. Tekung', 'Matlumi', 'Petani', '', '', '', 'Mistiyah', 'Petani', '', '', '', NULL, '468e1');
INSERT INTO `siswa` VALUES (27, '0', '0072145886', '0015/015.126', 'ZULIA', 'Perempuan', 'Lumajang', '10-07-2007', '17-07-2023', '', 'Offline', '1', NULL, 'Sumber Wadung, RT. 20 RW. 4, Desa/Kel. Jogotrunan, Kec. Lumajang, 67352', 'Su\'at', 'Petani', '', '', '', 'Yuliati', 'Petani', '', '', '', '0008338917', '5c6e5');
INSERT INTO `siswa` VALUES (30, '0', '3092563798', '0002/030.126', 'AHMAD ZIDANE JOENIARSYAH', 'Laki-laki', 'zzz', '22-06-2009', '14-07-2025', 'f4cf0b1018a4355baa8724f55a7ed45d.png', 'Aktif', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'Cholifah Murtiningsih', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (31, '0', '0097695777', '0003/031.126', 'AIN MULYANI RETNO CAHYANI	', 'Perempuan', 'zzz', '17-12-2009', '07-07-2025', '3990cab639d885c366d35ba0e0e6f3d5.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'KHUSNUL KHOTIMAH', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (32, '0', '0093278987', '0006/034.126', 'CINTA PUTRI OCTAVIANA', 'Perempuan', 'zzz', '20-10-2009', '07-07-2025', 'b8cfce71da4ccc523185768e9dac6d67.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'IFA NURJANAH	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (33, '0', '0101377885', '0007/035.126', 'DIAH AYU LESTARI	', 'Perempuan', 'zzz', '28-07-2010', '07-07-2025', '7ebf79ce7700587d75053a53d42a7d66.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'Siti Erniyah	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (34, '0', '0104554091', '0008/036.126', 'DINAR ANANDA SATRIA', 'Laki - Laki', 'zzz', '05-10-2010', '07-07-2025', '1295e90016138f6b7e27e1cdacd7d49f.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'Wita Budiartirini	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (35, '0', '0105541598', '0009/037.126', 'EUIS SEPTIA FITRI NUR HAFSHAH', 'Perempuan', 'zzz', '12-09-2010', '07-07-2025', '434264a730edb578ab8af065ce65387d.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'SITI RODZIYAH, S.SOS', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (36, '0', '0102881276', '0010/038.126', 'LEONITA FRISTA AMELIA	', 'Perempuan', 'zzz', '02-01-2010', '07-07-2025', '985cd18bbed88c91b4aa58953545ce00.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'BELA MUTMAINAH	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (37, '0', '0104541903', '0009/042.126', 'MUHAMAD YOGI VERNANDO', 'Laki - Laki', 'zzz', '09-03-2010', '07-07-2025', '40befce1c0eb7b562da2bd7808890054.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'Nurul Aini	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (38, '0', '0092944174', '0012/040.126', 'MUHAMMAD  RAVELO ABIDZAR', 'Laki - Laki', 'zzz', '19-10-2008', '07-07-2025', 'a3196513c52979597a9773c311e26093.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'Yufi Primitasari	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (39, '0', '0102517553', '0011/039.126', 'MUHAMMAD HABIBILLAH YAFKY YUSRIZA IL YASHA', 'Laki - Laki', 'zzz', '03-04-2010', '07-07-2025', 'e98dfd307e6a2ddc5ac16556be9b898c.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'RIZA SENTIA AGUSTINA', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (40, '0', '3101074258', '0011/044.126', 'RAMANUZAN IBRAHIM PURWANTO	', 'Laki - Laki', 'zzz', '10-02-2010', '07-07-2025', '9340107f5caad0317057abd507834d4b.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'SOFIYAH DITA ASMA	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (41, '0', '0095837602', '0012/045.126', 'RIZKA NURIZZAHRA	', 'Perempuan', 'zzz', '20-03-2009', '07-07-2025', 'a5de638a042a8a1110e1d9af4cdc60cf.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'Buati', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (42, '0', '0092970890', '0004/032.126', 'AURELIA BALQIST SALSABILA	', 'Perempuan', 'zzz', '17-06-2009', '07-07-2025', '49c27d7ce7e8ad933e768122b1268d9e.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'NANIK LAILATUL FITRIYA	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (43, '0', '0094494619', '0008/041.126', 'MUHAMMAD SULTONAN NASHIRO', 'Laki - Laki', 'zzz', '04-08-2009', '07-07-2025', 'defc143f2af91d44832bcb251281354a.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'ERTIK SUSILOWATI	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (44, '0', '0094086382', '0001/029.126', 'AHMAD FIRMAN DIVANO', 'Laki-laki', 'zzz', '08-05-2009', '07-07-2025', '9ab2c006e1d77b17926e9922d7560acf.png', 'Aktif', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'MELDA FERA AGUSTINA', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (45, '0', '0091889755', '0005/033.126', 'BIMA DWI WICAKSONO', 'Laki - Laki', 'zzz', '18-09-2009', '07-07-2025', '9306b3a3e26a3be883bc12d18fb03806.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'FERRY LUKMAN WAHYUDI', 'ZZ', 'ZZZ', 'ZZZ', 'zzz', 'RUKAYAH', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (46, '0', '0096989087', '0010/043.126', 'NAVEED EL FATHIN KURNIAWAN', 'Laki - Laki', 'zzz', '10-10-2009', '07-07-2025', '80bdaf4981956ba51d3d623663f0a223.png', 'Offline', '90', 'ryoyuwaraja', 'ZZZ', 'NANDA KURNIAWAN', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (47, '0', '24202607', '25100B019', 'Zaks Prian', 'Laki-laki', 'Lumajang', '20-01-2007', '01-07-2026', '', 'Aktif', '0', NULL, '', '', '', '', '', NULL, '', '', '', '', NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (48, '0', '0099999999', '1012526', 'Abdillah Chatam', 'Laki-laki', 'Lumajang', '01-01-2010', '15-07-2026', '', 'Aktif', '91', NULL, 'Alamat siswa', 'Chatam', 'Wiraswasta', '082332066465', NULL, NULL, 'Siti Nur Aini', 'Ibu Rumah Tangga', '081234567891', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (49, '0', '0199999999', '15012627', 'Abdurrahman Al Hafiz', 'Laki-laki', 'Lumajang', '16-06-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Jl. Tangkuban Perahu RT 05 RW 06 Desa Karangsari', 'Sudar widayatno', 'Wiraswasta', '85648961292', NULL, NULL, 'Fitrotul Adha', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (50, '0', '0100000000', '16012627', 'Ahmad Zhafir', 'Laki-laki', 'Lumajang', '05-10-2018', '15-07-2026', '', 'Aktif', '91', NULL, 'Jl Panjaitan GG luntas RT 1 RW 11 no 17 citrodiwangsan', 'Bayu Dwi Santoso', 'Karyawan swasta', '85258070302', NULL, NULL, 'Arika Desilia', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (51, '0', '0100000001', '17022627', 'Amirah Izdihar Faiz', 'Perempuan', 'Lumajang', '24-01-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Dusun Krajan Kulon RT.09 RW.02 Desa Selokbesuki Sukodono Lumajang', 'Muhammad Faiz Romli', 'Karyawan swasta', '85749019470', NULL, NULL, 'Dewi Kurotul Aini', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (52, '0', '0100000002', '18022627', 'Asma\' Albani', 'Perempuan', 'Lumajang', '18-03-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Jl. Slamet Rahardjo RT. 01 RW. 01 Dsn. Umpak Desa Tanggung Kec. Padang - Lumajang', 'Nasirudin Albani', 'Karyawan', '85236701551', NULL, NULL, 'Finna Margareta', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (53, '0', '0100000003', '19022627', 'Aysha Salma Salsabila', 'Perempuan', 'Surabaya', '18-05-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Dsn. Krajan - Desa Sarimemuning - Senduro', 'Hadiono', 'Swasta', '85732802362', NULL, NULL, 'Ika Hani Rahmayani', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (54, '0', '0100000004', '20022627', 'Azkia Ramadhani Setiawan', 'Perempuan', 'Lumajang', '18-08-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Jl Yosudarso 15 rt 01 rw 06 tompokersan Lumajang', 'Eko Setiawan', 'Swasta', '85655903746', NULL, NULL, 'Rita Vidiana', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (55, '0', '0100000005', '21022627', 'Khaulah chatam', 'Perempuan', 'Lumajang', '18-07-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Jl. Kh. Wahid Hasyim Gg. 03, Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316, Indonesia', 'Chatam', 'Wiraswasta', '82332066465', NULL, NULL, 'Siti Nur Aini', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (56, '0', '0100000006', '22022627', 'Maryam', 'Perempuan', 'Lumajang', '18-06-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Dusun selokambang RT. 04 RW.02 Desa Purwosono Kec. Sumbersuko', 'Teguh cahyono', 'Pedagang', '87725906376', NULL, NULL, 'Reni Agustin', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (57, '0', '0100000007', '23012627', 'Muhammad Ibrahim Al Fatih', 'Laki-laki', 'Lumajang', '18-09-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Desa Sidorejo dusun wungurejo RT/RW 007/004 kecamatan Rowokangkung', 'Muslimin', 'shadow teacher', '85749569287', NULL, NULL, 'Pristin Monotasari', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (58, '0', '0100000008', '24012627', 'Muhammad Yusuf', 'Laki-laki', 'Lumajang', '18-02-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Desa Tukum Dusun Pandan Wangi RT. 11 RW. 04 Kec. Tekung Kab. Lumajang', 'Ony Tri Sanjaya', 'Karyawan swasta', '85101839345', NULL, NULL, 'Nur Fadilah', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (59, '0', '0100000009', '25022627', 'Nafisha Jihan Arsyila', 'Perempuan', 'Lumajang', '18-11-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Jl. Lapangan RT. 02 RW.04 Desa Kebonagung Sukodono', 'Muhammad Jihad Achponi', 'Operator Layanan Operasional', '85704588616', NULL, NULL, 'Dwi Octavia Ratna Sari', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (60, '0', '0100000010', '26022627', 'Nusaibah Maryam', 'Perempuan', 'Lumajang', '18-12-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Dusun Sumberdawe RT.01 RW.03 Desa Kunir Kidul Kec. Kunir', 'Agzin Anmiba Raharsan', 'Wiraswasta', '81335017991', NULL, NULL, 'Luailiyatul Makmunah', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (61, '0', '0100000011', '27022627', 'RUMAYSHA ABIDAH', 'Perempuan', 'Lumajang', '18-04-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Dusun krajan wetan rt12 rw03 desa selokbesuki kecamatan sukodono kabupaten lumajang', 'Galih Susianto', 'Wiraswasta', '85739273533', NULL, NULL, 'Norita Fatatik Azizi', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (62, '0', '0100000012', '28012627', 'Sabiqul Haqqi Abadan', 'Laki-laki', 'Lumajang', '18-03-2019', '15-07-2026', '', 'Aktif', '91', NULL, 'Jalan Ade Irma Suryani RT 01 RW 02 Rogotrunan', 'Faza Abid Abadan', 'Ojek online', '8970692999', NULL, NULL, 'Diana Cecilia Santoso Putri', 'Ibu Rumah Tangga', '', NULL, NULL, NULL, NULL);

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
-- Records of tagihan_cetak_kartu
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_import_siswa
-- ----------------------------
INSERT INTO `tagihan_import_siswa` VALUES (1, 'IMP/202608/00001', 'preview_20260806125357_template_import_siswa.xlsx', 'uploads/import_siswa/preview_20260806125357_template_import_siswa.xlsx', 91, '2026/2027', 14, 'KELAS 10', 1, 1, 0, 'Selesai', 'Import siswa dari template XLSX', '06-08-2026', '12:54:29', 0, 'Administrator');
INSERT INTO `tagihan_import_siswa` VALUES (2, 'IMP/202608/00002', 'preview_20260806133619_template_import_siswa__1_.xlsx', 'uploads/import_siswa/preview_20260806133619_template_import_siswa__1_.xlsx', 91, '2026/2027', 14, 'KELAS 10', 14, 14, 0, 'Selesai', 'Import siswa dari template XLSX', '06-08-2026', '13:36:30', 0, 'Administrator');

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
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_import_siswa_detail
-- ----------------------------
INSERT INTO `tagihan_import_siswa_detail` VALUES (1, 1, 2, '1012526', '0099999999', 'Abdillah Chatam', 'Laki-laki', 'KELAS 10', 48, 'Berhasil', '', '{\"NIS\":\"1012526\",\"NISN\":\"0099999999\",\"NAMA_LENGKAP\":\"Abdillah Chatam\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"01-01-2010\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Alamat siswa\",\"NAMA_AYAH\":\"Chatam\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"082332066465\",\"NAMA_IBU\":\"Siti Nur Aini\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"081234567891\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (2, 2, 2, '15012627', '0199999999', 'Abdurrahman Al Hafiz', 'Laki-laki', 'KELAS 10', 49, 'Berhasil', '', '{\"NIS\":\"15012627\",\"NISN\":\"0199999999\",\"NAMA_LENGKAP\":\"Abdurrahman Al Hafiz\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"16-06-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Jl. Tangkuban Perahu RT 05 RW 06 Desa Karangsari\",\"NAMA_AYAH\":\"Sudar widayatno\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"85648961292\",\"NAMA_IBU\":\"Fitrotul Adha\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (3, 2, 3, '16012627', '0100000000', 'Ahmad Zhafir', 'Laki-laki', 'KELAS 10', 50, 'Berhasil', '', '{\"NIS\":\"16012627\",\"NISN\":\"0100000000\",\"NAMA_LENGKAP\":\"Ahmad Zhafir\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"05-10-2018\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Jl Panjaitan GG luntas RT 1 RW 11 no 17 citrodiwangsan\",\"NAMA_AYAH\":\"Bayu Dwi Santoso\",\"PEKERJAAN_AYAH\":\"Karyawan swasta\",\"TELEPON_AYAH\":\"85258070302\",\"NAMA_IBU\":\"Arika Desilia\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (4, 2, 4, '17022627', '0100000001', 'Amirah Izdihar Faiz', 'Perempuan', 'KELAS 10', 51, 'Berhasil', '', '{\"NIS\":\"17022627\",\"NISN\":\"0100000001\",\"NAMA_LENGKAP\":\"Amirah Izdihar Faiz\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"24-01-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Dusun Krajan Kulon RT.09 RW.02 Desa Selokbesuki Sukodono Lumajang\",\"NAMA_AYAH\":\"Muhammad Faiz Romli\",\"PEKERJAAN_AYAH\":\"Karyawan swasta\",\"TELEPON_AYAH\":\"85749019470\",\"NAMA_IBU\":\"Dewi Kurotul Aini\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (5, 2, 5, '18022627', '0100000002', 'Asma\' Albani', 'Perempuan', 'KELAS 10', 52, 'Berhasil', '', '{\"NIS\":\"18022627\",\"NISN\":\"0100000002\",\"NAMA_LENGKAP\":\"Asma\' Albani\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-03-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Jl. Slamet Rahardjo RT. 01 RW. 01 Dsn. Umpak Desa Tanggung Kec. Padang - Lumajang\",\"NAMA_AYAH\":\"Nasirudin Albani\",\"PEKERJAAN_AYAH\":\"Karyawan\",\"TELEPON_AYAH\":\"85236701551\",\"NAMA_IBU\":\"Finna Margareta\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (6, 2, 6, '19022627', '0100000003', 'Aysha Salma Salsabila', 'Perempuan', 'KELAS 10', 53, 'Berhasil', '', '{\"NIS\":\"19022627\",\"NISN\":\"0100000003\",\"NAMA_LENGKAP\":\"Aysha Salma Salsabila\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Surabaya\",\"TANGGAL_LAHIR\":\"18-05-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Dsn. Krajan - Desa Sarimemuning - Senduro\",\"NAMA_AYAH\":\"Hadiono\",\"PEKERJAAN_AYAH\":\"Swasta\",\"TELEPON_AYAH\":\"85732802362\",\"NAMA_IBU\":\"Ika Hani Rahmayani\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (7, 2, 7, '20022627', '0100000004', 'Azkia Ramadhani Setiawan', 'Perempuan', 'KELAS 10', 54, 'Berhasil', '', '{\"NIS\":\"20022627\",\"NISN\":\"0100000004\",\"NAMA_LENGKAP\":\"Azkia Ramadhani Setiawan\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-08-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Jl Yosudarso 15 rt 01 rw 06 tompokersan Lumajang\",\"NAMA_AYAH\":\"Eko Setiawan\",\"PEKERJAAN_AYAH\":\"Swasta\",\"TELEPON_AYAH\":\"85655903746\",\"NAMA_IBU\":\"Rita Vidiana\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (8, 2, 8, '21022627', '0100000005', 'Khaulah chatam', 'Perempuan', 'KELAS 10', 55, 'Berhasil', '', '{\"NIS\":\"21022627\",\"NISN\":\"0100000005\",\"NAMA_LENGKAP\":\"Khaulah chatam\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-07-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Jl. Kh. Wahid Hasyim Gg. 03, Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316, Indonesia\",\"NAMA_AYAH\":\"Chatam\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"82332066465\",\"NAMA_IBU\":\"Siti Nur Aini\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (9, 2, 9, '22022627', '0100000006', 'Maryam', 'Perempuan', 'KELAS 10', 56, 'Berhasil', '', '{\"NIS\":\"22022627\",\"NISN\":\"0100000006\",\"NAMA_LENGKAP\":\"Maryam\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-06-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Dusun selokambang RT. 04 RW.02 Desa Purwosono Kec. Sumbersuko\",\"NAMA_AYAH\":\"Teguh cahyono\",\"PEKERJAAN_AYAH\":\"Pedagang\",\"TELEPON_AYAH\":\"87725906376\",\"NAMA_IBU\":\"Reni Agustin\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (10, 2, 10, '23012627', '0100000007', 'Muhammad Ibrahim Al Fatih', 'Laki-laki', 'KELAS 10', 57, 'Berhasil', '', '{\"NIS\":\"23012627\",\"NISN\":\"0100000007\",\"NAMA_LENGKAP\":\"Muhammad Ibrahim Al Fatih\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-09-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Desa Sidorejo dusun wungurejo RT\\/RW 007\\/004 kecamatan Rowokangkung\",\"NAMA_AYAH\":\"Muslimin\",\"PEKERJAAN_AYAH\":\"shadow teacher\",\"TELEPON_AYAH\":\"85749569287\",\"NAMA_IBU\":\"Pristin Monotasari\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (11, 2, 11, '24012627', '0100000008', 'Muhammad Yusuf', 'Laki-laki', 'KELAS 10', 58, 'Berhasil', '', '{\"NIS\":\"24012627\",\"NISN\":\"0100000008\",\"NAMA_LENGKAP\":\"Muhammad Yusuf\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-02-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Desa Tukum Dusun Pandan Wangi RT. 11 RW. 04 Kec. Tekung Kab. Lumajang\",\"NAMA_AYAH\":\"Ony Tri Sanjaya\",\"PEKERJAAN_AYAH\":\"Karyawan swasta\",\"TELEPON_AYAH\":\"85101839345\",\"NAMA_IBU\":\"Nur Fadilah\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (12, 2, 12, '25022627', '0100000009', 'Nafisha Jihan Arsyila', 'Perempuan', 'KELAS 10', 59, 'Berhasil', '', '{\"NIS\":\"25022627\",\"NISN\":\"0100000009\",\"NAMA_LENGKAP\":\"Nafisha Jihan Arsyila\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-11-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Jl. Lapangan RT. 02 RW.04 Desa Kebonagung Sukodono\",\"NAMA_AYAH\":\"Muhammad Jihad Achponi\",\"PEKERJAAN_AYAH\":\"Operator Layanan Operasional\",\"TELEPON_AYAH\":\"85704588616\",\"NAMA_IBU\":\"Dwi Octavia Ratna Sari\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (13, 2, 13, '26022627', '0100000010', 'Nusaibah Maryam', 'Perempuan', 'KELAS 10', 60, 'Berhasil', '', '{\"NIS\":\"26022627\",\"NISN\":\"0100000010\",\"NAMA_LENGKAP\":\"Nusaibah Maryam\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-12-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Dusun Sumberdawe RT.01 RW.03 Desa Kunir Kidul Kec. Kunir\",\"NAMA_AYAH\":\"Agzin Anmiba Raharsan\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"81335017991\",\"NAMA_IBU\":\"Luailiyatul Makmunah\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (14, 2, 14, '27022627', '0100000011', 'RUMAYSHA ABIDAH', 'Perempuan', 'KELAS 10', 61, 'Berhasil', '', '{\"NIS\":\"27022627\",\"NISN\":\"0100000011\",\"NAMA_LENGKAP\":\"RUMAYSHA ABIDAH\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-04-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Dusun krajan wetan rt12 rw03 desa selokbesuki kecamatan sukodono kabupaten lumajang\",\"NAMA_AYAH\":\"Galih Susianto\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"85739273533\",\"NAMA_IBU\":\"Norita Fatatik Azizi\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (15, 2, 15, '28012627', '0100000012', 'Sabiqul Haqqi Abadan', 'Laki-laki', 'KELAS 10', 62, 'Berhasil', '', '{\"NIS\":\"28012627\",\"NISN\":\"0100000012\",\"NAMA_LENGKAP\":\"Sabiqul Haqqi Abadan\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-03-2019\",\"TANGGAL_AWAL_MASUK\":\"15-07-2026\",\"ALAMAT\":\"Jalan Ade Irma Suryani RT 01 RW 02 Rogotrunan\",\"NAMA_AYAH\":\"Faza Abid Abadan\",\"PEKERJAAN_AYAH\":\"Ojek online\",\"TELEPON_AYAH\":\"8970692999\",\"NAMA_IBU\":\"Diana Cecilia Santoso Putri\",\"PEKERJAAN_IBU\":\"Ibu Rumah Tangga\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_jenis
-- ----------------------------
INSERT INTO `tagihan_jenis` VALUES (1, 'SPP73468', 'SPP', 'Bulanan', 'Ya', 'Aktif', 'SPP Bulanan Siswa', '06-08-2026', '10:35:02', 0, 'Administrator');
INSERT INTO `tagihan_jenis` VALUES (2, 'KEG23685', 'Kegiatan Pilihan', 'Langsung', 'Tidak', 'Aktif', '', '06-08-2026', '12:49:56', 0, 'Administrator');

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
-- Records of tagihan_keringanan_siswa
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_log_aktivitas
-- ----------------------------
INSERT INTO `tagihan_log_aktivitas` VALUES (1, 'Tambah Tahun Ajaran', 'Master Data', 'Tambah', 'master_tahun_ajaran', '92', '2027/2028', 'Pengelolaan tahun ajaran', NULL, '{\"periode\":\"2027\\/2028\",\"status\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:21:12\",\"id_user\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:21:12', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (2, 'Aktifkan Tahun Ajaran', 'Master Data', 'Ubah', 'master_tahun_ajaran', '91', '2026/2027', 'Menetapkan tahun ajaran aktif', '{\"id\":\"91\",\"periode\":\"2026\\/2027\",\"status\":\"Tidak Aktif\",\"tanggal\":\"07-04-2026\",\"waktu\":\"08:42:04\",\"id_user\":\"34\"}', '{\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:21:20', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (3, 'Tambah Kelas', 'Master Data', 'Tambah', 'kelas', '4', 'KELAS 10', 'Pengelolaan master kelas', NULL, '{\"nama_kelas\":\"KELAS 10\",\"jurusan\":\"Rekayasa Perangkat Lunak\",\"status\":\"REGULER\",\"id_jurusan\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:21:51', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (4, 'Tambah Kelas', 'Master Data', 'Tambah', 'kelas', '5', 'KELAS 10', 'Pengelolaan master kelas', NULL, '{\"nama_kelas\":\"KELAS 10\",\"jurusan\":\"Rekayasa Perangkat Lunak\",\"status\":\"NONREGULER\",\"id_jurusan\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:24:42', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (5, 'Tambah Jenis Tagihan', 'Master Data', 'Tambah', 'tagihan_jenis', '1', 'SPP73468', 'Pengelolaan jenis tagihan', NULL, '{\"kode_jenis\":\"SPP73468\",\"nama_jenis\":\"SPP\",\"tipe_default\":\"Bulanan\",\"dianggap_tunggakan\":\"Ya\",\"status\":\"Aktif\",\"keterangan\":\"SPP Bulanan Siswa\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:34:14\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:34:14', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (6, 'Tambah Jenis Tagihan', 'Master Data', 'Tambah', 'tagihan_jenis', '2', 'KEG23685', 'Pengelolaan jenis tagihan', NULL, '{\"kode_jenis\":\"KEG23685\",\"nama_jenis\":\"Kegiatan Pilihan\",\"tipe_default\":\"Langsung\",\"dianggap_tunggakan\":\"Tidak\",\"status\":\"Nonaktif\",\"keterangan\":\"\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:34:51\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:34:51', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (7, 'Ubah Status Jenis Tagihan', 'Master Data', 'Ubah', 'tagihan_jenis', '1', 'SPP73468', 'Status menjadi Nonaktif', '{\"id\":\"1\",\"kode_jenis\":\"SPP73468\",\"nama_jenis\":\"SPP\",\"tipe_default\":\"Bulanan\",\"dianggap_tunggakan\":\"Ya\",\"status\":\"Aktif\",\"keterangan\":\"SPP Bulanan Siswa\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:34:14\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status\":\"Nonaktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:34:59', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (8, 'Ubah Status Jenis Tagihan', 'Master Data', 'Ubah', 'tagihan_jenis', '1', 'SPP73468', 'Status menjadi Aktif', '{\"id\":\"1\",\"kode_jenis\":\"SPP73468\",\"nama_jenis\":\"SPP\",\"tipe_default\":\"Bulanan\",\"dianggap_tunggakan\":\"Ya\",\"status\":\"Nonaktif\",\"keterangan\":\"SPP Bulanan Siswa\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:34:59\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:35:02', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (9, 'Ubah Status Metode', 'Master Data', 'Ubah', 'tagihan_metode_pembayaran', '1', 'TUNAI', 'Status menjadi Nonaktif', '{\"id\":\"1\",\"kode_metode\":\"TUNAI\",\"nama_metode\":\"Tunai\",\"jenis_metode\":\"Tunai\",\"butuh_uang_diterima\":\"Ya\",\"status\":\"Aktif\",\"urutan\":\"1\",\"keterangan\":\"Pembayaran tunai\",\"tanggal\":null,\"waktu\":null,\"id_user\":\"0\",\"nama_user\":null}', '{\"status\":\"Nonaktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '10:35:29', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (10, 'Ubah Status Metode', 'Master Data', 'Ubah', 'tagihan_metode_pembayaran', '1', 'TUNAI', 'Status menjadi Aktif', '{\"id\":\"1\",\"kode_metode\":\"TUNAI\",\"nama_metode\":\"Tunai\",\"jenis_metode\":\"Tunai\",\"butuh_uang_diterima\":\"Ya\",\"status\":\"Nonaktif\",\"urutan\":\"1\",\"keterangan\":\"Pembayaran tunai\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:35:28\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '06-08-2026', '10:45:45', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (11, 'Ubah Status Metode', 'Master Data', 'Ubah', 'tagihan_metode_pembayaran', '1', 'TUNAI', 'Status menjadi Nonaktif', '{\"id\":\"1\",\"kode_metode\":\"TUNAI\",\"nama_metode\":\"Tunai\",\"jenis_metode\":\"Tunai\",\"butuh_uang_diterima\":\"Ya\",\"status\":\"Aktif\",\"urutan\":\"1\",\"keterangan\":\"Pembayaran tunai\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:45:45\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status\":\"Nonaktif\"}', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '06-08-2026', '10:45:48', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (12, 'Ubah Metode Pembayaran', 'Master Data', 'Ubah', 'tagihan_metode_pembayaran', '2', 'TRANSFER', 'Pengelolaan metode pembayaran', '{\"id\":\"2\",\"kode_metode\":\"TRANSFER\",\"nama_metode\":\"Transfer Bank\",\"jenis_metode\":\"Transfer\",\"butuh_uang_diterima\":\"Tidak\",\"status\":\"Aktif\",\"urutan\":\"2\",\"keterangan\":\"Pembayaran melalui transfer bank\",\"tanggal\":null,\"waktu\":null,\"id_user\":\"0\",\"nama_user\":null}', '{\"kode_metode\":\"TRANSFER\",\"nama_metode\":\"Transfer Bank\",\"jenis_metode\":\"Transfer\",\"butuh_uang_diterima\":\"Tidak\",\"status\":\"Nonaktif\",\"urutan\":2,\"keterangan\":\"Pembayaran melalui transfer bank\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:45:53\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '06-08-2026', '10:45:53', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (13, 'Ubah Status Metode', 'Master Data', 'Ubah', 'tagihan_metode_pembayaran', '2', 'TRANSFER', 'Status menjadi Aktif', '{\"id\":\"2\",\"kode_metode\":\"TRANSFER\",\"nama_metode\":\"Transfer Bank\",\"jenis_metode\":\"Transfer\",\"butuh_uang_diterima\":\"Tidak\",\"status\":\"Nonaktif\",\"urutan\":\"2\",\"keterangan\":\"Pembayaran melalui transfer bank\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:45:53\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '06-08-2026', '10:45:56', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (14, 'Tambah Template WhatsApp', 'Pengaturan', 'Tambah', 'tagihan_template_whatsapp', '1', 'Template Utama', 'Template Bukti Pembayaran', NULL, '{\"jenis_template\":\"Bukti Pembayaran\",\"nama_template\":\"Template Utama\",\"isi_template\":\"Yth. Bapak\\/Ibu {nama_wali}, pembayaran {nama_siswa} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.\",\"status_default\":\"Ya\",\"status\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"11:02:04\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:02:04', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (15, 'Tambah Format Kartu Pembayaran', 'Pengaturan', 'Tambah', 'tagihan_pengaturan_cetak', '1', 'Kartu Pembayaran Sekolah', 'Konfigurasi format Kartu Pembayaran', NULL, '{\"jenis_format\":\"Kartu Pembayaran\",\"nama_format\":\"Kartu Pembayaran Sekolah\",\"status_default\":\"Tidak\",\"ukuran_kertas\":\"Custom\",\"orientasi\":\"Portrait\",\"lebar_kertas\":\"210\",\"tinggi_kertas\":\"148\",\"margin_atas\":\"\",\"margin_bawah\":\"\",\"margin_kiri\":\"\",\"margin_kanan\":\"\",\"tampilkan_logo\":\"Ya\",\"logo_sekolah\":\"\",\"nama_sekolah\":\"Sekolah\",\"alamat_sekolah\":\"\",\"telepon_sekolah\":\"\",\"judul_bukti\":\"\",\"header_cetak\":\"\",\"footer_cetak\":\"\",\"tampilkan_terbilang\":\"Ya\",\"tampilkan_uang_diterima\":\"Ya\",\"tampilkan_kembalian\":\"Ya\",\"tampilkan_sisa_tagihan\":\"Ya\",\"nama_penandatangan\":\"\",\"jabatan_penandatangan\":\"\",\"posisi_tanda_tangan\":\"Kanan\",\"pengaturan_json\":\"{\\\"jumlah_baris\\\":12,\\\"jarak_baris\\\":8,\\\"posisi_x\\\":10,\\\"posisi_y\\\":10,\\\"lebar_tanggal\\\":25,\\\"lebar_jenis\\\":70,\\\"lebar_nominal\\\":35,\\\"lebar_petugas\\\":20,\\\"kolom\\\":[\\\"Tanggal\\\",\\\"Jenis\\/Bulan\\\",\\\"Nominal\\\",\\\"Petugas\\\"]}\",\"status\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"11:04:14\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:04:14', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (16, 'Jadikan Format Default', 'Pengaturan', 'Ubah', 'tagihan_pengaturan_cetak', '1', 'Kartu Pembayaran Sekolah', 'Format default Kartu Pembayaran', '{\"id\":\"1\",\"jenis_format\":\"Kartu Pembayaran\",\"nama_format\":\"Kartu Pembayaran Sekolah\",\"status_default\":\"Tidak\",\"ukuran_kertas\":\"Custom\",\"orientasi\":\"Portrait\",\"lebar_kertas\":\"210\",\"tinggi_kertas\":\"148\",\"margin_atas\":\"\",\"margin_bawah\":\"\",\"margin_kiri\":\"\",\"margin_kanan\":\"\",\"tampilkan_logo\":\"Ya\",\"logo_sekolah\":\"\",\"nama_sekolah\":\"Sekolah\",\"alamat_sekolah\":\"\",\"telepon_sekolah\":\"\",\"judul_bukti\":\"\",\"header_cetak\":\"\",\"footer_cetak\":\"\",\"tampilkan_terbilang\":\"Ya\",\"tampilkan_uang_diterima\":\"Ya\",\"tampilkan_kembalian\":\"Ya\",\"tampilkan_sisa_tagihan\":\"Ya\",\"nama_penandatangan\":\"\",\"jabatan_penandatangan\":\"\",\"posisi_tanda_tangan\":\"Kanan\",\"pengaturan_json\":\"{\\\"jumlah_baris\\\":12,\\\"jarak_baris\\\":8,\\\"posisi_x\\\":10,\\\"posisi_y\\\":10,\\\"lebar_tanggal\\\":25,\\\"lebar_jenis\\\":70,\\\"lebar_nominal\\\":35,\\\"lebar_petugas\\\":20,\\\"kolom\\\":[\\\"Tanggal\\\",\\\"Jenis\\/Bulan\\\",\\\"Nominal\\\",\\\"Petugas\\\"]}\",\"status\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"11:04:14\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status_default\":\"Ya\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:04:17', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (17, 'Ubah Format Kartu Pembayaran', 'Pengaturan', 'Ubah', 'tagihan_pengaturan_cetak', '1', 'Kartu Pembayaran Sekolah', 'Konfigurasi format Kartu Pembayaran', '{\"id\":\"1\",\"jenis_format\":\"Kartu Pembayaran\",\"nama_format\":\"Kartu Pembayaran Sekolah\",\"status_default\":\"Ya\",\"ukuran_kertas\":\"Custom\",\"orientasi\":\"Portrait\",\"lebar_kertas\":\"210\",\"tinggi_kertas\":\"148\",\"margin_atas\":\"\",\"margin_bawah\":\"\",\"margin_kiri\":\"\",\"margin_kanan\":\"\",\"tampilkan_logo\":\"Ya\",\"logo_sekolah\":\"\",\"nama_sekolah\":\"Sekolah\",\"alamat_sekolah\":\"\",\"telepon_sekolah\":\"\",\"judul_bukti\":\"\",\"header_cetak\":\"\",\"footer_cetak\":\"\",\"tampilkan_terbilang\":\"Ya\",\"tampilkan_uang_diterima\":\"Ya\",\"tampilkan_kembalian\":\"Ya\",\"tampilkan_sisa_tagihan\":\"Ya\",\"nama_penandatangan\":\"\",\"jabatan_penandatangan\":\"\",\"posisi_tanda_tangan\":\"Kanan\",\"pengaturan_json\":\"{\\\"jumlah_baris\\\":12,\\\"jarak_baris\\\":8,\\\"posisi_x\\\":10,\\\"posisi_y\\\":10,\\\"lebar_tanggal\\\":25,\\\"lebar_jenis\\\":70,\\\"lebar_nominal\\\":35,\\\"lebar_petugas\\\":20,\\\"kolom\\\":[\\\"Tanggal\\\",\\\"Jenis\\/Bulan\\\",\\\"Nominal\\\",\\\"Petugas\\\"]}\",\"status\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"11:04:14\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"jenis_format\":\"Kartu Pembayaran\",\"nama_format\":\"Kartu Pembayaran Sekolah\",\"status_default\":\"Tidak\",\"ukuran_kertas\":\"Custom\",\"orientasi\":\"Portrait\",\"lebar_kertas\":\"210\",\"tinggi_kertas\":\"148\",\"margin_atas\":\"\",\"margin_bawah\":\"\",\"margin_kiri\":\"\",\"margin_kanan\":\"\",\"tampilkan_logo\":\"Ya\",\"logo_sekolah\":\"\",\"nama_sekolah\":\"Sekolah\",\"alamat_sekolah\":\"\",\"telepon_sekolah\":\"\",\"judul_bukti\":\"\",\"header_cetak\":\"\",\"footer_cetak\":\"\",\"tampilkan_terbilang\":\"Ya\",\"tampilkan_uang_diterima\":\"Ya\",\"tampilkan_kembalian\":\"Ya\",\"tampilkan_sisa_tagihan\":\"Ya\",\"nama_penandatangan\":\"\",\"jabatan_penandatangan\":\"\",\"posisi_tanda_tangan\":\"Kanan\",\"pengaturan_json\":\"{\\\"jumlah_baris\\\":12,\\\"jarak_baris\\\":8,\\\"posisi_x\\\":10,\\\"posisi_y\\\":10,\\\"lebar_tanggal\\\":25,\\\"lebar_jenis\\\":70,\\\"lebar_nominal\\\":35,\\\"lebar_petugas\\\":20,\\\"kolom\\\":[\\\"Tanggal\\\",\\\"Jenis\\/Bulan\\\",\\\"Nominal\\\",\\\"Petugas\\\"]}\",\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:04:25', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (18, 'Jadikan Format Default', 'Pengaturan', 'Ubah', 'tagihan_pengaturan_cetak', '1', 'Kartu Pembayaran Sekolah', 'Format default Kartu Pembayaran', '{\"id\":\"1\",\"jenis_format\":\"Kartu Pembayaran\",\"nama_format\":\"Kartu Pembayaran Sekolah\",\"status_default\":\"Tidak\",\"ukuran_kertas\":\"Custom\",\"orientasi\":\"Portrait\",\"lebar_kertas\":\"210\",\"tinggi_kertas\":\"148\",\"margin_atas\":\"\",\"margin_bawah\":\"\",\"margin_kiri\":\"\",\"margin_kanan\":\"\",\"tampilkan_logo\":\"Ya\",\"logo_sekolah\":\"\",\"nama_sekolah\":\"Sekolah\",\"alamat_sekolah\":\"\",\"telepon_sekolah\":\"\",\"judul_bukti\":\"\",\"header_cetak\":\"\",\"footer_cetak\":\"\",\"tampilkan_terbilang\":\"Ya\",\"tampilkan_uang_diterima\":\"Ya\",\"tampilkan_kembalian\":\"Ya\",\"tampilkan_sisa_tagihan\":\"Ya\",\"nama_penandatangan\":\"\",\"jabatan_penandatangan\":\"\",\"posisi_tanda_tangan\":\"Kanan\",\"pengaturan_json\":\"{\\\"jumlah_baris\\\":12,\\\"jarak_baris\\\":8,\\\"posisi_x\\\":10,\\\"posisi_y\\\":10,\\\"lebar_tanggal\\\":25,\\\"lebar_jenis\\\":70,\\\"lebar_nominal\\\":35,\\\"lebar_petugas\\\":20,\\\"kolom\\\":[\\\"Tanggal\\\",\\\"Jenis\\/Bulan\\\",\\\"Nominal\\\",\\\"Petugas\\\"]}\",\"status\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"11:04:14\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status_default\":\"Ya\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:04:32', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (19, 'Ubah Siswa', 'Master Data', 'Ubah', 'siswa', '13', '0001/001.126', 'Pengelolaan identitas siswa', '{\"id\":\"13\",\"id_daftar_siswa\":\"0\",\"nisn\":\"3084750785\",\"nis\":\"0001\\/001.126\",\"nama_lengkap\":\"ACHMAD DAFFA  ZULKARNAIN\",\"jk\":\"Laki - Laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"10-10-2008\",\"tanggal_awal_masuk\":\"17-07-2023\",\"foto_siswa\":\"\",\"status_pendaftaran\":\"Offline\",\"id_periode\":\"1\",\"password\":null,\"alamat_siswa\":\"Dsn Suco, RT. 3 RW. 22, Pasrujambe, Desa\\/Kel. Pasrujambe, Kec. Pasrujambe\",\"nama_ayah\":\"Muhammad Wempi Zulkarnain\",\"pekerjaan_ayah\":\"Wiraswasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"\",\"usia_ayah\":\"\",\"nama_ibu\":\"Nafiah\",\"pekerjaan_ibu\":\"Wiraswasta\",\"telepon_ibu\":\"\",\"alamat_ibu\":\"\",\"usia_ibu\":\"\",\"kode_absen\":null,\"password_pkl\":\"3bd57\"}', '{\"nis\":\"0001\\/001.126\",\"nisn\":\"3084750785\",\"nama_lengkap\":\"ACHMAD DAFFA  ZULKARNAIN\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"10-10-2008\",\"tanggal_awal_masuk\":\"17-07-2023\",\"alamat_siswa\":\"Dsn Suco, RT. 3 RW. 22, Pasrujambe, Desa\\/Kel. Pasrujambe, Kec. Pasrujambe\",\"nama_ayah\":\"Muhammad Wempi Zulkarnain\",\"pekerjaan_ayah\":\"Wiraswasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"\",\"nama_ibu\":\"Nafiah\",\"pekerjaan_ibu\":\"Wiraswasta\",\"telepon_ibu\":\"\",\"alamat_ibu\":\"\",\"status_pendaftaran\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:06:13', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (20, 'Ubah Siswa', 'Master Data', 'Ubah', 'siswa', '13', '0001/001.126', 'Pengelolaan identitas siswa', '{\"id\":\"13\",\"id_daftar_siswa\":\"0\",\"nisn\":\"3084750785\",\"nis\":\"0001\\/001.126\",\"nama_lengkap\":\"ACHMAD DAFFA  ZULKARNAIN\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"10-10-2008\",\"tanggal_awal_masuk\":\"17-07-2023\",\"foto_siswa\":\"\",\"status_pendaftaran\":\"Aktif\",\"id_periode\":\"1\",\"password\":null,\"alamat_siswa\":\"Dsn Suco, RT. 3 RW. 22, Pasrujambe, Desa\\/Kel. Pasrujambe, Kec. Pasrujambe\",\"nama_ayah\":\"Muhammad Wempi Zulkarnain\",\"pekerjaan_ayah\":\"Wiraswasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"\",\"usia_ayah\":\"\",\"nama_ibu\":\"Nafiah\",\"pekerjaan_ibu\":\"Wiraswasta\",\"telepon_ibu\":\"\",\"alamat_ibu\":\"\",\"usia_ibu\":\"\",\"kode_absen\":null,\"password_pkl\":\"3bd57\"}', '{\"nis\":\"0001\\/001.126\",\"nisn\":\"3084750785\",\"nama_lengkap\":\"ACHMAD DAFFA  ZULKARNAIN\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"10-10-2008\",\"tanggal_awal_masuk\":\"17-07-2023\",\"alamat_siswa\":\"Dsn Suco, RT. 3 RW. 22, Pasrujambe, Desa\\/Kel. Pasrujambe, Kec. Pasrujambe\",\"nama_ayah\":\"Muhammad Wempi Zulkarnain\",\"pekerjaan_ayah\":\"Wiraswasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"\",\"nama_ibu\":\"Nafiah\",\"pekerjaan_ibu\":\"Wiraswasta\",\"telepon_ibu\":\"\",\"alamat_ibu\":\"\",\"status_pendaftaran\":\"Nonaktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:06:29', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (21, 'Ubah Siswa', 'Master Data', 'Ubah', 'siswa', '13', '0001/001.126', 'Pengelolaan identitas siswa', '{\"id\":\"13\",\"id_daftar_siswa\":\"0\",\"nisn\":\"3084750785\",\"nis\":\"0001\\/001.126\",\"nama_lengkap\":\"ACHMAD DAFFA  ZULKARNAIN\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"10-10-2008\",\"tanggal_awal_masuk\":\"17-07-2023\",\"foto_siswa\":\"\",\"status_pendaftaran\":\"Nonaktif\",\"id_periode\":\"1\",\"password\":null,\"alamat_siswa\":\"Dsn Suco, RT. 3 RW. 22, Pasrujambe, Desa\\/Kel. Pasrujambe, Kec. Pasrujambe\",\"nama_ayah\":\"Muhammad Wempi Zulkarnain\",\"pekerjaan_ayah\":\"Wiraswasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"\",\"usia_ayah\":\"\",\"nama_ibu\":\"Nafiah\",\"pekerjaan_ibu\":\"Wiraswasta\",\"telepon_ibu\":\"\",\"alamat_ibu\":\"\",\"usia_ibu\":\"\",\"kode_absen\":null,\"password_pkl\":\"3bd57\"}', '{\"nis\":\"0001\\/001.126\",\"nisn\":\"3084750785\",\"nama_lengkap\":\"ACHMAD DAFFA  ZULKARNAIN\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"10-10-2008\",\"tanggal_awal_masuk\":\"17-07-2023\",\"alamat_siswa\":\"Dsn Suco, RT. 3 RW. 22, Pasrujambe, Desa\\/Kel. Pasrujambe, Kec. Pasrujambe\",\"nama_ayah\":\"Muhammad Wempi Zulkarnain\",\"pekerjaan_ayah\":\"Wiraswasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"\",\"nama_ibu\":\"Nafiah\",\"pekerjaan_ibu\":\"Wiraswasta\",\"telepon_ibu\":\"\",\"alamat_ibu\":\"\",\"status_pendaftaran\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:06:33', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (22, 'Ubah Siswa', 'Master Data', 'Ubah', 'siswa', '1', '0001/017.126', 'Pengelolaan identitas siswa', '{\"id\":\"1\",\"id_daftar_siswa\":\"0\",\"nisn\":\"0098826829\",\"nis\":\"0001\\/017.126\",\"nama_lengkap\":\"ADISKA REYFANO\",\"jk\":\"Laki - Laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"13-05-2009\",\"tanggal_awal_masuk\":\"06-07-2024\",\"foto_siswa\":\"\",\"status_pendaftaran\":\"Offline\",\"id_periode\":\"3\",\"password\":\"ryoyuwaraja\",\"alamat_siswa\":\"Dusun Kembangan, RT. 9 RW. 5, Desa\\/Kel. Kaliwungu, Kec. Tempeh, 67371\",\"nama_ayah\":\"Sukarto\",\"pekerjaan_ayah\":\"Karyawan Swasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"djjd\",\"usia_ayah\":\"56\",\"nama_ibu\":\"Iswati\",\"pekerjaan_ibu\":\"Karyawan Swasta\",\"telepon_ibu\":\"78\",\"alamat_ibu\":\"wwd\",\"usia_ibu\":\"56\",\"kode_absen\":null,\"password_pkl\":\"ryoyuwaraja\"}', '{\"nis\":\"0001\\/017.126\",\"nisn\":\"0098826829\",\"nama_lengkap\":\"ADISKA REYFANO\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"13-05-2009\",\"tanggal_awal_masuk\":\"06-07-2024\",\"alamat_siswa\":\"Dusun Kembangan, RT. 9 RW. 5, Desa\\/Kel. Kaliwungu, Kec. Tempeh, 67371\",\"nama_ayah\":\"Sukarto\",\"pekerjaan_ayah\":\"Karyawan Swasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"djjd\",\"nama_ibu\":\"Iswati\",\"pekerjaan_ibu\":\"Karyawan Swasta\",\"telepon_ibu\":\"78\",\"alamat_ibu\":\"wwd\",\"status_pendaftaran\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:07:19', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (23, 'Ubah Siswa', 'Master Data', 'Ubah', 'siswa', '2', '0002/018.126', 'Pengelolaan identitas siswa', '{\"id\":\"2\",\"id_daftar_siswa\":\"0\",\"nisn\":\"0087264530\",\"nis\":\"0002\\/018.126\",\"nama_lengkap\":\"AGIS DANIAL SYAIFURRIDJAL\",\"jk\":\"Laki - Laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"07-10-2008\",\"tanggal_awal_masuk\":\"06-07-2024\",\"foto_siswa\":\"\",\"status_pendaftaran\":\"Offline\",\"id_periode\":\"3\",\"password\":\"ryoyuwaraja\",\"alamat_siswa\":\"Jln. Raya Randuagung, RT. 1 RW. 15, Dusun Elosan, Kec. Randuagung, 67354\",\"nama_ayah\":\"Minhatul Aidy\",\"pekerjaan_ayah\":\"Wiraswasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"gg\",\"usia_ayah\":\"53\",\"nama_ibu\":\"Afifah\",\"pekerjaan_ibu\":\"Tidak bekerja\",\"telepon_ibu\":\"11\",\"alamat_ibu\":\"zz\",\"usia_ibu\":\"66\",\"kode_absen\":null,\"password_pkl\":\"ryoyuwaraja\"}', '{\"nis\":\"0002\\/018.126\",\"nisn\":\"0087264530\",\"nama_lengkap\":\"AGIS DANIAL SYAIFURRIDJAL\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"07-10-2008\",\"tanggal_awal_masuk\":\"06-07-2024\",\"alamat_siswa\":\"Jln. Raya Randuagung, RT. 1 RW. 15, Dusun Elosan, Kec. Randuagung, 67354\",\"nama_ayah\":\"Minhatul Aidy\",\"pekerjaan_ayah\":\"Wiraswasta\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"gg\",\"nama_ibu\":\"Afifah\",\"pekerjaan_ibu\":\"Tidak bekerja\",\"telepon_ibu\":\"11\",\"alamat_ibu\":\"zz\",\"status_pendaftaran\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:07:24', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (24, 'Tambah Siswa', 'Master Data', 'Tambah', 'siswa', '47', '25100B019', 'Pengelolaan identitas siswa', NULL, '{\"id_daftar_siswa\":\"0\",\"foto_siswa\":\"\",\"id_periode\":\"0\",\"nis\":\"25100B019\",\"nisn\":\"24202607\",\"nama_lengkap\":\"Zaks Prian\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"Lumajang\",\"tanggal_lahir\":\"20-01-2007\",\"tanggal_awal_masuk\":\"01-07-2026\",\"alamat_siswa\":\"\",\"nama_ayah\":\"\",\"pekerjaan_ayah\":\"\",\"telepon_ayah\":\"\",\"alamat_ayah\":\"\",\"nama_ibu\":\"\",\"pekerjaan_ibu\":\"\",\"telepon_ibu\":\"\",\"alamat_ibu\":\"\",\"status_pendaftaran\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:08:09', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (25, 'Ubah Siswa', 'Master Data', 'Ubah', 'siswa', '44', '0001/029.126', 'Pengelolaan identitas siswa', '{\"id\":\"44\",\"id_daftar_siswa\":\"0\",\"nisn\":\"0094086382\",\"nis\":\"0001\\/029.126\",\"nama_lengkap\":\"AHMAD FIRMAN DIVANO\",\"jk\":\"Laki - Laki\",\"tempat_lahir\":\"zzz\",\"tanggal_lahir\":\"08-05-2009\",\"tanggal_awal_masuk\":\"07-07-2025\",\"foto_siswa\":\"9ab2c006e1d77b17926e9922d7560acf.png\",\"status_pendaftaran\":\"Offline\",\"id_periode\":\"90\",\"password\":\"ryoyuwaraja\",\"alamat_siswa\":\"zzz\",\"nama_ayah\":\"zzz\",\"pekerjaan_ayah\":\"zzz\",\"telepon_ayah\":\"zzz\",\"alamat_ayah\":\"zzz\",\"usia_ayah\":\"zzz\",\"nama_ibu\":\"MELDA FERA AGUSTINA\\t\",\"pekerjaan_ibu\":\"zzz\",\"telepon_ibu\":\"zzz\",\"alamat_ibu\":\"zzz\",\"usia_ibu\":\"zzz\",\"kode_absen\":null,\"password_pkl\":\"ryoyuwaraja\"}', '{\"nis\":\"0001\\/029.126\",\"nisn\":\"0094086382\",\"nama_lengkap\":\"AHMAD FIRMAN DIVANO\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"zzz\",\"tanggal_lahir\":\"08-05-2009\",\"tanggal_awal_masuk\":\"07-07-2025\",\"alamat_siswa\":\"zzz\",\"nama_ayah\":\"zzz\",\"pekerjaan_ayah\":\"zzz\",\"telepon_ayah\":\"zzz\",\"alamat_ayah\":\"zzz\",\"nama_ibu\":\"MELDA FERA AGUSTINA\",\"pekerjaan_ibu\":\"zzz\",\"telepon_ibu\":\"zzz\",\"alamat_ibu\":\"zzz\",\"status_pendaftaran\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:21:31', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (26, 'Ubah Siswa', 'Master Data', 'Ubah', 'siswa', '30', '0002/030.126', 'Pengelolaan identitas siswa', '{\"id\":\"30\",\"id_daftar_siswa\":\"0\",\"nisn\":\"3092563798\",\"nis\":\"0002\\/030.126\",\"nama_lengkap\":\"AHMAD ZIDANE JOENIARSYAH\",\"jk\":\"Laki - Laki\",\"tempat_lahir\":\"zzz\",\"tanggal_lahir\":\"22-06-2009\",\"tanggal_awal_masuk\":\"14-07-2025\",\"foto_siswa\":\"f4cf0b1018a4355baa8724f55a7ed45d.png\",\"status_pendaftaran\":\"Offline\",\"id_periode\":\"90\",\"password\":\"ryoyuwaraja\",\"alamat_siswa\":\"zzz\",\"nama_ayah\":\"zzz\",\"pekerjaan_ayah\":\"zzz\",\"telepon_ayah\":\"zzz\",\"alamat_ayah\":\"zzz\",\"usia_ayah\":\"zzz\",\"nama_ibu\":\"Cholifah Murtiningsih\",\"pekerjaan_ibu\":\"zzz\",\"telepon_ibu\":\"zzz\",\"alamat_ibu\":\"zzz\",\"usia_ibu\":\"zzz\",\"kode_absen\":null,\"password_pkl\":\"ryoyuwaraja\"}', '{\"nis\":\"0002\\/030.126\",\"nisn\":\"3092563798\",\"nama_lengkap\":\"AHMAD ZIDANE JOENIARSYAH\",\"jk\":\"Laki-laki\",\"tempat_lahir\":\"zzz\",\"tanggal_lahir\":\"22-06-2009\",\"tanggal_awal_masuk\":\"14-07-2025\",\"alamat_siswa\":\"zzz\",\"nama_ayah\":\"zzz\",\"pekerjaan_ayah\":\"zzz\",\"telepon_ayah\":\"zzz\",\"alamat_ayah\":\"zzz\",\"nama_ibu\":\"Cholifah Murtiningsih\",\"pekerjaan_ibu\":\"zzz\",\"telepon_ibu\":\"zzz\",\"alamat_ibu\":\"zzz\",\"status_pendaftaran\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:21:37', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (27, 'Penempatan Siswa', 'Kesiswaan', 'Tambah', 'kelas_siswa', '14', 'KELAS 10', 'Menempatkan 3 siswa; dilewati 0', NULL, '{\"id_siswa\":[\"13\",\"1\",\"47\"]}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '11:22:34', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (28, 'Ubah Status Jenis Tagihan', 'Master Data', 'Ubah', 'tagihan_jenis', '2', 'KEG23685', 'Status menjadi Aktif', '{\"id\":\"2\",\"kode_jenis\":\"KEG23685\",\"nama_jenis\":\"Kegiatan Pilihan\",\"tipe_default\":\"Langsung\",\"dianggap_tunggakan\":\"Tidak\",\"status\":\"Nonaktif\",\"keterangan\":\"\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:34:51\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '12:49:56', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (29, 'Import Siswa', 'Master Data', 'Import', 'tagihan_import_siswa', '1', 'IMP/202608/00001', 'Import 1 siswa ke kelas KELAS 10', NULL, '{\"kode_import\":\"IMP\\/202608\\/00001\",\"nama_file\":\"preview_20260806125357_template_import_siswa.xlsx\",\"lokasi_file\":\"uploads\\/import_siswa\\/preview_20260806125357_template_import_siswa.xlsx\",\"id_periode\":91,\"periode\":\"2026\\/2027\",\"id_kelas_setting\":14,\"nama_kelas\":\"KELAS 10\",\"jumlah_data\":1,\"jumlah_berhasil\":0,\"jumlah_gagal\":0,\"status_import\":\"Diproses\",\"keterangan\":\"Import siswa dari template XLSX\",\"tanggal\":\"06-08-2026\",\"waktu\":\"12:54:29\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '12:54:29', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (30, 'Simpan Draft Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '1', 'TGH/202608/00001', 'Tagihan SPP Bulanan - 0 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":1,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":91,\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"nominal_default\":20000,\"model_tarif_bulanan\":\"Berbeda\",\"bulan_mulai\":7,\"tahun_mulai\":2026,\"bulan_selesai\":12,\"tahun_selesai\":2026,\"bulan_penagihan\":7,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"06-08-2026\",\"waktu\":\"13:07:02\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '13:07:02', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (31, 'Ubah Template WhatsApp', 'Pengaturan', 'Ubah', 'tagihan_template_whatsapp', '1', 'Template Utama', 'Template Bukti Pembayaran', '{\"id\":\"1\",\"jenis_template\":\"Bukti Pembayaran\",\"nama_template\":\"Template Utama\",\"isi_template\":\"Yth. Bapak\\/Ibu {nama_wali}, pembayaran {nama_siswa} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.\",\"status_default\":\"Ya\",\"status\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"11:02:04\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"jenis_template\":\"Bukti Pembayaran\",\"nama_template\":\"Template Utama\",\"isi_template\":\"Yth. Bapak\\/Ibu {nama_wali}, pembayaran {nama_siswa} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.\",\"status_default\":\"Ya\",\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '13:14:07', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (32, 'Ubah Template WhatsApp', 'Pengaturan', 'Ubah', 'tagihan_template_whatsapp', '1', 'Template Utama', 'Template Bukti Pembayaran', '{\"id\":\"1\",\"jenis_template\":\"Bukti Pembayaran\",\"nama_template\":\"Template Utama\",\"isi_template\":\"Yth. Bapak\\/Ibu {nama_wali}, pembayaran {nama_siswa} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.\",\"status_default\":\"Ya\",\"status\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"11:02:04\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"jenis_template\":\"Bukti Pembayaran\",\"nama_template\":\"Template Utama\",\"isi_template\":\"Yth. Bapak\\/Ibu {nama_wali}, pembayaran {nama_siswa} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.\",\"status_default\":\"Tidak\",\"status\":\"Tidak Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '13:14:17', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (33, 'Jadikan Template Default', 'Pengaturan', 'Ubah', 'tagihan_template_whatsapp', '1', 'Template Utama', 'Template default Bukti Pembayaran', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '13:14:26', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (34, 'Import Siswa', 'Master Data', 'Import', 'tagihan_import_siswa', '2', 'IMP/202608/00002', 'Import 14 siswa ke kelas KELAS 10', NULL, '{\"kode_import\":\"IMP\\/202608\\/00002\",\"nama_file\":\"preview_20260806133619_template_import_siswa__1_.xlsx\",\"lokasi_file\":\"uploads\\/import_siswa\\/preview_20260806133619_template_import_siswa__1_.xlsx\",\"id_periode\":91,\"periode\":\"2026\\/2027\",\"id_kelas_setting\":14,\"nama_kelas\":\"KELAS 10\",\"jumlah_data\":14,\"jumlah_berhasil\":0,\"jumlah_gagal\":0,\"status_import\":\"Diproses\",\"keterangan\":\"Import siswa dari template XLSX\",\"tanggal\":\"06-08-2026\",\"waktu\":\"13:36:30\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '13:36:30', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (35, 'Ubah Status Metode', 'Master Data', 'Ubah', 'tagihan_metode_pembayaran', '1', 'TUNAI', 'Status menjadi Aktif', '{\"id\":\"1\",\"kode_metode\":\"TUNAI\",\"nama_metode\":\"Tunai\",\"jenis_metode\":\"Tunai\",\"butuh_uang_diterima\":\"Ya\",\"status\":\"Nonaktif\",\"urutan\":\"1\",\"keterangan\":\"Pembayaran tunai\",\"tanggal\":\"06-08-2026\",\"waktu\":\"10:45:48\",\"id_user\":\"0\",\"nama_user\":\"Administrator\"}', '{\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '13:36:42', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (36, 'Terbitkan Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '1', 'TGH/202608/00001', '108 tagihan diterbitkan', '{\"id\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"nominal_default\":\"20000.00\",\"model_tarif_bulanan\":\"Berbeda\",\"bulan_mulai\":\"7\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"12\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"7\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"06-08-2026\",\"waktu\":\"13:07:02\",\"id_user\":\"0\",\"nama_user\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '14:23:20', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (37, 'Keluarkan Siswa Pembayar', 'Tagihan', 'Batal', 'tagihan_siswa', '48', 'TGH/202608/00001', 'Mengeluarkan siswa yang belum membayar', '[{\"id\":\"19\",\"no_tagihan\":\"TAG\\/202608\\/00019\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"7\",\"nama_bulan\":\"Juli\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":\"\",\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:23:20\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"20\",\"no_tagihan\":\"TAG\\/202608\\/00020\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"8\",\"nama_bulan\":\"Agustus\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":\"\",\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:23:20\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"21\",\"no_tagihan\":\"TAG\\/202608\\/00021\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"9\",\"nama_bulan\":\"September\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":\"\",\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:23:20\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"22\",\"no_tagihan\":\"TAG\\/202608\\/00022\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"10\",\"nama_bulan\":\"Oktober\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":\"\",\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:23:20\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"23\",\"no_tagihan\":\"TAG\\/202608\\/00023\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"11\",\"nama_bulan\":\"November\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":\"\",\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:23:20\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"24\",\"no_tagihan\":\"TAG\\/202608\\/00024\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"12\",\"nama_bulan\":\"Desember\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":\"\",\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:23:20\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null}]', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '14:26:28', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (38, 'Tambah Siswa Pembayar', 'Tagihan', 'Tambah', 'tagihan_siswa', '1', 'TGH/202608/00001', '6 baris tagihan ditambahkan', NULL, '{\"siswa\":[\"48\"]}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '14:26:38', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (39, 'Keluarkan Siswa Pembayar', 'Tagihan', 'Batal', 'tagihan_siswa', '48', 'TGH/202608/00001', 'Mengeluarkan siswa yang belum membayar', '[{\"id\":\"109\",\"no_tagihan\":\"TAG\\/202608\\/00109\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"7\",\"nama_bulan\":\"Juli\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":null,\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:26:38\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"110\",\"no_tagihan\":\"TAG\\/202608\\/00110\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"8\",\"nama_bulan\":\"Agustus\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":null,\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:26:38\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"111\",\"no_tagihan\":\"TAG\\/202608\\/00111\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"9\",\"nama_bulan\":\"September\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":null,\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:26:38\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"112\",\"no_tagihan\":\"TAG\\/202608\\/00112\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"10\",\"nama_bulan\":\"Oktober\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":null,\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:26:38\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"113\",\"no_tagihan\":\"TAG\\/202608\\/00113\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"11\",\"nama_bulan\":\"November\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":null,\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:26:38\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null},{\"id\":\"114\",\"no_tagihan\":\"TAG\\/202608\\/00114\",\"id_tagihan_master\":\"1\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"1\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"91\",\"periode\":\"2026\\/2027\",\"semester\":\"Genap\",\"bulan\":\"12\",\"nama_bulan\":\"Desember\",\"tahun\":\"2026\",\"tanggal_jatuh_tempo\":\"\",\"id_siswa\":\"48\",\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":\"14\",\"id_kelas\":\"1\",\"nama_kelas\":\"KELAS 10\",\"nominal_awal\":\"20000.00\",\"jenis_keringanan\":null,\"nilai_keringanan\":\"0.00\",\"nominal_tagihan\":\"20000.00\",\"nominal_dibayar\":\"0.00\",\"sisa_tagihan\":\"20000.00\",\"dianggap_tunggakan\":\"Ya\",\"status_pembayaran\":\"Belum Dibayar\",\"status_tagihan\":\"Aktif\",\"keterangan\":null,\"tanggal_generate\":\"06-08-2026\",\"waktu_generate\":\"14:26:38\",\"id_user_generate\":\"0\",\"nama_user_generate\":\"Administrator\",\"tanggal_update\":null,\"waktu_update\":null}]', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '14:26:41', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (40, 'Tambah Siswa Pembayar', 'Tagihan', 'Tambah', 'tagihan_siswa', '1', 'TGH/202608/00001', '6 baris tagihan ditambahkan', NULL, '{\"siswa\":[\"48\"]}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '14:26:44', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (41, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '1', 'BYR/202608/00001', 'Pembayaran Zaks Prian sebesar Rp20.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00001\",\"tanggal_transaksi\":\"06-08-2026\",\"waktu_transaksi\":\"14:40:22\",\"id_siswa\":47,\"nis\":\"25100B019\",\"nisn\":\"24202607\",\"nama_siswa\":\"Zaks Prian\",\"id_kelas_setting\":14,\"id_kelas\":1,\"nama_kelas\":\"KELAS 10\",\"id_periode\":91,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":20000,\"total_potongan\":0,\"total_pembayaran\":20000,\"id_metode_pembayaran\":1,\"nama_metode_pembayaran\":\"Tunai\",\"uang_diterima\":50000,\"kembalian\":30000,\"referensi_pembayaran\":\"\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"SPP bulanan\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '14:40:22', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (42, 'Cetak Ulang Bukti', 'Transaksi', 'Cetak', 'tagihan_pembayaran', '1', 'BYR/202608/00001', 'Bukti pembayaran dicetak/disimpan PDF.', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '14:41:09', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (43, 'Cetak Ulang Bukti', 'Transaksi', 'Cetak', 'tagihan_pembayaran', '1', 'BYR/202608/00001', 'Bukti pembayaran dicetak/disimpan PDF.', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '14:41:56', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (44, 'Buat Surat Tunggakan', 'Tunggakan', 'Tambah', 'tagihan_surat_tunggakan', '1', 'STG/202608/00001', 'Surat Abdillah Chatam sebesar Rp40.000', NULL, '{\"no_surat\":\"STG\\/202608\\/00001\",\"tanggal_surat\":\"06-08-2026\",\"id_siswa\":48,\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":14,\"id_kelas\":1,\"nama_kelas\":\"KELAS 10\",\"id_periode\":91,\"periode\":\"2026\\/2027\",\"batas_bulan\":8,\"batas_tahun\":2026,\"total_tunggakan\":40000,\"jumlah_tagihan\":2,\"nama_penandatangan\":\"Bendahara Sekolah\",\"jabatan_penandatangan\":\"Bendahara\",\"catatan_surat\":\"Silahkan untuk dilunasi\",\"status_cetak\":\"Belum\",\"status_kirim_whatsapp\":\"Belum\",\"status_surat\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"15:40:07\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '15:40:07', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (45, 'Buat Surat Tunggakan', 'Tunggakan', 'Tambah', 'tagihan_surat_tunggakan', '2', 'STG/202608/00002', 'Surat Abdillah Chatam sebesar Rp40.000', NULL, '{\"no_surat\":\"STG\\/202608\\/00002\",\"tanggal_surat\":\"06-08-2026\",\"id_siswa\":48,\"nis\":\"1012526\",\"nisn\":\"0099999999\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":14,\"id_kelas\":1,\"nama_kelas\":\"KELAS 10\",\"id_periode\":91,\"periode\":\"2026\\/2027\",\"batas_bulan\":8,\"batas_tahun\":2026,\"total_tunggakan\":40000,\"jumlah_tagihan\":2,\"nama_penandatangan\":\"Bendahara Sekolah\",\"jabatan_penandatangan\":\"Bendahara\",\"catatan_surat\":\"Silahkan untuk dilunasi\",\"status_cetak\":\"Belum\",\"status_kirim_whatsapp\":\"Belum\",\"status_surat\":\"Aktif\",\"tanggal\":\"06-08-2026\",\"waktu\":\"15:40:28\",\"id_user\":0,\"nama_user\":\"Administrator\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '15:40:28', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (46, 'Kirim Surat Tunggakan WhatsApp', 'Tunggakan', 'Kirim', 'tagihan_surat_tunggakan', '1', 'STG/202608/00001', 'Surat disiapkan ke 6282332066465', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '15:41:00', 0, 'Administrator');
INSERT INTO `tagihan_log_aktivitas` VALUES (47, 'Cetak Ulang Bukti', 'Transaksi', 'Cetak', 'tagihan_pembayaran', '1', 'BYR/202608/00001', 'Bukti pembayaran dicetak/disimpan PDF.', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '06-08-2026', '17:00:35', 0, 'Administrator');

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
-- Records of tagihan_log_export
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_master
-- ----------------------------
INSERT INTO `tagihan_master` VALUES (1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 20000.00, 'Berbeda', 7, 2026, 12, 2026, 7, 2026, '', 'Kelas', 'Ya', 'Selesai', 'Aktif', '', '06-08-2026', '13:07:02', 0, 'Administrator', '06-08-2026', '14:23:20', 0, 'Administrator');

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
-- Records of tagihan_metode_pembayaran
-- ----------------------------
INSERT INTO `tagihan_metode_pembayaran` VALUES (1, 'TUNAI', 'Tunai', 'Tunai', 'Ya', 'Aktif', 1, 'Pembayaran tunai', '06-08-2026', '13:36:42', 0, 'Administrator');
INSERT INTO `tagihan_metode_pembayaran` VALUES (2, 'TRANSFER', 'Transfer Bank', 'Transfer', 'Tidak', 'Aktif', 2, 'Pembayaran melalui transfer bank', '06-08-2026', '10:45:56', 0, 'Administrator');
INSERT INTO `tagihan_metode_pembayaran` VALUES (3, 'QRIS', 'QRIS', 'QRIS', 'Tidak', 'Aktif', 3, 'Pembayaran melalui QRIS', NULL, NULL, 0, NULL);

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
-- Records of tagihan_pembatalan_transaksi
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_pembayaran
-- ----------------------------
INSERT INTO `tagihan_pembayaran` VALUES (1, 'BYR/202608/00001', '06-08-2026', '14:40:22', 47, '25100B019', '24202607', 'Zaks Prian', 14, 1, 'KELAS 10', 91, '2026/2027', 20000.00, 0.00, 20000.00, 1, 'Tunai', 50000.00, 30000.00, '', 'Aktif', 'Sudah', 3, 'Belum', 'SPP bulanan', 0, 'Administrator');

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_pembayaran_detail
-- ----------------------------
INSERT INTO `tagihan_pembayaran_detail` VALUES (1, 1, 'BYR/202608/00001', 13, 'TAG/202608/00013', 1, 'Tagihan SPP Bulanan', 'Bulanan', 7, 'Juli', 2026, 20000.00, 0.00, 20000.00, 20000.00, 0.00, 'Lunas', 'Aktif', '06-08-2026', '14:40:22');

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_pengaturan_cetak
-- ----------------------------
INSERT INTO `tagihan_pengaturan_cetak` VALUES (1, 'Kartu Pembayaran', 'Kartu Pembayaran Sekolah', 'Ya', 'Custom', 'Portrait', '210', '148', '', '', '', '', 'Ya', '', 'Sekolah', '', '', '', '', '', 'Ya', 'Ya', 'Ya', 'Ya', '', '', 'Kanan', '{\"jumlah_baris\":12,\"jarak_baris\":8,\"posisi_x\":10,\"posisi_y\":10,\"lebar_tanggal\":25,\"lebar_jenis\":70,\"lebar_nominal\":35,\"lebar_petugas\":20,\"kolom\":[\"Tanggal\",\"Jenis/Bulan\",\"Nominal\",\"Petugas\"]}', 'Aktif', '06-08-2026', '11:04:14', 0, 'Administrator');

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
-- Records of tagihan_pengaturan_umum
-- ----------------------------
INSERT INTO `tagihan_pengaturan_umum` VALUES (1, 'FORMAT_NO_TRANSAKSI', 'Format Nomor Transaksi', 'BYR/{YYYY}{MM}/{URUT5}', 'Contoh: BYR/202608/00001', 'Aktif', NULL, NULL, 0, NULL);
INSERT INTO `tagihan_pengaturan_umum` VALUES (2, 'FORMAT_NO_TAGIHAN', 'Format Nomor Tagihan', 'TAG/{YYYY}/{URUT6}', 'Contoh: TAG/2026/000001', 'Aktif', NULL, NULL, 0, NULL);
INSERT INTO `tagihan_pengaturan_umum` VALUES (3, 'IZINKAN_KELEBIHAN_BAYAR', 'Izinkan Pembayaran Melebihi Sisa', 'Tidak', 'Ya/Tidak', 'Aktif', NULL, NULL, 0, NULL);
INSERT INTO `tagihan_pengaturan_umum` VALUES (4, 'CETAK_LANGSUNG', 'Cetak Bukti Setelah Transaksi', 'Tidak', 'Ya/Tidak', 'Aktif', NULL, NULL, 0, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_riwayat_kelas_siswa
-- ----------------------------
INSERT INTO `tagihan_riwayat_kelas_siswa` VALUES (1, 13, '0001/001.126', '3084750785', 'ACHMAD DAFFA  ZULKARNAIN', 0, 0, NULL, 0, NULL, NULL, 14, 1, 'KELAS 10', 91, '2026/2027', 'Genap', 'Penempatan', 'Belum Ditempatkan', 'Aktif', NULL, '06-08-2026', '11:22:34', 0, 'Administrator', 'Aktif', NULL, NULL, 0, NULL, NULL);
INSERT INTO `tagihan_riwayat_kelas_siswa` VALUES (2, 1, '0001/017.126', '0098826829', 'ADISKA REYFANO', 0, 0, NULL, 0, NULL, NULL, 14, 1, 'KELAS 10', 91, '2026/2027', 'Genap', 'Penempatan', 'Belum Ditempatkan', 'Aktif', NULL, '06-08-2026', '11:22:34', 0, 'Administrator', 'Aktif', NULL, NULL, 0, NULL, NULL);
INSERT INTO `tagihan_riwayat_kelas_siswa` VALUES (3, 47, '25100B019', '24202607', 'Zaks Prian', 0, 0, NULL, 0, NULL, NULL, 14, 1, 'KELAS 10', 91, '2026/2027', 'Genap', 'Penempatan', 'Belum Ditempatkan', 'Aktif', NULL, '06-08-2026', '11:22:34', 0, 'Administrator', 'Aktif', NULL, NULL, 0, NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_riwayat_whatsapp
-- ----------------------------
INSERT INTO `tagihan_riwayat_whatsapp` VALUES (1, 'Surat Tunggakan', 1, 'STG/202608/00001', 48, 'Abdillah Chatam', 'Chatam', 'Ayah', '6282332066465', 'Yth. Bapak/Ibu wali Abdillah Chatam, berikut kami sampaikan surat pemberitahuan tunggakan sebesar Rp40.000. Terima kasih.', NULL, 'Tautan', 'Disiapkan', NULL, '06-08-2026', '15:41:00', 0, 'Administrator');

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
) ENGINE = InnoDB AUTO_INCREMENT = 121 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_siswa
-- ----------------------------
INSERT INTO `tagihan_siswa` VALUES (1, 'TAG/202608/00001', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 13, '0001/001.126', '3084750785', 'ACHMAD DAFFA  ZULKARNAIN', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (2, 'TAG/202608/00002', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 13, '0001/001.126', '3084750785', 'ACHMAD DAFFA  ZULKARNAIN', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (3, 'TAG/202608/00003', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 13, '0001/001.126', '3084750785', 'ACHMAD DAFFA  ZULKARNAIN', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (4, 'TAG/202608/00004', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 13, '0001/001.126', '3084750785', 'ACHMAD DAFFA  ZULKARNAIN', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (5, 'TAG/202608/00005', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 13, '0001/001.126', '3084750785', 'ACHMAD DAFFA  ZULKARNAIN', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (6, 'TAG/202608/00006', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 13, '0001/001.126', '3084750785', 'ACHMAD DAFFA  ZULKARNAIN', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (7, 'TAG/202608/00007', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 1, '0001/017.126', '0098826829', 'ADISKA REYFANO', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (8, 'TAG/202608/00008', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 1, '0001/017.126', '0098826829', 'ADISKA REYFANO', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (9, 'TAG/202608/00009', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 1, '0001/017.126', '0098826829', 'ADISKA REYFANO', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (10, 'TAG/202608/00010', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 1, '0001/017.126', '0098826829', 'ADISKA REYFANO', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (11, 'TAG/202608/00011', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 1, '0001/017.126', '0098826829', 'ADISKA REYFANO', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (12, 'TAG/202608/00012', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 1, '0001/017.126', '0098826829', 'ADISKA REYFANO', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (13, 'TAG/202608/00013', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 47, '25100B019', '24202607', 'Zaks Prian', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 20000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', '06-08-2026', '14:40:22');
INSERT INTO `tagihan_siswa` VALUES (14, 'TAG/202608/00014', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 47, '25100B019', '24202607', 'Zaks Prian', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (15, 'TAG/202608/00015', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 47, '25100B019', '24202607', 'Zaks Prian', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (16, 'TAG/202608/00016', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 47, '25100B019', '24202607', 'Zaks Prian', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (17, 'TAG/202608/00017', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 47, '25100B019', '24202607', 'Zaks Prian', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (18, 'TAG/202608/00018', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 47, '25100B019', '24202607', 'Zaks Prian', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (25, 'TAG/202608/00025', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 49, '15012627', '0199999999', 'Abdurrahman Al Hafiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (26, 'TAG/202608/00026', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 49, '15012627', '0199999999', 'Abdurrahman Al Hafiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (27, 'TAG/202608/00027', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 49, '15012627', '0199999999', 'Abdurrahman Al Hafiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (28, 'TAG/202608/00028', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 49, '15012627', '0199999999', 'Abdurrahman Al Hafiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (29, 'TAG/202608/00029', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 49, '15012627', '0199999999', 'Abdurrahman Al Hafiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (30, 'TAG/202608/00030', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 49, '15012627', '0199999999', 'Abdurrahman Al Hafiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (31, 'TAG/202608/00031', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 50, '16012627', '0100000000', 'Ahmad Zhafir', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (32, 'TAG/202608/00032', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 50, '16012627', '0100000000', 'Ahmad Zhafir', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (33, 'TAG/202608/00033', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 50, '16012627', '0100000000', 'Ahmad Zhafir', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (34, 'TAG/202608/00034', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 50, '16012627', '0100000000', 'Ahmad Zhafir', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (35, 'TAG/202608/00035', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 50, '16012627', '0100000000', 'Ahmad Zhafir', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (36, 'TAG/202608/00036', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 50, '16012627', '0100000000', 'Ahmad Zhafir', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (37, 'TAG/202608/00037', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 51, '17022627', '0100000001', 'Amirah Izdihar Faiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (38, 'TAG/202608/00038', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 51, '17022627', '0100000001', 'Amirah Izdihar Faiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (39, 'TAG/202608/00039', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 51, '17022627', '0100000001', 'Amirah Izdihar Faiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (40, 'TAG/202608/00040', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 51, '17022627', '0100000001', 'Amirah Izdihar Faiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (41, 'TAG/202608/00041', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 51, '17022627', '0100000001', 'Amirah Izdihar Faiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (42, 'TAG/202608/00042', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 51, '17022627', '0100000001', 'Amirah Izdihar Faiz', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (43, 'TAG/202608/00043', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 52, '18022627', '0100000002', 'Asma\' Albani', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (44, 'TAG/202608/00044', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 52, '18022627', '0100000002', 'Asma\' Albani', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (45, 'TAG/202608/00045', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 52, '18022627', '0100000002', 'Asma\' Albani', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (46, 'TAG/202608/00046', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 52, '18022627', '0100000002', 'Asma\' Albani', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (47, 'TAG/202608/00047', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 52, '18022627', '0100000002', 'Asma\' Albani', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (48, 'TAG/202608/00048', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 52, '18022627', '0100000002', 'Asma\' Albani', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (49, 'TAG/202608/00049', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 53, '19022627', '0100000003', 'Aysha Salma Salsabila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (50, 'TAG/202608/00050', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 53, '19022627', '0100000003', 'Aysha Salma Salsabila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (51, 'TAG/202608/00051', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 53, '19022627', '0100000003', 'Aysha Salma Salsabila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (52, 'TAG/202608/00052', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 53, '19022627', '0100000003', 'Aysha Salma Salsabila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (53, 'TAG/202608/00053', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 53, '19022627', '0100000003', 'Aysha Salma Salsabila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (54, 'TAG/202608/00054', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 53, '19022627', '0100000003', 'Aysha Salma Salsabila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (55, 'TAG/202608/00055', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 54, '20022627', '0100000004', 'Azkia Ramadhani Setiawan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (56, 'TAG/202608/00056', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 54, '20022627', '0100000004', 'Azkia Ramadhani Setiawan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (57, 'TAG/202608/00057', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 54, '20022627', '0100000004', 'Azkia Ramadhani Setiawan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (58, 'TAG/202608/00058', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 54, '20022627', '0100000004', 'Azkia Ramadhani Setiawan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (59, 'TAG/202608/00059', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 54, '20022627', '0100000004', 'Azkia Ramadhani Setiawan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (60, 'TAG/202608/00060', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 54, '20022627', '0100000004', 'Azkia Ramadhani Setiawan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (61, 'TAG/202608/00061', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 55, '21022627', '0100000005', 'Khaulah chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (62, 'TAG/202608/00062', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 55, '21022627', '0100000005', 'Khaulah chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (63, 'TAG/202608/00063', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 55, '21022627', '0100000005', 'Khaulah chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (64, 'TAG/202608/00064', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 55, '21022627', '0100000005', 'Khaulah chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (65, 'TAG/202608/00065', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 55, '21022627', '0100000005', 'Khaulah chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (66, 'TAG/202608/00066', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 55, '21022627', '0100000005', 'Khaulah chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (67, 'TAG/202608/00067', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 56, '22022627', '0100000006', 'Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (68, 'TAG/202608/00068', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 56, '22022627', '0100000006', 'Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (69, 'TAG/202608/00069', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 56, '22022627', '0100000006', 'Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (70, 'TAG/202608/00070', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 56, '22022627', '0100000006', 'Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (71, 'TAG/202608/00071', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 56, '22022627', '0100000006', 'Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (72, 'TAG/202608/00072', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 56, '22022627', '0100000006', 'Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (73, 'TAG/202608/00073', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 57, '23012627', '0100000007', 'Muhammad Ibrahim Al Fatih', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (74, 'TAG/202608/00074', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 57, '23012627', '0100000007', 'Muhammad Ibrahim Al Fatih', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (75, 'TAG/202608/00075', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 57, '23012627', '0100000007', 'Muhammad Ibrahim Al Fatih', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (76, 'TAG/202608/00076', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 57, '23012627', '0100000007', 'Muhammad Ibrahim Al Fatih', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (77, 'TAG/202608/00077', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 57, '23012627', '0100000007', 'Muhammad Ibrahim Al Fatih', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (78, 'TAG/202608/00078', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 57, '23012627', '0100000007', 'Muhammad Ibrahim Al Fatih', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (79, 'TAG/202608/00079', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 58, '24012627', '0100000008', 'Muhammad Yusuf', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (80, 'TAG/202608/00080', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 58, '24012627', '0100000008', 'Muhammad Yusuf', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (81, 'TAG/202608/00081', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 58, '24012627', '0100000008', 'Muhammad Yusuf', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (82, 'TAG/202608/00082', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 58, '24012627', '0100000008', 'Muhammad Yusuf', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (83, 'TAG/202608/00083', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 58, '24012627', '0100000008', 'Muhammad Yusuf', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (84, 'TAG/202608/00084', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 58, '24012627', '0100000008', 'Muhammad Yusuf', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (85, 'TAG/202608/00085', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 59, '25022627', '0100000009', 'Nafisha Jihan Arsyila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (86, 'TAG/202608/00086', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 59, '25022627', '0100000009', 'Nafisha Jihan Arsyila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (87, 'TAG/202608/00087', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 59, '25022627', '0100000009', 'Nafisha Jihan Arsyila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (88, 'TAG/202608/00088', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 59, '25022627', '0100000009', 'Nafisha Jihan Arsyila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (89, 'TAG/202608/00089', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 59, '25022627', '0100000009', 'Nafisha Jihan Arsyila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (90, 'TAG/202608/00090', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 59, '25022627', '0100000009', 'Nafisha Jihan Arsyila', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (91, 'TAG/202608/00091', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 60, '26022627', '0100000010', 'Nusaibah Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (92, 'TAG/202608/00092', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 60, '26022627', '0100000010', 'Nusaibah Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (93, 'TAG/202608/00093', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 60, '26022627', '0100000010', 'Nusaibah Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (94, 'TAG/202608/00094', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 60, '26022627', '0100000010', 'Nusaibah Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (95, 'TAG/202608/00095', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 60, '26022627', '0100000010', 'Nusaibah Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (96, 'TAG/202608/00096', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 60, '26022627', '0100000010', 'Nusaibah Maryam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (97, 'TAG/202608/00097', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 61, '27022627', '0100000011', 'RUMAYSHA ABIDAH', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (98, 'TAG/202608/00098', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 61, '27022627', '0100000011', 'RUMAYSHA ABIDAH', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (99, 'TAG/202608/00099', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 61, '27022627', '0100000011', 'RUMAYSHA ABIDAH', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (100, 'TAG/202608/00100', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 61, '27022627', '0100000011', 'RUMAYSHA ABIDAH', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (101, 'TAG/202608/00101', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 61, '27022627', '0100000011', 'RUMAYSHA ABIDAH', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (102, 'TAG/202608/00102', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 61, '27022627', '0100000011', 'RUMAYSHA ABIDAH', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (103, 'TAG/202608/00103', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 62, '28012627', '0100000012', 'Sabiqul Haqqi Abadan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (104, 'TAG/202608/00104', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 62, '28012627', '0100000012', 'Sabiqul Haqqi Abadan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (105, 'TAG/202608/00105', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 62, '28012627', '0100000012', 'Sabiqul Haqqi Abadan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (106, 'TAG/202608/00106', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 62, '28012627', '0100000012', 'Sabiqul Haqqi Abadan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (107, 'TAG/202608/00107', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 62, '28012627', '0100000012', 'Sabiqul Haqqi Abadan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (108, 'TAG/202608/00108', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 62, '28012627', '0100000012', 'Sabiqul Haqqi Abadan', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '06-08-2026', '14:23:20', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (115, 'TAG/202608/00109', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 7, 'Juli', 2026, '', 48, '1012526', '0099999999', 'Abdillah Chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', NULL, '06-08-2026', '14:26:44', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (116, 'TAG/202608/00110', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 8, 'Agustus', 2026, '', 48, '1012526', '0099999999', 'Abdillah Chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', NULL, '06-08-2026', '14:26:44', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (117, 'TAG/202608/00111', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 9, 'September', 2026, '', 48, '1012526', '0099999999', 'Abdillah Chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', NULL, '06-08-2026', '14:26:44', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (118, 'TAG/202608/00112', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 10, 'Oktober', 2026, '', 48, '1012526', '0099999999', 'Abdillah Chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', NULL, '06-08-2026', '14:26:44', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (119, 'TAG/202608/00113', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 11, 'November', 2026, '', 48, '1012526', '0099999999', 'Abdillah Chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', NULL, '06-08-2026', '14:26:44', 0, 'Administrator', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (120, 'TAG/202608/00114', 1, 'TGH/202608/00001', 1, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 91, '2026/2027', 'Genap', 12, 'Desember', 2026, '', 48, '1012526', '0099999999', 'Abdillah Chatam', 14, 1, 'KELAS 10', 20000.00, NULL, 0.00, 20000.00, 0.00, 20000.00, 'Ya', 'Belum Dibayar', 'Aktif', NULL, '06-08-2026', '14:26:44', 0, 'Administrator', NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_surat_tunggakan
-- ----------------------------
INSERT INTO `tagihan_surat_tunggakan` VALUES (1, 'STG/202608/00001', '06-08-2026', 48, '1012526', '0099999999', 'Abdillah Chatam', 14, 1, 'KELAS 10', 91, '2026/2027', 8, 2026, 40000.00, 2, 'Bendahara Sekolah', 'Bendahara', 'Silahkan untuk dilunasi', NULL, 'Belum', 'Disiapkan', 'Aktif', '06-08-2026', '15:40:07', 0, 'Administrator');
INSERT INTO `tagihan_surat_tunggakan` VALUES (2, 'STG/202608/00002', '06-08-2026', 48, '1012526', '0099999999', 'Abdillah Chatam', 14, 1, 'KELAS 10', 91, '2026/2027', 8, 2026, 40000.00, 2, 'Bendahara Sekolah', 'Bendahara', 'Silahkan untuk dilunasi', NULL, 'Belum', 'Belum', 'Aktif', '06-08-2026', '15:40:28', 0, 'Administrator');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_surat_tunggakan_detail
-- ----------------------------
INSERT INTO `tagihan_surat_tunggakan_detail` VALUES (1, 1, 'STG/202608/00001', 115, 'TAG/202608/00109', 'Tagihan SPP Bulanan', 7, 'Juli', 2026, 20000.00, 0.00, 20000.00);
INSERT INTO `tagihan_surat_tunggakan_detail` VALUES (2, 1, 'STG/202608/00001', 116, 'TAG/202608/00110', 'Tagihan SPP Bulanan', 8, 'Agustus', 2026, 20000.00, 0.00, 20000.00);
INSERT INTO `tagihan_surat_tunggakan_detail` VALUES (3, 2, 'STG/202608/00002', 115, 'TAG/202608/00109', 'Tagihan SPP Bulanan', 7, 'Juli', 2026, 20000.00, 0.00, 20000.00);
INSERT INTO `tagihan_surat_tunggakan_detail` VALUES (4, 2, 'STG/202608/00002', 116, 'TAG/202608/00110', 'Tagihan SPP Bulanan', 8, 'Agustus', 2026, 20000.00, 0.00, 20000.00);

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_target_kelas
-- ----------------------------
INSERT INTO `tagihan_target_kelas` VALUES (1, 1, 14, 1, 'KELAS 10', 91, '2026/2027', 'Genap', 20000.00, 'Aktif', '06-08-2026', '13:07:02', 0, 'Administrator');

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
-- Records of tagihan_target_siswa
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_tarif_bulan
-- ----------------------------
INSERT INTO `tagihan_tarif_bulan` VALUES (1, 1, 7, 'Juli', 2026, 20000.00, '', 'Aktif', '06-08-2026', '13:07:02', 0, 'Administrator');
INSERT INTO `tagihan_tarif_bulan` VALUES (2, 1, 8, 'Agustus', 2026, 20000.00, '', 'Aktif', '06-08-2026', '13:07:02', 0, 'Administrator');
INSERT INTO `tagihan_tarif_bulan` VALUES (3, 1, 9, 'September', 2026, 20000.00, '', 'Aktif', '06-08-2026', '13:07:02', 0, 'Administrator');
INSERT INTO `tagihan_tarif_bulan` VALUES (4, 1, 10, 'Oktober', 2026, 20000.00, '', 'Aktif', '06-08-2026', '13:07:02', 0, 'Administrator');
INSERT INTO `tagihan_tarif_bulan` VALUES (5, 1, 11, 'November', 2026, 20000.00, '', 'Aktif', '06-08-2026', '13:07:02', 0, 'Administrator');
INSERT INTO `tagihan_tarif_bulan` VALUES (6, 1, 12, 'Desember', 2026, 20000.00, '', 'Aktif', '06-08-2026', '13:07:02', 0, 'Administrator');

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
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_template_whatsapp
-- ----------------------------
INSERT INTO `tagihan_template_whatsapp` VALUES (1, 'Bukti Pembayaran', 'Template Utama', 'Yth. Bapak/Ibu {nama_wali}, pembayaran {nama_siswa} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.', 'Ya', 'Aktif', '06-08-2026', '11:02:04', 0, 'Administrator');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_pegawai` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (17, 'admin', 'admin', '$2a$12$Bh53GmN6dogR9OnfVt30xuOzUBZNVBRMAybJDICugMIESB0y36I4u', 'admin123', '1', '', NULL);

SET FOREIGN_KEY_CHECKS = 1;
