# Catatan Implementasi

## Ketentuan yang diterapkan

1. Framework menggunakan CodeIgniter 3.1.13.
2. Controller, model, dan view dikelompokkan per modul.
3. Folder `application/views/template` hanya berisi `header.php` dan `footer.php`; sidebar berada di `header.php`.
4. Wireframe 01–08 menjadi acuan menu, urutan komponen, filter, modal, halaman khusus, dan validasi.
5. Adminto dipakai sebagai dasar visual tanpa komponen demo yang tidak ada pada wireframe.
6. jQuery dari bundle Adminto dimuat sebelum view; CDN jQuery 3.7.1 menjadi fallback.
7. Base URL memakai konfigurasi dinamis yang diberikan pengguna.
8. Tidak ada tabel baru, foreign key baru, atau perubahan struktur di luar SQL yang diberikan.
9. Login awal memakai `application/config/tagihan.php` karena database sumber tidak memiliki tabel autentikasi.
10. Tambah/edit sederhana memakai modal; proses kompleks memakai halaman khusus.
11. Pembayaran dan pembatalan menggunakan transaksi database atomik.
12. Tagihan dan kelas lama dipertahankan sebagai riwayat/snapshot.

## Penyesuaian saat pemasangan

- Koneksi database pada `application/config/database.php`.
- Nama, alamat, telepon, logo, serta penandatangan sekolah.
- Sinkronisasi tahun ajaran aktif dengan `kelas_setting`.
- Data master siswa, kelas, pegawai, jenis tagihan, dan metode pembayaran.
- Ukuran printer fisik kartu pembayaran.
