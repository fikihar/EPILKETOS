-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 21, 2025 at 03:55 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pilketos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`username`, `password`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3');

-- --------------------------------------------------------

--
-- Table structure for table `tb_datapilketos`
--

CREATE TABLE `tb_datapilketos` (
  `id` int NOT NULL DEFAULT '1',
  `tapel` varchar(10) NOT NULL,
  `tgl` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_datapilketos`
--

INSERT INTO `tb_datapilketos` (`id`, `tapel`, `tgl`) VALUES
(1, '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_identitassekolah`
--

CREATE TABLE `tb_identitassekolah` (
  `npsn` varchar(15) NOT NULL,
  `nm_sekolah` varchar(32) NOT NULL,
  `jln` varchar(32) DEFAULT NULL,
  `desa` varchar(32) DEFAULT NULL,
  `kec` varchar(32) DEFAULT NULL,
  `kab` varchar(32) DEFAULT NULL,
  `kpl_sekolah` varchar(32) DEFAULT NULL,
  `nip` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_identitassekolah`
--

INSERT INTO `tb_identitassekolah` (`npsn`, `nm_sekolah`, `jln`, `desa`, `kec`, `kab`, `kpl_sekolah`, `nip`) VALUES
('20338635', 'SMKS WALISONGO PECANGAAN ', 'Jl. Kauman No.1', 'Pecangaan Kulon', 'Pecangaan', 'Jepara', 'Irbab Aulia Amri, S.Pd, M.Pd', '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `kd_kelas` int NOT NULL,
  `nm_kelas` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`kd_kelas`, `nm_kelas`) VALUES
(11, 'X DPK'),
(12, 'XI DPK'),
(13, 'XII DPK'),
(14, 'X AKL'),
(16, 'XI AKL'),
(17, 'XII AKL'),
(18, 'X TO A'),
(19, 'XI TO A'),
(20, 'XII TO A'),
(21, 'X TO B'),
(22, 'XI TO B'),
(23, 'XII TO B'),
(24, 'X TO INDUSTRI'),
(25, 'XI TO INDUSTRI'),
(26, 'XII TO INDUSTRI'),
(27, 'X TJKT A'),
(28, 'XI TJKT A'),
(29, 'XII TJKT A'),
(30, 'X TJKT B'),
(31, 'XI TJKT B'),
(32, 'XII TJKT B');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pilih`
--

CREATE TABLE `tb_pilih` (
  `id_pilih` int NOT NULL,
  `nisn` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pilihan`
--

CREATE TABLE `tb_pilihan` (
  `nisn` varchar(32) NOT NULL,
  `nama` varchar(32) NOT NULL,
  `photo` varchar(32) NOT NULL,
  `no` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nm_siswa` varchar(32) DEFAULT NULL,
  `jk` char(1) NOT NULL,
  `kd_kelas` int DEFAULT NULL,
  `hadir` varchar(12) NOT NULL DEFAULT 'Tidak Hadir'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_daftarhadir`
-- (See below for the actual view)
--
CREATE TABLE `view_daftarhadir` (
`NISN` varchar(32)
,`nm_kelas` varchar(32)
,`nm_siswa` varchar(32)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_vote`
-- (See below for the actual view)
--
CREATE TABLE `view_vote` (
`nama` varchar(32)
,`nisn` varchar(32)
,`no` int
,`photo` varchar(32)
,`username` varchar(32)
);

-- --------------------------------------------------------

--
-- Structure for view `view_daftarhadir`
--
DROP TABLE IF EXISTS `view_daftarhadir`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_daftarhadir`  AS SELECT `tb_siswa`.`username` AS `NISN`, `tb_siswa`.`nm_siswa` AS `nm_siswa`, `tb_kelas`.`nm_kelas` AS `nm_kelas` FROM ((`tb_siswa` join `tb_kelas` on((`tb_kelas`.`kd_kelas` = `tb_siswa`.`kd_kelas`))) join `tb_pilih` on((`tb_siswa`.`username` = `tb_pilih`.`username`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `view_vote`
--
DROP TABLE IF EXISTS `view_vote`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_vote`  AS SELECT `tb_pilihan`.`nisn` AS `nisn`, `tb_pilihan`.`nama` AS `nama`, `tb_pilihan`.`photo` AS `photo`, `tb_pilihan`.`no` AS `no`, `tb_siswa`.`username` AS `username` FROM ((`tb_pilih` join `tb_pilihan` on((`tb_pilihan`.`nisn` = `tb_pilih`.`nisn`))) join `tb_siswa` on((`tb_siswa`.`username` = `tb_pilih`.`username`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tb_datapilketos`
--
ALTER TABLE `tb_datapilketos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_identitassekolah`
--
ALTER TABLE `tb_identitassekolah`
  ADD PRIMARY KEY (`npsn`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`kd_kelas`);

--
-- Indexes for table `tb_pilih`
--
ALTER TABLE `tb_pilih`
  ADD PRIMARY KEY (`id_pilih`);

--
-- Indexes for table `tb_pilihan`
--
ALTER TABLE `tb_pilihan`
  ADD PRIMARY KEY (`nisn`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `kd_kelas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tb_pilih`
--
ALTER TABLE `tb_pilih`
  MODIFY `id_pilih` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
