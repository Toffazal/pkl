-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2023 at 09:48 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pkl`
--

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama`) VALUES
(2, 'Teknik Komputer dan Jaringan (TKJ)'),
(3, 'RPL'),
(7, 'BDP');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok`
--

CREATE TABLE `kelompok` (
  `id` int(11) NOT NULL,
  `pid` int(11) NOT NULL COMMENT 'pembimbing id',
  `uid` int(11) NOT NULL COMMENT 'user id',
  `tempat_pkl` varchar(500) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = berjalan, 1 = selesai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kelompok`
--

INSERT INTO `kelompok` (`id`, `pid`, `uid`, `tempat_pkl`, `status`) VALUES
(2, 28, 26, 'PT. Eegyo Link Partner', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'User ID',
  `idp` int(11) NOT NULL COMMENT 'ID Penilaian (dari tabel penilaian)',
  `nilai` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `uid`, `idp`, `nilai`) VALUES
(1, 26, 1, '70'),
(2, 26, 2, '69'),
(3, 26, 3, '98'),
(4, 26, 4, '80'),
(5, 26, 5, '99'),
(6, 26, 6, '50');

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id` int(11) NOT NULL,
  `jid` int(11) NOT NULL COMMENT 'ID Jurusan',
  `kategori` varchar(200) NOT NULL,
  `nama` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id`, `jid`, `kategori`, `nama`) VALUES
(1, 2, 'non-teknis', 'Disiplin'),
(2, 2, 'non-teknis', 'Tanggung Jawab'),
(3, 2, 'non-teknis', 'Kejujuran'),
(4, 2, 'teknis', 'Perakitan Komputer'),
(5, 2, 'teknis', 'Instalasi Komputer'),
(6, 2, 'teknis', 'Instalasi Jarinngan');

-- --------------------------------------------------------

--
-- Table structure for table `permohonan`
--

CREATE TABLE `permohonan` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL COMMENT 'User ID',
  `tempat_pkl` varchar(500) NOT NULL,
  `berkas` varchar(500) NOT NULL,
  `tanggal_pengajuan` varchar(200) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = pending, 1 = ditolak, 2 = disetujui, 3 = sudah masuk kelompok, 4 = sudah selesai pkl, 5 = sudah dapat nilai',
  `alasan` varchar(900) NOT NULL,
  `tanggal_konfirmasi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `permohonan`
--

INSERT INTO `permohonan` (`id`, `uid`, `tempat_pkl`, `berkas`, `tanggal_pengajuan`, `status`, `alasan`, `tanggal_konfirmasi`) VALUES
(2, 26, 'PT. Eegyo Link Partner', '1676216767_f9fec4d21adc4bfda4d4.pdf', '12-02-2023', 5, '', '12-02-2023');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(500) NOT NULL,
  `nis` varchar(100) NOT NULL,
  `jurusan` varchar(50) NOT NULL COMMENT 'ID dari tabel jurusan',
  `kelas` varchar(100) NOT NULL,
  `telepon` varchar(50) NOT NULL,
  `alamat` varchar(900) NOT NULL,
  `foto` varchar(500) NOT NULL,
  `username` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `nis`, `jurusan`, `kelas`, `telepon`, `alamat`, `foto`, `username`, `password`, `role`) VALUES
(1, 'Admin', '', '0', '', '089613325456', '-', '1674453330_718446fde67a4ee017c5.jpg', 'admin', '$2y$10$n0ZhMZB0UXvS04m6rMTpJ.5sISwudmgw8E6XuKyPMqPXpe/IDehzy', 'admin'),
(26, 'Muhammad Ikhsan Adwa', '123456', '2', 'XI TKJ 1', '089613325456', '-', 'default.png', '123456', '$2y$10$i5HrFFyfOKb94qrI/GbAne.R5uSeoc8KNipm1LWAleAHDdWHCLb8u', 'siswa'),
(27, 'Muhammad Toffazal S.kom M.Kom', '', '2', '', '089613325456', '-', 'default.png', 'fazal', '$2y$10$IwtTsy7/f4yn6Cxm/eDjVuPrbAAJJOKb5BTLWSS54aYOXbGQZkNhy', 'kajur'),
(28, 'Bagus Erlangga Pratama', '', '2', '', '089613325456', '-', 'default.png', 'erlangga', '$2y$10$Pf961A.SHyRtU4jeBiR4BuBEkZutKeRS.T4eV5XqTtatlb6eiguKy', 'pembimbing');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permohonan`
--
ALTER TABLE `permohonan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelompok`
--
ALTER TABLE `kelompok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `permohonan`
--
ALTER TABLE `permohonan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
