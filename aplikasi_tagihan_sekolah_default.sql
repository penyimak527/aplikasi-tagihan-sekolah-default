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

 Date: 06/08/2026 10:54:21
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kelas_siswa
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
) ENGINE = InnoDB AUTO_INCREMENT = 47 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of siswa
-- ----------------------------
INSERT INTO `siswa` VALUES (1, '0', '0098826829', '0001/017.126', 'ADISKA REYFANO', 'Laki - Laki', 'Lumajang', '13-05-2009', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Dusun Kembangan, RT. 9 RW. 5, Desa/Kel. Kaliwungu, Kec. Tempeh, 67371', 'Sukarto', 'Karyawan Swasta', '', 'djjd', '56', 'Iswati', 'Karyawan Swasta', '78', 'wwd', '56', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (2, '0', '0087264530', '0002/018.126', 'AGIS DANIAL SYAIFURRIDJAL', 'Laki - Laki', 'Lumajang', '07-10-2008', '06-07-2024', '', 'Offline', '3', 'ryoyuwaraja', 'Jln. Raya Randuagung, RT. 1 RW. 15, Dusun Elosan, Kec. Randuagung, 67354', 'Minhatul Aidy', 'Wiraswasta', '', 'gg', '53', 'Afifah', 'Tidak bekerja', '11', 'zz', '66', NULL, 'ryoyuwaraja');
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
INSERT INTO `siswa` VALUES (13, '0', '3084750785', '0001/001.126', 'ACHMAD DAFFA  ZULKARNAIN', 'Laki - Laki', 'Lumajang', '10-10-2008', '17-07-2023', '', 'Offline', '1', NULL, 'Dsn Suco, RT. 3 RW. 22, Pasrujambe, Desa/Kel. Pasrujambe, Kec. Pasrujambe', 'Muhammad Wempi Zulkarnain', 'Wiraswasta', '', '', '', 'Nafiah', 'Wiraswasta', '', '', '', NULL, '3bd57');
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
INSERT INTO `siswa` VALUES (30, '0', '3092563798', '0002/030.126', 'AHMAD ZIDANE JOENIARSYAH', 'Laki - Laki', 'zzz', '22-06-2009', '14-07-2025', 'f4cf0b1018a4355baa8724f55a7ed45d.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'Cholifah Murtiningsih', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
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
INSERT INTO `siswa` VALUES (44, '0', '0094086382', '0001/029.126', 'AHMAD FIRMAN DIVANO', 'Laki - Laki', 'zzz', '08-05-2009', '07-07-2025', '9ab2c006e1d77b17926e9922d7560acf.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'zzz', 'MELDA FERA AGUSTINA	', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (45, '0', '0091889755', '0005/033.126', 'BIMA DWI WICAKSONO', 'Laki - Laki', 'zzz', '18-09-2009', '07-07-2025', '9306b3a3e26a3be883bc12d18fb03806.png', 'Offline', '90', 'ryoyuwaraja', 'zzz', 'FERRY LUKMAN WAHYUDI', 'ZZ', 'ZZZ', 'ZZZ', 'zzz', 'RUKAYAH', 'zzz', 'zzz', 'zzz', 'zzz', NULL, 'ryoyuwaraja');
INSERT INTO `siswa` VALUES (46, '0', '0096989087', '0010/043.126', 'NAVEED EL FATHIN KURNIAWAN', 'Laki - Laki', 'zzz', '10-10-2009', '07-07-2025', '80bdaf4981956ba51d3d623663f0a223.png', 'Offline', '90', 'ryoyuwaraja', 'ZZZ', 'NANDA KURNIAWAN', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', 'ZZZ', NULL, 'ryoyuwaraja');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_import_siswa
-- ----------------------------

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
-- Records of tagihan_import_siswa_detail
-- ----------------------------

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
INSERT INTO `tagihan_jenis` VALUES (2, 'KEG23685', 'Kegiatan Pilihan', 'Langsung', 'Tidak', 'Nonaktif', '', '06-08-2026', '10:34:51', 0, 'Administrator');

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
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_master
-- ----------------------------

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
INSERT INTO `tagihan_metode_pembayaran` VALUES (1, 'TUNAI', 'Tunai', 'Tunai', 'Ya', 'Nonaktif', 1, 'Pembayaran tunai', '06-08-2026', '10:45:48', 0, 'Administrator');
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_pembayaran
-- ----------------------------

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
-- Records of tagihan_pembayaran_detail
-- ----------------------------

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
-- Records of tagihan_pengaturan_cetak
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_riwayat_kelas_siswa
-- ----------------------------

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
-- Records of tagihan_riwayat_whatsapp
-- ----------------------------

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
-- Records of tagihan_siswa
-- ----------------------------

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
-- Records of tagihan_surat_tunggakan
-- ----------------------------

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
-- Records of tagihan_surat_tunggakan_detail
-- ----------------------------

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
-- Records of tagihan_target_kelas
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan_tarif_bulan
-- ----------------------------

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

-- ----------------------------
-- Records of tagihan_template_whatsapp
-- ----------------------------

SET FOREIGN_KEY_CHECKS = 1;
