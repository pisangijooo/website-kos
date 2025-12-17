Website Kos Pisang Ijo

Website Kos Pisang Ijo adalah aplikasi berbasis web untuk pengelolaan rumah kos secara digital. Sistem ini menyediakan fitur pencarian kamar, pengajuan sewa, verifikasi penyewa, serta manajemen pembayaran bulanan dengan alur yang terstruktur antara pengguna dan admin.

Aplikasi dibangun menggunakan PHP Native dan MySQL, dengan tampilan antarmuka yang konsisten dan profesional.

Tujuan Pengembangan

Proyek ini dikembangkan untuk:

Mempermudah pengelolaan data kos secara terpusat

Mengurangi pencatatan manual

Meningkatkan keamanan dan validasi data penyewa

Memberikan transparansi dalam proses pembayaran dan administrasi kos

Fitur Sistem
Fitur Pengunjung

Melihat halaman utama kos

Melihat daftar kamar tersedia

Melihat detail kamar (foto, fasilitas, lokasi, harga)

Pencarian kamar berdasarkan lokasi dan budget

Fitur Pengguna

Registrasi dan login akun

Booking kamar secara online

Upload KTP sebagai syarat pengajuan sewa

Melihat status pengajuan sewa

Melihat tagihan pembayaran bulanan

Upload bukti pembayaran

Melihat status dan riwayat pembayaran

Fitur Admin

Login admin

Dashboard admin dengan ringkasan data

Manajemen data kamar

Manajemen data penghuni

Verifikasi pengajuan sewa

Verifikasi dokumen KTP penyewa

Manajemen pembayaran bulanan

Verifikasi bukti pembayaran

Rekap data pembayaran

Alur Sistem

Pengguna melakukan registrasi dan login

Pengguna mengajukan booking kamar dengan upload KTP

Admin memverifikasi pengajuan sewa

Sistem otomatis membuat data penghuni dan tagihan pembayaran

Pengguna melakukan pembayaran manual dan upload bukti

Admin memverifikasi pembayaran

Status pembayaran diperbarui menjadi lunas

Struktur Direktori
website_kos/
├── admin/
│   ├── dashboard.php
│   ├── kamar.php
│   ├── penghuni.php
│   ├── pesanan.php
│   ├── pembayaran.php
│   └── ...
├── user/
│   ├── index_user.php
│   ├── booking.php
│   ├── pembayaran.php
│   └── ...
├── config/
│   └── koneksi.php
├── uploads/
│   ├── ktp/
│   ├── bukti/
│   └── foto_kamar/
├── assets/
├── db_kos.sql
├── index.php
├── login.php
├── registrasi.php
└── README.md

Teknologi yang Digunakan

PHP Native

MySQL

HTML

CSS

JavaScript

Google Fonts

Instalasi dan Konfigurasi

Clone repository ini

git clone https://github.com/username/website-kos-pisang-ijo.git


Pindahkan folder ke direktori server lokal
Contoh: htdocs pada XAMPP

Import database

Buka phpMyAdmin

Buat database baru, misalnya db_kos

Import file db_kos.sql

Konfigurasi koneksi database
Edit file config/koneksi.php sesuai dengan pengaturan database lokal

Jalankan aplikasi melalui browser

http://localhost/website_kos/

Keunggulan Sistem

Alur bisnis jelas dan terstruktur

Pembagian peran antara pengguna dan admin

Sistem verifikasi penyewa menggunakan KTP

Pencatatan pembayaran bulanan rapi

Tampilan antarmuka konsisten dan profesional

Catatan

Aplikasi ini dikembangkan menggunakan PHP Native tanpa framework, sehingga mudah dipahami dan dikembangkan lebih lanjut. Cocok digunakan sebagai proyek pembelajaran, tugas akhir, maupun sistem manajemen kos skala kecil hingga menengah.

Author

Intan Tri Yulianti
Teknik Informatika
