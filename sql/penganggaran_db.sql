-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 19, 2025 at 02:49 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penganggaran_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggaran`
--

CREATE TABLE `anggaran` (
  `id` int NOT NULL,
  `kode_program` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_program` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_sub_program` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nama_sub_program` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `kode_kegiatan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kegiatan` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggaran`
--

INSERT INTO `anggaran` (`id`, `kode_program`, `nama_program`, `kode_sub_program`, `nama_sub_program`, `kode_kegiatan`, `nama_kegiatan`, `created_by`, `created_at`) VALUES
(1, '06.', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '06.05.', 'Sub Program Pelayanan, dan Peningkatan Kualitas Penyelenggaraan Administrasi Perkantoran', '06.05.13.', 'Pengembangan Sistem Informasi untuk menunjang Manajemen Sekolah', NULL, '2025-08-12 07:44:00'),
(2, '06.', 'PROGRAM PENUNJANG URUSAN PEMERINTAHAN DAERAH KABUPATEN/KOTA', '06.05.', 'Sub Program Pelayanan, dan Peningkatan Kualitas Penyelenggaraan Administrasi Perkantoran', '06.05.14.', 'Transportasi atau perjalanan dinas dalam rangka koordinasi dan pelaporan ke Dinas Pendidikan', NULL, '2025-08-12 07:44:14');

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id` int NOT NULL,
  `kode_kegiatan` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `program` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `sub_program` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kegiatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id`, `kode_kegiatan`, `program`, `sub_program`, `nama_kegiatan`, `created_by`, `created_at`) VALUES
(7, '02.02.01.', 'Pengembangan Standar Isi', 'Pengembangan Perpustakaan', 'Kegiatan pemberdayaan perpustakaan terutama untuk pengembangan minat baca peserta didik', 1, '2025-09-08 04:06:17'),
(8, '02.03.01.', 'Pengembangan Standar Isi', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penyusunan Kurikulum', 1, '2025-09-08 04:06:17'),
(9, '02.03.02.', 'Pengembangan Standar Isi', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penyusunan kurikulum kompetensi keahlian', 1, '2025-09-08 04:06:17'),
(10, '02.06.01.', 'Pengembangan Standar Isi', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Kegiatan diskusi kolaborasi pengembangan RPP dalam Komunitas Belajar (termasuk KKG/MGMP/MGMPS/MGPMPK)', 1, '2025-09-08 04:06:17'),
(11, '03.01.01.', 'Pengembangan Standar Proses', 'Penerimaan Peserta Didik Baru', 'Pelaksanaan Pendaftaran Peserta Didik Baru (PPDB)', 1, '2025-09-08 04:06:17'),
(12, '03.01.02.', 'Pengembangan Standar Proses', 'Penerimaan Peserta Didik Baru', 'Pendataan ulang bagi Peserta Didik lama', 1, '2025-09-08 04:06:17'),
(13, '03.01.03.', 'Pengembangan Standar Proses', 'Penerimaan Peserta Didik Baru', 'Pelaksanaan kegiatan orientasi siswa baru yang bersifat akademik dan pengenalan lingkungan tanpa kekerasan', 1, '2025-09-08 04:06:17'),
(14, '03.02.01.', 'Pengembangan Standar Proses', 'Pengembangan Perpustakaan', 'Pelaksanaan kegiatan publikasi berkala sekolah (Majalah Sekolah', 1, '2025-09-08 04:06:17'),
(15, '03.02.02.', 'Pengembangan Standar Proses', 'Pengembangan Perpustakaan', 'Pembeliaan Buku Lembar Kerja Siswa', 1, '2025-09-08 04:06:17'),
(16, '03.02.03.', 'Pengembangan Standar Proses', 'Pengembangan Perpustakaan', 'Penyediaan atau pembiayaan langganan platform perpustakaan digital', 1, '2025-09-08 04:06:17'),
(17, '03.03.01.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penyusunan Silabus / Tujuan Pembelajaran', 1, '2025-09-08 04:06:17'),
(18, '03.03.02.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pengembangan Kegiatan Literasi dan Numerasi', 1, '2025-09-08 04:06:17'),
(19, '03.03.04.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pengembangan pembelajaran berbasis projek (termasuk P5)', 1, '2025-09-08 04:06:17'),
(20, '03.03.05.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penyelenggaraan Perbaikan/Pengayaan (Remedial)', 1, '2025-09-08 04:06:17'),
(21, '03.03.06.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pelaksanaan Ekstrakurikuler Kepramukaan', 1, '2025-09-08 04:06:17'),
(22, '03.03.07.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pelaksanaan Kegiatan Ekstrakurikuler (diluar Kepramukaan)', 1, '2025-09-08 04:06:17'),
(23, '03.03.08.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Program Pembinaan Kesiswaan dan Kepemimpinan Siswa', 1, '2025-09-08 04:06:17'),
(24, '03.03.10.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pengembangan program pencegahan dan penanganan kekerasan di satuan pendidikan (termasuk Program Roots)', 1, '2025-09-08 04:06:17'),
(25, '03.03.11.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penerapan Program Pencegahan Perundungan', 1, '2025-09-08 04:06:17'),
(26, '03.03.12.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penyelenggaraan: pencegahan penyalahgunaan narkotika', 1, '2025-09-08 04:06:17'),
(27, '03.03.13.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Konsultasi peningkatan mutu pendidikan (Konsultan & Psikolog)', 1, '2025-09-08 04:06:17'),
(28, '03.03.14.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penyelenggaraan Pesantren Kilat dan Kegiatan Keagamaan Sejenis', 1, '2025-09-08 04:06:17'),
(29, '03.03.15.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pengembangan kegiatan pelibatan orang tua/wali/keluarga di pembelajaran', 1, '2025-09-08 04:06:17'),
(30, '03.03.16.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penyusunan Pembagian Tugas Guru dan Jadwal Pelajaran', 1, '2025-09-08 04:06:17'),
(31, '03.03.17.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pembiayaan untuk partisipasi kegiatan berbagi praktik baik', 1, '2025-09-08 04:06:17'),
(32, '03.03.18.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pengayaan TIK untuk memfasilitasi kegiatan pembelajaran', 1, '2025-09-08 04:06:17'),
(33, '03.03.19.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pelaksanaan Lomba Lomba', 1, '2025-09-08 04:06:17'),
(34, '03.03.20.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Pelaksanaan Program-Program Sekolah Lainnya', 1, '2025-09-08 04:06:17'),
(35, '03.03.21.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Perayaan Hari Besar Agama', 1, '2025-09-08 04:06:17'),
(36, '03.03.22.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Penyelenggaraan Pembelajaran aktif', 1, '2025-09-08 04:06:17'),
(37, '03.04.01.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Asesmen/Evaluasi Pembelajaran', 'Pelaksanaan supervisi pembelajaran semua mapel/guru di sekolah', 1, '2025-09-08 04:06:17'),
(38, '03.04.02.', 'Pengembangan Standar Proses', 'Pelaksanaan Kegiatan Asesmen/Evaluasi Pembelajaran', 'Pelaksanaan Evaluasi kegiatan ekstrakurikuler', 1, '2025-09-08 04:06:17'),
(39, '03.05.01.', 'Pengembangan Standar Proses', 'Pelaksanaan  Administrasi Kegiatan Sekolah', 'Kegiatan koordinasi dan pelaporan untuk mendukung Program Prioritas Pusat (Program Indonesia Pintar', 1, '2025-09-08 04:06:17'),
(40, '03.05.02.', 'Pengembangan Standar Proses', 'Pelaksanaan  Administrasi Kegiatan Sekolah', 'Penyelenggaraan UKS', 1, '2025-09-08 04:06:17'),
(41, '04.06.01.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Pelaksanaan kegiatan komunitas belajar di satuan pendidikan', 1, '2025-09-08 04:06:17'),
(42, '04.06.02.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Kegiatan Komunitas Belajar antar sekolah (termasuk KKG', 1, '2025-09-08 04:06:17'),
(43, '04.06.03.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Pengembangan diri guru dan tenaga kependidikan materi lain di luar PMM', 1, '2025-09-08 04:06:17'),
(44, '04.06.04.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Pengembangan diri guru dan tenaga kependidikan materi lain melalui PMM', 1, '2025-09-08 04:06:17'),
(45, '04.06.05.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru', 1, '2025-09-08 04:06:17'),
(46, '04.06.06.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Kepala Sekolah', 1, '2025-09-08 04:06:17'),
(47, '04.06.07.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Pembinaan dan Peningkatan Kompetensi Tenaga Pelaksana Sekolah (Tenaga Ekstrakurikuler', 1, '2025-09-08 04:06:17'),
(48, '04.06.08.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Fasilitasi kepesertaan Guru dalam berbagai kegiatan prestasi guru', 1, '2025-09-08 04:06:17'),
(49, '04.06.09.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Kegiatan Magang Guru di Sekolah Lain', 1, '2025-09-08 04:06:17'),
(50, '04.06.11.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk keterlibatan orangtua/wali dan masyarakat dalam pembelajaran', 1, '2025-09-08 04:06:17'),
(51, '04.06.12.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk pengelolaan lingkungan pembelajaran yang aman dan nyaman', 1, '2025-09-08 04:06:17'),
(52, '04.06.13.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memperkuat numerasi', 1, '2025-09-08 04:06:17'),
(53, '04.06.14.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memperkuat literasi', 1, '2025-09-08 04:06:17'),
(54, '04.06.22.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memahami konten pembelajaran dan cara mengajarkannya', 1, '2025-09-08 04:06:17'),
(55, '04.06.23.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memahami Kurikulum dan cara mengajarkannya', 1, '2025-09-08 04:06:17'),
(56, '04.06.24.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk pengembangan diri melalui kebiasaan refleksi', 1, '2025-09-08 04:06:17'),
(57, '04.06.25.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk pembelajaran berorientasi pada peserta didik', 1, '2025-09-08 04:06:17'),
(58, '04.06.26.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk meamahami kematangam moral', 1, '2025-09-08 04:06:17'),
(59, '04.06.27.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk asesmen', 1, '2025-09-08 04:06:17'),
(60, '04.06.31.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk Pemahaman Profil Pelajar Pancasila: Bertakwa Kepada Tuhan YME dan Berakhlak Mulia', 1, '2025-09-08 04:06:17'),
(61, '04.06.32.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk Pemahaman Profil Pelajar Pancasila: Gotong Royong', 1, '2025-09-08 04:06:17'),
(62, '04.06.33.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk Pemahaman Profil Pelajar Pancasila: Kreativitas', 1, '2025-09-08 04:06:17'),
(63, '04.06.34.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk Pemahaman Profil Pelajar Pancasila: Nalar Kritis', 1, '2025-09-08 04:06:17'),
(64, '04.06.35.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk Pemahaman Profil Pelajar Pancasila: Kebinekaan Global', 1, '2025-09-08 04:06:17'),
(65, '04.06.36.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk Pemahaman Profil Pelajar Pancasila: Kemandirian', 1, '2025-09-08 04:06:17'),
(66, '04.06.41.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memahami tentang perundungan', 1, '2025-09-08 04:06:17'),
(67, '04.06.42.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memahami tentang disiplin positif (dan menghindari hukuman fisik)', 1, '2025-09-08 04:06:17'),
(68, '04.06.43.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memahami penyalahgunaan narkotika', 1, '2025-09-08 04:06:17'),
(69, '04.06.44.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memahami toleransi/kesetaraan/moderasi beragama dan budaya', 1, '2025-09-08 04:06:17'),
(70, '04.06.45.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memahami komitmen dan nilai-nilai kebangsaan', 1, '2025-09-08 04:06:17'),
(71, '04.06.46.', 'Pengembangan pendidik dan tenaga kependidikan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Peningkatan Kompetensi Guru untuk memahami sikap inklusif', 1, '2025-09-08 04:06:17'),
(72, '05.02.01.', 'Pengembangan sarana dan prasarana sekolah', 'Pengembangan Perpustakaan', 'Pemeliharaan buku/koleksi perpustakaan', 1, '2025-09-08 04:06:17'),
(73, '05.02.02.', 'Pengembangan sarana dan prasarana sekolah', 'Pengembangan Perpustakaan', 'Pengadaan buku/koleksi perpustakaan (selain buku teks', 1, '2025-09-08 04:06:17'),
(74, '05.02.03.', 'Pengembangan sarana dan prasarana sekolah', 'Pengembangan Perpustakaan', 'Pengadaan Buku Teks Utama/Pendamping Peserta Didik', 1, '2025-09-08 04:06:17'),
(75, '05.02.04.', 'Pengembangan sarana dan prasarana sekolah', 'Pengembangan Perpustakaan', 'Pengadaan Buku Teks Utama/Pendamping Guru', 1, '2025-09-08 04:06:17'),
(76, '05.02.05.', 'Pengembangan sarana dan prasarana sekolah', 'Pengembangan Perpustakaan', 'Pengadaan buku pengayaan dan referensi', 1, '2025-09-08 04:06:17'),
(77, '05.05.01.', 'Pengembangan sarana dan prasarana sekolah', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Penyediaan atau pembuatan media pembelajaran', 1, '2025-09-08 04:06:17'),
(78, '05.05.02.', 'Pengembangan sarana dan prasarana sekolah', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pengembangan sekolah sehat', 1, '2025-09-08 04:06:17'),
(79, '05.08.01.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pemeliharaan Prasarana Lahan', 1, '2025-09-08 04:06:17'),
(80, '05.08.02.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pengadaan Peralatan Sekolah diluar diluar komponen penyediaan alat multimedia pembelajaran', 1, '2025-09-08 04:06:17'),
(81, '05.08.03.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pemeliharaan Peralatan Sekolah', 1, '2025-09-08 04:06:17'),
(82, '05.08.04.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pengadaan Perlengkapan Sekolah diluar komponen penyediaan alat multimedia pembelajaran', 1, '2025-09-08 04:06:17'),
(83, '05.08.05.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pemeliharaan Perlengkapan Sekolah', 1, '2025-09-08 04:06:17'),
(84, '05.08.06.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Penyediaan prasarana akses/fasilitas bagi Peserta Didik Penyandang Disabilitas', 1, '2025-09-08 04:06:17'),
(85, '05.08.07.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pengadaan Peralatan untuk menunjang pembelajaran Peserta Didik Penyandang Disabilitas', 1, '2025-09-08 04:06:17'),
(86, '05.08.08.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pengadaan Sarana Perlengkapan untuk mendukung Peserta Didik Disabilitas', 1, '2025-09-08 04:06:17'),
(87, '05.08.09.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pengadaan Perlengkapan Daya dan Jasa Sekolah (instalasi air', 1, '2025-09-08 04:06:17'),
(88, '05.08.10.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pemeliharaan Perlengkapan Daya dan Jasa Sekolah (instalasi air', 1, '2025-09-08 04:06:17'),
(89, '05.08.11.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Pengadaan seragam untuk peserta didik', 1, '2025-09-08 04:06:17'),
(90, '05.08.12.', 'Pengembangan sarana dan prasarana sekolah', 'Pemeliharaan Sarana dan Prasarana Sekolah', 'Tindakan tanggap darurat dampak bencana (tidak termasuk perbaikan setelah lewat tanggap darurat)', 1, '2025-09-08 04:06:17'),
(91, '05.09.01.', 'Pengembangan sarana dan prasarana sekolah', 'Penyediaan Alat Multi Media Pembelajaran', 'Pengadaan Komputer Desktop/Work-station untuk Pembelajaran', 1, '2025-09-08 04:06:17'),
(92, '05.09.02.', 'Pengembangan sarana dan prasarana sekolah', 'Penyediaan Alat Multi Media Pembelajaran', 'Pengadaan Komputer Laptop', 1, '2025-09-08 04:06:17'),
(93, '05.09.04.', 'Pengembangan sarana dan prasarana sekolah', 'Penyediaan Alat Multi Media Pembelajaran', 'Pengadaan Printer', 1, '2025-09-08 04:06:17'),
(94, '05.09.05.', 'Pengembangan sarana dan prasarana sekolah', 'Penyediaan Alat Multi Media Pembelajaran', 'Pengadaan Proyektor, Layar Proyektor, dan Layar LCD/LED >= 32\"', 1, '2025-09-08 04:06:17'),
(95, '06.05.01.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Penyusunan perencanaan program satuan pendidikan (Visi Misi Sekolah', 1, '2025-09-08 04:06:17'),
(96, '06.05.02.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pengembangan dan Pelaksanaan Program Kerja Kepala Sekolah', 1, '2025-09-08 04:06:17'),
(97, '06.05.03.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pendataan Dapodik', 1, '2025-09-08 04:06:17'),
(98, '06.05.04.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pelaksanaan Monitoring Program/Kegiatan Sekolah', 1, '2025-09-08 04:06:17'),
(99, '06.05.05.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pelaksanaan Supervisi Administrasi Tata Usaha', 1, '2025-09-08 04:06:17'),
(100, '06.05.06.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Konsumsi Rapat Kedinasan dan Tamu Sekolah (diluar kegiatan lain)', 1, '2025-09-08 04:06:17'),
(101, '06.05.07.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pengadaan Bahan Praktik Pembelajaran', 1, '2025-09-08 04:06:17'),
(102, '06.05.08.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pembelian Bahan Habis Pakai untuk mendukung pembelajaran dan administrasi sekolah (termasuk ATK', 1, '2025-09-08 04:06:17'),
(103, '06.05.09.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pembelian bahan habis pakai/alat penunjang kebersihan dan sanitasi sekolah', 1, '2025-09-08 04:06:17'),
(104, '06.05.10.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pembelian Bahan Habis Pakai (termasuk Suku Cadang Alat) untuk Kegiatan Rumah Tangga Sekolah', 1, '2025-09-08 04:06:17'),
(105, '06.05.11.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pengelolaan dan operasional rutin sekolah dalam pembelajaran jarak jauh', 1, '2025-09-08 04:06:17'),
(106, '06.05.12.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pengembangan dan pemeliharaan Website Sekolah (termasuk media sosial sekolah)', 1, '2025-09-08 04:06:17'),
(107, '06.05.13.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Pengembangan Sistem Informasi untuk menunjang Manajemen Sekolah', 1, '2025-09-08 04:06:17'),
(108, '06.05.14.', 'Pengembangan standar pengelolaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Transportasi atau perjalanan dinas dalam rangka koordinasi dan pelaporan ke Dinas Pendidikan', 1, '2025-09-08 04:06:17'),
(109, '06.06.01.', 'Pengembangan standar pengelolaan', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Kegiatan kerjasama dengan sekolah bertaraf internasional untuk peningkatan kompetensi guru', 1, '2025-09-08 04:06:17'),
(110, '06.07.01.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Pembayaran daya listrik', 1, '2025-09-08 04:06:17'),
(111, '06.07.02.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Penambahan daya listrik', 1, '2025-09-08 04:06:17'),
(112, '06.07.03.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Pembayaran langganan air', 1, '2025-09-08 04:06:17'),
(113, '06.07.04.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Pembayaran biaya telepon', 1, '2025-09-08 04:06:17'),
(114, '06.07.05.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Pembayaran jasa internet', 1, '2025-09-08 04:06:17'),
(115, '06.07.06.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Penambahan daya internet', 1, '2025-09-08 04:06:17'),
(116, '06.07.07.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Pembelian Bahan Bakar Minyak/Gas untuk keperluan pembelajaran/RT Sekolah', 1, '2025-09-08 04:06:17'),
(117, '06.07.08.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Pembayaran Retribusi keamanan dan sampah', 1, '2025-09-08 04:06:17'),
(118, '06.07.09.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Pembayaran langganan koran dan majalah', 1, '2025-09-08 04:06:17'),
(119, '06.07.10.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Sewa genset', 1, '2025-09-08 04:06:17'),
(120, '06.07.12.', 'Pengembangan standar pengelolaan', 'Pembiayaan Langganan Daya dan Jasa', 'Belanja Sewa Rumah/Gedung/Gudang/Parkir/tanah (diluar bangunan utama sekolah', 1, '2025-09-08 04:06:17'),
(121, '07.05.01.', 'Pengembangan standar pembiayaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Bea materai', 1, '2025-09-08 04:06:17'),
(122, '07.05.02.', 'Pengembangan standar pembiayaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Penggandaan laporan dan/atau surat-menyurat', 1, '2025-09-08 04:06:17'),
(123, '07.05.03.', 'Pengembangan standar pembiayaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Penyelenggaraan sosialisasi dan pelaporan program', 1, '2025-09-08 04:06:17'),
(124, '07.05.04.', 'Pengembangan standar pembiayaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Penyelenggaraan kegiatan inventarisasi dan pendokumentasian nilai aset semua sarpras sekolah pada tahun berjalan', 1, '2025-09-08 04:06:17'),
(125, '07.05.05.', 'Pengembangan standar pembiayaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Penggalangan', 1, '2025-09-08 04:06:17'),
(126, '07.05.06.', 'Pengembangan standar pembiayaan', 'Pelaksanaan Administrasi Kegiatan Sekolah', 'Perjalanan dinas dalam rangka mengambil dana BOS di Bank (untuk sekolah terpencil)', 1, '2025-09-08 04:06:17'),
(127, '07.12.01.', 'Pengembangan standar pembiayaan', 'Pembayaran Honor', 'Pembayaran honor Guru/Pendidik', 1, '2025-09-08 04:06:17'),
(128, '07.12.02.', 'Pengembangan standar pembiayaan', 'Pembayaran Honor', 'Pembayaran honor Tenaga Kependidikan (selain pendidik)', 1, '2025-09-08 04:06:17'),
(129, '07.12.03.', 'Pengembangan standar pembiayaan', 'Pembayaran Honor', 'Pembayaran Honor tenaga administrasi', 1, '2025-09-08 04:06:17'),
(130, '07.12.04.', 'Pengembangan standar pembiayaan', 'Pembayaran Honor', 'Pembayaran honor Tenaga Penunjang atau pelaksana', 1, '2025-09-08 04:06:17'),
(131, '08.03.01.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Seleksi Siswa Program Bilingual', 1, '2025-09-08 04:06:17'),
(132, '08.03.02.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Pembelajaran dan Ekstrakurikuler', 'Seleksi Peserta Didik Program Kelas Akselerasi', 1, '2025-09-08 04:06:17'),
(134, '08.04.02.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Penyiapan dan Pelaksanaan Asesmen di Awal Pembelajaran', 1, '2025-09-08 04:06:17'),
(135, '08.04.03.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Penyusunan kisi-kisi dan penyusunan soal penilaian formatif (ulangan harian)', 1, '2025-09-08 04:06:17'),
(136, '08.04.04.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Pelaksanaan penilaian formatif (ulangan harian)', 1, '2025-09-08 04:06:17'),
(137, '08.04.05.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Penyusunan kisi-kisi dan penyusunan soal penilaian sumatif (ulangan tengah semester/akhir semester/kenaikan kelas)', 1, '2025-09-08 04:06:17'),
(138, '08.04.06.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Pelaksanaan penilaian sumatif (ulangan tengah semester/akhir semester/kenaikan kelas)', 1, '2025-09-08 04:06:17'),
(139, '08.04.07.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Penyusunan Kisi-Kisi dan Penyusunan Soal Penilaian/Asesmen Sekolah (Akhir Sekolah)', 1, '2025-09-08 04:06:17'),
(141, '08.04.09.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Penyusunan Kriteria Kenaikan Kelas', 1, '2025-09-08 04:06:17'),
(142, '08.04.10.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Penyusunan Kompetensi Ketuntasan Minimal', 1, '2025-09-08 04:06:17'),
(143, '08.04.11.', 'Pengembangan dan implementasi sistem penilaian', 'Pelaksanaan Kegiatan Asesmen dan Evaluasi Pembelajaran', 'Pengembangan Perangkat Asesmen Kejuruan', 1, '2025-09-08 04:06:17'),
(144, '08.06.01.', 'Pengembangan dan implementasi sistem penilaian', 'Pengembangan Profesi Pendidik dan Tenaga Kependidikan', 'Fasilitasi pengembangan kompetensi guru melalui diseminasi PSP (IHT', 1, '2025-09-08 04:06:17');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int NOT NULL,
  `menu_key` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` int DEFAULT NULL,
  `sort_order` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekening`
--

CREATE TABLE `rekening` (
  `id` int NOT NULL,
  `kode_rekening` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_belanja` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_rekening` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekening`
--

INSERT INTO `rekening` (`id`, `kode_rekening`, `nama_belanja`, `nama_rekening`, `created_by`, `created_at`) VALUES
(301, '5.1.02.01.01.0001', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Bahan Bangunan dan Konstruksi', NULL, '2025-09-08 03:35:52'),
(302, '5.1.02.01.01.0002', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Bahan Kimia', NULL, '2025-09-08 03:35:52'),
(303, '5.1.02.01.01.0004', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Bahan Bakar dan Pelumas', NULL, '2025-09-08 03:35:52'),
(304, '5.1.02.01.01.0005', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Bahan Baku Praktek KBM', NULL, '2025-09-08 03:35:52'),
(305, '5.1.02.01.01.0008', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Bahan/Bibit Tanaman', NULL, '2025-09-08 03:35:52'),
(306, '5.1.02.01.01.0009', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Isi Tabung Pemadam Kebakaran', NULL, '2025-09-08 03:35:52'),
(307, '5.1.02.01.01.0010', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Isi Tabung Gas', NULL, '2025-09-08 03:35:52'),
(308, '5.1.02.01.01.0011', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Bahan/Bibit Ternak/Bibit Ikan', NULL, '2025-09-08 03:35:52'),
(309, '5.1.02.01.01.0012', 'Belanja Barang Pakai Habis', 'Belanja Bahan-Bahan Lainnya', NULL, '2025-09-08 03:35:52'),
(310, '5.1.02.01.01.0013', 'Belanja Barang Pakai Habis', 'Belanja Suku Cadang-Suku Cadang Alat Angkutan', NULL, '2025-09-08 03:35:52'),
(311, '5.1.02.01.01.0016', 'Belanja Barang Pakai Habis', 'Belanja Suku Cadang-Suku Cadang Alat Laboratorium', NULL, '2025-09-08 03:35:52'),
(312, '5.1.02.01.01.0017', 'Belanja Barang Pakai Habis', 'Belanja Suku Cadang-Suku Cadang Alat Pemancar', NULL, '2025-09-08 03:35:52'),
(313, '5.1.02.01.01.0018', 'Belanja Barang Pakai Habis', 'Belanja Suku Cadang-Suku Cadang Alat Studio dan Komunikasi', NULL, '2025-09-08 03:35:52'),
(314, '5.1.02.01.01.0019', 'Belanja Barang Pakai Habis', 'Belanja Suku Cadang-Suku Cadang Alat Pertanian', NULL, '2025-09-08 03:35:52'),
(315, '5.1.02.01.01.0020', 'Belanja Barang Pakai Habis', 'Belanja Suku Cadang-Suku Cadang Alat Bengkel', NULL, '2025-09-08 03:35:52'),
(316, '5.1.02.01.01.0024', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Tulis Kantor', NULL, '2025-09-08 03:35:52'),
(317, '5.1.02.01.01.0025', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Kertas dan Cover', NULL, '2025-09-08 03:35:52'),
(318, '5.1.02.01.01.0026', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Bahan Cetak dan Penggandaan', NULL, '2025-09-08 03:35:52'),
(319, '5.1.02.01.01.0027', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Benda Pos', NULL, '2025-09-08 03:35:52'),
(320, '5.1.02.01.01.0029', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Bahan Komputer', NULL, '2025-09-08 03:35:52'),
(321, '5.1.02.01.01.0030', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perabot Kantor', NULL, '2025-09-08 03:35:52'),
(322, '5.1.02.01.01.0031', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat Listrik', NULL, '2025-09-08 03:35:52'),
(323, '5.1.02.01.01.0032', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Perlengkapan Dinas', NULL, '2025-09-08 03:35:52'),
(324, '5.1.02.01.01.0034', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Perlengkapan Pendukung Olahraga', NULL, '2025-09-08 03:35:52'),
(325, '5.1.02.01.01.0035', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor- Suvenir/Cendera Mata', NULL, '2025-09-08 03:35:52'),
(326, '5.1.02.01.01.0036', 'Belanja Barang Pakai Habis', 'Belanja Alat/Bahan untuk Kegiatan Kantor-Alat/Bahan untuk Kegiatan Kantor Lainnya', NULL, '2025-09-08 03:35:52'),
(327, '5.1.02.01.01.0037', 'Belanja Barang Pakai Habis', 'Belanja Obat-Obat-Obatan', NULL, '2025-09-08 03:35:52'),
(328, '5.1.02.01.01.0043', 'Belanja Barang Pakai Habis', 'Belanja Natura dan Pakan-Natura', NULL, '2025-09-08 03:35:52'),
(329, '5.1.02.01.01.0045', 'Belanja Barang Pakai Habis', 'Belanja Natura dan Pakan-Natura dan Pakan Lainnya', NULL, '2025-09-08 03:35:52'),
(330, '5.1.02.01.01.0052', 'Belanja Barang Pakai Habis', 'Belanja Makanan dan Minuman Rapat', NULL, '2025-09-08 03:35:52'),
(331, '5.1.02.01.01.0053', 'Belanja Barang Pakai Habis', 'Belanja Makanan dan Minuman Jamuan Tamu', NULL, '2025-09-08 03:35:52'),
(332, '5.1.02.01.01.0055', 'Belanja Barang Pakai Habis', 'Belanja Makanan dan Minuman pada Fasilitas Pelayanan Urusan Pendidikan', NULL, '2025-09-08 03:35:52'),
(333, '5.1.02.01.01.0064', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Dinas Lapangan (PDL)', NULL, '2025-09-08 03:35:52'),
(334, '5.1.02.01.01.0066', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Dinas Upacara (PDU)', NULL, '2025-09-08 03:35:52'),
(335, '5.1.02.01.01.0067', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Penyelamatan', NULL, '2025-09-08 03:35:52'),
(336, '5.1.02.01.01.0069', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Teknik', NULL, '2025-09-08 03:35:52'),
(337, '5.1.02.01.01.0071', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Kerja Laboratorium', NULL, '2025-09-08 03:35:52'),
(338, '5.1.02.01.01.0072', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Kerja Bengkel', NULL, '2025-09-08 03:35:52'),
(339, '5.1.02.01.01.0074', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Adat Daerah', NULL, '2025-09-08 03:35:52'),
(340, '5.1.02.01.01.0075', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Batik Tradisional', NULL, '2025-09-08 03:35:52'),
(341, '5.1.02.01.01.0076', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Olahraga', NULL, '2025-09-08 03:35:52'),
(342, '5.1.02.01.01.0077', 'Belanja Barang Pakai Habis', 'Belanja Pakaian Paskibraka', NULL, '2025-09-08 03:35:52'),
(343, '5.1.02.01.02.0003', 'Belanja Barang Tak Habis Pakai', 'Belanja Komponen-Komponen Peralatan', NULL, '2025-09-08 03:35:52'),
(344, '5.1.02.02.01.0003', 'Belanja Jasa Kantor', 'Honorarium Narasumber atau Pembahas', NULL, '2025-09-08 03:35:52'),
(345, '5.1.02.02.01.0004', 'Belanja Jasa Kantor', 'Honorarium Tim Pelaksana Kegiatan dan Sekretariat Tim Pelaksana Kegiatan', NULL, '2025-09-08 03:35:52'),
(346, '5.1.02.02.01.0006', 'Belanja Jasa Kantor', 'Honorarium Penyuluhan atau Pendampingan', NULL, '2025-09-08 03:35:52'),
(347, '5.1.02.02.01.0007', 'Belanja Jasa Kantor', 'Honorarium Rohaniwan', NULL, '2025-09-08 03:35:52'),
(348, '5.1.02.02.01.0008', 'Belanja Jasa Kantor', 'Honorarium Tim Penyusunan Jurnal', NULL, '2025-09-08 03:35:52'),
(349, '5.1.02.02.01.0009', 'Belanja Jasa Kantor', 'Honorarium Penyelenggara Ujian', NULL, '2025-09-08 03:35:52'),
(350, '5.1.02.02.01.0011', 'Belanja Jasa Kantor', 'Honorarium Penyelenggaraan Kegiatan Pendidikan dan Pelatihan', NULL, '2025-09-08 03:35:52'),
(351, '5.1.02.02.01.0013', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Pendidikan / Honorarium Guru', NULL, '2025-09-08 03:35:52'),
(352, '5.1.02.02.01.0015', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Laboratorium', NULL, '2025-09-08 03:35:52'),
(353, '5.1.02.02.01.0016', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Penanganan Prasarana dan Sarana Umum / Upah Tukang', NULL, '2025-09-08 03:35:52'),
(354, '5.1.02.02.01.0025', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Kesenian dan Kebudayaan', NULL, '2025-09-08 03:35:52'),
(355, '5.1.02.02.01.0026', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Administrasi', NULL, '2025-09-08 03:35:52'),
(356, '5.1.02.02.01.0027', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Operator Komputer', NULL, '2025-09-08 03:35:52'),
(357, '5.1.02.02.01.0029', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Ahli', NULL, '2025-09-08 03:35:52'),
(358, '5.1.02.02.01.0030', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Kebersihan', NULL, '2025-09-08 03:35:52'),
(359, '5.1.02.02.01.0031', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Keamanan', NULL, '2025-09-08 03:35:52'),
(360, '5.1.02.02.01.0035', 'Belanja Jasa Kantor', 'Belanja Jasa Tenaga Teknisi Mekanik dan Listrik', NULL, '2025-09-08 03:35:52'),
(361, '5.1.02.02.01.0036', 'Belanja Jasa Kantor', 'Belanja Jasa Audit/Surveillance ISO', NULL, '2025-09-08 03:35:52'),
(362, '5.1.02.02.01.0037', 'Belanja Jasa Kantor', 'Belanja Jasa Juri Perlombaan/Pertandingan', NULL, '2025-09-08 03:35:52'),
(363, '5.1.02.02.01.0038', 'Belanja Jasa Kantor', 'Belanja Jasa Tata Rias', NULL, '2025-09-08 03:35:52'),
(364, '5.1.02.02.01.0041', 'Belanja Jasa Kantor', 'Belanja Jasa Pemasangan Instalasi Telepon', NULL, '2025-09-08 03:35:52'),
(365, '5.1.02.02.01.0042', 'Belanja Jasa Kantor', 'Belanja Jasa Pelaksanaan Transaksi Keuangan', NULL, '2025-09-08 03:35:52'),
(366, '5.1.02.02.01.0049', 'Belanja Jasa Kantor', 'Belanja Jasa Pencucian Pakaian', NULL, '2025-09-08 03:35:52'),
(367, '5.1.02.02.01.0050', 'Belanja Jasa Kantor', 'Belanja Jasa Kalibrasi', NULL, '2025-09-08 03:35:52'),
(368, '5.1.02.02.01.0051', 'Belanja Jasa Kantor', 'Belanja Jasa Pengolahan Sampah', NULL, '2025-09-08 03:35:52'),
(369, '5.1.02.02.01.0052', 'Belanja Jasa Kantor', 'Belanja Jasa Pembersihan', NULL, '2025-09-08 03:35:52'),
(370, '5.1.02.02.01.0057', 'Belanja Jasa Kantor', 'Belanja Jasa Operator Kapal', NULL, '2025-09-08 03:35:52'),
(371, '5.1.02.02.01.0059', 'Belanja Jasa Kantor', 'Belanja Tagihan Telepon', NULL, '2025-09-08 03:35:52'),
(372, '5.1.02.02.01.0060', 'Belanja Jasa Kantor', 'Belanja Tagihan Air', NULL, '2025-09-08 03:35:52'),
(373, '5.1.02.02.01.0061', 'Belanja Jasa Kantor', 'Belanja Tagihan Listrik', NULL, '2025-09-08 03:35:52'),
(374, '5.1.02.02.01.0062', 'Belanja Jasa Kantor', 'Belanja Langganan Jurnal/Surat Kabar/Majalah', NULL, '2025-09-08 03:35:52'),
(375, '5.1.02.02.01.0063', 'Belanja Jasa Kantor', 'Belanja Kawat/Faksimili/Internet/TV Berlangganan', NULL, '2025-09-08 03:35:52'),
(376, '5.1.02.02.01.0064', 'Belanja Jasa Kantor', 'Belanja Paket/Pengiriman', NULL, '2025-09-08 03:35:52'),
(377, '5.1.02.02.01.0065', 'Belanja Jasa Kantor', 'Belanja Penambahan Daya', NULL, '2025-09-08 03:35:52'),
(378, '5.1.02.02.01.0066', 'Belanja Jasa Kantor', 'Belanja Registrasi/Keanggotaan', NULL, '2025-09-08 03:35:52'),
(379, '5.1.02.02.01.0067', 'Belanja Jasa Kantor', 'Belanja Pembayaran Bea', NULL, '2025-09-08 03:35:52'),
(380, '5.1.02.02.01.0071', 'Belanja Jasa Kantor', 'Belanja Lembur', NULL, '2025-09-08 03:35:52'),
(381, '5.1.02.02.02.0008', 'Belanja Iuran Jaminan/Asuransi', 'Belanja Asuransi Barang Milik Daerah', NULL, '2025-09-08 03:35:52'),
(382, '5.1.02.02.03.0002', 'Belanja Sewa Tanah', 'Belanja Sewa Tanah untuk Bangunan Gedung Perdagangan/Perusahaan/Pendidikan', NULL, '2025-09-08 03:35:52'),
(383, '5.1.02.02.04.0001', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Tractor', NULL, '2025-09-08 03:35:52'),
(384, '5.1.02.02.04.0010', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Pengangkat', NULL, '2025-09-08 03:35:52'),
(385, '5.1.02.02.04.0012', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Besar Darat Lainnya', NULL, '2025-09-08 03:35:52'),
(386, '5.1.02.02.04.0022', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Electric Generating Set', NULL, '2025-09-08 03:35:52'),
(387, '5.1.02.02.04.0023', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Pompa', NULL, '2025-09-08 03:35:52'),
(388, '5.1.02.02.04.0031', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Peralatan Selam', NULL, '2025-09-08 03:35:52'),
(389, '5.1.02.02.04.0036', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Kendaraan Bermotor Penumpang', NULL, '2025-09-08 03:35:52'),
(390, '5.1.02.02.04.0037', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Kendaraan Bermotor Angkutan Barang', NULL, '2025-09-08 03:35:52'),
(391, '5.1.02.02.04.0038', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Kendaraan Bermotor Beroda Dua', NULL, '2025-09-08 03:35:52'),
(392, '5.1.02.02.04.0039', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Kendaraan Bermotor Beroda Tiga', NULL, '2025-09-08 03:35:52'),
(393, '5.1.02.02.04.0117', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Kantor Lainnya', NULL, '2025-09-08 03:35:52'),
(394, '5.1.02.02.04.0118', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Mebel', NULL, '2025-09-08 03:35:52'),
(395, '5.1.02.02.04.0123', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Rumah Tangga Lainnya (Home Use)', NULL, '2025-09-08 03:35:52'),
(396, '5.1.02.02.04.0132', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Peralatan Studio Audio', NULL, '2025-09-08 03:35:52'),
(397, '5.1.02.02.04.0133', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Peralatan Studio Video dan Film', NULL, '2025-09-08 03:35:52'),
(398, '5.1.02.02.04.0134', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Peralatan Studio Gambar', NULL, '2025-09-08 03:35:52'),
(399, '5.1.02.02.04.0137', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Studio Lainnya', NULL, '2025-09-08 03:35:52'),
(400, '5.1.02.02.04.0140', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Komunikasi Radio HF/FM', NULL, '2025-09-08 03:35:52'),
(401, '5.1.02.02.04.0308', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:Bahasa Indonesia', NULL, '2025-09-08 03:35:52'),
(402, '5.1.02.02.04.0309', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:Matematika', NULL, '2025-09-08 03:35:52'),
(403, '5.1.02.02.04.0310', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:IPA Dasar', NULL, '2025-09-08 03:35:52'),
(404, '5.1.02.02.04.0311', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:IPA Lanjutan', NULL, '2025-09-08 03:35:52'),
(405, '5.1.02.02.04.0312', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:IPA Menengah', NULL, '2025-09-08 03:35:52'),
(406, '5.1.02.02.04.0313', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:IPA Atas', NULL, '2025-09-08 03:35:52'),
(407, '5.1.02.02.04.0314', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:IPS', NULL, '2025-09-08 03:35:52'),
(408, '5.1.02.02.04.0315', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:Agama', NULL, '2025-09-08 03:35:52'),
(409, '5.1.02.02.04.0316', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:Keterampilan', NULL, '2025-09-08 03:35:52'),
(410, '5.1.02.02.04.0317', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:Kesenian', NULL, '2025-09-08 03:35:52'),
(411, '5.1.02.02.04.0318', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:Olahraga', NULL, '2025-09-08 03:35:52'),
(412, '5.1.02.02.04.0319', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Praktik Sekolah Bidang Studi:PKN', NULL, '2025-09-08 03:35:52'),
(413, '5.1.02.02.04.0320', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Luar Biasa (Tuna Netra', NULL, '2025-09-08 03:35:52'),
(414, '5.1.02.02.04.0321', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga Kejuruan', NULL, '2025-09-08 03:35:52'),
(415, '5.1.02.02.04.0322', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Alat Peraga PAUD/TK', NULL, '2025-09-08 03:35:52'),
(416, '5.1.02.02.04.0355', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Peralatan Umum', NULL, '2025-09-08 03:35:52'),
(417, '5.1.02.02.04.0406', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Komputer Unit Lainnya', NULL, '2025-09-08 03:35:52'),
(418, '5.1.02.02.04.0411', 'Belanja Sewa Peralatan dan Mesin', 'Belanja Sewa Peralatan Komputer Lainnya', NULL, '2025-09-08 03:35:52'),
(419, '5.1.02.02.05.0009', 'Belanja Sewa Gedung dan Bangunan', 'Belanja Sewa Bangunan Gedung Tempat Pertemuan', NULL, '2025-09-08 03:35:52'),
(420, '5.1.02.02.05.0011', 'Belanja Sewa Gedung dan Bangunan', 'Belanja Sewa Bangunan Gedung Tempat Olahraga', NULL, '2025-09-08 03:35:52'),
(421, '5.1.02.02.05.0030', 'Belanja Sewa Gedung dan Bangunan', 'Belanja Sewa Bangunan Gedung Tempat Kerja Lainnya', NULL, '2025-09-08 03:35:52'),
(422, '5.1.02.02.12.0001', 'Belanja Kursus/Pelatihan', 'Sosialisasi', NULL, '2025-09-08 03:35:52'),
(423, '5.1.02.03.02.0036', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Angkutan-Alat Angkutan Darat Bermotor-Kendaraan Bermotor Penumpang', NULL, '2025-09-08 03:35:52'),
(424, '5.1.02.03.02.0113', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Kantor-Mesin Ketik', NULL, '2025-09-08 03:35:52'),
(425, '5.1.02.03.02.0115', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Kantor-Alat Reproduksi (Penggandaan) / Pemeliaharaan Printer', NULL, '2025-09-08 03:35:52'),
(426, '5.1.02.03.02.0116', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Kantor-Alat Penyimpan Perlengkapan Kantor', NULL, '2025-09-08 03:35:52'),
(427, '5.1.02.03.02.0117', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Kantor-Alat Kantor Lainnya', NULL, '2025-09-08 03:35:52'),
(428, '5.1.02.03.02.0118', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Mebel', NULL, '2025-09-08 03:35:52'),
(429, '5.1.02.03.02.0120', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Pembersih', NULL, '2025-09-08 03:35:52'),
(430, '5.1.02.03.02.0121', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Pendingin', NULL, '2025-09-08 03:35:52'),
(431, '5.1.02.03.02.0123', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Rumah Tangga Lainnya (Home Use)', NULL, '2025-09-08 03:35:52'),
(432, '5.1.02.03.02.0124', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Kantor dan Rumah Tangga-Alat Rumah Tangga-Alat Pemadam Kebakaran', NULL, '2025-09-08 03:35:52'),
(433, '5.1.02.03.02.0308', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:Bahasa Indonesia', NULL, '2025-09-08 03:35:52'),
(434, '5.1.02.03.02.0309', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:Matematika', NULL, '2025-09-08 03:35:52'),
(435, '5.1.02.03.02.0310', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:IPA Dasar', NULL, '2025-09-08 03:35:52'),
(436, '5.1.02.03.02.0311', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:IPA Lanjutan', NULL, '2025-09-08 03:35:52'),
(437, '5.1.02.03.02.0312', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:IPA Menengah', NULL, '2025-09-08 03:35:52'),
(438, '5.1.02.03.02.0313', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:IPA Atas', NULL, '2025-09-08 03:35:52'),
(439, '5.1.02.03.02.0314', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:IPS', NULL, '2025-09-08 03:35:52'),
(440, '5.1.02.03.02.0315', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:Agama', NULL, '2025-09-08 03:35:52'),
(441, '5.1.02.03.02.0316', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:Keterampilan', NULL, '2025-09-08 03:35:52'),
(442, '5.1.02.03.02.0317', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:Kesenian', NULL, '2025-09-08 03:35:52'),
(443, '5.1.02.03.02.0318', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:Olahraga', NULL, '2025-09-08 03:35:52'),
(444, '5.1.02.03.02.0319', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Praktik Sekolah Bidang Studi:PKN', NULL, '2025-09-08 03:35:52'),
(445, '5.1.02.03.02.0320', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Luar Biasa (Tuna Netra', NULL, '2025-09-08 03:35:52'),
(446, '5.1.02.03.02.0321', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga Kejuruan', NULL, '2025-09-08 03:35:52'),
(447, '5.1.02.03.02.0322', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Laboratorium-Alat Peraga Praktik Sekolah-Alat Peraga PAUD/TK', NULL, '2025-09-08 03:35:52'),
(448, '5.1.02.03.02.0404', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Komputer-Komputer Unit-Komputer Jaringan', NULL, '2025-09-08 03:35:52'),
(449, '5.1.02.03.02.0405', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Komputer-Komputer Unit-Personal Computer', NULL, '2025-09-08 03:35:52'),
(450, '5.1.02.03.02.0407', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Mainframe', NULL, '2025-09-08 03:35:52'),
(451, '5.1.02.03.02.0408', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Mini Computer', NULL, '2025-09-08 03:35:52'),
(452, '5.1.02.03.02.0409', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Personal Computer', NULL, '2025-09-08 03:35:52'),
(453, '5.1.02.03.02.0410', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Jaringan', NULL, '2025-09-08 03:35:52'),
(454, '5.1.02.03.02.0411', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Komputer-Peralatan Komputer-Peralatan Komputer Lainnya', NULL, '2025-09-08 03:35:52'),
(455, '5.1.02.03.02.0463', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Alat Peraga-Alat Peraga Pelatihan dan Percontohan-Alat Peraga Pelatihan', NULL, '2025-09-08 03:35:52'),
(456, '5.1.02.03.02.0504', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Peralatan Olahraga-Peralatan Olahraga-Peralatan Olahraga Atletik', NULL, '2025-09-08 03:35:52'),
(457, '5.1.02.03.02.0505', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Peralatan Olahraga-Peralatan Olahraga-Peralatan Permainan', NULL, '2025-09-08 03:35:52'),
(458, '5.1.02.03.02.0506', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Peralatan Olahraga-Peralatan Olahraga-Peralatan Senam', NULL, '2025-09-08 03:35:52'),
(459, '5.1.02.03.02.0507', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Peralatan Olahraga-Peralatan Olahraga-Peralatan Olahraga Air', NULL, '2025-09-08 03:35:52'),
(460, '5.1.02.03.02.0508', 'Belanja Pemeliharaan Peralatan dan Mesin', 'Belanja Pemeliharaan Peralatan Olahraga-Peralatan Olahraga-Peralatan Olahraga Udara', NULL, '2025-09-08 03:35:52'),
(461, '5.1.02.03.03.0001', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Kantor', NULL, '2025-09-08 03:35:52'),
(462, '5.1.02.03.03.0002', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gudang', NULL, '2025-09-08 03:35:52'),
(463, '5.1.02.03.03.0005', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Laboratorium', NULL, '2025-09-08 03:35:52'),
(464, '5.1.02.03.03.0006', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Kesehatan', NULL, '2025-09-08 03:35:52'),
(465, '5.1.02.03.03.0008', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Tempat Ibadah', NULL, '2025-09-08 03:35:52'),
(466, '5.1.02.03.03.0009', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Tempat Pertemuan', NULL, '2025-09-08 03:35:52'),
(467, '5.1.02.03.03.0010', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Tempat Pendidikan', NULL, '2025-09-08 03:35:52'),
(468, '5.1.02.03.03.0011', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Tempat Olahraga', NULL, '2025-09-08 03:35:52'),
(469, '5.1.02.03.03.0013', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung untuk Pos Jaga', NULL, '2025-09-08 03:35:52'),
(470, '5.1.02.03.03.0016', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Perpustakaan', NULL, '2025-09-08 03:35:52'),
(471, '5.1.02.03.03.0030', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Gedung Tempat Kerja Lainnya', NULL, '2025-09-08 03:35:52'),
(472, '5.1.02.03.03.0033', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Bangunan Parkir', NULL, '2025-09-08 03:35:52'),
(473, '5.1.02.03.03.0036', 'Belanja Pemeliharaan Gedung dan Bangunan', 'Belanja Pemeliharaan Bangunan Gedung-Bangunan Gedung Tempat Kerja-Taman', NULL, '2025-09-08 03:35:52'),
(474, '5.1.02.03.04.0075', 'Belanja Pemeliharaan Jalan', 'Jaringan', NULL, '2025-09-08 03:35:52'),
(475, '5.1.02.03.04.0076', 'Belanja Pemeliharaan Jalan', 'Jaringan', NULL, '2025-09-08 03:35:52'),
(476, '5.1.02.03.05.0001', 'Belanja Pemeliharaan Aset Tetap Lainnya', 'Belanja Pemeliharaan Bahan Perpustakaan-Bahan Perpustakaan Tercetak-Buku Umum', NULL, '2025-09-08 03:35:52'),
(477, '5.1.02.03.05.0021', 'Belanja Pemeliharaan Aset Tetap Lainnya', 'Belanja Pemeliharaan Bahan Perpustakaan-Musik-Musik Lainnya', NULL, '2025-09-08 03:35:52'),
(478, '5.1.02.03.05.0028', 'Belanja Pemeliharaan Aset Tetap Lainnya', 'Belanja Pemeliharaan Barang Bercorak Kesenian/Kebudayaan/Olahraga-Barang Bercorak Kesenian-Alat Musik', NULL, '2025-09-08 03:35:52'),
(479, '5.1.02.03.05.0030', 'Belanja Pemeliharaan Aset Tetap Lainnya', 'Belanja Pemeliharaan Barang Bercorak Kesenian/Kebudayaan/Olahraga-Barang Bercorak Kesenian-Alat Peraga Kesenian', NULL, '2025-09-08 03:35:52'),
(480, '5.1.02.04.01.0001', 'Belanja Perjalanan Dinas Dalam Negeri', 'Belanja Perjalanan Dinas Biasa / Luar Daerah', NULL, '2025-09-08 03:35:52'),
(481, '5.1.02.04.01.0003', 'Belanja Perjalanan Dinas Dalam Negeri', 'Belanja Perjalanan Dinas Dalam Kota / Dalam Daerah', NULL, '2025-09-08 03:35:52'),
(482, '5.1.02.04.01.0004', 'Belanja Perjalanan Dinas Dalam Negeri', 'Belanja Perjalanan Dinas Paket Meeting Dalam Kota', NULL, '2025-09-08 03:35:52'),
(483, '5.1.02.04.01.0005', 'Belanja Perjalanan Dinas Dalam Negeri', 'Belanja Perjalanan Dinas Paket Meeting Luar Kota', NULL, '2025-09-08 03:35:52'),
(484, '5.2.02.01.03.0003', 'Belanja Modal Alat Bantu', 'Belanja Modal Compressor', NULL, '2025-09-08 03:35:52'),
(485, '5.2.02.01.03.0004', 'Belanja Modal Alat Bantu', 'Belanja Modal Electric Generating Set', NULL, '2025-09-08 03:35:52'),
(486, '5.2.02.01.03.0005', 'Belanja Modal Alat Bantu', 'Belanja Modal Pompa', NULL, '2025-09-08 03:35:52'),
(487, '5.2.02.03.03.0010', 'Belanja Modal Alat Ukur', 'Belanja Modal Alat Timbangan/Biara', NULL, '2025-09-08 03:35:52'),
(488, '5.2.02.05.01.0001', 'Belanja Modal Alat Kantor', 'Belanja Modal Mesin Ketik', NULL, '2025-09-08 03:35:52'),
(489, '5.2.02.05.01.0002', 'Belanja Modal Alat Kantor', 'Belanja Modal Mesin Hitung/Mesin Jumlah', NULL, '2025-09-08 03:35:52'),
(490, '5.2.02.05.01.0003', 'Belanja Modal Alat Kantor', 'Belanja Modal Alat Reproduksi (Penggandaan)', NULL, '2025-09-08 03:35:52'),
(491, '5.2.02.05.01.0004', 'Belanja Modal Alat Kantor', 'Belanja Modal Alat Penyimpan Perlengkapan Kantor', NULL, '2025-09-08 03:35:52'),
(492, '5.2.02.05.01.0005', 'Belanja Modal Alat Kantor', 'Belanja Modal Alat Kantor Lainnya', NULL, '2025-09-08 03:35:52'),
(493, '5.2.02.05.02.0001', 'Belanja Modal Alat Rumah Tangga', 'Belanja Modal Mebel', NULL, '2025-09-08 03:35:52'),
(494, '5.2.02.05.02.0002', 'Belanja Modal Alat Rumah Tangga', 'Belanja Modal Alat Pengukur Waktu', NULL, '2025-09-08 03:35:52'),
(495, '5.2.02.05.02.0003', 'Belanja Modal Alat Rumah Tangga', 'Belanja Modal Alat Pembersih', NULL, '2025-09-08 03:35:52'),
(496, '5.2.02.05.02.0004', 'Belanja Modal Alat Rumah Tangga', 'Belanja Modal Alat Pendingin', NULL, '2025-09-08 03:35:52'),
(497, '5.2.02.05.02.0005', 'Belanja Modal Alat Rumah Tangga', 'Belanja Modal Alat Dapur', NULL, '2025-09-08 03:35:52'),
(498, '5.2.02.05.02.0006', 'Belanja Modal Alat Rumah Tangga', 'Belanja Modal Alat Rumah Tangga Lainnya (Home Use)', NULL, '2025-09-08 03:35:52'),
(499, '5.2.02.05.02.0007', 'Belanja Modal Alat Rumah Tangga', 'Belanja Modal Alat Pemadam Kebakaran', NULL, '2025-09-08 03:35:52'),
(500, '5.2.02.06.01.0001', 'Belanja Modal Alat Studio', 'Belanja Modal Peralatan Studio Audio', NULL, '2025-09-08 03:35:52'),
(501, '5.2.02.06.01.0002', 'Belanja Modal Alat Studio', 'Belanja Modal Peralatan Studio Video dan Film', NULL, '2025-09-08 03:35:52'),
(502, '5.2.02.06.01.0003', 'Belanja Modal Alat Studio', 'Belanja Modal Peralatan Studio Gambar', NULL, '2025-09-08 03:35:52'),
(503, '5.2.02.06.01.0004', 'Belanja Modal Alat Studio', 'Belanja Modal Peralatan Cetak', NULL, '2025-09-08 03:35:52'),
(504, '5.2.02.06.02.0001', 'Belanja Modal Alat Komunikasi', 'Belanja Modal Alat Komunikasi Telephone', NULL, '2025-09-08 03:35:52'),
(505, '5.2.02.06.02.0002', 'Belanja Modal Alat Komunikasi', 'Belanja Modal Alat Komunikasi Radio SSB', NULL, '2025-09-08 03:35:52'),
(506, '5.2.02.06.02.0003', 'Belanja Modal Alat Komunikasi', 'Belanja Modal Alat Komunikasi Radio HF/FM', NULL, '2025-09-08 03:35:52'),
(507, '5.2.02.06.03.0003', 'Belanja Modal Peralatan Pemancar', 'Belanja Modal Peralatan Pemancar VHF/FM', NULL, '2025-09-08 03:35:52'),
(508, '5.2.02.06.03.0008', 'Belanja Modal Peralatan Pemancar', 'Belanja Modal Peralatan Antena VHF/FM', NULL, '2025-09-08 03:35:52'),
(509, '5.2.02.06.03.0010', 'Belanja Modal Peralatan Pemancar', 'Belanja Modal Peralatan Antena SHF/Parabola', NULL, '2025-09-08 03:35:52'),
(510, '5.2.02.06.03.0019', 'Belanja Modal Peralatan Pemancar', 'Belanja Modal Switcher Antena', NULL, '2025-09-08 03:35:52'),
(511, '5.2.02.08.01.0006', 'Belanja Modal Unit Alat Laboratorium', 'Belanja Modal Alat Laboratorium Bahan Bangunan Konstruksi', NULL, '2025-09-08 03:35:52'),
(512, '5.2.02.08.01.0011', 'Belanja Modal Unit Alat Laboratorium', 'Belanja Modal Alat Laboratorium Umum', NULL, '2025-09-08 03:35:52'),
(513, '5.2.02.08.01.0012', 'Belanja Modal Unit Alat Laboratorium', 'Belanja Modal Alat Laboratorium Mikrobiologi', NULL, '2025-09-08 03:35:52'),
(514, '5.2.02.08.01.0013', 'Belanja Modal Unit Alat Laboratorium', 'Belanja Modal Alat Laboratorium Kimia', NULL, '2025-09-08 03:35:52'),
(515, '5.2.02.08.01.0020', 'Belanja Modal Unit Alat Laboratorium', 'Belanja Modal Alat Laboratorium Fisika', NULL, '2025-09-08 03:35:52'),
(516, '5.2.02.08.01.0041', 'Belanja Modal Unit Alat Laboratorium', 'Belanja Modal Alat Laboratorium Pertanian', NULL, '2025-09-08 03:35:52'),
(517, '5.2.02.08.01.0042', 'Belanja Modal Unit Alat Laboratorium', 'Belanja Modal Alat Laboratorium Elektronika dan Daya', NULL, '2025-09-08 03:35:52'),
(518, '5.2.02.08.01.0048', 'Belanja Modal Unit Alat Laboratorium', 'Belanja Modal Alat Laboratorium Biologi', NULL, '2025-09-08 03:35:52'),
(519, '5.2.02.08.03.0001', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Alat Peraga Praktek Sekolah Bidang Studi:Bahasa Indonesia', NULL, '2025-09-08 03:35:52'),
(520, '5.2.02.08.03.0002', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:Matematika', NULL, '2025-09-08 03:35:52'),
(521, '5.2.02.08.03.0003', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:IPA Dasar', NULL, '2025-09-08 03:35:52'),
(522, '5.2.02.08.03.0004', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:IPA Lanjutan', NULL, '2025-09-08 03:35:52'),
(523, '5.2.02.08.03.0005', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:IPA Menengah', NULL, '2025-09-08 03:35:52'),
(524, '5.2.02.08.03.0006', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:IPA Atas', NULL, '2025-09-08 03:35:52'),
(525, '5.2.02.08.03.0007', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:IPS', NULL, '2025-09-08 03:35:52'),
(526, '5.2.02.08.03.0008', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Alat Peraga Praktek Sekolah Bidang Studi:Agama', NULL, '2025-09-08 03:35:52'),
(527, '5.2.02.08.03.0009', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:Keterampilan', NULL, '2025-09-08 03:35:52'),
(528, '5.2.02.08.03.0010', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:Kesenian', NULL, '2025-09-08 03:35:52'),
(529, '5.2.02.08.03.0011', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:Olahraga', NULL, '2025-09-08 03:35:52'),
(530, '5.2.02.08.03.0012', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktek Sekolah Bidang Studi:PKN', NULL, '2025-09-08 03:35:52'),
(531, '5.2.02.08.03.0013', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Luar Biasa (Tuna Netra', NULL, '2025-09-08 03:35:52'),
(532, '5.2.02.08.03.0014', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Kejuruan', NULL, '2025-09-08 03:35:52'),
(533, '5.2.02.08.03.0015', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga PAUD/TK', NULL, '2025-09-08 03:35:52'),
(534, '5.2.02.08.03.0016', 'Belanja Modal Alat Peraga Praktek Sekolah', 'Belanja Modal Alat Peraga Praktik Sekolah Lainnya', NULL, '2025-09-08 03:35:52'),
(535, '5.2.02.10.01.0001', 'Belanja Modal Komputer Unit', 'Belanja Modal Komputer Jaringan', NULL, '2025-09-08 03:35:52'),
(536, '5.2.02.10.01.0002', 'Belanja Modal Komputer Unit', 'Belanja Modal Personal Computer', NULL, '2025-09-08 03:35:52'),
(537, '5.2.02.10.02.0001', 'Belanja Modal Peralatan Komputer', 'Belanja Modal Peralatan Mainframe', NULL, '2025-09-08 03:35:52'),
(538, '5.2.02.10.02.0002', 'Belanja Modal Peralatan Komputer', 'Belanja Modal Peralatan Mini Computer', NULL, '2025-09-08 03:35:52'),
(539, '5.2.02.10.02.0003', 'Belanja Modal Peralatan Komputer', 'Belanja Modal Peralatan Personal Computer', NULL, '2025-09-08 03:35:52'),
(540, '5.2.02.10.02.0004', 'Belanja Modal Peralatan Komputer', 'Belanja Modal Peralatan Jaringan', NULL, '2025-09-08 03:35:52'),
(541, '5.2.02.10.02.0005', 'Belanja Modal Peralatan Komputer', 'Belanja Modal Peralatan Komputer Lainnya', NULL, '2025-09-08 03:35:52'),
(542, '5.2.02.16.01.0001', 'Belanja Modal Alat Peraga Pelatihan dan Percontohan', 'Belanja Modal Alat Peraga Pelatihan', NULL, '2025-09-08 03:35:52'),
(543, '5.2.02.16.01.0002', 'Belanja Modal Alat Peraga Pelatihan dan Percontohan', 'Belanja Modal Alat Peraga Percontohan', NULL, '2025-09-08 03:35:52'),
(544, '5.2.02.18.01.0001', 'Belanja Modal Rambu-Rambu Lalu Lintas Darat', 'Belanja Modal Rambu Bersuar', NULL, '2025-09-08 03:35:52'),
(545, '5.2.02.18.01.0002', 'Belanja Modal Rambu-Rambu Lalu Lintas Darat', 'Belanja Modal Rambu Tidak Bersuar', NULL, '2025-09-08 03:35:52'),
(546, '5.2.02.19.01.0001', 'Belanja Modal Peralatan Olahraga', 'Belanja Modal Peralatan Olahraga Atletik', NULL, '2025-09-08 03:35:52'),
(547, '5.2.02.19.01.0002', 'Belanja Modal Peralatan Olahraga', 'Belanja Modal Peralatan Permainan', NULL, '2025-09-08 03:35:52'),
(548, '5.2.02.19.01.0003', 'Belanja Modal Peralatan Olahraga', 'Belanja Modal Peralatan Senam', NULL, '2025-09-08 03:35:52'),
(549, '5.2.02.19.01.0004', 'Belanja Modal Peralatan Olahraga', 'Belanja Modal Peralatan Olahraga Air', NULL, '2025-09-08 03:35:52'),
(550, '5.2.02.19.01.0005', 'Belanja Modal Peralatan Olahraga', 'Belanja Modal Peralatan Olahraga Udara', NULL, '2025-09-08 03:35:52'),
(551, '5.2.04.02.06.0005', 'Belanja Modal Bangunan Air Bersih/Air Baku', 'Belanja Modal Bangunan Pelengkap Air Bersih/Air Baku', NULL, '2025-09-08 03:35:52'),
(552, '5.2.04.03.01.0005', 'Belanja Modal Instalasi Air Bersih/Air Baku', 'Belanja Modal Instalasi Air Bersih/Air Baku Lainnya', NULL, '2025-09-08 03:35:52'),
(553, '5.2.04.03.05.0002', 'Belanja Modal Instalasi Pembangkit Listrik', 'Belanja Modal Instalasi Pembangkit Listrik Tenaga Diesel (PLTD)', NULL, '2025-09-08 03:35:52'),
(554, '5.2.04.04.02.0002', 'Belanja Modal Jaringan Listrik', 'Belanja Modal Jaringan Distribusi', NULL, '2025-09-08 03:35:52'),
(555, '5.2.04.04.02.0003', 'Belanja Modal Jaringan Listrik', 'Belanja Modal Jaringan Listrik Lainnya', NULL, '2025-09-08 03:35:52'),
(556, '5.2.04.04.03.0005', 'Belanja Modal Jaringan Telepon', 'Belanja Modal Jaringan Telepon Lainnya', NULL, '2025-09-08 03:35:52'),
(557, '5.2.05.01.01.0001', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Umum', NULL, '2025-09-08 03:35:52'),
(558, '5.2.05.01.01.0002', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Filsafat', NULL, '2025-09-08 03:35:52'),
(559, '5.2.05.01.01.0003', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Agama', NULL, '2025-09-08 03:35:52'),
(560, '5.2.05.01.01.0004', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Ilmu Sosial', NULL, '2025-09-08 03:35:52'),
(561, '5.2.05.01.01.0005', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Ilmu Bahasa', NULL, '2025-09-08 03:35:52'),
(562, '5.2.05.01.01.0006', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Matematika dan Pengetahuan Alam', NULL, '2025-09-08 03:35:52'),
(563, '5.2.05.01.01.0007', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Ilmu Pengetahuan Praktis', NULL, '2025-09-08 03:35:52'),
(564, '5.2.05.01.01.0008', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Arsitektur', NULL, '2025-09-08 03:35:52'),
(565, '5.2.05.01.01.0009', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Buku Geografi', NULL, '2025-09-08 03:35:52'),
(566, '5.2.05.01.01.0010', 'Belanja Modal Bahan Perpustakaan Tercetak', 'Belanja Modal Serial', NULL, '2025-09-08 03:35:52'),
(567, '5.2.05.01.02.0001', 'Belanja Modal Bahan Perpustakaan Terekam dan Bentuk Mikro', 'Belanja Modal Audio Visual', NULL, '2025-09-08 03:35:52'),
(568, '5.2.05.01.02.0002', 'Belanja Modal Bahan Perpustakaan Terekam dan Bentuk Mikro', 'Belanja Modal Bentuk Mikro (Microform)', NULL, '2025-09-08 03:35:52'),
(569, '5.2.05.01.03.0001', 'Belanja Modal Kartografi', 'Naskah', NULL, '2025-09-08 03:35:52'),
(570, '5.2.05.01.03.0002', 'Belanja Modal Kartografi', 'Naskah', NULL, '2025-09-08 03:35:52'),
(571, '5.2.05.01.03.0003', 'Belanja Modal Kartografi', 'Naskah', NULL, '2025-09-08 03:35:52'),
(572, '5.2.05.01.04.0001', 'Belanja Modal Musik', 'Belanja Modal Karya Musik', NULL, '2025-09-08 03:35:52'),
(573, '5.2.05.02.01.0001', 'Belanja Modal Barang Bercorak Kesenian', 'Belanja Modal Alat Musik', NULL, '2025-09-08 03:35:52'),
(574, '5.2.05.02.01.0002', 'Belanja Modal Barang Bercorak Kesenian', 'Belanja Modal Lukisan', NULL, '2025-09-08 03:35:52'),
(575, '5.2.05.02.01.0003', 'Belanja Modal Barang Bercorak Kesenian', 'Belanja Modal Alat Peraga Kesenian', NULL, '2025-09-08 03:35:52'),
(576, '5.2.05.02.02.0001', 'Belanja Modal Alat Bercorak Kebudayaan', 'Belanja Modal Pahatan', NULL, '2025-09-08 03:35:52'),
(577, '5.2.05.02.02.0002', 'Belanja Modal Alat Bercorak Kebudayaan', 'Belanja Modal Maket', NULL, '2025-09-08 03:35:52'),
(578, '5.2.05.02.02.0003', 'Belanja Modal Alat Bercorak Kebudayaan', 'Belanja Modal Barang Kerajinan', NULL, '2025-09-08 03:35:52'),
(579, '5.2.05.08.01.0005', 'Belanja Modal Aset Tidak Berwujud', 'Belanja Modal Software', NULL, '2025-09-08 03:35:52'),
(580, '1', 'Modal kejuruan', 'Belanja Modal Mesin Bubut', NULL, '2025-11-03 07:23:27');

-- --------------------------------------------------------

--
-- Table structure for table `rencana`
--

CREATE TABLE `rencana` (
  `id` int NOT NULL,
  `rekening_id` int NOT NULL,
  `kegiatan_id` int NOT NULL,
  `nama_rencana` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `nama_rencana_kegiatan` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `jumlah_rencana` int NOT NULL,
  `jumlah_kegiatan` int NOT NULL,
  `satuan` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `harga_satuan` int NOT NULL,
  `total_biaya` int DEFAULT '0',
  `bulan` enum('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember') COLLATE utf8mb4_general_ci NOT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_access`
--

CREATE TABLE `role_access` (
  `role` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `menu_key` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `allowed` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_access`
--

INSERT INTO `role_access` (`role`, `menu_key`, `allowed`) VALUES
('superadmin', 'hasil_penganggaran', 1),
('superadmin', 'kegiatan', 1),
('superadmin', 'penganggaran', 1),
('superadmin', 'register', 1),
('superadmin', 'rekening', 1),
('superadmin', 'reset_password', 1),
('superadmin', 'user_list', 1),
('user', 'admin_access', 0),
('user', 'analisa', 1),
('user', 'hasil_penganggaran', 0),
('user', 'home', 1),
('user', 'kegiatan', 1),
('user', 'kegiatan_list', 0),
('user', 'penganggaran', 1),
('user', 'perencanaan', 1),
('user', 'register', 1),
('user', 'rekening', 0),
('user', 'rekening_list', 0),
('user', 'reset_password', 0),
('user', 'rkas', 0),
('user', 'user_list', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('superadmin','user') COLLATE utf8mb4_general_ci DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `can_edit` tinyint(1) DEFAULT '1',
  `can_edit_rencana` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `can_edit`, `can_edit_rencana`) VALUES
(1, 'admin', '$2y$10$J0iDNIZJoHQC/ZD2dWdSQesakT38JjcMNv/wy8RlsF8DUj48rl3j.', 'superadmin', '2025-07-03 21:31:54', 1, 0),
(3, 'kapro', '$2y$10$uWBZSVe2AkIIY06zMTXOA.T1Xq6L2/9nZOeLijYy5Bxgb4i6rEPqC', 'user', '2025-07-04 07:08:57', 1, 0),
(14, 'user', '$2y$10$50ll0UeApNr9BuN6LMkKZObPCJFQnEwQEgtvjHwmCWakbZhJNZvVi', 'user', '2025-09-08 07:20:54', 1, 0),
(15, 'waka', '$2y$10$tz2uIriz/FYrkz52XowbaeRAUk1lYlVvhOUOVl8JYkPKFX285BD0C', 'user', '2025-11-03 07:18:05', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `menu_key` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `allowed` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`id`, `user_id`, `menu_key`, `allowed`) VALUES
(1, 3, 'user_list', 0),
(2, 3, 'register', 0),
(3, 3, 'reset_password', 0),
(4, 3, 'kegiatan', 0),
(5, 3, 'rekening', 0),
(6, 3, 'penganggaran', 0),
(7, 3, 'hasil_penganggaran', 1),
(8, 3, 'user_list', 0),
(9, 3, 'register', 0),
(10, 3, 'reset_password', 0),
(11, 3, 'kegiatan', 1),
(12, 3, 'rekening', 0),
(13, 3, 'penganggaran', 0),
(14, 3, 'hasil_penganggaran', 1),
(15, 3, 'user_list', 0),
(16, 3, 'register', 0),
(17, 3, 'reset_password', 0),
(18, 3, 'kegiatan', 1),
(19, 3, 'rekening', 0),
(20, 3, 'penganggaran', 0),
(21, 3, 'hasil_penganggaran', 1),
(22, 3, 'user_list', 0),
(23, 3, 'register', 0),
(24, 3, 'reset_password', 0),
(25, 3, 'kegiatan', 1),
(26, 3, 'rekening', 0),
(27, 3, 'penganggaran', 0),
(28, 3, 'hasil_penganggaran', 1),
(29, 3, 'user_list', 0),
(30, 3, 'register', 0),
(31, 3, 'reset_password', 0),
(32, 3, 'kegiatan', 0),
(33, 3, 'rekening', 0),
(34, 3, 'penganggaran', 1),
(35, 3, 'hasil_penganggaran', 0),
(36, 3, 'user_list', 0),
(37, 3, 'register', 0),
(38, 3, 'reset_password', 0),
(39, 3, 'kegiatan', 0),
(40, 3, 'rekening', 0),
(41, 3, 'penganggaran', 1),
(42, 3, 'hasil_penganggaran', 0),
(43, 3, 'user_list', 0),
(44, 3, 'register', 0),
(45, 3, 'reset_password', 0),
(46, 3, 'kegiatan', 0),
(47, 3, 'rekening', 0),
(48, 3, 'penganggaran', 1),
(49, 3, 'hasil_penganggaran', 0),
(50, 1, 'user_list', 1),
(51, 1, 'register', 1),
(52, 1, 'reset_password', 1),
(53, 1, 'kegiatan', 1),
(54, 1, 'rekening', 1),
(55, 1, 'penganggaran', 1),
(56, 1, 'hasil_penganggaran', 1),
(57, 3, 'user_list', 0),
(58, 3, 'register', 0),
(59, 3, 'reset_password', 0),
(60, 3, 'kegiatan', 0),
(61, 3, 'rekening', 0),
(62, 3, 'penganggaran', 1),
(63, 3, 'hasil_penganggaran', 1),
(64, 3, 'user_list', 0),
(65, 3, 'register', 0),
(66, 3, 'reset_password', 0),
(67, 3, 'kegiatan', 0),
(68, 3, 'rekening', 0),
(69, 3, 'penganggaran', 0),
(70, 3, 'hasil_penganggaran', 1),
(78, 3, 'user_list', 0),
(79, 3, 'register', 0),
(80, 3, 'reset_password', 0),
(81, 3, 'kegiatan', 0),
(82, 3, 'rekening', 0),
(83, 3, 'penganggaran', 1),
(84, 3, 'hasil_penganggaran', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menu_key` (`menu_key`);

--
-- Indexes for table `rekening`
--
ALTER TABLE `rekening`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `rencana`
--
ALTER TABLE `rencana`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rekening_id` (`rekening_id`),
  ADD KEY `kegiatan_id` (`kegiatan_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `role_access`
--
ALTER TABLE `role_access`
  ADD PRIMARY KEY (`role`,`menu_key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggaran`
--
ALTER TABLE `anggaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekening`
--
ALTER TABLE `rekening`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=581;

--
-- AUTO_INCREMENT for table `rencana`
--
ALTER TABLE `rencana`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggaran`
--
ALTER TABLE `anggaran`
  ADD CONSTRAINT `anggaran_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `rekening`
--
ALTER TABLE `rekening`
  ADD CONSTRAINT `rekening_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `rencana`
--
ALTER TABLE `rencana`
  ADD CONSTRAINT `rencana_ibfk_1` FOREIGN KEY (`rekening_id`) REFERENCES `rekening` (`id`),
  ADD CONSTRAINT `rencana_ibfk_2` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id`),
  ADD CONSTRAINT `rencana_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_access`
--
ALTER TABLE `user_access`
  ADD CONSTRAINT `user_access_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
