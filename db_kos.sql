-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2025 at 06:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kos`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Table structure for table `kamar`
--

CREATE TABLE `kamar` (
  `id_kamar` int(11) NOT NULL,
  `nama_kamar` varchar(100) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `fasilitas` text DEFAULT NULL,
  `status` enum('Kosong','Terisi') DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kamar`
--

INSERT INTO `kamar` (`id_kamar`, `nama_kamar`, `lokasi`, `deskripsi`, `harga`, `fasilitas`, `status`, `foto`) VALUES
(2, 'Kamar Banana Split', 'Pesanggrahan', 'Cocok buat mahasiswa yang suka suasana adem dan manis, kayak banana split! 🍨', 850000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 1.jpg'),
(3, 'Kamar Es Pisang Ijo', 'Mampang Prapatan', 'Nuansa segar dengan dinding warna pastel, bikin adem banget. ❄️', 950000.00, 'Kasur Double, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 3.jpg'),
(4, 'Kamar Smoothie Ijo', 'Jagakarsa', 'Minimalis tapi segar! Cocok buat kamu yang suka ketenangan. 🍃', 900000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 2.jpg'),
(5, 'Kamar Pisang Nugget', 'Pasar Minggu', 'Lucu dan nyaman, cocok buat yang suka ngadem sambil nonton. 📺', 850000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 4.jpg'),
(6, 'Kamar Banana Leaf', 'Pancoran', 'Tema tropis dengan dekorasi daun-daun hijau, suasananya tenang banget. 🌿', 1000000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem, Water Heater', 'Kosong', 'kos 6.jpg'),
(7, 'Kamar Pisang Goreng Keju', 'Kebayoran Lama', 'Ceria dengan cat dinding kuning kehijauan, bikin semangat pagi! ☀️', 900000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 5.jpg'),
(8, 'Kamar Ijo Lumut', 'Jagakarsa', 'Simpel tapi sejuk, cocok buat kamu yang suka privasi. 💤', 850000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 7.jpg'),
(9, 'Kamar Green Delight', 'Pasar Minggu', 'Suasana elegan tapi tetap “ijo-ijoan”, bikin betah di kamar. 🌱', 1050000.00, 'Kasur Double, Meja Belajar, Lemari Ac, Kamar Mandi Dalem, Water Heater', 'Kosong', 'kos 18.jpg'),
(10, 'Kamar Pisang Coklat', 'Kebayoran Baru', 'Kombinasi warna coklat dan hijau yang hangat, nyaman buat rebahan. 🍫', 950000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 9.jpg'),
(11, 'Kamar Banana Bliss', 'Jagakarsa', 'Cocok buat pekerja WFH, tenang dan produktif. 💻', 1100000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 11.jpg'),
(12, 'Kamar Es Serut Ijo', 'Setiabudi', 'Adem dan segar, cocok untuk mahasiswa hemat tapi butuh kenyamanan. ❄️', 850000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 10.jpg'),
(13, 'Kamar Pisang Hijau Latte', 'Cilandak', 'Kamar bernuansa cream seperti latte, lembut banget. ☕', 980000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 12.jpg'),
(14, 'Kamar Banana Dream', 'Pasar Minggu', 'Desain modern minimalis, suasana cozy buat istirahat maksimal. 🌙', 1200000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem, Water Heater', 'Kosong', 'kos 15.jpg'),
(15, 'Kamar Ijo Pisang Garden', 'Pancoran', 'WiFi, AC\r\nAda pemandangan taman kecil di luar jendela — cocok buat healing sore. 🌼', 1000000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 13.jpg'),
(16, 'Kamar Pisang Susu', 'Kebayoran Lama', 'Lucu dan lembut, dengan tema warna putih.', 900000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 14.jpg'),
(17, 'Kamar Banana Breeze', 'Jagakarsa', 'Kamar dengan sirkulasi udara bagus, segar tiap waktu. 💨', 1050000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 16.jpg'),
(18, 'Kamar Pisang Pandan', 'Kebayoran Lama', 'Aroma pandan yang khas bikin tidur makin nyenyak. 🌾', 950000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 19.jpg'),
(19, 'Kamar Pisang Crunchy', 'Tebet', 'Simple tapi tetap stylish, dengan nuansa cerah. 🍪', 880000.00, 'Kasur Single, Meja Belajar, Lemari Ac, Kamar Mandi Dalem', 'Kosong', 'kos 20.jpg'),
(20, 'Kamar Green Haven', 'Mampang Prapatan', 'Nyaman dan eksklusif, cocok untuk mahasiswi atau karyawan. 🌿', 1200000.00, 'Kasur Double, Meja Belajar, Lemari Ac, Kamar Mandi Dalem, Water Heater', 'Kosong', 'kos 21.jpg'),
(21, 'Kamar Banana Chill', 'Cilandak', 'Kamar modern buat anak muda aktif tapi butuh tempat chill. 😎', 1150000.00, 'Kasur Double, Meja Belajar, Lemari Ac, Kamar Mandi Dalem, Water Heater', 'Kosong', 'kos 22.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`id_kamar`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kamar`
--
ALTER TABLE `kamar`
  MODIFY `id_kamar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
