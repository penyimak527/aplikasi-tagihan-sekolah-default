# Aplikasi Tagihan Sekolah — CodeIgniter 3

Project ini menggunakan CodeIgniter **3.1.13**, struktur CMV per modul, aset visual Adminto, dan database `aplikasi_tagihan_sekolah_default.sql` yang diberikan.

## Acuan implementasi

- Wireframe 01–08 menjadi sumber utama menu, susunan halaman, filter, field, tombol, alur, dan validasi.
- Pola CMV mengikuti contoh `cmv_aksara`.
- Adminto dipakai sebagai dasar sidebar, topbar, card, form, modal, tabel, ikon, dan responsivitas.
- Komponen demo yang tidak terdapat dalam wireframe—pencarian menu global, bantuan, notifikasi demo, gear theme, dan theme customizer—tidak digunakan.
- Tidak ada tabel baru di luar database yang diberikan.

## Struktur CMV per modul

Controller, model, dan view dikelompokkan berdasarkan modul:

```text
application/
├── controllers/
│   ├── auth/
│   ├── dashboard/
│   ├── master_data/
│   ├── kesiswaan/
│   ├── tagihan/
│   ├── transaksi/
│   ├── tunggakan/
│   ├── laporan/
│   └── pengaturan/
├── models/
│   ├── dashboard/
│   ├── master_data/
│   ├── kesiswaan/
│   ├── tagihan/
│   ├── transaksi/
│   ├── tunggakan/
│   ├── laporan/
│   └── pengaturan/
└── views/
    ├── template/
    │   ├── header.php
    │   └── footer.php
    ├── dashboard/
    ├── master_data/
    ├── kesiswaan/
    ├── tagihan/
    ├── transaksi/
    ├── tunggakan/
    ├── laporan/
    └── pengaturan/
```

Folder `application/views/template` hanya berisi **`header.php` dan `footer.php`**. Sidebar dan topbar berada di `header.php`.

## Base URL

`application/config/config.php` menggunakan base URL dinamis sesuai ketentuan:

```php
$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
```

## jQuery dan aset Adminto

`assets/js/vendor.min.js` dari Adminto dimuat sebelum isi view dan sudah menyediakan jQuery/Bootstrap. CDN jQuery 3.7.1 dipakai sebagai fallback bila bundle vendor gagal memuat jQuery. Dengan demikian, kode CMV seperti `$(document).ready()`, `$.ajax()`, `.val()`, dan `.modal()` dapat digunakan pada view.

## Database

Project hanya menggunakan **31 tabel** yang terdapat pada SQL sumber:

- 8 tabel master lama: `jabatan`, `kelas`, `kelas_setting`, `kelas_siswa`, `master_tahun_ajaran`, `pegawai`, `pegawai_jabatan`, dan `siswa`;
- 23 tabel `tagihan_*` yang telah tersedia.

Tidak ditambahkan tabel akun, tabel master baru di luar SQL, atau foreign key baru.

File database:

```text
aplikasi_tagihan_sekolah_default.sql
```

File instalasi dengan seed data awal master tagihan:

```text
database_instalasi_lengkap.sql
```

## Login

Database sumber belum menyediakan tabel akun aplikasi. Karena tidak diperbolehkan menambah tabel baru, login awal menggunakan konfigurasi pada:

```text
application/config/tagihan.php
```

Akun awal:

```text
Username : admin
Password : admin123
```

Mekanisme ini tidak mengubah struktur database. Controller login berada pada:

```text
application/controllers/auth/Login.php
```

## Modul aplikasi

### Dashboard

- Filter tahun ajaran, kelas, dan periode.
- Delapan indikator utama.
- Grafik realisasi Juli–Juni.
- Ringkasan jenis dan status pembayaran.
- Transaksi terbaru dan tunggakan prioritas.
- Kondisi data kosong dan gagal dimuat.

### Master Data

- Tahun Ajaran.
- Kelas.
- Siswa.
- Import Siswa `.xlsx`.
- Jenis Tagihan.
- Metode Pembayaran.

CRUD sederhana menggunakan modal. Import siswa menggunakan halaman khusus.

### Kesiswaan

- Penempatan siswa.
- Kenaikan kelas.
- Pindah kelas.
- Tinggal kelas.
- Kelulusan.
- Berhenti/Pindah sekolah.
- Riwayat kelas dan koreksi penempatan terakhir.

Penempatan baru tidak menghapus penempatan lama. Tagihan lama tetap memakai snapshot kelas saat diterbitkan.

### Tagihan

- Tagihan Bulanan, Langsung, dan Tahunan.
- Draft, preview, dan penerbitan.
- Daftar batch tagihan.
- Siswa pembayar.
- Tarif per kelas.
- Tarif khusus siswa.
- Potongan dan pembebasan.

Urutan tarif:

```text
Tarif khusus siswa → Tarif kelas → Tarif umum → Potongan/Pembebasan
```

### Transaksi

- Pencarian dan pemilihan satu siswa.
- Tagihan tahun berjalan dan tahun sebelumnya.
- Keranjang multi-tagihan.
- Pembayaran penuh atau cicilan.
- Tunai/non-tunai, uang diterima, dan kembalian.
- Bukti pembayaran, WhatsApp, dan kartu pembayaran.
- Riwayat pembayaran.
- Halaman Pembatalan Transaksi.

Penyimpanan dan pembatalan menggunakan transaksi database atomik. Pembatalan tidak menghapus transaksi asli dan mengembalikan saldo setiap detail tagihan.

### Tagihan dan Tunggakan

- Tagihan per siswa.
- Tagihan per kelas.
- Tagihan per jenis.
- Tunggakan tahun sebelumnya.
- Surat pemberitahuan tunggakan dan WhatsApp.

Tagihan dengan `dianggap_tunggakan = Tidak` tetap dapat dibayar tetapi tidak masuk total dan surat tunggakan secara normal.

### Laporan

- Pembayaran Harian.
- Pembayaran Bulanan.
- Pembayaran Tahunan Juli–Juni.
- Rekap Per Kelas.
- Rekap Per Jenis.
- Laporan Tunggakan.
- Riwayat Pembatalan.

Ekspor mengikuti filter aktif. Nominal diekspor sebagai angka, sedangkan NIS/NISN dan nomor transaksi dipertahankan sebagai teks.

### Pengaturan

- Format Bukti Pembayaran.
- Format Kartu Pembayaran.
- Template WhatsApp.
- Log Aktivitas.

Pengaturan ini bukan theme customizer Adminto.

## Instalasi

1. Letakkan folder project di `htdocs`, `www`, atau document root server.
2. Buat database MySQL sesuai kebutuhan.
3. Import `database_instalasi_lengkap.sql` atau SQL sumber dan seed secara berurutan.
4. Sesuaikan koneksi pada `application/config/database.php`.
5. Pastikan Apache `mod_rewrite` dan `.htaccess` aktif.
6. Pastikan ekstensi PHP berikut tersedia:

   ```text
   mysqli
   session
   zip
   mbstring
   fileinfo
   ```

7. Pastikan folder berikut dapat ditulis:

   ```text
   uploads/
   application/logs/
   ```

## Import siswa

Template tersedia di:

```text
assets/template/template_import_siswa.xlsx
```

Alurnya: pilih tahun ajaran, semester, dan kelas → upload `.xlsx` → preview validasi → import baris valid → simpan riwayat import.

## Pemeriksaan

Pemeriksaan yang dilakukan sebelum paket dibuat:

- lint sintaks seluruh file PHP pada folder `application`;
- validasi referensi model dan view dari controller;
- validasi bahwa query hanya memakai tabel dalam SQL sumber;
- validasi 31 tabel pada SQL sumber dan SQL instalasi;
- pemeriksaan blok JavaScript view yang dapat dirender tanpa database;
- validasi folder template hanya berisi `header.php` dan `footer.php`;
- validasi controller dan model dikelompokkan per modul.

Pengujian integrasi dengan data nyata tetap perlu dilakukan pada server yang memiliki MySQL, terutama untuk sinkronisasi `master_tahun_ajaran`, `kelas_setting`, data siswa, serta printer fisik kartu pembayaran.
