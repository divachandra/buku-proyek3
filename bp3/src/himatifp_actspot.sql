-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 27, 2020 at 09:48 AM
-- Server version: 10.0.38-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `himatifp_actspot`
--

DELIMITER $$
--
-- Functions
--
$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_intern_absensi` varchar(10) NOT NULL,
  `id_mahasiswa_absensi` varchar(15) NOT NULL,
  `id_dosen_absensi` varchar(15) NOT NULL,
  `id_pembimbing_absensi` int(11) NOT NULL,
  `latitude_absensi` text NOT NULL,
  `longitude_absensi` text NOT NULL,
  `imei_perangkat_absensi` text NOT NULL,
  `id_kegiatan_absensi` int(11) NOT NULL,
  `catatan_absensi` text NOT NULL,
  `foto_absensi` text NOT NULL,
  `tgl_waktu_absensi` text NOT NULL,
  `status_absensi` varchar(20) DEFAULT NULL,
  `nilai_absensi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_intern_absensi`, `id_mahasiswa_absensi`, `id_dosen_absensi`, `id_pembimbing_absensi`, `latitude_absensi`, `longitude_absensi`, `imei_perangkat_absensi`, `id_kegiatan_absensi`, `catatan_absensi`, `foto_absensi`, `tgl_waktu_absensi`, `status_absensi`, `nilai_absensi`) VALUES
(69, '1', '1174006', '11374163', 190002, '-6.8745201', '107.5791786', '862535046332732', 2, '', 'IMG_20200126221626_2068482245014343933.jpg', '2020-01-26 22:16:40', 'diterima', 90),
(70, '1', '1174006', '11374163', 190002, '-6.8745201', '107.5791786', '862535046332732', 2, '', 'IMG_20200126225621_1423037255750857977.jpg', '2020-01-26 22:56:36', 'diterima', 90),
(71, '1', '1174006', '11374163', 190002, '-6.8745201', '107.5791786', '862535046332732', 3, '', 'IMG_20200127002411_749677738216280552.jpg', '2020-01-27 00:24:27', 'diterima', NULL),
(72, '1', '1174006', '11374163', 190002, '-6.8745201', '107.5791786', '862535046332732', 3, '', 'IMG_20200127005100_1942864337051558822.jpg', '2020-01-27 00:51:15', 'diterima', NULL),
(73, '1', '1174006', '11374163', 190002, '-6.8745201', '107.5791786', '862535046332732', 4, '', 'IMG_20200127010900_8464309671860998148.jpg', '2020-01-27 01:09:14', 'diterima', NULL),
(74, '1', '1174006', '11374163', 190002, '-6.8738389', '107.5757025', '862535046332732', 2, '', 'IMG_20200203083955_853697430429311170.jpg', '2020-02-03 08:40:13', 'diterima', 0),
(75, '1', '1174006', '11374163', 190002, '-6.8746732', '107.5751101', '862535046332732', 2, '', 'IMG_20200203103359_767125753568223866.jpg', '2020-02-03 10:35:06', 'diterima', 0),
(76, '1', '1174006', '11374163', 190002, '-6.8745201', '107.5791786', '862535046332732', 2, 'mengerjakan revisi', 'IMG_20200206091218_5909185369703606037.jpg', '2020-02-06 09:12:28', 'diterima', 2),
(77, '1', '1174006', '11374163', 190002, '-6.8745201', '107.5791786', '862535046332732', 2, 'mengerjakan revisi', 'IMG_20200206091441_5125434941358287249.jpg', '2020-02-06 09:14:57', 'diterima', 2);

--
-- Triggers `absensi`
--
DELIMITER $$
CREATE TRIGGER `pergeseran_absensi` AFTER INSERT ON `absensi` FOR EACH ROW INSERT INTO detail_absensi (id_intern_dt_absensi,id_mahasiswa_dt_absensi,id_absensi_dt_absensi, pergeseran_absensi)
    SELECT NEW.id_intern_absensi
         , NEW.id_mahasiswa_absensi 
         , NEW.id_absensi 
         , hitung_pergeseran(p.lat_pembimbing_perusahaan  ,p.long_pembimbing_perusahaan ,NEW.latitude_absensi,NEW.longitude_absensi)
      FROM pembimbing_perusahaan p
      LIMIT 1
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detail_absensi`
--

CREATE TABLE `detail_absensi` (
  `id_intern_dt_absensi` int(11) NOT NULL,
  `id_mahasiswa_dt_absensi` varchar(15) NOT NULL,
  `id_absensi_dt_absensi` int(11) NOT NULL,
  `pergeseran_absensi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_absensi`
--

INSERT INTO `detail_absensi` (`id_intern_dt_absensi`, `id_mahasiswa_dt_absensi`, `id_absensi_dt_absensi`, `pergeseran_absensi`) VALUES
(1, '1174006', 69, '435'),
(1, '1174006', 70, '435'),
(1, '1174006', 71, '435'),
(1, '1174006', 72, '435'),
(1, '1174006', 73, '435'),
(1, '1174006', 74, '64'),
(1, '1174006', 75, '153'),
(1, '1174006', 76, '435'),
(1, '1174006', 77, '435');

-- --------------------------------------------------------

--
-- Table structure for table `detail_intern`
--

CREATE TABLE `detail_intern` (
  `id_intern_dt_intern` int(11) NOT NULL,
  `id_mahasiswa_dt_intern` varchar(15) NOT NULL,
  `id_dosen_dt_intern` varchar(15) NOT NULL,
  `lama_internship` int(11) NOT NULL,
  `surat_intern` text NOT NULL,
  `id_pembimbing_dt_intern` int(11) DEFAULT NULL,
  `latitude_perusahaan` text,
  `longitude_perusahaan` text,
  `foto_perusahaan` text,
  `status_perusahaan` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_intern`
--

INSERT INTO `detail_intern` (`id_intern_dt_intern`, `id_mahasiswa_dt_intern`, `id_dosen_dt_intern`, `lama_internship`, `surat_intern`, `id_pembimbing_dt_intern`, `latitude_perusahaan`, `longitude_perusahaan`, `foto_perusahaan`, `status_perusahaan`) VALUES
(1, '1174006', '11374163', 180, '', 190002, '-6.8745201', '107.5791786', 'IMG_20200126214023_8598964901364464584.jpg', 'diterima'),
(1, '1174079', '11374163', 366, '', 190001, '-6.8746732', '107.5751101', 'IMG_20200203110033_3051713375763539681.jpg', NULL),
(1, '1174010', '11374163', 90, '', NULL, NULL, NULL, NULL, NULL),
(1, '555222', '10382070', 19, 'doc_21.pdf', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` varchar(15) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `id_prodi_dosen` varchar(10) NOT NULL,
  `kontak_dosen` text NOT NULL,
  `foto_dosen` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nama_dosen`, `id_prodi_dosen`, `kontak_dosen`, `foto_dosen`) VALUES
('10382070', 'Muhammad Ruslan Maulani, S.Kom., MT.', 'd3ti', '', NULL),
('11374163', 'M. Yusril Setyawan', 'd4ti', 'divakrishna55@gmail.com', 'cropped8666078964319432105.jpg'),
('11786219', 'Rolly Maulana Awangga, S.T., M.T.', 'd4ti', '', NULL),
('21388109', 'M. Harry K', 'd4ti', '', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `intern`
--

CREATE TABLE `intern` (
  `id_intern` int(11) NOT NULL,
  `id_koor_intern` varchar(15) NOT NULL,
  `status_intern` varchar(15) NOT NULL,
  `tgl_mulai_intern` datetime DEFAULT NULL,
  `tgl_akhir_intern` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `intern`
--

INSERT INTO `intern` (`id_intern`, `id_koor_intern`, `status_intern`, `tgl_mulai_intern`, `tgl_akhir_intern`) VALUES
(1, '21388109', 'berjalan', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `nama_kegiatan` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `nama_kegiatan`) VALUES
(1, 'Masuk'),
(2, 'Berkerja'),
(3, 'Istirahat'),
(4, 'Pulang');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` varchar(15) NOT NULL,
  `nama_mahasiswa` varchar(50) NOT NULL,
  `kelas_mahasiswa` varchar(5) NOT NULL,
  `id_prodi_mahasiswa` varchar(10) NOT NULL,
  `angkatan_mahasiswa` varchar(5) NOT NULL,
  `foto_mahasiswa` text,
  `kontak_mahasiswa` varchar(25) NOT NULL,
  `kode_otp` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama_mahasiswa`, `kelas_mahasiswa`, `id_prodi_mahasiswa`, `angkatan_mahasiswa`, `foto_mahasiswa`, `kontak_mahasiswa`, `kode_otp`) VALUES
('1174005', 'oniwaldus', '3a', 'd4ti', '2017', 'however-its- you.jpg', 'divakrishna55@gmail.com', NULL),
('1174006', 'Kadek Diva Krishna Murti', '3A', 'd4ti', '2017', 'cropped6678163712589999351.jpg', 'divakrishna55@gmail.com', '-'),
('1174008', 'arjun yuda', '3a', 'd4ti', '2017', NULL, 'divakrishna55@gmail.com', NULL),
('1174010', 'Dwi Yulianingsih', '3B', 'd4ti', '2017', 'cropped4765297604673833074.jpg', 'divakrishna55@gmail.com', '-'),
('1174079', 'chandra kirana poetra', '3c', 'd4ti', '2017', '', 'divakrishna55@gmail.com', '-'),
('555222', 'bbbbbbbbbbbb', '3c', 'd4ti', '2017', '2xc9z01.png', 'chandrakiranapoetracendan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_intern_notifikasi` int(11) NOT NULL,
  `id_mahasiswa_notifikasi` varchar(15) NOT NULL,
  `id_dosen_notifikasi` varchar(15) NOT NULL,
  `id_pembimbing_notifikasi` int(11) NOT NULL,
  `pesan_notifikasi` text NOT NULL,
  `tgl_waktu_notifikasi` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_intern_notifikasi`, `id_mahasiswa_notifikasi`, `id_dosen_notifikasi`, `id_pembimbing_notifikasi`, `pesan_notifikasi`, `tgl_waktu_notifikasi`) VALUES
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-02-09 07:43:53'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-02-09 07:43:49'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-02-09 12:59:01'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-02-06 09:15:02'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-02-06 09:12:33'),
(1, '1174079', '11374163', 190001, 'melakukan absensi pada', '2020-02-06 09:11:57'),
(1, '1174079', '11374163', 190001, 'melakukan absensi pada', '2020-02-06 09:11:43'),
(1, '1174079', '11374163', 190001, 'melakukan absensi pada', '2020-02-06 09:11:40'),
(1, '1174079', '11374163', 190001, 'melakukan absensi pada', '2020-02-06 09:10:53'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-02-06 09:10:01'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-02-06 08:59:45'),
(1, '1174079', '11374163', 190001, 'mendaftar ke perusahaan', '2020-02-03 11:01:19'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-02-03 10:35:07'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-02-03 08:40:30'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-02-03 08:40:13'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-01-27 01:09:24'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-01-27 01:09:14'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-01-27 01:01:16'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-01-27 12:51:16'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-01-27 12:47:18'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-01-27 12:24:28'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-01-26 11:02:06'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-01-26 10:56:39'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi absensi', '2020-01-26 10:54:14'),
(1, '1174006', '11374163', 190002, 'melakukan absensi pada', '2020-01-26 10:16:42'),
(1, '1174006', '11374163', 190002, 'mengkonfirmasi pendaftaran', '2020-01-26 10:02:26'),
(1, '1174006', '11374163', 190002, 'mendaftar ke perusahaan', '2020-01-26 09:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `pembimbing_perusahaan`
--

CREATE TABLE `pembimbing_perusahaan` (
  `id_pembimbing` int(11) NOT NULL,
  `nama_pembimbing` varchar(50) NOT NULL,
  `nama_perusahaan_perusahaan` text NOT NULL,
  `lat_pembimbing_perusahaan` text NOT NULL,
  `long_pembimbing_perusahaan` text NOT NULL,
  `kontak_pembimbing` varchar(25) NOT NULL,
  `foto_pembimbing` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembimbing_perusahaan`
--

INSERT INTO `pembimbing_perusahaan` (`id_pembimbing`, `nama_pembimbing`, `nama_perusahaan_perusahaan`, `lat_pembimbing_perusahaan`, `long_pembimbing_perusahaan`, `kontak_pembimbing`, `foto_pembimbing`) VALUES
(190001, 'Barry Allen', 'Star Labs', '-6.873334', '107.5754231', 'divakrishnam@gmail.com', 'cropped962247428636619754.jpg'),
(190002, 'Bruce Wayne', 'Wayne Industry', '-6.873334107', '107.5754231', 'divakrishna55@gmail.com', 'cropped1941288156213339903.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` varchar(10) NOT NULL,
  `nama_prodi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `nama_prodi`) VALUES
('d3ti', 'd3 teknik informatika'),
('d4ti', 'd4 teknik informatika');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` varchar(15) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `status_user` varchar(15) NOT NULL,
  `role_user` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `status_user`, `role_user`) VALUES
('1174006', 'divakun', 'divakun', 'aktif', 'mahasiswa'),
('1174079', 'chandras', 'chandras', 'aktif', 'mahasiswa'),
('11374163', 'pakyusril', 'pakyusril', 'aktif', 'dosen'),
('21388109', 'pakhary', 'pakharryy', 'aktif', 'dosen'),
('11786219', 'pakrolly', 'pakrolly', 'tidak aktif', 'dosen'),
('1174010', 'dwiyulig', 'dwiyul', 'aktif', 'mahasiswa'),
('1174008', 'arjunyuda', 'arjunyuda', 'aktif', 'mahasiswa'),
('1174005', 'oniwaldus', 'oniwaldus', 'tidak aktif', 'mahasiswa'),
('190001', 'theflash', 'theflashy', 'aktif', 'pembimbing'),
('190002', 'bruceaja', 'bruceaja', 'aktif', 'pembimbing'),
('1', 'admin', 'admin', 'aktif', 'admin'),
('555222', 'bbbbbbbbbbbb', 'bbbbbbbbbbbb', 'tidak aktif', 'mahasiswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`);

--
-- Indexes for table `intern`
--
ALTER TABLE `intern`
  ADD PRIMARY KEY (`id_intern`);

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`);

--
-- Indexes for table `pembimbing_perusahaan`
--
ALTER TABLE `pembimbing_perusahaan`
  ADD PRIMARY KEY (`id_pembimbing`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `intern`
--
ALTER TABLE `intern`
  MODIFY `id_intern` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pembimbing_perusahaan`
--
ALTER TABLE `pembimbing_perusahaan`
  MODIFY `id_pembimbing` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190003;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
