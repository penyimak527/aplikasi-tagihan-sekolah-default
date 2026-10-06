/*
 Navicat Premium Data Transfer

 Source Server         : lokalku
 Source Server Type    : MySQL
 Source Server Version : 100424
 Source Host           : localhost:3306
 Source Schema         : aplikasi_tagihan_sekolah

 Target Server Type    : MySQL
 Target Server Version : 100424
 File Encoding         : 65001

 Date: 10/09/2026 13:47:00
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
) ENGINE = InnoDB AUTO_INCREMENT = 20 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `jabatan` VALUES (19, 'Wakil Kepala Sekolah');

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
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kelas
-- ----------------------------
INSERT INTO `kelas` VALUES (17, 'TK', 0, '', 'REGULER');
INSERT INTO `kelas` VALUES (18, 'Kelas 1', 0, '', 'REGULER');
INSERT INTO `kelas` VALUES (19, 'Kelas 2', 0, '', 'REGULER');
INSERT INTO `kelas` VALUES (20, 'Kelas 3', 0, '', 'REGULER');

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
) ENGINE = InnoDB AUTO_INCREMENT = 58 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kelas_setting
-- ----------------------------
INSERT INTO `kelas_setting` VALUES (48, '17', 'TK', NULL, NULL, '98', NULL);
INSERT INTO `kelas_setting` VALUES (49, '18', 'Kelas 1', NULL, NULL, '98', NULL);
INSERT INTO `kelas_setting` VALUES (50, '19', 'Kelas 2', NULL, NULL, '98', NULL);
INSERT INTO `kelas_setting` VALUES (51, '20', 'Kelas 3', NULL, NULL, '98', NULL);
INSERT INTO `kelas_setting` VALUES (52, '18', 'Kelas 1', NULL, NULL, '99', NULL);
INSERT INTO `kelas_setting` VALUES (53, '19', 'Kelas 2', NULL, NULL, '99', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 113 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of kelas_siswa
-- ----------------------------
INSERT INTO `kelas_siswa` VALUES (49, '48', '22', 'Hamzah Umair Hermawan', '00714743987', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (50, '48', '23', 'Abdullah Albani', '00714743988', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (51, '48', '24', 'Adam At-Tirmidzi', '00714743989', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (52, '48', '25', 'Aisyah Nayla Bilqis', '00714743990', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (53, '48', '26', 'Alsava Aghnia Mafaza', '00714743991', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (54, '48', '27', 'Ayyub', '00714743992', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (55, '48', '28', 'Hanna Azalea Wahyu Firmawan', '00714743993', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (56, '48', '29', 'Oryza Amiirah Hasan', '00714743994', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (57, '48', '30', 'Rey Altezza Prabowo', '00714743995', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (58, '48', '31', 'Said', '00714743996', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (59, '48', '32', 'Yunus', '00714743997', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (60, '48', '33', 'Ziyad Abdullah Abqar Rafif', '00714743998', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (61, '49', '34', 'Abdurrahman Al Hafiz', '00712051513', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (62, '49', '35', 'Ahmad Zhafir', '00712051514', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (63, '49', '36', 'Amirah Izdihar Faiz', '00712051515', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (64, '49', '37', 'Asma\' Albani', '00712051516', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (65, '49', '38', 'Aysha Salma Salsabila', '00712051517', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (66, '49', '39', 'Azkia Ramadhani Setiawan', '00712051518', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (67, '49', '40', 'Khaulah chatam', '00712051519', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (68, '49', '41', 'Maryam', '00712051520', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (69, '49', '42', 'Muhammad Ibrahim Al Fatih', '00712051521', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (70, '49', '43', 'Muhammad Yusuf', '00712051522', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (71, '49', '44', 'Nafisha Jihan Arsyila', '00712051523', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (72, '49', '45', 'Nusaibah Maryam', '00712051524', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (73, '49', '46', 'RUMAYSHA ABIDAH', '00712051525', 'Perempuan', '0');
INSERT INTO `kelas_siswa` VALUES (74, '49', '47', 'Sabiqul Haqqi Abadan', '00712051526', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (75, '48', '21', 'Shafiyah Salsabila Izzuddin', '00714743986', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (76, '50', '48', 'Abdillah Chatam', '00723897520', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (77, '50', '49', 'Aisyah Qonitah Izzuddin', '00723897521', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (78, '50', '50', 'Ammar Hakami', '00723897522', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (79, '50', '51', 'Hamizan Umar Hermawan', '00723897523', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (80, '50', '52', 'Hisham Ali Hermawan', '00723897524', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (81, '50', '53', 'KHADIJAH', '00723897525', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (82, '50', '54', 'Laili Athiyyatuzzakiyah', '00723897526', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (83, '50', '55', 'Muhammad Uwais Ibadurrahman', '00723897527', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (84, '50', '56', 'Nesa Humaeyra Zulkarnain', '00723897528', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (85, '50', '57', 'SHAFIYYAH AZZAHRA', '00723897529', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (86, '50', '58', 'Zakaria Al Fatih', '00723897530', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (87, '50', '59', 'Hafshoh', '00723897531', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (88, '50', '60', 'Bilal', '00723897532', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (89, '50', '61', 'Muhammad Ibnu Abdillah', '00723897533', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (90, '48', '20', 'Affan Hakami', '0071353406', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (91, '49', '62', 'Muhammad Zakiprian', '00714725264', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (92, '52', '63', 'iqbal', '123', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (93, '53', '34', 'Abdurrahman Al Hafiz', '00712051513', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (94, '53', '35', 'Ahmad Zhafir', '00712051514', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (95, '53', '36', 'Amirah Izdihar Faiz', '00712051515', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (96, '53', '37', 'Asma\' Albani', '00712051516', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (97, '53', '38', 'Aysha Salma Salsabila', '00712051517', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (98, '53', '39', 'Azkia Ramadhani Setiawan', '00712051518', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (99, '53', '42', 'Muhammad Ibrahim Al Fatih', '00712051521', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (100, '53', '43', 'Muhammad Yusuf', '00712051522', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (101, '53', '62', 'Muhammad Zakiprian', '00714725264', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (102, '53', '44', 'Nafisha Jihan Arsyila', '00712051523', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (103, '53', '45', 'Nusaibah Maryam', '00712051524', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (104, '53', '46', 'RUMAYSHA ABIDAH', '00712051525', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (105, '53', '47', 'Sabiqul Haqqi Abadan', '00712051526', 'Laki-laki', '1');
INSERT INTO `kelas_siswa` VALUES (106, '51', '48', 'Abdillah Chatam', '00723897520', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (107, '52', '40', 'Khaulah chatam', '00712051519', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (108, '52', '41', 'Maryam', '00712051520', 'Perempuan', '1');
INSERT INTO `kelas_siswa` VALUES (109, '48', '48', 'Abdillah Chatam', '00723897520', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (110, '51', '48', 'Abdillah Chatam', '00723897520', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (111, '50', '48', 'Abdillah Chatam', '00723897520', 'Laki-laki', '0');
INSERT INTO `kelas_siswa` VALUES (112, '51', '48', 'Abdillah Chatam', '00723897520', 'Laki-laki', '1');

-- ----------------------------
-- Table structure for level
-- ----------------------------
DROP TABLE IF EXISTS `level`;
CREATE TABLE `level`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `level` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of level
-- ----------------------------
INSERT INTO `level` VALUES (1, 'Admin');
INSERT INTO `level` VALUES (3, 'Kepala Sekolah');
INSERT INTO `level` VALUES (4, 'Bendahara');

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
) ENGINE = InnoDB AUTO_INCREMENT = 213 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of list_menu
-- ----------------------------
INSERT INTO `list_menu` VALUES (1, 'dashboard', 'Dashboard', 'Dashboard', '1', '1');
INSERT INTO `list_menu` VALUES (2, 'admin/master_data/tahun_ajaran', 'Tahun Ajaran', 'Master Data', '1', '2');
INSERT INTO `list_menu` VALUES (3, 'admin/master_data/data_kelas', 'Kelas', 'Master Data', '1', '3');
INSERT INTO `list_menu` VALUES (4, 'admin/master_data/siswa', 'Siswa', 'Master Data', '1', '4');
INSERT INTO `list_menu` VALUES (5, 'admin/master_data/import_siswa', 'Import Siswa', 'Master Data', '1', '5');
INSERT INTO `list_menu` VALUES (6, 'admin/master_data/jenis_tagihan', 'Jenis Tagihan', 'Master Data', '1', '6');
INSERT INTO `list_menu` VALUES (7, 'admin/master_data/metode_pembayaran', 'Metode Pembayaran', 'Master Data', '1', '7');
INSERT INTO `list_menu` VALUES (8, 'admin/kesiswaan/penempatan_siswa', 'Penempatan Siswa', 'Kesiswaan', '1', '8');
INSERT INTO `list_menu` VALUES (9, 'admin/kesiswaan/kenaikan_kelas', 'Kenaikan Kelas', 'Kesiswaan', '1', '9');
INSERT INTO `list_menu` VALUES (10, 'admin/kesiswaan/pindah_kelas', 'Pindah Kelas', 'Kesiswaan', '1', '10');
INSERT INTO `list_menu` VALUES (11, 'admin/kesiswaan/tinggal_kelas', 'Tinggal Kelas', 'Kesiswaan', '1', '11');
INSERT INTO `list_menu` VALUES (12, 'admin/kesiswaan/kelulusan', 'Kelulusan', 'Kesiswaan', '1', '12');
INSERT INTO `list_menu` VALUES (13, 'admin/kesiswaan/status_siswa', 'Berhenti/Pindah Sekolah', 'Kesiswaan', '1', '13');
INSERT INTO `list_menu` VALUES (14, 'admin/kesiswaan/riwayat_kelas', 'Riwayat Kelas', 'Kesiswaan', '1', '14');
INSERT INTO `list_menu` VALUES (38, 'admin/pengaturan/user', 'User', 'Pengaturan', '1', '38');
INSERT INTO `list_menu` VALUES (39, 'admin/pengaturan/level', 'Level', 'Pengaturan', '1', '39');
INSERT INTO `list_menu` VALUES (40, 'admin/pengaturan/hak_akses', 'Hak Akses', 'Pengaturan', '1', '40');
INSERT INTO `list_menu` VALUES (41, 'admin/pengaturan/format_bukti', 'Format Bukti', 'Pengaturan', '1', '41');
INSERT INTO `list_menu` VALUES (42, 'admin/pengaturan/format_kartu', 'Format Kartu', 'Pengaturan', '1', '42');
INSERT INTO `list_menu` VALUES (43, 'admin/pengaturan/template_whatsapp', 'Template WhatsApp', 'Pengaturan', '1', '43');
INSERT INTO `list_menu` VALUES (44, 'admin/pengaturan/log_aktivitas', 'Log Aktivitas', 'Pengaturan', '1', '44');
INSERT INTO `list_menu` VALUES (64, 'admin/data_laporan/laporan_pembayaran', 'Laporan Pembayaran', 'Laporan', '1', '31');
INSERT INTO `list_menu` VALUES (65, 'admin/laporan/laporan/bulanan', 'Pembayaran Bulanan', 'Laporan', '1', '32');
INSERT INTO `list_menu` VALUES (66, 'admin/laporan/laporan/tahunan', 'Pembayaran Tahunan', 'Laporan', '1', '33');
INSERT INTO `list_menu` VALUES (67, 'admin/data_laporan/laporan_rekap_per_kelas', 'Rekap Pembayaran Per Kelas', 'Laporan', '1', '34');
INSERT INTO `list_menu` VALUES (68, 'admin/data_laporan/laporan_rekap_per_jenis', 'Rekap Pembayaran Per Jenis', 'Laporan', '1', '35');
INSERT INTO `list_menu` VALUES (69, 'admin/data_laporan/laporan_tunggakan', 'Laporan Tunggakan', 'Laporan', '1', '36');
INSERT INTO `list_menu` VALUES (70, 'admin/data_laporan/laporan_riwayat_pembatalan', 'Riwayat Pembatalan', 'Laporan', '1', '37');
INSERT INTO `list_menu` VALUES (72, 'admin/tagihan/daftar_tagihan', 'Daftar Tagihan', 'Tagihan', '1', '18');
INSERT INTO `list_menu` VALUES (73, 'admin/tagihan/siswa_pembayar', 'Siswa Pembayar', 'Tagihan', '1', '19');
INSERT INTO `list_menu` VALUES (74, 'admin/tagihan/tarif_per_kelas', 'Tarif Per Kelas', 'Tagihan', '1', '20');
INSERT INTO `list_menu` VALUES (76, 'admin/tagihan/keringanan', 'Potongan/Pembebasan', 'Tagihan', '1', '22');
INSERT INTO `list_menu` VALUES (82, 'admin/transaksi/pembayaran', 'Pembayaran Tagihan', 'Transaksi', '1', '23');
INSERT INTO `list_menu` VALUES (83, 'admin/transaksi/riwayat_pembayaran', 'Riwayat Pembayaran', 'Transaksi', '1', '24');
INSERT INTO `list_menu` VALUES (85, 'admin/master_data/wali_murid', 'Wali Murid', 'Master Data', '1', '45');
INSERT INTO `list_menu` VALUES (86, 'admin/master_data/kelas_setting', 'Kelas Setting', 'Master Data', '1', '46');
INSERT INTO `list_menu` VALUES (119, 'dashboard', 'Dashboard', 'Dashboard', '3', '1');
INSERT INTO `list_menu` VALUES (120, 'admin/kesiswaan/penempatan_siswa', 'Penempatan Siswa', 'Kesiswaan', '3', '8');
INSERT INTO `list_menu` VALUES (121, 'admin/kesiswaan/kenaikan_kelas', 'Kenaikan Kelas', 'Kesiswaan', '3', '9');
INSERT INTO `list_menu` VALUES (122, 'admin/kesiswaan/pindah_kelas', 'Pindah Kelas', 'Kesiswaan', '3', '10');
INSERT INTO `list_menu` VALUES (123, 'admin/kesiswaan/tinggal_kelas', 'Tinggal Kelas', 'Kesiswaan', '3', '11');
INSERT INTO `list_menu` VALUES (124, 'admin/kesiswaan/kelulusan', 'Kelulusan', 'Kesiswaan', '3', '12');
INSERT INTO `list_menu` VALUES (125, 'admin/kesiswaan/status_siswa', 'Berhenti/Pindah Sekolah', 'Kesiswaan', '3', '13');
INSERT INTO `list_menu` VALUES (126, 'admin/kesiswaan/riwayat_kelas', 'Riwayat Kelas', 'Kesiswaan', '3', '14');
INSERT INTO `list_menu` VALUES (127, 'admin/laporan/laporan/harian', 'Pembayaran Harian', 'Laporan', '3', '31');
INSERT INTO `list_menu` VALUES (128, 'admin/laporan/laporan/bulanan', 'Pembayaran Bulanan', 'Laporan', '3', '32');
INSERT INTO `list_menu` VALUES (129, 'admin/laporan/laporan/tahunan', 'Pembayaran Tahunan', 'Laporan', '3', '33');
INSERT INTO `list_menu` VALUES (130, 'admin/laporan/laporan/per_kelas', 'Rekap Per Kelas', 'Laporan', '3', '34');
INSERT INTO `list_menu` VALUES (131, 'admin/laporan/laporan/per_jenis', 'Rekap Per Jenis', 'Laporan', '3', '35');
INSERT INTO `list_menu` VALUES (132, 'admin/laporan/laporan/tunggakan', 'Laporan Tunggakan', 'Laporan', '3', '36');
INSERT INTO `list_menu` VALUES (133, 'admin/laporan/laporan/pembatalan', 'Riwayat Pembatalan', 'Laporan', '3', '37');
INSERT INTO `list_menu` VALUES (134, 'admin/master_data/tahun_ajaran', 'Tahun Ajaran', 'Master Data', '3', '2');
INSERT INTO `list_menu` VALUES (135, 'admin/master_data/data_kelas', 'Kelas', 'Master Data', '3', '3');
INSERT INTO `list_menu` VALUES (136, 'admin/master_data/kelas_setting', 'Kelas Setting', 'Master Data', '3', '46');
INSERT INTO `list_menu` VALUES (137, 'admin/master_data/siswa', 'Siswa', 'Master Data', '3', '4');
INSERT INTO `list_menu` VALUES (138, 'admin/master_data/import_siswa', 'Import Siswa', 'Master Data', '3', '5');
INSERT INTO `list_menu` VALUES (139, 'admin/master_data/jenis_tagihan', 'Jenis Tagihan', 'Master Data', '3', '6');
INSERT INTO `list_menu` VALUES (140, 'admin/master_data/metode_pembayaran', 'Metode Pembayaran', 'Master Data', '3', '7');
INSERT INTO `list_menu` VALUES (141, 'admin/master_data/wali_murid', 'Wali Murid', 'Master Data', '3', '45');
INSERT INTO `list_menu` VALUES (142, 'admin/pengaturan/user', 'User', 'Pengaturan', '3', '38');
INSERT INTO `list_menu` VALUES (143, 'admin/pengaturan/level', 'Level', 'Pengaturan', '3', '39');
INSERT INTO `list_menu` VALUES (144, 'admin/pengaturan/hak_akses', 'Hak Akses', 'Pengaturan', '3', '40');
INSERT INTO `list_menu` VALUES (145, 'admin/pengaturan/format_bukti', 'Format Bukti', 'Pengaturan', '3', '41');
INSERT INTO `list_menu` VALUES (146, 'admin/pengaturan/format_kartu', 'Format Kartu', 'Pengaturan', '3', '42');
INSERT INTO `list_menu` VALUES (147, 'admin/pengaturan/template_whatsapp', 'Template WhatsApp', 'Pengaturan', '3', '43');
INSERT INTO `list_menu` VALUES (148, 'admin/pengaturan/log_aktivitas', 'Log Aktivitas', 'Pengaturan', '3', '44');
INSERT INTO `list_menu` VALUES (149, 'admin/tagihan/daftar_tagihan', 'Daftar Tagihan', 'Tagihan', '3', '18');
INSERT INTO `list_menu` VALUES (150, 'admin/tagihan/siswa_pembayar', 'Siswa Pembayar', 'Tagihan', '3', '19');
INSERT INTO `list_menu` VALUES (151, 'admin/tagihan/tarif_per_kelas', 'Tarif Per Kelas', 'Tagihan', '3', '20');
INSERT INTO `list_menu` VALUES (153, 'admin/tagihan/keringanan', 'Potongan/Pembebasan', 'Tagihan', '3', '22');
INSERT INTO `list_menu` VALUES (159, 'admin/transaksi/pembayaran', 'Pembayaran Tagihan', 'Transaksi', '3', '23');
INSERT INTO `list_menu` VALUES (160, 'admin/transaksi/riwayat_pembayaran', 'Riwayat Pembayaran', 'Transaksi', '3', '24');
INSERT INTO `list_menu` VALUES (162, 'dashboard', 'Dashboard', 'Dashboard', '4', '1');
INSERT INTO `list_menu` VALUES (163, 'admin/laporan/laporan/harian', 'Pembayaran Harian', 'Laporan', '4', '31');
INSERT INTO `list_menu` VALUES (164, 'admin/laporan/laporan/bulanan', 'Pembayaran Bulanan', 'Laporan', '4', '32');
INSERT INTO `list_menu` VALUES (165, 'admin/laporan/laporan/tahunan', 'Pembayaran Tahunan', 'Laporan', '4', '33');
INSERT INTO `list_menu` VALUES (166, 'admin/laporan/laporan/per_kelas', 'Rekap Per Kelas', 'Laporan', '4', '34');
INSERT INTO `list_menu` VALUES (167, 'admin/laporan/laporan/per_jenis', 'Rekap Per Jenis', 'Laporan', '4', '35');
INSERT INTO `list_menu` VALUES (168, 'admin/laporan/laporan/tunggakan', 'Laporan Tunggakan', 'Laporan', '4', '36');
INSERT INTO `list_menu` VALUES (169, 'admin/laporan/laporan/pembatalan', 'Riwayat Pembatalan', 'Laporan', '4', '37');
INSERT INTO `list_menu` VALUES (170, 'admin/master_data/tahun_ajaran', 'Tahun Ajaran', 'Master Data', '4', '2');
INSERT INTO `list_menu` VALUES (171, 'admin/master_data/jenis_tagihan', 'Jenis Tagihan', 'Master Data', '4', '6');
INSERT INTO `list_menu` VALUES (172, 'admin/master_data/metode_pembayaran', 'Metode Pembayaran', 'Master Data', '4', '7');
INSERT INTO `list_menu` VALUES (173, 'admin/pengaturan/format_bukti', 'Format Bukti', 'Pengaturan', '4', '41');
INSERT INTO `list_menu` VALUES (174, 'admin/pengaturan/format_kartu', 'Format Kartu', 'Pengaturan', '4', '42');
INSERT INTO `list_menu` VALUES (175, 'admin/pengaturan/template_whatsapp', 'Template WhatsApp', 'Pengaturan', '4', '43');
INSERT INTO `list_menu` VALUES (176, 'admin/tagihan/daftar_tagihan', 'Daftar Tagihan', 'Tagihan', '4', '18');
INSERT INTO `list_menu` VALUES (177, 'admin/tagihan/siswa_pembayar', 'Siswa Pembayar', 'Tagihan', '4', '19');
INSERT INTO `list_menu` VALUES (178, 'admin/tagihan/tarif_per_kelas', 'Tarif Per Kelas', 'Tagihan', '4', '20');
INSERT INTO `list_menu` VALUES (180, 'admin/tagihan/keringanan', 'Potongan/Pembebasan', 'Tagihan', '4', '22');
INSERT INTO `list_menu` VALUES (186, 'admin/transaksi/pembayaran', 'Pembayaran Tagihan', 'Transaksi', '4', '23');
INSERT INTO `list_menu` VALUES (187, 'admin/transaksi/riwayat_pembayaran', 'Riwayat Pembayaran', 'Transaksi', '4', '24');
INSERT INTO `list_menu` VALUES (189, 'admin/kepegawaian/jabatan', 'Jabatan', 'Kepegawaian', '1', '47');
INSERT INTO `list_menu` VALUES (190, 'admin/kepegawaian/pegawai', 'Pegawai', 'Kepegawaian', '1', '48');
INSERT INTO `list_menu` VALUES (199, 'admin/tunggakan/surat_tunggakan', 'Surat Tunggakan', 'Tunggakan', '1', '30');
INSERT INTO `list_menu` VALUES (200, 'admin/tunggakan/monitoring_tagihan', 'Monitoring Tagihan', 'Tunggakan', '1', '50');
INSERT INTO `list_menu` VALUES (201, 'admin/kepegawaian/jabatan', 'Jabatan', 'Kepegawaian', '3', '47');
INSERT INTO `list_menu` VALUES (202, 'admin/kepegawaian/pegawai', 'Pegawai', 'Kepegawaian', '3', '48');
INSERT INTO `list_menu` VALUES (203, 'admin/tunggakan/surat_tunggakan', 'Surat Tunggakan', 'Tunggakan', '3', '30');
INSERT INTO `list_menu` VALUES (204, 'admin/tunggakan/monitoring_tagihan', 'Monitoring Tagihan', 'Tunggakan', '3', '50');
INSERT INTO `list_menu` VALUES (205, 'admin/kesiswaan/riwayat_kelas', 'Riwayat Kelas', 'Kesiswaan', '4', '14');
INSERT INTO `list_menu` VALUES (206, 'admin/master_data/siswa', 'Siswa', 'Master Data', '4', '4');
INSERT INTO `list_menu` VALUES (207, 'admin/master_data/import_siswa', 'Import Siswa', 'Master Data', '4', '5');
INSERT INTO `list_menu` VALUES (208, 'admin/tunggakan/surat_tunggakan', 'Surat Tunggakan', 'Tunggakan', '4', '30');
INSERT INTO `list_menu` VALUES (209, 'admin/tunggakan/monitoring_tagihan', 'Monitoring Tagihan', 'Tunggakan', '4', '50');
INSERT INTO `list_menu` VALUES (211, 'admin/transaksi/cicilan', 'Cicilan', 'Transaksi', '1', '51');
INSERT INTO `list_menu` VALUES (212, 'admin/transaksi/cicilan', 'Cicilan', 'Transaksi', '3', '51');

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
) ENGINE = InnoDB AUTO_INCREMENT = 102 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of master_tahun_ajaran
-- ----------------------------
INSERT INTO `master_tahun_ajaran` VALUES (97, '2025/2026', 'Tidak Aktif', '15-08-2026', '08:49:20', 17);
INSERT INTO `master_tahun_ajaran` VALUES (98, '2026/2027', 'Aktif', '15-08-2026', '08:49:30', 17);
INSERT INTO `master_tahun_ajaran` VALUES (99, '2027/2028', 'Tidak Aktif', '15-08-2026', '08:49:36', 17);
INSERT INTO `master_tahun_ajaran` VALUES (100, '2028/2029', 'Tidak Aktif', '15-08-2026', '08:49:50', 17);
INSERT INTO `master_tahun_ajaran` VALUES (101, '2029/2030', 'Tidak Aktif', '24-08-2026', '13:22:40', 17);

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
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES (1, 'dashboard', 'Dashboard', 'Dashboard', '1');
INSERT INTO `menu` VALUES (2, 'admin/master_data/tahun_ajaran', 'Tahun Ajaran', 'Master Data', '1');
INSERT INTO `menu` VALUES (3, 'admin/master_data/data_kelas', 'Kelas', 'Master Data', '2');
INSERT INTO `menu` VALUES (4, 'admin/master_data/siswa', 'Siswa', 'Master Data', '4');
INSERT INTO `menu` VALUES (5, 'admin/master_data/import_siswa', 'Import Siswa', 'Master Data', '5');
INSERT INTO `menu` VALUES (6, 'admin/master_data/jenis_tagihan', 'Jenis Tagihan', 'Master Data', '6');
INSERT INTO `menu` VALUES (7, 'admin/master_data/metode_pembayaran', 'Metode Pembayaran', 'Master Data', '7');
INSERT INTO `menu` VALUES (8, 'admin/kesiswaan/penempatan_siswa', 'Penempatan Siswa', 'Kesiswaan', '1');
INSERT INTO `menu` VALUES (9, 'admin/kesiswaan/kenaikan_kelas', 'Kenaikan Kelas', 'Kesiswaan', '2');
INSERT INTO `menu` VALUES (10, 'admin/kesiswaan/pindah_kelas', 'Pindah Kelas', 'Kesiswaan', '3');
INSERT INTO `menu` VALUES (11, 'admin/kesiswaan/tinggal_kelas', 'Tinggal Kelas', 'Kesiswaan', '4');
INSERT INTO `menu` VALUES (12, 'admin/kesiswaan/kelulusan', 'Kelulusan', 'Kesiswaan', '5');
INSERT INTO `menu` VALUES (13, 'admin/kesiswaan/status_siswa', 'Berhenti/Pindah Sekolah', 'Kesiswaan', '6');
INSERT INTO `menu` VALUES (14, 'admin/kesiswaan/riwayat_kelas', 'Riwayat Kelas', 'Kesiswaan', '7');
INSERT INTO `menu` VALUES (18, 'admin/tagihan/daftar_tagihan', 'Daftar Tagihan', 'Tagihan', '4');
INSERT INTO `menu` VALUES (19, 'admin/tagihan/siswa_pembayar', 'Siswa Pembayar', 'Tagihan', '5');
INSERT INTO `menu` VALUES (20, 'admin/tagihan/tarif_per_kelas', 'Tarif Per Kelas', 'Tagihan', '6');
INSERT INTO `menu` VALUES (22, 'admin/tagihan/keringanan', 'Potongan/Pembebasan', 'Tagihan', '8');
INSERT INTO `menu` VALUES (23, 'admin/transaksi/pembayaran', 'Pembayaran Tagihan', 'Transaksi', '1');
INSERT INTO `menu` VALUES (24, 'admin/transaksi/riwayat_pembayaran', 'Riwayat Pembayaran', 'Transaksi', '2');
INSERT INTO `menu` VALUES (30, 'admin/tunggakan/surat_tunggakan', 'Surat Tunggakan', 'Tunggakan', '1');
INSERT INTO `menu` VALUES (31, 'admin/laporan/laporan/harian', 'Pembayaran Harian', 'Laporan', '1');
INSERT INTO `menu` VALUES (32, 'admin/laporan/laporan/bulanan', 'Pembayaran Bulanan', 'Laporan', '2');
INSERT INTO `menu` VALUES (33, 'admin/laporan/laporan/tahunan', 'Pembayaran Tahunan', 'Laporan', '3');
INSERT INTO `menu` VALUES (34, 'admin/laporan/laporan/per_kelas', 'Rekap Per Kelas', 'Laporan', '4');
INSERT INTO `menu` VALUES (35, 'admin/laporan/laporan/per_jenis', 'Rekap Per Jenis', 'Laporan', '5');
INSERT INTO `menu` VALUES (36, 'admin/laporan/laporan/tunggakan', 'Laporan Tunggakan', 'Laporan', '6');
INSERT INTO `menu` VALUES (37, 'admin/laporan/laporan/pembatalan', 'Riwayat Pembatalan', 'Laporan', '7');
INSERT INTO `menu` VALUES (38, 'admin/pengaturan/user', 'User', 'Pengaturan', '1');
INSERT INTO `menu` VALUES (39, 'admin/pengaturan/level', 'Level', 'Pengaturan', '2');
INSERT INTO `menu` VALUES (40, 'admin/pengaturan/hak_akses', 'Hak Akses', 'Pengaturan', '3');
INSERT INTO `menu` VALUES (41, 'admin/pengaturan/format_bukti', 'Format Bukti', 'Pengaturan', '4');
INSERT INTO `menu` VALUES (42, 'admin/pengaturan/format_kartu', 'Format Kartu', 'Pengaturan', '5');
INSERT INTO `menu` VALUES (43, 'admin/pengaturan/template_whatsapp', 'Template WhatsApp', 'Pengaturan', '6');
INSERT INTO `menu` VALUES (44, 'admin/pengaturan/log_aktivitas', 'Log Aktivitas', 'Pengaturan', '7');
INSERT INTO `menu` VALUES (45, 'admin/master_data/wali_murid', 'Wali Murid', 'Master Data', '8');
INSERT INTO `menu` VALUES (46, 'admin/master_data/kelas_setting', 'Kelas Setting', 'Master Data', '3');
INSERT INTO `menu` VALUES (47, 'admin/kepegawaian/jabatan', 'Jabatan', 'Kepegawaian', '1');
INSERT INTO `menu` VALUES (48, 'admin/kepegawaian/pegawai', 'Pegawai', 'Kepegawaian', '2');
INSERT INTO `menu` VALUES (50, 'admin/tunggakan/monitoring_tagihan', 'Monitoring Tagihan', 'Tunggakan', '2');
INSERT INTO `menu` VALUES (51, 'admin/transaksi/cicilan', 'Cicilan', 'Transaksi', '3');

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
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pegawai
-- ----------------------------
INSERT INTO `pegawai` VALUES (2, 0, 'Mariya Wijayanti, S.E', 'Perempuan', 'Bandung', '1992-08-03', '082330216507', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (3, 0, 'Andini Oktarani Tria Rahma, S.Ds', 'Perempuan', 'Lumajang', '1994-10-15', '085939286060', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (4, 0, 'Ridhotullah Mahfud Yahya, A.Md', 'Laki - Laki', 'Jember', '1990-11-24', '085756383176', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (6, 0, 'Navida Dwi Ana Rahmawati, S.Pd', 'Perempuan', 'Lumajang', '1990-11-24', '085335181883', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (8, 0, 'Putri Wulida Sani, S.Pd', 'Perempuan', 'Lumajang', '2000-02-02', '081930753127', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (10, 0, 'Mohammad Rizky, S. Kom', 'Laki - Laki', 'Lumajang', '2001-10-15', '085234547923', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (11, 0, 'Nanis Su\'udah, S. Pd., Gr.', 'Perempuan', 'Lumajang', '1992-05-26', '089689028526', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (12, 0, 'Muhammad Mughni Labib, S.A.P., M.A.P', 'Laki - Laki', 'Lumajang', '01-03-1998', '082337993160', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (13, 0, 'Ahmad Nur Wicaksono, S.Pd', 'Laki - Laki', 'Lumajang', '06-05-1998', '085536928389', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (19, 0, 'Muhammad Fazar Ramadhan', 'Laki - Laki', 'Lumajang', '2008-09-16', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (21, 0, 'Khaidar Zulkarnaen Firdaus, S.Pd', 'Laki - Laki', 'Lumajang', '2000-04-01', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (22, 0, 'M. Zam Zam Putra Romadhon', 'Laki - Laki', 'Lumajang', '16-04-2025', '-', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (23, 0, 'Nabil Miftahudin, S. Pd', 'Laki - Laki', 'LUMAJANG', '01-01-0001', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (24, 0, 'Wahyu Novianto, S. Sos. I', 'Laki - Laki', 'LUMAJANG', '0001-01-01', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (25, 0, 'Munib Agil Cahyono, S. Pd', 'Laki - Laki', 'LUMAJANG', '0001-01-01', '', 'Offline', NULL);
INSERT INTO `pegawai` VALUES (26, 0, 'Nasirudin Albani, S.Pd.', 'Laki - Laki', 'LUMAJANG', '01-01-1995', '082132173212', 'Offline', NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 134 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of pegawai_jabatan
-- ----------------------------
INSERT INTO `pegawai_jabatan` VALUES (23, '2', '12', 'Guru', 'Muhammad Mughni Labib, S.A.P., M.A.P');
INSERT INTO `pegawai_jabatan` VALUES (24, '2', '13', 'Guru', 'Ahmad Nur Wicaksono, S.Pd');
INSERT INTO `pegawai_jabatan` VALUES (33, '15', '22', 'OB', 'M. Zam Zam Putra Romadhon');
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
INSERT INTO `pegawai_jabatan` VALUES (120, '2', '25', 'Guru', 'Munib Agil Cahyono, S. Pd');
INSERT INTO `pegawai_jabatan` VALUES (121, '8', '25', 'Wali Kelas', 'Munib Agil Cahyono, S. Pd');
INSERT INTO `pegawai_jabatan` VALUES (122, '1', '26', 'Kepala Sekolah', 'Nasirudin Albani, S.Pd.');
INSERT INTO `pegawai_jabatan` VALUES (131, '2', '23', 'Guru', 'Nabil Miftahudin, S. Pd');
INSERT INTO `pegawai_jabatan` VALUES (132, '16', '23', 'Admin', 'Nabil Miftahudin, S. Pd');

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
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of siswa
-- ----------------------------
INSERT INTO `siswa` VALUES (20, '0', '0071353406', '01032526', 'Affan Hakami', 'Laki-laki', 'Lumajang', '04-12-2020', '01-07-2026', '', 'Aktif', '0', NULL, 'Dusun Sidorejo RT 4 RW 5 desa karangsari kecamatan sukodono kabupaten lumajang', 'Muhammad Hakam nausa', 'Karyawan rumah makan', '085232939995', '', NULL, 'Erni Wijayanti', '', '', '', NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (21, '0', '00714743986', '04042526', 'Shafiyah Salsabila Izzuddin', 'Perempuan', 'Jember', '18-04-2022', '01-07-2026', '', 'Aktif', '0', NULL, 'Jl. Kartini RT 3 RW 6 Tempursari Lumajang', 'Akhmad Izzuddin', 'Guru', '082232780062', '', NULL, 'Yudistirawati Khusna', '', '', '', NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (22, '0', '00714743987', '05032526', 'Hamzah Umair Hermawan', 'Laki-laki', 'Lumajang', '20-06-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'Jalan Kelapa Gading 2 B2, Kelapa Gading Residence, Kel. Kepuharjo, Kec. Lumajang, Kab. Lumajang, Jawa Timur 67316', 'Mohammad Arief Hermawan', 'Pelatih Panahan', '+628113801308', NULL, NULL, 'Rahma Eka Widyaningsih', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (23, '0', '00714743988', '06032526', 'Abdullah Albani', 'Laki-laki', 'Lumajang', '07-06-2021', '01-07-2026', '', 'Pindah Sekolah', '98', NULL, 'Jl. Slamet Rahardjo RT. 01 RW. 01 Dsn. Umpak Desa Tanggung Kec. Padang - Lumajang', 'Nasirudin Albani', 'Karyawan', '085236701551', NULL, NULL, 'Finna Margareta', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (24, '0', '00714743989', '07032627', 'Adam At-Tirmidzi', 'Laki-laki', 'Lumajang', '11-10-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. Semeru RT.05 RW.01 BANJARWARU', 'MUTAMAT', 'WIRASWASTA', '082338858291', NULL, NULL, 'Wiwit Isti Faizah', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (25, '0', '00714743990', '08042627', 'Aisyah Nayla Bilqis', 'Perempuan', 'Lumajang', '06-09-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. Kyai Ilyas gg. 8 No. 6', 'Agung Taufik', 'Petani', '082141790404', NULL, NULL, 'Ike Marindasari Isworo Putri', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (26, '0', '00714743991', '09042627', 'Alsava Aghnia Mafaza', 'Perempuan', 'Lumajang', '26-03-2022', '01-07-2026', '', 'Aktif', '98', NULL, 'Desa Denok Krajan RT 04 RW 03 Kec. Lumajang Kab. Lumajang', 'DWI CAHYONO', 'Wiraswasta', '085231172382', NULL, NULL, 'Nahdiah Wulandari', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (27, '0', '00714743992', '10032627', 'Ayyub', 'Laki-laki', 'Lumajang', '27-09-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'KedungPakis, Pasirian, Lumajang', 'Benny Vinot Galo', 'Wiraswasta', '085656045601', NULL, NULL, 'Luvinda Royyachin', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (28, '0', '00714743993', '11042627', 'Hanna Azalea Wahyu Firmawan', 'Perempuan', 'Lumajang', '30-06-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'Perum. Adara park 1. Blok A20 komersil, dorogowok kunir.', 'Dian wahyu firmawan', 'ASN', '085204604204', NULL, NULL, 'Widatur Rokhmah', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (29, '0', '00714743994', '12042627', 'Oryza Amiirah Hasan', 'Perempuan', 'Lumajang', '05-04-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'Dusun Gumukmas, Pulo, Tempeh', 'Fuad Hasan', 'Wiraswasta', '085339087579', NULL, NULL, 'Lestari Puteri Utami', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (30, '0', '00714743995', '13032627', 'Rey Altezza Prabowo', 'Laki-laki', 'Lumajang', '10-05-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'Perum suko asri blok T2', 'Angget Mukti Prabowo', 'Pegawai pemerintahan', '085608569666', NULL, NULL, 'Atika Farah Rafidah', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (31, '0', '00714743996', '14032627', 'Said', 'Laki-laki', 'Lumajang', '19-01-2022', '01-07-2026', '', 'Aktif', '98', NULL, 'Rt 1 rw 5 dusun maduran Sarikemuning senduro', 'Suhardi', 'Ojek online', '085786719262', NULL, NULL, 'Yani Khoirul', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (32, '0', '00714743997', '15032627', 'Yunus', 'Laki-laki', 'Lumajang', '28-09-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'Jalan Kapten Kyai Ilyas Gang XII No.12', 'Yuki Dwi Baramantoro', 'Wiraswasta', '085338863349', NULL, NULL, 'Tartila', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (33, '0', '00714743998', '16032627', 'Ziyad Abdullah Abqar Rafif', 'Laki-laki', 'Lumajang', '28-09-2021', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. RA. Kartini Perum Graha Kartini No. 9', 'Buasan', 'Wiraswasta', '085258697477', NULL, NULL, 'Yuli Rafika Sari', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (34, '0', '00712051513', '15012627', 'Abdurrahman Al Hafiz', 'Laki-laki', 'Lumajang', '16-06-2019', '01-07-2026', '', 'Lulus', '98', NULL, 'Jl. Tangkuban Perahu RT 05 RW 06 Desa Karangsari', 'Sudar widayatno', 'Wiraswasta', '085648961292', NULL, NULL, 'Fitrotul Adha', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (35, '0', '00712051514', '16012627', 'Ahmad Zhafir', 'Laki-laki', 'Lumajang', '25-10-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl Panjaitan GG luntas RT 1 RW 11 no 17 citrodiwangsan', 'Bayu Dwi Santoso', 'Karyawan swasta', '085258070302', NULL, NULL, 'Arika Desilia', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (36, '0', '00712051515', '17022627', 'Amirah Izdihar Faiz', 'Perempuan', 'Lumajang', '24-01-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Dusun Krajan Kulon RT.09 RW.02 Desa Selokbesuki Sukodono Lumajang', 'Muhammad Faiz Romli', 'Karyawan swasta', '085749019470', NULL, NULL, 'Dewi Kurotul Aini', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (37, '0', '00712051516', '18022627', 'Asma\' Albani', 'Perempuan', 'Lumajang', '18-03-2020', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. Slamet Rahardjo RT. 01 RW. 01 Dsn. Umpak Desa Tanggung Kec. Padang - Lumajang', 'Nasirudin Albani', 'Karyawan', '085236701551', NULL, NULL, 'Finna Margareta', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (38, '0', '00712051517', '19022627', 'Aysha Salma Salsabila', 'Perempuan', 'Surabaya', '12-09-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Dsn. Krajan - Desa Sarimemuning - Senduro', 'Hadiono', 'Swasta', '085732802362', NULL, NULL, 'Ika Hani Rahmayani', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (39, '0', '00712051518', '20022627', 'Azkia Ramadhani Setiawan', 'Perempuan', 'Lumajang', '09-06-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl Yosudarso 15 rt 01 rw 06 tompokersan Lumajang', 'Eko Setiawan', 'Swasta', '085655903746', NULL, NULL, 'Rita Vidiana', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (40, '0', '00712051519', '21022627', 'Khaulah chatam', 'Perempuan', 'Lumajang', '21-02-2020', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. Kh. Wahid Hasyim Gg. 03, Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316, Indonesia', 'Chatam', 'Wiraswasta', '082332066465 / 082142004575', NULL, NULL, 'Siti Nur Aini', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (41, '0', '00712051520', '22022627', 'Maryam', 'Perempuan', 'Lumajang', '20-07-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Dusun selokambang RT. 04 RW.02 Desa Purwosono Kec. Sumbersuko', 'Teguh cahyono', 'Pedagang', '+62 877-2590-6376', NULL, NULL, 'Reni Agustin', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (42, '0', '00712051521', '23012627', 'Muhammad Ibrahim Al Fatih', 'Laki-laki', 'Lumajang', '19-08-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Desa Sidorejo dusun wungurejo RT/RW 007/004 kecamatan Rowokangkung', 'Muslimin', 'shadow teacher', '085749569287', NULL, NULL, 'Pristin Monotasari', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (43, '0', '00712051522', '24012627', 'Muhammad Yusuf', 'Laki-laki', 'Lumajang', '13-08-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Desa Tukum Dusun Pandan Wangi RT. 11 RW. 04 Kec. Tekung Kab. Lumajang', 'Ony Tri Sanjaya', 'Karyawan swasta', '085101839345', NULL, NULL, 'Nur Fadilah', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (44, '0', '00712051523', '25022627', 'Nafisha Jihan Arsyila', 'Perempuan', 'Lumajang', '06-02-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. Lapangan RT. 02 RW.04 Desa Kebonagung Sukodono', 'Muhammad Jihad Achponi', 'Operator Layanan Operasional', '085704588616', NULL, NULL, 'Dwi Octavia Ratna Sari', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (45, '0', '00712051524', '26022627', 'Nusaibah Maryam', 'Perempuan', 'Lumajang', '05-10-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Dusun Sumberdawe RT.01 RW.03 Desa Kunir Kidul Kec. Kunir', 'Agzin Anmiba Raharsan', 'Wiraswasta', '081335017991', NULL, NULL, 'Luailiyatul Makmunah', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (46, '0', '00712051525', '27022627', 'RUMAYSHA ABIDAH', 'Perempuan', 'Lumajang', '20-08-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Dusun krajan wetan rt12 rw03 desa selokbesuki kecamatan sukodono kabupaten lumajang', 'Galih Susianto', 'Wiraswasta', '085739273533', NULL, NULL, 'Norita Fatatik Azizi', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (47, '0', '00712051526', '28012627', 'Sabiqul Haqqi Abadan', 'Laki-laki', 'Lumajang', '15-04-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Jalan Ade Irma Suryani RT 01 RW 02 Rogotrunan', 'Faza Abid Abadan', 'Ojek online', '08970692999', NULL, NULL, 'Diana Cecilia Santoso Putri', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (48, '0', '00723897520', '01012526', 'Abdillah Chatam', 'Laki-laki', 'Lumajang', '', '01-07-2026', '', 'Aktif', '98', NULL, 'Jalan k.h wahid hasyim gang 3a no 01 rt 02 rw 10', 'Chatam', 'Wiraswasta', '082332066465', NULL, NULL, 'Siti Nur Aini', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (49, '0', '00723897521', '02022526', 'Aisyah Qonitah Izzuddin', 'Perempuan', 'Jember', '19-10-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. Kartini RT 3 RW 6 Tempursari Lumajang', 'Akhmad Izzuddin', 'Guru', '082232780062', NULL, NULL, 'Yudistirawati Khusna', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (50, '0', '00723897522', '03012526', 'Ammar Hakami', 'Laki-laki', 'Lumajang', '20-05-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'Dusun Sidorejo RT 4 RW 5 desa karangsari kecamatan sukodono kabupaten lumajang', 'Muhammad Hakam nausa', 'Karyawan rumah makan', '085232939995', NULL, NULL, 'Erni Wijayanti', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (51, '0', '00723897523', '04012526', 'Hamizan Umar Hermawan', 'Laki-laki', 'Lumajang', '21-07-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Jalan Kelapa Gading 2 B2, Kelapa Gading Residence, Kel. Kepuharjo, Kec. Lumajang, Kab. Lumajang, Jawa Timur 67316', 'Mohammad Arief Hermawan', 'Pelatih Panahan', '+628113801308', NULL, NULL, 'Rahma Eka Widyaningsih', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (52, '0', '00723897524', '05012526', 'Hisham Ali Hermawan', 'Laki-laki', 'Lumajang', '21-07-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Jalan Kelapa Gading 2 B2, Kelapa Gading Residence, Kel. Kepuharjo, Kec. Lumajang, Kab. Lumajang, Jawa Timur 67316', 'Mohammad Arief Hermawan', 'Pelatih Panahan', '+628113801308', NULL, NULL, 'Rahma Eka Widyaningsih', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (53, '0', '00723897525', '06022526', 'KHADIJAH', 'Perempuan', 'Lumajang', '11-11-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Dusun krajan timur Desa Tempeh tengah RT/RW,011/002 TEMPEH, LUMAJANG', 'MOHAMAD SYAIFUL ULUM', 'Karyawan swasta', '081935118875', NULL, NULL, 'Nisviya Indahsari', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (54, '0', '00723897526', '07022526', 'Laili Athiyyatuzzakiyah', 'Perempuan', 'Lumajang', '14-02-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Tempeh lor', 'Ahmad muzakki', 'Swasta', '082324005127/082333176267', NULL, NULL, 'Ike Agustin Ningtyas', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (55, '0', '00723897527', '08012526', 'Muhammad Uwais Ibadurrahman', 'Laki-laki', 'Lumajang', '30-11-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. Argopuro, Gg. H. Bisri, Lumajang', 'Nur Hadiyono', 'Wiraswasta', '082335549474', NULL, NULL, 'Nanik Agustin', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (56, '0', '00723897528', '09022526', 'Nesa Humaeyra Zulkarnain', 'Perempuan', 'Jember', '20-12-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Putri Dwi Arista Wulandari Arifin', 'Lubis Zulkarnain', 'Karyawan', '085330864556', NULL, NULL, 'Putri Dwi Arista Wulandari A.', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (57, '0', '00723897529', '10022526', 'SHAFIYYAH AZZAHRA', 'Perempuan', 'Lumajang', '29-03-2019', '01-07-2026', '', 'Aktif', '98', NULL, 'JL. KH WAHID HASYIM GG 3A NO 1 RT 02 RW 10 TOMPOKERSAN LUMAJANG', 'HANIF AMRULLOH', 'KARYAWAN', '081335590406', NULL, NULL, 'Tridewiningsih', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (58, '0', '00723897530', '11012526', 'Zakaria Al Fatih', 'Laki-laki', 'Lumajang', '22-02-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Lumajang', 'Hariyanto', 'Dagang', '085607617767', NULL, NULL, 'Yuliati', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (59, '0', '00723897531', '12022526', 'Hafshoh', 'Perempuan', 'Trenggalek', '02-09-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Jl. Api Jam\'ari RT/RW : 002/010 Kelurahan Jogotrunan Lumajang', 'Mokhamad Firman Sofi\'i', 'Wirausaha', '087755007144', NULL, NULL, 'Lusiana Kurniati Rohimah', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (60, '0', '00723897532', '13012526', 'Bilal', 'Laki-laki', 'Lumajang', '20-03-2018', '01-07-2026', '', 'Aktif', '98', NULL, 'Jalan Kapten Kyai Ilyas Gang XII No. 12', 'Yuki Dwi Bramantoro', 'Karyawan', '085138738100', NULL, NULL, 'Tartila', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (61, '0', '00723897533', '14012526', 'Muhammad Ibnu Abdillah', 'Laki-laki', 'Lumajang', '10-10-2018', '01-07-2026', '', 'Aktif', '98', NULL, '', 'Muhammad Guntur Susanto', 'Wiraswasta', '085648961292', NULL, NULL, 'Yulia Sofyani', '', '', NULL, NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (62, '0', '00714725264', '2567248559', 'Muhammad Zakiprian', 'Laki-laki', 'LUMAJANG', '01-01-2020', '01-07-2026', '', 'Aktif', '0', NULL, 'Jln. Imam Suja\'i No 20', 'Muhammad Yanto', 'swasta', '081354648720', '', NULL, 'Lailatul', 'ibu rumah tangga', '087358765932', '', NULL, NULL, NULL);
INSERT INTO `siswa` VALUES (63, '0', '123', '123', 'iqbal', 'Laki-laki', 'Lumajang', '02-01-2021', '01-07-2026', '', 'Aktif', '0', NULL, 'Jln Sumberejo', 'Utsman', 'swasta', '087248756944', '', NULL, 'Ibu', 'ibu rumah tangga', '0867458798989', '', NULL, NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_import_siswa
-- ----------------------------
INSERT INTO `tagihan_import_siswa` VALUES (1, 'IMP/202608/00001', 'preview_20260817040620_template_import_siswa__1_.xlsx', 'uploads/import_siswa/preview_20260817040620_template_import_siswa__1_.xlsx', 98, '2026/2027', 48, 'TK', 12, 12, 0, 'Selesai', 'Import siswa dari template XLSX', '17-08-2026', '04:06:44', 17, 'admin');
INSERT INTO `tagihan_import_siswa` VALUES (2, 'IMP/202608/00002', 'preview_20260817051758_template_import_siswa__2_.xlsx', 'uploads/import_siswa/preview_20260817051758_template_import_siswa__2_.xlsx', 98, '2026/2027', 49, 'Kelas 1', 14, 14, 0, 'Selesai', 'Import siswa dari template XLSX', '17-08-2026', '05:18:07', 17, 'admin');
INSERT INTO `tagihan_import_siswa` VALUES (3, 'IMP/202608/00003', 'preview_20260817053819_template_import_siswa__2_.xlsx', 'uploads/import_siswa/preview_20260817053819_template_import_siswa__2_.xlsx', 98, '2026/2027', 50, 'Kelas 2', 14, 14, 0, 'Selesai', 'Import siswa dari template XLSX', '17-08-2026', '05:38:22', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 41 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_import_siswa_detail
-- ----------------------------
INSERT INTO `tagihan_import_siswa_detail` VALUES (1, 1, 2, '05032526', '00714743987', 'Hamzah Umair Hermawan', 'Laki-laki', 'TK', 22, 'Berhasil', '', '{\"NIS\":\"05032526\",\"NISN\":\"00714743987\",\"NAMA_LENGKAP\":\"Hamzah Umair Hermawan\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"20-06-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jalan Kelapa Gading 2 B2, Kelapa Gading Residence, Kel. Kepuharjo, Kec. Lumajang, Kab. Lumajang, Jawa Timur 67316\",\"NAMA_AYAH\":\"Mohammad Arief Hermawan\",\"PEKERJAAN_AYAH\":\"Pelatih Panahan\",\"TELEPON_AYAH\":\"+628113801308\",\"NAMA_IBU\":\"Rahma Eka Widyaningsih\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (2, 1, 3, '06032526', '00714743988', 'Abdullah Albani', 'Laki-laki', 'TK', 23, 'Berhasil', '', '{\"NIS\":\"06032526\",\"NISN\":\"00714743988\",\"NAMA_LENGKAP\":\"Abdullah Albani\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"07-06-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Slamet Rahardjo RT. 01 RW. 01 Dsn. Umpak Desa Tanggung Kec. Padang - Lumajang\",\"NAMA_AYAH\":\"Nasirudin Albani\",\"PEKERJAAN_AYAH\":\"Karyawan\",\"TELEPON_AYAH\":\"085236701551\",\"NAMA_IBU\":\"Finna Margareta\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (3, 1, 4, '07032627', '00714743989', 'Adam At-Tirmidzi', 'Laki-laki', 'TK', 24, 'Berhasil', '', '{\"NIS\":\"07032627\",\"NISN\":\"00714743989\",\"NAMA_LENGKAP\":\"Adam At-Tirmidzi\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"11-10-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Semeru RT.05 RW.01 BANJARWARU\",\"NAMA_AYAH\":\"MUTAMAT\",\"PEKERJAAN_AYAH\":\"WIRASWASTA\",\"TELEPON_AYAH\":\"082338858291\",\"NAMA_IBU\":\"Wiwit Isti Faizah\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (4, 1, 5, '08042627', '00714743990', 'Aisyah Nayla Bilqis', 'Perempuan', 'TK', 25, 'Berhasil', '', '{\"NIS\":\"08042627\",\"NISN\":\"00714743990\",\"NAMA_LENGKAP\":\"Aisyah Nayla Bilqis\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"06-09-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Kyai Ilyas gg. 8 No. 6\",\"NAMA_AYAH\":\"Agung Taufik\",\"PEKERJAAN_AYAH\":\"Petani\",\"TELEPON_AYAH\":\"082141790404\",\"NAMA_IBU\":\"Ike Marindasari Isworo Putri\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (5, 1, 6, '09042627', '00714743991', 'Alsava Aghnia Mafaza', 'Perempuan', 'TK', 26, 'Berhasil', '', '{\"NIS\":\"09042627\",\"NISN\":\"00714743991\",\"NAMA_LENGKAP\":\"Alsava Aghnia Mafaza\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"26-03-2022\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Desa Denok Krajan RT 04 RW 03 Kec. Lumajang Kab. Lumajang\",\"NAMA_AYAH\":\"DWI CAHYONO\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"085231172382\",\"NAMA_IBU\":\"Nahdiah Wulandari\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (6, 1, 7, '10032627', '00714743992', 'Ayyub', 'Laki-laki', 'TK', 27, 'Berhasil', '', '{\"NIS\":\"10032627\",\"NISN\":\"00714743992\",\"NAMA_LENGKAP\":\"Ayyub\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"27-09-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"KedungPakis, Pasirian, Lumajang\",\"NAMA_AYAH\":\"Benny Vinot Galo\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"085656045601\",\"NAMA_IBU\":\"Luvinda Royyachin\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (7, 1, 8, '11042627', '00714743993', 'Hanna Azalea Wahyu Firmawan', 'Perempuan', 'TK', 28, 'Berhasil', '', '{\"NIS\":\"11042627\",\"NISN\":\"00714743993\",\"NAMA_LENGKAP\":\"Hanna Azalea Wahyu Firmawan\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"30-06-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Perum. Adara park 1. Blok A20 komersil, dorogowok kunir.\",\"NAMA_AYAH\":\"Dian wahyu firmawan\",\"PEKERJAAN_AYAH\":\"ASN\",\"TELEPON_AYAH\":\"085204604204\",\"NAMA_IBU\":\"Widatur Rokhmah\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (8, 1, 9, '12042627', '00714743994', 'Oryza Amiirah Hasan', 'Perempuan', 'TK', 29, 'Berhasil', '', '{\"NIS\":\"12042627\",\"NISN\":\"00714743994\",\"NAMA_LENGKAP\":\"Oryza Amiirah Hasan\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"05-04-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Dusun Gumukmas, Pulo, Tempeh\",\"NAMA_AYAH\":\"Fuad Hasan\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"085339087579\",\"NAMA_IBU\":\"Lestari Puteri Utami\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (9, 1, 10, '13032627', '00714743995', 'Rey Altezza Prabowo', 'Laki-laki', 'TK', 30, 'Berhasil', '', '{\"NIS\":\"13032627\",\"NISN\":\"00714743995\",\"NAMA_LENGKAP\":\"Rey Altezza Prabowo\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"10-05-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Perum suko asri blok T2\",\"NAMA_AYAH\":\"Angget Mukti Prabowo\",\"PEKERJAAN_AYAH\":\"Pegawai pemerintahan\",\"TELEPON_AYAH\":\"085608569666\",\"NAMA_IBU\":\"Atika Farah Rafidah\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (10, 1, 11, '14032627', '00714743996', 'Said', 'Laki-laki', 'TK', 31, 'Berhasil', '', '{\"NIS\":\"14032627\",\"NISN\":\"00714743996\",\"NAMA_LENGKAP\":\"Said\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"19-01-2022\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Rt 1 rw 5 dusun maduran Sarikemuning senduro\",\"NAMA_AYAH\":\"Suhardi\",\"PEKERJAAN_AYAH\":\"Ojek online\",\"TELEPON_AYAH\":\"085786719262\",\"NAMA_IBU\":\"Yani Khoirul\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (11, 1, 12, '15032627', '00714743997', 'Yunus', 'Laki-laki', 'TK', 32, 'Berhasil', '', '{\"NIS\":\"15032627\",\"NISN\":\"00714743997\",\"NAMA_LENGKAP\":\"Yunus\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"28-09-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jalan Kapten Kyai Ilyas Gang XII No.12\",\"NAMA_AYAH\":\"Yuki Dwi Baramantoro\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"085338863349\",\"NAMA_IBU\":\"Tartila\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (12, 1, 13, '16032627', '00714743998', 'Ziyad Abdullah Abqar Rafif', 'Laki-laki', 'TK', 33, 'Berhasil', '', '{\"NIS\":\"16032627\",\"NISN\":\"00714743998\",\"NAMA_LENGKAP\":\"Ziyad Abdullah Abqar Rafif\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"28-09-2021\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. RA. Kartini Perum Graha Kartini No. 9\",\"NAMA_AYAH\":\"Buasan\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"085258697477\",\"NAMA_IBU\":\"Yuli Rafika Sari\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"TK\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (13, 2, 2, '15012627', '00712051513', 'Abdurrahman Al Hafiz', 'Laki-laki', 'Kelas 1', 34, 'Berhasil', '', '{\"NIS\":\"15012627\",\"NISN\":\"00712051513\",\"NAMA_LENGKAP\":\"Abdurrahman Al Hafiz\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"16-06-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Tangkuban Perahu RT 05 RW 06 Desa Karangsari\",\"NAMA_AYAH\":\"Sudar widayatno\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"085648961292\",\"NAMA_IBU\":\"Fitrotul Adha\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (14, 2, 3, '16012627', '00712051514', 'Ahmad Zhafir', 'Laki-laki', 'Kelas 1', 35, 'Berhasil', '', '{\"NIS\":\"16012627\",\"NISN\":\"00712051514\",\"NAMA_LENGKAP\":\"Ahmad Zhafir\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"25-10-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl Panjaitan GG luntas RT 1 RW 11 no 17 citrodiwangsan\",\"NAMA_AYAH\":\"Bayu Dwi Santoso\",\"PEKERJAAN_AYAH\":\"Karyawan swasta\",\"TELEPON_AYAH\":\"085258070302\",\"NAMA_IBU\":\"Arika Desilia\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (15, 2, 4, '17022627', '00712051515', 'Amirah Izdihar Faiz', 'Perempuan', 'Kelas 1', 36, 'Berhasil', '', '{\"NIS\":\"17022627\",\"NISN\":\"00712051515\",\"NAMA_LENGKAP\":\"Amirah Izdihar Faiz\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"24-01-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Dusun Krajan Kulon RT.09 RW.02 Desa Selokbesuki Sukodono Lumajang\",\"NAMA_AYAH\":\"Muhammad Faiz Romli\",\"PEKERJAAN_AYAH\":\"Karyawan swasta\",\"TELEPON_AYAH\":\"085749019470\",\"NAMA_IBU\":\"Dewi Kurotul Aini\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (16, 2, 5, '18022627', '00712051516', 'Asma\' Albani', 'Perempuan', 'Kelas 1', 37, 'Berhasil', '', '{\"NIS\":\"18022627\",\"NISN\":\"00712051516\",\"NAMA_LENGKAP\":\"Asma\' Albani\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"18-03-2020\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Slamet Rahardjo RT. 01 RW. 01 Dsn. Umpak Desa Tanggung Kec. Padang - Lumajang\",\"NAMA_AYAH\":\"Nasirudin Albani\",\"PEKERJAAN_AYAH\":\"Karyawan\",\"TELEPON_AYAH\":\"085236701551\",\"NAMA_IBU\":\"Finna Margareta\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (17, 2, 6, '19022627', '00712051517', 'Aysha Salma Salsabila', 'Perempuan', 'Kelas 1', 38, 'Berhasil', '', '{\"NIS\":\"19022627\",\"NISN\":\"00712051517\",\"NAMA_LENGKAP\":\"Aysha Salma Salsabila\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Surabaya\",\"TANGGAL_LAHIR\":\"12-09-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Dsn. Krajan - Desa Sarimemuning - Senduro\",\"NAMA_AYAH\":\"Hadiono\",\"PEKERJAAN_AYAH\":\"Swasta\",\"TELEPON_AYAH\":\"085732802362\",\"NAMA_IBU\":\"Ika Hani Rahmayani\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (18, 2, 7, '20022627', '00712051518', 'Azkia Ramadhani Setiawan', 'Perempuan', 'Kelas 1', 39, 'Berhasil', '', '{\"NIS\":\"20022627\",\"NISN\":\"00712051518\",\"NAMA_LENGKAP\":\"Azkia Ramadhani Setiawan\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"09-06-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl Yosudarso 15 rt 01 rw 06 tompokersan Lumajang\",\"NAMA_AYAH\":\"Eko Setiawan\",\"PEKERJAAN_AYAH\":\"Swasta\",\"TELEPON_AYAH\":\"085655903746\",\"NAMA_IBU\":\"Rita Vidiana\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (19, 2, 8, '21022627', '00712051519', 'Khaulah chatam', 'Perempuan', 'Kelas 1', 40, 'Berhasil', '', '{\"NIS\":\"21022627\",\"NISN\":\"00712051519\",\"NAMA_LENGKAP\":\"Khaulah chatam\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"21-02-2020\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Kh. Wahid Hasyim Gg. 03, Tompokersan, Kec. Lumajang, Kabupaten Lumajang, Jawa Timur 67316, Indonesia\",\"NAMA_AYAH\":\"Chatam\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"082332066465 \\/ 082142004575\",\"NAMA_IBU\":\"Siti Nur Aini\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (20, 2, 9, '22022627', '00712051520', 'Maryam', 'Perempuan', 'Kelas 1', 41, 'Berhasil', '', '{\"NIS\":\"22022627\",\"NISN\":\"00712051520\",\"NAMA_LENGKAP\":\"Maryam\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"20-07-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Dusun selokambang RT. 04 RW.02 Desa Purwosono Kec. Sumbersuko\",\"NAMA_AYAH\":\"Teguh cahyono\",\"PEKERJAAN_AYAH\":\"Pedagang\",\"TELEPON_AYAH\":\"+62 877-2590-6376\",\"NAMA_IBU\":\"Reni Agustin\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (21, 2, 10, '23012627', '00712051521', 'Muhammad Ibrahim Al Fatih', 'Laki-laki', 'Kelas 1', 42, 'Berhasil', '', '{\"NIS\":\"23012627\",\"NISN\":\"00712051521\",\"NAMA_LENGKAP\":\"Muhammad Ibrahim Al Fatih\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"19-08-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Desa Sidorejo dusun wungurejo RT\\/RW 007\\/004 kecamatan Rowokangkung\",\"NAMA_AYAH\":\"Muslimin\",\"PEKERJAAN_AYAH\":\"shadow teacher\",\"TELEPON_AYAH\":\"085749569287\",\"NAMA_IBU\":\"Pristin Monotasari\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (22, 2, 11, '24012627', '00712051522', 'Muhammad Yusuf', 'Laki-laki', 'Kelas 1', 43, 'Berhasil', '', '{\"NIS\":\"24012627\",\"NISN\":\"00712051522\",\"NAMA_LENGKAP\":\"Muhammad Yusuf\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"13-08-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Desa Tukum Dusun Pandan Wangi RT. 11 RW. 04 Kec. Tekung Kab. Lumajang\",\"NAMA_AYAH\":\"Ony Tri Sanjaya\",\"PEKERJAAN_AYAH\":\"Karyawan swasta\",\"TELEPON_AYAH\":\"085101839345\",\"NAMA_IBU\":\"Nur Fadilah\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (23, 2, 12, '25022627', '00712051523', 'Nafisha Jihan Arsyila', 'Perempuan', 'Kelas 1', 44, 'Berhasil', '', '{\"NIS\":\"25022627\",\"NISN\":\"00712051523\",\"NAMA_LENGKAP\":\"Nafisha Jihan Arsyila\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"06-02-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Lapangan RT. 02 RW.04 Desa Kebonagung Sukodono\",\"NAMA_AYAH\":\"Muhammad Jihad Achponi\",\"PEKERJAAN_AYAH\":\"Operator Layanan Operasional\",\"TELEPON_AYAH\":\"085704588616\",\"NAMA_IBU\":\"Dwi Octavia Ratna Sari\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (24, 2, 13, '26022627', '00712051524', 'Nusaibah Maryam', 'Perempuan', 'Kelas 1', 45, 'Berhasil', '', '{\"NIS\":\"26022627\",\"NISN\":\"00712051524\",\"NAMA_LENGKAP\":\"Nusaibah Maryam\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"05-10-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Dusun Sumberdawe RT.01 RW.03 Desa Kunir Kidul Kec. Kunir\",\"NAMA_AYAH\":\"Agzin Anmiba Raharsan\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"081335017991\",\"NAMA_IBU\":\"Luailiyatul Makmunah\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (25, 2, 14, '27022627', '00712051525', 'RUMAYSHA ABIDAH', 'Perempuan', 'Kelas 1', 46, 'Berhasil', '', '{\"NIS\":\"27022627\",\"NISN\":\"00712051525\",\"NAMA_LENGKAP\":\"RUMAYSHA ABIDAH\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"20-08-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Dusun krajan wetan rt12 rw03 desa selokbesuki kecamatan sukodono kabupaten lumajang\",\"NAMA_AYAH\":\"Galih Susianto\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"085739273533\",\"NAMA_IBU\":\"Norita Fatatik Azizi\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (26, 2, 15, '28012627', '00712051526', 'Sabiqul Haqqi Abadan', 'Laki-laki', 'Kelas 1', 47, 'Berhasil', '', '{\"NIS\":\"28012627\",\"NISN\":\"00712051526\",\"NAMA_LENGKAP\":\"Sabiqul Haqqi Abadan\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"15-04-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jalan Ade Irma Suryani RT 01 RW 02 Rogotrunan\",\"NAMA_AYAH\":\"Faza Abid Abadan\",\"PEKERJAAN_AYAH\":\"Ojek online\",\"TELEPON_AYAH\":\"08970692999\",\"NAMA_IBU\":\"Diana Cecilia Santoso Putri\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (27, 3, 2, '01012526', '00723897520', 'Abdillah Chatam', 'Laki-Laki', 'Kelas 2', 48, 'Berhasil', '', '{\"NIS\":\"01012526\",\"NISN\":\"00723897520\",\"NAMA_LENGKAP\":\"Abdillah Chatam\",\"JENIS_KELAMIN\":\"Laki-Laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jalan k.h wahid hasyim gang 3a no 01 rt 02 rw 10\",\"NAMA_AYAH\":\"Chatam\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"082332066465\",\"NAMA_IBU\":\"Siti Nur Aini\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (28, 3, 3, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 'Perempuan', 'Kelas 2', 49, 'Berhasil', '', '{\"NIS\":\"02022526\",\"NISN\":\"00723897521\",\"NAMA_LENGKAP\":\"Aisyah Qonitah Izzuddin\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Jember\",\"TANGGAL_LAHIR\":\"19-10-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Kartini RT 3 RW 6 Tempursari Lumajang\",\"NAMA_AYAH\":\"Akhmad Izzuddin\",\"PEKERJAAN_AYAH\":\"Guru\",\"TELEPON_AYAH\":\"082232780062\",\"NAMA_IBU\":\"Yudistirawati Khusna\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (29, 3, 4, '03012526', '00723897522', 'Ammar Hakami', 'Laki-Laki', 'Kelas 2', 50, 'Berhasil', '', '{\"NIS\":\"03012526\",\"NISN\":\"00723897522\",\"NAMA_LENGKAP\":\"Ammar Hakami\",\"JENIS_KELAMIN\":\"Laki-Laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"20-05-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Dusun Sidorejo RT 4 RW 5 desa karangsari kecamatan sukodono kabupaten lumajang\",\"NAMA_AYAH\":\"Muhammad Hakam nausa\",\"PEKERJAAN_AYAH\":\"Karyawan rumah makan\",\"TELEPON_AYAH\":\"085232939995\",\"NAMA_IBU\":\"Erni Wijayanti\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (30, 3, 5, '04012526', '00723897523', 'Hamizan Umar Hermawan', 'Laki-Laki', 'Kelas 2', 51, 'Berhasil', '', '{\"NIS\":\"04012526\",\"NISN\":\"00723897523\",\"NAMA_LENGKAP\":\"Hamizan Umar Hermawan\",\"JENIS_KELAMIN\":\"Laki-Laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"21-07-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jalan Kelapa Gading 2 B2, Kelapa Gading Residence, Kel. Kepuharjo, Kec. Lumajang, Kab. Lumajang, Jawa Timur 67316\",\"NAMA_AYAH\":\"Mohammad Arief Hermawan\",\"PEKERJAAN_AYAH\":\"Pelatih Panahan\",\"TELEPON_AYAH\":\"+628113801308\",\"NAMA_IBU\":\"Rahma Eka Widyaningsih\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (31, 3, 6, '05012526', '00723897524', 'Hisham Ali Hermawan', 'Laki-Laki', 'Kelas 2', 52, 'Berhasil', '', '{\"NIS\":\"05012526\",\"NISN\":\"00723897524\",\"NAMA_LENGKAP\":\"Hisham Ali Hermawan\",\"JENIS_KELAMIN\":\"Laki-Laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"21-07-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jalan Kelapa Gading 2 B2, Kelapa Gading Residence, Kel. Kepuharjo, Kec. Lumajang, Kab. Lumajang, Jawa Timur 67316\",\"NAMA_AYAH\":\"Mohammad Arief Hermawan\",\"PEKERJAAN_AYAH\":\"Pelatih Panahan\",\"TELEPON_AYAH\":\"+628113801308\",\"NAMA_IBU\":\"Rahma Eka Widyaningsih\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (32, 3, 7, '06022526', '00723897525', 'KHADIJAH', 'Perempuan', 'Kelas 2', 53, 'Berhasil', '', '{\"NIS\":\"06022526\",\"NISN\":\"00723897525\",\"NAMA_LENGKAP\":\"KHADIJAH\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"11-11-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Dusun krajan timur Desa Tempeh tengah RT\\/RW,011\\/002 TEMPEH, LUMAJANG\",\"NAMA_AYAH\":\"MOHAMAD SYAIFUL ULUM\",\"PEKERJAAN_AYAH\":\"Karyawan swasta\",\"TELEPON_AYAH\":\"081935118875\",\"NAMA_IBU\":\"Nisviya Indahsari\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (33, 3, 8, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 'Perempuan', 'Kelas 2', 54, 'Berhasil', '', '{\"NIS\":\"07022526\",\"NISN\":\"00723897526\",\"NAMA_LENGKAP\":\"Laili Athiyyatuzzakiyah\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"14-02-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Tempeh lor\",\"NAMA_AYAH\":\"Ahmad muzakki\",\"PEKERJAAN_AYAH\":\"Swasta\",\"TELEPON_AYAH\":\"082324005127\\/082333176267\",\"NAMA_IBU\":\"Ike Agustin Ningtyas\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (34, 3, 9, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 'Laki-Laki', 'Kelas 2', 55, 'Berhasil', '', '{\"NIS\":\"08012526\",\"NISN\":\"00723897527\",\"NAMA_LENGKAP\":\"Muhammad Uwais Ibadurrahman\",\"JENIS_KELAMIN\":\"Laki-Laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"30-11-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Argopuro, Gg. H. Bisri, Lumajang\",\"NAMA_AYAH\":\"Nur Hadiyono\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"082335549474\",\"NAMA_IBU\":\"Nanik Agustin\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (35, 3, 10, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 'Perempuan', 'Kelas 2', 56, 'Berhasil', '', '{\"NIS\":\"09022526\",\"NISN\":\"00723897528\",\"NAMA_LENGKAP\":\"Nesa Humaeyra Zulkarnain\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Jember\",\"TANGGAL_LAHIR\":\"20-12-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Putri Dwi Arista Wulandari Arifin\",\"NAMA_AYAH\":\"Lubis Zulkarnain\",\"PEKERJAAN_AYAH\":\"Karyawan\",\"TELEPON_AYAH\":\"085330864556\",\"NAMA_IBU\":\"Putri Dwi Arista Wulandari A.\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (36, 3, 11, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 'Perempuan', 'Kelas 2', 57, 'Berhasil', '', '{\"NIS\":\"10022526\",\"NISN\":\"00723897529\",\"NAMA_LENGKAP\":\"SHAFIYYAH AZZAHRA\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"29-03-2019\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"JL. KH WAHID HASYIM GG 3A NO 1 RT 02 RW 10 TOMPOKERSAN LUMAJANG\",\"NAMA_AYAH\":\"HANIF AMRULLOH\",\"PEKERJAAN_AYAH\":\"KARYAWAN\",\"TELEPON_AYAH\":\"081335590406\",\"NAMA_IBU\":\"Tridewiningsih\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (37, 3, 12, '11012526', '00723897530', 'Zakaria Al Fatih', 'Laki-Laki', 'Kelas 2', 58, 'Berhasil', '', '{\"NIS\":\"11012526\",\"NISN\":\"00723897530\",\"NAMA_LENGKAP\":\"Zakaria Al Fatih\",\"JENIS_KELAMIN\":\"Laki-Laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"22-02-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Lumajang\",\"NAMA_AYAH\":\"Hariyanto\",\"PEKERJAAN_AYAH\":\"Dagang\",\"TELEPON_AYAH\":\"085607617767\",\"NAMA_IBU\":\"Yuliati\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (38, 3, 13, '12022526', '00723897531', 'Hafshoh', 'Perempuan', 'Kelas 2', 59, 'Berhasil', '', '{\"NIS\":\"12022526\",\"NISN\":\"00723897531\",\"NAMA_LENGKAP\":\"Hafshoh\",\"JENIS_KELAMIN\":\"Perempuan\",\"TEMPAT_LAHIR\":\"Trenggalek\",\"TANGGAL_LAHIR\":\"02-09-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jl. Api Jam\'ari RT\\/RW : 002\\/010 Kelurahan Jogotrunan Lumajang\",\"NAMA_AYAH\":\"Mokhamad Firman Sofi\'i\",\"PEKERJAAN_AYAH\":\"Wirausaha\",\"TELEPON_AYAH\":\"087755007144\",\"NAMA_IBU\":\"Lusiana Kurniati Rohimah\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (39, 3, 14, '13012526', '00723897532', 'Bilal', 'Laki-laki', 'Kelas 2', 60, 'Berhasil', '', '{\"NIS\":\"13012526\",\"NISN\":\"00723897532\",\"NAMA_LENGKAP\":\"Bilal\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"20-03-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"Jalan Kapten Kyai Ilyas Gang XII No. 12\",\"NAMA_AYAH\":\"Yuki Dwi Bramantoro\",\"PEKERJAAN_AYAH\":\"Karyawan\",\"TELEPON_AYAH\":\"085138738100\",\"NAMA_IBU\":\"Tartila\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');
INSERT INTO `tagihan_import_siswa_detail` VALUES (40, 3, 15, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 'Laki-laki', 'Kelas 2', 61, 'Berhasil', '', '{\"NIS\":\"14012526\",\"NISN\":\"00723897533\",\"NAMA_LENGKAP\":\"Muhammad Ibnu Abdillah\",\"JENIS_KELAMIN\":\"Laki-laki\",\"TEMPAT_LAHIR\":\"Lumajang\",\"TANGGAL_LAHIR\":\"10-10-2018\",\"TANGGAL_AWAL_MASUK\":\"01-07-2026\",\"ALAMAT\":\"\",\"NAMA_AYAH\":\"Muhammad Guntur Susanto\",\"PEKERJAAN_AYAH\":\"Wiraswasta\",\"TELEPON_AYAH\":\"085648961292\",\"NAMA_IBU\":\"Yulia Sofyani\",\"PEKERJAAN_IBU\":\"\",\"TELEPON_IBU\":\"\",\"NAMA_KELAS\":\"\"}');

-- ----------------------------
-- Table structure for tagihan_jenis
-- ----------------------------
DROP TABLE IF EXISTS `tagihan_jenis`;
CREATE TABLE `tagihan_jenis`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_jenis` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_jenis` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipe_default` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Bulanan/Langsung/Tahunan',
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
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_jenis
-- ----------------------------
INSERT INTO `tagihan_jenis` VALUES (8, 'SPP73468', 'SPP', 'Bulanan', 'Aktif', 'Jenis tagihan SPP bulanan', '28-08-2026', '08:25:20', 17, 'admin');
INSERT INTO `tagihan_jenis` VALUES (9, 'KEG23685', 'Kegiatan Tahunan Outbound', 'Tahunan', 'Aktif', 'Tagihan Tahunan Outbound', '28-08-2026', '08:26:24', 17, 'admin');
INSERT INTO `tagihan_jenis` VALUES (10, 'TAGBU8192', 'Tagihan Buku', 'Langsung', 'Aktif', 'Tagihan Buku Langsung', '28-08-2026', '08:27:07', 17, 'admin');
INSERT INTO `tagihan_jenis` VALUES (11, 'KEGSU123', 'Sumbangan Anak Yatim', 'Langsung', 'Aktif', '', '28-08-2026', '09:04:34', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 466 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_log_aktivitas
-- ----------------------------
INSERT INTO `tagihan_log_aktivitas` VALUES (406, 'Terbitkan Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '18', 'TGH/202608/00001', 'Tagihan SPP Bulanan - 78 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":5,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":50000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2026,\"bulan_selesai\":12,\"tahun_selesai\":2026,\"bulan_penagihan\":7,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"13:05:05\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '13:05:05', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (407, 'Simpan Draft Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '19', 'TGH/202608/00002', 'Sumbangan Jum\'at berkah - 0 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00002\",\"id_jenis_tagihan\":6,\"nama_jenis_tagihan\":\"Kegiatan Pilihan\",\"nama_tagihan\":\"Sumbangan Jum\'at berkah\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":5000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":1,\"tahun_mulai\":2026,\"bulan_selesai\":1,\"tahun_selesai\":2026,\"bulan_penagihan\":1,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"13:07:35\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '13:07:35', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (408, 'Edit Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '19', 'TGH/202608/00002', 'Mengubah draft tagihan sebelum diterbitkan.', '{\"id\":\"19\",\"kode_tagihan\":\"TGH\\/202608\\/00002\",\"id_jenis_tagihan\":\"6\",\"nama_jenis_tagihan\":\"Kegiatan Pilihan\",\"nama_tagihan\":\"Sumbangan Jum\'at berkah\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"5000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"13:07:35\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"id\":\"19\",\"kode_tagihan\":\"TGH\\/202608\\/00002\",\"id_jenis_tagihan\":\"6\",\"nama_jenis_tagihan\":\"Kegiatan Pilihan\",\"nama_tagihan\":\"Sumbangan Jum\'at berkah\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":5000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"13:07:35\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"27-08-2026\",\"waktu_update\":\"13:07:40\",\"id_user_update\":17,\"nama_user_update\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '13:07:40', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (409, 'Terbitkan Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '19', 'TGH/202608/00002', '27 tagihan diterbitkan', '{\"id\":\"19\",\"kode_tagihan\":\"TGH\\/202608\\/00002\",\"id_jenis_tagihan\":\"6\",\"nama_jenis_tagihan\":\"Kegiatan Pilihan\",\"nama_tagihan\":\"Sumbangan Jum\'at berkah\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"5000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"13:07:35\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"27-08-2026\",\"waktu_update\":\"13:07:40\",\"id_user_update\":\"17\",\"nama_user_update\":\"admin\"}', '{\"status\":\"Aktif\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '13:07:46', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (410, 'Tambah Metode Pembayaran', 'Master Data', 'Tambah', 'tagihan_metode_pembayaran', '10', 'MET-TUNAI', 'Pengelolaan metode pembayaran', NULL, '{\"kode_metode\":\"MET-TUNAI\",\"nama_metode\":\"Tunai\",\"jenis_metode\":\"Tunai\",\"butuh_uang_diterima\":\"Ya\",\"status\":\"Aktif\",\"urutan\":1,\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"14:01:52\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '14:01:52', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (411, 'Tambah Metode Pembayaran', 'Master Data', 'Tambah', 'tagihan_metode_pembayaran', '11', 'MET-TRANSFER', 'Pengelolaan metode pembayaran', NULL, '{\"kode_metode\":\"MET-TRANSFER\",\"nama_metode\":\"Transfer\",\"jenis_metode\":\"Transfer\",\"butuh_uang_diterima\":\"Tidak\",\"status\":\"Aktif\",\"urutan\":2,\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"14:01:57\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '14:01:57', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (412, 'Tambah Metode Pembayaran', 'Master Data', 'Tambah', 'tagihan_metode_pembayaran', '12', 'MET-QRIS', 'Pengelolaan metode pembayaran', NULL, '{\"kode_metode\":\"MET-QRIS\",\"nama_metode\":\"Qris\",\"jenis_metode\":\"QRIS\",\"butuh_uang_diterima\":\"Tidak\",\"status\":\"Aktif\",\"urutan\":3,\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"14:02:03\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '14:02:03', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (413, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '29', 'BYR/202608/00001', 'Pembayaran Aisyah Qonitah Izzuddin sebesar Rp25.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00001\",\"tanggal_transaksi\":\"27-08-2026\",\"waktu_transaksi\":\"14:03:00\",\"id_siswa\":49,\"nis\":\"02022526\",\"nisn\":\"00723897521\",\"nama_siswa\":\"Aisyah Qonitah Izzuddin\",\"id_kelas_setting\":50,\"id_kelas\":19,\"nama_kelas\":\"Kelas 2\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":25000,\"total_potongan\":0,\"total_pembayaran\":25000,\"id_metode_pembayaran\":10,\"nama_metode_pembayaran\":\"Tunai\",\"uang_diterima\":25000,\"kembalian\":0,\"referensi_pembayaran\":\"\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"Pembayaran dilakukan dengan cara mencicil\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '14:03:00', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (414, 'Batalkan Sisa Tagihan', 'Tagihan', 'Batal', 'tagihan_master', '18', 'TGH/202608/00001', '.', '{\"id\":\"18\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"5\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"50000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"7\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"12\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"7\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"13:05:05\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"status\":\"Dibatalkan\",\"jumlah\":78}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '16:19:01', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (415, 'Batalkan Sisa Tagihan', 'Tagihan', 'Batal', 'tagihan_master', '19', 'TGH/202608/00002', '.', '{\"id\":\"19\",\"kode_tagihan\":\"TGH\\/202608\\/00002\",\"id_jenis_tagihan\":\"6\",\"nama_jenis_tagihan\":\"Kegiatan Pilihan\",\"nama_tagihan\":\"Sumbangan Jum\'at berkah\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"5000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"13:07:35\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"27-08-2026\",\"waktu_update\":\"13:07:46\",\"id_user_update\":\"17\",\"nama_user_update\":\"admin\"}', '{\"status\":\"Dibatalkan\",\"jumlah\":27}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '16:19:20', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (416, 'Simpan Draft Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '20', 'TGH/202608/00003', 'rger - 0 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00003\",\"id_jenis_tagihan\":5,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"rger\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":100000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2026,\"bulan_selesai\":8,\"tahun_selesai\":2026,\"bulan_penagihan\":7,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"27-08-2026\",\"waktu\":\"16:27:25\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '16:27:25', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (417, 'Reset Password Wali Murid', 'Master Data', 'Ubah', 'wali_murid', '2', 'WALI/202608/00001', 'Reset password akun portal wali murid', '{\"wajib_ganti_password\":\"Tidak\"}', '{\"wajib_ganti_password\":\"Ya\",\"tanggal_password_update\":\"27-08-2026\",\"waktu_password_update\":\"16:54:42\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '27-08-2026', '16:54:42', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (418, 'Tambah Jenis Tagihan', 'Master Data', 'Tambah', 'tagihan_jenis', '8', 'SPP73468', 'Menambah jenis tagihan.', NULL, '{\"kode_jenis\":\"SPP73468\",\"nama_jenis\":\"SPP\",\"tipe_default\":\"Bulanan\",\"status\":\"Aktif\",\"keterangan\":\"Jenis tagihan SPP bulanan\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:25:20\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '28-08-2026', '08:25:20', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (419, 'Tambah Jenis Tagihan', 'Master Data', 'Tambah', 'tagihan_jenis', '9', 'KEG23685', 'Menambah jenis tagihan.', NULL, '{\"kode_jenis\":\"KEG23685\",\"nama_jenis\":\"Kegiatan Tahunan Outbound\",\"tipe_default\":\"Tahunan\",\"status\":\"Aktif\",\"keterangan\":\"Tagihan Tahunan Outbound\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:26:24\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:26:24', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (420, 'Tambah Jenis Tagihan', 'Master Data', 'Tambah', 'tagihan_jenis', '10', 'TAGBU8192', 'Menambah jenis tagihan.', NULL, '{\"kode_jenis\":\"TAGBU8192\",\"nama_jenis\":\"Tagihan Buku\",\"tipe_default\":\"Langsung\",\"status\":\"Aktif\",\"keterangan\":\"Tagihan Buku Langsung\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:27:07\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:27:07', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (421, 'Simpan Draft Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '21', 'TGH/202608/00001', 'Tagihan SPP Bulanan - 0 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":8,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":50000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2026,\"bulan_selesai\":6,\"tahun_selesai\":2027,\"bulan_penagihan\":7,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:28:36\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:28:36', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (422, 'Edit Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '21', 'TGH/202608/00001', 'Mengubah informasi, periode, tarif, dan target draft sebelum diterbitkan.', '{\"id\":\"21\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"8\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"50000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"7\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"6\",\"tahun_selesai\":\"2027\",\"bulan_penagihan\":\"7\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:28:36\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"id\":\"21\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":8,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":50000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2026,\"bulan_selesai\":6,\"tahun_selesai\":2027,\"bulan_penagihan\":7,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:28:36\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"08:29:17\",\"id_user_update\":17,\"nama_user_update\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:29:17', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (423, 'Edit Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '21', 'TGH/202608/00001', 'Mengubah informasi, periode, tarif, dan target draft sebelum diterbitkan.', '{\"id\":\"21\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"8\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"50000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"7\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"6\",\"tahun_selesai\":\"2027\",\"bulan_penagihan\":\"7\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:28:36\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"08:29:17\",\"id_user_update\":\"17\",\"nama_user_update\":\"admin\"}', '{\"id\":\"21\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":8,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":50000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2026,\"bulan_selesai\":6,\"tahun_selesai\":2027,\"bulan_penagihan\":7,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:28:36\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"08:29:26\",\"id_user_update\":17,\"nama_user_update\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:29:26', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (424, 'Edit Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '21', 'TGH/202608/00001', 'Mengubah informasi, periode, tarif, dan target draft sebelum diterbitkan.', '{\"id\":\"21\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"8\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"50000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"7\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"6\",\"tahun_selesai\":\"2027\",\"bulan_penagihan\":\"7\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:28:36\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"08:29:26\",\"id_user_update\":\"17\",\"nama_user_update\":\"admin\"}', '{\"id\":\"21\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":8,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":50000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2026,\"bulan_selesai\":6,\"tahun_selesai\":2027,\"bulan_penagihan\":7,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:28:36\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"08:30:11\",\"id_user_update\":17,\"nama_user_update\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (425, 'Terbitkan Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '21', 'TGH/202608/00001', '156 tagihan diterbitkan.', '{\"id\":\"21\",\"kode_tagihan\":\"TGH\\/202608\\/00001\",\"id_jenis_tagihan\":\"8\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"50000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"7\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"6\",\"tahun_selesai\":\"2027\",\"bulan_penagihan\":\"7\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:28:36\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"08:30:11\",\"id_user_update\":\"17\",\"nama_user_update\":\"admin\"}', '{\"status\":\"Aktif\",\"jumlah_tagihan\":156}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:30:16', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (426, 'Terbitkan Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '22', 'TGH/202608/00002', 'Kegiatan Outbound Ke Semeru - 27 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00002\",\"id_jenis_tagihan\":9,\"nama_jenis_tagihan\":\"Kegiatan Tahunan Outbound\",\"nama_tagihan\":\"Kegiatan Outbound Ke Semeru\",\"tipe_tagihan\":\"Tahunan\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":25000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":8,\"tahun_mulai\":2026,\"bulan_selesai\":8,\"tahun_selesai\":2026,\"bulan_penagihan\":8,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-08-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:32:20\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:32:20', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (427, 'Edit Tagihan Terbit', 'Tagihan', 'Ubah', 'tagihan_master', '22', 'TGH/202608/00002', 'Nominal/jatuh tempo diperbarui untuk 27 tagihan siswa belum bayar; 0 tagihan yang sudah memiliki pembayaran dipertahankan.', '{\"id\":\"22\",\"kode_tagihan\":\"TGH\\/202608\\/00002\",\"id_jenis_tagihan\":\"9\",\"nama_jenis_tagihan\":\"Kegiatan Tahunan Outbound\",\"nama_tagihan\":\"Kegiatan Outbound Ke Semeru\",\"tipe_tagihan\":\"Tahunan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"25000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"8\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"8\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"8\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-08-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:32:20\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:33:01', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (428, 'Edit Tagihan Terbit', 'Tagihan', 'Ubah', 'tagihan_master', '22', 'TGH/202608/00002', 'Nominal/jatuh tempo diperbarui untuk 27 tagihan siswa belum bayar; 0 tagihan yang sudah memiliki pembayaran dipertahankan.', '{\"id\":\"22\",\"kode_tagihan\":\"TGH\\/202608\\/00002\",\"id_jenis_tagihan\":\"9\",\"nama_jenis_tagihan\":\"Kegiatan Tahunan Outbound\",\"nama_tagihan\":\"Kegiatan Outbound Ke Semeru\",\"tipe_tagihan\":\"Tahunan\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"25000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"8\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"8\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"8\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"01-08-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:32:20\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"08:33:01\",\"id_user_update\":\"17\",\"nama_user_update\":\"admin\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:34:16', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (429, 'Tambah Metode Pembayaran', 'Master Data', 'Tambah', 'tagihan_metode_pembayaran', '13', 'MET-TUNAI', 'Pengelolaan metode pembayaran', NULL, '{\"kode_metode\":\"MET-TUNAI\",\"nama_metode\":\"Tunai\",\"jenis_metode\":\"Tunai\",\"butuh_uang_diterima\":\"Ya\",\"status\":\"Aktif\",\"urutan\":1,\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:35:10\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:35:10', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (430, 'Tambah Metode Pembayaran', 'Master Data', 'Tambah', 'tagihan_metode_pembayaran', '14', 'MET-TRANSFER', 'Pengelolaan metode pembayaran', NULL, '{\"kode_metode\":\"MET-TRANSFER\",\"nama_metode\":\"Transfer\",\"jenis_metode\":\"Transfer\",\"butuh_uang_diterima\":\"Tidak\",\"status\":\"Aktif\",\"urutan\":2,\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:35:16\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:35:16', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (431, 'Tambah Metode Pembayaran', 'Master Data', 'Tambah', 'tagihan_metode_pembayaran', '15', 'MET-QRIS', 'Pengelolaan metode pembayaran', NULL, '{\"kode_metode\":\"MET-QRIS\",\"nama_metode\":\"Qris\",\"jenis_metode\":\"QRIS\",\"butuh_uang_diterima\":\"Tidak\",\"status\":\"Aktif\",\"urutan\":3,\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"08:35:21\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:35:21', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (432, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '30', 'BYR/202608/00001', 'Pembayaran Aisyah Qonitah Izzuddin sebesar Rp25.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00001\",\"tanggal_transaksi\":\"28-08-2026\",\"waktu_transaksi\":\"08:36:01\",\"id_siswa\":49,\"nis\":\"02022526\",\"nisn\":\"00723897521\",\"nama_siswa\":\"Aisyah Qonitah Izzuddin\",\"id_kelas_setting\":50,\"id_kelas\":19,\"nama_kelas\":\"Kelas 2\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":25000,\"total_potongan\":0,\"total_pembayaran\":25000,\"id_metode_pembayaran\":13,\"nama_metode_pembayaran\":\"Tunai\",\"uang_diterima\":25000,\"kembalian\":0,\"referensi_pembayaran\":\"\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:36:01', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (433, 'Cetak Ulang Bukti', 'Transaksi', 'Cetak', 'tagihan_pembayaran', '30', 'BYR/202608/00001', 'Bukti pembayaran dicetak/disimpan PDF.', NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:47:53', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (434, 'Reset Password Wali Murid', 'Master Data', 'Ubah', 'wali_murid', '2', 'WALI/202608/00001', 'Reset password akun portal wali murid', '{\"wajib_ganti_password\":\"Tidak\"}', '{\"wajib_ganti_password\":\"Tidak\",\"tanggal_password_update\":\"28-08-2026\",\"waktu_password_update\":\"08:59:45\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '08:59:45', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (435, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '31', 'BYR/202608/00002', 'Pembayaran Aisyah Qonitah Izzuddin sebesar Rp50.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00002\",\"tanggal_transaksi\":\"28-08-2026\",\"waktu_transaksi\":\"09:03:04\",\"id_siswa\":49,\"nis\":\"02022526\",\"nisn\":\"00723897521\",\"nama_siswa\":\"Aisyah Qonitah Izzuddin\",\"id_kelas_setting\":50,\"id_kelas\":19,\"nama_kelas\":\"Kelas 2\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":50000,\"total_potongan\":0,\"total_pembayaran\":50000,\"id_metode_pembayaran\":15,\"nama_metode_pembayaran\":\"Qris\",\"uang_diterima\":50000,\"kembalian\":0,\"referensi_pembayaran\":\"Gopay\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:03:04', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (436, 'Tambah Jenis Tagihan', 'Master Data', 'Tambah', 'tagihan_jenis', '11', 'KEGSU123', 'Menambah jenis tagihan.', NULL, '{\"kode_jenis\":\"KEGSU123\",\"nama_jenis\":\"Sumbangan Anak Yatim\",\"tipe_default\":\"Langsung\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"09:04:34\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:04:34', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (437, 'Terbitkan Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '23', 'TGH/202608/00003', 'Sumbangan Anak Yatim & Piatu - 27 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00003\",\"id_jenis_tagihan\":11,\"nama_jenis_tagihan\":\"Sumbangan Anak Yatim\",\"nama_tagihan\":\"Sumbangan Anak Yatim & Piatu\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":10000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":8,\"tahun_mulai\":2026,\"bulan_selesai\":8,\"tahun_selesai\":2026,\"bulan_penagihan\":8,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"27-08-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"09:05:31\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:05:31', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (438, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '32', 'BYR/202608/00003', 'Pembayaran Aisyah Qonitah Izzuddin sebesar Rp10.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00003\",\"tanggal_transaksi\":\"28-08-2026\",\"waktu_transaksi\":\"09:06:55\",\"id_siswa\":49,\"nis\":\"02022526\",\"nisn\":\"00723897521\",\"nama_siswa\":\"Aisyah Qonitah Izzuddin\",\"id_kelas_setting\":50,\"id_kelas\":19,\"nama_kelas\":\"Kelas 2\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":10000,\"total_potongan\":0,\"total_pembayaran\":10000,\"id_metode_pembayaran\":13,\"nama_metode_pembayaran\":\"Tunai\",\"uang_diterima\":10000,\"kembalian\":0,\"referensi_pembayaran\":\"\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:06:55', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (439, 'Batalkan Sisa Tagihan', 'Tagihan', 'Batal', 'tagihan_master', '23', 'TGH/202608/00003', 'Sudah melewati hari', '{\"id\":\"23\",\"kode_tagihan\":\"TGH\\/202608\\/00003\",\"id_jenis_tagihan\":\"11\",\"nama_jenis_tagihan\":\"Sumbangan Anak Yatim\",\"nama_tagihan\":\"Sumbangan Anak Yatim & Piatu\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"10000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"8\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"8\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"8\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"27-08-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"09:05:31\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"status\":\"Dibatalkan\",\"jumlah_sisa_dibatalkan\":26}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:07:18', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (440, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '33', 'BYR/202608/00004', 'Pembayaran Hamizan Umar Hermawan sebesar Rp10.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00004\",\"tanggal_transaksi\":\"28-08-2026\",\"waktu_transaksi\":\"09:23:05\",\"id_siswa\":51,\"nis\":\"04012526\",\"nisn\":\"00723897523\",\"nama_siswa\":\"Hamizan Umar Hermawan\",\"id_kelas_setting\":50,\"id_kelas\":19,\"nama_kelas\":\"Kelas 2\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":10000,\"total_potongan\":0,\"total_pembayaran\":10000,\"id_metode_pembayaran\":13,\"nama_metode_pembayaran\":\"Tunai\",\"uang_diterima\":10000,\"kembalian\":0,\"referensi_pembayaran\":\"\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"Ada hal lain yang diperlukan\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:23:05', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (441, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '34', 'BYR/202608/00005', 'Pembayaran Hamizan Umar Hermawan sebesar Rp25.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00005\",\"tanggal_transaksi\":\"28-08-2026\",\"waktu_transaksi\":\"09:23:43\",\"id_siswa\":51,\"nis\":\"04012526\",\"nisn\":\"00723897523\",\"nama_siswa\":\"Hamizan Umar Hermawan\",\"id_kelas_setting\":50,\"id_kelas\":19,\"nama_kelas\":\"Kelas 2\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":25000,\"total_potongan\":0,\"total_pembayaran\":25000,\"id_metode_pembayaran\":13,\"nama_metode_pembayaran\":\"Tunai\",\"uang_diterima\":25000,\"kembalian\":0,\"referensi_pembayaran\":\"\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:23:44', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (442, 'Reset Password Wali Murid', 'Master Data', 'Ubah', 'wali_murid', '2', 'WALI/202608/00001', 'Reset password akun portal wali murid', '{\"wajib_ganti_password\":\"Tidak\"}', '{\"wajib_ganti_password\":\"Ya\",\"tanggal_password_update\":\"28-08-2026\",\"waktu_password_update\":\"09:25:58\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:25:58', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (443, 'Terbitkan Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '24', 'TGH/202608/00004', 'Tagihan SPP Bulanan kelas 10 - 12 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00004\",\"id_jenis_tagihan\":8,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"Tagihan SPP Bulanan kelas 10\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":100000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2026,\"bulan_selesai\":6,\"tahun_selesai\":2027,\"bulan_penagihan\":7,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-07-2026\",\"target_tagihan\":\"Kelas\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"09:33:34\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (444, 'Simpan Draft Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '25', 'TGH/202608/00005', 'gwegwe - 0 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00005\",\"id_jenis_tagihan\":8,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"gwegwe\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":99,\"periode\":\"2027\\/2028\",\"semester\":null,\"nominal_default\":111111,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2027,\"bulan_selesai\":6,\"tahun_selesai\":2028,\"bulan_penagihan\":7,\"tahun_penagihan\":2027,\"tanggal_jatuh_tempo\":\"31-07-2027\",\"target_tagihan\":\"Siswa\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"09:39:20\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:39:20', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (445, 'Edit Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '25', 'TGH/202608/00005', 'Mengubah informasi, periode, tarif, dan target draft sebelum diterbitkan.', '{\"id\":\"25\",\"kode_tagihan\":\"TGH\\/202608\\/00005\",\"id_jenis_tagihan\":\"8\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"gwegwe\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"99\",\"periode\":\"2027\\/2028\",\"semester\":null,\"nominal_default\":\"111111.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"7\",\"tahun_mulai\":\"2027\",\"bulan_selesai\":\"6\",\"tahun_selesai\":\"2028\",\"bulan_penagihan\":\"7\",\"tahun_penagihan\":\"2027\",\"tanggal_jatuh_tempo\":\"31-07-2027\",\"target_tagihan\":\"Siswa\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"09:39:20\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"id\":\"25\",\"kode_tagihan\":\"TGH\\/202608\\/00005\",\"id_jenis_tagihan\":8,\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"gwegwe\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"99\",\"periode\":\"2027\\/2028\",\"semester\":null,\"nominal_default\":111111,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":7,\"tahun_mulai\":2027,\"bulan_selesai\":12,\"tahun_selesai\":2027,\"bulan_penagihan\":7,\"tahun_penagihan\":2027,\"tanggal_jatuh_tempo\":\"31-07-2027\",\"target_tagihan\":\"Siswa\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"09:39:20\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"09:41:54\",\"id_user_update\":17,\"nama_user_update\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:41:54', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (446, 'Hapus Draft Tagihan', 'Tagihan', 'Batal', 'tagihan_master', '25', 'TGH/202608/00005', 'Menghapus draft tagihan yang belum diterbitkan.', '{\"id\":\"25\",\"kode_tagihan\":\"TGH\\/202608\\/00005\",\"id_jenis_tagihan\":\"8\",\"nama_jenis_tagihan\":\"SPP\",\"nama_tagihan\":\"gwegwe\",\"tipe_tagihan\":\"Bulanan\",\"id_periode\":\"99\",\"periode\":\"2027\\/2028\",\"semester\":null,\"nominal_default\":\"111111.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"7\",\"tahun_mulai\":\"2027\",\"bulan_selesai\":\"12\",\"tahun_selesai\":\"2027\",\"bulan_penagihan\":\"7\",\"tahun_penagihan\":\"2027\",\"tanggal_jatuh_tempo\":\"31-07-2027\",\"target_tagihan\":\"Siswa\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"09:39:20\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"09:41:54\",\"id_user_update\":\"17\",\"nama_user_update\":\"admin\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '09:42:06', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (447, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '35', 'BYR/202608/00006', 'Pembayaran Hamizan Umar Hermawan sebesar Rp565.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00006\",\"tanggal_transaksi\":\"28-08-2026\",\"waktu_transaksi\":\"10:31:01\",\"id_siswa\":51,\"nis\":\"04012526\",\"nisn\":\"00723897523\",\"nama_siswa\":\"Hamizan Umar Hermawan\",\"id_kelas_setting\":50,\"id_kelas\":19,\"nama_kelas\":\"Kelas 2\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":565000,\"total_potongan\":0,\"total_pembayaran\":565000,\"id_metode_pembayaran\":14,\"nama_metode_pembayaran\":\"Transfer\",\"uang_diterima\":565000,\"kembalian\":0,\"referensi_pembayaran\":\"BSI\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '10:31:01', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (448, 'Terima Pembayaran', 'Transaksi', 'Tambah', 'tagihan_pembayaran', '36', 'BYR/202608/00007', 'Pembayaran Abdillah Chatam sebesar Rp1.200.000', NULL, '{\"no_transaksi\":\"BYR\\/202608\\/00007\",\"tanggal_transaksi\":\"28-08-2026\",\"waktu_transaksi\":\"11:21:49\",\"id_siswa\":48,\"nis\":\"01012526\",\"nisn\":\"00723897520\",\"nama_siswa\":\"Abdillah Chatam\",\"id_kelas_setting\":51,\"id_kelas\":20,\"nama_kelas\":\"Kelas 3\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"total_tagihan_dipilih\":1200000,\"total_potongan\":0,\"total_pembayaran\":1200000,\"id_metode_pembayaran\":14,\"nama_metode_pembayaran\":\"Transfer\",\"uang_diterima\":1200000,\"kembalian\":0,\"referensi_pembayaran\":\"BSI\",\"status_transaksi\":\"Aktif\",\"status_cetak\":\"Belum\",\"jumlah_cetak\":0,\"status_kirim_whatsapp\":\"Belum\",\"keterangan\":\"\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '11:21:49', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (449, 'Terbitkan Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '26', 'TGH/202608/00005', 'Tagihan SPP Bulanan - 27 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00005\",\"id_jenis_tagihan\":11,\"nama_jenis_tagihan\":\"Sumbangan Anak Yatim\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":2000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":1,\"tahun_mulai\":2026,\"bulan_selesai\":1,\"tahun_selesai\":2026,\"bulan_penagihan\":1,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"11:25:46\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '11:25:46', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (450, 'Batalkan Sisa Tagihan', 'Tagihan', 'Batal', 'tagihan_master', '26', 'TGH/202608/00005', 'salah', '{\"id\":\"26\",\"kode_tagihan\":\"TGH\\/202608\\/00005\",\"id_jenis_tagihan\":\"11\",\"nama_jenis_tagihan\":\"Sumbangan Anak Yatim\",\"nama_tagihan\":\"Tagihan SPP Bulanan\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"2000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"11:25:46\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"status\":\"Dibatalkan\",\"jumlah_sisa_dibatalkan\":27}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '11:26:33', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (451, 'Simpan Draft Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '27', 'TGH/202608/00006', 'Slametan - 0 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00006\",\"id_jenis_tagihan\":11,\"nama_jenis_tagihan\":\"Sumbangan Anak Yatim\",\"nama_tagihan\":\"Slametan\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":10000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":1,\"tahun_mulai\":2026,\"bulan_selesai\":1,\"tahun_selesai\":2026,\"bulan_penagihan\":1,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"11:27:11\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '11:27:11', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (452, 'Terbitkan Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '27', 'TGH/202608/00006', '27 tagihan diterbitkan.', '{\"id\":\"27\",\"kode_tagihan\":\"TGH\\/202608\\/00006\",\"id_jenis_tagihan\":\"11\",\"nama_jenis_tagihan\":\"Sumbangan Anak Yatim\",\"nama_tagihan\":\"Slametan\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"10000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"11:27:11\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"status\":\"Aktif\",\"jumlah_tagihan\":27}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '11:27:20', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (453, 'Batalkan Sisa Tagihan', 'Tagihan', 'Batal', 'tagihan_master', '27', 'TGH/202608/00006', 'salah', '{\"id\":\"27\",\"kode_tagihan\":\"TGH\\/202608\\/00006\",\"id_jenis_tagihan\":\"11\",\"nama_jenis_tagihan\":\"Sumbangan Anak Yatim\",\"nama_tagihan\":\"Slametan\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"10000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Tidak\",\"status_generate\":\"Selesai\",\"status\":\"Aktif\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"11:27:11\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":\"28-08-2026\",\"waktu_update\":\"11:27:20\",\"id_user_update\":\"17\",\"nama_user_update\":\"admin\"}', '{\"status\":\"Dibatalkan\",\"jumlah_sisa_dibatalkan\":27}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '11:28:04', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (454, 'Simpan Draft Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '28', 'TGH/202608/00007', 'buku tulis - 0 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00007\",\"id_jenis_tagihan\":10,\"nama_jenis_tagihan\":\"Tagihan Buku\",\"nama_tagihan\":\"buku tulis\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":50000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":1,\"tahun_mulai\":2026,\"bulan_selesai\":1,\"tahun_selesai\":2026,\"bulan_penagihan\":1,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"11:28:30\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '11:28:30', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (455, 'Terbitkan Draft Tagihan', 'Tagihan', 'Ubah', 'tagihan_master', '28', 'TGH/202608/00007', '27 tagihan diterbitkan.', '{\"id\":\"28\",\"kode_tagihan\":\"TGH\\/202608\\/00007\",\"id_jenis_tagihan\":\"10\",\"nama_jenis_tagihan\":\"Tagihan Buku\",\"nama_tagihan\":\"buku tulis\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"50000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"11:28:30\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', '{\"status\":\"Aktif\",\"jumlah_tagihan\":27}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '11:28:38', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (456, 'Simpan Draft Tagihan', 'Tagihan', 'Tambah', 'tagihan_master', '29', 'TGH/202608/00008', 'buku - 0 tagihan siswa', NULL, '{\"kode_tagihan\":\"TGH\\/202608\\/00008\",\"id_jenis_tagihan\":10,\"nama_jenis_tagihan\":\"Tagihan Buku\",\"nama_tagihan\":\"buku\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":98,\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":5000,\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":1,\"tahun_mulai\":2026,\"bulan_selesai\":1,\"tahun_selesai\":2026,\"bulan_penagihan\":1,\"tahun_penagihan\":2026,\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"15:27:42\",\"id_user\":17,\"nama_user\":\"admin\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '15:27:42', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (457, 'Hapus Draft Tagihan', 'Tagihan', 'Batal', 'tagihan_master', '29', 'TGH/202608/00008', 'Menghapus draft tagihan yang belum diterbitkan.', '{\"id\":\"29\",\"kode_tagihan\":\"TGH\\/202608\\/00008\",\"id_jenis_tagihan\":\"10\",\"nama_jenis_tagihan\":\"Tagihan Buku\",\"nama_tagihan\":\"buku\",\"tipe_tagihan\":\"Langsung\",\"id_periode\":\"98\",\"periode\":\"2026\\/2027\",\"semester\":null,\"nominal_default\":\"5000.00\",\"model_tarif_bulanan\":\"Sama\",\"bulan_mulai\":\"1\",\"tahun_mulai\":\"2026\",\"bulan_selesai\":\"1\",\"tahun_selesai\":\"2026\",\"bulan_penagihan\":\"1\",\"tahun_penagihan\":\"2026\",\"tanggal_jatuh_tempo\":\"31-01-2026\",\"target_tagihan\":\"Semua\",\"dianggap_tunggakan\":\"Ya\",\"status_generate\":\"Belum\",\"status\":\"Draft\",\"keterangan\":\"\",\"tanggal\":\"28-08-2026\",\"waktu\":\"15:27:42\",\"id_user\":\"17\",\"nama_user\":\"admin\",\"tanggal_update\":null,\"waktu_update\":null,\"id_user_update\":\"0\",\"nama_user_update\":null}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '15:27:54', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (458, 'Pindah Kelas', 'Kesiswaan', 'Ubah', 'kelas_siswa', '48', '01012526', 'Kelas 3 ke TK', '{\"kelas\":{\"id\":\"51\",\"id_kelas\":\"20\",\"nama_kelas\":\"Kelas 3\",\"id_guru\":null,\"wali_kelas\":null,\"id_periode\":\"98\",\"semester\":null}}', '{\"kelas\":{\"id\":\"48\",\"id_kelas\":\"17\",\"nama_kelas\":\"TK\",\"id_guru\":null,\"wali_kelas\":null,\"id_periode\":\"98\",\"semester\":null},\"alasan\":\"test\"}', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '28-08-2026', '15:59:35', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (459, 'Pindah Kelas', 'Kesiswaan', 'Ubah', 'kelas_siswa', '48', '01012526', 'TK ke Kelas 3', '{\"kelas\":{\"id\":\"48\",\"id_kelas\":\"17\",\"nama_kelas\":\"TK\",\"id_guru\":null,\"wali_kelas\":null,\"id_periode\":\"98\",\"semester\":null}}', '{\"kelas\":{\"id\":\"51\",\"id_kelas\":\"20\",\"nama_kelas\":\"Kelas 3\",\"id_guru\":null,\"wali_kelas\":null,\"id_periode\":\"98\",\"semester\":null},\"alasan\":\"real\"}', '::1', 'Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Mobile Safari/537.36', '28-08-2026', '16:00:18', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (460, 'Koreksi Penempatan Siswa', 'Kesiswaan', 'Ubah', 'kelas_siswa', '48', '01012526', 'Kelas 3 dikoreksi menjadi Kelas 2 - salah kelas', '{\"kelas\":{\"id_kelas_siswa\":\"110\",\"id\":\"51\",\"id_kelas\":\"20\",\"nama_kelas\":\"Kelas 3\",\"id_guru\":null,\"wali_kelas\":null,\"id_periode\":\"98\",\"semester\":null,\"periode\":\"2026\\/2027\"}}', '{\"kelas\":{\"id\":\"50\",\"id_kelas\":\"19\",\"nama_kelas\":\"Kelas 2\",\"id_guru\":null,\"wali_kelas\":null,\"id_periode\":\"98\",\"semester\":null},\"alasan\":\"salah kelas\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '16:13:39', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (461, 'Koreksi Penempatan Siswa', 'Kesiswaan', 'Ubah', 'kelas_siswa', '48', '01012526', 'Kelas 2 dikoreksi menjadi Kelas 3 - benar kelas 3', '{\"kelas\":{\"id_kelas_siswa\":\"111\",\"id\":\"50\",\"id_kelas\":\"19\",\"nama_kelas\":\"Kelas 2\",\"id_guru\":null,\"wali_kelas\":null,\"id_periode\":\"98\",\"semester\":null,\"periode\":\"2026\\/2027\"}}', '{\"kelas\":{\"id\":\"51\",\"id_kelas\":\"20\",\"nama_kelas\":\"Kelas 3\",\"id_guru\":null,\"wali_kelas\":null,\"id_periode\":\"98\",\"semester\":null},\"alasan\":\"benar kelas 3\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '28-08-2026', '16:14:09', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (462, 'Tambah Kelas', 'Master Data', 'Tambah', 'kelas', '25', 'Kelas 1', 'Pengelolaan master kelas', NULL, '{\"nama_kelas\":\"Kelas 1\",\"jurusan\":\"A\",\"status\":\"REGULER\",\"id_jurusan\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '01-09-2026', '07:57:32', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (463, 'Hapus Kelas', 'Master Data', 'Batal', 'kelas', '25', 'Kelas 1', 'Menghapus kelas yang belum digunakan', '{\"id\":\"25\",\"nama_kelas\":\"Kelas 1\",\"id_jurusan\":\"0\",\"jurusan\":\"A\",\"status\":\"REGULER\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '01-09-2026', '07:58:16', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (464, 'Tambah Kelas', 'Master Data', 'Tambah', 'kelas', '26', 'Kelas 3A', 'Pengelolaan master kelas', NULL, '{\"nama_kelas\":\"Kelas 3A\",\"jurusan\":\"\",\"status\":\"REGULER\",\"id_jurusan\":0}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '01-09-2026', '08:12:00', 17, 'admin');
INSERT INTO `tagihan_log_aktivitas` VALUES (465, 'Hapus Kelas', 'Master Data', 'Batal', 'kelas', '26', 'Kelas 3A', 'Menghapus kelas yang belum digunakan', '{\"id\":\"26\",\"nama_kelas\":\"Kelas 3A\",\"id_jurusan\":\"0\",\"jurusan\":\"\",\"status\":\"REGULER\"}', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', '01-09-2026', '08:12:04', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 30 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_master
-- ----------------------------
INSERT INTO `tagihan_master` VALUES (21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 50000.00, 'Sama', 7, 2026, 6, 2027, 7, 2026, '31-07-2026', 'Kelas', 'Ya', 'Selesai', 'Aktif', '', '28-08-2026', '08:28:36', 17, 'admin', '28-08-2026', '08:30:16', 17, 'admin');
INSERT INTO `tagihan_master` VALUES (22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 25000.00, 'Sama', 8, 2026, 8, 2026, 8, 2026, '31-08-2026', 'Semua', 'Tidak', 'Selesai', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16', 17, 'admin');
INSERT INTO `tagihan_master` VALUES (23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 10000.00, 'Sama', 8, 2026, 8, 2026, 8, 2026, '27-08-2026', 'Semua', 'Tidak', 'Selesai', 'Dibatalkan', '', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18', 17, 'admin');
INSERT INTO `tagihan_master` VALUES (24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 100000.00, 'Sama', 7, 2026, 6, 2027, 7, 2026, '31-07-2026', 'Kelas', 'Ya', 'Selesai', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', NULL, NULL, 0, NULL);
INSERT INTO `tagihan_master` VALUES (26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 2000.00, 'Sama', 1, 2026, 1, 2026, 1, 2026, '31-01-2026', 'Semua', 'Ya', 'Selesai', 'Dibatalkan', '', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33', 17, 'admin');
INSERT INTO `tagihan_master` VALUES (27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 10000.00, 'Sama', 1, 2026, 1, 2026, 1, 2026, '31-01-2026', 'Semua', 'Tidak', 'Selesai', 'Dibatalkan', '', '28-08-2026', '11:27:11', 17, 'admin', '28-08-2026', '11:28:04', 17, 'admin');
INSERT INTO `tagihan_master` VALUES (28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 50000.00, 'Sama', 1, 2026, 1, 2026, 1, 2026, '31-01-2026', 'Semua', 'Ya', 'Selesai', 'Aktif', '', '28-08-2026', '11:28:30', 17, 'admin', '28-08-2026', '11:28:38', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_metode_pembayaran
-- ----------------------------
INSERT INTO `tagihan_metode_pembayaran` VALUES (13, 'MET-TUNAI', 'Tunai', 'Tunai', 'Ya', 'Aktif', 1, '', '28-08-2026', '08:35:10', 17, 'admin');
INSERT INTO `tagihan_metode_pembayaran` VALUES (14, 'MET-TRANSFER', 'Transfer', 'Transfer', 'Tidak', 'Aktif', 2, '', '28-08-2026', '08:35:16', 17, 'admin');
INSERT INTO `tagihan_metode_pembayaran` VALUES (15, 'MET-QRIS', 'Qris', 'QRIS', 'Tidak', 'Aktif', 3, '', '28-08-2026', '08:35:21', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
  INDEX `idx_tagihan_pembayaran_metode`(`id_metode_pembayaran`) USING BTREE,
  INDEX `idx_tagihan_pembayaran_portal`(`id_siswa`, `id_periode`, `status_transaksi`, `tanggal_transaksi`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 37 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_pembayaran
-- ----------------------------
INSERT INTO `tagihan_pembayaran` VALUES (30, 'BYR/202608/00001', '28-08-2026', '08:36:01', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 98, '2026/2027', 25000.00, 0.00, 25000.00, 13, 'Tunai', 25000.00, 0.00, '', 'Aktif', 'Sudah', 1, 'Belum', '', 17, 'admin');
INSERT INTO `tagihan_pembayaran` VALUES (31, 'BYR/202608/00002', '28-08-2026', '09:03:04', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 98, '2026/2027', 50000.00, 0.00, 50000.00, 15, 'Qris', 50000.00, 0.00, 'Gopay', 'Aktif', 'Belum', 0, 'Belum', '', 17, 'admin');
INSERT INTO `tagihan_pembayaran` VALUES (32, 'BYR/202608/00003', '28-08-2026', '09:06:55', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 98, '2026/2027', 10000.00, 0.00, 10000.00, 13, 'Tunai', 10000.00, 0.00, '', 'Aktif', 'Belum', 0, 'Belum', '', 17, 'admin');
INSERT INTO `tagihan_pembayaran` VALUES (33, 'BYR/202608/00004', '28-08-2026', '09:23:05', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 98, '2026/2027', 10000.00, 0.00, 10000.00, 13, 'Tunai', 10000.00, 0.00, '', 'Aktif', 'Belum', 0, 'Belum', 'Ada hal lain yang diperlukan', 17, 'admin');
INSERT INTO `tagihan_pembayaran` VALUES (34, 'BYR/202608/00005', '28-08-2026', '09:23:43', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 98, '2026/2027', 25000.00, 0.00, 25000.00, 13, 'Tunai', 25000.00, 0.00, '', 'Aktif', 'Belum', 0, 'Belum', '', 17, 'admin');
INSERT INTO `tagihan_pembayaran` VALUES (35, 'BYR/202608/00006', '28-08-2026', '10:31:01', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 98, '2026/2027', 565000.00, 0.00, 565000.00, 14, 'Transfer', 565000.00, 0.00, 'BSI', 'Aktif', 'Belum', 0, 'Belum', '', 17, 'admin');
INSERT INTO `tagihan_pembayaran` VALUES (36, 'BYR/202608/00007', '28-08-2026', '11:21:49', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 98, '2026/2027', 1200000.00, 0.00, 1200000.00, 14, 'Transfer', 1200000.00, 0.00, 'BSI', 'Aktif', 'Belum', 0, 'Belum', '', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 81 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_pembayaran_detail
-- ----------------------------
INSERT INTO `tagihan_pembayaran_detail` VALUES (52, 30, 'BYR/202608/00001', 766, 'TAG/202608/00001', 21, 'Tagihan SPP Bulanan', 'Bulanan', 7, 'Juli', 2026, 50000.00, 0.00, 50000.00, 25000.00, 25000.00, 'Dibayar Sebagian', 'Aktif', '28-08-2026', '08:36:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (53, 31, 'BYR/202608/00002', 767, 'TAG/202608/00002', 21, 'Tagihan SPP Bulanan', 'Bulanan', 8, 'Agustus', 2026, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '09:03:04');
INSERT INTO `tagihan_pembayaran_detail` VALUES (54, 32, 'BYR/202608/00003', 953, 'TAG/202608/00188', 23, 'Sumbangan Anak Yatim & Piatu', 'Langsung', 8, 'Agustus', 2026, 10000.00, 0.00, 10000.00, 10000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '09:06:55');
INSERT INTO `tagihan_pembayaran_detail` VALUES (55, 33, 'BYR/202608/00004', 790, 'TAG/202608/00025', 21, 'Tagihan SPP Bulanan', 'Bulanan', 7, 'Juli', 2026, 50000.00, 0.00, 50000.00, 10000.00, 40000.00, 'Dibayar Sebagian', 'Aktif', '28-08-2026', '09:23:05');
INSERT INTO `tagihan_pembayaran_detail` VALUES (56, 34, 'BYR/202608/00005', 790, 'TAG/202608/00025', 21, 'Tagihan SPP Bulanan', 'Bulanan', 7, 'Juli', 2026, 50000.00, 10000.00, 40000.00, 25000.00, 15000.00, 'Dibayar Sebagian', 'Aktif', '28-08-2026', '09:23:43');
INSERT INTO `tagihan_pembayaran_detail` VALUES (57, 35, 'BYR/202608/00006', 790, 'TAG/202608/00025', 21, 'Tagihan SPP Bulanan', 'Bulanan', 7, 'Juli', 2026, 50000.00, 35000.00, 15000.00, 15000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (58, 35, 'BYR/202608/00006', 791, 'TAG/202608/00026', 21, 'Tagihan SPP Bulanan', 'Bulanan', 8, 'Agustus', 2026, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (59, 35, 'BYR/202608/00006', 792, 'TAG/202608/00027', 21, 'Tagihan SPP Bulanan', 'Bulanan', 9, 'September', 2026, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (60, 35, 'BYR/202608/00006', 793, 'TAG/202608/00028', 21, 'Tagihan SPP Bulanan', 'Bulanan', 10, 'Oktober', 2026, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (61, 35, 'BYR/202608/00006', 794, 'TAG/202608/00029', 21, 'Tagihan SPP Bulanan', 'Bulanan', 11, 'November', 2026, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (62, 35, 'BYR/202608/00006', 795, 'TAG/202608/00030', 21, 'Tagihan SPP Bulanan', 'Bulanan', 12, 'Desember', 2026, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (63, 35, 'BYR/202608/00006', 796, 'TAG/202608/00031', 21, 'Tagihan SPP Bulanan', 'Bulanan', 1, 'Januari', 2027, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (64, 35, 'BYR/202608/00006', 797, 'TAG/202608/00032', 21, 'Tagihan SPP Bulanan', 'Bulanan', 2, 'Februari', 2027, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (65, 35, 'BYR/202608/00006', 798, 'TAG/202608/00033', 21, 'Tagihan SPP Bulanan', 'Bulanan', 3, 'Maret', 2027, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (66, 35, 'BYR/202608/00006', 799, 'TAG/202608/00034', 21, 'Tagihan SPP Bulanan', 'Bulanan', 4, 'April', 2027, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (67, 35, 'BYR/202608/00006', 800, 'TAG/202608/00035', 21, 'Tagihan SPP Bulanan', 'Bulanan', 5, 'Mei', 2027, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (68, 35, 'BYR/202608/00006', 801, 'TAG/202608/00036', 21, 'Tagihan SPP Bulanan', 'Bulanan', 6, 'Juni', 2027, 50000.00, 0.00, 50000.00, 50000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_pembayaran_detail` VALUES (69, 36, 'BYR/202608/00007', 978, 'TAG/202608/00213', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 9, 'September', 2026, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (70, 36, 'BYR/202608/00007', 979, 'TAG/202608/00214', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 10, 'Oktober', 2026, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (71, 36, 'BYR/202608/00007', 980, 'TAG/202608/00215', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 11, 'November', 2026, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (72, 36, 'BYR/202608/00007', 981, 'TAG/202608/00216', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 12, 'Desember', 2026, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (73, 36, 'BYR/202608/00007', 982, 'TAG/202608/00217', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 1, 'Januari', 2027, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (74, 36, 'BYR/202608/00007', 983, 'TAG/202608/00218', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 2, 'Februari', 2027, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (75, 36, 'BYR/202608/00007', 984, 'TAG/202608/00219', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 3, 'Maret', 2027, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (76, 36, 'BYR/202608/00007', 985, 'TAG/202608/00220', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 4, 'April', 2027, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (77, 36, 'BYR/202608/00007', 986, 'TAG/202608/00221', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 5, 'Mei', 2027, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (78, 36, 'BYR/202608/00007', 987, 'TAG/202608/00222', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 6, 'Juni', 2027, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (79, 36, 'BYR/202608/00007', 977, 'TAG/202608/00212', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 8, 'Agustus', 2026, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_pembayaran_detail` VALUES (80, 36, 'BYR/202608/00007', 976, 'TAG/202608/00211', 24, 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 7, 'Juli', 2026, 100000.00, 0.00, 100000.00, 100000.00, 0.00, 'Lunas', 'Aktif', '28-08-2026', '11:21:49');

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_pengaturan_cetak
-- ----------------------------
INSERT INTO `tagihan_pengaturan_cetak` VALUES (5, 'Kartu Pembayaran', 'Kartu Pembayaran Sekolah', 'Ya', 'Custom', 'Portrait', '210', '148', '', '', '', '', 'Ya', '', 'Sekolah', '', '', '', '', '', 'Ya', 'Ya', 'Ya', 'Ya', '', '', 'Kanan', '{\"jumlah_baris\":12,\"jarak_baris\":8,\"posisi_x\":10,\"posisi_y\":10,\"lebar_tanggal\":25,\"lebar_jenis\":70,\"lebar_nominal\":35,\"lebar_petugas\":20,\"kolom\":[\"Tanggal\",\"Jenis/Bulan\",\"Nominal\"]}', 'Aktif', '18-08-2026', '03:45:59', 17, 'admin');
INSERT INTO `tagihan_pengaturan_cetak` VALUES (6, 'Bukti Pembayaran', 'Bukti Pembayaran', 'Ya', '80mm', 'Portrait', '', '', '5', '5', '5', '5', 'Ya', 'uploads/pengaturan/logo_20260825145309_523.png', 'Sekolah Al Mahbaroh', 'Perumahan Srigading Dalam Kav. 8 Malang, Jawa Timur', '+62 819-3885-3738', 'BUKTI PEMBAYARAN', '', '', 'Ya', 'Ya', 'Ya', 'Ya', 'Nania', 'Bendahara', 'Kanan', NULL, 'Aktif', '18-08-2026', '03:48:13', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_pengaturan_umum
-- ----------------------------

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
) ENGINE = InnoDB AUTO_INCREMENT = 82 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_riwayat_kelas_siswa
-- ----------------------------
INSERT INTO `tagihan_riwayat_kelas_siswa` VALUES (78, 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 48, 17, 'TK', 98, '2026/2027', NULL, 'Pindah Kelas', 'Aktif', 'Aktif', 'test', '28-08-2026', '15:59:35', 17, 'admin', 'Aktif', NULL, NULL, 0, NULL, NULL);
INSERT INTO `tagihan_riwayat_kelas_siswa` VALUES (79, 48, '01012526', '00723897520', 'Abdillah Chatam', 48, 17, 'TK', 98, '2026/2027', NULL, 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 'Pindah Kelas', 'Aktif', 'Aktif', 'real', '28-08-2026', '16:00:18', 17, 'admin', 'Aktif', NULL, NULL, 0, NULL, NULL);
INSERT INTO `tagihan_riwayat_kelas_siswa` VALUES (80, 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 50, 19, 'Kelas 2', 98, '2026/2027', NULL, 'Koreksi Penempatan', 'Aktif', 'Aktif', 'salah kelas', '28-08-2026', '16:13:39', 17, 'admin', 'Aktif', NULL, NULL, 0, NULL, NULL);
INSERT INTO `tagihan_riwayat_kelas_siswa` VALUES (81, 48, '01012526', '00723897520', 'Abdillah Chatam', 50, 19, 'Kelas 2', 98, '2026/2027', NULL, 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 'Koreksi Penempatan', 'Aktif', 'Aktif', 'benar kelas 3', '28-08-2026', '16:14:09', 17, 'admin', 'Aktif', NULL, NULL, 0, NULL, NULL);

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
  `id_wali_murid` int NULL DEFAULT 0,
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
  INDEX `idx_tagihan_wa_status`(`status_kirim`) USING BTREE,
  INDEX `idx_tagihan_wa_wali`(`id_wali_murid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
  INDEX `idx_tagihan_siswa_bulan_tahun`(`bulan`, `tahun`) USING BTREE,
  INDEX `idx_tagihan_siswa_portal`(`id_siswa`, `id_periode`, `status_tagihan`, `status_pembayaran`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1069 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_siswa
-- ----------------------------
INSERT INTO `tagihan_siswa` VALUES (766, 'TAG/202608/00001', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 25000.00, 25000.00, 'Ya', 'Dibayar Sebagian', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '08:36:01');
INSERT INTO `tagihan_siswa` VALUES (767, 'TAG/202608/00002', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '09:03:04');
INSERT INTO `tagihan_siswa` VALUES (768, 'TAG/202608/00003', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (769, 'TAG/202608/00004', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (770, 'TAG/202608/00005', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (771, 'TAG/202608/00006', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (772, 'TAG/202608/00007', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (773, 'TAG/202608/00008', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (774, 'TAG/202608/00009', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (775, 'TAG/202608/00010', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (776, 'TAG/202608/00011', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (777, 'TAG/202608/00012', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (778, 'TAG/202608/00013', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (779, 'TAG/202608/00014', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (780, 'TAG/202608/00015', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (781, 'TAG/202608/00016', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (782, 'TAG/202608/00017', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (783, 'TAG/202608/00018', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (784, 'TAG/202608/00019', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (785, 'TAG/202608/00020', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (786, 'TAG/202608/00021', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (787, 'TAG/202608/00022', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (788, 'TAG/202608/00023', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (789, 'TAG/202608/00024', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (790, 'TAG/202608/00025', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (791, 'TAG/202608/00026', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (792, 'TAG/202608/00027', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (793, 'TAG/202608/00028', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (794, 'TAG/202608/00029', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (795, 'TAG/202608/00030', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (796, 'TAG/202608/00031', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (797, 'TAG/202608/00032', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (798, 'TAG/202608/00033', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (799, 'TAG/202608/00034', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (800, 'TAG/202608/00035', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (801, 'TAG/202608/00036', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 50000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', '28-08-2026', '10:31:01');
INSERT INTO `tagihan_siswa` VALUES (802, 'TAG/202608/00037', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (803, 'TAG/202608/00038', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (804, 'TAG/202608/00039', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (805, 'TAG/202608/00040', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (806, 'TAG/202608/00041', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (807, 'TAG/202608/00042', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (808, 'TAG/202608/00043', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (809, 'TAG/202608/00044', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (810, 'TAG/202608/00045', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (811, 'TAG/202608/00046', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (812, 'TAG/202608/00047', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (813, 'TAG/202608/00048', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (814, 'TAG/202608/00049', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (815, 'TAG/202608/00050', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (816, 'TAG/202608/00051', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (817, 'TAG/202608/00052', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (818, 'TAG/202608/00053', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (819, 'TAG/202608/00054', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (820, 'TAG/202608/00055', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (821, 'TAG/202608/00056', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (822, 'TAG/202608/00057', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (823, 'TAG/202608/00058', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (824, 'TAG/202608/00059', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (825, 'TAG/202608/00060', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (826, 'TAG/202608/00061', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (827, 'TAG/202608/00062', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (828, 'TAG/202608/00063', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (829, 'TAG/202608/00064', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (830, 'TAG/202608/00065', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (831, 'TAG/202608/00066', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:15', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (832, 'TAG/202608/00067', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (833, 'TAG/202608/00068', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (834, 'TAG/202608/00069', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (835, 'TAG/202608/00070', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (836, 'TAG/202608/00071', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (837, 'TAG/202608/00072', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (838, 'TAG/202608/00073', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (839, 'TAG/202608/00074', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (840, 'TAG/202608/00075', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (841, 'TAG/202608/00076', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (842, 'TAG/202608/00077', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (843, 'TAG/202608/00078', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (844, 'TAG/202608/00079', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (845, 'TAG/202608/00080', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (846, 'TAG/202608/00081', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (847, 'TAG/202608/00082', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (848, 'TAG/202608/00083', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (849, 'TAG/202608/00084', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (850, 'TAG/202608/00085', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (851, 'TAG/202608/00086', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (852, 'TAG/202608/00087', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (853, 'TAG/202608/00088', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (854, 'TAG/202608/00089', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (855, 'TAG/202608/00090', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (856, 'TAG/202608/00091', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (857, 'TAG/202608/00092', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (858, 'TAG/202608/00093', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (859, 'TAG/202608/00094', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (860, 'TAG/202608/00095', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (861, 'TAG/202608/00096', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (862, 'TAG/202608/00097', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (863, 'TAG/202608/00098', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (864, 'TAG/202608/00099', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (865, 'TAG/202608/00100', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (866, 'TAG/202608/00101', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (867, 'TAG/202608/00102', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (868, 'TAG/202608/00103', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (869, 'TAG/202608/00104', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (870, 'TAG/202608/00105', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (871, 'TAG/202608/00106', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (872, 'TAG/202608/00107', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (873, 'TAG/202608/00108', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (874, 'TAG/202608/00109', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (875, 'TAG/202608/00110', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (876, 'TAG/202608/00111', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (877, 'TAG/202608/00112', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (878, 'TAG/202608/00113', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (879, 'TAG/202608/00114', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (880, 'TAG/202608/00115', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (881, 'TAG/202608/00116', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (882, 'TAG/202608/00117', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (883, 'TAG/202608/00118', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (884, 'TAG/202608/00119', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (885, 'TAG/202608/00120', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (886, 'TAG/202608/00121', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (887, 'TAG/202608/00122', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (888, 'TAG/202608/00123', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (889, 'TAG/202608/00124', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (890, 'TAG/202608/00125', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (891, 'TAG/202608/00126', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (892, 'TAG/202608/00127', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (893, 'TAG/202608/00128', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (894, 'TAG/202608/00129', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (895, 'TAG/202608/00130', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (896, 'TAG/202608/00131', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (897, 'TAG/202608/00132', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (898, 'TAG/202608/00133', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (899, 'TAG/202608/00134', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (900, 'TAG/202608/00135', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (901, 'TAG/202608/00136', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (902, 'TAG/202608/00137', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (903, 'TAG/202608/00138', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (904, 'TAG/202608/00139', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (905, 'TAG/202608/00140', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (906, 'TAG/202608/00141', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (907, 'TAG/202608/00142', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (908, 'TAG/202608/00143', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (909, 'TAG/202608/00144', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (910, 'TAG/202608/00145', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (911, 'TAG/202608/00146', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (912, 'TAG/202608/00147', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (913, 'TAG/202608/00148', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (914, 'TAG/202608/00149', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (915, 'TAG/202608/00150', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (916, 'TAG/202608/00151', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (917, 'TAG/202608/00152', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (918, 'TAG/202608/00153', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (919, 'TAG/202608/00154', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (920, 'TAG/202608/00155', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (921, 'TAG/202608/00156', 21, 'TGH/202608/00001', 8, 'SPP', 'Tagihan SPP Bulanan', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:30:16', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (922, 'TAG/202608/00157', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (923, 'TAG/202608/00158', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 24, '07032627', '00714743989', 'Adam At-Tirmidzi', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (924, 'TAG/202608/00159', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 20, '01032526', '0071353406', 'Affan Hakami', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (925, 'TAG/202608/00160', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 25, '08042627', '00714743990', 'Aisyah Nayla Bilqis', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (926, 'TAG/202608/00161', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (927, 'TAG/202608/00162', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 26, '09042627', '00714743991', 'Alsava Aghnia Mafaza', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (928, 'TAG/202608/00163', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (929, 'TAG/202608/00164', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 27, '10032627', '00714743992', 'Ayyub', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (930, 'TAG/202608/00165', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (931, 'TAG/202608/00166', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (932, 'TAG/202608/00167', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (933, 'TAG/202608/00168', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 22, '05032526', '00714743987', 'Hamzah Umair Hermawan', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (934, 'TAG/202608/00169', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 28, '11042627', '00714743993', 'Hanna Azalea Wahyu Firmawan', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (935, 'TAG/202608/00170', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (936, 'TAG/202608/00171', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (937, 'TAG/202608/00172', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (938, 'TAG/202608/00173', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (939, 'TAG/202608/00174', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (940, 'TAG/202608/00175', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (941, 'TAG/202608/00176', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 29, '12042627', '00714743994', 'Oryza Amiirah Hasan', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (942, 'TAG/202608/00177', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 30, '13032627', '00714743995', 'Rey Altezza Prabowo', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (943, 'TAG/202608/00178', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 31, '14032627', '00714743996', 'Said', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (944, 'TAG/202608/00179', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 21, '04042526', '00714743986', 'Shafiyah Salsabila Izzuddin', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (945, 'TAG/202608/00180', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (946, 'TAG/202608/00181', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 32, '15032627', '00714743997', 'Yunus', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (947, 'TAG/202608/00182', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (948, 'TAG/202608/00183', 22, 'TGH/202608/00002', 9, 'Kegiatan Tahunan Outbound', 'Kegiatan Outbound Ke Semeru', 'Tahunan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 33, '16032627', '00714743998', 'Ziyad Abdullah Abqar Rafif', 48, 17, 'TK', 25000.00, NULL, 0.00, 25000.00, 0.00, 25000.00, 'Tidak', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '08:32:20', 17, 'admin', '28-08-2026', '08:34:16');
INSERT INTO `tagihan_siswa` VALUES (949, 'TAG/202608/00184', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (950, 'TAG/202608/00185', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 24, '07032627', '00714743989', 'Adam At-Tirmidzi', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (951, 'TAG/202608/00186', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 20, '01032526', '0071353406', 'Affan Hakami', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (952, 'TAG/202608/00187', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 25, '08042627', '00714743990', 'Aisyah Nayla Bilqis', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (953, 'TAG/202608/00188', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 10000.00, 0.00, 'Tidak', 'Lunas', 'Aktif', '', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:06:55');
INSERT INTO `tagihan_siswa` VALUES (954, 'TAG/202608/00189', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 26, '09042627', '00714743991', 'Alsava Aghnia Mafaza', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (955, 'TAG/202608/00190', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (956, 'TAG/202608/00191', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 27, '10032627', '00714743992', 'Ayyub', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (957, 'TAG/202608/00192', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (958, 'TAG/202608/00193', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (959, 'TAG/202608/00194', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (960, 'TAG/202608/00195', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 22, '05032526', '00714743987', 'Hamzah Umair Hermawan', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (961, 'TAG/202608/00196', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 28, '11042627', '00714743993', 'Hanna Azalea Wahyu Firmawan', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (962, 'TAG/202608/00197', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (963, 'TAG/202608/00198', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (964, 'TAG/202608/00199', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (965, 'TAG/202608/00200', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (966, 'TAG/202608/00201', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (967, 'TAG/202608/00202', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (968, 'TAG/202608/00203', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 29, '12042627', '00714743994', 'Oryza Amiirah Hasan', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (969, 'TAG/202608/00204', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 30, '13032627', '00714743995', 'Rey Altezza Prabowo', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (970, 'TAG/202608/00205', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 31, '14032627', '00714743996', 'Said', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (971, 'TAG/202608/00206', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 21, '04042526', '00714743986', 'Shafiyah Salsabila Izzuddin', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (972, 'TAG/202608/00207', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (973, 'TAG/202608/00208', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 32, '15032627', '00714743997', 'Yunus', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (974, 'TAG/202608/00209', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (975, 'TAG/202608/00210', 23, 'TGH/202608/00003', 11, 'Sumbangan Anak Yatim', 'Sumbangan Anak Yatim & Piatu', 'Langsung', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '27-08-2026', 33, '16032627', '00714743998', 'Ziyad Abdullah Abqar Rafif', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: Sudah melewati hari', '28-08-2026', '09:05:31', 17, 'admin', '28-08-2026', '09:07:18');
INSERT INTO `tagihan_siswa` VALUES (976, 'TAG/202608/00211', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 7, 'Juli', 2026, '31-07-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (977, 'TAG/202608/00212', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 8, 'Agustus', 2026, '31-08-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (978, 'TAG/202608/00213', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 9, 'September', 2026, '30-09-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (979, 'TAG/202608/00214', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 10, 'Oktober', 2026, '31-10-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (980, 'TAG/202608/00215', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 11, 'November', 2026, '30-11-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (981, 'TAG/202608/00216', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 12, 'Desember', 2026, '31-12-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (982, 'TAG/202608/00217', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 1, 'Januari', 2027, '31-01-2027', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (983, 'TAG/202608/00218', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 2, 'Februari', 2027, '28-02-2027', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (984, 'TAG/202608/00219', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 3, 'Maret', 2027, '31-03-2027', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (985, 'TAG/202608/00220', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 4, 'April', 2027, '30-04-2027', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (986, 'TAG/202608/00221', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 5, 'Mei', 2027, '31-05-2027', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (987, 'TAG/202608/00222', 24, 'TGH/202608/00004', 8, 'SPP', 'Tagihan SPP Bulanan kelas 10', 'Bulanan', 98, '2026/2027', NULL, 6, 'Juni', 2027, '30-06-2027', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 100000.00, NULL, 0.00, 100000.00, 100000.00, 0.00, 'Ya', 'Lunas', 'Aktif', '', '28-08-2026', '09:33:34', 17, 'admin', '28-08-2026', '11:21:49');
INSERT INTO `tagihan_siswa` VALUES (988, 'TAG/202608/00223', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (989, 'TAG/202608/00224', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 24, '07032627', '00714743989', 'Adam At-Tirmidzi', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (990, 'TAG/202608/00225', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 20, '01032526', '0071353406', 'Affan Hakami', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (991, 'TAG/202608/00226', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 25, '08042627', '00714743990', 'Aisyah Nayla Bilqis', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (992, 'TAG/202608/00227', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (993, 'TAG/202608/00228', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 26, '09042627', '00714743991', 'Alsava Aghnia Mafaza', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (994, 'TAG/202608/00229', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (995, 'TAG/202608/00230', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 27, '10032627', '00714743992', 'Ayyub', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (996, 'TAG/202608/00231', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (997, 'TAG/202608/00232', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (998, 'TAG/202608/00233', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (999, 'TAG/202608/00234', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 22, '05032526', '00714743987', 'Hamzah Umair Hermawan', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (1000, 'TAG/202608/00235', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 28, '11042627', '00714743993', 'Hanna Azalea Wahyu Firmawan', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (1001, 'TAG/202608/00236', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (1002, 'TAG/202608/00237', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (1003, 'TAG/202608/00238', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (1004, 'TAG/202608/00239', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (1005, 'TAG/202608/00240', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (1006, 'TAG/202608/00241', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (1007, 'TAG/202608/00242', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 29, '12042627', '00714743994', 'Oryza Amiirah Hasan', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (1008, 'TAG/202608/00243', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 30, '13032627', '00714743995', 'Rey Altezza Prabowo', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (1009, 'TAG/202608/00244', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 31, '14032627', '00714743996', 'Said', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (1010, 'TAG/202608/00245', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 21, '04042526', '00714743986', 'Shafiyah Salsabila Izzuddin', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (1011, 'TAG/202608/00246', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (1012, 'TAG/202608/00247', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 32, '15032627', '00714743997', 'Yunus', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (1013, 'TAG/202608/00248', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:33');
INSERT INTO `tagihan_siswa` VALUES (1014, 'TAG/202608/00249', 26, 'TGH/202608/00005', 11, 'Sumbangan Anak Yatim', 'Tagihan SPP Bulanan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 33, '16032627', '00714743998', 'Ziyad Abdullah Abqar Rafif', 48, 17, 'TK', 2000.00, NULL, 0.00, 2000.00, 0.00, 0.00, 'Ya', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:25:46', 17, 'admin', '28-08-2026', '11:26:32');
INSERT INTO `tagihan_siswa` VALUES (1015, 'TAG/202608/00250', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 22, '05032526', '00714743987', 'Hamzah Umair Hermawan', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1016, 'TAG/202608/00251', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 24, '07032627', '00714743989', 'Adam At-Tirmidzi', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1017, 'TAG/202608/00252', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 25, '08042627', '00714743990', 'Aisyah Nayla Bilqis', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1018, 'TAG/202608/00253', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 26, '09042627', '00714743991', 'Alsava Aghnia Mafaza', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1019, 'TAG/202608/00254', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 27, '10032627', '00714743992', 'Ayyub', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1020, 'TAG/202608/00255', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 28, '11042627', '00714743993', 'Hanna Azalea Wahyu Firmawan', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1021, 'TAG/202608/00256', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 29, '12042627', '00714743994', 'Oryza Amiirah Hasan', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1022, 'TAG/202608/00257', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 30, '13032627', '00714743995', 'Rey Altezza Prabowo', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1023, 'TAG/202608/00258', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 31, '14032627', '00714743996', 'Said', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1024, 'TAG/202608/00259', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 32, '15032627', '00714743997', 'Yunus', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1025, 'TAG/202608/00260', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 33, '16032627', '00714743998', 'Ziyad Abdullah Abqar Rafif', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1026, 'TAG/202608/00261', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 21, '04042526', '00714743986', 'Shafiyah Salsabila Izzuddin', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1027, 'TAG/202608/00262', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1028, 'TAG/202608/00263', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1029, 'TAG/202608/00264', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1030, 'TAG/202608/00265', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1031, 'TAG/202608/00266', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1032, 'TAG/202608/00267', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1033, 'TAG/202608/00268', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1034, 'TAG/202608/00269', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1035, 'TAG/202608/00270', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1036, 'TAG/202608/00271', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1037, 'TAG/202608/00272', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1038, 'TAG/202608/00273', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1039, 'TAG/202608/00274', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1040, 'TAG/202608/00275', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 20, '01032526', '0071353406', 'Affan Hakami', 48, 17, 'TK', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1041, 'TAG/202608/00276', 27, 'TGH/202608/00006', 11, 'Sumbangan Anak Yatim', 'Slametan', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 10000.00, NULL, 0.00, 10000.00, 0.00, 0.00, 'Tidak', 'Dibatalkan', 'Dibatalkan', '| Sisa dibatalkan: salah', '28-08-2026', '11:27:20', 17, 'admin', '28-08-2026', '11:28:04');
INSERT INTO `tagihan_siswa` VALUES (1042, 'TAG/202608/00277', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 22, '05032526', '00714743987', 'Hamzah Umair Hermawan', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1043, 'TAG/202608/00278', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 24, '07032627', '00714743989', 'Adam At-Tirmidzi', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1044, 'TAG/202608/00279', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 25, '08042627', '00714743990', 'Aisyah Nayla Bilqis', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1045, 'TAG/202608/00280', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 26, '09042627', '00714743991', 'Alsava Aghnia Mafaza', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1046, 'TAG/202608/00281', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 27, '10032627', '00714743992', 'Ayyub', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1047, 'TAG/202608/00282', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 28, '11042627', '00714743993', 'Hanna Azalea Wahyu Firmawan', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1048, 'TAG/202608/00283', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 29, '12042627', '00714743994', 'Oryza Amiirah Hasan', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1049, 'TAG/202608/00284', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 30, '13032627', '00714743995', 'Rey Altezza Prabowo', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1050, 'TAG/202608/00285', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 31, '14032627', '00714743996', 'Said', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1051, 'TAG/202608/00286', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 32, '15032627', '00714743997', 'Yunus', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1052, 'TAG/202608/00287', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 33, '16032627', '00714743998', 'Ziyad Abdullah Abqar Rafif', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1053, 'TAG/202608/00288', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 21, '04042526', '00714743986', 'Shafiyah Salsabila Izzuddin', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1054, 'TAG/202608/00289', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 49, '02022526', '00723897521', 'Aisyah Qonitah Izzuddin', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1055, 'TAG/202608/00290', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 50, '03012526', '00723897522', 'Ammar Hakami', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1056, 'TAG/202608/00291', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 51, '04012526', '00723897523', 'Hamizan Umar Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1057, 'TAG/202608/00292', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 52, '05012526', '00723897524', 'Hisham Ali Hermawan', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1058, 'TAG/202608/00293', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 53, '06022526', '00723897525', 'KHADIJAH', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1059, 'TAG/202608/00294', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 54, '07022526', '00723897526', 'Laili Athiyyatuzzakiyah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1060, 'TAG/202608/00295', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 55, '08012526', '00723897527', 'Muhammad Uwais Ibadurrahman', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1061, 'TAG/202608/00296', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 56, '09022526', '00723897528', 'Nesa Humaeyra Zulkarnain', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1062, 'TAG/202608/00297', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 57, '10022526', '00723897529', 'SHAFIYYAH AZZAHRA', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1063, 'TAG/202608/00298', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 58, '11012526', '00723897530', 'Zakaria Al Fatih', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1064, 'TAG/202608/00299', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 59, '12022526', '00723897531', 'Hafshoh', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1065, 'TAG/202608/00300', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 60, '13012526', '00723897532', 'Bilal', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1066, 'TAG/202608/00301', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 61, '14012526', '00723897533', 'Muhammad Ibnu Abdillah', 50, 19, 'Kelas 2', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1067, 'TAG/202608/00302', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 20, '01032526', '0071353406', 'Affan Hakami', 48, 17, 'TK', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);
INSERT INTO `tagihan_siswa` VALUES (1068, 'TAG/202608/00303', 28, 'TGH/202608/00007', 10, 'Tagihan Buku', 'buku tulis', 'Langsung', 98, '2026/2027', NULL, 1, 'Januari', 2026, '31-01-2026', 48, '01012526', '00723897520', 'Abdillah Chatam', 51, 20, 'Kelas 3', 50000.00, NULL, 0.00, 50000.00, 0.00, 50000.00, 'Ya', 'Belum Dibayar', 'Aktif', '', '28-08-2026', '11:28:38', 17, 'admin', NULL, NULL);

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
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 15 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 68 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_target_kelas
-- ----------------------------
INSERT INTO `tagihan_target_kelas` VALUES (46, 21, 50, 19, 'Kelas 2', 98, '2026/2027', NULL, 50000.00, 'Aktif', '28-08-2026', '08:30:11', 0, NULL);
INSERT INTO `tagihan_target_kelas` VALUES (47, 22, 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 25000.00, 'Aktif', '28-08-2026', '08:32:20', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (48, 22, 48, 17, 'TK', 98, '2026/2027', NULL, 25000.00, 'Aktif', '28-08-2026', '08:32:20', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (49, 22, 50, 19, 'Kelas 2', 98, '2026/2027', NULL, 25000.00, 'Aktif', '28-08-2026', '08:32:20', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (50, 23, 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 10000.00, 'Aktif', '28-08-2026', '09:05:31', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (51, 23, 48, 17, 'TK', 98, '2026/2027', NULL, 10000.00, 'Aktif', '28-08-2026', '09:05:31', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (52, 23, 50, 19, 'Kelas 2', 98, '2026/2027', NULL, 10000.00, 'Aktif', '28-08-2026', '09:05:31', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (53, 24, 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 100000.00, 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (56, 26, 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 2000.00, 'Aktif', '28-08-2026', '11:25:46', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (57, 26, 48, 17, 'TK', 98, '2026/2027', NULL, 2000.00, 'Aktif', '28-08-2026', '11:25:46', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (58, 26, 50, 19, 'Kelas 2', 98, '2026/2027', NULL, 2000.00, 'Aktif', '28-08-2026', '11:25:46', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (59, 27, 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 10000.00, 'Aktif', '28-08-2026', '11:27:11', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (60, 27, 48, 17, 'TK', 98, '2026/2027', NULL, 10000.00, 'Aktif', '28-08-2026', '11:27:11', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (61, 27, 50, 19, 'Kelas 2', 98, '2026/2027', NULL, 10000.00, 'Aktif', '28-08-2026', '11:27:11', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (62, 28, 51, 20, 'Kelas 3', 98, '2026/2027', NULL, 50000.00, 'Aktif', '28-08-2026', '11:28:30', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (63, 28, 48, 17, 'TK', 98, '2026/2027', NULL, 50000.00, 'Aktif', '28-08-2026', '11:28:30', 17, 'admin');
INSERT INTO `tagihan_target_kelas` VALUES (64, 28, 50, 19, 'Kelas 2', 98, '2026/2027', NULL, 50000.00, 'Aktif', '28-08-2026', '11:28:30', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 102 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_tarif_bulan
-- ----------------------------
INSERT INTO `tagihan_tarif_bulan` VALUES (60, 21, 7, 'Juli', 2026, 50000.00, '31-07-2026', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (61, 21, 8, 'Agustus', 2026, 50000.00, '31-08-2026', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (62, 21, 9, 'September', 2026, 50000.00, '30-09-2026', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (63, 21, 10, 'Oktober', 2026, 50000.00, '31-10-2026', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (64, 21, 11, 'November', 2026, 50000.00, '30-11-2026', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (65, 21, 12, 'Desember', 2026, 50000.00, '31-12-2026', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (66, 21, 1, 'Januari', 2027, 50000.00, '31-01-2027', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (67, 21, 2, 'Februari', 2027, 50000.00, '28-02-2027', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (68, 21, 3, 'Maret', 2027, 50000.00, '31-03-2027', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (69, 21, 4, 'April', 2027, 50000.00, '30-04-2027', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (70, 21, 5, 'Mei', 2027, 50000.00, '31-05-2027', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (71, 21, 6, 'Juni', 2027, 50000.00, '30-06-2027', 'Aktif', '28-08-2026', '08:30:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (72, 22, 8, 'Agustus', 2026, 25000.00, '31-08-2026', 'Aktif', '28-08-2026', '08:32:20', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (73, 23, 8, 'Agustus', 2026, 10000.00, '27-08-2026', 'Aktif', '28-08-2026', '09:05:31', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (74, 24, 7, 'Juli', 2026, 100000.00, '31-07-2026', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (75, 24, 8, 'Agustus', 2026, 100000.00, '31-08-2026', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (76, 24, 9, 'September', 2026, 100000.00, '30-09-2026', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (77, 24, 10, 'Oktober', 2026, 100000.00, '31-10-2026', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (78, 24, 11, 'November', 2026, 100000.00, '30-11-2026', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (79, 24, 12, 'Desember', 2026, 100000.00, '31-12-2026', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (80, 24, 1, 'Januari', 2027, 100000.00, '31-01-2027', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (81, 24, 2, 'Februari', 2027, 100000.00, '28-02-2027', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (82, 24, 3, 'Maret', 2027, 100000.00, '31-03-2027', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (83, 24, 4, 'April', 2027, 100000.00, '30-04-2027', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (84, 24, 5, 'Mei', 2027, 100000.00, '31-05-2027', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (85, 24, 6, 'Juni', 2027, 100000.00, '30-06-2027', 'Aktif', '28-08-2026', '09:33:34', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (98, 26, 1, 'Januari', 2026, 2000.00, '31-01-2026', 'Aktif', '28-08-2026', '11:25:46', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (99, 27, 1, 'Januari', 2026, 10000.00, '31-01-2026', 'Aktif', '28-08-2026', '11:27:11', 17, 'admin');
INSERT INTO `tagihan_tarif_bulan` VALUES (100, 28, 1, 'Januari', 2026, 50000.00, '31-01-2026', 'Aktif', '28-08-2026', '11:28:30', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of tagihan_template_whatsapp
-- ----------------------------
INSERT INTO `tagihan_template_whatsapp` VALUES (3, 'Bukti Pembayaran', 'Template Pembayaran Utama', 'Yth. Bapak/Ibu {nama_wali}, pembayaran atas nama {nama_siswa} kelas {kelas} sebesar {total_bayar} telah kami terima pada {tanggal}. Nomor transaksi: {no_transaksi}. Terima kasih.', 'Ya', 'Aktif', '18-08-2026', '03:43:23', 17, 'admin');
INSERT INTO `tagihan_template_whatsapp` VALUES (4, 'Surat Tunggakan', 'Template Utama Tunggakan', 'Yth. Bapak/Ibu {nama_wali}, tunggakan atas nama {nama_siswa} sebesar {total_tunggakan} belum terbayarkan sampai tanggal {tanggal}. Dimohon untuk segera dibayarkan. Terima kasih.', 'Ya', 'Aktif', '18-08-2026', '03:44:53', 17, 'admin');

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
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (17, 'admin', 'admin', '$2a$12$Bh53GmN6dogR9OnfVt30xuOzUBZNVBRMAybJDICugMIESB0y36I4u', 'admin123', '1', 'Admin', '');
INSERT INTO `users` VALUES (20, 'Nasirudin Albani, S.Pd.', 'Nasirudin', '$2y$10$WkWDWKJ0pABk9NHgdSBTaeJk5e7fWTFIyvGXNpVQylLPfFFC3S12m', 'nasirudin123', '3', 'Kepala Sekolah', '26');

-- ----------------------------
-- Table structure for wali_murid
-- ----------------------------
DROP TABLE IF EXISTS `wali_murid`;
CREATE TABLE `wali_murid`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_wali` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `nama_wali` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_telepon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `password_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `wajib_ganti_password` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Ya' COMMENT 'Ya/Tidak',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif' COMMENT 'Aktif/Tidak Aktif',
  `last_login_tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `last_login_waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `last_login_ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_password_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_password_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0 COMMENT 'Admin/petugas pembuat akun',
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user_update` int NULL DEFAULT 0,
  `nama_user_update` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_wali_murid_kode`(`kode_wali`) USING BTREE,
  UNIQUE INDEX `uq_wali_murid_username`(`username`) USING BTREE,
  INDEX `idx_wali_murid_nama`(`nama_wali`) USING BTREE,
  INDEX `idx_wali_murid_telepon`(`no_telepon`) USING BTREE,
  INDEX `idx_wali_murid_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of wali_murid
-- ----------------------------
INSERT INTO `wali_murid` VALUES (2, 'WALI/202608/00001', 'Chatam', '62813393374', 'Chatam@gmail.com', 'chatam912', '$2y$10$o2LZAZaYAork44ly0y/iteNf./tMaDLiP2Ml6TrQC59lkLzHyYnvC', NULL, 'Tidak', 'Aktif', '10-09-2026', '13:18:21', '::1', '28-08-2026', '09:26:45', '24-08-2026', '13:08:17', 17, 'admin', '28-08-2026', '09:25:58', 17, 'admin');

-- ----------------------------
-- Table structure for wali_murid_login_log
-- ----------------------------
DROP TABLE IF EXISTS `wali_murid_login_log`;
CREATE TABLE `wali_murid_login_log`  (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `id_wali_murid` int NULL DEFAULT 0,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status_login` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Berhasil/Gagal/Ditolak',
  `ip_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `idx_wali_login_id_wali`(`id_wali_murid`) USING BTREE,
  INDEX `idx_wali_login_username`(`username`) USING BTREE,
  INDEX `idx_wali_login_status`(`status_login`) USING BTREE,
  INDEX `idx_wali_login_tanggal`(`tanggal`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 26 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of wali_murid_login_log
-- ----------------------------
INSERT INTO `wali_murid_login_log` VALUES (3, 2, 'chatam912', 'Berhasil', '2404:c0:3569:e01d:c4f7:4dba:ab7:fb3c', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '24-08-2026', '13:13:49');
INSERT INTO `wali_murid_login_log` VALUES (4, 2, 'chatam912', 'Gagal', '2404:c0:346f:2d5c:298e:9a8:afbc:be68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '24-08-2026', '14:18:34');
INSERT INTO `wali_murid_login_log` VALUES (5, 2, 'chatam912', 'Berhasil', '2404:c0:346f:2d5c:298e:9a8:afbc:be68', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '24-08-2026', '14:20:13');
INSERT INTO `wali_murid_login_log` VALUES (6, 2, 'chatam912', 'Gagal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '27-08-2026', '16:54:17');
INSERT INTO `wali_murid_login_log` VALUES (7, 0, 'chatam', 'Gagal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '27-08-2026', '16:54:56');
INSERT INTO `wali_murid_login_log` VALUES (8, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '27-08-2026', '16:55:10');
INSERT INTO `wali_murid_login_log` VALUES (9, 2, 'chatam912', 'Gagal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '28-08-2026', '08:18:18');
INSERT INTO `wali_murid_login_log` VALUES (10, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '09:00:00');
INSERT INTO `wali_murid_login_log` VALUES (11, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '09:26:13');
INSERT INTO `wali_murid_login_log` VALUES (12, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '09:30:59');
INSERT INTO `wali_murid_login_log` VALUES (13, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '10:25:23');
INSERT INTO `wali_murid_login_log` VALUES (14, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '10:33:39');
INSERT INTO `wali_murid_login_log` VALUES (15, 2, 'chatam912', 'Gagal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '28-08-2026', '11:20:44');
INSERT INTO `wali_murid_login_log` VALUES (16, 2, 'chatam912', 'Gagal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '28-08-2026', '11:20:49');
INSERT INTO `wali_murid_login_log` VALUES (17, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '11:20:52');
INSERT INTO `wali_murid_login_log` VALUES (18, 2, 'chatam912', 'Gagal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '28-08-2026', '13:15:02');
INSERT INTO `wali_murid_login_log` VALUES (19, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '13:15:06');
INSERT INTO `wali_murid_login_log` VALUES (20, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '13:34:33');
INSERT INTO `wali_murid_login_log` VALUES (21, 2, 'chatam912', 'Gagal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '28-08-2026', '15:45:15');
INSERT INTO `wali_murid_login_log` VALUES (22, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '28-08-2026', '15:45:20');
INSERT INTO `wali_murid_login_log` VALUES (23, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '31-08-2026', '14:40:56');
INSERT INTO `wali_murid_login_log` VALUES (24, 2, 'chatam912', 'Gagal', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Username atau password tidak sesuai.', '10-09-2026', '13:17:44');
INSERT INTO `wali_murid_login_log` VALUES (25, 2, 'chatam912', 'Berhasil', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'Login Portal Wali Murid berhasil.', '10-09-2026', '13:18:21');

-- ----------------------------
-- Table structure for wali_murid_siswa
-- ----------------------------
DROP TABLE IF EXISTS `wali_murid_siswa`;
CREATE TABLE `wali_murid_siswa`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_wali_murid` int NULL DEFAULT 0,
  `id_siswa` int NULL DEFAULT 0,
  `hubungan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Wali' COMMENT 'Ayah/Ibu/Wali/Lainnya',
  `status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'Aktif' COMMENT 'Aktif/Tidak Aktif',
  `keterangan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user` int NULL DEFAULT 0,
  `nama_user` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tanggal_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `waktu_update` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `id_user_update` int NULL DEFAULT 0,
  `nama_user_update` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uq_wali_murid_siswa`(`id_wali_murid`, `id_siswa`) USING BTREE,
  INDEX `idx_wali_murid_siswa_wali`(`id_wali_murid`) USING BTREE,
  INDEX `idx_wali_murid_siswa_siswa`(`id_siswa`) USING BTREE,
  INDEX `idx_wali_murid_siswa_status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of wali_murid_siswa
-- ----------------------------
INSERT INTO `wali_murid_siswa` VALUES (2, 2, 48, 'Ayah', 'Aktif', '', '24-08-2026', '13:08:17', 17, 'admin', NULL, NULL, 0, NULL);
INSERT INTO `wali_murid_siswa` VALUES (3, 2, 40, 'Ayah', 'Aktif', '', '24-08-2026', '14:22:48', 17, 'admin', NULL, NULL, 0, NULL);

SET FOREIGN_KEY_CHECKS = 1;
