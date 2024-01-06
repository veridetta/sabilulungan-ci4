-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:1235
-- Generation Time: Jan 06, 2024 at 09:16 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_sabilulungan`
--

-- --------------------------------------------------------

--
-- Table structure for table `checklist`
--

CREATE TABLE `checklist` (
  `id` int UNSIGNED NOT NULL,
  `role_id` tinyint UNSIGNED NOT NULL,
  `sequence` int UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `type` enum('checkbox','radio','text') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `checklist`
--

INSERT INTO `checklist` (`id`, `role_id`, `sequence`, `name`, `type`) VALUES
(1, 5, 1, 'Proposal Hibah Bansos', 'checkbox'),
(2, 5, 2, 'Surat Keterangan Tanggung Jawab', 'checkbox'),
(3, 5, 3, 'Surat Keterangan Kesediaan Menyediakan Dana Pendamping', 'checkbox'),
(4, 5, 4, 'Gambar Rencana dan Konstruksi Bangunan', 'checkbox'),
(5, 5, 5, '1. Akta Notaris Pendirian Lembaga', 'checkbox'),
(6, 5, 6, '2. Surat Pernyataan Tanggung Jawab', 'checkbox'),
(7, 5, 7, '3. Nomor Pokok Wajib Pajak', 'checkbox'),
(8, 5, 8, '4. Surat Keterangan Domisili Lembaga dari Desa / Kelurahan Setempat', 'checkbox'),
(9, 5, 9, '5. Izin Operasional Tanda Daftar Lembaga dari Instansi yang Berwenang', 'checkbox'),
(10, 5, 10, '6. Bukti Kontrak Sesuai Gedung/Bangunan Bagi Lembaga yang Kantornya Menyewa', 'checkbox'),
(11, 5, 11, '7. Salinan Fotocopy KTP Atas Nama Ketua dan Sekretaris', 'checkbox'),
(12, 5, 12, '8. Salinan Rekening Bank yang Masih Aktif Atas Nama Lembaga dan/atau Pengurus Belanja Hibah', 'checkbox'),
(13, 5, 13, 'Keterangan', 'text'),
(14, 1, 1, 'Keterangan', 'text'),
(15, 3, 1, 'Ya', 'radio'),
(16, 3, 2, 'Tidak', 'radio'),
(17, 3, 3, 'Besar Rekomendasi Dana', 'text'),
(18, 3, 4, '1. Kesesuaian Harga Dalam Proposal dengan Standar Satuan Kerja', 'checkbox'),
(19, 3, 5, '2. Kesesuaian Kebutuhan Peralatan dan Bahan dalam Kegiatan', 'checkbox'),
(20, 3, 6, '3. Organisasi Tidak Fiktif', 'checkbox'),
(21, 3, 7, '4. Alamat Organisasi/Ketua Sesuai dengan Proposal', 'checkbox'),
(22, 3, 8, '5. Belum Pernah Menerima Satu Tahun Sebelumnya', 'checkbox'),
(23, 3, 9, '6. Verifikasi KTP', 'checkbox'),
(24, 3, 10, '7. Verifikasi Organisasi Berbadan Hukum', 'checkbox'),
(25, 3, 11, 'Keterangan', 'text'),
(26, 4, 1, 'Koreksi (Angka)', 'text'),
(27, 4, 2, 'Keterangan', 'text'),
(28, 2, 1, 'Nominal yang Direkomendasikan TAPD', 'text'),
(29, 2, 2, 'Keterangan', 'text'),
(30, 1, 2, 'Keterangan', 'text'),
(31, 4, 1, 'Kategori Hibah Bansos', 'radio');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `page_id` varchar(25) NOT NULL,
  `sequence` int UNSIGNED NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `content` text NOT NULL,
  `type` enum('1','2','3') NOT NULL COMMENT '1:image, 2:text, 3:file'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`page_id`, `sequence`, `title`, `content`, `type`) VALUES
('home', 1, NULL, '6b2dca096e66bf4a8b2136c1ab8e73a4.jpg', '1'),
('home', 2, NULL, 'ad1af5d7a2961274e5b8d429b76dcca3.jpg', '1'),
('peraturan', 1, 'SOP Bendaharan Hibah dan Bantuan Sosial (Repaired)', '01.02 SOP_Bendaharan Hibah dan Bantuan Sosial (Repaired).pdf', '3'),
('peraturan', 2, 'SK PPK-PPKD 2016', 'e160fd3cb66cd95f6a36afe6ece53f0a.doc', '3'),
('peraturan', 3, 'PERMENDAGRI 32 TAHUN 2011', '1d68bd38635b51f1c738e6f88b5e5bf5.pdf', '3'),
('peraturan', 4, 'PERMENDAGRI 39 TAHUN 2012 PERUBAHAN ATAS PERATURAN MENTERI DALAM NEGERI NOMOR 32 TAHUN 2011 TENTANG PEDOMAN PEMBERIAN HIBAH DAN BANTUAN SOSIAL YANG BERSUMBER DARI ANGGARAN PENDAPATAN DAN BELANJA DAERAH', '5a3191e98ca3da46b4e36491ea7e6c86.pdf', '3'),
('peraturan', 5, 'PERWAL NO 891 TAHUN 2011 TENTANG HIBAH BANSOS', 'c2dfcba5ab0fa9417b9b1f569931af7e.pdf', '3'),
('peraturan', 6, 'PERWAL NO 836 THN 2012 PERUBAHAN I PERWAL 891-2011 HIBAH BANSOS', '5b396c4c46b2ac1516042f9df33fcdd5.pdf', '3'),
('peraturan', 7, 'PERWAL NO 777 THN 2013 PERUBAHAN II PERWAL 891-2011 HIBAH BANSOS', 'dd67e7bac65d24c9833b07ac980c3a9e.pdf', '3'),
('peraturan', 8, 'PERWAL NO. 825 THN 2013 PERUBAHAN III PERWAL 891-2011 HIBAH BANSOS-evdok', '50e1acf5536ff8d403d07bd796817c77.pdf', '3'),
('peraturan', 9, 'PERWAL NO. 825 THN 2013 PERUBAHAN III PERWAL 891-2011 HIBAH BANSOS LAMPIRAN', '6f6da3e750f3985cac1e715a4399bc42.pdf', '3'),
('peraturan', 10, 'PERWAL NO 1205 THN 2013 PERUBAHAN IV PERWAL 891-2011 HIBAH BANSOS', '5d6c162aeff5302cedf1ef43037c42a5.pdf', '3'),
('peraturan', 11, 'PERWAL NO. 309 THN 2014 PERUBAHAN V PERWAL 891-2011 HIBAH BANSOS', '22bc1773be445df6fabd5584d5415694.pdf', '3'),
('peraturan', 12, 'PERWAL NO. 691 THN 2014 PERUBAHAN V PERWAL 891-2011 HIBAH BANSOS', '7d83fc75dd4399e68bf4b2245367566b.pdf', '3'),
('peraturan', 13, 'Hibah Bansos Online', '766d8fd943c05b384e6718396589c3c0.docx', '3'),
('peraturan', 14, 'Peraturan Walikota Nomor 816 Tahun 2015', '790a40427091ac801345fd09747387c8.pdf', '3'),
('peraturan', 15, 'SURAT EDARAN LPJ 2015', '7d50d38defe05ad8ba5272788a11fa6c.docx', '3'),
('peraturan', 16, 'Surat Edaran Menteri Dalam Negeri Nomor 9004627SJ Tentang Penajaman Ketentuan Pasal 298 Ayat (5) Undang-Undang Nomor 23 Tahun 2014 Tentang Pemerintahan Daerah', '8597f9c4903623f66c0e90de1d74bf90.pdf', '3'),
('peraturan', 17, 'Surat Permberitahuan Pemohon', '06e124370babc1f2a3e09d267a50c9c5.docx', '3'),
('peraturan', 18, 'Surat Permberitahuan SKPD Terkait', '6225452be03b620f44f9712313c5ee06.docx', '3'),
('tentang', 1, NULL, '<p>Sabilulungan, atau yang memiliki arti ‘Gotong Royong’ digagas oleh Pemerintah Kota Bandung untuk memfasilitasi keterbukaan dalam perwujudan program bansos dan hibah melalui media online.</p>\r\n<p>Program Sabilulungan bertujuan agar jalannya dana bantuan yang diturunkan Pemerintah Kota Bandung untuk membiayai berbagai proyek sosial yang diinginkan masyarakat dapat dipertanggungjawabkan secara terbuka. Seluruh proses dalam Sabilulungan dapat terlihat dan diawasi oleh seluruh lapisan masyarakat</p>\r\n<p>Melalui Sabilulungan, seluruh masyarakat dan organisasi di kota Bandung dapat:</p>\r\n<ol><li><p>Mengirimkan proposal terkait hibah bansos dan memonitor bagaimana status proposal tersebut (apakah diterima, ditolak, sedang diverifikasi, dan sebagainya); serta</p>\r\n</li>\r\n<li><p>Ikut berpartisipasi dalam memonitor jalannya hibah bansos yang sudah disetujui oleh Pemerintah Kota Bandung sehingga dapat turut memberikan masukan dan saran terkait jalannya hibah bansos tersebut.</p>\r\n</li>\r\n</ol>\r\n<p>Ayo ajukan ide kreatif kalian tanpa rasa takut akan penyelewengan dana yang diturunkan. Kita semua bersama dapat menjadi yang ahli dalam pembangunan Kota Bandung, Karena berani transparansi itu JUARA!</p>\r\n<h2>APA YANG SABILULUNGAN WUJUDKAN</h2>\r\n<p>BANSOS atau Bantuan Sosial, yaitu program bantuan dana diberikan secara selektif oleh pemerintah untuk ide-ide kreatif yang diusulkan oleh seluruh masyarakat Kota Bandung khususnya, secara perseorangan atau kelompok. Bantuan Sosial, bersifat sementara, tidak terus-menerus, tidak mengikat dan tidak wajib.</p>\r\n<p>HIBAH, yaitu program bantuan dana berkelanjutan dan terikat yang diberikan oleh pemerintah untuk setiap pengajuan proyek kreatif dari Lembaga Sosial Masyarakat (Non-Government Organitation atau NGO).</p>\r\n<h2>TAHAPAN SABILULUNGAN</h2>\r\n<p>Setiap masyarakat atau organisasi di kota Bandung yang ingin mengajukan proposal hibah bansos melalui Sabilulungan cukup mendaftarkan melalui aplikasi dan mengirimkan kelengkapan dokumen secara langsung, setelah itu Pemerintah Kota Bandung akan memverifikasi. Tahapan verifikasi selengkapnya sebagai berikut:</p>\r\n<ol><li><p>Masyarakat mendaftarkan proposal hibah bansos secara online melalui aplikasi Sabilulungan</p>\r\n</li>\r\n<li><p>Masyarakat menyerahkan kelengkapan dokumen secara langsung kepada Pemerintah Kota Bandung</p>\r\n</li>\r\n<li><p>TU Pimpinan akan memverifikasi kelengkapan proposal dan dokumen pendukung proposal tersebut</p>\r\n</li>\r\n<li><p>Walikota/wakil walikota akan memverifikasi proposal tersebut</p>\r\n</li>\r\n<li><p>Tim pertimbangan akan memverifikasi proposal dan mendisposisi proposal kepada SKPD (Satuan Kerja Perangkat Daerah) terkait</p>\r\n</li>\r\n<li><p>SKPD terkait akan memeriksa proposal tersebut dan memberikan rekomendasi besaran dana yang diusulkan untuk diberikan</p>\r\n</li>\r\n<li><p>Tim pertimbangan akan memeriksa usulan dana dari SKPD dan juga memberikan rekomendasi besaran dana yang diusulkan untuk diberikan</p>\r\n</li>\r\n<li><p>TAPD (Tim Anggaran Pemerintah Daerah) akan memeriksa usulan dana dari SKPD dan tim pertimbangan untuk kemudian memberikan rekomendasi final dana yang akan diberikan. Selanjutnya, seluruh proposal yang diberikan rekomendasi dana akan dikumpulkan dalam dokumen Daftar Nominatif Calon Penerima Belanja Hibah (DNC PBH)</p>\r\n</li>\r\n<li><p>Walikota/wakil walikota akan memeriksa DNC PBH. Apabila disetujui maka proposal-proposal yang termasuk dalam DNC PBH tersebut siap berjalan</p>\r\n</li>\r\n</ol>\r\n', '2'),
('tentang', 2, NULL, '1ed40192f33a9a88fc2d166b11b079f6.jpg', '1'),
('tentang', 3, NULL, '32596594590ef13591cc4c4a403dd69b.jpg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `flow`
--

CREATE TABLE `flow` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `role_id` tinyint UNSIGNED NOT NULL,
  `sequence` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `flow`
--

INSERT INTO `flow` (`id`, `name`, `role_id`, `sequence`) VALUES
(1, 'Pemeriksaan Kelengkapan oleh Bagian TU', 5, 1),
(2, 'Pemeriksaan oleh Bupati', 1, 2),
(3, 'Klasifikasi sesuai SKPD oleh Tim Pertimbangan', 4, 3),
(4, 'Rekomendasi Dana oleh SKPD', 3, 4),
(5, 'Verifikasi Proposal oleh Tim Pertimbangan', 4, 5),
(6, 'Verifikasi Proposal oleh TAPD', 2, 6),
(7, 'Proyek Berjalan', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `laporan_id` int UNSIGNED NOT NULL,
  `tahun` int UNSIGNED NOT NULL,
  `anggaran` decimal(18,2) NOT NULL,
  `realisasi_rp` decimal(18,2) NOT NULL,
  `realisasi_persen` float NOT NULL,
  `penerima_cair` int UNSIGNED NOT NULL,
  `penerima_lapor` int UNSIGNED NOT NULL,
  `nilai_lapor` decimal(18,2) NOT NULL,
  `file` varchar(64) NOT NULL,
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `laporan`
--

INSERT INTO `laporan` (`laporan_id`, `tahun`, `anggaran`, `realisasi_rp`, `realisasi_persen`, `penerima_cair`, `penerima_lapor`, `nilai_lapor`, `file`, `time_entry`) VALUES
(6, 2023, '20000.00', '19000.00', 10, 1, 2, '10000.00', '1701011077_e6327dd87b8034871df1.pdf', '2023-11-22 03:56:59');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `log_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `activity` varchar(25) NOT NULL,
  `id` varchar(25) DEFAULT NULL,
  `ip` varchar(25) NOT NULL,
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`log_id`, `user_id`, `activity`, `id`, `ip`, `time_entry`) VALUES
(1, 1, 'login', NULL, '::1', '2017-09-13 04:24:31'),
(2, 1, 'logout', NULL, '::1', '2017-09-13 04:24:51'),
(3, 1, 'login', NULL, '::1', '2023-11-22 03:54:56'),
(4, 1, 'add_laporan', '6', '::1', '2023-11-22 03:56:59'),
(5, 1, 'add_pengumuman', '1', '::1', '2023-11-22 03:58:04'),
(6, 1, 'add_pengumuman', '2', '::1', '2023-11-22 03:58:23'),
(7, 1, 'add_koordinator', '32', '::1', '2023-11-22 03:59:24'),
(8, 32, 'login', NULL, '::1', '2023-11-22 03:59:40'),
(9, 1, 'add_umum', '33', '::1', '2023-11-22 04:15:43'),
(10, 32, 'logout', NULL, '::1', '2023-11-22 04:15:53'),
(11, 33, 'login', NULL, '::1', '2023-11-22 04:16:02'),
(12, 33, 'daftar_hibah', '1', '::1', '2023-11-22 04:16:45'),
(13, 1, 'tu_periksa', '1', '::1', '2023-11-22 04:21:45'),
(14, 1, 'walikota_periksa', '1', '::1', '2023-11-22 04:22:06'),
(15, 1, 'pertimbangan_periksa', '1', '::1', '2023-11-22 04:22:15'),
(16, 1, 'skpd_periksa', '1', '::1', '2023-11-22 04:22:42'),
(17, 1, 'pertimbangan_verifikasi', '1', '::1', '2023-11-22 04:23:31'),
(18, 1, 'tapd_verifikasi', '1', '::1', '2023-11-22 04:27:17'),
(19, 1, 'walikota_setuju', '1', '::1', '2023-11-22 04:27:35'),
(20, 1, 'edit_detail', '1', '::1', '2023-11-22 04:30:51'),
(21, 33, 'logout', NULL, '::1', '2023-11-22 04:34:39'),
(22, 32, 'login', NULL, '::1', '2023-11-22 04:34:54'),
(23, 1, 'login', NULL, '::1', '2023-11-26 08:41:31'),
(24, 1, 'edit_hibah', '1', '::1', '2023-11-26 11:17:03'),
(25, 1, 'tu_periksa_edit', '1', '::1', '2023-11-26 11:47:58'),
(26, 1, 'edit_koordinator', '32', '::1', '2023-11-26 14:52:07'),
(27, 1, 'edit_laporan', '6', '::1', '2023-11-26 15:04:37'),
(28, 1, 'logout', NULL, '::1', '2023-11-26 15:08:27'),
(29, 34, 'register', '34', '::1', '2023-11-26 15:25:42'),
(30, 34, 'login', NULL, '::1', '2023-11-26 15:26:06'),
(31, 34, 'daftar_hibah', '3', '::1', '2023-11-26 15:34:51'),
(32, 34, 'daftar_hibah', '8', '::1', '2023-11-26 15:58:32'),
(33, 34, 'daftar_hibah', '17', '::1', '2023-11-26 16:10:30'),
(34, 34, 'add_lpj', '17', '::1', '2023-11-26 16:20:49'),
(35, 34, 'logout', NULL, '::1', '2023-11-26 16:21:07'),
(36, 34, 'login', NULL, '::1', '2023-11-26 16:46:59'),
(37, 34, 'logout', NULL, '::1', '2023-11-26 16:47:08'),
(38, 1, 'login', NULL, '::1', '2023-11-26 17:12:28'),
(39, 1, 'tu_periksa', '17', '::1', '2023-11-26 17:14:06'),
(40, 1, 'walikota_periksa', '17', '::1', '2023-11-26 17:14:22'),
(41, 1, 'pertimbangan_periksa', '17', '::1', '2023-11-26 17:14:37'),
(42, 1, 'skpd_periksa', '17', '::1', '2023-11-26 17:15:05'),
(43, 1, 'pertimbangan_verifikasi', '17', '::1', '2023-11-26 17:15:32'),
(44, 1, 'report', '17', '::1', '2023-11-26 17:32:11'),
(45, 1, 'report', '17', '::1', '2023-11-26 17:33:22'),
(46, 1, 'report', '17', '::1', '2023-11-26 17:36:51'),
(47, 1, 'report', '17', '::1', '2023-11-26 17:44:37'),
(48, 1, 'report', '17', '::1', '2023-11-26 17:49:07'),
(49, 1, 'add_nphd', '17', '::1', '2023-11-26 18:14:37'),
(50, 1, 'add_lpj', '17', '::1', '2023-11-26 18:41:09'),
(51, 1, 'login', NULL, '::1', '2023-11-27 05:10:11'),
(52, 1, 'report', '17', '::1', '2023-11-27 05:10:17'),
(53, 1, 'add_koordinator', '35', '::1', '2023-11-27 05:28:15'),
(54, 1, 'logout', NULL, '::1', '2023-11-27 05:28:25'),
(55, 1, 'login', NULL, '::1', '2023-11-27 05:31:48'),
(56, 1, 'edit_koordinator', '35', '::1', '2023-11-27 05:32:29'),
(57, 1, 'logout', NULL, '::1', '2023-11-27 05:32:41'),
(58, 35, 'login', NULL, '::1', '2023-11-27 05:32:57'),
(59, 1, 'login', NULL, '::1', '2023-11-27 06:05:25'),
(60, 35, 'logout', NULL, '::1', '2023-11-27 07:16:46'),
(61, 36, 'register', '36', '::1', '2023-11-27 07:17:35'),
(62, 34, 'login', NULL, '::1', '2023-11-27 07:20:25'),
(63, 34, 'logout', NULL, '::1', '2023-11-27 07:20:35'),
(64, 1, 'edit_umum', '36', '::1', '2023-11-27 07:21:54'),
(65, 36, 'login', NULL, '::1', '2023-11-27 07:22:05'),
(66, 36, 'daftar_hibah', '18', '::1', '2023-11-27 07:45:49'),
(67, 1, 'tu_periksa', '18', '::1', '2023-11-27 07:58:06'),
(68, 1, 'add_koordinator', '37', '::1', '2023-11-27 08:08:33'),
(69, 1, 'add_koordinator', '38', '::1', '2023-11-27 08:08:56'),
(70, 36, 'logout', NULL, '::1', '2023-11-27 08:09:05'),
(71, 37, 'login', NULL, '::1', '2023-11-27 08:09:18'),
(72, 1, 'login', NULL, '::1', '2023-11-29 04:41:22'),
(73, 1, 'edit_koordinator', '38', '::1', '2023-11-29 04:41:39'),
(74, 1, 'logout', NULL, '::1', '2023-11-29 04:41:47'),
(75, 38, 'login', NULL, '::1', '2023-11-29 04:41:55'),
(76, 38, 'generate_dnc', NULL, '::1', '2023-11-29 04:44:47'),
(77, 1, 'login', NULL, '::1', '2023-11-29 06:15:27'),
(78, 1, 'logout', NULL, '::1', '2023-11-29 06:16:22'),
(79, 37, 'login', NULL, '::1', '2023-11-29 06:16:34'),
(80, 1, 'login', NULL, '::1', '2023-11-29 06:53:43'),
(81, 1, 'logout', NULL, '::1', '2023-11-29 06:53:53'),
(82, 38, 'login', NULL, '::1', '2023-11-29 06:54:06'),
(83, 38, 'tapd_verifikasi', '17', '::1', '2023-11-29 06:54:44'),
(84, 1, 'login', NULL, '::1', '2023-11-29 06:55:21'),
(85, 1, 'edit_koordinator', '32', '::1', '2023-11-29 06:58:49'),
(86, 1, 'logout', NULL, '::1', '2023-11-29 06:58:57'),
(87, 32, 'login', NULL, '::1', '2023-11-29 06:59:11'),
(88, 32, 'walikota_setuju', '17', '::1', '2023-11-29 07:05:54'),
(89, 1, 'login', NULL, '::1', '2023-11-29 08:59:20'),
(90, 38, 'generate_dnc', NULL, '::1', '2023-11-29 09:03:01'),
(91, 38, 'report', '38', '::1', '2023-11-29 11:43:37'),
(92, 1, 'login', NULL, '::1', '2023-12-02 05:27:13'),
(93, 37, 'login', NULL, '::1', '2023-12-09 04:12:12'),
(94, 37, 'login', NULL, '::1', '2023-12-11 06:34:59'),
(95, 37, 'daftar_hibah', '19', '::1', '2023-12-11 06:39:14'),
(96, 37, 'daftar_hibah', '28', '::1', '2023-12-11 07:51:20'),
(97, 37, 'logout', NULL, '::1', '2023-12-11 08:07:01'),
(98, 1, 'login', NULL, '::1', '2023-12-11 08:07:18'),
(99, 1, 'login', NULL, '::1', '2024-01-04 02:12:17'),
(100, 1, 'login', NULL, '::1', '2024-01-06 08:18:31'),
(101, 1, 'logout', NULL, '::1', '2024-01-06 08:20:13'),
(102, 40, 'register', '40', '::1', '2024-01-06 08:22:12'),
(103, 1, 'login', NULL, '::1', '2024-01-06 08:22:38'),
(104, 1, 'edit_umum', '40', '::1', '2024-01-06 08:23:01'),
(105, 1, 'logout', NULL, '::1', '2024-01-06 08:23:06'),
(106, 40, 'login', NULL, '::1', '2024-01-06 08:23:20'),
(107, 40, 'daftar_hibah', '29', '::1', '2024-01-06 08:30:21'),
(108, 40, 'logout', NULL, '::1', '2024-01-06 08:30:29'),
(109, 1, 'login', NULL, '::1', '2024-01-06 08:30:41'),
(110, 1, 'tu_periksa', '29', '::1', '2024-01-06 08:51:44'),
(111, 1, 'walikota_periksa', '29', '::1', '2024-01-06 09:09:03'),
(112, 1, 'pertimbangan_periksa', '29', '::1', '2024-01-06 09:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `organisasi`
--

CREATE TABLE `organisasi` (
  `id` int NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(16) NOT NULL,
  `legal` tinyint(1) NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `organisasi`
--

INSERT INTO `organisasi` (`id`, `name`, `address`, `phone`, `legal`, `user_id`) VALUES
(1, 'Kerumunan Jualan', 'Jalan Mekarsari', '08231232132', 1, 35);

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `pengumuman_id` int NOT NULL,
  `judul` varchar(250) NOT NULL,
  `konten` longtext NOT NULL,
  `fl_aktif` enum('0','1') NOT NULL DEFAULT '1',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `pengumuman`
--

INSERT INTO `pengumuman` (`pengumuman_id`, `judul`, `konten`, `fl_aktif`, `date_created`) VALUES
(1, 'Tes', '<i>pengumuman</i>', '1', '2023-11-22 03:58:04'),
(2, '2', 'pengumuman 2', '1', '2023-11-22 03:58:23');

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE `proposal` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `user` varchar(256) DEFAULT NULL,
  `name` varchar(256) NOT NULL,
  `judul` varchar(256) NOT NULL,
  `latar_belakang` text NOT NULL,
  `maksud_tujuan` text NOT NULL,
  `address` varchar(512) NOT NULL,
  `file` varchar(64) DEFAULT NULL,
  `nphd` varchar(64) DEFAULT NULL,
  `foto` varchar(64) DEFAULT NULL,
  `type_id` tinyint UNSIGNED DEFAULT NULL,
  `skpd_id` int UNSIGNED DEFAULT NULL,
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_lpj` date DEFAULT NULL,
  `current_stat` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal`
--

INSERT INTO `proposal` (`id`, `user_id`, `user`, `name`, `judul`, `latar_belakang`, `maksud_tujuan`, `address`, `file`, `nphd`, `foto`, `type_id`, `skpd_id`, `time_entry`, `tanggal_lpj`, `current_stat`) VALUES
(1, 33, NULL, 'User', 'Makan Bersama', 'Lata makan bersama', 'tujuan dan maskud', 'User alamat revisi', '05a6989aeeaae56cff6d30d18cfb2405.pdf', NULL, NULL, 1, 1, '2023-11-21 17:00:00', '2023-11-22', 7),
(17, 34, NULL, 'User Baru', 'jiji', 'ojoijoij', 'oijoij', 'fsafsdf', '1701015030_d749e0dfb87bbaaa5edf.pdf', '2023-2024-Tugas 1-PBM1.pdf', NULL, 1, 2, '2023-11-25 17:00:00', '2023-11-08', 7),
(18, 36, NULL, 'Buat Apa', 'Mengaji ', 'Mengaji Bersama', 'Tujuan dan maksud', 'ALamat', '1701071149_e618e1e24dd0d5ac0923.pdf', NULL, NULL, 1, NULL, '2023-11-26 17:00:00', NULL, 1),
(19, 37, NULL, 'Tes vatet', 'fsfsd', 'sfsffe', 'fewefewfew', 'fsfsfdfs', '1702276754_e06001b9d5b960188083.pdf', NULL, NULL, NULL, NULL, '2023-12-20 17:00:00', NULL, NULL),
(28, 37, NULL, 'fasjioj', 'fasdfsadfadsf', 'fasdfadsfs', 'fasdfdsf', 'oijoifjsefedasfds', '1702281080_be789f191a110d4ff0b2.pdf', NULL, NULL, NULL, NULL, '2023-12-20 17:00:00', NULL, NULL),
(29, 40, NULL, 'User 99', 'fasdfdsafdasfds fas', ' dfasdfdsf dsafdas fdsa fsdaf', ' safadsfdsa fsda fdsaf sdf sadfdsa fdsaf ', 'Jkljfjsadfsad', '1704529821_c1f06b42ead64289cb80.pdf', NULL, NULL, 1, 1, '2024-01-05 17:00:00', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `proposal_approval`
--

CREATE TABLE `proposal_approval` (
  `proposal_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `flow_id` int UNSIGNED DEFAULT NULL,
  `action` enum('1','2') NOT NULL COMMENT '1=Approve, 2=Reject',
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal_approval`
--

INSERT INTO `proposal_approval` (`proposal_id`, `user_id`, `flow_id`, `action`, `time_entry`) VALUES
(1, 1, 1, '1', '2023-11-21 17:00:00'),
(1, 1, 2, '1', '2023-11-21 17:00:00'),
(1, 1, 3, '1', '2023-11-21 17:00:00'),
(1, 1, 4, '1', '2023-11-21 17:00:00'),
(1, 1, 5, '1', '2023-11-21 17:00:00'),
(1, 1, 6, '1', '2023-11-21 17:00:00'),
(1, 1, 7, '1', '2023-11-21 17:00:00'),
(17, 1, 1, '1', '2023-11-26 17:14:06'),
(17, 1, 2, '1', '2023-11-26 17:14:22'),
(17, 1, 3, '1', '2023-11-26 17:14:37'),
(17, 1, 4, '1', '2023-11-26 17:15:05'),
(17, 1, 5, '1', '2023-11-26 17:15:32'),
(18, 1, 1, '2', '2023-11-27 07:58:06'),
(17, 38, 6, '1', '2023-11-29 06:54:44'),
(17, 32, 7, '1', '2023-11-29 07:05:54'),
(29, 1, 1, '1', '2024-01-06 08:51:44'),
(29, 1, 2, '1', '2024-01-06 09:09:03'),
(29, 1, 3, '1', '2024-01-06 09:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `proposal_approval_history`
--

CREATE TABLE `proposal_approval_history` (
  `proposal_id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `flow_id` int UNSIGNED DEFAULT NULL,
  `role_id` tinyint UNSIGNED NOT NULL,
  `action` enum('1','2') NOT NULL COMMENT '1=Approve, 2=Reject',
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal_approval_history`
--

INSERT INTO `proposal_approval_history` (`proposal_id`, `user_id`, `flow_id`, `role_id`, `action`, `time_entry`) VALUES
(1, 1, 1, 9, '1', '2023-11-22 04:21:45'),
(1, 1, 2, 9, '1', '2023-11-22 04:22:06'),
(1, 1, 3, 9, '1', '2023-11-22 04:22:15'),
(1, 1, 4, 9, '1', '2023-11-22 04:22:42'),
(1, 1, 5, 9, '1', '2023-11-22 04:23:31'),
(1, 1, 6, 9, '1', '2023-11-22 04:27:17'),
(1, 1, 7, 9, '1', '2023-11-22 04:27:35'),
(17, 1, 1, 9, '1', '2023-11-26 17:14:06'),
(17, 1, 2, 9, '1', '2023-11-26 17:14:22'),
(17, 1, 3, 9, '1', '2023-11-26 17:14:37'),
(17, 1, 4, 9, '1', '2023-11-26 17:15:05'),
(17, 1, 5, 9, '1', '2023-11-26 17:15:32'),
(18, 1, 1, 9, '2', '2023-11-27 07:58:06'),
(17, 38, 6, 2, '1', '2023-11-29 06:54:44'),
(17, 32, 7, 1, '1', '2023-11-29 07:05:54'),
(29, 1, 1, 9, '1', '2024-01-06 08:51:44'),
(29, 1, 2, 9, '1', '2024-01-06 09:09:03'),
(29, 1, 3, 9, '1', '2024-01-06 09:09:18');

-- --------------------------------------------------------

--
-- Table structure for table `proposal_checklist`
--

CREATE TABLE `proposal_checklist` (
  `proposal_id` int UNSIGNED NOT NULL,
  `checklist_id` int UNSIGNED NOT NULL,
  `value` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal_checklist`
--

INSERT INTO `proposal_checklist` (`proposal_id`, `checklist_id`, `value`) VALUES
(1, 1, NULL),
(1, 2, NULL),
(1, 3, NULL),
(1, 4, NULL),
(1, 5, NULL),
(1, 6, NULL),
(1, 7, NULL),
(1, 8, NULL),
(1, 9, NULL),
(1, 10, NULL),
(1, 11, NULL),
(1, 12, NULL),
(1, 13, 'Mantap revisi'),
(1, 14, 'Boleh lanjut'),
(1, 15, NULL),
(1, 17, '300000'),
(1, 18, NULL),
(1, 19, NULL),
(1, 20, NULL),
(1, 21, NULL),
(1, 22, NULL),
(1, 23, NULL),
(1, 24, NULL),
(1, 25, 'Woke'),
(1, 26, '280000'),
(1, 27, 'Boleh'),
(1, 28, '290000'),
(1, 29, 'hihih'),
(1, 30, 'sudah ok'),
(1, 31, '1'),
(17, 1, NULL),
(17, 2, NULL),
(17, 3, NULL),
(17, 4, NULL),
(17, 5, NULL),
(17, 6, NULL),
(17, 7, NULL),
(17, 8, NULL),
(17, 9, NULL),
(17, 10, NULL),
(17, 11, NULL),
(17, 12, NULL),
(17, 13, 'Sudah lengkap sip'),
(17, 14, 'Oke sudah lengkap juga'),
(17, 15, NULL),
(17, 17, '190000'),
(17, 18, NULL),
(17, 19, NULL),
(17, 20, NULL),
(17, 21, NULL),
(17, 22, NULL),
(17, 23, NULL),
(17, 24, NULL),
(17, 25, 'Sudah mantap'),
(17, 26, '199000'),
(17, 27, 'Aman'),
(17, 28, '188000'),
(17, 29, 'Setuju'),
(17, 30, 'okee'),
(17, 31, '2'),
(18, 1, NULL),
(18, 2, NULL),
(18, 3, NULL),
(18, 4, NULL),
(18, 5, NULL),
(18, 6, NULL),
(18, 7, NULL),
(18, 8, NULL),
(18, 9, NULL),
(18, 10, NULL),
(18, 11, NULL),
(18, 12, NULL),
(18, 13, 'Saya tidak yakin'),
(29, 1, NULL),
(29, 2, NULL),
(29, 3, NULL),
(29, 4, NULL),
(29, 5, NULL),
(29, 6, NULL),
(29, 7, NULL),
(29, 8, NULL),
(29, 9, NULL),
(29, 10, NULL),
(29, 11, NULL),
(29, 12, NULL),
(29, 13, 'ok '),
(29, 14, 'SDasdasd'),
(29, 31, '1');

-- --------------------------------------------------------

--
-- Table structure for table `proposal_dana`
--

CREATE TABLE `proposal_dana` (
  `proposal_id` int UNSIGNED NOT NULL,
  `sequence` int UNSIGNED NOT NULL,
  `description` varchar(256) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `correction` decimal(18,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal_dana`
--

INSERT INTO `proposal_dana` (`proposal_id`, `sequence`, `description`, `amount`, `correction`) VALUES
(1, 1, 'Makan siang', '200000.00', NULL),
(17, 1, 'Kupon', '200000.00', '0.00'),
(18, 1, 'Beli Buku', '200000.00', NULL),
(19, 1, 'dwdwqd', '12000.00', NULL),
(28, 1, 'oofjaosjfj', '20000.00', NULL),
(29, 1, 'fafefewf', '300000.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proposal_lpj`
--

CREATE TABLE `proposal_lpj` (
  `id` int NOT NULL,
  `proposal_id` int UNSIGNED NOT NULL,
  `sequence` int UNSIGNED NOT NULL,
  `path` varchar(64) NOT NULL,
  `type` enum('1','2') NOT NULL COMMENT '1:image, 2:video',
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal_lpj`
--

INSERT INTO `proposal_lpj` (`id`, `proposal_id`, `sequence`, `path`, `type`, `description`) VALUES
(1, 17, 1, 'flow_7.png', '1', NULL),
(2, 17, 1, 'flow_11.png', '1', NULL),
(3, 17, 1, 'flow_12.png', '1', NULL),
(4, 17, 2, 'http://www.youtube.com/embed/uuO7e4Qg8vY?autoplay=1', '2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proposal_photo`
--

CREATE TABLE `proposal_photo` (
  `proposal_id` int UNSIGNED NOT NULL,
  `sequence` int UNSIGNED NOT NULL,
  `path` varchar(64) NOT NULL,
  `is_nphd` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal_photo`
--

INSERT INTO `proposal_photo` (`proposal_id`, `sequence`, `path`, `is_nphd`) VALUES
(1, 1, '22619e53237c5e2b439142cd157504d5.jpeg', b'0'),
(17, 1, 'bb45302a24f34962fe34e3bd826a8db9.png', b'0'),
(17, 2, 'flow.png', b'1'),
(18, 1, '202db726e232b542624514d5a65f645a.png', b'0'),
(19, 1, 'd3f337f9a8a50e92a6b65782f9a27c37.jpeg', b'0'),
(28, 1, '71a89144d63d6f523ce90a575506fc6c.jpeg', b'0'),
(29, 1, 'c125ce8563379078dcff227d5660788b.jpg', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `proposal_type`
--

CREATE TABLE `proposal_type` (
  `id` tinyint UNSIGNED NOT NULL,
  `name` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `proposal_type`
--

INSERT INTO `proposal_type` (`id`, `name`) VALUES
(1, 'Hibah'),
(2, 'Bansos');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` tinyint UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, 'Bupati'),
(2, 'Tim Panitia Anggaran Daerah'),
(3, 'SKPD'),
(4, 'Tim Pertimbangan'),
(5, 'Tata Usaha'),
(6, 'Warga'),
(7, 'Administrator'),
(8, 'Operator'),
(9, 'Super Administrator'),
(10, 'Kesbangpol');

-- --------------------------------------------------------

--
-- Table structure for table `skpd`
--

CREATE TABLE `skpd` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skpd`
--

INSERT INTO `skpd` (`id`, `name`) VALUES
(1, 'DINAS PENDIDIKAN, PEMUDA DAN OLAHRAGA'),
(2, 'KANTOR PERPUSTAKAAN DAN ARSIP DAERAH'),
(3, 'DINAS KESEHATAN'),
(4, 'RUMAH SAKIT UMUM DAERAH (RSUD) DR. RUBINI'),
(5, 'DINAS PEKERJAAN UMUM'),
(6, 'BADAN PERENCANAAN PEMBANGUNAN DAERAH (BAPPEDA)'),
(7, 'DINAS PERHUBUNGAN, KEBUDAYAAN DAN PARIWISATA'),
(8, 'BADAN LINGKUNGAN HIDUP DAN PENANGGULANGAN BENCANA DAERAH'),
(9, 'DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL'),
(10, 'BADAN KB, PEMBERDAYAAN PEREMPUAN & PERLINDUNGAN ANAK, PEMBERDAYAAN MASYARAKAT & PEMDES'),
(11, 'DINAS SOSIAL, TENAGA KERJA DAN TRANSMIGRASI'),
(12, 'KANTOR PENANAMAN MODAL DAN PELAYANAN TERPADU'),
(13, 'KANTOR SATUAN POLISI PAMONG PRAJA'),
(14, 'DEWAN PERWAKILAN RAKYAT DAERAH'),
(15, 'BUPATI DAN WAKIL BUPATI'),
(16, 'SEKRETARIAT DAERAH'),
(17, 'SEKRETARIAT DPRD'),
(18, 'DINAS PENDAPATAN PENGELOLA KEUANGAN DAN ASET DAERAH'),
(19, 'INSPEKTORAT KABUPATEN'),
(20, 'KECAMATAN MEMPAWAH HILIR'),
(21, 'KECAMATAN MEMPAWAH TIMUR'),
(22, 'KECAMATAN SUNGAI KUNYIT'),
(23, 'KECAMATAN SUNGAI PINYUH'),
(24, 'KECAMATAN ANJONGAN'),
(25, 'KECAMATAN TOHO'),
(26, 'KECAMATAN SADANIANG'),
(27, 'KECAMATAN SEGEDONG'),
(28, 'KECAMATAN SIANTAN'),
(29, 'BADAN KEPEGAWAIAN DAERAH'),
(30, 'DINAS PERTANIAN, PETERNAKAN, PERKEBUNAN DAN KEHUTANAN'),
(31, 'BADAN KETAHANAN PANGAN DAN PELAKSANA PENYULUHAN'),
(32, 'DINAS PERIKANAN DAN KELAUTAN'),
(33, 'DINAS PERINDUSTRIAN, PERDAGANGAN, KOPERASI UKM, PERTAMBANGAN DAN ENERGI');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(128) NOT NULL,
  `email` varchar(64) DEFAULT NULL,
  `address` varchar(512) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `ktp` varchar(64) DEFAULT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `role_id` tinyint UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_skpd` bit(1) NOT NULL DEFAULT b'0',
  `skpd_id` int UNSIGNED DEFAULT NULL,
  `time_entry` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `address`, `phone`, `ktp`, `username`, `password`, `role_id`, `is_active`, `is_skpd`, `skpd_id`, `time_entry`) VALUES
(1, 'Super Administrator', NULL, '', NULL, NULL, 'superadmin', '6079cca0923e90ff1eb3c45dd0391385', 9, 1, b'0', NULL, '2016-02-24 11:09:30'),
(32, 'Bupati', NULL, '', NULL, NULL, 'bupati', 'ace6ca18f65d006e4ceffa2ac6a25f02', 1, 1, b'0', NULL, '2023-11-22 03:59:24'),
(33, 'User', 'user@gmail.com', 'User alamat', '0821212111', '32102989898', 'user', 'ace6ca18f65d006e4ceffa2ac6a25f02', 6, 1, b'0', NULL, '2023-11-22 04:15:43'),
(34, 'User Baru', 'daftar@gmail.com', 'user baru alamat', '08323232322', '321029898982', 'userbaru', 'ace6ca18f65d006e4ceffa2ac6a25f02', 6, 1, b'0', NULL, '2023-11-26 15:25:42'),
(35, 'Kesbangpol', NULL, '', NULL, NULL, 'kesbangpol', '6079cca0923e90ff1eb3c45dd0391385', 10, 1, b'0', NULL, '2023-11-27 05:28:15'),
(36, 'User 2', 'user2@gmail.com', 'Alamat', '083231211', '1808009090', 'user2', 'ace6ca18f65d006e4ceffa2ac6a25f02', 6, 1, b'0', NULL, '2023-11-27 07:17:35'),
(37, 'TU', NULL, '', NULL, NULL, 'tu', 'ace6ca18f65d006e4ceffa2ac6a25f02', 5, 1, b'0', NULL, '2023-11-27 08:08:33'),
(38, 'TPAD', NULL, '', NULL, NULL, 'tpad', 'ace6ca18f65d006e4ceffa2ac6a25f02', 2, 1, b'0', NULL, '2023-11-27 08:08:56'),
(40, 'user99', 'user99@gmail.com', 'rusun 2 blok d\r\nrusun 2 blok d', '+62881027207572', '1231231', 'user99', 'd5fe5c8e0f0ba4d8fc5134d31c8a24e0', 6, 1, b'0', NULL, '2024-01-06 08:22:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `checklist`
--
ALTER TABLE `checklist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD UNIQUE KEY `page_id` (`page_id`,`sequence`);

--
-- Indexes for table `flow`
--
ALTER TABLE `flow`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sequence` (`sequence`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`laporan_id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `organisasi`
--
ALTER TABLE `organisasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`pengumuman_id`);

--
-- Indexes for table `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `skpd_id` (`skpd_id`),
  ADD KEY `current_stat` (`current_stat`);

--
-- Indexes for table `proposal_approval`
--
ALTER TABLE `proposal_approval`
  ADD KEY `proposal_id` (`proposal_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flow_id` (`flow_id`);

--
-- Indexes for table `proposal_approval_history`
--
ALTER TABLE `proposal_approval_history`
  ADD KEY `proposal_id` (`proposal_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `flow_id` (`flow_id`);

--
-- Indexes for table `proposal_checklist`
--
ALTER TABLE `proposal_checklist`
  ADD UNIQUE KEY `proposal_id` (`proposal_id`,`checklist_id`),
  ADD KEY `checklist_id` (`checklist_id`);

--
-- Indexes for table `proposal_dana`
--
ALTER TABLE `proposal_dana`
  ADD UNIQUE KEY `proposal_id` (`proposal_id`,`sequence`);

--
-- Indexes for table `proposal_lpj`
--
ALTER TABLE `proposal_lpj`
  ADD PRIMARY KEY (`id`),
  ADD KEY `toproposal` (`proposal_id`);

--
-- Indexes for table `proposal_photo`
--
ALTER TABLE `proposal_photo`
  ADD UNIQUE KEY `proposal_id` (`proposal_id`,`sequence`);

--
-- Indexes for table `proposal_type`
--
ALTER TABLE `proposal_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skpd`
--
ALTER TABLE `skpd`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `ktp` (`ktp`),
  ADD KEY `skpd_id` (`skpd_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `checklist`
--
ALTER TABLE `checklist`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `flow`
--
ALTER TABLE `flow`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `laporan_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `log_id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `organisasi`
--
ALTER TABLE `organisasi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `pengumuman_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `proposal_lpj`
--
ALTER TABLE `proposal_lpj`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `proposal_type`
--
ALTER TABLE `proposal_type`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` tinyint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `skpd`
--
ALTER TABLE `skpd`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `checklist`
--
ALTER TABLE `checklist`
  ADD CONSTRAINT `checklist_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `flow`
--
ALTER TABLE `flow`
  ADD CONSTRAINT `flow_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `log`
--
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `proposal`
--
ALTER TABLE `proposal`
  ADD CONSTRAINT `proposal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_ibfk_2` FOREIGN KEY (`type_id`) REFERENCES `proposal_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_ibfk_3` FOREIGN KEY (`skpd_id`) REFERENCES `skpd` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_ibfk_4` FOREIGN KEY (`current_stat`) REFERENCES `flow` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `proposal_approval`
--
ALTER TABLE `proposal_approval`
  ADD CONSTRAINT `proposal_approval_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_approval_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_approval_ibfk_3` FOREIGN KEY (`flow_id`) REFERENCES `flow` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposal_approval_history`
--
ALTER TABLE `proposal_approval_history`
  ADD CONSTRAINT `proposal_approval_history_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_approval_history_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_approval_history_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_approval_history_ibfk_4` FOREIGN KEY (`flow_id`) REFERENCES `flow` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposal_checklist`
--
ALTER TABLE `proposal_checklist`
  ADD CONSTRAINT `proposal_checklist_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `proposal_checklist_ibfk_2` FOREIGN KEY (`checklist_id`) REFERENCES `checklist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposal_dana`
--
ALTER TABLE `proposal_dana`
  ADD CONSTRAINT `proposal_dana_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposal_lpj`
--
ALTER TABLE `proposal_lpj`
  ADD CONSTRAINT `toproposal` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proposal_photo`
--
ALTER TABLE `proposal_photo`
  ADD CONSTRAINT `proposal_photo_ibfk_1` FOREIGN KEY (`proposal_id`) REFERENCES `proposal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`skpd_id`) REFERENCES `skpd` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
