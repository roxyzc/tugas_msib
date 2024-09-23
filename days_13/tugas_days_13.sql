-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 23, 2024 at 03:56 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tugas_days_13`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `getSiswaByBorn` (IN `tempat_lahir` VARCHAR(100))   BEGIN
    SELECT * FROM m_siswa
    WHERE ttl LIKE CONCAT('%', tempat_lahir, '%');
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getJmlByGender` (`gender_input` ENUM('L','P')) RETURNS INT(11)  BEGIN
    DECLARE jumlah INT;

    SELECT COUNT(*) INTO jumlah
    FROM m_siswa
    WHERE gender = gender_input;

    RETURN jumlah;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_products`
--

CREATE TABLE `m_products` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_products`
--

INSERT INTO `m_products` (`id`, `nama`, `harga`) VALUES
(1, 'kipas', '10000.00'),
(2, 'baterai', '5000.00');

--
-- Triggers `m_products`
--
DELIMITER $$
CREATE TRIGGER `produk_after_tambah` AFTER INSERT ON `m_products` FOR EACH ROW BEGIN
    INSERT INTO stock (id, quantity) VALUES (NEW.id, 0);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `m_siswa`
--

CREATE TABLE `m_siswa` (
  `siswa_id` int(11) NOT NULL,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `ttl` varchar(100) NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `m_siswa`
--

INSERT INTO `m_siswa` (`siswa_id`, `nis`, `nama`, `ttl`, `gender`, `alamat`) VALUES
(1, '123456', 'Aldo Prasetyo', 'Jakarta, 2008-05-15', 'L', 'Jl. Raya No. 1, Jakarta'),
(2, '123457', 'Siti Aisyah', 'Bandung, 2009-03-20', 'P', 'Jl. Kebon Jeruk No. 2, Bandung'),
(3, '123458', 'Budi Santoso', 'Surabaya, 2008-07-10', 'L', 'Jl. Cempaka No. 3, Surabaya'),
(4, '123459', 'Dewi Lestari', 'Semarang, 2009-02-14', 'P', 'Jl. Melati No. 4, Semarang'),
(5, '123460', 'Rudi Hidayat', 'Yogyakarta, 2008-11-30', 'L', 'Jl. Mawar No. 5, Yogyakarta');

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `nilai_IPA` decimal(5,2) NOT NULL,
  `nilai_IPS` decimal(5,2) NOT NULL,
  `nilai_MTK` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `siswa_id`, `nilai_IPA`, `nilai_IPS`, `nilai_MTK`) VALUES
(1, 1, '85.50', '78.00', '90.00'),
(2, 2, '88.00', '82.50', '75.00'),
(3, 3, '70.00', '65.50', '80.00'),
(4, 4, '92.00', '88.00', '95.50'),
(5, 5, '78.50', '80.00', '77.00');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `quantity`) VALUES
(1, 12),
(2, 15);

--
-- Triggers `stock`
--
DELIMITER $$
CREATE TRIGGER `stok_before_tambah` BEFORE UPDATE ON `stock` FOR EACH ROW BEGIN
    IF (NEW.quantity < 10) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Peringatan: Stok kurang dari 10!';
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_products`
--
ALTER TABLE `m_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_siswa`
--
ALTER TABLE `m_siswa`
  ADD PRIMARY KEY (`siswa_id`);

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_products`
--
ALTER TABLE `m_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_siswa`
--
ALTER TABLE `m_siswa`
  MODIFY `siswa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `m_siswa` (`siswa_id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`id`) REFERENCES `m_products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
