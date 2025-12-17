# Website Kos Pisang Ijo - Intan Tri Yulianti - 07TPLP018 - Teknik Informatika - Universitas Pamulang

Website Kos Pisang Ijo adalah aplikasi berbasis web untuk pengelolaan rumah kos secara digital. Sistem ini menyediakan fitur pencarian kamar, pengajuan sewa, verifikasi penyewa, serta manajemen pembayaran bulanan dengan alur yang terstruktur antara pengguna dan admin.

Aplikasi dibangun menggunakan PHP Native dan MySQL dengan tampilan antarmuka yang konsisten dan profesional.

---

## Tujuan Pengembangan

Proyek ini dikembangkan untuk:
- Mempermudah pengelolaan data kos secara terpusat
- Mengurangi pencatatan manual
- Meningkatkan keamanan dan validasi data penyewa
- Memberikan transparansi dalam proses pembayaran dan administrasi kos

---

## Fitur Sistem Website Kos 
![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Dashboard%20Pengguna.png?raw=true)

### Fitur Pengguna
![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Registrasi%20Pengguna.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Login%20Pengguna.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Dashboard%20Pengguna%20(2).png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Booking%20Pengguna.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Pembayaran%20Bulanan%20Pengguna.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Riwayat%20Booking%20Pengguna.png?raw=true)


### Fitur Admin
![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halam%20Login%20Admin.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Dashboard%20Admin.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Kamar%20Admin.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Data%20Penghuni%20Admin.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Pengajuan%20Sewa%20Admin.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Pembayaran%20Bulanan%20Admin.png?raw=true)

![alt text](https://github.com/pisangijooo/website-kos/blob/main/Capture%20tampilan%20website/Tampilan%20Halaman%20Rekapan%20Pembayaran%20Admin.png?raw=true)

---

## Alur Sistem

1. Pengguna melakukan registrasi dan login
2. Pengguna mengajukan booking kamar dengan upload KTP
3. Admin memverifikasi pengajuan sewa
4. Sistem otomatis membuat data penghuni dan tagihan pembayaran
5. Pengguna melakukan pembayaran manual dan upload bukti
6. Admin memverifikasi pembayaran
7. Status pembayaran diperbarui menjadi lunas

---

## Struktur Direktori

website_kos/
│
├── admin/
│   ├── dashboard.php
│   ├── kamar.php
│   ├── tambah_kamar.php
│   ├── kamar_edit.php
│   ├── kamar_hapus.php
│   ├── penghuni.php
│   ├── penghuni_tambah.php
│   ├── penghuni_edit.php
│   ├── penghuni_hapus.php
│   ├── pesanan.php
│   ├── pesanan_setuju.php
│   ├── pesanan_tolak.php
│   ├── pembayaran.php
│   ├── rekap.php
│   ├── login_admin.php
│   ├── logout_admin.php
│   └── uploads/
│
├── user/
│   ├── index_user.php
│   ├── booking.php
│   ├── pembayaran.php
│   ├── riwayat.php
│   └── pesanan_terima.php
│
├── config/
│   └── koneksi.php
│
├── uploads/
│   ├── foto_kamar/
│   ├── ktp/
│   └── bukti/
│
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
├── Capture_tampilan_website/
│
├── index.php
├── login.php
├── registrasi.php
├── logout.php
├── pemilik.php
├── style.css
├── db_kos.sql
├── test_koneksi.php
└── README.md


## Teknologi yang Digunakan

- PHP Native
- MySQL
- HTML
- CSS
- JavaScript
- Google Fonts

---

## Instalasi dan Konfigurasi

1. Clone repository
   git clone https://github.com/username/website-kos-pisang-ijo.git

2. Pindahkan folder ke direktori server lokal
   Contoh: htdocs pada XAMPP

3. Import database
   - Buka phpMyAdmin
   - Buat database baru, misalnya db_kos
   - Import file db_kos.sql

4. Konfigurasi koneksi database
   Edit file config/koneksi.php sesuai pengaturan database lokal

5. Jalankan aplikasi melalui browser
   http://localhost/website_kos/

---

## Keunggulan Sistem

- Alur bisnis jelas dan terstruktur
- Pembagian peran antara pengguna dan admin
- Sistem verifikasi penyewa menggunakan KTP
- Pencatatan pembayaran bulanan rapi
- Tampilan antarmuka konsisten dan profesional

---

## Catatan

Aplikasi ini dikembangkan menggunakan PHP Native tanpa framework. Cocok digunakan sebagai proyek pembelajaran, tugas akhir, maupun sistem manajemen kos skala kecil hingga menengah.

---

## Author

Intan Tri Yulianti  
Teknik Informatika
