-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 26, 2025 at 08:04 AM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u713383587_shriganga`
--

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `weight`, `price`, `created_at`) VALUES
(1, 1, '23g', 100.00, '2025-09-26 07:35:36'),
(2, 1, '50g', 200.00, '2025-09-26 07:35:36'),
(3, 1, '100g', 300.00, '2025-09-26 07:35:36'),
(4, 2, '23g', 200.00, '2025-09-26 07:35:36'),
(5, 2, '50g', 400.00, '2025-09-26 07:35:36'),
(6, 2, '100g', 600.00, '2025-09-26 07:35:36'),
(7, 3, '23g', 200.00, '2025-09-26 07:35:36'),
(8, 3, '50g', 400.00, '2025-09-26 07:35:36'),
(9, 3, '100g', 600.00, '2025-09-26 07:35:36'),
(10, 4, '23g', 200.00, '2025-09-26 07:35:36'),
(11, 4, '50g', 400.00, '2025-09-26 07:35:36'),
(12, 4, '100g', 600.00, '2025-09-26 07:35:36'),
(13, 5, '23g', 200.00, '2025-09-26 07:35:36'),
(14, 5, '50g', 400.00, '2025-09-26 07:35:36'),
(15, 5, '100g', 600.00, '2025-09-26 07:35:36'),
(16, 6, '23g', 200.00, '2025-09-26 07:35:36'),
(17, 6, '50g', 400.00, '2025-09-26 07:35:36'),
(18, 6, '100g', 600.00, '2025-09-26 07:35:36'),
(19, 7, '23g', 200.00, '2025-09-26 07:35:36'),
(20, 7, '50g', 400.00, '2025-09-26 07:35:36'),
(21, 7, '100g', 600.00, '2025-09-26 07:35:36'),
(22, 8, '23g', 200.00, '2025-09-26 07:35:36'),
(23, 8, '50g', 400.00, '2025-09-26 07:35:36'),
(24, 8, '100g', 600.00, '2025-09-26 07:35:36'),
(25, 1, '23g', 100.00, '2025-09-26 07:37:33'),
(26, 1, '50g', 200.00, '2025-09-26 07:37:33'),
(27, 1, '100g', 300.00, '2025-09-26 07:37:33'),
(28, 2, '23g', 200.00, '2025-09-26 07:37:33'),
(29, 2, '50g', 400.00, '2025-09-26 07:37:33'),
(30, 2, '100g', 600.00, '2025-09-26 07:37:33'),
(31, 3, '23g', 200.00, '2025-09-26 07:37:33'),
(32, 3, '50g', 400.00, '2025-09-26 07:37:33'),
(33, 3, '100g', 600.00, '2025-09-26 07:37:33'),
(34, 4, '23g', 200.00, '2025-09-26 07:37:33'),
(35, 4, '50g', 400.00, '2025-09-26 07:37:33'),
(36, 4, '100g', 600.00, '2025-09-26 07:37:33'),
(37, 5, '23g', 200.00, '2025-09-26 07:37:33'),
(38, 5, '50g', 400.00, '2025-09-26 07:37:33'),
(39, 5, '100g', 600.00, '2025-09-26 07:37:33'),
(40, 6, '23g', 200.00, '2025-09-26 07:37:33'),
(41, 6, '50g', 400.00, '2025-09-26 07:37:33'),
(42, 6, '100g', 600.00, '2025-09-26 07:37:33'),
(43, 7, '23g', 200.00, '2025-09-26 07:37:33'),
(44, 7, '50g', 400.00, '2025-09-26 07:37:33'),
(45, 7, '100g', 600.00, '2025-09-26 07:37:33'),
(46, 8, '23g', 200.00, '2025-09-26 07:37:33'),
(47, 8, '50g', 400.00, '2025-09-26 07:37:33'),
(48, 8, '100g', 600.00, '2025-09-26 07:37:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
